<?php
session_start();
include '../models/db_model.php';
include '../models/user_model.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$user_info = getUserInfo($conn, $_SESSION['user_id']);
if ($user_info) {
    echo json_encode(['balance' => $user_info['balance']]);
} else {
    echo json_encode(['error' => 'Not found']);
}
?>