-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 19 Mai 2014 à 12:39
-- Version du serveur: 5.5.20-log
-- Version de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

GRANT USAGE ON *.* TO 'biturodex'@'localhost' IDENTIFIED BY PASSWORD '*16C326D39D91AACCA5B97C580F6D18718300E8C5';

GRANT ALL PRIVILEGES ON `biturodex`.* TO 'biturodex'@'localhost';

--
-- Base de données: `biturodex`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `set_user_option`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `set_user_option`(IN `optuid` INT(11), IN `optname` VARCHAR(128), IN `optvalue` VARCHAR(128))
    NO SQL
    SQL SECURITY INVOKER
IF EXISTS(
	SELECT * FROM `user_options` 
	WHERE `user_options`.`uid` = optuid
        AND `user_options`.`option_name` = optname
        LIMIT 1
        )
THEN
	UPDATE `user_options` SET `option_value`=optvalue 
        WHERE `uid` = optuid
        AND `option_name` = optname;
ELSE
	INSERT INTO `user_options`(`uid`, `option_name`, `option_value`) 
        VALUES (optuid,optname,optvalue);
END IF$$

--
-- Fonctions
--
DROP FUNCTION IF EXISTS `get_distance`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `get_distance`(`origlat` DOUBLE, `origlng` DOUBLE, `targlat` DOUBLE, `targlng` DOUBLE) RETURNS double
    NO SQL
    SQL SECURITY INVOKER
RETURN(SQRT(POW(origlat - targlat, 2) + POW(origlng - targlng, 2)))$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `conversation`
--

