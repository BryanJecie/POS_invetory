<?php
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : Assessment and Cashiering System with Queue
###  @Copyright    : August 8-1-2016 
###
##
*/
class Reports_Model extends Model
{
	public $_save = false, $_error;


	public function save()
	{
		$this->_save;
	}
	public function getCompanyInfo()
	{
		$comp = $this->_DB->query("SELECT * FROM company");

		if ($comp->_count > 0) {
			return $comp->_result;
		}
		return null;
	}
	public function getSalesStocks($id = null)
	{

		$sales = $this->_DB->query("SELECT DISTINCT * FROM product
									INNER JOIN barcode ON barcode.product_id = product.product_id
									INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
									WHERE
									stockin_summary.stock_sum_id = {$id} ");

		if ($sales->_count > 0) {
			return $sales->_result;
		}
		return null;
	}
	public function getInvoiceSales($start, $end)
	{
		$daySales = $this->_DB->query("SELECT * FROM sales_invoice WHERE invoice_date BETWEEN '{$start}' AND '{$end}'");

		if ($daySales->_count > 0) {
			return $daySales->_result;
		}
		return null;
	}
	public function getStockSummary()
	{
		$stocks = $this->_DB->query("
				SELECT
				barcode.barcode,
				stockin_summary.stockin_sum_selling_quantity,
				stockin_summary.stockin_sum_selling_type,
				stockin_summary.stockin_sum_selling_price,
				stockin_summary.stockin_sum_buying_price,
				product.product_name,
				stockin_summary.stockin_sum_status,
				product.product_subname
				FROM product
				INNER JOIN barcode ON barcode.product_id = product.product_id
				INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
			");
		if ($stocks->_count > 0) {
			return $stocks->_result;
		}
		return null;
	}
	public function getSummarySales($start = null, $end = null)
	{

		if (!is_null($start) and !is_null($end)) {
			$sumSales = $this->_DB->query("
						 SELECT
						 sales_invoice.invoice_no,
						 sales_invoice.invoice_date,
						 sales_invoice.invoice_discount,
						 sales_invoice.invoice_total_amount,
						 sales_invoice.invoice_id,
						 sales_invoice.invoice_status
						 FROM
						 sales_invoice
						 WHERE invoice_date BETWEEN '{$start}' AND '{$end}'
				");
			if ($sumSales->_count > 0) {
				return $sumSales->_result;
			}
			return null;
		}
	}
	public function getPurchase($start = null, $end = null)
	{

		if (!is_null($start) and !is_null($end)) {

			$purchase =	$this->_DB->query(" 
							SELECT * FROM customer
							INNER JOIN orders ON orders.custom_id = customer.custom_id
							WHERE orders.order_date BETWEEN '{$start}' AND '{$end}' 
						");
			if ($purchase->_count > 0) {
				return $purchase->_result;
			}
			return null;
		}
	}
	public function loadInvoiceList($start = null, $end = null)
	{
		if (!is_null($start) and !is_null($end)) {

			$invoice = $this->_DB->query(" 
							SELECT * FROM
							purchased
							INNER JOIN supplier ON purchased.supplier_id = supplier.supplier_id
							INNER JOIN users ON purchased.user_id = users.user_id
							WHERE purchased.purchase_date BETWEEN '{$start}' AND '{$end}' 
						");
			if ($invoice->_count > 0) {
				return $invoice->_result;
			}
			return null;
		}
	}
	public function getSalesDetails($invId = null)
	{
		if (!is_null($invId)) {

			$invoice = $this->_DB->query(" 
							SELECT
							sales.sales_quantity,
							stockin_summary.stockin_sum_buying_price,
							stockin_summary.stockin_sum_selling_price,
							barcode.barcode,
							product.product_name,
							sales.sales_quantity_type,
							product.product_subname,
							IFNULL(sales.sales_discount, 0) as sales_discount,
							IFNULL(stockin_sum_selling_price * sales_quantity ,0 ) totalSales,
							IFNULL((stockin_sum_selling_price * sales_quantity) - (stockin_sum_buying_price * sales_quantity) ,0 ) AS totalProfit,
							IFNULL(stockin_sum_buying_price * sales_quantity ,0 ) AS totalCost
							FROM
							sales
							INNER JOIN stockin_summary ON sales.stock_sum_id = stockin_summary.stock_sum_id
							INNER JOIN barcode ON stockin_summary.barcode_id = barcode.barcode_id
							INNER JOIN product ON barcode.product_id = product.product_id 
							WHERE sales.invoice_id  = {$invId} 
						");
			if ($invoice->_count > 0) {
				return $invoice->_result;
			}
			return null;
		}
	}
	public function getPOSales($invId = null)
	{
		if (!is_null($invId)) {
			$invoice = $this->_DB->query(" 
							SELECT
							sales_partial.partial_amount,
							sales_invoice.invoice_id,
							sales_partial.partial_date
							FROM
							sales_partial
							INNER JOIN sales_invoice ON sales_partial.invoice_id = sales_invoice.invoice_id
							WHERE sales_partial.invoice_id  = {$invId} 
						");
			if ($invoice->_count > 0) {
				return $invoice->_result;
			}
			return null;
		}
	}
}
