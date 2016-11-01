-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 01 Novembre 2016 à 15:20
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `immoerp_v2`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_alert`
--

CREATE TABLE IF NOT EXISTS `t_alert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alert` text,
  `status` int(12) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `t_alert`
--

INSERT INTO `t_alert` (`id`, `alert`, `status`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(12, 'alerte', 0, '2016-03-14 05:57:42', 'admin', NULL, NULL),
(13, 'alerte', 0, '2016-03-14 05:57:47', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_appartement`
--

CREATE TABLE IF NOT EXISTS `t_appartement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `superficie` decimal(10,2) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `montantRevente` decimal(10,2) DEFAULT NULL,
  `niveau` varchar(45) DEFAULT NULL,
  `facade` varchar(45) DEFAULT NULL,
  `nombrePiece` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `cave` varchar(45) DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  `par` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=464 ;

--
-- Contenu de la table `t_appartement`
--

INSERT INTO `t_appartement` (`id`, `nom`, `superficie`, `prix`, `montantRevente`, `niveau`, `facade`, `nombrePiece`, `status`, `cave`, `idProjet`, `par`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(448, 'a1', '80.00', '5700000.00', NULL, '2', 'FA1', '5', 'Vendu', 'Avec', 15, '', NULL, NULL, NULL, NULL),
(449, 'A2', '85.00', '500000.00', NULL, '1', '2', '3', 'Vendu', 'Avec', 15, '', NULL, NULL, '2015-11-04 05:28:47', 'admin'),
(450, 'B1', '106.00', '680000.00', NULL, 'RC', '1', '3', 'Vendu', 'Avec', 16, '', NULL, NULL, NULL, NULL),
(453, 'a3', '91.00', '800000.00', NULL, '1', 'FA1', '6', 'Vendu', 'Avec', 15, '', '2015-11-04 04:40:33', 'admin', '2015-11-04 05:26:03', 'admin'),
(454, 'a4', '120.00', '1200000.00', NULL, '3', 'FA2', '7', 'Vendu', 'Avec', 15, 'Echami', '2015-11-04 05:48:46', 'admin', '2015-11-04 06:01:46', 'admin'),
(455, 'ap1', '90.00', '8500000.00', NULL, '2', 'F1', '6', 'Vendu', 'Avec', 18, '', '2015-11-04 08:23:05', 'admin', NULL, NULL),
(459, 'A7', '90.00', '1000000.00', NULL, '1', '125', '6', 'Vendu', 'Avec', 15, 'Ghizlan Meddahi', '2015-12-31 03:37:12', 'admin', '2015-12-31 03:38:28', 'admin'),
(456, 'AP2AN3', '89.00', '8000000.00', NULL, '2', '80', '5', 'Vendu', 'Avec', 18, '', '2015-12-08 12:09:35', 'admin', NULL, NULL),
(458, 'A8', '80.00', '550000.00', NULL, '3', '100', '5', 'Vendu', 'Avec', 15, '', '2015-12-16 01:57:27', 'admin', NULL, NULL),
(460, 'AZZER', '120.00', '730000.00', NULL, '3', '80', '6', 'Vendu', 'Avec', 15, '', '2016-02-25 06:08:31', 'admin', NULL, NULL),
(461, 'ADFR', '80.00', '880000.00', NULL, '1', '80', '6', 'Vendu', 'Avec', 15, 'Karim Ajouaou - 89000', '2016-03-07 04:43:31', 'admin', NULL, NULL),
(462, 'A11', '87.00', '790000.00', NULL, '1', 'A', '6', 'Vendu', 'Avec', 16, '', '2016-07-13 03:34:03', 'admin', NULL, NULL),
(463, 'A107', '87.00', '660000.00', NULL, '1', '25-80', '6', 'Vendu', 'Avec', 15, '', '2016-07-25 12:59:00', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_bien`
--

CREATE TABLE IF NOT EXISTS `t_bien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) DEFAULT NULL,
  `etage` varchar(45) DEFAULT NULL,
  `superficie` decimal(10,2) DEFAULT NULL,
  `facade` varchar(45) DEFAULT NULL,
  `reserve` varchar(10) DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_bug`
--

CREATE TABLE IF NOT EXISTS `t_bug` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bug` text,
  `lien` text,
  `status` int(2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `t_bug`
--

INSERT INTO `t_bug` (`id`, `bug`, `lien`, `status`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1, 'test', 'test', 0, '2015-12-17 03:46:18', 'admin', NULL, NULL),
(2, 'Error 404', 'http://localhost/AnnahdaProjet/bugs.php', 0, '2015-12-17 03:46:45', 'admin', NULL, NULL),
(3, 'http://localhost/AnnahdaProjet/bugs.php', 'http://localhost/AnnahdaProjet/bugs.php', 0, '2015-12-17 03:48:55', 'admin', NULL, NULL),
(4, 'Call to a member function fetch() on a non-object in /home/u914861886/public_html/model/HistoryManager.php on line 65', 'http://nodom.esy.es/history.php', 0, '2015-12-19 04:38:42', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_caisse`
--

CREATE TABLE IF NOT EXISTS `t_caisse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `dateOperation` date DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `destination` varchar(50) DEFAULT NULL,
  `companyID` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `t_caisse`
--

INSERT INTO `t_caisse` (`id`, `type`, `dateOperation`, `montant`, `designation`, `destination`, `companyID`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(4, 'Entree', '2015-12-09', '3000.00', 'Mohamed Frais d&eacute;placements', 'Annahda 1', NULL, '2015-12-09 11:28:59', 'admin', '2015-12-16 02:00:39', 'admin'),
(9, 'Entree', '2015-11-12', '1000.00', '', 'Annahda 1', NULL, '2015-12-09 11:48:11', 'admin', NULL, NULL),
(10, 'Sortie', '2015-08-13', '200.00', '', 'Annahda 1', NULL, '2015-12-09 11:49:22', 'admin', NULL, NULL),
(11, 'Sortie', '2015-12-16', '2000.00', 'Salim', 'Bureau', NULL, '2015-12-16 02:18:53', 'admin', NULL, NULL),
(12, 'Sortie', '2015-12-22', '200.00', 'Nettotage', 'Bureau', NULL, '2015-12-22 03:56:01', 'admin', NULL, NULL),
(13, 'Entree', '2016-02-26', '200.00', 'AZERTY', 'Bureau', NULL, '2016-02-26 04:43:09', 'admin', '2016-02-26 06:25:11', 'admin'),
(14, 'Sortie', '2016-02-26', '300.00', 'QWERTY', 'Bureau', NULL, '2016-02-26 04:43:26', 'admin', NULL, NULL),
(15, 'Entree', '2016-03-02', '100.00', 'test', 'Bureau', NULL, '2016-03-02 10:27:11', 'admin', NULL, NULL),
(16, 'Entree', '2016-01-13', '100.00', 'kfk', 'Bureau', NULL, '2016-03-02 10:27:26', 'admin', NULL, NULL),
(17, 'Entree', '2015-04-08', '100.00', 'test', 'Bureau', NULL, '2016-03-02 10:27:45', 'admin', NULL, NULL),
(18, 'Entree', '2015-10-07', '100.00', 'test', 'Bureau', NULL, '2016-03-02 10:28:16', 'admin', NULL, NULL),
(19, 'Entree', '2015-04-09', '200.00', 'jgi', 'Bureau', NULL, '2016-03-02 10:28:34', 'admin', NULL, NULL),
(20, 'Entree', '2016-08-08', '150.00', 'Test de ImmoERPV2', 'Bureau', 4, '2016-08-08 08:28:30', 'admin', '2016-08-09 12:20:37', 'admin'),
(21, 'Entree', '2016-08-08', '200.00', 'Test de ImmoERPV2', 'Bureau', 4, '2016-08-08 08:29:12', 'admin', NULL, NULL),
(22, 'Sortie', '2016-08-08', '260.00', 'Test de ImmoERPV2 ', 'Bureau', 4, '2016-08-08 08:43:47', 'admin', '2016-08-09 12:23:33', 'admin'),
(23, 'Sortie', '2016-07-08', '300.00', 'Test 2 ImmoERPV2', 'Bureau', 4, '2016-08-08 08:45:45', 'admin', NULL, NULL),
(24, 'Entree', '2016-07-21', '1000.00', 'Test ImmoERPV2', 'Bureau', 4, '2016-08-09 12:14:46', 'admin', NULL, NULL),
(25, 'Sortie', '2016-07-20', '140.00', 'Sidi Ali + Dejeuner', 'Bureau', 4, '2016-08-09 12:15:27', 'admin', NULL, NULL),
(26, 'Entree', '2016-10-26', '120.00', 'Rien', 'Bureau', 1, '2016-10-26 11:50:57', 'admin', NULL, NULL),
(27, 'Entree', '2016-10-26', '2000.00', 'Plus', 'Bureau', 1, '2016-10-26 12:08:40', 'admin', NULL, NULL),
(28, 'Sortie', '2016-10-26', '1200.00', 'Achats de ...', 'ImmoERP 2', 1, '2016-10-26 12:09:55', 'admin', NULL, NULL),
(29, 'Entree', '2016-10-26', '350.00', 'Mortgage', 'ImmoERP 1', 1, '2016-10-26 12:10:44', 'admin', NULL, NULL),
(30, 'Sortie', '2016-10-26', '2350.00', 'Fourniture (2PC+Imprimante)', 'Bureau', 1, '2016-10-26 12:11:12', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_charge`
--

CREATE TABLE IF NOT EXISTS `t_charge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) DEFAULT NULL,
  `dateOperation` date DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `societe` varchar(50) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `idProjet` int(12) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `t_charge`
--

INSERT INTO `t_charge` (`id`, `type`, `dateOperation`, `montant`, `societe`, `designation`, `idProjet`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(2, '4', '2015-11-02', '30000.00', 'Soci&eacute;t&eacute; Annahda', 'Soci&eacute;t&eacute; Massyn', 18, '2015-11-06 06:10:33', 'admin', '2016-01-18 04:10:37', 'admin'),
(3, '3', '2015-11-01', '40000.00', 'Soci&eacute;t&eacute; A', 'Jamal Guebbas', 18, '2015-11-06 06:15:13', 'admin', '2016-01-18 04:10:08', 'admin'),
(4, '2', '2015-11-06', '2000.00', 'Soci&eacute;t&eacute; Aramco', 'Abdekader Zlayji', 18, '2015-11-06 06:21:53', 'admin', '2016-01-18 04:09:20', 'admin'),
(5, '3', '2015-11-04', '3000.00', 'Soci&eacute;t&eacute; A', 'Jamal Guebbas', 18, '2015-11-06 06:22:22', 'admin', '2016-01-18 04:10:14', 'admin'),
(6, '11', '2015-11-03', '3000.00', 'Soci&eacute;t&eacute; X', 'Jamal Guebbas', 18, '2015-11-06 06:22:58', 'admin', '2016-01-18 04:11:09', 'admin'),
(7, '2', '2015-11-14', '10000.00', 'GrpAnhd', 'Rien de sp&eacute;cial', 18, '2015-11-14 02:46:14', 'admin', '2016-01-18 04:09:32', 'admin'),
(8, '4', '2015-11-24', '12000.00', 'Soci&eacute;t&eacute; CleanX', '', 18, '2015-11-24 02:24:06', 'admin', '2016-01-18 04:10:43', 'admin'),
(9, '4', '2015-11-24', '1000.00', 'Soci&eacute;t&eacute; NadafaNador', '', 18, '2015-11-24 02:25:53', 'admin', '2016-01-18 04:10:48', 'admin'),
(10, '5', '2015-11-24', '6000.00', 'Annahda', 'Prime des employ&eacute;s', 18, '2015-11-24 02:31:31', 'admin', '2016-01-18 04:09:50', 'admin'),
(11, '2', '2015-11-24', '40000.00', 'Annahda', 'Beton', 18, '2015-11-24 02:47:16', 'admin', '2016-01-18 04:09:38', 'admin'),
(13, '5', '2015-11-24', '2000.00', 'Soci&eacute;t&eacute; Annahda', 'Prime des assistantes', 18, '2015-11-24 03:01:27', 'admin', '2016-01-18 04:09:56', 'admin'),
(14, '6', '2015-11-24', '30000.00', 'Soci&eacute;t&eacute; Annahda', 'Levier', 18, '2015-11-24 03:24:50', 'admin', '2016-01-18 04:10:26', 'admin'),
(15, '9', '2015-11-24', '2000.00', 'Nadorcity', 'Publicit&eacute; en ligne ', 18, '2015-11-24 03:32:32', 'admin', '2016-01-18 04:12:29', 'admin'),
(19, '13', '2016-01-16', '2300.00', 'TUU', 'URU', 15, '2016-01-16 09:50:24', 'admin', '2016-01-18 04:07:35', 'admin'),
(21, '3', '2016-01-18', '500.00', 'Annahda', 'AAA', 18, '2016-01-18 04:38:30', 'admin', NULL, NULL),
(22, '3', '2016-03-31', '1000.00', 'ANNAHDA', 'AZERT', 15, '2016-03-31 01:00:32', 'admin', '2016-05-09 05:51:20', 'admin'),
(23, '11', '2016-03-09', '1500.00', 'Groupe Annahda Lil Iaamar', 'PAIEMENT DE TAXE VEHICULES AUTOMOBILES/ vignette PIK UP', 15, '2016-04-27 08:36:24', 'abdessamad', '2016-05-09 05:41:31', 'admin'),
(25, '14', '2016-05-09', '1.00', 'V', 'A', 15, '2016-05-09 05:45:08', 'admin', NULL, NULL),
(26, '14', '2016-05-09', '1.00', 'A', 'A', 15, '2016-05-09 05:46:06', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_charge_commun`
--

CREATE TABLE IF NOT EXISTS `t_charge_commun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) DEFAULT NULL,
  `dateOperation` date DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `societe` varchar(50) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `t_charge_commun`
--

INSERT INTO `t_charge_commun` (`id`, `type`, `dateOperation`, `montant`, `societe`, `designation`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1, '12', '2016-01-11', '1000.00', 'Groupe Annahda', 'AZERTYUIOP', '2016-01-11 11:21:19', 'admin', '2016-01-18 05:17:18', 'admin'),
(2, '13', '2016-01-11', '3500.00', 'Soci&eacute;t&eacute; Iaaza', 'QWERTYUOHK', '2016-01-11 11:25:50', 'admin', '2016-01-18 05:16:55', 'admin'),
(3, '13', '2016-01-11', '1350.00', 'Soci&eacute;t&eacute; Iaaza', 'AZEAOZEI', '2016-01-11 11:29:09', 'admin', '2016-01-18 05:17:01', 'admin'),
(4, '13', '2016-01-11', '3230.00', 'Groupe Annahda', 'AZERPZEOR', '2016-01-11 11:29:26', 'admin', '2016-01-18 05:17:06', 'admin'),
(5, '12', '2016-01-11', '1330.00', 'Groupe Annahda', 'PSDFOSDFL', '2016-01-11 11:29:54', 'admin', '2016-01-18 05:17:22', 'admin'),
(6, '14', '2016-03-14', '1200.00', 'test', 'test', '2016-03-14 09:45:16', 'admin', NULL, NULL),
(8, '12', '2016-01-20', '5.50', '', 'COMMISSION', '2016-04-27 08:40:20', 'abdessamad', NULL, NULL),
(9, '12', '2016-01-18', '5.50', 'Groupe Annahda', 'COMMISSION', '2016-04-27 08:42:24', 'abdessamad', NULL, NULL),
(11, '13', '2016-05-09', '200.00', 'zerzerz', 'zkejrhzjer', '2016-05-09 05:36:29', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_client`
--

CREATE TABLE IF NOT EXISTS `t_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `nomArabe` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `adresseArabe` varchar(255) DEFAULT NULL,
  `telephone1` varchar(45) DEFAULT NULL,
  `telephone2` varchar(45) DEFAULT NULL,
  `cin` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `code` text,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=318 ;

--
-- Contenu de la table `t_client`
--

INSERT INTO `t_client` (`id`, `nom`, `nomArabe`, `adresse`, `adresseArabe`, `telephone1`, `telephone2`, `cin`, `email`, `facebook`, `created`, `code`, `createdBy`, `updated`, `updatedBy`) VALUES
(300, 'El Mahi', NULL, 'Nador', NULL, '0613064330', '0536331031', 'S486672', 'honara56@hotmail.com ', NULL, '2015-10-20 00:00:00', '5626bf0982efd20151020222409', NULL, '2015-11-09 12:58:19', 'admin'),
(301, 'Rabie', NULL, 'Nador', NULL, '', '35uio', 'S1234556', 'Hjjkkl', NULL, '2015-10-20 00:00:00', '5626c347621ff20151020224215', NULL, NULL, NULL),
(302, 'A dlghani', NULL, 'Jjhhh', NULL, '', '0', 'Er455678', '', NULL, '2015-10-20 00:00:00', '5626c4b10966b20151020224817', NULL, NULL, NULL),
(303, 'E MAHI TIJANI', NULL, 'NADOR', NULL, '', '1452145', 'S678654', 'honara56@hotmail.com', NULL, '2015-10-23 00:00:00', '562a0912785f520151023101650', NULL, NULL, NULL),
(304, 'MOHAMED EL MAHI', NULL, 'NADOR', NULL, '', '', 'S8574Y', '', NULL, '2015-10-26 00:00:00', '562e5b5135e2420151026165649', NULL, NULL, NULL),
(305, 'semlali jamal', 'Ø§Ù„Ø³Ù…Ù„Ø§Ù„ÙŠ Ø¬Ù…Ø§Ù„', 'Rue Al Yasmin 30 Nador', 'Ø´Ø§Ø±Ø¹ Ø§Ù„ÙŠØ§Ø³Ù…ÙŠÙ† 30 Ø§Ù„Ù†Ø§Ø¸ÙˆØ±', '0672348904', '', 'F12542', 'jamal.sem@gmail.com', NULL, '2015-11-08 00:00:00', '563f92cc37cbc20151108192204', NULL, '2015-12-23 12:56:30', 'admin'),
(306, 'chalili najib', NULL, '', NULL, '', '', '', '', NULL, '2015-11-08 07:29:29', '563f94898528620151108192929', NULL, NULL, NULL),
(307, 'mohamed charif el maskini', NULL, '', NULL, '', '', '', '', NULL, '2015-11-08 07:34:49', '563f95c9aaf3020151108193449', 'admin', NULL, NULL),
(308, 'qsd', NULL, 'sdf', NULL, 'sdf', 'sdf', 'sdf', 'sdf', NULL, '2015-11-09 02:37:03', '5640a17fea3f020151109143703', 'admin', NULL, NULL),
(309, 'amin chemlal', 'Ø£Ù…ÙŠÙ† Ø´Ù…Ù„Ø§Ù„', '', '', '', '', 'S12312', '', NULL, '2015-11-11 11:52:39', '56431df7aa52420151111115239', 'admin', '2015-11-23 07:24:39', 'admin'),
(310, 'aassou mohamed', 'Ø¹Ø³Ùˆ Ù…Ø­Ù…Ø¯', 'rue laarassi', 'Ø´Ø§Ø±Ø¹ Ù„Ø¹Ø±Ø§ØµÙŠ Ø§Ù„Ù†Ø§Ø¶ÙˆØ±', '', '', 's10021', '', NULL, '2015-11-12 04:54:13', '5644b62502a7b20151112165413', 'admin', '2015-11-23 11:58:17', 'admin'),
(311, 'said el moumni', 'Ø³Ø¹ÙŠØ¯ Ø§Ù„Ù…ÙˆÙ…Ù†ÙŠ', 'Cit&eacute; Al Qods N&deg; 123', 'Ø­ÙŠ Ø§Ù„Ù‚Ø¯Ø³ Ø±Ù‚Ù… 123', '', '', 's10245', '', NULL, '2015-11-12 05:02:59', '5644b8332711e20151112170259', 'admin', '2016-01-08 09:58:57', 'admin'),
(312, 'mohamed el khattabi', 'Ù…Ø­Ù…Ø¯ Ø§Ù„Ø®Ø·Ø§Ø¨ÙŠ', 'quartier assalam nador', 'Ø­ÙŠ Ø§Ù„Ø³Ù„Ø§Ù… Ø§Ù„Ù†Ø§Ø¶ÙˆØ±', '0645667788', '0536609080', 'S123430', 'mido122@gmail.com', NULL, '2015-11-16 03:56:53', '5649eeb574fc720151116155653', 'admin', '2015-11-22 08:39:58', 'admin'),
(313, 'tarik tribak', 'Ø·Ø§Ø±Ù‚ Ø·Ø±ÙŠØ¨Ù‚', 'rue farahat hachad taourirt', 'Ø´Ø§Ø±Ø¹ ÙØ±Ø­Ø§Øª Ø­Ø´Ø§Ø¯ ØªØ§ÙˆØ±ÙŠØ±Øª', '0672337782', '', 'FO23499', 'tarik.tribak@gmail.com', NULL, '2015-12-08 12:08:31', '5666ba2f769cf20151208120831', 'admin', NULL, NULL),
(314, 'semlali rachid', 'Ø§Ù„Ø³Ù…Ù„Ø§Ù„ÙŠ Ø±Ø´ÙŠØ¯', 'Rue Annour 120 Nador', 'Ø´Ø§Ø±Ø¹ Ø§Ù„Ù†ÙˆØ± 120 Ø§Ù„Ù†Ø§Ø¸ÙˆØ±', '0536609033', '0536678899', 'S34090', 'semlali.rachid@gmail.com', NULL, '2015-12-23 12:46:56', '567a89b04314020151223124656', 'admin', NULL, NULL),
(315, 'souid ahmed ayoub', 'Ø³ÙˆÙŠØ¯ Ø£Ø­Ù…Ø¯ Ø£ÙŠÙˆØ¨', 'Rue Noujoum 12300 Nador', 'Ø´Ø§Ø±Ø¹ Ø§Ù„Ù†Ø¬ÙˆÙ… 12300 Ø§Ù„Ù†Ø§Ø¸ÙˆØ±', '0661738437', '', 'SD409399', 'a.souid@gmail.com', NULL, '2015-12-24 01:52:10', '567bea7a7311f20151224135210', 'admin', NULL, NULL),
(316, 'abdelouahab sekkat', 'Ø¹Ø¨Ø¯ Ø§Ù„ÙˆÙ‡Ø§Ø¨ Ø§Ù„Ø³Ù‚Ø§Ø·', 'Rue Prince Mohamed 123012 Nador', 'Ø´Ø§Ø±Ø¹ Ø§Ù„Ø£Ù…ÙŠØ± Ø³ÙŠØ¯ÙŠ Ù…Ø­Ù…Ø¯ 123012', '0615068855', '', 'O93892', 'a.sekkat@gmail.com', NULL, '2016-01-11 02:35:32', '5693afa46593d20160111143532', 'admin', NULL, NULL),
(317, 'afelouat othman', 'Ø¹Ø«Ù…Ø§Ù† Ø£ÙÙ„ÙˆØ§Ø·', 'Bni Enssar', 'Ø¨Ù†ÙŠ Ø£Ù†ØµØ§Ø±', '0671998301', '', 'S551090', 'othman.afelouat@gmail.com', NULL, '2016-05-26 06:56:11', '57472aabc0e3520160526185611', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_commande`
--

CREATE TABLE IF NOT EXISTS `t_commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idFournisseur` int(12) DEFAULT NULL,
  `idProjet` int(12) DEFAULT NULL,
  `dateCommande` date DEFAULT NULL,
  `numeroCommande` varchar(50) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `status` int(12) DEFAULT NULL,
  `codeLivraison` varchar(255) DEFAULT NULL,
  `companyID` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `t_commande`
--

