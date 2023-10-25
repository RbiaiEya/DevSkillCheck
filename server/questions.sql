-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 11 sep. 2023 à 21:27
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbdevskillcheck`
--

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `option1` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `option2` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `option3` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `option4` text COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id`, `question`, `answer`, `option1`, `option2`, `option3`, `option4`) VALUES
(1, 'What does HTML stand for?', 'C. Hyper Text Markup Language', 'A. Hyper Type Multi language', 'B. Hyper Text Multiple language', 'C. Hyper Text Markup Language', 'D. Home Text  Multi language'),
(2, 'What does CSS stand for?', 'A. Cascading Style Sheet', 'A. Cascading Style Sheet', 'B. Cute Style Sheet', 'C. Computer Style Sheet', 'D. Codehal Style Sheet'),
(3, 'What does PHP stand for?', 'A .Hypertext Preprocessor', 'A .Hypertext Preprocessor', 'B. Hometext Programming', 'C. Hypertext Preprogramming', 'D. Programming Hypertext Preprocessor'),
(4, 'What does SQL stand for?', 'D. Structured Query Language', 'A. Strenght Query Language', 'B. Stylesheet Query Language', 'C. Science Question Language', 'D. Structured Query Language'),
(5, 'What does XML stand for?', 'D. Extensible Markup Language', 'A. Excellent Multiple Language', 'B. Explore Multiple Language', 'C. Extra Markup Language', 'D. Extensible Markup Language');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
