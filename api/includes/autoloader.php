<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
spl_autoload_register('loader');

function loader($class_name){
    if($class_name == 'config\Database'){
        $class_name = 'config/Database';
    }
    $dir = $_SERVER['DOCUMENT_ROOT']."/placement-portal/api/classes/";
    $ext = ".php";
    $class_file_path = $dir.$class_name.$ext;

    //echo "\n".$class_file_path."\n";
    if ($e = file_exists($class_file_path)) {
        include_once $class_file_path;
    }
    else{
        echo var_dump($e);
    }

}
