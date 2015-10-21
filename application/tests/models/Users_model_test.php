<?php

/**
 * Tests for the admin/Users_model
 */
 
class Users_model_test extends TestCase{
	
	public function setUp(){
		$this->resetInstance();	//according to the docs for the v0.8.2
		$this->CI->load->model('admin/Users_model');
		$this->obj = $this->CI->Users_model;
	}
	
	public function test_listUsers(){
		$returned = $this->obj->listUsers(1,0);
		
		$this->assertEquals('administrator', $returned[0]['username']);
		$this->assertEquals(1, count($returned));
	}
	
	public function test_getUser(){
		$returned = $this->obj->getUser(1);
		
		$this->assertEquals('administrator', $returned->username);
	}
	
	public function testCountUsers(){
		$returned = $this->obj->countUsers();
		
		$this->assertTrue(is_numeric($returned));
		$this->assertTrue($returned >= 0);
	}
	
	public function testSearchByUsername(){
		$returned = $this->obj->searchByUsername('administrator');
		
		$this->assertEquals('admin@admin.com', $returned[0]['email']);
	}
	
	public function testSearchByEmail(){
		$returned = $this->obj->searchByEmail('admin@admin.com');
		
		$this->assertEquals('administrator', $returned[0]['username']);
	}
	
	//==========================================================================
	//	UPDATE METHODS
	//==========================================================================
	
	public function testUpdateUser(){
		$returned = $this->obj->updateUser(1, array('phone' => 'PHPUNIT'));
		
		$this->assertTrue($returned);	//method has returned true
		
		if($returned){
			$returned = $this->obj->getUser(1);
			
			$this->assertEquals('PHPUNIT', $returned->phone);	//test if phone is indeed set
			
			if($returned){
				$this->obj->updateUser(1, array('phone' => NULL));	//remove phone
			}
		}
	}
	
	/**
	 * Tests only if admin can't be deleted
	 */
	public function testDeleteUser(){
		$returned = $this->obj->deleteUser(1);
		
		$this->assertFalse($returned);	//admin can't be deleted
	}
	
}
