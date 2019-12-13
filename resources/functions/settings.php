<?php

###===============================================>
####
###
###
function _html()
{
  return '<html  lang="en-us" id="extr-page">'.PHP_EOL.'<head>'.PHP_EOL;
}
###===============================================>
####
###
###
function _header()
{
  echo '<!DOCTYPE html>'.PHP_EOL;
  echo _html();
  echo _link_icon('public/images/icon/acs_logo');
	echo _meta();
	echo _title(Config::get('site_name'));
}
###===============================================>
####
###
###
function _meta()
{
	return '<meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">'.PHP_EOL;
}
###===============================================>
####
###
###
function _title($title)
{
	return '<title>'.$title.'</title>'.PHP_EOL;
}
###===============================================>
####
###
###
function _path($path)
{
    return Base_Path.$path;
}
###===============================================>
####
###
###
function _getDirectory($path){
    return  scandir($path);
}
###===============================================>
####
###
###

function _link_css($path , $css_template = array())
{

  $css_dir ='';
  foreach ($css_template as $key => $value) {
           $css_dir .= Html::style($path.$value, ['name' => $value] );
  }
  return $css_dir;
}
###===============================================>
####
###
###
function _link_icon($path , $attribute = array())
{
  return Html::icon($path , $attribute);
}
###===============================================>
####
###
###

function _link_js($path = null , $js_template = array())
{
  $js_dir = '' ;
  foreach ($js_template as $value) {
           $js_dir .= Html::script($path.$value);
  }
  return $js_dir;
}
###===============================================>
####
###
###
function _footer()
{
	$html = '';
	for ($i=0; $i <4 ; $i++) {
		$html .= ' ';
	}
	return '<div id="usage"><ul>'.$html.'</ul></div>'.PHP_EOL;
}

