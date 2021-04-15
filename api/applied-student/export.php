<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment ; filename = export.xlsx");

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include_once '../config/Database.php';
include_once '../objects/AppliedStudent.php';
include_once '../utility.php';


$db = new Database();
$conn = $db->getConnection();
$applied_student = new AppliedStudent($conn);
//create new worksheet 
$spreadsheet = new Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();

$drive_id = !empty($_GET['drive_id']) ? sanitize($_GET['drive_id']) : null;
$branch_id = !empty($_GET['branch_id']) ? sanitize($_GET['branch_id']) : null;
$q = !empty($_GET['q']) ? sanitize($_GET['q']) : null;


if(!empty($drive_id)&&!empty($branch_id)&&!empty($q)){
    if($stmt = $applied_student->read($drive_id,$branch_id,$q)){
        
        $title_row = ['Name','Gender','D.O.B','Email ID','Contact','Institution name','Branch','Passout year','SSC %','HSC/DIPLOMA %','Current Course %','Live KT','Dead KT'];
        $worksheet->fromArray($title_row);
        $row_index = 2;
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            //write to excel sheet
            //extract($row);
            for ($i=1; $i < count($row); $i++) { 
                # code...
               // echo " $i $row_index";
                $worksheet->setCellValueByColumnAndRow($i,$row_index,$row[$i]);
            }
            //echo "\n--------------------------------------\n";
            $row_index++;
        }   
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
      
        
    }
    else{
        echo json_encode(array("status"=>"failed","msg"=>"Unable to read at this moment.."));
    }
}
else{
echo json_encode(array("status"=>"failed","msg"=>"Insufficient data"));

}