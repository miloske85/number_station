CREATE TABLE iplog_log (
	id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	page_id int(6) UNSIGNED NOT NULL,
	date int(10) NOT NULL,
	ua int(6) NOT NULL,
	referer varchar(1000) NULL,
	ip varchar(45) NOT NULL,
	user_id int(6) DEFAULT 0,
	comment varchar(500) NULL,
	PRIMARY KEY (id)
);
