--
-- Base de données :  `ceido_parapharmacie`
--
CREATE DATABASE IF NOT EXISTS `ceido_parapharmacie` DEFAULT CHARACTER SET utf16 COLLATE utf16_general_ci;
USE `ceido_parapharmacie`;

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
-- Structure de la table `coup_de_coeur`
--

DROP TABLE IF EXISTS `coup_de_coeur`;
CREATE TABLE IF NOT EXISTS `coup_de_coeur` (
  `id_coup_de_coeur` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) DEFAULT NULL,
  `num_semaine` int(11) DEFAULT NULL,
  `titre_general` char(40) NOT NULL,
  `cip_coup_de_coeur` char(13) DEFAULT NULL,
  `presentation_julie` char(250) DEFAULT NULL,
  `accroche` char(60) DEFAULT NULL,
  `descriptif` char(250) DEFAULT NULL,
  `conseil_malin` char(250) DEFAULT NULL,
  `le_petit_plus` char(210) DEFAULT NULL,
  PRIMARY KEY (`id_coup_de_coeur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `familles`
--

DROP TABLE IF EXISTS `familles`;
CREATE TABLE IF NOT EXISTS `familles` (
  `id_famille` int(11) NOT NULL,
  `designation` char(60) DEFAULT NULL,
  `ordre_affichage` int(11) DEFAULT NULL
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
-- Structure de la table `nos_marques`
--

DROP TABLE IF EXISTS `nos_marques`;
CREATE TABLE IF NOT EXISTS `nos_marques` (
  `id_nos_marques` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) DEFAULT NULL,
  `id_laboratoire` int(11) DEFAULT NULL,
  `concerne` char(1) DEFAULT 'n',
  PRIMARY KEY (`id_nos_marques`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id_produit` int(11) UNSIGNED NOT NULL,
  `cacl` char(15) DEFAULT NULL,
  `cip13` char(15) DEFAULT NULL,
  `ordre_top` int(11) DEFAULT NULL,
  `libelle_ospharm` char(200) DEFAULT NULL,
  `composition` text,
  `descriptif` text,
  `conseils` text,
  `id_famille` int(11) DEFAULT NULL,
  `id_sfamille` int(11) DEFAULT NULL,
  `id_ssfamille` int(11) DEFAULT NULL,
  `id_laboratoire` int(11) DEFAULT NULL,
  `id_tva` decimal(13,2) DEFAULT NULL,
  `prix` decimal(13,2) DEFAULT NULL,
  `date_traitement` date DEFAULT NULL,
  `produit_actif` char(1) DEFAULT 'i',
  `id_produit_lien` int(11) DEFAULT NULL,
  `code_int_ceido_1` char(15) DEFAULT NULL,
  `code_int_ceido_2` char(15) DEFAULT NULL,
  `code_int_ceido_3` char(15) DEFAULT NULL,
  `limite` int(11) DEFAULT NULL,
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
  `id_sfamille` int(11) NOT NULL,
  `id_famille` int(11) DEFAULT NULL,
  `designation` char(100) DEFAULT NULL,
  `ordre_affichage` int(11) DEFAULT NULL,
  `categorie` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ss_famille`
--

DROP TABLE IF EXISTS `ss_famille`;
CREATE TABLE IF NOT EXISTS `ss_famille` (
  `id_ssfamille` int(11) NOT NULL,
  `id_sfamille` int(11) DEFAULT NULL,
  `id_famille` int(11) DEFAULT NULL,
  `designation` char(100) DEFAULT NULL,
  `ordre_affichage` int(11) DEFAULT NULL
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
