<?php

use system\kernel\Controller;
use system\generator\ControlGenerator;
use system\kernel\View;
use system\AiReflection;

class HomeController extends Controller {

    function get_index(){
        $data['welcome'] = 'Hello World';
        View::response('home.index',$data);
    }
}
