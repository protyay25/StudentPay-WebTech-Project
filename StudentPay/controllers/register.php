<?php
session_start();
include '../models/db_model.php';
$error = "";

if (isset($_POST['register_submit'])) {
    $full_name = $_POST['full_name'];
    $student_id = $_POST['student_id'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $semester = $_POST['semester'];
    $blood_group = $_POST['blood_group'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (full_name, student_id, email, phone, department, semester, blood_group, password_hash, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'student')");
        $stmt->bind_param("ssssssss", $full_name, $student_id, $email, $phone, $department, $semester, $blood_group, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $student_id; 
            $_SESSION['full_name'] = $full_name;
            $_SESSION['role'] = 'student';
            header("Location: dashboard.php");
            exit(); 
        } else {
            $error = "Error: This Student ID or Email might already exist.";
        }
        $stmt->close();
    }
}

include '../views/register_view.php';
?>