<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">

    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-8 mx-auto">

                <div class="card">

                    <div class="card-header card-header-danger">

                        <h4 class="card-title">

                            <b>Tambah Barang</b>

                        </h4>

                    </div>

                    <div class="card-body">

                        <form action="<?= base_url('admin/barang/store') ?>" method="post">

                            <?= csrf_field() ?>

                            <div class="form-group">

                                <label>Nama Barang</label>

                                <input
                                    type="text"
                                    name="nama_barang"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="form-group">

                                <label>Kategori</label>

                                <select
                                    name="kategori"
                                    class="form-control">

                                    <option>Minuman</option>

                                    <option>Makanan</option>

                                    <option>Susu Suplemen</option>

                                    <option>Barang Lainnya</option>

                                </select>

                            </div>

                            <div class="form-group">

                                <label>Harga Beli</label>

                                <input
                                    type="number"
                                    name="harga_beli"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="form-group">

                                <label>Harga Jual</label>

                                <input
                                    type="number"
                                    name="harga_jual"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="form-group">

                                <label>Stok</label>

                                <input
                                    type="number"
                                    name="stok"
                                    class="form-control"
                                    required>

                            </div>

                            <button
                                class="btn btn-success btn-block">

                                Simpan Barang

                            </button>

                            <a
                                href="<?= base_url('admin/barang') ?>"
                                class="btn btn-secondary btn-block">

                                Kembali

                            </a>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>