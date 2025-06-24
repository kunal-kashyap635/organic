<?php
session_start();
include_once "db.php";
include_once "head.php";

$error = '';
$success = '';

// Validate token
if (isset($_GET['token'])) {

    if (! isset($_SESSION['reset_token']) || $_SESSION['reset_token'] !== $_GET['token'] || time() > $_SESSION['token_expires']) {
        $error = "Invalid or expired token";
    }
}

// Process password reset
if (isset($_POST['password']) && ! empty($_SESSION['reset_email'])) {

    $email = $_SESSION['reset_email'];
    $password = md5($_POST['password']);

    $db = db();
    $qr = $db->query("UPDATE users SET password = '$password' WHERE email = '$email'");
    
    if($qr){
        $success = "Password updated successfully!";

        // Clear reset session variables
        unset($_SESSION['reset_token']);
        unset($_SESSION['reset_email']);
        unset($_SESSION['token_expires']);
    } else {
        $error = "Failed to update password";
    }
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Your App Name</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Same styles as forgot-password.php */
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
        }
        
        body {
            background-color: var(--secondary-color);
            height: 100vh;
            /* display: flex; */
            align-items: center;
        }

        .container {
            margin-bottom: 50px;
        }
        
        .password-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            overflow: hidden;
            max-width: 450px;
            margin: 0 auto;
        }
        
        .password-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        
        .password-body {
            padding: 2rem;
            background-color: white;
        }
        
        .btn-reset {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            padding: 10px 20px;
            width: 100%;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .back-to-login {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .back-to-login:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="password-card">
            <div class="password-header">
                <h3><i class="fas fa-key"></i> Reset Your Password</h3>
            </div>
            <div class="password-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <div class="text-center mt-3">
                        <a href="forgot-password.php" class="back-to-login">
                            <i class="fas fa-arrow-left me-1"></i> Request new reset link
                        </a>
                    </div>
                <?php elseif ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <div class="text-center mt-3">
                        <a href="login.php" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-1"></i> Go to Login
                        </a>
                    </div>
                <?php else: ?>
                    <form method="POST" action="reset-password.php<?php echo isset($_GET['token']) ? '?token=' . htmlspecialchars($_GET['token']) : ''; ?>">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Enter new password">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="Confirm new password">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-reset btn-primary mb-3">
                            <i class="fas fa-save me-2"></i> Reset Password
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include_once "footer.php"; ?>

    <!-- Password confirmation validation -->
    <script>
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    </script>
</body>
</html>