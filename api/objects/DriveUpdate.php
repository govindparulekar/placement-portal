<?php
date_default_timezone_set('Asia/Kolkata');
include_once '../utility.php';

class DriveUpdate{
    private $conn;
    private $table_name = 'drive_update';

    public $drive_id;
    public $description;
    public $date_created;
    public $time_created;

    // construct or with $db as database connection
    public function __construct($conn){
        $this->conn = $conn;
    }  

    public function create(){
        
        $query = "INSERT INTO $this->table_name SET drive_id = $this->drive_id, description = :description, date_created = CURRENT_DATE, time_created = CURRENT_TIME";

        if(prebindex($query,$this->conn,[$this->description],['description'])){
            return true;
        }
        else{
            return false;
        }

    }
    public function read(){
        $query = "SELECT * FROM $this->table_name WHERE drive_id = $this->drive_id ORDER BY date_created DESC, time_created DESC ";

        if($stmt = $this->conn->query($query)){
            return $stmt;
        }
        else{
            return false;
        }

    }
    public function delete(){
        $query = "DELETE FROM $this->table_name WHERE id = $this->id";
        if($stmt = $this->conn->query($query)){
            return true;
        }
        else{
            return false;
        }
    }
}