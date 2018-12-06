<?php

namespace FB\src;

use FB\src\Route;

/**
* App class that initialize the app 
*
* PHP Version 7+
*
* Methods : getRoute, run
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
class App 
{

    /**
     * getRoute() is the method that actually checks if the current
     * route is valid or not.
     *
     * @return string $uri 
    */
    public static function getRoute() 
    {

	    global $routes;
	    $uri = $_SERVER['REQUEST_URI'];

	    if (!in_array(explode('?',$uri)[0], $routes)) {
	        Route::callController('HomeController@error404');
	        exit;
	    }

	    return $uri;

    }

    /**
     * The run() method is the first method that runs.
     * run() gets the current route and checks if it is valid.
     * If the route is invalid the app doesn't proceed any further.
     * 
     * @return this Method
    */
    public static function run() 
    {
        self::getRoute();
    }

}
