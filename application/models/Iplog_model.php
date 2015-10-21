<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Iplog Model
*
*	Version: 1.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Handles logging and display of IP addresses and other access parameters.
*
*	Requires: Codeigniter 3
*/

class Iplog_model extends MY_Model {


	public function __construct(){
		parent::__construct();
	}
	
	//==================================================================
	//	Getters
	//==================================================================
	
	/**
	 * Returns data for all visits, paginated
	 * 
	 * @returns Array
	 */
	public function getHits($order = 'date', $ordering = 'DESC', $start, $limit){
		$sql = "SELECT iplog_log.date, iplog_log.ip, iplog_log.referer, iplog_pages.uri, iplog_ua.ua, users.username FROM iplog_log LEFT JOIN iplog_pages ON iplog_log.page_id=iplog_pages.id LEFT JOIN iplog_ua ON iplog_log.ua=iplog_ua.id LEFT JOIN users ON iplog_log.user_id=users.id ORDER BY $order $ordering LIMIT $start, $limit";
		
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	/**
	 * Returns page id
	 * 
	 * @param string $uri Page URI
	 * 
	 * @returns Object
	 */
	public function getPageId($uri){
		$this->db->where('uri', $uri);
		$query = $this->db->get('iplog_pages');
		
		$res = $query->row();
		
		if($res){
			return $res->id;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Returns User Agent ID
	 * 
	 * @param string $ua User Agent string
	 * 
	 * @returns Object
	 */
	public function getUaId($ua){
		$this->db->where('ua', $ua);
		$query = $this->db->get('iplog_ua');
		
		$res = $query->row();
		
		if($res){
			return $res->id;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Counts the number of page hits recorded in database
	 * 
	 * @returns int
	 */
	public function countHits(){
		$sql = "SELECT COUNT(id) FROM iplog_log";
		$query = $this->db->query($sql);
		
		$result = $query->result_array();
		
		return $result[0]['COUNT(id)'];
	}
	
	/**
	 * Counts the number of page hits in several specific time periods
	 * 
	 * @returns Array of integers
	 */
	public function countHitsByTime(){
		$now = time();
		$day = $now - 86400;
		$week = $now - 604800;
		$month = $now - 2592000;
		
		$sql = "SELECT COUNT(id) FROM iplog_log WHERE date>'$day'";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		$result['day'] = $res[0]['COUNT(id)'];
		
		$sql = "SELECT COUNT(id) FROM iplog_log WHERE date>'$week'";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		$result['week'] = $res[0]['COUNT(id)'];
		
		$sql = "SELECT COUNT(id) FROM iplog_log WHERE date>'$month'";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		$result['month'] = $res[0]['COUNT(id)'];
		
		return $result;
	}
	
	//==================================================================
	//	Search methods
	//==================================================================
	
	/**
	 * Searches IPLOG tables
	 * 
	 * @param string $type Type of search: ip|username|referer|uri
	 * @param string $search Search string
	 * @param int $start SQL start
	 * @param int $limit SQL limit
	 * 
	 * @returns Array
	 */
	public function searchIplog($type, $search, $start, $limit){
		if($type == 'ip'){
			$sql = $this->queryBuilder('ip', $search);
		}
		else if($type == 'username'){
			$sql = $this->queryBuilder('username', $search);
		}
		else if($type == 'referer'){
			$sql = $this->queryBuilder('referer', $search);
		}
		else if($type == 'uri'){
			$sql = $this->queryBuilder('uri', $search);
		}

		$sql .= " LIMIT $start, $limit";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/**
	 * Counts search results
	 * 
	 * @param string $type Type of search: ip|username|referer|uri
	 * @param string $search Search string
	 * 
	 * @returns int
	 */
	public function countSearch($type, $search){
		$query = $this->db->query($this->queryBuilder($type, $search));

		$result = $query->result_array();
		return count($result);
	}
	
	//==================================================================
	//	Insert functions
	//
	//	$data param is an array
	//==================================================================
	
	/**
	 * Inserts main log data
	 * @param array $data Array of data
	 * 
	 * @returns bools $status
	 */
	public function insertLog($data){
		if($data['ip'] == null){
			$data['ip'] = 'n/a';
		}
		$status = $this->db->insert('iplog_log', $data);
		
		return $status;
	}
	
	/**
	 * Inserts new page into pages table
	 * 
	 * @returns $status
	 */
	public function insertPage($data){
		if($data['uri'] == null){
			$data['uri'] = 'n/a';
		}
		
		$status = $this->db->insert('iplog_pages', $data);
		
		return $status;
	}
	
	/**
	 * Inserts new User Agent
	 * 
	 * @returns $status
	 */
	public function insertUa($data){
		if($data['ua'] == null){
			$data['ua'] = 'n/a';
		}		
		
		$status = $this->db->insert('iplog_ua', $data);
		
		return $status;
	}
	
	//==================================================================
	//	Private methods
	//==================================================================
	
	/**
	 * Builds queries for searching database
	 */
	private function queryBuilder($type, $search){
		if($type == 'ip'){
			$sql = "SELECT iplog_log.date, iplog_log.ip, iplog_log.referer, iplog_pages.uri, iplog_ua.ua, users.username FROM iplog_log LEFT JOIN iplog_pages ON iplog_log.page_id=iplog_pages.id LEFT JOIN iplog_ua ON iplog_log.ua=iplog_ua.id LEFT JOIN users ON iplog_log.user_id=users.id WHERE ip='$search' ORDER BY date ASC";
		}
		else if($type == 'username'){
			$sql = "SELECT iplog_log.date, iplog_log.ip, iplog_log.referer, iplog_pages.uri, iplog_ua.ua, users.username FROM iplog_log LEFT JOIN iplog_pages ON iplog_log.page_id=iplog_pages.id LEFT JOIN iplog_ua ON iplog_log.ua=iplog_ua.id LEFT JOIN users ON iplog_log.user_id=users.id WHERE users.username='$search' ORDER BY date ASC";
		}
		else if($type == 'referer'){
			$sql = "SELECT iplog_log.date, iplog_log.ip, iplog_log.referer, iplog_pages.uri, iplog_ua.ua, users.username FROM iplog_log LEFT JOIN iplog_pages ON iplog_log.page_id=iplog_pages.id LEFT JOIN iplog_ua ON iplog_log.ua=iplog_ua.id LEFT JOIN users ON iplog_log.user_id=users.id WHERE referer='$search' ORDER BY date ASC";
		}
		else if($type == 'uri'){
			$sql = "SELECT iplog_log.date, iplog_log.ip, iplog_log.referer, iplog_pages.uri, iplog_ua.ua, users.username FROM iplog_log LEFT JOIN iplog_pages ON iplog_log.page_id=iplog_pages.id LEFT JOIN iplog_ua ON iplog_log.ua=iplog_ua.id LEFT JOIN users ON iplog_log.user_id=users.id WHERE iplog_pages.uri='$search' ORDER BY date ASC";
		}
		return $sql;
	}
	
}
