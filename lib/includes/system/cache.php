<?php

// Setting
$cachedir = ROOT.'/system/cache/';
$cachtime = 120;
$cachtext = 'cache';

//ignore list

$ignore_list = [
//    'path_to_ignore'
];

$page = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$cachefile = $cachedir.md5($page).'.'.$cachtext;

$ignore_page = false;
for($i = 0;$i<count($ignore_list);$i++){
    $ignore_page = (strpos($page,$ignore_list[$i]) !== false) ? true:$ignore_page;
}

$cachefile_created = ((@file_exists($cachefile)) and ($ignore_page === false))  ? @filemtime($cachefile):0;

//if(time() - $cachtime < $cachefile_created){
//    @readfile($cachefile);
//
//    exit();
//}

$files = scandir($cachedir);
foreach ($files as $key=>$vale) {
    if(!in_array($vale,array('.','..'))){
        if(time()-$cachtime > filemtime($cachedir.$vale)){
            unlink($cachedir.$vale);
        }
    }
}


