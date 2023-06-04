-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 04 juin 2023 à 13:02
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `articles`
--

-- --------------------------------------------------------

--
-- Structure de la table `achatimmediat`
--

DROP TABLE IF EXISTS `achatimmediat`;
CREATE TABLE IF NOT EXISTS `achatimmediat` (
  `ID_article` int(11) NOT NULL,
  `ID_vendeur` int(11) NOT NULL,
  `Notifications` varchar(255) NOT NULL,
  `Prix` int(11) NOT NULL,
  `NouveauPrix` int(11) NOT NULL,
  `ID_acheteur` int(11) DEFAULT NULL,
  `Nom` varchar(255) NOT NULL,
  `Photo` varchar(255) NOT NULL,
  `typeArticle` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Video` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_article`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `achatimmediat`
--

INSERT INTO `achatimmediat` (`ID_article`, `ID_vendeur`, `Notifications`, `Prix`, `NouveauPrix`, `ID_acheteur`, `Nom`, `Photo`, `typeArticle`, `Description`, `Video`) VALUES
(1, 1, 'disponible', 10600, 10600, 0, 'DO OLIVAL', 'images/Jaeger4.JPG', 0, 'Jaeger-le-Coultre monoface reverso', 'blabla.gif'),
(2, 1, 'disponible', 16550, 16550, 0, 'DO OLIVAL', 'images/Jaeger1.PNG', 0, 'Jaeger-le-Coultre monoface reverso', 'blabla.gif'),
(3, 2, 'disponible', 10500, 10500, 4, 'CORDONNIER', 'images/Jaeger3.PNG', 0, 'Jaeger-le-Coultre monoface reverso', 'blabla.gif'),
(4, 2, 'disponible', 27000, 27000, 0, 'CORDONNIER', 'images/Jaeger2.PNG', 0, 'Jaeger-le-Coultre monoface reverso', 'blabla.gif'),
(5, 3, 'disponible', 90000, 90000, 0, 'RUHOMUTALLY', 'images/patek2.JPG', 0, 'Patek Philippe Calatrava', 'blabla.gif'),
(6, 3, 'disponible', 150000, 150000, 1, 'RUHOMUTALLY', 'images/patek3.PNG', 0, 'Patek Philippe Nautilus', 'blabla.gif'),
(7, 4, 'disponible', 1000, 550, 4, 'Pernaut', 'images/IMG_2060.JPG', 2, 'Article Test', 'blabla.gif'),
(8, 4, 'disponible', 3, 3, 0, 'Pernaut', 'images/IMG_4981.JPG', 2, 'cacaprou', 'blabla.gif'),
(9, 4, 'disponible', 1000, 1000, 0, 'Pernaut', 'images/photo.png', 2, 'Un bo marchÃ©', 'blabla.gif');

-- --------------------------------------------------------

--
-- Structure de la table `achatreduit`
--

DROP TABLE IF EXISTS `achatreduit`;
CREATE TABLE IF NOT EXISTS `achatreduit` (
  `ID_article` int(11) NOT NULL,
  `ID_vendeur` int(11) NOT NULL,
  `Prix` int(11) NOT NULL,
  `PrixReduit` int(11) NOT NULL,
  `ID_acheteur` int(11) DEFAULT NULL,
  `Photo` varchar(255) NOT NULL,
  `typeArticle` int(11) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `Video` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_article`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `achatreduit`
--

INSERT INTO `achatreduit` (`ID_article`, `ID_vendeur`, `Prix`, `PrixReduit`, `ID_acheteur`, `Photo`, `typeArticle`, `Description`, `Video`) VALUES
(7, 4, 1000, 550, NULL, 'images/IMG_2060.JPG', 0, 'Article Test', 'blabla.gif');

-- --------------------------------------------------------

--
-- Structure de la table `encheres`
--

DROP TABLE IF EXISTS `encheres`;
CREATE TABLE IF NOT EXISTS `encheres` (
  `ID_article` int(11) NOT NULL,
  `ID_vendeur` int(11) NOT NULL,
  `ID_acheteur` int(11) DEFAULT NULL,
  `Prix_initial` int(255) NOT NULL,
  `Prix_Actuel` int(255) NOT NULL,
  `NomProduit` varchar(255) NOT NULL,
  `Heure_Deb` time NOT NULL,
  `Heure_Fin` time NOT NULL,
  `Photo` varchar(255) NOT NULL,
  `Duree` varchar(255) NOT NULL,
  `typeArticle` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Video` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_article`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `encheres`
--

INSERT INTO `encheres` (`ID_article`, `ID_vendeur`, `ID_acheteur`, `Prix_initial`, `Prix_Actuel`, `NomProduit`, `Heure_Deb`, `Heure_Fin`, `Photo`, `Duree`, `typeArticle`, `Description`, `Video`) VALUES
(1, 0, 0, 11957, 12000, 'Bague Shandra Emeraude AA', '20:00:00', '04:00:00', 'Bague Shandra Emeraude AA.JPG', '8', 2, 'GLAMIRA Bague Shandra, Style Pierre imposante avec Emeraude qualité AA ', 'blabla.gif'),
(2, 0, 4, 73200, 96000, 'ROYAL OAK DOUBLE BALANCIER SQUELETTE', '12:00:00', '20:00:00', 'AP Royal Oak OpenWorked.JPG', '8', 2, 'La Royal Oak Double balancier Squelette résout les problèmes de stabilisation en intégrant un deuxième ensemble balancier-spiral sur le même axe.', 'blabla.gif'),
(3, 0, 0, 390000, 390000, 'Jacob & Co. Astronomia', '04:00:00', '12:00:00', 'Jacob & Co Astronomia.JPG', '8', 2, 'La ligne Astronomia Solar consiste essentiellement à mettre le soleil à son emplacement légitime, à savoir au centre de notre univers et donc au centre du cadran, sous la forme d’une citrine d’1,5 carat de taille Jacob®.', 'blabla.gif');

-- --------------------------------------------------------

--
-- Structure de la table `negociationvendeurclient`
--

DROP TABLE IF EXISTS `negociationvendeurclient`;
CREATE TABLE IF NOT EXISTS `negociationvendeurclient` (
  `ID_article` int(11) NOT NULL,
  `ID_vendeur` int(11) NOT NULL,
  `PrixDebut` int(11) NOT NULL,
  `PrixFin` int(11) NOT NULL,
  `NombreNegociations` int(11) NOT NULL,
  `EtatNegociation` int(11) NOT NULL,
  `ID_acheteur` int(11) DEFAULT NULL,
  `Nom` varchar(255) NOT NULL,
  `Photo` varchar(255) NOT NULL,
  `typeArticle` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Video` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_article`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
