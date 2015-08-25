<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/23/2015 AD
 * Time: 11:35 PM
 */

namespace system\generator\controls;


class Select extends Control implements IControl
{
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
        $option = $this->addition['option'];
        $val = $this->addition['value'];
        $display = $this->addition['display'];

        $options = "<option></option>";
        foreach ($option as $opt) {
            $options .= "<option value='".$opt->$val."'>".$opt->$display."</option>";
        }

        /**
         * Always do this before create HTML
         */
        $this->callStyle();

        $this->control = "<select id='".$this->id."' class='".$this->getCssClass()."' style='".$this->getStyle()."'>".$options."</select>";

        return parent::getControl();
    }

}