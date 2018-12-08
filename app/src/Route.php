<?php

namespace FB\src;

/**
* Route class responsible for creating routes 
*
* PHP Version 7+
*
* Methods : isRouteValid, registeTheRoute, get, post, callController
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
final class Route 
{

    /**
    * Method that validate the route
    *
    * @return boolean true / false
    */
    public static function isRouteValid() : bool
    {
        global $routes;
        $uri = $_SERVER['REQUEST_URI'];

        if (!in_array(explode('?',$uri)[0], $routes)) {
            return 0;
        } else {
            return 1;
        }
    }

    /**
    * Insert route into the $routes array.
    *
    * @param string $route
    * @return void
    */
    private static function registeTheRoute($route) 
    {
        global $routes;
        $routes[] = BASEDIR.$route;

    }
   

    /**
    * This method registe the route HTTP post method and call controller
    *
    * @param  string $route
    * @param  string $controller
    * @return object
    */ 
    public static function post($route, $controller) 
    {   
        
        if ($_SERVER['REQUEST_URI'] == BASEDIR.$route) {
            self::registeTheRoute($route);
            self::callController($controller);
        }
    }

    /**
    * This method get the controller's and method's name
    *
    * @param  string $controller
    * @return object
    * @throw \ErrorException
    */
    public static function callController($controller)
    {
        $controller = explode('@', $controller);
        $controllerClass  = $controller[0];
        $controllerMethod = $controller[1];
        $controllerClass  = 'FB\\controllers\\'.$controllerClass;

        if (!class_exists($controllerClass)) {
            throw new \ErrorException('Controller does not exit');  
        }

        $controllerClass = new $controllerClass;

        if(method_exists($controllerClass, $controllerMethod)) {
            $controllerClass->$controllerMethod();
        }else {
            throw new \ErrorException('Method does not exit');
        }
    }

}
