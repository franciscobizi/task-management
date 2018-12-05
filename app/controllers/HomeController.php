<?php

namespace FB\controllers;

use FB\src\{View, Upload, Validator}; 
use FB\models\Task;

/**
* HomeController  
*
* PHP Version 7+
*
* Methods : index, 
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
final class HomeController extends Controller
{

	public function index()
	{
	   $tasks = Task::all('tasks','0','3');
       View::jsonResponse(['status' => 200, 'tasks' => $tasks]);
	}

	public function addTask()
	{
       if (Validator::isEmpty($this->request)) {
            View::jsonResponse(['status' => 401, 'message' => 'There are empty fields!']);
            exit;
        }

        if (!Validator::isEmail($this->request['email'])) {
            View::jsonResponse(['status' => 401, 'message' => 'Invalid email!']);
            exit;
        }

        if ($_FILES['file']['size'] != null) {
        	$upload = new Upload($_FILES['file'], 320, 240, ROOT_PATH."/assets/img/tasks/");
        	$url = $upload->save();

            if (!$url) {
                View::jsonResponse(['status' => 401, 'message' => 'Image must be one of these extensions [gif, png, jpg]!']);
                exit;
            }

            $url =  basename($url);
        	$add['image'] = $url;
        	$add['created_at'] = date("Y-m-d h:i:s");
        	Task::create($add);

       		View::jsonResponse(['status' => 200, 'message' => 'Task added successfully!']);
            exit;
        }
	}

	public function paginateTask()
	{
       $tasks = Task::where();
       View::jsonResponse(['status' => 200, 'tasks' => $tasks]);
	}
}