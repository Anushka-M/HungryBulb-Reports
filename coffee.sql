-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2016 at 07:55 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `u_name` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(40) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`u_name`, `password`, `name`, `admin`) VALUES
('Admin_1', '04e12bdbaa38ec711e608e08dae4bc9f', 'Ujjjwal Syal', 1),
('Admin_2', 'd420c63144d6e0b50076115c62d2e2c0', 'Rajeev Syal', 1),
('AnushkaM', '8971cc118f2cdea0d6d0e8cfc29c209d', 'Anushka Mehra', 0),
('Bhavna', '8afa847f50a716e64932d995c8e7435a', 'Diksha Kapoor', 0);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `date` date NOT NULL,
  `u_name` varchar(40) NOT NULL,
  `project` varchar(100) NOT NULL,
  `report_name` varchar(10000) NOT NULL,
  `feedback` varchar(10000) DEFAULT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`date`, `u_name`, `project`, `report_name`, `feedback`, `score`) VALUES
('2016-06-17', 'AnushkaM', 'hgcjhvkjb', 'gvhjknl', 'goofle', 3),
('2016-06-18', 'AnushkaM', 'fghjkl', 'fdfghjk', 'ujj', 5),
('2016-06-18', 'Bhavna', 'fjijlweflijew', 'fjnof[bnnbkrp0vnklspqKDPq;`lglmw`wpbp', NULL, NULL),
('2016-06-19', 'AnushkaM', '', '', 'huddd dabang', 0),
('2016-06-20', 'AnushkaM', 'lalalala', 'hahahahaha', 'SDFGHJKL', 2),
('2016-06-21', 'AnushkaM', '', '', 'fhqhfuahu\r\n\r\nu', 8),
('2016-06-24', 'AnushkaM', '', '', 'wfefef', 2),
('2016-06-24', 'Bhavna', '', '', '23', 45),
('2016-06-25', 'AnushkaM', '', '', 'dfghj', 2),
('2016-07-01', 'Bhavna', '', '', 'Well not done', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`u_name`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`date`,`u_name`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
