<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	Custom Configuration file for Number Station project
*
*/

	//sql files to be installed
	$config['sql_files'] = array('captcha', 'ci_sessions', 'iplog_log', 'iplog_pages', 'iplog_ua', 'messages', 'private_messages', 'ion_auth');


	//directory containing sql files
	//must have trailing slash
	$config['sql_location'] = './application/sql/'; //has to have trailing slash/backslash