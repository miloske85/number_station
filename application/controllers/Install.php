<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Install
*
*	Version: 1.0
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Installs database. This is a 'standalone' controller, it doesn't extend MY_Controller because that controller depends
*	on the database and it doesn't load any models, it performs SQL queries by itself.
*
*	Requires: Codeigniter 3
*/

class Install extends CI_Controller {

	private $_sqlFiles = array();
	private $_status = array();

	private $_data = array(); //data array for views

	public function __construct(){
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->config->load('install', TRUE);
		$this->config->load('number_station', TRUE);

		$this->setViewData();
	}

	/**
	*	Displays installation page
	*/
	public function index(){
		$this->loadViews('install');
	}

	/**
	*	Performs installation
	*/
	public function install(){
		$this->loadSql();
		$this->executeSql();

		$this->_data['status_report'] = 'Installation successful.';
		foreach ($this->_status as $status){
			if($status != TRUE){
				$this->_data['status_report'] = 'Installation Error, not all tables have been installed, please check the issue manually.';
			}
		}

		$this->loadViews('status_report');
	}

	/**
	*	Loads SQL data from application/config/install
	*/
	private function loadSql(){
		$config_data = $this->config->item('install');

		foreach($config_data['sql_files'] as $sqlFile){
			$tmp = file_get_contents($config_data['sql_location'].$sqlFile.'.sql');
			$this->_sqlFiles[] = $tmp;	//has to be split
		}
	}

	/**
	*	Executes SQL
	*/
	private function executeSql(){

		foreach ($this->_sqlFiles as $sql){
			$this->_status[] = mysqli_multi_query($this->db->conn_id, $sql);
		}
	}

	/**
	*	Sets data to be passed to views
	*/
	private function setViewData(){
		$this->_data = $this->config->item('number_station');

		$this->_data['pageTitle'] = 'Set up database';
		$this->_data['data']['logged_in'] = FALSE;
		$this->_data['data']['is_admin'] = FALSE;		
	}

	private function loadViews($template){
		$this->load->view('common/header', $this->_data);
		$this->load->view('common/navbar', $this->_data);
		$this->load->view('common/site_head');
		$this->load->view($template, $this->_data);
		$this->load->view('common/footer', $this->_data);		
	}

}
