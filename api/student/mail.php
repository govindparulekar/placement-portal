<?php
include_once '../config/Database.php';
include_once '../send-mail.php';
include_once '../objects/Student.php';

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
        }
    }
    else{
        echo 'failed';
    }
    
}

function setBody($username,$password){
    $body = "Use following credentials to login into placement portal.\nUsername: $username\nPassword: $password\nDo not share your password and don't forget to change password once you are loged in.";

    return $body;
}

