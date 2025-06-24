<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .otp-container {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .otp-title {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .otp-message {
            text-align: center;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .otp-inputs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .otp-input {
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 24px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .otp-input:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            outline: none;
        }

        .btn-verify {
            width: 100%;
            padding: 12px;
            font-weight: 500;
        }

        .resend-link {
            text-align: center;
            margin-top: 20px;
        }

        .resend-link a {
            color: #4e73df;
            text-decoration: none;
        }
    </style>
</head>

<?php
session_start();
include_once "db.php";
require "mail.php";
$msg = null;
?>

<?php

// OTP sender
if (isset($_REQUEST['email'])) {

    $_SESSION['otp'] = rand(100000, 999999);

    $fullname = $_REQUEST['fname'] . ' ' . $_REQUEST['lname'];
    $pass = md5($_REQUEST['password']);
    $_SESSION['rval'] = " '$fullname' , '{$_REQUEST['email']}' , '$pass' , '{$_REQUEST['phone']}' , '{$_REQUEST['address']}' ";

    $_SESSION['email'] = $_REQUEST['email'];

    // echo $_SESSION['rval'];
    // echo "<br>";
    // echo $_SESSION['otp'];

    $msg = mailer($_SESSION['otp'], $_REQUEST['email'], "Otp For User Registration ") ? "otp sent successfully." : "error in sending otp";
}

// verify OTP and Add User Details In Database
if (isset($_POST['o1'])) {

    $otp = $_POST['o1'] . $_POST['o2'] . $_POST['o3'] . $_POST['o4'] . $_POST['o5'] . $_POST['o6'];

    if ($_SESSION['otp'] == $otp) {

        $val = $_SESSION['rval'];
        $db = db();

        $sql = "insert into users(name,email,password,phone,address) values($val)";
        // echo $sql;
        $qr = $db->query($sql);
        session_destroy();
        echo "
        <script> 
        alert('Registration is successful, please login with that email'); 
        location.href='./';
        </script>
        ";
    } else { 
        $msg = "invalid otp........."; 
    }
}

// resend OTP 
if (isset($_REQUEST['oresend']))
{
    $_SESSION['otp']=rand(100000,999999);
    $msg = mailer($_SESSION['otp'],$_SESSION['email'],"Otp For User Registration ") ? "otp resent successfully.": "error in sending otp" ;
    // echo $_SESSION['otp']; 
}

?>

<body>
    <div class="otp-container">
        <h2 class="otp-title">OTP Verification</h2>
        <p class="otp-message">We've sent a 6-digit code to your email/phone<br>Enter the code below to verify</p>

        <form action="" method="post" id="frm">
            <div class="otp-inputs">
                <input type="text" name="o1" class="otp-input form-control" maxlength="1" pattern="[0-9]">
                <input type="text" name="o2" class="otp-input form-control" maxlength="1" pattern="[0-9]">
                <input type="text" name="o3" class="otp-input form-control" maxlength="1" pattern="[0-9]">
                <input type="text" name="o4" class="otp-input form-control" maxlength="1" pattern="[0-9]">
                <input type="text" name="o5" class="otp-input form-control" maxlength="1" pattern="[0-9]">
                <input type="text" name="o6" class="otp-input form-control" maxlength="1" pattern="[0-9]">
            </div>

            <button type="submit" class="btn btn-primary btn-verify mb-3">Verify</button>

            <button type="submit" name="oresend" class="btn btn-primary btn-verify">Resend OTP</button>
            
            <div class="mb-3 mt-3">
                <?php echo isset($msg) ? "<p class='alert alert-success'>$msg</p>" : null; ?>
            </div>
        </form>
    </div>
</body>
</html>
