-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jul 2024 pada 12.27
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kip2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('devoperator@gmail.com|127.0.0.1', 'i:1;', 1721634950),
('devoperator@gmail.com|127.0.0.1:timer', 'i:1721634950;', 1721634950);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2024_03_25_030544_create_failed_jobs_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('dev@gmail.com', '$2y$12$vbOM5kwUqPwCgaHwcJx9dOu09HzUQi7KH13uj7OQf3sgFNjBcX/o6', '2024-07-18 05:02:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id` int(11) NOT NULL,
  `nik` varchar(100) NOT NULL,
  `id_seleksi` int(11) DEFAULT NULL,
  `id_tahun_penerimaan` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `status_pencairan` varchar(100) DEFAULT NULL,
  `bukti_pencairan` varchar(200) DEFAULT NULL,
  `no_kip` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengajuan`
--

INSERT INTO `pengajuan` (`id`, `nik`, `id_seleksi`, `id_tahun_penerimaan`, `status`, `status_pencairan`, `bukti_pencairan`, `no_kip`, `created_at`, `updated_at`) VALUES
(12, '2321333', 15, 7, 'Ditolak', NULL, '', NULL, '2024-07-22 02:00:03', '2024-07-22 02:03:15'),
(13, '4321321', 14, 7, 'Menunggu', NULL, '', NULL, '2024-07-22 02:09:51', '2024-07-22 02:10:12'),
(14, '4321322', 14, 7, 'Menunggu', NULL, '', NULL, '2024-07-22 02:10:01', '2024-07-22 02:10:21'),
(15, '4321333', 14, 9, 'Menunggu', NULL, '', NULL, '2024-07-22 02:10:40', '2024-07-22 02:10:49'),
(16, '2321321', 14, 7, 'Menunggu', NULL, '', NULL, '2024-07-22 02:15:23', '2024-07-22 02:15:32'),
(17, '2321322', 14, 10, 'Diterima', 'sudah', '1722073842.jpg', '05927662', '2024-07-27 01:54:00', '2024-07-27 02:50:42'),
(18, '34322', 14, 9, 'Diterima', 'sudah', '1722075954.jpg', '04311782', '2024-07-27 03:18:41', '2024-07-27 03:25:54'),
(19, '31122', 15, 9, 'Diterima', 'belum', NULL, '44408257', '2024-07-27 03:19:08', '2024-07-27 03:20:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perguruan_tinggi`
--

CREATE TABLE `perguruan_tinggi` (
  `kode_pt` int(11) NOT NULL,
  `nama_pt` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `perguruan_tinggi`
--

INSERT INTO `perguruan_tinggi` (`kode_pt`, `nama_pt`, `created_at`, `updated_at`) VALUES
(3333, 'Universitas Lampung', '2024-07-22 01:22:21', '2024-07-22 01:22:21'),
(11111, 'Universitas Sriwijaya', '2024-07-22 01:20:58', '2024-07-22 01:27:38'),
(22222, 'Universitas Bina Darma', '2024-07-22 01:21:42', '2024-07-22 01:27:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peserta`
--

CREATE TABLE `peserta` (
  `nik` varchar(50) NOT NULL,
  `kode_pt` int(11) DEFAULT NULL,
  `kode_prodi` int(11) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `no_rekening` varchar(150) DEFAULT NULL,
  `nisn` varchar(50) NOT NULL,
  `npsn` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `no_kk` varchar(50) NOT NULL,
  `nama_mahasiswa` varchar(200) NOT NULL,
  `tempat_lahir` varchar(200) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `no_kks` varchar(50) NOT NULL,
  `asal_sekolah` varchar(100) NOT NULL,
  `kab_kota_sekolah` varchar(100) NOT NULL,
  `prov_sekolah` varchar(100) NOT NULL,
  `nama_ayah` varchar(200) NOT NULL,
  `pekerjaan_ayah` varchar(100) NOT NULL,
  `penghasilan_ayah` varchar(50) NOT NULL,
  `status_ayah` varchar(50) NOT NULL,
  `nama_ibu` varchar(200) NOT NULL,
  `pekerjaan_ibu` varchar(100) NOT NULL,
  `penghasilan_ibu` varchar(50) NOT NULL,
  `status_ibu` varchar(50) NOT NULL,
  `jumlah_tanggungan` int(11) NOT NULL,
  `kepemilikan_rumah` varchar(50) NOT NULL,
  `tahun_perolehan_rumah` year(4) NOT NULL,
  `sumber_listrik` varchar(50) NOT NULL,
  `luas_tanah` int(11) NOT NULL,
  `luas_bangunan` int(11) NOT NULL,
  `sumber_air` varchar(50) NOT NULL,
  `mck` varchar(10) NOT NULL,
  `jarak_pusat_kota_km` int(11) NOT NULL,
  `program_studi` varchar(100) DEFAULT NULL,
  `perguruan_tinggi` varchar(100) DEFAULT NULL,
  `kategori_mahasiswa_penerima` varchar(100) DEFAULT NULL,
  `bank_penyalur` varchar(100) DEFAULT NULL,
  `no_sk_surat_Ajukan` varchar(100) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `keterangan_tambahan` varchar(100) DEFAULT NULL,
  `scan_surat_ajukan_jpg` varchar(255) DEFAULT NULL,
  `scan_surat_ajukan_pdf` varchar(255) DEFAULT NULL,
  `nama_bank_pt` varchar(100) DEFAULT NULL,
  `no_rekening_pt` varchar(100) DEFAULT NULL,
  `rekening_pt_atas_nama` varchar(100) DEFAULT NULL,
  `scan_sptjm_pdf` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `peserta`
--

INSERT INTO `peserta` (`nik`, `kode_pt`, `kode_prodi`, `status`, `bank`, `no_rekening`, `nisn`, `npsn`, `email`, `nim`, `no_kk`, `nama_mahasiswa`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `no_hp`, `no_kks`, `asal_sekolah`, `kab_kota_sekolah`, `prov_sekolah`, `nama_ayah`, `pekerjaan_ayah`, `penghasilan_ayah`, `status_ayah`, `nama_ibu`, `pekerjaan_ibu`, `penghasilan_ibu`, `status_ibu`, `jumlah_tanggungan`, `kepemilikan_rumah`, `tahun_perolehan_rumah`, `sumber_listrik`, `luas_tanah`, `luas_bangunan`, `sumber_air`, `mck`, `jarak_pusat_kota_km`, `program_studi`, `perguruan_tinggi`, `kategori_mahasiswa_penerima`, `bank_penyalur`, `no_sk_surat_Ajukan`, `tanggal_surat`, `keterangan_tambahan`, `scan_surat_ajukan_jpg`, `scan_surat_ajukan_pdf`, `nama_bank_pt`, `no_rekening_pt`, `rekening_pt_atas_nama`, `scan_sptjm_pdf`, `created_at`, `updated_at`) VALUES
('1021333', 22222, 1111, 'Aktif', '', '', '1231231', '1313131', 'arab@gmail.com', '2122121211', '1131321313', 'Vanda4', 'palembang', '2003-11-22', 'L', 'wadawdwadad', '103182321893', '1313131', 'negeri', 'dadadaaa', 'sumatera', 'Daniel', 'pns', '1000000', 'Hidup', 'ayu', 'pns', '1000000', 'Hidup', 1000000, '121212111', 2000, 'listrik', 1111, 1111, 'asdsadasdaa', 'addadadaaa', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-22 22:55:02', '2024-07-22 22:55:02'),
('1121333', 22222, 1111, 'Aktif', '', '', '1231231', '1313131', 'arab@gmail.com', '2122121211', '1131321313', 'Vanda5', 'palembang', '2004-01-02', 'L', 'wadawdwadad', '103182321893', '1313131', 'negeri', 'dadadaaa', 'sumatera', 'Daniel', 'pns', '1000000', 'Hidup', 'ayu', 'pns', '1000000', 'Hidup', 1000000, '121212111', 2000, 'listrik', 1111, 1111, 'asdsadasdaa', 'addadadaaa', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-22 22:55:02', '2024-07-22 22:55:02'),
('12323', 22222, 1111, 'Aktif', 'BRI', '34234234234', '423423', '324343', 'dev@gmail.com', '534543', '435345', 'Devano1', 'sidoarjo', '2003-11-22', 'Laki-laki', 'Sidoarjo', '5345', '35435', 'Ada', 'ada', 'ada', 'sd', 'ads', '324', 'asd', 'asdsd', 'dfdsf', '324324', 'sdfdsf', 3, 'sdfsdf', 2001, 'sad', 23, 123, 'sumur', '123', 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-27 03:15:28', '2024-07-27 03:15:28'),
('2321321', 22222, 1111, 'Aktif', '', '', '1231231', '1313131', 'arab@gmail.com', '2122121211', '1131321313', 'Aprilia', 'palembang', '2024-06-05', 'L', 'wadawdwadad', '103182321893', '1313131', 'negeri', 'dadadaaa', 'sumatera', 'Yudo', 'pns', '1000000', 'Hidup', 'ayu', 'pns', '1000000', 'Hidup', 1000000, '121212111', 2000, 'listrik', 1111, 1111, 'asdsadasdaa', 'addadadaaa', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-22 01:51:29', '2024-07-22 02:11:38'),
('2321322', 22222, 1112, 'Aktif', '', '', '1231231', '1313131', 'arab@gmail.com', '2122121211', '1131321313', 'Sahara', 'palembang', '2024-06-05', 'L', 'wadawdwadad', '103182321893', '1313131', 'negeri', 'dadadaaa', 'sumatera', 'Andin', 'pns', '1000000', 'Hidup', 'ayu', 'pns', '1000000', 'Hidup', 1000000, '121212111', 2000, 'listrik', 1111, 1111, 'asdsadasdaa', 'addadadaaa', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-22 01:51:29', '2024-07-22 01:51:29'),
('2321333', 22222, 1111, 'Aktif', '', '', '1231231', '1313131', 'arab@gmail.com', '2122121211', '1131321313', 'Vanda', 'palembang', '2024-06-05', 'L', 'wadawdwadad', '103182321893', '1313131', 'negeri', 'dadadaaa', 'sumatera', 'Daniel', 'pns', '1000000', 'Hidup', 'ayu', 'pns', '1000000', 'Hidup', 1000000, '121212111', 2000, 'listrik', 1111, 1111, 'asdsadasdaa', 'addadadaaa', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-22 01:51:29', '2024-07-22 01:51:29'),
('31122', 22222, 1111, 'Aktif', 'BRI', '34234234234', '423423', '324343', 'dev@gmail.com', '534543', '435345', 'Fira2', 'sidoarjo', '2003-11-22', 'Laki-laki', 'Sidoarjo', '5345', '35435', 'Ada', 'ada', 'ada', 'sd', 'ads', '324', 'asd', 'asdsd', 'dfdsf', '324324', 'sdfdsf', 3, 'sdfsdf', 2001, 'sad', 23, 123, 'sumur', '123', 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-27 03:17:59', '2024-07-27 03:17:59'),
('32433', 22222, 1111, 'Aktif', 'BRI', '34234234234', '423423', '324343', 'dev@gmail.com', '534543', '435345', 'Devano2', 'sidoarjo', '2003-02-01', 'Laki-laki', 'Sidoarjo', '5345', '35435', 'Ada', 'ada', 'ada', 'sd', 'ads', '324', 'asd', 'asdsd', 'dfdsf', '324324', 'sdfdsf', 3, 'sdfsdf', 2001, 'sad', 23, 123, 'sumur', '123', 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-27 03:15:28', '2024-07-27 03:15:28'),
('34322', 22222, 1111, 'Aktif', 'BRI', '34234234234', '423423', '324343', 'dev@gmail.com', '534543', '435345', 'Fira1', 'sidoarjo', '2003-11-22', 'Laki-laki', 'Sidoarjo', '5345', '35435', 'Ada', 'ada', 'ada', 'sd', 'ads', '324', 'asd', 'asdsd', 'dfdsf', '324324', 'sdfdsf', 3, 'sdfsdf', 2001, 'sad', 23, 123, 'sumur', '123', 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-27 03:17:59', '2024-07-27 03:17:59'),
('4321321', 11111, 1113, 'Aktif', '', '', '1231231', '1313131', 'arab@gmail.com', '2122121211', '1131321313', 'Yudi', 'palembang', '2024-06-05', 'L', 'wadawdwadad', '103182321893', '1313131', 'negeri', 'dadadaaa', 'sumatera', 'Yudo', 'pns', '1000000', 'Hidup', 'ayu', 'pns', '1000000', 'Hidup', 1000000, '121212111', 2000, 'listrik', 1111, 1111, 'asdsadasdaa', 'addadadaaa', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-22 02:09:30', '2024-07-22 02:09:30'),
('4321322', 11111, 1114, 'Aktif', '', '', '1231231', '1313131', 'arab@gmail.com', '2122121211', '1131321313', 'Sari', 'palembang', '2024-06-05', 'L', 'wadawdwadad', '103182321893', '1313131', 'negeri', 'dadadaaa', 'sumatera', 'Andin', 'pns', '1000000', 'Hidup', 'ayu', 'pns', '1000000', 'Hidup', 1000000, '121212111', 2000, 'listrik', 1111, 1111, 'asdsadasdaa', 'addadadaaa', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-22 02:09:30', '2024-07-22 02:09:30'),
('4321333', 11111, 1113, 'Aktif', '', '', '1231231', '1313131', 'arab@gmail.com', '2122121211', '1131321313', 'Fira', 'palembang', '2024-06-05', 'L', 'wadawdwadad', '103182321893', '1313131', 'negeri', 'dadadaaa', 'sumatera', 'Daniel', 'pns', '1000000', 'Hidup', 'ayu', 'pns', '1000000', 'Hidup', 1000000, '121212111', 2000, 'listrik', 1111, 1111, 'asdsadasdaa', 'addadadaaa', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-22 02:09:30', '2024-07-22 02:09:30'),
('7321333', 22222, 1111, 'Aktif', '', '', '1231231', '1313131', 'arab@gmail.com', '2122121211', '1131321313', 'Vanda2', 'palembang', '2024-06-05', 'L', 'wadawdwadad', '103182321893', '1313131', 'negeri', 'dadadaaa', 'sumatera', 'Daniel', 'pns', '1000000', 'Hidup', 'ayu', 'pns', '1000000', 'Hidup', 1000000, '121212111', 2000, 'listrik', 1111, 1111, 'asdsadasdaa', 'addadadaaa', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-22 22:18:42', '2024-07-22 22:18:42'),
('8321333', 22222, 1111, 'Aktif', '', '', '1231231', '1313131', 'arab@gmail.com', '2122121211', '1131321313', 'Vanda3', 'palembang', '2024-06-05', 'L', 'wadawdwadad', '103182321893', '1313131', 'negeri', 'dadadaaa', 'sumatera', 'Daniel', 'pns', '1000000', 'Hidup', 'ayu', 'pns', '1000000', 'Hidup', 1000000, '121212111', 2000, 'listrik', 1111, 1111, 'asdsadasdaa', 'addadadaaa', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-22 22:20:12', '2024-07-22 22:20:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `program_studi`
--

CREATE TABLE `program_studi` (
  `kode_prodi` int(11) NOT NULL,
  `kode_pt` int(11) DEFAULT NULL,
  `nama` varchar(200) NOT NULL,
  `akreditasi_prodi` char(5) NOT NULL,
  `ukt_spp` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `program_studi`
--

INSERT INTO `program_studi` (`kode_prodi`, `kode_pt`, `nama`, `akreditasi_prodi`, `ukt_spp`, `created_at`, `updated_at`) VALUES
(1111, 22222, 'Informatika', 'A', 3000000, '2024-07-22 01:35:57', '2024-07-22 01:35:57'),
(1112, 22222, 'Sistem Informasi', 'B', 5000000, '2024-07-22 01:36:26', '2024-07-22 01:36:51'),
(1113, 11111, 'Akuntansi', 'A', 5000000, '2024-07-22 02:07:44', '2024-07-22 02:07:44'),
(1114, 11111, 'Manajemen', 'B', 4000000, '2024-07-22 02:08:27', '2024-07-22 02:08:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `nama`) VALUES
(1, 'operator'),
(2, 'superadmin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `seleksi`
--

CREATE TABLE `seleksi` (
  `id` int(11) NOT NULL,
  `seleksi_penetapan` varchar(100) NOT NULL,
  `ranking_penetapan` int(11) NOT NULL,
  `kategori_penetapan` varchar(100) NOT NULL,
  `skema_bantuan_pembiayaan` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `seleksi`
--

INSERT INTO `seleksi` (`id`, `seleksi_penetapan`, `ranking_penetapan`, `kategori_penetapan`, `skema_bantuan_pembiayaan`, `created_at`, `updated_at`) VALUES
(14, 'Kategori A', 2, 'Kategori A', 5000000, '2024-07-22 01:28:45', '2024-07-22 01:28:45'),
(15, 'Kategori B', 1, 'Kategori B', 6000000, '2024-07-22 01:29:24', '2024-07-22 01:29:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bPQDhvQmX8cxQjHB5X9ucAKpDdOvKn0waa7KrgKa', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiU3VaRVhqeDdzV0xzcFA3elJza2dlZ1BBNDBFeUJTblNoZXNoUmh5TCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1722069793),
('v9yrgRWmT1Mwk8mIeuq3PiMLdx5wJAJy03PbwO1d', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibEpkOFVkeVZoY0U5aXA0Tnl3Z1p3VzlvNzc0VXdXYzVDMThrdFJ0cyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW5jYWlyYW4vZGV0YWlsLzM0MzIyLzkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3MjIwNzEzNTA7fX0=', 1722075975),
('ySBI15XNncOdeXivyf8QQiwFa6quILrUoasfWhom', 19, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTnlLMkV4dUpkV0FKemZmMEM3ZGNHNnpSajQzb1dQTFNrOFNoaDA2RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW5jYWlyYW4vZGV0YWlsLzM0MzIyLzkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxOTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3MjIwNzAzMTY7fX0=', 1722076013);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_penerimaan`
--

CREATE TABLE `tahun_penerimaan` (
  `id` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_dibuka` date NOT NULL,
  `tanggal_ditutup` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tahun_penerimaan`
--

INSERT INTO `tahun_penerimaan` (`id`, `tahun`, `deskripsi`, `tanggal_dibuka`, `tanggal_ditutup`, `created_at`, `updated_at`) VALUES
(7, 2021, 'Mahasiswa Penerima KIP Tahun 2021', '2021-01-22', '2024-08-09', '2024-07-22 01:30:50', '2024-07-22 01:59:01'),
(8, 2022, 'Mahasiswa Penerima KIP Tahun 2022', '2022-01-22', '2022-12-22', '2024-07-22 01:31:49', '2024-07-22 01:31:49'),
(9, 2023, 'Mahasiswa Penerima KIP Tahun 2023', '2023-02-09', '2024-08-10', '2024-07-22 01:32:24', '2024-07-22 01:32:24'),
(10, 2024, 'Mahasiswa Penerima KIP Tahun 2024', '2024-07-15', '2024-08-10', '2024-07-22 01:32:49', '2024-07-22 01:32:49'),
(11, 2025, 'Mahasiswa Penerima KIP Tahun 2025', '2025-01-22', '2025-12-30', '2024-07-22 01:33:22', '2024-07-22 01:33:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_role` int(11) DEFAULT NULL,
  `kode_pt` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_role`, `kode_pt`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(15, 2, NULL, 'admin', 'admin@gmail.com', NULL, '$2y$12$nS5rH/AyBhJhx2fWG0dTquiA0wdL9ljtLwVabiHrtmvWlFhNA.vN2', NULL, '2024-07-20 00:49:29', '2024-07-22 00:59:29'),
(19, 1, 22222, 'binaoperator', 'binaoperator@gmail.com', NULL, '$2y$12$7T7b/CCCktGV7pw/z6GA8u72bg7J60nXazLJd7si6GEFjfnpXiEwa', NULL, '2024-07-22 01:35:16', '2024-07-22 01:35:16'),
(20, 1, 11111, 'sriwijayaoperator', 'sriwijayaoperator@gmail.com', NULL, '$2y$12$VbZzAe6C.ZWFznc83vl3j.LgmlX3QM5AW8J2M9/nlZ1LrsXx5DSLy', NULL, '2024-07-22 02:05:45', '2024-07-22 02:05:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nik` (`nik`),
  ADD KEY `id_seleksi` (`id_seleksi`),
  ADD KEY `id_tahun_penerimaan` (`id_tahun_penerimaan`);

--
-- Indeks untuk tabel `perguruan_tinggi`
--
ALTER TABLE `perguruan_tinggi`
  ADD PRIMARY KEY (`kode_pt`);

--
-- Indeks untuk tabel `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `kode_pt` (`kode_pt`,`kode_prodi`),
  ADD KEY `id_prodi` (`kode_prodi`);

--
-- Indeks untuk tabel `program_studi`
--
ALTER TABLE `program_studi`
  ADD PRIMARY KEY (`kode_prodi`),
  ADD KEY `kode_pt` (`kode_pt`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `seleksi`
--
ALTER TABLE `seleksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tahun_penerimaan`
--
ALTER TABLE `tahun_penerimaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `kode_pt` (`kode_pt`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `seleksi`
--
ALTER TABLE `seleksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tahun_penerimaan`
--
ALTER TABLE `tahun_penerimaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD CONSTRAINT `pengajuan_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `peserta` (`nik`),
  ADD CONSTRAINT `pengajuan_ibfk_2` FOREIGN KEY (`id_seleksi`) REFERENCES `seleksi` (`id`),
  ADD CONSTRAINT `pengajuan_ibfk_3` FOREIGN KEY (`id_tahun_penerimaan`) REFERENCES `tahun_penerimaan` (`id`);

--
-- Ketidakleluasaan untuk tabel `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `peserta_ibfk_1` FOREIGN KEY (`kode_pt`) REFERENCES `perguruan_tinggi` (`kode_pt`),
  ADD CONSTRAINT `peserta_ibfk_2` FOREIGN KEY (`kode_prodi`) REFERENCES `program_studi` (`kode_prodi`);

--
-- Ketidakleluasaan untuk tabel `program_studi`
--
ALTER TABLE `program_studi`
  ADD CONSTRAINT `program_studi_ibfk_1` FOREIGN KEY (`kode_pt`) REFERENCES `perguruan_tinggi` (`kode_pt`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`kode_pt`) REFERENCES `perguruan_tinggi` (`kode_pt`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
