-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.6.25 - MySQL Community Server (GPL)
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para db_e4cc
CREATE DATABASE IF NOT EXISTS `db_e4cc` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `db_e4cc`;


-- Volcando estructura para tabla db_e4cc.class_room
CREATE TABLE IF NOT EXISTS `class_room` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `class_room_name` varchar(45) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_class_room_site_idx` (`site_id`),
  CONSTRAINT `fk_class_room_site` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.course
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL,
  `schedule_per_site_id` int(11) NOT NULL,
  `class_room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_class_schedule_per_site_idx` (`schedule_per_site_id`),
  KEY `fk_class_class_room_idx` (`class_room_id`),
  KEY `fk_class_user_idx` (`user_id`),
  CONSTRAINT `fk_class_class_room` FOREIGN KEY (`class_room_id`) REFERENCES `class_room` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_class_schedule_per_site` FOREIGN KEY (`schedule_per_site_id`) REFERENCES `schedule_per_site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_class_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.evaluation
CREATE TABLE IF NOT EXISTS `evaluation` (
  `id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inscription_id` int(11) NOT NULL,
  `final_score` decimal(10,0) NOT NULL,
  `evaluation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_evaluation_level_idx` (`level_id`),
  KEY `fk_evaluation_user_idx` (`user_id`),
  KEY `fk_evaluation_inscription_idx` (`inscription_id`),
  CONSTRAINT `fk_evaluation_inscription` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluation_level` FOREIGN KEY (`level_id`) REFERENCES `level` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluation_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.exam
CREATE TABLE IF NOT EXISTS `exam` (
  `id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.grade
CREATE TABLE IF NOT EXISTS `grade` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `evaluation_id` int(11) NOT NULL,
  `grade_score` decimal(10,0) NOT NULL,
  `question_comment` text,
  PRIMARY KEY (`id`),
  KEY `fk_grade_question_idx` (`question_id`),
  KEY `fk_grade_ealuation_idx` (`evaluation_id`),
  CONSTRAINT `fk_grade_ealuation` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_grade_question` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.inscription
CREATE TABLE IF NOT EXISTS `inscription` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `inscription_date` datetime NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_inscription_student_idx` (`student_id`),
  KEY `fk_inscription_course_idx` (`course_id`),
  CONSTRAINT `fk_inscription_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscription_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.level
CREATE TABLE IF NOT EXISTS `level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(45) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.person
CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` text NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.question
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_name` text NOT NULL,
  `score` decimal(10,0) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_question_exam_idx` (`exam_id`),
  CONSTRAINT `fk_question_exam` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(45) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.schedule
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(11) NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.schedule_per_site
CREATE TABLE IF NOT EXISTS `schedule_per_site` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_schedule_per_site_site_idx` (`site_id`),
  KEY `fk_schedule_per_site_schedule_idx` (`schedule_id`),
  CONSTRAINT `fk_schedule_per_site_schedule` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_schedule_per_site_site` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.site
CREATE TABLE IF NOT EXISTS `site` (
  `id` int(11) NOT NULL,
  `site_name` varchar(45) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.student
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `dui` int(11) NOT NULL,
  `insertion_date` datetime NOT NULL,
  `confirmation_date` datetime DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_student_person_idx` (`person_id`),
  CONSTRAINT `fk_student_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla db_e4cc.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_user_person_idx` (`person_id`),
  KEY `fk_user_role_idx` (`role_id`),
  CONSTRAINT `fk_user_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
