<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles/admin_style.css">
</head>
<body>
    <div class="admin-container">        
        <div class="admin-header-card">
            <div class="admin-info">
                <div class="admin-icon">🛡️</div>
                <div class="admin-text">
                    <h1>System Administrator</h1>
                    <span class="admin-badge">Admin Control Panel</span>
                </div>
            </div>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="card-title">All Students List</div>
                <form method="GET" class="filter-form">
                    <input type="text" name="search_id" placeholder="Search by Student ID" 
                           value="<?php echo isset($_GET['search_id']) ? htmlspecialchars($_GET['search_id']) : ''; ?>">
                    <button type="submit" class="btn-action">Search</button>
                    <?php if(isset($_GET['search_id']) && $_GET['search_id'] != ''): ?>
                        <a href="admin_dashboard.php" class="btn-clear">Clear</a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Student ID</th>
                            <th>Dept</th>
                            <th>Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $student_query = "SELECT * FROM users WHERE role='student'";
                        if(isset($_GET['search_id']) && trim($_GET['search_id']) != '') {
                            $search = trim($_GET['search_id']);
                            $student_query .= " AND student_id LIKE '%$search%'";
                        }
                        
                        $users = $conn->query($student_query);
                        
                        if($users->num_rows > 0) {
                            while($u = $users->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$u['full_name']}</td>
                                    <td>{$u['student_id']}</td>
                                    <td>{$u['department']}</td>
                                    <td class='text-amount'>TK ".number_format($u['balance'], 2)."</td>
                                    <td>
                                        <a href='?delete_user={$u['student_id']}' class='btn-remove' onclick=\"return confirm('Are you sure you want to remove this student?');\">Remove</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align:center;'>No students found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">All Transactions Log</div>
                
                <form method="GET" class="filter-form">
                    <?php if(isset($_GET['search_id'])): ?>
                        <input type="hidden" name="search_id" value="<?php echo htmlspecialchars($_GET['search_id']); ?>">
                    <?php endif; ?>
                    
                    <select name="type">
                        <option value="">All Transactions</option>
                        <option value="payment" <?php if(isset($_GET['type']) && $_GET['type']=='payment') echo 'selected'; ?>>Payments</option>
                        <option value="add_money" <?php if(isset($_GET['type']) && $_GET['type']=='add_money') echo 'selected'; ?>>Add Money</option>
                        <option value="cashout" <?php if(isset($_GET['type']) && $_GET['type']=='cashout') echo 'selected'; ?>>Cashout</option>
                    </select>
                    <button type="submit" class="btn-action">Filter</button>
                    <?php if(isset($_GET['type']) && $_GET['type'] != ''): ?>
                        <a href="admin_dashboard.php<?php echo isset($_GET['search_id']) ? '?search_id='.$_GET['search_id'] : ''; ?>" class="btn-clear">Clear Filter</a>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM transactions ";
                        if(isset($_GET['type']) && $_GET['type'] != '') {
                            $type = $_GET['type'];
                            $sql .= " WHERE type='$type' ";
                        }
                        $sql .= " ORDER BY id DESC";
                        
                        $trans = $conn->query($sql);
                        
                        if($trans->num_rows > 0) {
                            while($t = $trans->fetch_assoc()) {
                                $type_formatted = str_replace('_', ' ', $t['type']);
                                
                                // Sender Logic: Student হলে শুধু ID, বাকিদের ক্ষেত্রে Name
                                $sender_display = $t['sender_id'];
                                if($t['sender_id'] == 'Cashier') {
                                    $sender_display = 'Cashier';
                                } else {
                                    $s_q = $conn->query("SELECT role, full_name FROM users WHERE student_id = '{$t['sender_id']}'");
                                    if($s_q->num_rows > 0) {
                                        $s_data = $s_q->fetch_assoc();
                                        if($s_data['role'] == 'student') {
                                            $sender_display = $t['sender_id']; // স্টুডেন্ট হলে আইডি
                                        } else {
                                            $sender_display = $s_data['full_name']; // অন্যরা হলে নাম
                                        }
                                    }
                                }

                                // Receiver Logic: Student হলে শুধু ID, বাকিদের ক্ষেত্রে Name
                                $receiver_display = $t['receiver_id'];
                                if($t['receiver_id'] == 'Cashier') {
                                    $receiver_display = 'Cashier';
                                } else {
                                    $r_q = $conn->query("SELECT role, full_name FROM users WHERE student_id = '{$t['receiver_id']}'");
                                    if($r_q->num_rows > 0) {
                                        $r_data = $r_q->fetch_assoc();
                                        if($r_data['role'] == 'student') {
                                            $receiver_display = $t['receiver_id']; // স্টুডেন্ট হলে আইডি
                                        } else {
                                            $receiver_display = $r_data['full_name']; // অন্যরা হলে নাম
                                        }
                                    }
                                }

                                echo "<tr>
                                    <td>{$t['created_at']}</td>
                                    <td style='text-transform: capitalize;'>{$type_formatted}</td>
                                    <td>{$sender_display}</td>
                                    <td>{$receiver_display}</td>
                                    <td class='font-medium'>TK ".number_format($t['amount'], 2)."</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align:center;'>No transactions found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>