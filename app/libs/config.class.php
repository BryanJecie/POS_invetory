<?php

class Config
{
	private static $setting = [];

	public static function get($key)
  	{
  		return isset(self::$setting[$key]) ? self::$setting[$key] : null;
  	}
  	public static function set( $key , $value)
  	{
  		self::$setting[$key] = $value;
  	}
	public static function load($key)
	{
		if ($key) {
			$key = explode('/' , $key);
			$retVal = (is_array($key)) ? $key[0] : $key;
			$path = self::_require($retVal);
			foreach ($key as $value) {
				if (isset( $path[$value])) {
					$path = $path[$value];
				}
			}
			return $path;
		}
		return false;
	}
	public static function _require($key)
	{
		$config_path = CONFIG_PATH.'/'.strtolower($key).'.php';

		return (file_exists($config_path)) ? require($config_path) : null ;
	}
}
