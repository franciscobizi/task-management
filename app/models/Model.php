<?php

namespace FB\models;

use FB\db\DataBase;

/**
* Model class for working with DB 
*
* PHP Version 7+
*
* Methods : query, queryCount
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
class Model extends DataBase
{

    public static function create($data)
    {
        $fields = array_keys($data);

        foreach ($fields as $key) {
            $values[] = ":$key";
            $columns[] = "$key";
        }

        foreach ($data as $key => $value) {
            $n_data[":$key"] = $value;
        }
        
        $col = implode($columns, ",");
        $val = implode($values, ",");

        return parent::query("INSERT INTO {self::$table} ($col) VALUES ($val)", $n_data);
    }

    /**
    *   
    *  Method that list all tasks
    *  @param string $limit
    *  @param string $offset
    *  @return array $data
    */
    public static function all($table, $offset, $limit)
    {
        return parent::query("SELECT * FROM $table ORDER BY id DESC LIMIT $limit OFFSET $offset");
    }

    /**
    *   
    *  Method that find one task
    *
    *  @param string $id
    *  @return array $data 
    */
    public static function find($id)
    {
        return parent::query("SELECT * FROM self::$table WHERE id=:id", array(':id'=>$id));   
    }

    /**
    *   
    *  Method that update task
    *  @param array $data
    *  @return int $num 
    */
    public static function update($data)
    {
        $fields = array_keys($data);

        foreach ($fields as $key) {
            if ($key != 'id') {
                $fields = [
                            "$key=:$key"
                          ];
            }
        }

        $fields = implode($fields, ',');
        return parent::query("UPDATE self::$table SET $fields WHERE id=:id", $data);
    }

    /**
    *   
    *  Method that delete task
    *  @param array $data
    *  @return int $num 
    */
    public static function delete($id)
    {
        return parent::query("DELETE FROM self::$table WHERE id=:id", array(':id'=>$id));
    }

    /**
    *   
    *  Count total of rows
    *  
    *  @return int $num 
    */
    public static function countRows()
    {
        return parent::queryCount("SELECT COUNT(id) FROM self::$table");
    }

}
