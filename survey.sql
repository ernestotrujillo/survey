/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 50622
 Source Host           : localhost
 Source Database       : survey

 Target Server Type    : MySQL
 Target Server Version : 50622
 File Encoding         : utf-8

 Date: 05/23/2015 11:23:35 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `answer`
-- ----------------------------
DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `area`
-- ----------------------------
BEGIN;
INSERT INTO `area` VALUES ('1', 'AVA-Area1', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('2', 'AVA-Area2', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('3', 'AVA-Area3', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('4', 'CNS-Area1', '2', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `area_user`
-- ----------------------------
BEGIN;
INSERT INTO `area_user` VALUES ('4', '9', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('5', '10', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('6', '11', '2', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
COMMIT;

-- ----------------------------
--  Table structure for `base`
-- ----------------------------
DROP TABLE IF EXISTS `base`;
CREATE TABLE `base` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `password_resets`
-- ----------------------------
BEGIN;
INSERT INTO `password_resets` VALUES ('antonio.alarcon@outlook.com', '73958b3c07118de3abfd07315589ae27c4c1f6e978a4b25d18d99e6135849563', '2015-05-17 03:34:24');
COMMIT;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
INSERT INTO `survey` VALUES ('1', 'Encuesta de satisfacción', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('2', 'Encuesta de progreso', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
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
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_surver_user` (`user_id`,`survey_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `survey_id` (`survey_id`) USING BTREE,
  CONSTRAINT `user_survey_survey_id` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `user_survey_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `survey_user`
-- ----------------------------
BEGIN;
INSERT INTO `survey_user` VALUES ('1', '10', '1', 'Completado', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('2', '10', '2', 'Completado', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), ('3', '11', '2', 'Completado', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `unit_user`
-- ----------------------------
BEGIN;
INSERT INTO `unit_user` VALUES ('2', '8', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('7', 'Administrador', 'Administrador', 'u123456', 'admin@gmail.com', '4', '$2y$10$/9uq1TNZ3.8wkrLVlzg71eX5fHPqX9VZXH9ONI39y8yW2fhy0XBGm', '7GL0Mdw2HMhMU19QiONkAGdWHOWnrUdKXVdgLgp85G62vAPxaHP6SVSsPhWr', '0000-00-00 00:00:00', '2015-05-23 03:50:35', '1'), ('8', 'Director', 'Director', 'u123457', 'director@gmail.com', '3', '$2y$10$tfh8rRcQyZxUklL8Zil.mudFIY.h2Jc.g0oCO5z9QpJ.4Ml3tgxiq', null, '2015-05-23 04:13:58', '2015-05-23 07:24:13', '1'), ('9', 'Manager', 'Manager', 'u123458', 'manager@gmail.com', '2', '$2y$10$KOMMY.vooknx2g8cJ7dZD.WposKjtvFCABW9RhBqVEvq5fj74X3TK', null, '2015-05-23 15:11:10', '2015-05-23 15:11:10', '1'), ('10', 'User', 'User', 'u123459', 'user@gmail.com', '1', '$2y$10$km1oKkO.BHLLp2.j/RmouOouiYwg1GnT0QxYxn9Z3VIxuilpbsl5e', null, '2015-05-23 15:11:49', '2015-05-23 15:11:49', '1'), ('11', 'User2', 'User2', 'u123451', 'user2@gmail.com', '1', '$2y$10$7wMkyq8eG8SfNhJV9F1LregDD1JyHR/UfwV5HvKWK98HeILB9lu8G', null, '2015-05-23 15:12:40', '2015-05-23 15:12:40', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
