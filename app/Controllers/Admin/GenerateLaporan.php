<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use DateTime;
use DateInterval;
use DatePeriod;

use App\Models\memberModel;
use App\Models\KelasModel;
use App\Models\PresensimemberModel;
use App\Models\SiswaModel;
use App\Models\PresensiSiswaModel;
use App\Models\PenjualanModel;

class GenerateLaporan extends BaseController
{
   protected SiswaModel $siswaModel;
   protected KelasModel $kelasModel;

   protected memberModel $memberModel;

   protected PresensiSiswaModel $presensiSiswaModel;
   protected PresensimemberModel $presensimemberModel;

   protected PenjualanModel $penjualanModel;

   public function __construct()
   {
      $this->siswaModel = new SiswaModel();
      $this->kelasModel = new KelasModel();

      $this->memberModel = new memberModel();

      $this->presensiSiswaModel = new PresensiSiswaModel();
      $this->presensimemberModel = new PresensimemberModel();
      $this->penjualanModel = new PenjualanModel();
   }

   public function index()
   {
      $kelas = $this->kelasModel->getDataKelas();
      $member = $this->memberModel->getAllmember();

      $siswaPerKelas = [];

      foreach ($kelas as $value) {
         array_push($siswaPerKelas, $this->siswaModel->getSiswaByKelas($value['id_kelas']));
      }

      $data = [
         'title' => 'Generate Laporan',
         'ctx' => 'laporan',
         'siswaPerKelas' => $siswaPerKelas,
         'kelas' => $kelas,
         'member' => $member
      ];

      return view('admin/generate-laporan/generate-laporan', $data);
   }

   public function generateLaporanPendapatan()
   {
      $awal = $this->request->getVar('tanggal_awal');
      $akhir = $this->request->getVar('tanggal_akhir');
      $type = $this->request->getVar('type');
      $paketFilter = $this->request->getVar('paket');

      $rekap = [];

      $query = $this->memberModel
         ->where('tanggal_daftar >=', $awal)
         ->where('tanggal_daftar <=', $akhir);

      if ($paketFilter != 'all') {
         $query->where('paket', $paketFilter);
      }

      $detailMember = $query
         ->orderBy('tanggal_daftar', 'ASC')
         ->findAll();

      $totalMember = 0;
      $totalPendapatan = 0;
      $totalCash = 0;
      $totalQris = 0;

      foreach ($detailMember as $p) {

         $paket = $p['paket'];

         if (!isset($rekap[$paket])) {

            $rekap[$paket] = [
               'jumlah'  => 0,
               'nominal' => 0,
               'cash'    => 0,
               'qris'    => 0
            ];
         }

         $rekap[$paket]['jumlah']++;
         $rekap[$paket]['nominal'] += $p['nominal'];

         // CASH
         if ($p['metode_bayar'] == 'Cash') {

            $rekap[$paket]['cash'] += $p['nominal'];
            $totalCash += $p['nominal'];
         }

         // QRIS
         elseif ($p['metode_bayar'] == 'QRIS') {

            $rekap[$paket]['qris'] += $p['nominal'];
            $totalQris += $p['nominal'];
         }

         // GABUNGAN
         elseif ($p['metode_bayar'] == 'Gabungan') {

            $rekap[$paket]['cash'] += (int)$p['bayar_cash'];
            $rekap[$paket]['qris'] += (int)$p['bayar_qris'];

            $totalCash += (int)$p['bayar_cash'];
            $totalQris += (int)$p['bayar_qris'];
         }

         $totalMember++;
         $totalPendapatan += $p['nominal'];
      }

      $urutanPaket = [
         '1 Hari'  => 1,
         '1 Bulan' => 2,
         '3 Bulan' => 3,
         '6 Bulan' => 4,
         '12 Bulan' => 5
      ];

      uksort($rekap, function ($a, $b) use ($urutanPaket) {
         return $urutanPaket[$a] <=> $urutanPaket[$b];
      });

      // ===============================
      // PENJUALAN BARANG
      // ===============================

      $penjualanBarang = $this->penjualanModel
         ->where('DATE(tanggal) >=', $awal)
         ->where('DATE(tanggal) <=', $akhir)
         ->findAll();

      $barangCash = 0;
      $barangQris = 0;
      $totalPenjualanBarang = 0;

      foreach ($penjualanBarang as $row) {

         $barangCash += (int)$row['bayar_cash'];

         $barangQris += (int)$row['bayar_qris'];

         $totalPenjualanBarang += (int)$row['total'];
      }

      $data = [
         'detailMember' => $detailMember,
         'awal' => $awal,
         'akhir' => $akhir,

         'rekap' => $rekap,

         'totalMember' => $totalMember,
         'totalPendapatan' => $totalPendapatan,

         'totalCash' => $totalCash,
         'totalQris' => $totalQris,

         // dari kasir
         'barangCash' => $barangCash,
         'barangQris' => $barangQris,
         'totalPenjualanBarang' => $totalPenjualanBarang,

         'paketFilter' => $paketFilter,
         'grup' => 'member'
      ];

      if ($type == 'doc') {

         $this->response->setHeader(
            'Content-type',
            'application/vnd.ms-word'
         );

         $this->response->setHeader(
            'Content-Disposition',
            'attachment;Filename=laporan_pendapatan_member.doc'
         );

         return view(
            'admin/generate-laporan/laporan-pendapatan-member',
            $data
         );
      }

      return view(
         'admin/generate-laporan/laporan-pendapatan-member',
         $data
      ) . view('admin/generate-laporan/topdf');
   }

