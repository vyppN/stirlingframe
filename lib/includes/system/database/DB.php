<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DB
 *
 * @author Ai
 */
namespace system\database;

use system\database\Config;
use PDO;

class DB {
    private static $db;
    private $dbh;
    
    private function __construct() {
        try {
            $info = \system\Config::$database;
            $this->dbh = new PDO(
                    $info['driver'].":dbname=".
                    $info['database'].";host=".
                    $info['host'],
                    $info['user'],$info['password']
                    );
        } catch (PDOException $ex) {
            echo 'Connection failed: '.$ex->getMessage()."n";
            self::$db = null;
        }
    }
    
    private function __clone() { }
    
    public static function & instance(){
        if(!self::$db){
            self::$db = new DB();
        }
        return self::$db;
    }
    
    public static function changeDatabase($database){
        self::instance()->exec('USE '.$database);
    }
    
    public function __call($name, $arguments=array()) {
        return call_user_func_array(array($this->dbh,$name), $arguments);
    }
    
    public static function __callStatic($name, $arguments) {
        $db = self::instance();
        return call_user_func_array(array($db->dbh,$name), $arguments);
    }

}
