<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../../vendor/autoload.php';

require_once '../includes/autoloader.php';
use config\Database;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

//get posted data
$drive_id = !empty($_POST['drive_id']) ? $_POST['drive_id'] : null;
$email = !empty($_POST['email']) ? $_POST['email'] : null;
$package = !empty($_POST['package']) ? $_POST['package'] : null;

//Get database connection
$db = new Database();
$conn = $db->getConnection();
//instantiate student
$student = new Student($conn);
$placed_student = new PlacedStudent($conn);

$placed_student->drive_id = $drive_id;
$student->email = $email;
$placed_student->package = $package;

if ($stmt = $student->read('email')) {
   // echo $stmt->rowCount();
    if ($stmt->rowCount()>0) {
        $student_id = $stmt->fetchColumn(0);
        $placed_student->student_id = $student_id;
        if($placed_student->create()){
            echo json_encode(array("status"=>"success","msg"=>"Success"));      
        }
        else{
            http_response_code(500);
        }
    }
    else{
        echo 'fail';
    }
}
else{
    http_response_code(500);
}