   public function generateLaporanmember()
   {
      $member = $this->memberModel->getAllmember();
      $type = $this->request->getVar('type');

      if (empty($member)) {
         session()->setFlashdata([
            'msg' => 'Data member kosong!',
            'error' => true
         ]);
         return redirect()->to('/admin/laporan');
      }

      $bulan = $this->request->getVar('tanggalmember');

      // hari pertama dalam 1 bulan
      $begin = new Time($bulan, locale: 'id');
      // tanggal terakhir dalam 1 bulan
      $end = (new DateTime($begin->format('Y-m-t')))->modify('+1 day');
      // interval 1 hari
      $interval = DateInterval::createFromDateString('1 day');
      // buat array dari semua hari di bulan
      $period = new DatePeriod($begin, $interval, $end);

      $arrayTanggal = [];
      $dataAbsen = [];

      foreach ($period as $value) {
         // kecualikan hari sabtu dan minggu
         if (!($value->format('D') == 'Sat' || $value->format('D') == 'Sun')) {
            $lewat = Time::parse($value->format('Y-m-d'))->isAfter(Time::today());

            $absenByTanggal = $this->presensimemberModel
               ->getPresensiByTanggal($value->format('Y-m-d'));

            $absenByTanggal['lewat'] = $lewat;

            array_push($dataAbsen, $absenByTanggal);
            array_push($arrayTanggal, Time::createFromInstance($value, locale: 'id'));
         }
      }

      $laki = 0;

      foreach ($member as $value) {
         if ($value['jenis_kelamin'] != 'Perempuan') {
            $laki++;
         }
      }

      $data = [
         'tanggal' => $arrayTanggal,
         'bulan' => $begin->toLocalizedString('MMMM'),
         'listAbsen' => $dataAbsen,
         'listmember' => $member,
         'jumlahmember' => [
            'laki' => $laki,
            'perempuan' => count($member) - $laki
         ],
         'grup' => 'member',
      ];

      if ($type == 'doc') {
         $this->response->setHeader('Content-type', 'application/vnd.ms-word');
         $this->response->setHeader(
            'Content-Disposition',
            'attachment;Filename=laporan_absen_member_' . $begin->toLocalizedString('MMMM-Y') . '.doc'
         );

         return view('admin/generate-laporan/laporan-member', $data);
      }

      return view('admin/generate-laporan/laporan-member', $data) . view('admin/generate-laporan/topdf');
   }
}
