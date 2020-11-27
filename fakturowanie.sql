-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 27 Lis 2020, 22:41
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
  `data_sprzedazy` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `faktura`
--

INSERT INTO `faktura` (`id_faktura`, `numer_faktury`, `id_nabywca`, `id_status`, `data_wystawienia`, `data_sprzedazy`) VALUES
(1, '12461/2020', 1, 2, '2020-11-26', '2020-11-24'),
(3, '00000/2020', 1, 3, '2020-11-19', '2020-11-20'),
(4, '2020/3030', 1, 3, '2018-06-01', '2018-06-01');

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
(1, 1, 31),
(1, 3, 999),
(3, 1, 24124214);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nabywca`
--

CREATE TABLE `nabywca` (
  `id_nabywca` int(11) NOT NULL,
  `nazwa_nabywcy` varchar(40) NOT NULL,
  `adres` varchar(200) NOT NULL,
  `NIP` int(10) NOT NULL,
  `email_nabywcy` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `nabywca`
--

INSERT INTO `nabywca` (`id_nabywca`, `nazwa_nabywcy`, `adres`, `NIP`, `email_nabywcy`) VALUES
(1, 'Firma A', 'Daleko 39-205 RZESZÓW', 1234567891, 'test@gmail.com');

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
(1, 'Zapłacona'),
(2, 'Nie zapłacona'),
(3, 'Częściowo opłacona');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `towar`
--

CREATE TABLE `towar` (
  `id_towar` int(11) NOT NULL,
  `nazwa` varchar(40) NOT NULL,
  `cena` float NOT NULL,
  `jednostka_miary` varchar(5) NOT NULL,
  `stawka_vat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `towar`
--

INSERT INTO `towar` (`id_towar`, `nazwa`, `cena`, `jednostka_miary`, `stawka_vat`) VALUES
(1, 'Cement', 12.5, 'KG', 23),
(3, 'Ziemniaki', 50.45, 'KG', 11);

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
  ADD PRIMARY KEY (`id_towar`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `faktura`
--
ALTER TABLE `faktura`
  MODIFY `id_faktura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `nabywca`
--
ALTER TABLE `nabywca`
  MODIFY `id_nabywca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `status`
--
ALTER TABLE `status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `towar`
--
ALTER TABLE `towar`
  MODIFY `id_towar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
