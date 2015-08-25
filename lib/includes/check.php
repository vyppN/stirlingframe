<?php

if(!preg_match('/^(506.{2})$/',PHP_VERSION_ID,$matches)){
    echo 'Needs PHP 5.6+, please update your PHP version';
    die();
}else{
    echo 'pass: PHP = '.PHP_VERSION_ID;
}