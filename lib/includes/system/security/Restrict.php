<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/23/2015 AD
 * Time: 7:17 PM
 */

namespace system\security;


class Restrict
{
    public static function create($path,array $roles){
        if(strpos($path,'.')){
            return new RestrictMethod($path,$roles);
        }else{
            return new RestrictController($path,$roles);
        }
    }
}