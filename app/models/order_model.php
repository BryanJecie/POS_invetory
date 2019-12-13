<?php
/**
* 
*/
class Order_Model extends Model
{
	private $_save;
	
	public function loadCustomers()
	{
		$custom = $this->_DB->query("SELECT * FROM customer");

		if ($custom->_count > 0) {
			return $custom->_result;
		} else {
			return null;
		}
	}
	public function insertTempOrder( $source = array() )
	{

		if (Token::check($source['token'])) {
			Query::insert('temp_order', [
						'temp_order_name' 	   => $source['p-name'],
						'temp_order_quantity'  => $source['p-quantity'],
						'temp_order_quan_type' => $source['p-type'],
						'temp_order_price' 	   => $source['p-price'],
					]);
			if (Query::count()) {
				return true;
			}

		}
		return false;
	}
	public function getProduct()
	{
		$product = $this->_DB->query("
				SELECT
				barcode.barcode,
				product.product_id,
				product.product_name,
				stockin_summary.stockin_sum_selling_quantity,
				stockin_summary.stockin_sum_selling_type
				FROM
				product
				INNER JOIN barcode ON barcode.product_id = product.product_id
				INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id

			");
		if ($product->_count > 0) {
			return $product->_result;
		} else {
			return null;
		}
	}
	public function getTempOrder()
	{
		$temp = $this->_DB->query("SELECT * FROM temp_order");
		
		if ($temp->_count > 0) {
			return $temp->_result;
		} else {
			return null;
		}
	}
	public function getselectPurchased($id = null)
	{ 
		$product = $this->_DB->query("
				SELECT * FROM product
				INNER JOIN barcode ON barcode.product_id = product.product_id
				INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
				WHERE
				barcode.product_id = {$id}
			");
		if ($product->_count > 0) {
			return $product->_result;
		} else {
			return null;
		}
	}
	public function getListPurchased($id = null)
	{

		$where = (!is_null($id)) ? "WHERE orders.order_id = {$id}" : "WHERE orders.order_status = 'pending'";
	  
		$order = $this->_DB->query("SELECT * FROM  orders
									INNER JOIN customer ON orders.custom_id = customer.custom_id
									INNER JOIN users ON orders.user_id = users.user_id
									INNER JOIN personnel ON users.person_id = personnel.person_id
									$where ");

		if ($order->_count > 0) {
			return $order->_result;
		} else {
			return null;
		}
	}
	public function getNewOrderInvoice()
	{
		// $endDate = date("Y-12-31");
		$startDate = date("Y-m-1");
		$endDate   = date("Y-m-30");
		$order = $this->_DB->query("
						SELECT * FROM orders
						INNER JOIN users ON orders.user_id = users.user_id
						INNER JOIN customer ON orders.custom_id = customer.custom_id
						INNER JOIN personnel ON users.person_id = personnel.person_id
						WHERE
						orders.order_payment_status = 'unpaid' AND
						orders.order_payment_status != 'pending'
					");

		if ($order->_count > 0) {
			return $order->_result;
		}  
		return null;
	}
	public function getManageOrder()
	{
		$order = $this->_DB->query("SELECT * FROM orders
									INNER JOIN users ON orders.user_id = users.user_id
									INNER JOIN customer ON orders.custom_id = customer.custom_id
									INNER JOIN personnel ON users.person_id = personnel.person_id
									WHERE orders.order_status != 'pending'");

		if ($order->_count > 0) {
			return $order->_result;
		} else {
			return null;
		}
	}
	public function getOrdersCustomer($id = null)
	{
		$order = $this->_DB->query("
					SELECT * FROM orders
					INNER JOIN customer ON orders.custom_id = customer.custom_id
					INNER JOIN users ON orders.user_id = users.user_id
					INNER JOIN personnel ON users.person_id = personnel.person_id
					WHERE orders.order_id = {$id}
				");

		if ($order->_count > 0) {
			return $order->_result;
		}
		return null;
	}
	public function getOrders($id = null)
	{
		// $where = (!is_null($id)) ? "WHERE orders.order_id = {$id}" : "" ;
		$order = $this->_DB->query("
				SELECT * FROM orders
				INNER JOIN customer ON orders.custom_id = customer.custom_id
				INNER JOIN users ON orders.user_id = users.user_id
				INNER JOIN personnel ON users.person_id = personnel.person_id
				WHERE orders.order_id = {$id}
			");

		if ($order->_count > 0) {
			return $order->_result;
		} else {
			return null;
		}
	}
	public function getOrderMaxId()
	{
		$maxId = $this->_DB->query("SELECT Max(orders.order_id) FROM orders ");
		if ($maxId->_count > 0) {
			foreach ($maxId->_result[0] as $id) 
				return $id;
		} else {
			return null;
		}
	}
	public function insertOrder($source = array() , $orderNo = '', $discount = null, $key = false )
	{
		// print_r($source);
		if ($key) {
			Query::insert('orders',[
					'order_no'    		  => $orderNo++,
					'order_date'          => date('Y-m-d'),
					// 'order_payment_type'  => $source['payment'],
					'order_reference'     => $source['reference'],
					'order_status'  	  => 'pending',
					'order_payment_status'=> 'unpaid',
					'order_discount'      => $discount,
					'user_id'     		  => App::$auth->data()->user_id,
					'custom_id'           => $source['supplier']
				]);
			if (Query::count()) {
				return Query::last_insert_id();
			}
			else {
				return false;
			}
		}
	}
	public function insertOrderDetails( $source = array(), $idNo, $key = false )
	{
		
		if ($key AND is_array($source))
		{
			for ( $i = 0; $i < count($source['quantity']); $i++) { 
				 
				if (!is_null($source['OrderName'][$i]) AND $source['OrderName'][$i] != "") {
					Query::insert('order_details', [
							'details_order_name'      => $source['OrderName'][$i],
							'details_order_type'      => $source['type'][$i],
							'details_order_quantity'  => $source['quantity'][$i],
							'details_order_price'     => $source['price'][$i],
							'details_order_id'        => $idNo,
						]);
				}
				else{
					Query::insert('order_details', [
							'details_order_type'      => $source['type'][$i],
							'details_order_quantity'  => $source['quantity'][$i],
							'details_order_price'     => $source['price'][$i],
							'product_id'			  => $source['product_id'][$i],
							'details_order_id'        => $idNo,
						]);
				}
				
			}
			if (Query::count()) {
				$this->_DB->query("DELETE FROM `temp_order`");
			}
			return true;
		}
		return false;
	}
	public function getPendingOrder($orderId = null)
	{

		// if (!is_null($status)) {
		// 	$pending = $this->_DB->query("SELECT product.product_name, product.product_id FROM order_details
		// 								  INNER JOIN product ON order_details.product_id = product.product_id
		// 								  WHERE details_order_id = '{$orderId}' ");

		// 	if ($pending->_count > 0) {
		// 		return $pending->_result;
		// 	} else {
		// 		return null;
		// 	}
		// }
	}
 	public function getSummarySaleYear()
	{
		$endDate = date("Y-12-31");
		$startDate   = date("Y-1-1");
		$sales = $this->_DB->query("SELECT product.product_name, Sum(sales.sales_quantity) AS TotalQuantity,
									sales_invoice.invoice_date
									FROM product
									INNER JOIN barcode ON barcode.product_id = product.product_id
									INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
									INNER JOIN sales ON sales.stock_sum_id = stockin_summary.stock_sum_id
									INNER JOIN sales_invoice ON sales.invoice_id = sales_invoice.invoice_id
									WHERE sales_invoice.invoice_date BETWEEN '{$startDate}' AND '{$endDate}' 
									GROUP BY product.product_name LIMIT 0, 5 ");
		if ($sales->_count > 0) {
			return $sales->_result;
		}
		return null;
	}
	public function getSummarySalesMonth()
	{
		$startDate = date("Y-m-1");
		$endDate   = date("Y-m-30");
		$sales = $this->_DB->query("SELECT product.product_name, IFNULL(SUM(sales.sales_quantity),0) AS totalSales,
									sales_invoice.invoice_date, barcode.barcode 
									FROM product
									INNER JOIN barcode ON barcode.product_id = product.product_id
									INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
									INNER JOIN sales ON sales.stock_sum_id = stockin_summary.stock_sum_id
									INNER JOIN sales_invoice ON sales.invoice_id = sales_invoice.invoice_id
									WHERE sales_invoice.invoice_date BETWEEN '{$startDate}' AND '{$endDate}'
									GROUP BY barcode.barcode LIMIT 0, 5 ");
		if ($sales->_count > 0) {
			return $sales->_result;
		}
		return null;
	}
	public function loadProductSumary($prodId = null)
	{
		$items = array();
		if (!is_null($prodId)) {
			$sum = $this->_DB->query("
							SELECT 
							 stockin_summary.stock_sum_id,
							 stockin_summary.stockin_sum_selling_quantity,
							 stockin_summary.stockin_sum_selling_price,
							 stockin_summary.stockin_sum_buying_price,
							 stockin_summary.barcode_id,
							 stockin_summary.stockin_sum_selling_type
							FROM barcode 
							INNER JOIN stockin_summary 
							ON stockin_summary.barcode_id =  barcode.barcode_id
							WHERE barcode.product_id = {$prodId}
						");
			if ($sum->_count > 0) {
				foreach ($sum->_result as $s) {
					$items = [
							  $s->stock_sum_id, 
							  $s->stockin_sum_selling_quantity,
							  $s->stockin_sum_selling_price,
							  $s->stockin_sum_buying_price,
							  $s->barcode_id,
							  $s->stockin_sum_selling_type
							 ];
				}
			}
		}
		return $items;
	}
	public function getCompanyInfo()
 	{
 		$comp = $this->_DB->query("SELECT * FROM company");

		if ($comp->_count > 0) {
	    	return $comp->_result;
	    }
		return null;
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
 	public function loadOrderDetails($orderId = null)
 	{
 		if (!is_null($orderId)) {
 			$invoice = $this->_DB->query("
				 					SELECT DISTINCT
				 					order_details.details_order_quantity,
				 					order_details.details_order_type,
				 					stockin_summary.stock_sum_id
				 					FROM
				 					order_details
				 					INNER JOIN product ON order_details.product_id = product.product_id
				 					INNER JOIN barcode ON barcode.product_id = product.product_id
				 					INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
				 					WHERE
				 					order_details.details_order_id = {$orderId}
				 				");
 			if ($invoice->_count > 0) {
 				return $invoice->_result;
 			}
 			return null;
 		}
 	}
 	public function loadSumSalesPartial($orderId = null)
 	{
 		if (!is_null($orderId)) {
 			$partial = $this->_DB->query("
		 			 		SELECT
		 			 		sales_invoice.invoice_id,
		 			 		sales_invoice.invoice_discount,
		 			 		SUM(partial_amount) as total_partial
		 			 		FROM
		 			 		sales_invoice
		 			 		INNER JOIN sales_partial ON sales_partial.invoice_id = sales_invoice.invoice_id
		 			 		WHERE 
		 			 		sales_partial.order_id = {$orderId}
		 			 		GROUP BY
		 			 		sales_invoice.invoice_no
		 			 	");
 			if ($partial->_count > 0) {
 			 	return $partial->_result[0];
 			}
 		}
 		return null;
 	}
 	public function get_order_status_to_pay($cusId = nul)
 	{
 		if (!is_null($cusId)) {
 			$stat = $this->_DB->query("
		 			 		SELECT
		 			 		*,
		 			 		IFNULL(order_bill-order_discount,0) as total_payable
		 			 		FROM
		 			 		customer
		 			 		INNER JOIN orders ON orders.custom_id = customer.custom_id
		 			 		WHERE
		 			 		customer.custom_id = {$cusId} AND
		 			 		orders.order_payment_status = 'unpaid'
		 			 		ORDER BY
		 			 		orders.order_date ASC
		 			 	");
 			if ($stat->_count > 0) {
 			 	return $stat->_result;
 			}
 		}
 		return null;
 	}
 	public function setOrderStatus($orderId = null)
 	{
 		$status = $this->_DB->query("
				SELECT
				*
				FROM
				orders
				WHERE
				orders.order_status NOT LIKE 'pending' AND
				orders.order_id = {$orderId}	
 			");
 		
 		if ($status->_count > 0) {
 			return $status->_result;
 		}
 		return false;
 	}
 	public function loadSupplierNotification()
 	{
 		$items = array();
 		$noti  = $this->_DB->query("
	 				 SELECT
	 				 purchased.pur_id,
	 				 purchased.purchase_no,
	 				 purchased.purchase_date,
	 				 supplier.supplier_name,
	 				 purchased.purchase_payment_status
	 				 FROM
	 				 purchased
	 				 INNER JOIN notifications ON notifications.pur_id = purchased.pur_id
	 				 INNER JOIN supplier ON purchased.supplier_id = supplier.supplier_id
	 				 WHERE purchased.purchase_payment_status = 'unpaid'
	 				 AND notifications.noti_status ='unread'
	 				 LIMIT 0, 5
			    ");
		if ($noti->_count > 0) {
			return $noti->_result;
		}  
		return null;
 	}
 	public function loadNotifications()
 	{
 		$items = array();
 		$noti  = $this->_DB->query("
	 				SELECT
	 				orders.order_id,
	 				orders.order_date,
	 				orders.order_no,
	 				notifications.noti_status,
	 				notifications.noti_date,
	 				notifications.noti_time,
	 				customer.custom_firstname,
	 				orders.order_payment_status
	 				FROM orders
	 				INNER JOIN notifications ON notifications.order_id = orders.order_id
	 				INNER JOIN customer ON orders.custom_id = customer.custom_id
	 				WHERE
	 				orders.order_status = 'confirm' AND
	 				notifications.noti_status = 'unread' AND
	 				orders.order_payment_status = 'unpaid'
	 				LIMIT 0, 5 ");
		if ($noti->_count > 0) {
			return $noti->_result;
		}  
		return null;
 	}

 	public function get_orders_with_status($custId = null, $status = "")
 	{
 		$where = "AND orders.order_payment_status = '{$status}'";
 		if ($status == 'all') {
 			$where = null;
 		}
 	    
 	    
 		$pStat  = $this->_DB->query("
	 				 SELECT 
	 				 *,
                     IFNULL(order_bill - order_discount, 0) as totalPayable 
	 				 FROM
	 				 orders
	 				 WHERE
	 				 orders.custom_id = {$custId} 
	 				 $where
	 				 AND orders.order_status = 'confirm'
	 				 ORDER BY
	 				 orders.order_date ASC
				");
		if ($pStat->_count > 0) {
			return $pStat->_result;
		}  
		return null;
 	}

 	public function loadSupplier()
 	{
 		$noti  = $this->_DB->query("SELECT * FROM supplier");
		if ($noti->_count > 0) {
			return $noti->_result;
		}  
		return null;
 	}


 	public function load_stockout_summary($start = null , $end = null, $key = null)
 	{
 		$where = null;
 		$limit = null;
 		if (!is_null($start) AND !is_null($end)) {
 			$where = "WHERE stockout_summary.stockcout_date BETWEEN '{$start}' AND '{$end}'";
 		}
 	    
 	    if (!is_null($key)) {
 	    	$limit = 'LIMIT 0, 10';
 	    }

 		$stockout  = $this->_DB->query("
	 				 SELECT
	 				 barcode.barcode,
	 				 product.product_name,
	 				 product.product_subname,
	 				 SUM(stockout_summary.stockout_quantity) as item_out,
	 				 stockout_summary.stockcout_date,
	 				 stockout_summary.stockout_quantity_type,
	 				 stockout_summary.stockout_selling_price,
	 				 stockout_summary.stockout_status
	 				 FROM
	 				 stockout_summary
	 				 INNER JOIN barcode ON stockout_summary.barcode_id = barcode.barcode_id
	 				 INNER JOIN product ON barcode.product_id = product.product_id
	 				 $where
	 				 GROUP BY
	 				 barcode.barcode
	 				 ORDER BY
	 				 stockout_summary.stockcout_date ASC
	 				 $limit
				");
		if ($stockout->_count > 0) {
			return $stockout->_result;
		}  
		return null;
 	}

 	public function load_stockout_history($start = null , $end = null, $key = null)
 	{
 		$where = null;
 		$limit = null;
 		if (!is_null($start) AND !is_null($end)) {
 			$where = "WHERE stockout_summary.stockcout_date BETWEEN '{$start}' AND '{$end}'";
 		}

 		if (!is_null($key)) {
 			$limit = 'LIMIT 0, 10';
 		}
 		$stockout  = $this->_DB->query("
	 				 SELECT
	 				 barcode.barcode,
	 				 product.product_name,
	 				 product.product_subname,
	 				 stockout_summary.stockout_quantity,
	 				 stockout_summary.stockcout_date,
	 				 stockout_summary.stockout_quantity_type,
	 				 stockout_summary.stockout_selling_price,
	 				 stockout_summary.stockout_status
	 				 FROM
	 				 stockout_summary
	 				 INNER JOIN barcode ON stockout_summary.barcode_id = barcode.barcode_id
	 				 INNER JOIN product ON barcode.product_id = product.product_id
	 				 $where
	 				 ORDER BY
	 				 stockout_summary.stockcout_date ASC
	 				 $limit
				");
		if ($stockout->_count > 0) {
			return $stockout->_result;
		}  
		return null;
 	}

 	public function update($table, $key, $id, $field = array())
	{
		$set ='';
		$i = 1;
		foreach ($field as $name => $value) {
			$set .= "{$name} = ?";
			if ($i < count($field)) {
					$set .= ', ';
			}
			$i++;
		}
		$sql = "UPDATE {$table} SET {$set} WHERE {$key} = {$id} ";
		
		 // echo $sql;
		 
		if (!Query::getSql()->query($sql , $field)->errors()) {
			return true;
		}
		return false;
	}
	public function get($table, $items = array())
	{
		if (count($items) === 3) {
			$optrs = array('=','>','<','<=','>=');
			$field  = $items[0];
			$optr   = $items[1];  
			$value  = $items[2];  
			$action = 'SELECT *';
			if (in_array($optr, $optrs))
			{
				$sql = "{$action} FROM {$table} WHERE {$field} {$optr} ?";
				if (!Query::getSql()->query($sql ,  array($value))->errors()) {
					return $this->result();
				}
			}
		}
		return false;
	}
	public function post( $table, $fields = array() )
	{
		if ($this->insert( $table , $fields )) {
			$this->_save  =  true; 
		}
	}
	public function insert($table = '', $field = array())
	{
		if (count($field)) {
			$keys = array_keys($field);
			$value = '';
			$i = 1;
			foreach ($field as $fields ) {
			 	$value .= '?';
			 	if ($i < count($field)) {
			 		$value .= ', ';
			 		$i++;
			 	}
			}
			$sql = "INSERT INTO {$table} (`" .implode('`,`', $keys). "`) VALUES ({$value}) ";

			if ($this->_DB->query($sql , $field)->errors()) {
				return true;
			}
		}
		return false;
	}
	public function lastInsertId()
	{
		$this->_DB->query('SELECT LAST_INSERT_ID();');
		if ($this->count()) {
			foreach ($this->result()[0] as $id) {
				return $id;
			}
		}
		return false;
	}
	public function save()
	{
		return $this->_save;
	}
	public function result()
	{
		return $this->_DB->_result;
	}
	public function count()
	{
		if ($this->_DB->_count > 0) {
			return true;
		}
		return false;
	}
} 