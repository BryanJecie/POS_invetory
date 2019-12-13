<?php
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
 */
class Product_Model extends Model
{
	public $_save = false, $_error;

	public function postStockin($source = array())
	{
		if (!empty($source) and is_array($source)) {

			Query::insert('barcode', [
				'barcode' => $source['barcode'],
				'prof_id' => $source['prof-id']
			]);

			$bar_id = Query::last_insert_id();

			Query::insert('stockin', [
				'stock_quantity' => $source['quanity'],
				'stock_price' => $source['price'],
				'stock_input' => $source['date'],
				'user_id' => App::$auth->data()->user_id,
				'bar_id' => $bar_id,
			]);
			if (Query::count()) {
				return true;
			}
		}

		return false;
	}
	public function getProduct_type()
	{

		$product = $this->_DB->query("SELECT * FROM product_type ");

		if ($product->_count > 0) {
			return $product->_result;
		}
		return null;
	}
	public function insertProductType($source = array())
	{

		if (!empty($source) and is_array($source)) {

			Query::insert('product_type', [
				'prod_type' => $source['form'][0]['value'],
				'date' => date('Y-m-d H:m:s')
			]);
			if (Query::count()) {
				return true;
			}
		}

		return false;
	}
	public function getStockin()
	{
		$stockin = $this->_DB->query("SELECT * FROM product_profile
									  INNER JOIN barcode ON barcode.prof_id = product_profile.prof_id
									  INNER JOIN stockin ON stockin.bar_id = barcode.bar_id");
		if ($stockin->_count > 0) {
			return $stockin->_result;
		}
		return null;
	}
	public function getProductProfile()
	{
		$profile = $this->_DB->query("SELECT * FROM product_type INNER JOIN product_profile ON product_profile.prod_id = product_type.prod_id");

		if ($profile->_count > 0) {
			return $profile->_result;
		}
		return null;
	}
	public function insertProductProfile($source = array())
	{
		if (!empty($source) and is_array($source)) {

			Query::insert('product_profile', [
				'prof_name' => $source['name'],
				'prof_size' => $source['size'],
				'prof_weight' => $source['weight'],
				'prof_desc' => $source['desc'],
				'date_insert' => date('Y-m-d H:m:s'),
				'prod_id' => $source['type']
			]);
			if (Query::count()) {
				return true;
			}
		}

		return true;
	}
	public function get_all_sub_product()
	{
		$brand = $this->_DB->query("SELECT * FROM product_type INNER JOIN product_brand ON product_brand.type_id = product_type.type_id");

		if ($brand->_count > 0) {
			return $brand->_result;
		}
		return null;
	}
	public function get_all_product_type()
	{
		$prd = $this->_DB->query("SELECT * FROM product_type");

		if ($prd->_count > 0) {
			return $prd->_result;
		}
		return null;
	}
	public function get_max_id()
	{
		$prd = $this->_DB->query("SELECT Max(product.product_id) as productId FROM product");

		if ($prd->_count > 0) {
			return $prd->_result;
		}
		return null;
	}
	public function get_brand($type_id)
	{
		$prd = $this->_DB->query("SELECT * FROM product_brand WHERE type_id = {$type_id} ORDER BY product_brand.brand_name ASC");

		if ($prd->_count > 0) {
			return $prd->_result;
		}
		return null;
	}
	public function createProductInput($source = array())
	{
		if (is_array($source)) {
			Query::insert('product', [
				'product_code' => $source['code'],
				'product_name' => $source['name'],
				'product_subname' => $source['subname'],
				'product_insert_date' => date("Y-m-d"),
				'brand_id' => $source['brand'],
			]);

			$prod_id = Query::last_insert_id();


			Query::select('barcode', [
				'barcode', '=', $source['barcode']
			]);

			if (Query::count()) {

				$bar_id = Query::first()->barcode_id;

				Query::select('stockin_summary', [
					'barcode_id', '=', $bar_id
				]);

				$sum = 0;
				if (Query::count()) {
					$sum = Query::first()->stockin_sum_quantity + $source['quantity'];
				}

				Query::update('stockin_summary', 'barcode_id', $bar_id, [
					'stockin_sum_quantity' => $sum
				]);

			} else {
				Query::insert('barcode', [
					'barcode' => $source['barcode'],
					'product_id' => $prod_id
				]);

				$bar_id = Query::last_insert_id();

				Query::insert('stockin_summary', [
					'stockin_sum_quantity' => $source['quantity'],
					'stockin_sum_buying_price' => $source['buying'],
					'stockin_sum_selling_price' => $source['selling'],
					'stockin_sum_quantity_type' => $source['quan-type'],
					'stockin_sum_date' => date("Y-m-d"),
					'barcode_id' => $bar_id
				]);
			}



			Query::insert('product_stockin', [
				'stockin_quantity' => $source['quantity'],
				'stockin_quantity_type' => $source['quan-type'],
				'stockin_date' => date("Y-m-d"),
				'stockin_buying_price' => $source['buying'],
				'stockin_selling_price' => $source['selling'],
				'barcode_id' => $bar_id
			]);


			if (Query::count()) {
				return true;
			} else {
				return false;
			}
		}
	}
	public function getProductStockin()
	{
		$stockin = $this->_DB->query("SELECT * FROM product_type
									   INNER JOIN product_brand ON product_brand.type_id = product_type.type_id
									   INNER JOIN product ON product.brand_id = product_brand.brand_id
									   INNER JOIN barcode ON barcode.product_id = product.product_id
									   INNER JOIN product_stockin ON product_stockin.barcode_id = barcode.barcode_id");
		if ($stockin->_count > 0) {
			return $stockin->_result;
		}
		return null;
	}
	public function get_product_info($id = null)
	{
		$product = $this->_DB->query("
				SELECT * FROM product
			    INNER JOIN barcode ON barcode.product_id = product.product_id
			    INNER JOIN product_stockin ON product_stockin.barcode_id = barcode.barcode_id
			    WHERE product_stockin.stockin_id = {$id} 
			");
		if ($product->_count > 0) {
			return $product->_result;
		}
		return null;
	}
	public function getSalesProduct()
	{
		$sales = $this->_DB->query("SELECT * FROM sales
						  			INNER JOIN stockin_summary ON sales.stock_sum_id = stockin_summary.stock_sum_id
						  			INNER JOIN barcode ON stockin_summary.barcode_id = barcode.barcode_id
						  			INNER JOIN product ON barcode.product_id = product.product_id
						  			INNER JOIN product_brand ON product.brand_id = product_brand.brand_id
						  			INNER JOIN product_type ON product_brand.type_id = product_type.type_id");

		if ($sales->_count > 0) {
			return $sales->_result;
		}
		return null;
	}
	public function getDeleteTempOrder()
	{
		$sales = $this->_DB->query("DELETE FROM `temp_order`");
	}


	public function get_damage_product($damageId = null)
	{
		$damage = $this->_DB->query("
						SELECT
						*
						FROM
						product_damage
						INNER JOIN barcode ON product_damage.barcode_id = barcode.barcode_id
						WHERE
						product_damage.damage_id = {$damageId}
					");

		if ($damage->_count > 0) {
			return $damage->_result[0];
		}
		return null;
	}
	public function getDamageProduct()
	{
		$damage = $this->_DB->query("
						SELECT * FROM
						product_damage
						INNER JOIN barcode ON product_damage.barcode_id = barcode.barcode_id
						INNER JOIN product ON barcode.product_id = product.product_id
						INNER JOIN product_brand ON product.brand_id = product_brand.brand_id
						INNER JOIN product_type ON product_brand.type_id = product_type.type_id
					");

		if ($damage->_count > 0) {
			return $damage->_result;
		}
		return null;
	}
	public function loadProductType()
	{
		$types = $this->_DB->query("SELECT * FROM product_type");

		if ($types->_count > 0) {
			$opt = '<option value="">Choose Category</option>';
			foreach ($types->_result as $type) {
				$opt .= '<option value="' . $type->type_id . '">' . $type->type_name . '</option>';
			}
			return $opt;
		}
		return null;
	}
	public function getBarcodeList($key = false)
	{
		$inner = '';
		if ($key) {
			$inner = "INNER JOIN product ON barcode.product_id = product.product_id";
		}

		$barcode = $this->_DB->query("SELECT * FROM `barcode` $inner");

		if ($barcode->_count > 0) {
			return $barcode->_result;
		}
		return null;
	}

	public function loadProductExist($barcode = null)
	{
		$exist = $this->_DB->query("
					SELECT DISTINCT
					product_type.type_name,
					product_brand.brand_name,
					product.product_name,
					product.product_subname,
					barcode.barcode,
					stockin_summary.stockin_sum_selling_quantity,
					stockin_summary.stockin_sum_buying_price,
					stockin_summary.stockin_sum_selling_price,
					stockin_summary.stockin_sum_selling_type,
					stockin_summary.stockin_sum_quantity_type,
					stockin_summary.stockin_sum_quantity_per,
					product_type.type_id,
					product_brand.brand_id
					FROM
					product_type
					INNER JOIN product_brand ON product_brand.type_id = product_type.type_id
					INNER JOIN product ON product.brand_id = product_brand.brand_id
					INNER JOIN barcode ON barcode.product_id = product.product_id
					INNER JOIN stockin_summary ON stockin_summary.barcode_id = barcode.barcode_id	
					WHERE
					barcode.barcode = '{$barcode}'
					GROUP BY
					barcode.barcode
			");
		if ($exist->_count > 0) {
			return $exist->_result;
		}
		return null;
	}

	public function update($table, $key, $id, $field = array())
	{
		$set = '';
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

		if (!Query::getSql()->query($sql, $field)->errors()) {
			return true;
		}
		return false;
	}
	public function get($table, $items = array())
	{
		if (count($items) === 3) {
			$optrs = array('=', '>', '<', '<=', '>=');
			$field = $items[0];
			$optr = $items[1];
			$value = $items[2];
			$action = 'SELECT *';
			if (in_array($optr, $optrs)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$optr} ?";
				if (!Query::getSql()->query($sql, array($value))->errors()) {
					return $this->result();
				}
			}
		}
		return false;
	}
	public function post($table, $fields = array())
	{
		if ($this->insert($table, $fields)) {
			$this->_save = true;
		}
	}
	public function insert($table = '', $field = array())
	{
		if (count($field)) {
			$keys = array_keys($field);
			$value = '';
			$i = 1;
			foreach ($field as $fields) {
				$value .= '?';
				if ($i < count($field)) {
					$value .= ', ';
					$i++;
				}
			}
			$sql = "INSERT INTO {$table} (`" . implode('`,`', $keys) . "`) VALUES ({$value}) ";

			if ($this->_DB->query($sql, $field)->errors()) {
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
	public function count()
	{
		if ($this->_DB->_count > 0) {
			return true;
		}
		return false;
	}
	public function result()
	{
		return $this->_DB->_result;
	}
	public function first()
	{
		return $this->_DB->_result[0];
	}
}
  