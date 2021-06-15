<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../includes/autoloader.php';
use config\Database;
//get database connection
$db = new Database();
$conn = $db->getConnection();
$drive = new Drive($conn);

$drive_id = !empty($_POST['drive_id']) ? $_POST['drive_id'] : null;

if(!empty($drive_id)){
    $drive->drive_id = $drive_id;
    if ($drive->delete()) {
        echo json_encode(array("status"=>"success","msg"=>"Ended successfully"));
        
    }
    else{
        http_response_code(500);
        echo json_encode(array("status"=>"failed","msg"=>"Insufficient data"));
    }
}
else{
    http_response_code(400);
    echo json_encode(array("status"=>"failed","msg"=>"Insufficient data"));

}