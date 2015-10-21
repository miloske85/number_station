<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Name: Messages
*
*	Version: 1.1
*
*	Author: Milos Milutinovic
*			milos.milutinovic@live.com
*
*	Created: 2015-07
*
*	Description: Handles public messages. Default route.
*
*	Requires: Codeigniter 3
*/
class Messages extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form', 'captcha', 'security'));
		$this->load->library(array('ion_auth', 'pagination', 'session'));

		$this->load->model(array('Captcha_model', 'Messages_model'));

		$this->_data['pageTitle'] = 'Numbers Relay Page';		
	}

	/**
	 * Displays paginated list of public messages
	 */
	public function index(){
		if(!$this->_data['data']['logged_in']){
			$this->_data['captcha'] = $this->createCatcha();
		}
		
		//set up pagination
		$this->_pagination_config['total_rows'] = $this->Messages_model->countMessages();
		$this->_pagination_config['base_url'] = base_url('messages/index');
		$this->pagination->initialize($this->_pagination_config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$this->_data['messages'] = $this->Messages_model->getMessages($page, $this->_pagination_config['per_page']);

		$this->_data['pag_links'] = $this->pagination->create_links();

		$this->loadViews('main');
	}

	/**
	 * Handles posting of new (public) message
	 */
	public function post(){

		$data = array(
					'name' => $this->input->post('name'),
					'captcha' => $this->input->post('captcha'),
					'message' => $this->input->post('message'),
			);
			
		$data = $this->security->xss_clean($data);

		if($this->Messages_model->validateMessage($this->_data['validation_params']) == TRUE){
			//form submitted and verified;
			$ip = $this->input->ip_address();

			if(!$this->_data['data']['logged_in']){
				$status = $this->Captcha_model->checkCaptcha($data['captcha'], $ip);
			}
			else{
				$status = true;	//user is logged in and there's no captcha
			}

			if($status){
				//captcha verified
				if(!$this->_data['data']['logged_in']){
					$messageData['name'] = $data['name'];
					$messageData['user_id'] = 0;
				}
				else{
					$messageData['name'] = '';
					$messageData['user_id'] = $this->_data['data']['iauth_user_id'];
					
				}
				
				$messageData['message'] = $data['message'];

				$instStatus = $this->Messages_model->insertMessage($messageData);

				if($instStatus){
					$this->_data['status_report'] = 'Message posted successfully';
					$this->_data['urls']['redirect_target'] = $this->_data['urls']['home'];
				}
				else{
					$this->_data['status_report'] = 'Message posting failed';
				}
				$this->loadViews('status_report');
			}
			else{
				//captcha failed
				$this->_data['captcha_error'] = 'CAPTCHA code was wrong';
				if(!$this->_data['data']['logged_in']){
					$this->_data['captcha'] = $this->createCatcha();
				}				
				$this->loadViews('main');
			}
		}
		else{
			//form validation has failed

			if(!$this->_data['data']['logged_in']){
				$this->_data['captcha'] = $this->createCatcha();
			}
			$this->loadViews('main');
		}

	}

	/**
	*	Performs search of public messages.	
	*	Uses session storage to help with pagination.
	*/
	public function search(){
		$searchPostString = $this->input->post('search_message');

		//clear session on post, uses hidden form field
		if($this->input->post('post_check')){
			$this->session->searchString = NULL;
		}

		if(strlen($searchPostString) >= 2 OR strlen($this->session->searchString) >= 2){
			//session storage management
			if($this->session->searchString AND !$searchPostString){	//has to be like this, isset() won't work
				$searchString = $this->session->searchString;
			}
			else{
				$this->session->searchString = $searchPostString;
				$searchString = $searchPostString;
			}

			//pagination
			$this->_pagination_config['base_url'] = base_url('messages/search');
			$this->_pagination_config['total_rows'] = $this->Messages_model->countMessageSearch($searchString);
			$this->_pagination_config['per_page'] = 20;

			$this->_data['search_count'] = $this->_pagination_config['total_rows']; //displays count on the page

			$this->pagination->initialize($this->_pagination_config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			//data
			$this->_data['search_results'] = $this->Messages_model->searchMessages($searchString, $page, $this->_pagination_config['per_page']);

			$this->_data['pag_links'] = $this->pagination->create_links();

			$this->loadViews('search_results_messages');
		}
		else{
			$this->_data['status_report'] = 'Search string must be at least 2 characters long';
			$this->loadViews('status_report');
		}
	}

	/**
	 * Shows single message
	 */
	public function show_message($id = null){
		if(!isset($id)){
			$this->_data['status_report'] = 'The specified message doesn\'t exist';
			$this->loadViews('status_report');
		}
		else{
			$this->_data['message'] = $this->Messages_model->getMessage($id);

			if($this->_data['message']){
				$this->loadViews('show_message');
			}
			else{
				$this->_data['status_report'] = 'The specified message doesn\'t exist';
				$this->loadViews('status_report');
			}
		}
	}

	/**
	 * Displays confirmation page and deletes message
	 */
	public function delete($id, $confirmation = null){
		$message = $this->Messages_model->getMessage($id);

		if(!isset($confirmation)){
			$this->_data['status_report'] = 'Are you sure you want to delete the message';
			$this->_data['message'] = $message;

			$this->loadViews('delete_status');
		}
		else{

			if($this->_data['data']['logged_in']){
				if($this->_data['data']['iauth_user_id'] == $message->user_id){
					$status = $this->Messages_model->deleteMessage($id);
					
					$this->_data['delete_conf'] = 'c';
					if($status){
						$this->_data['status_report'] = 'Message deleted successfully';
						$this->_data['urls']['redirect_target'] = $this->_data['urls']['home'];
					}
					else{
						$this->_data['status_report'] = 'Message was not deleted';
					}

					$this->loadViews('delete_status');
				}
			}
		}

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
}
