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
$student = new Student($conn);

$student_id = !empty($_POST['student_id']) ? sanitize($_POST['student_id']) : null;
$name = !empty($_POST['name']) ? sanitize($_POST['name']) : null;
$roll_no = !empty($_POST['roll_no']) ? sanitize($_POST['roll_no']) : null;
$branch_id = !empty($_POST['branch_id']) ? sanitize($_POST['branch_id']) : null;
$tpo_id = !empty($_POST['tpo_id']) ? sanitize($_POST['tpo_id']) : null;
$email = !empty($_POST['email']) ? sanitize($_POST['email']) : null;



if (!empty($student_id)) {
    $student->student_id = $student_id;
    fetch('id');
}
else if(!empty($name)&&!empty($branch_id)&&!empty($tpo_id)){
    $student->name = $name;
    fetch('name');

}
else if(!empty($roll_no)&&!empty($branch_id)&&!empty($tpo_id)){
    $student->roll_no = $roll_no;
    fetch('roll');
    
}
else if(!empty($branch_id)&&!empty($tpo_id)){
    fetch('branch');
    
}
else if(!empty($email)){
    $student->email = $email;
    fetch('email');
}
else{
    echo json_encode(array("status"=>"failed","msg"=>"Insufficient data"));
}

function fetch($filter){
    global $student,$branch_id,$tpo_id;
      
    $student->branch_id = $branch_id;
    $student->tpo_id = $tpo_id;

    
    if($stmt = $student->read($filter)){
        if ($stmt->rowCount()>0) {
            # code...
            $data = array("status"=>"succes","records"=> array());
            while($row = $stmt->fetch()){
                extract($row);
                $student_data = array(
                "student_id"                => $student_id,
                "name"                      => $name,
                "roll_no"                   => $roll_no,
                "branch"                    => $branch_name,
                "division"                  => $division,
                "email"                     => $email,
                "contact"                   => $contact,
                "dob"                       => $dob,
                "gender"                    => $gender,
                "institute"                 => $institute,
                "passout_year"              => $passout_year,
                "ssc_per"                   => $ssc_per,
                "hsc_dip_per"               => $hsc_dip_per,
                "current_course_agg"        => $current_course_agg,
                "sem1"                      => $sem1,
                "sem2"                      => $sem2,
                "sem3"                      => $sem3,
                "sem4"                      => $sem4,
                "sem5"                      => $sem5,
                "sem6"                      => $sem6,
                "sem7"                      => $sem7,
                "sem8"                      => $sem8,
                "active_kt"                 => $active_kt,
                "dead_kt"                   => $dead_kt,
                "dp"                        => $dp,
                "new_login"                 => $new_login
            );
            array_push($data['records'],$student_data);
            //echo "hello";
            }         
            $data['count'] = $stmt->rowCount();
            echo json_encode($data);
        }
        else{
            http_response_code(404);
            echo json_encode(array("status"=>"failed","msg"=>"NO record found"));

        }
    }
    else{
        http_response_code(500);
    }
}
    

