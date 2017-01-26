-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 26 Janvier 2017 à 10:37
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mnhn`
--

--CREATE DATABASE MNHN;


-- --------------------------------------------------------

--
-- Structure de la table `donnee`
--

CREATE TABLE `donnee` (
  `id_donnee` int(11) NOT NULL,
  `nomfichier_donnee` varchar(25) NOT NULL,
  `commentaire_donnee` text,
  `actif_donnee` tinyint(1) NOT NULL,
  `datecreation_donnee` date NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_projet` int(11) NOT NULL,
  `id_reftypedonnee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id_projet` int(11) NOT NULL,
  `libelle_projet` varchar(25) NOT NULL,
  `commentaire_projet` text,
  `actif_projet` tinyint(1) NOT NULL,
  `datecreation_projet` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `projet2refexperience`
--

CREATE TABLE `projet2refexperience` (
  `id_projet` int(11) NOT NULL,
  `id_refexperience` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `projet2utilisateur`
--

CREATE TABLE `projet2utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_projet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `refexperience`
--

CREATE TABLE `refexperience` (
  `id_refexperience` int(11) NOT NULL,
  `libelle_refexperience` varchar(25) NOT NULL,
  `commentaire_refexperience` text,
  `actif_refexperience` tinyint(1) NOT NULL,
  `datecreation_refexperience` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `reftypedonnee`
--

CREATE TABLE `reftypedonnee` (
  `id_reftypedonnee` int(11) NOT NULL,
  `libelle_reftypedonnee` varchar(25) NOT NULL,
  `commentaire_reftypedonnee` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom_utilisateur` varchar(35) NOT NULL,
  `prenom_utilisateur` varchar(35) NOT NULL,
  `mail_utilisateur` varchar(50) NOT NULL,
  `motdepasse_utilisateur` varchar(25) NOT NULL,
  `actif_utilisateur` tinyint(1) NOT NULL,
  `datecreation_utilisateur` date NOT NULL,
  `admin_utilisateur` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `donnee`
--
ALTER TABLE `donnee`
  ADD PRIMARY KEY (`id_donnee`),
  ADD KEY `FK_Donnee_id_utilisateur` (`id_utilisateur`),
  ADD KEY `FK_Donnee_id_projet` (`id_projet`),
  ADD KEY `FK_Donnee_id_reftypedonnee` (`id_reftypedonnee`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id_projet`),
  ADD UNIQUE KEY `libelle_projet` (`libelle_projet`);

--
-- Index pour la table `projet2refexperience`
--
ALTER TABLE `projet2refexperience`
  ADD PRIMARY KEY (`id_projet`,`id_refexperience`),
  ADD KEY `FK_Projet2RefExperience_id_refexperience` (`id_refexperience`);

--
-- Index pour la table `projet2utilisateur`
--
ALTER TABLE `projet2utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`,`id_projet`),
  ADD KEY `FK_Projet2Utilisateur_id_projet` (`id_projet`);

--
-- Index pour la table `refexperience`
--
ALTER TABLE `refexperience`
  ADD PRIMARY KEY (`id_refexperience`),
  ADD UNIQUE KEY `libelle_refexperience` (`libelle_refexperience`);

--
-- Index pour la table `reftypedonnee`
--
ALTER TABLE `reftypedonnee`
  ADD PRIMARY KEY (`id_reftypedonnee`),
  ADD UNIQUE KEY `libelle_reftypedonnee` (`libelle_reftypedonnee`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `donnee`
--
ALTER TABLE `donnee`
  MODIFY `id_donnee` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id_projet` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `refexperience`
--
ALTER TABLE `refexperience`
  MODIFY `id_refexperience` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `reftypedonnee`
--
ALTER TABLE `reftypedonnee`
  MODIFY `id_reftypedonnee` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `donnee`
--
ALTER TABLE `donnee`
  ADD CONSTRAINT `FK_Donnee_id_projet` FOREIGN KEY (`id_projet`) REFERENCES `projet` (`id_projet`),
  ADD CONSTRAINT `FK_Donnee_id_reftypedonnee` FOREIGN KEY (`id_reftypedonnee`) REFERENCES `reftypedonnee` (`id_reftypedonnee`),
  ADD CONSTRAINT `FK_Donnee_id_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `projet2refexperience`
--
ALTER TABLE `projet2refexperience`
  ADD CONSTRAINT `FK_Projet2RefExperience_id_projet` FOREIGN KEY (`id_projet`) REFERENCES `projet` (`id_projet`),
  ADD CONSTRAINT `FK_Projet2RefExperience_id_refexperience` FOREIGN KEY (`id_refexperience`) REFERENCES `refexperience` (`id_refexperience`);

--
-- Contraintes pour la table `projet2utilisateur`
--
ALTER TABLE `projet2utilisateur`
  ADD CONSTRAINT `FK_Projet2Utilisateur_id_projet` FOREIGN KEY (`id_projet`) REFERENCES `projet` (`id_projet`),
  ADD CONSTRAINT `FK_Projet2Utilisateur_id_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;