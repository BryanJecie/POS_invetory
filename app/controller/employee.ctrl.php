<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
 */
class EmployeeController extends Controller
{
	public function __construct()
	{

		switch (App::$auth->data()->user_role) {
			case 'cashier':
				Redirect::to('page/pos');
				break;
		}
		if (!App::$auth->isLoggedIn()) {
			Redirect::to('index/userAuth');
		}
		Parent::__construct();
	}
	public function add_employee()
	{
		$this->loadModel('employee');

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {

				$validation = new Validate;

				// echo "<pre>";
				// print_r($_POST);
				// return;
				$valid = $validation->check($_POST, [
					'username' => [
						'min' => 3,
						'unique' => 'users',
					],
				]);
				if ($valid->passed()) {
					$userId = $this->model->createEmployee($_POST);
					if ($userId) {
						if (Input::get('image-file')) {
							$folder = PUBLIC_PATH . 'images/users/' . $userId;
							if (!file_exists($folder)) {
								mkdir($folder, 0777, true);
							} else {
								$folder = PUBLIC_PATH . 'images/users/' . $userId;
							}

							App::$image->upload_image($folder, Input::get('image-file'), true);
						}
						Session::setFlash('<div class="alert alert-success fade in m-b-15">
								           	 <i class="fa fa-check"></i>
								          	 	Employee Save
								             <span class="close" data-dismiss="alert">×</span>
								           </div>');
					}

				} else {
					$err = '';
					foreach ($valid->errors() as $error) {
						$err .= $error;
					}
					Session::setFlash('<div class="alert alert-danger fade in m-b-15">
								          <strong>Error!</strong>
								          	' . $err . '
								          <span class="close" data-dismiss="alert">×</span>
								        </div>');
				}
			}
		}

		$maxID = $this->model->getEmployeeMaxID();

		$access = $this->model->getAccess();
		$userRole = $this->model->getUserRole();


		foreach ($maxID as $ids)
			$id = $ids;

		$this->view->load('default', 'employee/addEmployee', [
			'title' => 'Employee',
			'id' => $id += 1,
			'access' => $access,
			'role' => $userRole
		]);
	}
	public function manage_employee($action = null)
	{
		// print_r($this->params);
		// // print_r($action);
		// return false;
		if (!is_null($action) and isset($this->params[1])) {



		}
		$this->loadModel('employee');





		$emp = $this->model->getEmployee();

		$access = $this->model->getAccess();

		$role = $this->model->getUserRole();

		$this->view->load('default', 'employee/manage_employee', [
			'title' => 'Employee',
			'employee' => $emp,
			'access' => $access,
			'role' => $role
		]);
	}
	public function manage_logs()
	{
		$this->loadModel('employee');

		$usersLogs = $this->model->getEmployeeLogs();

		$this->view->load('default', 'employee/manageLogs', [
			'title' => 'Log History',
			'usersLogs' => $usersLogs
		]);
	}
	public function edit_employee($action = null)
	{
		$this->loadModel('employee');
		$empId = null;

		if (!is_null($action) and isset($this->params[1])) {
			$empId = $this->params[1];
		}


		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {

				$userId = Input::get('userId');
				$personId = Input::get('personId');

				Query::update('users', 'user_id', $userId, [
					'username' => Input::get('username'),
					'role_id' => Input::get('role')
				]);
				Query::update('personnel', 'person_id', $personId, [
					'person_first' => Input::get('fname'),
					'person_middle' => Input::get('mname'),
					'person_last' => Input::get('lname'),
					'person_address' => Input::get('address'),
					'person_birthdate' => Input::get('bdate'),
				]);
				Query::delete('accessibility', ['user_id', '=', $userId]);

				foreach (Input::get('empAccess') as $acs) {
					Query::insert('accessibility', [
						'access_list_id' => $acs,
						'user_id' => $userId
					]);
				}

				if (Input::get('image-file')) {
					$folder = PUBLIC_PATH . 'images/users/' . $userId;
					if (!file_exists($folder)) {
						mkdir($folder, 0777, true);
					} else {
						$folder = PUBLIC_PATH . 'images/users/' . $userId;
					}
					App::$image->upload_image($folder, Input::get('image-file'), true);
				}

				if (Query::count()) {
					Session::setFlash('Employee Information Update.');
				}
			}
		}

		$employee = $this->model->getEmployeeInfo($empId); 
		// print_r($employee);
		// return;
		$access = $this->model->getAccess();

		$role = $this->model->getUserRole();

		$this->view->load('default', 'employee/view_employee', [
			'title' => 'Employee',
			'access' => $access,
			'role' => $role,
			'employee' => $employee
		]);
	}
	public function editEmployee()
	{
	 	# code...
	}
}

