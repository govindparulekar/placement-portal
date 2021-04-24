<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../includes/autoloader.php';
use config\Database;
//get database connection
$db = new Database();
$conn = $db->getConnection();
$drive = new Drive($conn);

$drive_id = !empty($_POST['drive_id']) ? $_POST['drive_id'] : null;

if(!empty($drive_id)){
    $drive->drive_id = $drive_id;
    if($stmt = $drive->readById()){
        if($stmt->rowCount()>0){
            $data = array("status"=>"succes","records"=> array());
            $row = $stmt->fetch();
            extract($row);
            $drive_data = array(
                "drive_id"          => $drive_id,
                "company_name"      => $company_name,
                "description"       => $description,
                "designation"       => $designation,
                "package_range"     => $package_range,
                "package_fixed"     => $package_fixed,
                "drive_start_date"  => $drive_start_date,
                "app_end_date"      => $app_end_date,
                "ssc_per"           => $ssc_per,
                "hsc_dip_per"       => $hsc_dip_per,
                "max_live_kt"       => $max_live_kt,
                "current_course_agg"=> $current_course_agg,
                "strict_checking"   => $strict_checking,
                "created_at"        => $created_at,
            );
            array_push($data['records'],$drive_data);
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