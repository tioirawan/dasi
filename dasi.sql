-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2019 at 08:06 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `npsn` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL COMMENT 'Negeri / Swasta',
  `bentuk_pendidikan` varchar(255) NOT NULL COMMENT 'SMK / SMA',
  `nama_sekolah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `npsn`, `status`, `bentuk_pendidikan`, `nama_sekolah`) VALUES
(1, '20539750', 'Negeri', 'SMK', 'SMKN 8 Malang'),
(2, '12345678', 'Negeri', 'SMA', 'SMA Negeri 1 Jupiter');

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
  `taggal_pembayaran` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `spp`
--

INSERT INTO `spp` (`id`, `id_sekolah`, `id_siswa`, `bulan`, `status_pembayaran`, `taggal_pembayaran`) VALUES
(1, 1, 23, 'januari', 0, NULL),
(2, 1, 23, 'februari', 0, NULL),
(3, 1, 23, 'maret', 0, NULL),
(4, 1, 23, 'april', 0, NULL),
(5, 1, 23, 'mei', 0, NULL),
(6, 1, 23, 'juni', 0, NULL),
(7, 1, 23, 'juli', 0, NULL),
(8, 1, 23, 'agustus', 0, NULL),
(9, 1, 23, 'september', 0, NULL),
(10, 1, 23, 'oktober', 0, NULL),
(11, 1, 23, 'november', 0, NULL),
(12, 1, 23, 'desember', 0, NULL);

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
(18, 1, '2019-04-07 08:20:10', 'Albert Enstein', 'laki-laki', 'enstein@relativity.science', 'siswa', 'XIII', 'SCIENCE', 'A', '0010100110', 500000, 'fdd6a2c0d13fad2ebf832f2cd5c7b11f'),
(19, 1, '2019-04-07 11:56:42', 'Tio Misbaqul Irawan', 'laki-laki', 'tioirawan063@gmail.com', 'siswa', 'X', 'RPL', 'A', '0019323659', 0, '8d4576a288fe78dfd3b7c28641e4dfa2'),
(23, 1, '2019-04-10 05:39:06', 'Adecya Jalu Mahadwija', 'laki-laki', 'jaludwija37@gmail.com', 'siswa', 'X', 'RPL', 'A', '0012341238', 0, '568d95cbf418b9c944ff0e4157c89a8c');

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donation_disbursement`
--
ALTER TABLE `donation_disbursement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qrcode`
--
ALTER TABLE `qrcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `spp`
--
ALTER TABLE `spp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `toko_transaction`
--
ALTER TABLE `toko_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
