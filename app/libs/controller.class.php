<?php
###===============================================
#### Controller class
###
###

class Controller
{
	protected $data;

	protected $model;

	protected $params;

	protected $action;
	 

	public function __construct( $data = array() )
	{
		 
		$this->action = App::getRouter()->getParams();
		
	 	$url_val      = (App::getRouter()->get_url()) ? explode('=' , App::getRouter()->get_url()) : null ;

	 	if (isset($url_val[1])){
	 		$this->params = $url_val;
	 	}

		$this->view = new View;

	}
	public function getData()
	{
		return $this->data;
	}
	public function getModel()
	{
		return $this->model;
	}
	public function getParams()
	{
		return $this->params;
	}
	public function getAction()
	{
		return $this->action;
	}
	public function loadModel($name)
	{
		
        $path =  APP_PATH.'models/'.strtolower($name).'_model.php';
       
        if (file_exists($path)) {
            
            require($path);
            
            $modelName = ucfirst($name) . '_Model';
            
            $this->model = new $modelName();
        }    
	}
}
