SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
CREATE TABLE IF NOT EXISTS `assets` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `tag` varchar(15) collate utf8_unicode_ci NOT NULL,
  `serial` varchar(30) collate utf8_unicode_ci NOT NULL,
  `value1` varchar(30) collate utf8_unicode_ci NOT NULL,
  `value2` varchar(30) collate utf8_unicode_ci NOT NULL,
  `label1` varchar(30) collate utf8_unicode_ci NOT NULL,
  `label2` varchar(30) collate utf8_unicode_ci NOT NULL,
  `brand` varchar(50) collate utf8_unicode_ci NOT NULL,
  `model` varchar(15) collate utf8_unicode_ci NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `desc` varchar(255) collate utf8_unicode_ci NOT NULL,
  `category_id` mediumint(8) unsigned NOT NULL,
  `location_id` mediumint(8) unsigned NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `status` enum('current','disposed','sold') collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `serial` (`serial`),
  UNIQUE KEY `value1` (`value1`),
  UNIQUE KEY `value2` (`value2`),
  UNIQUE KEY `tag` (`tag`),
  KEY `location_id` (`location_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `parent` mediumint(8) unsigned NOT NULL,
  `name` varchar(30) collate utf8_unicode_ci NOT NULL,
  `depreciation` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `categories_departments` (
  `category_id` mediumint(8) unsigned NOT NULL,
  `department_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `category_id` (`category_id`,`department_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `config` (
  `key` varchar(15) collate utf8_unicode_ci NOT NULL,
  `value` varchar(255) collate utf8_unicode_ci NOT NULL,
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `departments` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `location_id` mediumint(8) unsigned NOT NULL,
  `name` varchar(20) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `location_id` (`location_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `departments_users` (
  `user_id` mediumint(8) unsigned NOT NULL,
  `department_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`department_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `locations` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `locations_admins` (
  `location_id` mediumint(8) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `location_id` (`location_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `logs` (
  `id` mediumint(8) unsigned NOT NULL,
  `asset_id` mediumint(8) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  `timestamp` datetime NOT NULL,
  `type` enum('inservice','disposed','sold','restored','tagchange') collate utf8_unicode_ci NOT NULL,
  `before` varchar(50) collate utf8_unicode_ci NOT NULL,
  `after` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `asset_id` (`asset_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `email` varchar(50) collate utf8_unicode_ci NOT NULL,
  `password` varchar(128) collate utf8_unicode_ci NOT NULL,
  `name` varchar(35) collate utf8_unicode_ci NOT NULL,
  `superadmin` enum('0','1') collate utf8_unicode_ci NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

INSERT INTO `config` (`key`, `value`) VALUES ('password-salt', MD5(RAND());