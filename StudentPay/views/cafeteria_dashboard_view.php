<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Dashboard</title>
    <link rel="stylesheet" href="../styles/cafeteria_style.css">
</head>
<body>
    <div class="cafeteria-container">
        
        <div class="header-card">
            <div class="header-title">
                <h1>Cafeteria Dashboard</h1>
                <span>Service Provider Panel</span>
            </div>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>

        <?php if(isset($success_msg)) echo "<div class='alert alert-success'>$success_msg</div>"; ?>
        <?php if(isset($error_msg)) echo "<div class='alert alert-danger'>$error_msg</div>"; ?>
        
        <div class="card">
            <div class="card-title">Generate Bill for Student</div>
            <form method="POST">
                <div class="form-row">
                    <div class="input-group">
                        <label>Student ID</label>
                        <input type="text" name="student_id" placeholder="e.g. 23-55002-3" required>
                    </div>
                    <div class="input-group">
                        <label>Amount (TK)</label>
                        <input type="number" name="amount" min="1" placeholder="e.g. 50" required>
                    </div>
                    <button type="submit" name="add_due" class="btn-submit">Send Bill</button>
                </div>
            </form>
        </div>

        <?php if(isset($success_item_msg)) echo "<div class='alert alert-success'>$success_item_msg</div>"; ?>

        <div class="card">
            <div class="card-title">Manage Items</div>
            <form method="POST" style="margin-bottom: 25px;">
                <div class="form-row">
                    <div class="input-group">
                        <label>Item Name</label>
                        <input type="text" name="item_name" placeholder="e.g. Ghost / Alu Piyaji" required>
                    </div>
                    <div class="input-group">
                        <label>Price (TK)</label>
                        <input type="number" name="price" min="1" placeholder="e.g. 20" required>
                    </div>
                    <button type="submit" name="add_item" class="btn-submit btn-dark">Add Item</button>
                </div>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $items = $conn->query("SELECT * FROM items WHERE provider_id='$provider'");
                    if($items->num_rows > 0) {
                        while($i = $items->fetch_assoc()) echo "<tr><td>{$i['item_name']}</td><td class='text-amount'>TK ".number_format($i['price'], 2)."</td></tr>";
                    } else {
                        echo "<tr><td colspan='2' style='text-align:center; color:#64748b;'>No items added yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Payment History (Received) Table Restored -->
        <div class="card">
            <div class="card-title">Payment History (Received)</div>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Student ID</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $trans = $conn->query("SELECT * FROM transactions WHERE receiver_id = '$provider' ORDER BY id DESC");
                    if($trans->num_rows > 0) {
                        while($t = $trans->fetch_assoc()) echo "<tr><td>{$t['created_at']}</td><td>{$t['sender_id']}</td><td class='text-amount'>TK ".number_format($t['amount'], 2)."</td></tr>";
                    } else {
                        echo "<tr><td colspan='3' style='text-align:center; color:#64748b;'>No payments received yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>