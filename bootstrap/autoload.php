<?php
###===============================================>
#### Define PATH
###
###

define('PATH', dirname(dirname(realpath(__FILE__))));

###===============================================>
#### Define Real PATH
###
###

define('BASE_PATH', str_replace('\\', '/', PATH.'/'));

###===============================================>
####
###
###

define('SYS_PATH', explode('/', BASE_PATH)[3]);


###===============================================>
#### Include all directory
###
###

$directories = require_once BASE_PATH.'/config/directory.php';

###===============================================>
#### Define all directory
###
###

foreach ($directories as $folder => $directory) {
	define($folder, BASE_PATH  . $directory.'/');
}

###===============================================>
#### load the initialize file
###
###

require_once APP_PATH.'/core/init.php';

###===============================================>
#### load the Loader file
###
###
require_once CONFIG_PATH.'/loader.php';
