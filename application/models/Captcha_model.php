<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Captcha model
*
*	Version: 1.0
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Handles Captcha data.
*
*	Requires: Codeigniter 3
*/

 class Captcha_model extends CI_Model {


	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * Inserts captcha code and IP address into database
	 * 
	 * @param array $data CAPTCHA data
	 * 
	 * @returns void
	 */
	public function insertCaptcha($data){
		if($data['ip_address'] != '0.0.0.0' AND $data['word'] != null){
			$query = $this->db->insert_string('captcha', $data);
			$this->db->query($query);
		}
	}

	/**
	*	Checks if correct captcha is typed
	* 
	* 	@param string $word User entered Captcha code
	* 	@param string $ip IP Address
	*
	*	@returns bool true If captcha is correct
	*/
	public function checkCaptcha($word, $ip){
		//clear db of expired entries
		$expired = time() - 7200;
		$this->db->where('captcha_time < ', $expired)->delete('captcha');

		$sql = "SELECT count(`captcha_id`) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($word, $ip, $expired);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();

		if($row->count > 0){
			return TRUE;
		}
	}


}
