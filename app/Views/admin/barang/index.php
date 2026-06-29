<?php

/** @var array $barang */

$barang ??= [];

?>
<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content') ?>

<div class="content">

    <div class="container-fluid">

        <div class="card">

            <div class="card-header card-header-danger">

                <div class="row">

                    <div class="col">

                        <h4 class="card-title">

                            <b>Master Barang</b>

                        </h4>

                        <p class="card-category">

                            Daftar Barang Gym

                        </p>

                    </div>

                    <div class="col text-right">

                        <a href="<?= base_url('admin/barang/create') ?>"

                            class="btn btn-success">

                            <i class="material-icons">

                                add

                            </i>

                            Tambah Barang

                        </a>

                    </div>

                </div>

            </div>

            <div class="card-body">

                <?php if (session()->getFlashdata('msg')): ?>

                    <div class="alert alert-success">

                        <?= session()->getFlashdata('msg') ?>

                    </div>

                <?php endif ?>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="text-danger">

                            <tr>

                                <th>No</th>

                                <th>Nama Barang</th>

                                <th>Kategori</th>

                                <th>Harga Beli</th>

                                <th>Harga Jual</th>

                                <th>Stok</th>

                                <th width="170">

                                    Aksi

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $no = 1;

                            foreach ($barang as $b):

                            ?>

                                <tr>

                                    <td><?= $no++ ?></td>

                                    <td>

                                        <b>

                                            <?= $b['nama_barang'] ?>

                                        </b>

                                    </td>

                                    <td>

                                        <span class="badge badge-info">

                                            <?= $b['kategori'] ?>

                                        </span>

                                    </td>

                                    <td>

                                        Rp <?= number_format($b['harga_beli'], 0, ',', '.') ?>

                                    </td>

                                    <td>

                                        Rp <?= number_format($b['harga_jual'], 0, ',', '.') ?>

                                    </td>

                                    <td>

                                        <span class="badge badge-success">

                                            <?= $b['stok'] ?>

                                        </span>

                                    </td>

                                    <td>

                                        <a

                                            href="<?= base_url('admin/barang/edit/' . $b['id_barang']) ?>"

                                            class="btn btn-warning btn-sm">

                                            Edit

                                        </a>

                                        <a

                                            href="<?= base_url('admin/barang/delete/' . $b['id_barang']) ?>"

                                            onclick="return confirm('Hapus barang ini?')"

                                            class="btn btn-danger btn-sm">

                                            Hapus

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>