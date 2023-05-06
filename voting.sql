-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2023 at 07:31 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `subject` longtext NOT NULL,
  `body` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`subject`, `body`) VALUES
('', 's');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_form`
--

CREATE TABLE `tbl_form` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `random_code` varchar(6) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `vote` varchar(32) NOT NULL,
  `vote_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_form`
--

INSERT INTO `tbl_form` (`id`, `username`, `email`, `random_code`, `status`, `vote`, `vote_status`) VALUES
(10, 'Jodie', 'jodie@test.com', '555555', 1, '', 0),
(11, 'Jodie', 'jodie@test.com', '111111', 1, '', 0),
(12, 'Jodie', 'jodie@test.com', '222222', 1, '', 0),
(13, 'Jodie', 'jodie@test.com', '444444', 1, '', 0),
(14, 'Jodie', 'jodie@test.com', '333333', 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kandidat`
--

CREATE TABLE `tbl_kandidat` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_name` varchar(32) NOT NULL,
  `total_votes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kandidat`
--

INSERT INTO `tbl_kandidat` (`id`, `name`, `image_name`, `total_votes`) VALUES
(1, 'Steffany Faustine', 'steffany.png', 0),
(2, 'Jennifer Joevanca Arifin', 'jennifer.png', 0),
(3, 'Vania Callysta Tandy', 'vania.png', 0),
(4, 'Celine Lorenz', 'celine.png', 0),
(5, 'Edelyne Tanamal', 'edelyne.png', 0),
(6, 'Vilkent Bradley Salim', 'vilkent.png', 0),
(7, 'Kylie Natasha Halim', 'kylie.png', 0),
(8, 'Verrel Angkasa', 'verrel.png', 0),
(9, 'Audrey Tamalate', 'audrey.png', 0),
(10, 'Kheydelix Val', 'khey.png', 0),
(11, 'Viola Cristy', 'viola.png', 0),
(12, 'Alfredo Pratama', 'alfredo.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`username`, `password`) VALUES
('ayam', 'bebek'),
('admin', 'password');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_form`
--
ALTER TABLE `tbl_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_kandidat`
--
ALTER TABLE `tbl_kandidat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_form`
--
ALTER TABLE `tbl_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_kandidat`
--
ALTER TABLE `tbl_kandidat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
