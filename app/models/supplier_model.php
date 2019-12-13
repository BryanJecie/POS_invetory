<?php
/**
* 
*/
class Supplier_Model extends Model
{
	
	public function getSupplier()
	{
		$supplier = $this->_DB->query("SELECT * FROM supplier");

		if ($supplier->_count > 0) {
			return $supplier->_result;
		} else {
			return null;
		}
	}
	public function insertPurchased($source = array() , $orderNo = '', $key = false )
	{

		if ($key) {
			 
			Query::insert('purchased', [
					'purchase_no'    		  => $orderNo,
					'purchase_date'           => $source['date'],
					'purchase_payment_type'   => $source['payment'],
					'purchase_reference'     => $source['reference'],
					'purchase_total_amount'   => $source['grandTotal'],
					'purchase_payment_status' => 'unpaid',
					'user_id'     		      => App::$auth->data()->user_id,
					'supplier_id'             => $source['supplier'],
				]);
			if (Query::count()) {
				return Query::last_insert_id();
			}
			else {
				return false;
			}
		}
	}
	public function insertPurchasedDetails( $source = array(), $idNo, $key = false )
	{
		
		if ($key AND is_array($source))
		{
			for ( $i = 0; $i < count($source['quantity']); $i++) { 
				 
				if (!is_null($source['OrderName'][$i]) AND $source['OrderName'][$i] != "") {
					Query::insert('purchased_details', [
							'pur_det_name'      => $source['OrderName'][$i],
							'pur_det_type'      => $source['type'][$i],
							'pur_det_quantity'  => $source['quantity'][$i],
							'pur_der_price'     => $source['price'][$i],
							'pur_id'            => $idNo,
						]);
				}
				else{
					Query::insert('purchased_details', [
							'pur_det_type'      => $source['type'][$i],
							'pur_det_quantity'  => $source['quantity'][$i],
							'pur_der_price'     => $source['price'][$i],
							'product_id'		=> $source['product_id'][$i],
							'pur_id'            => $idNo,
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
	public function insertTempPurchased( $source = array() )
	{
		if ($source['add-product']) {
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
	public function getPurchasedMaxId()
	{
		$max = $this->_DB->query("
					SELECT
					Max(purchased.pur_id) AS maxId
					FROM
					purchased
			 	");

		if ($max->_count > 0) {
			return $max->_result[0]->maxId;
		}  
		return null;
	}
	public function loadPurchased()
	{
		 
		$purchased = $this->_DB->query("
						SELECT * FROM
						purchased
						INNER JOIN supplier ON purchased.supplier_id = supplier.supplier_id
						INNER JOIN users ON purchased.user_id = users.user_id
						INNER JOIN personnel ON users.person_id = personnel.person_id
			 	");

		if ($purchased->_count > 0) {
			return $purchased->_result;
		}  
		return null;
	}
	public function getPurchased($purId = null)
	{
		if (!is_null($purId)) {
			$purchased = $this->_DB->query("
							SELECT * FROM
							purchased
							INNER JOIN supplier ON purchased.supplier_id = supplier.supplier_id
							INNER JOIN users ON purchased.user_id = users.user_id
							INNER JOIN personnel ON users.person_id = personnel.person_id
							WHERE
							purchased.pur_id = {$purId}
				 	");

			if ($purchased->_count > 0) {
				return $purchased->_result;
			}  
		}
		return null;
	}
}