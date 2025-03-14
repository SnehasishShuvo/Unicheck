<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

// Handle Delete Operation
if (isset($_POST['delete'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "DELETE FROM users WHERE id = $user_id";
    if (mysqli_query($conn, $sql)) {
        session_destroy();
        header("location: login.php");
        exit;
    }
}

// Handle Update Operation
if (isset($_POST['update'])) {
    $user_id = $_SESSION['user_id'];
    $new_username = mysqli_real_escape_string($conn, $_POST['new_username']);
    $new_email = mysqli_real_escape_string($conn, $_POST['new_email']);
    
    $sql = "UPDATE users SET username='$new_username', email='$new_email' WHERE id=$user_id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['username'] = $new_username;
        $success_message = "Profile updated successfully!";
    } else {
        $error_message = "Error updating profile: " . mysqli_error($conn);
    }
}

// Fetch Current User Data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user_data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="dashboard-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="welcome-header">
                    <i class="bi bi-person-circle me-2"></i>
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                </h2>
                <a href="logout.php" class="btn btn-danger">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </a>
            </div>

            <?php if(isset($success_message)) { ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    <?php echo $success_message; ?>
                </div>
            <?php } ?>
            
            <?php if(isset($error_message)) { ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php } ?>

            <div class="card mb-4">
                <div class="card-header">
                    <h4><i class="bi bi-person-badge me-2"></i>Your Profile Information</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="new_username" class="form-label">
                                <i class="bi bi-person me-2"></i>Username
                            </label>
                            <input type="text" class="form-control" id="new_username" name="new_username" 
                                   value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="new_email" class="form-label">
                                <i class="bi bi-envelope me-2"></i>Email
                            </label>
                            <input type="email" class="form-control" id="new_email" name="new_email" 
                                   value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                        </div>
                        
                        <button type="submit" name="update" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Profile
                        </button>
                    </form>
                </div>
            </div>

            <div class="card delete-section">
                <div class="card-header">
                    <h4><i class="bi bi-exclamation-triangle me-2"></i>Delete Account</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="bi bi-info-circle me-2"></i>
                        Warning: This action cannot be undone. All your data will be permanently deleted.
                    </p>
                    <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                        <button type="submit" name="delete" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Delete Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 