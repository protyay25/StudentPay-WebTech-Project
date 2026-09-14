<?php
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbName = "student_pay_db";

$conn = mysqli_connect($host, $user, $password);

$conn->query("CREATE DATABASE IF NOT EXISTS $dbName");
mysqli_select_db($conn, $dbName);

$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NULL UNIQUE,
    phone VARCHAR(20) NULL,
    department VARCHAR(50) NULL,
    semester VARCHAR(20) NULL,
    blood_group VARCHAR(10) NULL,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'student',
    balance DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id VARCHAR(50),
    receiver_id VARCHAR(50),
    amount DECIMAL(10,2),
    type VARCHAR(20), 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS dues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50),
    provider_id VARCHAR(50),
    amount DECIMAL(10,2),
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS money_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50),
    amount DECIMAL(10,2),
    type VARCHAR(20),
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    provider_id VARCHAR(50),
    item_name VARCHAR(100),
    price DECIMAL(10,2),
    is_available BOOLEAN DEFAULT TRUE
)");

$admin_pass = password_hash("admin", PASSWORD_DEFAULT);
$cafeteria_pass = password_hash("service", PASSWORD_DEFAULT);
$cashier_pass = password_hash("cash", PASSWORD_DEFAULT);

$accounts = [
    "('Admin', '123-456', '$admin_pass', 'admin')",
    "('Cafeteria', '12-34-56', '$cafeteria_pass', 'cafeteria')",
    "('Cashier', '1-2-3-4', '$cashier_pass', 'cashier')"
];

foreach ($accounts as $acc) {
    $conn->query("REPLACE INTO users (full_name, student_id, password_hash, role) VALUES $acc");
}

echo "<h3 style='color:green;'>Database Setup Completed Successfully!</h3>";
echo "<b>Login Credentials:</b><br>";
echo "Admin -> ID: 123-456 | Pass: admin<br>";
echo "Cafeteria -> ID: 12-34-56 | Pass: service<br>";
echo "Cashier -> ID: 1-2-3-4 | Pass: cash<br>";
?>