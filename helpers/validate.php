<?php 
	
	// validate class for register input
	class Validate {
		private $_passed = false,
				$_errors = array(),
				$_query = null;

		function __construct(){
			// $this->_query = new query;
		}

		public function check($source , $items = array()){
			$value ='';

			foreach ($items as $item => $rules) {
			    foreach ($rules as $rule => $rule_value) {
					$value  = trim($source[$item]);
					$item   = escape($item);

					if ($rule === 'required' && empty($value)) {
						$this->addError("{$item} is required");
					}else if(!empty($value)){

						switch ($rule) {
							case 'min':
									if (strlen($value) < $rule_value) {
										$this->addError("{$item} must be minimum of {$rule_value} character");
									}
								break;
							case 'max':
									if (strlen($value) > $rule_value) {
										$this->addError("{$item} must be Maximum of {$rule_value} character");
									}
								break;
							case 'matches':
									if ($value != $source[$rule_value]) {
										$this->addError("{$rule_value} must be matches of {$item}");
									}
								break;
							case 'unique':
									Query::select($rule_value , [$item , '=' , $value]);
									if (Query::getSql()->count()) {
										$this->addError("{$value} must be exist");
									}
								break;
						
							case 'user_status':

									$optr = array('|','@','.',':');

									for ($i=0; $i < strlen($rule_value) ; $i++) { 

										if (in_array($rule_value[$i], $optr)) {

										 	$cred   = split($rule_value[$i], $rule_value);
										  
										 	$table  = $cred[0];
											$status = $cred[1];

											$data 	= DB::table([$table])->where([$item, '=', $value]);

											if ($data->_count > 0) {
												foreach ($data->_result as $stat) {
													if ($stat->user_status === $status) {
														$this->addError(ucwords($value)." is already login");
													}
												}
											}
										}
									}
								break;
							case 'role':
							 	
									$optrs = array('|','@','.',':');


									for ($i=0; $i < strlen($rule_value); $i++) { 
										if (in_array($rule_value[$i],$optrs) ) {
											$cred      = explode($rule_value[$i], $rule_value);

											$table     = $cred[0];
											$roleName  = $cred[1];
											$userRoles = Query::getSql()->query("
															 SELECT user_role.user_role FROM user_role
															 INNER JOIN users ON users.role_id = user_role.role_id
															 WHERE {$item} = '{$value}'
														");
											if ($userRoles->_count > 0) {
												foreach ($userRoles->_result as $roles) {
													if ($roles->user_role !== $roleName) {
														$this->addError(ucwords($roleName)." Staff Login Only!");
													}
												}
											}
										}
									}

							 	break; 
							default:
								# code...
								break;
						}
					
					}
			    }
			}
			if (empty($this->_errors)) {
				$this->_passed = true; 
			}
			return $this;
		}
		private  function addError($error){
			$this->_errors[] = $error;
		}
		public  function errors(){
			return $this->_errors;
		}
		public  function passed(){
			return  $this->_passed;
		}

	}
	
 ?>