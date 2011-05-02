
CREATE TABLE IF NOT EXISTS `config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`config_id`),
  KEY `order` (`order`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `config_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  `config_content` blob NOT NULL,
  `commented` tinyint(1) NOT NULL,
  `revision` int(11) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `mail_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `config-id` (`config_id`)
) DEFAULT CHARSET=utf8 ;
