<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/23/2015 AD
 * Time: 7:33 PM
 */

namespace system\security;


interface IUserGroup
{
    public function addRoles($role);
    public function getRoles();
}