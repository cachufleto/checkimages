-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 05 Juillet 2016 à 09:23
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ceido_medicaments`
--
USE `ceido_medicaments`;

--
-- Contenu de la table `familles`
--

INSERT INTO `familles` (`id_famille`, `designation`, `ordre_affichage`) VALUES
(0, '---', 1),
(1, 'Hygiène, Intimité', 1),
(2, 'Soins dentaires', 1),
(3, 'Circulation veineuse', 1),
(4, 'Digestion', 1),
(5, 'Douleurs et Fièvre', 1),
(6, 'Vitalité', 1),
(8, 'Yeux et Oreilles', 1),
(10, 'Peau et Cheveux', 1),
(11, 'Rhume, Gorge et Toux', 1);

--
-- Contenu de la table `laboratoires`
--

INSERT INTO `laboratoires` (`id_laboratoire`, `designation`) VALUES
(1, 'SANOFI AVENTIS FRANCE'),
(2, 'BRISTOL MYERS SQUIBB / UPSA'),
(3, 'BOIRON DOLISOS'),
(4, 'TEVA SANTE'),
(5, 'MAYOLY SPINDLER'),
(6, 'PIERRE FABRE MEDICAMENT'),
(7, 'EXPANSCIENCE'),
(8, 'THERABEL LUCIEN PHARMA'),
(9, 'MYLAN'),
(10, 'BIOGARAN'),
(11, 'RECKITT BENCKISER HEALTHCARE'),
(12, 'UCB PHARMA SA'),
(13, 'BOEHRINGER INGELHEIM FRANCE'),
(14, 'NORGINE FRANCE'),
(15, 'MEDAPHARMA'),
(16, 'IPSEN PHARMA'),
(17, 'BAYER SANTE FAMILIALE'),
(18, 'CENTRAL CHIMIOTHERAPIE DERMOC.'),
(19, 'SUNSTAR PHARMADENT'),
(20, 'JOHNSON JOHNSON SANTE BEAUTE'),
(21, 'JOLLY JATEL'),
(22, 'GENEVRIER SA'),
(23, 'PFIZER'),
(24, 'URGO'),
(25, 'BOUCHARA RECORDATI'),
(26, 'ELERTE'),
(27, 'ARROW GENERIQUES'),
(28, 'PIERRE FABRE DERMATOLOGIE'),
(29, 'PIERRE FABRE SANTE'),
(30, 'SERVIER'),
(31, 'SANDOZ SAS'),
(32, 'TECHNI PHARMA'),
(33, 'IPRAD - ALFA WASSERMANN PHARMA'),
(34, 'ZAMBON FRANCE'),
(35, 'MENARINI FRANCE'),
(36, 'CRINEX SA'),
(37, 'BIOCODEX'),
(38, 'GRIMBERG'),
(39, 'TONIPHARM'),
(40, 'ROTTAPHARM - MADAUS'),
(41, 'COOPER'),
(42, 'GIFRER BARBEZAT'),
(43, 'EREMPHARMA'),
(44, 'EG LABO'),
(45, 'LEO PHARMA'),
(46, 'STIEFEL'),
(47, 'MERCK MEDICATION FAMILIALE SAS'),
(48, 'ABBOTT'),
(49, 'NOVARTIS SANTE FAMILIALE SAS'),
(50, 'PROCTER GAMBLE PHARMACEUTICALS'),
(51, 'ALMIRALL SAS'),
(52, 'CHAUVIN BAUSCH LOMB'),
(53, 'EUROPHTA'),
(54, 'WARNER CHILCOTT'),
(55, 'ALLERGAN FRANCE'),
(56, 'LABCATAL'),
(57, 'EFFIK'),
(58, 'THEA'),
(59, 'LEHNING'),
(60, 'FERRIER'),
(61, 'DUCRAY'),
(62, 'CRISTERS'),
(63, 'SOCIETE ETUDES RECH. BIO. SERB'),
(64, 'ALCON SA'),
(65, 'NEGMA - LERADS'),
(66, 'ALMUS FRANCE'),
(67, 'ZYDUS FRANCE SAS'),
(68, 'PLUS PHARMACIE SA'),
(69, 'APTALIS PHARMA SAS'),
(70, 'GRUNENTHAL'),
(71, 'SIGMA-TAU FRANCE'),
(72, 'HRA-PHARMA'),
(73, 'RPG RANBAXY PHARMACIE GENERIQ.'),
(74, 'CEPHALON FRANCE'),
(75, 'BROTHIER NOGUES'),
(76, 'OMEGA PHARMA'),
(77, 'TEOFARMA'),
(78, 'INNOTECH INTERNATIONAL'),
(79, 'GILBERT'),
(80, 'ALTER'),
(81, 'BAILLEUL BIORGA'),
(82, 'SINCLAIR PHARMA'),
(83, 'GLAXOSMITHKLINE SANTE GRD PUB.'),
(84, 'AMDIPHARM'),
(85, 'GALDERMA'),
(86, 'ARKOPHARMA'),
(87, 'BAYER SANTE'),
(88, 'LAPHI PPDH'),
(89, 'LABORATOIRE DES GRANIONS'),
(90, 'ASTELLAS PHARMA'),
(91, 'MSD FRANCE'),
(92, 'TRADIPHAR'),
(93, 'GERDA'),
(94, 'BESINS INTERNATIONAL'),
(95, 'DISSOLVUROL'),
(96, 'JANSSEN CILAG SA'),
(97, 'MOLNLYCKE HEALTH CARE'),
(98, 'NATURACTIVE PLANTES MEDECINES'),
(99, 'HEPATOUM'),
(100, 'CHIESI SA'),
(101, 'FERRING SA'),
(102, 'GUERBET'),
(103, 'BAILLY-CREAT'),
(104, 'DOLIAGE'),
(105, 'IPRAD'),
(106, 'PHARMASTRA'),
(107, 'HORUS PHARMA'),
(108, 'SERP'),
(109, 'DERMOPHIL INDIEN'),
(110, 'DB PHARMA'),
(111, 'SUPER DIET'),
(112, 'AEROCID'),
(113, 'GOMENOL'),
(114, 'HOMME DE FER'),
(115, 'SOFIBEL FUMOUZE'),
(116, 'B BRAUN MEDICAL SAS'),
(117, 'FUCA'),
(118, 'TOULADE'),
(119, 'M. RICHARD SAS'),
(120, 'MAJORELLE'),
(121, 'BIODIM'),
(122, 'WELEDA'),
(123, 'GABA'),
(124, 'PHARMA LAB'),
(125, 'PHARMA REFERENCE / PHR LAB'),
(126, 'BRIDE'),
(127, 'SOLVAY PHARMA'),
(128, 'TISANE PROVENCALE'),
(129, 'BIOPROJET PHARMA'),
(130, 'PHARMA DEVELOPPEMENT'),
(131, 'SODIA'),
(132, 'LISAPHARM'),
(133, 'MERCK SERONO'),
(134, 'PIONNEAU'),
(135, 'UNITHER INDUSTRIES'),
(136, 'DEXO SA'),
(137, 'EXPANPHARM INTERNATIONAL'),
(138, 'ACTAVIS - ARROW GENERIQUES'),
(139, 'NEPENTHES'),
(140, 'PHARMA 2000'),
(141, 'DIETETIQUE ET SANTE'),
(142, 'JUVISE PHARMACEUTICALS'),
(143, 'ROGE CAVAILLES SAS'),
(144, 'MEDIWIN LIMITED'),
(145, 'FORTE PHARMA'),
(146, 'RD PHARMA'),
(147, 'GLAXOSMITHKLINE'),
(148, 'BAYER HEALTHCARE'),
(149, 'GILBERT (GR. BATTEUR)'),
(150, 'FRESENIUS KABI FRANCE'),
(151, 'SANOFI ZENTIVA'),
(152, 'CHAIX ET DU MARAIS'),
(153, 'ROCHE'),
(154, 'DERMATERRA'),
(155, 'SANOFI PASTEUR MSD'),
(156, 'PHARMACIE CENTRALE DES ARMEES'),
(157, 'INNOTHERA'),
(158, 'QUALIMED'),
(159, 'KREUSSLER PHARMA'),
(160, 'ROSA PHYTOPHARMA');

--
-- Contenu de la table `s_familles`
--

INSERT INTO `s_familles` (`id_sfamille`, `id_famille`, `designation`, `ordre_affichage`, `categorie`) VALUES
(0, 0, '---', NULL, NULL),
(1, 1, 'Féminité', 1, 'a'),
(2, 1, 'Grossesse, Ménopause', 1, 'a'),
(3, 1, 'Hygiène, Protection', 1, 'a'),
(4, 1, 'Troubles urinaires', 1, 'a'),
(5, 2, 'Aphtes, Sécheresses', 1, 'a'),
(6, 2, 'Bains de bouche', 1, 'a'),
(7, 2, 'Dentifrice', 1, 'a'),
(8, 2, 'Douleurs dentaires', 1, 'a'),
(10, 3, 'Circulation', 1, 'a'),
(11, 3, 'Coups, Bleus, Bosses', 1, 'a'),
(12, 3, 'Hémorroïdes', 1, 'a'),
(13, 3, 'Hypotension', 1, 'a'),
(14, 4, 'Anti-inflammatoire', 1, 'a'),
(15, 4, 'Antiparasitaire', 1, 'a'),
(16, 4, 'Ballonnements', 1, 'a'),
(17, 4, 'Constipation', 1, 'a'),
(18, 4, 'Diarrhée', 1, 'a'),
(19, 4, 'Digestion difficile', 1, 'a'),
(20, 4, 'Maux d''estomac', 1, 'a'),
(21, 4, 'Nausées', 1, 'a'),
(22, 4, 'Protection flore', 1, 'a'),
(23, 5, 'Anti-inflammatoire: Ibuprofène', 1, 'a'),
(25, 5, 'Aspirine', 1, 'a'),
(26, 5, 'Autres', 1, 'a'),
(27, 5, 'Douleurs articulaires', 1, 'a'),
(28, 5, 'Douleurs musculaires', 1, 'a'),
(29, 5, 'Paracétamol', 1, 'a'),
(30, 6, 'Arrêt du tabac', 1, 'a'),
(31, 6, 'Carence', 1, 'a'),
(32, 6, 'Détente, Sommeil', 1, 'a'),
(33, 6, 'Vertiges, Migraines', 1, 'a'),
(34, 6, 'Vitamines, Toniques', 1, 'a'),
(35, 8, 'Lavages', 1, 'a'),
(36, 8, 'Soins', 1, 'a'),
(38, 10, 'Acné', 1, 'a'),
(39, 10, 'Anti-irritation', 1, 'a'),
(40, 10, 'Apaisant', 1, 'a'),
(41, 10, 'Bouton de fièvre', 1, 'a'),
(42, 10, 'Chute des cheveux', 1, 'a'),
(43, 10, 'Cicatrisant', 1, 'a'),
(44, 10, 'Coups de soleil, Brûlures', 1, 'a'),
(45, 10, 'Désinfectant', 1, 'a'),
(46, 10, 'Irritations, Parasites', 1, 'a'),
(47, 10, 'Mycose', 1, 'a'),
(48, 6, 'Poids', 1, 'a'),
(49, 10, 'Shampoing traitant', 1, 'a'),
(50, 10, 'Verrues, Cors', 1, 'a'),
(51, 11, 'Allergie', 1, 'a'),
(52, 11, 'Bronches, Nez', 1, 'a'),
(53, 11, 'Maux de gorge', 1, 'a'),
(55, 11, 'Rhume, Etats grippaux', 1, 'a'),
(56, 11, 'Toux', 1, 'a'),
(63, 2, 'Homéopathie', 1, 'a'),
(64, 11, 'Homéopathie', 1, 'a'),
(65, 1, 'Homéopathie', 1, 'a'),
(66, 3, 'Homéopathie', 1, 'a'),
(67, 4, 'Homéopathie', 1, 'a'),
(68, 5, 'Homéopathie', 1, 'a'),
(69, 6, 'Homéopathie', 1, 'a'),
(70, 8, 'Homéopathie', 1, 'a'),
(71, 10, 'Homéopathie', 1, 'a'),
(82, 11, 'Oligothérapie', 1, 'a'),
(87, 6, 'Oligothérapie', 1, 'a');

--
-- Contenu de la table `ss_famille`
--

INSERT INTO `ss_famille` (`id_ssfamille`, `id_sfamille`, `id_famille`, `designation`, `ordre_affichage`) VALUES
(0, 0, 0, '---', NULL),
(1, 29, 5, 'Dafalgan', 1),
(2, 29, 5, 'Doliprane', 1),
(3, 29, 5, 'Efferalgan', 1),
(13, 65, 1, 'Troubles urinaires', 1),
(14, 66, 3, 'Circulation', 1),
(15, 68, 5, 'Coups, Bleus, Bosses', 1),
(16, 66, 3, 'Hémorroïdes', 1),
(17, 67, 4, 'Diarrhée', 1),
(18, 67, 4, 'Digestion difficile', 1),
(19, 70, 8, 'Lavages', 1),
(20, 71, 10, 'Cicatrisant', 1),
(22, 71, 10, 'Verrues, Cors', 1),
(23, 69, 6, 'Mal des transports', 1),
(24, 68, 5, 'Douleurs articulaires', 1),
(26, 63, 2, 'Douleurs dentaires', 1),
(27, 69, 6, 'Détente, Sommeil', 1),
(28, 69, 6, 'Vertiges, Migraines', 1),
(29, 69, 6, 'Vitamines', 1),
(30, 71, 10, 'Allergie', 1),
(31, 64, 11, 'Maux de gorge, Allergie', 1),
(32, 64, 11, 'Rhume, Etats grippaux', 1),
(34, 64, 11, 'Toux, Bronches', 1),
(49, 87, 6, 'Détente, Sommeil', 1),
(52, 66, 3, 'Coups, Bleus, Bosses', 1),
(55, 29, 5, 'Autres', 1),
(56, 68, 5, 'Fièvre, Grippe et Rhume', 1);
--
-- Base de données :  `ceido_parapharmacie`
--
USE `ceido_parapharmacie`;

--
-- Contenu de la table `control_images`
--

INSERT INTO `familles` (`id_famille`, `designation`, `ordre_affichage`) VALUES
(1, 'Beauté et Soins', 1),
(2, 'Cheveux', 1),
(3, 'Bébé et Maman', 1),
(4, 'Auto tests', 1),
(5, 'Dentaire', 1),
(6, 'Hygiène', 1),
(7, 'Solaire', 1),
(8, 'Bionature', 1),
(9, 'Diététique', 1),
(10, 'Se soigner', 1),
(11, 'Animaux de compagnie', 1),
(12, 'Santé connectée', 1),
(0, '---', NULL);

--
-- Contenu de la table `laboratoires`
--

INSERT INTO `laboratoires` (`id_laboratoire`, `designation`) VALUES
(1, 'GILBERT (GR. BATTEUR)'),
(2, 'CAUDALIE'),
(3, 'RECKITT BENCKISER HEALTHCARE'),
(4, 'NUTRISANTE'),
(5, 'HORUS PHARMA'),
(6, 'URGO'),
(7, 'OMEGA PHARMA'),
(8, 'SUNSTAR PHARMADENT'),
(9, 'PROCTER GAMBLE PHARMACEUTICALS'),
(10, 'BAYER SANTE FAMILIALE'),
(11, 'COOPER'),
(12, 'DECTRAPHARM'),
(13, 'NUXE'),
(14, 'POLIVE'),
(15, 'SANTE VERTE LTD'),
(16, 'PROTIFAST'),
(17, 'ARAGAN'),
(18, 'ARKOPHARMA'),
(19, 'EXPANSCIENCE'),
(20, 'IPRAD'),
(21, 'GUIGOZ'),
(22, 'KLORANE'),
(23, 'NOVARTIS SANTE FAMILIALE SAS'),
(24, 'ROGE CAVAILLES SAS'),
(25, 'AVENE'),
(26, 'GLAXOSMITHKLINE SANTE GRD PUB.'),
(27, 'JOHNSON JOHNSON SANTE BEAUTE'),
(28, 'INELDEA'),
(29, 'NUTERGIA'),
(30, '3M SANTE'),
(31, 'SANOFLORE'),
(32, 'SVR'),
(33, 'SODILAC'),
(34, 'LES 3 CHENES'),
(35, 'A DERMA'),
(36, 'SABILUC DEP. LCP (GR. BATTEUR)'),
(37, 'URIAGE'),
(38, 'DIEPHARMEX'),
(39, 'VICHY COSMETIQUE ACTIVE FRANCE'),
(40, 'SSL HEALTHCARE FRANCE'),
(41, 'BESINS INTERNATIONAL'),
(42, 'FORTE PHARMA'),
(43, 'PURESSENTIEL FRANCE'),
(44, 'PIERRE FABRE SANTE'),
(45, 'ROCHE POSAY'),
(46, 'MERCK MEDICATION FAMILIALE SAS'),
(47, 'EQUILIBRE ATTITUDE'),
(48, 'PILEJE'),
(49, 'NATURACTIVE PLANTES MEDECINES'),
(50, 'BIODERMA'),
(51, 'NH CO NUTRITION'),
(52, 'BOEHRINGER INGELHEIM FRANCE'),
(53, 'SIDN SANTE NATURELLE'),
(54, 'PRANAROM'),
(55, 'MERIAL'),
(56, 'NOVARTIS SANTE ANIMALE SA'),
(57, 'BAYER DIVISION SANTE ANIMALE'),
(58, 'NOREVA PHARMA - LED'),
(59, 'BLEDINA SA'),
(60, 'HARTMANN LAROCHETTE'),
(61, 'GABA'),
(62, 'ROTTAPHARM - MADAUS'),
(63, 'SANOFI AVENTIS FRANCE'),
(64, 'DUCRAY'),
(65, 'MENARINI FRANCE'),
(66, 'SOFIBEL FUMOUZE'),
(67, 'BOIRON DOLISOS'),
(68, 'RENE FURTERER'),
(69, 'LABORATOIRES DERMAT. EUCERIN'),
(70, 'OENOBIOL SANOFI AVENTIS'),
(71, 'WELEDA'),
(72, 'MAYOLY SPINDLER'),
(73, 'PHYTOSOLBA'),
(74, 'LIERAC'),
(75, 'MAM BABY FRANCE'),
(76, 'TEOFARMA'),
(77, 'VEMEDIA'),
(78, 'GALDERMA'),
(79, 'CHAUVIN BAUSCH LOMB'),
(80, 'ZAMBON FRANCE'),
(81, 'TONIPHARM'),
(82, 'AEROCID'),
(83, 'BAILLEUL BIORGA'),
(84, 'ALCON SA'),
(85, 'GIFRER BARBEZAT'),
(86, 'LEHNING'),
(87, 'LYOCENTRE'),
(88, 'QUIES'),
(89, 'LACTALIS NUTRITION SANTE'),
(90, 'GALENIC'),
(91, 'ALBRENOR PHARMA'),
(92, 'IPRAD - VEGEBOM'),
(93, 'BIOES'),
(94, 'TETRA MEDICAL'),
(95, 'ASEPTA'),
(96, 'FAMADEM - DIAFARM'),
(97, 'DIETETIQUE ET SANTE'),
(98, 'JALDES'),
(99, 'THEA'),
(100, 'ATLANTIC NATURE'),
(101, 'DAYANG'),
(102, 'HORIZANE'),
(103, 'GENEVRIER SA'),
(104, 'GARANCIA'),
(105, 'LR MEDICAL'),
(106, 'EFFIK'),
(107, 'TEVA SANTE'),
(108, 'CRINEX SA'),
(109, 'PHARM''UP'),
(110, 'PFIZER'),
(111, 'TRADIPHAR'),
(112, 'CENTRAL CHIMIOTHERAPIE DERMOC.'),
(113, 'LAPHAL INDUSTRIES'),
(114, 'COSMEDIET'),
(115, 'EISAI'),
(116, 'BSN MEDICAL'),
(117, 'HIRAPHARM'),
(118, 'ABC PHARMACARE'),
(119, 'NUTRIBEN'),
(120, 'LABORATOIRE DES GRANIONS'),
(121, 'DENSMORE'),
(122, 'VITRY'),
(123, 'HAGER & WERKEN GMBH & CO. KG'),
(124, 'SUPER DIET'),
(125, 'TRB CHEMEDICA SAS FRANCE'),
(126, 'SINCLAIR PHARMA'),
(127, 'MILLET INNOVATION'),
(128, 'PRODENE KLINT'),
(129, 'DB PHARMA'),
(130, 'COSBIONAT'),
(131, 'EVAUX LABORATOIRES'),
(132, 'DEXSIL LABS'),
(133, 'YSONUT'),
(134, 'SANTEN'),
(135, 'MONIN CHANTEAUD'),
(136, 'MEAD JOHNSON'),
(137, 'CONTRALCO'),
(138, 'BLUE SKIN'),
(139, 'NEW NORDIC FRANCE'),
(140, 'LEURQUIN MEDIOLANUM'),
(141, 'LERO'),
(142, 'RACINES SA'),
(143, 'BIOETHIC'),
(144, 'MEDAPHARMA'),
(145, 'SYNERGIA'),
(146, 'PHYTALESSENCE'),
(147, 'ALMAFIL'),
(148, 'PHYTHEA'),
(149, 'ROGER GALLET'),
(150, 'OTC CONCEPT'),
(151, 'LABORATOIRE DE LA MER'),
(152, 'ESTIPHARM'),
(153, 'BIOPHARME'),
(154, 'JECARE FRANCE'),
(155, 'SANTISPHARMA AG'),
(156, 'BRISTOL MYERS SQUIBB / UPSA'),
(157, 'ARGILETZ'),
(158, 'COMP. GEN. DIETETIQUE YALACTA'),
(159, 'FILORGA'),
(160, 'OYSTERSHELL'),
(161, 'LILLE HEALTHCARE'),
(162, 'LE PAPIER D''ARMENIE'),
(163, 'CETEM'),
(164, 'BAYER HEALTHCARE'),
(165, 'FRANCE SECURITE'),
(166, 'EAU DES CARMES BOYER'),
(167, 'ABBOTT'),
(168, 'MAVALA'),
(169, 'CODIFRA'),
(170, 'BRAUN'),
(171, 'EMBRYOLISSE'),
(172, 'AUREX'),
(173, 'SODIA'),
(174, 'TVM'),
(175, 'HERMES EDULCORANTS'),
(176, 'DENTORIA'),
(177, 'INTERVET'),
(178, 'VETOQUINOL'),
(179, 'SIEMENS HEALTHCARE DIAGNOSTICS'),
(180, 'CORYNE DE BRUYNES'),
(181, 'DERMOPHIL INDIEN'),
(182, 'DELATEX'),
(183, 'DJO FRANCE'),
(184, 'BROTHIER NOGUES'),
(185, 'PRAIRIAL'),
(186, 'PIONNEAU'),
(187, 'JOHNSON JOHNSON CONSUMER'),
(188, 'SOVEDIS'),
(189, 'CYTOLNAT'),
(190, 'RADIATEX'),
(191, 'MEDI VISION'),
(192, 'DARPHIN'),
(193, 'LABO. CONTACTOLOGIE APPLIQUEE'),
(194, 'RHINO HORN FRANCE'),
(195, 'ECOMAR SA'),
(196, 'BIOPROJET PHARMA'),
(197, 'MEDELA FRANCE'),
(198, 'HRA-PHARMA'),
(199, 'OMRON SANTE FRANCE'),
(200, 'CLEMENT THIONVILLE'),
(201, 'BOUCHARA RECORDATI'),
(202, 'ACM LABORATOIRE DERMATOLOGIQUE'),
(203, 'DISSOLVUROL'),
(204, 'VITAGERMINE'),
(205, 'PHARMATOKA'),
(206, 'EVERGREEN LAND EUROPE'),
(207, 'PIERRE FABRE DERMATOLOGIE'),
(208, 'NUTRIVERCELL'),
(209, 'MAGNIEN'),
(210, 'ACTIVA'),
(211, 'SERP'),
(212, 'LABOLAC'),
(213, 'IPRAD - ALFA WASSERMANN PHARMA'),
(214, 'VITALCO'),
(215, 'NESTLE FRANCE'),
(216, 'DOLIAGE'),
(217, 'EURODEP'),
(218, 'MATERNOV'),
(219, 'AGETI'),
(220, 'INSTITUT PHYTOCEUTIC'),
(221, 'ABOCA'),
(222, 'SKINCLEVER'),
(223, 'JIANGI SARL'),
(224, 'GILBERT (GR. BATTEUR)'),
(225, 'LABO. CONTACTOLOGIE APPLIQUEE'),
(226, 'SABILUC DEP. LCP (GR. BATTEUR)'),
(227, 'LABORATOIRES DERMAT. EUCERIN'),
(228, 'COMP. GEN. DIETETIQUE YALACTA'),
(229, 'HAGER & WERKEN GMBH & CO. KG'),
(230, '20.00 %'),
(231, 'AUVEX'),
(232, 'LILLY FRAN. ELANCO VETERINAIRE'),
(233, 'SEMES'),
(234, 'EUROMEDIS'),
(235, 'MOLNLYCKE HEALTH CARE'),
(236, 'NESTLE CLINICAL NUTRITION'),
(237, 'DIFFUSION TECHNIQUE FRANCAISE'),
(238, 'ANSELL SA'),
(239, 'FRESENIUS KABI FRANCE'),
(240, 'VISIOMED'),
(241, 'COLOPLAST'),
(242, 'FGP PHARMA GMBH'),
(243, 'ARTSANA'),
(244, 'SCA HYGIENE PRODUCTS'),
(245, 'VALATEX'),
(246, 'SOGIPHAR'),
(247, 'MYLAN'),
(248, 'SMITH AND NEPHEW'),
(249, 'LEADER SANTE'),
(250, 'PEDIACT'),
(251, 'CEFAR COMPEX FRANCE'),
(252, 'POLIDIS'),
(253, 'EUROPHTA'),
(254, 'BECTON DICKINSON FRANCE SA'),
(255, 'SCHWA MEDICO FRANCE'),
(256, 'B BRAUN MEDICAL SAS'),
(257, 'NUTRICIA NUTRITION CLINIQUE'),
(258, 'ARIANE MEDICAL CONSULTING'),
(259, 'MEDIFLUX'),
(260, 'PHARMA DEVELOPPEMENT'),
(261, 'PULMO MED'),
(262, 'AGUETTANT'),
(263, 'CEORA'),
(264, 'FREESENS'),
(265, 'GLAXOSMITHKLINE'),
(266, 'SONALTO'),
(267, 'CONVATEC'),
(268, 'GYNEAS'),
(269, 'NICOX PHARMA'),
(270, 'PETERS SURGICAL'),
(271, 'SINOVITAL'),
(272, 'ADP JARMAT'),
(273, 'PHITEST'),
(274, 'THUASNE'),
(275, 'HOLLISTER'),
(276, 'SYSTEM ASSISTANCE MEDICAL'),
(277, 'JANVIER'),
(278, 'BIOPREVENTIS'),
(279, 'PILES MR'),
(280, 'SOLGAR FRANCE'),
(281, 'DERMATERRA'),
(282, 'AIRPLUS FOOTCARE'),
(283, 'MELVITA'),
(284, 'FLOMED SERVICE'),
(285, 'INRESA'),
(286, 'PROTEC''SOM'),
(287, 'LCH MEDICAL PRODUCTS'),
(288, 'LABODERM'),
(289, 'ABC PHARMA'),
(290, 'BENEDETTI'),
(291, 'CORMAN S.P.A'),
(292, 'CONTAPHARM'),
(293, 'SANTINOV'),
(294, 'JARIMEX DAMPLE'),
(295, 'MARVEL'),
(296, 'MKL'),
(297, 'MAPS INTERNATIONAL'),
(298, 'ALFA GREEN'),
(299, 'DR SCHEFFLER FRANCE'),
(300, 'ID PHARMA'),
(301, 'APURNA NUTRITION LACTALIS'),
(302, 'L''OCCITANE EN PROVENCE');

--
-- Contenu de la table `s_familles`
--

INSERT INTO `s_familles` (`id_sfamille`, `id_famille`, `designation`, `ordre_affichage`, `categorie`) VALUES
(10, 1, 'Visage', 1, 'a'),
(11, 1, 'Corps', 2, 'a'),
(12, 1, 'Mains', 3, 'a'),
(13, 1, 'Pieds', 4, 'a'),
(14, 1, 'Maquillage', 5, 'a'),
(15, 1, 'Soins hommes', 6, 'a'),
(16, 1, 'Bien-être', 7, 'a'),
(20, 2, 'Shampoings', 8, 'a'),
(21, 2, 'Après shampoings', 9, 'a'),
(22, 2, 'Soins des cheveux', 10, 'a'),
(23, 2, 'Produits coiffants', 11, 'a'),
(24, 2, 'Colorations', 12, 'a'),
(25, 2, 'Anti-chutes', 13, 'a'),
(26, 2, 'Anti-poux', 14, 'a'),
(30, 3, 'Alimentation', 15, 'a'),
(31, 3, 'Biberons, Tétines', 16, 'a'),
(32, 3, 'Hygiène BB', 17, 'a'),
(33, 3, 'Puériculture', 18, 'a'),
(34, 3, 'Grossesse', 19, 'a'),
(35, 3, 'Allaitement', 20, 'a'),
(40, 4, 'Femme', 21, 'a'),
(41, 4, 'Orientation diagnostic', 22, 'a'),
(42, 4, 'Appareils de mesure', 23, 'a'),
(50, 5, 'Dentifrices', 24, 'a'),
(51, 5, 'Brosses à dents', 25, 'a'),
(52, 5, 'Brossettes', 26, 'a'),
(53, 5, 'Fils dentaires', 27, 'a'),
(54, 5, 'Bains de bouche, haleines fraîches', 28, 'a'),
(55, 5, 'Aphtes, Douleurs', 29, 'a'),
(56, 5, 'Appareils dentaires et accessoires', 30, 'a'),
(61, 6, 'Yeux', 31, 'a'),
(62, 6, 'Nez', 32, 'a'),
(63, 6, 'Oreilles', 33, 'a'),
(64, 6, 'Hygiène intime', 34, 'a'),
(65, 6, 'Troubles urinaires et Incontinence', 35, 'a'),
(66, 6, 'Sexualité', 36, 'a'),
(67, 6, 'Premiers soins', 37, 'a'),
(68, 6, 'Intérieurs maisons sprays', 38, 'a'),
(70, 7, 'Protection solaire Adultes', 39, 'a'),
(71, 7, 'Protection solaire Enfants et BB', 40, 'a'),
(72, 7, 'Après soleil', 41, 'a'),
(73, 7, 'Capillaire solaire', 42, 'a'),
(74, 7, 'Diététique solaire', 43, 'a'),
(75, 7, 'Autobronzants et Crèmes teintées', 44, 'a'),
(76, 7, 'Anti-moustiques', 45, 'a'),
(80, 8, 'Cosmétiques BIO', 46, 'a'),
(81, 8, 'Hygiène BIO', 47, 'a'),
(82, 8, 'Phytothérapie BIO', 48, 'a'),
(83, 8, 'Tisanes BIO', 49, 'a'),
(84, 8, 'Aromathérapie BIO', 50, 'a'),
(85, 8, 'Tisanes', 51, 'a'),
(86, 8, 'Phytotherapie', 52, 'a'),
(87, 8, 'Aromathérapie', 53, 'a'),
(90, 9, 'Brûles graisses', 54, 'a'),
(91, 9, 'Draineurs', 55, 'a'),
(92, 9, 'Crèmes amincissantes', 56, 'a'),
(93, 9, 'Coupes faim -Substituts', 57, 'a'),
(94, 9, 'Hyperprotéinés', 58, 'a'),
(95, 9, 'Diététique sportive', 59, 'a'),
(100, 10, 'Douleurs', 60, 'a'),
(101, 10, 'Vision', 61, 'a'),
(102, 10, 'Nez Gorge Oreille Respiration', 62, 'a'),
(103, 10, 'Mémoire', 63, 'a'),
(104, 10, 'Stress, Sommeil', 64, 'a'),
(105, 10, 'Digestion, Transit', 65, 'a'),
(106, 10, 'Maternité, Ménopause', 66, 'a'),
(107, 10, 'Circulation veineuse', 67, 'a'),
(108, 10, 'Beauté', 68, 'a'),
(109, 10, 'Autres', 69, 'a'),
(110, 11, 'Vermifuges Digestion', 70, 'a'),
(111, 11, 'Anti-puces, Anti-tiques', 71, 'a'),
(112, 11, 'Dermatologie-Soins externes', 72, 'a'),
(113, 11, 'Soins internes', 73, 'a'),
(114, 11, 'Toilettage', 74, 'a'),
(120, 12, 'Appareils de mesure', 75, 'a'),
(121, 12, 'Activités physiques', 76, 'a'),
(122, 12, 'Tensiomètres', 77, 'a'),
(123, 12, 'Lecteurs de glycémie', 78, 'a'),
(0, 0, '---', NULL, NULL);

--
-- Contenu de la table `ss_famille`
--

INSERT INTO `ss_famille` (`id_ssfamille`, `id_sfamille`, `id_famille`, `designation`, `ordre_affichage`) VALUES
(1000, 10, 1, 'Démaquillants, Nettoyants', 1),
(1001, 10, 1, 'Soins hydratants nourrissants', 1),
(1002, 10, 1, 'Contours des yeux', 1),
(1003, 10, 1, 'Sticks, Baumes à lèvres', 1),
(1004, 10, 1, 'Gommages, Masques', 1),
(1005, 10, 1, 'Soins anti-âge, anti-rides', 1),
(1006, 10, 1, 'Soins traitants', 1),
(1010, 11, 1, 'Gommage-Tonique corps', 1),
(1011, 11, 1, 'Soins hydratants -Huiles -Traitants', 1),
(1012, 11, 1, 'Bain – douche', 1),
(1013, 11, 1, 'Déodorants -Parfums', 1),
(1020, 12, 1, 'Mains desséchées ou abîmées', 1),
(1021, 12, 1, 'Manucure - Traitants', 1),
(1030, 13, 1, 'Pieds secs ou abîmés', 1),
(1031, 13, 1, 'Pieds fatigués et échauffés', 1),
(1032, 13, 1, 'Gommages', 1),
(1033, 13, 1, 'Protections des pieds et coussinets', 1),
(1034, 13, 1, 'Accessoires -traitement', 1),
(1040, 14, 1, 'Teint', 1),
(1041, 14, 1, 'Yeux', 1),
(1042, 14, 1, 'Lèvres', 1),
(1043, 14, 1, 'Ongles', 1),
(1050, 15, 1, 'Rasage', 1),
(1051, 15, 1, 'Soins hydratants', 1),
(1052, 15, 1, 'Soins anti-âge', 1),
(1060, 16, 1, 'Huiles essentielles', 1),
(1061, 16, 1, 'Vitamines et minéraux', 1),
(1062, 16, 1, 'Nervosité, stress, sommeil', 1),
(1063, 16, 1, 'Jambes lourdes', 1),
(1064, 16, 1, 'Douleurs musculaires ou articulaires', 1),
(1310, 32, 3, 'Change de bb', 1),
(1311, 32, 3, 'Bain, toilette', 1),
(1312, 32, 3, 'Soins hydratants', 1),
(1400, 40, 4, 'Test de grossesse', 1),
(1401, 40, 4, 'Test d’ovulation', 1),
(1402, 40, 4, 'Test de ménopause', 1),
(1403, 40, 4, 'Test de fertilité', 1),
(1404, 40, 4, 'Test infection urinaire', 1),
(1405, 41, 4, 'Intolerance Allergie', 1),
(1406, 41, 4, 'Autres tests', 1),
(1407, 42, 4, 'Glycemie', 1),
(1408, 42, 4, 'Poids', 1),
(1409, 42, 4, 'Temperature', 1),
(1410, 42, 4, 'Tension', 1),
(1411, 42, 4, 'Tension', 1),
(1610, 64, 6, 'Toilettes intime', 1),
(1611, 64, 6, 'Protections hygiéniques', 1),
(1660, 66, 6, 'Préservatifs', 1),
(1661, 66, 6, 'Lubrifiants', 1),
(1670, 67, 6, 'Pansements-Bandes', 1),
(1671, 67, 6, 'Désinfectants', 1),
(1672, 67, 6, 'cicatrisations', 1),
(1500, 120, 12, 'Fréquences cardiaques', 1),
(1501, 120, 12, 'Tensiomètres', 1),
(1502, 120, 12, 'Lecteurs de glycémie', 1),
(0, 0, 0, '---', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
