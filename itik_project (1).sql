-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Bulan Mei 2026 pada 04.24
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
-- Database: `itik_project`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_lengkap`, `username`, `password`) VALUES
(1, 'Santoso budi', 'adminn', 'admin123\r\n'),
(2, 'Haho Haho', 'haho', 'haho123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `history_pelanggan`
--

CREATE TABLE `history_pelanggan` (
  `id_historyPelanggan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `kuantitas_pesanan` int(11) DEFAULT NULL,
  `harga_perproduk` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `metode_pengiriman` varchar(50) NOT NULL,
  `alamat_pengiriman` text DEFAULT NULL,
  `biaya_ongkir` int(11) DEFAULT 0,
  `status_pesanan` varchar(20) DEFAULT 'Pending',
  `waktu_transaksi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `history_pelanggan`
--

INSERT INTO `history_pelanggan` (`id_historyPelanggan`, `id_pelanggan`, `id_pesanan`, `id_produk`, `kuantitas_pesanan`, `harga_perproduk`, `subtotal`, `metode_pengiriman`, `alamat_pengiriman`, `biaya_ongkir`, `status_pesanan`, `waktu_transaksi`) VALUES
(28, 1, 74, 4, 1, 60000.00, 85000.00, 'Kirim ke Alamat', 'Jl kurtis, Denpasar, Bali', 25000, 'Pending', '2026-05-15 12:29:48'),
(29, 1, 75, 6, 3, 15000.00, 55000.00, 'Kirim ke Alamat', 'Jl kertajaya sebelah sungai prindapan, Jember, Jawa Timur', 10000, 'Pending', '2026-05-15 12:43:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat_lengkap` text DEFAULT NULL,
  `role` varchar(20) DEFAULT 'pelanggan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_lengkap`, `username`, `password`, `no_hp`, `email`, `alamat_lengkap`, `role`) VALUES
(1, 'GEOVANNY HUGO ARIFIN', 'van', '$2y$10$5UPuDbnuagLdAUuLSKgIu.5EvnmHfPzTsgpdprDHVg2lQvxiNKfmC', '0891221', 'yovanarifin05@gmail.com', 'Jember', 'pelanggan'),
(3, 'Krisna Tri Novan', 'kris', '$2y$10$kRMBw0cnMr5BY8zlfNGNtOpNHHP1Npb7ERzywol4ZdYsledp7suKS', '085678913340', 'krisna123@gmail.com', 'Jl situbondo ', 'pelanggan'),
(4, '1290812', 'jiawd', '$2y$10$dH5g.CW8rFFMWc0TWqV4Xu5g2FyJGWfOv7LbSMliad6QpNokZGTCi', '9091209', 'yawdw120@gmail.com', 'mkamwdaw', 'pelanggan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `ukuran` varchar(50) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `metode_pengiriman` varchar(50) NOT NULL,
  `provinsi` varchar(50) DEFAULT NULL,
  `kabupaten` varchar(50) DEFAULT NULL,
  `alamat_lengkap` text DEFAULT NULL,
  `biaya_ongkir` int(11) DEFAULT 0,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `tanggal_pesanan` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','Diterima','Diantar') DEFAULT 'Pending',
  `waktu_transaksi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_pelanggan`, `id_produk`, `nama_produk`, `ukuran`, `harga_satuan`, `jumlah`, `total_harga`, `metode_pembayaran`, `metode_pengiriman`, `provinsi`, `kabupaten`, `alamat_lengkap`, `biaya_ongkir`, `bukti_pembayaran`, `tanggal_pesanan`, `status`, `waktu_transaksi`) VALUES
(74, 1, 4, 'Telur Bebek Segar', '3kg', 60000, 1, 85000, 'COD', 'Kirim ke Alamat', 'Bali', 'Denpasar', 'Jl kurtis', 25000, '', '2026-05-15 19:29:48', 'Diterima', '2026-05-15 12:29:48'),
(75, 1, 6, 'Usus Bebek', '1.3kg', 15000, 3, 55000, 'Transfer Bank', 'Kirim ke Alamat', 'Jawa Timur', 'Jember', 'Jl kertajaya sebelah sungai prindapan', 10000, '6a07150ce266d.png', '2026-05-15 19:43:56', 'Diterima', '2026-05-15 12:43:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_perProduk` decimal(10,2) NOT NULL,
  `berat_produk` text NOT NULL,
  `stok_tersedia` enum('tersedia','habis') DEFAULT 'tersedia',
  `deskripsi` text NOT NULL,
  `foto_produk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga_perProduk`, `berat_produk`, `stok_tersedia`, `deskripsi`, `foto_produk`) VALUES
