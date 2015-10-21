<?php

class PrivateMessageSeeder extends Seeder{
	
	public function run(){
		
		//insert mock private message
		$data = array('sender' => 2, 'recepient' => 1, 'subject' => 'PHPUNIT Test', 'message' => 'PHPUNIT Test', 'date_sent' => 0);
		
		$this->db->insert('private_messages', $data);
	}
}
