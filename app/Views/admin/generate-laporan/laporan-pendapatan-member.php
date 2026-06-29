<?php

/** @var object $generalSettings */
/** @var string $awal */
/** @var string $akhir */
/** @var array $rekap */

/** @var int $totalMember */
/** @var int|float $totalCash */
/** @var int|float $totalQris */
/** @var int|float $totalPendapatan */

/** @var int|float $barangCash */
/** @var int|float $barangQris */
/** @var int|float $totalPenjualanBarang */

$rekap ??= [];

$totalMember ??= 0;
$totalCash ??= 0;
$totalQris ??= 0;
$totalPendapatan ??= 0;

$barangCash ??= 0;
$barangQris ??= 0;
$totalPenjualanBarang ??= 0;

?>
<?= $this->extend('templates/laporan') ?>

<?= $this->section('content') ?>

<?php $this->extend('templates/laporan') ?>

<?php $this->section('content') ?>

<table width="100%">
    <tr>
        <td width="120">
            <img src="<?= getLogo(); ?>" width="100">
        </td>

        ```
        <td align="center">
            <h2 style="margin:0">
                LAPORAN PENDAPATAN MEMBER
            </h2>

            <h3 style="margin:0">
                <?= $generalSettings->school_name ?>
            </h3>

            <p style="margin:0">
                Periode :
                <?= date('d-m-Y', strtotime($awal)); ?>
                s/d
                <?= date('d-m-Y', strtotime($akhir)); ?>
            </p>
        </td>
    </tr>
    ```

</table>

<hr>

<h3>Ringkasan Pendapatan</h3>

<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <tr style="background:#cfe2f3;font-weight:bold;">
        <th colspan="2">Pendapatan Member</th>
    </tr>

    <tr style="background:#d9ead3;font-weight:bold;">
        <th>No</th>
        <th>Paket</th>
        <th>Jumlah Member</th>
        <th>Cash</th>
        <th>QRIS</th>
        <th>Total Pendapatan</th>
    </tr>

    <?php $no = 1; ?>

    <?php foreach ($rekap as $paket => $row): ?>

        <tr>

            <td align="center">
                <?= $no++ ?>
            </td>

            <td>
                <?= $paket ?>
            </td>

            <td align="center">
                <?= $row['jumlah'] ?>
            </td>

            <td align="right">
                Rp <?= number_format($row['cash'], 0, ',', '.') ?>
            </td>

            <td align="right">
                Rp <?= number_format($row['qris'], 0, ',', '.') ?>
            </td>

            <td align="right">
                Rp <?= number_format($row['nominal'], 0, ',', '.') ?>
            </td>

        </tr>

    <?php endforeach; ?>

</table>

<br>

<table border="1" width="100%" cellspacing="0" cellpadding="5">

    <tr style="background:#f4cccc;font-weight:bold;">

        <td colspan="2" align="LEFT">
            TOTAL
        </td>

        <td align="center">
            <?= $totalMember ?>
        </td>

        <td align="right">
            Rp <?= number_format($totalCash, 0, ',', '.') ?>
        </td>

        <td align="right">
            Rp <?= number_format($totalQris, 0, ',', '.') ?>
        </td>

        <td align="right">
            Rp <?= number_format($totalPendapatan, 0, ',', '.') ?>
        </td>

    </tr>

    <tr>

        <td colspan="2" align="LEFT">
            PENJUALAN BARANG
        </td>

        <td align="center">
            -
        </td>

        <td align="right">
            Rp <?= number_format($barangCash ?? 0, 0, ',', '.') ?>
        </td>

        <td align="right">
            Rp <?= number_format($barangQris ?? 0, 0, ',', '.') ?>
        </td>

        <td align="right">
            Rp <?= number_format($totalPenjualanBarang ?? 0, 0, ',', '.') ?>
        </td>

    </tr>

    <tr style="background:#d9ead3;font-weight:bold;">

        <td colspan="2" align="LEFT">
            GRAND TOTAL
        </td>

        <td align="center">
            <?= $totalMember ?>
        </td>

        <td align="right">
            Rp <?= number_format(
                    $totalCash + ($barangCash ?? 0),
                    0,
                    ',',
                    '.'
                ) ?>
        </td>

        <td align="right">
            Rp <?= number_format(
                    $totalQris + ($barangQris ?? 0),
                    0,
                    ',',
                    '.'
                ) ?>
        </td>

        <td align="right">
            Rp <?= number_format(
                    $totalPendapatan + ($totalPenjualanBarang ?? 0),
                    0,
                    ',',
                    '.'
                ) ?>
        </td>

    </tr>

</table>

<br><br><br>

<table width="100%">
    <tr>

        ```
        <td width="60%"></td>

        <td align="center">

            <?= date('d-m-Y') ?>

            <br><br>

            Mengetahui,

            <br><br><br><br><br>

            _____________________

        </td>

    </tr>
    ```

</table>

<?php $this->endSection() ?>


</table>

<?= $this->endSection() ?>