<?php
/**
 * Created by PhpStorm.
 * User: vyppN
 * Date: 8/24/2015 AD
 * Time: 1:59 AM
 */

namespace system\annotation;


class Annotation
{
    const ANNOTATION_CONTROL = "/@(Control)(.*\\n?)/";
    const ANNOTATION_REFERENCE = "/@(Reference)(.*\\n?)/";
    const ANNOTATION_LABEL = "/@(Label)(.*\\n?)/";

    const PROP_TYPE = "/(type=)(\\w+)/";
    const PROP_CLASS = "/(class=){(.+)}/";
    const PROP_MODEL = '/(model=)(\\w+)/';
    const PROP_VALUE = '/(value=)(\\w+)/';
    const PROP_DISPLAY = '/(display=)(\\w+)/';
    const PROP_TEXT = "/\\((.*)\\)/";
}