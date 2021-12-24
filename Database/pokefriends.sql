-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 24, 2021 alle 15:33
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
  `padre` int(11) DEFAULT NULL,
  `contenuto` int(11) DEFAULT NULL,
  `timestamp` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `commenti`
--

INSERT INTO `commenti` (`id`, `utente`, `testo`, `padre`, `contenuto`, `timestamp`) VALUES
(2, 9, 'Bel commento', NULL, 18, '2021-12-24');

-- --------------------------------------------------------

--
-- Struttura della tabella `contenuti`
--

CREATE TABLE `contenuti` (
  `id` int(11) NOT NULL,
  `path` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tipo` tinyint(4) NOT NULL DEFAULT 0,
  `titolo` tinytext COLLATE utf8_bin NOT NULL,
  `data_creazione` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `contenuti`
--

INSERT INTO `contenuti` (`id`, `path`, `tipo`, `titolo`, `data_creazione`) VALUES
(5, 'Prova', 0, 'Come ottenere Arceus in Gen 4', '2021-12-23'),
(7, 'mew', 1, 'La leggenda di Mew sotto il camioncino', '2021-12-23'),
(18, 'php75C8', 1, 'Mew Pazzo sgravato', '2021-12-24');

-- --------------------------------------------------------

--
-- Struttura della tabella `karma_commenti`
--

CREATE TABLE `karma_commenti` (
  `id` int(11) NOT NULL,
  `commento` int(11) NOT NULL,
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

--
-- Dump dei dati per la tabella `karma_contenuti`
--

INSERT INTO `karma_contenuti` (`id`, `contenuto`, `valore`) VALUES
(1, 5, 1),
(2, 5, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(32) NOT NULL,
  `email` varchar(320) COLLATE utf8_bin NOT NULL,
  `password` varchar(60) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `username` varchar(30) COLLATE utf8_bin NOT NULL,
  `privilegio` tinyint(4) NOT NULL,
  `data_iscrizione` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `email`, `password`, `username`, `privilegio`, `data_iscrizione`) VALUES
(9, 'prova@gmail.com', '$2y$10$rx4qtx2dLrUq7Xpvm81iGupb71kJeYNpZtBFBwJb9ATjM0.iyj.hu', 'pieri', 1, '2021-12-16'),
(43, 'gianni@gmail.com', '$2y$10$M4r7JxoMS7JiS7/ABVtZKeE8sLJZ6PPAQlaZqypxvCWYL1WIj4Z1.', 'carlo', 0, '2021-12-23'),
(44, 'carlo@gasdf', '$2y$10$XAm7.Or258CZ7HOm.OPPVO/8A8ZYsN20.uGLOJp/RvPSHT3ILABr6', 'mario', 0, '2021-12-23'),
(47, 'paolo@gmail.com', '$2y$10$aYlBpwMU7jJWW3yv3NoHwOQdYVnrRW6mSATgP4oqBlkE/3TOPB10e', 'arturo', 0, '2021-12-23');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `commenti`
--
ALTER TABLE `commenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `padre` (`padre`),
  ADD KEY `content` (`contenuto`),
  ADD KEY `utente` (`utente`);

--
-- Indici per le tabelle `contenuti`
--
ALTER TABLE `contenuti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `path` (`path`) USING HASH;

--
-- Indici per le tabelle `karma_commenti`
--
ALTER TABLE `karma_commenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commento` (`commento`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `contenuti`
--
ALTER TABLE `contenuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `commenti`
--
ALTER TABLE `commenti`
  ADD CONSTRAINT `content` FOREIGN KEY (`contenuto`) REFERENCES `contenuti` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `padre` FOREIGN KEY (`padre`) REFERENCES `commenti` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `utente` FOREIGN KEY (`utente`) REFERENCES `utenti` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
