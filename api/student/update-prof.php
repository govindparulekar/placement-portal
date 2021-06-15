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
/*-------------General info---------------------------*/
$email = !empty($_POST['email']) ? sanitize($_POST['email']) : null;
$contact = !empty($_POST['contact']) ? sanitize($_POST['contact']) : null;
$dob = !empty($_POST['dob']) ? sanitize($_POST['dob']) : null;
$gender = !empty($_POST['gender']) ? sanitize($_POST['gender']) : null;
$passout_year = !empty($_POST['passout_year']) ? sanitize($_POST['passout_year']) : null;
$institute = !empty($_POST['institute']) ? sanitize($_POST['institute']) : null;
//$dpfile = !empty($_POST['dpfile']) ? sanitize($_POST['dpfile']) : null;

/*-------------Academic info---------------------------*/
$ssc_per = !empty($_POST['ssc_per']) ? sanitize($_POST['ssc_per']) : null;
$hsc_dip_per = !empty($_POST['hsc_dip_per']) ? sanitize($_POST['hsc_dip_per']) : null;
$sem1 = $_POST['sem1'];
$sem2 = $_POST['sem2'];
$sem3 = $_POST['sem3'];
$sem4 = $_POST['sem4'];
$sem5 = $_POST['sem5'];
$sem6 = $_POST['sem6'];
$sem7 = $_POST['sem7'];
$sem8 = $_POST['sem8'];
$active_kt = !empty($_POST['active_kt']) ? sanitize($_POST['active_kt']) : null;

$cca = !empty($_POST['cca']) ? sanitize($_POST['cca']) : null;


if (!empty($email)&&!empty($contact)&&!empty($dob)&&!empty($gender)&&!empty($passout_year)&&!empty($institute)&&!empty($student_id)) {
    $student->email = $email;
    $student->contact = $contact;
    $student->dob = $dob;
    $student->gender = $gender;
    $student->passout_year = $passout_year;
    $student->institute = $institute;
    $student->student_id = $student_id;

    //echo ($ssc_per,$hsc_dip_per,$cca,$active_kt,$sem1,$sem2,$sem3,$sem4,$sem5,$sem6,$sem7,$sem8);
   // $str = "$ssc_per $hsc_dip_per $cca $active_kt $sem1 $sem2 $sem3 $sem4 $sem5 $sem6 $sem7 $sem8";
   //echo $str;

    if ($student->saveGeneralInfo()&&$student->saveAcadInfo($ssc_per,$hsc_dip_per,$sem1,$sem2,$sem3,$sem4,$sem5,$sem6,$sem7,$sem8,$cca,$active_kt)) {
        //echo json_encode(array("status"=>"success","msg"=>"Mailed successfully"));
        $query = "UPDATE student_basic_info SET new_login = 0 WHERE student_id = $student_id";
        $conn->query($query);
        echo json_encode(array("status"=>"success","msg"=> "success"));
        
    }
    else{
    http_response_code(500);  
    }
}
else{
    http_response_code(400);
}
    

