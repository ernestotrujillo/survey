/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 50616
 Source Host           : localhost
 Source Database       : survey

 Target Server Type    : MySQL
 Target Server Version : 50616
 File Encoding         : utf-8

 Date: 05/25/2015 15:35:04 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `answer`
-- ----------------------------
DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `survey_user` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `survey_user` (`survey_user`) USING BTREE,
  KEY `question_id` (`question_id`) USING BTREE,
  KEY `option_id` (`option_id`) USING BTREE,
  CONSTRAINT `answer_option_id_fk` FOREIGN KEY (`option_id`) REFERENCES `option` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `answer_question_id_fk` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `answer_survey_user_fk` FOREIGN KEY (`survey_user`) REFERENCES `survey_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `answer`
-- ----------------------------
BEGIN;
INSERT INTO `answer` VALUES ('28', 'Antonio', '21', '5', null, '1', '2015-05-25 19:34:48', '2015-05-25 19:34:48'), ('29', '10-11-12', '21', '6', null, '1', '2015-05-25 19:34:48', '2015-05-25 19:34:48'), ('30', '13', '21', '7', '13', '1', '2015-05-25 19:34:48', '2015-05-25 19:34:48'), ('31', '2015-05-20', '21', '8', null, '1', '2015-05-25 19:34:48', '2015-05-25 19:34:48'), ('32', '18', '21', '9', '18', '1', '2015-05-25 19:34:48', '2015-05-25 19:34:48'), ('33', 'No mucho', '21', '10', null, '1', '2015-05-25 19:34:48', '2015-05-25 19:34:48'), ('34', 'A ver', '22', '4', null, '1', '2015-05-25 19:50:46', '2015-05-25 19:50:46');
COMMIT;

-- ----------------------------
--  Table structure for `area`
-- ----------------------------
DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `unit_id` (`unit_id`) USING BTREE,
  CONSTRAINT `unit_id_fk` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `area`
-- ----------------------------
BEGIN;
INSERT INTO `area` VALUES ('1', 'AVA-Area1', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('2', 'AVA-Area2', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('3', 'AVA-Area3', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('4', 'CNS-Area1', '2', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('5', 'CNS-Area2', '2', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('6', 'IBU-Area1', '3', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('7', 'IBU-Area2', '3', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('8', 'IBU-Area3', '3', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('9', 'SPC-Area1', '4', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('10', 'SPC-Area2', '4', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
--  Table structure for `area_user`
-- ----------------------------
DROP TABLE IF EXISTS `area_user`;
CREATE TABLE `area_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `area_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `area_id` (`area_id`) USING BTREE,
  CONSTRAINT `area_id_area_fk` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `user_id_area_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `area_user`
