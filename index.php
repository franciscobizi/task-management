<?php
declare(strict_types=1);

define('ROOT_PATH', dirname(__FILE__));
require_once( './vendor/autoload.php' );
require_once( './app/globals.php' );
require_once( './app/routes.php' );

use FB\src\App;
App::run();