<?php

class Messages_test extends TestCase{

	private $_output;

	public function test_index(){

		$this->_output = $this->request('GET', ['Messages', 'index']);
		$this->checkCommonTests();
	}

	/**
	*	Checks the output of loading this page with GET
	*/
	public function test_postGet(){

		$this->_output = $this->request('GET', ['Messages', 'post']);
		$this->checkCommonTests();
	}

	/**
	*	Tests posting message without CAPTCHA
	*/
	public function test_postNoCaptcha(){
		$this->_output = $this->request('POST', ['Messages', 'post'], ['message' => 'test_message']);
		$this->checkCommonTests();
	}
	
	public function test_postPost(){
		$this->_output = $this->request('POST', ['Messages', 'post'], ['message' => 'PHPUNIT Test Message']);
		$this->checkCommonTests();
	}

	/**
	*	Tests loading the search page with GET
	*/
	public function test_searchGet(){

		$this->_output = $this->request('GET', ['Messages', 'search']);
		$this->checkCommonTests();
		$this->assertContains('Search string must be at least 2 characters long', $this->_output);
	}

	/**
	*	Performs a search, test message is already in the database
	*/
	public function test_searchPost(){
		$this->_output = $this->request('POST', ['Messages', 'search'], ['search_message' => 'testCountMessages']);
		$this->checkCommonTests();
		$this->assertContains('testCountMessages', $this->_output);
	}

	public function test_show_message(){
		//	message not specified
		$this->_output = $this->request('GET', ['Messages', 'show_message']);
		$this->checkCommonTests();
		$this->assertContains('The specified message doesn\'t exist', $this->_output);

		// any message would do
		$this->_output = $this->request('GET', ['Messages', 'show_message', '1']);
		$this->checkCommonTests();
		$this->assertContains('Listing of a message', $this->_output);
	}

	/**
	*	Performs basic checks common to all methods
	*/
	private function checkCommonTests(){
		$this->assertContains('<title>Numbers Relay Page</title>', $this->_output);
		$this->assertNotContains('A PHP Error was encountered', $this->_output);
		$this->assertContains("<body><!--", $this->_output);
	}

}
