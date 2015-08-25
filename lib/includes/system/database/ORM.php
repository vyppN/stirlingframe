<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ORM
 *
 * @author Ai
 */
namespace system\database;
use PDO;

abstract class ORM {

    private $query;

    public function __construct() {
        $this->query = new Query($this->table());
    }

    public function find($id, $column = "*") {
        $static = new static;
        return $static->where('id', '=', $id)->first($column);
    }

    public function first($columns = "*") {
        return @array_shift($this->get($columns));
    }

    public function get($columns = "*") {
        return $this->query->get($columns, PDO::FETCH_CLASS, get_called_class());
    }
    
    public function delete(){
        $this->query->delete();
    }

    public function save($id_name = "id") {
        $this->query->save((array) $this, $id_name = "id");
    }

    public function table() {
        if (isset($this->table))
            return $this->table;
        else {
            return Utility::GetTable(get_called_class());
        }
    }

    public function __call($name, $arguments) {
        call_user_func_array(array($this->query, $name), $arguments);
        return $this;
    }

    public static function __callStatic($method, $args = array()) {
        $static = new Static;

        call_user_func_array(array($static->query, $method), $args);

        return $static;
    }

}
