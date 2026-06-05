<?php

use App\Libraries\enums\TipeUser;

switch ($type) {

   case TipeUser::member:
?>
      <div class="card border-success shadow-sm">
   <div class="card-header bg-success text-white">
      <h4 class="mb-0">
         <i class="material-icons">check_circle</i>
         Absen <?= ucfirst($waktu); ?> Berhasil
      </h4>
   </div>

   <div class="card-body">
      <table class="table table-borderless mb-0">
         <tr>
            <td width="130"><b>Nama</b></td>
            <td><?= $data['nama_member']; ?></td>
         </tr>
         <tr>
            <td><b>ID Member</b></td>
            <td><?= $data['id_member']; ?></td>
         </tr>
         <tr>
            <td><b>No HP</b></td>
            <td><?= $data['no_hp']; ?></td>
         </tr>
         <tr>
            <td><b>Jam Masuk</b></td>
            <td>
               <span class="badge badge-info p-2">
                  <?= $presensi['jam_masuk'] ?? '-'; ?>
               </span>
            </td>
         </tr>
         <tr>
            <td><b>Jam Pulang</b></td>
            <td>
               <span class="badge badge-warning p-2">
                  <?= $presensi['jam_keluar'] ?? '-'; ?>
               </span>
            </td>
         </tr>
      </table>
   </div>
</div>
<?php
      break;

   default:
?>
      <h3 class="text-danger">Tipe tidak valid</h3>
<?php
      break;
}
?>