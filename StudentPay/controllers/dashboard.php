<?php
session_start();
include '../models/db_model.php';
include '../models/user_model.php';

if ($_SESSION['role'] != 'student') { 
    header("Location: login.php"); 
    exit(); 
}
$std_id = $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

if (isset($_POST['pay_bill'])) {
    $due_id = $_POST['due_id'];
    $amount = $_POST['amount'];
    $provider = $_POST['provider_id'];

    $student_balance = getUserBalance($conn, $std_id);

    if ($student_balance >= $amount) {
        $conn->query("UPDATE users SET balance = balance - $amount WHERE student_id = '$std_id'");
        $conn->query("UPDATE users SET balance = balance + $amount WHERE student_id = '$provider'");
        $conn->query("UPDATE dues SET status = 'paid' WHERE id = '$due_id'");
        $conn->query("INSERT INTO transactions (sender_id, receiver_id, amount, type) VALUES ('$std_id', '$provider', '$amount', 'payment')");
        $success_msg = "Payment Successful!";
    } else {
        $error_msg = "Not enough balance!";
    }
}

if (isset($_POST['req_money'])) {
    $amt = $_POST['amount'];
    $type = $_POST['type'];
    
    if ($type == 'cashout') {
        $student_balance = getUserBalance($conn, $std_id);
        if ($amt > $student_balance) {
            $error_msg = "Not Enough Balance for Cash Out!";
        } else {
            $conn->query("INSERT INTO money_requests (student_id, amount, type) VALUES ('$std_id', '$amt', '$type')");
            $success_msg = "Cashout request sent to Cashier!";
        }
    } else {
        $conn->query("INSERT INTO money_requests (student_id, amount, type) VALUES ('$std_id', '$amt', '$type')");
        $success_msg = "Add Money request sent to Cashier!";
    }
}

$user_info = getUserInfo($conn, $std_id);
$dues = $conn->query("SELECT dues.*, users.full_name AS provider_name FROM dues JOIN users ON dues.provider_id = users.student_id WHERE dues.student_id = '$std_id' AND dues.status = 'pending'");
$trans = $conn->query("SELECT * FROM transactions WHERE sender_id = '$std_id' OR receiver_id = '$std_id' ORDER BY id DESC");

include '../views/dashboard_view.php';
?>