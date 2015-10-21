<?php

class UserSeeder extends Seeder{
	
	public function run(){
		
		//set avatar
		$data['avatar'] = 'PHPUnit_test_avatar';
		
		$this->db->where('id',1);
		$this->db->update('users', $data);
	}
}
