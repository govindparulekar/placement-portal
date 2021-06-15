<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 86400");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  
require_once '../includes/autoloader.php';
include_once '../includes/utility.inc.php';

use config\Database;
//get database connection
$db = new Database();
$conn = $db->getConnection();
$applied_student = new AppliedStudent($conn);

$drive_id = !empty($_GET['drive_id']) ? sanitize($_GET['drive_id']) : null;
$student_id = !empty($_GET['student_id']) ? sanitize($_GET['student_id']) : null;


if(!empty($drive_id)&&!empty($student_id)){

    $applied_student->drive_id = $drive_id;
    $applied_student->student_id = $student_id;
    if($stmt = $applied_student->checkIfApplied()){
        
        if($stmt->rowCount()>0){   
            echo json_encode(array("status"=>"success","msg"=>"Applied","c"=>$stmt->rowCount()));
            
        }
        else{
            
            echo json_encode(array("status"=>"success","msg"=>"Not applied"));
        }
    }
    else{
        http_response_code(500);
        echo json_encode(array("status"=>"failed","msg"=>"Unable to read at this moment.."));
    }
}
else{
    http_response_code(400);
    echo json_encode(array("status"=>"failed","msg"=>"Insufficient data"));

}


