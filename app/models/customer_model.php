<?php
/**
* 
*/
class Customer_Model extends Model
{
	
	 public function getCustomMaxID()
	 {
	 	$maxID = $this->_DB->query("SELECT Max(customer.custom_id) FROM customer");


		if ($maxID->_count > 0) {
			return $maxID->_result[0];
		} else {
			return null;
		}
	 }
	 public function getCustomer()
	 {
	 	$custom = $this->_DB->query("SELECT * FROM customer");
	 	
		if ($custom->_count > 0) {
			return $custom->_result;
		} else {
			return null;
		}
	 }
	 public function updateCustomer( $source = array() )
	 {
	 	if (is_array($source)) {
	 		Query::update('customer','custom_id', $source['custom-id'],[
	 				'custom_firstname' => $source['first'],
	 				'custom_lastname' => $source['last'],
	 				'custom_email' => $source['email'],
	 				'custom_phone' => $source['phone'],
	 				'custom_address' => $source['address'],
	 				'custom_birthdate' => $source['birthdate'],
	 				'custom_discount' => $source['discount']
	 			]);
	 	}
	 }
}