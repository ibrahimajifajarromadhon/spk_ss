-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Apr 2025 pada 12.25
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_ss`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kandungan_sunscreen`
--

CREATE TABLE `kandungan_sunscreen` (
  `id_kandungan` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `kriteria_jenis_kulit` int(11) NOT NULL,
  `kriteria_masalah_kulit` int(11) NOT NULL,
  `kriteria_reaksi_alergi` int(11) NOT NULL,
  `kriteria_aktivitas_pengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kandungan_sunscreen`
--

INSERT INTO `kandungan_sunscreen` (`id_kandungan`, `nama`, `kriteria_jenis_kulit`, `kriteria_masalah_kulit`, `kriteria_reaksi_alergi`, `kriteria_aktivitas_pengguna`) VALUES
(1, 'Zinc Oxide', 10, 15, 20, 25),
(2, 'Titanium Dioxide', 6, 14, 19, 22),
(3, 'Avobenzone', 6, 13, 18, 24),
(4, 'Homosalate', 7, 11, 17, 23),
(5, 'Oxybenzone', 6, 13, 16, 22),
(6, 'Octinoxate', 8, 14, 16, 23),
(7, 'Octisalate', 10, 11, 16, 22),
(8, 'Octocrylene', 8, 14, 16, 25);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis` enum('cf','sf') NOT NULL,
  `ket` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama`, `jenis`, `ket`) VALUES
(1, 'Jenis Kulit', 'cf', 'Core Factor'),
(2, 'Masalah Kulit', 'cf', 'Core Factor'),
(3, 'Reaksi Alergi', 'sf', 'Secondary Factor'),
(4, 'Aktivitas Pengguna', 'sf', 'Secondary Factor');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembobotan`
--

CREATE TABLE `pembobotan` (
  `id_bobot` int(11) NOT NULL,
  `selisih` int(11) DEFAULT NULL,
  `bobot` float DEFAULT NULL,
  `ket` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pembobotan`
--

INSERT INTO `pembobotan` (`id_bobot`, `selisih`, `bobot`, `ket`) VALUES
(1, 0, 5, 'Cocok 100% dengan kebutuhan kulit'),
(2, 1, 4.5, 'Sedikit lebih dari yang dibutuhkan, masih sesuai'),
(3, -1, 4, 'Sedikit kurang dari yang dibutuhkan, masih bisa di'),
(4, 2, 3.5, 'Cukup lebih dari yang dibutuhkan, mungkin kurang o'),
(5, -2, 3, 'Cukup kurang dari yang dibutuhkan, bisa kurang efe'),
(6, 3, 2.5, 'Terlalu banyak dari yang dibutuhkan, bisa kurang c'),
(7, -3, 2, 'Terlalu sedikit dari yang dibutuhkan, bisa tidak e'),
(8, 4, 1.5, 'Sangat berlebihan dari yang dibutuhkan, kurang dis'),
(9, -4, 1, 'Sangat kurang dari yang dibutuhkan, tidak disarank');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama`, `email`, `password`) VALUES
(1, 'Udin', 'udin@gmail.com', '$2y$10$uCoQzrqvuz5REt5IZgltF.vp.uFkXigmxzAWUgGM5ICInnqvzsPCq'),
(2, 'tes', 'tes@gmail.com', '$2y$10$UsN8XAALKk9oDwB2yZbSN.vOMSGScScmktHuIox7QsrlemEGvSVXm'),
(3, 'Dinda', 'dinda12345@gmail.com', '$2y$10$dK.7Kc7KSeTgxshjvhE/iuEHLB9ibsV3Q09NrZSXGmxESPUcX0njm');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peringkat`
--

CREATE TABLE `peringkat` (
  `id_peringkat` int(11) NOT NULL,
  `kandungan_id` int(11) NOT NULL,
  `pengguna_id` int(11) NOT NULL,
  `nilai_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `peringkat`
--

INSERT INTO `peringkat` (`id_peringkat`, `kandungan_id`, `pengguna_id`, `nilai_total`) VALUES
(17, 1, 1, 5),
(18, 2, 1, 3.15),
(19, 3, 1, 2.95),
(20, 4, 1, 2.3),
(21, 5, 1, 2.35),
(22, 6, 1, 3.55),
(23, 7, 1, 2.875),
(24, 8, 1, 3.775),
(97, 1, 2, 3.45),
(98, 2, 2, 4.525),
(99, 3, 2, 4.25),
(100, 4, 2, 2.975),
(101, 5, 2, 3.725),
(102, 6, 2, 3.525),
(103, 7, 2, 1.625),
(104, 8, 2, 3.45),
(129, 1, 3, 2.6),
(130, 2, 3, 3.275),
(131, 3, 3, 3.4),
(132, 4, 3, 4.45),
(133, 5, 3, 3.175),
(134, 6, 3, 3.425),
(135, 7, 3, 3.7),
(136, 8, 3, 3.125);

-- --------------------------------------------------------

--
-- Struktur dari tabel `preferensi_pengguna`
--

CREATE TABLE `preferensi_pengguna` (
  `id_preferensi` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `profil_jenis_kulit` int(11) NOT NULL,
  `profil_masalah_kulit` int(11) NOT NULL,
  `profil_reaksi_alergi` int(11) NOT NULL,
  `profil_aktivitas_pengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `preferensi_pengguna`
--

INSERT INTO `preferensi_pengguna` (`id_preferensi`, `id_pengguna`, `profil_jenis_kulit`, `profil_masalah_kulit`, `profil_reaksi_alergi`, `profil_aktivitas_pengguna`) VALUES
(4, 1, 10, 15, 20, 25),
(5, 2, 6, 15, 20, 24),
(6, 3, 8, 11, 20, 23);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nilai` int(11) NOT NULL,
  `kriteria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `nama`, `nilai`, `kriteria_id`) VALUES
