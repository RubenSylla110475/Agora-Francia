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
-- Base de données : `comptes`
--

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `ID_Notif` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Profil` int(255) NOT NULL,
  `Messages` text NOT NULL,
  `Temps` datetime NOT NULL,
  PRIMARY KEY (`ID_Notif`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`ID_Notif`, `ID_Profil`, `Messages`, `Temps`) VALUES
(5, 1, 'L\'article : Patek Philippe Nautilus Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-04 00:32:43'),
(4, 1, 'L\'article : Jaeger-le-Coultre monoface reverso Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-03 23:43:10'),
(3, 1, 'L\'article : cacamiam Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-03 23:42:54'),
(2, 1, 'L\'article : Jaeger-le-Coultre monoface reverso Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-03 23:42:45'),
(1, 1, 'L\'article : Jaeger-le-Coultre monoface reverso Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-03 23:39:54'),
(6, 1, 'L\'article : cacamiam Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-04 00:34:00'),
(7, 1, 'L\'article : cacasandra Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-04 00:47:34'),
(8, 1, 'L\'article : Patek Philippe Nautilus Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-04 13:00:54'),
(9, 1, 'L\'article : irisveutquemefaire Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-04 13:06:44'),
(10, 1, 'L\'article : cacasandra Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-04 13:54:54'),
(11, 1, 'L\'article : oui Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-04 13:58:36'),
(12, 1, 'L\'article : Patek Philippe Nautilus Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-04 13:58:49'),
(13, 1, 'L\'article : Lucas comme neuf Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-04 14:03:04'),
(14, 4, 'L\'article : Article Test Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-04 14:21:29'),
(15, 4, 'L\'article : Article Test Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-04 14:21:52'),
(16, 4, 'L\'article : Jaeger-le-Coultre monoface reverso Ã  Ã©tÃ© ajoutÃ© au panier !', '2023-06-04 14:23:02'),
(17, 4, 'Vous avez enchÃ©ri sur l\'articleROYAL OAK DOUBLE BALANCIER SQUELETTEpour la somme de 84000 â‚¬', '2023-06-04 14:47:48'),
(18, 4, 'Vous avez enchÃ©ri sur l\'articleROYAL OAK DOUBLE BALANCIER SQUELETTEpour la somme de 85000 â‚¬', '2023-06-04 14:48:02'),
(19, 4, 'Vous avez enchÃ©ri sur l\'articleROYAL OAK DOUBLE BALANCIER SQUELETTEpour la somme de 96000 â‚¬', '2023-06-04 14:51:55');

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
  `ID_profil` int(11) NOT NULL,
  `Type_compte` int(255) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `Pseudo` varchar(255) NOT NULL,
  `Mail` varchar(255) NOT NULL,
  `PhotoProfil` varchar(255) NOT NULL,
  `PhotoCouverture` varchar(255) NOT NULL,
  `Adresse` varchar(255) DEFAULT NULL,
  `NumeroCB` int(255) DEFAULT NULL,
  `dateExpiration` text,
  `Cryptogramme` int(255) DEFAULT NULL,
  `TypeCarte` varchar(255) DEFAULT NULL,
  `AdresseLigne1` varchar(255) DEFAULT NULL,
  `AdresseLigne2` varchar(255) DEFAULT NULL,
  `Ville` varchar(255) DEFAULT NULL,
  `CodePostal` int(255) DEFAULT NULL,
  `Pays` varchar(255) DEFAULT NULL,
  `NumeroTelephone` text,
  `MotDePasse` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_profil`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`ID_profil`, `Type_compte`, `Nom`, `Prenom`, `Pseudo`, `Mail`, `PhotoProfil`, `PhotoCouverture`, `Adresse`, `NumeroCB`, `dateExpiration`, `Cryptogramme`, `TypeCarte`, `AdresseLigne1`, `AdresseLigne2`, `Ville`, `CodePostal`, `Pays`, `NumeroTelephone`, `MotDePasse`) VALUES
(1, 3, 'Sylla', 'Ruben', 'Ruben_Sylla', 'sylla.ruben@edu.ece.fr', 'images/ruben.jpeg', 'images/graphic_landscape.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 781740946, 'ruben'),
(2, 3, 'DoOlival', 'Timothe', 'Timothe_DoOlival', 'dooloval.timothe@edu.ece.fr', 'images/timothe.jpeg', 'images/bulles wind11.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 762412676, 'timothe'),
(3, 3, 'Cordonnier', 'Iris', 'Iris_Cordonnier', 'cordonnier.iris@edu.ece.fr', 'images/iris.JPG', 'images/IMG_5732.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 787825071, 'iris'),
(4, 3, 'Ruhomutally', 'Lucas', 'Lucas_Ruhomutally', 'ruhomutally.lucas@edu.ece.fr', 'images/lucas.jpg', 'images/IMG_1939.JPG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 602648133, 'lucas');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
