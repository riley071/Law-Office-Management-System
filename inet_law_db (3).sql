-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 09:00 AM
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
-- Database: `inet_law_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_user` varchar(30) NOT NULL,
  `admin_pass` text NOT NULL,
  `complete_name` varchar(100) NOT NULL,
  `email_address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_user`, `admin_pass`, `complete_name`, `email_address`) VALUES
(1, 'admin1', 'admin123', 'Demo Admin', 'admin@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appoinment`
--

CREATE TABLE `tbl_appoinment` (
  `appointment_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `firm_id` int(11) NOT NULL,
  `attorney_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `reference_number` varchar(15) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `appointment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_appoinment`
--

INSERT INTO `tbl_appoinment` (`appointment_id`, `client_id`, `firm_id`, `attorney_id`, `service_id`, `reference_number`, `remarks`, `status`, `appointment_date`) VALUES
(2, 1, 0, 2, 1, 'REF-5359-21', 'hhh', 0, '2025-04-12'),
(3, 1, 0, 2, 1, 'REF-9051-21', 'dgd', 1, '2025-04-26'),
(4, 1, 0, 2, 1, 'REF-9691-21', 'dgd', 1, '2025-04-26'),
(5, 1, 0, 2, 1, 'REF-5940-21', 'HHH', 0, '2025-04-24'),
(6, 1, 0, 2, 1, 'REF-2808-21', 'HHH', 0, '2025-04-24'),
(7, 1, 0, 2, 1, 'REF-3055-21', 'HHHH', 0, '2025-04-17'),
(11, 4, 0, 2, 1, 'REF-5933-21', 'dddddddddd', 0, '2025-05-05'),
(12, 4, 0, 2, 1, 'REF-5194-21', 'zzzz', 1, '2025-05-30'),
(13, 4, 0, 2, 0, 'REF-3152-21', 'zzzz', 1, '2025-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attorney`
--

CREATE TABLE `tbl_attorney` (
  `attorney_id` int(11) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(30) NOT NULL,
  `gender` int(1) NOT NULL,
  `complete_address` varchar(150) NOT NULL,
  `contact_details` varchar(50) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `profile_picture` text NOT NULL,
  `education` text NOT NULL,
  `professional_experience` text NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `account_status` int(1) NOT NULL,
  `attorney_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_attorney`
--

INSERT INTO `tbl_attorney` (`attorney_id`, `last_name`, `first_name`, `middle_name`, `gender`, `complete_address`, `contact_details`, `fax`, `profile_picture`, `education`, `professional_experience`, `username`, `password`, `account_status`, `attorney_email`) VALUES
(2, 'yes', 'emmanuel', 'no', 1, 'kamewa', '84849', '848494', '', 'LAW', '6', 'EMMA', 'EMMA123', 1, 'emzom@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attorney_firm`
--

CREATE TABLE `tbl_attorney_firm` (
  `record_id` int(11) NOT NULL,
  `attorney_id` int(11) NOT NULL,
  `firm_id` int(11) NOT NULL,
  `firm_name` varchar(255) NOT NULL,
  `firm_address` text NOT NULL,
  `firm_contact` varchar(50) NOT NULL,
  `firm_email` varchar(100) NOT NULL,
  `firm_history` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_badwords`
--

CREATE TABLE `tbl_badwords` (
  `word_id` int(11) NOT NULL,
  `bad_word` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_case`
--

CREATE TABLE `tbl_case` (
  `case_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `attorney_id` int(11) NOT NULL,
  `case_title` varchar(255) NOT NULL,
  `case_description` text DEFAULT NULL,
  `status` enum('Open','In Progress','Closed') DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_case`
--

INSERT INTO `tbl_case` (`case_id`, `client_id`, `attorney_id`, `case_title`, `case_description`, `status`, `created_at`) VALUES
(3, 1, 2, 'judgeg', 'hkgrhiuyerhire', '', '2025-04-10 04:02:30'),
(4, 1, 2, 'dhhhhhhhhh', 'hddddddddddd', 'Open', '2025-04-10 19:16:50'),
(5, 1, 2, 'ddddddddddd', NULL, 'In Progress', '2025-05-03 13:41:28'),
(6, 4, 2, 'dgdggd', 'dggd', 'Open', '2025-05-04 06:32:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_case_progress`
--

CREATE TABLE `tbl_case_progress` (
  `progress_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `update_title` varchar(255) NOT NULL,
  `update_description` text DEFAULT NULL,
  `update_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_case_progress`
--

INSERT INTO `tbl_case_progress` (`progress_id`, `case_id`, `update_title`, `update_description`, `update_date`) VALUES
(10, 4, 'dgggdvv', 'dgdfffffffffffff', '2025-05-09 00:00:00'),
(11, 3, 'ggrrrrrrrrrrrrrrrrrrrrrrrrr', 'sfsgfffffffffffffffffffffffffffffffff', '2025-04-15 00:00:00'),
(12, 4, 'Same', 'same', '2025-04-30 00:00:00'),
(13, 4, 'gjvjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', 'kjhj', '2025-05-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_client`
--

CREATE TABLE `tbl_client` (
  `client_id` int(11) NOT NULL,
  `client_lastname` varchar(30) NOT NULL,
  `client_firstname` varchar(30) NOT NULL,
  `client_middlename` varchar(30) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `valid_id` text NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `account_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_client`
--

INSERT INTO `tbl_client` (`client_id`, `client_lastname`, `client_firstname`, `client_middlename`, `contact`, `email_address`, `valid_id`, `username`, `password`, `account_status`) VALUES
(1, 'Mbewe', 'Thoko', 'James', '0999111222', 'emzo@gmail.com', 'NID123456', 'thokom', 'hashedpassword123', 1),
(2, 'jkdjdkj', 'jdjdj', 'djkjdj', '0933883838', 'emzomat@gmail.com', '', 'jdkd', '$2y$10$Nmns0oCZWOCQmDDDSskYb.rqKaUhFsLgMdPdmDS/EKunlYeqgWmK6', 0),
(3, 'DHHD', 'SHJ', 'DUDUI', '92882', 'were@gmail.com', '', 'UHDH', '$2y$10$BhrWUdrZta3DNnj2wYYbkOsoqabXcsJq1VS7vV2aY7jk0GNqC.FMC', 0),
(4, 'client', 'User', 'client', '0498484', 'client@gmail.com', '', 'client', '$2y$10$sH2SmQJfW3fSDRG4tcGm1urQbllT91fx.HA5.L16AsPyDkafFYA92', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_documents`
--

CREATE TABLE `tbl_documents` (
  `document_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `uploaded_by` enum('client','attorney','admin') NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` text NOT NULL,
  `upload_date` datetime DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_documents`
--

INSERT INTO `tbl_documents` (`document_id`, `case_id`, `uploaded_by`, `file_name`, `file_path`, `upload_date`, `description`, `client_id`) VALUES
(3, 4, 'admin', 'COMP1649 Individual Coursework_Annotated TOC(1).pdf', 'uploads/documents/case_4/1744393680_COMP1649 Individual Coursework_Annotated TOC(1).pdf', '2025-04-11 19:48:00', 'dd', NULL),
(4, 6, 'client', 'SANWECKA_Lilongwe_Campus_Form_2025.pdf', '../uploads/documents/SANWECKA_Lilongwe_Campus_Form_2025.pdf', '2025-05-04 08:58:00', NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE `tbl_feedback` (
  `feedback_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `attorney_id` int(11) NOT NULL,
  `message` varchar(100) NOT NULL,
  `rate` int(1) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_firm`
--

CREATE TABLE `tbl_firm` (
  `firm_id` int(11) NOT NULL,
  `firm_name` varchar(255) NOT NULL,
  `firm_address` text NOT NULL,
  `firm_contact` varchar(50) NOT NULL,
  `firm_email` varchar(255) NOT NULL,
  `firm_history` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_firm`
--

INSERT INTO `tbl_firm` (`firm_id`, `firm_name`, `firm_address`, `firm_contact`, `firm_email`, `firm_history`, `created_at`) VALUES
(1, 'ginnery corner ', 'post code 28383', '099494844', 'GINNERY@GMAIL.COM', 'FHFH', '2025-04-08 17:18:47'),
(2, 'HHH', 'RHRH', 'RURU', 'emzomatewere@gmail.com', '4848', '2025-04-08 17:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_firm_services`
--

CREATE TABLE `tbl_firm_services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `firm_id` int(11) NOT NULL,
  `attorney_id` int(11) NOT NULL,
  `rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_firm_services`
--

INSERT INTO `tbl_firm_services` (`service_id`, `service_name`, `description`, `firm_id`, `attorney_id`, `rate`) VALUES
(0, 'S', 'ddhd', 0, 2, -6),
(1, 'Ejjd', 'fhfh', 0, 1, 23939);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `notification_id` int(11) NOT NULL,
  `recipient_email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `send_time` datetime NOT NULL,
  `status` enum('pending','sent') DEFAULT 'pending',
  `appointment_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`notification_id`, `recipient_email`, `subject`, `message`, `send_time`, `status`, `appointment_id`, `created_at`) VALUES
(1, '', 'New Appointment Confirmation', 'Dear Client,\n\nYour appointment has been scheduled successfully with Ref #: REF-5940-21 on 2025-04-24T01:57.\n\nRegards,\nLaw Office', '0000-00-00 00:00:00', 'pending', 5, '2025-04-09 23:57:44'),
(2, 'emzomatewere@gmail.com', 'New Appointment Assigned', 'Dear Attorney,\n\nYou have a new appointment assigned with Ref #: REF-5940-21 on 2025-04-24T01:57.\n\nPlease check your portal for details.', '0000-00-00 00:00:00', 'pending', 5, '2025-04-09 23:57:44'),
(3, 'emzomatewere@gmail.com', 'New Appointment Confirmation', 'Dear Client,\n\nYour appointment has been scheduled successfully with Ref #: REF-2808-21 on 2025-04-24T01:57.\n\nRegards,\nLaw Office', '0000-00-00 00:00:00', 'pending', 6, '2025-04-10 03:38:03'),
(4, 'emzomatewere@gmail.com', 'New Appointment Assigned', 'Dear Attorney,\n\nYou have a new appointment assigned with Ref #: REF-2808-21 on 2025-04-24T01:57.\n\nPlease check your portal for details.', '0000-00-00 00:00:00', 'pending', 6, '2025-04-10 03:38:03'),
(5, 'emzomatewere@gmail.com', 'New Appointment Confirmation', 'Dear Client,\n\nYour appointment has been scheduled successfully with Ref #: REF-3055-21 on 2025-04-17T05:38.\n\nRegards,\nLaw Office', '0000-00-00 00:00:00', 'pending', 7, '2025-04-10 03:38:40'),
(6, 'emzomatewere@gmail.com', 'New Appointment Assigned', 'Dear Attorney,\n\nYou have a new appointment assigned with Ref #: REF-3055-21 on 2025-04-17T05:38.\n\nPlease check your portal for details.', '0000-00-00 00:00:00', 'pending', 7, '2025-04-10 03:38:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','attorney','client') NOT NULL,
  `linked_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_appoinment`
--
ALTER TABLE `tbl_appoinment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `firm_id` (`firm_id`),
  ADD KEY `attorney_id` (`attorney_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `tbl_attorney`
--
ALTER TABLE `tbl_attorney`
  ADD PRIMARY KEY (`attorney_id`);

--
-- Indexes for table `tbl_attorney_firm`
--
ALTER TABLE `tbl_attorney_firm`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `attorney_id` (`attorney_id`),
  ADD KEY `firm_id` (`firm_id`);

--
-- Indexes for table `tbl_badwords`
--
ALTER TABLE `tbl_badwords`
  ADD PRIMARY KEY (`word_id`);

--
-- Indexes for table `tbl_case`
--
ALTER TABLE `tbl_case`
  ADD PRIMARY KEY (`case_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `attorney_id` (`attorney_id`);

--
-- Indexes for table `tbl_case_progress`
--
ALTER TABLE `tbl_case_progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `tbl_client`
--
ALTER TABLE `tbl_client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `tbl_firm`
--
ALTER TABLE `tbl_firm`
  ADD PRIMARY KEY (`firm_id`);

--
-- Indexes for table `tbl_firm_services`
--
ALTER TABLE `tbl_firm_services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `firm_id` (`firm_id`),
  ADD KEY `attorney_id` (`attorney_id`);

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_appoinment`
--
ALTER TABLE `tbl_appoinment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_attorney`
--
ALTER TABLE `tbl_attorney`
  MODIFY `attorney_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_attorney_firm`
--
ALTER TABLE `tbl_attorney_firm`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_badwords`
--
ALTER TABLE `tbl_badwords`
  MODIFY `word_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_case`
--
ALTER TABLE `tbl_case`
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_case_progress`
--
ALTER TABLE `tbl_case_progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_client`
--
ALTER TABLE `tbl_client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_firm`
--
ALTER TABLE `tbl_firm`
  MODIFY `firm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_case`
--
ALTER TABLE `tbl_case`
  ADD CONSTRAINT `tbl_case_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `tbl_client` (`client_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_case_ibfk_2` FOREIGN KEY (`attorney_id`) REFERENCES `tbl_attorney` (`attorney_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_case_progress`
--
ALTER TABLE `tbl_case_progress`
  ADD CONSTRAINT `tbl_case_progress_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `tbl_case` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_documents`
--
ALTER TABLE `tbl_documents`
  ADD CONSTRAINT `tbl_documents_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `tbl_case` (`case_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
