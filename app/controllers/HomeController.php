<?php

namespace FB\controllers;

use FB\src\{View, Upload, Validator}; 
use FB\models\Task;

/**
* HomeController  
*
* PHP Version 7+
*
* Methods : index, addTask 
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
final class HomeController extends Controller
{
	/**
    * Display all tasks on home page
    */
	public function index()
	{
	   $per_page = 4;
        $total_rows = (new Task())->countRows()->execute();
        $total_pages = ceil($total_rows / $per_page);
        $data = (new Task())->all('0','4')->execute();
        $pages = ['total_pages' => $total_pages, 'current_page' => 1];
        $data = [$data, $pages];
        View::render('index', $data);
	}

	
    /*
    *  Add new task
    */
	public function addTask()
    {
        $add = ['name' => $_POST['name'], 'email' => $_POST['email'], 'task' => $_POST['task']];

        if (Validator::isEmpty($add)) {
            View::jsonResponse(['status' => 401, 'message' => 'There are empty fields!']);
        }

        if (!Validator::isEmail($add['email'])) {
            View::jsonResponse(['status' => 401, 'message' => 'Invalid email!']);
        }

        
        $add  = Validator::cleanData($add);

        if ($_FILES['image']['size'] != null) {
        	$upload = new Upload($_FILES['image'], 320, 240, ROOT_PATH."/build/img/tasks/");
        	$url = $upload->save();

            if (!$url) {
                View::jsonResponse(['status' => 401, 'message' => 'Image must be one of these extensions [gif, png, jpg]!']);
            }

            $url =  basename($url);
        	$add['image'] = $url;

        	(new Task())->create($add)->execute();

       		View::jsonResponse(['status' => 200, 'message' => 'Task added successfully!']);
        }
	}

    /*
    *  Paginate tasks
    */
	public function paginate()
	{	
		$page = $_POST['page_n'];
        $per_page = 4;
        $offset = ($page - 1) * $per_page;
        $task = (new Task())->all($offset, $per_page)->execute();

        View::jsonResponse(['status' => 200, 'tasks' => $task]);
	}

	/*
    *  Method to display 404 code when page not match
    */
    public function error404()
    {
        return View::render('404'); 
    }
}