<?php
/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : Assessment and Cashiering System with Queue
###  @Copyright    : August 8-1-2016 
###
##
*/
class Settings_Model extends Model
{
	public $_save = false , $_error;

	 
	public function getCompanyInfo()
	{
		$compInfo = $this->_DB->query("SELECT * FROM company");
		
		if ( $compInfo->_count > 0 ) {
			return $compInfo->_result;
		}
		return null;
	}
	public function save()
	{
		$this->_save;
	}
 

	 
}
 