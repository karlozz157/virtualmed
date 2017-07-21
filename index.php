<?php

require __DIR__ . '/vendor/autoload.php';

use Virtualmed\Http\Router;

$router = new Router();
$router->route('/carlos', 'TestController@carlosAction');
$router->route('/emily', 'TestController@emilyAction');
