<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../includes/autoloader.php';
include_once '../includes/utility.inc.php';

use config\Database;

//get database connection
$db = new Database();
$conn = $db->getConnection();
$tpo = new TPO($conn);

//get tpo info from tpo
$inst_id = !empty($_POST['inst_id']) ? $_POST['inst_id'] : null;
$first_name = !empty($_POST['first_name']) ? $_POST['first_name'] : null;
$last_name = !empty($_POST['last_name']) ? $_POST['last_name'] : null;
$email = !empty($_POST['email']) ? $_POST['email'] : null;
$inst_name = !empty($_POST['inst_name']) ? $_POST['inst_name'] : null;
$contact = !empty($_POST['contact']) ? $_POST['contact'] : null;
$inst_addr = !empty($_POST['inst_addr']) ? $_POST['inst_addr'] : null;
$created_at;


if(
    !empty($inst_id)&&
    !empty($first_name)&&
    !empty($last_name)&&
    !empty($email)&&
    !empty($inst_name)&&
    !empty($contact)&&
    !empty($inst_addr)
){
    $tpo->tpo_id = $inst_id;
    $tpo->first_name = $first_name;
    $tpo->last_name = $last_name;
    $tpo->email = $email;
    $tpo->inst_name = $inst_name;
    $tpo->inst_addr = $inst_addr;
    $tpo->contact = $contact; 
    $tpo->created_at = date('Y-m-d H:i:s');

    
    switch ($tpo->isRegistered()) {//checking rowcount
        case 0:// no record found
            if($tpo->register()){
                echo json_encode(array("status"=>"success","msg"=>"User registered successfully"));
            }
            else{
                echo json_encode(array("status"=>"failed","msg"=>"unable to register"));
            }      
            break;
        case 1://1 record found
            echo json_encode(array("status"=>"failed","msg"=>"user exists"));
            break;
        default://query execution error
            echo json_encode(array("status"=>"failed","msg"=>"unable to register"));
            
            break;
    }
       
}
else{
    echo json_encode(array("status"=>"failed","msg"=>"Insufficient data"));
  
}
