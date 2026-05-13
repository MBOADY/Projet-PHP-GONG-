-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.4.3 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage des données de la table gong.club : ~8 rows (environ)
DELETE FROM `club`;
INSERT INTO `club` (`id_club`, `nom`, `ville`, `latitude`, `longitude`) VALUES
	(1, 'MMA Factory', 'Paris', 48.83400000, 2.38550000),
	(2, 'Boxing Club Niortais', 'Niort', 46.32370000, -0.46480000),
	(3, 'Académie Pythagore', 'Angoulême', 45.64840000, 0.15600000),
	(4, 'Marseille Boxing Club', 'Marseille', 43.29640000, 5.36970000),
	(5, 'FKA - Fight Kombat Academy', 'Lyon', 45.76400000, 4.83560000),
	(6, 'US Métro', 'Antony', 48.75380000, 2.30000000),
	(7, 'Atch Academy', 'Pantin', 48.89500000, 2.40200000),
	(8, 'Karaté Club Toulouse', 'Toulouse', 43.60450000, 1.44400000);

-- Listage des données de la table gong.enseigner : ~18 rows (environ)
DELETE FROM `enseigner`;
INSERT INTO `enseigner` (`id_club`, `id_sport`) VALUES
	(1, 1),
	(3, 1),
	(5, 1),
	(7, 1),
	(2, 2),
	(4, 2),
	(4, 3),
	(3, 4),
	(1, 5),
	(6, 5),
	(5, 6),
	(6, 7),
	(8, 8),
	(1, 10),
	(7, 10),
	(6, 11),
	(8, 12),
	(5, 13);

-- Listage des données de la table gong.envoyer_message : ~2 rows (environ)
DELETE FROM `envoyer_message`;
INSERT INTO `envoyer_message` (`id_message`, `id_expediteur`, `id_destinataire`, `date_envoi`, `contenu`) VALUES
	(1, 3, 29, '2026-05-04 22:13:58', 'salut'),
	(2, 29, 3, '2026-05-04 22:14:46', 'salut');

-- Listage des données de la table gong.pratiquer : ~29 rows (environ)
DELETE FROM `pratiquer`;
INSERT INTO `pratiquer` (`id_utilisateur`, `id_sport`, `experience_annees`, `niveau`) VALUES
	(1, 1, 3, 'Intermédiaire'),
	(3, 1, 5, 'Débutant'),
	(4, 2, 2, 'Intermédiaire'),
	(5, 3, 4, 'Avancé'),
	(6, 1, 1, 'Débutant'),
	(7, 4, 3, 'Intermédiaire'),
	(8, 5, 5, 'Avancé'),
	(9, 6, 0, 'Débutant'),
	(10, 1, 2, 'Intermédiaire'),
	(11, 7, 6, 'Avancé'),
	(12, 2, 1, 'Débutant'),
	(13, 8, 3, 'Intermédiaire'),
	(14, 4, 4, 'Intermédiaire'),
	(15, 3, 8, 'Avancé'),
	(16, 1, 2, 'Intermédiaire'),
	(17, 2, 0, 'Débutant'),
	(18, 6, 5, 'Avancé'),
	(19, 5, 3, 'Intermédiaire'),
	(20, 1, 7, 'Avancé'),
	(21, 4, 1, 'Débutant'),
	(22, 7, 4, 'Intermédiaire'),
	(23, 8, 2, 'Intermédiaire'),
	(24, 3, 6, 'Avancé'),
	(25, 1, 0, 'Débutant'),
	(26, 2, 3, 'Intermédiaire'),
	(27, 6, 5, 'Avancé'),
	(28, 4, 1, 'Débutant'),
	(29, 9, 7, 'Avancé'),
	(30, 1, 0, 'Inconnu');

-- Listage des données de la table gong.session_sparring : ~4 rows (environ)
DELETE FROM `session_sparring`;
INSERT INTO `session_sparring` (`id_session`, `date_creation`, `date_rencontre`, `statut`, `id_demandeur`, `id_partenaire`, `id_club`) VALUES
	(2, '2026-05-04 16:32:42', '2026-06-01 18:00:00', 'En attente', 3, 1, 1),
	(3, '2026-05-04 16:32:43', '2026-06-01 18:00:00', 'En attente', 3, 1, 1),
	(4, '2026-05-04 16:32:44', '2026-06-01 18:00:00', 'En attente', 3, 1, 1),
	(5, '2026-05-04 17:20:14', '2026-06-01 18:00:00', 'Accepté', 29, 3, 1);

-- Listage des données de la table gong.sport : ~13 rows (environ)
DELETE FROM `sport`;
INSERT INTO `sport` (`id_sport`, `nom_sport`) VALUES
	(1, 'MMA'),
	(2, 'Boxe Anglaise'),
	(3, 'Muay Thai'),
	(4, 'Jiu-Jitsu Brésilien'),
	(5, 'Lutte'),
	(6, 'Kickboxing'),
	(7, 'Judo'),
	(8, 'Karaté'),
	(9, 'Taekwondo'),
	(10, 'Grappling'),
	(11, 'Sambo'),
	(12, 'Self-défense'),
	(13, 'K-1');

