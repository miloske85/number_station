CREATE TABLE IF NOT EXISTS captcha (
        captcha_id int(10) unsigned NOT NULL auto_increment,
        captcha_time int(10) unsigned NOT NULL,
        ip_address varchar(45) NOT NULL,
        word varchar(20) NOT NULL,
        PRIMARY KEY (`captcha_id`),
        KEY (`word`)
);