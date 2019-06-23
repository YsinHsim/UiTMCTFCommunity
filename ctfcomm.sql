-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2019 at 07:58 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ctfcomm`
--

-- --------------------------------------------------------

--
-- Table structure for table `crackfile`
--

CREATE TABLE `crackfile` (
  `name` varchar(42) NOT NULL,
  `platform` varchar(24) NOT NULL,
  `language` varchar(24) NOT NULL,
  `level` varchar(24) NOT NULL,
  `flag` varchar(42) NOT NULL,
  `date_uploaded` varchar(24) NOT NULL,
  `uploader` varchar(42) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crackfile`
--

INSERT INTO `crackfile` (`name`, `platform`, `language`, `level`, `flag`, `date_uploaded`, `uploader`, `description`) VALUES
('EasyCtf1', 'Windows', 'C/C++', 'Very Easy', '45332', '11-05-2019', 'sharkSniffer', 'This is pretty easy CTF. Just perfect for newcomer. Good luck.'),
('Test', 'Windows', 'Assembler', 'Very Easy', 'Test', '12-05-2019', 'john', 'Test'),
('Test2', 'Windows', 'C/C++', 'Easy', 'Test2', '12-05-2019', 'john', 'Test2');

-- --------------------------------------------------------

--
-- Table structure for table `solution`
--

CREATE TABLE `solution` (
  `sol_name` varchar(42) NOT NULL,
  `sol_ctf` varchar(42) NOT NULL,
  `sol_uploader` varchar(42) NOT NULL,
  `date_uploaded` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `solution`
--

INSERT INTO `solution` (`sol_name`, `sol_ctf`, `sol_uploader`, `date_uploaded`) VALUES
('mySolution for EasyCtf1', 'EasyCtf1', 'john', '15-05-2019'),
('Solution1 for Test2', 'Test2', 'sharkSniffer', '15-05-2019'),
('Solution2 for Test2', 'Test2', 'sharkSniffer', '15-05-2019'),
('Solution3 for Test2', 'Test2', 'sharkSniffer', '15-05-2019');

-- --------------------------------------------------------

--
-- Table structure for table `solved`
--

CREATE TABLE `solved` (
  `id` int(11) NOT NULL,
  `ctf_name` varchar(42) NOT NULL,
  `ctf_solver` varchar(42) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `solved`
--

INSERT INTO `solved` (`id`, `ctf_name`, `ctf_solver`) VALUES
(1, 'EasyCtf1', 'john'),
(2, 'Test', 'sharkSniffer'),
(3, 'Test2', 'sharkSniffer');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(42) NOT NULL,
  `pass` varchar(42) NOT NULL,
  `last_crack_solved` varchar(24) NOT NULL DEFAULT 'NULL',
  `last_login_time` varchar(24) NOT NULL,
  `email` varchar(42) NOT NULL,
  `crack_score` int(11) NOT NULL,
  `last_login_date` varchar(24) NOT NULL,
  `user_type` varchar(24) NOT NULL DEFAULT 'Pwner',
  `user_status` varchar(24) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `pass`, `last_crack_solved`, `last_login_time`, `email`, `crack_score`, `last_login_date`, `user_type`, `user_status`) VALUES
('john', '#!/bin/sh', '11-05-2019', '03:09:41am', 'yasinhassim43@gmail.com', 125, '21-05-2019', 'Pwner', 'Active'),
('sharkSniffer', '#!/bin/sh', '12-05-2019', '07:44:29pm', 'yasinhassim43@gmail.com', 350, '01-06-2019', 'Admin', 'Active'),
('stickyRat', '#!/bin/sh', 'NULL', '08:48:22pm', 'tempmail@cyber-mail.net', 0, '15-05-2019', 'Pwner', 'Not Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crackfile`
--
ALTER TABLE `crackfile`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `solution`
--
ALTER TABLE `solution`
  ADD PRIMARY KEY (`sol_name`);

--
-- Indexes for table `solved`
--
ALTER TABLE `solved`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `solved`
--
ALTER TABLE `solved`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
