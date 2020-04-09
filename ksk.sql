-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Apr 2020 pada 12.29
-- Versi server: 10.4.8-MariaDB
-- Versi PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ksk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `verificationcode` varchar(250) NOT NULL,
  `verificationstatus` int(11) NOT NULL,
  `activeflag` int(11) NOT NULL,
  `role` varchar(9) NOT NULL,
  `driverlicense` varchar(20) DEFAULT NULL,
  `verificationdate` date NOT NULL,
  `lastpassworddate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userid`, `fullname`, `address`, `phone`, `email`, `password`, `verificationcode`, `verificationstatus`, `activeflag`, `role`, `driverlicense`, `verificationdate`, `lastpassworddate`) VALUES
(2, 'Yudi Agusta', 'address', 'phone', 'yudiagustabali@yahoo.com', 'fb046cb3abf9a27041edce8647675a30', '8268a8501a342d5747110f4e85a519af', 1, 1, 'Volunteer', 'driverlicense', '2020-04-08', '2020-04-09'),
(3, 'Clara Mayu', 'Jalan Tukad Badung', '081338407756', 'yudiagustawork@gmail.com', 'c60a5919fd974afed051b9ccfbc720b3', 'd38c02719fec388d5d66af537ccace2d', 1, 1, 'Staff', '985730288', '2020-04-08', '2020-04-09');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