DROP TABLE IF EXISTS `conversation`;
CREATE TABLE IF NOT EXISTS `conversation` (
  `id_conversation` int(11) NOT NULL AUTO_INCREMENT,
  `closed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_conversation`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `conversation`
--

INSERT INTO `conversation` (`id_conversation`, `closed`) VALUES
(1, 0),
(2, 0),
(3, 0),
(4, 0),
(5, 0),
(6, 0),
(7, 0),
(8, 0),
(9, 0);

-- --------------------------------------------------------

--
-- Structure de la table `conversation_subscribe`
--

DROP TABLE IF EXISTS `conversation_subscribe`;
CREATE TABLE IF NOT EXISTS `conversation_subscribe` (
  `id_conversation` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id_conversation`,`uid`),
  KEY `conversation_subscribe_fk_Uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `conversation_subscribe`
--

INSERT INTO `conversation_subscribe` (`id_conversation`, `uid`) VALUES
(0, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(0, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2);

-- --------------------------------------------------------

--
-- Structure de la table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `uid` int(11) NOT NULL,
  `id_establishment` int(11) NOT NULL,
  `rights` int(11) NOT NULL,
  `label` varchar(60) NOT NULL,
  PRIMARY KEY (`uid`,`id_establishment`),
  KEY `employees_fk_Id_establishment` (`id_establishment`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `establishment`
--

DROP TABLE IF EXISTS `establishment`;
CREATE TABLE IF NOT EXISTS `establishment` (
  `id_establishment` int(11) NOT NULL AUTO_INCREMENT,
  `id_type` int(11) DEFAULT NULL,
  `name` varchar(60) CHARACTER SET latin1 DEFAULT NULL,
  `address0` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address1` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `postcode` varchar(6) CHARACTER SET latin1 DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  PRIMARY KEY (`id_establishment`),
  KEY `establishment_fk_Id_type` (`id_type`),
  KEY `id_establishment` (`id_establishment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `establishment`
--

INSERT INTO `establishment` (`id_establishment`, `id_type`, `name`, `address0`, `address1`, `city`, `postcode`, `latitude`, `longitude`) VALUES
(6, 0, 'Pussy Twisters', '2 Rue Crudère', NULL, 'Marseille', '13007', 43.2941023, 5.3837552);

-- --------------------------------------------------------

--
-- Structure de la table `establishment_type`
--

DROP TABLE IF EXISTS `establishment_type`;
CREATE TABLE IF NOT EXISTS `establishment_type` (
  `id_type_establishment` int(11) NOT NULL,
  `label_type` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_type_establishment`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `establishment_type`
--

INSERT INTO `establishment_type` (`id_type_establishment`, `label_type`) VALUES
(0, 'bar');

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `owner_uid` int(11) NOT NULL,
  `id_establishment` int(11) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `radius` int(11) DEFAULT NULL,
  `begins` datetime DEFAULT NULL,
  `ends` datetime DEFAULT NULL,
  `id_type` int(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_event`),
  KEY `event_fk_Id_type` (`id_type`),
  KEY `event_fk_Id_establishment` (`id_establishment`),
  KEY `event_fk_Owner_uid` (`owner_uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `event`
--

INSERT INTO `event` (`id_event`, `name`, `owner_uid`, `id_establishment`, `latitude`, `longitude`, `radius`, `begins`, `ends`, `id_type`, `address`) VALUES
(3, 'soirÃ©Ã© YOLO', 1, 6, 0, 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL),
(4, 'soirÃ©Ã© YOLO', 1, 6, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL),
(5, 'soirÃ©Ã© YOLO', 1, 6, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL),
(6, 'soirÃ©Ã© YOLO', 1, 6, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL),
(7, 'soirÃ©Ã© YOLO', 1, 6, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `event_participation`
--

DROP TABLE IF EXISTS `event_participation`;
CREATE TABLE IF NOT EXISTS `event_participation` (
  `id_participation` int(11) NOT NULL,
  `id_event` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `yesnomaybe` tinyint(4) DEFAULT NULL,
  `confirmed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_participation`),
  KEY `evnt_prtcptn_fk_Id_event` (`id_event`),
  KEY `event_participation_fk_Uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `event_type`
--

DROP TABLE IF EXISTS `event_type`;
CREATE TABLE IF NOT EXISTS `event_type` (
  `id_type_event` int(11) NOT NULL AUTO_INCREMENT,
  `label_type` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_type_event`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `event_type`
--

INSERT INTO `event_type` (`id_type_event`, `label_type`) VALUES
(1, 'beuverie');

-- --------------------------------------------------------

--
-- Structure de la table `event_wall`
--

DROP TABLE IF EXISTS `event_wall`;
CREATE TABLE IF NOT EXISTS `event_wall` (
  `id_wall_post` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `op_uid` int(11) NOT NULL,
  `message` varchar(4096) NOT NULL,
  PRIMARY KEY (`id_wall_post`),
  KEY `event_wall_fk_Op_uid` (`op_uid`),
  KEY `event_wall_fk_Id_event` (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_conversation` int(11) DEFAULT NULL,
  `from_uid` int(11) DEFAULT NULL,
  `message` varchar(4096) DEFAULT NULL,
  PRIMARY KEY (`id_message`),
  KEY `message_fk_From_uid` (`from_uid`),
  KEY `message_fk_Id_conversation` (`id_conversation`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id_message`, `id_conversation`, `from_uid`, `message`) VALUES
(1, NULL, NULL, NULL),
(2, 0, 1, 'Toast'),
(3, 0, 1, 'Toast'),
(4, 0, 1, 'Toast'),
(5, 0, 1, 'Toast'),
(6, 0, 2, 'Pwet'),
(7, 0, 1, 'Toast'),
(8, 0, 2, 'Pwet'),
(9, 0, 1, 'Toast'),
(10, 0, 2, 'Pwet'),
(13, 3, 1, 'Toast'),
(14, 3, 2, 'Pwet'),
(15, 4, 1, 'Toast'),
(16, 4, 2, 'Pwet'),
(17, 5, 1, 'Toast'),
(18, 5, 2, 'Pwet'),
(19, 6, 1, 'Toast'),
(20, 6, 2, 'Pwet'),
(21, 7, 1, 'Toast'),
(22, 7, 2, 'Pwet'),
(23, 8, 1, 'Toast'),
(24, 8, 2, 'Pwet'),
(25, 9, 1, 'Toast'),
(26, 9, 2, 'Pwet');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `firstname` varchar(30) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `mailaddress` varchar(64) DEFAULT NULL,
  `passwd` varchar(256) DEFAULT NULL,
  `sesstoken` varchar(60) DEFAULT NULL,
  `sesstimestamp` timestamp NULL DEFAULT NULL,
  `pushtoken` varchar(60) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`uid`, `name`, `firstname`, `username`, `mailaddress`, `passwd`, `sesstoken`, `sesstimestamp`, `pushtoken`, `latitude`, `longitude`) VALUES
(1, 'toast', 'toast', 'toast', 'toast', '$2a$08$lololololololololololeSg.goaXlfTWWo8p5BF.ZP3OsgimhDWC', 'MDE1N2QxNGFmNGYwODY4YjFiNTBmZWE3OTgwNTk2MTYxMzk4ODEzMDkz', NULL, NULL, NULL, NULL),
(2, 'pwet', 'pwet', 'pwet', 'pwet', '$2a$08$lololololololololololeXYx6JrO8SxM4G.oYvB0YQfru3VfP.Ji', NULL, NULL, NULL, NULL, NULL),
(3, 'poulpe', 'poulpe', 'poulpe', 'poulpe@ocean.com', '$2a$08$lolololololololololole76Cq4Gi5oy.44rCLkQXaFlgK5neLa1m', 'MWY2ZjY2ZmRmNGZiMTljMjY5MDFlMDc3MTc0MjNmOWExNDAwMzM3MDI5', NULL, NULL, NULL, NULL),
(4, 'ad', 'min', 'admin', 'aaa@hotmail.fr', '$2a$08$lolololololololololole76Cq4Gi5oy.44rCLkQXaFlgK5neLa1m', 'NGFjZTRkYzYzOGQ0MWExMzJjOTNlMjM0Yjk2NThjZjAxNDAwNDk3NTA1', '2014-05-19 11:05:05', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_options`
--

DROP TABLE IF EXISTS `user_options`;
CREATE TABLE IF NOT EXISTS `user_options` (
  `id_option` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `option_name` varchar(128) DEFAULT NULL,
  `option_value` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id_option`),
  KEY `user_options_fk_Uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `user_options`
--

INSERT INTO `user_options` (`id_option`, `uid`, `option_name`, `option_value`) VALUES
(1, 4, 'profile_pic', 'C:\\Users\\Irkam\\Documents\\GitHub\\biturodex\\app/uploads/4_1400502747.jpg');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `conversation_subscribe`
--
ALTER TABLE `conversation_subscribe`
  ADD CONSTRAINT `cnvrstn_sbscrb_fk_Id_cnvrstn` FOREIGN KEY (`id_conversation`) REFERENCES `conversation` (`id_conversation`),
  ADD CONSTRAINT `conversation_subscribe_fk_Uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);

--
-- Contraintes pour la table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_fk_Id_establishment` FOREIGN KEY (`id_establishment`) REFERENCES `establishment` (`id_establishment`),
  ADD CONSTRAINT `employees_fk_Uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);

--
-- Contraintes pour la table `establishment`
--
ALTER TABLE `establishment`
  ADD CONSTRAINT `establishment_fk_Id_type` FOREIGN KEY (`id_type`) REFERENCES `establishment_type` (`id_type_establishment`);

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_fk_Id_establishment` FOREIGN KEY (`id_establishment`) REFERENCES `establishment` (`id_establishment`),
  ADD CONSTRAINT `event_fk_Id_type` FOREIGN KEY (`id_type`) REFERENCES `event_type` (`id_type_event`),
  ADD CONSTRAINT `event_fk_Owner_uid` FOREIGN KEY (`owner_uid`) REFERENCES `user` (`uid`);

--
-- Contraintes pour la table `event_participation`
--
ALTER TABLE `event_participation`
  ADD CONSTRAINT `event_participation_fk_Uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`),
  ADD CONSTRAINT `evnt_prtcptn_fk_Id_event` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`);

--
-- Contraintes pour la table `event_wall`
--
ALTER TABLE `event_wall`
  ADD CONSTRAINT `event_wall_fk_Id_event` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`),
  ADD CONSTRAINT `event_wall_fk_Op_uid` FOREIGN KEY (`op_uid`) REFERENCES `user` (`uid`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_fk_From_uid` FOREIGN KEY (`from_uid`) REFERENCES `user` (`uid`),
  ADD CONSTRAINT `message_fk_Id_conversation` FOREIGN KEY (`id_conversation`) REFERENCES `conversation` (`id_conversation`);

--
-- Contraintes pour la table `user_options`
--
ALTER TABLE `user_options`
  ADD CONSTRAINT `user_options_fk_Uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
