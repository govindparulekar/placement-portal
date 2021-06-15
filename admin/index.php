<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
  header("location: ../tpo/");
  exit;
}
require_once '../api/includes/autoloader.php';
use config\Database;

$db = new config\Database();
$conn = $db->getConnection();

$tpo = new TPO($conn);
if (isset($_POST['login-btn'])) {
  # code...
  $email = $_POST['email'];
  $password = $_POST['password'];
  $tpo->email = $email;
  $error = '';
  if ($stmt = $tpo->isVerified()) {
    
    $row = $stmt->fetch();
    if (password_verify($password,$row['password'])) {
      session_start();
      $_SESSION['logged_in'] = true;
      $_SESSION['id'] = $row['tpo_id'];
      $_SESSION['dp_url'] = $row['dp'];
      header('location: ../tpo/');
    }
    else{
      $error .= 'Password is incorrect!';
    }
    
  }
  else{
    $error .= 'email is incorrect';
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
    .row{
      align-self: center;
    }
    .container{
      min-height: 100vh;
      display: flex;
      justify-content: center;
    }
  </style>
</head>
<body>
  <h1></h1>
  <div class="container">
    <div class="row">
      <div class="card shadow">
        <div class="card-header">
        <h2>Login</h2>
        </div>
        <div class="card-body">
          <form action="" method="post">
            <div class="mb-3">
              <label for="email-inp" class="form-label">Email address</label>
              <input type="email" required class="form-control" id="email-inp" aria-describedby="emailHelp" name="email">
              <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
              <label for="pw-inp" class="form-label">Password</label>
              <input type="password" required class="form-control" id="pw-inp" name="password">
            </div>
            <button type="submit" name="login-btn" class="btn btn-primary">Log in</button>
          </form>
      </div>

    </div>

  </div>

</body>

</html>
