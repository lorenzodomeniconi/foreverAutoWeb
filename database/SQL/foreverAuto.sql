-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Giu 04, 2025 alle 20:36
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foreverAuto`
--
CREATE DATABASE IF NOT EXISTS `foreverAuto` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `foreverAuto`;

-- --------------------------------------------------------

--
-- Struttura della tabella `acquirenti`
--

CREATE TABLE `acquirenti` (
  `codFiscale` varchar(16) NOT NULL,
  `nome` varchar(25) NOT NULL,
  `cognome` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `acquirenti`
--

INSERT INTO `acquirenti` (`codFiscale`, `nome`, `cognome`, `username`, `email`, `telefono`) VALUES
('DMNLNZ02E16H294X', 'Lorenzo', 'Domeniconi', 'lorenzoDome', 'lorenzo.domeniconi16@gmail.com', NULL),
('R4R4R4JJR4R4R4R4', 'Paolo', 'Rossi', 'paoloRossi', 'paolo.rossi@test.com', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `carrelli`
--

CREATE TABLE `carrelli` (
  `codCarrello` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `chiuso` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `carrelliSpecifici`
--

CREATE TABLE `carrelliSpecifici` (
  `codCarrello` int(11) NOT NULL,
  `numTelaio` varchar(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `tipo` varchar(25) NOT NULL,
  `descrizione` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`tipo`, `descrizione`) VALUES
('Supercar', 'Automobili di lusso.'),
('SUV', 'Veicoli dalle dimensioni importanti.'),
('Utilitarie', 'Il comfort è la principale qualità del veicolo.');

-- --------------------------------------------------------

--
-- Struttura della tabella `concessionarie`
--

CREATE TABLE `concessionarie` (
  `partitaIva` varchar(11) NOT NULL,
  `ragSociale` varchar(50) NOT NULL,
  `sede` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `concessionarie`
--

INSERT INTO `concessionarie` (`partitaIva`, `ragSociale`, `sede`, `telefono`, `email`, `username`) VALUES
('12234324234', 'Mdm Auto S.r.l.', 'Via dell\'Università 50, Cesena', NULL, 'mdmauto@test.com', 'mdmauto'),
('56534324298', 'KeCar S.r.l.', 'Via dell\'Università 50, Cesena', NULL, 'kecar@test.com', 'kecar');

-- --------------------------------------------------------

--
-- Struttura della tabella `credenziali`
--

CREATE TABLE `credenziali` (
  `username` varchar(25) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `credenziali`
--

INSERT INTO `credenziali` (`username`, `password`) VALUES
('kecar', '$2y$10$TQfw9kT/Z8nMWB.kTwXjoeFeRLDm8sfkojMUoIp/TwQBM/MiIXKk.'),
('lorenzoDome', '$2y$10$KuXTSiaxo8HBtCtS53w7h.U5kWbDHfPWw1zS4rWT34naLRf7ORdAG'),
('mdmauto', '$2y$10$L/NsxlZM7Wz/t2dnomqyOOvOsxoX1vEnTaAwYLzWfDVQLAAQZ1P6u'),
('paoloRossi', '$2y$10$.x.Y8yVYsHNbjaO3rbRWUOweFCW60qobGRE9rSB0T4rBG9VLj0tBW');

-- --------------------------------------------------------

--
-- Struttura della tabella `notifiche`
--

CREATE TABLE `notifiche` (
  `codNotifica` int(11) NOT NULL,
  `dataOra` datetime NOT NULL,
  `messaggio` varchar(100) NOT NULL,
  `nuova` tinyint(1) NOT NULL,
  `destinatario` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `veicoli`
--

CREATE TABLE `veicoli` (
  `numTelaio` varchar(17) NOT NULL,
  `marca` varchar(25) NOT NULL,
  `modello` varchar(25) NOT NULL,
  `descrizione` varchar(100) NOT NULL,
  `alimentazione` varchar(25) NOT NULL,
  `prezzo` int(10) NOT NULL,
  `categoria` varchar(25) NOT NULL,
  `concessionaria` varchar(11) NOT NULL,
  `kilometri` int(11) NOT NULL,
  `proprietariPrecedenti` int(11) NOT NULL,
  `venduto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `veicoli`
--

