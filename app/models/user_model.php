<?php
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : Assessment and Cashiering System with Queue
###  @Copyright    : August 8-1-2016 
###
##
*/
class User_Model extends Model
{
	public $_save = false , $_error;

	public function insert_user($source)
	{
		// echo "<pre>";
		// var_export($source);
		// echo "</pre>";

	 	Query::insert('user_account', [
	  		'fname'  		=> $source['first'],
	  		'mname' 		=> $source['middle'],
	  		'lname' 		=> $source['last'],
	  		'username'  	=> $source['username'],
	  		'password'  	=> $source['password'],
	  		'date_created'  => date("Y-m-d H:i:s")
	  	]);
	 	
	 	$id = Query::last_insert_id();
	    
	    if (Query::getSql()->count()) {

	 		foreach ($source as $item) {

	 			if (is_numeric($item)) {

	 				$this->_DB->query("SELECT * FROM accessibility_list WHERE accessibility_list.accl_id = {$item} ");
	 				
	 				if ($this->_DB->count()) {
	 					Query::insert('accessibility',[
 				 				'user_id' => $id,
 				 				'accl_id' => $this->_DB->result()[0]->accl_id
	 				 	]);
	 				}
	 			}
	 		 }
	 	 	return true;
	 	  }
	 	return false;
	}
	public function postUser( $source = array() )
	{
		if (!empty($source) AND is_array($source)) {

			$salt = Hash::salt(32);
			
			Query::insert('users', [
		 		'username'  	=> $source['first'],
		 		'password' 		=> Hash::make($source['password'] , $salt),
		 		'first' 		=> $source['first'],
		 		'middle'  		=> $source['middle'],
		 		'last'  		=> $source['last'],
		 		'user_role'  	=> $source['role'],
		 		'user_status'	=> 'offline',
		 		'user_prev'		=> 0,
		 		'user_salt'		=> $salt
		 	]);
		 	if (Query::count()) {
	    		return Query::last_insert_id();
	    	} 
		}
		return false; 
	}
	public function getUsers()
	{
	 	$users = $this->_DB->query("SELECT * FROM users");
		
		if ($users->_count > 0) {
			return $users->_result;
		}
		return null;
	}
	public function save()
	{
		$this->_save;
	}
 

	 
}
 