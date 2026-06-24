<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-success">
                  <h4 class="card-title"><b>Form Edit member</b></h4>

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

                  <form action="<?= base_url('admin/member/edit'); ?>" method="post">
                     <?= csrf_field() ?>
                     <?php $validation = \Config\Services::validation(); ?>

                     <input type="hidden" name="id" value="<?= $data['id_member'] ?>">


                     <div class="form-group mt-4">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama"
                           class="form-control <?= $validation->getError('nama') ? 'is-invalid' : ''; ?>" name="nama"
                           placeholder="Your Name" value="<?= old('nama') ?? $oldInput['nama'] ?? $data['nama_member'] ?>"
                           required>
                        <div class="invalid-feedback">
                           <?= $validation->getError('nama'); ?>
                        </div>
                     </div>

                     <div class="form-group mt-2">
                        <label for="jk">Jenis Kelamin</label>
                        <?php
                        $jenisKelamin = (old('jk') ?? $oldInput['jk'] ?? $data['jenis_kelamin']);
                        $l = $jenisKelamin == 'Laki-laki' || $jenisKelamin == '1' ? 'checked' : '';
                        $p = $jenisKelamin == 'Perempuan' || $jenisKelamin == '2' ? 'checked' : '';
                        ?>
                        <div
                           class="form-check form-control pt-0 mb-1 <?= $validation->getError('jk') ? 'is-invalid' : ''; ?>">
                           <div class="row">
                              <div class="col-auto">
                                 <div class="row">
                                    <div class="col-auto pr-1">
                                       <input class="form-check" type="radio" name="jk" value="Laki-laki" <?= $l; ?>>
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
                                       <input class="form-check" type="radio" name="jk" value="Perempuan" <?= $p; ?>>
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
                           value="<?= old('alamat') ?? $oldInput['alamat'] ?? $data['alamat'] ?>">
                     </div>

                     <div class="form-group mt-4">
                        <label for="hp">No HP</label>
                        <input type="number" id="hp" name="no_hp"
                           class="form-control <?= $validation->getError('no_hp') ? 'is-invalid' : ''; ?>"
                           placeholder="08969xxx" value="<?= old('no_hp') ?? $oldInput['no_hp'] ?? $data['no_hp'] ?>"
                           required>
                        <div class="invalid-feedback">
                           <?= $validation->getError('no_hp'); ?>
                        </div>
                     </div>

                     <?php
                     $paket = old('paket') ?? ($data['paket'] ?? '');
                     ?>

                     <div class="form-group mt-4">
                        <label>Paket Membership</label>

                        <select name="paket" id="paket" class="form-control" required>
                           <option value="">Pilih Paket</option>

                           <option value="1 Hari" <?= $paket == '1 Hari' ? 'selected' : '' ?>>
                              1 Hari
                           </option>

                           <option value="1 Bulan" <?= $paket == '1 Bulan' ? 'selected' : '' ?>>
                              1 Bulan
                           </option>

                           <option value="3 Bulan" <?= $paket == '3 Bulan' ? 'selected' : '' ?>>
                              3 Bulan
                           </option>

                           <option value="6 Bulan" <?= $paket == '6 Bulan' ? 'selected' : '' ?>>
                              6 Bulan
                           </option>

                           <option value="12 Bulan" <?= $paket == '12 Bulan' ? 'selected' : '' ?>>
                              12 Bulan
                           </option>
                        </select>
                     </div>

                     <div class="form-group mt-4">
                        <label>Nominal</label>
                        <input type="number"
                           name="nominal"
                           id="nominal"
                           class="form-control"
                           value="<?= old('nominal') ?? ($data['nominal'] ?? '') ?>"
                           readonly>
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
                           value="<?= old('rfid') ?? $oldInput['rfid'] ?? $data['rfid_code'] ?? '' ?>"
                           placeholder="Tap RFID Card here">
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

      const paket = document.getElementById('paket');
      const nominal = document.getElementById('nominal');

      function updateNominal() {

         switch (paket.value) {

            case '1 Hari':
               nominal.value = 25000;
               break;

            case '1 Bulan':
               nominal.value = 175000;
               break;

            case '3 Bulan':
               nominal.value = 425000;
               break;

            case '6 Bulan':
               nominal.value = 875000;
               break;

            case '12 Bulan':
               nominal.value = 1775000;
               break;

            default:
               nominal.value = '';
         }
      }

      paket.addEventListener('change', updateNominal);

      updateNominal();
   });

   const cash = document.getElementById('cash');
   const qris = document.getElementById('qris');

   const metodeBayar =
      document.getElementById('metode_bayar');

   const gabunganArea =
      document.getElementById('gabunganArea');

   function updateMetode() {

      if (cash.checked && qris.checked) {

         metodeBayar.value = 'Gabungan';
         gabunganArea.style.display = 'block';

      } else if (cash.checked) {

         metodeBayar.value = 'Cash';
         gabunganArea.style.display = 'none';

      } else if (qris.checked) {

         metodeBayar.value = 'QRIS';
         gabunganArea.style.display = 'none';

      } else {

         metodeBayar.value = '';
         gabunganArea.style.display = 'none';

      }
   }

   cash.addEventListener('change', updateMetode);
   qris.addEventListener('change', updateMetode);

   updateMetode();

   function toggleMetodeBayar() {

      if (metodeBayar.value === 'Gabungan') {

         gabunganArea.style.display = 'block';

      } else {

         gabunganArea.style.display = 'none';

      }
   }

   metodeBayar.addEventListener(
      'change',
      toggleMetodeBayar
   );

   toggleMetodeBayar();
</script>
<?= $this->endSection() ?>