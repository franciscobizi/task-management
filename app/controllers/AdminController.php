<?php

namespace FB\controllers;

use FB\src\{View, Auth, Validator};
use FB\models\Task;

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
		
        $data = [ 'username' => $_POST['username'], 'password' => $_POST['password'] ];

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

    /**
    *   
    *  Method that display user account
    *
    *  @return array $data
    */
	public function userAccount()
	{
        $per_page = 4;
        $total_rows = (new Task())->countRows()->execute();
        $total_pages = ceil($total_rows / $per_page);
        $data = (new Task())->all('0','4')->execute();
        $pages = ['total_pages' => $total_pages, 'current_page' => 1];
        $data = [$data, $pages];
        View::render('userprofile', $data);
	}

	/**
    *   
    *  Method that logout
    *
    *  @return void
    */
	public function userLogOut() : void
	{
		if(Auth::loggedOut()){
			header('location: admin');
		}
	}

	/**
    *   
    *  Method for changing tasks status
    *
    *  @return void
    */
    public function status() : void
    {
        $jwt = Auth::isValidToken($_COOKIE['SSID']);
        
        if (!$jwt) {
            View::jsonResponse(['status' => 401, 'message'   => 'Access denied for you!']);
        }

        $data = [ 'status' => $_POST['status'], 'id' => $_POST['statusid']];
        $data  = Validator::cleanData($data);
        (new Task())->update($data)->execute();
        header('location: user-profile');

    }


    /**
    *   
    *  Method for editing tasks
    *
    *  @return void
    */
	public function editTask()
	{
		$jwt = Auth::isValidToken($_COOKIE['SSID']);
        
        if (!$jwt) {
            View::jsonResponse(['status' => 401, 'message'   => 'Access denied for you!']);
        }

        $update = [ 'task' => $_POST['etask'], 'id' => $_POST['taskid']];
        $update  = Validator::cleanData($update);

        if (Validator::isEmpty($update)) {
            View::jsonResponse(['status' => 401, 'message'   => 'There are empty fields!']);
        }

        (new Task())->update($update)->execute();

        View::jsonResponse(['status' => 200, 'message'   => 'Task edited successful!']);    
        
	}
}