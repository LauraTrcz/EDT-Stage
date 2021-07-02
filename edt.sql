-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 02 juil. 2021 à 15:30
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
(1, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '2021-05-28 15:28:32', 'M. LESAINT', 'UFR-Sciences', 'Licence Pro - Sciences', 'Métiers du commerce international / Marketing et commerce international des vins de terroir ESA', 2019, 'Semestre 1'),
(2, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '2021-05-31 09:46:33', 'M. RICHER', 'UFR-Sciences', 'Licence - Sciences', 'Licence 2 Sciences de la vie et de la terre - CMI -BSV', 2020, 'Semestre 2'),
(3, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '2021-06-21 12:14:00', 'M. RICHER', 'UFR-Sciences', 'Portail L1/L2 - Sciences', 'Licence 1 Sciences, technologies, santé / Portail MPCIE - CMI CE', 2018, 'Période 2'),
(4, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '2021-06-21 12:16:08', 'M. RICHER', 'UFR-Sciences', 'Licence Pro - Sciences', 'Commercialisation de produits alimentaires/ Valorisation innovation transformation de produits alimentaires ESA', 2018, 'Période 2'),
(5, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '2021-06-21 12:16:45', 'M. JAMIN', 'UFR-Sciences', 'Licence - Sciences', 'Licence 3 Informatique', 2020, 'Période 6'),
(6, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '2021-06-21 12:17:05', 'M. JAMIN', 'UFR-Sciences', 'Master - Sciences', 'Mathématiques et Applications / Mathématiques fondamentales et appliquées / Analyse et probabilités', 2020, 'Semestre 2'),
(7, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '2021-06-22 09:42:41', 'M. JAMIN', 'UFR-Sciences', 'Licence Pro - Sciences', 'Métiers du commerce international / Marketing et commerce international des vins de terroir ESA', 2018, 'Période 10'),
(8, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw.xml', '2021-07-01 21:46:49', 'M. RICHER', 'UFR-Sciences', 'Portail L1/L2 - Sciences', 'Licence 1 Sciences, technologies, santé / Portail MPCIE - CMI PSI', 2020, 'Période 1'),
(9, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw.xml', '2021-07-01 23:37:20', 'M. JAMIN', 'UFR-Sciences', 'Master - Sciences', 'Physique Appliquée et Ingénierie Physique /  Photonique signal imagerie', 2015, 'Période 12'),
(10, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '2021-07-01 23:38:15', 'M. RICHER', 'UFR-Sciences', 'Licence - Sciences', 'Licence 3 Chimie - médicaments', 2015, 'Semestre 2'),
(11, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '2021-07-02 00:05:00', 'M. JAMIN', 'UFR-Sciences', 'Master - Sciences', 'Biologie Santé / Neurobiologie Cellulaire et Moléculaire', 2015, 'Période 11'),
(12, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw.xml', '2021-07-02 06:59:33', 'M. RICHER', 'UFR-Sciences', 'Licence - Sciences', 'Licence 1 Double Licence Math-Économie', 2017, 'Période 3'),
(13, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s44_dw.xml', '2021-07-02 11:58:17', 'M. LESAINT', 'UFR-Sciences', 'Licence - Sciences', 'Licence 3 Physique applications', 2016, 'Période 7'),
(14, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '2021-07-02 12:17:22', 'M. JAMIN', 'UFR-Sciences', 'Portail L1/L2 - Sciences', 'Licence 1 Sciences, technologies, santé / Portail MPCIE - Mise à niveau', 2019, 'Période 5'),
(15, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s1.xml', '2021-07-02 13:03:33', 'M. RICHER', 'UFR-Sciences', 'Master - Sciences', 'Bio-géoscience / Paléontologie, paléo-environnement & patrimoine', 2021, 'Semestre 1');

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
  `initTime` float NOT NULL,
  `solveTime` float NOT NULL,
  `variables` int(255) NOT NULL,
  `propagators` int(255) NOT NULL,
  `propagations` int(255) NOT NULL,
  `nodes` int(255) NOT NULL,
  `failures` int(255) NOT NULL,
  `restarts` int(255) NOT NULL,
  `peakDepth` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `solutions`
--

INSERT INTO `solutions` (`id`, `fichier_probleme`, `fichier_solution`, `timestamp_t`, `solver`, `format`, `representation`, `temps_calcul`, `initTime`, `solveTime`, `variables`, `propagators`, `propagations`, `nodes`, `failures`, `restarts`, `peakDepth`) VALUES
(1, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw.xml', 'solution_ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw__2072021_02_13_43.xml', '2021-07-02 00:13:48', 'minizinc', 'dzn', 'intent', '02:11:06', 0.386, 0.017, 14011, 13537, 69148, 38, 0, 0, 37),
(2, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw.xml', 'solution_ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw__2072021_02_24_13.xml', '2021-07-02 00:24:17', 'minizinc', 'dzn', 'intent', '10:10:10', 0.391, 0.015, 14011, 13537, 69148, 38, 0, 0, 37),
(3, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw.xml', 'solution_ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw__2072021_09_00_06.xml', '2021-07-02 07:00:14', 'minizinc', 'dzn', 'intent', '10:00:00', 0.691, 0.018, 14011, 13537, 69148, 38, 0, 0, 37),
(4, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw.xml', 'solution_ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw__2072021_12_09_56.xml', '2021-07-02 10:10:00', 'minizinc', 'dzn', 'intent', '10:20:30', 0.383, 0.017, 14011, 13537, 69148, 38, 0, 0, 37),
(5, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw.xml', 'solution_ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw__2072021_02_20_37.xml', '2021-07-02 12:20:42', 'minizinc', 'dzn', 'intent', '10:10:10', 0.376, 0.015, 14011, 13537, 69148, 38, 0, 0, 37),
(6, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw.xml', 'solution_ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw__2072021_02_28_58.xml', '2021-07-02 12:29:02', 'minizinc', 'dzn', 'intent', '20:20:04', 0.411, 0.018, 14011, 13537, 69148, 38, 0, 0, 37),
(7, 'ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw.xml', 'solution_ua_l3info_20s6_w12d5s8_e0r5t2g4_s45_dw__2072021_03_05_01.xml', '2021-07-02 13:05:05', 'minizinc', 'dzn', 'intent', '00:00:10', 0.38, 0.022, 14011, 13537, 69148, 38, 0, 0, 37);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `solutions`
--
ALTER TABLE `solutions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
