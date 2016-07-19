-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 13 Juillet 2016 à 17:18
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ceido_surfimages`
--

--
-- Vider la table avant d'insérer `images`
--

TRUNCATE TABLE `images`;
--
-- Contenu de la table `images`
--

INSERT INTO `images` (`id`, `site`, `nom`, `produit`, `upload`, `zapper`, `cip13`) VALUES
(3, 'http://www.infos-medicaments.com/monographie/images/', '178496', NULL, 0, 1, NULL),
(4, 'photos/en_cours', '3400941513220.jpg', NULL, 1, 2, '3400941513220'),
(5, 'photos/en_cours', '3400949960194.jpg', NULL, 1, 2, '3400949960194'),
(6, 'photos/en_cours', '3400949409709.jpg', NULL, 1, 2, '3400949409709'),
(7, 'photos/en_cours', '3400933533489.jpg', NULL, 1, 2, '3400933533489'),
(8, 'photos/en_cours', '3400938504958.jpg', NULL, 1, 2, '3400938504958'),
(9, 'photos/en_cours', '3400949409877.jpg', NULL, 1, 2, '3400949409877'),
(10, 'photos/en_cours', '3400949875528.jpg', NULL, 1, 2, '3400949875528'),
(11, 'photos/en_cours', '3400939794969.jpg', NULL, 1, 2, '3400939794969'),
(12, 'http://www.infos-medicaments.com/monographie/images/', '181419', NULL, 0, 1, NULL),
(13, 'http://www.infos-medicaments.com/monographie/images/', '181663', NULL, 0, 1, NULL),
(14, 'http://www.infos-medicaments.com/monographie/images/', '181666', NULL, 0, 1, NULL),
(15, 'http://www.infos-medicaments.com/monographie/images/', '181672', NULL, 0, 1, NULL),
(16, 'http://www.infos-medicaments.com/monographie/images/', '181725', NULL, 0, 1, NULL),
(17, 'photos/en_cours', '3400941558405.jpg', NULL, 1, 2, '3400941558405'),
(18, 'photos/en_cours', '3400934194788.jpg', NULL, 1, 2, '3400934194788'),
(19, 'photos/en_cours', '3400949398669.jpg', NULL, 1, 2, '3400949398669'),
(20, 'http://www.infos-medicaments.com/monographie/images/', '185253', NULL, 0, 1, NULL),
(21, 'photos/en_cours', '3400949215539.jpg', NULL, 1, 2, '3400949215539'),
(22, 'http://www.infos-medicaments.com/monographie/images/', '185418', NULL, 0, 1, NULL),
(23, 'photos/en_cours', '3400949851683.jpg', NULL, 1, 2, '3400949851683'),
(24, 'http://www.infos-medicaments.com/monographie/images/', '185832', NULL, 0, 1, NULL),
(25, 'http://www.infos-medicaments.com/monographie/images/', '185833', NULL, 0, 1, NULL),
(26, 'http://www.infos-medicaments.com/monographie/images/', '185844', NULL, 0, 1, NULL),
(27, 'photos/en_cours', '3400934691867.jpg', NULL, 1, 2, '3400934691867'),
(28, 'photos/en_cours', '3400939990859.jpg', NULL, 1, 2, '3400939990859'),
(29, 'photos/en_cours', '3400936868540.jpg', NULL, 1, 2, '3400936868540'),
(30, 'http://www.infos-medicaments.com/monographie/images/', '186068', NULL, 0, 1, NULL),
(31, 'photos/en_cours', '3400938924473.jpg', NULL, 1, 2, '3400938924473'),
(32, 'photos/en_cours', '3400936461390.jpg', NULL, 1, 2, '3400936461390'),
(33, 'http://www.infos-medicaments.com/monographie/images/', '186801', NULL, 0, 1, NULL),
(34, 'photos/en_cours', '3400921874976.jpg', NULL, 1, 2, '3400921874976'),
(35, 'photos/en_cours', '3400949898350.jpg', NULL, 1, 2, '3400949898350'),
(37, 'photos/en_cours', '3400949974092.jpg', NULL, 1, 2, '3400949974092'),
(38, 'http://www.infos-medicaments.com/monographie/images/', '188067', NULL, 0, 1, NULL),
(39, 'http://www.infos-medicaments.com/monographie/images/', '188130', NULL, 0, 1, NULL),
(40, 'http://www.infos-medicaments.com/monographie/images/', '188131', NULL, 0, 1, NULL),
(41, 'http://www.infos-medicaments.com/monographie/images/', '188774', NULL, 0, 1, NULL),
(42, 'http://www.infos-medicaments.com/monographie/images/', '188783', NULL, 0, 1, NULL),
(43, 'photos/en_cours', '3400937408325.jpg', NULL, 1, 2, '3400937408325'),
(44, 'photos/en_cours', '3400921662078.jpg', NULL, 1, 2, '3400921662078'),
(45, 'http://www.infos-medicaments.com/monographie/images/', '190043', NULL, 0, 1, NULL),
(46, 'http://www.infos-medicaments.com/monographie/images/', '190044', NULL, 0, 1, NULL),
(47, 'http://www.infos-medicaments.com/monographie/images/', '190283', NULL, 0, 1, NULL),
(49, 'http://www.infos-medicaments.com/monographie/images/', '190335', NULL, 0, 1, NULL),
(50, 'photos/en_cours', '3400941597954.jpg', NULL, 1, 2, '3400941597954'),
(51, 'photos/en_cours', '3400941686245.jpg', NULL, 1, 2, '3400941686245'),
(52, 'http://www.infos-medicaments.com/monographie/images/', '191146', NULL, 0, 1, NULL),
(54, 'http://www.infos-medicaments.com/monographie/images/', '191216', NULL, 1, 2, '3400941825644'),
(55, 'http://www.infos-medicaments.com/monographie/images/', '192141', NULL, 0, 1, NULL),
(56, 'http://www.infos-medicaments.com/monographie/images/', '192278', NULL, 0, 1, NULL),
(57, 'http://www.infos-medicaments.com/monographie/images/', '192368', NULL, 0, 1, NULL),
(58, 'http://www.infos-medicaments.com/monographie/images/', '193105', NULL, 0, 1, NULL),
(59, 'http://www.infos-medicaments.com/monographie/images/', '193106', NULL, 0, 1, NULL),
(60, 'photos/en_cours', '3400936290754.jpg', NULL, 1, 2, '3400936290754'),
(62, 'http://www.infos-medicaments.com/monographie/images/', '193679', NULL, 1, 2, '3400921798074'),
(63, 'http://www.infos-medicaments.com/monographie/images/', '193680', NULL, 0, 1, NULL),
(64, 'http://www.infos-medicaments.com/monographie/images/', '194053', NULL, 1, 2, '3400949858439'),
(66, 'http://www.infos-medicaments.com/monographie/images/', '195800', NULL, 1, 2, '3400922031736'),
(67, 'http://www.infos-medicaments.com/monographie/images/', '195801', NULL, 1, 2, '3400937560818'),
(68, 'http://www.infos-medicaments.com/monographie/images/', '197620', NULL, 0, 1, NULL),
(69, 'http://www.infos-medicaments.com/monographie/images/', '19788', NULL, 0, 1, NULL),
(70, 'http://www.infos-medicaments.com/monographie/images/', '19793', NULL, 1, 2, '3400930005491'),
(71, 'http://www.infos-medicaments.com/monographie/images/', '198289', NULL, 1, 2, '3400936251892'),
(72, 'photos/en_cours', '3400930041512.jpg', NULL, 1, 2, '3400930041512'),
(73, 'photos/en_cours', '3400937531542.jpg', NULL, 1, 2, '3400937531542'),
(74, 'http://www.infos-medicaments.com/monographie/images/', '198756', NULL, 0, 1, NULL),
(75, 'http://www.infos-medicaments.com/monographie/images/', '198818', NULL, 0, 1, NULL),
(76, 'http://www.infos-medicaments.com/monographie/images/', '198819', NULL, 0, 1, NULL),
(77, 'photos/en_cours', '3400930060612.jpg', NULL, 1, 2, '3400930060612'),
(78, 'http://www.infos-medicaments.com/monographie/images/', '19889', NULL, 0, 1, NULL),
(79, 'photos/en_cours', '3400930063163.jpg', NULL, 1, 2, '3400930063163'),
(80, 'photos/en_cours', '3400930063453.jpg', NULL, 1, 2, '3400930063453'),
(82, 'http://www.infos-medicaments.com/monographie/images/', '19899', NULL, 0, 1, NULL),
(83, 'http://www.infos-medicaments.com/monographie/images/', '19901', NULL, 0, 1, NULL),
(84, 'photos/en_cours', '3400930069608.jpg', NULL, 1, 2, '3400930069608'),
(85, 'http://www.infos-medicaments.com/monographie/images/', '19924', NULL, 0, 1, NULL),
(86, 'photos/en_cours', '3400930078181.jpg', NULL, 1, 2, '3400930078181'),
(87, 'http://www.infos-medicaments.com/monographie/images/', '199421', NULL, 0, 1, NULL),
(88, 'photos/en_cours', '3400930088876.jpg', NULL, 1, 2, '3400930088876'),
(89, 'photos/en_cours', '3400930088937.jpg', NULL, 1, 2, '3400930088937'),
(90, 'http://www.infos-medicaments.com/monographie/images/', '19955', NULL, 0, 1, NULL),
(91, 'http://www.infos-medicaments.com/monographie/images/', '199558', NULL, 1, 2, '3400922151014'),
(93, 'http://www.infos-medicaments.com/monographie/images/', '19966', NULL, 1, 2, '3400930100226'),
(94, 'photos/en_cours', '3400930102466.jpg', NULL, 1, 2, '3400930102466'),
(95, 'http://www.infos-medicaments.com/monographie/images/', '19969', NULL, 0, 1, NULL),
(96, 'http://www.infos-medicaments.com/monographie/images/', '19970', NULL, 1, 2, '3400930102756'),
(97, 'photos/en_cours', '3400930102817.jpg', NULL, 1, 2, '3400930102817'),
(98, 'photos/en_cours', '3400930105078.jpg', NULL, 1, 2, '3400930105078'),
(99, 'photos/en_cours', '3400922031507.jpg', NULL, 1, 2, '3400922031507'),
(100, 'http://www.infos-medicaments.com/monographie/images/', '19978', NULL, 0, 1, NULL),
(101, 'http://www.infos-medicaments.com/monographie/images/', '19980', NULL, 1, 2, '3400930108550'),
(103, 'http://www.infos-medicaments.com/monographie/images/', '19992', NULL, 1, 2, '3400930111161'),
(104, 'http://www.infos-medicaments.com/monographie/images/', '19993', NULL, 1, 2, '3400930111390'),
(105, 'http://www.infos-medicaments.com/monographie/images/', '19998', NULL, 0, 1, NULL),
(106, 'photos/en_cours', '3400933834968.jpg', NULL, 1, 2, '3400933834968'),
(107, 'http://www.infos-medicaments.com/monographie/images/', '20019', NULL, 1, 2, '3400930131442'),
(1945, 'photos/traitement/GIFRER/GIFRER PHOTOS', 'BicareGifrerplus.png', NULL, 0, 0, NULL),
(109, 'photos/en_cours', '3400921897630.jpg', NULL, 1, 2, '3400921897630'),
(110, 'http://www.infos-medicaments.com/monographie/images/', '200552', NULL, 1, 2, '3400922031965');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
