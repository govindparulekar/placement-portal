<?php
session_start();
//echo 'helo';
if (!isset($_SESSION['logged_in']) && !$_SESSION['logged_in'] === true) {
  header("location: $_SERVER['DOCUMENT_ROOT']/placement-portal/admin/index.php");
  exit;
}




