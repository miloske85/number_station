<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Login
*
*	Version: 1.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Performs log in/out operations.
*
*	Requires: Codeigniter 3
*/
class Login extends MY_Controller {


	public function __construct(){
		parent::__construct();

		$this->load->helper(array('url','form'));
		$this->load->library(array('form_validation', 'ion_auth'));
		$this->load->model(array('User_model'));
		$this->_data['pageTitle'] = 'Log In';
	}

	/**
	 * Displays login form, processes data and logs the user in
	 */
	public function index(){

		$this->_data['nav_uri'] = 'login';

		$data = array(
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password')
			);		

		if(!isset($data['username'])){	//if loading for the first time show the form
			$this->loadViews('login');
		}
		else{		//data submitted

			if($this->User_model->validateLogin($this->_data['validation_params']) == TRUE){
				$status = $this->ion_auth->login($data['username'], $data['password']);

				//redirect
				if($status){
					redirect('/');
				}
				else{
					$this->_data['status_report'] = 'Login failed, wrong username or password';
					$this->loadViews('status_report');
				}
			}
			else{
				$this->loadViews('login');
			}
		}
	}

	/**
	 * Logs out and redirects to /
	 */
	public function logout(){
		$this->ion_auth->logout();
		redirect('/');
	}

}
