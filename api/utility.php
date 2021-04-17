<?php

function sanitize($data){
    return htmlspecialchars(strip_tags($data));
}

function prebindex($query,$conn,$values,$params){
    $stmt = $conn->prepare($query);
    
    for ($i=0; $i < count($values) ; $i++) { 
        
        $stmt->bindParam(":$params[$i]",$values[$i]);
    }
    if($stmt->execute()){
        return $stmt;
    }
    else{
        return false;
    }

}