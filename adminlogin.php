<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            align-items: center;
            padding: 10px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            background-color: #0d6efd;
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 20px;
            text-align: center;
        }

        .login-body {
            padding: 30px;
            background-color: white;
            border-radius: 0 0 10px 10px;
        }

        .form-control {
            padding: 10px 15px;
            height: 45px;
        }

        .btn-login {
            height: 45px;
            font-weight: 500;
        }

        .input-group-text {
            background-color: transparent;
        }
    </style>
</head>

<?php
session_start();

include_once "db.php";
$msg = null;
if (isset($_POST['username'])) {

    $db = db();

    $uname = $_POST['username'];
    $pwd = md5($_POST['password']);

    $sql = "select * from admin where name = '$uname' and password = '$pwd'";
    $qr = $db->query($sql);

    if ($qr->num_rows > 0) {
        $res = $qr->fetch_assoc();
        $_SESSION['aid'] = $res['id'];
        header("location: admindashboard.php");
    } else {
        $msg = "Invalid Credentials.....";
    }
    $db->close();
}
include_once "head.php";
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="login-card mx-auto">
                    <div class="login-header">
                        <h3><i class="fas fa-lock me-2"></i>Admin Login</h3>
                    </div>
                    <div class="login-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter admin username" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-login">Login</button>

                            <div class="mb-3 mt-3">
                                <?php echo isset($msg) ? "<p class='alert alert-danger'>$msg</p>" : null; ?>
                            </div>

                            <div class="text-center mt-3">
                                <a href="#" class="text-decoration-none">Forgot password</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p class="text-muted">Copyright &copy; All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "footer.php"; ?>
</body>
</html>