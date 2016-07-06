-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 05 Juillet 2016 à 09:13
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ceidotest_medicaments`
--
CREATE DATABASE IF NOT EXISTS `ceidotest_medicaments` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ceidotest_medicaments`;

-- --------------------------------------------------------

--
-- Structure de la table `control_images`
--

DROP TABLE IF EXISTS `control_images`;
CREATE TABLE IF NOT EXISTS `control_images` (
  `cip13` varchar(13) NOT NULL,
  `image` tinyint(1) NOT NULL,
  `vignette` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `familles`
--

DROP TABLE IF EXISTS `familles`;
CREATE TABLE IF NOT EXISTS `familles` (
  `id_famille` int(11) NOT NULL AUTO_INCREMENT,
  `designation` char(60) DEFAULT NULL,
  `ordre_affichage` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_famille`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `laboratoires`
--

DROP TABLE IF EXISTS `laboratoires`;
CREATE TABLE IF NOT EXISTS `laboratoires` (
  `id_laboratoire` int(11) NOT NULL AUTO_INCREMENT,
  `designation` char(60) DEFAULT NULL,
  PRIMARY KEY (`id_laboratoire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `param_connex`
--

DROP TABLE IF EXISTS `param_connex`;
CREATE TABLE IF NOT EXISTS `param_connex` (
  `id_table_connect` int(11) NOT NULL AUTO_INCREMENT,
  `base_medicaments_asp` char(200) DEFAULT NULL,
  `base_medicaments` char(200) DEFAULT NULL,
  PRIMARY KEY (`id_table_connect`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `patientsaaaa`
--

DROP TABLE IF EXISTS `patientsaaaa`;
CREATE TABLE IF NOT EXISTS `patientsaaaa` (
  `id_patient` int(11) NOT NULL AUTO_INCREMENT,
  `id_pharmacie` int(11) DEFAULT NULL,
  `fh` char(1) DEFAULT NULL,
  `nom` char(50) DEFAULT NULL,
  `prenom` char(50) DEFAULT NULL,
  `journaissance` char(2) DEFAULT NULL,
  `moisnaissance` char(2) DEFAULT NULL,
  `anneenaissance` char(4) DEFAULT NULL,
  `email` char(80) DEFAULT NULL,
  `adresse` char(50) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` char(50) DEFAULT NULL,
  `motdepasse` char(10) DEFAULT NULL,
  `taille` int(11) DEFAULT NULL,
  `poids` int(11) DEFAULT NULL,
  `enceinte` char(1) DEFAULT NULL,
  `allaitement` char(1) DEFAULT NULL,
  `traitementencours` text NOT NULL,
  `allergie` text NOT NULL,
  `antecedents` text NOT NULL,
  PRIMARY KEY (`id_patient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id_produit` int(11) NOT NULL AUTO_INCREMENT,
  `cis` char(15) DEFAULT NULL,
  `cip13` char(15) DEFAULT NULL,
  `id_famille` int(11) DEFAULT NULL,
  `id_sfamille` int(11) DEFAULT NULL,
  `id_ssfamille` int(11) DEFAULT NULL,
  `limite` int(11) DEFAULT NULL,
  `denomination` longtext NOT NULL,
  `presentation` text NOT NULL,
  `id_laboratoire` int(11) DEFAULT NULL,
  `id_tva` decimal(13,2) DEFAULT NULL,
  `prix_moyen` decimal(13,2) DEFAULT NULL,
  `ordre_top` int(11) DEFAULT NULL,
  `date_traitement` date DEFAULT NULL,
  `produit_actif` char(1) DEFAULT NULL,
  `prix_public` decimal(13,2) DEFAULT NULL,
  `ansm` char(100) DEFAULT NULL,
  `libelle_ospharm` char(200) DEFAULT NULL,
  PRIMARY KEY (`id_produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produits_cip1234567`
--

DROP TABLE IF EXISTS `produits_cip1234567`;
CREATE TABLE IF NOT EXISTS `produits_cip1234567` (
  `id_produit_pharma` int(11) NOT NULL AUTO_INCREMENT,
  `cip13` char(14) DEFAULT NULL,
  `prix_ttc` decimal(2,0) DEFAULT NULL,
  `exclus` char(1) DEFAULT NULL,
  `prix_promo` decimal(13,2) DEFAULT NULL,
  `date_deb_promo` date DEFAULT NULL,
  `date_fin_promo` date DEFAULT NULL,
  `id_laboratoire` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_produit_pharma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produits_cip2007650`
--

DROP TABLE IF EXISTS `produits_cip2007650`;
CREATE TABLE IF NOT EXISTS `produits_cip2007650` (
  `id_produit_pharma` int(11) NOT NULL AUTO_INCREMENT,
  `cip13` char(14) DEFAULT NULL,
  `prix_ttc` decimal(13,2) DEFAULT NULL,
  `exclus` char(1) DEFAULT NULL,
  `prix_promo` decimal(13,2) DEFAULT NULL,
  `date_deb_promo` date DEFAULT NULL,
  `date_fin_promo` date DEFAULT NULL,
  `id_laboratoire` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_produit_pharma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produits_cip2016471`
--

DROP TABLE IF EXISTS `produits_cip2016471`;
CREATE TABLE IF NOT EXISTS `produits_cip2016471` (
  `id_produit_pharma` int(11) NOT NULL AUTO_INCREMENT,
  `cip13` char(14) DEFAULT NULL,
  `prix_ttc` decimal(13,2) DEFAULT NULL,
  `exclus` char(1) DEFAULT NULL,
  `prix_promo` decimal(13,2) DEFAULT NULL,
  `date_deb_promo` date DEFAULT NULL,
  `date_fin_promo` date DEFAULT NULL,
  `id_laboratoire` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_produit_pharma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produits_cip2016576`
--

DROP TABLE IF EXISTS `produits_cip2016576`;
CREATE TABLE IF NOT EXISTS `produits_cip2016576` (
  `id_produit_pharma` int(11) NOT NULL AUTO_INCREMENT,
  `cip13` char(14) DEFAULT NULL,
  `prix_ttc` decimal(13,2) DEFAULT NULL,
  `exclus` char(1) DEFAULT NULL,
  `prix_promo` decimal(13,2) DEFAULT NULL,
  `date_deb_promo` date DEFAULT NULL,
  `date_fin_promo` date DEFAULT NULL,
  `id_laboratoire` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_produit_pharma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produits_cip2068954`
--

DROP TABLE IF EXISTS `produits_cip2068954`;
CREATE TABLE IF NOT EXISTS `produits_cip2068954` (
  `id_produit_pharma` int(11) NOT NULL AUTO_INCREMENT,
  `cip13` char(14) DEFAULT NULL,
  `prix_ttc` decimal(13,2) DEFAULT NULL,
  `exclus` char(1) DEFAULT NULL,
  `prix_promo` decimal(13,2) DEFAULT NULL,
  `date_deb_promo` date DEFAULT NULL,
  `date_fin_promo` date DEFAULT NULL,
  `id_laboratoire` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_produit_pharma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produits_cip2235681`
--

DROP TABLE IF EXISTS `produits_cip2235681`;
CREATE TABLE IF NOT EXISTS `produits_cip2235681` (
  `id_produit_pharma` int(11) NOT NULL AUTO_INCREMENT,
  `cip13` char(14) DEFAULT NULL,
  `prix_ttc` decimal(13,2) DEFAULT NULL,
  `exclus` char(1) DEFAULT NULL,
  `prix_promo` decimal(13,2) DEFAULT NULL,
  `date_deb_promo` date DEFAULT NULL,
  `date_fin_promo` date DEFAULT NULL,
  `id_laboratoire` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_produit_pharma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `s_familles`
--

DROP TABLE IF EXISTS `s_familles`;
CREATE TABLE IF NOT EXISTS `s_familles` (
  `id_sfamille` int(11) NOT NULL AUTO_INCREMENT,
  `id_famille` int(11) DEFAULT NULL,
  `designation` char(100) DEFAULT NULL,
  `ordre_affichage` int(11) DEFAULT NULL,
  `categorie` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_sfamille`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sqlmapoutput`
--

DROP TABLE IF EXISTS `sqlmapoutput`;
CREATE TABLE IF NOT EXISTS `sqlmapoutput` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ss_famille`
--

DROP TABLE IF EXISTS `ss_famille`;
CREATE TABLE IF NOT EXISTS `ss_famille` (
  `id_ssfamille` int(11) NOT NULL AUTO_INCREMENT,
  `id_sfamille` int(11) DEFAULT NULL,
  `id_famille` int(11) DEFAULT NULL,
  `designation` char(100) DEFAULT NULL,
  `ordre_affichage` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ssfamille`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tva`
--

DROP TABLE IF EXISTS `tva`;
CREATE TABLE IF NOT EXISTS `tva` (
  `id_tva` int(11) NOT NULL AUTO_INCREMENT,
  `taux` decimal(13,2) DEFAULT NULL,
  `designation` char(40) DEFAULT NULL,
  PRIMARY KEY (`id_tva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` char(60) DEFAULT NULL,
  `email_utilisateur` char(60) DEFAULT NULL,
  `login_utilisateur` char(20) DEFAULT NULL,
  `passe_utilisateur` char(20) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
