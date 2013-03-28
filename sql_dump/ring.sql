-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 24 2013 г., 23:23
-- Версия сервера: 5.5.28
-- Версия PHP: 5.4.4-14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `ring`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_accounts`
--

CREATE TABLE IF NOT EXISTS `user_accounts` (
  `uacc_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uacc_group_fk` smallint(5) unsigned NOT NULL,
  `uacc_email` varchar(100) NOT NULL,
  `uacc_username` varchar(15) NOT NULL,
  `uacc_password` varchar(60) NOT NULL,
  `uacc_ip_address` varchar(40) NOT NULL,
  `uacc_salt` varchar(40) NOT NULL,
  `uacc_activation_token` varchar(40) NOT NULL,
  `uacc_forgotten_password_token` varchar(40) NOT NULL,
  `uacc_forgotten_password_expire` datetime NOT NULL,
  `uacc_update_email_token` varchar(40) NOT NULL,
  `uacc_update_email` varchar(100) NOT NULL,
  `uacc_active` tinyint(1) unsigned NOT NULL,
  `uacc_suspend` tinyint(1) unsigned NOT NULL,
  `uacc_fail_login_attempts` smallint(5) NOT NULL,
  `uacc_fail_login_ip_address` varchar(40) NOT NULL,
  `uacc_date_fail_login_ban` datetime NOT NULL COMMENT 'Time user is banned until due to repeated failed logins',
  `uacc_date_last_login` datetime NOT NULL,
  `uacc_date_added` datetime NOT NULL,
  PRIMARY KEY (`uacc_id`),
  UNIQUE KEY `uacc_id` (`uacc_id`),
  KEY `uacc_group_fk` (`uacc_group_fk`),
  KEY `uacc_email` (`uacc_email`),
  KEY `uacc_username` (`uacc_username`),
  KEY `uacc_fail_login_ip_address` (`uacc_fail_login_ip_address`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `ugrp_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `ugrp_name` varchar(20) NOT NULL,
  `ugrp_desc` varchar(100) NOT NULL,
  `ugrp_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`ugrp_id`),
  UNIQUE KEY `ugrp_id` (`ugrp_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_login_sessions`
--

CREATE TABLE IF NOT EXISTS `user_login_sessions` (
  `usess_uacc_fk` int(11) NOT NULL,
  `usess_series` varchar(40) NOT NULL,
  `usess_token` varchar(40) NOT NULL,
  `usess_login_date` datetime NOT NULL,
  PRIMARY KEY (`usess_token`),
  UNIQUE KEY `usess_token` (`usess_token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_privileges`
--

CREATE TABLE IF NOT EXISTS `user_privileges` (
  `upriv_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `upriv_name` varchar(20) NOT NULL,
  `upriv_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`upriv_id`),
  UNIQUE KEY `upriv_id` (`upriv_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_privilege_groups`
--

CREATE TABLE IF NOT EXISTS `user_privilege_groups` (
  `upriv_groups_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `upriv_groups_ugrp_fk` smallint(5) unsigned NOT NULL,
  `upriv_groups_upriv_fk` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`upriv_groups_id`),
  UNIQUE KEY `upriv_groups_id` (`upriv_groups_id`) USING BTREE,
  KEY `upriv_groups_ugrp_fk` (`upriv_groups_ugrp_fk`),
  KEY `upriv_groups_upriv_fk` (`upriv_groups_upriv_fk`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_privilege_users`
--

CREATE TABLE IF NOT EXISTS `user_privilege_users` (
  `upriv_users_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `upriv_users_uacc_fk` int(11) NOT NULL,
  `upriv_users_upriv_fk` smallint(5) NOT NULL,
  PRIMARY KEY (`upriv_users_id`),
  UNIQUE KEY `upriv_users_id` (`upriv_users_id`) USING BTREE,
  KEY `upriv_users_uacc_fk` (`upriv_users_uacc_fk`),
  KEY `upriv_users_upriv_fk` (`upriv_users_upriv_fk`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
