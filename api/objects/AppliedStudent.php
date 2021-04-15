<?php
class AppliedStudent{
    private $conn;

    // construct or with $db as database connection
    public function __construct($conn){
        $this->conn = $conn;
    } 
    
    public function read($drive_id,$branch_id,$q){
        if($q == "all"){
            $query = "SELECT aps.student_id, s.name, s.gender, s.dob, s.email, s.contact, s.institution_name, b.branch_name, s.passout_year, sa.ssc_per, sa.hsc_dip_per, sa.current_course_agg, sa.active_kt,sa.dead_kt
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
    


}