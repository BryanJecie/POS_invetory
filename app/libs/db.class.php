<?php


 	class DB
	{
		protected static $_instance = null , $action = '', $key = false;

		public  $_error = false , $_result, $_count = 0;

		private $pdo, $_query;

		public function __construct()
		{
			try {
				$this->pdo = new PDO('mysql:host='.Config::load('database/host').';dbname='.
											Config::load('database/dbname'),
											Config::load('database/username'),
											Config::load('database/password'));
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
		public static function getInstance()
		{
			if (!isset(self::$_instance)) {
				self::$_instance = new DB;
			}
			return self::$_instance;
		}
		public function query( $sql , $params = array() )
		{	
			// echo '<pre>';
			// echo $sql.'<br>';
			// print_r($params);
			// echo '</pre>';
			if ($this->_query = $this->pdo->prepare( $sql)) {
				$i = 1;
				if (count($params)) {
					foreach ($params as $param) {
						 $this->_query->bindValue($i , $param );
						 $i++;
					}
				}
				if ($this->_query->execute()) {
					    $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
					    $this->_count  = $this->_query->rowCount();
							    // echo "<pre>";
							   	//  print_r($this->_result);
							    // echo "</pre>";

				}else{
						$this->_error = true;
				}
			}
			return $this;
		}
		public static function table($tables = array())
		{
			$script = 'SELECT * FROM';
			$i = 1;
			if (is_array($tables)) {
				$tbl = '';
				foreach ( $tables as $result ){
					$tbl .= "{$result} ";
					if ($i < count($tables)) {
						$tbl .= ', ';
					}
					$i++;
				}
				self::$action = $script.' '.$tbl;
			} else {
				self::$action = $script.' '.$tables;
			}
			return self::getInstance();
		}
		public function where($attribute = array())
		{
			if (count($attribute) === 3) {
				$optrs = array('=','>','<','<=','>=');

				$field = $attribute[0];
				$optr  = $attribute[1];
				$value = $attribute[2];

				if (in_array($optr, $optrs))
				{
					$sql = self::$action. " WHERE {$field} {$optr} ?";
					if (!$this->query($sql, array($value))->errors()) {
						self::$key = true;
					} 
				}
			}
			return self::getInstance();
		}
		public function get()
		{
			if (self::$key) {
				return $this->first();
			}  
			return null;
		}
		public function all()
		{
			if (self::$key) {
				return $this->result();
			} else {
				$this->query(self::$action);
				return $this->result();
			}
		}
		public function first()
		{
			return $this->result()[0];
		}
		public function result()
		{
			return $this->_result;
		}
		public function count()
		{
			return $this->_count;
		}
		public function errors()
		{
			return $this->_error;
		}
	}
