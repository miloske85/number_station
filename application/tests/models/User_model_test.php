<?php

	class User_model_test extends TestCase{

		public function setUp(){
			$this->resetInstance();	//according to the docs for the v0.8.2
			$this->CI->load->model('User_model');
			$this->obj = $this->CI->User_model;
		}
		
		public static function setUpBeforeClass(){
			parent::setUpBeforeClass();

			$CI =& get_instance();
			$CI->load->library('Seeder');
			$CI->seeder->call('UserSeeder');
		}

		public function testGetIdFromUname(){
			$returned = $this->obj->getIdFromUname('administrator');
			
			$this->assertEquals(1, $returned, 'Returnd user ID not accurate');
		}
		
		public function testGetUsername(){
			$returned = $this->obj->getUsername('admin@admin.com');
			
			$this->assertEquals('administrator', $returned, 'Returned username not accurate');
		}
		
		public function testCheckExistingPassword(){
			$returned = $this->obj->checkExistingPassword('password',1);
			
			$this->assertTrue($returned);
		}
		
		public function testGetAvatar(){
			$returned = $this->obj->getAvatar(1);
			
			$this->assertEquals('PHPUnit_test_avatar', $returned->avatar, 'Avatar not set properly');
		}
		
		public function testListUsers(){
			$returned = $this->obj->listUsers(0,1);
			
			$this->assertEquals('administrator', $returned[0]['username'], 'Username not returned correctly');
			$this->assertTrue(count($returned) == 1);
		}
		
		public function testGetUser(){
			$returned = $this->obj->getUser(1);	//returning one dimensional, two member array
			
			$this->assertTrue(count($returned) == 2);
			$this->assertEquals('administrator', $returned['username']);
		}
		
		public function testCountUsers(){
			$returned = $this->obj->countUsers();
			
			$this->assertTrue(is_numeric($returned));
			$this->assertTrue($returned >= 0);
		}
		
		//	====================================================================
		//	Update methods
		//	====================================================================
		
		public function testChangePassword(){
			$returned = $this->obj->changePassword('password',1);
			
			$this->assertTrue($returned);
		}
		
		public function testUpdateAvatar(){
			$returned = $this->obj->updateAvatar(1,array('avatar' => 'PHPUNIT'));
			
			$this->assertTrue($returned);
		}
		
		/**
		 * Tests success of updateAvatar() by checking changes in database
		 */
		public function testSuccessUpdateAvatar(){
			$returned = $this->obj->getAvatar(1);
			
			$this->assertEquals('PHPUNIT', $returned->avatar, 'Avatar not updated properly');
		}
		
		public function testDeleteAvatar(){
			$returned = $this->obj->deleteAvatar(1);
			
			$this->assertTrue($returned);
		}
		
		/**
		 * Tests success of deleteAvatar() by querying database
		 */
		public function testSuccessDeleteAvatar(){
			$returned = $this->obj->getAvatar(1);
			
			$this->assertEquals(NULL, $returned->avatar, 'Avatar not deleted properly');
		}


	}
