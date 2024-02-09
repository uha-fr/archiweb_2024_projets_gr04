-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 09 fév. 2024 à 09:23
-- Version du serveur : 8.0.31
-- Version de PHP : 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `manger`
--

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

DROP TABLE IF EXISTS `recette`;
CREATE TABLE IF NOT EXISTS `recette` (
  `id` varchar(13) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `id_utilisateur` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `recette`
--

INSERT INTO `recette` (`id`, `nom`, `description`, `id_utilisateur`) VALUES
('1', 'Galette des rois', 'Une bonne galette à la frangipane', NULL),
('2', 'Soupe de poireaux', 'La bonne soupe miam', NULL),
('3', 'Bouillabaisse', 'Un riche ragoût de poisson provençal, la bouillabaisse combine divers poissons et fruits de mer dans un bouillon parfumé au safran. Servie traditionnellement avec une rouille, une sauce à l\'ail et au piment, elle est un pilier de la cuisine méditerranéenne.', NULL),
('4', 'Coq au Vin', 'Un classique de la cuisine française, le coq au vin est un plat mijoté où le poulet est cuit lentement dans du vin rouge avec des lardons, des champignons et des oignons, créant ainsi une sauce riche et profonde.', NULL),
('5', 'Ratatouille', 'Ce plat végétarien originaire de Nice est un mélange coloré d\'aubergines, de courgettes, de poivrons et de tomates, mijoté avec de l\'huile d\'olive et des herbes. Il est souvent servi comme accompagnement ou plat principal.', NULL),
('6', 'Quiche Lorraine', 'Une tarte salée originaire de Lorraine, composée d\'une pâte brisée garnie d\'un appareil à crème et d\'œufs, enrichie de lardons fumés. Elle peut être servie chaude ou froide, idéale pour un repas léger.', NULL),
('7', 'Boeuf Bourguignon', 'Un ragoût de bœuf savoureux, mijoté pendant des heures dans du vin rouge de Bourgogne avec des carottes, des oignons et des champignons. Ce plat est célèbre pour sa profondeur de goût et sa sauce riche.', NULL),
('8', 'Soupe à l\'Oignon', 'Un plat réconfortant, la soupe à l\'oignon est faite de oignons caramélisés lentement cuits dans un bouillon de bœuf, souvent gratinée au four avec des tranches de pain et recouverte de fromage fondu.', NULL),
('10', 'Cassoulet', 'Un riche ragoût de haricots blancs, de saucisses et de viandes variées comme du porc ou du confit de canard. Originaire du sud-ouest de la France, c\'est un plat copieux et réconfortant.', NULL),
('11', 'Salade Niçoise', 'Une salade composée typique de la Côte d\'Azur, elle mélange thon, œufs durs, légumes frais comme des tomates et des haricots verts, avec des olives noires et des anchois, le tout assaisonné d\'une vinaigrette légère.', NULL),
('12', 'Crème Brûlée', 'Un dessert élégant et simple, composé d\'une riche crème custard à la vanille, refroidie et recouverte d\'une couche de sucre caramélisé croquant. La surface caramélisée est souvent brûlée au chalumeau juste avant de servir.', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
