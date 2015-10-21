<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Users model
*
*	Version: 1.0
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Used by admin CP for managing users.
*
*	Requires: Codeigniter 3
*/
 class Users_model extends MY_Model {

	public function __construct(){
		parent::__construct();
		$this->load->library('ion_auth');
	}

	public function listUsers($limit, $start){
		$this->db->select(array('id','username','email','active'));
		$this->db->order_by('username');
		$this->db->limit($limit, $start); //order is flipped compared to mysql query

		$query = $this->db->get('users');

		return $query->result_array();
	}

	public function getUser($id){
		$this->db->where('id', $id);
		$query = $this->db->get('users');

		return $query->row();
	}

	/**
	*	Counts all the users
	*/
	public function countUsers(){
		$sql = "SELECT COUNT(id) FROM users";
		$query = $this->db->query($sql);

		$result = $query->result_array();

		return $result[0]['COUNT(id)'];
	}

	public function searchByUsername($username){
		return $this->searchUser($username, 'username');
	}

	public function searchByEmail($email){
		return $this->searchUser($email, 'email');
	}

	public function updateUser($id, $data){
		$this->db->where('id', $id);
		$status = $this->db->update('users', $data);

		return $status;
	}

	/**
	 * Deletes a user, unless id == 1
	 * 
	 * @param int $id UserId
	 * 
	 * @returns bool
	 */
	public function deleteUser($id){
		if($id != 1){
			$status = $this->db->delete('users', array('id'=> $id));

			if($status){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}

	private function searchUser($search, $type){
		if($type == 'username'){
			$this->db->like('username', $search);
		}
		elseif($type == 'email'){
			$this->db->like('email', $search);
		}
		else{
			return false;
		}

		$this->db->order_by('username');
		$query = $this->db->get('users');

		return $query->result_array();		
	}


}
