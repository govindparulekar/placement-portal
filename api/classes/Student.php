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
                echo "$this->name\n";
                echo "$this->branch_id\n";
                echo "$this->tpo_id\n";
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
            case 'email':
                //echo $this->email;
                $query = "SELECT * FROM $this->table_name s
                            JOIN student_acadamic_info as sa
                            ON s.student_id = sa.student_id
                            JOIN branch as b
                            ON s.branch_id = b.branch_id
                            WHERE s.email = '$this->email'";
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
        /*here im first checking if the entry for email already exists and its not empty if it exists and not empty i dont wont to execute query as it will cause error bcz email is unique key . i dont want to cause error but simply ignor tht entry.*/

        //check if student exists with this email in the db
        $stmt = $this->conn->query("SELECT count(*) FROM $this->table_name WHERE email = '$this->email'");

        //if student doesnt exists with this email and email is not empty ,register 
        if ($stmt->fetchColumn() == 0 && $this->email !== "") {
            //echo $c;
            $query = "INSERT INTO $this->table_name SET tpo_id = :tpo_id, name = :name , email = :email, username = :username, password = :password, division = :division, branch_id = :branch_id, roll_no =:roll_no";
            //echo var_dump($this->conn);
            $stmt = $this->conn->prepare($query);
            //echo var_dump($stmt);
            $this->tpo_id = htmlspecialchars(strip_tags($this->tpo_id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->division = htmlspecialchars(strip_tags($this->division));
            $this->branch_id = htmlspecialchars(strip_tags($this->branch_id));
            $this->roll_no = htmlspecialchars(strip_tags($this->roll_no));
            /*
            echo "\n$this->tpo_id\n";
            echo "$this->name\n";
            echo "$this->email\n";
            echo "$this->username\n";
            echo "$this->password\n";
            echo "$this->division\n";
            echo "$this->branch_id\n";
            echo "$this->roll_no\n";
            */

            
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
                print_r($stmt->errorInfo());
                return false;
            }
               
        }   
        return true;

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