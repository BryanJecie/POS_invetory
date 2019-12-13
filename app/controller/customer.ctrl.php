<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
class CustomerController extends Controller
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
	
	public function manage_customer( $id = null)
	{
		$this->loadModel('customer');
		
		$customs = $this->model->getCustomer();

		$this->updateCustomerInfo();

	 	$this->view->load('default','customer/manage_customer',[
	 			'title'   => 'Manage Customer',
		 		'customs' => $customs,
	 		]);

	 	if (!is_null($id)) {
			Query::delete('customer',['custom_id', '=', $id]);
			if (Query::count()) {
				// Redirect::to('customer/manage_customer');
				Session::setFlash('Customer Successfully deleted');
			}
		 } 
	}
	public function new_customer()
	{
		$this->loadModel('customer');

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				
				$disc  = ''; 

				for ( $i=0; $i < strlen(Input::get('discount')) ; $i++) { 
					if (Input::get('discount')[$i] === '%') {
						$discArr = explode(Input::get('discount')[$i], Input::get('discount'));
						$disc    = '.'.$discArr[0];
					}
					else if(Input::get('discount')[$i] === '.'){
						$disc = Input::get('discount');
					}
				}

				Query::insert('customer',[
						'custom_no'			=> Input::get('cus_no'),
						'custom_firstname'	=> Input::get('first'),
						'custom_lastname'	=> Input::get('last'),
						'custom_address'	=> Input::get('address'),
						'custom_birthdate'	=> Input::get('birthdate'),
						'custom_discount'	=> $disc,
						'custom_email'		=> Input::get('email'),
						'custom_phone'		=> Input::get('phone'),
						'register_date'		=> date('Y-m-d H:m:s')
					]);
				if (Query::count()) {
					Session::setFlash('Customer Successfully save');
				} 
			}
		}


		$maxID   = $this->model->getCustomMaxID();
	  
		foreach ($maxID as $ids) 
				$id = $ids;
		  
	 	$this->view->load('default','customer/new_customer',[
		 		'title' => 'New Customer',
		 		'id'    => $id+=1
	 		]);
	}
	public function updateCustomerInfo()
	{
		if (Input::exist()) {
			// if (Token::check(Input::get('token'))) {
				$update = $this->model->updateCustomer($_POST);
				if ($update) {
					Redirect::to('customer/manage_customer');
					// Session::setFlash('Customer Successfully Update');
				}
			// }
		}
	}
	 
	 
}

