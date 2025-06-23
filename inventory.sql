-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 12:38 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `health_rec`
--

CREATE TABLE `health_rec` (
  `ID` int(11) NOT NULL,
  `Student_Number` varchar(244) NOT NULL,
  `Concern` text NOT NULL,
  `temperature` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `prescription` text NOT NULL,
  `Admission_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `ID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Generic_Name` varchar(244) NOT NULL,
  `Brand_Name` varchar(244) NOT NULL,
  `Mg` varchar(244) NOT NULL,
  `Expiration_Date` date NOT NULL,
  `Date_Added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`ID`, `Quantity`, `Generic_Name`, `Brand_Name`, `Mg`, `Expiration_Date`, `Date_Added`) VALUES
(1, 150, 'Paracetamol', 'Biogesic', '5mg', '2024-02-06', '2024-06-10'),
(2, 10, 'Cetirizine', 'Alnix', '5mg', '2026-12-12', '2024-06-10'),
(3, 50, 'Ibuprofen', 'Medicol', '10mg', '2027-12-12', '2024-06-10'),
(4, 25, 'Loperamide', 'Diatabs', '10mg', '2028-12-12', '2024-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `students_rec`
--

CREATE TABLE `students_rec` (
  `ID` int(11) NOT NULL,
  `Student_Number` varchar(244) NOT NULL,
  `Last_Name` varchar(244) NOT NULL,
  `First_Name` varchar(244) NOT NULL,
  `Middle_Initial` varchar(244) NOT NULL,
  `Contact_No` varchar(244) NOT NULL,
  `Course_Section` varchar(244) NOT NULL,
  `Age` int(11) NOT NULL,
  `Gender` varchar(244) NOT NULL,
  `Guardian` varchar(244) NOT NULL,
  `Guardian_No` varchar(244) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `First_Name` varchar(244) NOT NULL,
  `Middle_Initial` varchar(244) NOT NULL,
  `Last_Name` varchar(244) NOT NULL,
  `Password` varchar(244) NOT NULL,
  `Email` varchar(244) NOT NULL,
  `Date_Created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `First_Name`, `Middle_Initial`, `Last_Name`, `Password`, `Email`, `Date_Created`) VALUES
(1, 'Colet', 'A.', 'Vergara', '12345', 'nurse1@gmail.com', '2025-06-22 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `health_rec`
--
ALTER TABLE `health_rec`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `students_rec`
--
ALTER TABLE `students_rec`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `health_rec`
--
ALTER TABLE `health_rec`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students_rec`
--
ALTER TABLE `students_rec`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
