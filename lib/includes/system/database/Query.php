<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Query
 *
 * @author Ai
 */
namespace system\database;

use PDO;

class Query {

    private $table;
    private $where = array();
    private $limit;
    private $bindings = array();

    public function __construct($table) {
        $this->table = $table;
    }

    public function where($key, $oper, $value) {
        $this->where[] = "AND " . $key . ' ' . $oper . ' ' . "?";
        $this->bindings[] = $value;
    }

    public function limit($limit = 10) {
        $this->limit = $limit;
    }

    public function get($columns = "*", $fetch_mode = PDO::FETCH_ASSOC, $class_name = '') {
        $sql = "SELECT " . $columns . " FROM " . $this->table . $this->getWhere() . $this->getLimit();
        $sth = DB::prepare($sql);
        if ($fetch_mode == PDO::FETCH_CLASS) {
            $sth->setFetchMode($fetch_mode, $class_name);
        } else {
            $sth->setFetchMode($fetch_mode);
        }

        for ($i = 1; $i <= count($this->bindings); $i ++) {
            $sth->bindParam($i, $this->bindings[$i - 1]);
        }
        $sth->execute();
        $data = $sth->fetchAll();
        return $data;
    }
    
    public function delete(){
        $sql = "DELETE FROM ".$this->table.$this->getWhere();
        $sth = DB::prepare($sql);
        $sth->execute();
    }

    public function first($columns = '*', $fetch_mode = PDO::FETCH_ASSOC, $class_name = '') {

        return @array_shift($this->get($columns, $fetch_mode, $class_name));
    }

    public function save($attributes = array(), $id_name = "id") {
        $attributes = $this->matchColumn($attributes);
        if (isset($attributes[$id_name])) {
            $sql = $this->getUpdate($attributes, $id_name);
        } else {
            $sql = $this->getInsert($attributes);
        }
        $sth = DB::prepare($sql);
        $sth->execute($attributes);
    }

    private function getInsert($attribute = array()) {
        $keys = array_keys($attribute);
        return "INSERT INTO " . $this->table . "(" . implode(",", $keys) . ")" . " VALUES(:" . implode(",:", $keys) . ")";
    }

    private function getUpdate($attribute, $id_name) {
        $updates = '';
        foreach ($attribute as $key => $value) {
            $updates.=$key . '=:' . $key . ',';
        }
        $updates = rtrim($updates, ',');
        return "UPDATE " . $this->table . " SET " . $updates . " WHERE " . $id_name . "=:" . $id_name;
    }

    private function getWhere() {
        if (empty($this->where)) {
            return '';
        }
        $where_sql = ' Where ' . ltrim(implode(" ", $this->where), "ANDOR");
        return $where_sql;
    }

    private function getLimit() {
        if (isset($this->limit)) {
            return " Limit " . $this->limit;
        }
    }

    private function matchColumn($attributes) {
        $new = array();
        $statement = DB::query('DESCRIBE ' . $this->table);
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            if (isset($attributes[$row['Field']])) {
                $new[$row['Field']] = $attributes[$row['Field']];
            }
        }
        return $new;
    }

}
