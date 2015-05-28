CREATE TABLE `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL,
  `html` longtext,
  `type` varchar(50) NOT NULL DEFAULT '',
  `timePublished` int(10) unsigned DEFAULT '0',
  `status` varchar(50) NOT NULL DEFAULT 'hidden',
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `content_meta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contentId` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `content_id` (`contentId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `action` varchar(50) NOT NULL,
  `group` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(8000) NOT NULL,
  `time` int(12) NOT NULL,
  `userId` int(12) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `log_admin_unseen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logId` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `path` varchar(500) NOT NULL,
  `type` varchar(20) NOT NULL,
  `timePublished` int(10) unsigned DEFAULT '0',
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `timeRegistered` int(10) unsigned DEFAULT NULL,
  `level` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `nameFirst` varchar(75) NOT NULL DEFAULT '',
  `nameLast` varchar(75) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `user_permission` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userId` INT(10) UNSIGNED NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `ability` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idParent` INT NULL,
  `url` VARCHAR(255) NULL,
  `name` VARCHAR(150) NULL,
  `keyGroup` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `mail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `to` VARCHAR(255) NULL,
  `from` VARCHAR(255) NULL,
  `subject` VARCHAR(255) NULL,
  `body` longtext,
  `timeSent` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
