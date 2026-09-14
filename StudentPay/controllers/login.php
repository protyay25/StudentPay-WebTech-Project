<?php
session_start();
include '../models/db_model.php';

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') header("Location: admin_dashboard.php");
    elseif ($_SESSION['role'] == 'cafeteria') header("Location: cafeteria_dashboard.php");
    elseif ($_SESSION['role'] == 'cashier') header("Location: cashier_dashboard.php");
    else header("Location: dashboard.php");
    exit();
}

$error = "";

if (isset($_POST['login_submit'])) {
    $student_id = trim($_POST['student_id']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, full_name, password_hash, role FROM users WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $student_id;
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            
            if ($user['role'] == 'admin') header("Location: admin_dashboard.php");
            elseif ($user['role'] == 'cafeteria') header("Location: cafeteria_dashboard.php");
            elseif ($user['role'] == 'cashier') header("Location: cashier_dashboard.php");
            else header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid Password!";
        }
    } else {
        $error = "User ID not found!";
    }
    $stmt->close();
}

include '../views/login_view.php';
?>