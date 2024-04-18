-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour cinema_elena
CREATE DATABASE IF NOT EXISTS `cinema_elena` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cinema_elena`;

-- Listage de la structure de table cinema_elena. acteur
CREATE TABLE IF NOT EXISTS `acteur` (
  `id_acteur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_acteur`),
  UNIQUE KEY `id_personne` (`id_personne`),
  CONSTRAINT `acteur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_elena.acteur : ~23 rows (environ)
INSERT INTO `acteur` (`id_acteur`, `id_personne`) VALUES
	(1, 1),
	(2, 2),
	(3, 3),
	(4, 4),
	(5, 5),
	(6, 7),
	(7, 8),
	(8, 9),
	(9, 11),
	(10, 12),
	(11, 14),
	(12, 15),
	(13, 16),
	(14, 17),
	(15, 19),
	(16, 21),
	(17, 22),
	(18, 24),
	(19, 25),
	(20, 27),
	(22, 29),
	(23, 30);

-- Listage de la structure de table cinema_elena. contrat
CREATE TABLE IF NOT EXISTS `contrat` (
  `id_film` int NOT NULL,
  `id_acteur` int NOT NULL,
  `id_role` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_acteur`,`id_role`),
  KEY `id_acteur` (`id_acteur`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `contrat_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `contrat_ibfk_2` FOREIGN KEY (`id_acteur`) REFERENCES `acteur` (`id_acteur`),
  CONSTRAINT `contrat_ibfk_3` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_elena.contrat : ~23 rows (environ)
INSERT INTO `contrat` (`id_film`, `id_acteur`, `id_role`) VALUES
	(1, 1, 2),
	(1, 2, 1),
	(1, 3, 3),
	(2, 4, 4),
	(8, 4, 13),
	(11, 4, 20),
	(2, 5, 5),
	(3, 6, 6),
	(3, 7, 7),
	(4, 8, 8),
	(5, 9, 9),
	(5, 10, 10),
	(6, 11, 9),
	(6, 12, 10),
	(7, 13, 11),
	(7, 14, 12),
	(8, 15, 14),
	(9, 16, 15),
	(9, 17, 16),
	(10, 18, 18),
	(10, 19, 17),
	(11, 20, 19),
	(6, 23, 21);

-- Listage de la structure de table cinema_elena.destion_genre
CREATE TABLE IF NOT EXISTS `gestion_genre` (
  `id_film` int NOT NULL,
  `id_genre` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_genre`),
  KEY `id_genre` (`id_genre`),
  CONSTRAINT `gestion_genre_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `gestion_genre_2` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_elena.gestion_genre : ~13 rows (environ)
INSERT INTO `gestion_genre` (`id_film`, `id_genre`) VALUES
	(7, 1),
	(1, 2),
	(4, 2),
	(9, 2),
	(10, 2),
	(8, 3),
	(9, 3),
	(10, 3),
	(4, 4),
	(5, 5),
	(6, 5),
	(2, 6),
	(3, 6);

-- Listage de la structure de table cinema_elena. film
CREATE TABLE IF NOT EXISTS `film` (
  `id_film` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `date_sortie` DATE NOT NULL,
  `duree` int NOT NULL,
  `synopsis` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin  NOT NULL,
  `note` INT NOT NULL,
  `id_realisateur` int NOT NULL,
  `affiche_film` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  PRIMARY KEY (`id_film`),
  KEY `id_realisateur` (`id_realisateur`),
  CONSTRAINT `film_ibfk_1` FOREIGN KEY (`id_realisateur`) REFERENCES `realisateur` (`id_realisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_elena.film : ~11 rows (environ)
INSERT INTO `film` (`id_film`, `titre`, `date_sortie`, `duree`, `synopsis`, `note`, `id_realisateur`, `affiche_film`) VALUES
	(1, 'Million Dollar baby', 2005, 132, '"Maggie en a marre de son boulot de serveuse dans le Missouri. Elle part à Los Angeles pour se mettre à la boxe. Là-bas, elle espère bien se faire entrainer par le respecté Frankie Dunn"\r\n ', 4.4, 1, 'public/img/affiches/millionDollarBaby.jpg'),
	(2, 'Sully', 2016, 96, 'Le 15 janvier 2009, le monde a assisté au "miracle sur l\'"Hudson" accompli par le commandant "Sully" Sullenberger : en effet, celui-ci a réussi à poser son appareil sur les eaux glacées du fleuve Hudson, sauvant ainsi la vie des 155 passagers à bord. Cependant, alors que Sully était salué par l\'opinion publique et les médias pour son exploit inédit dans l\'histoire de l\'aviation, une enquête a été ouverte, menaçant de détruire sa réputation et sa carrière.', 4.1, 1, 'public/img/affiches/sully.jpg'),
	(3, 'Mary Shelley', 2018, 120, 'La famille de Mary Wollstonecraft désapprouve quand elle et le poète Percy Shelley annoncent leur amour l\'un pour l\'autre. La famille est horrifiée lorsqu\'elle constate que le couple s\'est enfui, accompagné de la demi-soeur de Marie, Claire.', 4, 2, 'public/img/affiches/MaryShelley.jpg'),
	(4, 'La jetée', 1962, 28, 'A la suite de la 3e guerre mondiale qui a détruit Paris, un homme cobaye, envoyé dans le passé y rencontre une femme et découvre avec elle le bonheur d\'instants partagés. Devant le succès de ces expériences, on tente alors de l\'acheminer dans le futur.', 4.5, 3, 'public/img/affiches/laJetee.jpg'),
	(5, 'Nosferatu fantôme de la nuit', 1979, 84, 'Lorsqu\'un jeune homme, Jonathan Harker, part en destination de la Transylvanie pour négocier la vente d\'une maison avec le comte Dracula, sa femme Lucy s\'inquiète pour sa sécurité.', 3.5, 4, 'public/img/affiches/nosferatu.jpg'),
	(6, 'Dracula', 1992, 127, 'Transylvanie, 1462. Viad Drakul laisse la belle Elisabeta pour aller guerroyer contre l\'envahisseur turc. Revenu victorieux du combat, il découvre le corps inanimé de sa femme, qui s\'est suicidée à la fausse nouvelle de sa mort. Eperdu de douleur, il abjure sa foi et en appelle aux puissances du sang pour retrouver sa bien-aimée.', 4.2, 5, 'public/img/affiches/dracula.jpg'),
	(7, 'Le Parrain', 1972, 177, 'En 1945, à New York, les Corleone sont une des 5 familles de la mafia. Don Vito Corleone, `parrain\' de cette famille, marie sa fille à un bookmaker. Sollozzo, `parrain\' de la famille Tattaglia, propose à Don Vito une association dans le trafic de drogue, mais celui-ci refuse. Sonny, un de ses fils, y est quant à lui favorable. Afin de traiter avec Sonny, Sollozzo tente de faire tuer Don Vito, mais celui-ci en réchappe.', 4, 5, 'public/img/affiches/leParrain.jpg'),
	(8, 'Forest Gump', 1994, 142, 'Sur un banc, à Savannah, en Géorgie, Forrest Gump attend le bus. Comme celui-ci tarde à venir, le jeune homme raconte sa vie à ses compagnons d\'ennui. A priori, ses capacités intellectuelles plutôt limitées ne le destinaient pas à de grandes choses', 4.6, 6, 'public/img/affiches/forestGump.jpg'),
	(9, 'Le cercle des poètes disparus', 1990, 128, 'Todd Anderson, un garçon plutôt timide, est envoyé dans la prestigieuse académie de Welton, réputée pour être l\'une des plus fermées et austères des États-Unis, là où son frère avait connu de brillantes études. C\'est dans cette université qu\'il va faire la rencontre d\'un professeur de lettres anglaises plutôt étrange, Mr Keating, qui les encourage à toujours refuser l\'ordre établi. ', 4.3, 7, 'public/img/affiches/cercleDesPoetesDisparus.jpg'),
	(10, 'Winter Break', 2023, 133, 'Un instructeur maussade d\'une école préparatoire de la Nouvelle-Angleterre reste sur le campus pendant les vacances de Noël pour garder une poignée d\'étudiants qui n\'ont nulle part où aller.', 4.1, 8, 'public/img/affiches/winterbreak.webp'),
	(11, 'La ligne verte', 1999, 189, 'Paul Edgecomb, pensionnaire centenaire d\'une maison de retraite, est hanté par ses souvenirs. Gardien-chef du pénitencier de Cold Mountain, en 1935, il était chargé de veiller au bon déroulement des exécutions capitales au bloc E (la ligne verte) en s\'efforçant d\'adoucir les derniers moments des condamnés. Parmi eux se trouvait un colosse du nom de John Coffey, accusé du viol et du meurtre de deux fillettes.', 4.6, 9, 'public/img/affiches/ligneVerte.jpg');

-- Listage de la structure de table cinema_elena. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `genre` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_elena.genre : ~6 rows (environ)
INSERT INTO `genre` (`id_genre`, `genre`) VALUES
	(1, 'Action'),
	(2, 'Drame'),
	(3, 'Comedy'),
	(4, 'Sci-Fi'),
	(5, 'Fantastique'),
	(6, 'Biopic');

-- Listage de la structure de table cinema_elena. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id_personne` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `sexe` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `profil` varchar(255) COLLATE utf8mb3_bin DEFAULT NULL,
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_elena.personne : ~30 rows (environ)
INSERT INTO `personne` (`id_personne`, `nom`, `prenom`, `sexe`, `date_naissance`, `profil`) VALUES
	(1, 'Eastwood', 'Clint', 'homme', '1930-05-31', 'Clint Eastwood est un acteur, réalisateur et producteur de cinéma américain'),
	(2, 'Swank', 'Hilary', 'femme', '1974-07-30', 'Hilary Swank est une actrice et productrice américaine'),
	(3, 'Freeman', 'Morgan', 'homme', '1937-06-01', 'Morgan Freeman est un acteur , réalisateur et producteur de cinéma américain'),
	(4, 'Hanks', 'Tom', 'homme', '1956-07-09', 'Tom Hanks est un acteur, réalisateur et producteur de cinéma américano-grec'),
	(5, 'Eckhart', 'Aaron', 'homme', '1968-03-12', ' Aaron Eckhart est un acteur, réalisateur et producteur américain'),
	(6, 'Al-Mansour', 'Haifaa', 'femme', '1974-08-10', 'Haifaa Al-Mansour est une réalisatrice saoudienne'),
	(7, 'Fanning', 'Elle', 'femme', '1998-04-09', ' Elle Fanning est une actrice américaine'),
	(8, 'Booth', 'Douglas', 'homme', '1992-07-09', 'Douglas Booth est un acteur britannique'),
	(9, 'Marker', 'Chris', 'homme', '1921-07-29', 'Chris Marker est un réalisateur, écrivain, illustrateur, traducteur, photographe, éditeur, philosophe, essayiste, critique, poéte et producteur de cinéma français'),
	(10, 'Herzog', 'Werner', 'homme', '1942-09-05', 'Werner Herzog est  un réalisateur, acteur et metteur en scéne allemand'),
	(11, 'Kinski', 'Klaus', 'homme', '1926-10-18', 'Klaus Kinski est un comédien allemand'),
	(12, 'Adjani', 'Isabelle', 'femme', '1955-07-27','Isabelle Adjani est une actrice et chanteuse française' ),
	(13, 'Coppola', 'Francis', 'homme', '1939-04-07', 'Francis Ford Coppola est un réalisateur, producteur de cinéma et scénariste américain'),
	(14, 'Oldman', 'Gary', 'homme', '1958-03-21', 'Gary Oldman est un acteur, réalisateur, scénariste et producteur britannique naturalisé américain'),
	(15, 'Frost', 'Sadie', 'femme', '1965-06-15', 'Sadie Frost est une actrice britannique'),
	(16, 'Pacino', 'Alfredo', 'homme', '1940-04-25', 'Alfredo Pacino, dit Al Pacino, est un acteur, réalisateur, scénariste et producteur de cinéma américain'),
	(17, 'Brando', 'Marlon', 'homme', '1924-04-03', 'Marlon Brando est un acteur et réalisateur américain'),
	(18, 'Zemeckis', 'Robert', 'homme', '1952-05-14', 'Robert Zemeckis est un réalisateur, producteur et scénariste américain'),
	(19, 'Wright', 'Robin', 'femme', '1966-04-08', 'Robin Wright est une actrice et réalisatrice américaine'),
	(20, 'Weir', 'Peter', 'homme', '1944-08-21', 'Peter Weir est un réalisateur, scénariste et producteur australien'),
	(21, 'Williams', 'Robin', 'homme', '1951-07-21', 'Robin Willams est un acteur, humoriste et producteur américain'),
	(22, 'Hawke', 'Ethan', 'homme', '1970-11-06', 'Ethan Hawke est un acteur, écrivain, réalisateur et scénariste américain'),
	(23, 'Payne', 'Alexander', 'homme', '1961-02-10', 'Alexander Payne est un réalisateur, scénariste et producteur américain'),
	(24, 'Giamitti', 'Paul', 'homme', '1967-06-06', 'Paul Giamitti est un acteur américain'),
	(25, 'Randolph', 'Da\'Vine Joy', 'femme', '1986-05-21', 'Da\'Vine Joy Randolph est une actrice et chanteuse américaine'),
	(26, 'Darabont', 'Frank', 'homme', '1959-01-28', 'Frank Darabont est un réalisateur, scénariste, producteur, compositeur, musicien et acteur de cinéma américain'),
	(27, 'Duncan', 'Michael', 'homme', '1957-12-10', 'Michael Clarke Dunkan est un acteur américain'),
	(29, 'Robbie', 'Margot', 'femme', '1990-07-02', 'Margot Robbie est une actrice et productrice de cinéma australienne'),
	(30, 'Ryder', 'Winona', 'femme', '1971-10-29', 'Winona Laura Horowitz, dite Winona Ryder, est une actrice, productrice et réalisatrice américaine');

-- Listage de la structure de table cinema_elena. realisateur
CREATE TABLE IF NOT EXISTS `realisateur` (
  `id_realisateur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_realisateur`),
  UNIQUE KEY `id_personne` (`id_personne`),
  CONSTRAINT `realisateur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_elena.realisateur : ~9 rows (environ)
INSERT INTO `realisateur` (`id_realisateur`, `id_personne`) VALUES
	(1, 1),
	(2, 6),
	(3, 9),
	(4, 10),
	(5, 13),
	(6, 18),
	(7, 20),
	(8, 23),
	(9, 26);

-- Listage de la structure de table cinema_elena.role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `nom_personnage` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Listage des données de la table cinema_elena.role : ~21 rows (environ)
INSERT INTO `role` (`id_role`, `nom_personnage`) VALUES
	(1, 'Maggie'),
	(2, 'Frankie Dunn'),
	(3, 'Eddie Dupris'),
	(4, 'Sully'),
	(5, 'Jeff Skiles'),
	(6, 'Mary Wollstonecraft'),
	(7, 'Percy Shelley'),
	(8, 'Homme cobaye'),
	(9, 'Dracula'),
	(10, 'Lucy Westenra'),
	(11, 'Michael Corleone'),
	(12, 'Vito Corleone'),
	(13, 'Forest Gump'),
	(14, 'Jenny '),
	(15, 'John Keating'),
	(16, 'Todd Anderson'),
	(17, 'Mary Lamb'),
	(18, 'Paul Hunham'),
	(19, 'John Coffey'),
	(20, 'Paul Edgecomb'),
	(21, 'Mina Harker');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
