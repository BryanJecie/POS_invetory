<?php 
###===============================================>
#### Router Class
###
###
 

	class Router
	{
		protected $uri;
		protected $controller;
		protected $action;
		protected $params, $route, $method_prefix, $language, $default;

		public  $url;

		public function getUri()
		{
			return $this->uri;
		}
		public function getController()
		{
			return $this->controller;
		}
		public function getAction()
		{
			return $this->action;
		}
		public function getParams()
		{
			return $this->params;
		}
		public function getRoute()
		{
			return $this->route;
		}
		public function getMethodPrefix()
		{
			return $this->method_prefix;
		}
		public function getLanguage()
		{
			return $this->language;
		}
		public function getDefault()
		{
			return $this->default;
		}
		public function get_url()
		{
			return $this->url;
		}
		public function __construct($uri)
		{

			$this->uri 	 		 = urldecode(trim($uri , '/'));
			$routes 	 		 = Config::get('routes');
			$this->route 		 = Config::get('default_route');

			$this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';

			$this->language   	 = Config::get('default_language');
			$this->controller 	 = Config::get('default_controller');
			$this->action        = Config::get('default_action');


			$uri_parts = explode('?', $this->uri);
			
			$path = $uri_parts[0];
			
			$path_parts = explode('/', $path);


			if (count($path_parts)) {
				if (current($path_parts)) {
			 		$this->default = strtolower(current( $path_parts));
			 		array_shift($path_parts);
			 	}
				if (in_array(strtolower(current($path_parts)), array_keys($routes))) {
			 		$this->route = strtolower(current($path_parts));
			 		$this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
			 		array_shift($path_parts);
				}
				else if (in_array(strtolower(current($path_parts)), Config::get('languages')) ) {
			 		$this->language = strtolower(current($path_parts));
			 		array_shift($path_parts);
			 	}

			 	if (current($path_parts)) {
			 		$this->controller = strtolower(current($path_parts));
			 		array_shift($path_parts);
			 	}
			 	if (current($path_parts)) {
			 		$this->action = strtolower(current($path_parts));
			 		array_shift($path_parts);
			 	}
					$this->params = $path_parts;
				    $this->url = isset($uri_parts[1]) ? $uri_parts[1] : null ;
			}
		}
	}
