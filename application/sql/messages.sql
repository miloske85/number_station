CREATE TABLE `messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(6) unsigned DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `date_mess` int(10) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
