-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 07 Juin 2017 à 09:49
-- Version du serveur :  10.1.19-MariaDB
-- Version de PHP :  5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_planning`
--

-- --------------------------------------------------------

--
-- Structure de la table `color`
--

CREATE TABLE `color` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `color`
--

INSERT INTO `color` (`id`, `name`, `hex`) VALUES
(1, 'Blanc', '#FFFFFF'),
(2, 'Bleu', '#8EC9E2'),
(3, 'Vert', '#91F08E'),
(4, 'Orange', '#FFC966');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_05_11_062800_create_all_tables', 1);

-- --------------------------------------------------------

--
-- Structure de la table `msp`
--

CREATE TABLE `msp` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initials` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `msp`
--

INSERT INTO `msp` (`id`, `firstname`, `lastname`, `initials`) VALUES
(1, 'Stéphane', 'Pottier', 'SP'),
(2, 'Joseph', 'Dupont', 'JD'),
(25, 'Jean', 'Robert', 'JR'),
(26, 'Bernard', 'Joubert', 'BJ');

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

CREATE TABLE `task` (
  `id` int(10) UNSIGNED NOT NULL,
  `worker_id` int(10) UNSIGNED NOT NULL,
  `workshop_level_3_id` int(10) UNSIGNED NOT NULL,
  `isMorning` tinyint(1) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `task`
--

INSERT INTO `task` (`id`, `worker_id`, `workshop_level_3_id`, `isMorning`, `date`) VALUES
(29, 14, 30, 0, '2017-05-15'),
(33, 13, 31, 1, '2017-05-15'),
(34, 14, 35, 1, '2017-05-15'),
(35, 13, 38, 0, '2017-05-17'),
(36, 12, 32, 1, '2017-05-15'),
(37, 12, 33, 1, '2017-05-15'),
(38, 12, 36, 1, '2017-05-15'),
(39, 12, 36, 1, '2017-05-15'),
(40, 12, 36, 1, '2017-05-15'),
(41, 12, 36, 1, '2017-05-15'),
(71, 13, 31, 0, '2017-05-22'),
(96, 14, 32, 0, '2017-05-30'),
(104, 12, 30, 0, '2017-05-30'),
(109, 12, 30, 0, '2017-05-29'),
(110, 2, 30, 1, '2017-05-29'),
(111, 13, 30, 1, '2017-05-30'),
(114, 13, 30, 0, '2017-06-01'),
(115, 12, 31, 1, '2017-05-29'),
(116, 13, 32, 1, '2017-05-29'),
(117, 14, 33, 1, '2017-05-29'),
(118, 2, 31, 0, '2017-05-29'),
(119, 13, 32, 0, '2017-05-29'),
(120, 14, 33, 0, '2017-05-29'),
(121, 2, 38, 1, '2017-06-01'),
(122, 12, 35, 1, '2017-05-31'),
(123, 12, 36, 1, '2017-05-30'),
(124, 2, 37, 1, '2017-05-30'),
(125, 13, 37, 0, '2017-06-02'),
(126, 14, 38, 1, '2017-06-02'),
(127, 2, 36, 0, '2017-05-30'),
(129, 14, 35, 1, '2017-05-30'),
(131, 2, 30, 1, '2017-05-31'),
(132, 12, 30, 0, '2017-05-31'),
(134, 12, 30, 0, '2017-06-02'),
(135, 2, 30, 0, '2017-06-02');

-- --------------------------------------------------------

--
-- Structure de la table `worker`
--

CREATE TABLE `worker` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `msp_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `worker`
--

INSERT INTO `worker` (`id`, `firstname`, `lastname`, `username`, `percentage`, `created_at`, `updated_at`, `msp_id`) VALUES
(2, 'Pierre', 'Bolomey', 'Pierre_Bolomey', 90, '2017-05-10 22:00:00', '2017-05-10 22:00:00', 1),
(12, 'Jean', 'Pierre', 'Jean_Pierre', 50, '2017-05-12 09:38:07', '2017-05-12 09:38:07', 2),
(13, 'Albert', 'Dumoulin', 'Albert_Dumoulin', 60, '2017-05-15 05:02:10', '2017-05-15 05:02:10', 2),
(14, 'Jacques', 'Dupond', 'Jacques_Dupond', 50, '2017-05-17 12:23:09', '2017-05-17 12:23:09', 1);

-- --------------------------------------------------------

--
-- Structure de la table `workshop_level_1`
--

CREATE TABLE `workshop_level_1` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `workshop_level_1`
--

INSERT INTO `workshop_level_1` (`id`, `name`, `color_id`) VALUES
(12, 'Atelier Services et prestations sociales', 2),
(14, 'Atelier Grain de Sel', 3),
(15, 'Aterlier Général', 4);

-- --------------------------------------------------------

--
-- Structure de la table `workshop_level_2`
--

CREATE TABLE `workshop_level_2` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workshop_level_1_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `workshop_level_2`
--

INSERT INTO `workshop_level_2` (`id`, `name`, `workshop_level_1_id`) VALUES
(11, 'Secrétariat-récéption', 12),
(12, 'Animation', 12),
(14, 'Cuisine', 14),
(15, 'Cafeteria', 14),
(16, 'Production', 15),
(17, 'Entretien', 15);

-- --------------------------------------------------------

--
-- Structure de la table `workshop_level_3`
--

CREATE TABLE `workshop_level_3` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workshop_level_2_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `workshop_level_3`
--

INSERT INTO `workshop_level_3` (`id`, `name`, `workshop_level_2_id`) VALUES
(30, 'Récéption', 11),
(31, 'Chauffeur', 11),
(32, 'Rédacteur', 11),
(33, 'Animation', 12),
(35, 'Cuisine', 14),
(36, 'Cafeteria', 15),
(37, 'Production', 16),
(38, 'Entretien', 17);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `msp`
--
ALTER TABLE `msp`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_worker_id_foreign` (`worker_id`),
  ADD KEY `task_workshop_level_3_id_foreign` (`workshop_level_3_id`);

--
-- Index pour la table `worker`
--
ALTER TABLE `worker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `worker_msp_id_foreign` (`msp_id`);

--
-- Index pour la table `workshop_level_1`
--
ALTER TABLE `workshop_level_1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workshop_level_1_color_id_foreign` (`color_id`);

--
-- Index pour la table `workshop_level_2`
--
ALTER TABLE `workshop_level_2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workshop_level_2_workshop_level_1_id_foreign` (`workshop_level_1_id`);

--
-- Index pour la table `workshop_level_3`
--
ALTER TABLE `workshop_level_3`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workshop_level_3_workshop_level_2_id_foreign` (`workshop_level_2_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `color`
--
ALTER TABLE `color`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `msp`
--
ALTER TABLE `msp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;
--
-- AUTO_INCREMENT pour la table `worker`
--
ALTER TABLE `worker`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `workshop_level_1`
--
ALTER TABLE `workshop_level_1`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `workshop_level_2`
--
ALTER TABLE `workshop_level_2`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `workshop_level_3`
--
ALTER TABLE `workshop_level_3`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`id`),
  ADD CONSTRAINT `task_workshop_level_3_id_foreign` FOREIGN KEY (`workshop_level_3_id`) REFERENCES `workshop_level_3` (`id`);

--
-- Contraintes pour la table `worker`
--
ALTER TABLE `worker`
  ADD CONSTRAINT `worker_msp_id_foreign` FOREIGN KEY (`msp_id`) REFERENCES `msp` (`id`);

--
-- Contraintes pour la table `workshop_level_1`
--
ALTER TABLE `workshop_level_1`
  ADD CONSTRAINT `workshop_level_1_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`);

--
-- Contraintes pour la table `workshop_level_2`
--
ALTER TABLE `workshop_level_2`
  ADD CONSTRAINT `workshop_level_2_workshop_level_1_id_foreign` FOREIGN KEY (`workshop_level_1_id`) REFERENCES `workshop_level_1` (`id`);

--
-- Contraintes pour la table `workshop_level_3`
--
ALTER TABLE `workshop_level_3`
  ADD CONSTRAINT `workshop_level_3_workshop_level_2_id_foreign` FOREIGN KEY (`workshop_level_2_id`) REFERENCES `workshop_level_2` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
