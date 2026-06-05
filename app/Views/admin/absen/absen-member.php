<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="card">
         <div class="card-body">
            <div class="pt-3 pl-3 pb-2">
               <h4><b>Tanggal</b></h4>
               <input class="form-control" type="date" name="tangal" id="tanggal" value="<?= date('Y-m-d'); ?>" onchange="getmember()" style="max-width: 200px;">
            </div>
         </div>
      </div>
      <div class="card primary">
         <div class="card-body">
            <div class="row justify-content-between">
               <div class="col">
                  <div class="pt-3 pl-3">
                     <h4><b>Absen member</b></h4>
                     <p>Daftar member muncul disini</p>
                  </div>
               </div>
               <div class="col-sm-auto">
                  <a href="#" class="btn btn-success pl-3 mr-3 mt-3" onclick="kelas = getmember()" data-toggle="tab">
                     <i class="material-icons mr-2">refresh</i> Refresh
                  </a>
               </div>
            </div>

            <div id="datamember">

            </div>
         </div>
      </div>
   </div>

   <!-- Modal -->
   <div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="modalUbahKehadiran" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="modalUbahKehadiran">Ubah kehadiran</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div id="modalFormUbahmember"></div>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
   getmember();

   function getmember() {
      var tanggal = $('#tanggal').val();

      jQuery.ajax({
         url: "<?= base_url('/admin/absen-member'); ?>",
         type: 'post',
         data: {
            'tanggal': tanggal
         },
         success: function(response, status, xhr) {
            // console.log(status);
            $('#datamember').html(response);

            $('html, body').animate({
               scrollTop: $("#datamember").offset().top
            }, 500);
         },
         error: function(xhr, status, thrown) {
            console.log(thrown);
            $('#datamember').html(thrown);
         }
      });
   }

   function ubahKehadiran() {
      var tanggal = $('#tanggal').val();

      var form = $('#formUbah').serializeArray();

      form.push({
         name: 'tanggal',
         value: tanggal
      });

      jQuery.ajax({
         url: "<?= base_url('/admin/absen-member/edit'); ?>",
         type: 'post',
         data: form,
         success: function(response, status, xhr) {
            // console.log(status);

            if (response['status']) {
               alert('Berhasil ubah kehadiran : ' + response['nama_member']);
            } else {
               alert('Gagal ubah kehadiran : ' + response['nama_member']);
            }

            getmember();
         },
         error: function(xhr, status, thrown) {
            console.log(thrown);
            alert('Gagal ubah kehadiran\n' + thrown);
         }
      });
   }

   function getDataKehadiran(idPresensi, idmember) {
      jQuery.ajax({
         url: "<?= base_url('/admin/absen-member/kehadiran'); ?>",
         type: 'post',
         data: {
            'id_presensi': idPresensi,
            'id_member': idmember
         },
         success: function(response, status, xhr) {
            // console.log(status);
            $('#modalFormUbahmember').html(response);
         },
         error: function(xhr, status, thrown) {
            console.log(thrown);
            $('#modalFormUbahmember').html(thrown);
         }
      });
   }
</script>
<?= $this->endSection() ?>
