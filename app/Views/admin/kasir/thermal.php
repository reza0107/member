<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Struk</title>

    <style>
        body {

            width: 58mm;

            font-family: monospace;

            font-size: 11px;

        }

        .center {

            text-align: center;

        }

        table {

            width: 100%;

            border-collapse: collapse;

        }

        td {

            font-size: 11px;

        }

        hr {

            border: dashed 1px #000;

        }
    </style>

</head>

<body>

    <div class="center">

        <b>RAJA GYM</b>

        <br>

        Jl. ..............

        <br>

        ====================

    </div>

    Kode :

    <?= $penjualan['kode_penjualan'] ?>

    <br>

    Tanggal :

    <?= date('d/m/Y H:i', strtotime($penjualan['tanggal'])) ?>

    <hr>

    <table>

        <?php foreach ($detail as $d): ?>

            <tr>

                <td colspan="2">

                    <?= $d['nama_barang'] ?>

                </td>

            </tr>

            <tr>

                <td>

                    <?= $d['qty'] ?>

                    x

                    <?= number_format($d['harga']) ?>

                </td>

                <td align="right">

                    <?= number_format($d['subtotal']) ?>

                </td>

            </tr>

        <?php endforeach; ?>

    </table>

    <hr>

    <table>

        <tr>

            <td>Total</td>

            <td align="right">

                Rp <?= number_format($penjualan['total']) ?>

            </td>

        </tr>

        <tr>

            <td>Cash</td>

            <td align="right">

                Rp <?= number_format($penjualan['bayar_cash']) ?>

            </td>

        </tr>

        <tr>

            <td>QRIS</td>

            <td align="right">

                Rp <?= number_format($penjualan['bayar_qris']) ?>

            </td>

        </tr>

        <tr>

            <td>Metode</td>

            <td align="right">

                <?= $penjualan['metode_bayar'] ?>

            </td>

        </tr>

    </table>

    <hr>

    <div class="center">

        Terima Kasih

        <br>

        Selamat Berlatih

    </div>

    <script>
        window.onload = function() {

            window.print();

            setTimeout(function() {

                window.location.href = "<?= base_url('admin/kasir') ?>";

            }, 1000);

        };
    </script>

</body>

</html>