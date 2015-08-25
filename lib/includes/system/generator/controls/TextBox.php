<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/23/2015 AD
 * Time: 10:08 PM
 */

namespace system\generator\controls;


class TextBox extends Control implements IControl
{
    public function __construct($id)
    {
        parent::__construct($id);
    }


    public function getValue()
    {
        // TODO: Implement getValue() method.
    }

    public function setValue($value)
    {
        // TODO: Implement setValue() method.
    }

    public function setVisible($visible)
    {
        // TODO: Implement setVisible() method.
    }

    public function getControl()
    {
        /**
         * Always do this before create HTML
         */
        $this->callStyle();

        $this->control = "<input type='text' id='".$this->id."' class='".$this->getCssClass()."' style='".$this->getStyle()."'/>";
        return parent::getControl();
    }
}