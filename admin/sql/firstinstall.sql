CREATE TABLE `#__mtwmultiple_firstinstall` (
  `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `filename` VARCHAR( 255 ) NOT NULL ,
  `type` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM ;

INSERT INTO `#__plugins` VALUES(35, 'System - First Install', 'mtwFirstInstall', 'system', 0, 0, 1, 0, 0, 62, '0000-00-00 00:00:00', '');
