<?php

class Private_messages_test extends TestCase{
	
	private $_output;
	
	/**
	 * Private message ID (of the message inserted by the seeder
	 */
	private $_pmid;
	
	public static function setUpBeforeClass(){
			parent::setUpBeforeClass();

			$CI =& get_instance();
			$CI->load->library('Seeder');
			$CI->seeder->call('PrivateMessageSeeder');			
	}
	
	/**
	 * Sets up object to communicate with Private_messages_model
	 */
	public function setUp(){
			$this->resetInstance();	//according to the docs for the v0.8.2
			$this->CI->load->model('Private_messages_model');
			$this->obj = $this->CI->Private_messages_model;
			
			$this->getMessageId();
	}
	
	public function test_index(){
		$this->_output = $this->request('GET', 'private_messages/index');
		
		$this->checkCommonTests();
	}
	
	public function test_read_message(){
		$this->_output = $this->request('GET', 'private_messages/read_message/'.$this->_pmid);
		$this->checkCommonTests();
		
		$this->assertContains('PHPUNIT Test', $this->_output);
	}
	
	public function test_send_message(){
		$this->_output = $this->request('GET', 'private_messages/send_message');
		$this->checkCommonTests();
	}
	
	public function test_delete(){
		$this->_output = $this->request('GET', 'private_messages/delete/'.$this->_pmid.'/conf');
		$this->checkCommonTests();
		$this->assertContains('Message deleted successfully', $this->_output);
	}
	
	/**
	*	Performs basic checks common to all methods
	*/
	private function checkCommonTests(){
		$this->assertContains('<title>User Control Panel</title>', $this->_output);
		$this->assertNotContains('A PHP Error was encountered', $this->_output);
		$this->assertContains("<body><!--", $this->_output);
	}
	
	/**
	 * Sets the PM id
	 */
	private function getMessageId(){
		$this->_pmid = $this->obj->getMessageId('PHPUNIT Test');
	}
}
