<?php

namespace FB\controllers;

use FB\src\{
	View, 
	Task,
	Auth
};

/**
* AdminController  
*
* PHP Version 7+
*
* Methods : userAuth, userAccount, editTask 
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
final class AdminController extends Controller
{

	public function userAuth()
	{
       View::jsonResponse();
	}

	public function userAccount()
	{
       View::jsonResponse(['status' => 200, 'tasks' => $tasks]);
	}

	public function manageTasks()
	{
	   $action = isset($this->request['action']) ?? : null;

       switch ($action) {
       	case 'update':
       		Task::update();
       		break;
       	case 'delete':
       		Task::delete();
       		break;
       	default:
       		# code...
       		break;
       }
	}
}