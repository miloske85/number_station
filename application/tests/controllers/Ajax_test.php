<?php

class Ajax_test extends TestCase{
	
	public function testRegirster(){
		$output = $this->request('GET', 'ajax/register/administrator');
		
		$this->assertContains('<p class="text-danger">Username already taken</p>', $output);
	}
	
}
