<?php
// Common Model functions for database queries

function getUserBalance($conn, $std_id) {
    $stmt = $conn->prepare("SELECT balance FROM users WHERE student_id = ?");
    $stmt->bind_param("s", $std_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc()['balance'];
    }
    return 0.00;
}

function getUserInfo($conn, $std_id) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE student_id = ?");
    $stmt->bind_param("s", $std_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function deleteStudent($conn, $d_id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE student_id = ? AND role = 'student'");
    $stmt->bind_param("s", $d_id);
    $stmt->execute();
    $stmt->close();
}
?>