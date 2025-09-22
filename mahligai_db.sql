-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2025 at 07:58 AM
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
-- Database: `mahligai_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `booking_date` datetime NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `payment_method` varchar(50) NOT NULL DEFAULT 'Tunai',
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` varchar(50) DEFAULT 'Pending',
  `payment_proof` varchar(255) DEFAULT NULL,
  `cancellation_reason` text DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `customer_id`, `booking_date`, `vehicle_type`, `notes`, `status`, `payment_method`, `total_price`, `payment_status`, `payment_proof`, `cancellation_reason`, `cancelled_at`) VALUES
(40, 6, '2025-07-06 16:50:00', 'Lainnya', 'Tolong Bersih Dan Detail', 'Pending', 'Transfer Bank', 65000.00, 'Rejected', '/uploads/payment_proofs/6868e6e9f388b_WhatsApp Image 2025-07-05 at 11.40.16_4b7a716f.jpg', 'Tidak Bisa silahkan hubungi wa di footer untuk return permbayaran', NULL),
(41, 6, '2025-07-06 15:50:00', 'Lainnya', 'Gass', 'Completed', 'Transfer Bank', 65000.00, 'Confirmed', '/uploads/payment_proofs/6868e75638f31_WhatsApp Image 2025-07-05 at 11.40.17_169e0ff8.jpg', NULL, NULL),
(42, 6, '2025-07-09 09:15:00', 'Lainnya', '...', 'Completed', 'QRIS', 120000.00, 'Confirmed', '/uploads/payment_proofs/686c625267d9b_ChatGPT Image 5 Jul 2025, 11.42.55.png', NULL, NULL),
(43, 6, '2025-07-09 09:00:00', 'Motor', '......', 'Cancelled', 'QRIS', 15000.00, 'Rejected', '/uploads/payment_proofs/686c6d1f99ddf_ChatGPT Image 5 Jul 2025, 11.42.55.png', 'Dibatalkan oleh pelanggan.', '2025-07-08 03:00:37');

-- --------------------------------------------------------

--
-- Table structure for table `booking_services`
--

