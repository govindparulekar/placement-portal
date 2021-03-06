<?php
class Criteria{
    private $table_name = 'criteria';
    private $conn;

    public $drive_id;
    public $ssc_per;
    public $hsc_dip_per;
    public $max_live_kt;
    public $current_course_agg;
    public $strict_checking;

    public function __construct($conn){
        $this->conn = $conn;
    } 

    public function create(){
        $query = "INSERT INTO $this->table_name SET drive_id = :drive_id, ssc_per = :ssc_per, hsc_dip_per = :hdp, max_live_kt = :mlk, current_course_agg = :current_course_agg,
        strict_checking = :sc";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':drive_id',$this->drive_id);
        $stmt->bindParam(':ssc_per',$this->ssc_per);
        $stmt->bindParam(':hdp',$this->hsc_dip_per);
        $stmt->bindParam(':mlk',$this->max_live_kt);
        $stmt->bindParam(':sc',$this->strict_checking);
        $stmt->bindParam(':current_course_agg',$this->current_course_agg);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }

    }

    public function read(){
        $query = "SELECT * FROM $this->table_name WHERE drive_id = :drive_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':drive_id',$this->drive_id);

        if($stmt->execute()){
            return $stmt;
        }
        else{
            return false;
        }

    }

   

}