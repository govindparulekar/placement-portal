<?php
class Drive{
    private $table_name = 'drives';
    private $conn;

    public $drive_id;
    public $tpo_id;
    public $company_name;
    public $description;
    public $package_fixed;
    public $package_range;
    public $designation;
    public $drive_start_date;
    public $app_end_date;
    public $job_location;
    public $sheet_link;

    // construct or with $db as database connection
    public function __construct($conn){
        $this->conn = $conn;
    }   

    public function create(){
        $query = "INSERT INTO $this->table_name
                    SET tpo_id = :tpo_id,
                    drive_id = :drive_id,
                    company_name = :company_name,
                    description = :description,
                    package_fixed = :package_fixed,
                    package_range = :package_range,
                    designation = :designation,
                    drive_start_date = :dst,
                    app_end_date = :aed,
                    job_location = :job_location,
                    sheet_link = :sheet_link";

        $stmt = $this->conn->prepare($query);

        //total 10
        $stmt->bindParam(':tpo_id',$this->tpo_id);
        $stmt->bindParam(':drive_id',$this->drive_id);
        $stmt->bindParam(':company_name',$this->company_name);
        $stmt->bindParam(':description',$this->description);
        $stmt->bindParam(':package_fixed',$this->package_fixed);
        $stmt->bindParam(':package_range',$this->package_range);
        $stmt->bindParam(':designation',$this->designation);
        $stmt->bindParam(':dst',$this->drive_start_date);
        $stmt->bindParam(':aed',$this->app_end_date);
        $stmt->bindParam(':job_location',$this->job_location);
        $stmt->bindParam(':sheet_link',$this->sheet_link);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }

    }
    function delete(){
        $query = "DELETE FROM $this->table_name WHERE drive_id = $this->drive_id";
        if ($stmt = $this->conn->query($query)) {
            return true;
        }
        else{
            return false;
        }
    }

    function readByAppliedStudents($student_id){
        $query = "SELECT d.drive_id,company_name,description,package_fixed,package_range,designation, app_end_date, drive_start_date, created_at, c.ssc_per, c.hsc_dip_per, c.max_live_kt, c.current_course_agg, c.strict_checking, job_location, sheet_link
        FROM drives AS d
        JOIN applied_student as aps
        on d.drive_id = aps.drive_id
        LEFT JOIN criteria as c
        on d.drive_id = c.drive_id
        WHERE aps.student_id = $student_id
        ";
        if ($stmt = $this->conn->query($query)) {
            # code...
            return $stmt;
        }
        else{
            return false;
        }
    }

    function readByBranch($branch_id){
       // echo $branch_id , $this->tpo_id;
        $query = "SELECT d.drive_id,company_name,description,package_fixed,package_range,designation, app_end_date, drive_start_date, created_at, c.ssc_per, c.hsc_dip_per, c.max_live_kt, c.current_course_agg, c.strict_checking, job_location, sheet_link
        FROM drives AS d
        JOIN drive_branch_xref AS db
        ON d.drive_id = db.drive_id
        LEFT JOIN criteria AS c
        ON d.drive_id = c.drive_id
        WHERE db.branch_id = :branch_id AND d.tpo_id = :tpo_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tpo_id',$this->tpo_id);
        $stmt->bindParam(':branch_id',$branch_id);

        if($stmt->execute()){
            return $stmt;
        }
        else{
            return false;
        }

    }

    function readById(){
        $query = "SELECT d.drive_id,company_name,description,package_fixed,package_range,designation, app_end_date, drive_start_date, created_at, c.ssc_per, c.hsc_dip_per, c.max_live_kt, c.current_course_agg, c.strict_checking,job_location,sheet_link  
        FROM drives AS d
        LEFT JOIN criteria AS c
        ON d.drive_id = c.drive_id
        WHERE d.drive_id = :drive_id";

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