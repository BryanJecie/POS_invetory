<?php
###===============================================>
#### Image Class
###
###

class Image
{
	public $userId , $attribute;

	function __construct($userId = null)
	{
		if (!is_null($userId)) {
		    $this->userId = $userId;
		}
	}
	public function get($path = '', $attribute = [], $id = null)
	{

		$path  = $path.$id;
		$image = $this->set_glob($path);
		  
		if (!empty($image)) {
			return $this->display($image , $attribute);
		}
		return $this->display('public/images/no_image/no_image.png', $attribute);
	}
	 
	public function upload_image($path , $image = array() ,  $key = false)
	{
		if ($key) {
			if (is_dir($path)) {
				if (strlen($image['name']) > 0) {
					if (move_uploaded_file($image['tmp_name'], $path .'/'. basename($image['name']))) {
						return true;
					}
			 	}
			}
		}
		return false;
	}
	public function user($path = null , $attribute = array())
	{
		$path = $path.'/'.$this->userId;
		$path = $this->set_glob($path);
		if (!empty($path)) {
			echo '<input type="hidden" id="user-image-path" value="'.$path.'" >';
			return $this->display($path , $attribute);
		} else {
			echo '<input type="hidden" id="user-image-path" value="public/images/no_image/no_image.png" >';
			return $this->display('public/images/no_image/no_image.png',$attribute);
		}
	}

	public function set_glob($path = null)
	{

		$images = glob($path."/*.{png,jpeg,jpg,gif,PNG,JPG,GIF,JPEG}", GLOB_BRACE);
		
		if (!is_null($images) AND !empty($images)) {
			$img ='';
			foreach ($images as $image)
	 			return $image;
		}
 		return false;
	}
	public function display($path='' , $attribute)
	{
		return Html::image($path, $attribute);
	}
	public function no_image($attribute)
	{
		$this->attribute = $attribute;
		return Html::image('public/images/no_image/no_image.png',  $this->attribute);
	}
}
