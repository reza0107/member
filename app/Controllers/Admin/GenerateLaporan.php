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

class GenerateLaporan extends BaseController
{
   protected SiswaModel $siswaModel;
   protected KelasModel $kelasModel;

   protected memberModel $memberModel;

   protected PresensiSiswaModel $presensiSiswaModel;
   protected PresensimemberModel $presensimemberModel;

   public function __construct()
   {
      $this->siswaModel = new SiswaModel();
      $this->kelasModel = new KelasModel();

      $this->memberModel = new memberModel();

      $this->presensiSiswaModel = new PresensiSiswaModel();
      $this->presensimemberModel = new PresensimemberModel();
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

      $rekap = [
         '1 Hari' => ['jumlah' => 0, 'nominal' => 0],
         '1 Bulan' => ['jumlah' => 0, 'nominal' => 0],
         '3 Bulan' => ['jumlah' => 0, 'nominal' => 0],
         '6 Bulan' => ['jumlah' => 0, 'nominal' => 0],
         '12 Bulan' => ['jumlah' => 0, 'nominal' => 0],
      ];

      $query = $this->presensimemberModel
         ->select('tb_presensi_member.*, tb_member.nama_member, tb_member.paket, tb_member.nominal, tb_member.tanggal_daftar, tb_member.tanggal_expired')
         ->join('tb_member', 'tb_member.id_member = tb_presensi_member.id_member')
         ->where('tanggal >=', $awal)
         ->where('tanggal <=', $akhir);

      if ($paketFilter != 'all') {
         $query->where('tb_member.paket', $paketFilter);
      }

      $presensi = $query
         ->groupBy('tb_presensi_member.id_member')
         ->findAll();

      $totalMember = 0;
      $totalPendapatan = 0;

      foreach ($presensi as $p) {

         $paket = $p['paket'];

         if (!isset($rekap[$paket])) {
            continue;
         }

         $rekap[$paket]['jumlah']++;
         $rekap[$paket]['nominal'] += $p['nominal'];

         $totalMember++;
         $totalPendapatan += $p['nominal'];
      }

      $data = [
         'detailMember' => $presensi,
         'awal' => $awal,
         'akhir' => $akhir,
         'rekap' => $rekap,
         'totalMember' => $totalMember,
         'totalPendapatan' => $totalPendapatan,
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
