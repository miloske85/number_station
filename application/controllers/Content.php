<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Content
*
*	Version: 1.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Serves pages (views) with static content.
*
*	Requires: Codeigniter 3
*/
class Content extends MY_Controller {


	public function __construct(){
		parent::__construct();
	}

	/**
	*	Displays Terms of Service page
	*/
	public function tos(){
		$this->_data['pageTitle'] = 'Terms of Service';
		$this->_data['nav_uri'] = 'tos';
		$this->loadViews('static/tos', $this->_data);
	}

	/**
	*	Displays About page
	*/
	public function about(){
		$this->_data['pageTitle'] = 'About';
		$this->_data['nav_uri'] = 'about';
		$this->loadViews('static/about', $this->_data);
	}

	/**
	*	Displays External links page
	*/
	public function external_links(){
		$this->_data['pageTitle'] = 'External Links';
		$this->_data['nav_uri'] = 'ext-links';
		$this->loadViews('static/ext_links', $this->_data);
	}

}