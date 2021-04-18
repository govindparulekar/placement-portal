<?php

class Student{
    // db connection and table info
    private $conn;
    private $table_name = "student_basic_info";

    //object properties
    public $student_id;
    public $tpo_id;
    public $name;
    public $email;
    public $username;
    public $password;
    public $pass_text;
    public $division;
    public $branch_id;
    public $roll_no;
    

    // constructor with $db as database connection
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function read($filter){
        switch ($filter) {
            case 'id':
                $query = "SELECT * FROM $this->table_name s
                            JOIN student_acadamic_info as sa
                            ON s.student_id = sa.student_id
                            JOIN branch as b
                            ON s.branch_id = b.branch_id
                            WHERE s.student_id = $this->student_id";
            break;
            case 'name':
                $query = "SELECT * FROM $this->table_name s
                            JOIN student_acadamic_info as sa
                            ON s.student_id = sa.student_id
                            JOIN branch as b
                            ON s.branch_id = b.branch_id
                            WHERE s.name = '$this->name' AND s.branch_id = $this->branch_id AND s.tpo_id = $this->tpo_id";
            break;
            case 'roll':
                $query = "SELECT * FROM $this->table_name s
                            JOIN student_acadamic_info as sa
                            ON s.student_id = sa.student_id
                            JOIN branch as b
                            ON s.branch_id = b.branch_id
                            WHERE s.roll_no = $this->roll_no AND s.branch_id = $this->branch_id AND s.tpo_id = $this->tpo_id";
            break;
            
            default:
                $query = "SELECT * FROM $this->table_name s
                            JOIN student_acadamic_info as sa
                            ON s.student_id = sa.student_id
                            JOIN branch as b
                            ON s.branch_id = b.branch_id
                            WHERE s.branch_id = $this->branch_id AND s.tpo_id = $this->tpo_id";
                # code...
                break;
        }
        
        if($stmt = $this->conn->query($query)){
            return $stmt;
        }
        else{
            return false;
        }
    }

    public function register(){
        $query = "INSERT INTO $this->table_name SET tpo_id = :tpo_id, name = :name , email = :email, username = :username, password = :password, division = :division, branch_id = :branch_id, roll_no =:roll_no";

        $stmt = $this->conn->prepare($query);
        $this->tpo_id = htmlspecialchars(strip_tags($this->tpo_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->division = htmlspecialchars(strip_tags($this->division));
        $this->branch_id = htmlspecialchars(strip_tags($this->branch_id));
        $this->roll_no = htmlspecialchars(strip_tags($this->roll_no));
        
        $stmt->bindParam(":tpo_id",$this->tpo_id);
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":email",$this->email);
        $stmt->bindParam(":username",$this->username);
        $stmt->bindParam(":password",$this->password);
        $stmt->bindParam(":division",$this->division);
        $stmt->bindParam(":branch_id",$this->branch_id);
        $stmt->bindParam(":roll_no",$this->roll_no);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }

    }

    public function readByEmailSent(){
        $query = "SELECT * FROM $this->table_name where tpo_id = :tpo_id and email_sent = 0";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":tpo_id",$this->tpo_id);

        if($stmt->execute()){
            return $stmt;
        }
        else{
            return false;
        }

    }

    public function setEmailSent(){
        $query = "UPDATE $this->table_name SET email_sent = 1 WHERE student_id = $this->student_id";

        $this->conn->query($query);
       
    }
}