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
$drive = new DriveUpdate($conn);

$drive_update = new DriveUpdate($conn);
$id = !empty($_POST['id']) ? sanitize($_POST['id']) : null;

if(!empty($id)){
    $drive_update->id = $id;
    if($drive_update->delete()){         
        echo json_encode(array("status"=>"success","msg"=>"Deleted Successfully"));
        
    }
    else{
        echo json_encode(array("status"=>"failed","msg"=>"Unable to read at this moment.."));
    }
}
else{
    echo json_encode(array("status"=>"failed","msg"=>"Insufficient data"));

}