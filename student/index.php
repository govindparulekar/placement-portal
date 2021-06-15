<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
  header("location: new-drives.php");
  exit;
}
require_once '../api/includes/autoloader.php';
use config\Database;

$db = new Database();
$conn = $db->getConnection();

$student = new Student($conn);
if (isset($_POST['login-btn'])) {

  # code...
  $uname = $_POST['uname'];
  //echo $uname;
  $entered_pwd = $_POST['pwd'];
  $student->username = $uname;
  $error = '';
  if ($stmt = $student->read('uname')) {

    if ($stmt->rowCount()>0) {
        $row = $stmt->fetch();
        $pw = $row['password'];
        if ($entered_pwd === $pw) {
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['id'] = $row['student_id'];
            $_SESSION['dp_url'] = $row['dp'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['tpo_id'] = $row['tpo_id'];
            $_SESSION['branch_id'] = $row['branch_id'];
            $_SESSION['fullname'] = $row['name'];
           // $_SESSION['new_login'] = $row['new_login'];
            //echo $_SESSION['tpo_id'] = $row['tpo_id'];
            header('location: new-drives.php');
        } 
        else{

            $error .= 'Password is incorrect!';
        }

    }
    else{
        
        $error .= 'username is incorrect';
    }
    
  }
  else{
      $error .= 'something went wrong';
  }

  echo $error;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login</title>
  
  <!--Bootstrap-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
        .card
        {
        width: 25;
        }
        .card-header
        {
        text-align: center;
        color: white;
        background:royalblue !important;

        }
        .row
        {
        align-self : center;
        }
        .container
        {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        }
        .btn
        {
        width: 100%;

        }
        .form-text
        {
        margin-right: 5rem;
        }
    </style>
</head>
<body>

  <div class="container">
    <div class="row">
    
      <div class="card shadow">
        <div class="card-header">
        <h2>Login</h2>
        </div>
        <div class="card-body">
          <form action="index.php" method="post">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" required class="form-control" id="username"  name="uname">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" required class="form-control" id="exampleInputPassword1" name="pwd">
            </div>
            
            <button type="submit" class="btn btn-primary" name="login-btn">Log in</button>
          </form>
      </div>

    </div>

  </div>

</body>

</html>