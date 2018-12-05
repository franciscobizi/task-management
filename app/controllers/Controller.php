<?php

namespace FB\controllers;

/**
* Controller base controller 
*
* PHP Version 7+
*
* Methods : constructor
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
class Controller
{
	protected $request;

	public function __construct()
	{
		$json = file_get_contents('php://input');
		
		return $this->request = json_decode($json, true);
	}
}