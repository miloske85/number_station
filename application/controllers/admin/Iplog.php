<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Iplog
*
*	Version: 1.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Provides listing and search of IP addr. and other access parameters.
*
*	Requires: Codeigniter 3
*/
class Iplog extends MY_Controller {


	public function __construct(){
		parent::__construct();
		
		$this->load->helper(array('url','form', 'cookie'));
		$this->load->library(array('form_validation', 'ion_auth', 'pagination'));
		$this->checkAdmin('redirect');
		$this->load->model(array('Iplog_model'));
		$this->config->load('number_station', TRUE);
		$this->_data['pageTitle'] = 'Access Log';

		//navbar hack
		$this->_data['nav_uri'] = 'admin';
	}
	
	public function index(){
		$this->_data['total_hits'] = $this->Iplog_model->countHits();
		$this->_data['hits_by_time'] = $this->Iplog_model->countHitsByTime();
		
		$this->loadViews('admin/iplog_overview');
	}
	
	/**
	 * Shows list of all visits
	 * 
	 * @param string $order Order by
	 * @param string $type Type of ordering, ascending or descending
	 */
	public function view_list($order = 'date', $ordering = 'DESC'){
		
		$this->_pagination_config['base_url'] = base_url('admin/iplog/view_list/'.$order.'/'.$ordering.'/');
		$this->_pagination_config['total_rows'] = $this->Iplog_model->countHits();
		$this->_pagination_config['per_page'] = 20;
		
		$this->pagination->initialize($this->_pagination_config);
		
		$page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
		
		$this->_data['hits_list'] = $this->Iplog_model->getHits($order, $ordering, $page, $this->_pagination_config['per_page']);
		
		$this->_data['pag_links'] = $this->pagination->create_links();
		
		$this->loadViews('admin/hits_list');	
	}
	
	public function search(){
		if($this->input->post('iplogSearch') != null){
			//search form is posted
			$formData = array(
				'iplogSearch' => $this->input->post('iplogSearch'),
				'searchType' => $this->input->post('iplogSearchRadio')
			);
			set_cookie('ns_iplog_search_string', $formData['iplogSearch'], 86400);
			set_cookie('ns_iplog_search_type', $formData['searchType'], 86400);
		}
		else{
			//don't have submitted data with pagination
			$formData['iplogSearch'] = get_cookie('ns_iplog_search_string');
			$formData['searchType'] = get_cookie('ns_iplog_search_type');
		}
		
		//set up pagination
		$this->_pagination_config['base_url'] = base_url('admin/iplog/search');
		$this->_pagination_config['total_rows'] = $this->Iplog_model->countSearch($formData['searchType'], $formData['iplogSearch']);
		$this->_pagination_config['per_page'] = 20;

		$this->_data['search_count'] = $this->_pagination_config['total_rows'];

		$this->pagination->initialize($this->_pagination_config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		switch($formData['searchType']){
			case 'ip':
				$data['hits_list'] = $this->Iplog_model->searchIplog('ip',$formData['iplogSearch'], $page, $this->_pagination_config['per_page']);
			break;
			case 'username':
				$data['hits_list'] = $this->Iplog_model->searchIplog('username', $formData['iplogSearch'], $page, $this->_pagination_config['per_page']);
			break;
			case 'referer':
				$data['hits_list'] = $this->Iplog_model->searchIplog('referer', $formData['iplogSearch'], $page, $this->_pagination_config['per_page']);
			break;
			case 'uri':
				$data['hits_list'] = $this->Iplog_model->searchIplog('uri', $formData['iplogSearch'], $page, $this->_pagination_config['per_page']);
			break;
			
			default:
				echo 'wrong search parameter';
				die;
			break;
		}
		
		$this->_data['pag_links'] = $this->pagination->create_links();
		$this->_data = array_merge($this->_data, $data);
		
		$this->loadViews('admin/search_list');

	}
	
	
	protected function loadViews($template, $data = null){
		parent::loadAdminViews($template, $data);
	}
}
