<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Demo model
*
*	Version: 1.0
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Model for resetting site data.
*
*	Requires: Codeigniter 3
*/

class Demo_model extends MY_Model {

 	private $_sqlFiles = array();
 	private $_status = array();

	public function __construct(){
		parent::__construct();
	}

	/**
	*	Resets database to the original config
	*/
	public function reset(){
		$this->loadSql();
		$this->setResetTime();

		$this->executeSql();
	}

	/**
	*	Returns the timestamp of the last reset
	*
	*	@returns int Unix timestamp
	*/
	public function getLastResetTime(){
		$this->db->select('tstamp');
		$query = $this->db->get('demo_reset_time');

		$result = $query->row();

		return $result->tstamp;
	}

	/**
	*	Sets the time of the reset
	*/
	private function setResetTime(){
		$time = time();
		//$this->_sqlFiles[] = "UPDATE demo_reset_time SET tstamp='$time' WHERE id=1";
		$this->_sqlFiles[] = "DELETE FROM demo_reset_time; INSERT INTO demo_reset_time (tstamp) VALUES ('$time');";
	}

	/**
	*	Loads the content of sql files into array
	*/
	private function loadSql(){
		$sqlLocation = './application/sql/demo/data/';
		$files = scandir($sqlLocation);

		//remove other files
		for($i=0;$i<count($files);$i++){
			if(!preg_match('/sql/',$files[$i])){
				unset($files[$i]);
			}
		}

		foreach ($files as $file){
			$this->_sqlFiles[] = file_get_contents($sqlLocation.$file);
		}
	}

	/**
	*	Executes the content of sql files
	*/
	private function executeSql(){

		$sql = implode("\n", $this->_sqlFiles);

		$this->_status[] = @mysqli_multi_query($this->db->conn_id, $sql);
	}

}