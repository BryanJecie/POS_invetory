<?php
###===============================================>
####  URL class
###
###
class Url
{
	public static function route( $path = null)
	{
		  return self::load($path);
	}
	public static function link($path = null)
	{
		 return self::load($path);
	}
	public static function load($path)
	{
		return  self::_set().$path;
	}
	public static function http()
	{
		return stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	}
	public static function uri()
	{
		return $_SERVER['REQUEST_URI'];
	}
	public static function host()
	{
		return $_SERVER['HTTP_HOST'];
	}
	public static function protocol()
	{
		return $_SERVER['SERVER_PROTOCOL'];
	}
	public static function self()
	{
		return $_SERVER['PHP_SELF'];
	}
	public static function _set()
	{
		return self::http().self::host().'/'.SYS_PATH.'/';
	}
}
