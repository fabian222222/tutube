-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 15 déc. 2020 à 22:30
-- Version du serveur :  5.7.30
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données : `tutube`
--
CREATE DATABASE IF NOT EXISTS `tutube` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tutube`;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nickname`, `mail`, `password`) VALUES
(2, 'maxim', 'maximfaraj@gmail.com', 'fjkhbgezavjreahbgfkihgkh'),
(5, 'gabi', 'gabi@gmail.com', '1234567897r'),
(20, 'fabian', 'fabianzuo@gmail.com', 'salutatoia'),
(21, 'josh', 'josh@gmail.com', 'albertreporter'),
(22, 'yasuo ', 'yasuo@gmail.com', 'hiygughijhftyuhij'),
(23, 'feuka', 'feuka@gmail.com', 'salutatoia');

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `title`, `url`, `comment`) VALUES
(27, 'Sentir', 'https://www.youtube.com/watch?v=0Z7oz2sAyX8', 'Ca sent vraiment bon'),
(28, 'League of Legends ', 'https://www.youtube.com/watch?v=-hsvtnIV2qc', 'Retourne bosser '),
(29, 'Squeezie', 'https://www.youtube.com/watch?v=saRiiB95GFE', 'squeezie'),
(30, 'Squeezie', 'https://www.youtube.com/watch?v=zuDtOgAWADI', 'defgstdqgf');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;