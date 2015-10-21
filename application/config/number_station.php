<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
|--------------------------------------------------------------------------
|	Custom Configuration file for Numbers Station project
|--------------------------------------------------------------------------
|
|	Explanation of parameters
|
|	['is_demo']	When set to true the site data will be reset periodically
|	with the data from SQL files in application/sql/demo/data. Must be
|	disabled in production environment.
|
|	['date_format']	Date format (PHP) to be displayed.
|
|
|	Admin nav bar section contains array that is used to build navbar in admin control panel.
|
|	['captcha_params']	Settings for creating Codeigniter CAPTCHA, refer to
|	CI manual for individual settings
|
|	['validation_params']	Sets global parameters for form validation, refer to
|	CI manual for individual settings
|
|	['pagination_params']	Sets global parameters for pagination, refer to
|	CI manual for individual settings
|
|--------------------------------------------------------------------------
*/

	$config = array(
		'nav_uri' => 'messages'
	);

	//new convention
	$config['urls'] = array(
		'home' => base_url(),
		'login' => base_url('login/'),
		'logout' => base_url('logout/'),
		'register' => base_url('register'),
		'forgot_password' => base_url('user/forgot_password'),
		'user_cp' => base_url('user/'),
		'change_pass' => base_url('user/change_pass'),
		'avatar_page' => base_url('user/avatar'),
		'message_delete' => base_url('messages/delete'),
		'user_show_message' => base_url('messages/show_message'),
		'private_messages' => base_url('private_messages'),
		'read_private_msg' => base_url('private_messages/read_message'),
		'send_private_message' => base_url('private_messages/send_message'),		
		'delete_private_message' => base_url('private_messages/delete'),
		'install' => base_url('install/install'),
		'TOS' => base_url('content/tos'),
		'about' => base_url('content/about'),
		'external_links' => base_url('content/external_links'),
		'list_users' => base_url('user/list_users'),
		'show_user' => base_url('user/show_user'),
		'user_delete_avatar' => base_url('user/delete_avatar'),

		'admin' => base_url('admin/ap'),
		'admin_show_user' => base_url('admin/ap/show_user'),		
		'admin_delete_user' => base_url('admin/ap/delete/user'),
		'admin_promote_user' => base_url('admin/ap/promote_user'),
		'admin_show_message' => base_url('admin/ap/show_message'),		
		'admin_delete_message' => base_url('admin/ap/delete/message'),
		'iplog_show_visit_list' => base_url('admin/iplog/view_list'),
		'iplog_search' => base_url('admin/iplog/search'),
		'admin_edit_message' => base_url('admin/ap/edit_message'),
		'admin_edit_user' => base_url('admin/ap/edit_user'),
		'admin_cancel_link' => base_url('admin/ap'),
		'admin_delete_link' => base_url('admin/ap/delete')
	);

	$config['forms'] = array(
		'message' => base_url('messages/post'),
		'message_search' => base_url('messages/search'),
		'send_pm_post' => base_url('private_messages/send_pm_post'),
		'avatar_upload' => base_url('user/avatar_post'),
		'change_password' => base_url('user/cp_post'),
		'login' => base_url('login'),
		'register' => base_url('register'),
		'forgot_pass' => base_url('user/forgot_password_post'),
		'admin_search_message' => base_url('admin/search/message'),
		'admin_search_username' => base_url('admin/search/username'),
		'admin_search_email' => base_url('admin/search/email')

	);

	$config['assets'] = array(
		//CSS
		'css' => base_url('css/main.css'),
		'css_patch' => base_url('css/patch.css'),
		'favicon' => base_url('favicon.ico'),
		'fa_css' => base_url('css/font-awesome.min.css'),

		//JS
		'modernizr' => base_url('js/vendor/modernizr-2.8.3.min.js'),
		'jquery' => base_url('js/vendor/jquery-1.11.3.min.js'),
		'bootstrap_js' => base_url('js/vendor/bootstrap.min.js'),
		'dropdown_js' => base_url('js/vendor/dropdown.js'),
		'collapse_js' => null,
		'transition_js' => null,
		'validation_js_lib' => base_url('js/vendor/jquery.validate.min.js'),

		//my scripts
		'ajax_register' => base_url('js/ajax-register.js'),
		'validate_main' => base_url('js/validate_main.js'),
		'validate_register' => base_url('js/validate_register.js'),
		'validate_login' => base_url('js/validate_login.js'),
		'js_redirect' => base_url('js/redirect.js'),
		'password_strength_meter' => base_url('js/password_strength_meter.js'),

		//img
		'avatar_placeholder' => base_url('img/avatar_placeholder.png')
	);

	$config['data'] = array(
		'is_demo' => false,
		'date_format' => 'M/j/Y g:i A',
		'email_available' => false,
		'pageTitle' => 'Default Title',
		'upload_path' => './uploads',		
		
	);

	//admin nav bar
	$config['admin_nav'] = array(
				'root' => array(
						'url' => base_url('admin/ap'),
						'label' => 'Admin Root'
					),
				'messages' => array(
						'url' => base_url('admin/ap/list_messages'),
						'label' => 'View Messages'
					),
				'users' => array(
						'url' => base_url('admin/ap/list_users'),
						'label' => 'List Users'
					),
				'search' => array(
						'url' => base_url('admin/search'),
						'label' => 'Search'
					),
				'ip' => array(
						'url' => base_url('admin/iplog'),
						'label' => 'View IPs'
					)
	);

	$config['captcha_params'] = array(
		'word_length' => 1,
		'img_path' => './captcha/',
		'img_url' => base_url('captcha/'),
		'font_path' => ('./fonts/OpenSans-Light.ttf'),
		'font_size' => 20,
		'img_height' => 40,
		'img_width' => 180,
		'pool' => '123456789ABCDEFGHKLMNPRSTUVWXYZabcdefghijkmnpqrstuvwyz',

		'colors' => array(
			'background' => array(240,240,240),
			'border' => array(120,120,120),
			'text' => array(20,0,0),
			'grid' => array(120,120,120)
			)
		);

	$config['validation_params'] = array(
			'error_delim_open' => '<div class="text-danger">',
			'error_delim_close' => '</div>'
		);

	$config['pagination_params'] = array(
			'per_page' => 20,
			'full_tag_open' => '<ul class="pagination">',
			'full_tag_close' => '</ul>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>',
			'cur_tag_open' => '<li class="active"><a>',		//bootstrap requires anchor tags
			'cur_tag_close' => '</a></li>',
			'prev_tag_open' => '<li>',
			'prev_tag_close' => '</li>',
			'next_tag_open' => '<li>',
			'next_tag_close' => '</li>',
			'first_tag_open' => '<li>',
			'first_tag_close' => '</li>',
			'last_tag_open' => '<li>',
			'last_tag_close' => '</li>'
	);
