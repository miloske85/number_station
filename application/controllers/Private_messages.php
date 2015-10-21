<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Private messages
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
class Private_messages extends MY_Controller {
	
	private $_user_id;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form', 'security'));
		$this->load->library(array('form_validation', 'ion_auth', 'email', 'pagination'));

		$this->load->model(array('User_model', 'Messages_model', 'Private_messages_model'));

		$this->config->load('number_station', TRUE);

		$this->checkLoggedIn('access_denied');
		
		//setting properties
		if($this->_data['data']['logged_in']){
			$this->_user_id = $this->_data['data']['iauth_user_id'];
		}

		$this->_data['nav_uri']	= 'pm';
		$this->_data['pageTitle'] = 'User Control Panel';	
	}
	
	/**
	 * Displays paginated list of private messages
	 */
	public function index(){
		if($this->checkLoggedIn()){
			
			$this->_pagination_config['base_url'] = base_url('private_messages/index');	//has to be changed from the default
			$this->_pagination_config['total_rows'] = $this->_data['unread_pm_count'];
			$this->pagination->initialize($this->_pagination_config);
			
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			
			$this->_data['private_messages'] = $this->Private_messages_model->getPrivateMessages($page, $this->_pagination_config['per_page'], $this->_user_id);			
			
			$this->_data['pag_links'] = $this->pagination->create_links();

			$this->loadViews('user/private_messages_list');
		}
	}
	
	/**
	 * Reads single message and marks it as read
	 */
	public function read_message($id){
		$this->_data['pm'] = $this->Private_messages_model->getPrivateMessage($this->_user_id, $id);
		
		//mark read
		$this->Private_messages_model->markPMasRead($this->_user_id, $id);
		
		$this->loadViews('user/read_message');
	}
	
	/**
	 * Shows form for sending private message
	 */
	public function send_message($recepient = null, $replyTo = null){
		if(isset($recepient)){
			$this->_data['recepient'] = $recepient;
		}
		if(isset($replyTo)){
			$this->_data['subject'] = 'Re: '.$this->Private_messages_model->getSubject($this->_user_id, $replyTo);
		}
		$this->loadViews('user/send_message');
	}
	
	/**
	 * Gathers data and sends message
	 */
	public function send_pm_post(){
		$data = array(
				'recepient' => $this->input->post('recepient'),
				'subject' => $this->input->post('subject'),
				'message' => $this->input->post('message')
		);
		
		$data = $this->security->xss_clean($data);
		
		if($this->Private_messages_model->validatePM($this->_data['validation_params']) === TRUE){
			//form submitted and validated
			$data['sender'] = $this->_user_id;
			$recepient = $this->User_model->getIdFromUname($data['recepient']);
			
			if(!$recepient){
				//invalid username supplied
				$this->_data['status_report'] = 'You entered inexistent username';
			}
			else{
				//ok sending message
				$data['recepient'] = $recepient; //switch username for user id;
				$status = $this->Private_messages_model->sendPM($data);
				
				if($status){
					$this->_data['status_report'] = 'Message sent';
					$this->_data['urls']['redirect_target'] = $this->_data['urls']['private_messages'];
				}
				else{
					$this->_data['status_report'] = 'Message was not sent, please try again later';
				}				
				
			}
			$this->loadViews('status_report', $this->_data);
		}
		else{
			//form not validated
			$this->loadViews('user/send_message', $this->_data);
		}
	}
	
	/**
	 * Displays delete confirmation and then deletes private message
	 */
	public function delete($id, $confirmation = null){
		$msg = $this->Private_messages_model->getPrivateMessage($this->_user_id, $id);
		if(!isset($confirmation)){
			$this->_data['message'] = $msg;
			$this->_data['status_report'] = 'Are you sure you want to delete this private message?';
			$this->loadViews('user/user_status_report', $this->_data);
		}
		else{
			if($this->_user_id == $msg->recepient){
				//delete message
				$status = $this->Private_messages_model->delete($id);
				
				if($status){
					$this->_data['status_report'] = 'Message deleted successfully';
				}
				else{
					$this->_data['status_report'] = 'Message not deleted';
				}
				
				$this->loadViews('delete_status');
			}
		}
	}	
}
