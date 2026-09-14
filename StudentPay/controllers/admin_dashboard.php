<?php
session_start();
include '../models/db_model.php';
include '../models/user_model.php';

if ($_SESSION['role'] != 'admin') { 
    header("Location: login.php");
    exit(); 
}

if(isset($_GET['delete_user'])){
    deleteStudent($conn, $_GET['delete_user']);
    header("Location: admin_dashboard.php");
    exit();
}

include '../views/admin_dashboard_view.php';
?>