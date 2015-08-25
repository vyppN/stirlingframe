<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/23/2015 AD
 * Time: 10:15 PM
 */

namespace system\generator\controls;


abstract class Control
{
    protected $id;
    protected $value;
    protected $style;
    protected $control;
    protected $cssClass;
    protected $addition;
    protected $label;

    /**
     * Control constructor.
     * @param $style
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->style = [];
        $this->addition = [];
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return array
     */
    public function getAddition()
    {
        return $this->addition;
    }

    /**
     * @param array $addition
     */
    public function setAddition($key,$addition)
    {
        $this->addition[$key] = $addition;

        if(@$this->addition['label']){
            $this->label = $this->addition['label'];
        }
    }

    protected function callStyle(){
        if(@$this->addition['style']){
            @$styles = $this->addition[style];
            foreach ($styles as $style) {
                if($style['id'] == $this->id){
                    $this->setStyle($style['style'],$style['value']);
                }
            }
        }

        if(@$this->addition['cssClass']){
            @$css = $this->addition['cssClass'];
            foreach ($css as $c) {
                if($c['id'] == $this->id){
                    $this->addClass($c['class']);
                }
            }

        }
    }

    public function getStyle(){
        return implode('; ',array_map(function($v,$k){return $k.' : '.$v;},$this->style,array_keys($this->style))).';';
    }

    public function setStyle($style,$value){
        $this->style[$style] = $value;
    }

    public function setCss($css){
        $this->cssClass = $css;
    }

    public function addClass($css){
        $this->cssClass .= ' '.$css;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCssClass()
    {
        return trim($this->cssClass);
    }

    public function getControl(){
        $data = '';
        if(@$this->addition['label']) {
            return "<label for'$this->id'>$this->label</label>$this->control";
        }else{
            return $this->control;
        }
    }
}