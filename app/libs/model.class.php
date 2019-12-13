<?php
/**
*
*/
class Model
{
	protected $_DB;

	public function __construct()
	{
		$this->_DB =  DB::getInstance();
	}
}
