<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Search
*
*	Version: 1.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Performs various searches from admin control panel.
*
*	Requires: Codeigniter 3
*/
class Search extends MY_Controller {


	public function __construct(){
		parent::__construct();
		
		$this->load->helper(array('url','form'));
		$this->load->library(array('form_validation', 'ion_auth', 'pagination'));
		$this->load->model(array('User_model', 'admin/Users_model', 'Messages_model', 'admin/Admindata_model'));
		$this->checkAdmin('die');
		//$this->setViewData1();
		$temp = $this->Admindata_model->getData();
		$this->_data = array_merge($this->_data, $temp);

		//navbar hack
		$this->_data['nav_uri'] = 'admin';
	}

	public function index(){
		$this->loadViews('admin/search');
	}

	public function message(){
		$searchString = $this->input->post('search_message');

		//pagination
		$this->_pagination_config['base_url'] = base_url('admin/search/message');
		$this->_pagination_config['total_rows'] = $this->Messages_model->countMessageSearch($searchString, TRUE);
		$this->_pagination_config['per_page'] = 20;

		$this->_data['search_count'] = $this->_pagination_config['total_rows'];

		$this->pagination->initialize($this->_pagination_config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		//data
		$this->_data['search_results'] = $this->Messages_model->searchMessages($searchString, $page, $this->_pagination_config['per_page'], TRUE);

		$this->_data['pag_links'] = $this->pagination->create_links();

		$this->loadViews('admin/search_results_messages');
	}

	public function username(){
		$searchString = $this->input->post('search_username');

		$this->_data['search_results'] = $this->Users_model->searchByUsername($searchString);
		$this->_data['search_count'] = count($this->_data['search_results']);
		$this->loadViews('admin/search_results_users');
	}

	public function email(){
		$searchString = $this->input->post('search_email');

		$this->_data['search_results'] = $this->Users_model->searchByEmail($searchString);
		$this->_data['search_count'] = count($this->_data['search_results']);
		$this->loadViews('admin/search_results_users');
	}

	protected function loadViews($template, $data = null){
		parent::loadAdminViews($template, $data);
	}
	
	private $i=0;

	//protected function setViewData1(){
		//parent::setViewData();
		//$temp = $this->Admindata_model->getData();
		//$this->_data = array_merge($this->_data, $temp);
	//}	

}
