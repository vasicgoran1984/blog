-- phpMyAdmin SQL Dump
-- version 4.0.10deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 08, 2019 at 01:39 PM
-- Server version: 5.6.33-0ubuntu0.14.04.1
-- PHP Version: 5.6.40-1+ubuntu14.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `clanci`
--

CREATE TABLE IF NOT EXISTS `clanci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `korisnik_id` int(40) DEFAULT NULL,
  `naslovna_slika` varchar(7) DEFAULT NULL,
  `naslov_clanka` varchar(50) DEFAULT NULL,
  `kratki_tekst` varchar(50) DEFAULT NULL,
  `dugacki_tekst` text,
  `kljucne_rijeci` varchar(200) DEFAULT NULL,
  `slug` varchar(30) DEFAULT NULL,
  `objavljen` tinyint(1) DEFAULT NULL,
  `datum_objave_clanka` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `korisnik_id` (`korisnik_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `clanci`
--

INSERT INTO `clanci` (`id`, `korisnik_id`, `naslovna_slika`, `naslov_clanka`, `kratki_tekst`, `dugacki_tekst`, `kljucne_rijeci`, `slug`, `objavljen`, `datum_objave_clanka`) VALUES
(1, 1, '1.png', 'Audi A4', 'novi Audi model', ' Ve? u prvom kontaktu uživo na cesti A4 je iznenadio svojom samouvjerenom pojavom. Pri?a zapo?eta tre?om generacijom iz 2004. godine udarila je temelje izgledu ?etvorke, a posljednja, peta po redu, generacija dovela je dizajnerski izraz za?et Walterom de Silvom do vrhunca. Iako ve?i od prethodnika, novi A4 djeluje vrlo kompaktno, gotovo nabijeno, a ono što iznena?uje je da je Audi naglaskom na agresivnost uspio stvoriti automobil za kojim ?e ve?ina okrenuti glavu. ', 'audi vw seat', 'audi-a4', 1, '2019-03-18 11:14:37'),
(2, 2, '2.png', 'Samsung', 'novi Samsung', 'Preuzmi kontrolu sa novim Galaxy S10+. OÅ¾ivi svoje vizije uz pomoÄ‡ pet kamera visoke klase, svedoÄeÄ‡i kako je svaki snimak optimizovan na filmskom Infinity-O ekranu. Deli video zapise u 4K UHD, a zatim deli bateriju. Å½ivi inteligentnije uz prilagodljive performanse i navike krojene po meri.', 'samsung telefon android', 'samsung', 1, '2019-03-01 15:14:42'),
(3, 3, '3.png', 'Server dell', 'server ', 'U danaÅ¡njoj digitalnoj ekonomiji, tehnologija se mora transformirati brzinom poslovanja kako bi razvila i implementirala nove aplikacije, optimizirala resurse i pruÅ¾ila idealno iskustvo kupovineâ€, rekao je predsjednik SluÅ¾be serverskih rjeÅ¡enja u tvrtki Dell EMC Ashley Gorakhpurwalla te dodao: â€œS naÅ¡im vodstvom u inovacijama tehnologije servera, najnovija generacija PowerEdge servera temelj su suvremenog podatkovnog centra', 'server', 'server-dell', 1, '2019-03-07 20:09:29'),
(4, 3, '4.png', 'Angular', 'framework', 'ECMAScript 5 standard uveo je novu metodu za kreiranje objekata, a to je kreira-nje koriË‡stenjem statiË‡cke funkcijeObject.create().  Prvi argument navedene funkcijeje prototip objekta kojeg kreiramo.  Drugi element je opcionalan i detalje oko tog ele-menta moË‡zete prona Ìci', 'js framework ', 'angular', 1, '2019-03-07 15:54:15'),
(5, 3, '5.png', 'Laravel', 'php', 'Laravel je open-source web framework. Baziran je na PHP-u, odnosno Simfony framework-u. Razvio ga je Taylor Otwell s ciljem razvoja web aplikacija prateÄ‡i modelâ€“viewâ€“controller (MVC) arhitekturu. Smatra se jednim od najpopularnijih PHP framework-a. ', 'web prgoramiranje php', 'php-programski-jezik', 1, '2019-02-20 15:58:52'),
(6, 3, '6.png', 'Laptop IBM', 'IBM', 'Ovaj savjet vrijedi ako kupujete laptop ili PC s predinstaliranim Windows OS-om. Iako se radi o najdosadnijem dijelu na koji moÅ¾ete potroÅ¡iti i do nekoliko sati, nipoÅ¡to ga nemojte preskoÄiti.', 'IBM', 'laptop-ibm', 1, '2019-03-07 16:55:50'),
(7, 1, '7.png', 'Disk SSD', 'SSD nova memorija', 'Ponuditi da aÅ¾urirate raÄunalo Äim ga prvi put pokrenete. Nakon Å¡to se spojite na internet, pokrenite aÅ¾uriranje. No, prije toga se pobrinite da za to imate dovoljno vremena, pogotovo ako ste kupili model laptopa koji je u prodaji veÄ‡ neko vrijeme jer proces aÅ¾uriranja', 'disk memorija', 'disk-ssd', 1, '2019-03-07 16:57:01'),
(8, 1, '8.png', 'jQuery biblioteka', 'Biblioteka', 'U danaÃ…Â¡njoj digitalnoj ekonomiji, tehnologija se mora transformirati brzinom poslovanja kako bi razvila i implementirala nove aplikacije, optimizirala resurse i pruÃ…Â¾ila idealno iskustvo kupovineÃ¢â‚¬Â, rekao je predsjednik SluÃ…Â¾be serverskih rjeÃ…Â¡enja u tvrtki Dell EMC Ashley Gorakhpurwalla te dodao: Ã¢â‚¬Å“S naÃ…Â¡im vodstvom u inovacijama tehnologije servera, najnovija generacija PowerEdge servera temelj su suvremenog podatkovnog centra', 'jquery', 'jquery-biblioteka', 1, '2019-03-08 08:54:47'),
(9, 3, '9.png', 'Nove tehnologije', 'tehnologije', 'U danaÃ…Â¡njoj digitalnoj ekonomiji, tehnologija se mora transformirati brzinom poslovanja kako bi razvila i implementirala nove aplikacije, optimizirala resurse i pruÃ…Â¾ila idealno iskustvo kupovineÃ¢â‚¬Â, rekao je predsjednik SluÃ…Â¾be serverskih rjeÃ…Â¡enja u tvrtki Dell EMC Ashley Gorakhpurwalla te dodao: Ã¢â‚¬Å“S naÃ…Â¡im vodstvom u inovacijama tehnologije servera, najnovija generacija PowerEdge servera temelj su suvremenog podatkovnog centra', 'software programiranje', 'nove-tehnologije', 1, '2019-03-07 19:57:18'),
(10, 3, '10.png', 'Novi model', 'Vozila tehnologije', 'U danaÃ…Â¡njoj digitalnoj ekonomiji, tehnologija se mora transformirati brzinom poslovanja kako bi razvila i implementirala nove aplikacije, optimizirala resurse i pruÃ…Â¾ila idealno iskustvo kupovineÃ¢â‚¬Â, rekao je predsjednik SluÃ…Â¾be serverskih rjeÃ…Â¡enja u tvrtki Dell EMC Ashley Gorakhpurwalla te dodao: Ã¢â‚¬Å“S naÃ…Â¡im vodstvom u inovacijama tehnologije servera, najnovija generacija PowerEdge servera temelj su suvremenog podatkovnog centra', 'vozila', 'novi-clanak-o-vozilima', 1, '2019-03-07 20:09:35'),
(11, 3, '11.png', 'Web programiranje', 'programiranje', 'U danaÃ…Â¡njoj digitalnoj ekonomiji, tehnologija se mora transformirati brzinom poslovanja kako bi razvila i implementirala nove aplikacije, optimizirala resurse i pruÃ…Â¾ila idealno iskustvo kupovineÃ¢â‚¬Â, rekao je predsjednik SluÃ…Â¾be serverskih rjeÃ…Â¡enja u tvrtki Dell EMC Ashley Gorakhpurwalla te dodao: Ã¢â‚¬Å“S naÃ…Â¡im vodstvom u inovacijama tehnologije servera, najnovija generacija PowerEdge servera temelj su suvremenog podatkovnog centra', 'web prgoramiranje php', 'web-programiranje', 1, '2019-03-07 20:14:55'),
(12, 3, '12.png', 'Noci clanak', 'tekst novi clanak', 'U danaÃ…Â¡njoj digitalnoj ekonomiji, tehnologija se mora transformirati brzinom poslovanja kako bi razvila i implementirala nove aplikacije, optimizirala resurse i pruÃ…Â¾ila idealno iskustvo kupovineÃ¢â‚¬Â, rekao je predsjednik SluÃ…Â¾be serverskih rjeÃ…Â¡enja u tvrtki Dell EMC Ashley Gorakhpurwalla te dodao: Ã¢â‚¬Å“S naÃ…Â¡im vodstvom u inovacijama tehnologije servera, najnovija generacija PowerEdge servera temelj su suvremenog podatkovnog centra', 'novi clanak', 'noci-clanak', 0, '2019-03-07 20:15:32'),
(13, 3, '13.png', 'Radionica', 'radionica', 'U danaÃ…Â¡njoj digitalnoj ekonomiji, tehnologija se mora transformirati brzinom poslovanja kako bi razvila i implementirala nove aplikacije, optimizirala resurse i pruÃ…Â¾ila idealno iskustvo kupovineÃ¢â‚¬Â, rekao je predsjednik SluÃ…Â¾be serverskih rjeÃ…Â¡enja u tvrtki Dell EMC Ashley Gorakhpurwalla te dodao: Ã¢â‚¬Å“S naÃ…Â¡im vodstvom u inovacijama tehnologije servera, najnovija generacija PowerEdge servera temelj su suvremenog podatkovnog centra', 'radionica', 'radionica', 1, '2019-03-07 20:16:09'),
(14, 3, '', 'praksa', 'test', 'U danaÃ…Â¡njoj digitalnoj ekonomiji, tehnologija se mora transformirati brzinom poslovanja kako bi razvila i implementirala nove aplikacije, optimizirala resurse i pruÃ…Â¾ila idealno iskustvo kupovineÃ¢â‚¬Â, rekao je predsjednik SluÃ…Â¾be serverskih rjeÃ…Â¡enja u tvrtki Dell EMC Ashley Gorakhpurwalla te dodao: Ã¢â‚¬Å“S naÃ…Â¡im vodstvom u inovacijama tehnologije servera, najnovija generacija PowerEdge servera temelj su suvremenog podatkovnog centra', 'test dva tri', 'praksa', 0, '2019-03-07 20:16:28'),
(15, 3, '15.png', 'Test clanak', 'software', 'U danaÃ…Â¡njoj digitalnoj ekonomiji, tehnologija se mora transformirati brzinom poslovanja kako bi razvila i implementirala nove aplikacije, optimizirala resurse i pruÃ…Â¾ila idealno iskustvo kupovineÃ¢â‚¬Â, rekao je predsjednik SluÃ…Â¾be serverskih rjeÃ…Â¡enja u tvrtki Dell EMC Ashley Gorakhpurwalla te dodao: Ã¢â‚¬Å“S naÃ…Â¡im vodstvom u inovacijama tehnologije servera, najnovija generacija PowerEdge servera temelj su suvremenog podatkovnog centra', 'software programiranje', 'api', 1, '2019-02-18 20:35:17'),
(16, 3, '16.png', 'Clanak dva', 'software', 'U danaÃ…Â¡njoj digitalnoj ekonomiji, tehnologija se mora transformirati brzinom poslovanja kako bi razvila i implementirala nove aplikacije, optimizirala resurse i pruÃ…Â¾ila idealno iskustvo kupovineÃ¢â‚¬Â, rekao je predsjednik SluÃ…Â¾be serverskih rjeÃ…Â¡enja u tvrtki Dell EMC Ashley Gorakhpurwalla te dodao: Ã¢â‚¬Å“S naÃ…Â¡im vodstvom u inovacijama tehnologije servera, najnovija generacija PowerEdge servera temelj su suvremenog podatkovnog centra', 'software programiranje', 'api', 0, '2019-03-07 20:35:02'),
(17, 3, '17.png', 'API', 'software', 'U danaÃ…Â¡njoj digitalnoj ekonomiji, tehnologija se mora transformirati brzinom poslovanja kako bi razvila i implementirala nove aplikacije, optimizirala resurse i pruÃ…Â¾ila idealno iskustvo kupovineÃ¢â‚¬Â, rekao je predsjednik SluÃ…Â¾be serverskih rjeÃ…Â¡enja u tvrtki Dell EMC Ashley Gorakhpurwalla te dodao: Ã¢â‚¬Å“S naÃ…Â¡im vodstvom u inovacijama tehnologije servera, najnovija generacija PowerEdge servera temelj su suvremenog podatkovnog centra', 'software programiranje', 'api', 0, '2019-03-07 20:17:46'),
(18, 1, '', 'Novi Clanak laptop ', 'Kratki clanak za laptop', 'Preuzmi kontrolu sa novim Galaxy S10+. OÃ…Â¾ivi svoje vizije uz pomoÃ„â€¡ pet kamera visoke klase, svedoÃ„ÂeÃ„â€¡i kako je svaki snimak optimizovan na filmskom Infinity-O ekranu. Deli video zapise u 4K UHD, a zatim deli bateriju. Ã…Â½ivi inteligentnije uz prilagodljive performanse i navike krojene po meri.', 'laptop pc ', 'novi-clanak-laptop', 0, '2019-03-08 09:24:49');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clanci`
--
ALTER TABLE `clanci`
  ADD CONSTRAINT `clanci_ibfk_1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnici` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
