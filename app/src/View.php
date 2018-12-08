<?php

namespace FB\src;

/**
* View class that allow to render pages 
*
* PHP Version 7+
*
* Methods : render
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
class View
{
    /**
    *  @param string $path the path of file
    *  @param array $data data to be rendered
    *  @throw \ErrorException
    */
    public static function render($path, array $data = null)
    {
        $thePath = ROOT_PATH . '/app/views/'.$path.'.html';
        
        if (!file_exists($thePath)) {
          throw new \ErrorException('View cannot be found');  
        }

        require_once($thePath);
    }

    /**
    *  @param array $data data to be rendered
    *  @return array $json
    */
    public static function jsonResponse(array $data = null)
    {
        echo json_encode($data);
        exit;
    }
    
}