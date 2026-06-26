<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">
    <div class="container-fluid">

        <div class="card">

            <div class="card-header card-header-danger">

                <h4 class="card-title">
                    <b>Keranjang Belanja</b>
                </h4>

            </div>

            <div class="card-body">

                <form action="<?= base_url('admin/kasir/checkout') ?>" method="post">

                    <?= csrf_field(); ?>

                    <table class="table table-bordered table-hover">

                        <thead class="text-danger">

                            <tr>

                                <th>No</th>

                                <th>Barang</th>

                                <th>Harga</th>

                                <th width="180">Qty</th>

                                <th>Subtotal</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $no = 1;

                            $grandTotal = 0;

                            ?>

                            <?php foreach ($cart as $item): ?>

                                <?php
                                $grandTotal += $item['subtotal'];
                                ?>

                                <tr>

                                    <td><?= $no++ ?></td>

                                    <td><?= $item['nama_barang'] ?></td>

                                    <td>

                                        Rp <?= number_format($item['harga'], 0, ',', '.') ?>

                                    </td>

                                    <td>
                                        <?= $item['qty'] ?>
                                    </td>

                                    <td>

                                        Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>

                                    </td>



                                    <td>

                                        <a href="<?= base_url('admin/kasir/kurang/' . $item['id_barang']) ?>"
                                            class="btn btn-warning btn-sm">

                                            <i class="material-icons">remove</i>

                                        </a>

                                        <a href="<?= base_url('admin/kasir/tambah/' . $item['id_barang']) ?>"
                                            class="btn btn-success btn-sm">

                                            <i class="material-icons">add</i>

                                        </a>

                                    </td>

                                    <td>

                                        <a href="<?= base_url('admin/kasir/hapus/' . $item['id_barang']) ?>"
                                            class="btn btn-danger btn-sm">

                                            <i class="material-icons">delete</i>

                                        </a>

                                    </td>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                    <hr>

                    <div class="row">

                        <div class="col-md-6">

                            <h4>

                                Total Belanja

                            </h4>

                        </div>

                        <div class="col-md-6 text-right">

                            <h3 class="text-danger">

                                Rp <?= number_format($grandTotal, 0, ',', '.') ?>

                            </h3>

                        </div>

                    </div>

                    <hr>

                    <div class="form-group">

                        <label>

                            Metode Pembayaran

                        </label>

                        <div>

                            <label class="mr-4">

                                <input
                                    type="checkbox"
                                    id="cash">

                                Cash

                            </label>

                            <label>

                                <input
                                    type="checkbox"
                                    id="qris">

                                QRIS

                            </label>

                        </div>

                        <input
                            type="hidden"
                            name="metode_bayar"
                            id="metode_bayar">

                    </div>

                    <div id="gabunganArea" style="display:none;">

                        <div class="row">

                            <div class="col-md-6">

                                <label>Bayar Cash</label>

                                <input

                                    type="number"

                                    class="form-control"

                                    name="bayar_cash"

                                    value="0">

                            </div>

                            <div class="col-md-6">

                                <label>Bayar QRIS</label>

                                <input

                                    type="number"

                                    class="form-control"

                                    name="bayar_qris"

                                    value="0">

                            </div>

                        </div>

                    </div>

                    <br>

                    <button class="btn btn-success btn-lg">

                        BAYAR

                    </button>

                    <a href="<?= base_url('admin/kasir/batal') ?>"
                        class="btn btn-danger btn-lg">
                        Batal
                    </a>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
    const cash = document.getElementById('cash');

    const qris = document.getElementById('qris');

    const metode = document.getElementById('metode_bayar');

    const gabungan = document.getElementById('gabunganArea');

    function updateBayar() {

        if (cash.checked && qris.checked) {

            metode.value = 'Gabungan';

            gabungan.style.display = 'block';

        } else if (cash.checked) {

            metode.value = 'Cash';

            gabungan.style.display = 'none';

        } else if (qris.checked) {

            metode.value = 'QRIS';

            gabungan.style.display = 'none';

        } else {

            metode.value = '';

            gabungan.style.display = 'none';

        }

    }

    cash.onchange = updateBayar;

    qris.onchange = updateBayar;

    function reloadKeranjang() {

        location.reload();

    }

    $(document).on('click', '.tambah', function() {

        let id = $(this).data('id');

        $.post(

            "<?= base_url('admin/kasir/updateQty') ?>",

            {

                id_barang: id,

                aksi: 'plus'

            },

            function(res) {

                if (res.status) {

                    reloadKeranjang();

                }

            }

        );

    });

    $(document).on('click', '.kurang', function() {

        let id = $(this).data('id');

        $.post(

            "<?= base_url('admin/kasir/updateQty') ?>",

            {

                id_barang: id,

                aksi: 'minus'

            },

            function(res) {

                if (res.status) {

                    reloadKeranjang();

                }

            }

        );

    });

    $(document).on('click', '.hapus', function() {

        if (!confirm("Hapus barang ini?")) {

            return;

        }

        let id = $(this).data('id');

        $.post(

            "<?= base_url('admin/kasir/hapusKeranjang') ?>",

            {

                id_barang: id

            },

            function(res) {

                if (res.status) {

                    reloadKeranjang();

                }

            }

        );

    });
</script>

<?= $this->endSection() ?>