<?php

/**
 * Some tests use searchMessage() method
 * It is essential that this method works properly
 */

	class Messages_model_test extends TestCase{
		
		private $_data = array();
		
		public function setUp(){
			$this->resetInstance();	//according to the docs for the v0.8.2
			$this->CI->load->model('Messages_model');
			$this->obj = $this->CI->Messages_model;
			$this->_data = array('name' => 'PHPUNIT', 'message' => 'PHPUNIT', 'active' => 1);
		}
		
		/**
		 * Tests if insertMessage works uses searchMessage() to verify
		 */
		public function testInsertMessage(){
			$returned = $this->obj->insertMessage($this->_data);
			
			$this->assertTrue($returned);
			
			$returned = $this->obj->searchMessages('PHPUNIT',0,10);
			$this->assertEquals('PHPUNIT', $returned[0]['message']);
		}
		
		public function testSearchMessages(){
			$returned = $this->obj->searchMessages('PHPUNIT',0,10);
			$this->assertEquals('PHPUNIT', $returned[0]['message']);
		}
		
		public function testGetMessages(){
			$returned = $this->obj->getMessages(0,3);
			
			$this->assertTrue(is_array($returned));
		}
		
		public function testGetMessage(){
			$id = (int) $this->obj->searchMessages('PHPUNIT',0,1)[0]['id'];
			$returned = $this->obj->getMessage($id);
			
			$this->assertEquals('PHPUNIT', $returned->name);
		}		
		
		/**
		 * Depends on getMessage()
		 */
		public function testUpdateMessage(){
			$id = (int) $this->obj->searchMessages('PHPUNIT',0,1)[0]['id'];
			$data = array('name' => 'PHPUNIT name');
			
			if(is_numeric($id)){
				$returned = $this->obj->updateMessage($id, $data);
				
				$this->assertTrue($returned);
				
				if($returned){
					$returned = $this->obj->getMessage($id);
					
					$this->assertContains('PHPUNIT name', $returned->name);	//	Tests if message was actually updated
				}
			}
		}
		
		public function testDeleteMessage(){
			$id = (int) $this->obj->searchMessages('PHPUNIT',0,1)[0]['id'];
			if(is_numeric($id)){
				$returned = $this->obj->deleteMessage($id);
				
				$this->assertTrue($returned);	//checks what method returns
				
				if($returned){
					$returned = $this->obj->getMessage($id);
					
					$this->assertFalse($returned);	//checks if the message is actually deleted
				}
			}
			else{
				$this->assertTrue(FALSE, 'Message id not set correctly (not numeric)');
			}
		}
		
		public function testCountMessages(){
			$returned = $this->obj->countMessages();
			
			$this->assertTrue(is_numeric($returned) && $returned >= 0);
		}

		public function testCountMessageSearch(){
			$expected = 2;

			$returned = $this->obj->countMessageSearch('testCountMessages', true);

			$this->assertEquals($expected, $returned, 'Counting messages matching search string');
		}


	}
