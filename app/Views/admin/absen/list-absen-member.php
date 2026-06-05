<?php

use App\Libraries\enums\UserRole; ?>
<style>
   .absensi-wrapper {
      position: relative;
      border-radius: 20px;
      overflow: hidden;
   }

   .absensi-wrapper::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;

      background:
         linear-gradient(rgba(0, 0, 0, 0.75),
            rgba(0, 0, 0, 0.75)),
         url('<?= base_url("assets/img/RajaGym.jpeg") ?>');

      background-size: cover;
      background-position: center;
      z-index: 0;
   }

   .absensi-content {
      position: relative;
      z-index: 1;
   }

   .absensi-content table {
      color: white;
   }

   .absensi-content thead {
      background: rgba(255, 255, 255, 0.12);
   }

   .absensi-content tbody tr {
      transition: .3s;
   }

   .absensi-content tbody tr:hover {
      background: rgba(255, 255, 255, 0.08);
   }

   .absensi-content td,
   .absensi-content th {
      border-color: rgba(255, 255, 255, 0.15) !important;
   }
</style>
<div class="absensi-wrapper">
   <div id="dataSiswa" class="card-body table-responsive pb-5 absensi-content">
      <?php if (!empty($data)): ?>
         <table class="table table-hover">
            <thead class="text-success">
               <th><b>No.</b></th>
               <th><b>Nama member</b></th>
               <th><b>Kehadiran</b></th>
               <th><b>Jam masuk</b></th>
               <th><b>Jam pulang</b></th>
               <th><b>Keterangan</b></th>
               <th><b>Aksi</b></th>
            </thead>
            <tbody>
               <?php $no = 1; ?>
               <?php foreach ($data as $value): ?>
                  <?php
                  $idKehadiran = intval($value['id_kehadiran'] ?? ($lewat ? 5 : 4));
                  $kehadiran = kehadiran($idKehadiran);
                  ?>
                  <tr>
                     <td><?= $no; ?></td>
                     <td><b><?= $value['nama_member']; ?></b></td>
                     <td>
                        <p class="p-2 my-auto w-100 badge badge-<?= $kehadiran['color']; ?> text-center">
                           <b><?= $kehadiran['text']; ?></b>
                        </p>
                     </td>
                     <td><b><?= $value['jam_masuk'] ?? '-'; ?></b></td>
                     <td><b><?= $value['jam_keluar'] ?? '-'; ?></b></td>
                     <td><?= $value['keterangan'] ?? '-'; ?></td>
                     <td>
                        <?php if (!$lewat && can_edit_attendance()): ?>
                           <button data-toggle="modal" data-target="#ubahModal" onclick="getDataKehadiran(<?= $value['id_presensi'] ?? '-1'; ?>, <?= $value['id_member']; ?>)" class="btn btn-info p-2"
                              id="<?= $value['id_member']; ?>">
                              <i class="material-icons">edit</i>
                              Edit
                           </button>
                        <?php else: ?>
                           <button class="btn btn-disabled p-2">No Action</button>
                        <?php endif; ?>
                     </td>
                  </tr>
               <?php $no++;
               endforeach ?>
            </tbody>
         </table>
      <?php
      else:
      ?>
         <div class="row">
            <div class="col">
               <h4 class="text-center text-danger">Data tidak ditemukan</h4>
            </div>
         </div>
      <?php
      endif; ?>
   </div>
</div>

<?php
function kehadiran($kehadiran): array
{
   $text = '';
   $color = '';
   switch ($kehadiran) {
      case 1:
         $color = 'success';
         $text = 'Hadir';
         break;
      case 2:
         $color = 'warning';
         $text = 'Sakit';
         break;
      case 3:
         $color = 'info';
         $text = 'Izin';
         break;
      case 4:
         $color = 'danger';
         $text = 'Tanpa keterangan';
         break;
      case 5:
      default:
         $color = 'disabled';
         $text = 'Belum tersedia';
         break;
   }

   return ['color' => $color, 'text' => $text];
}
?>