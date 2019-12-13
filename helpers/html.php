<?php
###===============================================>
####  HTML class
###
###
class Html
{
	protected static $title;

	public static function style($url , $attributes = array())
	{
		return '<link rel="stylesheet" type="text/css" href="'.Url::link($url).'.css" '.self::_getAttr($attributes).' charset="utf-8">'.PHP_EOL;
	}
	public static function script($url)
	{
		return '<script src="'.Url::link($url).'.js" type="text/javascript" charset="utf-8" async defer></script>'.PHP_EOL;
	}
	public static function image($url, $attributes = array())
	{
		return '<img src="'.Url::link($url).'" '.self::_getAttr($attributes).'>'.PHP_EOL;
	}
	public static function href($url , $string , $attributes = array())
	{
		return '<a href="'.$url.'" '.self::_getAttr($attributes).'>'.$string.'</a>'.PHP_EOL;
	}
		public static function icon($url , $attributes = array())
	{
		return  '<link rel="icon" type="image/png" href="'.Url::link($url).'.ico"  "'.self::_getAttr($attributes).'">'.PHP_EOL;
	}
	public static function _getAttr($attributes)
	{
		$attribute = '';

		if (!is_null($attributes)) {
			foreach ($attributes as $key => $value) {
				 	$attribute .= $key. '='.'"'.$value.'"' ;
			}
	 	}
		return $attribute;
	}
}
