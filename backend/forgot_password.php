<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        // Generate reset token
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Store token in database
        $update_sql = "UPDATE users SET reset_token='$token', reset_expiry='$expiry' WHERE email='$email'";
        if (mysqli_query($conn, $update_sql)) {
            // In a real application, you would send an email with the reset link
            // For demonstration, we'll just show the token
            $success = "Password reset link has been sent to your email!";
            
            // Create reset link (in real application, this would be sent via email)
            $reset_link = "reset_password.php?token=" . $token;
            $_SESSION['demo_reset_link'] = $reset_link; // This is just for demonstration
        } else {
            $error = "Error generating reset link. Please try again.";
        }
    } else {
        $error = "No account found with that email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="auth-container">
            <h2 class="text-center mb-4 welcome-header">Reset Password</h2>
            
            <?php if(isset($error)) { ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <?php if(isset($success)) { ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    <?php echo $success; ?>
                </div>
                <!-- This is just for demonstration purposes -->
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Demo Reset Link: <a href="<?php echo $_SESSION['demo_reset_link']; ?>" class="alert-link">Click here to reset password</a>
                </div>
            <?php } ?>

            <div class="text-center mb-4">
                <i class="bi bi-key-fill text-primary" style="font-size: 3rem;"></i>
            </div>

            <p class="text-center text-muted mb-4">
                Enter your email address and we'll send you a link to reset your password.
            </p>

            <form action="" method="POST">
                <div class="mb-4">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope me-2"></i>Email Address
                    </label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-send me-2"></i>Send Reset Link
                </button>
            </form>
            
            <p class="text-center mt-3">
                Remember your password? <a href="login.php" class="auth-link">Login here</a>
            </p>
        </div>
    </div>
</body>
</html> 