<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Private messages model
*
*	Version: 1.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Handles private messages.
*
*	Requires: Codeigniter 3
*/

 class Private_messages_model extends MY_Model {


	public function __construct(){
		parent::__construct();
	}
	
	//==================================================================
	//	Private messaging
	//==================================================================

	/**
	 * Sends private message. Sender is set to the user_id of the logged in user in the controller
	 * 
	 * @returns $status
	 */
	public function sendPM($data){
		$data['date_sent'] = time();
		$status = $this->db->insert('private_messages', $data);

		return $status;
	}
	
	/**
	 * Marks private message as read
	 * 
	 * @returns $status
	 */
	public function markPMasRead($user_id, $id){
		$data = array('is_read' => 1);
		
		$this->db->where(array('id' => $id, 'recepient' => $user_id));
		
		$status = $this->db->update('private_messages', $data);
		
		return $status;
	}

	/**
	 * Gets all private messages for given user_id
	 * 
	 * Output is paginated
	 */
	public function getPrivateMessages($start, $limit, $user_id){
		$sql = "SELECT id, sender, subject, date_sent, is_read FROM private_messages WHERE recepient='$user_id' ORDER BY is_read, date_sent DESC LIMIT $start, $limit";
		$query = $this->db->query($sql);

		$result = $query->result_array();
		
		//inject usernames
		$ret = array();
		
		foreach($result as $row){
			$id = $row['sender'];
			$this->db->where('id', $id);
			$this->db->select('username');
			$query = $this->db->get('users');
			
			$row['username'] = $query->row()->username;
			
			$ret[] = $row;
		}
		
		return $ret;
	}
	
	/**
	 * Returns single private message
	 * 
	 * @param int $user_id Id of the current user
	 * @param int $id Id of the message
	 * 
	 * @returns Object
	 */
	public function getPrivateMessage($user_id, $id){
		$this->db->where(array('id' => $id, 'recepient' => $user_id));
		$query = $this->db->get('private_messages');
		
		$result = $query->row();
		
		$result->username = $this->getUsernameFromId($result->sender);
		
		return $result;
	}
	
	/**
	 * Counts private messages
	 * 
	 * @param int $user_id
	 * @param bool $unread (optional) If not set to true only unread messages are counted
	 * 
	 * @returns int
	 */
	public function countPrivateMessages($user_id, $unread = FALSE){
		if($unread == TRUE){
			$sql = "SELECT COUNT(id) FROM private_messages WHERE recepient='$user_id'"; //count all private messages for user
		}
		else{
			$sql = "SELECT COUNT(id) FROM private_messages WHERE recepient='$user_id' AND is_read='0'";  //count unread PMs
		}
		$query = $this->db->query($sql);
		
		$result = $query->result_array();
		
		return $result[0]['COUNT(id)'];
	}

	/**
	 * Returns subject
	 * 
	 * @param int $id Private message ID
	 * 
	 * @returns Object
	 */
	public function getSubject($user_id, $id){
		$this->db->where(array('recepient' => $user_id, 'id' => $id));
		$this->db->select('subject');

		$query = $this->db->get('private_messages');

		$res = $query->row();

		return $res->subject;
	}
	
	/**
	 * Deletes Message. Security handled by the controller.
	 * 
	 * @param $id Private message ID
	 * 
	 * @returns bool
	 */
	public function delete($id){
		$this->db->where('id', $id);
		
		$status = $this->db->delete('private_messages');
		
		if($status){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Used to get message id in testing
	 */
	public function selectMessage($search){
		$this->db->where('message', $search);
		$this->db->select('id');
		$query = $this->db->get('private_messages');
		$res = $query->row();
		
		return $res->id;
	}
	
	/**
	 * Returns private message ID from given subject
	 * 
	 * @param string $subject Private Message subject
	 * 
	 * @returns int
	 */
	public function getMessageId($subject){
		$this->db->where('subject', $subject);
		$this->db->select('id');
		
		$query = $this->db->get('private_messages');
		
		return $query->row()->id;
	}
	
	//==================================================================
	//	Form Validation
	//
	//	All methods return bool TRUE on success
	//==================================================================
	
	/**
	 * Validates PM sending form
	 */
	public function validatePM($params){
		$config = array(
			array(
				'field' => 'recepient',
				'label' => 'Recepient',
				'rules' => 'required|max_length[255]'
			),
			array(
				'field' => 'subject',
				'label' => 'Subject',
				'rules' => 'required|max_length[255]|min_length[2]'
			),
			array(
				'field' => 'message',
				'label' => 'Message',
				'rules' => 'required|min_length[1]|max_length[10000]'
			)
		);
		$this->form_validation->set_error_delimiters($params['error_delim_open'],$params['error_delim_close']);
		$this->form_validation->set_rules($config);
		
		if($this->form_validation->run() === TRUE){
			return TRUE;
		}
	}
	
	//==================================================================
	//	Private methods
	//==================================================================
	
	
	/**
	 * Returns username from given user_id
	 */
	private function getUsernameFromId($id){
		$this->db->where('id', $id);
		$this->db->select('username');
		$query = $this->db->get('users');
		
		$res = $query->row();
		
		return $res->username;
	}
	
	
}
