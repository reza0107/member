<?php

namespace App\Models;

use CodeIgniter\Model;

class memberModel extends Model
{
   protected $allowedFields = [
      'nama_member',
      'jenis_kelamin',
      'alamat',
      'no_hp',
      'paket',
      'nominal',
      'tanggal_daftar',
      'tanggal_expired',
      'status',
      'qr_code',
      'unique_code',
      'rfid_code'
   ];

   protected $table = 'tb_member';

   protected $primaryKey = 'id_member';

   public function cekmember(string $unique_code)
   {
      return $this->where(['unique_code' => $unique_code])
         ->orWhere(['rfid_code' => $unique_code])
         ->first();
   }

   public function getAllmember()
   {
      return $this->orderBy('nama_member')->findAll();
   }

   public function getmemberById($id)
   {
      return $this->where([$this->primaryKey => $id])->first();
   }

   public function createmember(
      $nama,
      $jenisKelamin,
      $alamat,
      $noHp,
      $paket,
      $rfid = null
   ) {
      $tanggalDaftar = date('Y-m-d');

      switch ($paket) {

         case '1 Hari':
            $expired = date('Y-m-d', strtotime('+1 day'));
            break;

         case '1 Bulan':
            $expired = date('Y-m-d', strtotime('+1 month'));
            break;

         case '3 Bulan':
            $expired = date('Y-m-d', strtotime('+3 months'));
            break;

         case '6 Bulan':
            $expired = date('Y-m-d', strtotime('+6 months'));
            break;

         case '12 Bulan':
            $expired = date('Y-m-d', strtotime('+12 months'));
            break;

         default:
            $expired = $tanggalDaftar;
            break;
      }

      $nominal = match ($paket) {
         '1 Hari' => 25000,
         '1 Bulan' => 175000,
         '3 Bulan' => 425000,
         '6 Bulan' => 875000,
         '12 Bulan' => 1775000,
         default => 0
      };

      $uniqueCode = uniqid('MBR');

      return $this->save([
         'nama_member' => $nama,
         'jenis_kelamin' => $jenisKelamin,
         'alamat' => $alamat,
         'no_hp' => $noHp,
         'paket' => $paket,
         'nominal' => $nominal,
         'tanggal_daftar' => $tanggalDaftar,
         'tanggal_expired' => $expired,
         'status' => 'Aktif',
         'unique_code' => $uniqueCode,
         'qr_code' => $uniqueCode,
         'rfid_code' => $rfid
      ]);
   }

   public function updatemember($id, $nama, $jenisKelamin, $alamat, $noHp, $rfid = null)
   {
      return $this->save([
         $this->primaryKey => $id,
         'nama_member' => $nama,
         'jenis_kelamin' => $jenisKelamin,
         'alamat' => $alamat,
         'no_hp' => $noHp,
         'rfid_code' => $rfid,
      ]);
   }

   //generate CSV object
   public function generateCSVObject($filePath)
   {
      $array = array();
      $fields = array();
      $txtName = uniqid() . '.txt';
      $i = 0;
      $handle = fopen($filePath, 'r');
      if ($handle) {
         while (($row = fgetcsv($handle)) !== false) {
            if (empty($fields)) {
               $fields = $row;
               // Remove BOM from the first element if present
               if (isset($fields[0])) {
                  $fields[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $fields[0]);
               }
               // Trim all fields
               $fields = array_map('trim', $fields);
               continue;
            }
            foreach ($row as $k => $value) {
               if (isset($fields[$k])) {
                  $array[$i][$fields[$k]] = trim($value);
               }
            }
            $i++;
         }
         if (!feof($handle)) {
            return false;
         }
         fclose($handle);
         if (!empty($array)) {
            $txtFile = fopen(FCPATH . 'uploads/tmp/' . $txtName, 'w');
            fwrite($txtFile, serialize($array));
            fclose($txtFile);
            $obj = new \stdClass();
            $obj->numberOfItems = countItems($array);
            $obj->txtFileName = $txtName;
            @unlink($filePath);
            return $obj;
         }
      }
      return false;
   }

   //import csv item
   public function importCSVItem($txtFileName, $index)
   {
      $filePath = FCPATH . 'uploads/tmp/' . $txtFileName;
      $file = fopen($filePath, 'r');
      $content = fread($file, filesize($filePath));
      $array = @unserialize($content);
      if (!empty($array)) {
         $i = 1;
         foreach ($array as $item) {
            if ($i == $index) {
               $nama = getCSVInputValue($item, 'nama_member');
               $noHp = getCSVInputValue($item, 'no_hp');

               $data = array();
               $data['nama_member'] = $nama;
               $data['jenis_kelamin'] = getCSVInputValue($item, 'jenis_kelamin');
               $data['alamat'] = getCSVInputValue($item, 'alamat');
               $data['no_hp'] = $noHp;
               // Logic from createmember
               $data['unique_code'] = sha1($nama . md5($nama . $noHp)) . substr(sha1(rand(0, 100)), 0, 24);

               $this->insert($data);
               return $data;
            }
            $i++;
         }
      }
   }
}
