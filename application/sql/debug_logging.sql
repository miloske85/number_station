CREATE TABLE debug_logging(
	id int(11) unsigned NOT NULL AUTO_INCREMENT,
	tstamp int(10) unsigned DEFAULT 0,
	value TEXT NULL,
	PRIMARY KEY (id)
)