-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2025 at 12:39 AM
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
-- Database: `ci4_ekskul`
--

-- --------------------------------------------------------

--
-- Table structure for table `ekskuls`
--

CREATE TABLE `ekskuls` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `capacity` int(10) UNSIGNED DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(255) DEFAULT NULL COMMENT 'URL atau path image ekskul'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ekskuls`
--

INSERT INTO `ekskuls` (`id`, `title`, `slug`, `description`, `capacity`, `created_at`, `updated_at`, `image`) VALUES
(1, 'Robotik', 'robotik', 'Ekskul ini fokus pada teknologi, robot, dan pemrograman. Peserta belajar logika, problem solving, dan inovasi teknologi yang bermanfaat untuk masa depan.', 20, '2025-11-26 15:33:36', '2025-11-26 09:40:12', NULL),
(2, 'Futsal', 'futsal', 'Selain olahraga tim biasa, ekskul ini menawarkan tantangan fisik, endurance, dan kekuatan. Cocok untuk yang suka tantangan dan olahraga aktif.', 25, '2025-11-26 15:33:36', '2025-11-26 09:43:01', NULL),
(3, 'Basket', 'basket', 'Ekskul olahraga tim ini melatih kerjasama, strategi, dan daya tahan fisik. Sambil bermain, peserta belajar sportivitas, kepemimpinan, dan semangat juang.', 20, '2025-11-26 09:24:20', '2025-11-26 09:41:22', NULL),
(4, 'Pencak Silat', 'pencakdashsilat', 'Ekskul ini mengajarkan seni bela diri, disiplin, dan kekuatan fisik. Selain berlatih teknik, peserta juga belajar mental tangguh dan percaya diri. Cocok untuk yang ingin sehat, fokus, dan berani.', 20, '2025-11-26 09:39:01', '2025-11-26 09:41:33', NULL),
(5, 'Musik', 'musik', 'Ekskul ini mengembangkan bakat bermusik, kreativitas, dan kerja sama tim. Dari latihan instrumen hingga penampilan panggung, peserta belajar ekspresi diri melalui musik.', 30, '2025-11-26 09:39:40', '2025-11-26 09:41:40', NULL),
(6, 'Seni Rupa', 'enidashrup', 'Ekskul seni menyalurkan kreativitas dan imajinasi. Peserta belajar melukis, menggambar, atau desain grafis, membangun kepekaan estetika dan kemampuan visual.', 30, '2025-11-26 09:39:58', '2025-11-26 09:41:52', NULL),
(7, 'Teater', 'teater', 'Ekskul teater melatih keberanian, ekspresi, dan komunikasi. Peserta belajar akting, improvisasi, dan membawakan cerita di atas panggung dengan percaya diri.', 20, '2025-11-26 09:40:27', '2025-11-26 09:42:03', NULL),
(8, 'Fotografi', 'fotografi', 'Ekskul ini mengembangkan kreativitas visual melalui kamera. Peserta belajar teknik memotret, mengedit, dan membuat konten visual yang menarik.', 20, '2025-11-26 09:41:00', '2025-11-26 09:42:08', NULL),
(9, 'Public speaking', 'publicdashspeaking', 'Ekskul ini mengasah kemampuan komunikasi, berargumentasi, dan percaya diri saat berbicara di depan umum. Cocok untuk yang ingin lancar bicara dan pintar berdebat.', 20, '2025-11-26 09:42:43', '2025-11-26 09:42:43', NULL),
(10, 'Badminton', 'badminton', 'Ekskul olahraga ini mengembangkan ketangkasan, kecepatan, dan strategi bermain. Peserta belajar teknik servis, smash, dan footwork sambil meningkatkan kebugaran dan sportivitas. Cocok untuk yang aktif dan kompetitif.', 40, '2025-11-26 09:44:52', '2025-11-26 09:44:52', NULL),
(11, 'Modelling', 'modelling', 'Ekskul ini mengajarkan siswa seni berpose, percaya diri, dan tampil di atas panggung. Peserta belajar fashion, etika, public speaking, dan teknik catwalk. Cocok untuk yang ingin mengekspresikan diri, tampil percaya diri, dan mengasah kreativitas di dunia fashion.', 25, '2025-11-26 09:45:12', '2025-11-26 09:45:12', NULL),
(12, 'voli', 'voli', 'Ekskul voli melatih kerjasama tim, ketangkasan, dan strategi bermain di lapangan. Peserta belajar teknik passing, smash, servis, serta sportivitas. Cocok untuk siswa yang energik, kompetitif, dan suka tantangan.', 25, '2025-11-26 09:46:04', '2025-11-26 09:46:04', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ekskuls`
--
ALTER TABLE `ekskuls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ekskuls`
--
ALTER TABLE `ekskuls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
