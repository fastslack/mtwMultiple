CREATE TABLE `#__mtwmultiple_firstinstall` (
  `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `filename` VARCHAR( 255 ) NOT NULL ,
  `type` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM ;

INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`, `client_id`, `enabled`, `access`, `protected`, `manifest_cache`, `params`, `custom_data`, `system_data`, `checked_out`, `checked_out_time`, `ordering`, `state`) VALUES
(NULL, 'plg_mtwFirstInstall', 'plugin', 'mtwFirstInstall', 'system', 0, 1, 1, 1, '', '{}', '', '', 0, '0000-00-00 00:00:00', 1, 0);

