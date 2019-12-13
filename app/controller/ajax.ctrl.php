<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
class AjaxController extends Controller
{
	public function __construct()
	{	
	 	// Parent::__construct();
	}
	 
	public function getCustomerList()
	{
		$this->loadModel('search');
		
		$customers = $this->model->customersList();
		
		$data = array();

		if ( !is_null($customers) AND is_array($customers) ) {

			foreach ($customers as $customer) {
				$data['cus_id'][] =  $customer->custom_id;
				$data['names'][]  =  '['.$customer->custom_no.'] - '.ucwords($customer->custom_lastname.' '.$customer->custom_firstname);
			}
		}
	 	echo json_encode($data);
	}
	public function searchProduct()
	{
		$this->loadModel('search');
		
		$value = Input::get('value');
		
		$search = $this->model->getSearchProduct($value);
		
		$data = array();

	 	
	  
 	 	if (!is_null($search) AND is_array($search)) {
 	 		$label  = 'primary';
 	 		$status = 'Available';
 	 		foreach ($search as $val) {
 	 			if ($val->stockin_sum_quantity < 1) {
 	 				$label  = 'danger';
 	 				$status = 'Unavailable';
 	 			}
 	 			$data['tr'][] = "<tr>
		 						 	<td>{$val->product_name}</td>
		 						 	<td>{$val->barcode}</td>
		 						 	<td>{$val->stockin_sum_quantity}  {$val->stockin_sum_quantity_type}</td>
		 						 	<td><b>".number_format($val->stockin_sum_selling_price ,2)."</b></td>
		 						 	<td><label class='label label-".$label." label-xs'>".$status."</label></td>
		 						 	<td>
		 						 		<button value='".$val->product_id."' class='btn btn-primary btn-xs btn-item-add'>
		 						 			<i class='fa fa-plus'></i>
		 						 		</button>
		 						 	</td>
		 					    </tr>";
 	 		}

 			$data['object'] = $search[0];

 			$data['key'] = true;
 	 	} else { 
 	 		$data['key'] = false;
 	 	}

	 	echo json_encode($data);
	}
	public function getProductSelect()
	{
		if (Input::exist()) {
			$product_id = Input::get('product_id');


		}
	}
	public function getSelectSearch()
	{
		$this->loadModel('search');

		$product_id = Input::get('prod_id');

		$object = $this->model->getSelectProduct($product_id);

		$data = array();

	 	if (!is_null($object) AND is_array($object)) {
	 		$data['obj'] = $object;
	 		foreach ($object as $val) {
	 			Query::insert('tempSales',[
	 					'stockSumId'      =>  $val->stock_sum_id,
	 					'barcode'         =>  $val->barcode,
	 					'productPrice'    =>  $val->stockin_sum_selling_price,
	 					'productName'     =>  $val->product_name,
	 					'productQuantity' =>  1,
	 					'quantityType'    =>  $val->stockin_sum_selling_type
	 				]);
	 			if (Query::count()) {
	 				$data['tr'] =  '<tr class="odd gradeX purch-tr">
			                            <td><span class="p-text">'.$val->product_name.'</span></td>
			                            <td><span class="p-text">'.$val->barcode.'</span></td>
			                            <td>
			                            	<input style="text-align:right"  class="form-control input-inline input-sm input-pur-quan" type="text" value="1">
			                            	<select class="form-control input-inline input-sm" name="gender" readonly>
		                                        <option value="pcs">Pcs</option>
		                                        <option value="kilo">Kls</option>
		                                        <option value="box">Box</option>
		                                        <option value="box">Met</option>
		                                        <option value="inches">Inch </option>
		                                        <option value="centimeter">Cm</option>
		                                    </select>
			                            </td>
			                            <td>
                                            <input type="text" class="form-control pull-right input-sm" style="width: 30%; text-align: right;" name="" value="" placeholder="0.00">
			                            </td>
			                            <td>
			                            	<input style="text-align:left" class="form-control input-inline input-sm input-pur-quan" id="input-price" type="text" value="'.number_format($val->stockin_sum_selling_price,2).'">
			                            </td>
			                            <td style="text-align: right">
			                            	<button value="" type="button" class="btn btn-danger btn-xs btn-purchased-delete">
			                            		<i class="fa fa-trash"></i>
			                            	</button>
			                            </td>
			                        </tr>';
	 			}
	 			
	 		}

	 		// number_format(number)
	 	}
	 	echo json_encode($data);
	}
	public function getBrandName()
	{
		$this->loadModel('product');
		
		$data = array();
		

		if (Input::exist()) {
			
			$type_id = Input::get('cat_id');
			 
			$type = $this->model->get_brand($type_id);

			if (!is_null($type) AND is_array($type)) {
				$data['key']  = true;
				foreach ($type as $brand) {
					$data['type'][] = '<option value="'.$brand->brand_id.'">'.ucwords($brand->brand_name).'</option>';
				}
			} else {
				$data['key']  = false;
			}

		}
		echo json_encode($data);
	}
	public function postProductType()
	{
		$this->loadModel('product');

		$form 	= Input::get('form');
		$data 	= array();
		$varia  = array();

		
		// createProductInput
		if (Input::exist()) {

			foreach ($form as $key => $value) {
				if ($value['name'] == 'p-code') {
					$varia['code'] = $value['value']; 
				} elseif($value['name'] == 'p-name'){
					$varia['name'] = $value['value'];
				} elseif ($value['name'] == 'p-subname') {
					$varia['subname'] =$value['value']; 
				} elseif ($value['name'] == 'p-barcode') {
					$varia['barcode'] =$value['value'];
				} elseif ($value['name'] == 'p-desc') {
					$varia['desc'] =$value['value'];
				} elseif ($value['name'] == 'p-brand') {
					$varia['brand'] =$value['value'];
				} elseif ($value['name'] == 'p-selling-price') {
					$varia['selling'] =$value['value'];
				} elseif ($value['name'] == 'p-quantity') {
					$varia['quantity'] =$value['value'];
				} elseif ($value['name'] == 'p-quan-type') {
					$varia['quan-type'] =$value['value'];
				} else {
					$varia['buying'] =$value['value'];
				}
			}
			$res = $this->model->createProductInput($varia);




			if ($res) {
				$data['key'] = true;
			} else {
				$data['key'] = false;

			}
		}
		echo json_encode($data);
	}
	public function deleteTempOrder()
	{
		$this->loadModel('product');

		$this->model->getDeleteTempOrder();
	}
	public function orderQuantityUdate( )
	{
		$data = array();
		if (Input::exist()) {
			$tempId   = Input::get('tempId');
			$inputVal = Input::get('inputVal');

			Query::update('temp_order', 'temp_order_id' , $tempId ,[
					'temp_order_quantity' => $inputVal
				]);
			if (Query::count()) {
				$data['key'] = true;
			}
			else{
				$data['key'] = false;
			}
		}
		echo json_encode($data);
	}
	public function orderDiscountUpdate( )
	{
		$data = array();
		if (Input::exist()) {
			$tempId   = Input::get('tempId');
			$inputVal = Input::get('inputVal');

			Query::update('temp_order', 'temp_order_id' , $tempId ,[
					'temp_order_discount' => $inputVal
				]);
			if (Query::count()) {
				$data['key'] = true;
			}
			else{
				$data['key'] = false;
			}
		}
		echo json_encode($data);
	}
	public function update_temp_purchased( )
	{
		$data = array();
		if (Input::exist()) {
			$tempId   = Input::get('tempId');
			$inputVal = Input::get('inVal');

			Query::update('temp_order', 'temp_order_id' , $tempId ,[
					'temp_order_price' => $inputVal
				]);
			if (Query::count()) {
				$data['key'] = true;
			}
			else{
				$data['key'] = false;
			}
		}
		echo json_encode($data);
	}
	public function postDeletePurchase()
	{
		$data = array();
		
		$this->loadModel('cashier');

		$tempSales = $this->model->getTempPurcahse();

		if (Input::exist()) {
			
			$salesId = Input::get('salesId');

			Query::delete('tempSales', [
					'salesId', '=', $salesId
				]);

			if (Query::count()) {
				$data['key'] = true;

				foreach ($tempSales as $listSales) {
					$data['list'] = $listSales; 
				}

				// $data['list']
				 
			}
		}
		echo json_encode($data);
	}
	public function getPurchaseList()
	{
		$this->loadModel('cashier');
		
		$items = array(); 

		$tempSales = $this->model->getTempPurcahse();

		if (!empty($tempSales) AND is_array($tempSales)) {
			foreach ($tempSales as $sales) {
				$items['key']  = true; 
			 	$items['list'][] = [
			 		$sales->productName, 
			 		'<span class="pull-right">'.$sales->barcode.'</span>', 
			 		'<span class="pull-right">
						<input type="text" class="form-control input-inline input-xs inputQuantity" name="quantity" style="width: 40px;height:25px;text-align:right" value="'.$sales->productQuantity.'" placeholder="">
						<input type="text" class="form-control input-inline input-xs" name="type" style="width: 35px;height:25px;" value="'.$sales->quantityType.'" readonly="">
			 		</span>',
	 		 		'<span class="pull-right">
	 					<input type="text" class="form-control input-inline input-xs discount" name="discount" dval="'.$sales->salesId.'" style="width: 40px;height:25px;text-align:right" value="'.$sales->discount.'" placeholder="0">
	 		 		</span>',
	 		 		'<span class="pull-right">
	 					<input type="text" class="form-control input-inline input-xs" name="price" style="width:45px;height:25px;" value="'.$sales->productPrice.'" readonly="">
	 		 		</span>',
	 		 		'<button value="" type="button" class="btn btn-danger btn-xs btnPurchaseDelete" style="margin-left:20px;" cval="'.$sales->salesId.'">
                 		<i class="fa fa-trash"></i>
                	</button>'
			 	];
			}
		}
		else{
			$items['key']  = false; 
			$items['list'][] = ["","","","","",""];
		}
		 
		echo json_encode($items);
	}
	public function getTotalValue()
	{
		$data = array();
		
		if (Input::exist()) {
			if (Input::get('action') === 'getVal') {
		
				$this->loadModel('cashier');

				$tempSales = $this->model->getTempPurcahse();
				$gTotal = 0;

				if (!empty($tempSales) AND is_array($tempSales)) {
					
					$sum         = 0;
					$disc        = 0;
					$total       = 0;
					$qty         = 0;
					$percent     = 0;
					$data['key'] = true; 
					$totalSum = 0;
					$totalDisc = 0;
					foreach ( $tempSales as $sale ) {

						$sum     = $sale->productPrice * $sale->productQuantity;
						
						if (!is_null($sale->discount)) {
							$disc = $sale->discount;
							$totalDisc += $sale->discount;
						}
						
						$totalSum  = $sum - $disc;
						$total   +=  $totalSum ;
						$qty     +=  $sale->productQuantity;

						
					}
					if (Input::get('customNo') !== null AND Input::get('customNo') !== "" ) {
					
						$custInfo = DB::table('customer')->where(['custom_no', '=', Input::get('customNo')])->get();

						if (!empty($custInfo)) {
							$percent = $totalSum + ((double)$custInfo->custom_discount * $total);
							$gTotal  = ($total - $percent);
						}
					}
					else{
						$gTotal  = $total;
						$percent = $totalDisc;

					}
					$data['total']  = floatval($total);
					$data['pTotal'] = floatval($percent);
					$data['gTotal'] = floatval($gTotal);
					$data['qty']    = $qty;
				}
				else{
					$data['total'] = number_format(0,2);

					$data['key'] = false; 
				}
			}
		}
		echo json_encode($data);
	}
	public function postCancelPurchase()
	{
		$this->loadModel('cashier');
		
		$data = array();

		if (Input::exist()) {
			
			$salesCancel = $this->model->getTempDelete();

			if ($salesCancel) {
				$data['key'] = true;
			}
			else{
				$data['key'] = false;
			}
		}
		echo json_encode($data);
	}
	public function postPurchasedDiscount()
	{
		$this->loadModel('cashier');
				 
		$data = array();

		if (Input::exist()) {
			 
			Query::update('tempSales','salesId' , Input::get('salesId'), [
			 		'discount' => Input::get('discVal')
			 	]);
			if (Query::count()) {
				$data['key'] = true;
			} 
			else{
				$data['key'] = false;
			}
		}
		echo json_encode($data);
	}
	public function postUpdateQuantity()
	{
		$this->loadModel('cashier');
		 
		$data = array();

		if (Input::exist()) {
			
			 
			Query::update('tempSales','salesId' , Input::get('salesId'), [
			 		'productQuantity' => Input::get('inputVal')
			 	]);
			if (Query::count()) {
				$data['key'] = true;
			} 
			else{
				$data['key'] = false;
			}
		}
		echo json_encode($data);
	}
	public function postPayment()
	{
		$this->loadModel('cashier');
		$snv = 'SIN-';
		$snString = 'SN-';

		$data = array();
		if (Input::exist()) {
			$salesId = $this->model->getSalesMaxInvoice();

			$formPay = Input::get('formPay');
			$cDisc   = Input::get('customDisc') ;


			$data[] = $formPay;
			if ( $salesId  < 1 ) {
				$salesId = 1;
			}
			$no    =  str_pad($salesId, 4, '0', STR_PAD_LEFT); 
			$invNo = $snv.$no;
			
			foreach ($formPay as $name => $value) {
				if ($value['name'] !== "reciept" AND $value['name'] !== 'on') {
					Query::insert('sales_invoice', [
							'invoice_no' 		   => $invNo,
							'invoice_date' 		   => date('Y-m-d'),
							'invoice_time' 		   => date('H:m:s'),
							'invoice_status'       => 'purchase',
							'invoice_total_amount' => Input::get('totalAmount'),
							'invoice_input_amount' => $value['value'],
							'invoice_discount'     => $cDisc,
							'user_id' 			   => App::$auth->data()->user_id,
						]);
				}
			}
			$invId = Query::last_insert_id();
			if (Query::count()) {
				
				foreach ($this->model->getTempPurcahse() as $sale) {
					 
					$snIdMax = ( $this->model->getMaxSalesId()  < 1 ) ? 1 :  $this->model->getMaxSalesId();
					$snId    =  str_pad($snIdMax, 6, '0', STR_PAD_LEFT); 
					$invNo   =  $snString.$snId;

					Query::select('stockin_summary' , ['stock_sum_id', '=', $sale->stockSumId]);

					if (Query::count()) {
						$bcode = Query::first()->barcode_id;
						$price = Query::first()->stockin_sum_selling_price;
						$price = Query::first()->stockin_sum_selling_price;
						$total = Query::first()->stockin_sum_selling_quantity - $sale->productQuantity;

						Query::update('stockin_summary', 'stock_sum_id', $sale->stockSumId, ['stockin_sum_selling_quantity' => $total]);

						Query::insert('sales',[
							'sales_quantity'      => $sale->productQuantity,
							'sales_no'			  => $invNo,
							'sales_discount'      => $sale->discount,
							'sales_quantity_type' => $sale->quantityType,
							'stock_sum_id' 	      => $sale->stockSumId,
							'invoice_id' 		  => $invId
						]);

						Query::insert('stockout_summary',[
							    'stockout_quantity' 	 => $sale->productQuantity, 
							    'stockcout_date' 	     => date('Y-m-d'), 
							    'stockout_quantity_type' => $sale->quantityType, 
							    'stockout_selling_price' => $price, 
							    'stockout_status' 		 => 'stockout', 
							    'barcode_id'             => $bcode
							]);


						$data['key'] = true;						
					}
					else {
						$data['key'] = false;						

					}
				}
				$this->model->getTempDelete();
				$data['invId'] = $invId;
			}
		}
		echo json_encode($data);
	}
	public function searchReturnProduct()
	{
		$this->loadModel('cashier');
		$items = array ();
		if (Input::exist()) {
			$lists = $this->model->listProductReturn(Input::get('value'));
			if (!empty($lists)) {
				foreach ($lists as $key => $list) {
					$items['invno'] = $key;
					foreach ($list as $li) {
						$items['list'][] = '
							<tr>
								<td>
									<div class="checkbox" style="position: absolute; margin:0; margin-left: -10px">
							         <label>
							           <input type="checkbox" class="checkbox-return" name="void[]"" value="'.$li->sales_id.'" >
							           <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
							         </label>
							        </div>
								</td>
								<td style="width:50%">'.ucwords($li->product_name).'</td>
								<td><b>'.$li->barcode.'</b></td>
								<td>
								   <center>
								 	  <input name="qtyType[]" class="qtyType" type="hidden" value="'.$li->sales_quantity_type.'" disabled>
								 	  <input name="product[]" class="product" type="hidden" value="'.$li->product_name.'" disabled>
								 	  <input name="barcode[]" class="barcode" type="hidden" value="'.$li->barcode.'" disabled>
								 	  <input name="salesQty[]" class="salesQty" type="hidden" value="'.$li->sales_quantity.'" disabled>
								 	  <input name="invoiceId[]" class="invoiceId" type="hidden" value="'.$li->invoice_id.'" disabled>
								 	  <input name="sumId[]" class="sumId" type="hidden" value="'.$li->stock_sum_id.'" disabled>
								 	  <input name="return-qty[]" autocomplete="off" type="text" cqty="'.$li->sales_quantity.'" value="'.$li->sales_quantity.'" class="form-control ret-qty" style="width:60%; text-align:center; height:25px;" disabled>
								   </center>
								</td>
							</tr>';  
					}
				}
				$items['key'] = true;
			}
			else{
				$items['key'] = false;
				$items['list'] = '<tr><td colspan="5"><h5>No Invoice Available.<h5></td></tr>';
			}
		}
		echo json_encode($items);
	}
	public function postReturn()
	{	
		$items  = array();
		if (Input::exist()) {
			
			$this->loadModel('cashier');
			
			$salesIdArry   = Input::get('void');
			$returnQtyArry = Input::get('return-qty');
			$remainQty     = Input::get('salesQty');
			$sumIdArry     = Input::get('sumId');
			$invoiceIdArr  = Input::get('invoiceId');
			$productArry   = Input::get('product');
			$barcodeArry   = Input::get('barcode');
			$qtyTypeArry   = Input::get('qtyType');

			if (!empty($salesIdArry)) {
				$salesId = 0;
				$retQty  = 0;
				$sumId   = 0;
				$invId   = 0;
				$tQty    = 0;
				for ($i=0; $i < count($salesIdArry); $i++) { 
					
					$retQty  = $returnQtyArry[$i];
					$sumId   = $sumIdArry[$i];
					$invId   = $invoiceIdArr[$i];
					$tSalesQty    = ($remainQty[$i] - $retQty);
					$tSumQty = (_get_sum_selling_qty($sumId)['qty'] + $retQty);
					$tPrice  = (_get_invoice_total_amount($invId) - (_get_sum_selling_qty($sumId)['price'] * $retQty));

					if ($tSalesQty < 1) {
						Query::delete('sales', ['sales_id', '=', $salesIdArry[$i]]);
					}
					else{
						Query::update('sales', 'sales_id' , $salesIdArry[$i], [
								'sales_quantity' =>  $tSalesQty
							]);
					}
					Query::update('stockin_summary', 'stock_sum_id' , $sumId, [
							'stockin_sum_selling_quantity' =>  $tSumQty
						]);
					if (Query::count()) {
						Query::update('sales_invoice', 'invoice_id' , $invId, [
							'invoice_total_amount' =>  $tPrice
						]);
					}	
					Query::insert('tempSales' , [
							'stockSumId'      => $sumId,
							'barcode'         => $barcodeArry[$i],
							'productPrice'    => _get_sum_selling_qty($sumId)['price'],
							'productName'     => $productArry[$i],
							'productQuantity' => $retQty,
							'quantityType'    => $qtyTypeArry[$i]
						]);
				}

				$items['key'] = true;
			}
		}
		echo json_encode($items);
	}
	public function postSupplierInvoice()
	{
		$this->loadModel('order');
		$data = array();
		if (Input::exist()) {
			
			$status = Input::get('status');

			if (!is_null($status)) {

				// Query::select('orders' , ['order_status','=', $status]);
				
				$notis = $this->model->loadSupplierNotification();

				if (!is_null($notis)) {
					$data['count']  = count($notis);
					foreach ($notis as $pending) {
						$data['key']    =  true;
					 	$data['list'][] =  '<li class="media notiListSupplier">
				                                <a href="javascript:;" cval="'.$pending->pur_id.'">
				                                    <div class="media-left">
				                                    	<i class="fa fa-bell-o media-object bg-red"></i>
				                                    </div>
				                                    <div class="media-body">
				                                        <h6 class="media-heading"><b>'.ucwords($pending->supplier_name).'</b></h6>
				                                         <small>Order No : '.$pending->purchase_no.'</small>
				                                        <div class="text-muted f-s-11">'.date('M. j, Y g:i a', strtotime($pending->purchase_date)).'</div>
				                                    </div>
				                                </a>
				                            </li>';	
					}
					
				}
				else{
					$data['key'] = false;
				}
			}			
		}
		echo json_encode($data);
	}
	public function postPerdingOrder()
	{
		$this->loadModel('order');
		$data = array();
		if (Input::exist()) {
			
			$status = Input::get('status');

			if (!is_null($status)) {

				// Query::select('orders' , ['order_status','=', $status]);
				
				$notis = $this->model->loadNotifications();

				if (!is_null($notis)) {
					$data['count']  = count($notis);
					foreach ($notis as $pending) {
						$data['key']    =  true;
					 	$data['list'][] =  '<li class="media notiList">
				                                <a href="javascript:;" cval="'.$pending->order_id.'">
				                                    <div class="media-left">
				                                    	<i class="fa fa-bell-o media-object bg-red"></i>
				                                    </div>
				                                    <div class="media-body">
				                                        <h6 class="media-heading"><b>'.ucwords($pending->custom_firstname).'</b></h6>
				                                         <small>Order No : '.$pending->order_no.'</small>
				                                        <div class="text-muted f-s-11">'.date('M. j, Y g:i a', strtotime($pending->order_date)).'</div>
				                                    </div>
				                                </a>
				                            </li>';	
					}
					
				}
				else{
					$data['key'] = false;
				}
			}			
		}
		echo json_encode($data);
	}
	public function getSalesToday()
	{
		$items = array();
		if (Input::exist()) {
			$this->loadModel('cashier');
			$sales = $this->model->sales();
			if (!is_null($sales)) {
				$dTotal = 0;
				$gTotal = 0;
				$salesQ = 0;
				$total  = 0;

				foreach ($sales as $sale) {
					$labelClass = ($sale->invoice_status === 'orders') ? 'success' : 'primary';	
					if (is_null($sale->total_amount) OR $sale->total_amount ==="") {
						$total = _get_partial_payme_with_invoice($sale->invoice_id);
					}
					else{
						$total = $sale->total_amount;
					}
					$gTotal += $total;
					$salesQ += $sale->qty;
					$dTotal += $sale->discount;
				 
					$items['list'][] = [
						'<b class="text-info">'.$sale->invoice_no.'</b>',
						$sale->qty,
						date('h:i:s a', strtotime($sale->invoice_time)),
						'<label class="label label-'.$labelClass.'">'.strtoupper($sale->invoice_status).'</label>',
						'<b>'.number_format($sale->discount,2).'</b>',
						'<b style="margin-left:30%;">'.number_format($total,2).'</b>',

					];	
				}
				$items['gSales'] = $salesQ;
				$items['dSales'] = number_format($dTotal,2);
				$items['gTotal'] = number_format($gTotal,2).' <span style="font-size:18px;">&#8369;</span>';
				$items['key'] = true;	
			}			
			else{
				$items['key'] = false;
			}

		}
		echo json_encode($items);
	}
	public function setDiscount()
	{
		$items = array();
		if (Input::exist()) {
			$customNo   = Input::get('customNo');
			$customInfo = DB::table('customer')->where(['custom_no', '=', $customNo])->get();
			if (!empty($customInfo)) {
				$items['obj']  = [
					$customInfo->custom_firstname,
					$customInfo->custom_lastname,
					$customInfo->custom_discount
				];
				$items['key'] = true;
			}
		}
		echo json_encode($items);
	}
	public function loadProductLIst()
	{
		$items = array();
		if (Input::exist()) {
			if (Input::get('action') === 'get') {
				$this->loadModel('cashier');
				
				$products = $this->model->getAllProduct();
				foreach ($products as $prod) {
					$items[] =  '<option value="">'.$prod->product_name.'</option>';
						// $prod->product_name
						// $prod->stockin_sum_selling_price
						// $prod->stockin_sum_status
						// $prod->stockin_sum_selling_quantity
						// $prod->stockin_sum_selling_type
				 
				}
				// $items = ;
			}
		}
		echo json_encode($items);
	}
	public function loadInventory()
	{
		$items = array();
		if (Input::exist()) {
			if (Input::get('action') === 'get') {
				$this->loadModel('cashier');

				$remain = $this->model->retrieveRemainingProduct();
				if (!is_null($remain)) {
					foreach ($remain as $re) {
						$items['item'][] = [
							$re->barcode,
							'<b>'.$re->stockin.'</b>'.' '.ucwords($re->stockin_sum_selling_type),
							'<b>'.$re->stockout.'</b>'.' '.ucwords($re->sales_quantity_type),
							'<b>'.number_format($re->stockin_sum_selling_price,2).'</b>'
						];
					}
					$items['key'] = true;
				}
			}
		}
		echo json_encode($items);
	}
	public function getProductList()
	{

		$this->loadModel('cashier');
		$items   = array();
		$product = $this->model->getAllProduct();
	
		if (!is_null($product)) {
			foreach ($product as $prod) {
				$items[]  = ['['. $prod->barcode .'] '.
					        strtoupper($prod->product_name).' '. 
					        $prod->stockin_sum_selling_quantity.' '.
					        $prod->stockin_sum_selling_quantity.$prod->stockin_sum_selling_type.' '.
					        $prod->stockin_sum_selling_price
					        ]; 
			}
		}
		echo json_encode($items);
	}
	public function load_stockout()
	{
		$items = array();

		$this->loadModel('order');
		if (Input::exist()) {
			if (Input::get('action') === 'get') {
			 	$start = Input::get('start');
			 	$end   = Input::get('end');

			 	$stocks = array();

			 	if ($start !== "" AND $end !== "") {
					$stocks = $this->model->load_stockout_summary($start, $end);
			 	}
			 	else{
			 		$stocks = $this->model->load_stockout_summary(null, null);
			 	}
			 	if (!empty($stocks)) {

				 	$count = 1;
				 	$out = 0;
				 	foreach ($stocks as $stock) {
				 		$items['list'][] = [
				 			$count++,
				 			ucwords($stock->product_name.' '.$stock->product_subname),
				 			'<b class="text-info">'.$stock->barcode.'</b>',
				 			number_format($stock->stockout_selling_price,2),
				 			'<label class="label label-info">'.$stock->item_out.' '.strtoupper($stock->stockout_quantity_type).'</label>',
				 			'<label class="label label-danger">'.strtoupper($stock->stockout_status).'</label>'
				 		];

				 		$out += $stock->item_out;
				 	}
				 	$items['list'][] = ["","","","","<h5>TOTAL OUT</h5>","<h5>".$out."</h5>"];
			 		$items['key'] = true;
			 	}
			 	else{
			 		$items['list'] = array();
			 		$items['key'] = false;
			 	}

			}
		}
		echo json_encode($items);
	}
	public function load_stockout_history()
	{
		$items = array();

		$this->loadModel('order');
		if (Input::exist()) {
			if (Input::get('action') === 'get') {
			 	$start = Input::get('start');
			 	$end   = Input::get('end');
			 	$key   = (Input::get('key') === 'true') ? Input::get('key') : null;

			 	$stocks = array();
			 	 
			 	if ($start !== "" AND $end !== "") {
					$stocks = $this->model->load_stockout_history($start, $end, $key);
			 	}
			 	else{
			 		$stocks = $this->model->load_stockout_history(null, null, $key);
			 	}
			 	if (!empty($stocks)) {

				 	$count = 1;
				 	$out = 0;
				 	foreach ($stocks as $stock) {
				 		$items['list'][] = [
				 			$count++,
				 			ucwords($stock->product_name.' '.$stock->product_subname),
				 			'<b class="text-info">'.$stock->barcode.'</b>',
				 			'<b>'.$stock->stockcout_date.'</b>',
				 			number_format($stock->stockout_selling_price,2),
				 			'<label class="label label-info">'.$stock->stockout_quantity.' '.strtoupper($stock->stockout_quantity_type).'</label>',
				 			'<label class="label label-danger">'.strtoupper($stock->stockout_status).'</label>'
				 		];
				 		$out += $stock->stockout_quantity;
				 	}
				 	$items['list'][] = ["","","","","","<h5>TOTAL OUT</h5>","<h5>".$out."</h5>"];
			 		$items['key'] = true;
			 	}
			 	else{
			 		$items['list'] = array();
			 		$items['key'] = false;
			 	}

			}
		}
		echo json_encode($items);
	}
	public function get_qty_details()
	{
		 $items = array();

		 $this->loadModel('order');
		 if (Input::exist()) {

		 	$qVal  = Input::get('qVal');
		 	$detId = Input::get('detId');

		 	if (is_null($qVal) OR $qVal ==="") {
		 		$qVal = 0;
		 	}
		 	Query::update('order_details', 'details_id', $detId,  [
		 		 'details_order_quantity' => $qVal
		 		]);

		 	if (Query::count()) {
		 		$items['key'] = true;
		 	}
		 	else{
		 		$items['key'] = false;
		 	}

		 }
		 echo json_encode($items);
	}
	public function set_delete_order()
	{
		$items = array();

		$this->loadModel('order');
		
		if (Input::exist()) {
		 	$detId = Input::get('detId');

		 	Query::delete('order_details', ['details_id', '=', $detId]);

		 	if (Query::count()) {
		 		$items['key'] = true;
		 	}
		 	else{
		 		$items['key'] = false;
		 	}

		}
		echo json_encode($items);
	}
	
}