-- Listage des données de la table gong.utilisateur : ~29 rows (environ)
DELETE FROM `utilisateur`;
INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `ville`, `poids`, `taille`, `stats_publiques`, `date_inscription`, `role`) VALUES
	(1, 'Martin', 'Lucas', 'lucas@test.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Niort', 77, 182, 1, '2026-05-04 14:54:37', 'membre'),
	(3, 'test', 'test', 'test@gmail.com', '$2y$10$UI5cv5kr5xlqKgOXAnY4ge1jwJ89y40wh.tB8qV1.sy037mFTMjxS', 'niort', 50, 190, 1, '2026-05-04 15:42:33', 'membre'),
	(4, 'Lefebvre', 'Thomas', 'thomas.lefebvre@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris', 75, 180, 1, '2026-05-04 16:29:18', 'membre'),
	(5, 'Garcia', 'Julie', 'julie.garcia@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Marseille', 60, 165, 1, '2026-05-04 16:29:18', 'membre'),
	(6, 'Roux', 'Antoine', 'antoine.roux@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lyon', 82, 185, 1, '2026-05-04 16:29:18', 'membre'),
	(7, 'Moreau', 'Clara', 'clara.moreau@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Toulouse', 55, 160, 1, '2026-05-04 16:29:18', 'membre'),
	(8, 'Fournier', 'Maxime', 'maxime.fournier@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Niort', 90, 188, 1, '2026-05-04 16:29:18', 'membre'),
	(9, 'Girard', 'Emma', 'emma.girard@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nantes', 65, 170, 1, '2026-05-04 16:29:18', 'membre'),
	(10, 'Bonnet', 'Hugo', 'hugo.bonnet@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bordeaux', 78, 182, 1, '2026-05-04 16:29:18', 'membre'),
	(11, 'Lambert', 'Chloé', 'chloe.lambert@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lille', 58, 163, 1, '2026-05-04 16:29:18', 'membre'),
	(12, 'Fontaine', 'Paul', 'paul.fontaine@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Strasbourg', 85, 186, 1, '2026-05-04 16:29:18', 'membre'),
	(13, 'Rousseau', 'Léa', 'lea.rousseau@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Rennes', 62, 168, 1, '2026-05-04 16:29:18', 'membre'),
	(14, 'Vincent', 'Arthur', 'arthur.vincent@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris', 72, 175, 1, '2026-05-04 16:29:18', 'membre'),
	(15, 'Muller', 'Camille', 'camille.muller@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Montpellier', 68, 172, 1, '2026-05-04 16:29:18', 'membre'),
	(16, 'Guerin', 'Léo', 'leo.guerin@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Niort', 95, 190, 1, '2026-05-04 16:29:18', 'membre'),
	(17, 'Blanc', 'Sarah', 'sarah.blanc@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Marseille', 54, 158, 1, '2026-05-04 16:29:18', 'membre'),
	(18, 'Garnier', 'Victor', 'victor.garnier@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lyon', 80, 183, 1, '2026-05-04 16:29:18', 'membre'),
	(19, 'Chevalier', 'Manon', 'manon.chevalier@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Toulouse', 66, 171, 1, '2026-05-04 16:29:18', 'membre'),
	(20, 'Francois', 'Nicolas', 'nicolas.francois@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nice', 88, 187, 1, '2026-05-04 16:29:18', 'membre'),
	(21, 'Perez', 'Inès', 'ines.perez@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nantes', 59, 164, 1, '2026-05-04 16:29:18', 'membre'),
	(22, 'Marchand', 'Louis', 'louis.marchand@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bordeaux', 76, 178, 1, '2026-05-04 16:29:18', 'membre'),
	(23, 'Dufour', 'Eva', 'eva.dufour@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lille', 63, 169, 1, '2026-05-04 16:29:18', 'membre'),
	(24, 'Leroy', 'Mathis', 'mathis.leroy@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris', 79, 181, 1, '2026-05-04 16:29:18', 'membre'),
	(25, 'Clement', 'Jade', 'jade.clement@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Strasbourg', 57, 161, 1, '2026-05-04 16:29:18', 'membre'),
	(26, 'Gauthier', 'Nathan', 'nathan.gauthier@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Rennes', 84, 184, 1, '2026-05-04 16:29:18', 'membre'),
	(27, 'Morin', 'Alice', 'alice.morin@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Montpellier', 61, 167, 1, '2026-05-04 16:29:18', 'membre'),
	(28, 'Lemoine', 'Enzo', 'enzo.lemoine@gong.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Niort', 73, 176, 1, '2026-05-04 16:29:18', 'membre'),
	(29, 'boady', 'mathys', 'mathysboady@gmail.com', '$2y$10$ilK4yjj1/Pmh33YK2rr6WuWuaPwk6K7v8OVP6flt/uN9AxiWY9.H6', 'niort', 68, 172, 1, '2026-05-04 17:14:51', 'membre'),
	(30, 'admin', 'admin', 'admin@gong.fr', '$2y$10$Pf.RwbQSN.SI7W5ppVYtYeACHqU2YaQVBwPbFa2sd.4lo5ws1Xnvi', 'niort', 100, 100, 1, '2026-05-11 01:00:55', 'admin');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
