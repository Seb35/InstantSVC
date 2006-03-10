CREATE DATABASE teletask;
use teletask;

CREATE TABLE `languages` ( `id` bigint(20) unsigned NOT NULL auto_increment, `name` varchar(255) NOT NULL default '', `code` varchar(10) NOT NULL default '', PRIMARY KEY (`id`), UNIQUE KEY `code` (`code`), KEY `name` (`name`) ) TYPE=MyISAM;

CREATE TABLE `lecturegroups` ( `id` bigint(20) unsigned NOT NULL auto_increment, `name` varchar(255) NOT NULL default '', `showName` enum('y','n') NOT NULL default 'y', PRIMARY KEY (`id`), KEY `name` (`name`) ) TYPE=MyISAM;

CREATE TABLE `lectures` ( `id` bigint(20) unsigned NOT NULL auto_increment, `name` varchar(255) NOT NULL default '', `namehtml` text, `streamurldsl` varchar(255) default NULL, `streamurlisdn` varchar(255) default NULL, `streamurllivestream` varchar(255) default NULL, `abstract` text, `languagesId` bigint(20) unsigned NOT NULL default '0', `duration` time default NULL, `logo` bigint(20) unsigned default NULL, `time` datetime default NULL, `sortdate` datetime NOT NULL default '0000-00-00 00:00:00', `livestreamstarttime` datetime default NULL, `livestreamendtime` datetime default NULL, `place` varchar(255) default NULL, `institution` bigint(20) unsigned default NULL, PRIMARY KEY (`id`), KEY `name` (`name`), KEY `languages` (`languagesId`), KEY `sortdate` (`sortdate`), KEY `languagesId` (`languagesId`) ) TYPE=MyISAM;

CREATE TABLE `lecturestatus` ( `seriesId` bigint(20) unsigned NOT NULL default '0', `lecturesId` bigint(20) unsigned NOT NULL default '0', `status` enum('hidden','upcoming','inactive') NOT NULL default 'upcoming', `availablefrom` datetime default NULL, PRIMARY KEY (`seriesId`,`lecturesId`), KEY `status` (`status`) ) TYPE=MyISAM;

CREATE TABLE `linkgroups` ( `id` bigint(20) unsigned NOT NULL auto_increment, `name` varchar(255) NOT NULL default '', `showName` enum('y','n') NOT NULL default 'y', PRIMARY KEY (`id`), KEY `name` (`name`) ) TYPE=MyISAM;

CREATE TABLE `links` ( `id` bigint(20) unsigned NOT NULL auto_increment, `name` varchar(255) NOT NULL default '', `url` varchar(255) NOT NULL default '', PRIMARY KEY (`id`), KEY `name` (`name`) ) TYPE=MyISAM;

CREATE TABLE `media` ( `id` bigint(20) unsigned NOT NULL auto_increment, `mediagroupsId` bigint(20) unsigned NOT NULL default '0', `name` varchar(255) NOT NULL default '', `url` varchar(255) NOT NULL default '', PRIMARY KEY (`id`), UNIQUE KEY `url` (`url`), KEY `mediagroupsId` (`mediagroupsId`) ) TYPE=MyISAM;

CREATE TABLE `mediagroups` ( `id` bigint(20) unsigned NOT NULL auto_increment, `parentId` bigint(20) unsigned default NULL, `name` varchar(255) NOT NULL default '', `baseurl` varchar(255) NOT NULL default '', PRIMARY KEY (`id`), KEY `parentId` (`parentId`) ) TYPE=MyISAM;

CREATE TABLE `news` ( `id` bigint(20) unsigned NOT NULL auto_increment, `newsdate` datetime NOT NULL default '0000-00-00 00:00:00', `heading` varchar(40) NOT NULL default '', `abstract` text NOT NULL, `abstracthtml` text, `linkurl` varchar(255) default NULL, `languagesId` bigint(20) unsigned NOT NULL default '0', PRIMARY KEY (`id`), KEY `languagesId` (`languagesId`), KEY `newsdate` (`newsdate`), FULLTEXT KEY `heading` (`heading`) ) TYPE=MyISAM;

CREATE TABLE `people` ( `id` bigint(20) unsigned NOT NULL auto_increment, `name` varchar(255) NOT NULL default '', `emailurl` varchar(255) default NULL, `homepageurl` varchar(255) default NULL, PRIMARY KEY (`id`), KEY `name` (`name`), FULLTEXT KEY `name_2` (`name`) ) TYPE=MyISAM;

CREATE TABLE `relation_authors_lectures_people` ( `lecturesId` bigint(20) unsigned NOT NULL default '0', `peopleId` bigint(20) unsigned NOT NULL default '0', PRIMARY KEY (`lecturesId`,`peopleId`) ) TYPE=MyISAM;

