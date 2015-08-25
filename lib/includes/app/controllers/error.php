<?php
use system\kernel\Controller;
use system\kernel\View;

class ErrorController extends Controller{

    public function get_index($value){
        $data['error'] = $value;
        View::response('error.index',$data);
    }
}