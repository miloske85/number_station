<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Demo Reset
*
*	Version: 1.0
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Controller for resetting site data.
*
*	Requires: Codeigniter 3
*/

class Demo_reset extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->model(array('Demo_model'));
		$this->load->helper('url');
	}


	public function index(){
		redirect('/');
	}

	/**
	*	Resets data, called from MY_Controller or elsewhere. Should have random name for an added security.
	*/
	public function reset_j49zm30nj29(){
		$this->Demo_model->reset();
	}




}