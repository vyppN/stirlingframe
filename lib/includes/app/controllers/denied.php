<?php
use system\kernel\Controller;

class DeniedController extends Controller
{
    function get_index(){
        echo 'ACCESS DENIED!!';
    }
}