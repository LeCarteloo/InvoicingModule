-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Sty 2021, 11:34
-- Wersja serwera: 10.4.16-MariaDB
-- Wersja PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `fakturowanie`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `faktura`
--

CREATE TABLE `faktura` (
  `id_faktura` int(11) NOT NULL,
  `numer_faktury` varchar(16) NOT NULL,
  `id_nabywca` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `data_wystawienia` date NOT NULL,
  `data_sprzedazy` date NOT NULL,
  `data_platnosci` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `faktura`
--

INSERT INTO `faktura` (`id_faktura`, `numer_faktury`, `id_nabywca`, `id_status`, `data_wystawienia`, `data_sprzedazy`, `data_platnosci`) VALUES
(4, '1/2021/0109', 1, 1, '2021-01-09', '2021-01-07', '2021-01-08'),
(5, '2/2021/0109', 1, 1, '2021-01-09', '2021-01-14', '2021-02-03'),
(6, '3/2021/0109', 1, 1, '2021-01-09', '2021-01-03', '2021-01-04'),
(7, '4/2021/0109', 1, 1, '2021-01-09', '2021-01-20', '2021-01-03'),
(8, '5/2021/0109', 1, 1, '2021-01-09', '2021-01-09', '2021-01-09'),
(9, '6/2021/0109', 1, 1, '2021-01-09', '2021-01-20', '2021-01-06'),
(10, '7/2021/0109', 1, 1, '2021-01-09', '2021-01-20', '2021-01-15'),
(11, '8/2021/0109', 1, 1, '2021-01-09', '2021-01-29', '2021-01-17'),
(12, '9/2021/0109', 1, 1, '2021-01-09', '2021-01-29', '2021-01-23'),
(13, '1/2021/0116', 1, 2, '2021-01-16', '2021-01-01', '2021-01-31'),
(14, '1/2021/0117', 1, 2, '2021-01-17', '2021-01-31', '2021-01-06'),
(15, '2/2021/0117', 1, 2, '2021-01-17', '2021-01-13', '2021-01-22'),
(16, '3/2021/0117', 1, 2, '2021-01-17', '2021-01-14', '2021-01-14'),
(17, '4/2021/0117', 1, 2, '2021-01-17', '2021-02-05', '2021-01-06'),
(18, '5/2021/0117', 1, 2, '2021-01-17', '2021-01-01', '2021-01-03'),
(19, '6/2021/0117', 1, 1, '2021-01-17', '2021-01-06', '2021-01-31'),
(20, '7/2021/0117', 1, 1, '2021-01-17', '2021-01-29', '2021-01-08'),
(21, '1/2021/0118', 4, 2, '2021-01-18', '2021-01-14', '2021-01-15'),
(22, '9/2021/0117', 1, 2, '2021-01-07', '2021-01-07', '2021-01-09'),
(23, '1/2021/0119', 3, 2, '2021-01-19', '2021-01-01', '2021-01-31'),
(24, '2/2021/0119', 1, 2, '2021-01-19', '2021-01-09', '2021-01-14'),
(25, '3/2021/0119', 4, 1, '2021-01-19', '2021-01-18', '2021-01-24');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `faktura_towar`
--

CREATE TABLE `faktura_towar` (
  `id_faktura` int(11) NOT NULL,
  `id_towar` int(11) NOT NULL,
  `ilość` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `faktura_towar`
--

INSERT INTO `faktura_towar` (`id_faktura`, `id_towar`, `ilość`) VALUES
(1, 1, 15),
(1, 2, 20),
(1, 3, 5),
(1, 4, 50),
(2, 2, 8),
(2, 4, 11),
(3, 1, 100),
(3, 1, 22),
(4, 1, 22),
(5, 1, 22),
(6, 1, 22),
(7, 1, 15),
(8, 1, 9),
(8, 2, 99),
(8, 3, 999),
(9, 1, 15),
(10, 4, 33),
(11, 3, 22),
(12, 4, 11),
(13, 1, 99),
(14, 1, 15),
(15, 1, 15),
(16, 1, 15),
(17, 1, 2),
(20, 95, 999),
(21, 90, 15),
(21, 96, 33),
(22, 100, 22),
(22, 99, 12),
(23, 1, 15),
(24, 4, 2),
(24, 5, 13),
(24, 6, 115),
(25, 8, 15),
(25, 6, 11);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nabywca`
--

CREATE TABLE `nabywca` (
  `id_nabywca` int(11) NOT NULL,
  `nazwa_nabywcy` varchar(40) NOT NULL,
  `adres` varchar(200) NOT NULL,
  `NIP` varchar(10) NOT NULL,
  `email_nabywcy` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `nabywca`
--

INSERT INTO `nabywca` (`id_nabywca`, `nazwa_nabywcy`, `adres`, `NIP`, `email_nabywcy`) VALUES
(1, 'Tracz Firma', 'Rzeszowska 13', '7622654927', 'email3@gmail.com'),
(2, 'Kowalska', 'Krakowska 12', '3892726480', 'email2@gmail.com'),
(3, 'Kokoski', 'Stara 16', '1010002231', 'email6@gmail.com'),
(4, 'Skok', 'Starsza 17', '1040001590', 'email7@gmail.com');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `status`
--

CREATE TABLE `status` (
  `id_status` int(11) NOT NULL,
  `status_faktury` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `status`
--

INSERT INTO `status` (`id_status`, `status_faktury`) VALUES
(1, 'Opłacona'),
(2, 'Nie opłacona');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `towar`
--

CREATE TABLE `towar` (
  `id_towar` int(11) NOT NULL,
  `nazwa` varchar(40) NOT NULL,
  `jednostka_miary` varchar(5) NOT NULL,
  `stawka_vat` int(11) NOT NULL,
  `cena` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `towar`
--

INSERT INTO `towar` (`id_towar`, `nazwa`, `jednostka_miary`, `stawka_vat`, `cena`) VALUES
(1, 'Skakanka', 'szt', 8, 20),
(2, 'Winogrono', 'kg', 8, 50),
(3, 'Jabłka', 'kg', 23, 8),
(4, 'Krem do rąk', 'szt', 23, 10),
(5, 'Szampon', 'szt', 23, 15),
(6, 'Lakier do paznokci', 'szt', 23, 20),
(7, 'Ziemniaki', 'kg', 23, 6),
(8, 'Lenovo G580', 'szt', 23, 2500),
(9, 'Ogórki', 'kg', 23, 14),
(10, 'Pomidory', 'kg', 23, 11),
(11, 'Mata do ćwiczń', 'szt', 23, 50),
(12, 'Piłka ', 'szt', 23, 90),
(13, 'Iphone 11', 'szt', 23, 4312),
(14, 'Nokia 3310', 'szt', 23, 12000),
(15, 'Czereśnie', 'kg', 23, 30);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `faktura`
--
ALTER TABLE `faktura`
  ADD PRIMARY KEY (`id_faktura`),
  ADD KEY `id_nabywca` (`id_status`,`id_nabywca`),
  ADD KEY `id_nabywca_2` (`id_nabywca`);

--
-- Indeksy dla tabeli `faktura_towar`
--
ALTER TABLE `faktura_towar`
  ADD KEY `id_faktura` (`id_towar`,`id_faktura`) USING BTREE,
  ADD KEY `id_faktura_2` (`id_faktura`);

--
-- Indeksy dla tabeli `nabywca`
--
ALTER TABLE `nabywca`
  ADD PRIMARY KEY (`id_nabywca`);

--
-- Indeksy dla tabeli `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indeksy dla tabeli `towar`
--
ALTER TABLE `towar`
  ADD PRIMARY KEY (`id_towar`),
  ADD UNIQUE KEY `nazwa` (`nazwa`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `faktura`
--
ALTER TABLE `faktura`
  MODIFY `id_faktura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT dla tabeli `nabywca`
--
ALTER TABLE `nabywca`
  MODIFY `id_nabywca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `status`
--
ALTER TABLE `status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `towar`
--
ALTER TABLE `towar`
  MODIFY `id_towar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `faktura`
--
ALTER TABLE `faktura`
  ADD CONSTRAINT `faktura_ibfk_1` FOREIGN KEY (`id_nabywca`) REFERENCES `nabywca` (`id_nabywca`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `faktura_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `faktura_towar`
--
ALTER TABLE `faktura_towar`
  ADD CONSTRAINT `faktura_towar_ibfk_1` FOREIGN KEY (`id_towar`) REFERENCES `towar` (`id_towar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `faktura_towar_ibfk_2` FOREIGN KEY (`id_faktura`) REFERENCES `faktura` (`id_faktura`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
