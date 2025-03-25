SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `balikdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `balikdb`;

CREATE TABLE `film` (
  `id` int(11) NOT NULL,
  `idAutora` int(11) NOT NULL,
  `nazovFilmu` varchar(30) NOT NULL,
  `popisFilmu` varchar(1000) DEFAULT NULL,
  `kategoria` varchar(15) DEFAULT NULL,
  `datumPremierySR` date DEFAULT NULL,
  `url` varchar(2083) DEFAULT NULL,
  `stav` varchar(20) DEFAULT 'neschvalene',
  `datumPridania` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `obsadenie` (
  `idObsadenia` int(11) NOT NULL,
  `pozicia` varchar(15) NOT NULL,
  `meno` varchar(30) NOT NULL,
  `priezvisko` varchar(30) DEFAULT NULL,
  `idFilmu` int(11) DEFAULT NULL,
  `stavObsadenia` varchar(20) DEFAULT 'neschvalene'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `pouzivatelia` (
  `idPouzivatela` int(11) NOT NULL,
  `firstname` varchar(256) DEFAULT NULL,
  `lastname` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `password` varchar(2048) DEFAULT NULL,
  `funkcia` varchar(20) DEFAULT 'user'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `poziadavka` (
  `idPoziadavky` int(11) NOT NULL,
  `nazovPozadovanehoFilmu` varchar(30) DEFAULT NULL,
  `popis` varchar(100) DEFAULT NULL,
  `odpovedAdmina` varchar(50) DEFAULT NULL,
  `idAdmina` int(11) DEFAULT NULL,
  `emailPozadovatela` varchar(256) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `film`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `obsadenie`
  ADD PRIMARY KEY (`idObsadenia`),
  ADD KEY `id_filmu__fk` (`idFilmu`);

ALTER TABLE `pouzivatelia`
  ADD PRIMARY KEY (`idPouzivatela`),
  ADD UNIQUE KEY `pouzivatelia_email_uindex` (`email`);

ALTER TABLE `poziadavka`
  ADD PRIMARY KEY (`idPoziadavky`);


ALTER TABLE `film`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `obsadenie`
  MODIFY `idObsadenia` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `pouzivatelia`
  MODIFY `idPouzivatela` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `poziadavka`
  MODIFY `idPoziadavky` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
