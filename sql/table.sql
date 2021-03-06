CREATE TABLE `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `databaseVersion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NULL DEFAULT NULL,
  `timePatched` int(10) NULL DEFAULT NULL,
  `userId` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NULL DEFAULT NULL,
  `slug` varchar(255) NULL DEFAULT NULL,
  `html` longtext,
  `type` varchar(50) NULL DEFAULT NULL,
  `timePublished` int(10) NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT NULL,
  `userId` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `contentMeta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contentId` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `contentId` (`contentId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NULL DEFAULT NULL,
  `description` varchar(255) NULL DEFAULT NULL,
  `url` varchar(255) NULL DEFAULT NULL,
  `action` varchar(50) NULL DEFAULT NULL,
  `timeCreated` int(10) NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  `image` varchar(255) NULL DEFAULT NULL,
  `groupKey` varchar(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(8000) NOT NULL,
  `time` int(12) NOT NULL,
  `userId` int(12) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
  KEY `userId` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `logAdminUnseen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logId` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  PRIMARY KEY (`id`)
  KEY `logId` (`logId`)
  KEY `userId` (`userId`)
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
  KEY `userId` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `timeRegistered` int(10) unsigned DEFAULT NULL,
  `nameFirst` varchar(75) NOT NULL DEFAULT '',
  `nameLast` varchar(75) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `userPermission` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userId` INT(10) UNSIGNED NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idParent` INT NULL,
  `url` VARCHAR(255) NULL,
  `name` VARCHAR(150) NULL,
  `keyGroup` VARCHAR(45) NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `mail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `to` VARCHAR(255) NULL,
  `from` VARCHAR(255) NULL,
  `subject` VARCHAR(255) NULL,
  `body` longtext,
  `timeSent` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
