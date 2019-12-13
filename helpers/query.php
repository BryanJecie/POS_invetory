
<?php

class Query{


	public static function action($action, $table, $where = array() )
	{
		if (count($where) === 3) {
			$optrs = array('=','>','<','<=','>=');
			$field = $where[0];
			$optr  = $where[1];
			$value = $where[2];

			if (in_array($optr, $optrs))
			{
				$sql = "{$action} FROM {$table} WHERE {$field} {$optr} ?";
				if (!self::getSql()->query($sql ,  array($value))->errors()) {
					return true;
				}
			}
		}
		return false;
	}
	public static function insert($table , $field = array())
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

			if (!self::getSql()->query($sql , $field)->errors()) {
				return true;
			}
		}
		return false;
	}
	public static function update($table, $key, $id, $field = array())
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
		 
		if (!self::getSql()->query($sql , $field)->errors()) {
			return true;
		}
		return false;
	}
	public static function last_insert_id()
	{
		self::getSql()->query('SELECT LAST_INSERT_ID();');
		if (self::getSql()->count()) {
			foreach (self::getSql()->result()[0] as $id) {
				 return $id;
			}
		}
		return false;
	}
	public static function selectJoin($table, $join, $where)
	{
		return self::innerJoin('SELECT *', $table, $join, $where);
	}
	public static function select( $table , $where)
	{
		return self::action('SELECT *', $table ,$where);
	}
	public static function delete( $table , $where )
	{
		return self::action('DELETE', $table ,$where);
	}
	public static function count()
	{
		return self::getSql()->count();
	}
	public function result()
	{
		return self::getSql()->result();
	}
	public static function first()
	{
		return self::getSql()->result()[0];
	}
	public static function getSql()
	{
		return  DB::getInstance();
	}

}
