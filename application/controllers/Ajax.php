<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Ajax
*
*	Version: 1.0.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Controller for handling AJAX requests.
*
*	Requires: Codeigniter 3
*/

class Ajax extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form', 'captcha'));
		$this->load->library(array('form_validation', 'ion_auth', 'email', 'pagination'));

		$this->config->load('number_station', TRUE);
		$this->config->load('ion_auth', TRUE);

	}

	/**
	*	Checks if username is already registered
	*
	*	@param string $username Username typed into form
	*/
	public function register($username){

		$check = $this->ion_auth->username_check($username);	//returns TRUE if registered, FALSE if username is available

		if($check){
			echo '<p class="text-danger">Username already taken</p>';
		}
		else{
			echo '<p class="text-success">Username available</p>';
		}
	}

	public function index(){
		redirect('/');
	}

}
