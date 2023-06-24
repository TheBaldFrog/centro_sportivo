-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 24, 2023 alle 18:30
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `centro_sportivo`
--
CREATE DATABASE IF NOT EXISTS `centro_sportivo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `centro_sportivo`;

-- --------------------------------------------------------

--
-- Struttura della tabella `corso`
--

CREATE TABLE `corso` (
  `id` int(11) NOT NULL,
  `nome_id` varchar(30) NOT NULL,
  `istruttore_id` int(11) NOT NULL,
  `giorno_settimana` varchar(20) NOT NULL,
  `orario_prefissato` time NOT NULL,
  `numero_lezioni` int(10) UNSIGNED NOT NULL,
  `costo_iscrizione` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `corso`
--

INSERT INTO `corso` (`id`, `nome_id`, `istruttore_id`, `giorno_settimana`, `orario_prefissato`, `numero_lezioni`, `costo_iscrizione`) VALUES
(1, 'tennis', 3, 'lunedì', '13:00:00', 35, 105),
(2, 'calcio', 1, 'martedì', '14:00:00', 23, 100),
(3, 'nuoto', 4, 'giovedì', '16:00:00', 15, 150),
(11, 'golf', 4, 'domenica', '15:00:00', 0, 200);

-- --------------------------------------------------------

--
-- Struttura della tabella `istruttore`
--

CREATE TABLE `istruttore` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `descrizione` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `istruttore`
--

INSERT INTO `istruttore` (`id`, `nome`, `cognome`, `descrizione`) VALUES
(1, 'Marco', 'Rossi', 'Marco Rossi è un istruttore sportivo specializzato in pallavolo. Ha una vasta esperienza nell’insegnamento della disciplina a livello amatoriale e agonistico. Marco è molto appassionato del suo lavoro e si dedica con entusiasmo alla formazione dei suoi allievi, aiutandoli a migliorare le loro abilità tecniche e a raggiungere i loro obiettivi sportivi. Con la sua competenza e il suo approccio motivazionale, Marco è in grado di trasmettere ai suoi allievi la passione per lo sport e per la vita sana.'),
(2, 'Giulia', 'Bianchi', 'Giulia Bianchi è un’istruttrice sportiva specializzata in nuoto. Ha una vasta esperienza nell’insegnamento della disciplina a livello amatoriale e agonistico. Giulia è molto appassionata del suo lavoro e si dedica con entusiasmo alla formazione dei suoi allievi, aiutandoli a migliorare le loro abilità tecniche e a raggiungere i loro obiettivi sportivi. Con la sua competenza e il suo approccio motivazionale, Giulia è in grado di trasmettere ai suoi allievi la passione per lo sport e per la vita sana.'),
(3, 'Andrea', 'Conti', 'Andrea Conti è un istruttore sportivo specializzato in calcio. Ha una vasta esperienza nell’insegnamento della disciplina a livello amatoriale e agonistico. Andrea è molto appassionato del suo lavoro e si dedica con entusiasmo alla formazione dei suoi allievi, aiutandoli a migliorare le loro abilità tecniche e a raggiungere i loro obiettivi sportivi. Con la sua competenza e il suo approccio motivazionale, Andrea è in grado di trasmettere ai suoi allievi la passione per lo sport e per la vita sana.'),
(4, 'Federica', 'Lombardi ', ' Federica Lombardi è un’istruttrice sportiva specializzata in tennis. Ha una vasta esperienza nell’insegnamento della disciplina a livello amatoriale e agonistico. Federica è molto appassionata del suo lavoro e si dedica con entusiasmo alla formazione dei suoi allievi, aiutandoli a migliorare le loro abilità tecniche e a raggiungere i loro obiettivi sportivi. Con la sua competenza e il suo approccio motivazionale, Federica è in grado di trasmettere ai suoi allievi la passione per lo sport e per la vita sana.'),
(5, 'Alessandra', 'Romano', 'Alessandra è un’istruttrice sportiva altamente qualificata e appassionata. Ha una vasta esperienza in diverse discipline sportive e sa come motivare e incoraggiare i suoi allievi a raggiungere i loro obiettivi. È sempre pronta ad aiutare e a fornire consigli utili per migliorare le prestazioni. Alessandra è molto attenta alle esigenze dei suoi allievi e sa come adattare gli allenamenti alle loro capacità e obiettivi. La sua passione per lo sport è contagiosa e i suoi allievi apprezzano il suo entusiasmo e la sua dedizione. Alessandra è sempre alla ricerca di nuove sfide e sa come spingere i suoi allievi a superare i loro limiti in modo sicuro ed efficace.'),
(6, 'Federica', 'Pellegrini', 'Federica Pellegrini è un istruttore di nuoto professionista con anni di esperienza nell’insegnamento della disciplina. La sua passione per il nuoto e la sua dedizione al miglioramento continuo lo rendono un insegnante eccezionale. Marco è sempre pronto ad aiutare i suoi allievi a migliorare le loro abilità in acqua e a superare i loro limiti. La sua energia positiva e il suo entusiasmo contagioso ispirano tutti coloro che lo incontrano. Con la sua guida esperta e il suo incoraggiamento costante, Marco aiuta i suoi allievi a diventare nuotatori più forti e sicuri di sé.'),
(7, 'Erika', 'Vigliotti', 'Giulia Bianchi è un’istruttrice di yoga professionista con anni di esperienza nell’insegnamento della disciplina. La sua passione per lo yoga e la sua dedizione al miglioramento continuo la rendono un’insegnante eccezionale. Giulia è sempre pronta ad aiutare i suoi allievi a trovare l’equilibrio tra corpo e mente e a superare i loro limiti. La sua energia positiva e il suo entusiasmo contagioso ispirano tutti coloro che la incontrano. Con la sua guida esperta e il suo incoraggiamento costante, Giulia aiuta i suoi allievi a diventare più forti e sicuri di sé sia fisicamente che mentalmente.'),
(10, 'fdsf', 'fdsfsd', 'fdsfsdf11111111212121dfsfdsgfdhdfgdfgldskjnljksdnfkjlgvnksdjfngvbjkasdfnvjkadsngjkdsNFGKJADSnfkjsdNJFGHJKSdlKLLfndjsjdfhuredshgusierhgudrsghnfdusjihgnuidasghauirjehngfdjkgnhauirehgnuijredg'),
(11, 'Dfa', 'Dgfg1', '12'),
(14, 'dfsg', 'fdsfdsfg', 'gLorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit vitae doloribus aperiam totam? Itaque, nihil ducimus autem veritatis architecto eius corporis assumenda perferendis ratione in, facilis porro inventore! Id, molestiae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit vitae doloribus aperiam totam? Itaque, nihil ducimus autem veritatis architecto eius corporis assumenda perferendis ratione in, facilis porro inventore! Id, molestiae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit vitae doloribus aperiam totam? Itaque, nihil ducimus autem veritatis architecto eius corporis assumenda perferendis ratione in, facilis porro inventore! Id, molestiae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit vitae doloribus aperiam totam? Itaque, nihil ducimus autem veritatis architecto eius corporis assumenda perferendis ratione in, facilis porro inventore! Id, molestiae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit vitae doloribus aperiam totam? Itaque, nihil ducimus autem veritatis architecto eius corporis assumenda perferendis ratione in, facilis porro inventore! Id, molestiae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit vitae doloribus aperiam totam? Itaque, nihil ducimus autem veritatis architecto eius corporis assumenda perferendis ratione in, facilis porro inventore! Id, molestiae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit vitae doloribus aperiam totam? Itaque, nihil ducimus autem veritatis architecto eius corporis assumenda perferendis ratione in, facilis porro inventore! Id, molestiae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit vitae doloribus aperiam totam? Itaque, nihil ducimus autem veritatis architecto eius corporis assumenda perferendis ratione in, facilis porro inventore! Id, molestiae.');

-- --------------------------------------------------------

--
-- Struttura della tabella `nome_corso`
--

CREATE TABLE `nome_corso` (
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `nome_corso`
--

INSERT INTO `nome_corso` (`nome`) VALUES
('calcio'),
('golf'),
('nuoto'),
('sala pesi'),
('tennis'),
('yoga');

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE `prenotazione` (
  `id` int(11) NOT NULL,
  `corso_id` int(11) NOT NULL,
  `utente_id` int(11) NOT NULL,
  `data_prenotazione` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prenotazione`