-- ----------------------------
BEGIN;
INSERT INTO `area_user` VALUES ('1', '9', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('2', '10', '2', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('3', '11', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('4', '12', '2', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
--  Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `migrations`
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table', '1'), ('2014_10_12_100000_create_password_resets_table', '1');
COMMIT;

-- ----------------------------
--  Table structure for `option`
-- ----------------------------
DROP TABLE IF EXISTS `option`;
CREATE TABLE `option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`) USING BTREE,
  CONSTRAINT `option_question_id_fk` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `option`
-- ----------------------------
BEGIN;
INSERT INTO `option` VALUES ('1', 'Internet', '2', '1', '2015-05-24 22:56:49', '2015-05-24 22:56:49'), ('2', 'Television', '2', '1', '2015-05-24 22:56:49', '2015-05-24 22:56:49'), ('3', 'Radio', '2', '1', '2015-05-24 22:56:49', '2015-05-24 22:56:49'), ('4', 'Prensa', '2', '1', '2015-05-24 22:56:50', '2015-05-24 22:56:50'), ('5', 'Excelente', '3', '1', '2015-05-24 22:56:50', '2015-05-24 22:56:50'), ('6', 'Bueno', '3', '1', '2015-05-24 22:56:50', '2015-05-24 22:56:50'), ('7', 'Regular', '3', '1', '2015-05-24 22:56:50', '2015-05-24 22:56:50'), ('8', 'Malo', '3', '1', '2015-05-24 22:56:50', '2015-05-24 22:56:50'), ('9', 'Internet', '6', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('10', 'Television', '6', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('11', 'Radio', '6', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('12', 'Prensa', '6', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('13', 'Excelente', '7', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('14', 'Bueno', '7', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('15', 'Regular', '7', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('16', 'Malo', '7', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('17', 'Tecnología', '9', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('18', 'Juegos', '9', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('19', 'Ocio', '9', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('20', 'Deporte', '9', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28');
COMMIT;

-- ----------------------------
--  Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `question`
-- ----------------------------
DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(200) NOT NULL,
  `survey_id` int(10) unsigned NOT NULL,
  `weight` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`) USING BTREE,
  CONSTRAINT `question_survey_id` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `question`
-- ----------------------------
BEGIN;
INSERT INTO `question` VALUES ('1', 'Nombre Completo', '1', '1', '0', '0', '2015-05-24 22:56:49', '2015-05-24 22:56:49'), ('2', '¿Donde nos vio?', '2', '1', '0', '0', '2015-05-24 22:56:49', '2015-05-24 22:56:49'), ('3', '¿Que le pareció el servicio?', '3', '1', '0', '0', '2015-05-24 22:56:50', '2015-05-24 22:56:50'), ('4', 'Esta es una pregunta de prueba', '1', '2', '0', '1', '2015-05-25 00:41:09', '2015-05-25 00:41:09'), ('5', 'Nombre Completo', '1', '1', '0', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('6', '¿Donde nos vio?', '2', '1', '0', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('7', '¿Que le pareció el servicio?', '3', '1', '0', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('8', 'Fecha de nacimiento', '5', '1', '0', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('9', '¿Que interés prefieres?', '4', '1', '0', '1', '2015-05-25 00:43:28', '2015-05-25 00:43:28'), ('10', '¿Algo que agregar?', '1', '1', '0', '1', '2015-05-25 01:38:11', '2015-05-25 01:38:11');
COMMIT;

-- ----------------------------
--  Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `roles`
-- ----------------------------
BEGIN;
INSERT INTO `roles` VALUES ('1', 'User', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('2', 'Manager', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('3', 'Director', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('4', 'Administrador', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
--  Table structure for `survey`
-- ----------------------------
DROP TABLE IF EXISTS `survey`;
CREATE TABLE `survey` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `unit_id` (`unit_id`) USING BTREE,
  CONSTRAINT `survey_unit_id_fk` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `survey`
-- ----------------------------
BEGIN;
INSERT INTO `survey` VALUES ('1', 'Encuesta de satisfacción de usuario', '1', '1', '2015-05-24 22:56:49', '2015-05-24 22:56:49'), ('2', 'Encuesta de Prueba', '1', '1', '2015-05-25 00:41:09', '2015-05-25 00:41:09');
COMMIT;

-- ----------------------------
--  Table structure for `survey_image`
-- ----------------------------
DROP TABLE IF EXISTS `survey_image`;
CREATE TABLE `survey_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `survey_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`) USING BTREE,
  CONSTRAINT `survey_image_survey_id_fk` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `survey_user`
-- ----------------------------
DROP TABLE IF EXISTS `survey_user`;
CREATE TABLE `survey_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `survey_id` int(10) unsigned NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `cicle` int(10) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_surver_user` (`user_id`,`survey_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `survey_id` (`survey_id`) USING BTREE,
  CONSTRAINT `user_survey_survey_id` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `user_survey_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `survey_user`
-- ----------------------------
BEGIN;
INSERT INTO `survey_user` VALUES ('21', '11', '1', 'Completada', '3', '1', '2015-05-25 19:34:48', '2015-05-25 19:34:48'), ('22', '11', '2', 'Completada', '1', '1', '2015-05-25 19:50:46', '2015-05-25 19:50:46');
COMMIT;

-- ----------------------------
--  Table structure for `unit`
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `unit`
-- ----------------------------
BEGIN;
INSERT INTO `unit` VALUES ('1', 'AVA', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('2', 'CNS', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('3', 'IBU', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('4', 'SPC', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
--  Table structure for `unit_user`
-- ----------------------------
DROP TABLE IF EXISTS `unit_user`;
CREATE TABLE `unit_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `unit_id` (`unit_id`) USING BTREE,
  CONSTRAINT `unit_id_user_fk` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `user_id_unit_area_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `unit_user`
-- ----------------------------
BEGIN;
INSERT INTO `unit_user` VALUES ('1', '8', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `unumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_unumber_unique` (`unumber`) USING BTREE,
  KEY `users_role_id` (`role_id`) USING BTREE,
  CONSTRAINT `user_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'Administrador', 'Administrador', 'u123456', 'admin@gmail.com', '4', '$2y$10$W4f4g8uga9EHLLLwfMPnJuZxQPhiocl2tsViZLcrwMBIjrU5DvDxO', 'ZR3nxMucVF0Iz4eSN4TCvtH8i6oIXpvWHPjhpGdLSBVFwGc3j4PHloXa26K3', '0000-00-00 00:00:00', '2015-05-25 13:41:45', '1'), ('8', 'Director-AVA', 'Director-AVA', 'u123457', 'director@gmail.com', '3', '$2y$10$/xUVviGt55H0X5XNSiB3FOl8/iC9EZV/E1.pcYskfiHypqbmwLtFu', 'j9fnMsK2YaisIx61UpsC7yt4cjXXKca3q3lwIylA9xHidv69WXTSfC8uo3PW', '2015-05-24 21:35:44', '2015-05-24 22:12:23', '1'), ('9', 'Manager-AVA-Area1', 'Manager-AVA-Area1', 'u123458', 'manager@gmail.com', '2', '$2y$10$uSBC1KJ1nsuJtOEdSdUVye.hsAYwEiYnIj.4b68XR5Ep6Dn/SLyPC', null, '2015-05-24 21:36:54', '2015-05-24 21:36:54', '1'), ('10', 'Manager-AVA-Area2', 'Manager-AVA-Area2', 'u123459', 'manager2@gmail.com', '2', '$2y$10$62qXydwgNJ9GxGAImIXqO.AsUsO3QWv7iVheZg16O8bKj/qsl.roS', null, '2015-05-24 21:37:33', '2015-05-24 21:37:33', '1'), ('11', 'User', 'User', 'u123451', 'user@gmail.com', '1', '$2y$10$YKMyXxwFwoLIrdpjLJ/woOCSBldsQm7PyLK4XHNutGNlqOozYB.5O', 'EkAuJuNPtuIyNB5eq7Tl3D47KdbnCcjlIg0FvjV0cFCOiE0KBDs9QBtDtw43', '2015-05-24 21:38:08', '2015-05-25 01:37:24', '1'), ('12', 'User2', 'User2', 'u123452', 'user2@gmail.com', '1', '$2y$10$EPVHZfrNc3BmGb5HYw4ALuslTILoSDFvez3zN5WUBZz6hYItpSJA.', null, '2015-05-24 21:38:41', '2015-05-24 21:38:41', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
