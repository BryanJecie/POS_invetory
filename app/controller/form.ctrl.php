<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
class FormController extends Controller
{
	public function __construct()
	{	

		// switch (App::$auth->data()->user_role) {
		// 	case 'cashier':
		// 		Redirect::to('cashier');
		// 		break;
			
		// 	case 'queue':
		// 		Redirect::to('queue');
		// 		break;
		// }
	 
		// if (!App::$auth->isLoggedIn()) {
	 // 		Redirect::to('index/userAuth');
	 // 	}
	 	Parent::__construct();
	}
	public function postProfile()
	{
		$this->loadModel('product');

		if (Input::exist()) {
		 	if (Token::check(Input::get('token'))) {

	 	 		$res = $this->model->insertProductProfile($_POST);
				if ( $res ) {
					// Redirect::to('home/profile');
 	  				Session::setFlash('Item Successfully save');
				}
		 		
		 	}
		} 
	}
}