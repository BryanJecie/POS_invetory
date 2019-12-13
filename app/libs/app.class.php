<?php
###===============================================
#### App Class
###
###

class App
{


	public static $auth, $image;

	private static $router;

	/**
	 * this method allows the application is run
	 * 
	 * @return true
	 */
	public static function run($uri)
	{

		//instantiate the router class
		self::$router = new Router($uri);
		
		//Execute the Auth mehod
		self::$auth = new Auth();

		// self::$auth = $auth->data();

		//Execute the Image mehod
		self::$image = self::Image();

		$con_class = ucfirst(self::$router->getController()) . 'Controller';
	 
		//Check if class is exist
		if (!class_exists($con_class)) {
			if ($con_class == 'UserauthController' || $con_class == 'SignoutController') {
				$con_class = 'IndexController';
			} else {
				require RES_PATH . '/views/error/404.php';
				return false;
			}
		}

	 	// return false;
		$con_object = new $con_class();

		$con_method = strtolower(self::$router->getMethodPrefix() . self::$router->getAction());

		//Check if method is exist
		//return false
		if (!method_exists($con_object, $con_method)) {
			require RES_PATH . '/views/error/404.php';
			return false;
		}
	 	
	 	//make an function is array
		call_user_func_array([$con_object, $con_method], self::$router->getParams());
	}

	/**
	 * (Optional) Set a custom router
	 * @param string $path Use the file name of your controller, eg: error.php
	 */
	public function getRouter()
	{
		return self::$router;
	}

	/**
	 * (Optional) Set a custom controller
	 * @param string $path Use the file name of your controller, eg: error.php
	 */
	public static function controller()
	{
		return self::$router->getController();
	}

	/**
	 * (Optional) Set a custom method action
	 * @param string $path Use the file name of your controller, eg: error.php
	 */
	public static function method()
	{
		return self::$router->getAction();
	}

	/**
	 * (Optional) Set a custom param data
	 * @param string $path Use the file name of your controller, eg: error.php
	 */
	public static function params()
	{
		return self::$router->getParams();
	}

	/**
	 * (Optional) Set a custom path to the error file
	 * @param string $path Use the file name of your controller, eg: error.php
	 */
	public static function userImage()
	{
		return new Image(self::$auth->data()->user_id);
	}

	/**
	 * (static) abject for login user
	 * @param string $path Use the file name of your controller, eg: error.php
	 */
	public static function Auth()
	{
		return self::$auth = new Auth();
	}

	/**
	 * (static) abject for login user
	 * @param string $path Use the file name of your controller, eg: error.php
	 */
	public static function Image()
	{
		return new Image;
	}
}
