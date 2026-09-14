<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentPay - Registration</title>   
    <link rel="stylesheet" href="../styles/reg.css">
</head>
<body>
    <div class="WhiteRegDiv">
        <div class="icon">           
            <img src="../StudentLogo.jpg" alt="Icon">
        </div>
        <h1>Student Registration</h1>
        <p>Please provide your academic and personal details to continue</p>
        <?php if(!empty($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post" onsubmit="return validateRegistration()">
            <div class="form-grid">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label>Student ID</label>
                    <input type="text" name="student_id" placeholder="xx-xxxxx-x" required>
                </div>
                <div class="form-group full-width">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter institutional email address" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" placeholder="01XXXXXXXXX" required>
                </div>
                <div class="form-group">
                    <label>Blood Group</label>
                    <input type="text" name="blood_group" placeholder="Enter your blood group" required>
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <select name="department" required>
                        <option value="" disabled selected>Select Department</option>
                        <option value="CSE">CSE</option>
                        <option value="BBA">BBA</option>
                        <option value="EEE">EEE</option>
                        <option value="English">English</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Semester / Batch</label>
                    <input type="text" name="semester" placeholder="e.g., 5th" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Create a strong password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Re-type your password" required>
                </div>
            </div>
            <div class="form-check">
                <input type="checkbox" id="terms" required>
                <label for="terms">I agree to the <a href="#">Terms & Conditions</a></label>
            </div>
            <button type="submit" name="register_submit" class="signinbtn">Register</button>
        </form>
        <div class="footer-text">
            Already have an account? <a href="login.php">Sign in here</a>
        </div>
    </div>
    <script>
    function validateRegistration() {
        let pass = document.querySelector('input[name="password"]').value;
        let cpass = document.querySelector('input[name="confirm_password"]').value;
        let phone = document.querySelector('input[name="phone"]').value;
        if (pass !== cpass) {
            alert("JS Validation Error: Passwords do not match!");
            return false; 
        }
        if (phone.length < 11 || isNaN(phone)) {
            alert("JS Validation Error: Please enter a valid 11-digit phone number!");
            return false;
        }
        return true; 
    }
    </script>
</body>
</html>