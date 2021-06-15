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

$student_id = !empty($_POST['student_id']) ? sanitize($_POST['student_id']) : null;

if (!empty($student_id)) {
    $upload_dir = '../uploads/dp/';
    $file_name = $_FILES['dpfile']['name'];
    $file_temp_name = $_FILES['dpfile']['tmp_name'];  
    if(move_uploaded_file($file_temp_name,$upload_dir.$file_name)){
        $PATH = 'http://localhost/placement-portal/api/uploads/dp/'.$file_name;
        $query = "UPDATE student_basic_info SET dp = '$PATH' WHERE student_id = $student_id";
        $conn->query($query);
        echo json_encode(array("status"=>"success","msg"=>"dp upload success"));       
    }
    else{
        http_response_code(500);
    }

}
else{
    http_response_code(400);
}
