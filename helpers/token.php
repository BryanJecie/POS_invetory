<?php
###===============================================
#### Token allows to generate identifier  string 
###
###

class Token
{

	###===============================================
	#### generate token string 
	###
	###
	public static function generate()
	{
		return Session::put(Config::load('utilities/token_name'), md5(uniqid()));
	}

	###===============================================
	#### Check token exist
	###
	###
	public static function check($token)
	{
		$tokenName = Config::load('utilities/token_name');

		if (Session::exist( $tokenName ) && $token === Session::get( $tokenName )) {

			Session::delete( $tokenName );

			return true;
		}
		return false;
	}
}
