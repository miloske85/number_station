<?php

class Users_test extends TestCase{

	private $_output;

	/**
	*	Accessing index page when not authenticated should redirect to the homepage
	*/
	//public function test_indexRedirect(){
		//$this->_output = $this->request('GET', ['User', 'index']);
		//$this->assertRedirect('/', 302);
	//}	

	//public function test_indexAuth(){
		//	Setting private properties with ReflectionHelper
		//$obj = new User();
		//ReflectionHelper::setPrivateProperty($obj, $viewData['username'], 'phpunit');
		//ReflectionHelper::setPrivateProperty($obj, $viewData['email'], 'phpunit@phpunit.local');

		//$this->_output = $this->request('GET', ['User', 'index']);
		//$this->checkCommonTests();	//	Works, but the test fails because $this->_user is not an object when running PHPUnit
	//}
	
	//public function test_list_users(){
		//$this->_output = $this->request('GET', 'user/list_users');
		//$this->checkCommonTests();
		//$this->assertContains('administrator', $this->_output);
	//}
	

	/**
	*	Method that shows single user profile
	*/
	public function test_show_user(){
		$this->_output = $this->request('GET', ['User', 'show_user', '1']);
		$this->checkCommonTests();
		$this->assertContains('administrator', $this->_output);
	}
	
	public function test_list_users(){
		$this->_output = $this->request('GET', ['User', 'list_users']);
		$this->checkCommonTests();
		$this->assertContains('List of registered users', $this->_output);
	}
	
	public function test_avatar(){
		$this->_output = $this->request('GET', 'user/avatar');
		$this->checkCommonTests();
		$this->assertContains('Your current avatar', $this->_output);
	}
	
	/**
	 * Tests form display page
	 */
	public function test_change_pass(){
		$this->_output = $this->request('GET', 'user/change_pass');
		$this->checkCommonTests();
		$this->assertContains('Old Password', $this->_output);
	}
	
	/**
	 * Tests form display page
	 */
	public function test_forgot_password(){
		$this->_output = $this->request('GET', 'user/forgot_password');
		$this->checkCommonTests();
	}

	/**
	*	Performs basic checks common to all methods
	*/
	private function checkCommonTests(){
		$this->assertContains('<title>User Control Panel</title>', $this->_output);
		$this->assertNotContains('A PHP Error was encountered', $this->_output);
		$this->assertContains("<body><!--", $this->_output);
	}
}
