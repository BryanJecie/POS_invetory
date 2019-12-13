<?php
###===============================================>
#### Display Time Zone
###
###

date_default_timezone_set('Asia/Manila');

###===============================================>
#### Start the Session
###
###

session_start();

###===============================================>
#### Load Classes Here
###
###


// ob_start();

function __autoload($class_name)
{
	$libs_path    = APP_PATH.'libs/'.strtolower($class_name).'.class.php';
	$con_path 	  = APP_PATH.'controller'.'/'.str_replace('controller', '', strtolower($class_name)) .'.ctrl.php';
	$helpers_path = HELPERS_PATH.strtolower($class_name).'.php';
	 
	if (file_exists($libs_path)){
		require_once $libs_path;
	}
	if (file_exists($helpers_path)){
		require_once $helpers_path;
	}
	if (file_exists($con_path)){
		require_once $con_path;
	}
}

###===============================================>
#### Display HTML settings
###
###

require_once RES_PATH.'/functions/settings.php';

require_once RES_PATH.'/functions/utilities.php';

require_once RES_PATH.'/functions/function.php';

###===============================================>
#### Setter Configuration
###
###

if (Cookie::exist(Config::load('utilities/cookie_name')) && !Session::exist(Config::load('utilities/session_name'))) {

	$hash  = Cookie::get(Config::load('utilities/cookie_name'));
	$check = DB::table('`users_session`')->where(['`hash`','=',$hash]);

	if ( $check->_count > 0 ) {
		
		$userId = $check->_result[0]->user_id;
		
		$user  = new Auth($userId);
	
		$login = $user->login();
		 
		Query::update('users','user_id', $userId, ['status' => 'online' ]);
		Redirect::to('home');
	}
} 

if (!Session::exist(Config::load('utilities/session_name'))){
	return false;
	$db = new DB;
	$logs = $db->query("SELECT * FROM  users  INNER JOIN  users_logs  ON users_logs.user_id = users.user_id");
	if ($logs->_count > 0) {
		foreach ($logs->_result as $log) {
			if ($log->status === 'online' && $log->log_status === 'login') {
				$userId = $log->user_id;
				Query::update('users','user_id', $log->user_id, ['status' => 'offline']);

				Query::update('users_logs', 'log_id', $log->log_id, [
						 	  'logout_date' => date('Y-m-d H:m:s'),
						 	  'log_status'  => 'logout'
			 	]);
			}
		}
	}
} 
