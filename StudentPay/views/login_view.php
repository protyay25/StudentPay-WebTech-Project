<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StudentPay - Sign In</title>    
    <link rel="stylesheet" href="../styles/login.css">
</head>
<body>
    
    <div class="WhiteDiv">
        <h1>Student Pay</h1>
        <div class="icon">
            <img src="../styles/StudentLogo.jpg" alt="Icon">
        </div>
        <p>Easy and Efficient Commercial Transactions in Campus</p>

        <div class="welcome-section">
            <h2><i>Welcome Here</i></h2>
            <p>Sign in to continue your Transactions</p>
        </div>

        <?php if(!empty($error)) echo "<div class='error'>$error</div>"; ?>

        <form method="post">
            <div class="form-group">
                <label>User ID</label>
                <input type="text" name="student_id" placeholder="Enter your ID" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="login_submit" class="signinbtn">Login</button>
        </form>
        <div class="footer-text">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>

</body>
</html>