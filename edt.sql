-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 22 juin 2021 à 15:29
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `edt`
--

-- --------------------------------------------------------

--
-- Structure de la table `probleme`
--

CREATE TABLE `probleme` (
  `id` int(11) NOT NULL,
  `fichier` varchar(1000) NOT NULL,
  `date_t` timestamp NOT NULL DEFAULT current_timestamp(),
  `auteur` varchar(50) NOT NULL,
  `composantes` varchar(300) NOT NULL,
  `filiere` varchar(300) NOT NULL,
  `formation` varchar(300) NOT NULL,
  `annee` int(4) NOT NULL,
  `periode` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `probleme`
--

INSERT INTO `probleme` (`id`, `fichier`, `date_t`, `auteur`, `composantes`, `filiere`, `formation`, `annee`, `periode`) VALUES
(17, 'dgfdf', '2021-05-26 11:14:35', 'M. RICHER', 'UFR-Sciences', 'Master Ingénierie - Sciences', 'CMI BSV', 2018, 'Semestre 2'),
(18, 'dgvdg', '2021-05-26 11:14:55', 'M. LESAINT', 'UFR-Sciences', 'Licence - Sciences', 'Licence 3 Biologie cellulaire moléculaire et physiologie', 2020, 'Semestre 1'),
(19, 'yhyg', '2021-05-28 07:50:43', 'M. LESAINT', 'UFR-Sciences', 'Licence Pro - Sciences', 'Maîtrise énergie, électricité, développement durable / Génie thermique', 2016, 'Semestre 1'),
(21, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '2021-05-28 15:28:32', 'M. LESAINT', 'UFR-Sciences', 'Licence Pro - Sciences', 'Métiers du commerce international / Marketing et commerce international des vins de terroir ESA', 2019, 'Semestre 1'),
(23, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '2021-05-31 09:46:33', 'M. RICHER', 'UFR-Sciences', 'Licence - Sciences', 'Licence 2 Sciences de la vie et de la terre - CMI -BSV', 2020, 'Semestre 2'),
(24, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '2021-05-31 19:42:28', 'M. RICHER', 'UFR-Sciences', 'Master Ingénierie - Sciences', 'CMI PSI', 2021, 'Semestre 2'),
(44, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '2021-06-21 12:14:00', 'M. RICHER', 'UFR-Sciences', 'Portail L1/L2 - Sciences', 'Licence 1 Sciences, technologies, santé / Portail MPCIE - CMI CE', 2018, 'P2'),
(47, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '2021-06-21 12:16:08', 'M. RICHER', 'UFR-Sciences', 'Licence Pro - Sciences', 'Commercialisation de produits alimentaires/ Valorisation innovation transformation de produits alimentaires ESA', 2018, 'P2'),
(48, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '2021-06-21 12:16:45', 'M. JAMIN', 'UFR-Sciences', 'Licence - Sciences', 'Licence 3 Informatique', 2020, 'P6'),
(49, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '2021-06-21 12:17:05', 'M. JAMIN', 'UFR-Sciences', 'Master - Sciences', 'Mathématiques et Applications / Mathématiques fondamentales et appliquées / Analyse et probabilités', 2020, 'Semestre 2'),
(50, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '2021-06-22 09:42:41', 'M. JAMIN', 'UFR-Sciences', 'Licence Pro - Sciences', 'Métiers du commerce international / Marketing et commerce international des vins de terroir ESA', 2018, 'P10');

-- --------------------------------------------------------

--
-- Structure de la table `solutions`
--

CREATE TABLE `solutions` (
  `id` int(255) NOT NULL,
  `fichier_probleme` varchar(255) NOT NULL,
  `fichier_solution` varchar(255) NOT NULL,
  `timestamp_t` timestamp NOT NULL DEFAULT current_timestamp(),
  `solver` varchar(100) NOT NULL,
  `format` varchar(100) NOT NULL,
  `representation` varchar(100) NOT NULL,
  `temps_calcul` varchar(10) NOT NULL,
  `stat_2` int(255) NOT NULL,
  `stat_3` int(255) NOT NULL,
  `stat_4` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `solutions`
--

INSERT INTO `solutions` (`id`, `fichier_probleme`, `fichier_solution`, `timestamp_t`, `solver`, `format`, `representation`, `temps_calcul`, `stat_2`, `stat_3`, `stat_4`) VALUES
(1, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '', '2021-06-22 11:23:38', 'minizinc', 'dzn', 'intent', '02:20:02', 0, 0, 0),
(3, 'instance_xml/ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '', '2021-06-22 11:37:05', 'minizinc', 'dzn', 'intent', '19:00:00', 0, 0, 0),
(4, 'instance_xml/ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '', '2021-06-22 11:48:49', 'CHR', 'json', 'extent', '00:10:00', 0, 0, 0),
(5, 'instance_xml/ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '', '2021-06-22 12:01:36', 'minizinc', 'dzn', 'intent', '02:00:00', 0, 0, 0),
(6, 'instance_xml/ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '', '2021-06-22 12:03:28', 'minizinc', 'dzn', 'intent', '02:00:00', 0, 0, 0),
(7, 'instance_xml/ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '', '2021-06-22 12:20:30', 'minizinc', 'dzn', 'intent', '02:00:00', 0, 0, 0),
(8, 'instance_xml/ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '', '2021-06-22 12:21:21', 'minizinc', 'json', 'extent', '02:00:00', 0, 0, 0),
(9, 'instance_xml/ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '', '2021-06-22 12:23:13', 'minizinc', 'dzn', 'intent', '02:00:00', 0, 0, 0),
(10, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '', '2021-06-22 13:20:43', 'minizinc', 'dzn', 'intent', '02:20:00', 0, 0, 0),
(11, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '', '2021-06-22 13:29:43', 'minizinc', 'dzn', 'intent', '02:20:00', 0, 0, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `probleme`
--
ALTER TABLE `probleme`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `solutions`
--
ALTER TABLE `solutions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `probleme`
--
ALTER TABLE `probleme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `solutions`
--
ALTER TABLE `solutions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
