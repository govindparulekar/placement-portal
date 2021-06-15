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

$applied_student = new AppliedStudent($conn);

$drive_id= !empty($_POST['drive_id']) ? sanitize($_POST['drive_id']) : null;
$student_id = !empty($_POST['student_id']) ? sanitize($_POST['student_id']) : null;

if(!empty($drive_id)&&!empty($student_id)){
    $applied_student->drive_id = $drive_id;
    $applied_student->student_id = $student_id;
    if ($applied_student->create()) {
        echo json_encode(array("status"=>"success","msg"=>"Application Sent"));
        
    }
}
else{
    http_response_code(500);
    echo json_encode(array("status"=>"failed","msg"=>"Insufficient data"));

}


