<?php
/*
*	Test if emails can be sent
*/
die;
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends MY_Controller {

	public function __construct(){
		parent::__construct();
		// $this->load->helper(array('url','form', 'captcha'));
		$this->load->library(array('email'));

		// $this->load->model(array('User_model', 'Captcha_model'));

		$this->config->load('number_station', TRUE);
		$this->config->load('ion_auth', TRUE);

		// $this->setViewData();
		// $this->setIdentity();
	}

	public function index(){
		$this->email->from('postmaster@www-deb.linux.local');
		$this->email->to('milos@www-deb.linux.local');

		$this->email->subject('CI emails test');

		$this->email->message('Testing to see if CI can send messages');

		$status = $this->email->send();
	}

}