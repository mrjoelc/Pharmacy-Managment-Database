# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.23)
# Database: Farmacia
# Generation Time: 2019-01-05 09:40:32 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Azienda
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Azienda`;

CREATE TABLE `Azienda` (
  `nomeAzienda` varchar(30) NOT NULL DEFAULT '',
  `recapitoTel` varchar(13) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`nomeAzienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Azienda` WRITE;
/*!40000 ALTER TABLE `Azienda` DISABLE KEYS */;

INSERT INTO `Azienda` (`nomeAzienda`, `recapitoTel`, `email`)
VALUES
	('Angelini','345678912','assistenza_farmacia@angelini.it'),
	('Bracco','234567891','bracco_support@bracco.it'),
	('Chiesi','234567891','centro_assistenza@chiesi.it'),
	('Menarini','123456789','centro_operativo_ct@menarini.it');

/*!40000 ALTER TABLE `Azienda` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Cassetto
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Cassetto`;

CREATE TABLE `Cassetto` (
  `n_cass` int(1) unsigned NOT NULL,
  `n_scaf` int(1) unsigned NOT NULL,
  PRIMARY KEY (`n_cass`,`n_scaf`),
  KEY `cassetto1` (`n_scaf`),
  CONSTRAINT `cassetto1` FOREIGN KEY (`n_scaf`) REFERENCES `Scaffale` (`n_scaf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Cassetto` WRITE;
/*!40000 ALTER TABLE `Cassetto` DISABLE KEYS */;

INSERT INTO `Cassetto` (`n_cass`, `n_scaf`)
VALUES
	(1,101),
	(2,101),
	(3,101),
	(4,101),
	(5,101),
	(6,101),
	(7,101),
	(8,101),
	(9,101),
	(10,101),
	(1,201),
	(2,201),
	(3,201),
	(4,201),
	(5,201),
	(6,201),
	(7,201),
	(8,201),
	(9,201),
	(10,201),
	(1,301),
	(2,301),
	(3,301),
	(4,301),
	(5,301),
	(6,301),
	(7,301),
	(8,301),
	(9,301),
	(10,301),
	(1,401),
	(2,401),
	(3,401),
	(4,401),
	(5,401),
	(6,401),
	(7,401),
	(8,401),
	(9,401),
	(10,401),
	(1,501),
	(2,501),
	(3,501),
	(4,501),
	(5,501),
	(6,501),
	(7,501),
	(8,501),
	(9,501),
	(10,501),
	(1,601),
	(2,601),
	(3,601),
	(4,601),
	(5,601),
	(6,601),
	(7,601),
	(8,601),
	(9,601),
	(10,601);

/*!40000 ALTER TABLE `Cassetto` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Farmaco
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Farmaco`;

CREATE TABLE `Farmaco` (
  `nomeFarmaco` varchar(50) NOT NULL DEFAULT '',
  `nomeAzienda` varchar(30) NOT NULL DEFAULT '',
  `impiego` varchar(50) NOT NULL DEFAULT '',
  `dataScadenza` date NOT NULL,
  PRIMARY KEY (`nomeFarmaco`,`nomeAzienda`),
  KEY `farmaco1` (`nomeAzienda`),
  CONSTRAINT `farmaco1` FOREIGN KEY (`nomeAzienda`) REFERENCES `Azienda` (`nomeAzienda`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Farmaco` WRITE;
/*!40000 ALTER TABLE `Farmaco` DISABLE KEYS */;

INSERT INTO `Farmaco` (`nomeFarmaco`, `nomeAzienda`, `impiego`, `dataScadenza`)
VALUES
	('Acutil Multivitaminico Plus ','Angelini','Integratore multivitaminico, Memoria','2019-12-21'),
	('Daparox','Angelini','Antidepressivo','2020-04-05'),
	('Tachipirina','Angelini','Cura del dolore, disturbi infiammatori','2020-01-01');

/*!40000 ALTER TABLE `Farmaco` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table PosizioneFarmaco
# ------------------------------------------------------------

DROP TABLE IF EXISTS `PosizioneFarmaco`;

CREATE TABLE `PosizioneFarmaco` (
  `nomeFarmaco` varchar(50) NOT NULL DEFAULT '',
  `nomeAzienda` varchar(30) NOT NULL DEFAULT '',
  `n_cass` int(1) unsigned NOT NULL,
  `n_scaf` int(1) unsigned NOT NULL,
  PRIMARY KEY (`nomeFarmaco`,`nomeAzienda`),
  KEY `PS2` (`nomeAzienda`),
  KEY `PS3` (`n_cass`),
  KEY `PS4` (`n_scaf`),
  CONSTRAINT `PS1` FOREIGN KEY (`nomeFarmaco`) REFERENCES `Farmaco` (`nomeFarmaco`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `PS2` FOREIGN KEY (`nomeAzienda`) REFERENCES `Azienda` (`nomeAzienda`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `PS3` FOREIGN KEY (`n_cass`) REFERENCES `Cassetto` (`n_cass`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `PS4` FOREIGN KEY (`n_scaf`) REFERENCES `Scaffale` (`n_scaf`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `PosizioneFarmaco` WRITE;
/*!40000 ALTER TABLE `PosizioneFarmaco` DISABLE KEYS */;

INSERT INTO `PosizioneFarmaco` (`nomeFarmaco`, `nomeAzienda`, `n_cass`, `n_scaf`)
VALUES
	('Acutil Multivitaminico Plus','Angelini',1,501),
	('Daparox','Angelini',2,501),
	('Tachipirina','Angelini',3,501);

/*!40000 ALTER TABLE `PosizioneFarmaco` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Scaffale
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Scaffale`;

CREATE TABLE `Scaffale` (
  `n_scaf` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`n_scaf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Scaffale` WRITE;
/*!40000 ALTER TABLE `Scaffale` DISABLE KEYS */;

INSERT INTO `Scaffale` (`n_scaf`, `categoria`)
VALUES
	(101,'Sistema Cardiovascolare'),
	(201,'Sistema Gastrointestinale e Metabolismo'),
	(301,'Sangue e Organi Emopoietici'),
	(401,'Antineoplastici e Immunomodulatori'),
	(501,'Sistema Nervoso Centrale'),
	(601,'Apparato Respiratorio');

/*!40000 ALTER TABLE `Scaffale` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
