<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-success">
                  <h4 class="card-title"><b>Form Tambah member</b></h4>

               </div>
               <div class="card-body mx-5 my-3">

                  <?php if (session()->getFlashdata('msg')): ?>
                     <div class="pb-2">
                        <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?> ">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <i class="material-icons">close</i>
                           </button>
                           <?= session()->getFlashdata('msg') ?>
                        </div>
                     </div>
                  <?php endif; ?>

                  <form action="<?= base_url('admin/member/create'); ?>" method="post">
                     <?= csrf_field() ?>
                     <?php $validation = \Config\Services::validation(); ?>

                     <div class="form-group mt-4">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama"
                           class="form-control <?= $validation->getError('nama') ? 'is-invalid' : ''; ?>" name="nama"
                           placeholder="Your Name" value="<?= old('nama') ?? $oldInput['nama'] ?? '' ?>" required>
                        <div class="invalid-feedback">
                           <?= $validation->getError('nama'); ?>
                        </div>
                     </div>

                     <div class="form-group mt-2">
                        <label for="jk">Jenis Kelamin</label>
                        <?php
                        if (old('jk')) {
                           $l = (old('jk') ?? $oldInput['jk'] ?? '') == '1' ? 'checked' : '';
                           $p = (old('jk') ?? $oldInput['jk'] ?? '') == '2' ? 'checked' : '';
                        }
                        ?>
                        <div
                           class="form-check form-control pt-0 mb-1 <?= $validation->getError('jk') ? 'is-invalid' : ''; ?>">
                           <div class="row">
                              <div class="col-auto">
                                 <div class="row">
                                    <div class="col-auto pr-1">
                                       <input class="form-check" type="radio" name="jk" id="laki" value="1" <?= $l ?? ''; ?>>
                                    </div>
                                    <div class="col">
                                       <label class="form-check-label pl-0 pt-1" for="laki">
                                          <h6 class="text-dark">Laki-laki</h5>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                              <div class="col">
                                 <div class="row">
                                    <div class="col-auto pr-1">
                                       <input class="form-check" type="radio" name="jk" id="perempuan" value="2" <?= $p ?? ''; ?>>
                                    </div>
                                    <div class="col">
                                       <label class="form-check-label pl-0 pt-1" for="perempuan">
                                          <h6 class="text-dark">Perempuan</h6>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="invalid-feedback">
                           <?= $validation->getError('jk'); ?>
                        </div>
                     </div>

                     <div class="form-group mt-4">
                        <label for="alamat">Alamat</label>
                        <input type="text" id="alamat" name="alamat" class="form-control"
                           value="<?= old('alamat') ?? $oldInput['alamat'] ?? '' ?>">
                     </div>

                     <div class="form-group mt-4">
                        <label for="hp">No HP</label>
                        <input type="number" id="hp" name="no_hp"
                           class="form-control <?= $validation->getError('no_hp') ? 'is-invalid' : ''; ?>"
                           placeholder="08969xxx" value="<?= old('no_hp') ?? $oldInput['no_hp'] ?? '' ?>" required>
                        <div class="invalid-feedback">
                           <?= $validation->getError('no_hp'); ?>
                        </div>
                     </div>

                     <div class="form-group mt-4">
                        <label>Paket Membership</label>

                        <select name="paket" class="form-control" required>
                           <option value="">Pilih Paket</option>
                           <option value="1 Hari">1 Hari</option>
                           <option value="1 Bulan">1 Bulan</option>
                           <option value="3 Bulan">3 Bulan</option>
                           <option value="6 Bulan">6 Bulan</option>
                           <option value="12 Bulan">12 Bulan</option>
                        </select>
                     </div>

                     <div class="form-group mt-4">
                        <label for="nominal">Nominal</label>

                        <input type="text"
                           id="nominal"
                           name="nominal"
                           class="form-control"
                           readonly
                           placeholder="Nominal otomatis">
                     </div>

                     <div class="form-group">

                        <label>Metode Pembayaran</label>

                        <?php
                        $metode = $data['metode_bayar'] ?? '';
                        ?>

                        <div class="custom-control custom-checkbox">
                           <input type="checkbox"
                              class="custom-control-input"
                              id="cash">
                           <label class="custom-control-label" for="cash">
                              Cash
                           </label>
                        </div>

                        <div class="custom-control custom-checkbox">
                           <input type="checkbox"
                              class="custom-control-input"
                              id="qris">
                           <label class="custom-control-label" for="qris">
                              QRIS
                           </label>
                        </div>

                        <input
                           type="hidden"
                           name="metode_bayar"
                           id="metode_bayar"
                           value="<?= $metode ?>">

                     </div>

                     <div id="gabunganArea" style="display:none">

                        <div class="form-group">

                           <label>Bayar Cash</label>

                           <input
                              type="number"
                              class="form-control"
                              name="bayar_cash"
                              value="0">

                        </div>

                        <div class="form-group">

                           <label>Bayar QRIS</label>

                           <input
                              type="number"
                              class="form-control"
                              name="bayar_qris"
                              value="0">

                        </div>

                     </div>

                     <div class="form-group mt-4">
                        <label for="rfid">RFID Code</label>
                        <input type="text" id="rfid" name="rfid"
                           class="form-control <?= $validation->getError('rfid') ? 'is-invalid' : ''; ?>"
                           value="<?= old('rfid') ?? $oldInput['rfid'] ?? '' ?>" placeholder="Tap RFID Card here">
                        <div class="invalid-feedback">
                           <?= $validation->getError('rfid'); ?>
                        </div>
                     </div>

                     <button type="submit" class="btn btn-success btn-block">Simpan</button>
                  </form>

                  <hr>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   document.addEventListener('DOMContentLoaded', function() {

      const paket = document.querySelector('select[name="paket"]');
      const nominal = document.getElementById('nominal');
      const cash = document.getElementById('cash');
      const qris = document.getElementById('qris');

      const metode = document.getElementById('metode_bayar');
      const gabunganArea = document.getElementById('gabunganArea');

      function updateMetode() {

         if (cash.checked && qris.checked) {

            metode.value = 'Gabungan';

            gabunganArea.style.display = 'block';

         } else if (cash.checked) {

            metode.value = 'Cash';

            gabunganArea.style.display = 'none';

         } else if (qris.checked) {

            metode.value = 'QRIS';

            gabunganArea.style.display = 'none';

         } else {

            metode.value = '';

            gabunganArea.style.display = 'none';

         }
      }

      cash.addEventListener('change', updateMetode);
      qris.addEventListener('change', updateMetode);

      updateMetode();

      paket.addEventListener('change', function() {

         let harga = '';

         switch (this.value) {

            case '1 Hari':
               nominal.value = 25000;
               nominalText.innerHTML = 'Rp 25.000';
               break;

            case '1 Bulan':
               nominal.value = 175000;
               nominalText.innerHTML = 'Rp 175.000';
               break;

            case '3 Bulan':
               nominal.value = 425000;
               nominalText.innerHTML = 'Rp 425.000';
               break;

            case '6 Bulan':
               nominal.value = 875000;
               nominalText.innerHTML = 'Rp 875.000';
               break;

            case '12 Bulan':
               nominal.value = 1775000;
               nominalText.innerHTML = 'Rp 1.775.000';
               break;
         }

         nominal.value = harga;

      });

   });
</script>
<?= $this->endSection() ?>