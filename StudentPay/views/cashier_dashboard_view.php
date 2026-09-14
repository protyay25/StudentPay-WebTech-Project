<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Dashboard</title>
    <link rel="stylesheet" href="../styles/cashier.css">
</head>
<body>
    <div class="cashier-container">
        
        <div class="cashier-header">
            <div class="cashier-title">
                <h1>💵 Cashier Dashboard</h1>
                <span>Fund Management Portal</span>
            </div>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>

        <?php if(isset($msg)) echo "<div class='alert alert-success'>✅ $msg</div>"; ?>
        
        <!-- Pending Requests Table -->
        <div class="card">
            <div class="card-header">Pending Requests</div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Request Type</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $reqs =$conn->query("SELECT * FROM money_requests WHERE status='pending'");
                        if($reqs->num_rows > 0) {
                            while($r =$reqs->fetch_assoc()) {
                                
                                $badge_class = ($r['type'] == 'add') ? 'badge-add' : 'badge-cashout';
                                $type_text = ($r['type'] == 'add') ? '+ Add Money' : '- Cashout';

                                echo "<tr>
                                    <td><strong>{$r['student_id']}</strong></td>
                                    <td><span class='badge {$badge_class}'>{$type_text}</span></td>
                                    <td class='amount-text'>৳ ".number_format($r['amount'], 2)."</td>
                                    <td>
                                        <form method='POST' style='margin:0;'>
                                            <input type='hidden' name='req_id' value='{$r['id']}'>
                                            <input type='hidden' name='student_id' value='{$r['student_id']}'>
                                            <input type='hidden' name='amount' value='{$r['amount']}'>
                                            <input type='hidden' name='type' value='{$r['type']}'>
                                            <button type='submit' name='process_req' class='btn-approve'>Approve</button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align:center; color:#6b7280;'>No pending requests available.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- All Transactions Table -->
        <div class="card">
            <div class="card-header">All Transactions (Add / Cashout)</div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Transaction Type</th>
                            <th>Student ID</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $trans =$conn->query("SELECT * FROM transactions WHERE type IN ('add_money', 'cashout') ORDER BY id DESC");
                        if($trans->num_rows > 0) {
                            while($t =$trans->fetch_assoc()) {
                                
                                $std = ($t['type'] == 'add_money') ? $t['receiver_id'] :$t['sender_id'];
                                
                                $badge_class = ($t['type'] == 'add_money') ? 'badge-add' : 'badge-cashout';
                                $type_formatted = str_replace('_', ' ',$t['type']);
                                $prefix = ($t['type'] == 'add_money') ? '+' : '-';

                                echo "<tr>
                                    <td>{$t['created_at']}</td>
                                    <td><span class='badge {$badge_class}'>{$type_formatted}</span></td>
                                    <td>{$std}</td>
                                    <td class='amount-text'>{$prefix} ৳ ".number_format($t['amount'], 2)."</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align:center; color:#6b7280;'>No transaction history found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>