-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2026 at 05:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rapor_ramdan`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi_ramdan`
--

CREATE TABLE `absensi_ramdan` (
  `id_absen` int(11) NOT NULL,
  `nis` int(11) NOT NULL,
  `sakit` int(11) NOT NULL,
  `izin` int(11) NOT NULL,
  `alfa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi_ramdan`
--

INSERT INTO `absensi_ramdan` (`id_absen`, `nis`, `sakit`, `izin`, `alfa`) VALUES
(1, 10243299, 0, 0, 0),
(2, 10243297, 1, 0, 0),
(3, 10243298, 0, 0, 2),
(4, 10243378, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kelas_ramdan`
--

CREATE TABLE `kelas_ramdan` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(30) NOT NULL,
  `id_guru` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas_ramdan`
--

INSERT INTO `kelas_ramdan` (`id_kelas`, `nama_kelas`, `id_guru`) VALUES
(1, 'X RPL B', 1054),
(2, 'XI TP B', 1055),
(3, 'XI ANM B', 1056),
(4, 'X DKV A', 1057);

-- --------------------------------------------------------

--
-- Table structure for table `mapel_ramdan`
--

CREATE TABLE `mapel_ramdan` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(50) NOT NULL,
  `kkm` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mapel_ramdan`
--

INSERT INTO `mapel_ramdan` (`id_mapel`, `nama_mapel`, `kkm`) VALUES
(1, 'Bahasa Inggris', 75),
(2, 'Penjas', 75),
(3, 'Bahasa jepang', 75),
(4, 'PAI', 75);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_ramdan`
--

CREATE TABLE `nilai_ramdan` (
  `id_nilai` varchar(11) NOT NULL,
  `nis` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `nilai_tugas` decimal(10,0) NOT NULL,
  `nilai_uts` decimal(10,0) NOT NULL,
  `nilai_uas` decimal(10,0) NOT NULL,
  `nilai_akhir` decimal(10,0) NOT NULL,
  `deskripsi` text NOT NULL,
  `semester` varchar(10) NOT NULL,
  `tahun_ajaran` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai_ramdan`
--

INSERT INTO `nilai_ramdan` (`id_nilai`, `nis`, `id_mapel`, `nilai_tugas`, `nilai_uts`, `nilai_uas`, `nilai_akhir`, `deskripsi`, `semester`, `tahun_ajaran`) VALUES
('NP001', 10243299, 1, 89, 89, 92, 90, 'Sangat Baik', 'ganjil', '2025-2026'),
('NP002', 10243297, 2, 97, 69, 87, 85, 'Baik', 'ganjil', '2025/2026');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_ramdan`
--

CREATE TABLE `siswa_ramdan` (
  `nis` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tempat_lahir` varchar(20) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `id_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa_ramdan`
--

INSERT INTO `siswa_ramdan` (`nis`, `nama`, `tempat_lahir`, `tgl_lahir`, `alamat`, `id_kelas`) VALUES
(10243297, 'Dirgahayu', 'Cimahi', '2017-01-19', 'Sangkur', 1),
(10243298, 'Muhamad Ramdan', 'Cimahi', '2008-09-06', 'Permana', 1),
(10243299, 'Argi', 'Cimahi', '2026-10-05', 'tugu Mekar', 3),
(10243378, 'Ucup', 'Cimahi', '2016-01-03', 'haur koneng', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_ramdan`
--

CREATE TABLE `user_ramdan` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('admin','guru','wali kelas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_ramdan`
--

INSERT INTO `user_ramdan` (`id`, `username`, `password`, `role`) VALUES
(1, 'Mordex', 'RamdanGG', 'admin'),
(2, 'Mimi', 'RamdanGG', 'guru'),
(3, 'Santuy', 'RamdanGG', 'guru'),
(4, 'kkiky', 'RamdanGG', 'wali kelas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi_ramdan`
--
ALTER TABLE `absensi_ramdan`
  ADD PRIMARY KEY (`id_absen`),
  ADD KEY `nis` (`nis`);

--
-- Indexes for table `kelas_ramdan`
--
ALTER TABLE `kelas_ramdan`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `mapel_ramdan`
--
ALTER TABLE `mapel_ramdan`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `nilai_ramdan`
--
ALTER TABLE `nilai_ramdan`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `nis` (`nis`,`id_mapel`),
  ADD KEY `FK_mapel` (`id_mapel`);

--
-- Indexes for table `siswa_ramdan`
--
ALTER TABLE `siswa_ramdan`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `user_ramdan`
--
ALTER TABLE `user_ramdan`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi_ramdan`
--
ALTER TABLE `absensi_ramdan`
  ADD CONSTRAINT `FK_nis` FOREIGN KEY (`nis`) REFERENCES `siswa_ramdan` (`nis`);

--
-- Constraints for table `nilai_ramdan`
--
ALTER TABLE `nilai_ramdan`
  ADD CONSTRAINT `FK_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel_ramdan` (`id_mapel`),
  ADD CONSTRAINT `FK_nis2` FOREIGN KEY (`nis`) REFERENCES `siswa_ramdan` (`nis`);

--
-- Constraints for table `siswa_ramdan`
--
ALTER TABLE `siswa_ramdan`
  ADD CONSTRAINT `FK_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas_ramdan` (`id_kelas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
