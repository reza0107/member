-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jun 2026 pada 08.51
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_absensi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'admin', NULL, '2026-06-04 13:41:28', 0),
(2, '::1', 'superadmin', NULL, '2026-06-04 13:41:50', 0),
(3, '::1', 'adminsuper@gmail.com', 1, '2026-06-04 13:41:59', 1),
(4, '::1', 'adminsuper@gmail.com', 1, '2026-06-05 08:55:39', 1),
(5, '::1', 'adminsuper@gmail.com', 1, '2026-06-05 13:07:26', 1),
(6, '::1', 'adminsuper@gmail.com', 1, '2026-06-05 13:24:16', 1),
(7, '::1', 'adminsuper@gmail.com', 1, '2026-06-05 13:53:13', 1),
(8, '::1', 'adminsuper@gmail.com', 1, '2026-06-05 13:58:28', 1),
(9, '::1', 'adminsuper@gmail.com', 1, '2026-06-05 15:06:28', 1),
(10, '::1', 'adminsuper@gmail.com', 1, '2026-06-11 17:34:48', 1),
(11, '::1', 'adminsuper@gmail.com', 1, '2026-06-12 09:16:03', 1),
(12, '::1', 'adminsuper@gmail.com', 1, '2026-06-12 12:12:22', 1),
(13, '::1', 'adminsuper@gmail.com', 1, '2026-06-18 18:49:07', 1),
(14, '::1', 'adminsuper@gmail.com', 1, '2026-06-19 10:39:50', 1),
(15, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 08:52:06', 1),
(16, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 08:57:27', 1),
(17, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 10:18:05', 1),
(18, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 10:19:47', 1),
(19, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 10:29:57', 1),
(20, '::1', 'SUPERADMIN', NULL, '2026-06-23 10:34:49', 0),
(21, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 10:35:02', 1),
(22, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 11:14:53', 1),
(23, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 11:30:16', 1),
(24, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 11:32:07', 1),
(25, '::1', 'superadmn', NULL, '2026-06-23 11:32:43', 0),
(26, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 11:32:57', 1),
(27, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 11:37:19', 1),
(28, '::1', 'superadmin', NULL, '2026-06-23 11:38:15', 0),
(29, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 11:38:25', 1),
(30, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 11:38:40', 1),
(31, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 11:50:56', 1),
(32, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 12:14:22', 1),
(33, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 12:48:13', 1),
(34, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 12:49:09', 1),
(35, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 12:49:35', 1),
(36, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 13:09:41', 1),
(37, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 13:59:25', 1),
(38, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 14:00:05', 1),
(39, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 14:31:55', 1),
(40, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 14:32:47', 1),
(41, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 14:56:15', 1),
(42, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 15:06:16', 1),
(43, '::1', 'adminsuper@gmail.com', 1, '2026-06-23 15:12:48', 1),
(44, '::1', 'adminsuper@gmail.com', 1, '2026-06-24 11:09:54', 1),
(45, '::1', 'adminsuper@gmail.com', 1, '2026-06-24 14:08:55', 1),
(46, '::1', 'adminsuper@gmail.com', 1, '2026-06-24 16:13:47', 1),
(47, '::1', 'adminsuper@gmail.com', 1, '2026-06-25 11:18:57', 1),
(48, '::1', 'adminsuper@gmail.com', 1, '2026-06-25 18:14:02', 1),
(49, '::1', 'adminsuper@gmail.com', 1, '2026-06-26 16:20:03', 1),
(50, '::1', 'adminsuper@gmail.com', 1, '2026-06-26 16:57:26', 1),
(51, '::1', 'kasir', NULL, '2026-06-26 16:58:48', 0),
(52, '::1', 'kasir', NULL, '2026-06-26 17:01:35', 0),
(53, '::1', 'kasir', NULL, '2026-06-26 17:03:36', 0),
(54, '::1', 'kasir', NULL, '2026-06-26 17:03:41', 0),
(55, '::1', 'adminsuper@gmail.com', 1, '2026-06-26 17:03:51', 1),
(56, '::1', 'kasir', NULL, '2026-06-26 17:05:50', 0),
(57, '::1', 'kasir', NULL, '2026-06-26 17:14:39', 0),
(58, '::1', 'adminsuper@gmail.com', 1, '2026-06-26 17:18:27', 1),
(59, '::1', 'kasirrajagym', NULL, '2026-06-26 17:19:25', 0),
(60, '::1', 'kasirrajagym', NULL, '2026-06-26 17:19:50', 0),
(61, '::1', 'superadmin', NULL, '2026-06-26 17:36:01', 0),
(62, '::1', 'adminsuper@gmail.com', 1, '2026-06-26 17:36:09', 1),
(63, '::1', 'kasir@rajagym.com', 2, '2026-06-26 17:37:33', 1),
(64, '::1', 'kasir@rajagym.com', 2, '2026-06-26 17:41:00', 1),
(65, '::1', 'adminsuper@gmail.com', 1, '2026-06-26 18:08:26', 1),
(66, '::1', 'kasir', NULL, '2026-06-29 09:53:34', 0),
(67, '::1', 'adminsuper@gmail.com', 1, '2026-06-29 09:53:43', 1),
(68, '::1', 'kasir@kasir.com', 3, '2026-06-29 09:57:16', 1),
(69, '::1', 'adminsuper@gmail.com', 1, '2026-06-29 10:23:49', 1),
(70, '::1', 'kasir', NULL, '2026-06-29 13:18:32', 0),
(71, '::1', 'kasir@kasir.com', 3, '2026-06-29 13:18:38', 1),
(72, '::1', 'adminsuper@gmail.com', 1, '2026-06-29 13:19:44', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `logo` varchar(225) DEFAULT NULL,
  `school_name` varchar(225) DEFAULT 'SMK 1 Indonesia',
  `school_year` varchar(225) DEFAULT '2024/2025',
  `copyright` varchar(225) DEFAULT '© 2025 All rights reserved.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `general_settings`
--

INSERT INTO `general_settings` (`id`, `logo`, `school_name`, `school_year`, `copyright`) VALUES
(1, 'uploads/logo/logo_6a21397d68bcf8-27585649.jpeg', 'Raja Gym', '2026', '© 2026 All rights reserved.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1780555204, 1),
(2, '2023-08-18-000001', 'App\\Database\\Migrations\\CreateJurusanTable', 'default', 'App', 1780555204, 1),
(3, '2023-08-18-000002', 'App\\Database\\Migrations\\CreateKelasTable', 'default', 'App', 1780555204, 1),
(4, '2023-08-18-000003', 'App\\Database\\Migrations\\CreateDB', 'default', 'App', 1780555206, 1),
(5, '2023-08-18-000004', 'App\\Database\\Migrations\\AddSuperadmin', 'default', 'App', 1780555206, 1),
(6, '2024-07-24-083011', 'App\\Database\\Migrations\\GeneralSettings', 'default', 'App', 1780555207, 1),
(7, '2025-12-23-000001', 'App\\Database\\Migrations\\AddRfidToSiswaGuru', 'default', 'App', 1780555208, 1),
(8, '2025-12-23-000002', 'App\\Database\\Migrations\\AddWaliKelasToKelas', 'default', 'App', 1780555211, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `kategori` enum('Makanan','Minuman','Susu Suplemen','Lainnya') NOT NULL,
  `harga_beli` bigint(20) NOT NULL,
  `harga_jual` bigint(20) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_barang`
--

INSERT INTO `tb_barang` (`id_barang`, `nama_barang`, `kategori`, `harga_beli`, `harga_jual`, `stok`, `created_at`) VALUES
(1, 'Air Mineral', 'Minuman', 3000, 5000, 43, '2026-06-25 04:29:45'),
(2, 'Teh Botol', 'Minuman', 4500, 7000, 44, '2026-06-25 04:29:45'),
(3, 'Mie Instan', 'Makanan', 2500, 5000, 100, '2026-06-25 04:29:45'),
(4, 'Roti Coklat', 'Makanan', 4000, 7000, 49, '2026-06-25 04:29:45'),
(5, 'Whey Protein', 'Susu Suplemen', 250000, 350000, 16, '2026-06-25 04:29:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_penjualan`
--

CREATE TABLE `tb_detail_penjualan` (
  `id_detail` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(150) DEFAULT NULL,
  `harga` bigint(20) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `subtotal` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jurusan`
--

CREATE TABLE `tb_jurusan` (
  `id` int(11) UNSIGNED NOT NULL,
  `jurusan` varchar(32) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tb_jurusan`
--

INSERT INTO `tb_jurusan` (`id`, `jurusan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'OTKP', NULL, NULL, NULL),
(2, 'BDP', NULL, NULL, NULL),
(3, 'AKL', NULL, NULL, NULL),
(4, 'RPL', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kehadiran`
--

CREATE TABLE `tb_kehadiran` (
  `id_kehadiran` int(11) NOT NULL,
  `kehadiran` enum('Hadir','Sakit','Izin','Tanpa keterangan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tb_kehadiran`
--

INSERT INTO `tb_kehadiran` (`id_kehadiran`, `kehadiran`) VALUES
(1, 'Hadir'),
(2, 'Sakit'),
(3, 'Izin'),
(4, 'Tanpa keterangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` int(11) UNSIGNED NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `id_jurusan` int(11) UNSIGNED NOT NULL,
  `index_kelas` varchar(5) NOT NULL,
  `id_wali_kelas` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `tingkat`, `id_jurusan`, `index_kelas`, `id_wali_kelas`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'X', 1, 'A', NULL, NULL, NULL, NULL),
(2, 'X', 2, 'A', NULL, NULL, NULL, NULL),
(3, 'X', 3, 'A', NULL, NULL, NULL, NULL),
(4, 'X', 4, 'A', NULL, NULL, NULL, NULL),
(5, 'XI', 1, 'A', NULL, NULL, NULL, NULL),
(6, 'XI', 2, 'A', NULL, NULL, NULL, NULL),
(7, 'XI', 3, 'A', NULL, NULL, NULL, NULL),
(8, 'XI', 4, 'A', NULL, NULL, NULL, NULL),
(9, 'XII', 1, 'A', NULL, NULL, NULL, NULL),
(10, 'XII', 2, 'A', NULL, NULL, NULL, NULL),
(11, 'XII', 3, 'A', NULL, NULL, NULL, NULL),
(12, 'XII', 4, 'A', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_member`
--

CREATE TABLE `tb_member` (
  `id_member` int(11) NOT NULL,
  `nama_member` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `paket` enum('1 Hari','1 Bulan','3 Bulan','6 Bulan','12 Bulan') DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  `tanggal_expired` date DEFAULT NULL,
  `status` enum('Aktif','Expired') DEFAULT 'Aktif',
  `qr_code` varchar(255) DEFAULT NULL,
  `unique_code` varchar(64) NOT NULL,
  `rfid_code` varchar(100) DEFAULT NULL,
  `nominal` decimal(12,0) NOT NULL DEFAULT 0,
  `metode_bayar` varchar(20) DEFAULT NULL,
  `bayar_cash` bigint(20) DEFAULT 0,
  `bayar_qris` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tb_member`
--

INSERT INTO `tb_member` (`id_member`, `nama_member`, `no_hp`, `jenis_kelamin`, `alamat`, `paket`, `tanggal_daftar`, `tanggal_expired`, `status`, `qr_code`, `unique_code`, `rfid_code`, `nominal`, `metode_bayar`, `bayar_cash`, `bayar_qris`) VALUES
(30, 'REZA MAULANA RIZKY', '085225405779', 'Laki-laki', 'DUSUN KEDAWON RT 002/RW 006 RENGASPENDAWA,LARANGANBREBES', '1 Bulan', '2026-06-24', '2026-07-24', 'Aktif', 'MBR6a3b58e8804cd', 'MBR6a3b58e8804cd', '', 175000, 'QRIS', 0, 0),
(31, 'REZA MAULANA ', '085225405779', 'Laki-laki', 'DUSUN KEDAWON RT 002/RW 006 RENGASPENDAWA,LARANGANBREBES', '3 Bulan', '2026-06-24', '2026-09-24', 'Aktif', 'MBR6a3b593973d02', 'MBR6a3b593973d02', '', 425000, 'Cash', 0, 0),
(32, 'REZA', '085225405779', 'Laki-laki', 'DUSUN KEDAWON RT 002/RW 006 RENGASPENDAWA,LARANGANBREBES', '6 Bulan', '2026-06-24', '2026-12-24', 'Aktif', 'MBR6a3b769b0e0e8', 'MBR6a3b769b0e0e8', '', 875000, 'Gabungan', 870000, 5000),
(33, 'Harian 1 24-06-2026', '-', 'Laki-laki', '-', '1 Hari', '2026-06-24', '2026-06-24', 'Expired', 'HRN-20260624-0001', 'HRN-20260624-0001', NULL, 25000, 'Cash', 25000, 0),
(34, 'Harian 2 24-06-2026', '-', 'Laki-laki', '-', '1 Hari', '2026-06-24', '2026-06-24', 'Expired', 'HRN-20260624-0002', 'HRN-20260624-0002', NULL, 25000, 'QRIS', 0, 25000),
(35, 'Harian 3 24-06-2026', '-', 'Laki-laki', '-', '1 Hari', '2026-06-24', '2026-06-24', 'Expired', 'HRN-20260624-0003', 'HRN-20260624-0003', NULL, 25000, 'Gabungan', 20000, 5000),
(36, 'Harian 1 26-06-2026', '-', 'Laki-laki', '-', '1 Hari', '2026-06-26', '2026-06-26', 'Expired', 'HRN-20260626-0001', 'HRN-20260626-0001', NULL, 25000, 'QRIS', 0, 25000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_penjualan`
--

CREATE TABLE `tb_penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `kode_penjualan` varchar(30) NOT NULL,
  `tanggal` datetime NOT NULL,
  `total_barang` int(11) DEFAULT 0,
  `subtotal` bigint(20) DEFAULT 0,
  `diskon` bigint(20) DEFAULT 0,
  `total` bigint(20) DEFAULT 0,
  `metode_bayar` enum('Cash','QRIS','Gabungan') DEFAULT NULL,
  `bayar_cash` bigint(20) DEFAULT 0,
  `bayar_qris` bigint(20) DEFAULT 0,
  `kasir` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_penjualan_barang`
--

CREATE TABLE `tb_penjualan_barang` (
  `id_penjualan` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `harga_satuan` bigint(20) NOT NULL,
  `total_harga` bigint(20) NOT NULL,
  `metode_bayar` enum('Cash','QRIS','Gabungan') DEFAULT 'Cash',
  `bayar_cash` bigint(20) DEFAULT 0,
  `bayar_qris` bigint(20) DEFAULT 0,
  `tanggal_penjualan` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_presensi_member`
--

CREATE TABLE `tb_presensi_member` (
  `id_presensi` int(11) NOT NULL,
  `id_member` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `id_kehadiran` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tb_presensi_member`
--

INSERT INTO `tb_presensi_member` (`id_presensi`, `id_member`, `tanggal`, `jam_masuk`, `jam_keluar`, `id_kehadiran`, `keterangan`) VALUES
(23, 33, '2026-06-24', '14:08:29', NULL, 1, ''),
(24, 34, '2026-06-24', '14:08:33', NULL, 1, ''),
(25, 35, '2026-06-24', '14:08:45', NULL, 1, ''),
(26, 36, '2026-06-26', '16:57:17', NULL, 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_presensi_siswa`
--

CREATE TABLE `tb_presensi_siswa` (
  `id_presensi` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_kelas` int(11) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `id_kehadiran` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(16) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `id_kelas` int(11) UNSIGNED NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `no_hp` varchar(32) NOT NULL,
  `unique_code` varchar(64) NOT NULL,
  `rfid_code` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_member` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `role` enum('Superadmin','Admin','Kasir') DEFAULT 'Kasir',
  `is_superadmin` tinyint(1) NOT NULL DEFAULT 0,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_member`, `email`, `username`, `role`, `is_superadmin`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'adminsuper@gmail.com', 'superadmin', 'Superadmin', 1, '$2y$10$VxfRCzJ5AOBZsho7iLSNNub0N.K6dng.5cKZMDbCF6ROhZZ1UfnWi', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(3, NULL, 'kasir@kasir.com', 'kasirr', 'Kasir', 4, '$2y$10$HsKQrfdIxXiVU.VXhJMuHO6K7kcbo6x.IU4KDxrUf/A6anqlURWE.', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indeks untuk tabel `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indeks untuk tabel `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indeks untuk tabel `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indeks untuk tabel `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `tb_detail_penjualan`
--
ALTER TABLE `tb_detail_penjualan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_penjualan` (`id_penjualan`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jurusan` (`jurusan`);

--
-- Indeks untuk tabel `tb_kehadiran`
--
ALTER TABLE `tb_kehadiran`
  ADD PRIMARY KEY (`id_kehadiran`);

--
-- Indeks untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `tb_kelas_id_jurusan_foreign` (`id_jurusan`),
  ADD KEY `fk_tb_kelas_id_wali_kelas` (`id_wali_kelas`);

--
-- Indeks untuk tabel `tb_member`
--
ALTER TABLE `tb_member`
  ADD PRIMARY KEY (`id_member`),
  ADD UNIQUE KEY `unique_code` (`unique_code`),
  ADD KEY `idx_tb_guru_rfid_code` (`rfid_code`);

--
-- Indeks untuk tabel `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `tb_penjualan_barang`
--
ALTER TABLE `tb_penjualan_barang`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `tb_presensi_member`
--
ALTER TABLE `tb_presensi_member`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_guru` (`id_member`),
  ADD KEY `id_kehadiran` (`id_kehadiran`);

--
-- Indeks untuk tabel `tb_presensi_siswa`
--
ALTER TABLE `tb_presensi_siswa`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_kehadiran` (`id_kehadiran`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `unique_code` (`unique_code`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `idx_tb_siswa_rfid_code` (`rfid_code`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_users_id_guru` (`id_member`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_detail_penjualan`
--
ALTER TABLE `tb_detail_penjualan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_kehadiran`
--
ALTER TABLE `tb_kehadiran`
  MODIFY `id_kehadiran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id_kelas` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tb_member`
--
ALTER TABLE `tb_member`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_penjualan_barang`
--
ALTER TABLE `tb_penjualan_barang`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_presensi_member`
--
ALTER TABLE `tb_presensi_member`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `tb_presensi_siswa`
--
ALTER TABLE `tb_presensi_siswa`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_detail_penjualan`
--
ALTER TABLE `tb_detail_penjualan`
  ADD CONSTRAINT `tb_detail_penjualan_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `tb_penjualan` (`id_penjualan`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_detail_penjualan_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`);

--
-- Ketidakleluasaan untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD CONSTRAINT `fk_tb_kelas_id_wali_kelas` FOREIGN KEY (`id_wali_kelas`) REFERENCES `tb_member` (`id_member`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tb_kelas_id_jurusan_foreign` FOREIGN KEY (`id_jurusan`) REFERENCES `tb_jurusan` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_presensi_member`
--
ALTER TABLE `tb_presensi_member`
  ADD CONSTRAINT `tb_presensi_guru_id_guru_foreign` FOREIGN KEY (`id_member`) REFERENCES `tb_member` (`id_member`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `tb_presensi_guru_id_kehadiran_foreign` FOREIGN KEY (`id_kehadiran`) REFERENCES `tb_kehadiran` (`id_kehadiran`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_presensi_siswa`
--
ALTER TABLE `tb_presensi_siswa`
  ADD CONSTRAINT `tb_presensi_siswa_id_kehadiran_foreign` FOREIGN KEY (`id_kehadiran`) REFERENCES `tb_kehadiran` (`id_kehadiran`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_presensi_siswa_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `tb_presensi_siswa_id_siswa_foreign` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `tb_siswa_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_id_guru` FOREIGN KEY (`id_member`) REFERENCES `tb_member` (`id_member`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
