<?php
use system\security\RestrictController;
use system\security\RestrictMethod;
use system\security\Restrict;
require_once ROOT.'/system/security/authentication.php';
require_once dirname(dirname(__FILE__)).'/models/Role.php';
/*
 *
 * Restrict urls that must have authentication for access
 *
 *
 */
 return [

    /*
     *
     * Priority: if use Controller restriction, restriction method of that controller must be on top
     *
     */
    //new RestrictMethod('user.admin',[Role::ADMIN]),

    /*========================================================*/

    /*
     * Controller level authentication
     *
     * Usage 1: Restrict::create('controller',roles[])
     * usage 2: new RestrictController('controller',roles[])
     *
     */
//    Restrict::create('admin',[Role::ADMIN]),
//    new RestrictController('user',[Role::USER]),

    /*========================================================*/

    /*
     * Method level authentication
     *
     * Usage 1: Restrict::create('controller.method',roles[])
     * usage 2: new RestrictMethod('controller.method',roles[])
     *
     */

//    Restrict::create('product.love',[Role::USER]),
//    new RestrictMethod('product.admin',[Role::ADMIN]),

];