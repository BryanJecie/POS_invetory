<?php 	
###===============================================
#### View Class
###
##
#
class View
{
	public function load($view = null, $content = null, $data = [], $key = false)
	{
		$master_path = RES_PATH.'views/'.$view.'.sade.php';
	 	if (file_exists($master_path)) {
	 		require_once $master_path;
	 	}
	}
}