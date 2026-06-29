<?php

/** @var array $barang */

$barang ??= [];

?>
<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">

    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-8 mx-auto">

                <div class="card">

                    <div class="card-header card-header-warning">

                        <h4 class="card-title">

                            <b>Edit Barang</b>

                        </h4>

                    </div>

                    <div class="card-body">

                        <form action="<?= base_url('admin/barang/update') ?>" method="post">

                            <?= csrf_field() ?>

                            <input
                                type="hidden"
                                name="id_barang"
                                value="<?= $barang['id_barang'] ?>">

                            <div class="form-group">

                                <label>Nama Barang</label>

                                <input
                                    type="text"
                                    name="nama_barang"
                                    class="form-control"
                                    value="<?= $barang['nama_barang'] ?>"
                                    required>

                            </div>

                            <div class="form-group">

                                <label>Kategori</label>

                                <select
                                    name="kategori"
                                    class="form-control">

                                    <option value="Minuman"
                                        <?= $barang['kategori'] == 'Minuman' ? 'selected' : '' ?>>

                                        Minuman

                                    </option>

                                    <option value="Makanan"
                                        <?= $barang['kategori'] == 'Makanan' ? 'selected' : '' ?>>

                                        Makanan

                                    </option>

                                    <option value="Susu Suplemen"
                                        <?= $barang['kategori'] == 'Susu Suplemen' ? 'selected' : '' ?>>

                                        Susu Suplemen

                                    </option>

                                    <option value="Barang Lainnya"
                                        <?= $barang['kategori'] == 'Barang Lainnya' ? 'selected' : '' ?>>

                                        Barang Lainnya

                                    </option>

                                </select>

                            </div>

                            <div class="form-group">

                                <label>Harga Beli</label>

                                <input
                                    type="number"
                                    name="harga_beli"
                                    class="form-control"
                                    value="<?= $barang['harga_beli'] ?>"
                                    required>

                            </div>

                            <div class="form-group">

                                <label>Harga Jual</label>

                                <input
                                    type="number"
                                    name="harga_jual"
                                    class="form-control"
                                    value="<?= $barang['harga_jual'] ?>"
                                    required>

                            </div>

                            <div class="form-group">

                                <label>Stok</label>

                                <input
                                    type="number"
                                    name="stok"
                                    class="form-control"
                                    value="<?= $barang['stok'] ?>"
                                    required>

                            </div>

                            <button
                                class="btn btn-warning btn-block">

                                Update Barang

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