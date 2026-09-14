<?php
session_start();
include '../models/db_model.php';
if ($_SESSION['role'] != 'cafeteria') { header("Location: login.php"); exit(); }
$provider = $_SESSION['user_id'];

if(isset($_POST['add_due'])){
    $std = trim($_POST['student_id']);
    $amt = trim($_POST['amount']);
    
    $check_student = $conn->prepare("SELECT id, full_name FROM users WHERE student_id = ? AND role = 'student'");
    $check_student->bind_param("s", $std);
    $check_student->execute();
    $result = $check_student->get_result();
    
    if($result->num_rows > 0) {
        $student_data = $result->fetch_assoc();
        $student_name = $student_data['full_name'];
        
        $stmt = $conn->prepare("INSERT INTO dues (student_id, provider_id, amount) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $std, $provider, $amt);
        if($stmt->execute()) {
            $success_msg = "Bill successfully sent to <strong>$student_name</strong> ($std)!";
        }
        $stmt->close();
    } else {
        $error_msg = "Error: Student ID <strong>$std</strong> is not registered in the system!";
    }
    $check_student->close();
}

if(isset($_POST['add_item'])){
    $name = trim($_POST['item_name']);
    $price = trim($_POST['price']);
    
    $stmt = $conn->prepare("INSERT INTO items (provider_id, item_name, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $provider, $name, $price);
    $stmt->execute();
    $success_item_msg = "Item added successfully!";
    $stmt->close();
}

include '../views/cafeteria_dashboard_view.php';
?>