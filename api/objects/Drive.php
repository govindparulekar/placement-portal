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
    public $branch;
    public $designation;
    public $drive_start_date;
    public $app_end_date;

    public function create(){
        $query = "INSERT INTO $this->table_name
                    SET tpo_id = :tpoid,
                    company_name = :company_name,
                    description = :description,
                    package_fixed = :package_fixed,
                    package_range = :package_range,
                    branch = :branch,
                    designation = :designation,
                    drive_start_date = :dst,
                    app_end_date = :aed";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tpo_id',$this->tpo_id);
        $stmt->bindParam(':company_name',$this->company_name);
        $stmt->bindParam(':description',$this->description);
        $stmt->bindParam(':package_fixed',$this->package_fixed);
        $stmt->bindParam(':package_range',$this->package_range);
        $stmt->bindParam(':branch',$this->branch);
        $stmt->bindParam(':designation',$this->designation);
        $stmt->bindParam(':dst',$this->drive_start_date);
        $stmt->bindParam(':aed',$this->app_end_date);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }

    }

    function read(){
        $query = "SELECT * FROM $this->table_name WHERE tpo_id = :tpo_id, branch = :branch";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tpo_id',$this->tpo_id);
        $stmt->bindParam(':branch',$this->branch);

        if($stmt->execute()){
            return $stmt;
        }
        else{
            return false;
        }

    }
}