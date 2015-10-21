<?php

class Admin_search_test extends TestCase{

	private $_output;

	public function test_index(){
		$this->_output = $this->request('GET', 'admin/search/index');
		$this->checkCommonTests();
	}

	public function test_messagePost(){
		
	}

	/**
	*	Performs basic checks common to all methods
	*/
	private function checkCommonTests(){
		$this->assertContains('<title>Admin Panel</title>', $this->_output);
		$this->assertNotContains('A PHP Error was encountered', $this->_output);
		$this->assertContains("<body><!--", $this->_output);
	}

}
