<?php

define('ROOT_PATH', dirname(__FILE__));
require_once( './vendor/autoload.php' );
require_once( './app/globals.php' );
require_once( './app/routes.php' );

use FB\app\src\App;
App::run();