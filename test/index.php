<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment ; filename = hello world.xlsx");
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

$worksheet = $spreadsheet->getActiveSheet();
$worksheet->setCellValue('A1','Govind ajsdfjakjdadjf sldjkfs jfkjjljsf lajflajskdkjaskdjf ajsdfjsdfkjksjdfj dskjfskdfjdkjf');

$writer = new Xlsx($spreadsheet);

$writer->save('php://output');
?>

