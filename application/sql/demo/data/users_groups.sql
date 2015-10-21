DELETE FROM `users_groups`;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(4, 2, 1),
(3, 2, 2),
(5, 3, 2);