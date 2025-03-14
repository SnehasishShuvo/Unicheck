<?php
session_start();
include 'config.php';

if (!isset($_GET['token'])) {
    header("location: login.php");
    exit;
}

$token = mysqli_real_escape_string($conn, $_GET['token']);
$current_time = date('Y-m-d H:i:s');

// Verify token and check if it's not expired
$sql = "SELECT * FROM users WHERE reset_token = '$token' AND reset_expiry > '$current_time'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    $_SESSION['error'] = "Invalid or expired reset link.";
    header("location: forgot_password.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $update_sql = "UPDATE users SET password='$hashed_password', reset_token=NULL, reset_expiry=NULL WHERE reset_token='$token'";
        
        if (mysqli_query($conn, $update_sql)) {
            $_SESSION['message'] = "Password has been reset successfully!";
            header("location: login.php");
            exit;
        } else {
            $error = "Error resetting password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="auth-container">
            <h2 class="text-center mb-4 welcome-header">Create New Password</h2>
            
            <?php if(isset($error)) { ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <div class="text-center mb-4">
                <i class="bi bi-shield-lock-fill text-primary" style="font-size: 3rem;"></i>
            </div>

            <p class="text-center text-muted mb-4">
                Please enter your new password below.
            </p>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock me-2"></i>New Password
                    </label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <div class="mb-4">
                    <label for="confirm_password" class="form-label">
                        <i class="bi bi-lock-fill me-2"></i>Confirm Password
                    </label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-check2-circle me-2"></i>Reset Password
                </button>
            </form>
        </div>
    </div>
</body>
</html> 