CREATE TABLE `booking_services` (
  `booking_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_services`
--

INSERT INTO `booking_services` (`booking_id`, `service_id`) VALUES
(40, 10),
(40, 11),
(41, 10),
(41, 11),
(42, 2),
(42, 9),
(43, 10);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `phone_number`, `email`) VALUES
(6, 'Dzakhwan', 'Rohid', '0812267659213', 'dzakhwan12@gmail.com'),
(8, 'Fazila ', 'Jannah p', '085767933303', 'jannahfazila@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `gallery_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`gallery_id`, `image_path`, `caption`, `uploaded_at`) VALUES
(6, '/uploads/gallery/proof_6868add751cc87.91621235.jpg', 'Selamat datang di Mahligai Auto Care! Kami siap membuat kendaraan Anda kembali #BersihdanNyaman. Hubungi kami atau scan QR code untuk info lebih lanjut.', '2025-07-05 04:45:11'),
(7, '/uploads/gallery/proof_6868ae0041ff90.75454956.jpg', 'Cari kami? Gampang! Kunjungi kami di lokasi yang strategis untuk perawatan mobil terbaik di kota. Kami tunggu kedatangan Anda! #MahligaiAutoCare #WeAreHere', '2025-07-05 04:45:52'),
(8, '/uploads/gallery/proof_6868ae171199e5.59044164.jpg', 'Setiap detail penting. Dengan teknik snow wash andalan kami, kotoran membandel terangkat sempurna tanpa merusak cat. Kilau maksimal, perlindungan ekstra!', '2025-07-05 04:46:15'),
(9, '/uploads/gallery/proof_6868ae4ad943e8.76239353.jpg', 'Menunggu jadi lebih santai. Nikmati fasilitas ruang tunggu kami yang nyaman selagi tim kami merawat kendaraan kesayangan Anda.', '2025-07-05 04:47:06'),
(10, '/uploads/gallery/proof_6868ae74cb74c2.48151273.jpg', 'Tidak perlu khawatir soal parkir. Kami menyediakan area parkir yang luas dan aman untuk kenyamanan setiap pelanggan kami.', '2025-07-05 04:47:48'),
(11, '/uploads/gallery/proof_6868ae8454ccc7.21529204.jpg', 'Butuh tempat sejuk untuk menunggu? Ruang tunggu indoor kami yang dilengkapi AC siap memberikan kenyamanan ekstra untuk Anda.', '2025-07-05 04:48:04'),
(12, '/uploads/gallery/proof_6868ae93f1a749.69144411.jpg', 'Kebersihan interior adalah prioritas. Kami membersihkan setiap sudut kabin dengan vakum untuk memastikan mobil Anda bersih dari debu dan kotoran.', '2025-07-05 04:48:19'),
(13, '/uploads/gallery/proof_6868aea2a17709.80722980.jpg', 'Bersih hingga ke kolong mobil! Dengan sistem cuci hidrolik T-H, kami pastikan tidak ada bagian yang terlewat. Bersih menyeluruh, dari atas sampai bawah.', '2025-07-05 04:48:34'),
(14, '/uploads/gallery/proof_6868aeb5488d47.69407907.jpg', 'Detail kecil membuat perbedaan besar. Tim kami dengan teliti membersihkan setiap panel interior untuk hasil yang sempurna.', '2025-07-05 04:48:53'),
(15, '/uploads/gallery/proof_6868aec5625b58.36193693.jpg', 'Tidak hanya mobil, kami juga ahli dalam merawat motor! Setiap komponen, termasuk suspensi, kami bersihkan dengan detail.', '2025-07-05 04:49:09'),
(16, '/uploads/gallery/proof_6868aed3f41175.97882816.jpg', 'Perawatan detail juga untuk kendaraan roda dua Anda. Kembalikan kilau dan kebersihan motor Anda seperti baru hanya di Mahligai Auto Care!', '2025-07-05 04:49:24'),
(17, '/uploads/gallery/proof_6868b86a764507.45441451.jpg', 'Price List ya sobbb!!', '2025-07-05 05:30:18');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `description`, `price`) VALUES
(1, 'Cuci Kilat', 'Pencucian eksterior cepat dengan busa dan bilas.', 30000.00),
(2, 'Cuci Lengkap', 'Pencucian eksterior dan interior, vakum, ban, dan poles dasar.', 75000.00),
(3, 'Detailing Premium Mobil', 'Pencucian lengkap, detailing interior mendalam, poles, dan ceramic coating.', 1500000.00),
(4, 'Cuci Standar', 'Pencucian dengan Cara Biasa dan standar', 25000.00),
(8, 'Cuci Mobil Kecil', 'Sempurna untuk jenis mobil sedan, hatchback, dan sejenisnya.', 40000.00),
(9, 'Cuci Mobil Besar', ' Ideal untuk mobil jenis SUV, MPV, dan kendaraan besar lainnya.', 45000.00),
(10, 'Cuci Motor', 'Berikan perhatian khusus pada sepeda motor Anda. Layanan cuci motor kami akan membersihkan setiap bagian dari debu dan kotoran jalanan, membuatnya tampak segar dan terawat.', 15000.00),
(11, 'Cuci Karpet', 'Layanan cuci karpet profesional kami menggunakan teknik pembersihan mendalam untuk menghilangkan noda.(Khusus Ukuran 2,5 X 3 M)', 50000.00);

-- --------------------------------------------------------

--
-- Table structure for table `suggestions_complaints`
--

CREATE TABLE `suggestions_complaints` (
  `suggestion_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suggestions_complaints`
--

INSERT INTO `suggestions_complaints` (`suggestion_id`, `customer_id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(6, 6, 'Dzakhwan Rohid', 'dzakhwan12@gmail.com', 'kritik', 'Tidak bersih', '2025-07-08 03:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `role`, `customer_id`) VALUES
(2, 'admin1_master', '$2y$10$T06xbege6RnSp4MspDPMKeI802d.j.oupSXdaWbFROuDjeiUw5gOa', 'admin1', NULL),
(3, 'admin2_booking', '$2y$10$ttwuD2fDXLqCoCpZDjZUnOoSmT2SOqKkO0k7HPSJQ/KLbGvmZFWni', 'admin2', NULL),
(6, 'rohid', '$2y$10$OwroDSgeXDdA7oLDg0B7/.f06m.f1qgHwQw1rGsKMR8wU5lMBe.UC', 'user', 6),
(8, 'Fazilajp', '$2y$10$Sdz9LQM9k2vNUlWnnWQtYuGkGDo2Sn25j6szZI.RxbyW8YZsntzKe', 'user', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `booking_services`
--
ALTER TABLE `booking_services`
  ADD PRIMARY KEY (`booking_id`,`service_id`),
  ADD KEY `fk_service_id` (`service_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`gallery_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `suggestions_complaints`
--
ALTER TABLE `suggestions_complaints`
  ADD PRIMARY KEY (`suggestion_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `suggestions_complaints`
--
ALTER TABLE `suggestions_complaints`
  MODIFY `suggestion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `booking_services`
--
ALTER TABLE `booking_services`
  ADD CONSTRAINT `fk_booking_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_service_id` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE CASCADE;

--
-- Constraints for table `suggestions_complaints`
--
ALTER TABLE `suggestions_complaints`
  ADD CONSTRAINT `suggestions_complaints_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
