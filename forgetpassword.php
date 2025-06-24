<?php
session_start();
include_once "db.php";
include_once "head.php";
include_once "mail.php";

$error = '';
$success = '';

if (isset($_POST['email'])) {

    $email = $_POST['email'];

    $db = db();
    
    $result = $db->query("SELECT * FROM users WHERE email = '$email'");
    
    if ($result->num_rows > 0) {
        
        $user = $result->fetch_assoc();

        $token = bin2hex(random_bytes(32));
        
        // Store token in session instead of database
        $_SESSION['reset_token'] = $token;
        $_SESSION['reset_email'] = $user['email'];
        $_SESSION['token_expires'] = date("Y-m-d H:i:s", time() + 3600); // 1 hour expiration
        
        
        // Send email (in a real app, you would actually send this)
        $resetLink = "http://localhost/organic/reset-password.php?token=$token";
        $success = mailer($resetLink, $_SESSION['reset_email'], "Password reset link has been sent to your email!") ? "Password reset link sent Successfully.." : "Password reset link sent Failed..";
        
        // For demo purposes, we'll just show the link
        $_SESSION['demo_reset_link'] = $resetLink;
    } else {
        $error = "No account found with that email address";
    }
    
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password Ogani</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
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
                <h3><i class="fas fa-key"></i> Forgot Your Password?</h3>
                <p class="mb-0">Enter your email and we'll send you a reset link</p>
            </div>
            <div class="password-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($success); ?>
                        <?php if (isset($_SESSION['demo_reset_link'])): ?>
                            <div class="mt-3">
                                <small>Demo Link: <a href="<?php echo $_SESSION['demo_reset_link']; ?>">Reset Password</a></small>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email address">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-reset btn-primary mb-3">
                        <i class="fas fa-paper-plane me-2"></i> Send Reset Link
                    </button>
                    
                    <div class="text-center">
                        <a href="login.php" class="back-to-login">
                            <i class="fas fa-arrow-left me-1"></i> Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include_once "footer.php"; ?>
</body>
</html>