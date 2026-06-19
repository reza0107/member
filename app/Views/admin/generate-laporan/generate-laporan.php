<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <?php if (session()->getFlashdata('msg')): ?>
               <div class="pb-2 px-3">
                  <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?> ">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                     </button>
                     <?= session()->getFlashdata('msg') ?>
                  </div>
               </div>
            <?php endif; ?>
            <div class="card">
               <div class="card-header card-header-tabs card-header-info">
                  <div class="nav-tabs-navigation">
                     <div class="row">
                        <div class="col">
                           <h4 class="card-title"><b>Generate Laporan</b></h4>
                           <p class="card-category">Laporan absen</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row">

                     <!-- CARD PENDAPATAN -->
                     <div class="col-md-6">
                        <div class="card border-success h-100">

                           <div class="card-header bg-success text-white">
                              <h4 class="mb-0">
                                 💰 Laporan Pendapatan Membership
                              </h4>
                           </div>

                           <div class="card-body">

                              <form action="<?= base_url('admin/laporan/pendapatan'); ?>" method="post">

                                 <div class="form-group">
                                    <label>Dari Tanggal</label>
                                    <input type="date"
                                       name="tanggal_awal"
                                       class="form-control"
                                       required>
                                 </div>

                                 <div class="form-group">
                                    <label>Sampai Tanggal</label>
                                    <input type="date"
                                       name="tanggal_akhir"
                                       class="form-control"
                                       required>
                                 </div>

                                 <div class="form-group">
                                    <label>Paket Membership</label>

                                    <select name="paket" class="form-control">
                                       <option value="all">Semua Paket</option>
                                       <option value="1 Hari">1 Hari</option>
                                       <option value="1 Bulan">1 Bulan</option>
                                       <option value="3 Bulan">3 Bulan</option>
                                       <option value="6 Bulan">6 Bulan</option>
                                       <option value="12 Bulan">12 Bulan</option>
                                    </select>
                                 </div>

                                 <div class="row mt-4">

                                    <div class="col-6">
                                       <button
                                          type="submit"
                                          name="type"
                                          value="pdf"
                                          class="btn btn-danger btn-block">

                                          <i class="material-icons">picture_as_pdf</i>
                                          PDF
                                       </button>
                                    </div>

                                    <div class="col-6">
                                       <button
                                          type="submit"
                                          name="type"
                                          value="doc"
                                          class="btn btn-info btn-block">

                                          <i class="material-icons">description</i>
                                          DOC
                                       </button>
                                    </div>

                                 </div>

                              </form>

                           </div>

                        </div>
                     </div>

                     <!-- CARD ABSENSI -->
                     <div class="col-md-6">
                        <div class="card border-info h-100">

                           <div class="card-header bg-info text-white">
                              <h4 class="mb-0">
                                 📋 Laporan Absensi Member
                              </h4>
                           </div>

                           <div class="card-body">

                              <form action="<?= base_url('admin/laporan/member'); ?>" method="post">

                                 <div class="form-group">

                                    <label>Total Member</label>

                                    <input
                                       type="text"
                                       class="form-control"
                                       value="<?= count($member); ?> Member"
                                       readonly>

                                 </div>

                                 <div class="form-group">

                                    <label>Bulan</label>

                                    <input
                                       type="month"
                                       name="tanggalmember"
                                       class="form-control"
                                       value="<?= date('Y-m'); ?>">

                                 </div>

                                 <div class="row mt-4">

                                    <div class="col-6">

                                       <button
                                          type="submit"
                                          name="type"
                                          value="pdf"
                                          class="btn btn-danger btn-block">

                                          <i class="material-icons">picture_as_pdf</i>
                                          PDF

                                       </button>

                                    </div>

                                    <div class="col-6">

                                       <button
                                          type="submit"
                                          name="type"
                                          value="doc"
                                          class="btn btn-info btn-block">

                                          <i class="material-icons">description</i>
                                          DOC

                                       </button>

                                    </div>

                                 </div>

                              </form>

                           </div>

                        </div>
                     </div>

                  </div>
                  <br><br>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>