<?php

namespace FB\controllers;

use FB\src\{View, Auth, Validator};
use FB\src\Task;

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

	/**
    *   
    *  Method that render the admin page
    */
	public function index()
	{
		View::render('admin');
	}

	/**
    *   
    *  Authentication method
    *
    *  @return void
    */
	public function auth()
	{
		
        $data = [
					'username' => $_POST['username'],
					'password' => $_POST['password']
				];

		$data  = Validator::cleanData($data);

        if (Validator::isEmpty($data)) {
            View::jsonResponse(['status' => 401, 'message'   => 'There are empty fields!']);
        }

        Auth::loginUser($data['username'], $data['password']);

		if (Auth::isLoggedIn()) {
			View::jsonResponse(['status' => 200, 'message'   => 'authorized']);
		}else{
            View::jsonResponse(['status' => 401, 'message'   => 'Email or password invalid!']);
		}
	}

	public function userAccount()
	{
       View::jsonResponse(['status' => 200, 'tasks' => $tasks]);
	}

	public function manageTasks()
	{
	   $action = isset($this->request['action']) ?? null;

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