--

INSERT INTO `prenotazione` (`id`, `corso_id`, `utente_id`, `data_prenotazione`) VALUES
(1, 1, 1, '2023-04-25'),
(2, 1, 2, '2023-04-20'),
(3, 2, 1, '2023-04-12'),
(5, 2, 3, '2023-04-12'),
(6, 2, 4, '2023-04-15'),
(7, 3, 5, '0000-00-00'),
(8, 3, 6, '0000-00-00'),
(9, 3, 7, '0000-00-00'),
(10, 3, 8, '0000-00-00'),
(11, 2, 2, '0000-00-00'),
(12, 2, 4, '0000-00-00'),
(13, 2, 9, '0000-00-00'),
(14, 2, 10, '0000-00-00'),
(15, 2, 8, '0000-00-00'),
(16, 2, 8, '0000-00-00');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `data_nascita` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `nome`, `cognome`, `data_nascita`) VALUES
(1, 'hfdfgfdg', 'Franceschetti', '1990-02-07'),
(2, 'Matteo', 'Todaro', '2000-02-14'),
(3, 'Paolo', 'Mattarella', '2000-02-08'),
(4, 'Sylvia', 'Toscannini', '2002-07-14'),
(5, 'Mario', 'Murri', '1967-12-07'),
(6, 'Laura', 'Cesarotti', '1987-11-19'),
(7, 'Liberto', 'Paliotta', '1962-06-04'),
(8, 'Angelo', 'Trentini', '1999-07-18'),
(9, 'Leonardo', 'Pisaroni', '2003-09-02'),
(10, 'Moraru', 'Liviu', '2004-01-24'),
(18, 'gsdgds', 'gdsgds', '2023-05-30'),
(19, 'T', 'T2', '2015-06-03'),
(59, 'GG', 'GGG', '1987-11-19');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `corso`
--
ALTER TABLE `corso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nome_id` (`nome_id`),
  ADD KEY `istruttori_id` (`istruttore_id`);

--
-- Indici per le tabelle `istruttore`
--
ALTER TABLE `istruttore`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `nome_corso`
--
ALTER TABLE `nome_corso`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corso_id` (`corso_id`),
  ADD KEY `utente_id` (`utente_id`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `corso`
--
ALTER TABLE `corso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `istruttore`
--
ALTER TABLE `istruttore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `corso`
--
ALTER TABLE `corso`
  ADD CONSTRAINT `corso_ibfk_1` FOREIGN KEY (`nome_id`) REFERENCES `nome_corso` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `corso_ibfk_2` FOREIGN KEY (`istruttore_id`) REFERENCES `istruttore` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD CONSTRAINT `prenotazione_ibfk_1` FOREIGN KEY (`corso_id`) REFERENCES `corso` (`id`),
  ADD CONSTRAINT `prenotazione_ibfk_2` FOREIGN KEY (`utente_id`) REFERENCES `utente` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
