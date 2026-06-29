<?php

/** @var array $penjualan */
/** @var array $detail */

$penjualan ??= [];
$detail ??= [];

?>
<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">

    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-10 mx-auto">

                <div class="card">

                    <div class="card-header card-header-info">

                        <h4 class="card-title">
                            <b>Detail Penjualan</b>
                        </h4>

                        <p class="card-category">
                            <?= $penjualan['kode_penjualan'] ?>
                        </p>

                    </div>

                    <div class="card-body">

                        <div class="row mb-4">

                            <div class="col-md-6">

                                <table class="table table-borderless">

                                    <tr>

                                        <td width="170">
                                            <b>Kode Penjualan</b>
                                        </td>

                                        <td>
                                            <?= $penjualan['kode_penjualan'] ?>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            <b>Tanggal</b>
                                        </td>

                                        <td>
                                            <?= date('d-m-Y H:i', strtotime($penjualan['tanggal'])) ?>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            <b>Kasir</b>
                                        </td>

                                        <td>
                                            <?= $penjualan['kasir'] ?>
                                        </td>

                                    </tr>

                                </table>

                            </div>

                            <div class="col-md-6">

                                <table class="table table-borderless">

                                    <tr>

                                        <td width="170">
                                            <b>Metode</b>
                                        </td>

                                        <td>
                                            <?= $penjualan['metode_bayar'] ?>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            <b>Cash</b>
                                        </td>

                                        <td>

                                            Rp <?= number_format($penjualan['bayar_cash'], 0, ',', '.') ?>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            <b>QRIS</b>
                                        </td>

                                        <td>

                                            Rp <?= number_format($penjualan['bayar_qris'], 0, ',', '.') ?>

                                        </td>

                                    </tr>

                                </table>

                            </div>

                        </div>

                        <hr>

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped">

                                <thead class="text-info">

                                    <tr>

                                        <th>No</th>

                                        <th>Barang</th>

                                        <th>Harga</th>

                                        <th>Qty</th>

                                        <th>Subtotal</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    $no = 1;

                                    $grand = 0;

                                    ?>

                                    <?php foreach ($detail as $row): ?>

                                        <?php $grand += $row['subtotal']; ?>

                                        <tr>

                                            <td><?= $no++ ?></td>

                                            <td>

                                                <?= $row['nama_barang'] ?>

                                            </td>

                                            <td align="right">

                                                Rp <?= number_format($row['harga'], 0, ',', '.') ?>

                                            </td>

                                            <td align="center">

                                                <?= $row['qty'] ?>

                                            </td>

                                            <td align="right">

                                                Rp <?= number_format($row['subtotal'], 0, ',', '.') ?>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                                <tfoot>

                                    <tr>

                                        <th colspan="4">

                                            GRAND TOTAL

                                        </th>

                                        <th style="text-align:right">

                                            Rp <?= number_format($grand, 0, ',', '.') ?>

                                        </th>

                                    </tr>

                                </tfoot>

                            </table>

                        </div>

                        <div class="text-right mt-4">

                            <a
                                href="<?= base_url('admin/kasir/riwayat') ?>"
                                class="btn btn-secondary">

                                Kembali

                            </a>

                            <a
                                target="_blank"
                                href="<?= base_url('admin/kasir/thermal/' . $penjualan['id_penjualan']) ?>"
                                class="btn btn-success">

                                <i class="material-icons">print</i>

                                Cetak Thermal

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>