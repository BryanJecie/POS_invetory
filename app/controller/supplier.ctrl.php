<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
class SupplierController extends Controller
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
	public function add_supplier()
	{
		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				Query::insert('supplier',[
						'supplier_company_name' => Input::get('company-name'),
						'supplier_name'         => Input::get('supplier'),
						'supplier_email'        => Input::get('email'),
						'supplier_phone_no'     => Input::get('phone'),
						'supplier_address'      => Input::get('addess')
					]);
				if (Query::count()) {
					Session::setflash('Suppllier Suppllier Save');
				}
			}
		}
	 	$this->view->load('default','purchase/add_supplier',['title'=>'Suppllier']);
	}
	public function manage_supplier()
	{

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				Query::update('supplier','supplier_id', Input::get('sup-id'),[
						'supplier_company_name' => Input::get('sup-comp'),
						'supplier_name' 		=> Input::get('sup-name'),
						'supplier_email' 		=> Input::get('sup-email'),
						'supplier_phone_no' 	=> Input::get('sup-phone'),
						'supplier_address' 		=> Input::get('sup-add')
					]);
				if (Query::count()) {
					 Session::setFlash("Suppllier Update");
				}
			}
		}

		$this->loadModel('supplier');

		$suppliers = $this->model->getSupplier();

	 	$this->view->load('default','purchase/manage_supplier',[
	 		'title'=>'Manage Suppllier',
	 		'suppliers'=> $suppliers

	 	]);
	}
	public function new_purchase()
	{
	 	$this->view->load('default','purchase/create_purchase',['title'=>'Manage Purchase']);
	}
	public function purchase_history()
	{
	 	$this->view->load('default','purchase/purchase_history',['title'=>'Manage Purchase']);
	}
	public function updateSuppler()
	{
		if (Input::exist()) {
				// echo "<pre>";
				// print_r($_POST);
				Query::update('supplier','supplier_id', Input::get('sup-id'),[
						'supplier_company_name' => Input::get('sup-comp'),
						'supplier_name' 		=> Input::get('sup-name'),
						'supplier_email' 		=> Input::get('sup-email'),
						'supplier_phone_no' 	=> Input::get('sup-phone'),
						'supplier_address' 		=> Input::get('sup-add')
					]);
		}
	}
	public function deleteSupplier()
	{
		$data = array();
		if (Input::exist()) {
			Query::delete('supplier', ['supplier_id', '=', Input::get('suppplierId')]);
			if ( Query::count() ) {
				$data['key'] = true;
			}
			else {
				$data['key'] = false;
			}
		}
		echo json_encode($data);
	}
 	public function new_invoice()
 	{
		if (Input::exist()) {
			
			$this->loadModel('supplier');

			if (Token::check(Input::get('token'))) {
	  			
	  			$id = $this->model->getPurchasedMaxId();
	  			
	  			if ($id < 1 OR is_null($id)) {
	  				$id = 1;
	  			}
 				$orderNo =  'PUR'.str_pad($id, 5, '0', STR_PAD_LEFT); 

 				$orderId = $this->model->insertPurchased($_POST, $orderNo , true);
 				 
 				if ($orderId) {
 				 
 					$order = $this->model->insertPurchasedDetails($_POST, $orderId , true);

 					if ($order) {
 						Query::insert('notifications', [
 								'pur_id'    => $orderId,
 								'noti_status' => 'unread',
 								'noti_date'   => date('Y-m-d'),
 								'noti_time'   => date('H:m:s'),
 							]);
 						if (Query::count()) {
 							Session::setFlash('Purchased Successfully Save !');
 							// Redirect::to('supplier/new_invoice');
 						}
 					}
 				}
			}
			elseif (Input::get('add-product')) {
			    $insert = $this->model->insertTempPurchased($_POST);
				if ($insert) {
					Redirect::to('supplier/new_invoice');
				}
			}
		}
		$this->loadModel('order');

		$supplier  = $this->model->loadSupplier();
		$product   = $this->model->getProduct();
		$temp      = $this->model->getTempOrder();

 		$this->view->load('default','purchase/new.invoice',[
				'title' => 'Invoice',
				'products' => $product,
				'temps' => $temp,
				'supplier' => $supplier
 			]);
 	}
 	public function manage_invoice()
 	{

 		$this->loadModel('supplier');

 		$purchases = $this->model->loadPurchased();

 		$this->view->load('default','purchase/manage.invoice',[
				'title'    => 'Manage Invoice',
				'purchase' => $purchases
 			]);
 	}
 	public function add_temp_purchase()
 	{
		$data = array();

 		if (Input::exist()) {
 			$this->loadModel('order');

	 		$id = Input::get('purchase_id');

			$temp_order = $this->model->getselectPurchased($id);

			$info = array();

			foreach ($temp_order as $val) {
				Query::insert('temp_order',[
						'temp_order_price' 	   => $val->stockin_sum_buying_price,
						'temp_order_quantity'  => 1,
						'product_id'		   => $id,
						'temp_order_quan_type' => $val->stockin_sum_selling_type
					]);
			}
			if (Query::count()) {
				$data['key'] = true; 
			}
			else {
				$data['key'] = false; 
			}
 		}
		echo json_encode($data);
 	}
 	public function add_new_purchased()
 	{
 		if (Input::exist()) {
 			
 			$this->loadModel('supplier');
 			 
 			$id = $this->model->getPurchasedMaxId();
 			if ($id < 1 OR is_null($id)) {
 				$id = 1;
 			}

			if (Input::get('form-purchased') == 'purchase') {

				$orderNo =  'PUR'.str_pad($id, 5, '0', STR_PAD_LEFT); 

				$orderId = $this->model->insertPurchased($_POST, $orderNo , true);
				 
				if ($orderId) {
				 
					$order = $this->model->insertPurchasedDetails($_POST, $orderId , true);
					if ($order) {
						Query::insert('notifications', [
								'pur_id'    => $orderId,
								'noti_status' => 'unread',
								'noti_date'   => date('Y-m-d'),
								'noti_time'   => date('H:m:s'),
							]);
						if (Query::count()) {
							Redirect::to('supplier/new_invoice');
						}
					}
				}
			}
 		}
 	}
 	public function view_manage_invoice($purId = null)
 	{

 		if (is_null($purId)) {
  		    Redirect::to('supplier/manage_invoice');
 		}

 		$this->loadModel('supplier');
 		
 		if (Input::exist()) {
 			if (Token::check(Input::get('token'))) {
 				
 				Query::select('purchased', ['pur_id', '=', $purId ]);

 				if (Query::count()) {
 					foreach (Query::result() as $pur) {
 						
 						Query::insert('payment_purchased', [
 								'pay_pur_date' => date('Y-m-d'),
 								'pay_amount'   => $pur->purchase_total_amount,
 								'pur_id'       => $purId   
 							]);

 						if (Query::count()) {
 							Query::update('purchased','pur_id', $purId,[
 									'purchase_payment_status' => 'paid',
 								]);
 							if (Query::count()) {
 								Session::setFlash("Invoice Paid");
 							}
 						}
 					}
 				}
 			}
 		}
 		
 		$gPurchased = $this->model->getPurchased($purId);

 		$this->view->load('default','purchase/view.manage.invoice',[
				'title'    => 'View Manage Invoice',
				'gPurchased' => $gPurchased,
 			]);
 		
 	}

}

