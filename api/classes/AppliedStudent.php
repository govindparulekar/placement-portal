<?php
class AppliedStudent{
    private $conn;
    public $drive_id;
    public $student_id;

    // construct or with $db as database connection
    public function __construct($conn){
        $this->conn = $conn;
    } 

    public function create(){
        $query = "INSERT INTO applied_student SET drive_id = $this->drive_id, student_id = $this->student_id";

        if($stmt = $this->conn->query($query)){
            return true;
        }
        else{
            return false;
        }
    }

    public function checkIfApplied(){
        //echo $this->drive_id;
        //secho $this->student_id;
        $query = "SELECT * FROM applied_student WHERE drive_id = $this->drive_id and student_id = $this->student_id";

        if ($stmt = $this->conn->query($query)) {
            return $stmt;
        }
        else{
            return false;
        }
    }
    
    
    public function read($drive_id,$branch_id,$q){
        if($q == "all"){
            $query = "SELECT aps.student_id,s.roll_no, s.name, s.gender, s.dob, s.email, s.contact, s.institute, b.branch_name, s.passout_year, sa.ssc_per, sa.hsc_dip_per, sa.current_course_agg, sa.active_kt
            FROM applied_student AS aps
            JOIN student_basic_info AS s
            ON aps.student_id = s.student_id
            JOIN student_acadamic_info as sa
            ON aps.student_id = sa.student_id
            JOIN branch as b
            ON s.branch_id = b.branch_id
    
            WHERE aps.drive_id = $drive_id AND s.branch_id = $branch_id";
        }
        else{
            $query = "SELECT aps.student_id, s.name, s.roll_no, ps.package
                    FROM applied_student AS aps
                    JOIN placed_student AS ps
                    ON aps.student_id = ps.student_id
                    JOIN student_basic_info AS s
                    ON ps.student_id = s.student_id
                    WHERE aps.drive_id = $drive_id and branch_id = $branch_id";
        }
        
        if($stmt = $this->conn->query($query)){
            return $stmt;
        }
        else{
            return false;
        }
     
    }

    function remove($student_id_array){
        $query = "DELETE FROM applied_student WHERE student_id = :student_id";
        $stmt = $this->conn->prepare($query);

        for ($i=0; $i < count($student_id_array) ; $i++) { 
            # code...
            $stmt->bindParam(':student_id',$student_id_array[$i]);
            if(!$stmt->execute()){
                return false;
            }
        }
        return true;
    }
    


}