<?php
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
 */

class IndexController extends Controller
{
	public function __construct()
	{
		// if (isset($this->params[1]) AND $this->params[1] !== Session::get(Config::load('utilities/cashier_name'))) {
		// 	$user = new Auth();
		// 	$user->logout();
		// 	// Redirect::to('index/userAuth');
		// }
		Parent::__construct();
	}
	public function index()
	{

		if (App::$auth->isLoggedIn()) {

			switch (App::$auth->data()->user_role) {
					// case 'cashier':
					// 	Redirect::to('page/pos');
					// break;
				case 'admin':
					Redirect::to('home');
					break;
			}
		}

		$this->loadModel('reports');

		$compInfo = $this->model->getCompanyInfo();

		$this->view->load('default', 'login/defaultLogin', [
			'admin' => 'admin',
			'comps' => $compInfo
		]);
	}
	public function userAuth()
	{

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {

				$validate = new Validate;

				$valid = $validate->check($_POST, [
					'username' => [
						'required' => true,
						// 'user_status' => 'users:online',
						'role' => 'user_role:admin'
					],
					'password' => [
						'required' => true
					]
				]);
				if ($valid->passed()) {

					$login = App::Auth()->login(Input::get('username'), Input::get('password'));

					if ($login) {

						Query::update('users', 'user_id', App::$auth->data()->user_id, ['user_status' => 'online']);

						Query::insert('user_logs', [
							'login_date' => date('Y-m-d H:m:s'),
							'user_id' => App::$auth->data()->user_id,
							'log_status' => 'login'
						]);

						if (Query::count()) {

							$logId = Query::last_insert_id();
							$sessionLogName = Config::load('utilities/login_id');

							Session::put($sessionLogName, $logId);

							if (App::$auth->data()->user_role == 'cashier')
								Redirect::to('page/pos');
							else
								Redirect::to('home');
						}
					} else {
						Session::setFlash('Username & Password is incorrect.');
					}
				} else {
					$er = '';
					foreach ($valid->errors() as $error)
						$er .= ' ' . $error . '<br>';
					Session::setFlash($er);
				}
			} else {
				Session::setFlash('Only admin Login here');
			}

			// }
		}
		$this->index();
	}
	public function postLogout()
	{

		$auth = new Auth;
		$auth->logout();

		Redirect::to("signOut?user=" . Hash::salt(20));
	}
	public function postCashierLogout()
	{
		$treg = array();

		if (Input::exist()) {
			// $user_id = Input::get('user_id');
			$auth = new Auth;
			$auth->logout();

			$treg['key'] = true;
		}
		echo json_encode($treg);
	}



	public function checkUser()
	{
		$trig = array();

		$user = Input::get('user_id');

		$count = DB::table('users')->where(['user_id', '=', $user])->count();

		if ($count > 0) {
			$trig['key'] = true;
		} else {
			$trig['key'] = false;
		}
		// $this->postLogout();

		echo json_encode($trig);
	}
	public function signOut()
	{
		$this->index();
	}
	public function userLock($action = null)
	{

		if (Input::exist()) {
			if (Input::get('token')) {
				$users = new Auth($this->params[1]);
				if ($users->data()->password === Hash::make(Input::get('password'), $users->data()->user_salt)) {
					// Redirect::to();
					Redirect::to('page/pos/user?cashier=' . Hash::make(App::$auth->data()->user_id));
				} else {
					Session::setFlash("Password Incorrect...");
				}
			}
		}
		if (!is_null($action) and isset($this->params[1])) {
			// Session::delete(Config::load('utilities/session_name'));





			$this->view->load('lock', 'login/lockScreen');
		}
	}
	public function pos($string = null)
	{
		$this->loadModel('reports');

		$compInfo = $this->model->getCompanyInfo();


		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {

				$validate = new Validate;
				$valid = $validate->check($_POST, [
					'username' => [
						'required' => true,
						'user_status' => 'users:online',
						'role' => 'user_role:cashier'
					],
					'password' => [
						'required' => true
					]
				]);
				if ($valid->passed()) {

					$login = App::Auth()->login(Input::get('username'), Input::get('password'));

					if ($login) {

						Query::update('users', 'user_id', App::$auth->data()->user_id, ['user_status' => 'online']);

						if (Query::count()) {

							Redirect::to('page/pos/cashier_login?cashier=' . Hash::make('cashier'));
						}
					} else {
						Session::setFlash('Username & Password is incorrect.');
					}
				} else {
					$er = '';
					foreach ($valid->errors() as $error) {
						$er .= ' ' . $error . '<br>';
					}
					Session::setFlash($er);
					Session::delete(Config::load('utilities/cashier_name'));
				}
			}
		}

		if (!is_null($string) and $this->params[0] === 'cashier' and Hash::make('cashier') === $this->params[1]) {

			Session::put(Config::load('utilities/cashier_name'), $this->params[1]);

			if (Session::get(Config::load('utilities/cashier_name')) === $this->params[1] and Session::exist(Config::load('utilities/cashier_name'))) {
				$this->view->load('default', 'login/cashierLogin', [
					'comps' => $compInfo
				]);
			}
		}
	}
}
