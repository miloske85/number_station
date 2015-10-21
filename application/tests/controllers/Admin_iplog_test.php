<?php

class Admin_iplog_test extends TestCase{
	
	private $_output;
	
	public function test_index(){
		$this->_output = $this->request('GET', 'admin/iplog/index');
		
		$this->checkCommonTests();
	}
	
	public function test_view_list(){
		$this->_output = $this->request('GET', 'admin/iplog/view_list');
		
		$this->checkCommonTests();
	}
	
	/**
	*	Performs basic checks common to all methods
	*/
	private function checkCommonTests(){
		$this->assertContains('<title>Access Log</title>', $this->_output);
		$this->assertNotContains('A PHP Error was encountered', $this->_output);
		$this->assertContains("<body><!--", $this->_output);
	}
}
