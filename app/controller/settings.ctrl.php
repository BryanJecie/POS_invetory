<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
class SettingsController extends Controller
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
	public function business_profile()
	{
		$this->loadModel('settings');
		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				$comp_id = Input::get('comp-id');
				if (!is_null(Input::get('comp-id')) AND $comp_id != "") {
					Query::update('company','comp_id', Input::get('comp-id'),[
							'comp_name'       => Input::get('comp-name'),
							'comp_email'      => Input::get('comp-email'),
							'comp_abbr'      => Input::get('comp-abbr'),
							'comp_address' 	  => Input::get('comp-address'),
							'comp_start_date' => Input::get('comp-date'),
							'comp_phone'      => Input::get('phone'),
						]);
					if (Query::count()) {
						Session::setFlash('Company Infortaion Update');
					}
				}
				else{
					Query::insert('company',[
							'comp_name'       => Input::get('comp-name'),
							'comp_abbr'       => Input::get('comp-abbr'),
							'comp_email'      => Input::get('comp-email'),
							'comp_address' 	  => Input::get('comp-address'),
							'comp_start_date' => Input::get('comp-date'),
							'comp_phone'      => Input::get('phone'),
						]);
					if (Query::count()) {
						Session::setFlash('Company Save');
					}
				}
		 		if (Input::get('image-file')){

		 			$folder = PUBLIC_PATH.'images/company/'.$comp_id;

		 			if ( !file_exists($folder) ){
						mkdir( $folder, 0777, true );
						
		 			}
		 			else {
		 				$folder = PUBLIC_PATH.'images/company/'.$comp_id;

		 			}

		 			App::$image->upload_image($folder, Input::get('image-file') ,true );
			 	}
			}
		}
		$comp = $this->model->getCompanyInfo();

	 	$this->view->load('default','settings/business_profile',[
	 			'title'	=> 'Settings',
	 			'comp'  => $comp
	 		]);
	}
	public function control_panel()
	{
		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
			 	
			}
		}
	 	$this->view->load('default','settings/control.panel',[
 			'title'	=> 'Settings',
 		]);
	} 
}

