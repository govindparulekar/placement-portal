<?php
session_start();
$doc_root = $_SERVER['DOCUMENT_ROOT'];
//echo 'helo';
if (!isset($_SESSION['logged_in']) && !$_SESSION['logged_in'] === true) {
  header("location: ../admin/index.php");
  exit;
}




