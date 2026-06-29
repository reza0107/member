<?php
/** @var object $generalSettings */

use App\Libraries\enums\UserRole;

$context = $ctx ?? 'dashboard';

$menuItems = [];
switch ($context) {

   case 'absen-member':
   case 'member':
      $sidebarColor = 'green';
      break;

   case 'qr':
   case 'backup':
   case 'penjualan-barang':
   case 'barang':
   case 'riwayat':
   case 'kasir':
      $sidebarColor = 'danger';
      break;

   default:
      $sidebarColor = 'azure';
      break;
}

// ==========================
// ADMIN
// ==========================
if (is_superadmin()) {

   $menuItems = [

      [
         'title' => 'Dashboard',
         'url' => 'admin/dashboard',
         'icon' => 'dashboard',
         'context' => 'dashboard',
         'visible' => true
      ],

      [
         'title' => 'Absensi member',
         'url' => 'admin/absen-member',
         'icon' => 'checklist',
         'context' => 'absen-member',
         'visible' => true
      ],

      [
         'title' => 'Data member',
         'url' => 'admin/member',
         'icon' => 'person_4',
         'context' => 'member',
         'visible' => true
      ],

      [
         'title' => 'Generate QR Code',
         'url' => 'admin/generate',
         'icon' => 'qr_code',
         'context' => 'qr',
         'visible' => true
      ],

      [
         'title' => 'Master Barang',
         'url' => 'admin/barang',
         'icon' => 'inventory_2',
         'context' => 'barang',
         'visible' => true
      ],

      [
         'title' => 'Kasir',
         'url' => 'admin/kasir',
         'icon' => 'shopping_cart',
         'context' => 'kasir',
         'visible' => true
      ],

      [
         'title' => 'Generate Laporan',
         'url' => 'admin/laporan',
         'icon' => 'print',
         'context' => 'laporan',
         'visible' => true
      ],

      [
         'title' => 'Data Petugas',
         'url' => 'admin/petugas',
         'icon' => 'computer',
         'context' => 'petugas',
         'visible' => true
      ],

      [
         'title' => 'Pengaturan',
         'url' => 'admin/general-settings',
         'icon' => 'settings',
         'context' => 'general_settings',
         'visible' => true
      ],

      [
         'title' => 'Backup & Restore',
         'url' => 'admin/backup',
         'icon' => 'backup',
         'context' => 'backup',
         'visible' => true
      ]

   ];
}

// ==========================
// KASIR
// ==========================
elseif (is_kasir()) {

   $menuItems = [

      [
         'title' => 'Kasir',
         'url' => 'admin/kasir',
         'icon' => 'shopping_cart',
         'context' => 'kasir',
         'visible' => true
      ],

      [
         'title' => 'Riwayat Penjualan',
         'url' => 'admin/kasir/riwayat',
         'icon' => 'receipt_long',
         'context' => 'riwayat',
         'visible' => true
      ],
      [
         'title' => 'Generate Laporan',
         'url' => 'admin/laporan',
         'icon' => 'print',
         'context' => 'laporan',
         'visible' => true
      ]

   ];
} elseif (is_kepsek()) {

   // MENU KEPSEK

} elseif (user_role() === UserRole::StafPetugas) {

   // MENU PETUGAS

} elseif (is_wali_kelas()) {

   // MENU WALI KELAS

}else {

   $menuItems = [];
}

?>
<div class="sidebar" data-color="<?= $sidebarColor; ?>" data-image="<?= base_url('assets/img/sidebar/RajaGym.jpeg'); ?>">
   <!-- data-background-color="black/red" -->
   <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
   <div class="logo">
      <a class="simple-text logo-normal">
         <b>Operator<br>Petugas Absensi</b>
         <br>
         <small><?= $generalSettings->school_name; ?></small>
      </a>
   </div>
   <div class="sidebar-wrapper">
      <ul class="nav">
         <?php
         foreach ($menuItems as $item):
            if (!$item['visible'])
               continue;
         ?>
            <li class="nav-item <?= $context == $item['context'] ? 'active' : ''; ?>">
               <a class="nav-link font-weight-bold" href="<?= base_url($item['url']); ?>">
                  <i class="material-icons"><?= $item['icon']; ?></i>
                  <p><?= $item['title']; ?></p>
               </a>
            </li>
         <?php endforeach; ?>
      </ul>
   </div>
</div>