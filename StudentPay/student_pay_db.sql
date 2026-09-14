CREATE DATABASE IF NOT EXISTS student_pay_db;
USE student_pay_db;

CREATE TABLE IF NOT EXISTS users (
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
);

CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id VARCHAR(50),
    receiver_id VARCHAR(50),
    amount DECIMAL(10,2),
    type VARCHAR(20), 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS dues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50),
    provider_id VARCHAR(50),
    amount DECIMAL(10,2),
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS money_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50),
    amount DECIMAL(10,2),
    type VARCHAR(20),
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    provider_id VARCHAR(50),
    item_name VARCHAR(100),
    price DECIMAL(10,2),
    is_available BOOLEAN DEFAULT TRUE
);