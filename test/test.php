<?php
require '../vendor/autoload.php';
require '../api/config/Database.php';
require '../api/objects/Student.php';
require '../api/objects/PlacedStudent.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;

//get posted data
$drive_id = !empty($_GET['drive_id']) ? $_GET['drive_id'] : null;

//Get database connection
$db = new Database();
$conn = $db->getConnection();
//instantiate student
$student = new Student($conn);
$placed_student = new PlacedStudent($conn);




if ($_POST['submit']) {

    //echo 'submitted';
    $upload_dir = 'uploads/sheets/';
    $file_temp_name = $_FILES['sheet']['tmp_name'];
    $file_name = $_FILES['sheet']['name'];
    $file_ext = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
    $valid_ext = ['xls','xlsx','png'];

    if (in_array($file_ext,$valid_ext)) {
        move_uploaded_file($file_temp_name,$upload_dir.$file_name);
        $errors = processSheet($student,$upload_dir,$file_name,$drive_id,$placed_student);
        echo $errors;

    }
    
}

function processSheet($student,$upload_dir,$file_name,$drive_id,$placed_student){
    $errors = 0;
    //load workbook
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($upload_dir.$file_name);
    //get active worksheet
    $worksheet = $spreadsheet->getActiveSheet();
    // Get the highest row and column numbers referenced in the worksheet
    $highestRow = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); 

    for ($sheet_row=2; $sheet_row <= $highestRow ; $sheet_row++) { 
        $row_data = array();
        for ($sheet_col=1; $sheet_col <= $highestColumnIndex ; $sheet_col++) { 
            $cellValue = $worksheet->getCellByColumnAndRow($sheet_col,$sheet_row)->getValue();
            if(!$cellValue){
                break 2;
            }
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
                $errors += $placed_student->create() ? 0 : 1 ;     
                
            }
            else{
                $errors++;
                return $errors;
            }
        }
        else{
            $errors++;
            echo 'fail';
            return $errors;
        }
        
    }
}
