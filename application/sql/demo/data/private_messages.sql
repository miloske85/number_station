DELETE FROM `private_messages`;

--
-- Dumping data for table `private_messages`
--

INSERT INTO `private_messages` (`id`, `sender`, `recepient`, `subject`, `message`, `date_sent`, `is_read`) VALUES
(1, 1, 2, 'Welcome', 'Hi, welcome to the demo version of my site.\r\n\r\nThanks for taking the interest in it.\r\n\r\nHere you can explore every functionality of this site (as an admin) and after pre-set time everything will be returned to the original state. Please don''t hesitate to contact me for any questions/suggestions/criticism.\r\n\r\nIf you wish to see the site from a (regular) user perspective you can log in as "reg_user_01" with password "password".\r\n\r\nBest regards,\r\nMilos', 1437834386, 0);
