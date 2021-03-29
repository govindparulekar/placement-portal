<?php
require '../../vendor/autoload.php';
require '../config/Database.php';
require '../objects/Student.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

//get posted data
$tpo_id = !empty($_POST['tpo_id']) ? $_POST['tpo_id'] : null;

//Get database connection
$db = new Database();
$conn = $db->getConnection();
//instantiate student
$student = new Student($conn);

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('test.xlsx');
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
        echo var_dump($row_data);
    }
    $student->tpo_id = $tpo_id;
    $student->name = $row_data[0];
    $student->email = $row_data[1];
    $student->roll_no = $row_data[2];   
    $student->division = $row_data[3];
    $student->branch = $row_data[4];
    $student->username = explode(" ",$row_data[0])[0].$student->roll_no;
    $student->password = substr(md5($student->email),0,8);
    //$student->password = password_hash($student->pass_text,PASSWORD_DEFAULT);

    $student->register();
}
if($sheet_row < $highestRow){
    echo json_encode(array("status"=>"failed","msg"=>"error parsing excel sheet"));
}
else{
    echo json_encode(array("status"=>"success","msg"=>"registered"));
}