-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 01 nov 2015 kl 13:10
-- Serverversion: 5.6.17
-- PHP-version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `uppgift 4`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `anvandare`
--

CREATE TABLE IF NOT EXISTS `anvandare` (
  `namn` varchar(50) DEFAULT NULL,
  `efternamn` varchar(50) DEFAULT NULL,
  `adress` varchar(50) DEFAULT NULL,
  `telnr` varchar(20) DEFAULT NULL,
  `anvandarnamn` varchar(50) NOT NULL,
  PRIMARY KEY (`anvandarnamn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `anvandare`
--

INSERT INTO `anvandare` (`namn`, `efternamn`, `adress`, `telnr`, `anvandarnamn`) VALUES
('adam', 'andersson', 'v?stra kattarpsv?gen 2', '040 651553', 'adam'),
('Anders', 'Andersson', 'Pilgatan 2', '040 787878', 'anders-a'),
('Eva', 'Karlsson', 'ystadsgatan 23', '040 878754', 'eva_k'),
('Ingrid', 'Johansson', 'barav?gen 6', '073 56654', 'Ingrid'),
('Jennie', 'Persson', 'Alnarpsv?gen 45', '070 999887', 'j.persson'),
('Johan', 'Johansson', 'barav?gen 6', '073 566543', 'johan'),
('mia', 'sun', 'f?ltsgatan 8', '', 'mia.sun'),
('Parisa', 'Karimi Palm', 'Trossgatan 13', '040971443', 'parisak'),
('Paul', 'eriksson', 't?garpsv?gen 67', '070 100097', 'paul.e'),
('Per', 'Andersson', 'S?dergatan 12', '046 123325', 'per.andersson'),
('tony', 'mandar', 'getv?gen 6', '070-567878', 'tony.m');

-- --------------------------------------------------------

--
-- Tabellstruktur `bestallning`
--

CREATE TABLE IF NOT EXISTS `bestallning` (
  `bestallning_id` int(11) NOT NULL AUTO_INCREMENT,
  `anvandarnamn` varchar(50) DEFAULT NULL,
  `bok_id` int(11) DEFAULT NULL,
  `hamtningdatum` date DEFAULT NULL,
  `aterlamningdatum` date DEFAULT NULL,
  PRIMARY KEY (`bestallning_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumpning av Data i tabell `bestallning`
--

INSERT INTO `bestallning` (`bestallning_id`, `anvandarnamn`, `bok_id`, `hamtningdatum`, `aterlamningdatum`) VALUES
(1, 'parisak', 2, '2015-10-31', '2015-11-15'),
(3, 'parisak', 4, '2015-02-12', '2015-05-30'),
(5, 'johan', 10, '2015-10-31', '2015-11-15'),
(7, 'johan', 2, '2015-11-15', '2015-11-30'),
(41, 'johan ', 2, '2015-11-15', '2015-11-30'),
(42, 'johan ', 2, '2015-11-30', '2015-12-15'),
(43, 'johan ', 2, '2015-12-15', '2015-12-30'),
(44, 'anders-a ', 2, '2015-12-30', '2016-01-14'),
(45, 'anders-a ', 21, '2015-11-01', '2015-11-16'),
(46, 'anders-a ', 21, '2015-11-01', '2015-11-16'),
(47, 'anders-a ', 21, '2015-11-01', '2015-11-16'),
(48, 'anders-a ', 21, '2015-11-01', '2015-11-16'),
(49, 'mia.sun ', 32, '2015-11-01', '2015-11-16');

-- --------------------------------------------------------

--
-- Tabellstruktur `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `titel` varchar(255) DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumpning av Data i tabell `books`
--

INSERT INTO `books` (`book_id`, `titel`, `kategori_id`) VALUES
(1, 'Astronomisk kalender 2016 : Vad du kan se på himlen under året', 1),
(2, 'Handbok i matematik', 1),
(3, 'Illusionen om gud', 1),
(4, 'A brief history of time', 1),
(5, 'Tänk om - : Seriösa vetenskapliga svar på absurda hypotetiska frågor', 1),
(6, 'En kortfattad historik över nästan allting', 1),
(7, 'Ond kemi : berättelser om människor, mord och molekyler', 1),
(8, 'Fysik : vad som är värt att veta', 1),
(9, 'What if?', 1),
(10, 'Matematik : vad som är värt att veta', 1),
(11, 'Kriget har inget kvinnligt ansikte', 2),
(12, 'Lögnen', 2),
(13, 'LÄR DIG LEVA: Mindre stress - Mer närvaro', 2),
(14, 'Playground', 2),
(15, 'Konsten att höra hjärtslag', 2),
(16, 'Jordstorm', 2),
(17, 'Stalker', 2),
(18, 'Kaninen som så gärna ville somna : en annorlunda godnattsaga', 2),
(19, 'Himlen är alltid högre', 2),
(20, 'Den första lögnen', 2),
(21, 'Steve Jobs - en biografi', 3),
(22, 'Ingen lätt dag : en elitsoldats självbiografi', 3),
(23, 'Led Zeppelin : en biografi', 3),
(24, 'Northug : en biografi', 3),
(25, 'Stenbeck : en biografi över en framgångsrik affärsman', 3),
(26, 'Denna dagen, ett liv : En biografi över Astrid Lindgren', 3),
(27, 'Hillary Rodham Clinton : en politisk biografi', 3),
(28, 'Kruka : en biografi om Suzanne Brøgger', 3),
(29, 'ID-bricka En barnmorskas biografi', 3),
(30, 'Charles Bukowski : biografi', 3),
(31, 'Vår trädkoja med 13 våningar', 4),
(32, 'Titta, lampa!', 4),
(33, 'Hej Ruby : äventyr i datorernas magiska värld', 4),
(34, 'Hej Ruby : äventyr i datorernas magiska värld', 4),
(35, 'PlaygroundProblem Solving and Program Design in C, Global Edition', 4),
(36, 'De underkända', 4),
(37, 'I sanningens namn', 4),
(38, 'Mellan fyra ögon', 4),
(39, 'Hur smart är din hund : praktiska övningar att göra hemma', 4),
(40, 'Gatukatten Bob', 4);

-- --------------------------------------------------------

--
-- Tabellstruktur `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
  `kategori_id` int(11) NOT NULL AUTO_INCREMENT,
  `namn` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kategori_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `namn`) VALUES
(1, 'vetenskaplig'),
(2, 'skonliteratur'),
(3, 'biografi'),
(4, 'ovrigt');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
