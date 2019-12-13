<?php
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/
class Search_Model extends Model
{
	public $_save = false , $_error;

	public function getSearchProduct($key = "")
	{
	 	$search = $this->_DB->query("SELECT * FROM product_type
										INNER JOIN product_brand ON product_brand.type_id = product_type.type_id
										INNER JOIN product ON product.brand_id = product_brand.brand_id
										INNER JOIN barcode ON barcode.product_id = product.product_id
										INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
									WHERE
										product_type.type_name LIKE '%".$key."%' OR
										product_brand.brand_name LIKE '%".$key."%' OR  
										product.product_name LIKE '%".$key."%' OR  
										barcode.barcode  LIKE '%".$key."%' OR 
										stockin_summary.stockin_sum_selling_price LIKE '%".$key."%' OR  
										stockin_summary.stockin_sum_buying_price LIKE '%".$key."%' OR  
										stockin_summary.stockin_sum_quantity LIKE '%".$key."%'
										ORDER BY
										product.product_name ASC");

	 	if ( $search->_count > 0 ) {
	 		return $search->_result;
	 	}
		return null;
	}
	public function getSelectProduct($id)
	{
	 
		$obj = $this->_DB->query("SELECT * FROM product
								  INNER JOIN barcode ON barcode.product_id = product.product_id
								  INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id
								  WHERE product.product_id = {$id} ");
		if ( $obj->_count > 0 ) {
	 		return $obj->_result;
	 	}
		return null;
	}
	public function customersList()
	{
		$cus_obj = $this->_DB->query("SELECT * FROM customer");

		if ( $cus_obj->_count > 0 ) {
	 		return $cus_obj->_result;
	 	}
		return null;
	}
	public function save()
	{
		$this->_save;
	}
 

	 
}
  