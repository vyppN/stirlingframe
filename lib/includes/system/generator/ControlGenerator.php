<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/23/2015 AD
 * Time: 10:01 PM
 */

namespace system\generator;


use system\annotation\Annotation;
use system\generator\factory\ControlFactory;

class ControlGenerator
{
    private $class;
    private $control;

    private $style;
    private $addition;

    public function setClass($class){
        $this->class = $class;
    }
    public function generate(){
        $classReflect = new \ReflectionClass($this->class);
        $classDoc = $classReflect->getDocComment();
        $this->genControl();
    }

    public function addStyle($id,$style,$value){
        $classname = strtolower($this->class);
        $this->style[] = ['id'=> $classname.'_'.$id,'style' =>$style ,'value' => $value];
    }

    public function addCSS($id,$cssClass){
        $classname = strtolower($this->class);
        $this->addition['cssClass'][] = ['id'=> $classname.'_'.$id,'class'=>$cssClass];
    }

    public function getControl(){
        return $this->control;
    }

    private function genControl(){


        $props = get_class_vars($this->class);
        $classname = strtolower($this->class);

        $factory = new ControlFactory();

        $reflection = new ReflectionHelper();

        foreach ($props as $key=>$value) {

            $id = $classname.'_'.$key;

            $varReflect = new \ReflectionProperty($this->class,$key);
            $varDoc =$varReflect->getDocComment();

            // Control
            $controlProperties = $reflection->checkPatternWithMultipleParams(Annotation::ANNOTATION_CONTROL,$varDoc);
            @$typeprop = $reflection->checkPatternWithMultipleParams(Annotation::PROP_TYPE,$controlProperties);
            @$cssprop = $reflection->checkPatternWithMultipleParams(Annotation::PROP_CLASS,$controlProperties);

            //Reference
            @$referenceProperties = $reflection->checkPatternWithMultipleParams(Annotation::ANNOTATION_REFERENCE,$varDoc);

            //Label
            @$labelProperties = $reflection->checkPatternWithMultipleParams(Annotation::ANNOTATION_LABEL,$varDoc);


            //-------- Additional parameters -------------//
            if($referenceProperties || $labelProperties) {

                @$modelprop = $reflection->checkPatternWithMultipleParams(Annotation::PROP_MODEL,$referenceProperties);
                @$valprop = $reflection->checkPatternWithMultipleParams(Annotation::PROP_VALUE,$referenceProperties);
                @$displayprop = $reflection->checkPatternWithMultipleParams(Annotation::PROP_DISPLAY,$referenceProperties);
                @$text = $reflection->checkPatternWithSingleParams(Annotation::PROP_TEXT,$labelProperties);

                if($modelprop) {
                    $option = (new $modelprop)->get();
                    $this->addition['option'] = $option;
                    $this->addition['value'] = $valprop;
                    $this->addition['display'] = $displayprop;

                }
                if($text){
                    $this->addition['label'] = $text;
                }

            }
            $this->addition['style'] = $this->style;
            $this->control .= $factory->create($typeprop,$id,$cssprop,$this->addition);
        }

    }

}