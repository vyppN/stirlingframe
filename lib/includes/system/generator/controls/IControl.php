<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/23/2015 AD
 * Time: 10:08 PM
 */

namespace system\generator\controls;


interface IControl
{
    const Hidden = 'none';
    const Visible = 'block';
    const Checked = 'checked';
    const Unchecked = '';


    /**
     * @return value of control
     */
    public function getValue();


    /**
     * @param $value value of control
     * @return mixed
     */
    public function setValue($value);


    /**
     * @param $visible set visible
     * @return mixed
     */
    public function setVisible($visible);

    /**
     * @return mixed
     */
    public function getControl();
}