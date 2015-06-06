`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `yearId` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  KEY `id` (`id`),
  KEY `yearId` (`yearId`),
  KEY `yearId` (`yearId`),



CREATE TABLE `tennisYear` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `value` longtext NOT NULL,
  KEY `id` (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tennisDivision` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `yearId` int(10) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  KEY `id` (`id`),
  KEY `yearId` (`yearId`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tennisPlayer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `yearId` int(10) unsigned NOT NULL,
  `nameFirst` varchar(75) NOT NULL DEFAULT '',
  `nameLast` varchar(75) NOT NULL DEFAULT '',
  `rank` int(10) unsigned DEFAULT NULL,
  `phoneLandline` varchar(30) DEFAULT '',
  `phoneMobile` varchar(30) DEFAULT '',
  `ettaLicenseNumber` varchar(10) NOT NULL DEFAULT '',
  `teamId` int(10) unsigned DEFAULT NULL,
  KEY `id` (`id`),
  KEY `yearId` (`yearId`),
  KEY `teamId` (`teamId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tennisTeam` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `yearId` int(10) unsigned NOT NULL COMMENT 'no need as division id is unique?',
  `name` varchar(75) NOT NULL,
  `homeWeekday` tinyint(1) DEFAULT NULL,
  `secretaryId` int(10) unsigned DEFAULT NULL,
  `venueId` int(10) unsigned NOT NULL,
  `divisionId` int(10) unsigned NOT NULL,
  KEY `id` (`id`),
  KEY `yearId` (`yearId`),
  KEY `secretaryId` (`secretaryId`),
  KEY `venueId` (`venueId`),
  KEY `divisionId` (`divisionId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tennisFixture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `yearId` int(10) unsigned NOT NULL,
  `teamIdLeft` int(10) unsigned NOT NULL,
  `teamIdRight` int(10) unsigned NOT NULL,
  `timeFulfilled` int(11) unsigned DEFAULT NULL,
  KEY `id` (`id`),
  KEY `yearId` (`yearId`),
  KEY `teamIdLeft` (`teamIdLeft`),
  KEY `teamIdRight` (`teamIdRight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

CREATE TABLE `tennisEncounter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `yearId` int(10) unsigned NOT NULL,
  `playerIdLeft` int(10) unsigned DEFAULT NULL,
  `playerIdRight` int(10) unsigned DEFAULT NULL,
  `scoreLeft` tinyint(3) unsigned DEFAULT NULL,
  `scoreRight` tinyint(3) unsigned DEFAULT NULL,
  `playerRankChangeLeft` tinyint(4) DEFAULT NULL,
  `playerRankChangeRight` tinyint(4) DEFAULT NULL,
  `fixtureId` int(10) unsigned DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  KEY `id` (`id`),
  KEY `yearId` (`yearId`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tennisVenue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `yearId` int(10) unsigned NOT NULL,
  `name` varchar(75) NOT NULL,
  `location` varchar(200) NOT NULL,
  KEY `id` (`id`),
  KEY `yearId` (`yearId`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
