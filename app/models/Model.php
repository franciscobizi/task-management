<?php

namespace FB\models;

use FB\db\DataBase;

/**
* Model class for working with DB 
*
* PHP Version 7+
*
* Methods : create, find, update, delete, execute, countRows
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
class Model extends DataBase
{
    protected $table, $result;

    /**
    *   
    *  Method that create tasks
    *  @param array $data
    *  @return array $data
    */
    public function create($data)
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

        $this->result = parent::query("INSERT INTO $this->table ($col) VALUES ($val)", $n_data);
        return $this;
    }

    /**
    *   
    *  Method that list all tasks
    *  @param string $limit
    *  @param string $offset
    *  @return array $data
    */
    public function all($offset, $limit)
    {
        $this->result = parent::query("SELECT * FROM $this->table ORDER BY id DESC LIMIT $limit OFFSET $offset");
        return $this;
    }


    /**
    *   
    *  Method that find one task
    *
    *  @param string $id
    *  @return array $data 
    */
    public function find($id)
    {
        $this->result = parent::query("SELECT * FROM $this->table WHERE id=:id", array(':id'=>$id));
        return $this;   
    }

    /**
    *   
    *  Method that update task
    *  @param array $data
    *  @return int $num 
    */
    public function update($data)
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
        $this->result = parent::query("UPDATE $this->table SET $fields WHERE id=:id", $data);
        return $this;
    }

    /**
    *   
    *  Method that delete task
    *  @param array $data
    *  @return int $num 
    */
    public function delete($id)
    {
        $this->result = parent::query("DELETE FROM $this->table WHERE id=:id", array(':id'=>$id));
        return $this;
    }

    /**
    *   
    *  Count total of rows
    *  
    *  @return int $num 
    */
    public function countRows()
    {
        $this->result = parent::queryCount("SELECT COUNT(id) FROM $this->table");
        return $this;
    }
    
    /**
    *   
    *  Method that return the result after execution
    *
    *  @return array $data 
    */
    final public function execute()
    {
        return $this->result;
    }

}
