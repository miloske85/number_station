<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Messages Model
*
*	Version: 1.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: CRUD operations for public messages and form validation.
*
*	Requires: Codeigniter 3
*/

 class Messages_model extends MY_Model {


	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->config->load('number_station', TRUE);
	}

	//==================================================================
	//	Public messages handling
	//==================================================================

	/**
	 * Inserts message into database
	 * 
	 * @param array $data
	 * 
	 * @returns $status
	 */
	public function insertMessage($data){
		$data['date_mess'] = time();	//get the current timestamp
		$status = $this->db->insert('messages', $data);

		return $status;
	}

	/**
	*	Lists all the (public) messages
	*
	*	@param int $start SQL start
	* 	@param int $limit SQL limit
	* 	@param bool $admin When false (default), inactive messages will not be returned, when set to true, all messages are returned
	* 
	* 	@returns array
	*/
	public function getMessages($start, $limit, $admin = FALSE){
		if(!$admin){
			//regular user is viewing site, don't return disabled messages
			$sql = "SELECT messages.*, users.username FROM messages LEFT JOIN users ON messages.user_id=users.id WHERE messages.active='1' ORDER BY date_mess DESC LIMIT $start, $limit";
		}
		else{
			$sql = "SELECT messages.*, users.username FROM messages LEFT JOIN users ON messages.user_id=users.id ORDER BY date_mess DESC LIMIT $start, $limit";
		}
		
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}

	/**
	*	Returns a single message along with username/guest name of the poster
	* 
	* 	@param int $id Message ID
	* 	@param bool $admin (optional) If set to true inactive message will be shown
	* 
	* 	@returns message object
	*/
	public function getMessage($id, $admin = FALSE){
		$message = $this->getMessageRaw($id, $admin);

		//get username from other table
		if($message){
			if($message->user_id != 0){
				$this->db->where('id', $message->user_id);
				$this->db->select('username');
				$query = $this->db->get('users');

				$result = $query->row();

				$message->username = $result->username;
			}
			else{
				$message->username = $message->name;
			}
			
			return $message;
		}
		else{
			return FALSE;
		}		
	}

	/**
	 *	Searches messages and does pagination
	 *
	 *	@param string $search Search string
	 *	@param int $start SQL start
	 *	@param int $limit SQL limit
	 *	@param bool $admin When not set to true, only active messages are returned
	 */
	public function searchMessages($search, $start, $limit, $admin = FALSE){
		$this->db->like('message', $search);
		if(!$admin){
			$this->db->where('active', 1);
		}
		$this->db->order_by('date_mess', 'DESC');
		$this->db->limit($limit, $start);

		$query = $this->db->get('messages');

		$result = $query->result_array();
		if(!$result){
			return null;
		}

		$result = $this->clipMessage($result);

		$result = $this->injectName($result);

		return $result;
	}
	
	/**
	 * Updates message
	 * 
	 * @param int $id Message ID
	 * @param array $data Message data array
	 *
	 * @returns $status
	 */
	public function updateMessage($id, $data){
		$this->db->where('id', $id);
		$status = $this->db->update('messages', $data);

		return $status;
	}

	/**
	 * Deletes Message
	 * 
	 * @param int $id Message ID
	 * 
	 * @returns bool;
	 */
	public function deleteMessage($id){
		$status = $this->db->delete('messages', array('id' => $id));
		
		if($status){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/**
	*	Counts all the active messages
	* 
	* 	@param bool $admin When not set to true only active (not deleted) messages will be counted
	* 
	* 	@returns int
	*/
	public function countMessages($admin = FALSE){
		if($admin == TRUE){
			$sql = "SELECT COUNT(id) FROM messages";
		}
		else{
			$sql = "SELECT COUNT(id) FROM messages WHERE active='1'";
		}
		$query = $this->db->query($sql);

		$result = $query->result_array();

		return $result[0]['COUNT(id)'];
	}

	/**
	*	Count messages matching the search string
	* 
	* 	@param string $search Search String
	* 	@param bool $admin (optional) When not set to true only active messages will be counted
	* 
	* 	@returns int
	*/
	public function countMessageSearch($search, $admin = FALSE){
		$this->db->like('message', $search);
		if(!$admin){
			$this->db->where('active', 1);
		}
		$this->db->select('COUNT(id)');

		$query = $this->db->get('messages');

		$result = $query->result_array();

		return $result[0]['COUNT(id)'];
	}
	

	
	//==================================================================
	//	Form Validation
	//
	//	All methods return bool TRUE on success
	//==================================================================

	/**
	 * Validates message form data
	 */
	public function validateMessage($params){
		$config = array(
				array(
					'field' => 'message',
					'label' => 'Message',
					'rules' => 'required|min_length[2]|max_length[8192]'
					)
				);

		if(!$this->ion_auth->logged_in()){
			$config[] = array(
					'field' => 'name',
					'label' => 'Name',
					'rules' => 'required|min_length[2]|max_length[100]'				
				);
		}
		$this->form_validation->set_error_delimiters($params['error_delim_open'],$params['error_delim_close']);
		$this->form_validation->set_rules($config);

		if($this->form_validation->run() == true){
			return true;
		}
	}
	
	//==================================================================
	//	Private methods
	//==================================================================

	/**
	*	Injects username in messages return result and also runs nl2br on message field
	*/
	private function injectName($data){
		foreach ($data as $row){
			if($row['user_id'] != 0){
				$this->db->where('id', $row['user_id']);
				$this->db->from('users');
				$query = $this->db->get();

				$res = $query->row();
				
				$row['name'] = $res->username;

			}

			$row['message'] = nl2br($row['message']);

			$result[] = $row;			
		}

		return $result;
	}

	/**
	*	Clips messages longer than 100 characters
	*/
	private function clipMessage($data){
		foreach ($data as $row){
			if(strlen($row['message']) > 100){
				$row['message'] = substr($row['message'], 0, 100);
				$row['message'] .= ' ...';
			}
			$result[] = $row;
		}
		return $result;
	}


	/**
	*	Gets a single message, raw entry from table
	*
	*	@param int $id Message ID
	*	@param bool $admin When true only active (non deleted) messages are returned
	*/
	private function getMessageRaw($id, $admin){
		$this->db->where('id', $id);
		if($admin == FALSE){
			$this->db->where('active', 1);
		}
		$query = $this->db->get('messages');

		return $query->row();
	}
	



}
