<style>
   .member-wrapper {
      background:
         linear-gradient(rgba(20, 20, 20, 0.85),
            rgba(20, 20, 20, 0.85)),
         url('<?= base_url("assets/img/RajaGym.jpeg") ?>');

      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;

      box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
      border-radius: 30px !important;
      overflow: hidden;
   }

   .member-wrapper table {
      color: white;
      border-radius: 30px !important;
   }

   .member-wrapper thead {
      background: rgba(255, 255, 255, .08);
   }

   /* Header tabel */
   .member-wrapper thead th:first-child {
      border-top-left-radius: 15px;
   }

   .member-wrapper thead th:last-child {
      border-top-right-radius: 15px;
   }

   .member-wrapper thead th {
      color: #4caf50 !important;
      border-top: none !important;
   }

   .member-wrapper tbody tr {
      transition: .3s;
   }

   .member-wrapper tbody tr:hover {
      background: rgba(255, 255, 255, .08);
   }

   .member-wrapper td,
   .member-wrapper th {
      border-color: rgba(255, 255, 255, .1) !important;
   }

   .member-wrapper .form-control,
   .member-wrapper select {
      border-radius: 30px !important;
      background: rgba(255, 255, 255, .95);
   }

   /* Badge Aktif & Expired */
   .member-wrapper .badge {
      border-radius: 30px !important;
      padding: 8px 15px;
   }

   .member-wrapper .badge-success {
      background: #28a745;
   }

   .member-wrapper .badge-danger {
      background: #dc3545;
   }

   .member-wrapper .btn {
      border-radius: 30px !important;
      margin-right: 3px;
   }

   .card {
      border-radius: 30px !important;
   }

   .mb-3 {
      margin-left: 5px;
      margin-right: 5px;
      margin-bottom: 1rem !important;
   }
</style>

<div class="card-body">
   <div class="member-wrapper table-responsive">
      <div class="text-center mb-4">
         <h2 class="text-white font-weight-bold">
            DATA MEMBER RAJA GYM
         </h2>

         <p class="text-light">
            Kelola data member aktif dan expired
         </p>
      </div>
      <?php if (!$empty) : ?>
         <div class="row mb-3">

            <div class="col-md-4">
               <input type="text"
                  id="searchMember"
                  class="form-control"
                  placeholder="Cari nama member...">
            </div>

            <div class="col-md-3">
               <select id="filterJK" class="form-control">
                  <option value="">Semua Jenis Kelamin</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
               </select>
            </div>

            <div class="col-md-3">
               <select id="filterStatus" class="form-control">
                  <option value="">Semua Status</option>
                  <option value="Aktif">Aktif</option>
                  <option value="Expired">Expired</option>
               </select>
            </div>

            <div class="col-md-2">
               <button type="button"
                  id="resetFilter"
                  class="btn btn-secondary btn-block">
                  Reset
               </button>
            </div>

         </div>
         <table class="table table-hover" id="memberTable">
            <thead class="text-success">
               <th><b>No</b></th>
               <th><b>Nama Member</b></th>
               <th><b>Jenis Kelamin</b></th>
               <th><b>No HP</b></th>
               <th><b>Paket</b></th>
               <th><b>Expired</b></th>
               <th><b>Status</b></th>
               <th width="1%"><b>Aksi</b></th>
            </thead>
            <tbody>
               <?php $i = 1;
               foreach ($data as $value) : ?>
                  <tr>
                     <td><?= $i; ?></td>
                     <td><b><?= $value['nama_member']; ?></b></td>
                     <td><?= $value['jenis_kelamin']; ?></td>
                     <td><?= $value['no_hp']; ?></td>
                     <td><?= $value['paket']; ?></td>
                     <td><?= $value['tanggal_expired']; ?></td>

                     <td>
                        <?php
                        $expired = strtotime($value['tanggal_expired']) < strtotime(date('Y-m-d'));
                        ?>

                        <?php if (!$expired): ?>
                           <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                           <span class="badge badge-danger">Expired</span>
                        <?php endif; ?>
                     </td>

                     <td>
                        <div class="d-flex justify-content-center">
                           <a href="<?= base_url('admin/member/edit/' . $value['id_member']); ?>"
                              class="btn btn-success p-2">
                              <i class="material-icons">edit</i>
                           </a>

                           <form action="<?= base_url('admin/member/delete/' . $value['id_member']); ?>"
                              method="post"
                              class="d-inline">
                              <?= csrf_field(); ?>
                              <input type="hidden" name="_method" value="DELETE">

                              <button type="submit"
                                 class="btn btn-danger p-2"
                                 onclick="return confirm('Hapus member ini?')">
                                 <i class="material-icons">delete_forever</i>
                              </button>
                           </form>

                           <a href="<?= base_url('admin/qr/member/' . $value['id_member'] . '/download'); ?>"
                              class="btn btn-info p-2">
                              <i class="material-icons">qr_code</i>
                           </a>
                        </div>
                     </td>
                  </tr>
               <?php $i++;
               endforeach; ?>
            </tbody>
         </table>
      <?php else : ?>
         <div class="row">
            <div class="col">
               <h4 class="text-center text-danger">Data tidak ditemukan</h4>
            </div>
         </div>
      <?php endif; ?>
   </div>
</div>
<script>
   $(document).ready(function() {

      function filterTable() {

         let search = $('#searchMember').val().toLowerCase();
         let jk = $('#filterJK').val();
         let status = $('#filterStatus').val();

         $('#memberTable tbody tr').each(function() {

            let nama = $(this).find('td:eq(1)').text().toLowerCase();
            let jenisKelamin = $(this).find('td:eq(2)').text().trim();
            let statusMember = $(this).find('td:eq(6)').text().trim();

            let tampil = true;

            // Cari Nama
            if (search && !nama.includes(search)) {
               tampil = false;
            }

            // Filter JK
            if (jk && jenisKelamin !== jk) {
               tampil = false;
            }

            // Filter Status
            if (status && statusMember !== status) {
               tampil = false;
            }

            $(this).toggle(tampil);
         });
      }

      $('#searchMember').on('keyup', filterTable);
      $('#filterJK').on('change', filterTable);
      $('#filterStatus').on('change', filterTable);

      $('#resetFilter').on('click', function() {
         $('#searchMember').val('');
         $('#filterJK').val('');
         $('#filterStatus').val('');
         filterTable();
      });

   });
</script>