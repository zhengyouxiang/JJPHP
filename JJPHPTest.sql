-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 08 月 13 日 05:10
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `jjphptest`
--

-- --------------------------------------------------------

--
-- 表的结构 `application`
--

DROP TABLE IF EXISTS `application`;
CREATE TABLE IF NOT EXISTS `application` (
  `id` int(11) NOT NULL auto_increment,
  `author_id` int(11) NOT NULL,
  `maintainer_id` int(11) default NULL,
  `title` varchar(50) NOT NULL,
  `web` varchar(100) NOT NULL,
  `slogan` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 导出表中的数据 `application`
--

INSERT INTO `application` (`id`, `author_id`, `maintainer_id`, `title`, `web`, `slogan`) VALUES
(1, 11, 11, 'Adminer', 'http://www.adminer.org/', 'Database management in single PHP file'),
(2, 11, NULL, 'JUSH', 'http://jush.sourceforge.net/', 'JavaScript Syntax Highlighter'),
(3, 12, 12, 'Nette', 'http://nettephp.com/', 'Nette Framework for PHP 5'),
(4, 12, 12, 'Dibi', 'http://dibiphp.com/', 'Database Abstraction Library for PHP 5');

-- --------------------------------------------------------

--
-- 表的结构 `application_tag`
--

DROP TABLE IF EXISTS `application_tag`;
CREATE TABLE IF NOT EXISTS `application_tag` (
  `application_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY  (`application_id`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `application_tag`
--

INSERT INTO `application_tag` (`application_id`, `tag_id`) VALUES
(1, 21),
(1, 22),
(2, 23),
(3, 21),
(4, 21),
(4, 22),
(5, 21);

-- --------------------------------------------------------

--
-- 表的结构 `author`
--

DROP TABLE IF EXISTS `author`;
CREATE TABLE IF NOT EXISTS `author` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `web` varchar(100) NOT NULL,
  `born` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 导出表中的数据 `author`
--

INSERT INTO `author` (`id`, `name`, `web`, `born`) VALUES
(11, 'Jakub Vrana', 'http://www.vrana.cz/', NULL),
(12, 'David Grudl', 'http://davidgrudl.com/', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `jjdbcache`
--

DROP TABLE IF EXISTS `jjdbcache`;
CREATE TABLE IF NOT EXISTS `jjdbcache` (
  `id` int(10) NOT NULL auto_increment,
  `k` varchar(255) NOT NULL default '',
  `v` text NOT NULL,
  `dtime` int(10) NOT NULL default '0',
  `cachetime` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `k` (`k`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `jjdbcache`
--

INSERT INTO `jjdbcache` (`id`, `k`, `v`, `dtime`, `cachetime`) VALUES
(1, '098f6bcd4621d373cade4e832627b4f6', 'czoxMToiaGVsbG8gSkpQSFAiOw==', 1344788760, 0);

-- --------------------------------------------------------

--
-- 表的结构 `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(20) NOT NULL auto_increment,
  `client_id` varchar(20) NOT NULL,
  `client_secret` varchar(20) NOT NULL,
  `redirect_uri` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `client_id`, `client_secret`, `redirect_uri`) VALUES
(1, '1000', '1000', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `oauth_codes`
--

DROP TABLE IF EXISTS `oauth_codes`;
CREATE TABLE IF NOT EXISTS `oauth_codes` (
  `id` int(20) NOT NULL auto_increment,
  `code` varchar(40) NOT NULL,
  `client_id` varchar(20) NOT NULL,
  `user_id` varchar(32) default NULL,
  `redirect_uri` varchar(200) default NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(250) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `oauth_codes`
--


-- --------------------------------------------------------

--
-- 表的结构 `oauth_tokens`
--

DROP TABLE IF EXISTS `oauth_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_tokens` (
  `id` int(20) NOT NULL auto_increment,
  `oauth_token` varchar(40) NOT NULL,
  `client_id` varchar(20) NOT NULL,
  `user_id` varchar(32) default NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `oauth_tokens`
--


-- --------------------------------------------------------

--
-- 表的结构 `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- 导出表中的数据 `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(21, 'PHP'),
(22, 'MySQL'),
(23, 'JavaScript');
