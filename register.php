<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            padding: 10px;
        }

        .registration-form {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 5px;
        }

        .form-title {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #4e73df;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #3a5ccc;
        }

        .signup-link {
            margin-top: 15px;
            text-align: left;
            color: #6c757d;
        }

        .signup-link a {
            color: #4e73df;
            text-decoration: none;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .registration-form {
                padding: 20px;
            }
        }
    </style>
</head>

<?php include_once "head.php"; ?>

<body>
    <div class="registration-form">
        <h2 class="form-title">Create Your Account</h2>

        <form action="otp.php" method="post" id="frm">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="fname" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lname" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone">
            </div>

            <div class="form-group">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>

            <div class="form-group">
                <input type="checkbox" id="terms" required>
                <label for="terms">I agree to the terms and conditions</label>
            </div>

            <button type="submit" class="btn-submit">Register</button>

            <p class="signup-link">Do have an account? <a href="http://localhost/organic/login.php">Sign In</a></p>
        </form>
    </div>
    <?php  include_once "footer.php";   ?>
</body>
</html>

