<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: MY Controller
*
*	Version: 1.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Sets some basic data, logs IP addresses and other access parameters, loads views.
*
*	Requires: Codeigniter 3
*/

class MY_Controller extends CI_Controller {

	protected $_pagination_config = array();
	
	/**
	 * Data being passed to views
	 */
	protected $_data = array();
	
	private $_user_id;

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('ion_auth');
		
		$this->load->model(array('Private_messages_model', 'Iplog_model'));
		
		$this->config->load('number_station', TRUE);
		
		$this->setViewData();

		$demo_status = $this->checkDemo(); //can be disabled in production environment

		$this->setPaginationData();

		@$this->iplog();	//iplog function should fail silently
		$this->getUserId();	
	}	

	/**
	*	Creates CAPTCHA IMAGE
	*
	*	@returns Captcha object
	*/
	protected function createCatcha(){
		$values = $this->_data['captcha_params'];

		return create_captcha($values);
	}

	/**
	 * Loads a set of views
	 */
	protected function loadViews($template, $data = null){
		if(!is_array($data)){
			$data = $this->_data;
		}
		$this->load->view('common/header', $data);
		$this->load->view('common/navbar', $data);
		$this->load->view('common/site_head');
		$this->load->view($template, $data);
		$this->load->view('common/footer', $data);
	}

	/**
	 * Loads a set of views for admin control panel
	 */
	protected function loadAdminViews($template, $data = null){
		if(!is_array($data)){
			$data = $this->_data;
		}
		$this->load->view('common/header', $data);
		$this->load->view('common/navbar', $data);
		$this->load->view('admin/nav_top', $data);
		$this->load->view($template, $data);
		$this->load->view('common/footer', $data);		
	}
	
	/**
	 * Checks if a regular user is logged in.
	 * 
	 * * @param string $type 'return', 'access_denied', 'redirect', 'die'
	 */
	protected function checkLoggedIn($type = 'return'){
		$status = $this->_data['data']['logged_in'];
		return $this->processAuth($type, $status);
	}
	
	/**
	 * Checks if admin is logged in
	 *
	 * @param string $type 'return', 'access_denied', 'redirect', 'die'
	 */
	protected function checkAdmin($type = 'return'){
		$status = $this->_data['data']['is_admin'];
		return $this->processAuth($type, $status);
	}
	
	/**
	 * Processes authentication
	 * 
	 * @param string $type Type given to the check functions above
	 * @param boolean $status Status of the authentication
	 */
	private function processAuth($type, $status){
		if($type == 'return'){
			return $status;
		}

		if(!$status){
			if($type == 'access_denied'){
				$this->loadViews('access_denied');
			}
			
			if($type == 'redirect' && $status == FALSE){
				redirect('/');
				break;
			}
			
			if($type == 'die' && $status == FALSE){
				die;
			}
		}
	}
	
	/**
	 * Sets basic data to be passed to views, it reads the config file
	 * 
	 * In 'testing' ENV it mocks the admin user
	 */
	private function setViewData(){
		$this->_data = $this->config->item('number_station');

		$this->_data['data']['logged_in'] = $this->ion_auth->logged_in();
		if($this->_data['data']['logged_in']){
			$this->_data['data']['iauth_user_id'] = $this->ion_auth->user()->row()->id; //user id of logged in user
			$this->_data['unread_pm_count'] = $this->Private_messages_model->countPrivateMessages($this->_data['data']['iauth_user_id']);
			$this->_data['greet_user'] = $this->ion_auth->user()->row()->username;
		}
		$this->_data['data']['is_admin'] = $this->ion_auth->is_admin();
		
		if(ENVIRONMENT == 'testing'){
			$this->_data['data']['logged_in'] = TRUE;
			$this->_data['data']['iauth_user_id'] = 1;
			$this->_data['unread_pm_count'] = 1;
			$this->_data['greet_user'] = 'PHPUnit Administrator';
			$this->_data['data']['is_admin'] = TRUE;
		}
	}

	private function setPaginationData(){
		$this->_pagination_config = $this->_data['pagination_params'];		
	}
	
	/**
	 * Logs IP and other access parameters
	 */
	private function iplog(){
		//get raw data
		$data = array(
			'date' => time(),
			'ua' => $_SERVER['HTTP_USER_AGENT'],
			'ip' => $_SERVER['REMOTE_ADDR'],
			'referer' => $_SERVER['HTTP_REFERER'],
			'uri' => $_SERVER['REQUEST_URI'],
			'user_id' => $this->_user_id
		);
		
		//set defaults if values not specified (unit testing, etc)
		if($data['ip'] == null) $data['ip'] = 'n/a';
		if($data['uri'] == null) $data['uri'] = 'n/a';
		if($data['ua'] == null) $data['ua'] = 'n/a';
		
		//get page id
		$page_id = $this->Iplog_model->getPageId($data['uri']);
		if(!$page_id){
			//insert page and get id
			$this->Iplog_model->insertPage(array('uri' => $data['uri']));
			
			//insert method only returns bool, so query again
			$data['page_id'] = $this->Iplog_model->getPageId($data['uri']);
		}
		else{
			//page already in db
			$data['page_id'] = $page_id;
		}
		
		//get ua_id
		$ua_id = $this->Iplog_model->getUaId($data['ua']);
		
		if(!$ua_id){
			//insert ua and get id
			$this->Iplog_model->insertUa(array('ua' => $data['ua']));
			$data['ua'] = $this->Iplog_model->getUaId($data['ua']);
			
		}
		else{
			$data['ua'] = $ua_id;
		}
		
		//remove extraneous data
		unset($data['uri']);
		
		//insert
		$this->Iplog_model->insertLog($data);

	}
	
	/**
	*	Sets user id
	*/
	private function getUserId(){
		if($this->ion_auth->logged_in()){
			$this->_user_id = $this->ion_auth->user()->row()->id;
		}
		
		if($this->_user_id == NULL){
			$this->_user_id = 0;
		}
	}

	/**
	*	Checks if this installation is a demo (as set in main config file)
	*	
	*	If it is it resets everything every half hour
	*/
	private function checkDemo(){
		if($this->_data['data']['is_demo']){
			$this->load->model('Demo_model');

			$lastReset = $this->Demo_model->getLastResetTime();
			
			if((time() - $lastReset) > 1800){
				// redirect (base_url('demo_reset/reset_j49zm30nj29/'));
				file_get_contents(base_url('demo_reset/reset_j49zm30nj29/'));
			}
		}
	}
	

}
