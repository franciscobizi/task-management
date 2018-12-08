<?php

namespace FB\src;

use FB\src\Route;

/**
* App class that initialize the app 
*
* PHP Version 7+
*
* Methods : run
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
class App 
{

    /**
     * The run() method is the first method that runs.
     * run() gets the current route and checks if it is valid.
     * If the route is invalid the app doesn't proceed any further.
     * 
     * @return this Method
    */
    public static function run() 
    {   
        $uri = $_SERVER['REQUEST_URI'];
        
        if (!Route::isRouteValid()) {
            Route::callController('HomeController@error404');
            exit;
        }

        return $uri;
    }

}