INSERT INTO `veicoli` (`numTelaio`, `marca`, `modello`, `descrizione`, `alimentazione`, `prezzo`, `categoria`, `concessionaria`, `kilometri`, `proprietariPrecedenti`, `venduto`) VALUES
('1234TFDT8476352GT', 'Lamborghini', 'Temerario', 'Lamborghini Temerario Blu.\r\nMotore 3L V8 ibrido 800 cavalli.', 'Benzina', 350000, 'Supercar', '12234324234', 0, 1, 0),
('4444TFDT8476352RE', 'Ferrari', 'Portofino', 'Ferrari Portofino cabrio.\r\nMotore 3L V8 540 cavalli.', 'Benzina', 189000, 'Supercar', '12234324234', 24900, 1, 0),
('66GTTFDT8476352OI', 'Ferrari', 'F8', 'Ferrari F8 Tributo MY2023.\r\nMotore V8 Bi-turbo 4L 800 cavalli.', 'Benzina', 293000, 'Supercar', '56534324298', 950, 1, 1),
('8765HYHY8476352OP', 'Fiat', 'Panda', 'Fiat Panda 4x4 Full Optional.\r\nMotore 1.6L 4 cilindri 95 cavalli.', 'GPL', 19000, 'Utilitarie', '12234324234', 10, 0, 0),
('JH89TFDT8476352MN', 'Porsche', 'Macan', 'Porsche Macan.\r\nMotore 2L V6 295 cavalli.', 'Benzina', 49000, 'SUV', '12234324234', 98000, 1, 1),
('JJ87TFDT8476352HH', 'Audi', 'Q3', 'Audi Q3 S line edition MY2023.\r\nMotore 2L 4 cilindri 150 cavalli.', 'Diesel', 39000, 'SUV', '56534324298', 19000, 1, 0),
('KJUYTFDT847635277', 'Audi', 'A1', 'Audi A1 MY2025.\r\nMotore 1.3L 3 cilindri 98 cavalli.\r\nDisponibile da ordinare.', 'Benzina', 21000, 'Utilitarie', '12234324234', 0, 0, 0),
('LO09TFDT8476352KJ', 'Renault', 'Clio', 'Renault Clio MY2024.\r\nMotore Benzina 3 cilindri 1.5L 105 cavalli', 'Benzina', 24900, 'Utilitarie', '56534324298', 13, 0, 0),
('LO21TFDT8476352KK', 'BMW', 'Serie1', 'BMW Serie 1 MY2019.\r\nMotore 2L Diesel 150 cavalli.', 'Diesel', 34000, 'Utilitarie', '56534324298', 45000, 2, 1),
('YT29TFDT8476352CX', 'Audi', 'A3', 'Audi A3 MY2025.\r\nMotore Diesel 2L 4 cilindri 150 cavalli.', 'Diesel', 39900, 'Utilitarie', '12234324234', 29000, 1, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `vendite`
--

CREATE TABLE `vendite` (
  `codVendita` int(11) NOT NULL,
  `codCarrello` int(11) NOT NULL,
  `dataOra` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `acquirenti`
--
ALTER TABLE `acquirenti`
  ADD PRIMARY KEY (`codFiscale`),
  ADD KEY `fk_username_acquirenti` (`username`) USING BTREE;

--
-- Indici per le tabelle `carrelli`
--
ALTER TABLE `carrelli`
  ADD PRIMARY KEY (`codCarrello`),
  ADD KEY `usernameCarrello` (`username`);

--
-- Indici per le tabelle `carrelliSpecifici`
--
ALTER TABLE `carrelliSpecifici`
  ADD PRIMARY KEY (`codCarrello`,`numTelaio`),
  ADD KEY `numTelaioCarrello` (`numTelaio`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`tipo`);

--
-- Indici per le tabelle `concessionarie`
--
ALTER TABLE `concessionarie`
  ADD PRIMARY KEY (`partitaIva`),
  ADD KEY `fk_username_concessionarie` (`username`) USING BTREE;

--
-- Indici per le tabelle `credenziali`
--
ALTER TABLE `credenziali`
  ADD PRIMARY KEY (`username`);

--
-- Indici per le tabelle `notifiche`
--
ALTER TABLE `notifiche`
  ADD PRIMARY KEY (`codNotifica`),
  ADD KEY `destinatario` (`destinatario`);

--
-- Indici per le tabelle `veicoli`
--
ALTER TABLE `veicoli`
  ADD PRIMARY KEY (`numTelaio`),
  ADD KEY `concessionaria` (`concessionaria`),
  ADD KEY `categoria` (`categoria`);

--
-- Indici per le tabelle `vendite`
--
ALTER TABLE `vendite`
  ADD PRIMARY KEY (`codVendita`),
  ADD KEY `codCarrelloVendita` (`codCarrello`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `carrelli`
--
ALTER TABLE `carrelli`
  MODIFY `codCarrello` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `notifiche`
--
ALTER TABLE `notifiche`
  MODIFY `codNotifica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `vendite`
--
ALTER TABLE `vendite`
  MODIFY `codVendita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `acquirenti`
--
ALTER TABLE `acquirenti`
  ADD CONSTRAINT `username` FOREIGN KEY (`username`) REFERENCES `credenziali` (`username`);

--
-- Limiti per la tabella `carrelli`
--
ALTER TABLE `carrelli`
  ADD CONSTRAINT `usernameCarrello` FOREIGN KEY (`username`) REFERENCES `credenziali` (`username`);

--
-- Limiti per la tabella `carrelliSpecifici`
--
ALTER TABLE `carrelliSpecifici`
  ADD CONSTRAINT `codCarrelloSpecifico` FOREIGN KEY (`codCarrello`) REFERENCES `carrelli` (`codCarrello`),
  ADD CONSTRAINT `numTelaioCarrello` FOREIGN KEY (`numTelaio`) REFERENCES `veicoli` (`numTelaio`);

--
-- Limiti per la tabella `concessionarie`
--
ALTER TABLE `concessionarie`
  ADD CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `credenziali` (`username`);

--
-- Limiti per la tabella `notifiche`
--
ALTER TABLE `notifiche`
  ADD CONSTRAINT `destinatario` FOREIGN KEY (`destinatario`) REFERENCES `credenziali` (`username`);

--
-- Limiti per la tabella `veicoli`
--
ALTER TABLE `veicoli`
  ADD CONSTRAINT `categoria` FOREIGN KEY (`categoria`) REFERENCES `categorie` (`tipo`),
  ADD CONSTRAINT `concessionaria` FOREIGN KEY (`concessionaria`) REFERENCES `concessionarie` (`partitaIva`);

--
-- Limiti per la tabella `vendite`
--
ALTER TABLE `vendite`
  ADD CONSTRAINT `codCarrelloVendita` FOREIGN KEY (`codCarrello`) REFERENCES `carrelli` (`codCarrello`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
