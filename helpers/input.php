<?php
###===============================================
#### Input class Getter String
###
###

class Input
{

	###===============================================
	#### Exist post type
	###
	###
	public static function exist($type = 'POST')
	{
		// return the post type
		switch ($type) {
			case 'POST':
				return (!empty($_POST)) ? true : false;
				break;
			case 'GET':
				return (!empty($_GET)) ? true : false;
				break;
			default:
				return false;
			break;
		}
	}

	###===============================================
	#### Get the value string
	###
	###
	public static function get($type)
	{
		// check post type
		if (isset($_POST[$type])){
			return $_POST[$type];
		
		}else if(isset($_GET[$type])){
			return $_GET[$type];
	 
		}else if(isset($_FILES[$type])){
			return $_FILES[$type];
		}
		return false;
	}
}
