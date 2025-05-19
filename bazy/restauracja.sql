-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 20, 2025 at 01:26 AM
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
-- Struktura tabeli dla tabeli `opinie`
--

CREATE TABLE `opinie` (
  `id` int(11) NOT NULL,
  `uzytkownik_id` int(11) DEFAULT NULL,
  `imie` varchar(100) DEFAULT NULL,
  `tresc` text DEFAULT NULL,
  `data_dodania` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opinie`
--

INSERT INTO `opinie` (`id`, `uzytkownik_id`, `imie`, `tresc`, `data_dodania`) VALUES
(1, NULL, 'Ewa', 'Polecam.', '2025-05-18 23:13:33'),
(2, NULL, 'Marek', 'Rewelacyjne miejsce! Jedzenie przepyszne, obsługa bardzo miła i pomocna. Zdecydowanie polecam', '2025-05-18 23:23:32'),
(3, NULL, 'Janek', 'Fajna restauracja', '2025-05-19 00:13:32'),
(5, NULL, 'Dominik', 'Cudowne miejsce! Jedzenie przepyszne, obsługa bardzo miła i pomocna. Zdecydowanie polecam! UwU', '2025-05-19 22:09:26');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pytania`
--

CREATE TABLE `pytania` (
  `id` int(11) NOT NULL,
  `uzytkownik_id` int(11) DEFAULT NULL,
  `imie` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tresc` text NOT NULL,
  `data_dodania` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pytania`
--

INSERT INTO `pytania` (`id`, `uzytkownik_id`, `imie`, `email`, `tresc`, `data_dodania`) VALUES
(1, 9, 'Ewa', 'ewanowak@gmail.com', 'Jakie są godziny otwarcia?', '2025-05-20 01:02:20'),
(2, 9, 'Ewa', 'ewanowak@gmail.com', 'Czy jest możliwość organizacji przyjęć?', '2025-05-20 01:13:06'),
(3, 9, 'Jan', 'jan_kowalski12@gmail.com', 'Jaki jest numer kontaktowy?', '2025-05-20 01:16:15');

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
  `stolik_nr` int(11) NOT NULL,
  `uzytkownik_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rezerwacje`
--

INSERT INTO `rezerwacje` (`id`, `imie`, `nazwisko`, `telefon`, `data`, `godzina`, `ilosc_osob`, `stolik_nr`, `uzytkownik_id`) VALUES
(1, 'Anna', 'Kowalska', '+48-123-456-789', '2025-05-12', '18:00:00', 2, 5, NULL),
(2, 'Jan', 'Nowak', '+48-987-654-321', '2025-05-12', '19:30:00', 4, 3, NULL),
(3, 'Piotr', 'Zieliński', '+48-555-333-222', '2025-05-13', '20:00:00', 6, 7, NULL),
(4, 'Maria', 'Wiśniewska', '+48-111-222-333', '2025-05-14', '17:00:00', 2, 1, NULL),
(5, 'Tomasz', 'Kaczmarek', '+48-444-555-666', '2025-05-14', '18:30:00', 3, 4, NULL),
(6, 'Karolina', 'Mazur', '+48-222-333-444', '2025-05-15', '19:00:00', 5, 6, NULL),
(7, 'Michał', 'Dąbrowski', '+48-666-777-888', '2025-05-15', '20:30:00', 2, 2, NULL),
(8, 'Ewa', 'Lewandowska', '+48-999-000-111', '2025-05-16', '18:15:00', 1, 8, NULL),
(9, 'Robert', 'Wójcik', '+48-888-999-000', '2025-05-16', '21:00:00', 4, 9, NULL),
(59, 'aaaaaaaaaa', 'adscfsdg', '+48-746-874-699', '2025-05-08', '21:00:00', 1, 1, NULL),
(60, 'aaaaaaaaaa', 'adscfsdg', '+48-746-874-699', '2025-05-08', '21:00:00', 1, 2, NULL),
(61, 'aaaaaaaaaa', 'adscfsdg', '+48-746-874-699', '2025-05-08', '21:00:00', 1, 3, NULL),
(62, 'aaaaaaaaaa', 'adscfsdg', '+48-746-874-699', '2025-05-08', '21:00:00', 1, 4, NULL),
(63, 'aaaaaaaaaa', 'adscfsdg', '+48-746-874-699', '2025-05-08', '21:00:00', 1, 5, NULL),
(64, 'aaaaaaaaaa', 'adscfsdg', '+48-746-874-699', '2025-05-08', '14:00:00', 1, 1, NULL),
(65, 'aaaaaaaaaa', 'adscfsdg', '+48-746-874-699', '2025-05-08', '20:00:00', 1, 1, NULL),
(66, 'aaaaaaaaaa', 'adscfsdg', '+48-746-874-699', '2025-05-08', '20:00:00', 1, 2, NULL),
(67, 'aaaaaaaaaa', 'adscfsdg', '+48-746-874-699', '2025-05-08', '20:00:00', 1, 3, NULL),
(68, 'aaaaaaaaaa', 'adscfsdg', '+48-746-874-699', '2025-05-08', '20:00:00', 1, 4, NULL),
(69, 'aaaaaaaaaa', 'adscfsdg', '+48-746-874-699', '2025-05-08', '20:00:00', 1, 5, NULL),
(70, 'aaaaaaaaaa', 'adscfsdg', '+48-345-525-454', '2025-05-08', '13:00:00', 1, 1, NULL),
(71, 'aaaaaaaaaa', 'adscfsdg', '+48-345-525-454', '2025-05-08', '13:00:00', 1, 2, NULL),
(72, 'aaaaaaaaaa', 'adscfsdg', '+48-345-525-454', '2025-05-08', '14:00:00', 1, 2, NULL),
(73, 'aaaaaaaaaa', 'adscfsdg', '+48-345-525-454', '2025-05-08', '14:00:00', 1, 3, NULL);

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
(8, 'Ewa', 'Kaczmarek', 'ewka', 'ewa.kaczmarek@example.com', '$2y$10$Pass1234SecureHashTestAB', 'admin'),
(9, 'Zofia', 'Kowalska', 'zofia_k', 'zofiakowalska@gmail.com', '$2y$10$V.V0fKaevF0ysKOeAWekx.LGI3m2L7KkKHgQtG3KFvvMQAi.pPrZu', 'uzytkownik');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `opinie`
--
ALTER TABLE `opinie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `pytania`
--
ALTER TABLE `pytania`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rezerwacje_uzytkownik` (`uzytkownik_id`);

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
-- AUTO_INCREMENT for table `opinie`
--
ALTER TABLE `opinie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pytania`
--
ALTER TABLE `pytania`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `opinie`
--
ALTER TABLE `opinie`
  ADD CONSTRAINT `opinie_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pytania`
--
ALTER TABLE `pytania`
  ADD CONSTRAINT `pytania_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pytania_ibfk_2` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD CONSTRAINT `fk_rezerwacje_uzytkownik` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
