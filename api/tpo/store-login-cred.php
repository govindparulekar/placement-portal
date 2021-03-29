<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../objects/TPO.php';
include_once '../send-mail.php';

//get database connection
$db = new Database();
$conn = $db->getConnection();
$tpo = new TPO($conn);

$tpo_id = !empty($_POST['tpo_id']) ? $_POST['tpo_id'] : null;

if(!empty($tpo_id)){
    $tpo->tpo_id = $tpo_id;
    $stmt = $tpo->read();//can cause exception
    $email = $stmt->fetchColumn(3);
    //echo $email;
    $tpo->email = $email;
    $pass_text = substr(md5($email),0,8);

    $tpo->password = password_hash($pass_text,PASSWORD_DEFAULT); 
    //echo $tpo->password;
    if($tpo->storeLoginCred()){
        //prepare to send mail
        $from = 'govindvp511@gmail.com';
        $to = $email;
        $sub = 'Placement-portal login credentials';
        $body = "Your account has been verified successfully by our staff. Kindly use username and password to login to system.\n Username: $email \nPassword:$pass_text\n Please change password once loged in.";
        //send mail
        echo sendMail($from,$to,$sub,$body);
        echo json_encode(array("status"=>"success","msg"=>"login cred stored successfully")); 

    }
    else{
        echo json_encode(array("status"=>"failed","msg"=>"unable to storee"));

    }
}