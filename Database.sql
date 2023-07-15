-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Lug 15, 2023 alle 15:31
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
-- Database: `progetto`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `fonte`
--

CREATE TABLE `fonte` (
  `id` int(11) NOT NULL,
  `link` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `fonte`
--

INSERT INTO `fonte` (`id`, `link`) VALUES
(4, 'initalia.virgilio.it'),
(5, 'www.dailymotion.com'),
(1, 'www.iltempo.it'),
(3, 'www.vanityfair.it');

-- --------------------------------------------------------

--
-- Struttura della tabella `lista_nera`
--

CREATE TABLE `lista_nera` (
  `id_utente` int(11) NOT NULL,
  `id_fonte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `lista_nera`
--

INSERT INTO `lista_nera` (`id_utente`, `id_fonte`) VALUES
(4, 1),
(4, 3),
(4, 4),
(4, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `notizia`
--

CREATE TABLE `notizia` (
  `id` int(11) NOT NULL,
  `link` varchar(256) DEFAULT NULL,
  `argomento` varchar(256) DEFAULT NULL,
  `tipo` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `notizia`
--

INSERT INTO `notizia` (`id`, `link`, `argomento`, `tipo`) VALUES
(40, 'https://www.vanityfair.it/lifestyle/animali/2019/05/21/australia-sos-koala-si-stanno-estinguendo-e-possibile-salvarli', 'Estinzione dei koala in Australia.', 'testo'),
(41, 'https://animalfactguide.com/tag/koala/', 'Viaggiare con gli animali domestici', 'testo'),
(42, 'https://www.euronews.com/green/2020/06/30/why-devastating-loss-of-koalas-could-make-them-extinct-by-2050', 'Estinzione dei koala entro il 2050.', 'testo'),
(43, 'https://www.flickr.com/photos/antonellafoti/35529445234', 'Escursione di arrampicata a strapiombo.', 'testo'),
(44, 'https://initalia.virgilio.it/scogliere-italiane-affascinanti-e-di-grande-impatto-scenografico-4898', 'Scogliere italiane.', 'testo'),
(45, 'https://www.dailymotion.com/video/x7bhm1w', 'Celebrità e curiosità', 'testo'),
(47, 'https://www.iltempo.it/esteri/2023/07/02/news/francia-scontri-disordini-rivolte-proteste-nahel-auto-fiamme-36271079/', 'Scontri in Francia', 'testo'),
(48, 'https://www.vanityfair.it/lifestyle/animali/2019/05/21/australia-sos-koala-si-stanno-estinguendo-e-possibile-salvarli', 'Estinzione dei Koala in Australia', 'testo'),
(49, 'https://siviaggia.it/viaggi/fotonotizia/scogliere-piu-belle-italia/326986/', 'Natura.', 'testo'),
(50, 'https://www.repubblica.it/economia/2023/07/08/news/berlusconi_figli_tasse_eredita_successione-407020605/', 'Risposta: Economia', 'testo');

-- --------------------------------------------------------

--
-- Struttura della tabella `segnalazione`
--

CREATE TABLE `segnalazione` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) DEFAULT NULL,
  `id_notizia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `segnalazione`
--

INSERT INTO `segnalazione` (`id`, `id_utente`, `id_notizia`) VALUES
(36, 4, 40),
(37, 4, 41),
(38, 4, 42),
(39, 4, 43),
(40, 4, 44),
(41, 4, 45),
(42, 4, 45),
(43, 4, 47),
(44, 4, 40),
(45, 4, 49),
(46, 4, 50);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `nome`, `email`, `password`) VALUES
(4, 'Danymine', 'dparisi778@gmail.com', '6d91317463ff828c3f5e38d74f1c4f09');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `fonte`
--
ALTER TABLE `fonte`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `link` (`link`);

--
-- Indici per le tabelle `lista_nera`
--
ALTER TABLE `lista_nera`
  ADD PRIMARY KEY (`id_utente`,`id_fonte`),
  ADD KEY `id_fonte` (`id_fonte`);

--
-- Indici per le tabelle `notizia`
--
ALTER TABLE `notizia`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `segnalazione`
--
ALTER TABLE `segnalazione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_notizia` (`id_notizia`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `fonte`
--
ALTER TABLE `fonte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `notizia`
--
ALTER TABLE `notizia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT per la tabella `segnalazione`
--
ALTER TABLE `segnalazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `lista_nera`
--
ALTER TABLE `lista_nera`
  ADD CONSTRAINT `lista_nera_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`),
  ADD CONSTRAINT `lista_nera_ibfk_2` FOREIGN KEY (`id_fonte`) REFERENCES `fonte` (`id`);

--
-- Limiti per la tabella `segnalazione`
--
ALTER TABLE `segnalazione`
  ADD CONSTRAINT `segnalazione_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`),
  ADD CONSTRAINT `segnalazione_ibfk_2` FOREIGN KEY (`id_notizia`) REFERENCES `notizia` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
