<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\memberModel;
use App\Models\KelasModel;
use App\Models\SiswaModel;

class GenerateQR extends BaseController
{
   protected SiswaModel $siswaModel;
   protected KelasModel $kelasModel;

   protected memberModel $memberModel;

   public function __construct()
   {
      $this->siswaModel = new SiswaModel();
      $this->kelasModel = new KelasModel();

      $this->memberModel = new memberModel();
   }

   public function index()
   {
      if (!can_view_report()) {
         return redirect()->to('admin');
      }

      $siswa = $this->siswaModel->getAllSiswaWithKelas();
      $kelas = $this->kelasModel->getDataKelas();
      $member = $this->memberModel->getAllmember();

      $data = [
         'title' => 'Generate QR Code',
         'ctx' => 'qr',
         'siswa' => $siswa,
         'kelas' => $kelas,
         'member' => $member
      ];

      return view('admin/generate-qr/generate-qr', $data);
   }

   public function getSiswaByKelas()
   {
      $idKelas = $this->request->getVar('idKelas');

      $siswa = $this->siswaModel->getSiswaByKelas($idKelas);

      return $this->response->setJSON($siswa);
   }
}
