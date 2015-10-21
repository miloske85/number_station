<?php

class Install_test extends TestCase{
	
	private $_output;
	
	public function test_index(){
		$this->_output = $this->request('GET', 'install/index');
		
		$this->checkCommonTests();
		$this->assertContains('This will install database tables', $this->_output);
	}
	
	/**
	*	Performs basic checks common to all methods
	*/
	private function checkCommonTests(){
		$this->assertContains('<title>Set up database</title>', $this->_output);
		$this->assertNotContains('A PHP Error was encountered', $this->_output);
		$this->assertContains("<body><!--", $this->_output);
	}
}
