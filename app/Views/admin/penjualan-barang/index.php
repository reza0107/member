<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content') ?>

<div class="content">

    <div class="container-fluid">

        <div class="card">

            <div class="card-header card-header-danger">

                <h4>Penjualan Barang</h4>

            </div>

            <div class="card-body">

                <form action="<?= base_url('admin/penjualan-barang/create') ?>" method="post">

                    <div class="row">

                        <div class="col-md-4">
                            <input type="text"
                                name="nama_barang"
                                class="form-control"
                                placeholder="Nama Barang"
                                required>
                        </div>

                        <div class="col-md-2">
                            <input type="number"
                                name="qty"
                                class="form-control"
                                placeholder="Qty"
                                required>
                        </div>

                        <div class="col-md-3">
                            <input type="number"
                                name="harga_satuan"
                                class="form-control"
                                placeholder="Harga"
                                required>
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-danger">
                                Simpan
                            </button>
                        </div>

                    </div>

                    <hr>

                    <table class="table table-bordered">

                        <thead>

                            <tr>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Total</th>
                                <th>Metode</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($barang as $b): ?>

                                <tr>

                                    <td><?= $b['tanggal_penjualan'] ?></td>

                                    <td><?= $b['nama_barang'] ?></td>

                                    <td><?= $b['qty'] ?></td>

                                    <td>
                                        Rp <?= number_format($b['harga_satuan']) ?>
                                    </td>

                                    <td>
                                        Rp <?= number_format($b['total_harga']) ?>
                                    </td>

                                    <td>
                                        <?= $b['metode_bayar'] ?>
                                    </td>

                                </tr>

                            <?php endforeach ?>

                        </tbody>

                    </table>

                </form>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>