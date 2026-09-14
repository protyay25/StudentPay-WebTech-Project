<?php
session_start();
include '../models/db_model.php';
if ($_SESSION['role'] != 'cashier') { header("Location: login.php"); exit(); }

if (isset($_POST['process_req'])) {
    $req_id = $_POST['req_id'];
    $std_id = $_POST['student_id'];
    $amt = $_POST['amount'];
    $type = $_POST['type'];

    if ($type == 'add') {
        $conn->query("UPDATE users SET balance = balance + $amt WHERE student_id = '$std_id'");
        $conn->query("INSERT INTO transactions (sender_id, receiver_id, amount, type) VALUES ('Cashier', '$std_id', '$amt', 'add_money')");
    } else {
        $conn->query("UPDATE users SET balance = balance - $amt WHERE student_id = '$std_id'");
        $conn->query("INSERT INTO transactions (sender_id, receiver_id, amount, type) VALUES ('$std_id', 'Cashier', '$amt', 'cashout')");
    }
    $conn->query("UPDATE money_requests SET status = 'approved' WHERE id = '$req_id'");
    $msg = "Transaction Approved Successfully!";
}

include '../views/cashier_dashboard_view.php';
?>