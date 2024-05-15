-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 03:55 AM
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
-- Database: `fareco_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `user_ID` bigint(100) NOT NULL,
  `Fname` varchar(150) NOT NULL,
  `Lname` varchar(150) NOT NULL,
  `acc_user` varchar(100) NOT NULL,
  `acc_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`user_ID`, `Fname`, `Lname`, `acc_user`, `acc_pass`) VALUES
(35778, 'Rhea', '', 'rhea', '12345'),
(12345678, 'Michelle', 'Asis', 'michi_23', '12345me');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `title` varchar(250) NOT NULL,
  `content` varchar(300) NOT NULL,
  `tags` varchar(200) NOT NULL,
  `image` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `likes` bigint(250) NOT NULL,
  `acc_user` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`title`, `content`, `tags`, `image`, `likes`, `acc_user`) VALUES
('asfjk', 'kjsdhfkj', 'shirt,skirt,pants', 'IMG-66437dfe12de54.56410907.jpg', 0, ''),
('sdkghkj', 'jkhdfkjbn', 'shirt,skirt', 'IMG-66437e7823dea9.55172146.jpg', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `userprof`
--

CREATE TABLE `userprof` (
  `acc_user` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `avatar` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`title`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
