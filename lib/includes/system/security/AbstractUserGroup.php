<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/23/2015 AD
 * Time: 7:38 PM
 */

namespace system\security;


abstract class AbstractUserGroup implements IUserGroup
{
    private $roles;

    /**
     * UserGroup constructor.
     */
    public function __construct()
    {
        $this->roles = array();
    }



    public function addRoles($role)
    {
        $this->roles[] = $role;
    }

    public function getRoles()
    {
        return $this->roles;
    }

}