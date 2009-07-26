DROP TABLE IF EXISTS `#__mtwmultiple_sites`;
CREATE TABLE IF NOT EXISTS `jos_mtwmultiple_sites` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `title` varchar(255) collate utf8_unicode_ci NOT NULL,
  `email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `password` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__mtwmultiple_extensions`;
CREATE TABLE IF NOT EXISTS `jos_mtwmultiple_extensions` (
  `id` int(11) NOT NULL auto_increment,
  `filename` varchar(255) collate utf8_unicode_ci NOT NULL,
  `type` varchar(255) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `author` varchar(255) collate utf8_unicode_ci NOT NULL,
  `creationDate` varchar(255) collate utf8_unicode_ci NOT NULL,
  `copyright` varchar(255) collate utf8_unicode_ci NOT NULL,
  `license` varchar(255) collate utf8_unicode_ci NOT NULL,
  `authorEmail` varchar(255) collate utf8_unicode_ci NOT NULL,
  `authorUrl` varchar(255) collate utf8_unicode_ci NOT NULL,
  `version` varchar(255) collate utf8_unicode_ci NOT NULL,
  `enable` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

