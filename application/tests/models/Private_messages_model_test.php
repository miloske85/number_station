<?php

class Private_messages_model_test extends TestCase{
	
	public function setUp(){
		$this->resetInstance();	//according to the docs for the v0.8.2
		$this->CI->load->model('Private_messages_model');
		$this->obj = $this->CI->Private_messages_model;
	}
	
	public function testSendPm(){
		$returned = $this->obj->sendPM(array('sender' => 2, 'recepient' => 1, 'subject' => 'PHPUNIT', 'message' => 'PHPUNIT Test'));
		
		$this->assertTrue($returned);	//tests what sendPM() returns
	}
	
	public function testSelectMessage(){
		$returned = (int) $this->obj->selectMessage('PHPUNIT Test');
		
		$this->assertTrue(is_numeric($returned));
	}
	
	public function testMarkPMasRead(){
		$id = (int) $this->obj->selectMessage('PHPUNIT Test');
		$returned = $this->obj->markPMasRead(1, $id);
		
		$this->assertTrue($returned);
	}
	
	public function testGetPrivateMessages(){
		$returned = $this->obj->getPrivateMessages(0,50,1);
		
		$this->assertTrue(is_array($returned));
	}
	
	public function testGetPrivateMessage(){
		$id = (int) $this->obj->selectMessage('PHPUNIT Test');
		$returned = $this->obj->getPrivateMessage(1,$id);
		
		$this->assertContains('PHPUNIT', $returned->subject);
	}
	
	public function testCountPrivateMessages(){
		$returned = (int) $this->obj->countPrivateMessages(1);
		
		$this->assertTrue(is_numeric($returned));
	}
	
	public function testGetSubject(){
		$id = (int) $this->obj->selectMessage('PHPUNIT Test');
		$returned = $this->obj->getSubject(1, $id);
		
		$this->assertContains('PHPUNIT', $returned);
	}
	
	public function testDelete(){
		$id = (int) $this->obj->selectMessage('PHPUNIT Test');
		$returned = $this->obj->delete($id);
		
		$this->assertTrue($returned);
	}

}
