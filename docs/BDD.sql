SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `avoir`;
CREATE TABLE `avoir` (
  `id_1` varchar(42) NOT NULL,
  `id_2` varchar(42) NOT NULL,
  PRIMARY KEY (`id_1`,`id_2`),
  KEY `id_2` (`id_2`),
  CONSTRAINT `avoir_ibfk_1` FOREIGN KEY (`id_2`) REFERENCES `favoris` (`id`),
  CONSTRAINT `avoir_ibfk_2` FOREIGN KEY (`id_1`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE `commentaires` (
  `id` varchar(42) NOT NULL,
  `utilisateurId` varchar(42) DEFAULT NULL,
  `nom` varchar(42) DEFAULT NULL,
  `commentaire` varchar(42) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `ecrit`;
CREATE TABLE `ecrit` (
  `id_1` varchar(42) NOT NULL,
  `id_2` varchar(42) NOT NULL,
  PRIMARY KEY (`id_1`,`id_2`),
  KEY `id_2` (`id_2`),
  CONSTRAINT `ecrit_ibfk_1` FOREIGN KEY (`id_2`) REFERENCES `utilisateurs` (`id`),
  CONSTRAINT `ecrit_ibfk_2` FOREIGN KEY (`id_1`) REFERENCES `commentaires` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `fabriquer`;
CREATE TABLE `fabriquer` (
  `id_1` varchar(42) NOT NULL,
  `id_2` varchar(42) NOT NULL,
  PRIMARY KEY (`id_1`,`id_2`),
  KEY `id_2` (`id_2`),
  CONSTRAINT `fabriquer_ibfk_1` FOREIGN KEY (`id_2`) REFERENCES `origamis` (`id`),
  CONSTRAINT `fabriquer_ibfk_2` FOREIGN KEY (`id_1`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `favoris`;
CREATE TABLE `favoris` (
  `id` varchar(42) NOT NULL,
  `utilisateurId` varchar(42) DEFAULT NULL,
  `origamiId` varchar(42) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `origamis`;
CREATE TABLE `origamis` (
  `id` varchar(42) NOT NULL,
  `utilisateurId` varchar(42) DEFAULT NULL,
  `nom` varchar(42) DEFAULT NULL,
  `description` varchar(42) DEFAULT NULL,
  `image` varchar(42) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `poster`;
CREATE TABLE `poster` (
  `id_1` varchar(42) NOT NULL,
  `id_2` varchar(42) NOT NULL,
  PRIMARY KEY (`id_1`,`id_2`),
  KEY `id_2` (`id_2`),
  CONSTRAINT `poster_ibfk_1` FOREIGN KEY (`id_2`) REFERENCES `utilisateurs` (`id`),
  CONSTRAINT `poster_ibfk_2` FOREIGN KEY (`id_1`) REFERENCES `videos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE `utilisateurs` (
  `id` varchar(42) NOT NULL,
  `nom` varchar(42) DEFAULT NULL,
  `email` varchar(42) DEFAULT NULL,
  `motDePasse` varchar(42) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `videos`;
CREATE TABLE `videos` (
  `id` varchar(42) NOT NULL,
  `utilisateurId` varchar(42) DEFAULT NULL,
  `titre` varchar(42) DEFAULT NULL,
  `lienUrl` varchar(42) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