(4, 'Telur Bebek Segar', 5000.00, '1kg(10000), 1.5kg(15000) , 2kg(25000), 3kg(60000)', 'tersedia', 'Telur dengan kualitas terbaik serta dapat disajikan dengan berbagai jenis makanan', 'pictures/Gemini_Generated_Image_7w814o7w814o7w81.png'),
(5, 'Daging Bebek', 0.00, '0.6kg(10000), 1kg(15000), 2kg(25000), 3kg(35000)', 'habis', 'Daging bebek utuh dengan kualitas terbaik dari peternakan kami serta cocok untuk dijadikan bisnis atau masakan rumah  ', 'pictures/1777416673_daging itik utuh.png'),
(6, 'Usus Bebek', 0.00, '1kg(13000), 1.3kg(15000), 1.7kg(25000), 2kg(40000), 5kg(80000), 6kg(100000)', 'tersedia', 'usus dengan kualitas terbaik dari peternakan kami bisa diolah untuk makanan ringan maupun berat', 'pictures/1778827864_Gemini_Generated_Image_92j40r92j40r92j4.png'),
(7, 'Rempelo Ati', 0.00, '1kg(12000), 1.5kg(17000), 2kg(25000), 5kg(200000)', 'tersedia', 'Rempelo ati dengan kualitas terbaik dari peternakan kami,bisa dijadikan bahan olahan rumahan atau usaha anda', 'pictures/1777627948_Gemini_Generated_Image_3jkaum3jkaum3jka.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `rating` int(1) DEFAULT NULL,
  `pesan` text NOT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `balasan_admin` text DEFAULT NULL,
  `tanggal_ulasan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `id_pelanggan`, `rating`, `pesan`, `foto_bukti`, `id_admin`, `balasan_admin`, `tanggal_ulasan`) VALUES
(13, 3, 2, 'bagus\r\n', '', NULL, NULL, '2026-05-14 15:48:44'),
(14, 0, 2, 'sip\r\n', '', NULL, NULL, '2026-05-14 15:49:56'),
(16, 1, 4, 'nah', '', NULL, NULL, '2026-05-14 16:02:22'),
(17, 1, 2, 'awda', '', NULL, NULL, '2026-05-14 16:03:05'),
(18, 1, 2, 'nah', '', 1, 'siap kak', '2026-05-14 16:04:14'),
(19, 1, 2, 'bagus tpi ada kekurangan', '', 1, 'apa itu?', '2026-05-15 13:01:03'),
(21, NULL, 3, 'cocok', '', 1, 'makasi', '2026-05-15 14:13:42'),
(22, 1, 4, 'yoi', '', 1, 'ooh oke', '2026-05-15 14:17:25'),
(23, NULL, 5, 'Saya akan kembali kesini karna produk serta pelayanannya baik semua', '', 1, 'terima kasih kak', '2026-05-15 14:48:12'),
(24, 1, 5, 'sangat baik dan sungguh-sungguh', '', 1, 'siap kak terima kasih penilaiannya', '2026-05-15 14:48:54');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `history_pelanggan`
--
ALTER TABLE `history_pelanggan`
  ADD PRIMARY KEY (`id_historyPelanggan`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `fk_id_produk` (`id_produk`),
  ADD KEY `fk_pesanan_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `fk_ulasan_admin` (`id_admin`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `history_pelanggan`
--
ALTER TABLE `history_pelanggan`
  MODIFY `id_historyPelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `history_pelanggan`
--
ALTER TABLE `history_pelanggan`
  ADD CONSTRAINT `fk_id_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `history_pelanggan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `history_pelanggan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_id_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pesanan_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `fk_ulasan_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
