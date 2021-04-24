<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../../vendor/autoload.php';
require_once '../includes/autoloader.php';
include_once '../includes/utility.inc.php';

use config\Database;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

//get posted data
$tpo_id = !empty($_POST['tpo_id']) ? $_POST['tpo_id'] : null;
$branch_id = !empty($_POST['branch_id']) ? $_POST['branch_id'] : null;


//Get database connection
$db = new Database();
$conn = $db->getConnection();
//instantiate student
$student = new Student($conn);
$error = "";


//echo 'submitted';
$upload_dir = '../uploads/sheets/';
$file_temp_name = $_FILES['file']['tmp_name'];
$file_name = $_FILES['file']['name'];
$file_ext = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
$valid_ext = ['xls','xlsx'];

if (in_array($file_ext,$valid_ext)) {
    move_uploaded_file($file_temp_name,$upload_dir.$file_name);
    //get the array of students data if data is stored in db succsessfully and send to front end as json
    if($records = processSheet($student,$upload_dir,$file_name,$tpo_id,$branch_id)){
        echo json_encode(array("status"=>"success","msg"=>"Registered successfully","records"=>$records));
    }
    else{
        echo json_encode(array("status"=>"failed","msg"=>$error));
    }      

}
    



function processSheet($student,$upload_dir,$file_name,$tpo_id,$branch_id){
    global $error;
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($upload_dir.$file_name);
    $worksheet = $spreadsheet->getActiveSheet();

    // Get the highest row and column numbers referenced in the worksheet
    $highestRow = $worksheet->getHighestDataRow(); // e.g. 10
    $highestColumn = $worksheet->getHighestDataColumn(); // e.g 'F'
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); 

    //echo "highest row: $highestRow\n";
    $records = array();

    for ($sheet_row=2; $sheet_row <= $highestRow ; $sheet_row++) { 
        //checking if table starts from 1st cell
        if (!$worksheet->getCellByColumnAndRow(1,1)->getValue()) {
            $error = "Error parsing file";
            return false;
        }
        //echo "sheet row: $sheet_row\n";
    
        $row_data = array();
        for ($sheet_col=1; $sheet_col <= $highestColumnIndex ; $sheet_col++) { 
           // echo "sheet col: $sheet_col\n";
            $cellValue = $worksheet->getCellByColumnAndRow($sheet_col,$sheet_row)->getValue();
    
            array_push($row_data,$cellValue);
            //echo var_dump($row_data);
        }
        $student->tpo_id = $tpo_id;
        $student->name = $row_data[0];
        $student->email = $row_data[1];
        $student->roll_no = $row_data[2];   
        $student->division = $row_data[3];
        $student->branch_id = $branch_id;
        $student->username = explode(" ",$row_data[0])[0].$student->roll_no;
        $student->password = substr(md5($student->email),0,8);
        //$student->password = password_hash($student->pass_text,PASSWORD_DEFAULT);
        //make assoc array and store into records
        $student_data = array();
        $student_data['name'] = $student->name;
        $student_data['roll_no'] = $student->roll_no;
        $student_data['division'] = $student->division;
        $student_data['email'] = $student->email;
        $student_data['username'] = $student->username;

        array_push($records,$student_data);


        if(!$student->register()){
            unlink($upload_dir.$file_name);
            $error = "Something went wrong";
            return false;
        }
    }
    unlink($upload_dir.$file_name);
    return $records;

}