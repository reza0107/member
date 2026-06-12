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

   .member-wrapper {
      padding: 25px;
      max-width: 100%;
   }

   .member-wrapper table {
      min-width: 1100px;
   }

   .table-responsive {
      overflow-x: auto;
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
         <?php

         $jmlHarian = 0;
         $jml1Bulan = 0;
         $jml3Bulan = 0;
         $jml6Bulan = 0;
         $jml12Bulan = 0;

         foreach ($data as $m) {

            if ($m['paket'] == '1 Hari') $jmlHarian++;

            if ($m['paket'] == '1 Bulan') $jml1Bulan++;

            if ($m['paket'] == '3 Bulan') $jml3Bulan++;

            if ($m['paket'] == '6 Bulan') $jml6Bulan++;

            if ($m['paket'] == '12 Bulan' || $m['paket'] == '1 Tahun') $jml12Bulan++;
         }
         ?>
         <!-- BARIS 1 -->
         <div class="row mb-3">

            <div class="col-md-4 mb-2">
               <input type="text"
                  id="searchMember"
                  class="form-control"
                  placeholder="🔍 Cari Nama Member">
            </div>

            <div class="col-md-3 mb-2">
               <select id="filterJK" class="form-control">
                  <option value="">Semua Jenis Kelamin</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
               </select>
            </div>

            <div class="col-md-3 mb-2">
               <select id="filterStatus" class="form-control">
                  <option value="">Semua Status</option>
                  <option value="Aktif">Aktif</option>
                  <option value="Expired">Expired</option>
               </select>
            </div>

            <div class="col-md-2 mb-2">
               <button
                  type="button"
                  id="resetFilter"
                  class="btn btn-danger ">
                  Reset
               </button>
            </div>

         </div>

         <!-- BARIS 2 -->
         <div class="row mb-4">

            <div class="col-md-3 mb-2">
               <select id="filterPaket" class="form-control">
                  <option value="">Semua Paket</option>
                  <option value="1 Hari">1 Hari</option>
                  <option value="1 Bulan">1 Bulan</option>
                  <option value="3 Bulan">3 Bulan</option>
                  <option value="6 Bulan">6 Bulan</option>
                  <option value="12 Bulan">12 Bulan</option>
               </select>
            </div>

            <div class="col-md-3 mb-2">
               <input type="date"
                  id="tanggalDari"
                  class="form-control">
            </div>

            <div class="col-md-3 mb-2">
               <input type="date"
                  id="tanggalSampai"
                  class="form-control">
            </div>

         </div>
         <table class="table table-hover" id="memberTable">
            <thead class="text-success">
               <th><b>No</b></th>
               <th><b>Nama Member</b></th>
               <th><b>Jenis Kelamin</b></th>
               <th><b>No HP</b></th>
               <th><b>Paket</b></th>
               <th><b>Tanggal Daftar</b></th>
               <th><b>Nominal</b></th>
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

                     <td class="tanggal-daftar">
                        <?= $value['tanggal_daftar']; ?>
                     </td>

                     <td>
                        Rp <?= number_format($value['nominal'], 0, ',', '.'); ?>
                     </td>

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
         <?php

         $totalMember = count($data);

         $totalNominal = 0;

         foreach ($data as $m) {
            $totalNominal += ($m['nominal'] ?? 0);
         }

         ?>

         <div id="hasilFilter"
            class="row mt-4"
            style="display:none">

            <div class="col-md-6">

               <div class="card bg-success text-white">

                  <div class="card-body text-center">

                     <h6>Total Member</h6>

                     <h2 id="totalMember">0</h2>

                  </div>

               </div>

            </div>

            <div class="col-md-6">

               <div class="card bg-info text-white">

                  <div class="card-body text-center">

                     <h6>Total Nominal</h6>

                     <h2>
                        Rp <span id="totalNominal">0</span>
                     </h2>

                  </div>

               </div>

            </div>

         </div>
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
         let paket = $('#filterPaket').val();

         let dari = $('#tanggalDari').val();
         let sampai = $('#tanggalSampai').val();

         let totalMember = 0;
         let totalNominal = 0;

         $('#memberTable tbody tr').each(function() {

            let nama = $(this).find('td:eq(1)').text().toLowerCase();
            let jenisKelamin = $(this).find('td:eq(2)').text().trim();
            let paketMember = $(this).find('td:eq(4)').text().trim();

            let tanggal = $(this).find('td:eq(5)').text().trim();

            let statusMember = $(this)
               .find('td:eq(8) .badge')
               .text()
               .trim();

            let tanggalExpired = $(this).find('td:eq(7)').text().trim();

            let tampil = true;

            // Nama
            if (search && !nama.includes(search)) {
               tampil = false;
            }

            // Jenis Kelamin
            if (jk !== '' && jenisKelamin !== jk) {
               tampil = false;
            }

            // Status
            if (status !== '' && statusMember !== status) {
               tampil = false;
            }

            // Paket
            if (paket !== '' && paketMember !== paket) {
               tampil = false;
            }

            // Tanggal
            if (status === 'Expired') {

               if (dari !== '' && tanggalExpired < dari) {
                  tampil = false;
               }

               if (sampai !== '' && tanggalExpired > sampai) {
                  tampil = false;
               }

            } else {

               if (dari !== '' && tanggal < dari) {
                  tampil = false;
               }

               if (sampai !== '' && tanggal > sampai) {
                  tampil = false;
               }

            }

            // Hitung total jika tampil
            if (tampil) {

               totalMember++;

               let nominal = parseInt(
                  $(this)
                  .find('td:eq(6)')
                  .text()
                  .replace(/Rp/g, '')
                  .replace(/\./g, '')
                  .trim()
               ) || 0;

               totalNominal += nominal;
            }
            $('#totalMember').text(totalMember)

            $(this).toggle(tampil);

            console.log(
               $(this).find('td:eq(8)').text().trim()
            );

         });

         // Tampilkan total HANYA jika paket + tanggal dipilih
         if (
            paket !== '' &&
            dari !== '' &&
            sampai !== ''
         ) {

            $('#hasilFilter').show();

            $('#totalMember').text(totalMember);

            $('#totalNominal').text(
               totalNominal.toLocaleString('id-ID')
            );
         } else {

            $('#hasilFilter').hide();

         }
      }

      $('#searchMember').on('keyup', filterTable);

      $('#filterJK').on('change', filterTable);

      $('#filterStatus').on('change', filterTable);

      $('#filterPaket').on('change', filterTable);

      $('#tanggalDari').on('change', filterTable);

      $('#tanggalSampai').on('change', filterTable);

      $('#resetFilter').on('click', function() {

         $('#searchMember').val('');

         $('#filterJK').val('');

         $('#filterStatus').val('');

         $('#filterPaket').val('');

         $('#tanggalDari').val('');

         $('#tanggalSampai').val('');

         $('#hasilFilter').hide();

         filterTable();
      });

   });
</script>