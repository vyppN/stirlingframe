<?php

namespace system;

class AiReflection
{
    private $class;

    /**
     * Reflection constructor.
     * @param $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }


    public function generate(){
        $classReflect = new \ReflectionClass($this->class);
        $classDoc = $classReflect->getDocComment();
        $this->getControl($classDoc);
//        preg_match_all('#@(.*?)\n#s', $classDoc, $classAnnotations);
//        var_dump($classAnnotations[1]);
//        $props = get_class_vars($this->class);
//
//        foreach ($props as $key=>$value) {
//            $varReflect = new \ReflectionProperty($this->class,$key);
//            $varDoc =$varReflect->getDocComment();
//            preg_match_all('#@(.*?)\n#s', $varDoc, $varAnnotations);
//            var_dump($varAnnotations[1]);
//        }
    }

    public function getControl($classDoc){
        $control = "/@(Control)(.*\\n?)/";

        $props = get_class_vars($this->class);

        foreach ($props as $key=>$value) {
            $varReflect = new \ReflectionProperty($this->class,$key);
            $varDoc =$varReflect->getDocComment();
            preg_match_all($control, $varDoc, $varAnnotations);


            echo $key.': ';
            echo $varAnnotations[2][0];
            echo '<br/>';
        }

    }
}