-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2022 at 11:30 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pokefriends`
--

-- --------------------------------------------------------

--
-- Table structure for table `commenti`
--

CREATE TABLE `commenti` (
  `id` int(11) NOT NULL,
  `utente` int(11) NOT NULL,
  `testo` varchar(255) COLLATE utf8_bin NOT NULL,
  `contenuto` int(11) DEFAULT NULL,
  `timestamp` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `commenti`
--

INSERT INTO `commenti` (`id`, `utente`, `testo`, `contenuto`, `timestamp`) VALUES
(17, 9, 'bsdgsdgsdgsdgsdgsd', 21, '2021-12-27'),
(18, 9, 'bsdgsdgsdgsdgsdgsdgwegwegwegew', 21, '2021-12-27'),
(92, 48, 'feffwfwfwef', 21, '2021-12-28'),
(93, 48, 'feffwfwfwef', 21, '2021-12-28'),
(94, 48, 'OUUUUUU', 21, '2021-12-28'),
(95, 48, 'HUHHHHHH', 21, '2021-12-28'),
(96, 48, 'HUHHHHHH', 21, '2021-12-28'),
(97, 48, 'fefwew', 21, '2021-12-28'),
(103, 48, 'xdlul comment', 19, '2021-12-29'),
(108, 9, 'gegrege', 19, '2021-12-30'),
(121, 49, 'asdfasdfad', 19, '2022-01-14'),
(125, 49, 'Mi piace questo post', 21, '2022-01-16'),
(126, 49, 'Non sto più nella pelle per la nuova stagione!', 22, '2022-01-16'),
(127, 49, 'Bellissimo post! Quanta nostalgia!! :\'(', 25, '2022-01-16'),
(128, 43, 'Che sballo! Questa guida è una bomba!', 19, '2022-01-16'),
(129, 43, 'Gran bel post, mi porta indietro nel tempo', 25, '2022-01-16'),
(133, 51, 'Gran bella guida, davvero interessante', 20, '2022-01-17'),
(134, 51, 'Prova commento', 38, '2022-01-17'),
(135, 51, 'Non ci credo, era da così tanto tempo che non sentivo parlare della storia dei Pokèmon', 25, '2022-01-17');

-- --------------------------------------------------------

--
-- Table structure for table `contenuti`
--

CREATE TABLE `contenuti` (
  `id` int(11) NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tipo` tinyint(4) NOT NULL DEFAULT 0,
  `titolo` tinytext COLLATE utf8_bin NOT NULL,
  `data_creazione` date NOT NULL DEFAULT current_timestamp(),
  `editore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `contenuti`
--

INSERT INTO `contenuti` (`id`, `path`, `tipo`, `titolo`, `data_creazione`, `editore`) VALUES
(19, 'arceus', 0, 'Come ottenere Arceus in 4a generazione', '2022-01-06', 9),
(20, 'ditto', 0, 'Come catturare Ditto in Pokèmon Diamante Brillante e Perla Splendente', '2021-12-11', 47),
(21, 'twoberrymagikarp', 0, 'Come aumentare il livello dei Magikarp velocemente in Magikarp Jump', '2021-12-24', 44),
(22, 'decimastagione', 1, 'Svelata la decima stagione della Lega Lotte Go', '2021-12-22', 48),
(23, 'mewundertruck', 1, 'C\'è un Mew nascosto sotto il camioncino in Pokèmon Rosso e Blu', '2021-12-17', 49),
(24, 'pokemonsocialimpact', 1, 'Pokemon Go e il suo impatto sociale', '2021-12-19', 43),
(25, 'pokemonstory', 1, 'La Storia di Pokèmon', '2021-12-21', 50),
(37, 'phpD034', 0, 'Duplicato Guida n°4', '2022-01-04', 51),
(38, 'php1ACB', 0, 'Duplicato Guida n°5', '2022-01-13', 51),
(39, 'php5E2E', 0, 'Duplicato Guida n°6', '2021-12-18', 51),
(40, 'phpA75E', 0, 'Duplicato Guida n°7', '2021-12-02', 51),
(41, 'php82D5', 1, 'Duplicato Articolo n°5', '2022-01-06', 51),
(42, 'phpBCD2', 1, 'Duplicato Articolo n°6', '2021-12-14', 51),
(43, 'phpFDF3', 1, 'Duplicato Articolo n°7', '2021-12-29', 51);

-- --------------------------------------------------------

--
-- Table structure for table `karma_commenti`
--

CREATE TABLE `karma_commenti` (
  `id` int(11) NOT NULL,
  `commento` int(11) NOT NULL,
  `utente` int(11) NOT NULL,
  `valore` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karma_commenti`
--

INSERT INTO `karma_commenti` (`id`, `commento`, `utente`, `valore`) VALUES
(8, 17, 48, 1),
(103, 133, 51, 1),
(104, 134, 51, 1),
(105, 129, 51, 1),
(106, 127, 51, 1);

-- --------------------------------------------------------

--
-- Table structure for table `karma_contenuti`
--

