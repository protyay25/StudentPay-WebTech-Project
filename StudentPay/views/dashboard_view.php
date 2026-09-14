<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../styles/dashboard.css">
</head>
<body>
    <div class="dashboard-container">    
        <div class="profile-header">
            <div class="profile-details">
                <div class="profile-avatar">🎓</div>
                <div class="profile-text">
                    <h2><?php echo htmlspecialchars($user_info['full_name']); ?></h2>
                    <span class="badge">Student ID: <?php echo htmlspecialchars($std_id); ?></span>
                </div>
            </div>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>

        <?php if(!empty($success_msg)) echo "<div class='alert alert-success'>$success_msg</div>"; ?>
        <?php if(!empty($error_msg)) echo "<div class='alert alert-danger'>$error_msg</div>"; ?>

        <div class="balance-section">
            <div class="balance-title">
                Current Balance 
            </div>
            <div class="balance-amount" id="current-balance">TK <?php echo number_format($user_info['balance'], 2); ?></div>
        </div>

        <div class="card">
            <div class="card-header">Request Add Money / Cashout</div>
            <div class="card-body">
                <form method="POST" action="dashboard.php" class="action-form" onsubmit="return validateRequestForm()">
                    <div class="input-group">
                        <label>Amount:</label>
                        <input type="number" name="amount" min="1" placeholder="e.g. 500" required>
                    </div>
                    <div class="input-group">
                        <label>Type:</label>
                        <select name="type">
                            <option value="add">Add Money</option>
                            <option value="cashout">Cashout</option>
                        </select>
                    </div>
                    <button type="submit" name="req_money" class="btn-submit">Submit Request</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Pending Payments</div>
            <div class="card-body no-padding">
                <table>
                    <thead>
                        <tr>
                            <th>Service Provider</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($dues->num_rows > 0) {
                            while($d =$dues->fetch_assoc()) {
                                echo "<tr>
                                    <td><strong>{$d['provider_name']}</strong></td>
                                    <td class='text-amount'>{$d['amount']} TK</td>
                                    <td>
                                        <form method='POST' action='dashboard.php' style='margin:0;'>
                                            <input type='hidden' name='due_id' value='{$d['id']}'>
                                            <input type='hidden' name='amount' value='{$d['amount']}'>
                                            <input type='hidden' name='provider_id' value='{$d['provider_id']}'>
                                            <button type='submit' name='pay_bill' class='btn-pay'>Pay Now</button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>No pending payments.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">My Transaction History</div>
            <div class="card-body no-padding">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>To / From</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($trans->num_rows > 0) {
                            while($t = $trans->fetch_assoc()) {$is_sender = ($t['sender_id'] ==$std_id);
                                $other_id =$is_sender ? $t['receiver_id'] :$t['sender_id'];
                                
                                $name_q =$conn->query("SELECT full_name FROM users WHERE student_id = '$other_id'");
                                $other_name = ($name_q->num_rows > 0) ? $name_q->fetch_assoc()['full_name'] :$other_id;

                                $prefix =$is_sender ? "To: " : "From: ";
                                $type_formatted = str_replace('_', ' ',$t['type']);
                                
                                echo "<tr>
                                    <td>{$t['created_at']}</td>
                                    <td style='text-transform: capitalize;'>{$type_formatted}</td>
                                    <td>{$prefix} <strong>{$other_name}</strong></td>
                                    <td class='text-amount'>{$t['amount']} TK</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>No transactions yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
    function validateRequestForm() {
        let amount = document.querySelector('input[name="amount"]').value;
        if (amount <= 0) {
            alert("JS Validation Error: Amount must be greater than 0.");
            return false;
        }
        return true; 
    }
    </script>
</body>
</html>