-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 05 Jul 2026 pada 12.29
-- Versi server: 8.0.30
-- Versi PHP: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `db_pengaduan_fasilitas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Ruang Kelas', 'Pengaduan terkait fasilitas ruangan kelas', '2026-07-01 15:27:32', '2026-07-01 15:27:32'),
(2, 'Toilet', 'Pengaduan terkait fasilitas toilet', '2026-07-05 09:43:19', '2026-07-05 09:43:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `latitude` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `locations`
--

INSERT INTO `locations` (`id`, `name`, `address`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'Kelas VII', 'Kelas VII A', '', '', '2026-07-01 15:28:09', '2026-07-01 15:28:09'),
(2, 'Toilet', 'Toilet Lantai 1', '', '', '2026-07-05 09:44:03', '2026-07-05 09:44:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(10, '2026-07-01-142910', 'App\\Database\\Migrations\\CreateRolesTable', 'default', 'App', 1782916941, 1),
(11, '2026-07-01-142911', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1782916941, 1),
(12, '2026-07-01-142912', 'App\\Database\\Migrations\\CreateCategoriesTable', 'default', 'App', 1782916941, 1),
(13, '2026-07-01-142913', 'App\\Database\\Migrations\\CreateLocationsTable', 'default', 'App', 1782916941, 1),
(14, '2026-07-01-142914', 'App\\Database\\Migrations\\CreateReportsTable', 'default', 'App', 1782916941, 1),
(15, '2026-07-01-142915', 'App\\Database\\Migrations\\CreateReportPhotosTable', 'default', 'App', 1782916941, 1),
(16, '2026-07-01-142916', 'App\\Database\\Migrations\\CreateReportVotesTable', 'default', 'App', 1782916941, 1),
(17, '2026-07-01-142917', 'App\\Database\\Migrations\\CreateReportCommentsTable', 'default', 'App', 1782916942, 1),
(18, '2026-07-01-142918', 'App\\Database\\Migrations\\CreateReportStatusHistoriesTable', 'default', 'App', 1782916942, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `reports`
--

CREATE TABLE `reports` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu_verifikasi',
  `priority` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'sedang',
  `rejection_reason` text COLLATE utf8mb4_general_ci,
  `completed_note` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `category_id`, `location_id`, `assigned_to`, `title`, `description`, `status`, `priority`, `rejection_reason`, `completed_note`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 1, 4, 'Pintu Kelas Bolong', 'Pintu Kelas Bolong', 'selesai', 'sedang', NULL, 'Pintu kelas sudah di ganti', '2026-07-02 05:45:56', '2026-07-02 06:00:19'),
(2, 7, 1, 1, 4, 'Lampu nati', 'lampu perlu di ganti', 'selesai', 'tinggi', NULL, 'lampu sudah di ganti', '2026-07-02 13:50:50', '2026-07-05 09:50:21'),
(3, 6, 2, 2, 4, 'Pintu kamar mandi rusak', 'ada lebang yang cukup besar pada pintu toilet di lantai 1', 'selesai', 'tinggi', NULL, 'pintu toilet sudah di perbaiki', '2026-07-05 09:46:40', '2026-07-05 09:50:57'),
(4, 6, 1, 1, 4, 'genteng bocor', 'perlu di ganti', 'selesai', 'tinggi', NULL, 'sudah ganti\r\n', '2026-07-05 12:02:29', '2026-07-05 12:05:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `report_comments`
--

CREATE TABLE `report_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `report_comments`
--

