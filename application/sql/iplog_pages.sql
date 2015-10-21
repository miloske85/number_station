CREATE TABLE iplog_pages (
	id int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
	site_id int(5) UNSIGNED NULL,
	name varchar(50) NULL,
	uri varchar(500) NOT NULL,
	version varchar(50) NULL,
	comment varchar(500) NULL,
	PRIMARY KEY (id),
	UNIQUE KEY uri_index (uri)
);
