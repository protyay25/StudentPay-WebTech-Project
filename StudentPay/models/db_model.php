<?php
$host = "localhost";
$user = "root";
$password = "";
$dbName = "student_pay_db";

$conn = mysqli_connect($host, $user, $password, $dbName);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>