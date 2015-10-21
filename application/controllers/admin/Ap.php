<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Ap
*
*	Version: 1.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Main admin control panel controller.
*
*	Requires: Codeigniter 3
*/
class Ap extends MY_Controller {


	public function __construct(){
		parent::__construct();
		
		$this->load->helper(array('url','form'));
		$this->load->library(array('form_validation', 'ion_auth', 'pagination'));
		$this->checkAdmin('die');
		$this->load->model(array('User_model', 'admin/Users_model', 'Messages_model', 'admin/Admindata_model', 'Iplog_model'));
		$this->config->load('number_station', TRUE);
		
		//$this->setViewData();
		$this->_data['pageTitle'] = 'Admin Control Panel';
		//navbar hack
		$this->_data['nav_uri'] = 'admin';
	}

	public function index(){
		$this->_data['num_users'] = $this->Users_model->countUsers();
		$this->_data['num_mess'] = $this->Messages_model->countMessages(TRUE);
		$this->_data['num_hits'] = $this->Iplog_model->countHits();
		
		$this->loadViews('admin/ap_home');
	}

	public function list_users(){
		$data = $this->_data;

		$this->_pagination_config['base_url'] = base_url('admin/ap/list_users/');
		$this->_pagination_config['total_rows'] = $this->Users_model->countUsers();
		$this->_pagination_config['per_page'] = 20;

		$this->pagination->initialize($this->_pagination_config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$data['user_list'] = $this->Users_model->listUsers($this->_pagination_config['per_page'], $page);

		$data['pag_links'] = $this->pagination->create_links();		

		$this->loadViews('admin/user_list', $data);
	}

	public function list_messages(){
		$data = $this->_data;

		$this->_pagination_config['base_url'] = base_url('admin/ap/list_messages/');
		$this->_pagination_config['total_rows'] = $this->Messages_model->countMessages(TRUE);
		$this->_pagination_config['per_page'] = 20;


		$this->pagination->initialize($this->_pagination_config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$data['message_list'] = $this->Messages_model->getMessages($page, $this->_pagination_config['per_page'], TRUE);

		$data['pag_links'] = $this->pagination->create_links();		

		$this->loadViews('admin/message_list', $data);

	}
	
	public function show_message($id){
		$data = $this->_data;

		$data['message'] = $this->Messages_model->getMessage($id, TRUE);

		$this->loadViews('admin/show_message', $data);

	}

	/**
	*	Show single user
	*/
	public function show_user($id){
		$data = $this->_data;

		$data['user'] = $this->Users_model->getUser($id);
		$data['user']->is_admin = $this->ion_auth->is_admin($id);

		$this->loadViews('admin/show_user', $data);
	}

	public function edit_message($id){
		$this->_data['message'] = $this->Messages_model->getMessage($id, TRUE);	//get message to display

		if($this->input->post('message') != null){
			$data = array(
				'message' => $this->input->post('message'),
				'active' => $this->input->post('active')
				);

			$status = $this->Messages_model->updateMessage($id, $data);

			if($status){
				$this->_data['status'] = 'Message updated Successfully';
			}
			else{
				$this->_data['status'] = 'Message not updated';
			}

			$this->loadViews('admin/status_display');
		}
		//message not posted
		else{
			$this->loadViews('admin/edit_message');
		}
	}

	public function edit_user($id){
		$this->_data['user'] = $this->Users_model->getUser($id);

		if($this->input->post('username') != null){
			$data = array(
					'username' => $this->input->post('username'),
					'email' => $this->input->post('email'),
					'active' => $this->input->post('active')
				);

			$status = $this->Users_model->updateUser($id, $data);

			if($status){
				$this->_data['status'] = 'User updated successfully';
			}
			else{
				$this->_data['status'] = 'User not updated';
			}

			$this->loadViews('admin/status_display');
		}
		else{
			$this->loadViews('admin/edit_user');
		}
	}

	/**
	*	Promote user to admin, or demote admin to user
	*/
	public function promote_user($id, $action){
		if($action == 1){
			$status = $this->ion_auth->add_to_group(1, $id);
		}
		elseif($action == 0){
			if($id != 1 and $id != $this->ion_auth->user()->row()->id){
				$status = $this->ion_auth->remove_from_group(1, $id);
			}
			else{
				echo 'I\'m afraid I can\'t let you do that Dave';
				die;
			}
		}
		else{
			echo 'Don\'t be naughty';
			die;
		}

		//display result
		if($status){
			$this->_data['status'] = 'Operation completed successfully';
		}
		else{
			$this->_data['status'] = 'Operation failed';
		}
		$this->loadViews('admin/status_display');
	}

	/**
	*	Delete message or user
	*/
	public function delete($type, $id, $confirm = null){

		if($type == 'user'){
		$temp = array(
			'item_type' => 'user',
			'delete_link' => $this->_data['urls']['admin_delete_user'],
			'cancel_link' => $this->_data['urls']['admin_show_user']
			);
		}
		elseif($type == 'message'){
		$temp = array(
			'item_type' => 'message',
			'delete_link' => $this->_data['urls']['admin_delete_message'],
			'cancel_link' => $this->_data['urls']['admin_show_message']
			);
		}
		else{
			echo 'Invalid data type, click links, don\'t type URLs';;
			die;
		}

		$this->_data = array_merge($this->_data, $temp);

		if(!isset($confirm)){
			$this->_data['id'] = $id;

			$this->loadViews('admin/delete_conf');
		}
		elseif($confirm == 'c'){
			if($type == 'user'){
				$status = $this->Users_model->deleteUser($id);
			}
			elseif($type == 'message'){
				$status = $this->Messages_model->deleteMessage($id);
			}

			//status message
			if($status){
				$this->_data['status'] = ucfirst($type).' deleted Successfully';
			}
			else{
				$this->_data['status'] = ucfirst($type).' not deleted';
			}

			$this->loadViews('admin/status_display');
		}
	}

	protected function loadViews($template, $data = null){
		parent::loadAdminViews($template, $data);
	}

	//protected function setViewData(){
		////$this->_data = $this->config->item('number_station');
		//parent::setViewData();
		//$this->_data['pageTitle'] = 'Admin Control Panel';
		
		////$temp = $this->Admindata_model->getData();
		////$this->_data = array_merge($this->_data, $temp);
	//}

	//private function checkAdmin(){
		//if(!$this->ion_auth->is_admin()){
			//echo 'Access Denied';
			//die;
		//}		
	//}

}
