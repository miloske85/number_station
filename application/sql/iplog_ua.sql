CREATE TABLE iplog_ua (
	id int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
	ua varchar(500) NOT NULL,
	comment varchar(200) NULL,
	PRIMARY KEY (id),
	UNIQUE KEY ua_index (ua)
);
