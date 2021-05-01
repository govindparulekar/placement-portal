<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../../vendor/autoload.php';

require_once '../includes/autoloader.php';
use config\Database;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

//get posted data
$drive_id = !empty($_POST['drive_id']) ? $_POST['drive_id'] : null;

//Get database connection
$db = new Database();
$conn = $db->getConnection();
//instantiate student
$student = new Student($conn);
$placed_student = new PlacedStudent($conn);
$error = "";





    //echo 'submitted';
    $upload_dir = '../uploads/sheets/';
    $file_temp_name = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
    $file_ext = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
    $valid_ext = ['xls','xlsx'];
    
    if (in_array($file_ext,$valid_ext)) {
        move_uploaded_file($file_temp_name,$upload_dir.$file_name);
        if(processSheet($student,$upload_dir,$file_name,$drive_id,$placed_student)){
            echo json_encode(array("status"=>"success","msg"=>"Success"));      
        }
        else{
            echo json_encode(array("status"=>"failed","msg"=>$error));
        }
        //secho $errors;
        
    }
    


function processSheet($student,$upload_dir,$file_name,$drive_id,$placed_student){
    global $error;
    //load workbook
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($upload_dir.$file_name);
    //get active worksheet
    $worksheet = $spreadsheet->getActiveSheet();
    // Get the highest row and column numbers referenced in the worksheet
    $highestRow = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); 
    
    for ($sheet_row=2; $sheet_row <= $highestRow ; $sheet_row++) { 
        //checking if table starts from 1st cell
        if (!$worksheet->getCellByColumnAndRow(1,1)->getValue()) {
            $error = "Error parsing file";
            return false;
        }
        $row_data = array();
        for ($sheet_col=1; $sheet_col <= $highestColumnIndex ; $sheet_col++) { 
            $cellValue = $worksheet->getCellByColumnAndRow($sheet_col,$sheet_row)->getValue();
            
            array_push($row_data,$cellValue);
        }
        //echo var_dump($row_data);
        $student->email = $row_data[0];
        $package = $row_data[1];
        //echo $student->email;
        if($stmt = $student->read('email')){//Get student id by email
            if ($stmt->rowCount()>0) {
                $student_id = $stmt->fetchColumn(0);
                $placed_student->drive_id = $drive_id;
                $placed_student->student_id = $student_id;
                $placed_student->package = $package;
                if (!$placed_student->create()) {
                    $error = "something went wrong, check for ambiguity in sheet data";
                    return false;
                }                
            }
            else{
                $error = "something went wrong, check for ambiguity in sheet data";
                return false;
            }
        }
        else{
            $error = "something went wrong, check for ambiguity in sheet data";
            //echo 'fail';
            return false;
        }       
    }//end of for
    return true;
}
