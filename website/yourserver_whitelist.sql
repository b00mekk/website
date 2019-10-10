-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `userID` text COLLATE utf8_polish_ci NOT NULL,
  `username` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- `admins`
--

INSERT INTO `admins` (`id`, `userID`, `username`) VALUES
(1, 'DISCORD_ID', 'DISCORD_USERNAME');

-- --------------------------------------------------------

--
-- `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `discordID` text CHARACTER SET latin1 NOT NULL,
  `discordTAG` text CHARACTER SET latin1 NOT NULL,
  `discordName` text CHARACTER SET latin1 NOT NULL,
  `age` int(11) NOT NULL,
  `rpDefinition` text CHARACTER SET latin1 NOT NULL,
  `charName` text CHARACTER SET latin1 NOT NULL,
  `charDesc` text CHARACTER SET latin1 NOT NULL,
  `charJob` text COLLATE utf8_polish_ci NOT NULL,
  `mg` text CHARACTER SET latin1 NOT NULL,
  `steam` text CHARACTER SET latin1 NOT NULL,
  `status` int(11) NOT NULL,
  `date` text CHARACTER SET latin1 NOT NULL,
  `meDo` text COLLATE utf8_polish_ci NOT NULL,
  `fear` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- `applications`
--

INSERT INTO `applications` (`id`, `discordID`, `discordTAG`, `discordName`, `age`, `rpDefinition`, `charName`, `charDesc`, `charJob`, `mg`, `steam`, `status`, `date`, `meDo`, `fear`) VALUES
(1, 'discord_id', 'discord_tag', 'discordName', 99, 'test', 'tester tester', 'character description', 'characters job', 'mg', 'steam', 'status', 'date', 'meDo', 'fear');

--
-- 
--

--
-- 
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
