-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2019 at 02:37 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL DEFAULT 'admin',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `id_sekolah`, `nama`, `email`, `level`, `password`) VALUES
(1, 1, 'admin', 'admin@mail.com', 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9'),
(2, 1, 'TU', 'tu@smkn8malang.com', 'admin', '5e49fc989c52f362807f09465a98ffbf');

-- --------------------------------------------------------

--
-- Table structure for table `admin_journal`
--

CREATE TABLE `admin_journal` (
  `id` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_admin` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `nilai` bigint(20) NOT NULL,
  `ext_1` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_journal`
--

INSERT INTO `admin_journal` (`id`, `id_sekolah`, `tanggal`, `id_admin`, `code`, `nilai`, `ext_1`) VALUES
(1, 1, '2019-04-07 11:55:12', 2, 'change_donation_status', 0, '6'),
(2, 1, '2019-04-07 11:55:16', 2, 'change_donation_status', 1, '6'),
(3, 1, '2019-04-07 11:56:44', 2, 'register_user', 0, '19'),
(4, 1, '2019-04-10 05:11:49', 2, 'login', 0, ''),
(5, 1, '2019-04-10 05:32:01', 2, 'login', 0, ''),
(6, 1, '2019-04-10 05:35:06', 2, 'register_user', 0, '1'),
(7, 1, '2019-04-10 05:35:49', 2, 'register_user', 0, '1'),
(8, 1, '2019-04-10 05:39:06', 2, 'register_user', 0, '23'),
(9, 1, '2019-04-11 07:35:02', 2, 'login', 0, ''),
(10, 1, '2019-04-11 07:35:11', 2, 'setor_tunai_siswa', 1000000, '19'),
(11, 1, '2019-04-11 07:37:48', 2, 'login', 0, ''),
(12, 1, '2019-04-11 07:40:39', 2, 'register_user', 0, '24'),
(13, 1, '2019-04-11 07:46:10', 2, 'login', 0, ''),
(14, 1, '2019-04-11 07:49:01', 2, 'generate_qr_toko', 0, '7'),
(15, 1, '2019-04-11 07:51:20', 2, 'create_toko', 0, ''),
(16, 1, '2019-04-11 07:51:38', 2, 'generate_qr_toko', 0, '8'),
(17, 1, '2019-04-11 11:19:33', 2, 'login', 0, ''),
(18, 1, '2019-04-11 11:19:48', 2, 'setor_tunai_siswa', 2147483647, '19'),
(19, 1, '2019-04-11 11:54:27', 2, 'login', 0, ''),
(20, 1, '2019-04-11 11:55:36', 2, 'register_user', 0, '25'),
(21, 1, '2019-04-11 11:56:48', 2, 'login', 0, ''),
(22, 1, '2019-04-11 11:57:12', 2, 'setor_tunai_siswa', 20000000, '25'),
(23, 1, '2019-04-11 12:10:52', 2, 'login', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `id` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` longtext NOT NULL,
  `posted_by` int(11) NOT NULL COMMENT 'id admin',
  `target_donasi` bigint(20) NOT NULL,
  `terkumpul` bigint(20) NOT NULL DEFAULT '0',
  `status` enum('open','close') NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`id`, `id_sekolah`, `judul`, `deskripsi`, `posted_by`, `target_donasi`, `terkumpul`, `status`) VALUES
(6, 1, 'Penggalangan Dana Team $_BASH', 'Dukung team $_BASH dalam permata youthpreneur', 1, 1000000, 751000, 'open'),
(7, 1, 'Panti Asuhan Palsu', 'Untuk percobaan, tolong sumbangkan dana kalian', 1, 500000, 0, 'close'),
(8, 1, 'Donasi Pembuatan Logo', 'Buat logo itu susah', 1, 2000000, 284600, 'open');

-- --------------------------------------------------------

--
-- Table structure for table `donation_disbursement`
--

CREATE TABLE `donation_disbursement` (
  `id` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `idadmin` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amout` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `qrcode`
--

CREATE TABLE `qrcode` (
  `id` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL COMMENT 'Nilai QR',
  `judul` varchar(255) NOT NULL,
  `tetap` tinyint(1) NOT NULL,
  `generated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_toko` int(11) NOT NULL,
  `nilai` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qrcode`
--

INSERT INTO `qrcode` (`id`, `id_sekolah`, `unique_id`, `judul`, `tetap`, `generated_by`, `created_at`, `id_toko`, `nilai`) VALUES
(1, 1, 'veHHHUyPYY', 'Es Teh', 1, 1, '2019-04-03 12:02:20', 5, 1000),
(2, 1, 'U9Xc6PcEmp', 'Bakso', 0, 1, '2019-04-03 12:42:39', 5, 5000),
(3, 1, 'WrvYEVdUur', 'Big Mac', 1, 1, '2019-04-03 12:52:25', 6, 50000),
(4, 1, '0Q4pMH2dpY', 'Mahalll', 1, 1, '2019-04-03 12:53:56', 6, 1000000),
(5, 1, 'UwoL49FLWS', 'Mc Nuggets', 1, 1, '2019-04-07 04:13:00', 6, 24000),
(6, 1, 'Rt8zXqT1kg', 'Whopper Jr', 1, 1, '2019-04-07 05:02:01', 7, 30000),
(7, 1, 'SmedagRpI9', 'Lalapan', 1, 2, '2019-04-11 07:49:01', 5, 17000),
(8, 1, 'GZfgN9zN3t', 'Tahu Isi', 1, 2, '2019-04-11 07:51:38', 8, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `npsn` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL COMMENT 'Negeri / Swasta',
  `bentuk_pendidikan` varchar(255) NOT NULL COMMENT 'SMK / SMA',
  `nama_sekolah` varchar(255) NOT NULL,
  `biaya_spp` bigint(20) NOT NULL,
  `saldo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `npsn`, `status`, `bentuk_pendidikan`, `nama_sekolah`, `biaya_spp`, `saldo`) VALUES
(1, '20539750', 'Negeri', 'SMK', 'SMKN 8 Malang', 250000, 6250000),
(2, '12345678', 'Negeri', 'SMA', 'SMA Negeri 1 Jupiter', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `spp`
--

CREATE TABLE `spp` (
  `id` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `bulan` enum('januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember') NOT NULL,
  `status_pembayaran` tinyint(1) DEFAULT '0',
  `tanggal_pembayaran` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `spp`
--

INSERT INTO `spp` (`id`, `id_sekolah`, `id_siswa`, `bulan`, `status_pembayaran`, `tanggal_pembayaran`) VALUES
(1, 1, 23, 'januari', 1, '2019-04-11 11:28:20'),
(2, 1, 23, 'februari', 1, '2019-04-15 17:00:00'),
(3, 1, 23, 'maret', 1, '2019-04-11 11:28:25'),
(4, 1, 23, 'april', 1, '2019-04-20 17:00:00'),
(5, 1, 23, 'mei', 1, '2019-04-11 11:28:32'),
(6, 1, 23, 'juni', 1, '2019-04-19 17:00:00'),
(7, 1, 23, 'juli', 1, '2019-04-11 11:22:01'),
(8, 1, 23, 'agustus', 1, '2019-04-11 11:17:45'),
(9, 1, 23, 'september', 1, '2019-04-11 11:17:08'),
(10, 1, 23, 'oktober', 1, '2019-04-11 11:24:41'),
(11, 1, 23, 'november', 1, '2019-04-11 11:25:08'),
(12, 1, 23, 'desember', 1, '2019-04-11 11:26:06'),
(13, 1, 24, 'januari', 1, '2019-04-11 11:47:31'),
(14, 1, 24, 'februari', 1, '2019-04-11 11:47:36'),
(15, 1, 24, 'maret', 1, '2019-04-11 11:47:41'),
(16, 1, 24, 'april', 1, '2019-04-11 11:44:33'),
(17, 1, 24, 'mei', 1, '2019-04-11 11:47:19'),
(18, 1, 24, 'juni', 1, '2019-03-31 17:00:00'),
(19, 1, 24, 'juli', 1, '2019-04-11 11:42:45'),
(20, 1, 24, 'agustus', 1, '2019-04-11 11:42:51'),
(21, 1, 24, 'september', 1, '2019-04-11 11:47:25'),
(22, 1, 24, 'oktober', 1, '2019-04-11 11:42:57'),
(23, 1, 24, 'november', 1, '2019-04-11 11:43:02'),
(24, 1, 24, 'desember', 1, '2019-04-11 11:43:09'),
(25, 1, 25, 'januari', 0, NULL),
(26, 1, 25, 'februari', 0, NULL),
(27, 1, 25, 'maret', 0, NULL),
(28, 1, 25, 'april', 1, '2019-04-11 11:57:59'),
(29, 1, 25, 'mei', 0, NULL),
(30, 1, 25, 'juni', 1, '2019-04-11 11:57:46'),
(31, 1, 25, 'juli', 1, '2019-04-11 11:57:30'),
(32, 1, 25, 'agustus', 1, '2019-04-11 12:06:41'),
(33, 1, 25, 'september', 0, NULL),
(34, 1, 25, 'oktober', 0, NULL),
(35, 1, 25, 'november', 0, NULL),
(36, 1, 25, 'desember', 1, '2019-04-11 11:57:40');

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` mediumtext NOT NULL,
  `saldo` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id`, `id_sekolah`, `nama`, `deskripsi`, `saldo`) VALUES
(5, 1, 'Pak Dadang', 'Nasi, Ayam, Bakso dan Es Teh', 0),
(6, 1, 'McDonald\'s', 'Jual makanan mahal', 0),
(7, 1, 'Burger King', 'Dine with king', 0),
(8, 1, 'Ery Maret', 'Sedia tahu isi', 0);

-- --------------------------------------------------------

--
-- Table structure for table `toko_transaction`
--

CREATE TABLE `toko_transaction` (
  `id` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `toko_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `qr_id` int(11) NOT NULL,
  `jumlah` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `tanggal_pendaftaran` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nama` varchar(255) NOT NULL,
  `kelamin` enum('laki-laki','perempuan') NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL DEFAULT 'siswa',
  `tingkatan` enum('I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII','XIII') NOT NULL,
  `jurusan` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `nisn` varchar(255) NOT NULL,
  `saldo` bigint(20) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_sekolah`, `tanggal_pendaftaran`, `nama`, `kelamin`, `email`, `level`, `tingkatan`, `jurusan`, `kelas`, `nisn`, `saldo`, `password`) VALUES
(18, 1, '2019-04-07 08:20:10', 'Albert Enstein', 'laki-laki', 'enstein@relativity.science', 'siswa', 'XIII', 'SCIENCE', 'A', '0010100110', 510000, 'fdd6a2c0d13fad2ebf832f2cd5c7b11f'),
(19, 1, '2019-04-07 11:56:42', 'Tio Misbaqul Irawan', 'laki-laki', 'tioirawan063@gmail.com', 'siswa', 'X', 'RPL', 'A', '0019323659', 2145938048, '8d4576a288fe78dfd3b7c28641e4dfa2'),
(23, 1, '2019-04-10 05:39:06', 'Adecya Jalu Mahadwija', 'laki-laki', 'jaludwija37@gmail.com', 'siswa', 'X', 'RPL', 'A', '0012341238', 0, '568d95cbf418b9c944ff0e4157c89a8c'),
(24, 1, '2019-04-11 07:40:37', 'Incride ', 'laki-laki', 'alvinakbar095@gmail.com', 'siswa', 'X', 'RPL', 'A', '009876543', 7249999, 'ad20b2f1472945fd16ad92bea91dccf8'),
(25, 1, '2019-04-11 11:55:34', 'Syahrian Virbi Irawan', 'laki-laki', 'virbibu@gmail.com', 'siswa', 'VII', 'IPA', 'D', '0012412313', 18750000, 'da48fd36d4b4cfc6f125a44c9b4033bb');

-- --------------------------------------------------------

--
-- Table structure for table `users_donation`
--

CREATE TABLE `users_donation` (
  `id` int(11) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `donation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `private` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_donation`
--

INSERT INTO `users_donation` (`id`, `id_sekolah`, `tanggal`, `donation_id`, `user_id`, `jumlah`, `private`) VALUES
(1, 1, '2019-04-11 07:37:31', 8, 19, 4600, 0),
(2, 1, '2019-04-11 08:15:35', 6, 19, 1000, 0),
(3, 1, '2019-04-11 08:59:38', 8, 19, 80000, 0),
(4, 1, '2019-04-11 08:59:51', 8, 19, 200000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_transaction`
--

CREATE TABLE `users_transaction` (
  `id` bigint(20) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `kredit` bigint(20) NOT NULL,
  `debit` bigint(20) NOT NULL,
  `tipe` varchar(255) NOT NULL COMMENT 'tipe transasi (spp/donasi/dll)',
  `jenis` enum('masuk','keluar') NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'tanggal transaksi',
  `user_id` int(11) NOT NULL,
  `metode` varchar(255) NOT NULL COMMENT 'metode pembayaran (transfer nisn/qrcode)',
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_transaction`
--

INSERT INTO `users_transaction` (`id`, `id_sekolah`, `kredit`, `debit`, `tipe`, `jenis`, `tanggal`, `user_id`, `metode`, `deskripsi`) VALUES
(1, 1, 1000000, 1000000, 'topup', 'masuk', '2019-04-11 14:35:11', 19, 'teller', 'Setor Tunai'),
(2, 1, 10000, 990000, 'transfer', 'keluar', '2019-04-11 14:35:27', 19, 'manual', 'Transfer ke Albert Enstein'),
(3, 1, 10000, 510000, 'transfer', 'masuk', '2019-04-11 14:35:27', 18, 'manual', 'Transfer dari Tio Misbaqul Irawan'),
(4, 1, 4600, 985400, 'donation', 'keluar', '2019-04-11 14:37:31', 19, 'direct', 'Donasi Donasi Pembuatan Logo'),
(5, 1, 500000, 9500000, 'transfer', 'keluar', '2019-04-11 14:44:19', 24, 'manual', 'Transfer ke Tio Misbaqul Irawan'),
(6, 1, 500000, 1485400, 'transfer', 'masuk', '2019-04-11 14:44:19', 19, 'manual', 'Transfer dari Incride '),
(7, 1, 499999, 985401, 'transfer', 'keluar', '2019-04-11 14:44:58', 19, 'manual', 'Transfer ke Incride '),
(8, 1, 499999, 9999999, 'transfer', 'masuk', '2019-04-11 14:44:58', 24, 'manual', 'Transfer dari Tio Misbaqul Irawan'),
(9, 1, 1000, 984401, 'donation', 'keluar', '2019-04-11 15:15:35', 19, 'direct', 'Donasi Penggalangan Dana Team $_BASH'),
(10, 1, 80000, 904401, 'donation', 'keluar', '2019-04-11 15:59:38', 19, 'direct', 'Donasi Donasi Pembuatan Logo'),
(11, 1, 200000, 704401, 'donation', 'keluar', '2019-04-11 15:59:51', 19, 'direct', 'Donasi Donasi Pembuatan Logo'),
(12, 1, 2147483647, 2147483647, 'topup', 'masuk', '2019-04-11 18:19:48', 19, 'teller', 'Setor Tunai'),
(13, 1, 250000, 2146938048, 'spp', 'keluar', '2019-04-11 18:25:08', 19, 'spp payment', 'Pembayaran SPP Bulan November'),
(14, 1, 250000, 2146688048, 'spp', 'keluar', '2019-04-11 18:26:06', 19, 'spp payment', 'Pembayaran SPP Bulan Desember'),
(15, 1, 250000, 2146438048, 'spp', 'keluar', '2019-04-11 18:28:20', 19, 'spp payment', 'Pembayaran SPP Bulan Januari'),
(16, 1, 250000, 2146188048, 'spp', 'keluar', '2019-04-11 18:28:25', 19, 'spp payment', 'Pembayaran SPP Bulan Maret'),
(17, 1, 250000, 2145938048, 'spp', 'keluar', '2019-04-11 18:28:32', 19, 'spp payment', 'Pembayaran SPP Bulan Mei'),
(18, 1, 250000, 9749999, 'spp', 'keluar', '2019-04-11 18:42:45', 24, 'spp payment', 'Pembayaran SPP Bulan Juli'),
(19, 1, 250000, 9499999, 'spp', 'keluar', '2019-04-11 18:42:51', 24, 'spp payment', 'Pembayaran SPP Bulan Agustus'),
(20, 1, 250000, 9249999, 'spp', 'keluar', '2019-04-11 18:42:57', 24, 'spp payment', 'Pembayaran SPP Bulan Oktober'),
(21, 1, 250000, 8999999, 'spp', 'keluar', '2019-04-11 18:43:03', 24, 'spp payment', 'Pembayaran SPP Bulan November'),
(22, 1, 250000, 8749999, 'spp', 'keluar', '2019-04-11 18:43:09', 24, 'spp payment', 'Pembayaran SPP Bulan Desember'),
(23, 1, 250000, 8499999, 'spp', 'keluar', '2019-04-11 18:44:33', 24, 'spp payment', 'Pembayaran SPP Bulan April'),
(24, 1, 250000, 8249999, 'spp', 'keluar', '2019-04-11 18:47:19', 24, 'spp payment', 'Pembayaran SPP Bulan Mei'),
(25, 1, 250000, 7999999, 'spp', 'keluar', '2019-04-11 18:47:25', 24, 'spp payment', 'Pembayaran SPP Bulan September'),
(26, 1, 250000, 7749999, 'spp', 'keluar', '2019-04-11 18:47:31', 24, 'spp payment', 'Pembayaran SPP Bulan Januari'),
(27, 1, 250000, 7499999, 'spp', 'keluar', '2019-04-11 18:47:36', 24, 'spp payment', 'Pembayaran SPP Bulan Februari'),
(28, 1, 250000, 7249999, 'spp', 'keluar', '2019-04-11 18:47:41', 24, 'spp payment', 'Pembayaran SPP Bulan Maret'),
(29, 1, 20000000, 20000000, 'topup', 'masuk', '2019-04-11 18:57:12', 25, 'teller', 'Setor Tunai'),
(30, 1, 250000, 19750000, 'spp', 'keluar', '2019-04-11 18:57:30', 25, 'spp payment', 'Pembayaran SPP Bulan Juli'),
(31, 1, 250000, 19500000, 'spp', 'keluar', '2019-04-11 18:57:40', 25, 'spp payment', 'Pembayaran SPP Bulan Desember'),
(32, 1, 250000, 19250000, 'spp', 'keluar', '2019-04-11 18:57:46', 25, 'spp payment', 'Pembayaran SPP Bulan Juni'),
(33, 1, 250000, 19000000, 'spp', 'keluar', '2019-04-11 18:57:59', 25, 'spp payment', 'Pembayaran SPP Bulan April'),
(34, 1, 250000, 18750000, 'spp', 'keluar', '2019-04-11 19:06:41', 25, 'spp payment', 'Pembayaran SPP Bulan Agustus');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indexes for table `admin_journal`
--
ALTER TABLE `admin_journal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sekolah` (`id_sekolah`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posted_by` (`posted_by`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indexes for table `donation_disbursement`
--
ALTER TABLE `donation_disbursement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idadmin` (`idadmin`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indexes for table `qrcode`
--
ALTER TABLE `qrcode`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`),
  ADD KEY `generated_by` (`generated_by`),
  ADD KEY `id_toko` (`id_toko`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spp`
--
ALTER TABLE `spp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sekolah` (`id_sekolah`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indexes for table `toko_transaction`
--
ALTER TABLE `toko_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indexes for table `users_donation`
--
ALTER TABLE `users_donation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donation_id` (`donation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- Indexes for table `users_transaction`
--
ALTER TABLE `users_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id_sekolah` (`id_sekolah`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_journal`
--
ALTER TABLE `admin_journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `donation_disbursement`
--
ALTER TABLE `donation_disbursement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qrcode`
--
ALTER TABLE `qrcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `spp`
--
ALTER TABLE `spp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `toko_transaction`
--
ALTER TABLE `toko_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users_donation`
--
ALTER TABLE `users_donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users_transaction`
--
ALTER TABLE `users_transaction`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `schools` (`id`);

--
-- Constraints for table `admin_journal`
--
ALTER TABLE `admin_journal`
  ADD CONSTRAINT `admin_journal_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `admin_journal_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id`);

--
-- Constraints for table `donation`
--
ALTER TABLE `donation`
  ADD CONSTRAINT `donation_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `donation_ibfk_2` FOREIGN KEY (`id_sekolah`) REFERENCES `schools` (`id`);

--
-- Constraints for table `donation_disbursement`
--
ALTER TABLE `donation_disbursement`
  ADD CONSTRAINT `donation_disbursement_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `donation_disbursement_ibfk_2` FOREIGN KEY (`idadmin`) REFERENCES `admin` (`id`);

--
-- Constraints for table `qrcode`
--
ALTER TABLE `qrcode`
  ADD CONSTRAINT `qrcode_ibfk_1` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id`),
  ADD CONSTRAINT `qrcode_ibfk_2` FOREIGN KEY (`generated_by`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `qrcode_ibfk_3` FOREIGN KEY (`id_sekolah`) REFERENCES `schools` (`id`);

--
-- Constraints for table `spp`
--
ALTER TABLE `spp`
  ADD CONSTRAINT `spp_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `schools` (`id`),
  ADD CONSTRAINT `spp_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `users` (`id`);

--
-- Constraints for table `toko`
--
ALTER TABLE `toko`
  ADD CONSTRAINT `toko_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `schools` (`id`);

--
-- Constraints for table `toko_transaction`
--
ALTER TABLE `toko_transaction`
  ADD CONSTRAINT `toko_transaction_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `schools` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_sekolah`) REFERENCES `schools` (`id`);

--
-- Constraints for table `users_donation`
--
ALTER TABLE `users_donation`
  ADD CONSTRAINT `users_donation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_donation_ibfk_2` FOREIGN KEY (`donation_id`) REFERENCES `donation` (`id`),
  ADD CONSTRAINT `users_donation_ibfk_3` FOREIGN KEY (`id_sekolah`) REFERENCES `schools` (`id`);

--
-- Constraints for table `users_transaction`
--
ALTER TABLE `users_transaction`
  ADD CONSTRAINT `users_transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_transaction_ibfk_2` FOREIGN KEY (`id_sekolah`) REFERENCES `schools` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
