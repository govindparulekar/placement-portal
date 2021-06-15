<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../includes/autoloader.php';
include_once '../includes/utility.inc.php';

use config\Database;

$db = new Database();
$conn = $db->getConnection();

$error = false;


/*-----------------------------get posted data----------------------------------------*/
$tpo_id = !empty($_POST['tpo_id']) ? sanitize($_POST['tpo_id']) : null;
$company_name = !empty($_POST['company_name']) ? sanitize($_POST['company_name']) : null;
$description = !empty($_POST['description']) ? sanitize($_POST['description']) : null;
$package_fixed = !empty($_POST['package_fixed']) ? sanitize($_POST['package_fixed']) : null;
$package_range = !empty($_POST['package_range']) ? sanitize($_POST['package_range']) : null;
$designation = !empty($_POST['designation']) ? sanitize($_POST['designation']) : null;
$drive_start_date = !empty($_POST['drive_start_date']) ? sanitize($_POST['drive_start_date']) : null;
$app_end_date = !empty($_POST['app_end_date']) ? sanitize($_POST['app_end_date']) : null;
$ssc_per = !empty($_POST['ssc_per']) ? sanitize($_POST['ssc_per']) : null;
$hsc_dip_per = !empty($_POST['hsc_dip_per']) ? sanitize($_POST['hsc_dip_per']) : null;
$max_live_kt = !empty($_POST['max_live_kt']) ? sanitize($_POST['max_live_kt']) : null;
$strict_checking = !empty($_POST['strict_checking']) ? sanitize($_POST['strict_checking']) : null;
$current_course_agg = !empty($_POST['current_course_agg']) ? sanitize($_POST['current_course_agg']) : null;
$job_location = !empty($_POST['job_location']) ? sanitize($_POST['job_location']) : null;
$sheet_link = !empty($_POST['sheet_link']) ? sanitize($_POST['sheet_link']) : null;

$no_criteria = $_POST['no_criteria'];
//array
$branch = !empty($_POST['branch']) ? $_POST['branch'] : null;
//echo var_dump($branch);
/*---------------------------------------------------------------------------------------------*/

//create random drive id so as to put this into criteria and drive table simultaneously
$drive_id = mt_rand();


if(addDriveDetails()){
    addCriteria();
    connectDriveBranch();
    
    echo json_encode(array("status"=>"success","msg"=>"created successfully"));
}
else{
    echo json_encode(array("status"=>"failed","msg"=>"something went wrong.."));
}

/*------------------------------------Functions------------------------------------*/
function addDriveDetails(){
    global $conn,$tpo_id,$drive_id,$company_name,$description,$designation,$app_end_date,$package_fixed,$package_range,$drive_start_date,$job_location,$sheet_link;

    $drive = new Drive($conn);
    
    $drive->tpo_id = $tpo_id;
    $drive->drive_id = $drive_id;
    $drive->company_name = $company_name;
    $drive->description = $description;
    $drive->package_fixed = $package_fixed;
    $drive->package_range = $package_range;
    $drive->designation = $designation;
    $drive->drive_start_date = $drive_start_date;
    $drive->app_end_date = $app_end_date;
    $drive->job_location = $job_location;
    $drive->sheet_link = $sheet_link;
    
    return $drive->create();
}

function addCriteria(){
    global $conn,$drive_id,$ssc_per,$hsc_dip_per,$max_live_kt,$current_course_agg,$strict_checking,$no_criteria;
    if($no_criteria){
        return;
    }
    
    $criteria = new Criteria($conn);
    //drive criteria info
    $criteria->drive_id = $drive_id;
    $criteria->ssc_per = $ssc_per;
    $criteria->hsc_dip_per = $hsc_dip_per;
    $criteria->max_live_kt = $max_live_kt;
    $criteria->current_course_agg = $current_course_agg;
    $criteria->strict_checking = $strict_checking;
    
    $criteria->create();
    
}
function connectDriveBranch(){
    global $conn,$branch,$drive_id;
    //prepare query for drive_branch_xref
    $query = "INSERT INTO drive_branch_xref SET drive_id = :drive_id, branch_id = :branch_id";
    $stmt = $conn->prepare($query);
    //loop through the branches and create drive for each branch 
    for ($i=0; $i < count($branch); $i++) {    
    
        $branch_id = $branch[$i];
        $stmt->bindParam(':drive_id',$drive_id);
        $stmt->bindParam(':branch_id',$branch_id);
        $stmt->execute();
        
    }
}

$conn = null;



