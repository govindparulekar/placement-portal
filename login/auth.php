<?php
require_once '../api/includes/autoloader.php';
use config\Database;

$db = new Database();
$conn = $db->getConnection();

$email = $_POST['email'];
$password = $_POST['password'];

