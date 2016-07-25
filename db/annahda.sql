-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 09 Novembre 2015 à 03:23
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `annahda`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_appartement`
--

CREATE TABLE IF NOT EXISTS `t_appartement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `superficie` decimal(10,2) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=456 ;

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
-- Structure de la table `t_caisse_entrees`
--

CREATE TABLE IF NOT EXISTS `t_caisse_entrees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant` decimal(12,2) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `dateOperation` date DEFAULT NULL,
  `utilisateur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_caisse_sorties`
--

CREATE TABLE IF NOT EXISTS `t_caisse_sorties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant` decimal(12,2) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `dateOperation` date DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `utilisateur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=481 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_client`
--

CREATE TABLE IF NOT EXISTS `t_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=308 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_comptebancaire`
--

CREATE TABLE IF NOT EXISTS `t_comptebancaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

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
  `numero` varchar(255) DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `prixVente` decimal(12,2) DEFAULT NULL,
  `avance` decimal(12,2) DEFAULT NULL,
  `modePaiement` varchar(255) DEFAULT NULL,
  `dureePaiement` int(11) DEFAULT NULL,
  `nombreMois` int(11) DEFAULT NULL,
  `echeance` decimal(12,2) DEFAULT NULL,
  `note` text,
  `idClient` int(11) DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  `idBien` int(11) DEFAULT NULL,
  `typeBien` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `numeroCheque` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=418 ;

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_livraison`
--

CREATE TABLE IF NOT EXISTS `t_livraison` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2736 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_livraison_detail`
--

CREATE TABLE IF NOT EXISTS `t_livraison_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) DEFAULT NULL,
  `designation` text,
  `prixUnitaire` decimal(12,2) DEFAULT NULL,
  `quantite` decimal(12,2) DEFAULT NULL,
  `idLivraison` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=671 ;

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
  `mezzanine` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  `par` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

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
  `date` date DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `modePaiement` varchar(255) DEFAULT NULL,
  `idContrat` int(11) DEFAULT NULL,
  `numeroCheque` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1679 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_projet`
--

CREATE TABLE IF NOT EXISTS `t_projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `superficie` decimal(10,2) DEFAULT NULL,
  `description` text,
  `budget` decimal(12,2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(60) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=218 ;

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
