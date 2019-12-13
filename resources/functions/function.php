<?php 
###===============================================>
####
###
###

function _get_partial_payment($orderId = null){
	if (!is_null($orderId)) {
		$partialPayment = Query::getSql()->query("
		      SELECT
		      SUM(partial_amount) as total_partial
		      FROM
		      sales_invoice
		      INNER JOIN sales_partial ON sales_partial.invoice_id = sales_invoice.invoice_id
		      WHERE 
		      sales_partial.order_id = {$orderId}
		      GROUP BY
		      sales_invoice.invoice_no
		  ");

		if ($partialPayment->_count > 0) {
			return $partialPayment->_result[0]->total_partial;
		}
	}
	return null;
}
function _sales_partials($orderId = null)
{
	if (!is_null($orderId)) {
		$partial = Query::getSql()->query("
		      SELECT * FROM
		      sales_invoice
		      INNER JOIN sales_partial ON sales_partial.invoice_id = sales_invoice.invoice_id
		      WHERE sales_partial.order_id = {$orderId}
		  ");

		if ($partial->_count > 0) {
			return $partial->_result;
		}
	}
	return null;
}
function _get_sales_invoice_by_customer($custId = null)
{
	if (!is_null($custId)) {
			$partial = Query::getSql()->query("
		      SELECT DISTINCT
		      sales_invoice.invoice_total_amount,
		      sales_invoice.invoice_input_amount,
		      sales_invoice.invoice_date,
		      sales_partial.invoice_id
		      FROM
		      sales_invoice
		      LEFT JOIN sales_partial ON sales_partial.invoice_id = sales_invoice.invoice_id
		      WHERE
		      sales_invoice.custom_id = {$custId} AND
		      sales_partial.invoice_id IS NULL
		  ");

		if ($partial->_count > 0) {
			return $partial->_result;
		}
	}
	return null;
}
function _get_partial_payme_with_invoice($invoiceId = null)
{
	if (!is_null($invoiceId)) {
		$partialPayment = Query::getSql()->query("
			      SELECT
			      IFNULL(SUM(partial_amount),0) as total_partial
			      FROM
			      sales_invoice
			      INNER JOIN sales_partial ON sales_partial.invoice_id = sales_invoice.invoice_id
			      WHERE 
			      sales_partial.invoice_id = {$invoiceId}
			      GROUP BY
			      sales_invoice.invoice_no
			  ");
		if ($partialPayment->_count) {
			return $partialPayment->_result[0]->total_partial;
		}
		return null;

	}
}
function _get_sum_order_details($orderId = null)
{
	 if (!is_null($orderId)) {
	 	$totalOrderPrice = Query::getSql()->query("
	 		      SELECT
	 		      IFNULL(SUM((details_order_quantity * details_order_price)),0) as total_order_price
	 		      FROM
	 		      order_details
	 		      WHERE
	 		      order_details.details_order_id = {$orderId}
	 		      GROUP BY
	 		      order_details.details_order_id
	 		  ");
	 	if ($totalOrderPrice->_count) {
	 		return $totalOrderPrice->_result[0]->total_order_price;
	 	}
	 	return 0;

	 }
}
function _get_sum_selling_qty($stockId = null)
{
	if (!is_null($stockId)) {
		$stockSum = Query::getSql()->query("
				       SELECT
				       stockin_summary.stockin_sum_selling_quantity as qty,
				       stockin_summary.stockin_sum_selling_price AS price
				       FROM
				       stockin_summary
				       WHERE
				       stockin_summary.stock_sum_id = {$stockId}
				  	");
		if ($stockSum->_count) {
			return [
					'qty'   => $stockSum->_result[0]->qty,
				   	'price' => $stockSum->_result[0]->price
				   ];
		}
		return 0;
	}
}
function _get_invoice_total_amount($invId = null)
{
	if (!is_null($invId)) {
		$invAmnt = Query::getSql()->query("
				        SELECT
				        sales_invoice.invoice_total_amount as amount
				        FROM
				        sales_invoice
				        WHERE
				        sales_invoice.invoice_id = {$invId}
				  	");
		if ($invAmnt->_count) {
			return $invAmnt->_result[0]->amount;
		}
		return 0;
	}
}