(6, 'Normal', 1, 1),
(7, 'Kombinasi', 2, 1),
(8, 'Berminyak', 3, 1),
(9, 'Kering', 4, 1),
(10, 'Sensitif', 5, 1),
(11, 'Tidak ada masalah', 1, 2),
(12, 'Flek hitam/Hiperpigmentasi', 2, 2),
(13, 'Penuaan/Keriput', 3, 2),
(14, 'Jerawat', 4, 2),
(15, 'Kemerahan/Iritasi', 5, 2),
(16, 'Tidak ada alergi', 1, 3),
(17, 'Alergi terhadap pelembap tertentu', 2, 3),
(18, 'Alergi terhadap alkohol', 3, 3),
(19, 'Alergi terhadap parfum', 4, 3),
(20, 'Alergi terhadap pengawet', 5, 3),
(21, 'Selalu di dalam ruangan tanpa paparan langsung ', 1, 4),
(22, 'Mayoritas di dalam ruangan dengan paparan tidak langsung\r\n', 2, 4),
(23, 'Kombinasi (di dalam & di luar ruangan seimbang)', 3, 4),
(24, 'Sering beraktivitas di luar ruangan ', 4, 4),
(25, 'Aktivitas tinggi di luar ruangan ', 5, 4);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kandungan_sunscreen`
--
ALTER TABLE `kandungan_sunscreen`
  ADD PRIMARY KEY (`id_kandungan`),
  ADD KEY `id_kandungan` (`kriteria_jenis_kulit`,`kriteria_masalah_kulit`,`kriteria_reaksi_alergi`,`kriteria_aktivitas_pengguna`) USING BTREE,
  ADD KEY `kriteria_masalah_kulit` (`kriteria_masalah_kulit`),
  ADD KEY `kriteria_reaksi_alergi` (`kriteria_reaksi_alergi`),
  ADD KEY `kriteria_aktivitas_pengguna` (`kriteria_aktivitas_pengguna`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `pembobotan`
--
ALTER TABLE `pembobotan`
  ADD PRIMARY KEY (`id_bobot`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `peringkat`
--
ALTER TABLE `peringkat`
  ADD PRIMARY KEY (`id_peringkat`),
  ADD KEY `kandungan_id` (`kandungan_id`),
  ADD KEY `pengguna_id` (`pengguna_id`);

--
-- Indeks untuk tabel `preferensi_pengguna`
--
ALTER TABLE `preferensi_pengguna`
  ADD PRIMARY KEY (`id_preferensi`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `profil_jenis_kulit` (`profil_jenis_kulit`),
  ADD KEY `profil_masalah_kulit` (`profil_masalah_kulit`),
  ADD KEY `profil_reaksi_alergi` (`profil_reaksi_alergi`),
  ADD KEY `profil_aktivitas_pengguna` (`profil_aktivitas_pengguna`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `kriteria_id` (`kriteria_id`) USING BTREE;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kandungan_sunscreen`
--
ALTER TABLE `kandungan_sunscreen`
  MODIFY `id_kandungan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `peringkat`
--
ALTER TABLE `peringkat`
  MODIFY `id_peringkat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT untuk tabel `preferensi_pengguna`
--
ALTER TABLE `preferensi_pengguna`
  MODIFY `id_preferensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kandungan_sunscreen`
--
ALTER TABLE `kandungan_sunscreen`
  ADD CONSTRAINT `kandungan_sunscreen_ibfk_1` FOREIGN KEY (`kriteria_jenis_kulit`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `kandungan_sunscreen_ibfk_2` FOREIGN KEY (`kriteria_masalah_kulit`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `kandungan_sunscreen_ibfk_3` FOREIGN KEY (`kriteria_reaksi_alergi`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `kandungan_sunscreen_ibfk_4` FOREIGN KEY (`kriteria_aktivitas_pengguna`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `peringkat`
--
ALTER TABLE `peringkat`
  ADD CONSTRAINT `peringkat_ibfk_1` FOREIGN KEY (`kandungan_id`) REFERENCES `kandungan_sunscreen` (`id_kandungan`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `peringkat_ibfk_2` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `preferensi_pengguna`
--
ALTER TABLE `preferensi_pengguna`
  ADD CONSTRAINT `preferensi_pengguna_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `preferensi_pengguna_ibfk_2` FOREIGN KEY (`profil_jenis_kulit`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `preferensi_pengguna_ibfk_3` FOREIGN KEY (`profil_masalah_kulit`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `preferensi_pengguna_ibfk_4` FOREIGN KEY (`profil_reaksi_alergi`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `preferensi_pengguna_ibfk_5` FOREIGN KEY (`profil_aktivitas_pengguna`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
