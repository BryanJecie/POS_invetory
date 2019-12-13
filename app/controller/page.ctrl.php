<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : Assessment and Cashiering System with Queue
###  @Copyright    : August 8-1-2016 
###
##
*/
class PageController extends Controller
{
	private $param;


	public function __construct()
	{	

		 
	 
		if (!App::$auth->isLoggedIn()) {
	 		Redirect::to('index/userAuth');
	 	}
	 	if (App::$auth->data()->user_role === 'cashier' AND empty(App::params())) {
	 		// Redirect::to('index/postLogout');
	 	}
	 
	 	// echo App::$auth->data()->user_role;
	 	// if ($this->params[1] !== Session::get(Config::load('utilities/cashier_name'))) {
	 	// 	print_r($this->params);
	 	// 	$user = new Auth();
	 	// 	$user->logout();
	 	// 	Redirect::to('index/userAuth');
	 	// }
	 	Parent::__construct();
	}
	 
	public function index()
	{
	 	$this->view->load('page/cashier','page/content/cashier-index');
	}

	public function pos($user = null)
	{
	 	// print_r($this->params);
		$this->param = $this->params;
		
		$this->loadModel('cashier');

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				Query::insert('cash_type',[
					'cast_type'		=> Input::get('cash-type'),
					'cash_amount'	=> Input::get('amount'),
					'cash_date'		=> date('Y-m-d H:m:s'),
					'cash_desc'		=> Input::get('note'),
					'user_id'		=> App::$auth->data()->user_id
				]);
				if (Query::count()) {
					Session::setFlash('Cash Successfully '. ucwords(Input::get('cash-type')));
				} 
			}
		}

		// echo Session::get(Config::load('utilities/cashier_name')).'<br>';
		// print_r($this->params['1']);

		$remain    = $this->model->retrieveRemainingProduct();
		$customers = $this->model->retrieveCustomers();
		$maxID     = $this->model->getCustomMaxID();
		$tempSales = $this->model->getTempPurcahse();
		$product   = $this->model->getAllProduct();



	 	$id = 0;
		foreach ($maxID as $ids) {
			$id = $ids;
		}
	 	$this->view->load('page/cashier','page/content/cashier-index',[
	 		'customers' => $customers,
	 		'remain'    => $remain,
	 		'id'    	=> $id+=1,
	 		'tempSales' => $tempSales,
	 		'products'  => $product,
	 		]);
	}
	public function getCustomers()
	{
		
		if (!is_null($listOject) AND is_array($listOject)) {
			// return 
		}
	}
	public function postCostumer()
	{
		 
		if (Input::exist()) {
			 Query::insert('customer',[
						'custom_no'			=> Input::get('cus_no'),
						'custom_firstname'	=> Input::get('first'),
						'custom_lastname'	=> Input::get('last'),
						'custom_address'	=> Input::get('address'),
						'custom_birthdate'	=> Input::get('birthdate'),
						'custom_discount'	=> Input::get('discount'),
						'custom_email'		=> Input::get('email'),
						'custom_phone'		=> Input::get('phone'),
						'register_date'		=> date('Y-m-d H:m:s')
					]);
			if (Query::count()) {
				Redirect::to('page/pos');
			} 
		}
			 
		$this->pos();
		
	}
	public function print_r()
	{
	 	$this->view->load('page/print','page/print/print');
	}
	 
}

