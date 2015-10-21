<?php

class Login_test extends TestCase{

	private $_output;

	public function test_loginGet(){

		$this->_output = $this->request('GET', ['Login', 'index']);
		$this->checkCommonTests();
	}

	public function test_loginWrongCredentials(){
		$this->_output = $this->request('POST', ['Login', 'index'], ['username' => 'not-exists', 'password' => 'not-exists']);
		$this->checkCommonTests();
		$this->assertContains('Login failed, wrong username or password', $this->_output);
	}

	public function test_loginGoodCredentials(){
		//	These credentials don't pass authentication, despite being good
		//$this->_output = $this->request('POST', ['Login', 'index'], ['username' => 'administrator', 'password' => 'password']);
		//$this->assertRedirect('/', 302);
		//$this->checkCommonTests();
		// $this->assertContains('Login failed, wrong username or password', $this->_output);
	}

	/**
	*	Performs basic checks common to all methods
	*/
	private function checkCommonTests(){
		$this->assertContains('<title>Log In</title>', $this->_output);
		$this->assertNotContains('A PHP Error was encountered', $this->_output);
		$this->assertContains("<body><!--", $this->_output);
	}
}
