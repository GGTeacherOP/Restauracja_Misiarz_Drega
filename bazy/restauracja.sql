-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 25, 2025 at 10:50 PM
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
-- Struktura tabeli dla tabeli `odpowiedzi`
--

CREATE TABLE `odpowiedzi` (
  `id` int(11) NOT NULL,
  `pytanie_id` int(11) NOT NULL,
  `uzytkownik_id` int(11) NOT NULL,
  `tresc` text NOT NULL,
  `data_dodania` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `odpowiedzi`
--

INSERT INTO `odpowiedzi` (`id`, `pytanie_id`, `uzytkownik_id`, `tresc`, `data_dodania`) VALUES
(1, 2, 14, 'Tak, w razie potrzeby proszę dzwonić pod numer: 123 456 789.', '2025-05-25 22:34:46');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opinie`
--

CREATE TABLE `opinie` (
  `id` int(11) NOT NULL,
  `uzytkownik_id` int(11) DEFAULT NULL,
  `nazwa_uzytkownika` varchar(100) NOT NULL,
  `tresc` text DEFAULT NULL,
  `data_dodania` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opinie`
--

INSERT INTO `opinie` (`id`, `uzytkownik_id`, `nazwa_uzytkownika`, `tresc`, `data_dodania`) VALUES
(1, NULL, 'Ewa', 'Polecam.', '2025-05-18 23:13:33'),
(2, NULL, 'Marek', 'Rewelacyjne miejsce! Jedzenie przepyszne, obsługa bardzo miła i pomocna. Zdecydowanie polecam', '2025-05-18 23:23:32'),
(3, NULL, 'Janek', 'Fajna restauracja', '2025-05-19 00:13:32'),
(5, NULL, 'Dominik', 'Cudowne miejsce! Jedzenie przepyszne, obsługa bardzo miła i pomocna. Zdecydowanie polecam! UwU', '2025-05-19 22:09:26');

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `opinie_z_uzytkownikami`
-- (See below for the actual view)
--
CREATE TABLE `opinie_z_uzytkownikami` (
`id` int(11)
,`tresc` text
,`data_dodania` datetime
,`nazwa_uzytkownika` varchar(50)
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id` int(11) NOT NULL,
  `uzytkownik_id` int(11) DEFAULT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `stanowisko` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `pensja` decimal(10,2) NOT NULL,
  `data_zatrudnienia` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pracownicy`
--

INSERT INTO `pracownicy` (`id`, `uzytkownik_id`, `imie`, `nazwisko`, `stanowisko`, `email`, `telefon`, `pensja`, `data_zatrudnienia`) VALUES
(1, NULL, 'Anna', 'Nowak', 'Szef kuchni', 'anna.nowak@restauracja.pl', '+48 123 456 789', 6500.00, '2022-01-15'),
(2, NULL, 'Piotr', 'Kowalski', 'Kucharz', 'piotr.kowalski@restauracja.pl', '+48 234 567 890', 5200.00, '2022-03-10'),
(3, NULL, 'Marta', 'Wiśniewska', 'Pomoc kuchenna', 'marta.wisniewska@restauracja.pl', '+48 345 678 901', 3800.00, '2023-02-20'),
(4, NULL, 'Krzysztof', 'Wójcik', 'Barman', 'krzysztof.wojcik@restauracja.pl', '+48 456 789 012', 4800.00, '2021-11-05'),
(5, NULL, 'Alicja', 'Kowalczyk', 'Kelner', 'alicja.kowalczyk@restauracja.pl', '+48 567 890 123', 4200.00, '2023-01-10'),
(6, NULL, 'Marek', 'Kamiński', 'Kelner', 'marek.kaminski@restauracja.pl', '+48 678 901 234', 4200.00, '2023-04-15'),
(7, NULL, 'Joanna', 'Lewandowska', 'Manager', 'joanna.lewandowska@restauracja.pl', '+48 789 012 345', 7200.00, '2020-08-22'),
(8, NULL, 'Tomasz', 'Dąbrowski', 'Pracownik magazynu', 'tomasz.dabrowski@restauracja.pl', '+48 890 123 456', 3600.00, '2023-05-10'),
(9, NULL, 'Barbara', 'Szymańska', 'Hostessa', 'barbara.szymanska@restauracja.pl', '+48 901 234 567', 4000.00, '2022-09-01'),
(10, NULL, 'Grzegorz', 'Woźniak', 'Kucharz', 'grzegorz.wozniak@restauracja.pl', '+48 012 345 678', 5500.00, '2021-07-15');

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `pracownicy_z_kontem`
-- (See below for the actual view)
--
CREATE TABLE `pracownicy_z_kontem` (
`id` int(11)
,`nazwa_uzytkownika` varchar(50)
,`imie` varchar(50)
,`nazwisko` varchar(50)
,`stanowisko` varchar(50)
,`email` varchar(100)
,`telefon` varchar(20)
,`pensja` decimal(10,2)
,`data_zatrudnienia` date
);

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
(9, 'Robert', 'Wójcik', '+48-888-999-000', '2025-05-16', '21:00:00', 4, 9, NULL);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `rezerwacje_szczegoly`
-- (See below for the actual view)
--
CREATE TABLE `rezerwacje_szczegoly` (
`id` int(11)
,`imie` varchar(50)
,`nazwisko` varchar(50)
,`telefon` varchar(15)
,`data` date
,`godzina` time
,`ilosc_osob` int(11)
,`stolik_nr` int(11)
,`nazwa_uzytkownika` varchar(50)
);

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
  `uprawnienia` enum('uzytkownik','admin','wlasciciel','obsluga') NOT NULL DEFAULT 'uzytkownik',
  `remember_token` varchar(64) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `imie`, `nazwisko`, `nazwa_uzytkownika`, `email`, `haslo`, `uprawnienia`, `remember_token`, `token_expiry`) VALUES
(1, 'Jan', 'Kowalski', 'janek123', 'jan.kowalski@example.com', 'qwer23@sq', 'uzytkownik', NULL, NULL),
(2, 'Anna', 'Nowak', 'anusia', 'anna.nowak@example.com', 'anada@32wwe', 'admin', NULL, NULL),
(3, 'Piotr', 'Zieliński', 'zielony', 'piotr.zielinski@example.com', 'saw@dw12', 'uzytkownik', NULL, NULL),
(4, 'Katarzyna', 'Wiśniewska', 'kaska_w', 'katarzyna.w@example.com', 'fdw@1231w', 'uzytkownik', NULL, NULL),
(5, 'Tomasz', 'Lewandowski', 'tom_lew', 'tomasz.lew@example.com', 'swadm@23', 'admin', NULL, NULL),
(6, 'Monika', 'Dąbrowska', 'monidab', 'monika.dab@example.com', 'dsw@43212', 'uzytkownik', NULL, NULL),
(7, 'Marek', 'Szymański', 'mareksz', 'marek.szymanski@example.com', 'dwew@e21', 'uzytkownik', NULL, NULL),
(8, 'Ewa', 'Kaczmarek', 'ewka', 'ewa.kaczmarek@example.com', 'adm@se32', 'admin', NULL, NULL),
(9, 'Andrzej', 'Kwiadkowski', 'AndrejKwiatek', 'and.kwiatek@gmail.com', 'sh@eyws2123', 'uzytkownik', NULL, NULL),
(10, 'Jacek', 'Śliwa', 'właściciel', 'wlasciciel@restauracja.pl', '$2y$10$TajneHaslo123', 'wlasciciel', NULL, NULL),
(14, 'Paweł', 'Majewski', 'pawel_obsluga', 'pawel.majewski@example.com', 'Obsluga123!', 'obsluga', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id` int(11) NOT NULL,
  `imie_nazwisko` varchar(100) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `adres` varchar(200) NOT NULL,
  `dania` text NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `data_zamowienia` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('nowe','w_realizacji','dostarczone') NOT NULL DEFAULT 'nowe',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowienia`
--

INSERT INTO `zamowienia` (`id`, `imie_nazwisko`, `telefon`, `adres`, `dania`, `cena`, `data_zamowienia`, `status`, `user_id`) VALUES
(1, 'Mikołaj Misiarz', '666 333 999', 'Ulica jakas 48g', 'Pizza Primavera', 44.00, '2025-05-15 19:00:18', 'nowe', NULL),
(2, 'Andrzej Nowak', '333 444 555', 'Jagielonczyka 45c', 'Makaron Pappardelle z Kurczakiem', 42.00, '2025-05-15 19:01:26', 'nowe', NULL);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `zamowienia_uzytkownikow`
-- (See below for the actual view)
--
CREATE TABLE `zamowienia_uzytkownikow` (
`id` int(11)
,`imie_nazwisko` varchar(100)
,`telefon` varchar(15)
,`adres` varchar(200)
,`dania` text
,`cena` decimal(10,2)
,`data_zamowienia` datetime
,`status` enum('nowe','w_realizacji','dostarczone')
,`nazwa_uzytkownika` varchar(50)
);

-- --------------------------------------------------------

--
-- Struktura widoku `opinie_z_uzytkownikami`
--
DROP TABLE IF EXISTS `opinie_z_uzytkownikami`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `opinie_z_uzytkownikami`  AS SELECT `o`.`id` AS `id`, `o`.`tresc` AS `tresc`, `o`.`data_dodania` AS `data_dodania`, `u`.`nazwa_uzytkownika` AS `nazwa_uzytkownika` FROM (`opinie` `o` join `uzytkownicy` `u` on(`o`.`uzytkownik_id` = `u`.`id`)) ;

-- --------------------------------------------------------

--
-- Struktura widoku `pracownicy_z_kontem`
--
DROP TABLE IF EXISTS `pracownicy_z_kontem`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pracownicy_z_kontem`  AS SELECT `p`.`id` AS `id`, `u`.`nazwa_uzytkownika` AS `nazwa_uzytkownika`, `p`.`imie` AS `imie`, `p`.`nazwisko` AS `nazwisko`, `p`.`stanowisko` AS `stanowisko`, `p`.`email` AS `email`, `p`.`telefon` AS `telefon`, `p`.`pensja` AS `pensja`, `p`.`data_zatrudnienia` AS `data_zatrudnienia` FROM (`pracownicy` `p` join `uzytkownicy` `u` on(`p`.`uzytkownik_id` = `u`.`id`)) ;

-- --------------------------------------------------------

--
-- Struktura widoku `rezerwacje_szczegoly`
--
DROP TABLE IF EXISTS `rezerwacje_szczegoly`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rezerwacje_szczegoly`  AS SELECT `r`.`id` AS `id`, `r`.`imie` AS `imie`, `r`.`nazwisko` AS `nazwisko`, `r`.`telefon` AS `telefon`, `r`.`data` AS `data`, `r`.`godzina` AS `godzina`, `r`.`ilosc_osob` AS `ilosc_osob`, `r`.`stolik_nr` AS `stolik_nr`, `u`.`nazwa_uzytkownika` AS `nazwa_uzytkownika` FROM (`rezerwacje` `r` join `uzytkownicy` `u` on(`r`.`uzytkownik_id` = `u`.`id`)) ;

-- --------------------------------------------------------

--
-- Struktura widoku `zamowienia_uzytkownikow`
--
DROP TABLE IF EXISTS `zamowienia_uzytkownikow`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `zamowienia_uzytkownikow`  AS SELECT `z`.`id` AS `id`, `z`.`imie_nazwisko` AS `imie_nazwisko`, `z`.`telefon` AS `telefon`, `z`.`adres` AS `adres`, `z`.`dania` AS `dania`, `z`.`cena` AS `cena`, `z`.`data_zamowienia` AS `data_zamowienia`, `z`.`status` AS `status`, `u`.`nazwa_uzytkownika` AS `nazwa_uzytkownika` FROM (`zamowienia` `z` join `uzytkownicy` `u` on(`z`.`user_id` = `u`.`id`)) ;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `odpowiedzi`
--
ALTER TABLE `odpowiedzi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pytanie_id` (`pytanie_id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `opinie`
--
ALTER TABLE `opinie`
  ADD KEY `fk_opinie_uzytkownik` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_pracownik_uzytkownik` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `pytania`
--
ALTER TABLE `pytania`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pytania_uzytkownik` (`uzytkownik_id`);

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
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `odpowiedzi`
--
ALTER TABLE `odpowiedzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pytania`
--
ALTER TABLE `pytania`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `odpowiedzi`
--
ALTER TABLE `odpowiedzi`
  ADD CONSTRAINT `odpowiedzi_ibfk_1` FOREIGN KEY (`pytanie_id`) REFERENCES `pytania` (`id`),
  ADD CONSTRAINT `odpowiedzi_ibfk_2` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`);

--
-- Constraints for table `opinie`
--
ALTER TABLE `opinie`
  ADD CONSTRAINT `fk_opinie_uzytkownik` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD CONSTRAINT `fk_pracownicy_uzytkownik` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pracownik_uzytkownik` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`);

--
-- Constraints for table `pytania`
--
ALTER TABLE `pytania`
  ADD CONSTRAINT `fk_pytania_uzytkownik` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD CONSTRAINT `fk_rezerwacje_uzytkownik` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `fk_zamowienia_uzytkownik` FOREIGN KEY (`user_id`) REFERENCES `uzytkownicy` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `uzytkownicy` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
