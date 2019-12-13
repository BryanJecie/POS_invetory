<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : Assessment and Cashiering System with Queue
###  @Copyright    : August 8-1-2016 
###
##
*/
class PosController extends Controller
{
	public function __construct()
	{	
	 	Parent::__construct();
	}
	public function index()
	{
		$this->loadModel('reports');

		$compInfo = $this->model->getCompanyInfo();

		$this->view->load('page/cashier','page/content/cashier-index',[
			'comps' => $compInfo
	 	]);
	}
	public function user_auth($action = null)
	{
		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				$validate = new Validate;
				$valid = $validate->check($_POST , [
 						'username' => [
 							'required'    => true, 
 							// 'user_status' => 'users:online',
 							'role'        => 'user_role:cashier' 
 						],
 						'password' => [
 							'required' => true
 						]
	 	 			]);
		 	 		if ($valid->passed()) {

						$login = App::Auth()->login( Input::get('username'),  Input::get('password') );

		 	 			if ($login) {
							
							Query::update('users','user_id', App::$auth->data()->user_id , ['user_status' => 'online']);

							//   print_r($this->params[1]);
							// return ;

		 	 				if (Query::count()) {

								Session::put(Config::load('utilities/cashier_name'), $this->params[1]);

		 	 					Redirect::to('page/pos/cashier_login?cashier='.App::$auth->data()->username);
		 	 				}
		 	 			} 
		 	 			else {
		 	 				Session::setFlash('Username & Password is incorrect.');
		 	 			}
		 	 		} 
		 	 		else {
		 	 			$er = '';
				 	 	foreach ($valid->errors() as $error){
	 							$er .= ' '.$error.'<br>';
	  			        }
	  			        Session::setFlash($er);
	  			        // Session::delete(Config::load('utilities/cashier_name'));
		 	 		} 
			}
		}
		$this->index();
	}
	public function postLogout()
	{
		
		$auth = new Auth;
		$auth->logout();

		Redirect::to("pos/index/cashier_login?cashier=".Hash::salt(20));
	}
}

