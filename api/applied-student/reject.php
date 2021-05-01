<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 86400");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  
require_once '../includes/autoloader.php';
include_once '../includes/utility.inc.php';

use config\Database;
//get database connection
$db = new Database();
$conn = $db->getConnection();
$applied_student = new AppliedStudent($conn);

$student_id_array = !empty($_POST['student_id_array']) ? $_POST['student_id_array']: null;

if(!empty($student_id_array)){
    if($applied_student->remove($student_id_array)){
    echo json_encode(array("status"=>"success","msg"=>"Operation Successful"));

    }
    else{
        http_response_code(500);
        echo json_encode(array("status"=>"failed","msg"=>"Unable to read at this moment.."));
    }
}
else{
    echo json_encode(array("status"=>"failed","msg"=>"Insufficient data"));

}