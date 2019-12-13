<?php 

function escape($string){
	
	return htmlentities( $string, ENT_QUOTES , 'UTF-8');
}



function ulActive( $ctrl = null ){
	// return $ctrl;
	
	if ($ctrl == App::controller() ) {
		return 'active';
	}
	return null;
}

function liActive( $method = null ){
	 
	if ($method == App::method() ) {
		return 'active';
	}
	return null;
}
function bodyClass($method = null)
{
	$class = '';
	switch ($method) {
		case 'stud_personal':
			$class = 'content-full-width';
			break;
		case 'dis_prior':
			$class = 'content-full-width';
			break;
		case 'student_masterlist':
			$class = 'content-full-width';
			break;
		case 'refunds':
			$class = 'content-full-width';
			break;
		case 'balances':
			$class = 'content-full-width';
			break;
		case 'account_slip':
			$class = 'content-full-width';
			break;
		case 'head_office_report':
			$class = 'content-full-width';
			break;
		case 'particular_setting':
			$class = 'content-full-width';
			break;
		case 'payment_history':
			$class = 'content-full-width';
			break;
		case 'statement_account':
			$class = 'content-full-width';
			break;
		case 'log_history':
			$class = 'content-full-width';
			break;
		case 'create_account':
			$class = 'content-full-width';
			break;
	}
	return $class;
}
function getNo($string = '', $maxId = null , $range)
{
	$value = '';
	if (!is_null($maxId)) {
		$value = $string.str_pad($maxId, $range, '0', STR_PAD_LEFT);
	}
	return $value;

}


 function company()
{
	$comp = Query::getSql()->query("SELECT * FROM company");
	 
	if ($comp->_count > 0) {
		return $comp->_result[0];
	}
	return 'UNKNOWN';
}