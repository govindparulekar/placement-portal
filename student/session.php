
<?php
session_start();
//echo 'helo';
if (!isset($_SESSION['logged_in']) && !$_SESSION['logged_in'] === true) {
  header("location: http://localhost/placement-portal/student/index.php");
  exit;
}
 