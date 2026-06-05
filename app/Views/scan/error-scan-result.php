<h3 class="text-danger"><?= $msg; ?></h3>

<?php if (!empty($data)) : ?>
<div class="alert alert-warning mt-3">
   <p>Nama : <b><?= $data['nama_member'] ?? '-'; ?></b></p>
   <p>ID Member : <b><?= $data['id_member'] ?? '-'; ?></b></p>
   <p>Masa Aktif Sampai :
      <b class="text-danger">
         <?= $data['tanggal_expired'] ?? '-'; ?>
      </b>
   </p>
</div>
<?php endif; ?>