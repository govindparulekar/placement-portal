<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../objects/DriveUpdate.php';
include_once '../utility.php';


//get database connection
$db = new Database();
$conn = $db->getConnection();
$drive = new DriveUpdate($conn);

$drive_update = new DriveUpdate($conn);
$drive_id = !empty($_POST['drive_id']) ? sanitize($_POST['drive_id']) : null;

if(!empty($drive_id)){
    $drive_update->drive_id = $drive_id;
    if($stmt = $drive_update->read()){
        if($stmt->rowCount()>0){
            $data = array("status"=>"succes","records"=> array());
            while($row = $stmt->fetch()){
                extract($row);
                $drive_update_data = array(
                "id"        => $id,
                "description"    => $description,
                "date_created"     => $date_created,
                "time_created"     => $time_created
            );
            array_push($data['records'],$drive_update_data);
            }        
            echo json_encode($data);
            
        }
        else{
            echo json_encode(array("status"=>"failed","msg"=>"NO record found"));
        }
    }
    else{
        echo json_encode(array("status"=>"failed","msg"=>"Unable to read at this moment.."));
    }
}
else{
    echo json_encode(array("status"=>"failed","msg"=>"Insufficient data"));

}