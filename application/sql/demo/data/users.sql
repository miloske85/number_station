DELETE FROM `users`;

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `avatar`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$08$5A4C.jieIVb7O2CMOco3n.751h9kglKm9rBrbYlDUvcJo//5H50iu', '', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, NULL, 1, 'Admin', 'istrator', 'ADMIN', '0', NULL),
(2, '192.168.109.1', 'demo', '$2y$08$kmB2Q6jGWn8CpK.ABhbkRuSLH02kJf6htzP6ZPWBAWDwjri/FQ8Ay', NULL, 'demo@examle.com', NULL, NULL, NULL, NULL, 1437833561, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(3, '192.168.109.1', 'reg_user_01', '$2y$08$qd.dBKesVnXOBShJ24l2D.91RZEBozKbyAl0HjEmZxdgcbFJ5xp.2', NULL, 'reg_user_01@example.com', NULL, NULL, NULL, NULL, 1437833655, NULL, 1, NULL, NULL, NULL, NULL, NULL);