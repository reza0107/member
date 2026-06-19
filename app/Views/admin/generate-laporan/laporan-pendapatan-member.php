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

    ```
    <tr style="background:#d9ead3;font-weight:bold;">
        <th>No</th>
        <th>Paket</th>
        <th>Jumlah Member</th>
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
                Rp <?= number_format($row['nominal'], 0, ',', '.') ?>
            </td>

        </tr>

    <?php endforeach; ?>

    <tr style="font-weight:bold;background:#f4cccc;">

        <td colspan="2" align="center">
            GRAND TOTAL
        </td>

        <td align="center">
            <?= $totalMember ?>
        </td>

        <td align="right">
            Rp <?= number_format($totalPendapatan, 0, ',', '.') ?>
        </td>

    </tr>
    ```

</table>

<br>

<h3>Detail Member Yang Hadir</h3>

<table border="1" width="100%" cellspacing="0" cellpadding="5">

    ```
    <tr style="background:#cfe2f3;font-weight:bold;">
        <th>No</th>
        <th>Nama Member</th>
        <th>Paket</th>
        <th>Tanggal Daftar</th>
        <th>Tanggal Expired</th>
        <th>Nominal</th>
    </tr>

    <?php $no = 1; ?>

    <?php foreach ($detailMember as $member): ?>

        <tr>

            <td align="center">
                <?= $no++ ?>
            </td>

            <td>
                <?= $member['nama_member'] ?>
            </td>

            <td align="center">
                <?= $member['paket'] ?>
            </td>

            <td align="center">
                <?= $member['tanggal_daftar'] ?>
            </td>

            <td align="center">
                <?= $member['tanggal_expired'] ?>
            </td>

            <td align="right">
                Rp <?= number_format($member['nominal'], 0, ',', '.') ?>
            </td>

        </tr>

    <?php endforeach; ?>
    ```

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