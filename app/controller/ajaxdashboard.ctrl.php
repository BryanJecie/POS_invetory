<?php 
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
class AjaxDashboardController extends Controller
{ 
	public function setStockintItems()
	{
		$items = array();
		if (Input::exist()) {
			if (Input::get('action') === 'get') {
				$startDate = date("Y-m-1");
				$endDate   = date("Y-m-30");
				$stOut = Query::getSql()->query("
											SELECT
											IFNULL(SUM(product_stockin.stockin_selling_quantity),0) AS totalStockin
											FROM
											product_stockin
											WHERE
											product_stockin.stockin_date BETWEEN '{$startDate}' AND '{$endDate}' 
							             ");
				if ($stOut->_count > 0) {
					$items['in'] =  $stOut->_result[0]->totalStockin;
				}
			}
		}
		echo json_encode($items);
	}
	public function setStockOutItems()
	{
		$items = array();
		if (Input::exist()) {
			if (Input::get('action') === 'get') {
				$startDate = date("Y-m-1");
				$endDate   = date("Y-m-30");

				$stOut = Query::getSql()->query("
											SELECT
											IFNULL(Sum(stockout_summary.stockout_quantity),0) AS `totalStockOut`
											FROM
											stockout_summary
											WHERE
											stockout_summary.stockcout_date BETWEEN '{$startDate}' AND '{$endDate}' 
							             ");
				// $items = $stOut;
				if ($stOut->_count > 0) {
					$items['out'] =  $stOut->_result[0]->totalStockOut;
				}
				else{
					$items['out'] = 0;
				}
			}
		}
		echo json_encode($items);
	}
	public function setTotalSales()
	{
		$items = array();
		if (Input::exist()) {
			if (Input::get('action') === 'get') {
				$startDate = date("Y-m-1");
				$endDate   = date("Y-m-30");


				$stOut = Query::getSql()->query("
							SELECT
							sales_invoice.invoice_total_amount,
							sales_invoice.invoice_id
							FROM
							sales_invoice
							WHERE
							sales_invoice.invoice_date BETWEEN  '{$startDate}' AND '{$endDate}' 
			             ");
				
				$total = 0;
				if ($stOut->_count > 0) {
					foreach ($stOut->_result as $sales) {
						if (is_null($sales->invoice_total_amount)) {
							$stOut = Query::getSql()->query("
										SELECT
										IFNULL(Sum(sales_partial.partial_amount),0) AS partial
										FROM
										sales_partial
										WHERE
										sales_partial.invoice_id = {$sales->invoice_id}
						             ")->get();
							$total += $stOut->partial;
						}else{
							$total += $sales->invoice_total_amount;
						}
					}
				}
				$items['sales'] =  number_format($total,2);
			}
		}
		echo json_encode($items);
	}
	public function setSalesNow()
	{
		$items = array();
		if (Input::exist()) {
			if (Input::get('action') === 'get') {
				$startDate = date("Y-m-d");
				$stOut = Query::getSql()->query("
								 SELECT
								 sales_invoice.invoice_total_amount,
								 sales_invoice.invoice_id
								 FROM
								 sales_invoice
								 WHERE
								 sales_invoice.invoice_date = '{$startDate}';
				         ");
				$total = 0;
				if ($stOut->_count > 0) {
					foreach ($stOut->_result as $sales) {
						if (is_null($sales->invoice_total_amount)) {
							$stOut = Query::getSql()->query("
										SELECT
										IFNULL(Sum(sales_partial.partial_amount),0) AS partial
										FROM
										sales_partial
										WHERE
										sales_partial.invoice_id = {$sales->invoice_id}
						             ")->get();
							$total += $stOut->partial;
						}else{
							$total += $sales->invoice_total_amount;
						}
					}
				}
				$items['now'] =  number_format($total,2);

			}
		}
		echo json_encode($items);
	}
	public function setNotification()
	{
		$items = array();
		if (Input::exist()) {
		 	
		 	$id = null;
		 	$attr =  '';

		 	if (Input::get('purStatus') === 'supplier'){
		 		$id = Input::get('purId');
		 		$attr = 'pur_id';
		 	}
		 	else{
		 		$attr = 'order_id';
		 		$id = Input::get('orderId');
		 	}

		 	Query::update('notifications', $attr, $id, [
		 			'noti_status' => 'read'
		 		]);
		 	if (Query::count()) {
		 		$items['key'] = true;
		 	}

		}
		echo json_encode($items);
	}
}	