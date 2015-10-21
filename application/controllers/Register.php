<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Register
*
*	Version: 1.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Performs user registration.
*
*	Requires: Codeigniter 3
*/
class Register extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->helper(array('url','form', 'captcha', 'security'));
		$this->load->library(array('form_validation', 'ion_auth'));
		$this->load->model(array('Captcha_model', 'User_model'));
		$this->_data['pageTitle'] = 'Register';
	}

	/**
	 * Displays form, collects data, registers user. All-in-one.
	 */
	public function index(){

		$this->_data['nav_uri'] = 'register';
		
		$data = array(
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password'),
				'password2' => $this->input->post('password2'),
				'captcha' => $this->input->post('captcha')
			);

		$data = $this->security->xss_clean($data);

		if(!isset($data['username'])){
			$this->_data['captcha'] = $this->createCatcha();
			$this->loadViews('register');
		}
		//form submitted
		else{

			if($this->User_model->validateReg($this->_data['validation_params']) == TRUE){
				//check captcha

				$ip = $this->input->ip_address();

				$check = $this->Captcha_model->checkCaptcha($data['captcha'], $ip);

				if($check){
					//check username and email

					$uniqueness = 1;

					if($this->ion_auth->username_check($data['username'])){
						$uniqueness = 0;
						$this->_data['status_report'] = 'Username already taken';
					}
					if($this->ion_auth->email_check($data['email'])){
						$uniqueness = 0;
						$this->_data['status_report'] = 'Email already registered';
					}

					if($uniqueness == 1){
						// echo 'ok, registering';
						$status = $this->ion_auth->register($data['username'], $data['password'], $data['email'], array());

						if($status){
							$this->_data['status_report'] = 'Account registered successfully';
						}
						else{
							$this->_data['status_report'] = 'Registration failed, please try again later';
						}
						$this->loadViews('status_report');
					}
					else{
						$this->loadViews('status_report');
					}
				}
				else{
					$this->_data['captcha'] = $this->createCatcha();
					$this->_data['error'] = 'CAPTCHA code did not match';
					$this->loadViews('register');
				}
			}
			else{
				$this->_data['captcha'] = $this->createCatcha();
				$this->loadViews('register');
			}						
		}

	}

	protected function createCatcha(){
		$cap = parent::createCatcha();

		$data = array(
				'word' => $cap['word'],
				'ip_address' => $this->input->ip_address(),
				'captcha_time' => $cap['time']
			);

		$this->Captcha_model->insertCaptcha($data);

		return $cap;		
	}	
}
