<?php

namespace App\Controllers\Admin;

use App\Models\memberModel;

use App\Controllers\BaseController;
use App\Models\KehadiranModel;
use App\Models\PresensimemberModel;
use CodeIgniter\I18n\Time;

class DataAbsenmember extends BaseController
{
   protected memberModel $memberModel;

   protected PresensimemberModel $presensimember;

   protected KehadiranModel $kehadiranModel;

   public function __construct()
   {
      $this->memberModel = new memberModel();

      $this->presensimember = new PresensimemberModel();

      $this->kehadiranModel = new KehadiranModel();
   }

   public function index()
   {
      $data = [
         'title' => 'Data Absen member',
         'ctx' => 'absen-member',
      ];

      return view('admin/absen/absen-member', $data);
   }

   public function ambilDatamember()
   {
      // ambil variabel POST
      $tanggal = $this->request->getVar('tanggal');

      $lewat = Time::parse($tanggal)->isAfter(Time::today());

      $result = $this->presensimember->getPresensiByTanggal($tanggal);

      $data = [
         'data' => $result,
         'listKehadiran' => $this->kehadiranModel->getAllKehadiran(),
         'lewat' => $lewat
      ];

      return view('admin/absen/list-absen-member', $data);
   }

   public function ambilKehadiran()
   {
      $idPresensi = $this->request->getVar('id_presensi');
      $idmember = $this->request->getVar('id_member');

      $data = [
         'presensi' => $this->presensimember->getPresensiById($idPresensi),
         'listKehadiran' => $this->kehadiranModel->getAllKehadiran(),
         'data' => $this->memberModel->getmemberById($idmember)
      ];

      return view('admin/absen/ubah-kehadiran-modal', $data);
   }

   public function ubahKehadiran()
   {
      // ambil variabel POST
      $idKehadiran = $this->request->getVar('id_kehadiran');
      $idmember = $this->request->getVar('id_member');
      $tanggal = $this->request->getVar('tanggal');
      $jamMasuk = $this->request->getVar('jam_masuk');
      $jamKeluar = $this->request->getVar('jam_keluar');
      $keterangan = $this->request->getVar('keterangan');

      $cek = $this->presensimember->cekAbsen($idmember, $tanggal);

      $result = $this->presensimember->updatePresensi(
         $cek == false ? NULL : $cek,
         $idmember,
         $tanggal,
         $idKehadiran,
         $jamMasuk ?? NULL,
         $jamKeluar ?? NULL,
         $keterangan
      );

      $response['nama_member'] = $this->memberModel->getmemberById($idmember)['nama_member'];

      if ($result) {
         $response['status'] = TRUE;
      } else {
         $response['status'] = FALSE;
      }

      return $this->response->setJSON($response);
   }
}
