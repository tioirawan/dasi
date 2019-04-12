-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2019 at 02:33 PM
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
(6, 1, 'Penggalangan Dana Team $_BASH', 'Dukung team $_BASH dalam permata youthpreneur', 1, 1000000, 801000, 'open'),
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
(1, '20539750', 'Negeri', 'SMK', 'SMKN 8 Malang', 250000, 1000000),
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
(25, 1, 25, 'januari', 1, '2019-04-12 04:29:44'),
(26, 1, 25, 'februari', 1, '2019-04-12 05:42:07'),
(27, 1, 25, 'maret', 1, '2019-04-12 05:42:25'),
(28, 1, 25, 'april', 1, '2019-04-11 11:57:59'),
(29, 1, 25, 'mei', 1, '2019-04-12 05:42:15'),
(30, 1, 25, 'juni', 1, '2019-04-11 11:57:46'),
(31, 1, 25, 'juli', 1, '2019-04-11 11:57:30'),
(32, 1, 25, 'agustus', 1, '2019-04-11 12:06:41'),
(33, 1, 25, 'september', 1, '2019-04-12 05:41:48'),
(34, 1, 25, 'oktober', 1, '2019-04-12 05:41:55'),
(35, 1, 25, 'november', 1, '2019-04-12 05:42:01'),
(36, 1, 25, 'desember', 1, '2019-04-11 11:57:40'),
(37, 1, 26, 'januari', 0, NULL),
(38, 1, 26, 'februari', 0, NULL),
(39, 1, 26, 'maret', 0, NULL),
(40, 1, 26, 'april', 0, NULL),
(41, 1, 26, 'mei', 0, NULL),
(42, 1, 26, 'juni', 0, NULL),
(43, 1, 26, 'juli', 1, '2019-04-12 12:22:19'),
(44, 1, 26, 'agustus', 1, '2019-04-12 12:22:33'),
(45, 1, 26, 'september', 1, '2019-04-12 12:22:38'),
(46, 1, 26, 'oktober', 1, '2019-04-12 12:27:06'),
(47, 1, 26, 'november', 0, NULL),
(48, 1, 26, 'desember', 0, NULL);

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
(19, 1, '2019-04-07 11:56:42', 'Tio Misbaqul Irawan', 'laki-laki', 'tioirawan063@gmail.com', 'siswa', 'X', 'RPL', 'A', '0019323659', 2145888048, '8d4576a288fe78dfd3b7c28641e4dfa2'),
(23, 1, '2019-04-10 05:39:06', 'Adecya Jalu Mahadwija', 'laki-laki', 'jaludwija37@gmail.com', 'siswa', 'X', 'RPL', 'A', '0012341238', 0, '568d95cbf418b9c944ff0e4157c89a8c'),
(24, 1, '2019-04-11 07:40:37', 'Incride ', 'laki-laki', 'alvinakbar095@gmail.com', 'siswa', 'X', 'RPL', 'A', '009876543', 7249999, 'ad20b2f1472945fd16ad92bea91dccf8'),
(25, 1, '2019-04-11 11:55:34', 'Syahrian Virbi Irawan', 'laki-laki', 'virbibu@gmail.com', 'siswa', 'VII', 'IPA', 'D', '0012412313', 17000000, 'da48fd36d4b4cfc6f125a44c9b4033bb'),
(26, 1, '2019-04-12 12:08:01', 'Unun Tri Suntari', 'perempuan', 'unun@gmail.com', 'siswa', 'X', 'RPL', 'A', '0013121415', 0, '6649c9d04b963c9d86dacc0dcbb58e56');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users_donation`
--
ALTER TABLE `users_donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_transaction`
--
ALTER TABLE `users_transaction`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

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
