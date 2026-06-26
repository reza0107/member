<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">

    <div class="container-fluid">

        <div class="row">

            <!-- KATEGORI -->

            <div class="col-md-12">

                <div class="card">
                    <div class="row mb-3">

                        <div class="col-md-12">

                            <input
                                type="text"
                                id="searchBarang"
                                class="form-control"
                                placeholder="🔍 Cari barang...">

                        </div>
                        <br class="my-2">
                        <br class="my-2">

                    </div>

                    <div class="card-header card-header-danger">

                        <h4 class="card-title">

                            <b>Kasir Penjualan Barang</b>

                        </h4>

                        <p class="card-category">

                            Pilih kategori barang

                        </p>

                    </div>

                    <div class="card-body">

                        <div class="row text-center">

                            <div class="col-md-3 kategori-item">

                                <button
                                    class="btn btn-info btn-block kategori"
                                    data-kategori="Minuman">

                                    🥤<br>
                                    Minuman

                                </button>

                            </div>

                            <div class="col-md-3 kategori-item">

                                <button
                                    class="btn btn-success btn-block kategori"
                                    data-kategori="Makanan">

                                    🍜<br>
                                    Makanan

                                </button>

                            </div>

                            <div class="col-md-3 kategori-item">

                                <button
                                    class="btn btn-warning btn-block kategori"
                                    data-kategori="Susu Suplemen">

                                    💪<br>
                                    Susu Suplemen

                                </button>

                            </div>

                            <div class="col-md-3 kategori-item">

                                <button
                                    class="btn btn-secondary btn-block kategori"
                                    data-kategori="Barang Lainnya">

                                    📦<br>
                                    Barang Lainnya

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- LIST BARANG -->

            <div class="col-md-12">

                <div class="row" id="listBarang">

                </div>

            </div>

        </div>

    </div>

</div>

<!-- FLOATING BUTTON -->

<div
    style="
        position:fixed;
        bottom:20px;
        right:20px;
        z-index:9999;
        display:flex;
        gap:10px;
    ">

    <!-- Riwayat -->

    <a
        href="<?= base_url('admin/kasir/riwayat') ?>"
        class="btn btn-info btn-lg">

        <i class="material-icons">history</i>

        Riwayat

    </a>

    <!-- Keranjang -->

    <a
        href="<?= base_url('admin/kasir/keranjang') ?>"
        class="btn btn-danger btn-lg">

        <i class="material-icons">shopping_cart</i>

        Keranjang

        <?php

        $totalQty = 0;

        $cart = session()->get('cart') ?? [];

        foreach ($cart as $item) {
            $totalQty += $item['qty'];
        }

        ?>

        <span
            class="badge badge-light"
            id="jumlahKeranjang">

            <?= $totalQty ?>

        </span>

    </a>

</div>

<script src="<?= base_url('assets/js/core/jquery-3.5.1.min.js') ?>"></script>

<script>
    $(function() {

        $('.kategori').click(function() {

            let kategori = $(this).data('kategori');

            $.get(

                "<?= base_url('admin/kasir/kategori/') ?>" + kategori,

                function(data) {

                    let html = '';

                    $.each(data, function(i, row) {

                        html += `
                        <div class="col-md-3 barang-item"
                        data-nama="${row.nama_barang.toLowerCase()}"
                        data-kategori="${row.kategori.toLowerCase()}">
                        
                        <div class="card">

        <div class="card-body text-center">

            <h4>${row.nama_barang}</h4>

            <hr>

            <h5>
                Rp ${Number(row.harga_jual).toLocaleString('id-ID')}
            </h5>

            <p>Stok : ${row.stok}</p>

            <button
                class="btn btn-success tambah"
                data-id="${row.id_barang}">
                +
            </button>

        </div>

    </div>

</div>

`;

                    });

                    $('#listBarang').html(html);

                }

            );

        });

    });

    $(document).on('click', '.tambah', function() {

        let id = $(this).data('id');

        $.post(

            "<?= base_url('admin/kasir/tambahKeranjang') ?>",

            {

                id_barang: id

            },

            function(res) {

                if (res.status) {

                    $('#jumlahKeranjang').html(res.jumlah);

                }

                alert(res.msg);

            }

        );

    });
    $('#searchBarang').keyup(function() {

        let keyword = $(this).val();

        if (keyword.length == 0) {

            $('#listBarang').html('');

            return;

        }

        $.get(

            "<?= base_url('admin/kasir/cari') ?>",

            {
                keyword: keyword
            },

            function(data) {

                let html = '';

                $.each(data, function(i, row) {

                    html += `

                <div class="col-md-3">

                    <div class="card">

                        <div class="card-body text-center">

                            <h5>${row.nama_barang}</h5>

                            <small>

                                ${row.kategori}

                            </small>

                            <hr>

                            <h5>

                                Rp ${Number(row.harga_jual).toLocaleString('id-ID')}

                            </h5>

                            <p>

                                Stok : ${row.stok}

                            </p>

                            <button

                                class="btn btn-success tambah"

                                data-id="${row.id_barang}">

                                +

                            </button>

                        </div>

                    </div>

                </div>

                `;

                });

                $('#listBarang').html(html);

            }

        );

    });
</script>

<?= $this->endSection() ?>