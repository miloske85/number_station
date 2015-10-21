<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Admindata model
*
*	Version: 1.0
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Sets data for admin control panel.
*
*	Requires: Codeigniter 3
*/

 class Admindata_model extends MY_Model {

 	private $_adminData = array();

	public function __construct(){
		parent::__construct();
		$this->load->library('ion_auth');
		$this->setData();
	}

	public function getData(){
		return $this->_adminData;
	}
	
	private function setData(){

		$temp = array(
				'pageTitle' => 'Admin Panel',
				// 'welcome_message' => 'Greetings, '.$this->ion_auth->user()->row()->username,
				// 'welcome_message' => 'Greetings, ',
				'logged_in' => $this->ion_auth->logged_in()
			);

		$this->_adminData = array_merge($this->_adminData, $temp);
	}	

}