CREATE TABLE `relation_authors_series_people` ( `seriesId` bigint(20) unsigned NOT NULL default '0', `peopleId` bigint(20) unsigned NOT NULL default '0', PRIMARY KEY (`seriesId`,`peopleId`) ) TYPE=MyISAM;

CREATE TABLE `relation_contacts_series_people` ( `seriesId` bigint(20) unsigned NOT NULL default '0', `peopleId` bigint(20) unsigned NOT NULL default '0', PRIMARY KEY (`seriesId`,`peopleId`) ) TYPE=MyISAM;

CREATE TABLE `relation_lecturegroups_lectures` ( `lecturegroupsId` bigint(20) unsigned NOT NULL default '0', `lecturesId` bigint(20) unsigned NOT NULL default '0', `number` smallint(6) unsigned default NULL, `displaynumeral` varchar(10) default NULL, PRIMARY KEY (`lecturegroupsId`,`lecturesId`), KEY `lecturesOrder` (`number`) ) TYPE=MyISAM;

CREATE TABLE `relation_lectures_linkgroups` ( `lecturesId` bigint(20) unsigned NOT NULL default '0', `linkgroupsId` bigint(20) unsigned NOT NULL default '0', `number` smallint(6) unsigned default '0', PRIMARY KEY (`lecturesId`,`linkgroupsId`), KEY `linkgroupsOrder` (`number`) ) TYPE=MyISAM;

CREATE TABLE `relation_linkgroups_links` ( `linkgroupsId` bigint(20) unsigned NOT NULL default '0', `linksId` bigint(20) unsigned NOT NULL default '0', `number` smallint(6) unsigned default NULL, PRIMARY KEY (`linkgroupsId`,`linksId`), KEY `linkgroupsOrder` (`number`) ) TYPE=MyISAM;

CREATE TABLE `relation_series_lecturegroups` ( `seriesId` bigint(20) unsigned NOT NULL default '0', `lecturegroupsId` bigint(20) unsigned NOT NULL default '0', `number` smallint(6) unsigned default NULL, `displaynumeral` varchar(10) default NULL, PRIMARY KEY (`seriesId`,`lecturegroupsId`), KEY `lecturegroupOrder` (`number`) ) TYPE=MyISAM;

CREATE TABLE `relation_series_linkgroups` ( `seriesId` bigint(20) unsigned NOT NULL default '0', `linkgroupsId` bigint(20) unsigned NOT NULL default '0', `number` smallint(6) unsigned default '0', PRIMARY KEY (`seriesId`,`linkgroupsId`), KEY `linkgroupOrder` (`number`) ) TYPE=MyISAM;

CREATE TABLE `relation_series_topics` ( `seriesId` bigint(20) unsigned NOT NULL default '0', `topicsId` bigint(20) unsigned NOT NULL default '0', PRIMARY KEY (`seriesId`,`topicsId`) ) TYPE=MyISAM;

CREATE TABLE `relation_speakers_lectures_people` ( `lecturesId` bigint(20) unsigned NOT NULL default '0', `peopleId` bigint(20) unsigned NOT NULL default '0', PRIMARY KEY (`lecturesId`,`peopleId`) ) TYPE=MyISAM;

CREATE TABLE `series` ( `id` bigint(20) unsigned NOT NULL auto_increment, `name` varchar(255) NOT NULL default '', `namehtml` text, `abstract` text, `shortabstract` text, `keywords` text, `languagesId` bigint(20) unsigned NOT NULL default '0', `logo` bigint(20) unsigned default NULL, `time` varchar(255) default NULL, `sortdate` datetime NOT NULL default '0000-00-00 00:00:00', `place` varchar(255) default NULL, `institution` bigint(20) unsigned default NULL, `seriestype` set('lecture','event','symposium','topic') NOT NULL default 'lecture', `template` varchar(255) NOT NULL default 'default', `externalurl` varchar(255) default NULL, `status` enum('visible','hidden','inactive') NOT NULL default 'visible', PRIMARY KEY (`id`), KEY `status` (`status`) ) TYPE=MyISAM;

CREATE TABLE `topicnames` ( `topicsId` bigint(20) unsigned NOT NULL default '0', `name` varchar(255) NOT NULL default '', `languagesId` bigint(20) unsigned NOT NULL default '0', PRIMARY KEY (`topicsId`,`languagesId`) ) TYPE=MyISAM;

CREATE TABLE `topics` ( `id` bigint(20) unsigned NOT NULL auto_increment, `name` varchar(255) NOT NULL default '', PRIMARY KEY (`id`), UNIQUE KEY `name` (`name`) ) TYPE=MyISAM;