INSERT INTO `t_commande` (`id`, `idFournisseur`, `idProjet`, `dateCommande`, `numeroCommande`, `designation`, `status`, `codeLivraison`, `companyID`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(7, 29, 0, '2016-03-17', 'cmd123', 'commande de said kamli &agrave; verifier avant de soumettre le ch&egrave;que', 0, '56eac970a51b220160317161248', 4, '2016-03-17 04:12:48', 'admin', NULL, NULL),
(8, 28, 15, '2016-08-03', 'CMD450029', 'CPJ500', 0, '57a9fa1fb56a120160809174327', 4, '2016-08-09 05:43:27', 'admin', '2016-08-23 03:58:28', 'admin'),
(10, 29, 0, '2016-07-05', 'CMD345', 'Rien de Sp&eacute;cial', 0, '57aa0f66ecfb620160809191414', 4, '2016-08-09 07:14:14', 'admin', NULL, NULL),
(11, 30, 19, '2016-10-26', '120', 'BTN', 0, '5810c9cf4d84d20161026172047', 1, '2016-10-26 05:20:47', 'admin', '2016-10-26 05:26:42', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `t_commandedetail`
--

CREATE TABLE IF NOT EXISTS `t_commandedetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(100) DEFAULT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  `quantite` decimal(12,2) DEFAULT NULL,
  `idCommande` int(12) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `t_commandedetail`
--

INSERT INTO `t_commandedetail` (`id`, `reference`, `libelle`, `quantite`, `idCommande`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(8, 'cpj100', 'cpj', '100.00', 7, '2016-03-17 04:13:04', 'admin', NULL, NULL),
(9, 'cpj', 'armo', '10.00', 8, '2016-08-09 07:03:58', 'admin', '2016-08-23 03:58:41', 'admin'),
(11, 'bhc', 'bhc100', '30.00', 10, '2016-08-09 07:14:26', 'admin', NULL, NULL),
(12, 'BTN', 'btn100', '123.00', 11, '2016-10-26 05:23:10', 'admin', '2016-10-26 05:23:29', 'admin'),
(13, 'test', 'test1', '123.00', 11, '2016-10-26 05:23:37', 'admin', '2016-10-26 05:27:54', 'admin'),
(14, 'CPG', 'CPG300', '30.00', 11, '2016-10-26 05:27:24', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_company`
--

CREATE TABLE IF NOT EXISTS `t_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `nomArabe` varchar(50) DEFAULT NULL,
  `adresseArabe` varchar(255) DEFAULT NULL,
  `directeur` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `t_company`
--

INSERT INTO `t_company` (`id`, `nom`, `adresse`, `nomArabe`, `adresseArabe`, `directeur`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1, 'Groupe Annahda S.A.R.L', 'Rue Ouled Brahim Mezzanine Nador', 'Ù…Ø¬Ù…ÙˆØ¹Ø© Ø§Ù„Ù†Ù‡Ø¶Ø© Ù„Ù„Ø§Ø¹Ù…Ø§Ø±', 'Ø´Ø§Ø±Ø¹ Ø£ÙˆÙ„Ø§Ø¯ Ø§Ø¨Ø±Ø§Ù‡ÙŠÙ… Ø§Ù„Ù†Ø§Ø¸ÙˆØ±', 'Rabie El Mahie', '2015-12-21 06:50:44', 'admin', '2015-12-21 06:52:19', 'admin'),
(2, 'Nodom S.A.R.L', 'Rue Najah N&deg; 123 Nador', 'Ø´Ø±ÙƒØ© Ù†Ø¸Ù… Ø´.Ù….Ù…', 'Ø´Ø§Ø±Ø¹ Ø§Ù„Ù†Ø¬Ø§Ø­ Ø±Ù‚Ù… 123 Ø§Ù„Ù†Ø§Ø¸ÙˆØ±', 'AASSOU Abdelilah', '2016-08-08 05:14:34', 'admin', NULL, NULL),
(3, 'TopEntreprise S.A.R.L', 'Rue Diamant Vert N&deg; 3002 Nador', 'Ø·ÙˆØ¨ Ø£Ù†ØªØ±Ø¨Ø±ÙŠØ²', 'Ø´Ø§Ø±Ø¹ Ø§Ù„Ø¬ÙˆÙ‡Ø±Ø© Ø§Ù„Ø®Ø¶Ø±Ø§Ø¡ Ø±Ù‚Ù… 3002 Ø§Ù„Ù†Ø§Ø¸ÙˆØ±', 'Mohamed ESKALLI', '2016-08-08 05:47:13', 'admin', NULL, NULL),
(4, 'Annour S.A.R.L', 'Rue Marrakech N&deg;31 Nador', 'Ø´Ø±ÙƒØ© Ø§Ù„Ù†ÙˆØ±', 'Ø´Ø§Ø±Ø¹ Ù…Ø±Ø§ÙƒØ´ Ø±Ù‚Ù… 31 Ø§Ù„Ù†Ø§Ø¸ÙˆØ±', 'Mohamed Souissi', '2016-08-08 06:41:56', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_comptebancaire`
--

CREATE TABLE IF NOT EXISTS `t_comptebancaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) DEFAULT NULL,
  `denomination` varchar(255) DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `t_comptebancaire`
--

INSERT INTO `t_comptebancaire` (`id`, `numero`, `denomination`, `dateCreation`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1, '1110023', NULL, '2015-11-05', '2015-11-05 04:53:18', 'admin', NULL, NULL),
(2, '909888', NULL, '2015-11-05', '2015-11-05 05:00:06', 'admin', NULL, NULL),
(3, '129000', 'test test', '2015-11-05', '2015-11-05 05:00:56', 'admin', '2015-11-14 02:32:04', 'admin'),
(4, '800009', 'p1nh', '2015-11-05', '2015-11-05 05:01:22', 'admin', '2015-11-13 11:13:45', 'admin'),
(5, '10021542986', 'pr anhd2', '2015-11-13', '2015-11-13 11:04:37', 'admin', '2015-11-13 11:12:48', 'admin'),
(6, '255498600001', 'Groupe Annahda Compte 1', '2015-11-13', '2015-11-13 11:06:07', 'admin', '2015-12-04 05:54:12', 'mouaad'),
(7, '89055519803', 'Annahda 1', '2015-11-26', '2015-11-26 01:50:04', 'admin', '2015-12-16 02:35:35', 'admin'),
(8, '90239', 'Iaaza', '2015-12-16', '2015-12-16 02:34:56', 'admin', NULL, NULL),
(9, '123013', 'Iaaza 2', '2015-12-16', '2015-12-16 02:37:01', 'admin', '2015-12-17 12:59:33', 'admin'),
(10, '1230231999990000XD', 'BP123123', '2015-12-17', '2015-12-17 01:02:52', 'admin', '2016-01-11 10:17:06', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `t_conge_employe_projet`
--

CREATE TABLE IF NOT EXISTS `t_conge_employe_projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `idEmploye` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `t_conge_employe_projet`
--

INSERT INTO `t_conge_employe_projet` (`id`, `dateDebut`, `dateFin`, `idEmploye`) VALUES
(1, '2015-10-20', '2015-11-20', 2);

-- --------------------------------------------------------

--
-- Structure de la table `t_conge_employe_societe`
--

CREATE TABLE IF NOT EXISTS `t_conge_employe_societe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `idEmploye` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_contrat`
--

CREATE TABLE IF NOT EXISTS `t_contrat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `prixVente` decimal(12,2) DEFAULT NULL,
  `avance` decimal(12,2) DEFAULT NULL,
  `prixVenteArabe` varchar(255) DEFAULT NULL,
  `avanceArabe` varchar(255) DEFAULT NULL,
  `modePaiement` varchar(255) DEFAULT NULL,
  `dureePaiement` int(11) DEFAULT NULL,
  `nombreMois` int(11) DEFAULT NULL,
  `echeance` decimal(12,2) DEFAULT NULL,
  `note` text,
  `imageNote` text,
  `idClient` int(11) DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  `idBien` int(11) DEFAULT NULL,
  `typeBien` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `revendre` int(2) DEFAULT NULL,
  `numeroCheque` varchar(255) DEFAULT NULL,
  `societeArabe` int(11) DEFAULT NULL,
  `etatBienArabe` varchar(100) DEFAULT NULL,
  `facadeArabe` varchar(50) DEFAULT NULL,
  `articlesArabes` text,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=452 ;

--
-- Contenu de la table `t_contrat`
--

INSERT INTO `t_contrat` (`id`, `reference`, `numero`, `dateCreation`, `prixVente`, `avance`, `prixVenteArabe`, `avanceArabe`, `modePaiement`, `dureePaiement`, `nombreMois`, `echeance`, `note`, `imageNote`, `idClient`, `idProjet`, `idBien`, `typeBien`, `code`, `status`, `revendre`, `numeroCheque`, `societeArabe`, `etatBienArabe`, `facadeArabe`, `articlesArabes`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(420, NULL, '12100', '2015-11-12', '2900000.00', '50000.00', NULL, NULL, 'Especes', 24, 3, '356250.00', '', NULL, 311, 15, 30, 'localCommercial', '5644b914837ae20151112170644', 'actif', 0, '10001', 1, NULL, NULL, NULL, '2015-11-12 05:06:44', 'admin', NULL, NULL),
(421, NULL, '12001', '2015-11-16', '8500000.00', '500000.00', NULL, NULL, 'Especes', 12, 2, '1333333.00', 'Changer les portes', NULL, 312, 18, 455, 'appartement', '5649ef319bcb820151116155857', 'actif', 0, '20012', 1, NULL, NULL, NULL, '2015-11-16 03:58:57', 'admin', NULL, NULL),
(419, NULL, '100521', '2015-11-12', '500000.00', '20000.00', NULL, NULL, 'Especes', 24, 4, '80000.00', 'Changer la peinture', NULL, 310, 15, 449, 'appartement', '5644b7fb67c6020151112170203', 'actif', 0, '10121', 1, NULL, NULL, NULL, '2015-11-12 05:02:03', 'admin', NULL, NULL),
(418, NULL, '123', '2015-11-11', '1000000.00', '10000.00', NULL, NULL, 'Especes', 24, 4, '165000.00', 'rien de plus', NULL, 309, 15, 29, 'localCommercial', '56431e1114d8120151111115305', 'actif', 0, '1231234', 1, NULL, NULL, NULL, '2015-11-11 11:53:05', 'admin', NULL, NULL),
(417, NULL, 'cc1020', '2015-11-09', '750000.00', '100000.00', NULL, NULL, 'Especes', 24, 4, '108333.00', 'changer la couleur de peinture en jaune', NULL, 300, 15, 453, 'appartement', '563fd716d786820151109001326', 'actif', 0, 'a90125', 1, NULL, NULL, NULL, '2015-11-09 12:13:26', 'admin', '2015-11-09 03:06:31', 'admin'),
(422, NULL, '10001', '2015-11-26', '3900000.00', '500000.00', NULL, NULL, 'Especes', 12, 6, '1700000.00', '', NULL, 312, 15, 31, 'localCommercial', '5656fe404486a20151126134240', 'actif', 0, '', 1, NULL, NULL, NULL, '2015-11-26 01:42:40', 'admin', NULL, NULL),
(423, NULL, '1230', '2015-11-26', '5700000.00', '300000.00', NULL, NULL, 'Especes', 24, 4, '900000.00', '', NULL, 312, 15, 448, 'appartement', '56573f61666f320151126182033', 'actif', 0, '120', 1, NULL, NULL, NULL, '2015-11-26 06:20:33', 'admin', NULL, NULL),
(424, NULL, '1111111', '2015-11-27', '1200000.00', '100000.00', NULL, NULL, 'Especes', 24, 3, '137500.00', 'Le reste &agrave; voir', NULL, 311, 15, 454, 'appartement', '5658990c30acf20151127185524', 'annulle', 1, '12020', 1, NULL, NULL, NULL, '2015-11-27 06:55:24', 'admin', NULL, NULL),
(425, NULL, '123090', '2015-11-27', '1200000.00', '100000.00', NULL, NULL, 'Especes', 24, 3, '137500.00', '', NULL, 309, 15, 454, 'appartement', '56589ae281cd520151127190314', 'annulle', 0, '123213999', 1, NULL, NULL, NULL, '2015-11-27 07:03:14', 'admin', NULL, NULL),
(426, NULL, '12090', '2015-11-27', '1200000.00', '100000.00', NULL, NULL, 'Especes', 24, 3, '137500.00', 'Rien de plus', NULL, 309, 15, 454, 'appartement', '56589c5bee6dc20151127190931', 'annulle', 0, '120192', 1, NULL, NULL, NULL, '2015-11-27 07:09:31', 'admin', NULL, NULL),
(427, NULL, '123012', '2015-11-27', '1200000.00', '100000.00', NULL, NULL, 'Especes', 24, 3, '137500.00', 'Rien de sp&eacute;cial', NULL, 312, 15, 454, 'appartement', '56589d1d6cc7e20151127191245', 'annulle', 0, '12301293', 1, NULL, NULL, NULL, '2015-11-27 07:12:45', 'admin', NULL, NULL),
(428, NULL, '3453499', '2015-11-27', '1200000.00', '100000.00', NULL, NULL, 'Especes', 24, 3, '137500.00', 'Rien de sp&eacute;cial', NULL, 312, 15, 454, 'appartement', '5658a025a1d2520151127192541', 'annulle', 0, '23912', 1, NULL, NULL, NULL, '2015-11-27 07:25:41', 'admin', NULL, NULL),
(429, NULL, '123000', '2015-11-28', '1200000.00', '200000.00', NULL, NULL, 'Especes', 24, 3, '125000.00', 'Rien de sp&eacute;cial', NULL, 312, 15, 454, 'appartement', '5659ac285e1ea20151128142912', 'actif', 0, '12301209', 1, NULL, NULL, NULL, '2015-11-28 02:29:12', 'admin', NULL, NULL),
(431, NULL, '120900', '2015-12-08', '8000000.00', '100000.00', NULL, NULL, 'Especes', 24, 4, '1316667.00', 'Ouvrir les fen&ecirc;tres int&eacute;rieures', NULL, 313, 18, 456, 'appartement', '5666baaf509a820151208121039', 'actif', 0, '123399', 1, NULL, NULL, NULL, '2015-12-08 12:10:39', 'admin', NULL, NULL),
(430, NULL, '12309901', '2015-11-28', '1200000.00', '200000.00', NULL, NULL, 'Especes', 24, 3, '125000.00', 'Rien de sp&eacute;cial', NULL, 312, 15, 454, 'appartement', '5659ace3f26a220151128143219', 'annulle', 0, '2390091230', 1, NULL, NULL, NULL, '2015-11-28 02:32:19', 'admin', NULL, NULL),
(432, NULL, '12', '2015-12-19', '500000.00', '100000.00', NULL, NULL, 'Especes', 24, 3, '50000.00', 'test', NULL, 312, 15, 458, 'appartement', '56757cc1290d420151219165025', 'actif', 0, '12', 1, NULL, NULL, NULL, '2015-12-19 04:50:25', 'admin', NULL, NULL),
(433, NULL, '123333', '2015-12-22', '550000.00', '10000.00', NULL, NULL, 'Especes', 24, 8, '180000.00', '', NULL, 312, 15, 458, 'appartement', '567966cd186c120151222160549', 'actif', 0, '12333', 1, NULL, NULL, NULL, '2015-12-22 04:05:49', 'admin', '2015-12-23 10:31:38', 'admin'),
(434, NULL, '1', '2015-12-22', '550000.00', '100000.00', NULL, NULL, 'Especes', 24, 4, '75000.00', 'Peinture blanche', NULL, 312, 15, 458, 'appartement', '56797cd782e8020151222173951', 'actif', 0, '13042934', 1, NULL, NULL, NULL, '2015-12-22 05:39:51', 'admin', NULL, NULL),
(435, NULL, '1', '2015-12-22', '550000.00', '100000.00', NULL, NULL, 'Especes', 24, 4, '75000.00', 'Peinture blanche', NULL, 312, 15, 458, 'appartement', '56797d3a94e4320151222174130', 'actif', 0, '13042934', 1, NULL, NULL, NULL, '2015-12-22 05:41:30', 'admin', NULL, NULL),
(436, NULL, '100001', '2015-12-23', '680000.00', '200000.00', NULL, NULL, 'Especes', 48, 6, '60000.00', 'Ajouter une fen&ecirc;tre au balcon', NULL, 314, 16, 450, 'appartement', '567a8a2f9b86d20151223124903', 'actif', 0, '30290', 1, NULL, NULL, NULL, '2015-12-23 12:49:03', 'admin', NULL, NULL),
(437, NULL, '100020', '2015-12-24', '130000.00', '30000.00', NULL, NULL, 'Especes', 2, 2, '20000.00', 'Ajouter un grillage deri&egrave;re la porte', NULL, 315, 15, 32, 'localCommercial', '567bebaa16a1520151224135714', 'annulle', 1, '1', 1, NULL, NULL, NULL, '2015-12-24 01:57:14', 'admin', NULL, NULL),
(438, NULL, '9021', '2015-12-24', '130000.00', '30000.00', 'Ù…Ø¦Ø© Ùˆ Ø«Ù„Ø§Ø«ÙˆÙ† Ø£Ù„Ù', 'Ø«Ù„Ø§Ø«ÙˆÙ† Ø£Ù„Ù', 'Especes', 12, 4, '33333.00', 'Changer grillage', NULL, 315, 15, 32, 'localCommercial', '567bef0968ff920151224141137', 'actif', 0, '1930', 1, NULL, NULL, NULL, '2015-12-24 02:11:37', 'admin', '2016-01-06 12:59:50', 'admin'),
(439, NULL, '9021', '2015-12-24', '130000.00', '30000.00', NULL, NULL, 'Especes', 12, 5, '41667.00', 'Changer grillage', NULL, 315, 15, 32, 'localCommercial', '567bef7151ca820151224141321', 'actif', 0, '1930', 1, NULL, NULL, NULL, '2015-12-24 02:13:21', 'admin', '2015-12-24 03:03:57', 'admin'),
(440, 'C20160111-024726', '123021390', '2016-01-11', '1000000.00', '500000.00', 'Ù…Ù„ÙŠÙˆÙ†', 'Ø®Ù…Ø³ Ù…Ø¦Ø© Ø£Ù„Ù', 'Especes', 12, 3, '125000.00', 'Rien', NULL, 316, 15, 34, 'localCommercial', '5693b26e8314b20160111144726', 'actif', 0, '1231293', 1, 'GrosOeuvre', '123', NULL, '2016-01-11 02:47:26', 'admin', '2016-03-07 01:12:33', 'admin'),
(441, 'C20160126-080735', '123', '2016-01-26', '1000000.00', '50000.00', 'Ù…Ù„ÙŠÙˆÙ†', 'Ø®Ù…Ø³ÙˆÙ† Ø§Ù„Ù', 'Especes', 24, 4, '158333.00', 'Pere de Mina', '/pieces/pieces_notes_clients/5773eb4828300Tulips.jpg', 314, 15, 459, 'appartement', '56a7c3f7084d120160126200735', 'actif', 0, '12342349 - 23409234923''', 1, NULL, NULL, NULL, '2016-01-26 08:07:35', 'admin', NULL, NULL),
(442, 'C20160222-051207', '123', '2016-02-22', '1900000.00', '1900000.00', 'Ù…Ù„ÙŠÙˆÙ† Ùˆ ØªØ³Ø¹ Ù…Ø¦Ø© Ø£Ù„Ù', 'Ù…Ù„ÙŠÙˆÙ† Ùˆ ØªØ³Ø¹ Ù…Ø¦Ø© Ø£Ù„Ù', 'Especes', 1, 1, '1000000.00', '1', NULL, 315, 15, 33, 'localCommercial', '56cb33577deb720160222171207', 'actif', 1, '1', 1, 'Finition', '123', '', '2016-02-22 05:12:07', 'admin', '2016-07-22 01:18:59', 'admin'),
(443, 'C20160225-060943', '123', '2016-02-25', '730000.00', '100000.00', 'Ø³Ø¨Ø¹ Ù…Ø¦Ø© Ùˆ Ø«Ù„Ø§Ø«ÙˆÙ† Ø£Ù„Ù', 'Ù…Ø¦Ø© Ø£Ù„Ù', 'Especes', 12, 3, '157500.00', 'Rien de sp', NULL, 309, 15, 460, 'appartement', '56cf35577f45820160225180943', 'annulle', 0, '123', 1, NULL, NULL, NULL, '2016-02-25 06:09:43', 'admin', NULL, NULL),
(444, 'C20160226-011551', '1092929', '2016-02-26', '720000.00', '100000.00', 'Ø³Ø¨Ø¹ Ù…Ø¦Ø© Ùˆ Ø«Ù„Ø§Ø«ÙˆÙ† Ø£Ù„Ù', 'Ù…Ø¦Ø© Ø£Ù„Ù', 'Especes', 12, 4, '206667.00', 'Rien de sp', '/pieces/pieces_notes_clients/5773ead8635faKoala.jpg', 310, 15, 460, 'appartement', '56d041f7c07ce20160226131551', 'actif', 1, '0931203120', 1, 'GrosOeuvre', '100', NULL, '2016-02-26 01:15:51', 'admin', '2016-03-30 04:55:08', 'admin'),
(445, 'C20160526-070753', '120120', '2016-05-26', '880000.00', '120000.00', 'Ø«Ù…Ø§Ù† Ù…Ø¦Ø© Ùˆ Ø«Ù…Ø§Ù†ÙˆÙ† Ø£Ù„Ù', 'Ù…Ø¦Ø© Ùˆ Ø¹Ø´Ø±ÙˆÙ† Ø£Ù„Ù', 'Especes', 36, 4, '84444.00', 'Changer la couleur des rideaux', '/pieces/pieces_notes_clients/57473564a889cJellyfish.jpg', 317, 15, 461, 'appartement', '57472d69468ab20160526190753', 'annulle', 0, '01910', 1, 'GrosOeuvre', 'Ø´Ø§Ø±Ø¹ 80 Ù…ØªØ± ', NULL, '2016-05-26 07:07:53', 'admin', NULL, NULL),
(446, 'C20160526-074625', '12301230', '2016-05-26', '880000.00', '120000.00', 'Ø«Ù…Ø§Ù† Ù…Ø¦Ø© Ùˆ Ø«Ù…Ø§Ù†ÙˆÙ† Ø£Ù„Ù', 'Ù…Ø¦Ø© Ùˆ Ø¹Ø´Ø±ÙˆÙ† Ø£Ù„Ù', 'Especes', 24, 2, '63333.00', 'Ajouter une porte de garde', '', 317, 15, 461, 'appartement', '57473671351ef20160526194625', 'annulle', 0, '1230123', 1, 'GrosOeuvre', 'Ø´Ø§Ø±Ø¹ 80 Ù…ØªØ±', NULL, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(447, 'C20160526-075339', '90202', '2016-05-26', '880000.00', '120000.00', 'Ø«Ù…Ø§Ù† Ù…Ø¦Ø© Ùˆ Ø«Ù…Ø§Ù†ÙˆÙ† Ø£Ù„Ù', 'Ù…Ø¦Ø© Ùˆ Ø¹Ø´Ø±ÙˆÙ† Ø£Ù„Ù', 'Especes', 36, 3, '63333.00', 'Changer les couleurs des chambres', '/pieces/pieces_notes_clients/5773e938e85e2Chrysanthemum.jpg', 317, 15, 461, 'appartement', '5747382366de120160526195339', 'actif', 0, '120120', 1, 'GrosOeuvre', 'Ø´Ø§Ø±Ø¹ 80 Ù…ØªØ±', NULL, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(448, 'C20160713-041128', '191200', '2016-07-13', '790000.00', '100000.00', 'Ø³Ø¨Ø¹ Ù…Ø¦Ø© Ùˆ ØªØ³Ø¹ÙˆÙ† Ø£Ù„Ù', 'Ù…Ø¦Ø© Ø£Ù„Ù', 'Especes', 24, 3, '86250.00', '', '', 312, 16, 462, 'appartement', '57864c10ced6220160713161128', 'hidden', 0, '100919', 1, 'Ø§Ù„Ø£Ø´ØºØ§Ù„ Ø§Ù„Ø£Ø³Ø§Ø³ÙŠØ© Ù„Ù„Ø¨Ù†Ø§Ø¡', 'Ø§Ù„Ø´Ù‚ Ø§Ù„Ø§ÙˆÙ„ Ùˆ Ø§Ù„Ø´Ù‚ Ø§Ù„Ø«Ø§Ù†ÙŠ Ùˆ Ø§', 'Ø§Ù„Ø£Ø´ØºØ§Ù„ Ø§Ù„Ø£Ø³Ø§Ø³ÙŠØ© Ù„Ù„Ø¨Ù†Ø§Ø¡', '2016-07-13 04:11:28', 'admin', NULL, NULL),
(449, 'C20160713-043534', '111111111', '2016-07-13', '790000.00', '100000.00', 'Ø³Ø¨Ø¹ Ù…Ø¦Ø© Ùˆ ØªØ³Ø¹ÙˆÙ† Ø£Ù„Ù', 'Ù…Ø¦Ø© Ø£Ù„Ù', 'Especes', 24, 4, '115000.00', '', '', 312, 16, 462, 'appartement', '578651b68546320160713163534', 'annulle', 0, '32323', 1, 'GrosOeuvre', '120', 'Ø§Ù„Ø¨Ù†Ø¯ Ø§Ù„Ø§ÙˆÙ„ -Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…Ù…-\r\nØ§Ù„Ø¨Ù†Ø¯ Ø§Ù„Ø«Ø§Ù†ÙŠ -Ù…Ù…Ù…Ù…ÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒÙƒ-\r\nØ§Ù„Ø¨Ù†Ø¯ Ø§Ù„Ø«Ø§Ù„Ø« Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤Ø¤-', '2016-07-13 04:35:34', 'admin', '2016-07-13 04:55:07', 'admin'),
(450, 'C20160713-050517', '34343434', '2016-07-13', '790000.00', '100000.00', 'Ø³Ø¨Ø¹ Ù…Ø¦Ø© Ùˆ ØªØ³Ø¹ÙˆÙ† Ø£Ù„Ù', 'Ù…Ø¦Ø© Ø£Ù„Ù', 'Especes', 24, 4, '115000.00', '', '/pieces/pieces_notes_clients/57865bce37185Koala.jpg', 312, 16, 462, 'appartement', '578658ad95df420160713170517', 'actif', 0, '456040', 1, 'Ø§Ù„Ø£Ø´ØºØ§Ù„ Ø§Ù„Ø£Ø³Ø§Ø³ÙŠØ© Ù„Ù„Ø¨Ù†Ø§Ø¡', '120', '&lt;ul&gt;&lt;li&gt;Ø§Ù„Ø¨Ù†Ø¯ Ø§Ù„Ø§ÙˆÙ„ Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†Ù†&lt;/li&gt;&lt;li&gt;Ø§Ù„Ø¨Ù†Ø¯ Ø§Ù„Ø«Ø§Ù†ÙŠ Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­Ø­&lt;/li&gt;&lt;li&gt;Ø§Ù„Ø¨Ù†Ø¯ Ø§Ù„Ø«Ø§Ù„Ø« ÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆÙˆ&lt;/li&gt;&lt;/ul&gt;', '2016-07-13 05:05:17', 'admin', NULL, NULL),
(451, 'C20160725-011636', '11111', '2016-07-25', '660000.00', '200000.00', 'Ø³Øª Ù…Ø¦Ø© Ùˆ Ø³ØªÙˆÙ† Ø£Ù„Ù', 'Ù…Ø¦ØªØ§ Ø£Ù„Ù', 'Especes', 24, 5, '95833.00', '', '', 305, 15, 463, 'appartement', '5795f514c905920160725131636', 'actif', 0, '12020', 1, 'Ø§Ù„Ø£Ø´ØºØ§Ù„ Ø§Ù„Ø£Ø³Ø§Ø³ÙŠØ© Ù„Ù„Ø¨Ù†Ø§Ø¡', '25-80', '', '2016-07-25 01:16:36', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_contratcaslibre`
--

CREATE TABLE IF NOT EXISTS `t_contratcaslibre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `observation` text,
  `status` int(2) DEFAULT NULL,
  `codeContrat` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `t_contratcaslibre`
--

INSERT INTO `t_contratcaslibre` (`id`, `date`, `montant`, `observation`, `status`, `codeContrat`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1, '2015-11-26', '100000.00', '', 0, '56573f61666f320151126182033', NULL, NULL, NULL, NULL),
(2, '2016-01-26', '100000.00', '', 0, '56573f61666f320151126182033', NULL, NULL, NULL, NULL),
(3, '2016-02-26', '200000.00', '', 0, '56573f61666f320151126182033', NULL, NULL, NULL, NULL),
(4, '2016-03-26', '200000.00', '', 0, '56573f61666f320151126182033', NULL, NULL, NULL, NULL),
(5, '2016-04-26', '200000.00', '', 0, '56573f61666f320151126182033', NULL, NULL, NULL, NULL),
(6, '2016-05-26', '100000.00', '', 0, '56573f61666f320151126182033', NULL, NULL, NULL, NULL),
(7, '2016-01-01', '30000.00', 'Avance', 0, '567bebaa16a1520151224135714', '2015-12-24 01:57:14', 'admin', NULL, NULL),
(8, '2016-03-01', '50000.00', 'Premir&eacute;re R&eacute;glement', 0, '567bebaa16a1520151224135714', '2015-12-24 01:57:14', 'admin', NULL, NULL),
(9, '2016-05-01', '50000.00', 'Deuxi&egrave;me R&eacute;glement', 0, '567bebaa16a1520151224135714', '2015-12-24 01:57:14', 'admin', NULL, NULL),
(10, '2015-12-24', '0.00', '', 0, '567bebaa16a1520151224135714', '2015-12-24 01:57:14', 'admin', NULL, NULL),
(11, '2015-12-24', '0.00', '', 0, '567bebaa16a1520151224135714', '2015-12-24 01:57:14', 'admin', NULL, NULL),
(12, '2015-12-24', '0.00', '', 0, '567bebaa16a1520151224135714', '2015-12-24 01:57:14', 'admin', NULL, NULL),
(13, '2016-01-01', '30000.00', 'Avance', 0, '567bef0968ff920151224141137', '2015-12-24 02:11:37', 'admin', NULL, NULL),
(14, '2016-03-01', '30000.00', 'Premi&egrave;re R&eacute;glement', 0, '567bef0968ff920151224141137', '2015-12-24 02:11:37', 'admin', NULL, NULL),
(15, '2016-04-08', '30000.00', 'Deuxi&egrave;me R&eacute;glement', 0, '567bef0968ff920151224141137', '2015-12-24 02:11:37', 'admin', NULL, NULL),
(16, '2016-06-10', '40000.00', 'Troisi&egrave;me R&eacute;glement', 0, '567bef0968ff920151224141137', '2015-12-24 02:11:37', 'admin', NULL, NULL),
(17, NULL, NULL, NULL, 0, '567bef0968ff920151224141137', '2015-12-24 02:11:37', 'admin', NULL, NULL),
(18, NULL, NULL, NULL, 0, '567bef0968ff920151224141137', '2015-12-24 02:11:37', 'admin', NULL, NULL),
(19, '2016-01-01', '30000.00', 'Avance', 0, '567bef7151ca820151224141321', '2015-12-24 02:13:21', 'admin', NULL, NULL),
(20, '2016-03-01', '30000.00', 'Premi&egrave;re R&eacute;glement', 0, '567bef7151ca820151224141321', '2015-12-24 02:13:21', 'admin', NULL, NULL),
(21, '2016-04-08', '30000.00', 'Deuxi&egrave;me R&eacute;glement', 0, '567bef7151ca820151224141321', '2015-12-24 02:13:21', 'admin', NULL, NULL),
(22, '2016-06-10', '40000.00', 'Troisi&egrave;me R&eacute;glement', 0, '567bef7151ca820151224141321', '2015-12-24 02:13:21', 'admin', NULL, NULL),
(23, '2016-03-03', '500000.00', '1er r&eacute;glement', 0, '5693b26e8314b20160111144726', NULL, NULL, NULL, NULL),
(24, '2016-09-30', '500000.00', '2 eme et derniere reglement', 0, '5693b26e8314b20160111144726', NULL, NULL, NULL, NULL),
(25, '2016-09-10', '180000.00', '', 0, '567966cd186c120151222160549', NULL, NULL, NULL, NULL),
(26, '2016-11-09', '180000.00', '', 0, '567966cd186c120151222160549', NULL, NULL, NULL, NULL),
(27, '2016-12-01', '180000.00', '', 0, '567966cd186c120151222160549', NULL, NULL, NULL, NULL),
(28, '2017-03-09', '40000.00', 'Rien  de rien', 0, '5693b26e8314b20160111144726', '2016-01-26 02:42:53', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_contratdetails`
--

CREATE TABLE IF NOT EXISTS `t_contratdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateOperation` date DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `numeroCheque` varchar(100) DEFAULT NULL,
  `idContratEmploye` int(12) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `t_contratdetails`
--

INSERT INTO `t_contratdetails` (`id`, `dateOperation`, `montant`, `numeroCheque`, `idContratEmploye`, `created`, `createdBy`) VALUES
(1, '2015-12-10', '2000.00', '12013', 1, NULL, NULL),
(2, '2015-12-11', '10000.00', '1', 3, NULL, NULL),
(3, '2015-12-11', '5000.00', '2', 3, NULL, NULL),
(4, '2016-06-18', '2000.00', '7890', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_contratemploye`
--

CREATE TABLE IF NOT EXISTS `t_contratemploye` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateContrat` date DEFAULT NULL,
  `dateFinContrat` date DEFAULT NULL,
  `prixUnitaire` decimal(10,2) DEFAULT NULL,
  `unite` varchar(30) DEFAULT NULL,
  `nomUnite` varchar(50) DEFAULT NULL,
  `nomUniteArabe` varchar(100) DEFAULT NULL,
  `traveaux` varchar(100) DEFAULT NULL,
  `traveauxArabe` varchar(100) DEFAULT NULL,
  `articlesArabes` text,
  `nombreUnites` decimal(10,2) DEFAULT NULL,
  `prixUnitaire2` decimal(10,2) DEFAULT NULL,
  `unite2` varchar(30) DEFAULT NULL,
  `nomUnite2` varchar(50) DEFAULT NULL,
  `nomUniteArabe2` varchar(100) DEFAULT NULL,
  `nombreUnites2` decimal(10,2) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `employe` int(11) DEFAULT NULL,
  `idSociete` int(11) DEFAULT NULL,
  `idProjet` int(12) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `t_contratemploye`
--

INSERT INTO `t_contratemploye` (`id`, `dateContrat`, `dateFinContrat`, `prixUnitaire`, `unite`, `nomUnite`, `nomUniteArabe`, `traveaux`, `traveauxArabe`, `articlesArabes`, `nombreUnites`, `prixUnitaire2`, `unite2`, `nomUnite2`, `nomUniteArabe2`, `nombreUnites2`, `total`, `employe`, `idSociete`, `idProjet`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1, '2015-12-10', NULL, '100.00', 'm&sup2;', NULL, NULL, NULL, NULL, NULL, '100.00', NULL, NULL, NULL, NULL, NULL, '10000.00', 1, 1, 15, '2015-12-10 07:12:08', 'admin', NULL, NULL),
(2, '2015-12-10', NULL, '300.00', 'unite', NULL, NULL, NULL, NULL, NULL, '12.00', NULL, NULL, NULL, NULL, NULL, '3600.00', 4, 1, 15, '2015-12-10 07:33:01', 'admin', NULL, NULL),
(3, '2015-12-11', NULL, '70.00', 'appartement', NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '0.00', 4, 1, 15, '2015-12-11 05:33:56', 'admin', NULL, NULL),
(4, '2015-12-19', '2016-03-04', '30.00', 'm&sup2;', '', NULL, 'test', 'ÙÙŠØ³Ù', NULL, '30.00', '10.00', 'm lineaire', '', NULL, '20.00', '1100.00', 4, 1, 15, '2015-12-19 04:57:53', 'admin', NULL, NULL),
(5, '2016-06-18', '0000-00-00', '60.00', 'm lineaire', '', NULL, 'Aluminium', '', NULL, '200.00', '0.00', '', '', NULL, '0.00', '12000.00', 5, 1, 15, '2016-06-18 04:12:20', 'admin', NULL, NULL),
(6, '2016-01-13', '2016-04-01', '70.00', 'unite', 'porte', NULL, 'Aluminium', 'Ø£Ù„ÙˆÙ…ÙŠÙ†ÙŠÙˆÙ…', NULL, '100.00', NULL, NULL, NULL, NULL, NULL, '7000.00', 3, 1, 15, '2016-01-13 12:54:58', 'admin', NULL, NULL),
(7, '2016-01-26', '2016-05-05', '60.00', 'unite', 'surface', NULL, 'Peinture', 'Ø§Ù„ØµØ¨Ø§ØºØ©', NULL, '100.00', '20.00', 'm lineaire', '', NULL, '200.00', '3500.00', 1, 1, 15, '2016-01-26 03:21:17', 'admin', NULL, NULL),
(8, '2016-03-01', '2016-03-01', '70.00', 'm&sup2;', '', NULL, 'construction', 'Ø§Ù„Ø¨Ù†Ø§Ø¡', NULL, '100.00', '30.00', 'm lineaire', '', NULL, '100.00', '10000.00', 3, 1, 15, '2016-03-01 04:08:58', 'admin', NULL, NULL),
(9, '2016-03-05', '2016-03-05', '2000.00', 'unite', 'appartement', 'Ø´Ù‚Ø©', 'test', 'Ø§Ù„Ù†Ø¬Ø§Ø±Ø©', NULL, '18.00', '70.00', 'unite', 'PORTE', 'Ø¨Ø§Ø¨', '10.00', '36700.00', 5, 1, 15, '2016-03-05 11:58:13', 'admin', NULL, NULL),
(10, '2016-03-15', '2016-03-15', '12.00', 'm&sup2;', '', '', 'testatat', 'Ø§Ù„Ø¬Ø¨Øµ', 'Ø§Ù„Ø¨Ù†Ø¯ Ø§Ù„Ø«Ø§Ù„Ø« Ø¹Ø´Ø± : Ø¹Ù„Ù‰ Ø§Ù„Ù…ØªØ¹Ø§Ù‚Ø¯ Ø£Ù† ÙŠØ³Ù„Ù… Ø§Ù„Ø§Ø´ØºØ§Ù„ ÙÙŠ Ø§Ù„Ø§Ø¬Ø§Ù„ Ø§Ù„Ù…ØªÙÙ‚ Ø¹Ù„ÙŠÙ‡Ø§.', '120.00', '0.00', 'm&sup2;', '', '', '0.00', '1440.00', 1, 1, 15, '2016-03-15 10:11:43', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_contrattravail`
--

CREATE TABLE IF NOT EXISTS `t_contrattravail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `cin` varchar(50) DEFAULT NULL,
  `adresse` text,
  `dateNaissance` varchar(25) DEFAULT NULL,
  `matiere` varchar(100) DEFAULT NULL,
  `prix` decimal(12,2) DEFAULT NULL,
  `mesure` decimal(12,2) DEFAULT NULL,
  `prixTotal` decimal(12,2) DEFAULT NULL,
  `dateContrat` date DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_contrattravailreglement`
--

CREATE TABLE IF NOT EXISTS `t_contrattravailreglement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant` decimal(12,2) DEFAULT NULL,
  `motif` text,
  `dateReglement` date DEFAULT NULL,
  `idContratTravail` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_employe`
--

CREATE TABLE IF NOT EXISTS `t_employe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `nomArabe` varchar(50) DEFAULT NULL,
  `adresseArabe` varchar(255) DEFAULT NULL,
  `cin` varchar(50) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `t_employe`
--

INSERT INTO `t_employe` (`id`, `nom`, `adresse`, `nomArabe`, `adresseArabe`, `cin`, `telephone`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1, 'mustapha almelali', 'Rue 4002 Beni Ennsar Nador', 'Ù…ØµØ·ÙÙŠ Ø§Ù„Ù…Ù„Ø§Ù„ÙŠ', 'Ø´Ø§Ø±Ø¹ 4002 Ø¨Ù†ÙŠ Ø£Ù†ØµØ§Ø± Ø§Ù„Ù†Ø§Ø¸ÙˆØ±', 'I47830', '0672337782', '2015-12-10 05:33:33', 'admin', '2015-12-10 05:45:53', 'admin'),
(3, 'Mohamed Taghlaoui', 'Rue Patrice Lumumba Oujda', 'Ù…Ø­Ù…Ø¯ Ø§Ù„ØªØºÙ„Ø§ÙˆÙŠ', 'Ø´Ø§Ø±Ø¹ Ø¨Ø§ØªØ±ÙŠØ³ Ù„ÙˆÙ…ÙˆÙ…Ø¨Ø§ ÙˆØ¬Ø¯Ø©', 'OF2394', '0668467738', '2015-12-10 07:30:57', 'admin', NULL, NULL),
(4, 'karim amellah', 'Rue Tanger Nador', 'ÙƒØ±ÙŠÙ… Ø£Ù…Ù„Ø§Ø­', 'Ø´Ø§Ø±Ø¹ Ø·Ù†Ø¬Ø© Ø§Ù„Ù†Ø§Ø¸ÙˆØ±', 'S34029', '0662334478', '2015-12-10 07:32:50', 'admin', NULL, NULL),
(5, 'Selam Dehmani', '34 Rue Ligue Arab Nador', 'Ø³Ù„Ø§Ù… Ø§Ù„Ø¯Ø­Ù…Ø§Ù†ÙŠ', 'Ø´Ø§Ø±Ø¹ Ø§Ù„Ø¬Ø§Ù…Ø¹Ø© Ø§Ù„Ø¹Ø±Ø¨ÙŠØ© 34, Ø§Ù„Ù†Ø§Ø¸ÙˆØ±', 'S123099', '0672881900', '2015-12-17 01:01:09', 'admin', '2015-12-17 01:01:34', 'admin'),
(7, 'tes', 'teqt', 'ets', 'teteet', 'tes', 'test', '2015-12-17 01:08:53', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_employe_projet`
--

CREATE TABLE IF NOT EXISTS `t_employe_projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `cin` varchar(100) DEFAULT NULL,
  `photo` text,
  `telephone` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `etatCivile` varchar(45) DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateSortie` date DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `t_employe_projet`
--

INSERT INTO `t_employe_projet` (`id`, `nom`, `cin`, `photo`, `telephone`, `email`, `etatCivile`, `dateDebut`, `dateSortie`, `idProjet`) VALUES
(2, 'Hoissein electricien', 'Z3378', '/photo_employes_societe/5626c8ab7f9f820151020_143632.jpg', '', '', 'Mari&eacute;', '2015-10-20', '2015-11-25', 16);

-- --------------------------------------------------------

--
-- Structure de la table `t_employe_societe`
--

CREATE TABLE IF NOT EXISTS `t_employe_societe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `cin` varchar(100) DEFAULT NULL,
  `photo` text,
  `telephone` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `etatCivile` varchar(45) DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateSortie` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `t_employe_societe`
--

INSERT INTO `t_employe_societe` (`id`, `nom`, `cin`, `photo`, `telephone`, `email`, `etatCivile`, `dateDebut`, `dateSortie`) VALUES
(1, 'LAILA KANOUN', 'S******', '', '0698103017', 'lailasaslo@hotmail.com', 'C&eacute;libataire', '2014-03-04', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `t_fournisseur`
--

CREATE TABLE IF NOT EXISTS `t_fournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telephone1` varchar(45) DEFAULT NULL,
  `telephone2` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `t_fournisseur`
--

INSERT INTO `t_fournisseur` (`id`, `nom`, `adresse`, `email`, `telephone1`, `telephone2`, `fax`, `dateCreation`, `code`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(19, 'Ste guarimetal', 'Nador', 'societe.garimetal@gmail.com', '0536606936', '0536606937', '0536606938', '2015-10-20', '5626c60bbe25c20151020225403', NULL, NULL, '2015-11-24 03:15:47', 'admin'),
(20, 'Ste westmat', 'Nador', 'westmat@gmail.com', '0536330099', '0536330094', '0536330092', '2015-10-20', '5626c6d5b606320151020225725', NULL, NULL, '2015-11-24 03:17:00', 'admin'),
(21, 'amin zitouni', 'Quartier Al Amal S&eacute;louane', 'zitouni.amin@gmail.com', '0536600890', '0661334888', '0536600890', NULL, '564b57507c6fd20151117173528', NULL, NULL, '2015-11-24 03:17:19', 'admin'),
(22, 'abderahman yaalou', 'Rue Angad Oujda', 'yaalou.a@gmail.com', '0612009999', '0536600325', '0536600324', NULL, '564b587a6786520151117174026', NULL, NULL, '2015-11-24 03:13:17', 'admin'),
(28, 'Soci&eacute;t&eacute; FouratMetal', ' Houara Ouled Rahou Route De Missour - Guercif ', 'fouratmetal@gmail.com', '0535409900', '0535409911', '0535409901', NULL, '56546fcd31d3b20151124151021', '2015-11-24 03:10:21', 'admin', NULL, NULL),
(25, 'halim achalhi', 'rue tanger 125 nador', 'hi.achalhi@gmail.com', '0536600215', '0536601245', '0536600215', NULL, '5652090ae174120151122192722', '2015-11-22 07:27:22', 'admin', '2015-11-24 03:10:45', 'admin'),
(29, 'said kemli', 'rue 340 Nador', 'said.kemli@gmail.com', '0536609950', '', '', NULL, '56729dbf2454520151217123423', '2015-12-17 12:34:23', 'admin', NULL, NULL),
(30, 'Jebbari Moustafa', 'Rue Tafilalt ', '', '0675234456', '0536607788', '', NULL, '57bc5982008d920160823161114', '2016-08-23 04:11:14', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_history`
--

CREATE TABLE IF NOT EXISTS `t_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(50) DEFAULT NULL,
  `target` varchar(50) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=427 ;

--
-- Contenu de la table `t_history`
--

INSERT INTO `t_history` (`id`, `action`, `target`, `description`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(3, 'Modification', 'Table des comptes bancaires', 'Modifier un compte bancaire', '2015-12-04 05:54:12', 'mouaad', NULL, NULL),
(4, 'Modification', 'Table des tÃ¢ches', 'Modifier le status d''une tÃ¢che', '2015-12-04 05:55:45', 'admin', NULL, NULL),
(5, 'Suppression', 'Table des tÃ¢ches', 'Supprimer les tÃ¢ches validÃ©es', '2015-12-04 06:25:37', 'admin', NULL, NULL),
(6, 'Modification', 'Table des livraisons', 'Modifier une livraison', '2015-12-05 12:31:28', 'mouaad', NULL, NULL),
(7, 'Modification', 'Table des livraisons', 'Modifier une livraison', '2015-12-05 12:31:53', 'mouaad', NULL, NULL),
(8, 'Modification', 'Table des livraisons', 'Modifier une livraison', '2015-12-05 12:33:56', 'mouaad', NULL, NULL),
(9, 'Ajout', 'Table des livraisons', 'Ajouter une livraison', '2015-12-05 12:34:10', 'mouaad', NULL, NULL),
(10, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajouter un article Ã  la livraison', '2015-12-05 12:34:25', 'mouaad', NULL, NULL),
(11, 'Ajout', 'Table des paiements clients ', 'Ajouter un paiement client', '2015-12-07 10:36:40', 'admin', NULL, NULL),
(12, 'Ajout', 'Table des clients', 'Ajouter un client', '2015-12-08 12:08:31', 'admin', NULL, NULL),
(13, 'Ajout', 'Table des appartements', 'Ajouter un appartement', '2015-12-08 12:09:35', 'admin', NULL, NULL),
(14, 'Ajout', 'Table des contrats', 'Ajouter un contrat', '2015-12-08 12:10:39', 'admin', NULL, NULL),
(15, 'Suppression', 'Table de caisse', 'Supprimer une opÃ©ration', '2015-12-09 11:19:59', 'admin', NULL, NULL),
(16, 'Ajout', 'Table de caisse', 'Ajouter une opÃ©ration', '2015-12-09 11:25:53', 'admin', NULL, NULL),
(17, 'Modification', 'Table de caisse', 'Modifier une opÃ©ration', '2015-12-09 11:28:11', 'admin', NULL, NULL),
(18, 'Suppression', 'Table de caisse', 'Supprimer une opÃ©ration', '2015-12-09 11:28:25', 'admin', NULL, NULL),
(19, 'Suppression', 'Table de caisse', 'Supprimer une opÃ©ration', '2015-12-09 11:28:46', 'admin', NULL, NULL),
(20, 'Ajout', 'Table de caisse', 'Ajouter une opÃ©ration', '2015-12-09 11:28:59', 'admin', NULL, NULL),
(21, 'Ajout', 'Table de caisse', 'Ajouter une opÃ©ration', '2015-12-09 11:47:14', 'admin', NULL, NULL),
(22, 'Ajout', 'Table de caisse', 'Ajouter une opÃ©ration', '2015-12-09 11:47:21', 'admin', NULL, NULL),
(23, 'Ajout', 'Table de caisse', 'Ajouter une opÃ©ration', '2015-12-09 11:47:30', 'admin', NULL, NULL),
(24, 'Ajout', 'Table de caisse', 'Ajouter une opÃ©ration', '2015-12-09 11:47:57', 'admin', NULL, NULL),
(25, 'Ajout', 'Table de caisse', 'Ajouter une opÃ©ration', '2015-12-09 11:48:11', 'admin', NULL, NULL),
(26, 'Ajout', 'Table de caisse', 'Ajouter une opÃ©ration', '2015-12-09 11:49:22', 'admin', NULL, NULL),
(27, 'Suppression', 'Table de caisse', 'Supprimer une opÃ©ration', '2015-12-09 12:58:49', 'admin', NULL, NULL),
(28, 'Suppression', 'Table de caisse', 'Supprimer une opÃ©ration', '2015-12-09 12:58:57', 'admin', NULL, NULL),
(29, 'Suppression', 'Table de caisse', 'Supprimer une opÃ©ration', '2015-12-09 12:59:05', 'admin', NULL, NULL),
(30, 'Modification', 'Table des tÃ¢ches', 'Modifier le status d''une tÃ¢che', '2015-12-10 04:06:56', 'admin', NULL, NULL),
(31, 'Suppression', 'Table des tÃ¢ches', 'Supprimer les tÃ¢ches validÃ©es', '2015-12-10 04:07:24', 'admin', NULL, NULL),
(32, 'Ajout', 'Table des employÃ©s', 'Ajouter un employÃ©', '2015-12-10 05:33:33', 'admin', NULL, NULL),
(33, 'Ajout', 'Table des employÃ©s', 'Modifier un employÃ©', '2015-12-10 05:45:53', 'admin', NULL, NULL),
(34, 'Ajout', 'Table des employÃ©s', 'Ajouter un employÃ©', '2015-12-10 07:30:17', 'admin', NULL, NULL),
(35, 'Ajout', 'Table des employÃ©s', 'Ajouter un employÃ©', '2015-12-10 07:30:57', 'admin', NULL, NULL),
(36, 'Suppression', 'Table des employÃ©s', 'Supprimer un employÃ©', '2015-12-10 07:31:12', 'admin', NULL, NULL),
(37, 'Ajout', 'Table des employÃ©s', 'Ajouter un employÃ©', '2015-12-10 07:32:50', 'admin', NULL, NULL),
(38, 'Ajout', 'Table des tÃ¢ches', 'Ajouter une nouvelle tÃ¢che', '2015-12-11 05:26:54', 'admin', NULL, NULL),
(39, 'Modification', 'Table des tÃ¢ches', 'Modifier le status d''une tÃ¢che', '2015-12-11 05:27:27', 'mouaad', NULL, NULL),
(40, 'Ajout', 'Table des tÃ¢ches', 'Ajouter une nouvelle tÃ¢che', '2015-12-11 05:27:49', 'mouaad', NULL, NULL),
(41, 'Modification', 'Table des tÃ¢ches', 'Modifier le status d''une tÃ¢che', '2015-12-11 05:28:10', 'admin', NULL, NULL),
(42, 'Modification', 'Table des tÃ¢ches', 'Modifier le status d''une tÃ¢che', '2015-12-11 05:28:13', 'admin', NULL, NULL),
(43, 'Ajout', 'Table des paiements clients ', 'Ajouter un paiement client', '2015-12-11 10:07:52', 'admin', NULL, NULL),
(44, 'Modification', 'Table des projets', 'Modifier un projet', '2015-12-11 10:21:55', 'admin', NULL, NULL),
(45, 'Ajout', 'Table des tÃ¢ches', 'Ajouter une nouvelle tÃ¢che', '2015-12-11 10:59:20', 'admin', NULL, NULL),
(46, 'Ajout', 'Table des tÃ¢ches', 'Ajouter une nouvelle tÃ¢che', '2015-12-11 10:59:44', 'admin', NULL, NULL),
(47, 'Ajout', 'Table des livraisons', 'Ajouter une livraison', '2015-12-15 12:02:54', 'admin', NULL, NULL),
(48, 'Ajout', 'Table des livraisons', 'Ajouter une livraison', '2015-12-15 12:10:23', 'admin', NULL, NULL),
(49, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajouter un article Ã  la livraison', '2015-12-15 12:10:36', 'admin', NULL, NULL),
(50, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajouter un article Ã  la livraison', '2015-12-15 12:10:45', 'admin', NULL, NULL),
(51, 'Modification', 'Table des dÃ©tails livraisons', 'Modifier un article de la livraison', '2015-12-15 12:24:17', 'admin', NULL, NULL),
(52, 'Ajout', 'Table des rÃ©glements fournisseurs', 'Ajouter un rÃ©glement fournisseur', '2015-12-16 01:14:06', 'admin', NULL, NULL),
(53, 'Ajout', 'Table des charges', 'Ajout d''une charge de type : Finition, le : 2015-12-16, d''un montant de : 2000, dont la designation est : Rien - Projet : Annahda 1', '2015-12-16 01:48:51', 'admin', NULL, NULL),
(54, 'Ajout', 'Table des appartements', 'Ajout de l''appartement : XO1 - Projet : Annahda 1', '2015-12-16 01:50:54', 'admin', NULL, NULL),
(55, 'Modification Status', 'Table des appartements', 'Changement de status de l''appartement XO1 vers le status : R&eacute;serv&eacute; - Projet : Annahda 1', '2015-12-16 01:53:14', 'admin', NULL, NULL),
(56, 'Modification Client', 'Table des appartements', 'Changement de rÃ©servation de l''appartement XO1 pour  : AASSOU Abdelilah - Projet : Annahda 1', '2015-12-16 01:53:40', 'admin', NULL, NULL),
(57, 'Modification', 'Table des appartements', 'Modification de l''appartement : XO1 - Projet : Annahda 1', '2015-12-16 01:54:41', 'admin', NULL, NULL),
(58, 'Suppression', 'Table des appartements', 'Suppression de l''appartement XO1 - Projet : Annahda 1', '2015-12-16 01:55:09', 'admin', NULL, NULL),
(59, 'Ajout', 'Table des appartements', 'Ajout de l''appartement : A8 - Projet : Annahda 1', '2015-12-16 01:57:27', 'admin', NULL, NULL),
(60, 'Modification', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 4, de type : Entree, le 2015-12-09, d''un montant de : 3000DH, en dÃ©signation : Mohamed Frais d&eacute;placements', '2015-12-16 02:00:39', 'admin', NULL, NULL),
(61, 'Suppression', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 5, de type : Sortie, le 2015-12-09, d''un montant de : DH, en dÃ©signation : ', '2015-12-16 02:01:27', 'admin', NULL, NULL),
(62, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Sortie, le 2015-12-16, d''un montant de : 2000DH, en dÃ©signation : Salim', '2015-12-16 02:18:53', 'admin', NULL, NULL),
(63, 'Modification', 'Table des comptes bancaires', 'Modifier le compte bancaire numÃ©ro : 8905551980, avec la dÃ©nomination : Annahda 1', '2015-12-16 02:34:32', 'admin', NULL, NULL),
(64, 'Ajout', 'Table des comptes bancaires', 'Ajouter le compte bancaire numÃ©ro : 90239, avec la dÃ©nomination : Iaaza', '2015-12-16 02:34:56', 'admin', NULL, NULL),
(65, 'Modification', 'Table des comptes bancaires', 'Modifier le compte bancaire numÃ©ro : 89055519803, avec la dÃ©nomination : Annahda 1', '2015-12-16 02:35:35', 'admin', NULL, NULL),
(66, 'Ajout', 'Table des comptes bancaires', 'Ajouter le compte bancaire numÃ©ro : 1, avec la dÃ©nomination : Test', '2015-12-16 02:37:01', 'admin', NULL, NULL),
(67, 'Modification', 'Table des comptes bancaires', 'Modifier le compte bancaire numÃ©ro : 1, avec la dÃ©nomination : Test 1', '2015-12-16 02:37:09', 'admin', NULL, NULL),
(68, 'Ajout', 'Table des fournisseurs', 'Ajout du fournisseur : said kemli', '2015-12-17 12:34:23', 'admin', NULL, NULL),
(69, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 200, fournisseur : said kemli - Projet : Annahda 1 - SociÃ©tÃ© : Annahda', '2015-12-17 12:36:18', 'admin', NULL, NULL),
(70, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2751 - SociÃ©tÃ© : Annahda', '2015-12-17 12:36:31', 'admin', NULL, NULL),
(71, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2751 - SociÃ©tÃ© : Annahda', '2015-12-17 12:36:38', 'admin', NULL, NULL),
(72, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 300, fournisseur : Soci&eacute;t&eacute; FouratMetal - Projet : Annahda 1 - SociÃ©tÃ© : Annahda', '2015-12-17 12:37:41', 'admin', NULL, NULL),
(73, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2752 - SociÃ©tÃ© : Annahda', '2015-12-17 12:37:54', 'admin', NULL, NULL),
(74, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 400, fournisseur : said kemli - Projet : Annahda 1 - SociÃ©tÃ© : Annahda', '2015-12-17 12:51:40', 'admin', NULL, NULL),
(75, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 4 - SociÃ©tÃ© : Iaaza', '2015-12-17 12:51:56', 'admin', NULL, NULL),
(76, 'Suppression', 'Table des livraisons, Table dÃ©tails livraisons', 'Suppression de la livraison 2 ainsi que ses dÃ©tails - SociÃ©tÃ© : Iaaza', '2015-12-17 12:52:04', 'admin', NULL, NULL),
(77, 'Suppression', 'Table des livraisons, Table dÃ©tails livraisons', 'Suppression de la livraison 3 ainsi que ses dÃ©tails - SociÃ©tÃ© : Iaaza', '2015-12-17 12:52:08', 'admin', NULL, NULL),
(78, 'Ajout', 'Table des rÃ©glements fournisseurs Iaaza', 'Ajout du rÃ©glement, montant : 3000, fournisseur : said kemli - SociÃ©tÃ© : Iaaza', '2015-12-17 12:54:37', 'admin', NULL, NULL),
(79, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 401, fournisseur : said kemli - Projet : Annahda 1 - SociÃ©tÃ© : Iaaza', '2015-12-17 12:58:09', 'admin', NULL, NULL),
(80, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : test, fournisseur : said kemli - Projet : Annahda 1 - SociÃ©tÃ© : Annahda', '2015-12-17 12:58:35', 'admin', NULL, NULL),
(81, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 5 - SociÃ©tÃ© : Iaaza', '2015-12-17 12:58:43', 'admin', NULL, NULL),
(82, 'Suppression', 'Table des livraisons, Table dÃ©tails livraisons', 'Suppression de la livraison 5 ainsi que ses dÃ©tails - SociÃ©tÃ© : Iaaza', '2015-12-17 12:58:51', 'admin', NULL, NULL),
(83, 'Modification', 'Table des comptes bancaires', 'Modifier le compte bancaire numÃ©ro : 123013, avec la dÃ©nomination : Iaaza 2', '2015-12-17 12:59:33', 'admin', NULL, NULL),
(84, 'Ajout', 'Table des employÃ©s', 'Ajout de l''employÃ© : Selam Dehmani', '2015-12-17 01:01:09', 'admin', NULL, NULL),
(85, 'Modification', 'Table des employÃ©s', 'Modification de l''employÃ© : Selam Dehmani', '2015-12-17 01:01:34', 'admin', NULL, NULL),
(86, 'Ajout', 'Table des comptes bancaires', 'Ajouter le compte bancaire numÃ©ro : test, avec la dÃ©nomination : test', '2015-12-17 01:02:52', 'admin', NULL, NULL),
(87, 'Ajout', 'Table des employÃ©s', 'Ajout de l''employÃ© : test', '2015-12-17 01:04:30', 'admin', NULL, NULL),
(88, 'Suppression', 'Table des employÃ©s', 'Suppression de l''employÃ© : test', '2015-12-17 01:04:34', 'admin', NULL, NULL),
(89, 'Ajout', 'Table des employÃ©s', 'Ajout de l''employÃ© : tes', '2015-12-17 01:08:53', 'admin', NULL, NULL),
(90, 'Modification', 'Table des projets', 'Modification du projet : Annahda 1', '2015-12-21 04:35:19', 'admin', NULL, NULL),
(91, 'Modification', 'Table des projets', 'Modification du projet : Annahda 1', '2015-12-21 04:37:17', 'admin', NULL, NULL),
(92, 'Modification', 'Table des projets', 'Modification du projet : Annahda 1', '2015-12-21 04:38:29', 'admin', NULL, NULL),
(93, 'Ajout', 'Table des projets', 'Ajout du projet : Annahda 13', '2015-12-21 04:39:57', 'admin', NULL, NULL),
(94, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2015-12-22, d''un montant de : 1000DH, en dÃ©signation : Salim', '2015-12-22 03:21:46', 'admin', NULL, NULL),
(95, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Sortie, le 2015-12-22, d''un montant de : 200DH, en dÃ©signation : Voiture', '2015-12-22 03:22:06', 'admin', NULL, NULL),
(96, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2015-12-22, d''un montant de : 2000DH, en dÃ©signation : Test', '2015-12-22 03:32:33', 'abdou', NULL, NULL),
(97, 'Modification', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 1, de type : Sortie, le 2015-12-22, d''un montant de : 1000.00DH, en dÃ©signation : Salim', '2015-12-22 03:32:50', 'abdou', NULL, NULL),
(98, 'Modification', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 3, de type : Sortie, le 2015-12-22, d''un montant de : 2000.00DH, en dÃ©signation : Test', '2015-12-22 03:33:06', 'abdou', NULL, NULL),
(99, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 4 - SociÃ©tÃ© : Iaaza', '2015-12-22 03:50:44', 'admin', NULL, NULL),
(100, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 111, fournisseur : Soci&eacute;t&eacute; FouratMetal - Projet : Annahda 1 - SociÃ©tÃ© : Annahda', '2015-12-22 03:51:51', 'admin', NULL, NULL),
(101, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 6 - SociÃ©tÃ© : Iaaza', '2015-12-22 03:52:03', 'admin', NULL, NULL),
(102, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 12, fournisseur : said kemli - Projet : Annahda 1 - SociÃ©tÃ© : Annahda', '2015-12-22 03:53:24', 'admin', NULL, NULL),
(103, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 7 - SociÃ©tÃ© : Iaaza', '2015-12-22 03:53:44', 'admin', NULL, NULL),
(104, 'Ajout', 'Table des rÃ©glements fournisseurs Iaaza', 'Ajout du rÃ©glement, montant : 1000, fournisseur : said kemli - SociÃ©tÃ© : Iaaza', '2015-12-22 03:54:36', 'admin', NULL, NULL),
(105, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Sortie, le 2015-12-22, d''un montant de : 200DH, en dÃ©signation : Nettotage', '2015-12-22 03:56:01', 'admin', NULL, NULL),
(106, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 433, montant : 90000', '2016-06-18 04:08:29', 'admin', NULL, NULL),
(107, 'Ajout', 'Table des tÃ¢ches', 'Ajouter une nouvelle tÃ¢che', '2016-06-18 04:22:31', 'admin', NULL, NULL),
(108, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 1, client : mohamed el khattabi, appartement : 458, prix : 550000 - Projet : Annahda 1', '2015-12-22 05:41:30', 'admin', NULL, NULL),
(109, 'Ajout', 'Table des clients', 'Ajout du client : semlali rachid', '2015-12-23 12:46:56', 'admin', NULL, NULL),
(110, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 100001, client : semlali rachid, appartement : 450, prix : 680000 - Projet : Annahda 2', '2015-12-23 12:49:03', 'admin', NULL, NULL),
(111, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 436, montant : 200000', '2015-12-23 12:50:34', 'admin', NULL, NULL),
(112, 'Modification', 'Table des clients', 'Modifier le client : semlali jamal', '2015-12-23 12:56:30', 'admin', NULL, NULL),
(113, 'Modification', 'Table des contrats', 'Modification du contrat dont l''identifiant est : 433 - Projet : Annahda 1', '2015-12-23 10:30:52', 'admin', NULL, NULL),
(114, 'Modification', 'Table des contrats', 'Modification du contrat dont l''identifiant est : 433 - Projet : Annahda 1', '2015-12-23 10:31:38', 'admin', NULL, NULL),
(115, 'Modification de status', 'Table des rÃ©glements prÃ©vus', 'Modifier les status d''un rÃ©glement prÃ©vu', '2015-12-23 10:32:45', 'admin', NULL, NULL),
(116, 'Modification de status', 'Table des rÃ©glements prÃ©vus', 'Modifier les status d''un rÃ©glement prÃ©vu', '2015-12-23 10:32:52', 'admin', NULL, NULL),
(117, 'Ajout', 'Table des locaux commerciaux', 'Ajout du local commercial : LC30 - Projet : Annahda 1', '2015-12-24 01:50:10', 'admin', NULL, NULL),
(118, 'Ajout', 'Table des clients', 'Ajout du client : souid ahmed ayoub', '2015-12-24 01:52:10', 'admin', NULL, NULL),
(119, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 100020, client : souid ahmed ayoub, localCommercial : 32, prix : 130000 - Projet : Annahda 1', '2015-12-24 01:57:14', 'admin', NULL, NULL),
(120, 'DÃ©sistement', 'Table des contrats', 'DÃ©sistement du contrat dont l''identifiant est : 437 - Projet : Annahda 1', '2015-12-24 02:05:46', 'admin', NULL, NULL),
(121, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 9021, client : souid ahmed ayoub, localCommercial : 32, prix : 130000 - Projet : Annahda 1', '2015-12-24 02:11:37', 'admin', NULL, NULL),
(122, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 9021, client : souid ahmed ayoub, localCommercial : 32, prix : 130000 - Projet : Annahda 1', '2015-12-24 02:13:21', 'admin', NULL, NULL),
(123, 'Modification', 'Table des contrats', 'Modification du contrat dont l''identifiant est : 439 - Projet : Annahda 1', '2015-12-24 03:03:57', 'admin', NULL, NULL),
(124, 'Suppression', 'Table des tÃ¢ches', 'Supprimer une tÃ¢che', '2015-12-24 03:31:46', 'admin', NULL, NULL),
(125, 'Modification', 'Table des tÃ¢ches', 'Modifier une tÃ¢che', '2015-12-24 03:56:09', 'admin', NULL, NULL),
(126, 'Modification', 'Table des tÃ¢ches', 'Modifier une tÃ¢che', '2015-12-24 03:56:24', 'admin', NULL, NULL),
(127, 'Modification', 'Table des tÃ¢ches', 'Modifier le status d''une tÃ¢che', '2015-12-24 03:57:31', 'mouaad', NULL, NULL),
(128, 'Modification', 'Table des tÃ¢ches', 'Modifier le status d''une tÃ¢che', '2015-12-24 03:57:36', 'mouaad', NULL, NULL),
(129, 'Modification', 'Table des tÃ¢ches', 'Modifier le status d''une tÃ¢che', '2015-12-24 03:57:40', 'mouaad', NULL, NULL),
(130, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 12, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Iaaza', '2015-12-24 04:53:15', 'admin', NULL, NULL),
(131, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 12, fournisseur : said kemli - Projet : Annahda 4 - SociÃ©tÃ© : Iaaza', '2015-12-24 04:57:56', 'admin', NULL, NULL),
(132, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 12, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Iaaza', '2015-12-24 04:58:11', 'admin', NULL, NULL),
(133, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 1001, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2015-12-24 05:14:22', 'admin', NULL, NULL),
(134, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 1001, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Iaaza', '2015-12-24 05:18:06', 'admin', NULL, NULL),
(135, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2015-12-28 05:22:49', 'admin', NULL, NULL),
(136, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2015-12-28 05:26:56', 'admin', NULL, NULL),
(137, 'Retirage', 'Table des paiements clients', 'Retirage de paiement client de la page des Ã©tats des paiements', '2015-12-28 05:36:10', 'admin', NULL, NULL),
(138, 'Annulation', 'Table des paiements clients', 'Annulation de paiement client', '2015-12-28 05:43:15', 'admin', NULL, NULL),
(139, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2015-12-28 05:43:22', 'admin', NULL, NULL),
(140, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2015-12-28 05:43:29', 'admin', NULL, NULL),
(141, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2015-12-28 05:43:35', 'admin', NULL, NULL),
(142, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2015-12-28 05:43:40', 'admin', NULL, NULL),
(143, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2015-12-28 05:43:45', 'admin', NULL, NULL),
(144, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2015-12-28 05:43:55', 'admin', NULL, NULL),
(145, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2015-12-28 05:44:09', 'admin', NULL, NULL),
(146, 'Retirage', 'Table des paiements clients', 'Retirage de paiement client de la page des Ã©tats des paiements', '2015-12-28 05:44:23', 'admin', NULL, NULL),
(147, 'Ajout', 'Table des rÃ©glements fournisseurs Annahda', 'Ajout du rÃ©glement, montant : 9000, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2015-12-28 06:24:46', 'admin', NULL, NULL),
(148, 'Ajout', 'Table des rÃ©glements fournisseurs Annahda', 'Ajout du rÃ©glement, montant : 230920000, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2015-12-28 06:38:41', 'admin', NULL, NULL),
(149, 'Suppression', 'Table des rÃ©glements fournisseurs Annahda', 'Suppression du rÃ©glement, montant : 230920000.00, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2015-12-28 06:39:15', 'admin', NULL, NULL),
(150, 'Ajout', 'Table des rÃ©glements fournisseurs Annahda', 'Ajout du rÃ©glement, montant : 1000, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2015-12-28 06:41:16', 'admin', NULL, NULL),
(151, 'Ajout', 'Table des rÃ©glements fournisseurs Annahda', 'Ajout du rÃ©glement, montant : 3000, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2015-12-28 06:43:08', 'admin', NULL, NULL),
(152, 'Suppression', 'Table des rÃ©glements fournisseurs Annahda', 'Suppression du rÃ©glement, montant : 3000.00, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2015-12-28 06:43:16', 'admin', NULL, NULL),
(153, 'Modification', 'Table des rÃ©glements fournisseurs Annahda', 'Modification du rÃ©glement, montant : 300, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2015-12-28 06:55:10', 'admin', NULL, NULL),
(154, 'Modification', 'Table des rÃ©glements fournisseurs Annahda', 'Modification du rÃ©glement, montant : 400, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2015-12-28 06:57:41', 'admin', NULL, NULL),
(155, 'Modification', 'Table des rÃ©glements fournisseurs Annahda', 'Modification du rÃ©glement, montant : 400.00, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2015-12-28 06:58:00', 'admin', NULL, NULL),
(156, 'Modification', 'Table des rÃ©glements fournisseurs Annahda', 'Modification du rÃ©glement, montant : 400.00, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2015-12-28 06:59:45', 'admin', NULL, NULL),
(157, 'Ajout', 'Table des rÃ©glements fournisseurs Annahda', 'Ajout du rÃ©glement, montant : 400, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2015-12-28 07:00:35', 'admin', NULL, NULL),
(158, 'Ajout', 'Table des rÃ©glements fournisseurs Iaaza', 'Ajout du rÃ©glement, montant : 3000, fournisseur : said kemli - SociÃ©tÃ© : Iaaza', '2015-12-29 12:29:55', 'admin', NULL, NULL),
(159, 'Ajout', 'Table des rÃ©glements fournisseurs Iaaza', 'Ajout du rÃ©glement, montant : 2000, fournisseur : said kemli - SociÃ©tÃ© : Iaaza', '2015-12-29 12:30:27', 'admin', NULL, NULL),
(160, 'Ajout', 'Table des rÃ©glements fournisseurs Iaaza', 'Ajout du rÃ©glement, montant : 1040, fournisseur : said kemli - SociÃ©tÃ© : Iaaza', '2015-12-29 12:30:51', 'admin', NULL, NULL),
(161, 'Ajout', 'Table des terrains', 'Ajout du terrain:  - Projet : Annahda 3', '2015-12-31 02:57:51', 'mido', NULL, NULL),
(162, 'Modification', 'Table des terrains', 'Modification du terrain: 309, ouled boutaib nador - Projet : Annahda 3', '2015-12-31 03:01:37', 'mido', NULL, NULL),
(163, 'Modification', 'Table des terrains', 'Modification du terrain: 309, ouled boutaib nador - Projet : Annahda 3', '2015-12-31 03:01:49', 'mido', NULL, NULL),
(164, 'Ajout', 'Table des terrains', 'Ajout du terrain: Rue El Ouehda 4093 Nador - Projet : Annahda 3', '2015-12-31 03:06:24', 'mido', NULL, NULL),
(165, 'Suppression', 'Table des terrain', 'Suppression du terrain  - Projet : Annahda 3', '2015-12-31 03:09:58', 'mido', NULL, NULL),
(166, 'Modification', 'Table des terrains', 'Modification du terrain: Rue El Ouehda 4093 Nador - Projet : Annahda 3', '2015-12-31 03:11:14', 'mido', NULL, NULL),
(167, 'Modification', 'Table des terrains', 'Modification du terrain: Rue El Ouehda 4093 Nador - Projet : Annahda 3', '2015-12-31 03:11:41', 'mido', NULL, NULL),
(168, 'Modification', 'Table des terrains', 'Modification du terrain: Rue El Ouehda 4093 Nador - Projet : Annahda 3', '2015-12-31 03:12:00', 'mido', NULL, NULL),
(169, 'Modification', 'Table des terrains', 'Modification du terrain: Rue El Ouehda 4093 Nador - Projet : Annahda 3', '2015-12-31 03:15:11', 'mido', NULL, NULL),
(170, 'Ajout', 'Table des appartements', 'Ajout de l''appartement : A7 - Projet : Annahda 1', '2015-12-31 03:37:12', 'admin', NULL, NULL),
(171, 'Modification', 'Table des appartements', 'Modification de l''appartement : A7 - Projet : Annahda 1', '2015-12-31 03:38:28', 'admin', NULL, NULL),
(172, 'Modification Status', 'Table des appartements', 'Changement de status de l''appartement A7 vers le status : R&eacute;serv&eacute; - Projet : Annahda 1', '2015-12-31 03:39:07', 'admin', NULL, NULL),
(173, 'Modification Client', 'Table des appartements', 'Changement de rÃ©servation de l''appartement A7 pour  : Ghizlan Meddahi - Projet : Annahda 1', '2015-12-31 03:39:18', 'admin', NULL, NULL),
(174, 'Ajout', 'Table des locaux commerciaux', 'Ajout du local commercial : L5 - Projet : Annahda 1', '2016-01-05 05:07:51', 'admin', NULL, NULL),
(175, 'Ajout', 'Table des locaux commerciaux', 'Ajout du local commercial : L6 - Projet : Annahda 1', '2016-01-05 05:08:09', 'admin', NULL, NULL),
(176, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2016-01-06 11:46:02', 'admin', NULL, NULL),
(177, 'Annulation', 'Table des paiements clients', 'Annulation de paiement client', '2016-01-06 11:46:44', 'admin', NULL, NULL),
(178, 'Modification', 'Table des contrats', 'Modification du contrat dont l''identifiant est : 438 - Projet : Annahda 1', '2016-01-06 12:49:19', 'admin', NULL, NULL),
(179, 'Modification', 'Table des contrats', 'Modification du contrat dont l''identifiant est : 438 - Projet : Annahda 1', '2016-01-06 12:55:00', 'admin', NULL, NULL),
(180, 'Modification', 'Table des contrats', 'Modification du contrat dont l''identifiant est : 438 - Projet : Annahda 1', '2016-01-06 12:59:50', 'admin', NULL, NULL),
(181, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 8 - SociÃ©tÃ© : Iaaza', '2016-01-07 12:15:10', 'user', NULL, NULL),
(182, 'Modification', 'Table des dÃ©tails livraisons', 'Modification de l''article 8 - SociÃ©tÃ© : Iaaza', '2016-01-07 12:15:17', 'user', NULL, NULL),
(183, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 1001, fournisseur : said kemli - Projet : Annahda 3 - SociÃ©tÃ© : Iaaza', '2016-01-07 12:15:32', 'user', NULL, NULL),
(184, 'Modification', 'Table des clients', 'Modifier le client : said el moumni', '2016-01-08 09:58:57', 'admin', NULL, NULL),
(185, 'Modification', 'Table des comptes bancaires', 'Modifier le compte bancaire numÃ©ro : 1230231999990000XD, avec la dÃ©nomination : BP123123', '2016-01-11 10:17:06', 'admin', NULL, NULL),
(186, 'Ajout', 'Table des charges communs', 'Ajout d''une charge de type : Tr&eacute;sorerie, le : 2016-01-11, d''un montant de : 1000, dont la designation est : AZERTYUIOP - Projet : ', '2016-01-11 11:21:19', 'admin', NULL, NULL),
(187, 'Modification', 'Table des charges communs', 'Modification de la charge dont l''identifiant est : 1 de type : Tresorerie, le : 2016-01-11, d''un montant de : 1000.00, dont la designation est : AZERTYUIOP - Projet : ', '2016-01-11 11:24:50', 'admin', NULL, NULL),
(188, 'Ajout', 'Table des charges communs', 'Ajout d''une charge de type : Agence Marchica, le : 2016-01-11, d''un montant de : 3500, dont la designation est : QWERTYUOHK - Projet : ', '2016-01-11 11:25:50', 'admin', NULL, NULL),
(189, 'Ajout', 'Table des charges communs', 'Ajout d''une charge de type : Agence Marchica, le : 2016-01-11, d''un montant de : 1350, dont la designation est : AZEAOZEI - Projet : ', '2016-01-11 11:29:09', 'admin', NULL, NULL),
(190, 'Ajout', 'Table des charges communs', 'Ajout d''une charge de type : Agence Marchica, le : 2016-01-11, d''un montant de : 3230, dont la designation est : AZERPZEOR - Projet : ', '2016-01-11 11:29:26', 'admin', NULL, NULL),
(191, 'Ajout', 'Table des charges communs', 'Ajout d''une charge de type : Tresorerie, le : 2016-01-11, d''un montant de : 1330, dont la designation est : PSDFOSDFL - Projet : ', '2016-01-11 11:29:54', 'admin', NULL, NULL),
(192, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 1001, fournisseur : said kemli - Projet : Annahda 3 - SociÃ©tÃ© : Iaaza', '2016-01-11 12:14:22', 'admin', NULL, NULL),
(193, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 10299, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-01-11 12:27:24', 'admin', NULL, NULL),
(194, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2753 - SociÃ©tÃ© : Annahda', '2016-01-11 12:27:38', 'admin', NULL, NULL),
(195, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 433, montant : 10000', '2016-01-11 12:55:09', 'admin', NULL, NULL),
(196, 'Modification', 'Table des paiements clients', 'Modification du paiement client, montant : 10000', '2016-01-11 12:59:37', 'admin', NULL, NULL),
(197, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 433, montant : 30000', '2016-01-11 01:00:01', 'admin', NULL, NULL),
(198, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 433, montant : 40000', '2016-01-11 01:02:29', 'admin', NULL, NULL),
(199, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 433, montant : 40000', '2016-01-11 01:10:41', 'admin', NULL, NULL),
(200, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 433, montant : 30000', '2016-01-11 02:14:33', 'admin', NULL, NULL),
(201, 'Ajout', 'Table des clients', 'Ajout du client : abdelouahab sekkat', '2016-01-11 02:35:32', 'admin', NULL, NULL),
(202, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 1231230, client : abdelouahab sekkat, localCommercial : 34, prix : 1000000 - Projet : Annahda 1', '2016-01-11 02:36:53', 'admin', NULL, NULL),
(203, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 123021390, client : abdelouahab sekkat, localCommercial : 34, prix : 1000000 - Projet : Annahda 1', '2016-01-11 02:47:26', 'admin', NULL, NULL),
(204, 'Ajout', 'Table des charges', 'Ajout d''une charge de type : NOTAIRE &amp; FRAIS D''ENREGISTREMENT, le : 2016-01-16, d''un montant de : 2000, dont la designation est : GO - Projet : Annahda 1', '2016-01-16 09:25:52', 'admin', NULL, NULL),
(205, 'Ajout', 'Table des charges', 'Ajout d''une charge de type : NOTAIRE-FRAIS-ENREGISTREMENTS, le : 2016-01-16, d''un montant de : 2300, dont la designation est : URU - Projet : Annahda 1', '2016-01-16 09:50:24', 'admin', NULL, NULL),
(206, 'Ajout', 'Table des charges', 'Ajout d''une charge de type : 3, le : 2016-01-18, d''un montant de : 2000, dont la designation est : Test - Projet : Annahda 1', '2016-01-18 04:06:01', 'admin', NULL, NULL),
(207, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 16 de type : 3, le : 2015-12-16, d''un montant de : 2000.00, dont la designation est : Rien - Projet : Annahda 1', '2016-01-18 04:06:59', 'admin', NULL, NULL),
(208, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 17 de type : 3, le : 2015-12-16, d''un montant de : 2000.00, dont la designation est : Rien - Projet : Annahda 1', '2016-01-18 04:07:04', 'admin', NULL, NULL),
(209, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 19 de type : 13, le : 2016-01-16, d''un montant de : 2300.00, dont la designation est : URU - Projet : Annahda 1', '2016-01-18 04:07:35', 'admin', NULL, NULL),
(210, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 4 de type : 2, le : 2015-11-06, d''un montant de : 2000.00, dont la designation est : Abdekader Zlayji - Projet : Annahda 3', '2016-01-18 04:09:20', 'admin', NULL, NULL),
(211, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 7 de type : 2, le : 2015-11-14, d''un montant de : 10000.00, dont la designation est : Rien de sp&eacute;cial - Projet : Annahda 3', '2016-01-18 04:09:32', 'admin', NULL, NULL),
(212, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 11 de type : 2, le : 2015-11-24, d''un montant de : 40000.00, dont la designation est : Beton - Projet : Annahda 3', '2016-01-18 04:09:39', 'admin', NULL, NULL),
(213, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 10 de type : 5, le : 2015-11-24, d''un montant de : 6000.00, dont la designation est : Prime des employ&eacute;s - Projet : Annahda 3', '2016-01-18 04:09:50', 'admin', NULL, NULL),
(214, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 13 de type : 5, le : 2015-11-24, d''un montant de : 2000.00, dont la designation est : Prime des assistantes - Projet : Annahda 3', '2016-01-18 04:09:56', 'admin', NULL, NULL),
(215, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 3 de type : 3, le : 2015-11-01, d''un montant de : 40000.00, dont la designation est : Jamal Guebbas - Projet : Annahda 3', '2016-01-18 04:10:08', 'admin', NULL, NULL),
(216, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 5 de type : 3, le : 2015-11-04, d''un montant de : 3000.00, dont la designation est : Jamal Guebbas - Projet : Annahda 3', '2016-01-18 04:10:14', 'admin', NULL, NULL),
(217, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 14 de type : 6, le : 2015-11-24, d''un montant de : 30000.00, dont la designation est : Levier - Projet : Annahda 3', '2016-01-18 04:10:26', 'admin', NULL, NULL),
(218, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 2 de type : 4, le : 2015-11-02, d''un montant de : 30000.00, dont la designation est : Soci&eacute;t&eacute; Massyn - Projet : Annahda 3', '2016-01-18 04:10:37', 'admin', NULL, NULL),
(219, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 8 de type : 4, le : 2015-11-24, d''un montant de : 12000.00, dont la designation est :  - Projet : Annahda 3', '2016-01-18 04:10:43', 'admin', NULL, NULL),
(220, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 9 de type : 4, le : 2015-11-24, d''un montant de : 1000.00, dont la designation est :  - Projet : Annahda 3', '2016-01-18 04:10:49', 'admin', NULL, NULL),
(221, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 6 de type : 11, le : 2015-11-03, d''un montant de : 3000.00, dont la designation est : Jamal Guebbas - Projet : Annahda 3', '2016-01-18 04:11:09', 'admin', NULL, NULL),
(222, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 15 de type : 9, le : 2015-11-24, d''un montant de : 2000.00, dont la designation est : Publicit&eacute; en ligne  - Projet : Annahda 3', '2016-01-18 04:12:29', 'admin', NULL, NULL),
(223, 'Ajout', 'Table des charges', 'Ajout d''une charge de type : 3, le : 2016-01-18, d''un montant de : 500, dont la designation est : AAA - Projet : Annahda 3', '2016-01-18 04:38:30', 'admin', NULL, NULL),
(224, 'Modification', 'Table des charges communs', 'Modification de la charge dont l''identifiant est : 2 de type : 13, le : 2016-01-11, d''un montant de : 3500.00, dont la designation est : QWERTYUOHK - Projet : ', '2016-01-18 05:16:55', 'admin', NULL, NULL),
(225, 'Modification', 'Table des charges communs', 'Modification de la charge dont l''identifiant est : 3 de type : 13, le : 2016-01-11, d''un montant de : 1350.00, dont la designation est : AZEAOZEI - Projet : ', '2016-01-18 05:17:01', 'admin', NULL, NULL),
(226, 'Modification', 'Table des charges communs', 'Modification de la charge dont l''identifiant est : 4 de type : 13, le : 2016-01-11, d''un montant de : 3230.00, dont la designation est : AZERPZEOR - Projet : ', '2016-01-18 05:17:06', 'admin', NULL, NULL),
(227, 'Modification', 'Table des charges communs', 'Modification de la charge dont l''identifiant est : 1 de type : 12, le : 2016-01-11, d''un montant de : 1000.00, dont la designation est : AZERTYUIOP - Projet : ', '2016-01-18 05:17:18', 'admin', NULL, NULL),
(228, 'Modification', 'Table des charges communs', 'Modification de la charge dont l''identifiant est : 5 de type : 12, le : 2016-01-11, d''un montant de : 1330.00, dont la designation est : PSDFOSDFL - Projet : ', '2016-01-18 05:17:22', 'admin', NULL, NULL),
(229, 'Modification Status Revendre', 'Table des contrats', 'Modification de status Revendement du contrat dont l''identifiant est : 424 - Projet : Annahda 1', '2016-01-18 06:34:30', 'admin', NULL, NULL),
(230, 'Modification Status Revendre', 'Table des contrats', 'Modification de status Revendement du contrat dont l''identifiant est : 424 - Projet : Annahda 1', '2016-01-18 06:36:48', 'admin', NULL, NULL),
(231, 'Modification Status Revendre', 'Table des contrats', 'Modification de status Revendement du contrat dont l''identifiant est : 424 - Projet : Annahda 1', '2016-01-18 06:37:17', 'admin', NULL, NULL),
(232, 'Modification Status Revendre', 'Table des contrats', 'Modification de status Revendement du contrat dont l''identifiant est : 437 - Projet : Annahda 1', '2016-01-18 07:34:00', 'admin', NULL, NULL),
(233, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 12323149, fournisseur : said kemli - Projet : Annahda 1 - SociÃ©tÃ© : Annahda', '2016-01-19 04:54:57', 'admin', NULL, NULL),
(234, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2754 - SociÃ©tÃ© : Annahda', '2016-01-19 04:55:10', 'admin', NULL, NULL),
(235, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 1222, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-01-26 06:11:28', 'admin', NULL, NULL),
(236, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2755 - SociÃ©tÃ© : Annahda', '2016-01-26 06:11:42', 'admin', NULL, NULL),
(237, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 12301239, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-01-26 06:26:51', 'admin', NULL, NULL),
(238, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2756 - SociÃ©tÃ© : Annahda', '2016-01-26 06:27:02', 'admin', NULL, NULL),
(239, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 123, client : said el moumni, appartement : 459, prix : 1000000 - Projet : Annahda 1', '2016-01-26 07:43:43', 'admin', NULL, NULL),
(240, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 123, client : semlali rachid, localCommercial : 33, prix : 1900000 - Projet : Annahda 1', '2016-01-26 08:00:04', 'admin', NULL, NULL),
(241, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 123, client : semlali rachid, appartement : 459, prix : 1000000 - Projet : Annahda 1', '2016-01-26 08:07:35', 'admin', NULL, NULL),
(242, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 441, montant : 10000', '2016-02-01 09:30:44', 'admin', NULL, NULL),
(243, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 441, montant : 10908.3', '2016-02-09 03:59:49', 'admin', NULL, NULL),
(244, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 441, montant : 38235.75', '2016-02-09 04:02:38', 'admin', NULL, NULL),
(245, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 441, montant : 10908.5', '2016-02-10 06:00:07', 'admin', NULL, NULL),
(246, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 441, montant : 10905.1', '2016-02-10 06:02:41', 'admin', NULL, NULL),
(247, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 0000001, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-11 03:01:21', 'admin', NULL, NULL),
(248, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 0000001, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-11 03:12:44', 'admin', NULL, NULL),
(249, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2757 - SociÃ©tÃ© : Annahda', '2016-02-11 03:13:15', 'admin', NULL, NULL),
(250, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 11111, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-11 05:11:30', 'admin', NULL, NULL),
(251, 'Suppression', 'Table des livraisons, Table dÃ©tails livraisons', 'Suppression de la livraison 2759 ainsi que ses dÃ©tails - SociÃ©tÃ© : Annahda', '2016-02-11 05:11:39', 'admin', NULL, NULL),
(252, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 23019, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-11 05:11:50', 'admin', NULL, NULL),
(253, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 23019, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-11 05:12:27', 'admin', NULL, NULL),
(254, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 23019, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-11 05:14:21', 'admin', NULL, NULL),
(255, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 23019, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-11 05:24:18', 'admin', NULL, NULL),
(256, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 23019, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-11 05:25:19', 'admin', NULL, NULL),
(257, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 23019, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-11 05:25:34', 'admin', NULL, NULL),
(258, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 23019, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-11 05:25:43', 'admin', NULL, NULL),
(259, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2760 - SociÃ©tÃ© : Annahda', '2016-02-11 05:27:56', 'admin', NULL, NULL),
(260, 'Modification', 'Table des dÃ©tails livraisons', 'Modification de l''article 709 - SociÃ©tÃ© : Annahda', '2016-02-11 05:30:46', 'admin', NULL, NULL),
(261, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2760 - SociÃ©tÃ© : Annahda', '2016-02-11 05:31:01', 'admin', NULL, NULL),
(262, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2760 - SociÃ©tÃ© : Annahda', '2016-02-11 05:31:19', 'admin', NULL, NULL),
(263, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2760 - SociÃ©tÃ© : Annahda', '2016-02-11 05:33:23', 'admin', NULL, NULL),
(264, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 2760 - SociÃ©tÃ© : Annahda', '2016-02-11 05:38:20', 'admin', NULL, NULL),
(265, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 123, client : souid ahmed ayoub, localCommercial : 33, prix : 1900000 - Projet : Annahda 1', '2016-02-22 05:12:07', 'admin', NULL, NULL),
(266, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 3123, fournisseur : Ste westmat - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-25 03:48:13', 'admin', NULL, NULL),
(267, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 9 - SociÃ©tÃ© : Iaaza', '2016-02-25 03:48:27', 'admin', NULL, NULL),
(268, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 123, fournisseur : Ste westmat - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-25 05:08:00', 'admin', NULL, NULL),
(269, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 123, fournisseur : Ste westmat - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-25 05:08:52', 'admin', NULL, NULL),
(270, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 12, fournisseur : Ste westmat - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-25 05:10:40', 'admin', NULL, NULL),
(271, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 12 - SociÃ©tÃ© : Iaaza', '2016-02-25 05:10:52', 'admin', NULL, NULL),
(272, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 12, fournisseur : Ste westmat - Projet : Annahda 1 - SociÃ©tÃ© : Iaaza', '2016-02-25 05:12:05', 'admin', NULL, NULL),
(273, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : 12, fournisseur : Ste westmat - Projet : Annahda 1 - SociÃ©tÃ© : Iaaza', '2016-02-25 05:14:26', 'admin', NULL, NULL),
(274, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 12, fournisseur : Ste guarimetal - Projet :  - SociÃ©tÃ© : Annahda', '2016-02-25 05:21:56', 'admin', NULL, NULL),
(275, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 13 - SociÃ©tÃ© : Iaaza', '2016-02-25 05:22:06', 'admin', NULL, NULL),
(276, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 10 - SociÃ©tÃ© : Iaaza', '2016-02-25 05:25:19', 'admin', NULL, NULL),
(277, 'Ajout', 'Table des dÃ©tails livraisons', 'Ajout d''un article Ã  la livraison : 11 - SociÃ©tÃ© : Iaaza', '2016-02-25 05:25:38', 'admin', NULL, NULL),
(278, 'Ajout', 'Table des rÃ©glements fournisseurs Iaaza', 'Ajout du rÃ©glement, montant : 10000, fournisseur : Ste guarimetal - SociÃ©tÃ© : Iaaza', '2016-02-25 05:26:10', 'admin', NULL, NULL),
(279, 'Ajout', 'Table des rÃ©glements fournisseurs Iaaza', 'Ajout du rÃ©glement, montant : 10000, fournisseur : Ste westmat - SociÃ©tÃ© : Iaaza', '2016-02-25 05:26:42', 'admin', NULL, NULL),
(280, 'Ajout', 'Table des appartements', 'Ajout de l''appartement : AZZER - Projet : Annahda 1', '2016-02-25 06:08:31', 'admin', NULL, NULL),
(281, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 123, client : amin chemlal, appartement : 460, prix : 730000 - Projet : Annahda 1', '2016-02-25 06:09:43', 'admin', NULL, NULL),
(282, 'DÃ©sistement', 'Table des contrats', 'DÃ©sistement du contrat dont l''identifiant est : 443 - Projet : Annahda 1', '2016-02-26 01:14:43', 'admin', NULL, NULL),
(283, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 1092929, client : aassou mohamed, appartement : 460, prix : 730000 - Projet : Annahda 1', '2016-02-26 01:15:51', 'admin', NULL, NULL),
(284, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-02-26, d''un montant de : 100DH, en dÃ©signation : AZERTY', '2016-02-26 04:43:09', 'admin', NULL, NULL),
(285, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Sortie, le 2016-02-26, d''un montant de : 300DH, en dÃ©signation : QWERTY', '2016-02-26 04:43:26', 'admin', NULL, NULL),
(286, 'Modification', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 1, de type : Sortie, le 2015-12-22, d''un montant de : 1200DH, en dÃ©signation : Salim', '2016-02-26 06:22:12', 'admin', NULL, NULL),
(287, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-02-26, d''un montant de : 300000000DH, en dÃ©signation : WOW', '2016-02-26 06:23:18', 'admin', NULL, NULL),
(288, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-02-26, d''un montant de : 200DH, en dÃ©signation : Ram', '2016-02-26 06:24:07', 'admin', NULL, NULL),
(289, 'Modification', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 4, de type : Entree, le 2016-02-10, d''un montant de : 300000000.00DH, en dÃ©signation : WOW', '2016-02-26 06:24:18', 'admin', NULL, NULL),
(290, 'Modification', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 4, de type : Sortie, le 2016-02-10, d''un montant de : 300000000.00DH, en dÃ©signation : WOW', '2016-02-26 06:24:28', 'admin', NULL, NULL),
(291, 'Suppression', 'Table de caisse', 'Suppression de l''opÃ©ration dont l''identifiant est : 4, de type : Sortie, le 2016-02-10, d''un montant de : DH, en dÃ©signation : WOW', '2016-02-26 06:24:36', 'admin', NULL, NULL),
(292, 'Suppression', 'Table de caisse', 'Suppression de l''opÃ©ration dont l''identifiant est : 5, de type : Entree, le 2016-02-26, d''un montant de : DH, en dÃ©signation : Ram', '2016-02-26 06:24:50', 'admin', NULL, NULL);
INSERT INTO `t_history` (`id`, `action`, `target`, `description`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(293, 'Modification', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 13, de type : Entree, le 2016-02-26, d''un montant de : 200DH, en dÃ©signation : AZERTY', '2016-02-26 06:25:12', 'admin', NULL, NULL),
(294, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 444, montant : 10000', '2016-02-27 05:53:17', 'admin', NULL, NULL),
(295, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 444, montant : 10000', '2016-02-27 05:59:07', 'admin', NULL, NULL),
(296, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 444, montant : 10780', '2016-02-27 06:43:10', 'admin', NULL, NULL),
(297, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 444, montant : 21720', '2016-02-27 06:43:44', 'admin', NULL, NULL),
(298, 'Modification Status Revendre', 'Table des contrats', 'Modification de status Revendement du contrat dont l''identifiant est : 444 - Projet : Annahda 1', '2016-03-01 07:11:14', 'admin', NULL, NULL),
(299, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-03-02, d''un montant de : 100DH, en dÃ©signation : test', '2016-03-02 10:27:11', 'admin', NULL, NULL),
(300, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-01-13, d''un montant de : 100DH, en dÃ©signation : kfk', '2016-03-02 10:27:26', 'admin', NULL, NULL),
(301, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2015-04-08, d''un montant de : 100DH, en dÃ©signation : test', '2016-03-02 10:27:45', 'admin', NULL, NULL),
(302, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2015-10-07, d''un montant de : 100DH, en dÃ©signation : test', '2016-03-02 10:28:16', 'admin', NULL, NULL),
(303, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2015-04-09, d''un montant de : 200DH, en dÃ©signation : jgi', '2016-03-02 10:28:34', 'admin', NULL, NULL),
(304, 'Modification', 'Table des contrats', 'Modification du contrat dont l''identifiant est : 440 - Projet : Annahda 1', '2016-03-07 01:12:33', 'admin', NULL, NULL),
(305, 'Annulation', 'Table des paiements clients', 'Annulation de paiement client', '2016-03-07 03:59:22', 'admin', NULL, NULL),
(306, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2016-03-07 03:59:26', 'admin', NULL, NULL),
(307, 'Retirage', 'Table des paiements clients', 'Retirage de paiement client de la page des Ã©tats des paiements', '2016-03-07 03:59:47', 'admin', NULL, NULL),
(308, 'Ajout', 'Table des appartements', 'Ajout de l''appartement : ADFR - Projet : Annahda 1', '2016-03-07 04:43:31', 'admin', NULL, NULL),
(309, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-03-08 04:01:07', 'admin', NULL, NULL),
(310, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-03-08 04:01:17', 'admin', NULL, NULL),
(311, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-03-08 04:01:24', 'admin', NULL, NULL),
(312, 'Ajout', 'Table des charges communs', 'Ajout d''une charge de type : 14, le : 2016-03-14, d''un montant de : 1200, dont la designation est : test - Projet : ', '2016-03-14 09:45:16', 'admin', NULL, NULL),
(313, 'Suppression', 'Table des livraisons, Table dÃ©tails livraisons', 'Suppression de la livraison  ainsi que ses dÃ©tails - SociÃ©tÃ© : Annahda', '2016-03-17 03:20:26', 'admin', NULL, NULL),
(314, 'Suppression', 'Table des livraisons, Table dÃ©tails livraisons', 'Suppression de la livraison  ainsi que ses dÃ©tails - SociÃ©tÃ© : Annahda', '2016-03-17 03:24:46', 'admin', NULL, NULL),
(315, 'Suppression', 'Table des livraisons, Table dÃ©tails livraisons', 'Suppression de la livraison  ainsi que ses dÃ©tails - SociÃ©tÃ© : Annahda', '2016-03-17 03:30:16', 'admin', NULL, NULL),
(316, 'Modification', 'Table des contrats', 'Modification du contrat dont l''identifiant est : 444 - Projet : Annahda 1', '2016-03-30 04:55:08', 'admin', NULL, NULL),
(317, 'Ajout', 'Table des charges', 'Ajout d''une charge de type : 3, le : 2016-03-31, d''un montant de : 1000, dont la designation est : TEST - Projet : Annahda 1', '2016-03-31 01:00:32', 'admin', NULL, NULL),
(318, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2016-03-31 01:10:56', 'admin', NULL, NULL),
(319, 'Retirage', 'Table des paiements clients', 'Retirage de paiement client de la page des Ã©tats des paiements', '2016-03-31 01:11:07', 'admin', NULL, NULL),
(320, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2016-04-26 05:07:54', 'abdessamad', NULL, NULL),
(321, 'Validation', 'Table des paiements clients', 'Validation de paiement client', '2016-04-26 05:08:55', 'abdessamad', NULL, NULL),
(322, 'Modification Status Revendre', 'Table des contrats', 'Modification de status Revendement du contrat dont l''identifiant est : 442 - Projet : Annahda 1', '2016-04-26 05:40:40', 'abdessamad', NULL, NULL),
(323, 'Ajout', 'Table des charges communs', 'Ajout d''une charge de type : 14, le : 2016-05-09, d''un montant de : 2000, dont la designation est : Rien - Projet : ', '2016-05-09 05:33:00', 'admin', NULL, NULL),
(324, 'Modification', 'Table des charges communs', 'Modification de la charge : Publicite de type : 14, le : 2016-05-09, d''un montant de : 2000.00, dont la designation est : AKKKKKKKKKKKKKK - Projet : ', '2016-05-09 05:34:59', 'admin', NULL, NULL),
(325, 'Ajout', 'Table des charges communs', 'Ajout d''une charge de type : Agence Marchica, le : 2016-05-09, d''un montant de : 200, dont la designation est : zkejrhzjer - Projet : ', '2016-05-09 05:36:29', 'admin', NULL, NULL),
(326, 'Suppression', 'Table des charges', 'Suppression de la charge dont l''identifiant est : 10 de type : 14, le : 2016-05-09, d''un montant de : 2000.00, dont la designation est : AKKKKKKKKKKKKKK - Projet : ', '2016-05-09 05:38:22', 'admin', NULL, NULL),
(327, 'Suppression', 'Table des charges', 'Suppression de la charge dont l''identifiant est : 7 de type : Publicite, le : 0000-00-00, d''un montant de : 26880.00, dont la designation est : CHEQUE N 1175991 PAYE EN FAVEUR DE STE LABORATOIRE L.E.E.G.I SAR - Projet : ', '2016-05-09 05:38:56', 'admin', NULL, NULL),
(328, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 23 de type : 11, le : 2016-03-09, d''un montant de : 1500.00, dont la designation est : PAIEMENT DE TAXE VEHICULES AUTOMOBILES/ vignette PIK UP - Projet : Annahda 1', '2016-05-09 05:41:31', 'admin', NULL, NULL),
(329, 'Ajout', 'Table des charges', 'Ajout d''une charge de type : TESTRON, le : 2016-05-09, d''un montant de : 1, dont la designation est : A - Projet : Annahda 1', '2016-05-09 05:45:08', 'admin', NULL, NULL),
(330, 'Ajout', 'Table des charges', 'Ajout d''une charge de type : TESTRON, le : 2016-05-09, d''un montant de : 1, dont la designation est : A - Projet : Annahda 1', '2016-05-09 05:46:06', 'admin', NULL, NULL),
(331, 'Ajout', 'Table des charges', 'Ajout d''une charge de type : RRRRRRRR, le : 2016-05-09, d''un montant de : 12, dont la designation est : A - Projet : Annahda 1', '2016-05-09 05:47:28', 'admin', NULL, NULL),
(332, 'Suppression', 'Table des charges', 'Suppression de la charge dont l''identifiant est : 16 de type : , le : , d''un montant de : , dont la designation est :  - Projet : Annahda 1', '2016-05-09 05:50:18', 'admin', NULL, NULL),
(333, 'Suppression', 'Table des charges', 'Suppression de la charge dont l''identifiant est : 17 de type : Finition, le : 2015-12-16, d''un montant de : 2000.00, dont la designation est : Rien - Projet : Annahda 1', '2016-05-09 05:50:25', 'admin', NULL, NULL),
(334, 'Suppression', 'Table des charges', 'Suppression de la charge dont l''identifiant est : 20 de type : Finition, le : 2016-01-18, d''un montant de : 2000.00, dont la designation est : Test - Projet : Annahda 1', '2016-05-09 05:50:52', 'admin', NULL, NULL),
(335, 'Modification', 'Table des charges', 'Modification de la charge dont l''identifiant est : 22 de type : Finition, le : 2016-03-31, d''un montant de : 1000.00, dont la designation est : AZERT - Projet : Annahda 1', '2016-05-09 05:51:20', 'admin', NULL, NULL),
(336, 'Modification PiÃ¨ce rÃ©glement', 'Table des rÃ©glements clients', 'Modification de la piÃ¨ce de rÃ©gelement - OpÃ©ration : 1712', '2016-05-16 05:36:55', 'admin', NULL, NULL),
(337, 'Modification PiÃ¨ce rÃ©glement', 'Table des rÃ©glements clients', 'Modification de la piÃ¨ce de rÃ©gelement - OpÃ©ration : 1712', '2016-05-16 05:40:15', 'admin', NULL, NULL),
(338, 'Modification PiÃ¨ce rÃ©glement', 'Table des rÃ©glements clients', 'Modification de la piÃ¨ce de rÃ©gelement - OpÃ©ration : 1712', '2016-05-16 05:40:56', 'admin', NULL, NULL),
(339, 'Modification PiÃ¨ce rÃ©glement', 'Table des rÃ©glements clients', 'Modification de la piÃ¨ce de rÃ©gelement - OpÃ©ration : 1712', '2016-05-16 05:42:19', 'admin', NULL, NULL),
(340, 'Modification PiÃ¨ce rÃ©glement', 'Table des rÃ©glements clients', 'Modification de la piÃ¨ce de rÃ©gelement - OpÃ©ration : 1712', '2016-05-16 05:42:53', 'admin', NULL, NULL),
(341, 'Modification PiÃ¨ce rÃ©glement', 'Table des rÃ©glements clients', 'Modification de la piÃ¨ce de rÃ©gelement - OpÃ©ration : 1711', '2016-05-16 05:43:56', 'admin', NULL, NULL),
(342, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 444, montant : 12', '2016-05-16 05:44:49', 'admin', NULL, NULL),
(343, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 444, montant : 123', '2016-05-16 05:48:12', 'admin', NULL, NULL),
(344, 'Modification PiÃ¨ce rÃ©glement', 'Table des rÃ©glements clients', 'Modification de la piÃ¨ce de rÃ©gelement - OpÃ©ration : 1714', '2016-05-16 05:49:44', 'admin', NULL, NULL),
(345, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 444, montant : 123', '2016-05-16 05:50:09', 'admin', NULL, NULL),
(346, 'Modification PiÃ¨ce rÃ©glement', 'Table des rÃ©glements clients', 'Modification de la piÃ¨ce de rÃ©gelement - OpÃ©ration : 1715', '2016-05-17 11:32:31', 'admin', NULL, NULL),
(347, 'Ajout', 'Table des clients', 'Ajout du client : afelouat othman', '2016-05-26 06:56:11', 'admin', NULL, NULL),
(348, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 3020, client : afelouat othman, appartement : 461, prix : 880000 - Projet : Annahda 1', '2016-05-26 07:00:46', 'admin', NULL, NULL),
(349, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 120120, client : afelouat othman, appartement : 461, prix : 880000 - Projet : Annahda 1', '2016-05-26 07:07:53', 'admin', NULL, NULL),
(350, 'DÃ©sistement', 'Table des contrats', 'DÃ©sistement du contrat dont l''identifiant est : 445 - Projet : Annahda 1', '2016-05-26 07:44:12', 'admin', NULL, NULL),
(351, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 12301230, client : afelouat othman, appartement : 461, prix : 880000 - Projet : Annahda 1', '2016-05-26 07:46:25', 'admin', NULL, NULL),
(352, 'DÃ©sistement', 'Table des contrats', 'DÃ©sistement du contrat dont l''identifiant est : 446 - Projet : Annahda 1', '2016-05-26 07:51:26', 'admin', NULL, NULL),
(353, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 90202, client : afelouat othman, appartement : 461, prix : 880000 - Projet : Annahda 1', '2016-05-26 07:53:39', 'admin', NULL, NULL),
(354, 'Modification de status', 'Table des rÃ©glements prÃ©vus', 'Modifier les status d''un rÃ©glement prÃ©vu', '2016-06-08 03:26:59', 'admin', NULL, NULL),
(355, 'Suppression', 'Table des paiements clients', 'Suppression de paiement client', '2016-06-08 03:27:36', 'admin', NULL, NULL),
(356, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 06:55:24', 'admin', NULL, NULL),
(357, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 06:55:34', 'admin', NULL, NULL),
(358, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 06:55:58', 'admin', NULL, NULL),
(359, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 06:56:06', 'admin', NULL, NULL),
(360, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 06:56:13', 'admin', NULL, NULL),
(361, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 06:58:15', 'admin', NULL, NULL),
(362, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 06:58:29', 'admin', NULL, NULL),
(363, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 07:02:35', 'admin', NULL, NULL),
(364, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 07:02:42', 'admin', NULL, NULL),
(365, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 07:02:54', 'admin', NULL, NULL),
(366, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 07:08:07', 'admin', NULL, NULL),
(367, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 07:08:13', 'admin', NULL, NULL),
(368, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 07:08:21', 'admin', NULL, NULL),
(369, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 07:08:26', 'admin', NULL, NULL),
(370, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-06-16 07:10:40', 'admin', NULL, NULL),
(371, 'Ajout', 'Table des appartements', 'Ajout de l''appartement : A11 - Projet : Annahda 2', '2016-07-13 03:34:03', 'admin', NULL, NULL),
(372, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 191200, client : mohamed el khattabi, appartement : 462, prix : 790000 - Projet : Annahda 2', '2016-07-13 04:11:28', 'admin', NULL, NULL),
(373, 'DÃ©sistement', 'Table des contrats', 'DÃ©sistement du contrat dont l''identifiant est : 448 - Projet : Annahda 2', '2016-07-13 04:30:44', 'admin', NULL, NULL),
(374, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 111111111, client : mohamed el khattabi, appartement : 462, prix : 790000 - Projet : Annahda 2', '2016-07-13 04:35:34', 'admin', NULL, NULL),
(375, 'Modification', 'Table des contrats', 'Modification du contrat dont l''identifiant est : 449 - Projet : Annahda 2', '2016-07-13 04:37:25', 'admin', NULL, NULL),
(376, 'Modification', 'Table des contrats', 'Modification du contrat dont l''identifiant est : 449 - Projet : Annahda 2', '2016-07-13 04:55:07', 'admin', NULL, NULL),
(377, 'DÃ©sistement', 'Table des contrats', 'DÃ©sistement du contrat dont l''identifiant est : 449 - Projet : Annahda 2', '2016-07-13 05:01:17', 'admin', NULL, NULL),
(378, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 34343434, client : mohamed el khattabi, appartement : 462, prix : 790000 - Projet : Annahda 2', '2016-07-13 05:05:17', 'admin', NULL, NULL),
(379, 'DÃ©sistement', 'Table des contrats', 'DÃ©sistement du contrat dont l''identifiant est : 436 - Projet : Annahda 2', '2016-07-20 07:41:22', 'admin', NULL, NULL),
(380, 'Activation', 'Table des contrats', 'Activer un contrat', '2016-07-20 07:41:37', 'admin', NULL, NULL),
(381, 'Suppression', 'Table des contrats', 'Suppression du contrat dont l''identifiant est : 448 - Projet : Annahda 2', '2016-07-20 07:58:30', 'admin', NULL, NULL),
(382, 'Modification', 'Table des contrats', 'Modification du contrat dont l''identifiant est : 442 - Projet : Annahda 1', '2016-07-22 01:18:13', 'admin', NULL, NULL),
(383, 'Modification', 'Table des contrats', 'Modification du contrat dont l''identifiant est : 442 - Projet : Annahda 1', '2016-07-22 01:18:59', 'admin', NULL, NULL),
(384, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 101, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-07-25 12:34:13', 'admin', NULL, NULL),
(385, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 102, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-07-25 12:34:51', 'admin', NULL, NULL),
(386, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : 103, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-07-25 12:35:36', 'admin', NULL, NULL),
(387, 'Ajout', 'Table des appartements', 'Ajout de l''appartement : A107 - Projet : ImmoERP 1', '2016-07-25 12:59:00', 'admin', NULL, NULL),
(388, 'Ajout', 'Table des contrats', 'Ajout du contrat numÃ©ro : 11111, client : semlali jamal, appartement : 463, prix : 660000 - Projet : ImmoERP 1', '2016-07-25 01:16:36', 'admin', NULL, NULL),
(389, 'Ajout', 'Table des paiements clients ', 'Ajout d''un paiement client, pour le contrat : 451, montant : 200000', '2016-07-25 01:21:11', 'admin', NULL, NULL),
(390, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-07-25 01:34:38', 'admin', NULL, NULL),
(391, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-08-08, d''un montant de : 100DH, en dÃ©signation : Test de ImmoERPV2', '2016-08-08 08:28:30', 'admin', NULL, NULL),
(392, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-08-08, d''un montant de : 200DH, en dÃ©signation : Test de ImmoERPV2', '2016-08-08 08:29:12', 'admin', NULL, NULL),
(393, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-06-02, d''un montant de : 300DH, en dÃ©signation : Test ImmoERPV2', '2016-08-08 08:41:07', 'admin', NULL, NULL),
(394, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Sortie, le 2016-08-08, d''un montant de : 200DH, en dÃ©signation : Test 2 ImmoERPV2 ', '2016-08-08 08:43:47', 'admin', NULL, NULL),
(395, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Sortie, le 2016-07-08, d''un montant de : 300DH, en dÃ©signation : Test 2 ImmoERPV2', '2016-08-08 08:45:45', 'admin', NULL, NULL),
(396, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-07-21, d''un montant de : 1000DH, en dÃ©signation : Test ImmoERPV2', '2016-08-09 12:14:46', 'admin', NULL, NULL),
(397, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Sortie, le 2016-07-20, d''un montant de : 140DH, en dÃ©signation : Sidi Ali + Dejeuner', '2016-08-09 12:15:27', 'admin', NULL, NULL),
(398, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-08-09, d''un montant de : 1111111111111DH, en dÃ©signation : rrrrrrrrrrrrrrrrrrrrrrr', '2016-08-09 12:18:14', 'admin', NULL, NULL),
(399, 'Suppression', 'Table de caisse', 'Suppression de l''opÃ©ration dont l''identifiant est : 26, de type : Entree, le 2016-08-09, d''un montant de : DH, en dÃ©signation : rrrrrrrrrrrrrrrrrrrrrrr', '2016-08-09 12:18:32', 'admin', NULL, NULL),
(400, 'Modification', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 22, de type : Sortie, le 2016-08-08, d''un montant de : 200.00DH, en dÃ©signation : Test  ImmoERPV2 ', '2016-08-09 12:20:22', 'admin', NULL, NULL),
(401, 'Modification', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 20, de type : Entree, le 2016-08-08, d''un montant de : 150DH, en dÃ©signation : Test de ImmoERPV2', '2016-08-09 12:20:37', 'admin', NULL, NULL),
(402, 'Modification', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 22, de type : Sortie, le 2016-08-08, d''un montant de : 200.00DH, en dÃ©signation : Test de ImmoERPV2 ', '2016-08-09 12:23:21', 'admin', NULL, NULL),
(403, 'Modification', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 22, de type : Sortie, le 2016-08-08, d''un montant de : 260.00DH, en dÃ©signation : Test de ImmoERPV2 ', '2016-08-09 12:23:33', 'admin', NULL, NULL),
(404, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-08-09, d''un montant de : 2000DH, en dÃ©signation : EEEEEE', '2016-08-09 12:24:38', 'admin', NULL, NULL),
(405, 'Modification', 'Table de caisse', 'Modification de l''opÃ©ration dont l''identifiant est : 27, de type : Entree, le 2016-08-09, d''un montant de : 20DH, en dÃ©signation : EEEEEE', '2016-08-09 12:24:54', 'admin', NULL, NULL),
(406, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-08-09, d''un montant de : 20DH, en dÃ©signation : AAAAAAAAAAAAA', '2016-08-09 12:25:09', 'admin', NULL, NULL),
(407, 'Suppression', 'Table de caisse', 'Suppression de l''opÃ©ration dont l''identifiant est : 27, de type : Entree, le 2016-08-09, d''un montant de : DH, en dÃ©signation : EEEEEE', '2016-08-09 12:25:14', 'admin', NULL, NULL),
(408, 'Suppression', 'Table de caisse', 'Suppression de l''opÃ©ration dont l''identifiant est : 28, de type : Entree, le 2016-08-09, d''un montant de : DH, en dÃ©signation : AAAAAAAAAAAAA', '2016-08-09 12:25:17', 'admin', NULL, NULL),
(409, 'Ajout', 'Table des livraisons', 'Ajout de la livraison, libelle : BL101, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-08-09 08:18:54', 'admin', NULL, NULL),
(410, 'Ajout', 'Table des fournisseurs', 'Ajout du fournisseur : Jebbari Moustafa', '2016-08-23 04:11:14', 'admin', NULL, NULL),
(411, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-10-26, d''un montant de : 120DH, en dÃ©signation : Rien', '2016-10-26 11:50:57', 'admin', NULL, NULL),
(412, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-10-26, d''un montant de : 2000DH, en dÃ©signation : Plus', '2016-10-26 12:08:40', 'admin', NULL, NULL),
(413, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Sortie, le 2016-10-26, d''un montant de : 1200DH, en dÃ©signation : Achats de ...', '2016-10-26 12:09:55', 'admin', NULL, NULL),
(414, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-10-26, d''un montant de : 350DH, en dÃ©signation : Mortgage', '2016-10-26 12:10:44', 'admin', NULL, NULL),
(415, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Sortie, le 2016-10-26, d''un montant de : 2350DH, en dÃ©signation : Fourniture (2PC+Imprimante)', '2016-10-26 12:11:12', 'admin', NULL, NULL),
(416, 'Ajout', 'Table de caisse', 'Ajout d''une opÃ©ration de type : Entree, le 2016-10-26, d''un montant de : 200DH, en dÃ©signation : Achat des cartes de recharges INWI', '2016-10-26 04:53:02', 'admin', NULL, NULL),
(417, 'Suppression', 'Table de caisse', 'Suppression de l''opÃ©ration dont l''identifiant est : 31, de type : Entree, le 2016-10-26, d''un montant de : DH, en dÃ©signation : Achat des cartes de recharges INWI', '2016-10-26 04:53:16', 'admin', NULL, NULL),
(418, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : BL101A, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-10-27 11:44:19', 'admin', NULL, NULL),
(419, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : BL101, fournisseur : said kemli - Projet :  - SociÃ©tÃ© : Annahda', '2016-10-27 11:45:43', 'admin', NULL, NULL),
(420, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : BL101, fournisseur : said kemli - Projet : ImmoERP 1 - SociÃ©tÃ© : Annahda', '2016-10-27 12:05:34', 'admin', NULL, NULL),
(421, 'Modification', 'Table des livraisons', 'Modification du status de la livraison, idLivraison : ', '2016-10-27 01:42:11', 'admin', NULL, NULL),
(422, 'Modification', 'Table des livraisons', 'Modification de la livraison, libelle : BL101, fournisseur : said kemli - Projet : Al Matar Iskan - SociÃ©tÃ© : Annahda', '2016-10-27 03:29:50', 'admin', NULL, NULL),
(423, 'Modification', 'Table des rÃ©glements fournisseurs Annahda', 'Modification du rÃ©glement, montant : 4000, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2016-10-27 04:42:57', 'admin', NULL, NULL),
(424, 'Modification', 'Table des rÃ©glements fournisseurs Annahda', 'Modification du rÃ©glement, montant : 4000.00, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2016-10-27 04:43:12', 'admin', NULL, NULL),
(425, 'Modification', 'Table des rÃ©glements fournisseurs Annahda', 'Modification du rÃ©glement, montant : 4000.00, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2016-10-27 04:43:57', 'admin', NULL, NULL),
(426, 'Ajout', 'Table des rÃ©glements fournisseurs Annahda', 'Ajout du rÃ©glement, montant : 5000, fournisseur : said kemli - SociÃ©tÃ© : Annahda', '2016-10-27 04:44:29', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_livraison`
--

CREATE TABLE IF NOT EXISTS `t_livraison` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `designation` text NOT NULL,
  `quantite` decimal(12,2) NOT NULL,
  `prixUnitaire` decimal(10,2) NOT NULL,
  `paye` decimal(10,2) NOT NULL,
  `reste` decimal(10,2) NOT NULL,
  `dateLivraison` date NOT NULL,
  `modePaiement` varchar(50) NOT NULL,
  `idFournisseur` int(11) NOT NULL,
  `idProjet` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `companyID` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2765 ;

--
-- Contenu de la table `t_livraison`
--

INSERT INTO `t_livraison` (`id`, `libelle`, `status`, `type`, `designation`, `quantite`, `prixUnitaire`, `paye`, `reste`, `dateLivraison`, `modePaiement`, `idFournisseur`, `idProjet`, `code`, `companyID`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(2745, '1000200', 0, 1, '', '0.00', '0.00', '0.00', '0.00', '2015-11-19', '', 22, 21, '564ddf0e0234120151119153910', 2, NULL, NULL, NULL, NULL),
(2732, '40999', 0, 1, '', '0.00', '0.00', '0.00', '0.00', '2015-10-20', '', 20, 16, '5626c71b7e74a20151020225835', 2, NULL, NULL, '2015-11-17 03:46:50', 'admin'),
(2736, '120009', 0, 1, '', '0.00', '0.00', '0.00', '0.00', '2015-11-16', '', 19, 15, '5649fa19234a620151116164529', 1, NULL, NULL, '2015-11-17 04:06:24', 'admin'),
(2734, '90812', 0, 1, '', '0.00', '0.00', '0.00', '0.00', '2015-10-24', '', 20, 15, '562b64670170f20151024105847', 1, NULL, NULL, '2015-11-17 03:49:13', 'admin'),
(2735, '12089', 0, 1, '', '0.00', '0.00', '0.00', '0.00', '2015-10-26', '', 20, 15, '562e5e95ed10a20151026171045', 1, NULL, NULL, '2015-11-17 03:46:39', 'admin'),
(2737, '1070', 0, 2, '', '0.00', '0.00', '0.00', '0.00', '2015-11-16', '', 20, 18, '5649fff07628e20151116171024', 3, NULL, NULL, '2015-11-17 04:50:55', 'admin'),
(2738, '600300', 0, 2, '', '0.00', '0.00', '0.00', '0.00', '2015-11-16', '', 19, 15, '564a058e927ff20151116173422', 1, NULL, NULL, '2015-11-16 06:00:27', 'admin'),
(2739, '1186', 0, 2, '', '0.00', '0.00', '0.00', '0.00', '2015-11-17', '', 20, 15, '564b290e4827020151117141806', 1, NULL, NULL, NULL, NULL),
(2740, '111094', 0, 2, '', '0.00', '0.00', '0.00', '0.00', '2015-11-16', '', 19, 18, '564b295265bae20151117141914', 3, NULL, NULL, '2015-11-17 04:50:35', 'admin'),
(2741, '1010', 0, 2, '', '0.00', '0.00', '0.00', '0.00', '2015-11-17', '', 20, 15, '564b3daae95c320151117154602', 1, NULL, NULL, NULL, NULL),
(2744, '1986450', 0, 2, '', '0.00', '0.00', '0.00', '0.00', '2015-11-18', '', 22, 15, '564caf77ecad320151118180351', 1, NULL, NULL, NULL, NULL),
(2746, '100890', 0, 2, '', '0.00', '0.00', '0.00', '0.00', '2015-11-19', '', 22, 15, '564de4ff8a7b620151119160431', 1, NULL, NULL, NULL, NULL),
(2747, '102542', 0, 1, '', '0.00', '0.00', '0.00', '0.00', '2015-11-23', '', 22, 15, '5652ebe3137b820151123113515', 1, NULL, NULL, '2015-12-05 12:33:56', 'mouaad'),
(2748, '500016', 0, 1, '', '0.00', '0.00', '0.00', '0.00', '2015-10-06', '', 22, 15, '5652ec15c822220151123113605', 1, NULL, NULL, NULL, NULL),
(2749, '1230129', 0, 1, '', '0.00', '0.00', '0.00', '0.00', '2015-12-05', '', 22, 15, '5662cbb2bba3b20151205123410', 1, NULL, NULL, NULL, NULL),
(2750, '1', 0, NULL, '', '0.00', '0.00', '0.00', '0.00', '2015-12-15', '', 28, 15, '566ff35ed0ae720151215120254', 1, NULL, NULL, NULL, NULL),
(2751, '200', 0, NULL, '', '0.00', '0.00', '0.00', '0.00', '2015-12-17', '', 29, 15, '56729e32e210620151217123618', 1, NULL, NULL, NULL, NULL),
(2752, '300', 0, NULL, '', '0.00', '0.00', '0.00', '0.00', '2015-12-17', '', 28, 15, '56729e85b4d9520151217123741', 1, NULL, NULL, NULL, NULL),
(2753, '10299', 0, NULL, 'TEST123', '0.00', '0.00', '0.00', '0.00', '2016-01-11', '', 29, 0, '5693919c7965a20160111122724', 1, NULL, NULL, NULL, NULL),
(2754, '12323149', 0, NULL, 'Test', '0.00', '0.00', '0.00', '0.00', '2016-02-10', '', 29, 15, '569e5c51c9d6a20160119165457', 1, NULL, NULL, NULL, NULL),
(2755, '1222', 0, NULL, 'rien de rien', '0.00', '0.00', '0.00', '0.00', '2016-03-01', '', 29, 0, '56a7a8c08953420160126181128', 1, NULL, NULL, NULL, NULL),
(2756, '12301239', 0, NULL, 'BL123', '0.00', '0.00', '0.00', '0.00', '2016-01-26', '', 29, 0, '56a7ac5b5375c20160126182651', 1, NULL, NULL, NULL, NULL),
(2757, '0000001', 0, NULL, 'PPPPPPPPPPPPPP', '0.00', '0.00', '0.00', '0.00', '2016-02-11', '', 29, 0, '56bc9431623f120160211150121', 1, NULL, NULL, NULL, NULL),
(2758, '0000001', 0, NULL, 'PPPPPPPPPPPPPP', '0.00', '0.00', '0.00', '0.00', '2016-02-11', '', 29, 0, '56bc96dc950be20160211151244', 1, NULL, NULL, NULL, NULL),
(2760, '23019', 1, NULL, '', '0.00', '0.00', '0.00', '0.00', '2016-03-03', '', 29, 0, '56bcb2c6ca73320160211171150', 1, NULL, NULL, '2016-02-11 05:25:43', 'admin'),
(2761, '101', 1, NULL, 'CPJ', '0.00', '0.00', '0.00', '0.00', '2016-07-25', '', 29, 0, '5795eb25a6bae20160725123413', 1, NULL, NULL, NULL, NULL),
(2762, '102', NULL, NULL, 'btn', '0.00', '0.00', '0.00', '0.00', '2016-07-25', '', 29, 0, '5795eb4bd1fcd20160725123451', 1, NULL, NULL, NULL, NULL),
(2763, '103', NULL, NULL, 'pvc', '0.00', '0.00', '0.00', '0.00', '2016-07-25', '', 29, 0, '5795eb7827f3b20160725123536', 1, NULL, NULL, NULL, NULL),
(2764, 'BL101', 1, NULL, 'Blour 12', '0.00', '0.00', '0.00', '0.00', '2016-08-09', '', 29, 15, '57aa1e8e11fc220160809201854', 1, NULL, NULL, '2016-10-27 03:29:50', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `t_livraison_detail`
--

CREATE TABLE IF NOT EXISTS `t_livraison_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(2) DEFAULT NULL,
  `designation` text,
  `prixUnitaire` decimal(12,2) DEFAULT NULL,
  `quantite` decimal(12,2) DEFAULT NULL,
  `idLivraison` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=719 ;

--
-- Contenu de la table `t_livraison_detail`
--

INSERT INTO `t_livraison_detail` (`id`, `type`, `designation`, `prixUnitaire`, `quantite`, `idLivraison`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(666, 1, 'Fer', '7700.00', '15.00', 2732, NULL, NULL, NULL, NULL),
(667, 1, 'Fer', '7600.00', '20.00', 2732, NULL, NULL, NULL, NULL),
(668, 1, 'Fer', '8000.00', '20.00', 2732, NULL, NULL, NULL, NULL),
(669, 1, 'CPJ', '85.00', '100.00', 2734, NULL, NULL, NULL, NULL),
(670, 2, 'CPJ', '68.00', '100.00', 2735, NULL, NULL, NULL, NULL),
(671, 2, 'cpj', '60.00', '100.00', 2736, NULL, NULL, NULL, NULL),
(672, 2, 'pml', '100.00', '300.00', 2739, NULL, NULL, NULL, NULL),
(673, 2, 'cpg', '80.00', '100.00', 2740, NULL, NULL, '2015-11-17 03:07:02', 'admin'),
(675, 2, 'cpj', '120.00', '120.00', 2737, '2015-11-17 03:44:48', 'admin', NULL, NULL),
(676, 1, 'flk', '20.00', '100.00', 2741, '2015-11-17 03:46:14', 'admin', NULL, NULL),
(693, 1, 'btn', '100.00', '1000.00', 2738, '2015-11-18 07:16:27', 'admin', NULL, NULL),
(692, 2, 'btn', '120.00', '2000.00', 2744, '2015-11-18 06:09:11', 'admin', NULL, NULL),
(691, 2, 'btn', '100.00', '1000.00', 2744, '2015-11-18 06:08:58', 'admin', NULL, NULL),
(690, 2, 'pol', '150.00', '200.00', 2744, '2015-11-18 06:04:19', 'admin', NULL, NULL),
(689, 2, 'cp', '20.00', '1000.00', 2744, '2015-11-18 06:04:02', 'admin', NULL, NULL),
(682, 1, 'a', '12.00', '12.00', 2743, '2015-11-17 04:02:08', 'admin', NULL, NULL),
(683, 1, 'b', '12.00', '10.00', 2743, '2015-11-17 04:02:16', 'admin', NULL, NULL),
(684, 1, 'c', '12.00', '90.00', 2743, '2015-11-17 04:02:25', 'admin', NULL, NULL),
(685, 1, 'd', '30.00', '30.00', 2743, '2015-11-17 04:02:34', 'admin', NULL, NULL),
(694, 2, 'cpj', '30.00', '1000.00', 2745, '2015-11-19 03:39:18', 'admin', NULL, NULL),
(695, 2, 'cpj', '100.00', '100.00', 2746, '2015-11-19 04:04:40', 'admin', NULL, NULL),
(696, 2, 'cpj', '60.00', '200.00', 2747, '2015-11-23 11:35:28', 'admin', NULL, NULL),
(697, 2, 'btn', '80.00', '100.00', 2747, '2015-11-23 11:35:37', 'admin', NULL, NULL),
(698, 2, 'cpj', '100.00', '100.00', 2748, '2015-11-23 11:36:15', 'admin', NULL, NULL),
(699, 2, 'lpc', '40.00', '500.00', 2748, '2015-11-23 11:36:27', 'admin', NULL, NULL),
(700, 1, 'Marbre', '80.00', '300.00', 2749, '2015-12-05 12:34:25', 'mouaad', NULL, NULL),
(701, NULL, 'cpj', '10.00', '200.00', 2751, '2015-12-17 12:36:31', 'admin', NULL, NULL),
(702, NULL, 'btn', '80.00', '100.00', 2751, '2015-12-17 12:36:38', 'admin', NULL, NULL),
(703, NULL, 'ghj', '400.00', '3.00', 2752, '2015-12-17 12:37:54', 'admin', NULL, NULL),
(704, NULL, 'LLLLLLLLL', '10.00', '1000.00', 2753, '2016-01-11 12:27:38', 'admin', NULL, NULL),
(705, NULL, 'CPJ', '100.00', '1000.00', 2754, '2016-01-19 04:55:10', 'admin', NULL, NULL),
(706, NULL, 'lol', '12.00', '1000.00', 2755, '2016-01-26 06:11:42', 'admin', NULL, NULL),
(707, NULL, 'cpj', '60.00', '100.00', 2756, '2016-01-26 06:27:02', 'admin', NULL, NULL),
(708, NULL, 'lom', '12.00', '122.00', 2757, '2016-02-11 03:13:15', 'admin', NULL, NULL),
(709, NULL, 'cbt', '12.00', '200.00', 2760, '2016-02-11 05:27:56', 'admin', '2016-02-11 05:30:46', 'admin'),
(710, NULL, 'afl', '1.50', '100.00', 2760, '2016-02-11 05:31:01', 'admin', NULL, NULL),
(711, NULL, 'aze', '0.00', '0.00', 2760, '2016-02-11 05:31:19', 'admin', NULL, NULL),
(712, NULL, 'test', '12.00', '12.00', 2760, '2016-02-11 05:33:23', 'admin', NULL, NULL),
(713, NULL, 'azer', '12.00', '0.00', 2760, '2016-02-11 05:38:20', 'admin', NULL, NULL),
(714, NULL, 'cpj', '120.00', '10.00', 2761, '2016-07-25 12:34:26', 'admin', NULL, NULL),
(715, NULL, 'btn', '50.00', '1000.00', 2762, '2016-07-25 12:35:02', 'admin', NULL, NULL),
(716, NULL, 'pvc', '10.00', '200.00', 2763, '2016-07-25 12:35:45', 'admin', NULL, NULL),
(718, NULL, 'btn', '12.00', '30.00', 2764, '2016-10-27 12:04:17', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_locaux`
--

CREATE TABLE IF NOT EXISTS `t_locaux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `superficie` decimal(10,2) DEFAULT NULL,
  `facade` varchar(45) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `montantRevente` decimal(10,2) DEFAULT NULL,
  `mezzanine` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  `par` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Contenu de la table `t_locaux`
--

INSERT INTO `t_locaux` (`id`, `nom`, `superficie`, `facade`, `prix`, `montantRevente`, `mezzanine`, `status`, `idProjet`, `par`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(29, 'L1', '110.00', 'FAL1', '1200000.00', NULL, 'Avec', 'Vendu', 15, '', NULL, NULL, '2015-11-04 08:19:09', 'admin'),
(30, 'L2', '300.00', 'FAL2', '2900000.00', NULL, 'Avec', 'Vendu', 15, '', '2015-11-04 08:02:16', 'admin', NULL, NULL),
(32, 'LC30', '120.00', '100', '130000.00', NULL, 'Avec', 'Vendu', 15, '', '2015-12-24 01:50:10', 'admin', NULL, NULL),
(31, 'L3', '200.00', 'FAL4', '3900000.00', NULL, 'Avec', 'Vendu', 15, '', '2015-11-04 08:20:42', 'admin', NULL, NULL),
(33, 'L5', '200.00', 'FA1', '1900000.00', '1950000.00', 'Avec', 'Vendu', 15, 'Akaouch mohamed', '2016-01-05 05:07:51', 'admin', NULL, NULL),
(34, 'L6', '120.00', 'FL1', '1000000.00', NULL, 'Avec', 'Vendu', 15, '', '2016-01-05 05:08:09', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_mail`
--

CREATE TABLE IF NOT EXISTS `t_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `sender` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `t_mail`
--

INSERT INTO `t_mail` (`id`, `content`, `sender`, `created`) VALUES
(2, 'Salam merci', 'admin', '2015-10-20 23:14:30'),
(3, 'Ok', 'admin', '2015-10-20 23:14:40'),
(4, 'slm ', 'admin', '2015-10-24 10:48:32');

-- --------------------------------------------------------

--
-- Structure de la table `t_notes_client`
--

CREATE TABLE IF NOT EXISTS `t_notes_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note` text,
  `created` date DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  `codeContrat` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=901 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_operation`
--

CREATE TABLE IF NOT EXISTS `t_operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `dateReglement` date DEFAULT NULL,
  `compteBancaire` varchar(50) DEFAULT NULL,
  `observation` text,
  `montant` decimal(12,2) DEFAULT NULL,
  `modePaiement` varchar(255) DEFAULT NULL,
  `idContrat` int(11) DEFAULT NULL,
  `numeroCheque` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `url` text,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1718 ;

--
-- Contenu de la table `t_operation`
--

INSERT INTO `t_operation` (`id`, `reference`, `date`, `dateReglement`, `compteBancaire`, `observation`, `montant`, `modePaiement`, `idContrat`, `numeroCheque`, `status`, `url`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1665, NULL, '2015-10-20', NULL, NULL, NULL, '45000.00', 'Especes', 412, '0', 2, NULL, NULL, NULL, NULL, NULL),
(1666, NULL, '2015-10-20', NULL, NULL, NULL, '50000.00', 'Virement', 412, '0', 0, NULL, NULL, NULL, NULL, NULL),
(1667, NULL, '2015-10-20', NULL, NULL, NULL, '60000.00', 'Virement', 412, '', 0, NULL, NULL, NULL, NULL, NULL),
(1668, NULL, '2015-10-20', NULL, NULL, NULL, '6600.00', 'Cheque', 412, '6789908', 0, NULL, NULL, NULL, NULL, NULL),
(1669, NULL, '2015-10-20', NULL, NULL, NULL, '45000.00', 'Especes', 413, '', 0, NULL, NULL, NULL, NULL, NULL),
(1670, NULL, '2015-10-20', NULL, NULL, NULL, '50000.00', 'Especes', 413, '', 0, NULL, NULL, NULL, NULL, NULL),
(1671, NULL, '2015-10-20', NULL, NULL, NULL, '55555566.00', 'Especes', 414, '', 0, NULL, NULL, NULL, NULL, NULL),
(1672, NULL, '2015-10-20', NULL, NULL, NULL, '1300000000.00', 'Especes', 414, '', 0, NULL, NULL, NULL, NULL, NULL),
(1673, NULL, '2015-10-20', NULL, NULL, NULL, '-50000.00', 'Especes', 413, '', 0, NULL, NULL, NULL, NULL, NULL),
(1674, NULL, '2015-10-20', NULL, NULL, NULL, '-5000.00', 'Especes', 413, '', 0, NULL, NULL, NULL, NULL, NULL),
(1675, NULL, '2015-10-24', NULL, NULL, NULL, '50000.00', 'Especes', 413, '', 0, NULL, NULL, NULL, NULL, NULL),
(1676, NULL, '2015-10-26', NULL, NULL, NULL, '40000.00', 'Especes', 415, '0', 0, NULL, NULL, NULL, NULL, NULL),
(1677, NULL, '2015-10-26', NULL, NULL, NULL, '60000.00', 'Cheque', 415, '0', 0, NULL, NULL, NULL, NULL, NULL),
(1678, NULL, '2015-10-30', NULL, NULL, NULL, '4000.00', 'Especes', 416, '0', 0, NULL, NULL, NULL, NULL, NULL),
(1679, NULL, '2015-11-24', NULL, NULL, NULL, '30000.00', 'Especes', 420, '10004', 0, NULL, NULL, NULL, '2015-11-24 07:02:54', 'admin'),
(1680, NULL, '2015-11-24', NULL, NULL, NULL, '23000.00', 'Cheque', 420, '10001', 0, NULL, '2015-11-24 05:50:13', 'admin', '2015-11-24 07:02:35', 'admin'),
(1681, NULL, '2015-11-24', NULL, NULL, NULL, '20000.00', 'Especes', 420, '10005', 0, NULL, '2015-11-24 07:18:07', 'admin', NULL, NULL),
(1682, NULL, '2015-11-24', NULL, NULL, NULL, '50000.00', 'Cheque', 420, '10006', 0, NULL, '2015-11-24 07:18:44', 'admin', NULL, NULL),
(1683, NULL, '2015-11-16', NULL, NULL, NULL, '30000.00', 'Versement', 420, '10010', 0, NULL, '2015-11-24 07:19:20', 'admin', '2015-11-24 07:27:08', 'admin'),
(1684, NULL, '2015-11-24', NULL, NULL, NULL, '10000.00', 'Cheque', 420, '10007', 0, NULL, '2015-11-24 07:22:25', 'admin', NULL, NULL),
(1685, NULL, '2015-11-24', NULL, NULL, NULL, '20000.00', 'Especes', 420, '10008', 0, NULL, '2015-11-24 07:24:59', 'admin', NULL, NULL),
(1686, NULL, '2015-11-24', NULL, NULL, NULL, '30000.00', 'Especes', 420, '10009', 0, NULL, '2015-11-24 07:26:30', 'admin', NULL, NULL),
(1687, NULL, '2015-11-10', '2015-11-26', '255498600001', 'Le reste &agrave; ventiler sur 18 mois', '200000.00', 'Cheque', 422, '10092', 0, NULL, '2015-11-26 02:44:02', 'admin', '2015-11-26 03:13:07', 'admin'),
(1688, NULL, '2015-11-23', '2015-11-25', '8905551980', '', '10000.00', 'Especes', 422, '109290', 1, NULL, '2015-11-26 02:57:40', 'admin', '2015-11-26 03:13:37', 'admin'),
(1689, NULL, '2015-11-10', '2015-11-26', '8905551980', 'Le reste &agrave; ventiler sur 9 mois', '30000.00', 'Especes', 422, '12029', 1, NULL, '2015-11-26 03:33:16', 'admin', NULL, NULL),
(1690, NULL, '2015-12-03', '2015-12-03', '8905551980', '', '30000.00', 'Especes', 421, '102900', 1, NULL, '2015-12-03 10:55:23', 'mouaad', NULL, NULL),
(1691, NULL, '2015-12-07', '2015-12-07', '8905551980', '', '20000.00', 'Especes', 429, '1201290', 1, NULL, '2015-12-07 10:36:40', 'admin', NULL, NULL),
(1692, NULL, '2015-12-11', '2015-12-11', '8905551980', '', '60000.00', 'Virement', 422, '123', 1, NULL, '2015-12-11 10:07:52', 'admin', NULL, NULL),
(1693, NULL, '2016-06-18', '2016-06-18', '89055519803', '', '90000.00', 'Especes', 433, '122222', 2, NULL, '2016-06-18 04:08:29', 'admin', NULL, NULL),
(1694, NULL, '2015-12-23', '2015-12-23', '90239', 'Paiement de l''avance sur place', '200000.00', 'Especes', 436, '12092920', 2, NULL, '2015-12-23 12:50:34', 'admin', NULL, NULL),
(1695, '10000', '2016-01-11', '2016-01-11', '1230231999990000XD', '', '10000.00', 'Especes', 433, '1029019', 0, NULL, '2016-01-11 12:55:09', 'admin', '2016-01-11 12:59:37', 'admin'),
(1696, 'Num-56939941b14ad20160111010001', '2016-01-11', '0000-00-00', '1230231999990000XD', '', '30000.00', 'Especes', 433, '900012301', 0, NULL, '2016-01-11 01:00:01', 'admin', NULL, NULL),
(1697, '20160111010229569399d5b8f98', '2016-01-11', '0000-00-00', '1230231999990000XD', '', '40000.00', 'Especes', 433, '340930', 0, NULL, '2016-01-11 01:02:29', 'admin', NULL, NULL),
(1698, '20160111011041', '2016-01-11', '0000-00-00', '1230231999990000XD', 'Changer la date de r&eacute;cup&eacute;ration ', '40000.00', 'Especes', 433, '2349230', 0, NULL, '2016-01-11 01:10:41', 'admin', NULL, NULL),
(1699, 'Q20160111021433', '2016-01-11', '0000-00-00', '1230231999990000XD', 'Rien de sp&eacute;cial', '30000.00', 'Especes', 433, '30029', 0, NULL, '2016-01-11 02:14:33', 'admin', NULL, NULL),
(1700, 'Q20160201-093044', '2016-02-01', '2016-02-10', '1230231999990000XD', 'Rien', '10000.00', 'Especes', 441, '120', 0, NULL, '2016-02-01 09:30:44', 'admin', NULL, NULL),
(1701, 'Q20160209-035948', '2016-02-09', '2016-02-09', '1230231999990000XD', 'Pay&eacute; en Euro', '10908.30', 'Especes', 441, 'E2349', 0, NULL, '2016-02-09 03:59:49', 'admin', NULL, NULL),
(1702, 'Q20160209-040237', '2016-02-09', '2016-02-09', '1230231999990000XD', ' - (PayÃ© En Euro)', '38235.75', 'Especes', 441, 'E3029', 0, NULL, '2016-02-09 04:02:38', 'admin', NULL, NULL),
(1703, 'Q20160210-060005', '2016-02-10', '2016-02-10', '1230231999990000XD', ' - (PayÃ© En Euro)', '10908.50', 'Especes', 441, '123', 0, NULL, '2016-02-10 06:00:07', 'admin', NULL, NULL),
(1704, 'Q20160210-060240', '2016-02-10', '2016-02-10', '1230231999990000XD', ' - (PayÃ© En Euro)', '10905.10', 'Especes', 441, '124', 1, NULL, '2016-02-10 06:02:41', 'admin', NULL, NULL),
(1705, 'Q20160227-055317', '2016-02-27', '2016-02-27', '1230231999990000XD', ' - (PayÃ© En Euro)', '10000.00', 'Especes', 444, '10001', 0, NULL, '2016-02-27 05:53:17', 'admin', NULL, NULL),
(1706, 'Q20160227-055907', '2016-02-27', '0000-00-00', '1230231999990000XD', ' - (PayÃ© En Euro)', '10000.00', 'Especes', 444, '10192', 0, NULL, '2016-02-27 05:59:07', 'admin', NULL, NULL),
(1707, 'Q20160227-064310', '2016-02-27', '2016-02-27', '1230231999990000XD', ' - (PayÃ© En Euro)', '10780.00', 'Especes', 444, '109292', 1, NULL, '2016-02-27 06:43:10', 'admin', NULL, NULL),
(1708, 'Q20160227-064344', '2016-02-27', '2016-02-29', '1230231999990000XD', ' - (PayÃ© En Euro)', '21720.00', 'Especes', 444, '1029922', 2, NULL, '2016-02-27 06:43:44', 'admin', NULL, NULL),
(1709, 'Q20160428-044134', '2016-01-21', '2016-01-21', '1230231999990000XD', 'Ce rÃ©glement client fait rÃ©fÃ©rence Ã  la ligne 629 du relevÃ© bancaire du compte 00000', '30000.00', 'Versement', 420, '', 1, NULL, '2016-04-28 04:41:34', 'abdessamad', NULL, NULL),
(1710, 'Q20160428-044310', '2016-01-14', '2016-01-14', '1230231999990000XD', 'Ce rÃ©glement client fait rÃ©fÃ©rence Ã  la ligne 624 du relevÃ© bancaire du compte 00000', '200000.00', 'Versement', 444, '', 1, NULL, '2016-04-28 04:43:10', 'abdessamad', NULL, NULL),
(1711, 'Q20160428-044542', '2016-01-12', '2016-01-12', '255498600001', 'Ce rÃ©glement client fait rÃ©fÃ©rence Ã  la ligne : 622 du relevÃ© bancaire du compte bancaire : 255498600001', '200000.00', 'Versement', 444, '', 1, '/pieces/pieces_reglements/5739eabc895f2bootstrap.png', '2016-04-28 04:45:42', 'abdessamad', NULL, NULL),
(1716, '108277', '2016-06-03', '2016-06-03', '1230231999990000XD', 'VIREMENT EN VOTRE FAVEUR DE CNSS', '200.00', '', 420, '108277', 1, NULL, '2016-07-01 05:53:10', 'admin', NULL, NULL),
(1713, 'Q20160516-054449', '2016-05-16', '2016-05-16', '1230231999990000XD', 'ddddddddddddddddddd', '12.00', 'Cheque', 444, '12312312&quot;', 0, '', '2016-05-16 05:44:49', 'admin', NULL, NULL),
(1714, 'Q20160516-054812', '2016-05-16', '2016-05-16', '1230231999990000XD', 'azazeaze', '123.00', 'Especes', 444, '12312312312', 0, '/pieces/pieces_reglements/5739ec1887a3astatic.jpg', '2016-05-16 05:48:12', 'admin', NULL, NULL),
(1715, 'Q20160516-055009', '2016-05-16', '2016-05-16', '1230231999990000XD', 'aeazeazeazeaze', '123.00', 'Especes', 444, '1231231', 0, '/pieces/pieces_reglements/573ae52f53c02bootstrap.png', '2016-05-16 05:50:09', 'admin', NULL, NULL),
(1717, 'Q20160725-012111', '2016-07-25', '2016-07-25', '1230231999990000XD', 'Ch&egrave;que &agrave; verser au compte 2', '200000.00', 'Cheque', 451, '123', 0, '', '2016-07-25 01:21:11', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_pieces_appartement`
--

CREATE TABLE IF NOT EXISTS `t_pieces_appartement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `idAppartement` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `t_pieces_appartement`
--

INSERT INTO `t_pieces_appartement` (`id`, `nom`, `url`, `idAppartement`) VALUES
(7, '', '/pieces/pieces_appartement/5626bdc30400c20151017_130357.jpg', 449);

-- --------------------------------------------------------

--
-- Structure de la table `t_pieces_livraison`
--

CREATE TABLE IF NOT EXISTS `t_pieces_livraison` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `url` text,
  `idLivraison` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_pieces_locaux`
--

CREATE TABLE IF NOT EXISTS `t_pieces_locaux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `idLocaux` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `t_pieces_locaux`
--

INSERT INTO `t_pieces_locaux` (`id`, `nom`, `url`, `idLocaux`) VALUES
(4, 'Fiche descriptif du local commercial', '/pieces/pieces_locaux/575ad6cbe5a27Chrysanthemum.jpg', 29);

-- --------------------------------------------------------

--
-- Structure de la table `t_pieces_terrain`
--

CREATE TABLE IF NOT EXISTS `t_pieces_terrain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `idTerrain` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `t_pieces_terrain`
--

INSERT INTO `t_pieces_terrain` (`id`, `nom`, `url`, `idTerrain`) VALUES
(5, 'Molkia', '/pieces/pieces_terrain/56269a79d435320151020_143632.jpg', 2),
(6, 'jenesaispas', '/pieces/pieces_terrain/568539b67a784Desert.jpg', 5);

-- --------------------------------------------------------

--
-- Structure de la table `t_projet`
--

CREATE TABLE IF NOT EXISTS `t_projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `superficie` decimal(10,2) DEFAULT NULL,
  `description` text,
  `budget` decimal(12,2) DEFAULT NULL,
  `companyID` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(60) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(60) DEFAULT NULL,
  `nomArabe` varchar(100) DEFAULT NULL,
  `adresseArabe` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `t_projet`
--

INSERT INTO `t_projet` (`id`, `nom`, `titre`, `adresse`, `superficie`, `description`, `budget`, `companyID`, `created`, `createdBy`, `updated`, `updatedBy`, `nomArabe`, `adresseArabe`) VALUES
(15, 'Al Matar Iskan', 'A09123030MDRF', 'Quartier Al Matar ONDA 2300', '1000.00', '', '1200000.00', 1, NULL, NULL, '2015-12-21 04:38:29', 'admin', 'Ø§Ù„Ù†Ù‡Ø¶Ø© 1', 'Ø´Ø§Ø±Ø¹ Ø§Ù„Ù…Ø·Ø§Ø± 2300'),
(16, 'Jawharat Rif', NULL, 'Nador', '500.00', 'Projet Immobilier Social', '15000000.00', 2, NULL, NULL, '2015-11-03 04:37:25', 'admin', NULL, NULL),
(18, 'Diamant Blanc', NULL, 'Rue Al Matar 300', '500.00', 'Projet Immobilier Social', '4000000.00', 3, '2015-11-03 01:44:55', 'admin', NULL, NULL, NULL, NULL),
(19, 'Al Mossala', NULL, 'Rue S&eacute;louane S&eacute;louane', '400.00', 'Projet Immobilier Social', '4950000.00', 1, '2015-11-03 03:34:21', 'admin', '2015-11-03 03:36:37', 'admin', NULL, NULL),
(20, 'Annour', NULL, 'Rue ONDA 2300', '450.00', 'Projet Immobilier Social', '300000.00', 1, '2015-11-03 04:38:10', 'admin', NULL, NULL, NULL, NULL),
(21, 'Moussa Bnou Noussair', NULL, 'Rue Salam Nador', '300.00', 'Projet Complexe Commercial', '4000000.00', 2, '2015-11-03 05:03:48', 'admin', NULL, NULL, NULL, NULL),
(22, 'Al Hilal', NULL, 'Rue ONDA 434', '400.00', 'Projet Immobilier Social\r\n', '500000.00', 3, '2015-11-03 05:06:52', 'admin', NULL, NULL, NULL, NULL),
(23, 'Mediteraneo', NULL, 'Rue Taouima', '500.00', 'Projet Immobilier Social', '3500000.00', 1, '2015-11-03 05:07:41', 'admin', NULL, NULL, NULL, NULL),
(24, 'Lina', NULL, 'Rue S/N 0990', '300.00', 'Projet Immobilier', '400000.00', 2, '2015-11-03 05:08:12', 'admin', NULL, NULL, NULL, NULL),
(25, 'Ikamat Al Khayr', NULL, 'Rue ONDA 0293', '300.00', 'Projet Immobilier', '400000.00', 3, '2015-11-03 05:08:46', 'admin', NULL, NULL, NULL, NULL),
(26, 'Katr Annada', NULL, 'Rue ONDA 2920', '300.00', 'Projet Immobilier', '300000.00', 1, '2015-11-03 05:09:10', 'admin', NULL, NULL, NULL, NULL),
(27, 'ImmoERP 12', NULL, 'Rue ONDA 342394', '400.00', 'Projet Immobilier', '400000.00', 2, '2015-11-03 05:09:31', 'admin', NULL, NULL, NULL, NULL),
(28, 'Assakan Al Morih', '12093ET/40', 'Rue Al Hikma ONDA Nador', '400.00', 'Projet Immobilier', '700000.00', 3, '2015-12-21 04:39:57', 'admin', NULL, NULL, 'Ø§Ù„Ù†Ù‡Ø¶Ø© 13', 'Ø´Ø§Ø±Ø¹ Ø§Ù„Ø­ÙƒÙ…Ø© Ø§Ù„Ù…Ø·Ø§Ø± Ø§Ù„Ù†Ø§Ø¸ÙˆØ±');

-- --------------------------------------------------------

--
-- Structure de la table `t_reglementprevu`
--

CREATE TABLE IF NOT EXISTS `t_reglementprevu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datePrevu` date DEFAULT NULL,
  `codeContrat` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=218 ;

--
-- Contenu de la table `t_reglementprevu`
--

INSERT INTO `t_reglementprevu` (`id`, `datePrevu`, `codeContrat`, `status`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(33, '2016-02-28', '5659ace3f26a220151128143219', 0, '2015-11-28 02:32:19', 'admin', NULL, NULL),
(34, '2016-05-28', '5659ace3f26a220151128143219', 0, '2015-11-28 02:32:19', 'admin', NULL, NULL),
(35, '2016-08-28', '5659ace3f26a220151128143219', 0, '2015-11-28 02:32:19', 'admin', NULL, NULL),
(36, '2016-11-28', '5659ace3f26a220151128143219', 0, '2015-11-28 02:32:19', 'admin', NULL, NULL),
(37, '2017-02-28', '5659ace3f26a220151128143219', 0, '2015-11-28 02:32:19', 'admin', NULL, NULL),
(38, '2017-05-28', '5659ace3f26a220151128143219', 0, '2015-11-28 02:32:19', 'admin', NULL, NULL),
(39, '2017-08-28', '5659ace3f26a220151128143219', 0, '2015-11-28 02:32:19', 'admin', NULL, NULL),
(40, '2017-11-28', '5659ace3f26a220151128143219', 0, '2015-11-28 02:32:19', 'admin', NULL, NULL),
(41, '2016-04-08', '5666baaf509a820151208121039', 0, '2015-12-08 12:10:39', 'admin', NULL, NULL),
(42, '2016-08-08', '5666baaf509a820151208121039', 0, '2015-12-08 12:10:39', 'admin', NULL, NULL),
(43, '2016-12-08', '5666baaf509a820151208121039', 0, '2015-12-08 12:10:39', 'admin', NULL, NULL),
(44, '2017-04-08', '5666baaf509a820151208121039', 0, '2015-12-08 12:10:39', 'admin', NULL, NULL),
(45, '2017-08-08', '5666baaf509a820151208121039', 0, '2015-12-08 12:10:39', 'admin', NULL, NULL),
(46, '2017-12-08', '5666baaf509a820151208121039', 0, '2015-12-08 12:10:39', 'admin', NULL, NULL),
(47, '2016-03-19', '56757cc1290d420151219165025', 0, '2015-12-19 04:50:25', 'admin', NULL, NULL),
(48, '2016-06-19', '56757cc1290d420151219165025', 0, '2015-12-19 04:50:25', 'admin', NULL, NULL),
(49, '2016-09-19', '56757cc1290d420151219165025', 0, '2015-12-19 04:50:25', 'admin', NULL, NULL),
(50, '2016-12-19', '56757cc1290d420151219165025', 0, '2015-12-19 04:50:25', 'admin', NULL, NULL),
(51, '2017-03-19', '56757cc1290d420151219165025', 0, '2015-12-19 04:50:25', 'admin', NULL, NULL),
(52, '2017-06-19', '56757cc1290d420151219165025', 0, '2015-12-19 04:50:25', 'admin', NULL, NULL),
(53, '2017-09-19', '56757cc1290d420151219165025', 0, '2015-12-19 04:50:25', 'admin', NULL, NULL),
(54, '2017-12-19', '56757cc1290d420151219165025', 0, '2015-12-19 04:50:25', 'admin', NULL, NULL),
(61, '2016-04-22', '56797cd782e8020151222173951', 0, '2015-12-22 05:39:51', 'admin', NULL, NULL),
(62, '2016-08-22', '56797cd782e8020151222173951', 0, '2015-12-22 05:39:51', 'admin', NULL, NULL),
(63, '2016-12-22', '56797cd782e8020151222173951', 0, '2015-12-22 05:39:51', 'admin', NULL, NULL),
(64, '2017-04-22', '56797cd782e8020151222173951', 0, '2015-12-22 05:39:51', 'admin', NULL, NULL),
(65, '2017-08-22', '56797cd782e8020151222173951', 0, '2015-12-22 05:39:51', 'admin', NULL, NULL),
(66, '2017-12-22', '56797cd782e8020151222173951', 0, '2015-12-22 05:39:51', 'admin', NULL, NULL),
(67, '2016-04-22', '56797d3a94e4320151222174130', 0, '2015-12-22 05:41:30', 'admin', NULL, NULL),
(68, '2016-08-22', '56797d3a94e4320151222174130', 0, '2015-12-22 05:41:30', 'admin', NULL, NULL),
(69, '2016-12-22', '56797d3a94e4320151222174130', 0, '2015-12-22 05:41:30', 'admin', NULL, NULL),
(70, '2017-04-22', '56797d3a94e4320151222174130', 0, '2015-12-22 05:41:30', 'admin', NULL, NULL),
(71, '2017-08-22', '56797d3a94e4320151222174130', 0, '2015-12-22 05:41:30', 'admin', NULL, NULL),
(72, '2017-12-22', '56797d3a94e4320151222174130', 0, '2015-12-22 05:41:30', 'admin', NULL, NULL),
(73, '2016-06-23', '567a8a2f9b86d20151223124903', 0, '2015-12-23 12:49:03', 'admin', NULL, NULL),
(74, '2016-12-23', '567a8a2f9b86d20151223124903', 0, '2015-12-23 12:49:03', 'admin', NULL, NULL),
(75, '2017-06-23', '567a8a2f9b86d20151223124903', 0, '2015-12-23 12:49:03', 'admin', NULL, NULL),
(76, '2017-12-23', '567a8a2f9b86d20151223124903', 0, '2015-12-23 12:49:03', 'admin', NULL, NULL),
(77, '2018-06-23', '567a8a2f9b86d20151223124903', 0, '2015-12-23 12:49:03', 'admin', NULL, NULL),
(78, '2018-12-23', '567a8a2f9b86d20151223124903', 0, '2015-12-23 12:49:03', 'admin', NULL, NULL),
(79, '2019-06-23', '567a8a2f9b86d20151223124903', 0, '2015-12-23 12:49:03', 'admin', NULL, NULL),
(80, '2019-12-23', '567a8a2f9b86d20151223124903', 0, '2015-12-23 12:49:03', 'admin', NULL, NULL),
(84, '2016-08-22', '567966cd186c120151222160549', 0, '2015-12-23 10:31:38', 'admin', NULL, NULL),
(85, '2017-04-22', '567966cd186c120151222160549', 0, '2015-12-23 10:31:38', 'admin', NULL, NULL),
(86, '2017-12-22', '567966cd186c120151222160549', 0, '2015-12-23 10:31:38', 'admin', NULL, NULL),
(87, '2016-02-24', '567bebaa16a1520151224135714', 0, '2015-12-24 01:57:14', 'admin', NULL, NULL),
(88, '2016-04-11', '5693aff52c5b120160111143653', 0, '2016-01-11 02:36:53', 'admin', NULL, NULL),
(89, '2016-07-11', '5693aff52c5b120160111143653', 0, '2016-01-11 02:36:53', 'admin', NULL, NULL),
(90, '2016-10-11', '5693aff52c5b120160111143653', 0, '2016-01-11 02:36:53', 'admin', NULL, NULL),
(91, '2017-01-11', '5693aff52c5b120160111143653', 0, '2016-01-11 02:36:53', 'admin', NULL, NULL),
(96, '2016-04-26', '56a7be5f77e3320160126194343', 0, '2016-01-26 07:43:43', 'admin', NULL, NULL),
(97, '2016-07-26', '56a7be5f77e3320160126194343', 0, '2016-01-26 07:43:43', 'admin', NULL, NULL),
(98, '2016-10-26', '56a7be5f77e3320160126194343', 0, '2016-01-26 07:43:43', 'admin', NULL, NULL),
(99, '2017-01-26', '56a7be5f77e3320160126194343', 0, '2016-01-26 07:43:43', 'admin', NULL, NULL),
(100, '2016-05-26', '56a7c234093eb20160126200004', 0, '2016-01-26 08:00:04', 'admin', NULL, NULL),
(101, '2016-09-26', '56a7c234093eb20160126200004', 0, '2016-01-26 08:00:04', 'admin', NULL, NULL),
(102, '2017-01-26', '56a7c234093eb20160126200004', 0, '2016-01-26 08:00:04', 'admin', NULL, NULL),
(103, '2017-05-26', '56a7c234093eb20160126200004', 0, '2016-01-26 08:00:04', 'admin', NULL, NULL),
(104, '2017-09-26', '56a7c234093eb20160126200004', 0, '2016-01-26 08:00:04', 'admin', NULL, NULL),
(105, '2018-01-26', '56a7c234093eb20160126200004', 0, '2016-01-26 08:00:04', 'admin', NULL, NULL),
(106, '2016-05-26', '56a7c3f7084d120160126200735', 0, '2016-01-26 08:07:35', 'admin', NULL, NULL),
(107, '2016-09-26', '56a7c3f7084d120160126200735', 0, '2016-01-26 08:07:35', 'admin', NULL, NULL),
(108, '2017-01-26', '56a7c3f7084d120160126200735', 0, '2016-01-26 08:07:35', 'admin', NULL, NULL),
(109, '2017-05-26', '56a7c3f7084d120160126200735', 0, '2016-01-26 08:07:35', 'admin', NULL, NULL),
(110, '2017-09-26', '56a7c3f7084d120160126200735', 0, '2016-01-26 08:07:35', 'admin', NULL, NULL),
(111, '2018-01-26', '56a7c3f7084d120160126200735', 0, '2016-01-26 08:07:35', 'admin', NULL, NULL),
(113, '2016-05-25', '56cf35577f45820160225180943', 0, '2016-02-25 06:09:43', 'admin', NULL, NULL),
(114, '2016-08-25', '56cf35577f45820160225180943', 0, '2016-02-25 06:09:43', 'admin', NULL, NULL),
(115, '2016-11-25', '56cf35577f45820160225180943', 0, '2016-02-25 06:09:43', 'admin', NULL, NULL),
(116, '2017-02-25', '56cf35577f45820160225180943', 0, '2016-02-25 06:09:43', 'admin', NULL, NULL),
(121, '2016-04-11', '5693b26e8314b20160111144726', 0, '2016-03-07 01:12:33', 'admin', NULL, NULL),
(122, '2016-07-11', '5693b26e8314b20160111144726', 0, '2016-03-07 01:12:33', 'admin', NULL, NULL),
(123, '2016-10-11', '5693b26e8314b20160111144726', 0, '2016-03-07 01:12:33', 'admin', NULL, NULL),
(124, '2017-01-11', '5693b26e8314b20160111144726', 0, '2016-03-07 01:12:33', 'admin', NULL, NULL),
(125, '2016-06-26', '56d041f7c07ce20160226131551', 0, '2016-03-30 04:55:08', 'admin', NULL, NULL),
(126, '2016-10-26', '56d041f7c07ce20160226131551', 0, '2016-03-30 04:55:08', 'admin', NULL, NULL),
(127, '2017-02-26', '56d041f7c07ce20160226131551', 0, '2016-03-30 04:55:08', 'admin', NULL, NULL),
(128, '2016-09-26', '57472b39c6bb320160526185833', 0, '2016-05-26 06:58:33', 'admin', NULL, NULL),
(129, '2017-01-26', '57472b39c6bb320160526185833', 0, '2016-05-26 06:58:33', 'admin', NULL, NULL),
(130, '2017-05-26', '57472b39c6bb320160526185833', 0, '2016-05-26 06:58:33', 'admin', NULL, NULL),
(131, '2017-09-26', '57472b39c6bb320160526185833', 0, '2016-05-26 06:58:33', 'admin', NULL, NULL),
(132, '2018-01-26', '57472b39c6bb320160526185833', 0, '2016-05-26 06:58:33', 'admin', NULL, NULL),
(133, '2018-05-26', '57472b39c6bb320160526185833', 0, '2016-05-26 06:58:33', 'admin', NULL, NULL),
(134, '2018-09-26', '57472b39c6bb320160526185833', 0, '2016-05-26 06:58:33', 'admin', NULL, NULL),
(135, '2019-01-26', '57472b39c6bb320160526185833', 0, '2016-05-26 06:58:33', 'admin', NULL, NULL),
(136, '2019-05-26', '57472b39c6bb320160526185833', 0, '2016-05-26 06:58:33', 'admin', NULL, NULL),
(137, '2016-09-26', '57472bbec5a6720160526190046', 0, '2016-05-26 07:00:46', 'admin', NULL, NULL),
(138, '2017-01-26', '57472bbec5a6720160526190046', 0, '2016-05-26 07:00:46', 'admin', NULL, NULL),
(139, '2017-05-26', '57472bbec5a6720160526190046', 0, '2016-05-26 07:00:46', 'admin', NULL, NULL),
(140, '2017-09-26', '57472bbec5a6720160526190046', 0, '2016-05-26 07:00:46', 'admin', NULL, NULL),
(141, '2018-01-26', '57472bbec5a6720160526190046', 0, '2016-05-26 07:00:46', 'admin', NULL, NULL),
(142, '2018-05-26', '57472bbec5a6720160526190046', 0, '2016-05-26 07:00:46', 'admin', NULL, NULL),
(143, '2018-09-26', '57472bbec5a6720160526190046', 0, '2016-05-26 07:00:46', 'admin', NULL, NULL),
(144, '2019-01-26', '57472bbec5a6720160526190046', 0, '2016-05-26 07:00:46', 'admin', NULL, NULL),
(145, '2019-05-26', '57472bbec5a6720160526190046', 0, '2016-05-26 07:00:46', 'admin', NULL, NULL),
(146, '2016-09-26', '57472d69468ab20160526190753', 0, '2016-05-26 07:07:53', 'admin', NULL, NULL),
(147, '2017-01-26', '57472d69468ab20160526190753', 0, '2016-05-26 07:07:53', 'admin', NULL, NULL),
(148, '2017-05-26', '57472d69468ab20160526190753', 0, '2016-05-26 07:07:53', 'admin', NULL, NULL),
(149, '2017-09-26', '57472d69468ab20160526190753', 0, '2016-05-26 07:07:53', 'admin', NULL, NULL),
(150, '2018-01-26', '57472d69468ab20160526190753', 0, '2016-05-26 07:07:53', 'admin', NULL, NULL),
(151, '2018-05-26', '57472d69468ab20160526190753', 0, '2016-05-26 07:07:53', 'admin', NULL, NULL),
(152, '2018-09-26', '57472d69468ab20160526190753', 0, '2016-05-26 07:07:53', 'admin', NULL, NULL),
(153, '2019-01-26', '57472d69468ab20160526190753', 0, '2016-05-26 07:07:53', 'admin', NULL, NULL),
(154, '2019-05-26', '57472d69468ab20160526190753', 0, '2016-05-26 07:07:53', 'admin', NULL, NULL),
(155, '2016-07-26', '57473671351ef20160526194625', 0, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(156, '2016-09-26', '57473671351ef20160526194625', 0, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(157, '2016-11-26', '57473671351ef20160526194625', 0, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(158, '2017-01-26', '57473671351ef20160526194625', 0, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(159, '2017-03-26', '57473671351ef20160526194625', 0, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(160, '2017-05-26', '57473671351ef20160526194625', 0, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(161, '2017-07-26', '57473671351ef20160526194625', 0, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(162, '2017-09-26', '57473671351ef20160526194625', 0, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(163, '2017-11-26', '57473671351ef20160526194625', 0, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(164, '2018-01-26', '57473671351ef20160526194625', 0, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(165, '2018-03-26', '57473671351ef20160526194625', 0, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(166, '2018-05-26', '57473671351ef20160526194625', 0, '2016-05-26 07:46:25', 'admin', NULL, NULL),
(167, '2016-08-26', '5747382366de120160526195339', 0, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(168, '2016-11-26', '5747382366de120160526195339', 0, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(169, '2017-02-26', '5747382366de120160526195339', 0, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(170, '2017-05-26', '5747382366de120160526195339', 0, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(171, '2017-08-26', '5747382366de120160526195339', 0, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(172, '2017-11-26', '5747382366de120160526195339', 0, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(173, '2018-02-26', '5747382366de120160526195339', 0, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(174, '2018-05-26', '5747382366de120160526195339', 0, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(175, '2018-08-26', '5747382366de120160526195339', 0, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(176, '2018-11-26', '5747382366de120160526195339', 0, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(177, '2019-02-26', '5747382366de120160526195339', 0, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(178, '2019-05-26', '5747382366de120160526195339', 0, '2016-05-26 07:53:39', 'admin', NULL, NULL),
(179, '2016-10-13', '57864c10ced6220160713161128', 0, '2016-07-13 04:11:28', 'admin', NULL, NULL),
(180, '2017-01-13', '57864c10ced6220160713161128', 0, '2016-07-13 04:11:28', 'admin', NULL, NULL),
(181, '2017-04-13', '57864c10ced6220160713161128', 0, '2016-07-13 04:11:28', 'admin', NULL, NULL),
(182, '2017-07-13', '57864c10ced6220160713161128', 0, '2016-07-13 04:11:28', 'admin', NULL, NULL),
(183, '2017-10-13', '57864c10ced6220160713161128', 0, '2016-07-13 04:11:28', 'admin', NULL, NULL),
(184, '2018-01-13', '57864c10ced6220160713161128', 0, '2016-07-13 04:11:28', 'admin', NULL, NULL),
(185, '2018-04-13', '57864c10ced6220160713161128', 0, '2016-07-13 04:11:28', 'admin', NULL, NULL),
(186, '2018-07-13', '57864c10ced6220160713161128', 0, '2016-07-13 04:11:28', 'admin', NULL, NULL),
(199, '2016-11-13', '578651b68546320160713163534', 0, '2016-07-13 04:55:07', 'admin', NULL, NULL),
(200, '2017-03-13', '578651b68546320160713163534', 0, '2016-07-13 04:55:07', 'admin', NULL, NULL),
(201, '2017-07-13', '578651b68546320160713163534', 0, '2016-07-13 04:55:07', 'admin', NULL, NULL),
(202, '2017-11-13', '578651b68546320160713163534', 0, '2016-07-13 04:55:07', 'admin', NULL, NULL),
(203, '2018-03-13', '578651b68546320160713163534', 0, '2016-07-13 04:55:07', 'admin', NULL, NULL),
(204, '2018-07-13', '578651b68546320160713163534', 0, '2016-07-13 04:55:07', 'admin', NULL, NULL),
(205, '2016-11-13', '578658ad95df420160713170517', 0, '2016-07-13 05:05:17', 'admin', NULL, NULL),
(206, '2017-03-13', '578658ad95df420160713170517', 0, '2016-07-13 05:05:17', 'admin', NULL, NULL),
(207, '2017-07-13', '578658ad95df420160713170517', 0, '2016-07-13 05:05:17', 'admin', NULL, NULL),
(208, '2017-11-13', '578658ad95df420160713170517', 0, '2016-07-13 05:05:17', 'admin', NULL, NULL),
(209, '2018-03-13', '578658ad95df420160713170517', 0, '2016-07-13 05:05:17', 'admin', NULL, NULL),
(210, '2018-07-13', '578658ad95df420160713170517', 0, '2016-07-13 05:05:17', 'admin', NULL, NULL),
(212, '2016-03-22', '56cb33577deb720160222171207', 0, '2016-07-22 01:18:59', 'admin', NULL, NULL),
(213, '2016-12-25', '5795f514c905920160725131636', 0, '2016-07-25 01:16:36', 'admin', NULL, NULL),
(214, '2017-05-25', '5795f514c905920160725131636', 0, '2016-07-25 01:16:36', 'admin', NULL, NULL),
(215, '2017-10-25', '5795f514c905920160725131636', 0, '2016-07-25 01:16:36', 'admin', NULL, NULL),
(216, '2018-03-25', '5795f514c905920160725131636', 0, '2016-07-25 01:16:36', 'admin', NULL, NULL),
(217, '2018-08-25', '5795f514c905920160725131636', 0, '2016-07-25 01:16:36', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_reglement_fournisseur`
--

CREATE TABLE IF NOT EXISTS `t_reglement_fournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant` decimal(12,2) DEFAULT NULL,
  `dateReglement` date DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  `idFournisseur` int(11) DEFAULT NULL,
  `modePaiement` varchar(255) DEFAULT NULL,
  `numeroCheque` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=230 ;

--
-- Contenu de la table `t_reglement_fournisseur`
--

INSERT INTO `t_reglement_fournisseur` (`id`, `montant`, `dateReglement`, `idProjet`, `idFournisseur`, `modePaiement`, `numeroCheque`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(217, '200000.00', '2015-10-29', 16, 20, 'Cheque', '1233667', NULL, NULL, NULL, NULL),
(218, '0.00', '2015-11-16', 15, 20, 'Especes', 'aaaa', NULL, NULL, NULL, NULL),
(219, '150000.00', '2015-11-18', 15, 22, 'Especes', '10001', '2015-11-18 05:45:12', 'admin', NULL, NULL),
(220, '10000.00', '2015-11-18', 15, 22, 'Especes', '10002', '2015-11-18 05:53:45', 'admin', NULL, NULL),
(221, '100000.00', '2015-11-18', 15, 19, 'Especes', '10003', NULL, NULL, NULL, NULL),
(222, '1000.00', '2015-11-18', 15, 22, 'Especes', '10004', '2015-11-18 06:03:16', 'admin', NULL, NULL),
(223, '1000.00', '2015-11-18', 15, 22, 'Especes', '10005', '2015-11-18 06:09:32', 'admin', NULL, NULL),
(224, '9000.00', '2015-12-28', 0, 29, 'Especes', '120', '2015-12-28 06:24:46', 'admin', NULL, NULL),
(226, '400.00', '2015-10-16', 18, 29, 'Cheque', '909', '2015-12-28 06:41:16', 'admin', '2015-12-28 06:59:45', 'admin'),
(228, '4000.00', '2015-12-28', 15, 29, 'Cheque', '39029', '2015-12-28 07:00:35', 'admin', '2016-10-27 04:43:57', 'admin'),
(229, '5000.00', '2016-10-27', 20, 29, 'Cheque', '1231230139', '2016-10-27 04:44:29', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_relevebancaire`
--

CREATE TABLE IF NOT EXISTS `t_relevebancaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateOpe` varchar(20) DEFAULT NULL,
  `dateVal` varchar(20) DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `debit` decimal(12,2) DEFAULT NULL,
  `credit` decimal(12,2) DEFAULT NULL,
  `projet` varchar(50) DEFAULT NULL,
  `idCompteBancaire` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=713 ;

--
-- Contenu de la table `t_relevebancaire`
--

INSERT INTO `t_relevebancaire` (`id`, `dateOpe`, `dateVal`, `libelle`, `reference`, `debit`, `credit`, `projet`, `idCompteBancaire`, `status`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(705, '03/06/2016', '03/06/2016', 'VIREMENT EN VOTRE FAVEUR DE CNSS', '108277', '0.00', '200.00', '_', 10, 1, NULL, NULL, NULL, NULL),
(706, '04/06/2016', '03/06/2016', 'RETRAIT GAB AL KISSARIAT VILLE DE NADOR HEURE : 14:29:19', '0H4520', '1000.00', '0.00', '_', 10, 0, NULL, NULL, NULL, NULL),
(707, '05/06/2016', '05/06/2016', 'COTISATIONS PERIODIQUES DU CONTRAT D''EPARGNE RETRAITE MCMA-BP', '92227', '2575.00', '0.00', '_', 10, 0, NULL, NULL, NULL, NULL),
(708, '05/06/2016', '05/06/2016', 'COTISATIONS PERIODIQUES DU CONTRAT D''EPARGNE RETRAITE MCMA-BP', '204755', '206.00', '0.00', '_', 10, 0, NULL, NULL, NULL, NULL),
(709, '05/06/2016', '03/06/2016', 'RETRAIT GAB MEDITERRANEE VILLE DE NADOR HEURE : 10:48:32', '0Y7739', '1000.00', '0.00', '_', 10, 0, NULL, NULL, NULL, NULL),
(710, '06/06/2016', '03/06/2016', 'CHEQUE N 4165976 PAYE EN FAVEUR DE AMAR BENAMAR', '165976', '9000.00', '0.00', '_', 10, 0, NULL, NULL, NULL, NULL),
(711, '06/06/2016', '03/06/2016', 'ORDRE DE VIREMENT PERMANENT', '446475', '200.00', '0.00', '_', 10, 0, NULL, NULL, NULL, NULL),
(712, '10/06/2016', '09/06/2016', 'RETRAIT GAB ASSAADA VILLE DE NADOR HEURE : 14:19:36', '0U1424', '2000.00', '0.00', '_', 10, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_salaires_projet`
--

CREATE TABLE IF NOT EXISTS `t_salaires_projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salaire` decimal(12,2) DEFAULT NULL,
  `nombreJours` decimal(12,2) DEFAULT NULL,
  `dateOperation` date DEFAULT NULL,
  `idEmploye` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `t_salaires_projet`
--

INSERT INTO `t_salaires_projet` (`id`, `salaire`, `nombreJours`, `dateOperation`, `idEmploye`) VALUES
(1, '230.00', '100.00', '2015-10-20', 2);

-- --------------------------------------------------------

--
-- Structure de la table `t_salaires_societe`
--

CREATE TABLE IF NOT EXISTS `t_salaires_societe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salaire` decimal(12,2) DEFAULT NULL,
  `prime` decimal(12,2) DEFAULT NULL,
  `dateOperation` date DEFAULT NULL,
  `idEmploye` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_task`
--

CREATE TABLE IF NOT EXISTS `t_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) DEFAULT NULL,
  `content` text,
  `status` int(12) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `t_task`
--

INSERT INTO `t_task` (`id`, `user`, `content`, `status`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(2, 'abdou', 'test', 0, '2015-12-01 05:17:25', 'mouaad', NULL, NULL),
(8, 'admin', 'les bl ont &eacute;t&eacute; saisies', 1, '2015-12-02 01:32:07', 'mouaad', '2015-12-11 05:28:13', 'admin'),
(10, 'mouaad', 'compl&eacute;ter les BL de Westmat', 1, '2015-12-03 12:51:34', 'admin', '2015-12-24 03:57:31', 'mouaad'),
(13, 'mouaad', 'imp', 1, '2015-12-11 05:26:54', 'admin', '2015-12-11 05:27:27', 'mouaad'),
(14, 'admin', 'imp valide', 1, '2015-12-11 05:27:49', 'mouaad', '2015-12-11 05:28:10', 'admin'),
(16, 'mouaad', 'imprimer les &eacute;tats de sorties', 1, '2015-12-11 10:59:44', 'admin', '2015-12-24 03:57:35', 'mouaad'),
(17, 'mouaad', 'IMPRIMER BON n 90900', 1, '2016-06-18 04:22:31', 'admin', '2015-12-24 03:57:40', 'mouaad');

-- --------------------------------------------------------

--
-- Structure de la table `t_terrain`
--

CREATE TABLE IF NOT EXISTS `t_terrain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prix` decimal(12,2) DEFAULT NULL,
  `vendeur` varchar(100) DEFAULT NULL,
  `fraisAchat` decimal(12,2) DEFAULT NULL,
  `superficie` decimal(12,2) DEFAULT NULL,
  `emplacement` text,
  `idProjet` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `t_terrain`
--

INSERT INTO `t_terrain` (`id`, `prix`, `vendeur`, `fraisAchat`, `superficie`, `emplacement`, `idProjet`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(2, '320000.00', 'Outman jaloun', '180000.00', '280.00', 'Hay al matar', 15, NULL, NULL, NULL, NULL),
(3, '2000000.00', 'test', '10000.00', '200.00', 'onda', 15, '2015-12-12 03:03:36', 'admin', NULL, NULL),
(5, '1400000.00', 'selam nadiro', '15000.00', '500.00', 'Rue El Ouehda 4093 Nador', 18, '2015-12-31 03:06:24', 'mido', '2015-12-31 03:15:11', 'mido');

-- --------------------------------------------------------

--
-- Structure de la table `t_todo`
--

CREATE TABLE IF NOT EXISTS `t_todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `todo` varchar(255) DEFAULT NULL,
  `priority` int(2) DEFAULT NULL,
  `status` int(12) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `t_todo`
--

INSERT INTO `t_todo` (`id`, `todo`, `priority`, `status`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1, 'zer', 0, 0, '2016-05-05 04:28:46', 'abdessamad', NULL, NULL),
(3, 'azeazeazeazesdfsdfsdfsdf', 0, 0, '2016-05-05 04:31:46', 'mouaad', NULL, NULL),
(6, 'ataktak atikawa', 0, 0, '2016-05-05 04:33:55', 'mouaad', NULL, NULL),
(7, 'sdf', 0, 0, '2016-05-05 04:34:04', 'mouaad', NULL, NULL),
(8, 'sdf', 0, 0, '2016-05-05 04:34:08', 'mouaad', NULL, NULL),
(9, 'sdf', 0, 0, '2016-05-05 04:34:10', 'mouaad', NULL, NULL),
(10, 'sdfsdfsdfsdfsdf', 0, 0, '2016-05-05 04:34:13', 'mouaad', NULL, NULL),
(11, 'm', 0, 0, '2016-05-05 04:34:17', 'mouaad', NULL, NULL),
(12, 'l', 0, 0, '2016-05-05 04:34:19', 'mouaad', NULL, NULL),
(13, 'k', 0, 0, '2016-05-05 04:34:21', 'mouaad', NULL, NULL),
(14, 'aze', 1, 0, '2016-05-09 04:32:18', 'admin', '2016-05-09 04:53:47', 'admin'),
(18, 'Changer adresse bancaire', 0, 0, '2016-05-09 04:36:12', 'admin', '2016-05-09 04:53:42', 'admin'),
(19, 'Demander num&eacute;ro du comptable', 0, 0, '2016-05-09 04:36:15', 'admin', '2016-05-09 04:53:38', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `t_typecharge`
--

CREATE TABLE IF NOT EXISTS `t_typecharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `t_typecharge`
--

INSERT INTO `t_typecharge` (`id`, `nom`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1, 'Transport', '2015-11-06 07:53:23', 'admin', NULL, NULL),
(2, 'Construction', '2015-11-06 07:57:53', 'admin', NULL, NULL),
(3, 'Finition', '2015-11-06 07:57:59', 'admin', NULL, NULL),
(4, 'Hygiene', '2015-11-06 07:58:17', 'admin', NULL, NULL),
(5, 'Employes', '2015-11-24 02:31:01', 'admin', NULL, NULL),
(6, 'Gros Oeuvre', '2015-11-24 03:21:15', 'admin', NULL, NULL),
(7, 'Comptabilit&eacute;', '2015-11-24 03:25:56', 'admin', NULL, NULL),
(8, 'Frais administratifs', '2015-11-24 03:26:24', 'admin', NULL, NULL),
(9, 'Publicite', '2015-11-24 03:31:55', 'admin', '2015-12-04 06:49:19', 'mouaad'),
(10, 'Primes', '2015-12-04 07:05:48', 'mouaad', NULL, NULL),
(11, 'Transport', '2016-01-06 12:23:18', 'admin', NULL, NULL),
(12, 'NOTAIRE &amp; FRAIS D''ENREGISTREMENT', '2016-01-16 09:25:32', 'admin', NULL, NULL),
(13, 'NOTAIRE-FRAIS-ENREGISTREMENTS', '2016-01-16 09:50:13', 'admin', NULL, NULL),
(14, 'TESTRON', '2016-03-31 01:01:44', 'admin', NULL, NULL),
(15, 'RRRRRRRR', '2016-05-09 05:45:57', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_typecharge_commun`
--

CREATE TABLE IF NOT EXISTS `t_typecharge_commun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `t_typecharge_commun`
--

INSERT INTO `t_typecharge_commun` (`id`, `nom`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(12, 'Tresorerie', '2016-01-11 11:05:00', 'admin', '2016-01-11 11:05:13', 'admin'),
(13, 'Agence Marchica', '2016-01-11 11:25:18', 'admin', NULL, NULL),
(14, 'Publicite', '2016-03-14 09:44:54', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `profil` varchar(30) NOT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `t_user`
--

INSERT INTO `t_user` (`id`, `login`, `password`, `created`, `profil`, `status`) VALUES
(1, 'admin', 'admina', '2015-10-18', 'admin', 1),
(2, 'mouaad', '1234', '2015-10-18', 'admin', 1),
(3, 'Secretaire', 'secretaire', '2015-10-20', 'user', 1),
(4, 'abdou', 'abdou', '2015-10-26', 'manager', 1),
(5, 'mido', 'mido', '2015-12-31', 'consultant', 1),
(6, 'user', 'user', '2016-01-07', 'admin', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
