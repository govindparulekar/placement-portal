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

$db = new Database();
$conn = $db->getConnection();

$drive_update = new DriveUpdate($conn);

$drive_id = !empty($_POST['drive_id']) ? sanitize($_POST['drive_id']) : null;
$description = !empty($_POST['description']) ? sanitize($_POST['description']) : null;

if (!empty($drive_id)&&!empty($description)) {
    # code...
    $drive_update->drive_id = $drive_id;
    $drive_update->description = $description;

    if ($drive_update->create()) {
        # code...
        echo json_encode(array("status"=>"success","msg"=>"created successfully")); 
    }
    else{
        echo json_encode(array("status"=>"failed","msg"=>"something went wrong.."));

    }

}
else{
    echo json_encode(array("status"=>"failed","msg"=>"Insufficient Data"));

}

