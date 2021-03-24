<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../objects/TPO.php';

//get database connection
$db = new Database();
$conn = $db->getConnection();
$tpo = new TPO($conn);

$tpo_id = !empty($_POST['tpo_id']) ? $_POST['tpo_id'] : null;

if(!empty($tpo_id)){
    $tpo->tpo_id = $tpo_id;
    $stmt = $tpo->read();//can cause exception
    $email = $stmt->fetchColumn(3);
    //echo $email;
    $tpo->email = $email;

    $tpo->password = password_hash(substr(md5($email),0,8),PASSWORD_DEFAULT); 
    //echo $tpo->password;
    if($tpo->storeLoginCred()){
        echo json_encode(array("status"=>"success","msg"=>"login cred stored successfully"));     
    }
    else{
        echo json_encode(array("status"=>"failed","msg"=>"unable to store"));

    }
}