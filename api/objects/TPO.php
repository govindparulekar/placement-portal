<?php

class TPO{
    // db connection and table info
    private $conn;
    private $table_name = "tpo_info";

    //object properties
    public $tpo_id;
    public $first_name;
    public $last_name;
    public $email;
    public $contact;
    public $inst_name;
    public $inst_addr;
    public $dp;
    public $created_at;
    public $username;
    public $password;
    public $last_login;

    // constructor with $db as database connection
    public function __construct($conn){
        $this->conn = $conn;
    }

    function isRegistered(){
        $query = "SELECT * from ".$this->table_name." where email = :email ";
        $stmt = $this->conn->prepare($query);

        $this->tpo_id = htmlspecialchars(strip_tags($this->tpo_id));
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->inst_name = htmlspecialchars(strip_tags($this->inst_name));
        $this->inst_addr = htmlspecialchars(strip_tags($this->inst_addr));
        $this->contact = htmlspecialchars(strip_tags($this->contact));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));

        $stmt->bindParam(':email',$this->email);
        if($stmt->execute()){
            return $stmt->rowCount();
        }
        
        
    }

    function register(){

        $query = "INSERT INTO
                    ".$this->table_name."
                    SET tpo_id = :tpo_id, first_name = :fname, last_name = :lname, email = :email, inst_name = :inst_name, inst_addr = :inst_addr, contact = :contact, created_at = :created_at";
        
        //echo var_dump($this->conn);
        $stmt = $this->conn->prepare($query);//PDOstatement object

        $stmt->bindParam(":tpo_id",$this->tpo_id);
        $stmt->bindParam(":fname",$this->first_name);
        $stmt->bindParam(":lname",$this->last_name);
        $stmt->bindParam(":inst_name",$this->inst_name);
        $stmt->bindParam(":inst_addr",$this->inst_addr);
        $stmt->bindParam(":contact",$this->contact);
        $stmt->bindParam(":email",$this->email);
        $stmt->bindParam(":created_at",$this->created_at);

        if ($stmt->execute()) {
            return true;
        }
        else{
            return false;
        }
    }

    function read(){
        $query = "SELECT * FROM $this->table_name WHERE tpo_id = :tpo_id";
        $stmt = $this->conn->prepare($query);//PDOstatement object
        $this->tpo_id = htmlspecialchars(strip_tags($this->tpo_id));
        $stmt->bindParam(":tpo_id",$this->tpo_id);

        if($stmt->execute()){
            return $stmt;
        }
        else{
            return false;
        }

    }

    function storeLoginCred(){
        $query = "INSERT INTO tpo_login_cred SET tpo_id = :tpo_id, username = :username, password = :password";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username",$this->email);
        $stmt->bindParam(":password",$this->password);
        $stmt->bindParam(":tpo_id",$this->tpo_id);
  
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    

}










































































































































































































