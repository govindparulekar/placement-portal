<?php
include_once '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('test2.xlsx');
    $worksheet = $spreadsheet->getActiveSheet();

    // Get the highest row and column numbers referenced in the worksheet
    $highestRow = $worksheet->getHighestDataRow(); // e.g. 10
    $highestColumn = $worksheet->getHighestDataColumn(); // e.g 'F'
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); 

    echo "highest row: $highestRow\n";