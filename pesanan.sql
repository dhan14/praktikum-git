-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Apr 2021 pada 17.32
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pesanan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesan`
--

CREATE TABLE `detail_pesan` (
  `id_pesan` int(5) NOT NULL,
  `id_detail_pesan` int(5) NOT NULL,
  `id_produk` int(5) NOT NULL,
  `jumlah` int(50) NOT NULL,
  `harga` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_pesan`
--

INSERT INTO `detail_pesan` (`id_pesan`, `id_detail_pesan`, `id_produk`, `jumlah`, `harga`) VALUES
(99121, 1, 34341, 10, 'Rp 150.000'),
(99122, 2, 34342, 10, 'Rp 550.000'),
(99123, 3, 34343, 10, 'Rp 450.000'),
(99125, 4, 34344, 10, 'Rp 300.000'),
(99125, 5, 34345, 10, 'Rp 200.000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `faktur`
--

CREATE TABLE `faktur` (
  `id_faktur` int(5) NOT NULL,
  `tgl_faktur` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `faktur`
--

INSERT INTO `faktur` (`id_faktur`, `tgl_faktur`) VALUES
(11111, '2021-03-25'),
(11112, '2021-04-15'),
(11113, '2021-03-02'),
(11114, '2021-03-21'),
(11115, '2021-04-25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kuitansi`
--

CREATE TABLE `kuitansi` (
  `id_kuitansi` int(5) NOT NULL,
  `tgl_kuitansi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kuitansi`
--

INSERT INTO `kuitansi` (`id_kuitansi`, `tgl_kuitansi`) VALUES
(45450, '2021-03-24'),
(45451, '2021-04-14'),
(45452, '2021-04-01'),
(45453, '2021-03-20'),
(45454, '2021-04-23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(10) NOT NULL,
  `nama_pelanggan` varchar(20) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `telepon` int(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `telepon`, `email`, `tgl_lahir`) VALUES
(1230, 'Natalya Br Sidauruk', 'Jl Satria Manis No 900', 812345670, 'natalyasidauruk@gmail.com', '2001-12-26'),
(1231, 'Nur Raisa', 'Jl Kemoncol Kuningan No 101', 812989753, 'nurraisaaa@gmail.com', '2000-05-28'),
(1232, 'Oktavia Manullang', 'Jl Manis Berseri No 81', 812873947, 'oktaviamanullang@gmail.com', '2001-10-18'),
(1234, 'Rachmatika Intan', 'Jl Kasih Kurang No 111', 822989811, 'rhamatikaintan@gmail.com', '2001-11-11'),
(1235, 'Satria Glori ', 'Jl Perdamaian Abadi No 921', 822314131, 'satriaglori@gmail.com', '2001-09-11'),
(1236, 'Michael', 'Jl Minat Kasih No 91', 812341211, 'michael@gmail.com', '2001-04-21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan`
--

CREATE TABLE `pesan` (
  `id_pesan` int(5) NOT NULL,
  `tgl_pesan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pesan`
--

INSERT INTO `pesan` (`id_pesan`, `tgl_pesan`) VALUES
(99121, '2021-03-22'),
(99122, '2021-04-11'),
(99123, '2021-03-29'),
(99124, '2021-03-17'),
(99125, '2021-04-21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(5) NOT NULL,
  `nama_produk` varchar(25) NOT NULL,
  `satuan` int(3) NOT NULL,
  `harga` varchar(20) NOT NULL,
  `stock` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `satuan`, `harga`, `stock`) VALUES
(34341, 'Celana Jeans', 30, 'Rp 150.000', 40),
(34342, 'Kabaya', 40, 'Rp 550.000', 30),
(34343, 'Jas', 50, 'Rp 450.000', 30),
(34344, 'Baju Dewasa', 60, 'Rp 300.000', 40),
(34345, 'Rok ', 70, 'Rp 200.000', 50);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_pesan`
--
ALTER TABLE `detail_pesan`
  ADD PRIMARY KEY (`id_detail_pesan`);

--
-- Indeks untuk tabel `faktur`
--
ALTER TABLE `faktur`
  ADD PRIMARY KEY (`id_faktur`);

--
-- Indeks untuk tabel `kuitansi`
--
ALTER TABLE `kuitansi`
  ADD PRIMARY KEY (`id_kuitansi`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_pesan`
--
ALTER TABLE `detail_pesan`
  MODIFY `id_detail_pesan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `faktur`
--
ALTER TABLE `faktur`
  MODIFY `id_faktur` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11116;

--
-- AUTO_INCREMENT untuk tabel `kuitansi`
--
ALTER TABLE `kuitansi`
  MODIFY `id_kuitansi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45455;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1237;

--
-- AUTO_INCREMENT untuk tabel `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99126;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34346;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
