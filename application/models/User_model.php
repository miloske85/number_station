<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: User model
*
*	Version: 1.2
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Handles (regular) user data.
*
*	Requires: Codeigniter 3
*/

 class User_model extends MY_Model {

	public function __construct(){
		parent::__construct();
		$this->load->library('ion_auth');
	}
	
	/**
	 * Returns username from given email
	 * 
	 * @returns string Username or FALSE if email doesn't exist in database
	*/
	public function getUsername($email){
		$this->db->where('email', $email);
		$this->db->select('username');
		$query = $this->db->get('users');

		$result = $query->row();
		
		if($result){
			return $result->username;
		}
		else{
			return FALSE;
		}

		
	}
	
	/**
	 * Gets User ID from given username
	 * 
	 * @returns int User ID or FALSE if username doesn't exists in database
	 */
	public function getIdFromUname($username){
		$this->db->where('username', $username);
		$this->db->select('id');
		$query = $this->db->get('users');
		
		$result = $query->row();
		
		if($result){
			return $result->id;	//PHP notice when null
		}
		else{
			return FALSE;
		}
	}
	
	/**
	*	Checks if user has entered correct (existing) password
	* 
	*	@param string $password Existing password
	* 	@param int $id User ID, if not specified, current user ID will be used
	*
	*	@returns boolean True of password matches
	*/
	public function checkExistingPassword($password, $id=null){
		if(!isset($id)){
			$id = (int) $this->ion_auth->user()->row()->id;	//has to be typecast
		}

		if($this->ion_auth->hash_password_db($id, $password)){
			return TRUE;
		}		
	}

	/**
	 * Returns the avatar URL
	 */
	public function getAvatar($id){
		$this->db->where('id', $id);
		$this->db->select('avatar');
		$query = $this->db->get('users');
		
		if(!$query){
			return FALSE;
		}

		return $query->row();
	}

	/**
	*	List all registered users who are active (not banned)
	*/
	public function listUsers($start, $limit){
		$this->db->select(array('id','username'));
		$this->db->where('active', 1);
		$this->db->order_by('username');
		$this->db->limit($limit, $start);

		$query = $this->db->get('users');

		return $query->result_array();
	}

	/**
	 * Returns username and avatar if given user is not banned
	 * 
	 * @param int $id User ID
	 * 
	 * @returns array One dimensional array
	 */
	public function getUser($id){
		$this->db->select(array('username', 'avatar'));
		$this->db->where(array('active' => 1, 'id' => $id));

		$query = $this->db->get('users');

		$result =  $query->result_array();

		return $result[0];
	}

	/**
	*	Counts all registered users who are active (not banned)
	* 
	*	@returns int
	*/
	public function countUsers(){
		$sql = "SELECT COUNT(id) FROM users WHERE active=1";
		$query = $this->db->query($sql);

		$res = $query->result_array();

		return $res[0]['COUNT(id)'];
	}

	//==================================================================
	// Update methods
	//==================================================================
	
	/**
	 * Changes User password
	 * 
	 * @param string $password New password
	 * @param int $id (optional) User ID
	 * 
	 * @returns bool TRUE if password changed successfully
	 */
	public function changePassword($password, $id=null){
		if(!isset($id)){
			$id = $this->ion_auth->user()->row()->id;
		}

		$status = $this->ion_auth->update($id, array('password' => $password));

		if($status){
			return TRUE;
		}
	}

	/**
	 * Changes avatar
	 * 
	 * @param int $id User ID, ID of the logged in user
	 * @param array $data
	 * 
	 * returns bool $status
	 */
	public function updateAvatar($id, $data){
		$this->db->where('id', $id);
		$status = $this->db->update('users', $data);

		return $status;
	}

	/**
	*	Removes the avatar
	*
	*	@param int $id User ID of the logged in user
	* 
	*	@returns bool $status
	*/
	public function deleteAvatar($id){
		$sql = "UPDATE users SET avatar=null WHERE id=$id LIMIT 1";
		$status = $this->db->query($sql);

		if($status){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	//==================================================================
	//	Form Validation
	//
	//	All methods return bool TRUE on success
	//==================================================================
	
	/**
	*	Validates registration form data
	*
	*	@returns bool true if data is valid
	*/
	public function validateReg($params){
		$config = array(
				array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'required|min_length[2]|max_length[50]'					
					),
				array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'required|valid_email|max_length[255]'
					),
				array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'required|min_length[6]|max_length[255]'
					),
				array(
						'field' => 'password2',
						'label' => 'Confirm password',
						'rules' => 'required|matches[password]|max_length[255]'
						),
				);
		$this->form_validation->set_error_delimiters($params['error_delim_open'],$params['error_delim_close']);
		$this->form_validation->set_rules($config);

		if($this->form_validation->run() == TRUE){

			return TRUE;
		}
	}

	/**
	 * Validates login form data
	 */
	public function validateLogin($params){
		$config = array(
				array(
					'field' => 'username',
					'label' => 'Username',
					'rules' => 'required|min_length[2]|max_length[50]'
					),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required|max_length[255]'
					)
				);
		$this->form_validation->set_error_delimiters($params['error_delim_open'],$params['error_delim_close']);
		$this->form_validation->set_rules($config);

		if($this->form_validation->run() == TRUE){
			return TRUE;
		}
	}

	/**
	*	Validates form data for changing password
	*/
	public function validateChPass($params){
		$config = array(
			array(
				'field' => 'oldpass',
				'label' => 'Old Password',
				'rules' => 'required|max_length[255]'
				),
			array(
				'field' => 'newpass1',
				'label' => 'New Password',
				'rules' => 'required|min_length[6]|max_length[255]',
				),
			array(
				'field' => 'newpass2',
				'label' => 'Confirm New Password',
				'rules' => 'required|matches[newpass1]|max_length[255]'
				)
			);
		$this->form_validation->set_error_delimiters($params['error_delim_open'],$params['error_delim_close']);
		$this->form_validation->set_rules($config);

		if($this->form_validation->run() == TRUE){
			return TRUE;
		}
	}

	/**
	 * Validates for for resetting password
	 */
	public function validateResetPass($params){
		$config = array(
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|valid_email|max_length[255]'
				),
			array(
				'field' => 'captcha',
				'label' => 'CAPTCHA',
				'rules' => 'required|max_length[255]'
				)
			);
		$this->form_validation->set_error_delimiters($params['error_delim_open'],$params['error_delim_close']);
		$this->form_validation->set_rules($config);

		if($this->form_validation->run() == TRUE){
			return TRUE;
		}
	}




}
