<?php

namespace FB\models;

use FB\models\Model;

/**
* Task Model class for working with table tasks
*
* PHP Version 7+
*
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
final class Task extends Model 
{
	protected $table = 'tasks';

	public function __construct()
	{
		$this->table;
	}
}
