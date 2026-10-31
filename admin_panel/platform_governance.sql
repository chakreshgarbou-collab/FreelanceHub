-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2026 at 07:41 AM
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
-- Database: `platform_governance`
--

-- --------------------------------------------------------

--
-- Table structure for table `disputes`
--

CREATE TABLE `disputes` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `case_summary` text DEFAULT NULL,
  `dispute_status` enum('open','resolved_client','resolved_freelancer') DEFAULT 'open',
  `evidence_locked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disputes`
--

INSERT INTO `disputes` (`id`, `project_id`, `client_id`, `freelancer_id`, `case_summary`, `dispute_status`, `evidence_locked`, `created_at`) VALUES
(1, 101, 1, 2, 'Freelancer failed to deliver structural application endpoints within 48hrs.', 'open', 1, '2026-10-31 06:31:51'),
(2, 101, 1, 2, 'Freelancer failed to deliver structural application endpoints within 48hrs.', 'open', 1, '2026-10-31 06:33:19'),
(3, 101, 1, 2, 'Freelancer failed to deliver structural application endpoints within 48hrs.', 'open', 1, '2026-10-31 06:35:04'),
(4, 101, 1, 2, 'Freelancer failed to deliver structural application endpoints within 48hrs.', 'open', 1, '2026-10-31 06:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `financial_ledger`
--

CREATE TABLE `financial_ledger` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `escrow_status` enum('held','approved_payout','refunded_dispute') DEFAULT 'held',
  `maker_admin` varchar(50) NOT NULL,
  `checker_admin` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `financial_ledger`
--

INSERT INTO `financial_ledger` (`id`, `project_id`, `amount`, `escrow_status`, `maker_admin`, `checker_admin`, `updated_at`) VALUES
(1, 101, 1500.00, 'held', 'Admin_maker_1', NULL, '2026-10-31 06:27:35'),
(2, 101, 1500.00, 'held', 'Admin_maker_1', NULL, '2026-10-31 06:31:08'),
(3, 101, 1500.00, 'held', 'Admin_maker_1', NULL, '2026-10-31 06:31:51'),
(4, 101, 1500.00, 'held', 'Admin_maker_1', NULL, '2026-10-31 06:33:18'),
(5, 101, 1500.00, 'held', 'Admin_maker_1', NULL, '2026-10-31 06:35:04'),
(6, 101, 1500.00, 'held', 'Admin_maker_1', NULL, '2026-10-31 06:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `moderation_flag` enum('clean','flagged_ai','removed') DEFAULT 'clean',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `title`, `description`, `moderation_flag`, `created_at`) VALUES
(1, 'Urgent Bitcoin Transfer Help Needed', 'Pay outside the platform via telegram link', 'flagged_ai', '2026-10-31 06:35:04'),
(2, 'Urgent Bitcoin Transfer Help Needed', 'Pay outside the platform via telegram link', 'flagged_ai', '2026-10-31 06:36:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` enum('client','freelancer') NOT NULL,
  `verification_status` enum('pending','verified','rejected') DEFAULT 'pending',
  `account_status` enum('active','suspended','shadow_banned') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `role`, `verification_status`, `account_status`, `created_at`) VALUES
(1, 'Alice_Client', 'client', 'pending', 'active', '2026-10-31 06:27:35'),
(2, 'Bob_Dev', 'freelancer', 'verified', 'active', '2026-10-31 06:27:35'),
(3, 'Alice_Client', 'client', 'pending', 'active', '2026-10-31 06:31:07'),
(4, 'Bob_Dev', 'freelancer', 'verified', 'active', '2026-10-31 06:31:07'),
(5, 'Alice_Client', 'client', 'pending', 'active', '2026-10-31 06:31:50'),
(6, 'Bob_Dev', 'freelancer', 'verified', 'active', '2026-10-31 06:31:50'),
(7, 'Alice_Client', 'client', 'pending', 'active', '2026-10-31 06:33:18'),
(8, 'Bob_Dev', 'freelancer', 'verified', 'active', '2026-10-31 06:33:18'),
(9, 'Alice_Client', 'client', 'pending', 'active', '2026-10-31 06:35:04'),
(10, 'Bob_Dev', 'freelancer', 'verified', 'active', '2026-10-31 06:35:04'),
(11, 'Alice_Client', 'client', 'pending', 'active', '2026-10-31 06:36:00'),
(12, 'Bob_Dev', 'freelancer', 'verified', 'active', '2026-10-31 06:36:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disputes`
--
ALTER TABLE `disputes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_ledger`
--
ALTER TABLE `financial_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disputes`
--
ALTER TABLE `disputes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `financial_ledger`
--
ALTER TABLE `financial_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
