<?php
/**
* 
*/
class Cashier_Model extends Model
{
	
	public function getAllProduct()
	{
		$product = $this->_DB->query("
				SELECT
				product.product_name,
				barcode.barcode,
				product.product_id,
				stockin_summary.stockin_sum_selling_price,
				stockin_summary.stockin_sum_status,
				stockin_summary.stockin_sum_selling_quantity,
				stockin_summary.stockin_sum_selling_type
				FROM
				product
				INNER JOIN barcode ON barcode.product_id = product.product_id
				INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
				ORDER BY product.product_name ASC
			");
		if ($product->_count > 0) {
			return $product->_result;
		} else {
			return null;
		}
	}
	public function retrieveCustomers()
	{
		$customer = $this->_DB->query("SELECT * FROM customer");

		if ($customer->_count > 0) {
			return $customer->_result;
		} else {
			return null;
		}
	}
	public function getCustomMaxID()
	{
	 	$maxID = $this->_DB->query("SELECT Max(customer.custom_id) FROM customer");


		if ($maxID->_count > 0) {
			return $maxID->_result[0];
		} else {
			return null;
		}
	}
	public function retrieveRemainingProduct()
	{
		$remain = $this->_DB->query("
				 		SELECT
				 		barcode.barcode,
				 		IFNULL(SUM(sales.sales_quantity),0) AS stockout,
				 		IFNULL(stockin_summary.stockin_sum_selling_quantity,0) AS stockin,
				 		stockin_summary.stockin_sum_selling_type,
				 		sales.sales_quantity_type,
				 		stockin_summary.stockin_sum_selling_price
				 		FROM
				 		barcode
				 		LEFT JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
				 		LEFT JOIN sales ON sales.stock_sum_id = stockin_summary.stock_sum_id
				 		GROUP BY
				 		barcode.barcode
			");

		if ($remain->_count > 0) {
			return $remain->_result;
		} else {
			return null;
		}
	}
	public function getTempPurcahse()
	{
		$salesTemp = $this->_DB->query("SELECT * FROM tempSales");

		if ($salesTemp->_count > 0) {
			return $salesTemp->_result;
		} else {
			return null;
		}
	}
	public function getTempDelete()
	{
		
		$salesCancel = $this->_DB->query("DELETE FROM `tempSales`");

		if ($salesCancel->_count) {
			return true;
		} else {
			return false;
		}
	}
	public function getSalesMaxInvoice()
	{
		$maxID = $this->_DB->query("SELECT Max(sales_invoice.invoice_id) FROM sales_invoice");


		if ($maxID->_count > 0) {
			foreach ($maxID->_result as $id) {
				foreach ($id as $i) {
					return $i;
				}
			}
			 
		} else {
			return null;
		}
	}
	public function getMaxSalesId()
	{
		$maxID = $this->_DB->query("SELECT Max(sales.sales_id) FROM sales");


		if ($maxID->_count > 0) {
			foreach ($maxID->_result as $id) {
				foreach ($id as $i) {
					return $i;
				}
			}
			 
		} else {
			return null;
		}
	}
	public function listProductReturn($saleNo = null)
	{
		$items = array();
		Query::select('sales_invoice' , [
				'invoice_no', '=' , $saleNo
			]);
		$invId = 0;
		$invNo = '';

		if (Query::count()) {
			$invId = Query::first()->invoice_id;	
			$invNo = Query::first()->invoice_no;	
		}

		$ret = $this->_DB->query("
				SELECT
				product.product_name,
				sales.sales_quantity,
				barcode.barcode,
				stockin_summary.stock_sum_id,
				sales.sales_id,
				sales.invoice_id,
				sales.sales_quantity_type
				FROM
				sales
				INNER JOIN stockin_summary ON sales.stock_sum_id = stockin_summary.stock_sum_id
				INNER JOIN barcode ON stockin_summary.barcode_id = barcode.barcode_id
				INNER JOIN product ON barcode.product_id = product.product_id
				WHERE
				sales.invoice_id = {$invId}
			");

		if ($ret->_count > 0) {
			$items = [$invNo =>  $ret->_result];
		}
		return $items;
	}
	public function sales()
	{
		$date = date('Y-m-d');
		$ret = $this->_DB->query(" 
					SELECT
					sales_invoice.invoice_no, 
					sales_invoice.invoice_status,
					invoice_total_amount as total_amount,
					sales_invoice.invoice_time,
					SUM(sales.sales_quantity) as qty,
					invoice_discount as discount,
					sales_invoice.invoice_id
					FROM
					sales_invoice
					INNER JOIN sales ON sales.invoice_id = sales_invoice.invoice_id
					WHERE
					sales_invoice.invoice_date = '{$date}'
					GROUP BY
					sales_invoice.invoice_id
					ORDER BY
					sales_invoice.invoice_time DESC
			");
		if ($ret->_count > 0) {
			return $ret->_result;
		}
		else {
			return null;
		}
	}
}