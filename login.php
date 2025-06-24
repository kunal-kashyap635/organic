<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ogani</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #6c757d;
            --light-gray: #f8f9fa;
            --border-radius: 8px;
        }

        body {
            background-color: var(--light-gray);
            font-family: 'Cairo', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .login-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin: 20px 0;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #333;
        }

        .login-subtitle {
            color: var(--secondary-color);
            font-size: 16px;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            height: 48px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px 15px;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .form-check-input {
            margin-right: 8px;
        }

        .btn-login {
            width: 100%;
            height: 48px;
            border-radius: var(--border-radius);
            font-weight: 600;
            background-color: var(--primary-color);
            border: none;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .btn-login:hover {
            background-color: #3a5ccc;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: var(--secondary-color);
        }

        .divider-line {
            flex-grow: 1;
            height: 1px;
            background-color: #dee2e6;
        }

        .divider-text {
            padding: 0 15px;
            font-size: 14px;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: var(--secondary-color);
        }

        .signup-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<?php
session_start();
include_once "db.php";
?>

<?php
$msg = null;

if (isset($_POST['email'])) {

    $db = db();

    $pass = md5($_POST['password']);

    $sql = "select * from users where email = '{$_POST['email']}' and password = '$pass'";

    $qr = $db->query($sql);

    if ($qr->num_rows > 0) {
        $res = $qr->fetch_assoc();
        $_SESSION['id'] = $res['id'];
        $_SESSION['name'] = $res['name'];
        header("location: index.php");
        exit;
    } else {
        $msg = "Invalid Credentials.....";
    }
}
?>

<?php include_once "head.php"; ?>
<body>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1 class="login-title">Welcome Back</h1>
                <p class="login-subtitle">Please enter your login details</p>
            </div>

            <form action="" method="post" id="loginForm">
                <div class="form-group">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="johndoe@gmail.com" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                </div>

                <div class="remember-forgot">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="http://localhost/organic/forgetpassword.php" target="_blank" class="text-primary">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-primary btn-login">LOGIN</button>

                <div class="mb-3">
                    <?php echo isset($msg) ? "<p class='alert alert-danger mt-2 mb-2'>$msg</p>" : null; ?>
                </div>

                <div class="divider">
                    <div class="divider-line"></div>
                    <div class="divider-text">OR</div>
                    <div class="divider-line"></div>
                </div>

                <div class="social-icons text-center mb-3">
                    <a href="#" class="btn btn-outline-primary me-2"><i class="fab fa-google me-2"></i>Google</a>
                    <a href="#" class="btn btn-outline-primary"><i class="fab fa-facebook-f me-2"></i>Facebook</a>
                </div>

                <p class="signup-link">Don't have an account? <a href="http://localhost/organic/register.php">Sign up</a></p>
            </form>
        </div>
    </div>

    <?php include_once "footer.php"; ?>
</body>
</html>
