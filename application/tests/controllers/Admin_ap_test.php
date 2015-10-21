<?php

class Admin_ap_test extends TestCase{

	private $_output;

	public function test_indexAuth(){
		$this->_output = $this->request('GET', 'admin/ap/index');
		$this->checkCommonTests();
		$this->assertContains('Current statistics', $this->_output);
	}

	public function test_list_users(){
		$this->_output = $this->request('GET', 'admin/ap/list_users');
		$this->checkCommonTests();
	}

	public function test_list_messages(){
		$this->_output = $this->request('GET', 'admin/ap/list_messages');
		$this->checkCommonTests();
	}

	public function test_show_message(){
		$this->_output = $this->request('GET', 'admin/ap/show_message/1');
		$this->checkCommonTests();
	}

	public function test_show_user(){
		$this->_output = $this->request('GET', 'admin/ap/show_user/1');
		$this->checkCommonTests();
	}

	/**
	*	Loads message edit form
	*/
	public function test_edit_messageGet(){
		$this->_output = $this->request('GET', 'admin/ap/edit_message/1');
		$this->checkCommonTests();
	}

	/**
	*	Loads user edit form
	*/
	public function test_edit_userGet(){
		$this->_output = $this->request('GET', 'admin/ap/edit_user/1');
		$this->checkCommonTests();
	}

	/**
	*	Loads delete confirmation page
	*/
	public function test_deleteUncomfirmed(){
		$this->_output = $this->request('GET', 'admin/ap/delete/user/1');
		$this->checkCommonTests();
		$this->assertContains('Are you sure you want to delete this', $this->_output);
	}

	/**
	*	Performs basic checks common to all methods
	*/
	private function checkCommonTests(){
		$this->assertContains('<title>Admin Control Panel</title>', $this->_output);
		$this->assertNotContains('A PHP Error was encountered', $this->_output);
		$this->assertContains("<body><!--", $this->_output);
	}

}
