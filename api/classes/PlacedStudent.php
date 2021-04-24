<?php
include_once '../includes/utility.inc.php';
class PlacedStudent{
    private $conn;
    private $table_name = 'placed_student';

    public $drive_id;
    public $student_id;
    public $package;

    // constructor with $db as database connection
    public function __construct($conn){
        $this->conn = $conn;
    }


    public function create(){
        $query = "INSERT INTO $this->table_name SET drive_id = $this->drive_id, student_id = $this->student_id, package = :package";

        if(prebindex($query,$this->conn,[$this->package],['package'])){
            return true;
        }
        else{
            return false;
        }
    }
    

}