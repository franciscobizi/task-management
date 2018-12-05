<?php

namespace FB\db;

/**
* DataBase of application
* PHP Version 7+
*
* Methods : con
* @author Francisco Bizi <taylorsoft28@gmail.com>
*
*/
class DataBase 
{
	/**
	* Method thar return PDO object instance
	*
	* @return object $instance
	*/
	private static function con() 
	{

	    $pdo = new \PDO('mysql:host=localhost;dbname=dbtasks;', 'root', '');
	    $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
	    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	    return $pdo;
	}

	public static function query($query, $params = array()) 
    {
        $stmt = self::con()->prepare($query);
        $stmt->execute($params);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function queryCount($query) 
    {
        $count = self::con()->query($query)->fetchColumn();
        return $count;
    }

}
