<?php

require __DIR__ . '/vendor/autoload.php';

use Virtualmed\Http\Router;

Router::route('/contacts/index', 'Contact@index');
Router::route('/contacts/new', 'Contact@post');
