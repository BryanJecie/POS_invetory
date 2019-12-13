<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
class OrdersController extends Controller
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
	
	public function new_order()
	{
		$this->loadModel('order');
		
		if (Input::exist()) {
		    if (Token::check(Input::get('token'))) {
	    		$id = $this->model->getOrderMaxId();
	    		if ($id < 1) {
	    			$id = 1;
	    		}
	     		$orderNo =  'ORD'.str_pad($id, 5, '0', STR_PAD_LEFT); 

				$custId = Input::get('supplier');

				Query::select('customer', ['custom_id', '=', $custId]);

				if (Query::count()) {
					
					$totalDisc = 0;
					$custDisc = Query::first()->custom_discount;

					if (!is_null($custDisc) AND $custDisc !=="") {
						$custDisc = Query::first()->custom_discount;
						$discArr  = explode('%', $custDisc);

						if (count($discArr) > 1) {
						  $custDisc = '.'.$discArr[0];		
						}
						
						$totalDisc = (Input::get('grandTotal') * $custDisc) + Input::get('grandTotalDisc'); 
					}
					else{
						$totalDisc = Input::get('grandTotalDisc');
					}
  
					$orderId = $this->model->insertOrder($_POST,  $orderNo,  $totalDisc, true);

					if ($orderId) {
						$order = $this->model->insertOrderDetails($_POST, $orderId , true);
						if ($order) {
							Query::insert('notifications', [
									'order_id'    => $orderId,
									'noti_status' => 'unread',
									'noti_date'   => date('Y-m-d'),
									'noti_time'   => date('H:m:s'),
								]);
							if (Query::count()) {
								Session::setFlash('Customer Orders Successfully Save !');
							}
						}
					}
				}
			 
		    }
		    	
		}

		$customer  = $this->model->loadCustomers();
		$product   = $this->model->getProduct();
		$temp      = $this->model->getTempOrder();
		$this->view->load('default','order/new_order',[
				'title'    => 'ORDER',
				'customer' => $customer,
				'products' => $product,
				'temps'    => $temp
			]);

	}
	public function delete_temp_order()
	{
		$data = array();
		if (Input::exist()) {
			$id = Input::get('tmp_id');

			Query::delete('temp_order',[
					'temp_order_id' , '=' , $id
				]);
			if (Query::count()) {
				$data['key'] = true;
			} 
			else {
				$data['key'] = false;
			}
		}
		echo json_encode($data);
	}
	public function add_temp_order()
	{
		$this->loadModel('order');
		if (Input::exist()) {
			$id = Input::get('purchase_id');

			$temp_order = $this->model->getselectPurchased($id);

			$info = array();

			$data = array();

			foreach ($temp_order as $val) {
				Query::insert('temp_order',[
						'temp_order_price' 	   => $val->stockin_sum_selling_price,
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
	public function manage_order()
	{
		$this->loadModel('order');
		
		$order     = $this->model->getManageOrder();
		$customers = $this->model->loadCustomers();
		$this->view->load('default','order/manage_order',[
				'title'  => 'ORDERS',
				'orders' => $order,
				'customers' => $customers
			]);
	}
	public function manage_invoice_order()
	{
		$this->loadModel('order');
		
		$order = $this->model->getListPurchased();

		$this->view->load('default','order/manage_invoice',[
				'title'  => 'ORDERS',
				'orders' => $order
			]);
	}
	public function view_invoice_order()
	{
		 
		$ordDetails = array();
		$id         = null;
		$action     = null;
	
		$this->loadModel('order');
		 
 
		if (isset($this->params[0]) AND isset($this->params[0])) {
			$id = $this->params[1];

		}
		
		if (isset($this->params[2]) AND isset($this->params[3]) AND $this->params[3] === 'confirm') {
		 
			$ordDId    = $id;
			$ordDetail = DB::table('order_details')->where(['details_order_id' ,'=', $ordDId])->all();
		 
			foreach ($ordDetail as $detail) {
				$totalS   = 0;
				$sumInfo  = $this->model->loadProductSumary($detail->product_id);
				if (!empty($sumInfo)) {
					$sId    = $sumInfo[0];
					$sQ     = $sumInfo[1];
					$sQSP   = $sumInfo[2];
					$sQBP   = $sumInfo[3];
					$bCode  = $sumInfo[4];
					$Qtype  = $sumInfo[5];

					$totalS = ($sQ - $detail->details_order_quantity); 

					$this->model->update('stockin_summary', 'stock_sum_id', $sId, [
							'stockin_sum_selling_quantity' => $totalS
						]);

					if ($this->model->count()) {
						$this->model->post('stockout_summary',[
							    'stockout_quantity' 	 => $detail->details_order_quantity, 
							    'stockcout_date' 	     => date('Y-m-d'), 
							    'stockout_quantity_type' => $detail->details_order_type, 
							    'stockout_selling_price' => $detail->details_order_price, 
							    'stockout_status' 		 => 'stockout', 
							    'barcode_id'             => $bCode
							]);
					}
				}
			}

			Query::update('orders','order_id', $this->params[1] ,[
				'order_status' => $this->params[3],
				'order_bill'   => _get_sum_order_details($ordDId)
			]);
			
			if (Query::count()) {
				Redirect::to('orders/view_invoice_order/?ordId='.$this->params[1]);
				

				Session::setFlash('This order is '.'<b>'. ucwords($action).'</b>');
			}
		}
		
		if (isset($this->params[3]) AND $this->params[3]  === 'paid') {
			
			$orderId = $this->params[1];
			 
			// $sMinId  = $this->model->getSalesMaxInvoice();
			$saleId  = ($this->model->getSalesMaxInvoice() < 1) ? 1 : $sMinId;
			$invNo   = 'SIN-'.str_pad($saleId, 4, '0', STR_PAD_LEFT);

			$orders = $this->model->get('orders' , ['order_id', '=', $orderId])[0];

			$totalAmnt = Input::get('pTotal');
			$inputAmnt = Input::get('pAmount');

			if (!empty($orders)) {

				$custId  = $orders->custom_id;
				$payable = ($orders->order_bill - $orders->order_discount);

				 
				$payPartial = $this->model->loadSumSalesPartial($orderId);

				if (!is_null($payPartial)) {
					
					$totalPartial = $inputAmnt + $payPartial->total_partial;
					$totalInp = 0;
					if ($totalPartial < $payable ) {
						$totalInp = $inputAmnt;
					}
					else{
						$totalInp = $totalAmnt;
						$this->model->update('orders', 'order_id' ,  $orderId, ['order_payment_status' => 'paid']);
					}

					$this->model->post('sales_partial',[
							'partial_date'   => date('Y-m-d'),
							'partial_amount' => $totalInp,
							'invoice_id'     => $payPartial->invoice_id,
							'order_id'       => $orderId
						]);
					if ($this->model->count()) {
						Redirect::to('orders/view_invoice_order/?ordId='.$orderId);	 
					}	
				}
				else{

					$totalInp = 0;
					if ($inputAmnt < $payable) {
                   		$totalInp = $inputAmnt;
					}
					else{
						$totalInp = $totalAmnt;
						$this->model->update('orders', 'order_id' ,  $orderId, ['order_payment_status' => 'paid']);
					}

					$this->model->post('sales_invoice', [
               				'invoice_no' 		   => $invNo,
               				'invoice_date' 		   => date('Y-m-d'),
               				'invoice_time' 		   => date('H:m:s'),
               				'invoice_status'       => 'purchase',
               				'invoice_total_amount' => $totalAmnt,
               				'invoice_discount'     => Input::get('dTotal'),
               				'invoice_input_amount' => $totalInp,
               				'user_id' 			   => App::$auth->data()->user_id,
               				'custom_id'            => $custId,
               			]);	

					if ($this->model->count()) {
						$invoiceId = $this->model->lastInsertId();
				        $details   = $this->model->loadOrderDetails($orderId);
           				if (!is_null($details)) {
		                	foreach ($details as $detail) {
            					$this->model->post('sales', [
            							'sales_quantity' 	  => $detail->details_order_quantity,
            							'sales_quantity_type' => $detail->details_order_type,
            							'stock_sum_id'        => $detail->stock_sum_id,
            							'invoice_id' 		  => $invoiceId,
            						]);	 	  
		                	} 
           				}
           				$this->model->post('sales_partial', [
           					'partial_date'   => date('Y-m-d'),
           					'partial_amount' => $totalInp,
           					'invoice_id'     => $invoiceId,
           					'order_id'       => $orderId,
           				]);
						if ($this->model->count()) {
							Redirect::to('orders/view_invoice_order/?ordId='.$orderId);	
						}
           			}	
				}

			}
			 
		} 

		$order_details = $this->model->getOrders($id);
		$partialPay    = DB::table('sales_partial')->where(['order_id', '=', $id])->all();
		 
		$this->view->load('default','order/view_manage_order',[
				'title'		  => 'ORDERS',
				'ord_details' => $order_details,
				'orderId'     => $id,
				'partialPay'  => $partialPay,
			]);
	}
	public function post_add_order()
	{
		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
			    $this->loadModel('order');
				$orderId  = $this->params[1];
				$barcode  = explode('-', Input::get('barcode'))[0];
				$quantity = Input::get('quantity');

				$stocks = DB::table("
						barcode INNER JOIN product_stockin 
						ON product_stockin.barcode_id = barcode.barcode_id
					")->where(['barcode', '=', $barcode])
				      ->get();


				if (!is_null($stocks->stockin_selling_quantity) AND $stocks->stockin_selling_quantity !== 0) {

					$price = $stocks->stockin_selling_price;


					$this->model->post('order_details', [
							'details_order_id'       => $orderId,
							'details_order_type'     => $stocks->stockin_selling_type,
							'details_order_quantity' => $quantity,
							'details_order_price'    => $stocks->stockin_selling_price,
							'product_id'             => $stocks->product_id,
						]);

					if ($this->model->count()) {
						Redirect::to('orders/view_invoice_order/?ordId='.$orderId);
					}
				}    

				 
			}
		}
	}
	public function new_order_submit()
	{	
		$this->loadModel('order');

		$id = $this->model->getOrderMaxId();
		if ($id < 1) {
			$id = 1;
		}
 		$orderNo =  'ORD'.str_pad($id, 5, '0', STR_PAD_LEFT); 

		if (Input::exist()) {
			if (Input::get('form-purchased') == 'purchase') {
				// echo "<pre>";
				// print_r($_POST);
				$custId = Input::get('supplier');

				Query::select('customer', ['custom_id', '=', $custId]);

				if (Query::count()) {
					
					$totalDisc = 0;
					$custDisc = Query::first()->custom_discount;

					if (!is_null($custDisc) AND $custDisc !=="") {
						$custDisc = Query::first()->custom_discount;
						$discArr  = explode('%', $custDisc);

						if (count($discArr) > 1) {
						  $custDisc = '.'.$discArr[0];		
						}
						
						$totalDisc = (Input::get('grandTotal') * $custDisc) + Input::get('grandTotalDisc'); 
					}
					else{
						$totalDisc = Input::get('grandTotalDisc');
					}
					

  
					$orderId = $this->model->insertOrder($_POST,  $orderNo,  $totalDisc, true);

					if ($orderId) {
						$order = $this->model->insertOrderDetails($_POST, $orderId , true);
						if ($order) {
							Query::insert('notifications', [
									'order_id'    => $orderId,
									'noti_status' => 'unread',
									'noti_date'   => date('Y-m-d'),
									'noti_time'   => date('H:m:s'),
								]);
							if (Query::count()) {
								Redirect::to('orders/new_order');
							}
						}
					}
				}

				
			}
		}
	}
	public function postOrderStatus()
	{
		$data = array();

		if (Input::exist()) {
			switch (Input::get('action')) {
				case 'confirm':

					$this->loadModel('order');

					$ordinfo   = $this->model->getOrders(Input::get('ordNo'));
					$ordDId    = (!empty($ordinfo[0]->order_id)) ? $ordinfo[0]->order_id : null;
					$ordDetail = DB::table('order_details')->where(['details_order_id' ,'=', $ordDId])->all();
					
					foreach ($ordDetail as $detail) {
						$totalS   = 0;
						$sumInfo  = $this->model->loadProductSumary($detail->product_id);
						if (!empty($sumInfo)) {
							$sId    = $sumInfo[0];
							$sQ     = $sumInfo[1];
							$bCode  = $sumInfo[4];
							$totalS = ($sQ - $detail->details_order_quantity); 
							
							$this->model->update('stockin_summary', 'stock_sum_id', $sId, [
									'stockin_sum_selling_quantity' => $totalS
								]);
							if ($this->model->count()) {
								$this->model->post('stockout_summary',[
									    'stockout_quantity' 	 => $detail->details_order_quantity, 
									    'stockcout_date' 	     => date('Y-m-d'), 
									    'stockout_quantity_type' => $detail->details_order_type, 
									    'stockout_selling_price' => $detail->details_order_price, 
									    'stockout_status' 		 => 'stockout', 
									    'barcode_id'             => $bCode
									]);
							}
						}
					}
					Query::update('orders','order_id', Input::get('ordNo'), ['order_status' => Input::get('action')]);
					
					if (Query::count()) {
						$data['key'] = true;
					}

					break;
				case 'cancel':
				 	Query::update('orders','order_id' , Input::get('ordNo'), [
							'order_status' => 'cancel'
						]);
					if (Query::count()) {
				 		$data['key'] = true;
					}
					break;
			}
		}

		echo json_encode($data);
	}
	public function view_invoice_customer_order($custId = null, $request = array())
	{
		if (is_null($custId)) {
			Redirect::to('orders/manage_order');
		}
		$status = '';
		$cOrders = array();

		$this->loadModel('order');
		
		if (Input::get('payment_status')) {
			$status     = Input::get('payment_status');
			$stat_opt   = Input::get('payment_status');
		}
		else{
			$status     = 'all';
			$stat_opt   = '';
		}

		$pay_stats = $this->model->get_orders_with_status($custId, $status);

		if (!is_null($pay_stats)) {
			$cOrders['status'] = $pay_stats;	
		}

		$customers = $this->model->get('customer', ['custom_id', '=',$custId]);

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
		       
		       $sMinId  = $this->model->getSalesMaxInvoice();
		       $saleId  = ($sMinId < 1) ? 1 : $sMinId;
		       $invNo   = 'SIN-'.str_pad($saleId, 4, '0', STR_PAD_LEFT);

			   $custOrderPay = $this->model->get_order_status_to_pay($custId);

			   if ( !is_null($custOrderPay) ) {
			   	
			   		$inputAmnt   = Input::get('pay-amount');
			   		$gTotalOrder = Input::get('gTotalOrder');
			   		$pay_stat = '';
			   		$totalPay = 0;

			   		foreach ($custOrderPay as $order) {
			   			
			   			$totalPartial = $this->model->loadSumSalesPartial($order->order_id);

			   			if (!is_null($totalPartial)) {

			   				$totalBill  = (($order->order_bill - $order->order_discount) - $totalPartial->total_partial);

			   				if ($inputAmnt < $totalBill ) {
			   					$this->model->post('sales_partial', [
			   						'partial_date'   => date('Y-m-d'),
			   						'partial_amount' => $inputAmnt,
			   						'invoice_id'     => $totalPartial->invoice_id,
			   						'order_id'       => $order->order_id,
			   					]);
			   					if ($this->model->count()) {
			   						 break;
			   					}
			   				}
			   				else{
			   				  
			   					$this->model->post('sales_partial', [
			   						'partial_date'   => date('Y-m-d'),
			   						'partial_amount' => $totalBill,
			   						'invoice_id'     => $totalPartial->invoice_id,
			   						'order_id'       => $order->order_id,
			   					]);
			   					if ($this->model->count()) {
									$this->model->update('orders', 'order_id' ,  $order->order_id, ['order_payment_status' => 'paid']);
									$inputAmnt = ($inputAmnt - $totalBill);
									if ($inputAmnt < 1) {
										Redirect::to('orders/view_invoice_customer_order/'.$order->custom_id);
									}
			   					}
			   				}
			   			}
			   			else{
			   				if ($inputAmnt <  $order->total_payable) {
			   				 
			   					$this->model->post('sales_invoice', [
			   							'invoice_no' 		   => $invNo,
			   							'invoice_date' 		   => date('Y-m-d'),
			   							'invoice_time' 		   => date('H:m:s'),
			   							'invoice_status'       => 'orders',
			   							// 'invoice_total_amount' => $inputAmnt,
			   							'invoice_discount'     => $order->order_discount,
			   							'invoice_input_amount' => $inputAmnt,
			   							'user_id' 			   => App::$auth->data()->user_id,
			   							'custom_id'            => $order->custom_id,
			   						]);	
			   					$invoiceId =  $this->model->lastInsertId();
			   				
			   					if ($this->model->count()) {
					              
					                $invDetail = $this->model->loadOrderDetails($order->order_id);
					                if (!is_null($invDetail)) {
					                	foreach ($invDetail as $detail) {
		                					$this->model->post('sales', [
		                							'sales_quantity' 	  => $detail->details_order_quantity,
		                							'sales_quantity_type' => $detail->details_order_type,
		                							'stock_sum_id'        => $detail->stock_sum_id,
		                							'invoice_id' 		  => $invoiceId,
		                						]);	 	  
					                	}
					                }
		   							
					                $this->model->post('sales_partial', [
					                	'partial_date'   => date('Y-m-d'),
					                	'partial_amount' => $inputAmnt,
					                	'invoice_id'     => $invoiceId,
					                	'order_id'       => $order->order_id,
					                ]);
									 
		   							if ($this->model->count()) {
		   								Redirect::to('orders/view_invoice_customer_order/'.$order->custom_id);
		   							}
			   					}
			   				}
			   				else{
			   				 
			   					$inputAmnt = ($inputAmnt - $order->total_payable);
			   				 	
			   					$this->model->post('sales_invoice', [
			   							'invoice_no' 		   => $invNo,
			   							'invoice_date' 		   => date('Y-m-d'),
			   							'invoice_time' 		   => date('H:m:s'),
			   							'invoice_status'       => 'orders',
			   							// 'invoice_total_amount' => $order->total_payable,
			   							'invoice_discount'     => $order->order_discount,
			   							'invoice_input_amount' => $order->total_payable,
			   							'user_id' 			   => App::$auth->data()->user_id,
			   							'custom_id'            => $order->custom_id,
			   						]);	
			   					$invoiceId =  $this->model->lastInsertId();

			   					if ($this->model->count()) {
			   						
					                $invDetails = $this->model->loadOrderDetails($order->order_id);

					                if (!is_null($invDetails)) {
					                	foreach ($invDetails as $detail) {
		                					$this->model->post('sales', [
		                							'sales_quantity' 	  => $detail->details_order_quantity,
		                							'sales_quantity_type' => $detail->details_order_type,
		                							'stock_sum_id'        => $detail->stock_sum_id,
		                							'invoice_id' 		  => $invoiceId,
		                						]);	 	  
					                	}
					                }
					                $this->model->post('sales_partial', [
					                	'partial_date'   => date('Y-m-d'),
					                	'partial_amount' => $order->total_payable,
					                	'invoice_id'     => $invoiceId,
					                	'order_id'       => $order->order_id,
					                ]);

									$this->model->update('orders', 'order_id' ,  $order->order_id, ['order_payment_status' => 'paid']);
			   					}
		   					 	if ($inputAmnt < 1) {
		   							Redirect::to('orders/view_invoice_customer_order/'.$order->custom_id);
		   					 	}
			   				}
			   			}
			   		}
			   }
			}
		}

		$this->view->load('default','order/customer.order',[
				'title'        => 'CUSTOMER ORDER',
				'customOrders' => (isset($cOrders['status'])) ? $cOrders['status'] : $cOrders,
				'customers'    => $customers[0],
				'custId'       => $custId,
				'status'       => $status,
				'stat_opt'     => $stat_opt
			]);
	}
	
	
}

