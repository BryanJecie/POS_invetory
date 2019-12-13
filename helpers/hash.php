<?php
###===============================================
#### Hash class encrypted string
###
###

class Hash
{
	
	###===============================================
	#### create encrypted string
	###
	###
	public static function make($string, $salt = '')
	{
		return hash('sha256', $string . $salt);
	}

	###===============================================
	#### return encrypted string
	###
	###	
	public static function salt($lenght)
	{
		
		// return mcrypt_create_iv($lenght);
		return md5($lenght);
	}

	###===============================================
	#### Hash class encrypted unique string
	###
	###	
	public static function unique()
	{
		return self::make(uniqid());
	}

}
