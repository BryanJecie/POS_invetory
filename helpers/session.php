<?php
###===============================================
#### Session class holder session
###
###

class Session
{
	protected static $_message;

	/**
     * (Optional) Put a custom controller
     * @param string $path Use the file name of your controller, eg: error.php
     */
	public static function put( $name , $value )
	{
		return $_SESSION[$name] = $value;
	}

	/**
     * (Optional) Get a custom controller
     * @param string $path Use the file name of your controller, eg: error.php
     */
	public static function get($name)
	{
		return $_SESSION[$name];
	}

	/**
     * (Optional) Set a custom controller
     * @param string $path Use the file name of your controller, eg: error.php
     */
	public static function exist($name)
	{
		return (isset($_SESSION[$name])) ? true : false ;
	}

	/**
     * (Optional) Set a custom controller
     * @param string $path Use the file name of your controller, eg: error.php
     */
	public static function delete($name)
	{
		if (self::exist($name)) {
			unset($_SESSION[$name]);
		}
	}

	/**
     * (Optional) Set a custom controller
     * @param string $path Use the file name of your controller, eg: error.php
     */
	public static function setFlash($message)
	{
		self::$_message = $message;
	}

	/**
     * (Optional) Set a custom controller
     * @param string $path Use the file name of your controller, eg: error.php
     */
	public static function hasFlash()
	{
		return !is_null(self::$_message);
	}

	/**
     * (Optional) Set a custom controller
     * @param string $path Use the file name of your controller, eg: error.php
     */
	public static function flash()
	{
		echo self::$_message;
		self::$_message = null;
	}

	/**
     * (Optional) Set a custom controller
     * @param string $path Use the file name of your controller, eg: error.php
     */
	public static function destroy()
	{
		return session_destroy();
	}

}
