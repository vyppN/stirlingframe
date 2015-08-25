<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utility
 *
 * @author Ai
 */
namespace system\database;

class Utility {
    public static function GetTable($classname){
        if(substr(strtolower($classname), -1)=="y")
                    return strtolower(substr($classname,0,  strlen($classname)-1) . "ies");
            else if(substr(strtolower($classname), -1)=="s")
                    return strtolower($classname . "es");
            else if(substr(strtolower($classname), -1)=="f")
                    return strtolower(substr($classname,0,  strlen($classname)-1) . "ves");
            else
            return strtolower($classname . "s");
    }
}
