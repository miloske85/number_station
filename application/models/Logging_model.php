<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Logging model
*
*	Version: 1.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Used for simple debugging.
*
*	Requires: Codeigniter 3
*/

 class Logging_model extends MY_Model {

	public function __construct(){
		parent::__construct();
		// $this->load->library('ion_auth');
	}

	/**
	 * Logs the given string to database along with timestamp
	 * 
	 * @param string $string String to be logged
	 * 
	 * @returns void
	 */
	public function log($string){
		$data['value'] = $string;
		$data['tstamp'] = time();
		
		$this->db->insert('debug_logging', $data);
	}

}
