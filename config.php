<?php
$host = "localhost";
$user = "root";      // Change if you use a different user
$pass = "";          // Change if your MySQL has a password
$dbname = "cat_app";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
