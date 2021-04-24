<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../includes/autoloader.php';
include_once '../includes/utility.inc.php';
require_once '../includes/send-mail.inc.php';

use config\Database;
//get database connection
$db = new Database();
$conn = $db->getConnection();
$student = new Student($conn);

$tpo_id = !empty($_POST['tpo_id']) ? $_POST['tpo_id'] : null;
$sub = 'Placement Portal Login Credentials';


if(!empty($tpo_id)){
    $student->tpo_id = $tpo_id;
    if($stmt = $student->readByEmailSent()){
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){   
                extract($row);
                $student->student_id = $student_id;
                $body = setBody($username,$password);
                //echo "$email $password\n";
                if(sendMail(FROM,$email,$sub,$body)){
                    $student->setEmailSent();
                }     
                
            }
            echo json_encode(array("status"=>"success","msg"=>"Mailed successfully"));
        }
        else{
            echo json_encode(array("status"=>"success","msg"=>"Already emailed"));
        }
    }
    else{
        http_response_code(500);
        echo json_encode(array("status"=>"failed","msg"=>"Something went wrong.."));
    }
    
}

function setBody($username,$password){
    $body = "Use following credentials to login into placement portal.\nUsername: $username\nPassword: $password\nDo not share your password and don't forget to change password once you are loged in.";

    return $body;
}

