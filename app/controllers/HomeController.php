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
	// Display all tasks
	public function index()
	{
	   $task = (new Task())->all('0','3')->execute();
       View::jsonResponse(['status' => 200, 'tasks' => $task]);
	}

	// Add new task
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

        $add = ['name' => $this->request['name'], 'email' => $this->request['email'], 'task' => $this->request['task']];
        
        $add  = Validator::cleanData($add);

        if ($_FILES['image']['size'] != null) {
        	$upload = new Upload($_FILES['image'], 320, 240, ROOT_PATH."/build/img/tasks/");
        	$url = $upload->save();

            if (!$url) {
                View::jsonResponse(['status' => 401, 'message' => 'Image must be one of these extensions [gif, png, jpg]!']);
                exit;
            }

            $url =  basename($url);
        	$add['image'] = $url;

        	(new Task())->create($add)->execute();

       		View::jsonResponse(['status' => 200, 'message' => 'Task added successfully!']);
            exit;
        }
	}

	// Paginate tasks
	public function paginate()
	{	
		$page = $this->request['page_n'];
        $per_page = 3;
        $offset = ($page - 1) * $per_page;
        $total_rows = (new Task())->countRows()->execute();
        $total_pages = ceil($total_rows / $per_page);
        $task = (new Task())->all($offset, $per_page)->execute();

        View::jsonResponse(['status' => 200, 'tasks' => $task]);
         exit;
	}

	/*
    *  Method to display 404 code when page not match
    */
    public function error404()
    {
        return View::render('404'); 
    }
}