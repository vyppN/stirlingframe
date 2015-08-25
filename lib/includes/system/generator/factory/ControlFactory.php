<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/23/2015 AD
 * Time: 10:07 PM
 */

namespace system\generator\factory;

use system\generator\controls\TextBox;


class ControlFactory
{
    public function create($typeprop, $id, $cssprop,$addition=null)
    {
        $typeprop = 'system\\generator\\controls\\'.$typeprop;
        $control = new $typeprop($id);
        $control->setCss($cssprop);

        if($addition != null){
            foreach ($addition as $key => $vale) {
                $control->setAddition($key,$vale);
            }
        }

        return $control->getControl();
    }
}