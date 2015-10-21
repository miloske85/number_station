<?php

class Content_test extends TestCase{

	private $_output;

	public function test_tos(){

		$this->_output = $this->request('GET', ['Content', 'tos']);
		$this->checkCommonTests();
		$this->assertContains('<title>Terms of Service</title>', $this->_output);
	}

	public function test_about(){
		$this->_output = $this->request('GET', ['Content', 'about']);
		$this->checkCommonTests();
		$this->assertContains('<title>About</title>', $this->_output);
	}

	public function test_external_links(){
		$this->_output = $this->request('GET', ['Content', 'external_links']);
		$this->checkCommonTests();
		$this->assertContains('<title>External Links</title>', $this->_output);
	}

	/**
	*	Performs basic checks common to all methods
	*/
	private function checkCommonTests(){
		$this->assertNotContains('A PHP Error was encountered', $this->_output);
		$this->assertContains("<body><!--", $this->_output);
	}

}