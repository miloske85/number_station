CREATE TABLE `private_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sender` int(6) unsigned NOT NULL,
  `recepient` int(6) unsigned NOT NULL,
  `subject` varchar(200) NULL,
  `message` TEXT NOT NULL,
  `date_sent` int(10) NOT NULL,
  `is_read` TINYINT DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
