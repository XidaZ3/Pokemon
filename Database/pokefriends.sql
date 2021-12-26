-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 26, 2021 alle 19:59
-- Versione del server: 10.4.17-MariaDB
-- Versione PHP: 7.2.34

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
-- Struttura della tabella `commenti`
--

CREATE TABLE `commenti` (
  `id` int(11) NOT NULL,
  `utente` int(11) NOT NULL,
  `testo` tinytext COLLATE utf8_bin NOT NULL,
  `contenuto` int(11) DEFAULT NULL,
  `timestamp` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `contenuti`
--

CREATE TABLE `contenuti` (
  `id` int(11) NOT NULL,
  `path` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tipo` tinyint(4) NOT NULL DEFAULT 0,
  `titolo` tinytext COLLATE utf8_bin NOT NULL,
  `data_creazione` date NOT NULL DEFAULT current_timestamp(),
  `editore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `contenuti`
--

INSERT INTO `contenuti` (`id`, `path`, `tipo`, `titolo`, `data_creazione`, `editore`) VALUES
(19, 'arceus', 0, 'Come ottenere Arceus in 4a generazione', '2021-12-24', 9),
(20, 'ditto', 0, 'Come catturare Ditto in Pokèmon Diamante Brillante e Perla Splendente', '2021-12-24', 9),
(21, 'twoberrymagikarp', 0, 'Come aumentare il livello dei Magikarp velocemente in Magikarp Jump', '2021-12-24', 9),
(22, 'decimastagione', 1, 'Svelata la decima stagione della Lega Lotte Go', '2021-12-22', 9),
(23, 'mewundertruck', 1, 'C\'è un Mew nascosto sotto il camioncino in Pokèmon Rosso e Blu', '2021-12-17', 9),
(24, 'pokemonsocialimpact', 1, 'Pokemon Go e il suo impatto sociale', '2021-12-21', 9),
(25, 'pokemonstory', 1, 'La Storia di Pokèmon', '2021-12-09', 9),
(26, 'php134', 0, 'Vediamo se funziona', '2021-12-24', 9);

-- --------------------------------------------------------

--
-- Struttura della tabella `karma_commenti`
--

CREATE TABLE `karma_commenti` (
  `id` int(11) NOT NULL,
  `commento` int(11) NOT NULL,
  `utente` int(11) NOT NULL,
  `valore` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `karma_contenuti`
--

CREATE TABLE `karma_contenuti` (
  `id` int(11) NOT NULL,
  `contenuto` int(11) NOT NULL,
  `valore` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `email` varchar(320) COLLATE utf8_bin NOT NULL,
  `password` varchar(60) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `username` varchar(30) COLLATE utf8_bin NOT NULL,
  `privilegio` tinyint(4) NOT NULL,
  `data_iscrizione` date NOT NULL DEFAULT current_timestamp(),
  `attivo` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `email`, `password`, `username`, `privilegio`, `data_iscrizione`, `attivo`) VALUES
(9, 'prova@gmail.com', '$2y$10$rx4qtx2dLrUq7Xpvm81iGupb71kJeYNpZtBFBwJb9ATjM0.iyj.hu', 'pieri', 1, '2021-12-16', 1),
(43, 'gianni@gmail.com', '$2y$10$M4r7JxoMS7JiS7/ABVtZKeE8sLJZ6PPAQlaZqypxvCWYL1WIj4Z1.', 'carlo', 0, '2021-12-23', 1),
(44, 'carlo@gasdf', '$2y$10$XAm7.Or258CZ7HOm.OPPVO/8A8ZYsN20.uGLOJp/RvPSHT3ILABr6', 'mario', 0, '2021-12-23', 1),
(47, 'paolo@gmail.com', '$2y$10$aYlBpwMU7jJWW3yv3NoHwOQdYVnrRW6mSATgP4oqBlkE/3TOPB10e', 'arturo', 0, '2021-12-23', 1);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `commenti`
--
ALTER TABLE `commenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content` (`contenuto`),
  ADD KEY `utente` (`utente`);

--
-- Indici per le tabelle `contenuti`
--
ALTER TABLE `contenuti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `path` (`path`) USING HASH,
  ADD KEY `editore` (`editore`);

--
-- Indici per le tabelle `karma_commenti`
--
ALTER TABLE `karma_commenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commento` (`commento`),
  ADD KEY `utente` (`utente`);

--
-- Indici per le tabelle `karma_contenuti`
--
ALTER TABLE `karma_contenuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contenuto` (`contenuto`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `commenti`
--
ALTER TABLE `commenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `contenuti`
--
ALTER TABLE `contenuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT per la tabella `karma_commenti`
--
ALTER TABLE `karma_commenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `karma_contenuti`
--
ALTER TABLE `karma_contenuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `commenti`
--
ALTER TABLE `commenti`
  ADD CONSTRAINT `content` FOREIGN KEY (`contenuto`) REFERENCES `contenuti` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `utente` FOREIGN KEY (`utente`) REFERENCES `utenti` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `contenuti`
--
ALTER TABLE `contenuti`
  ADD CONSTRAINT `editore` FOREIGN KEY (`editore`) REFERENCES `utenti` (`id`);

--
-- Limiti per la tabella `karma_commenti`
--
ALTER TABLE `karma_commenti`
  ADD CONSTRAINT `karma_commento` FOREIGN KEY (`commento`) REFERENCES `commenti` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `karma_contenuti`
--
ALTER TABLE `karma_contenuti`
  ADD CONSTRAINT `contenuto` FOREIGN KEY (`contenuto`) REFERENCES `contenuti` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