CREATE TABLE `karma_contenuti` (
  `id` int(11) NOT NULL,
  `contenuto` int(11) NOT NULL,
  `utente` int(11) NOT NULL,
  `valore` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karma_contenuti`
--

INSERT INTO `karma_contenuti` (`id`, `contenuto`, `utente`, `valore`) VALUES
(9, 19, 9, 1),
(10, 19, 51, 1),
(13, 21, 49, 1),
(14, 22, 49, 1),
(15, 25, 49, 1),
(16, 19, 43, 1),
(17, 21, 43, 1),
(18, 25, 43, 1),
(19, 19, 47, 1),
(26, 21, 9, -1),
(27, 38, 51, 1),
(28, 39, 51, 1),
(29, 20, 51, 1),
(30, 25, 51, 1);

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `email` varchar(320) COLLATE utf8_bin NOT NULL,
  `password` varchar(60) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `username` varchar(30) COLLATE utf8_bin NOT NULL,
  `privilegio` tinyint(4) NOT NULL,
  `data_iscrizione` date NOT NULL DEFAULT current_timestamp(),
  `attivo` tinyint(4) NOT NULL DEFAULT 1,
  `avatar` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`id`, `email`, `password`, `username`, `privilegio`, `data_iscrizione`, `attivo`, `avatar`) VALUES
(9, 'prova@gmail.com', '$2y$10$rx4qtx2dLrUq7Xpvm81iGupb71kJeYNpZtBFBwJb9ATjM0.iyj.hu', 'pieri', 1, '2021-12-16', 1, 30),
(43, 'gianni@gmail.com', '$2y$10$M4r7JxoMS7JiS7/ABVtZKeE8sLJZ6PPAQlaZqypxvCWYL1WIj4Z1.', 'gianni', 0, '2021-12-23', 1, 20),
(44, 'carlo@gasdf', '$2y$10$XAm7.Or258CZ7HOm.OPPVO/8A8ZYsN20.uGLOJp/RvPSHT3ILABr6', 'carlo', 0, '2021-12-23', 1, 40),
(47, 'paolo@gmail.com', '$2y$10$aYlBpwMU7jJWW3yv3NoHwOQdYVnrRW6mSATgP4oqBlkE/3TOPB10e', 'paolo', 0, '2021-12-23', 1, 50),
(48, 'xd@lul.com', '$2y$10$JRyDF3Jjgg3nxSwEXAIw4uIRGbP2b9dSPU0WgQp/WGrONiFcMhJay', 'xd', 0, '2021-12-28', 1, 25),
(49, 'user', '$2y$10$Demfim8mckMVdjgy5r7bP.zRByFGToTfyl68xgTFa3AwTTG69228a', 'user', 0, '2022-01-10', 1, 33),
(50, 'pietro.marcatti@gmail.com', '$2y$10$pARkHknVeCA76wH1v5VCtOdxMARMYLxoGlIljXFs5ftdV838BffUa', 'prova', 0, '2022-01-13', 1, 178),
(51, 'admin', '$2y$10$7wqxpNqvQyG9y7QWYYrJKOux/G6BT/qlSQWvfa.DKr7MKvM7VbcF2', 'admin', 1, '2022-01-13', 1, 317);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commenti`
--
ALTER TABLE `commenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content` (`contenuto`),
  ADD KEY `utente` (`utente`);

--
-- Indexes for table `contenuti`
--
ALTER TABLE `contenuti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `path` (`path`),
  ADD KEY `editore` (`editore`);

--
-- Indexes for table `karma_commenti`
--
ALTER TABLE `karma_commenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commento` (`commento`),
  ADD KEY `utente` (`utente`);

--
-- Indexes for table `karma_contenuti`
--
ALTER TABLE `karma_contenuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contenuto` (`contenuto`),
  ADD KEY `contenuto_utente` (`utente`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commenti`
--
ALTER TABLE `commenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `contenuti`
--
ALTER TABLE `contenuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `karma_commenti`
--
ALTER TABLE `karma_commenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `karma_contenuti`
--
ALTER TABLE `karma_contenuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commenti`
--
ALTER TABLE `commenti`
  ADD CONSTRAINT `content` FOREIGN KEY (`contenuto`) REFERENCES `contenuti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utente` FOREIGN KEY (`utente`) REFERENCES `utenti` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `contenuti`
--
ALTER TABLE `contenuti`
  ADD CONSTRAINT `editore` FOREIGN KEY (`editore`) REFERENCES `utenti` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `karma_commenti`
--
ALTER TABLE `karma_commenti`
  ADD CONSTRAINT `commento_utente` FOREIGN KEY (`utente`) REFERENCES `utenti` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `karma_commento` FOREIGN KEY (`commento`) REFERENCES `commenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `karma_contenuti`
--
ALTER TABLE `karma_contenuti`
  ADD CONSTRAINT `contenuto_utente` FOREIGN KEY (`utente`) REFERENCES `utenti` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `karma_contenuto` FOREIGN KEY (`contenuto`) REFERENCES `contenuti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
