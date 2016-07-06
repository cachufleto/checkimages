--
-- Base de données :  `ceidotest_surfimages`
--
CREATE DATABASE IF NOT EXISTS `ceidotest_surfimages` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ceidotest_surfimages`;

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `site` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `produit` varchar(255) DEFAULT NULL,
  `upload` tinyint(1) DEFAULT '0',
  `zapper` tinyint(4) DEFAULT '0',
  `cip13` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nom` (`nom`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Liste des images';

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id_image` int(10) UNSIGNED NOT NULL,
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cip13` char(15) DEFAULT NULL,
  `denomination` longtext NOT NULL,
  `presentation` text NOT NULL,
  `type` int(1) DEFAULT NULL,
  `date_traitement` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `libelle` char(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
