<?php
spl_autoload_register('loader');

function loader($class_name){
    $dir = $_SERVER['DOCUMENT_ROOT']."/placement-portal/api/classes/";
    $ext = ".php";
    $class_file_path = $dir.$class_name.$ext;

    //echo "\n".$class_file_path."\n";
    if (file_exists($class_file_path)) {
        include_once $class_file_path;
    }
    else{
        echo 'class file isnt found';
    }

}