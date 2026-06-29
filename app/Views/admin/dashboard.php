<?php

/** @var array $member */
/** @var array $petugas */
/** @var array $kelas */
/** @var array $jurusan */
/** @var array $jumlahKehadiranmember */
/** @var array $grafikKehadiranmember */
/** @var array $dateRange */
/** @var string $dateNow */
/** @var object $generalSettings */

$member ??= [];
$petugas ??= [];
$kelas ??= [];
$jurusan ??= [];
$jumlahKehadiranmember ??= [
    'hadir' => 0,
    'izin' => 0,
    'sakit' => 0,
    'alfa' => 0
];

$grafikKehadiranmember ??= [
    'hadir' => [],
    'izin' => [],
    'sakit' => [],
    'alfa' => []
];

$dateRange ??= [];
$dateNow ??= date('d-m-Y');
?>
<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('styles') ?>
<style>
    .chart-container {
        position: relative;
        width: 100%;
        min-height: 250px;
    }

    @media (max-width:1199px) {

        .card-title {
            font-size: 1rem !important;
        }

        .card-category {
            font-size: 0.8rem !important;
        }

        .card-footer .stats {
            font-size: 0.75rem !important;
        }

        .custom-select {
            width: 100% !important;
            margin-top: 10px;
        }

        .chart-container {
            min-height: 450px;
        }

        #filterKelas {
            min-width: 220px;
        }

        canvas {
            max-width: 100% !important;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-radius: 18px;
        }

        .card-header-success {
            background: linear-gradient(135deg,
                    #28a745,
                    #20c997) !important;
        }

        .card-header-info {
            background: linear-gradient(135deg,
                    #17a2b8,
                    #007bff) !important;
        }

        .card-header-danger {
            background: linear-gradient(135deg,
                    #dc3545,
                    #ff6b6b) !important;
        }

        .card-body h1 {
            font-size: 3rem;
        }

        .card-body h2 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .card-body i {
            opacity: .95;
        }

        .card.shadow {
            border-radius: 18px;
            border: none;
            transition: .3s;
        }

        .card.shadow:hover {
            transform: translateY(-5px);
        }

        .card.shadow h1 {
            font-size: 3rem;
            margin-top: 10px;
            font-weight: 700;
        }

        .card.shadow h5 {
            margin-top: 10px;
            font-weight: 600;
        }

        @media(max-width:768px) {

            .card-body h1 {
                font-size: 2rem;
            }

            .card-body h2 {
                font-size: 1.8rem;
            }

        }
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<?php
$memberAktif = 0;
$memberExpired = 0;

foreach ($member as $m) {
    if (strtotime($m['tanggal_expired']) >= strtotime(date('Y-m-d'))) {
        $memberAktif++;
    } else {
        $memberExpired++;
    }
}
?>
<div class="content">
    <div class="container-fluid">

        <div class="card mb-4 border-0"
            style="
            background: linear-gradient(
                135deg,
                rgba(40,167,69,.9),
                rgba(32,201,151,.9)
            ),
            url('<?= base_url("assets/img/RajaGym.jpeg") ?>');
            background-size: cover;
            background-position: center;
            color: white;
         ">

            <div class="card-body py-5">

                <h2 class="font-weight-bold">
                    Selamat Datang di Raja Gym
                </h2>

                <p class="mb-0">
                    Dashboard Monitoring Member dan Absensi
                </p>

                <small>
                    <?= date('d F Y'); ?>
                </small>

            </div>

        </div>
        <!-- REKAP JUMLAH DATA -->
        <div class="row justify-content-center">

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center">

                        <div class="mb-3">
                            <i class="material-icons text-primary"
                                style="font-size:70px;">
                                groups
                            </i>
                        </div>

                        <h5 class="text-muted">
                            Total Member
                        </h5>

                        <h1 class="font-weight-bold text-primary">
                            <?= count($member); ?>
                        </h1>

                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center">

                        <div class="mb-3">
                            <i class="material-icons text-success"
                                style="font-size:70px;">
                                badge
                            </i>
                        </div>

                        <h5 class="text-muted">
                            Total Petugas
                        </h5>

                        <h1 class="font-weight-bold text-success">
                            <?= count($petugas); ?>
                        </h1>

                    </div>
                </div>
            </div>

        </div>
        <div class="row d-sm-none">
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header card-header-success">
                        <a href="<?= base_url('admin/member'); ?>" class="text-white">
                            <div class="d-flex justify-content-end">
                                <div class="text-right">
                                    <p class="card-category">Jumlah member</p>
                                    <h3 class="card-title text-nowrap">
                                        <i class="material-icons">person_4</i>
                                        <?= count($member); ?>
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-success">check</i>
                            Terdaftar
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">home</i>
                            <?= esc($generalSettings->school_name ?? '-') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header card-header-danger">
                        <a href="<?= base_url('admin/petugas'); ?>" class="text-white">
                            <div class="d-flex justify-content-end">
                                <div class="text-right">
                                    <p class="card-category">Jumlah petugas</p>
                                    <h3 class="card-title">
                                        <i class="material-icons">settings</i>

                                        <?= count($petugas); ?>
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">person</i>
                            Admin
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center" style="margin-bottom: 50px;">

            <!-- STATS member HARI INI -->



            <!-- ABSEN HARI INI -->
            <div class="col-lg-4 col-md-4 col-12 mb-3">
                <div class="card bg-success text-white h-100 shadow">
                    <div class="card-body text-center">
                        <i class="material-icons mb-2" style="font-size:60px;">
                            fact_check
                        </i>

                        <h5 class="font-weight-bold">
                            Absen Hari Ini
                        </h5>

                        <h1 class="font-weight-bold">
                            <?= $jumlahKehadiranmember['hadir']; ?>
                        </h1>
                    </div>
                </div>
            </div>

            <!-- MEMBER AKTIF -->
            <div class="col-lg-4 col-md-4 col-12 mb-3">
                <div class="card bg-primary text-white h-100 shadow">
                    <div class="card-body text-center">
                        <i class="material-icons mb-2" style="font-size:60px;">
                            groups
                        </i>

                        <h5 class="font-weight-bold">
                            Member Aktif
                        </h5>

                        <h1 class="font-weight-bold">
                            <?= $memberAktif ?? 0; ?>
                        </h1>
                    </div>
                </div>
            </div>

            <!-- MEMBER EXPIRED -->
            <div class="col-lg-4 col-md-4 col-12 mb-3">
                <div class="card bg-danger text-white h-100 shadow">
                    <div class="card-body text-center">
                        <i class="material-icons mb-2" style="font-size:60px;">
                            event_busy
                        </i>

                        <h5 class="font-weight-bold">
                            Member Expired
                        </h5>

                        <h1 class="font-weight-bold">
                            <?= $memberExpired ?? 0; ?>
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- CHART member -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-success">
                        <div class="alert alert-success">
                            <h4 class="mb-1">
                                Total Member: <?= count($member); ?>
                            </h4>

                            <small>
                                Monitoring kehadiran member 7 hari terakhir
                            </small>
                        </div>
                        <h4 class="card-title">Tingkat Kehadiran member</h4>
                        <p class="card-category">Statistik kehadiran 7 hari terakhir | <?= $dateNow; ?></p>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="kehadiranmember"></canvas>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-success">checklist</i> <a class="text-success" href="<?= base_url('admin/absen-member'); ?>">Lihat data</a>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-3 col-6">
                        <a href="<?= base_url('scan/masuk'); ?>" class="btn btn-success btn-block">
                            <i class="material-icons">qr_code_scanner</i><br>
                            Scan QR
                        </a>
                    </div>

                    <div class="col-md-3 col-6">
                        <a href="<?= base_url('admin/member'); ?>" class="btn btn-primary btn-block">
                            <i class="material-icons">groups</i><br>
                            Member
                        </a>
                    </div>

                    <div class="col-md-3 col-6">
                        <a href="<?= base_url('admin/absen-member'); ?>" class="btn btn-warning btn-block">
                            <i class="material-icons">fact_check</i><br>
                            Absensi
                        </a>
                    </div>

                    <div class="col-md-3 col-6">
                        <a href="<?= base_url('admin/generate'); ?>" class="btn btn-info btn-block">
                            <i class="material-icons">qr_code</i><br>
                            Generate QR
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Chart.js CDN -->
<script src="<?= base_url('assets/js/plugins/chartjs/chart.umd.min.js') ?>"></script>
<script>
    let kehadiranmemberChart;

    const chartLabels = <?= json_encode($dateRange) ?>;

    const chartColors = {
        hadir: {
            border: '#4caf50',
            bg: 'rgba(76, 175, 80, 1)'
        },
        sakit: {
            border: '#ff9800',
            bg: 'rgba(255, 152, 0, 1)'
        },
        izin: {
            border: '#00bcd4',
            bg: 'rgba(0, 188, 212, 1)'
        },
        alfa: {
            border: '#f44336',
            bg: 'rgba(244, 67, 54, 1)'
        }
    };

    function createChartConfig(data) {
        return {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                        label: 'Hadir',
                        data: data.hadir,
                        borderColor: chartColors.hadir.border,
                        backgroundColor: chartColors.hadir.bg,
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Sakit',
                        data: data.sakit,
                        borderColor: chartColors.sakit.border,
                        backgroundColor: chartColors.sakit.bg,
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Izin',
                        data: data.izin,
                        borderColor: chartColors.izin.border,
                        backgroundColor: chartColors.izin.bg,
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Alfa',
                        data: data.alfa,
                        borderColor: chartColors.alfa.border,
                        backgroundColor: chartColors.alfa.bg,
                        tension: 0.3,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' orang';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        stacked: false,
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                if (Number.isInteger(value)) return value;
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        stacked: false,
                        grid: {
                            display: false
                        }
                    }
                }
            }
        };
    }

    function initDashboardPageCharts() {

        const memberCtx = document.getElementById('kehadiranmember');
        if (memberCtx) {
            const datamember = {
                hadir: <?= json_encode($grafikKehadiranmember['hadir']) ?>,
                sakit: <?= json_encode($grafikKehadiranmember['sakit']) ?>,
                izin: <?= json_encode($grafikKehadiranmember['izin']) ?>,
                alfa: <?= json_encode($grafikKehadiranmember['alfa']) ?>
            };
            kehadiranmemberChart = new Chart(memberCtx, createChartConfig(datamember));
        }
    }

    $(document).ready(function() {
        initDashboardPageCharts();

        $('#filterKelas').on('change', function() {
            const idKelas = $(this).val();
            const loader = $('#filterLoader');

            loader.show();

            $.ajax({
                url: '<?= base_url('admin/dashboard/filter-data') ?>',
                type: 'POST',
                data: setAjaxData({
                    id_kelas: idKelas
                }),
                success: function(response) {
                    const obj = JSON.parse(response);
                    if (obj.result == 1) {
                        $('#siswaStatsContainer').html(obj.htmlContent);
                        updateSiswaChart(obj.chartData);

                        // Update Titles
                        // const className = $('#filterKelas option:selected').attr('data-kelas');
                        // if (idKelas == "") {
                        //     $('#titleSiswaStats').text("Absensi Siswa Hari Ini");
                        //     $('#titleSiswaChart').text("Tingkat Kehadiran Siswa");
                        // } else {
                        //     $('#titleSiswaStats').text("Absensi Siswa " + className + " Hari Ini");
                        //     $('#titleSiswaChart').text("Tingkat Kehadiran Siswa " + className);
                        // }
                    }
                },
                error: function(xhr, status, thrown) {
                    console.error(thrown);
                },
                complete: function() {
                    loader.hide();
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>