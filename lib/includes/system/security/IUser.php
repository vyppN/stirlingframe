<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/18/2015 AD
 * Time: 12:50 AM
 */

namespace system\security;


interface IUser
{
    function setUser($userdata,array $roles);
    function hasSession();
}