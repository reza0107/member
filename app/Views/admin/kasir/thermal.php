<?php

/** @var array $penjualan */
/** @var array $detail */

$penjualan ??= [];
$detail ??= [];

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Struk</title>

    <style>
        @page {
            size: 58mm auto;
            margin: 0;
        }

        html,
        body {

            width: 58mm;

            margin: 0;

            padding: 3mm;

            font-family: monospace;

            font-size: 11px;

            overflow: hidden;

        }

        table {

            width: 100%;

            border-collapse: collapse;

        }

        td {

            padding: 2px 0;

        }

        hr {

            border: none;

            border-top: 1px dashed #000;

            margin: 4px 0;

        }

        .center {

            text-align: center;

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
        window.onload = () => {

            setTimeout(() => {

                window.print();

            }, 200);

            window.onafterprint = () => {

                window.location.href =
                    "<?= base_url('admin/kasir'); ?>";

            };

        };
        
    </script>

</body>

</html>