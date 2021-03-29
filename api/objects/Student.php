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
    public $branch;
    public $roll_no;
    

    // constructor with $db as database connection
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function register(){
        $query = "INSERT INTO $this->table_name SET tpo_id = :tpo_id, name = :name , email = :email, username = :username, password = :password, division = :division, branch = :branch, roll_no =:roll_no";

        $stmt = $this->conn->prepare($query);
        $this->tpo_id = htmlspecialchars(strip_tags($this->tpo_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->division = htmlspecialchars(strip_tags($this->division));
        $this->branch = htmlspecialchars(strip_tags($this->branch));
        $this->roll_no = htmlspecialchars(strip_tags($this->roll_no));
        
        $stmt->bindParam(":tpo_id",$this->tpo_id);
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":email",$this->email);
        $stmt->bindParam(":username",$this->username);
        $stmt->bindParam(":password",$this->password);
        $stmt->bindParam(":division",$this->division);
        $stmt->bindParam(":branch",$this->branch);
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