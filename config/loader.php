<?php 





Config::set('site_name' , strtoupper(company()->comp_abbr).' | SYSTEM');

Config::set('default_route' , 'default');

Config::set('languages' ,  array('en'  , 'fr'));

Config::set('routes' , [
		'default' => '',
		'print' => 'print_'
	]);

Config::set('default_route' , 'default');

Config::set('default_controller' , 'index');

Config::set('default_language' , 'en');

Config::set('default_action' ,  'index');

