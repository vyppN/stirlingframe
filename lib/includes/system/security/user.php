<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/17/2015 AD
 * Time: 5:00 AM
 */

namespace system\security;


use system\kernel\Session;

class User extends Session implements IUser
{
    function setUser($userdata, array $roles)
    {
        parent::set('userdata',$userdata);
        parent::set('roles',$roles);
    }

    function hasSession()
    {
        if(parent::get('userdata') != null){
            return true;
        }
        return  false;
    }

    function getRoles(){
        return parent::get('roles');
    }

    function getUserData(){
        return parent::get('userdata');
    }
}