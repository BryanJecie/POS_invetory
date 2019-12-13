<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
class ReportsController extends Controller
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
	public function sales_report()
	{
		$this->loadModel('reports');
		
		$invoice          = array();
		$invoice['sales'] = array();

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				 
				$dateStart = strtotime(Input::get('start'));
				$dateEnd   = strtotime(Input::get('end'));

				if($dateStart > $dateEnd){
				 	Session::setFlash('Before ' .date('M. j, Y', strtotime(Input::get('start'))) . ' is not Applicable !');
				}
				else{
					$invoice['comps'] = $this->model->getCompanyInfo();

					$invoice['sales'] = $this->model->getInvoiceSales(date(Input::get('start')),date(Input::get('end')));

					if (!empty($invoice['sales'])) {
						$saleDet = array();
						$tProfit = 0;
						$tSales = 0;
						$tDiscount = 0;
						$tAmount = 0;
						$tReven = 0;
						foreach ($invoice['sales'] as $sale) {
							$profit = 0;
							$sales = 0;
							$reven = 0;
							$saleDet = $this->model->getSalesDetails($sale->invoice_id);
					 		if (!is_null($saleDet)) {
						 		foreach ($saleDet as $det) {
						 			 $invoice['tbl-sales'][] = [
						 			 	'pName'       => ucwords($det->product_name),
						 			 	'barcode'     => $det->barcode,
						 			 	'quanity'     => $det->sales_quantity,
						 			 	'buyPrice'    => $det->stockin_sum_buying_price,
						 			 	'salePrice'   => $det->stockin_sum_selling_price,
						 			 	'type'        => $det->sales_quantity_type,
						 			 	'totalSales'  => $det->totalSales,
						 			 	'totalDiscount'  => $det->sales_discount,
						 			 	'totalProfit' => $det->totalProfit,
						 			 ];
					 				
					 				$profit += $det->totalProfit;
					 				$sales  += $det->totalSales;
					 				$reven  += $det->totalCost;
						 		}
					 		}
					 		$tProfit   += $profit;
					 		$tSales    += $sales;
					 		$tReven    += $reven;

					 		$tAmount   += $sale->invoice_total_amount; 
					 		$tDiscount += $sale->invoice_discount;
						}
						$invoice['tbl-sales']['total'] = [
							'tProfit' => $tProfit , 'tSales' => $tSales , 'tAmount' => $tAmount, 'tDiscount' => $tDiscount, 'tRevenue' => $tReven, 
						];
					}
				}
			}
		}

	 	$this->view->load('default','reports/sales',[
		 		'title'    		=>'Reports',
		 		'invoice'       => $invoice,
		 		'start'  		=> Input::get('start'),
	 			'end'    		=> Input::get('end')
	 		]);
	}
	public function sales_summary_report()
	{
		$this->loadModel('reports');

		$sumSales = array();
		$key = false;
		
		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				$dateStart = strtotime(Input::get('start'));
				$dateEnd   = strtotime(Input::get('end'));

				if($dateStart > $dateEnd){
				 	Session::setFlash('Before ' .  Input::get('start') . ' is not Applicable !');
				}
				else{
					$sumSales = $this->model->getSummarySales(Input::get('start'), Input::get('end'));
				}
				$key = true;
			}
		}
				
		
	 	$this->view->load('default','reports/sales_summary',[
	 		'title'    => 'Reports',
	 		'sumSales' => $sumSales,
	 		'key'      => $key,
	 	]);
	} 
	public function purchase_order()
	{
		$this->loadModel('reports');
		$purchase 			  = array();
		$purchase['purchase'] = array();
		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				 

				$dateStart = strtotime(Input::get('start'));
				$dateEnd   = strtotime(Input::get('end'));

				if($dateStart > $dateEnd){
				 	Session::setFlash('Before ' .  date('M. j, Y', strtotime(Input::get('start'))) . ' is not Applicable !');
				}
				else{
					$purchase['purchase'] = $this->model->getPurchase(date(Input::get('start')),date(Input::get('end')));
					$purchase['comps']    = $this->model->getCompanyInfo();
				}
			}
		}
	 	$this->view->load('default','reports/purchase',[
	 		'title'     => 'Reports',
	 		'purchases'  => $purchase,
	 		'start'  => Input::get('start'),
	 		'end'    => Input::get('end'),
	 	]);
	}
	public function stocks_report()
	{
		$this->loadModel('reports');

		$stocks = $this->model->getStockSummary();
	 	
	 	$this->view->load('default','reports/stocks',[
	 		'title'  => 'Reports',
	 		'stocks' => $stocks
	 	]);
	}
	public function invoice_order()
	{
		$this->loadModel('reports');

		$invoice = array();
		$invoice['invoice'] = array();

		if (Input::exist()) {
			if (Token::check(Input::get('token'))) {
				 

				$dateStart = strtotime(Input::get('start'));
				$dateEnd   = strtotime(Input::get('end'));

				if($dateStart > $dateEnd){
				 	Session::setFlash('Before ' .  date('M. j, Y', strtotime(Input::get('start'))) . ' is not Applicable !');
				}
				else{
					$invoice['invoice'] = $this->model->loadInvoiceList(Input::get('start'), Input::get('end'));
					$invoice['comps']    = $this->model->getCompanyInfo();
				}

				// echo "<pre>";
				// print_r($purchase);
				// return;
			}
		}


		// $invoice = $this->model->loadInvoiceList();

		$this->view->load('default','reports/invoice',[
	 		'title'     => 'Invoice Orders',
	 		'invoice'   => $invoice,
	 		'start'     => Input::get('start'),
	 		'end'       => Input::get('end'),


	 	]);
	}
}

