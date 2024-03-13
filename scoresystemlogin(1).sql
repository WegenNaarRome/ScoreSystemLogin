-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2024 at 02:00 PM
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
-- Database: `scoresystemlogin`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `Id` int(11) NOT NULL,
  `Titel` varchar(128) NOT NULL,
  `Regels` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`Id`, `Titel`, `Regels`) VALUES
(1, 'Uno', 'Jemoeder');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Voornaam` varchar(50) NOT NULL,
  `Tussenvoegsel` varchar(20) NOT NULL,
  `Achternaam` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Wachtwoord` varchar(128) NOT NULL,
  `Opleiding` varchar(50) NOT NULL,
  `Rol` varchar(64) NOT NULL,
  `Geblokkeerd` tinyint(1) DEFAULT 0,
  `Aangemaakt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Voornaam`, `Tussenvoegsel`, `Achternaam`, `Email`, `Wachtwoord`, `Opleiding`, `Rol`, `Geblokkeerd`, `Aangemaakt`) VALUES
(1, 'Yordi', '', 'Gort', '23939@edu.rocfriesepoort.nl', 'sdakjdnasjkdnjkankjs', 'Software Development', 'Beheerder', 1, '2024-03-13 09:01:33'),
(2, 'Roy', '', 'Croezen', 'dikkebeer@edu.rocfriesepoort.nl', 'wildkippetje', 'Software Development', 'Gebruiker', 0, '2024-03-13 09:03:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
