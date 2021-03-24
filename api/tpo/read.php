<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../objects/TPO.php';

//get database connection
$db = new Database();
$conn = $db->getConnection();
$tpo = new TPO($conn);

$tpo_id = !empty($_GET['tpo_id']) ? $_GET['tpo_id'] : null;

if(!empty($tpo_id)){
    $tpo->tpo_id = $tpo_id;
    if($stmt = $tpo->read()){
        if($stmt->rowCount()>0){
            $data = array("status"=>"succes","records"=> array());
            $row = $stmt->fetch();
            extract($row);
            $tpo_data = array(
                "tpo_id"        => $tpo_id,
                "first_name"    => $first_name,
                "last_name"     => $last_name,
                "inst_name"     => $inst_name,
                "inst_addr"     => $inst_addr,
                "contact"       => $contact,
                "dp"            => $dp,
                "email"         => $email
            );
            array_push($data['records'],$tpo_data);
            echo json_encode($data);
            
        }
        else{
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