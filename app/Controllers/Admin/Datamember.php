<?php

namespace App\Controllers\Admin;

use App\Models\memberModel;
use App\Models\UploadModel;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class Datamember extends BaseController
{
   protected memberModel $memberModel;

   protected $memberValidationRules = [
      'nama' => [
         'rules' => 'required|min_length[3]'
      ],

      'jk' => [
         'rules' => 'required'
      ],

      'alamat' => [
         'rules' => 'required'
      ],

      'no_hp' => [
         'rules' => 'required'
      ],

      'paket' => [
         'rules' => 'required'
      ],

      'rfid' => [
         'rules' => 'permit_empty'
      ]
   ];

   public function __construct()
   {
      $this->memberModel = new memberModel();
   }

   public function index()
   {
      if (!is_superadmin()) {
         return redirect()->to('admin');
      }


      $data = [
         'title' => 'Data member',
         'ctx' => 'member',
      ];

      return view('admin/data/data-member', $data);
   }

   public function ambilDatamember()
   {
      $builder = $this->memberModel;

      // Filter Nama
      if ($this->request->getGet('nama')) {
         $builder->like(
            'nama_member',
            $this->request->getGet('nama')
         );
      }

      // Filter Jenis Kelamin
      if ($this->request->getGet('jenis_kelamin')) {
         $builder->where(
            'jenis_kelamin',
            $this->request->getGet('jenis_kelamin')
         );
      }

      // Filter Paket
      if ($this->request->getGet('paket')) {
         $builder->like(
            'paket',
            $this->request->getGet('paket')
         );
      }

      // Filter Status
      if ($this->request->getGet('status')) {

         if ($this->request->getGet('status') == 'Expired') {

            $builder->where(
               'tanggal_expired <',
               date('Y-m-d')
            );
         } elseif ($this->request->getGet('status') == 'Aktif') {

            $builder->where(
               'tanggal_expired >=',
               date('Y-m-d')
            );
         }
      }

      // Update status otomatis berdasarkan tanggal expired
      $allMember = $this->memberModel->findAll();

      foreach ($allMember as $member) {

         $statusBaru = (
            strtotime($member['tanggal_expired']) < strtotime(date('Y-m-d'))
         ) ? 'Expired' : 'Aktif';

         if ($member['status'] != $statusBaru) {

            $this->memberModel->update(
               $member['id_member'],
               [
                  'status' => $statusBaru
               ]
            );
         }
      }

      // Ambil data setelah update status
      $result = $builder->findAll();

      $data = [
         'data' => $result,
         'empty' => empty($result)
      ];

      return view('admin/data/list-data-member', $data);
   }

   public function formTambahmember()
   {
      $data = [
         'ctx' => 'member',
         'title' => 'Tambah Data member'
      ];

      return view('admin/data/create/create-data-member', $data);
   }

   public function savemember()
   {
      // validasi
      if (!$this->validate($this->memberValidationRules)) {
         $data = [
            'ctx' => 'member',
            'title' => 'Tambah Data member',
            'validation' => $this->validator,
            'oldInput' => $this->request->getVar()
         ];
         return view('/admin/data/create/create-data-member', $data);
      }

      // simpan
      $result = $this->memberModel->createmember(
         nama: $this->request->getVar('nama'),
         jenisKelamin: $this->request->getVar('jk'),
         alamat: $this->request->getVar('alamat'),
         noHp: $this->request->getVar('no_hp'),
         paket: $this->request->getVar('paket'),
         rfid: $this->request->getVar('rfid')
      );

      if ($result) {
         session()->setFlashdata([
            'msg' => 'Tambah data berhasil',
            'error' => false
         ]);
         return redirect()->to('/admin/member');
      }

      session()->setFlashdata([
         'msg' => 'Gagal menambah data',
         'error' => true
      ]);
      return redirect()->to('/admin/member/create/');
   }

   public function formEditmember($id)
   {
      $member = $this->memberModel->getmemberById($id);

      if (empty($member)) {
         throw new PageNotFoundException('Data member dengan id ' . $id . ' tidak ditemukan');
      }

      $data = [
         'data' => $member,
         'ctx' => 'member',
         'title' => 'Edit Data member',
      ];

      return view('admin/data/edit/edit-data-member', $data);
   }

   public function updatemember()
   {
      $idmember = $this->request->getVar('id');

      $this->memberValidationRules['rfid']['rules'] = "permit_empty|is_rfid_unique[{$idmember},member]";

      // validasi
      if (!$this->validate($this->memberValidationRules)) {
         $data = [
            'data' => $this->memberModel->getmemberById($idmember),
            'ctx' => 'member',
            'title' => 'Edit Data member',
            'validation' => $this->validator,
            'oldInput' => $this->request->getVar()
         ];
         return view('/admin/data/edit/edit-data-member', $data);
      }

      // update
      $result = $this->memberModel->updatemember(
         id: $idmember,
         nama: $this->request->getVar('nama'),
         jenisKelamin: $this->request->getVar('jk'),
         alamat: $this->request->getVar('alamat'),
         noHp: $this->request->getVar('no_hp'),
         rfid: $this->request->getVar('rfid')
      );

      if ($result) {
         session()->setFlashdata([
            'msg' => 'Edit data berhasil',
            'error' => false
         ]);
         return redirect()->to('/admin/member');
      }

      session()->setFlashdata([
         'msg' => 'Gagal mengubah data',
         'error' => true
      ]);
      return redirect()->to('/admin/member/edit/' . $idmember);
   }

   public function delete($id)
   {
      $result = $this->memberModel->delete($id);

      if ($result) {
         session()->setFlashdata([
            'msg' => 'Data berhasil dihapus',
            'error' => false
         ]);
         return redirect()->to('/admin/member');
      }

      session()->setFlashdata([
         'msg' => 'Gagal menghapus data',
         'error' => true
      ]);
      return redirect()->to('/admin/member');
   }

   /*
    *-------------------------------------------------------------------------------------------------
    * IMPORT member
    *-------------------------------------------------------------------------------------------------
    */

   /**
    * Bulk Post Upload
    */
   public function bulkPost()
   {
      $data = [
         'title' => 'Import member',
         'ctx' => 'member',
      ];

      return view('/admin/data/import-member', $data);
   }

   /**
    * Generate CSV Object Post
    */
   public function generateCSVObjectPost()
   {
      $uploadModel = new UploadModel();
      //delete old txt files
      $files = glob(FCPATH . 'uploads/tmp/*.txt');
      if (!empty($files)) {
         foreach ($files as $item) {
            @unlink($item);
         }
      }
      $file = $uploadModel->uploadCSVFile('file');
      if (!empty($file) && !empty($file['path'])) {
         $obj = $this->memberModel->generateCSVObject($file['path']);
         if (!empty($obj)) {
            $data = [
               'result' => 1,
               'numberOfItems' => $obj->numberOfItems,
               'txtFileName' => $obj->txtFileName,
            ];
            echo json_encode($data);
            exit();
         }
      }
      echo json_encode(['result' => 0]);
   }

   /**
    * Import CSV Item Post
    */
   public function importCSVItemPost()
   {
      $txtFileName = inputPost('txtFileName');
      $index = inputPost('index');
      $member = $this->memberModel->importCSVItem($txtFileName, $index);
      if (!empty($member)) {
         $data = [
            'result' => 1,
            'member' => $member,
            'index' => $index
         ];
         echo json_encode($data);
      } else {
         $data = [
            'result' => 0,
            'index' => $index
         ];
         echo json_encode($data);
      }
   }

   /**
    * Download CSV File Post
    */
   public function downloadCSVFilePost()
   {
      $submit = inputPost('submit');
      $response = \Config\Services::response();
      if ($submit == 'csv_member_template') {
         return $response->download(FCPATH . 'assets/file/csv_member_template.csv', null);
      }
   }
}
