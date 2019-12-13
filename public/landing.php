 <script>
 	alert()
 </script>




<?php

/* ###===============================================>
#### @Author       : Bayangyang Bahala
###  @Project      : INV
###  @Copyright    : August 8-1-2016 
###
##
*/


###===============================================>
#### Include the autoload files
###
###

require_once __DIR__ . '../../bootstrap/autoload.php';

###===============================================>
#### Run the Application
###
###

/*==== Run the application ===*/
App::run(Url::uri());


/*==== Check the password ===*/
// $password = Query::getSql()->query("SELECT * FROM users");
// if ($password->_count > 0) {
// 	foreach ($password->_result as $pass) {
// 		echo '<pre>';
// 			print_r('username =>' . $pass->username.PHP_EOL);
// 			print_r('password =>' . Hash::make( 'admin', $pass->user_salt) .PHP_EOL);
// 			print_r('password_encrypt =>' .$pass->password.PHP_EOL);
// 		echo '</pre>';

// 	}
// }


/*==== Check the routing ===*/
$router = new Router($_SERVER['REQUEST_URI']);
// echo "<pre>";
// 	print_r('Route => ' . $router->getRoute(). PHP_EOL );
// 	print_r('Language => ' . $router->getLanguage(). PHP_EOL );
// 	print_r('Controller => ' . $router->getController(). PHP_EOL );
// 	print_r('Action to be called => ' . $router->getMethodPrefix().$router->getAction() . PHP_EOL );
// 	echo "Params :";
// 	print_r($router->getParams());
// echo "</pre>";


// echo $router->getMethodPrefix(). $router->getAction();
