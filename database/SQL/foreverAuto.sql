-- Host: localhost
-- Creato il: Apr 11, 2025 alle 14:20
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Database: `foreverAuto`
--

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
  `codCategoria` int(11) NOT NULL,
  `tipo` varchar(25) NOT NULL,
  `descrizione` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `concessionarie`
--

CREATE TABLE `concessionarie` (
  `partitaIva` int(11) NOT NULL,
  `ragSociale` varchar(50) NOT NULL,
  `sede` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `credenziali`
--

CREATE TABLE `credenziali` (
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `codCategoria` int(11) NOT NULL,
  `concessionaria` int(11) NOT NULL,
  `kilometri` int(11) NOT NULL,
  `proprietariPrecedenti` int(11) NOT NULL,
  `venduto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`codCarrello`,`numTelaio`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`codCategoria`);

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
  ADD KEY `categoria` (`codCategoria`);

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
  MODIFY `codCarrello` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `codCategoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `notifiche`
--
ALTER TABLE `notifiche`
  MODIFY `codNotifica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `vendite`
--
ALTER TABLE `vendite`
  MODIFY `codVendita` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `categoria` FOREIGN KEY (`codCategoria`) REFERENCES `categorie` (`codCategoria`),
  ADD CONSTRAINT `concessionaria` FOREIGN KEY (`concessionaria`) REFERENCES `concessionarie` (`partitaIva`);

--
-- Limiti per la tabella `vendite`
--
ALTER TABLE `vendite`
  ADD CONSTRAINT `codCarrelloVendita` FOREIGN KEY (`codCarrello`) REFERENCES `carrelli` (`codCarrello`);
COMMIT;