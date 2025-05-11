-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 11, 2025 at 10:21 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restauracja`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rezerwacje`
--

CREATE TABLE `rezerwacje` (
  `id` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `data` date NOT NULL,
  `godzina` time NOT NULL,
  `ilosc_osob` int(11) NOT NULL,
  `stolik_nr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rezerwacje`
--

INSERT INTO `rezerwacje` (`id`, `imie`, `nazwisko`, `telefon`, `data`, `godzina`, `ilosc_osob`, `stolik_nr`) VALUES
(1, 'Anna', 'Kowalska', '+48-123-456-789', '2025-05-12', '18:00:00', 2, 5),
(2, 'Jan', 'Nowak', '+48-987-654-321', '2025-05-12', '19:30:00', 4, 3),
(3, 'Piotr', 'Zieliński', '+48-555-333-222', '2025-05-13', '20:00:00', 6, 7),
(4, 'Maria', 'Wiśniewska', '+48-111-222-333', '2025-05-14', '17:00:00', 2, 1),
(5, 'Tomasz', 'Kaczmarek', '+48-444-555-666', '2025-05-14', '18:30:00', 3, 4),
(6, 'Karolina', 'Mazur', '+48-222-333-444', '2025-05-15', '19:00:00', 5, 6),
(7, 'Michał', 'Dąbrowski', '+48-666-777-888', '2025-05-15', '20:30:00', 2, 2),
(8, 'Ewa', 'Lewandowska', '+48-999-000-111', '2025-05-16', '18:15:00', 1, 8),
(9, 'Robert', 'Wójcik', '+48-888-999-000', '2025-05-16', '21:00:00', 4, 9);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `imie` varchar(50) DEFAULT NULL,
  `nazwisko` varchar(50) DEFAULT NULL,
  `nazwa_uzytkownika` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `haslo` varchar(200) DEFAULT NULL,
  `uprawnienia` enum('admin','uzytkownik') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `imie`, `nazwisko`, `nazwa_uzytkownika`, `email`, `haslo`, `uprawnienia`) VALUES
(1, 'Jan', 'Kowalski', 'janek123', 'jan.kowalski@example.com', '$2y$10$abcdefghijklmnopqrstuv', 'uzytkownik'),
(2, 'Anna', 'Nowak', 'anusia', 'anna.nowak@example.com', '$2y$10$zyxwvutsrqponmlkjihgfedc', 'admin'),
(3, 'Piotr', 'Zieliński', 'zielony', 'piotr.zielinski@example.com', '$2y$10$1234567890qwertyuiopasd', 'uzytkownik'),
(4, 'Katarzyna', 'Wiśniewska', 'kaska_w', 'katarzyna.w@example.com', '$2y$10$ABCDEFabcdef1234567890gh', 'uzytkownik'),
(5, 'Tomasz', 'Lewandowski', 'tom_lew', 'tomasz.lew@example.com', '$2y$10$HasloBezpieczne123456789', 'admin'),
(6, 'Monika', 'Dąbrowska', 'monidab', 'monika.dab@example.com', '$2y$10$qwertyuiopasdfghjklzxcvb', 'uzytkownik'),
(7, 'Marek', 'Szymański', 'mareksz', 'marek.szymanski@example.com', '$2y$10$ZXCVBNMasdfghjklqwertyuio', 'uzytkownik'),
(8, 'Ewa', 'Kaczmarek', 'ewka', 'ewa.kaczmarek@example.com', '$2y$10$Pass1234SecureHashTestAB', 'admin');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nazwa_uzytkownika` (`nazwa_uzytkownika`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
