<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
class Print_Controller extends Controller
{
	public function __construct()
	{	
	 	Parent::__construct();
	}
	public function sales()
	{
		$this->loadModel('reports');

		$invoice          = array();
		$invoice['sales'] = array();


		$start = $this->params[1];
		$end   = $this->params[3];


		$dateStart = strtotime($start);
		$dateEnd   = strtotime($end);

		if($dateStart > $dateEnd){
		 	Session::setFlash('Before ' .date('M. j, Y', strtotime($start)) . ' is not Applicable !');
		}
		else{
			$invoice['sales'] = $this->model->getInvoiceSales(date($start),date($end));
			$invoice['comps'] = $this->model->getCompanyInfo();
		}

		$this->view->load('print','print/print.sales' , [
		 		'title-head' => 'Print Sales',
		 		'invoice'    => $invoice,
		 		'start'  		=> $start,
	 			'end'    		=> $end
		]);
	}
	public function order()
	{
		$this->loadModel('order');
 		$invoice       = array();
 		$orderId = $this->params[1];
		$orders        = $this->model->getOrders($orderId);
	 	// $order_id      = (!empty($order_details[0]->order_id)) ? $order_details[0]->order_id : "" ;
		$ordDetails    = DB::table('order_details')->where(['details_order_id' ,'=', $orderId])->all();

		$invoice['comps'] = $this->model->getCompanyInfo();
 		
		$this->view->load('print','print/print.order' , [
			 		'title-head'    => 'Print Order',
				    'title-content' => 'ORDERS',
			 		'orders'        => $orders,
				    'orDs'          => $ordDetails,
				    'invoice'       => $invoice

			]);
	}
	public function soe($custId = null, $status = null)
	{
		$this->loadModel('order');
 		$invoice          = array();
		$invoice['comps'] = $this->model->getCompanyInfo();
		
		if (is_null($status)) {
			$status = 'all';
		}
		$customer = $this->model->get('customer', ['custom_id', '=',$custId]);

		$orders   = $this->model->get_orders_with_status($custId, $status);
 
		$this->view->load('print','print/print.soe' , [
		 	 	'title-head'    => 'Print Statement of Account',
				'title-content' => 'Statement Of Account',
				'invoice'       => $invoice,
				'customer'      => $customer[0],
				'custId'        => $custId,
				'orders'        => $orders
			]);
	}
	public function stockout_sum($start = null, $end = null)
	{
		$this->loadModel('order');
		$key = null;
		if (!is_null($start) AND !is_null($end)) {
			$key = true;
		}

		$invoice['comps'] = $this->model->getCompanyInfo();
		$stocks = $this->model->load_stockout_summary($start, $end,$key); 
		$this->view->load('print','print/print.stockout.sum' , [
		 	 	'title-head'    => 'Print',
				'title-content' => 'Stockout Summary',
				'invoice'       => $invoice,
				'stocks'        => $stocks,
			]);
	}
	public function supplier_purchased()
	{
 		$this->loadModel('supplier');
 		$invoice['comps'] = Query::getSql()->query("SELECT * FROM company")->all();
 		$gPurchased       = $this->model->getPurchased($this->params[1]);

 		$this->view->load('print','print/print.supplier.invoice' , [
		 	 	'title-head'    => 'Print',
				'title-content' => 'Supplier Invoice',
				'invoice'       => $invoice,
				'gPurchased'    => $gPurchased,

			]);
	}
	public function stockout_hist($start = null, $end = null)
	{
		$this->loadModel('order');
		$invoice['comps'] = $this->model->getCompanyInfo();
		$key = null;
		if (!is_null($start) AND !is_null($end)) {
			$key = true;
		}
		$stocks = $this->model->load_stockout_history($start, $end, $key); 
		$this->view->load('print','print/print.stockout.hist' , [
		 	 	'title-head'    => 'Print',
				'title-content' => 'Stockout History',
				'invoice'       => $invoice,
				'stocks'        => $stocks,
			]);
	}
	public function cashier_reciept($invId = null)
	{
		$this->loadModel('reports');
		$salesDetails = array();
		$invSales = DB::table('
				sales_invoice
				INNER JOIN users ON sales_invoice.user_id = users.user_id
				INNER JOIN personnel ON users.person_id = personnel.person_id
				LEFT JOIN customer ON sales_invoice.custom_id = customer.custom_id
			')->where(['invoice_id', '=', $invId])->first();
		$countItems = 0; 
		if (!empty($invSales)) {
			$salesDetails = $this->model->getSalesDetails($invId);
			foreach ($salesDetails as $val) {
				$countItems += $val->sales_quantity;
			}
		}

		$this->view->load('print/print.reciept','', [
		 	 	'title-head' => 'Print',
		 	 	'invoice'    => $invSales,
		 	 	'invSales'   => $salesDetails,
		 	 	'itemsCount' => $countItems
			]);
	}
}

