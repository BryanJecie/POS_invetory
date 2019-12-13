<?php
###===============================================
#### AUTH Class for user login
###
###

class Auth
{

	public $_data;
	public $_sessionName;
	public $_cashierName;
	public $_isLoggedIn;
	public $_cookieName;
	public $_sessionDate;
	public $_sessionLogId;

	private $_DB;

	/**
	 * Constructor of auth class
	 * 
	 * @return true
	 */
	public function __construct($user = null)
	{
		// $this->_DB = new DB;
		$this->_sessionName = Config::load('utilities/session_name');
		$this->_cashierName = Config::load('utilities/cashier_name');
		$this->_cookieName = Config::load('utilities/cookie_name');
		$this->_sessionLogId = Config::load('utilities/login_id');

		if (!$user) {
			if (Session::exist($this->_sessionName)) {
				$user = Session::get($this->_sessionName);
				if ($this->find($user)) {
					$this->_isLoggedIn = true;
				} else {
					//  process log out
					$this->logout();
				}
			}
		} else {
			$this->find($user);
		}
	}

	/**
	 * (Optional) Set a custom method logout
	 * @param string $path Use the file name of your controller, eg: error.php
	 */
	public function logout()
	{


		$userId = $this->data()->user_id;

		Query::update('users', 'user_id', $userId, [
			'user_status' => 'offline'
		]);

		if (Query::count()) {

			Query::update('user_logs', 'log_id', $this->_sessionLogId, [
				'logout_date' => date('Y-m-d H:m:s'),
				'log_status' => 'logout'
			]);

		}
 
		// Cookie::delete($this->_cookieName);
		Session::delete($this->_sessionName);
		Session::delete($this->_cashierName);
		Session::delete($this->_sessionLogId);
	}

	/**
	 * (Optional) Set a custom method find
	 * @param allows to find the user in the database
	 */
	public function find($user = null, $trigger = false)
	{
		$data = '';
		if ($user) {
			$field = (is_numeric($user)) ? 'user_id' : 'username';
			   
			// $result = DB::table('users INNER JOIN personnel ON users.p_id = personnel.p_id')->where([$field, '=', $user])->all();
			// print_r($newResult);
			// return false;
			$result = DB::table('users INNER JOIN personnel ON users.person_id = personnel.person_id 
								 INNER JOIN user_role ON users.role_id = user_role.role_id')
				->where([$field, '=', $user])
				->all();

			if (is_array($result) and !empty($result)) {

				$this->_data = $result[0];
				return true;
			}

		}
		return false;
	}

	/**
	 * (Optional) Set a custom method login
	 * @param true
	 */
	public function login($username = null, $password = null, $remember = false)
	{
		if (!$username && !$password && $this->exist()) {
			Session::put($this->_sessionName, $this->data()->user_id);

		} else {
			$user = $this->find($username);
			if ($user) {
				if ($this->data()->password === Hash::make($password, $this->data()->user_salt)) {
					Session::put($this->_sessionName, $this->data()->user_id);

					if ($remember) {
						$hash = Hash::unique();
						$userId = $this->data()->user_id;
						// $sess_hash = Query::getSql()->query("SELECT * FROM `users_session` WHERE `user_id` = {$userId}");

						$sess_hash = DB::table('`users_session`')->where(['user_id', '=', $userId]);

						if ($sess_hash->_count <= 0) {
							Query::insert('users_session', [
								'user_id' => $userId,
								'hash' => $hash
							]);
						} else {
							$hash = $sess_hash->_result[0]->hash;
						}
						Cookie::put($this->_cookieName, $hash, Config::load('utilities/cookie_expiry'));
					}
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * (Optional) Set a custom method exist
	 * @param check is data is true 
	 */
	public function exist()
	{
		return (!empty($this->_data)) ? true : false;
	}

	/**
	 * (Optional) Set a custom method data
	 * @param return the data is not null
	 */
	public function data()
	{
		return $this->_data;
	}

	/**
	 * (Optional) Set a custom method is LoggedIn
	 * @param check if the user is login
	 */
	public function isLoggedIn()
	{
		return $this->_isLoggedIn;
	}
}