INSERT INTO `report_comments` (`id`, `report_id`, `user_id`, `comment`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'perlu diganti', '2026-07-02 05:58:45', '2026-07-02 05:58:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `report_photos`
--

CREATE TABLE `report_photos` (
  `id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `report_photos`
--

INSERT INTO `report_photos` (`id`, `report_id`, `photo`, `created_at`, `updated_at`) VALUES
(1, 1, '1782971156_f9f2d6ead4817b1bca7e.png', '2026-07-02 05:45:56', '2026-07-02 05:45:56'),
(2, 2, '1783000250_f971604eb029e8ddf363.png', '2026-07-02 13:50:50', '2026-07-02 13:50:50'),
(3, 3, '1783244800_ff823bec017f142b932a.png', '2026-07-05 09:46:40', '2026-07-05 09:46:40'),
(4, 4, '1783252950_30da294a9670ed74822b.jpeg', '2026-07-05 12:02:30', '2026-07-05 12:02:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `report_status_histories`
--

CREATE TABLE `report_status_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `old_status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `new_status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `note` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `report_status_histories`
--

INSERT INTO `report_status_histories` (`id`, `report_id`, `user_id`, `old_status`, `new_status`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 6, NULL, 'menunggu_verifikasi', 'Laporan dibuat oleh pelapor.', '2026-07-02 05:45:56', '2026-07-02 05:45:56'),
(2, 1, 3, 'menunggu_verifikasi', 'diverifikasi', 'Laporan ditugaskan kepada petugas.', '2026-07-02 05:53:46', '2026-07-02 05:53:46'),
(3, 1, 4, 'diverifikasi', 'diproses', 'Laporan mulai diproses oleh petugas.', '2026-07-02 05:58:54', '2026-07-02 05:58:54'),
(4, 1, 4, 'diproses', 'selesai', 'Pintu kelas sudah di ganti', '2026-07-02 06:00:19', '2026-07-02 06:00:19'),
(5, 2, 7, NULL, 'menunggu_verifikasi', 'Laporan dibuat oleh pelapor.', '2026-07-02 13:50:50', '2026-07-02 13:50:50'),
(6, 2, 3, 'menunggu_verifikasi', 'diverifikasi', 'Laporan diverifikasi oleh admin.', '2026-07-02 13:57:46', '2026-07-02 13:57:46'),
(7, 2, 3, 'diverifikasi', 'diverifikasi', 'Laporan ditugaskan kepada petugas.', '2026-07-02 13:57:51', '2026-07-02 13:57:51'),
(8, 3, 6, NULL, 'menunggu_verifikasi', 'Laporan dibuat oleh pelapor.', '2026-07-05 09:46:40', '2026-07-05 09:46:40'),
(9, 3, 3, 'menunggu_verifikasi', 'diverifikasi', 'Laporan diverifikasi oleh admin.', '2026-07-05 09:49:35', '2026-07-05 09:49:35'),
(10, 3, 3, 'diverifikasi', 'diverifikasi', 'Laporan ditugaskan kepada petugas.', '2026-07-05 09:49:42', '2026-07-05 09:49:42'),
(11, 2, 4, 'diverifikasi', 'diproses', 'Laporan mulai diproses oleh petugas.', '2026-07-05 09:50:03', '2026-07-05 09:50:03'),
(12, 2, 4, 'diproses', 'selesai', 'lampu sudah di ganti', '2026-07-05 09:50:21', '2026-07-05 09:50:21'),
(13, 3, 4, 'diverifikasi', 'diproses', 'Laporan mulai diproses oleh petugas.', '2026-07-05 09:50:37', '2026-07-05 09:50:37'),
(14, 3, 4, 'diproses', 'selesai', 'pintu toilet sudah di perbaiki', '2026-07-05 09:50:57', '2026-07-05 09:50:57'),
(15, 4, 6, NULL, 'menunggu_verifikasi', 'Laporan dibuat oleh pelapor.', '2026-07-05 12:02:30', '2026-07-05 12:02:30'),
(16, 4, 3, 'menunggu_verifikasi', 'diverifikasi', 'Laporan diverifikasi oleh admin.', '2026-07-05 12:03:29', '2026-07-05 12:03:29'),
(17, 4, 3, 'diverifikasi', 'diverifikasi', 'Laporan ditugaskan kepada petugas.', '2026-07-05 12:03:41', '2026-07-05 12:03:41'),
(18, 4, 4, 'diverifikasi', 'diproses', 'Laporan mulai diproses oleh petugas.', '2026-07-05 12:04:41', '2026-07-05 12:04:41'),
(19, 4, 4, 'diproses', 'selesai', 'sudah ganti\r\n', '2026-07-05 12:05:04', '2026-07-05 12:05:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `report_votes`
--

CREATE TABLE `report_votes` (
  `id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `report_votes`
--

INSERT INTO `report_votes` (`id`, `report_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, 6, '2026-07-05 09:03:15', '2026-07-05 09:03:15'),
(2, 1, 6, '2026-07-05 09:41:54', '2026-07-05 09:41:54'),
(3, 4, 6, '2026-07-05 12:05:52', '2026-07-05 12:05:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administritir', '2026-07-01 22:05:48', '2026-07-01 22:05:48'),
(2, 'petugas', 'Petugas', '2026-07-01 22:09:12', '2026-07-01 22:09:12'),
(3, 'pelapor', 'Pelapor', '2026-07-01 22:10:16', '2026-07-01 22:10:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `password`, `phone`, `address`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'Fathor Rozi', 'admin@gmail.com', '$2y$10$yizpQSgeJRntkrOfFDPK2OOejdPgQAwUVs0OE9M0AEcnMTHrMyp8W', '080000000000', 'Admin Sistem', 'active', '2026-07-01 22:06:20', '2026-07-01 22:06:20'),
(4, 2, 'Nauval', 'petugas@gmail.com', '$2y$10$8jb1nvdi45DobTChqx3aUexIDkBiZlKPqIUEYY/c9ZaxbXXZ1KQBG', NULL, NULL, 'active', '2026-07-01 22:11:34', '2026-07-01 22:11:38'),
(5, 3, 'Fathor Rozi', 'fathorrozi.ac@gmail.com', '$2y$10$FgVBv48fsfC5SqgATZF6uebkY74QBtW0ElC4ZhwwWIl9Uk0RAKZO6', '09876543212', 'Prenduan, Pragaan, Sumenep.', 'active', '2026-07-01 22:45:55', '2026-07-01 22:45:55'),
(6, 3, 'Pandu', 'pelapor@gmail.com', '$2y$10$5TJsrZSzAsBvUrpwO4N9Le00T/kM5gjvD0Lcv2n5/8KxM6unS/uqq', '', '', 'active', '2026-07-02 05:44:41', '2026-07-02 05:44:41'),
(7, 3, 'fathorrozi', 'fathorrozi@gmail.com', '$2y$10$qjlzV9LA7w/sm0Gzu3Zivu4CzCGoWYU01z0b4ybVOfePSIfLV4zuC', '', '', 'active', '2026-07-02 13:48:08', '2026-07-02 13:48:08');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_user_id_foreign` (`user_id`),
  ADD KEY `reports_category_id_foreign` (`category_id`),
  ADD KEY `reports_location_id_foreign` (`location_id`),
  ADD KEY `reports_assigned_to_foreign` (`assigned_to`);

--
-- Indeks untuk tabel `report_comments`
--
ALTER TABLE `report_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_comments_report_id_foreign` (`report_id`),
  ADD KEY `report_comments_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `report_photos`
--
ALTER TABLE `report_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_photos_report_id_foreign` (`report_id`);

--
-- Indeks untuk tabel `report_status_histories`
--
ALTER TABLE `report_status_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_status_histories_report_id_foreign` (`report_id`),
  ADD KEY `report_status_histories_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `report_votes`
--
ALTER TABLE `report_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_id_user_id` (`report_id`,`user_id`),
  ADD KEY `report_votes_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `report_comments`
--
ALTER TABLE `report_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `report_photos`
--
ALTER TABLE `report_photos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `report_status_histories`
--
ALTER TABLE `report_status_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `report_votes`
--
ALTER TABLE `report_votes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `reports_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `reports_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `report_comments`
--
ALTER TABLE `report_comments`
  ADD CONSTRAINT `report_comments_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `report_photos`
--
ALTER TABLE `report_photos`
  ADD CONSTRAINT `report_photos_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `report_status_histories`
--
ALTER TABLE `report_status_histories`
  ADD CONSTRAINT `report_status_histories_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_status_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `report_votes`
--
ALTER TABLE `report_votes`
  ADD CONSTRAINT `report_votes_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
