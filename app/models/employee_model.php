<?php

/**
 * 
 */
class Employee_Model extends Model
{
	public $empId;

	public function getEmployeeMaxID()
	{
		$maxID = $this->_DB->query("SELECT Max(personnel.person_id) FROM personnel");


		if ($maxID->_count > 0) {
			return $maxID->_result[0];
		} else {
			return null;
		}
	}
	public function getAccess()
	{
		$access = $this->_DB->query("SELECT * FROM accessibility_list");
		if ($access->_count > 0) {
			return $access->_result;
		} else {
			return null;
		}

	}
	public function createEmployee($source = array())
	{

		$salt = Hash::salt(32);
		$empId = 0;
		Query::insert('personnel', [
			'person_no' => $source['emp-no'],
			'person_first' => $source['first'],
			'person_middle' => $source['middle'],
			'person_last' => $source['last'],
			'person_address' => $source['address'],
			'person_position' => $source['position'],
			'person_birthdate' => $source['birthdate']
		]);
		if (Query::count()) {
			$empId = Query::last_insert_id();
		}
		Query::insert('users', [
			'username' => $source['username'],
			'password' => Hash::make($source['password'], $salt),
			'role_id' => $source['role'],
			'user_type' => 'user',
			'user_status' => 'offline',
			'user_salt' => $salt,
			'person_id' => $empId
		]);

		if (Query::count()) {
			$userId = Query::last_insert_id();
			$this->createAccess($source['access'], $userId);
			return $userId;
		}
		return false;

	}

	public function createAccess($access = array(), $userId = null)
	{
		if (is_array($access)) {
			foreach ($access as $acc) {
				Query::insert('accessibility', [
					'access_list_id' => $acc,
					'user_id' => $userId
				]);
			}
		}
	}
	public function getEmployeeInfo($empId = null)
	{
		$user = $this->_DB->query("SELECT * FROM users
								   INNER JOIN personnel ON users.person_id = personnel.person_id
								   INNER JOIN user_role ON users.role_id = user_role.role_id
								   WHERE users.user_id = {$empId} ");
		if ($user->_count > 0) {
			return $user->_result;
		} else {
			return null;
		}
	}
	public function getEmployee()
	{
		$employee = $this->_DB->query("SELECT * FROM personnel INNER JOIN users ON users.person_id = personnel.person_id INNER JOIN user_role ON users.role_id = user_role.role_id");

		if ($employee->_count > 0) {
			return $employee->_result;
		} else {
			return null;
		}
	}
	public function getEmployeeLogs()
	{
		$logs = $this->_DB->query("SELECT * FROM user_logs
								   INNER JOIN users ON user_logs.user_id = users.user_id
								   INNER JOIN user_role ON users.role_id = user_role.role_id");

		if ($logs->_count > 0) {
			return $logs->_result;
		} else {
			return null;
		}
	}
	public function getUserRole()
	{
		$role = $this->_DB->query("SELECT * FROM user_role");

		if ($role->_count > 0) {
			return $role->_result;
		} else {
			return null;
		}
	}
}