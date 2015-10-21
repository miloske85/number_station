<?php
	
	/**
	 * Fills database with given data
	*/
	$disable = true;
	
	if($disable){
		echo "script disabled, edit line 6 to enable it\n";
		die;
	}
	
	/*
	 * Disabled
	*/
	
	$dbhost = 'localhost';
	$dbdb = 'dev_ci_number_station';

	$dbuser = 'dbuser';
	$dbpass = 'dbpass';
	
	$dsn = "mysql:dbname=$dbdb;host=$dbhost";

	$dh = new PDO($dsn, $dbuser, $dbpass);

	$insertRounds = 50;
	
	//populate messages table
/*	for($i=0; $i<$insertRounds; $i++){
		$date_mess = time();
		$message = 'Message No. '.$i;
		
		$insSql = "INSERT INTO messages (user_id, date_mess, public, active, message) VALUES ('2', '$date_mess', '0','1', '$message')";
		$status = $dh->exec($insSql);
		//var_dump($insSql);
	}*/
	
	//populate private_messages table
	for($i=0; $i<$insertRounds; $i++){
		
		$username = 'fill_user'.$i;
		$ip_address = 'bogus';
		$password = 'bogus';
		$email = 'bogus';
		$sql = "INSERT INTO users (username, ip_address, password, email, created_on) VALUES ('$username', 'bogus','bogus','bogus',1)";

		$status = $dh->exec($sql);
		
		if(!$status){
			echo "db error<br>";
		}
	}
