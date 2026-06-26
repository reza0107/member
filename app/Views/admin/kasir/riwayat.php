<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">

    <div class="container-fluid">

        <?php if (session()->getFlashdata('msg')): ?>

            <div class="alert alert-success">

                <?= session()->getFlashdata('msg'); ?>

            </div>

        <?php endif; ?>

        <div class="card">



            <div class="card-header card-header-danger">

                <div class="row">

                    <div class="col-md-6">

                        <h4 class="card-title">

                            <b>Kasir Penjualan Barang</b>

                        </h4>

                        <p class="card-category">

                            Pilih kategori barang

                        </p>

                    </div>

                    <div class="col-md-6 text-right">

                        <a href="<?= base_url('admin/kasir/riwayat') ?>"
                            class="btn btn-success">

                            <i class="material-icons">

                                history

                            </i>

                            Riwayat Penjualan

                        </a>

                    </div>

                </div>

            </div>

            <h4 class="card-title">

                <b>Riwayat Penjualan</b>

            </h4>

            <p class="card-category">

                Semua transaksi penjualan barang

            </p>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="text-danger">

                        <tr>

                            <th>No</th>

                            <th>Kode</th>

                            <th>Tanggal</th>

                            <th>Kasir</th>

                            <th>Jumlah Barang</th>

                            <th>Metode</th>

                            <th>Cash</th>

                            <th>QRIS</th>

                            <th>Total</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php $no = 1; ?>

                        <?php foreach ($penjualan as $row): ?>

                            <tr>

                                <td><?= $no++ ?></td>

                                <td>

                                    <b><?= $row['kode_penjualan'] ?></b>

                                </td>

                                <td>

                                    <?= date('d-m-Y H:i', strtotime($row['tanggal'])) ?>

                                </td>

                                <td>

                                    <?= $row['kasir'] ?>

                                </td>

                                <td align="center">

                                    <?= $row['total_barang'] ?>

                                </td>

                                <td>

                                    <?= $row['metode_bayar'] ?>

                                </td>

                                <td align="right">

                                    Rp <?= number_format($row['bayar_cash'], 0, ',', '.') ?>

                                </td>

                                <td align="right">

                                    Rp <?= number_format($row['bayar_qris'], 0, ',', '.') ?>

                                </td>

                                <td align="right">

                                    <b>

                                        Rp <?= number_format($row['total'], 0, ',', '.') ?>

                                    </b>

                                </td>

                                <td width="120">

                                    <a

                                        href="<?= base_url('admin/kasir/detail/' . $row['id_penjualan']) ?>"

                                        class="btn btn-info btn-sm btn-block">

                                        Detail

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</div>

<?= $this->endSection() ?>