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
$branch_id = !empty($_GET['branch_id']) ? sanitize($_GET['branch_id']) : null;
$q = !empty($_GET['q']) ? sanitize($_GET['q']) : null;

    
if(!empty($drive_id)&&!empty($branch_id)&&!empty($q)){
    
    if($stmt = $applied_student->read($drive_id,$branch_id,$q)){
        if($stmt->rowCount()>0){
            $data = prepareJSON($stmt,$q);     
            echo json_encode($data);      
        }
        else{
            http_response_code(404);
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


/*-----------------------------------------functions--------------------------------------------*/
function prepareJSON($stmt,$q){
    $data = array("status"=>"succes","records"=> array());
            while($row = $stmt->fetch()){
                extract($row);
                if($q == "all"){
                    $applied_student_data = array(
                        "student_id"        => $student_id,
                        "student_name"    => $name,
                        "roll_no"     => $roll_no
                    );
                }
                else{
                    $applied_student_data = array(
                        "student_id"        => $student_id,
                        "student_name"    => $name,
                        "roll_no"     => $roll_no,
                        "package"     => $package
                    );
                }
                
            array_push($data['records'],$applied_student_data);
            }  
            $data["count"] = $stmt->rowCount();
            return $data;
}

function export(){

}