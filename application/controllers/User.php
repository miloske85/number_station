<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: User
*
*	Version: 1.2
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Controller for handling (regular) users, written for Numbers Relay Page project
*
*	Requires: Codeigniter 3
*/

class User extends MY_Controller {
	
	/**
	 * Ion Auth identity, set in config/ion_auth.php
	 */
	private $_identity;

	/**
	*	iauth user() object
	*/
	private $_user;

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form', 'captcha'));
		$this->load->library(array('form_validation', 'ion_auth', 'email', 'pagination'));

		$this->load->model(array('User_model', 'Captcha_model', 'Messages_model'));

		$this->config->load('number_station', TRUE);
		$this->config->load('ion_auth', TRUE);

		$this->setIdentity();

		$this->_data['nav_uri'] = 'user';
		$this->_data['pageTitle'] = 'User Control Panel';
	}

	/**
	 * Displays user control panel
	 */
	public function index(){
		if($this->checkLoggedIn()){

			//load user data
			$this->_data['username'] = $this->_user->username;
			$this->_data['email'] = $this->_user->email;			

			$this->loadViews('user/user');
		}
		else{
			redirect('/');
		}
	}

	/**
	*	Displays all registered users (not banned). Public method (available to guest users)
	*/
	public function list_users(){
		$this->_pagination_config['base_url'] = base_url('user/list_users');
		$this->_pagination_config['total_rows'] = $this->User_model->countUsers();
		$this->pagination->initialize($this->_pagination_config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$this->_data['user_list'] = $this->User_model->listUsers($page, $this->_pagination_config['per_page']);

		$this->_data['pag_links'] = $this->pagination->create_links();

		$this->_data['nav_uri'] = 'users';
		$this->loadViews('user_list');
	}

	/**
	*	Shows public profile of a user. Public method (available to guest users)
	*/
	public function show_user($id){
		$this->_data['user'] = $this->User_model->getUser($id);
		$this->_data['avatar'] = $this->User_model->getAvatar($id)->avatar;
		$this->loadViews('user_show');

	}

	/**
	*	Shows existing avatar, if any and allows upload of new one
	*/
	public function avatar(){
		$avatar = $this->User_model->getAvatar($this->_data['data']['iauth_user_id'])->avatar;

		$this->_data['avatar'] = $avatar;
		$this->loadViews('user/avatar');
	}

	/**
	*	Accepts new avatar upload
	*/
	public function avatar_post(){

		if($this->checkLoggedIn()){

			$file_name = uniqid().'.jpg'; //everything is renamed to jpg

			$config = array(
				'upload_path' => $this->_data['data']['upload_path'],
				'allowed_types' => 'gif|jpg|png',
				'max_size' => '50',
				'max_width' => '120',
				'max_height' => '120',
				'file_ext_tolower' => TRUE,
				'file_name' => $file_name
			);

			$file_name = base_url('uploads/').'/'.$file_name;

			$this->load->library('upload', $config);

			if($this->upload->do_upload()){
				$status = $this->User_model->updateAvatar($this->_data['data']['iauth_user_id'], array('avatar' => $file_name));
				if($status){
					$this->_data['status_report'] = 'File uploaded successfully.';
				}
				else{
					$this->_data['status_report'] = 'Upload error, please try again later';
				}

				$this->loadViews('status_report');
				//update database
			}
			else{
				//file not uploaded
				echo $this->upload->display_errors();
			}
		}
		else{
			//user not logged in
			$this->_data['status_report'] = 'You have to be logged in to upload avatar';
			$this->loadViews('status_report');
		}
	}

	/**
	 * Deletes avatar
	 */
	public function delete_avatar(){
		if($this->checkLoggedIn()){

			$this->User_model->deleteAvatar($this->_data['data']['iauth_user_id']);

			$this->_data['status_report'] = 'Avatar deleted successfully';
			$this->loadViews('status_report');
		}
		else{
			//user not logged in
			$this->_data['status_report'] = 'You have to be logged in to delete avatar';
			$this->loadViews('status_report');
		}
	}
	
	/**
	 * Displays change password form
	 */
	public function change_pass(){
		if($this->checkLoggedIn()){
			$this->loadViews('user/change_pass');
		}
		else{
			redirect('/');
		}
	}

	/**
	 * Collects data for changing password and changes password
	 */
	public function cp_post(){

		$data = array(
				'oldpass' => $this->input->post('oldpass'),
				'newpass1' => $this->input->post('newpass1'),
				'newpass2' => $this->input->post('newpass2')
			);

		if($this->User_model->validateChPass($this->_data['validation_params'])){
			if($this->User_model->checkExistingPassword($data['oldpass'])){
				if($this->User_model->changePassword($data['newpass1'])){
					$this->_data['status_report'] = 'Password changed successfully';
				}
				else{
					$this->_data['status_report'] = 'Password change failed';
				}
			}
			else{
				$this->_data['status_report'] = 'You entered incorrect (old) password';
			}

			$this->loadViews('status_report');
		}
		else{
			//form not validated
			$this->loadViews('user/change_pass');
		}
	}

	/**
	*	Displays password reset form
	*/
	public function forgot_password(){
		if($this->_data['data']['email_available']){
			$this->_data['ch_pass_form'] = base_url('user/forgot_pass_post');
			$this->_data['captcha'] = $this->createCatcha();
			$this->loadViews('user/forgot_password');
		}
		else{
			//email sending not available
			$this->_data['status_report'] = 'Password cannot be reset automatically';
			$this->_data['status_report_expl'] = 'Due to the limitations of the current hosting plan of this site, you password cannot be reset automatically. You will have to <a href="http://miloske.tk/#contact">contact me</a> and request a new password. Make sure to leave your email. Sorry for the inconvenience.';

			$this->loadViews('status_report');
		}
	}
	
	/**
	 * Collects data from form
	 */
	public function forgot_password_post(){
		$data = array(
			'email' => $this->input->post('email'),
			'captcha' => $this->input->post('captcha')
			);

		$ip = $this->input->ip_address();
		
		if($this->User_model->validateResetPass($this->_data['validation_params']) == TRUE){
			if($this->Captcha_model->checkCaptcha($data['captcha'], $ip) == TRUE){
				//reset pass
				// $this->User_model->resetPassword($data['email']);

				if($this->_identity == 'username'){
					//get username from email
					$resetParam = $this->User_model->getUsername($data['email']);
				}
				else{
					$resetParam = $data['email'];
				}
				$status = $this->ion_auth->forgotten_password($resetParam);

				$this->_data['status_report'] = 'Password reset successfully. You will receive password reset link in your email. If you don\'t receive an email soon, check your spam folder';
				$this->loadViews('status_report');
			}
			else{
				$this->_data['captcha'] = $this->createCatcha();
				$this->_data['error'] = 'CAPTCHA code did not match';
				$this->loadViews('user/forgot_password');
			}
		}
		else{
			$this->_data['captcha'] = $this->createCatcha();
			$this->loadViews('user/forgot_password');			
		}

	}
	
	/**
	 * Resets password
	 */
	public function reset_password($code){
		$newPass = $this->ion_auth->forgotten_password_complete($code);

		$this->_data['status_report'] = 'Your new password is'.$newPass;

		$this->loadViews('status_report');
	}

	protected function createCatcha(){
		$cap = parent::createCatcha();

		$data = array(
				'word' => $cap['word'],
				'ip_address' => $this->input->ip_address(),
				'captcha_time' => $cap['time']
			);

		$this->Captcha_model->insertCaptcha($data);

		return $cap;		
	}	

	/**
	 * Used to set ion_auth identity to what it is configured in ion_auth config file
	 * If this identity is set to email, email must be provided for resetting password
	 * and if it's username, then username must be provided
	 */
	private function setIdentity(){
		$config = $this->config->item('ion_auth');
		$this->_identity = $config['identity'];

		$this->_user = $this->ion_auth->user()->row();
	}

}
