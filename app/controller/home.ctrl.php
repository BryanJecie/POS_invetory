<?php
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
class HomeController extends Controller
{
	public function __construct()
	{

		if (App::$auth->data()->user_role === 'cashier' and empty(App::params())) {
			Redirect::to('index/userAuth');
		}
		if (!App::$auth->isLoggedIn()) {
			Redirect::to('index/userAuth');
		}

		Parent::__construct();
	}
	public function index()
	{
		$this->loadModel('order');

		$orders     = $this->model->getNewOrderInvoice();
		$salesYear  = $this->model->getSummarySaleYear();
		$salesMonth = $this->model->getSummarySalesMonth();

		$purchase = Query::getSql()->query("
						SELECT * FROM
						purchased
						INNER JOIN supplier ON purchased.supplier_id = supplier.supplier_id
						INNER JOIN users ON purchased.user_id = users.user_id
						INNER JOIN personnel ON users.person_id = personnel.person_id
						WHERE
						purchased.purchase_payment_status = 'unpaid'
						LIMIT 0, 5
					")->all();
		// print_R(Hash::salt(20));
		// return;
		// print_r(Cookie::get(Config::load('utilities/cookie_name')));
		$this->view->load('default', 'content/index', [
			'title'      => 'dashboard',
			'orders'     => $orders,
			'salesMonth' => $salesMonth,
			'salesYear'  => $salesYear,
			'purchase'   => $purchase
		]);
	}
	public function profile()
	{

		$this->loadModel('product');

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {

				$res = $this->model->insertProductProfile($_POST);

				if ($res) {
					// Redirect::to('home/profile');
					Session::setFlash('Product Successfully save');
				}
			}
		}

		$profile  = $this->model->getProductProfile();

		$prod_type = $this->model->getProduct_type();

		$this->view->load('default', 'content/profile', [
			'title'     =>  'profile',
			'prod_type' =>  $prod_type,
			'profile'   =>  $profile
		]);
	}
	public function stockin()
	{
		$this->loadModel('product');


		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {

				$stockin = $this->model->postStockin($_POST);

				if ($stockin) {
					Session::setFlash('Stock Successfully Input.');
				}
			}
		}

		$profile  = $this->model->getProductProfile();
		$stockin  = $this->model->getStockin();

		$this->view->load('default', 'content/stockin', [
			'title'   => 'Stockin',
			'profile' =>  $profile,
			'stockin' =>  $stockin
		]);
	}
	public function stockout()
	{
		$this->view->load('default', 'content/stockout', [
			'title'   => 'Stockout'
		]);
	}
	public function stocks()
	{
		$this->view->load('default', 'content/stocks', ['title' => 'stocks']);
	}
	public function monitor()
	{
		$this->view->load('default', 'content/monitor', ['title' => 'monitor']);
	}
	public function reports()
	{
		$this->view->load('default', 'content/reports', ['title' => 'reports']);
	}
	public function security()
	{
		$this->loadModel('user');

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				$validate = new Validate;


				$valid = $validate->check($_POST, [
					'username' => [
						'required' => true,
						'min'	   => 4,
						'unique'   => 'users'
					],
					'password' => [
						'required' => true,
						'min'	   => 4
					]
				]);
				if ($valid->passed()) {

					$user_id = $this->model->postUser($_POST);

					if ($user_id) {

						if (Input::get('image-file')) {
							$dir = '';

							if (!file_exists($dir = PUBLIC_PATH . 'images/users/' . $user_id))
								mkdir($dir, 0777, true);
							else
								$dir = PUBLIC_PATH . 'images/users/' . $user_id;

							App::$image->upload_image($dir, Input::get('image-file'),   true);
						}
						Session::setFlash('<div class="alert alert-success fade in m-b-15 noti-fade">
		 	    		                      <span class="close" data-dismiss="alert">×</span>
		 	    		                      <strong><i class="fa fa-check"></i> </strong><br>
		 	    		                      User Successfully Save.
				 	    		 		   </div>');
					}
				} else {
					$er = '';
					foreach ($valid->errors() as $error)
						$er .= ' ' . $error . '<br>';
					// Session::setFlash($er);
					Session::setFlash('<div class="alert alert-danger fade in m-b-15 noti-fade">
		 	    		                      <span class="close" data-dismiss="alert">×</span>
		 	    		                      <strong><i class="fa fa-warning"></i> ERROR ! </strong><br>
		 	    		                      ' . $er . '
				 	    		 		   </div>');
				}
			}
		}

		$users = $this->model->getUsers();

		$this->view->load('default', 'content/security', [
			'title' => 'security',
			'users' => $users,
		]);
	}
	public function securitys()
	{
		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				$validation = new Validate;

				$check = $validation->check($_POST, [
					'username' => [
						'required' => true,
						'min'      => 3,
						'unique'   => 'users',
					],
					'password' => [
						'required' => true
					]
				]);
				if ($check->passed()) {

					$salt = Hash::salt(32);

					Query::insert('users', [
						'username'   => Input::get('username'),
						'password'   => Hash::make(Input::get('password'), $salt),
						'user_salt'  => $salt,
						'user_level' => 'staff',
						'user_role'  => 'staff',
						'status'     => 'offline'
					]);
					Session::setFlash('<div class="alert alert-success fade in m-b-15">
								          <strong>Error!</strong>
								          	Data save
								          <span class="close" data-dismiss="alert">×</span>
								       </div>');
				} else {
					$err = '';
					foreach ($check->errors() as $error) {
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
		$this->view->load('default', 'content/security');

		// print_r($this->params);
	}
}
