-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Agu 2024 pada 15.14
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 7.4.1

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
-- Struktur dari tabel `building`
--

CREATE TABLE `building` (
  `building_id` int(8) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `building_scanner` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `building`
--

INSERT INTO `building` (`building_id`, `code`, `name`, `address`, `building_scanner`) VALUES
(4, 'SWUL6/2024', 'KEBERSIHAN', 'RSU AMBON', ''),
(5, 'SWJW8/2024', 'OBAT', 'RSU AMBON', ''),
(6, 'SWODO/2024', 'KONSULTASI', 'RSU AMBON', ''),
(7, 'SWXI2/2024', 'PEMERIKSAAN UMUM', 'RSU AMBON', ''),
(8, 'SWJ45/2024', 'RADIOLOGI', 'RSU AMBON', ''),
(9, 'SWDZV/2024', 'BERSALIN', 'RSU AMBON', ''),
(10, 'SWXD2/2024', 'ICU', 'RSU AMBON', ''),
(11, 'SWMMW/2024', 'UGD', 'RSU AMBON', ''),
(12, 'SWP4Y/2024', 'HRD', 'RSU AMBON', ''),
(13, 'SWGC8/2024', 'GUDANG', 'RSU AMBON', ''),
(14, 'SWYDK/2024', 'TEMPAT PARKIR', 'RSU AMBON', ''),
(15, 'SWUPQ/2024', 'REHABILITASI', 'RSU AMBON', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuty`
--

CREATE TABLE `cuty` (
  `cuty_id` int(11) NOT NULL,
  `employees_id` int(11) NOT NULL,
  `cuty_start` date NOT NULL,
  `cuty_end` date NOT NULL,
  `date_work` date NOT NULL,
  `cuty_total` int(5) NOT NULL,
  `cuty_description` varchar(100) NOT NULL,
  `cuty_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cuty`
--

INSERT INTO `cuty` (`cuty_id`, `employees_id`, `cuty_start`, `cuty_end`, `date_work`, `cuty_total`, `cuty_description`, `cuty_status`) VALUES
(3, 14, '2024-07-11', '2024-07-13', '2024-07-14', 3, 'sakit', 1),
(4, 17, '2024-07-12', '2024-07-17', '2024-07-18', 6, 'Ijin cuti dikarenakan Sakit', 1),
(5, 14, '2024-08-06', '2024-08-10', '2024-08-12', 10, 'Saya ijin cuti dikarenakan istri  saya sedang melahirkan', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employees_code` varchar(20) NOT NULL,
  `employees_email` varchar(30) NOT NULL,
  `employees_password` varchar(100) NOT NULL,
  `employees_name` varchar(50) NOT NULL,
  `pangkat` varchar(50) NOT NULL,
  `position_id` int(5) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `born` varchar(50) NOT NULL,
  `employess_address` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `created_login` datetime NOT NULL,
  `created_cookies` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `employees_code`, `employees_email`, `employees_password`, `employees_name`, `pangkat`, `position_id`, `shift_id`, `building_id`, `born`, `employess_address`, `photo`, `created_login`, `created_cookies`) VALUES
(14, '1000003', 'karyawan@gmail.com', 'acd2bcf0a751e78ba7a1904d55cb26b00b7b5c21ea1c7a91b373c2cf44ae0b29', 'RONI SETIAWAN', 'S1', 11, 6, 13, 'Manado 23 juli 1998', 'manado rt 04 rw 01', '2024-07-218b5b16551bccdacdf20f73f5a94193a4.jpeg', '2024-08-16 14:18:34', '3b58a25e863497fd04f9d1c0d0c616d2'),
(16, '1000002', 'amartholibrosyid@gmail.com', 'b9acba74bff2c29eef0cb33e9cdcf25377b5c7abcd3bcf30c8f93a30e2d0337f', 'AMAR THOLIB ROSYID', 'D3', 2, 16, 14, 'Ambon 30 juli 1981', 'ambon dusun 4', '2024-07-21c0112588e374c1fb70b0bc6930dcce42.jpeg', '2024-07-21 19:49:00', '4be3ad0586edd25797dc8c60eccdeb70'),
(17, '1000001', 'thoriq@gmail.com', '3a4af8db4daea53b7e117dd836ad88a5a68b77527c30a7263de3376211916abc', 'THORIQ SETIAWAN', 'D3', 8, 13, 4, 'Aceh 14  juli 1998', 'aceh dusun 1', '2024-07-21f5f33b6b0d42bd14fcbb092dda3272fa.jpg', '2024-07-21 19:51:11', '1e540e646cda5c56b2515895537d6eb6'),
(19, '0000001', 'fileohattalaibessy@gmail.com', '3747864e0a2161c905d1f8af8256524a3227f68bc6cc0996dad823c0d8b45057', 'FILEO SOFIO HATTALAIBESSY', 'S1', 9, 12, 12, 'Simajuntak 10 oktober 2000', 'simajuntak', '2024-08-146673e20716902ab0028890410cea52de.jpg', '2024-07-21 20:00:06', '-'),
(20, '1000004', 'santi@gmail.co.id', '927050d2d48daeffd6eb03d165352f2125861c7e6bb2abcf800f91984c5b121b', 'SANTI', 'D3', 13, 8, 5, 'Mojokerto 2 april 1999', 'mojokerto dusun 3', '2024-07-214973a1a22a3af8e55692d4f1f8cbb985.jpg', '2024-07-21 20:48:00', '-'),
(21, '1000005', 'iyansubarjo@gmail.id', '430cc7697435df3e722750a27909d7fefd44bb0a6b303936f6838acadbef2de4', 'DR. IYAN SUBARJONO', 'S2', 10, 11, 11, 'Ambon 17 Februari 1993', 'ambon dusun 2', '2024-07-218611994128789cf6239fc3503da2f81f.jpg', '2024-07-21 20:56:21', '-'),
(22, '1000006', 'drrichard@gmail.com', '2c267f3bd6c7640fa9254140e660005398d356a0d9ce29c3760516eb5c991e61', 'DR. RICHARD', 'S2', 14, 7, 10, 'Blitar 23 mei 2000', 'blitar dusun2', '2024-07-2160f880fdbef1b63d4f045d76e1ebbd00.jpeg', '2024-07-21 20:58:42', '-'),
(23, '1000007', 'alyaasihsaputri@gmail.com', '4f7b3947cf5b917cc14befc3272362fe98e03baec05e7654c0e6e87c9dd69a3b', 'ALYA ASIH SAPUTRI', 'S2', 7, 14, 9, '10 januari 2000', 'dusun 1 ', '2024-07-21a5daa9b6ac5b0f6bbec72828aa282c7f.jpg', '2024-07-21 21:00:57', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `position`
--

CREATE TABLE `position` (
  `position_id` int(5) NOT NULL,
  `position_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `position`
--

INSERT INTO `position` (`position_id`, `position_name`) VALUES
(1, 'STAFF'),
(2, 'PETUGAS PARKIR'),
(7, 'PERAWAT'),
(8, 'OFFICE BOY'),
(9, 'DIREKTUR'),
(10, 'DOKTER AHLI'),
(11, 'PEGAWAI GUDANG'),
(12, 'SUSTER'),
(13, 'ADMINITRASI'),
(14, 'DOKTER BEDAH');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presence`
--

CREATE TABLE `presence` (
  `presence_id` int(11) NOT NULL,
  `employees_id` int(11) NOT NULL,
  `presence_date` date NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `picture_in` text NOT NULL,
  `picture_out` varchar(150) NOT NULL,
  `present_id` int(11) NOT NULL COMMENT 'Masuk,Pulang,Tidak Hadir',
  `latitude_longtitude_in` varchar(100) NOT NULL,
  `latitude_longtitude_out` varchar(100) NOT NULL,
  `information` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `presence`
--

INSERT INTO `presence` (`presence_id`, `employees_id`, `presence_date`, `time_in`, `time_out`, `picture_in`, `picture_out`, `present_id`, `latitude_longtitude_in`, `latitude_longtitude_out`, `information`) VALUES
(1, 6, '2021-08-10', '21:48:19', '22:45:54', '2021-08-10-in-1628606899-6.jpeg', '2021-08-10-out-1628610354-6.jpeg', 1, '-4.5585849,105.40680789999999', '-4.5585849,105.40680789999999', ''),
(2, 6, '2021-08-11', '00:19:18', '00:22:11', '2021-08-11-in-1628615958-6.jpeg', '2021-08-11-out-1628616131-6.jpeg', 1, '-4.5585849,105.40680789999999', '-4.5585849,105.40680789999999', ''),
(3, 15, '2024-07-12', '11:56:30', '12:31:42', '2024-07-12-in-1720760190-15.jpeg', '2024-07-12-out-1720762302-15.jpeg', 1, '-7.70048,109.9595776', '-7.70048,109.9595776', ''),
(4, 17, '2024-07-12', '20:04:16', '20:05:19', '2024-07-12-in-1720789456-17.jpeg', '2024-07-12-out-1720789519-17.jpeg', 1, '-7.70048,109.9595776', '-7.70048,109.9595776', ''),
(5, 17, '2024-07-13', '13:45:26', '14:41:13', '2024-07-13-in-1720853126-17.jpeg', '2024-07-13-out-1720856473-17.jpeg', 1, '-7.5689243,109.9319802', '-7.7856768,110.3724544', ''),
(6, 18, '2024-07-19', '10:59:26', '00:00:00', '2024-07-19-in-1721361566-18.jpeg', '', 1, '-7.70048,109.9595776', '', ''),
(7, 14, '2024-07-25', '17:58:11', '00:00:00', '2024-07-25-in-1721905091-14.jpeg', '', 1, '-7.7036517,109.913971', '', ''),
(8, 14, '2024-07-27', '20:55:06', '00:00:00', '2024-07-27-in-1722088506-14.jpeg', '', 1, '-7.7070336,109.9628544', '', ''),
(9, 14, '2024-07-30', '20:32:05', '20:32:30', '2024-07-30-in-1722346325-14.jpeg', '2024-07-30-out-1722346350-14.jpeg', 1, '-7.7046205,109.9610951', '-7.7046205,109.9610951', ''),
(10, 14, '2024-08-01', '13:51:37', '21:11:10', '2024-08-01-in-1722495098-14.jpeg', '2024-08-01-out-1722521470-14.jpeg', 1, '-7.7046197,109.9610951', '-7.7037568,109.9628544', ''),
(11, 14, '2024-08-04', '20:30:06', '20:32:00', '2024-08-04-in-1722778206-14.jpeg', '2024-08-04-out-1722778320-14.jpeg', 1, '-7.7037568,109.9628544', '-7.7037568,109.9628544', ''),
(12, 14, '2024-08-16', '16:44:37', '16:44:50', '2024-08-16-in-1723801477-14.jpeg', '2024-08-16-out-1723801490-14.jpeg', 1, '-7.70048,109.9628544', '-7.70048,109.9628544', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `present_status`
--

CREATE TABLE `present_status` (
  `present_id` int(6) NOT NULL,
  `present_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `present_status`
--

INSERT INTO `present_status` (`present_id`, `present_name`) VALUES
(1, 'Hadir'),
(2, 'Sakit'),
(3, 'Izin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `shift`
--

CREATE TABLE `shift` (
  `shift_id` int(11) NOT NULL,
  `shift_name` varchar(20) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `shift`
--

INSERT INTO `shift` (`shift_id`, `shift_name`, `time_in`, `time_out`) VALUES
(1, 'FULL TIME', '08:00:00', '17:00:00'),
(5, 'PARUH WAKTU', '08:00:00', '11:30:00'),
(6, 'GUDANG', '07:30:00', '18:00:00'),
(7, 'DOKTER BEDAH', '08:30:00', '12:00:00'),
(8, 'ADMINITRASI', '08:00:00', '17:00:00'),
(9, 'SUSTER', '08:00:00', '17:00:00'),
(10, 'PEGAWAI GUDANG', '07:30:00', '18:00:00'),
(11, 'DOKTER AHLI', '13:00:00', '15:00:00'),
(12, 'DIREKTUR', '08:00:00', '11:00:00'),
(13, 'OFFICE BOY', '07:30:00', '18:00:00'),
(14, 'PERAWAT', '08:00:00', '17:00:00'),
(15, 'STAFF', '08:00:00', '17:00:00'),
(16, 'PETUGAS PARKIR', '07:30:00', '18:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sw_site`
--

CREATE TABLE `sw_site` (
  `site_id` int(4) NOT NULL,
  `site_url` varchar(100) NOT NULL,
  `site_name` varchar(50) NOT NULL,
  `site_company` varchar(30) NOT NULL,
  `site_manager` varchar(30) NOT NULL,
  `site_director` varchar(30) NOT NULL,
  `site_phone` char(12) NOT NULL,
  `site_address` text NOT NULL,
  `site_description` text NOT NULL,
  `site_logo` varchar(50) NOT NULL,
  `site_email` varchar(30) NOT NULL,
  `site_email_domain` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sw_site`
--

INSERT INTO `sw_site` (`site_id`, `site_url`, `site_name`, `site_company`, `site_manager`, `site_director`, `site_phone`, `site_address`, `site_description`, `site_logo`, `site_email`, `site_email_domain`) VALUES
(1, 'localhost/absen', 'RSU AMBON', 'RSU AMBON', 'MANAGER', 'DIREKTUR FILEO', '0812345678', 'Jl Ambon', 'Selamat Datang', 'boypng.png', 'admin@gmail.com', 'info@domain.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `registered` datetime NOT NULL,
  `created_login` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `session` varchar(100) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `browser` varchar(30) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`, `fullname`, `registered`, `created_login`, `last_login`, `session`, `ip`, `browser`, `level`) VALUES
(1, 'admin', 'admin@gmail.com', '88b3340abaa6acbf87abe45f68fa8960224c1e36f6a96433bcbc490c84c9c6d2', 'FILEO', '2021-02-03 10:22:00', '2024-08-16 16:42:28', '2024-08-16 20:17:54', '-', '1', 'Google Crome', 2),
(3, 'santi', 'santi@gmail.com', '035e0009b6356bfba0ef8eb562438a9a45bb578bf9ba806d12cb560e62d3260e', 'SANTI', '2024-08-16 20:17:41', '2024-08-16 20:18:02', '2024-08-16 20:17:41', '-', '1', 'Google Crome', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_level`
--

CREATE TABLE `user_level` (
  `level_id` int(4) NOT NULL,
  `level_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_level`
--

INSERT INTO `user_level` (`level_id`, `level_name`) VALUES
(1, 'Administrator'),
(2, 'Operator');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`building_id`);

--
-- Indeks untuk tabel `cuty`
--
ALTER TABLE `cuty`
  ADD PRIMARY KEY (`cuty_id`);

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indeks untuk tabel `presence`
--
ALTER TABLE `presence`
  ADD PRIMARY KEY (`presence_id`);

--
-- Indeks untuk tabel `present_status`
--
ALTER TABLE `present_status`
  ADD PRIMARY KEY (`present_id`);

--
-- Indeks untuk tabel `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`shift_id`);

--
-- Indeks untuk tabel `sw_site`
--
ALTER TABLE `sw_site`
  ADD PRIMARY KEY (`site_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeks untuk tabel `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`level_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `building`
--
ALTER TABLE `building`
  MODIFY `building_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `cuty`
--
ALTER TABLE `cuty`
  MODIFY `cuty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `position`
--
ALTER TABLE `position`
  MODIFY `position_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `presence`
--
ALTER TABLE `presence`
  MODIFY `presence_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `present_status`
--
ALTER TABLE `present_status`
  MODIFY `present_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `shift`
--
ALTER TABLE `shift`
  MODIFY `shift_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `sw_site`
--
ALTER TABLE `sw_site`
  MODIFY `site_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_level`
--
ALTER TABLE `user_level`
  MODIFY `level_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
