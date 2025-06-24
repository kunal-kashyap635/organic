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

<?php
session_start();
include_once "db.php";

$custid = $_GET['cid'] ? $_GET['cid'] : null;

$db = db();

$sql = "select * from users where id = '$custid'";
$qr = $db->query($sql);
if ($qr->num_rows > 0) {
    $result = $qr->fetch_assoc();

    // Split the full name into parts
    $nameParts = explode(' ', $result['name']);
    $firstName = $nameParts[0];
    $lastName = implode(' ', array_slice($nameParts, 1)); // Handle multiple last names
}

if (isset($_POST['email'])) {

    $db = db();
    $id = $_POST['id'];
    $name = $_POST['fname'] . ' ' . $_POST['lname'];
    $pwd = md5($_POST['password']);

    $qr = $db->query("update users set name = '$name', email = '{$_POST['email']}' , password = '$pwd' , phone = '{$_POST['phone']}' , address = '{$_POST['address']}' where id = '$id'");

    if ($qr) {
        $_SESSION['message'] = "Customer ID $id Updated successfully";
        $_SESSION['message_type'] = "success"; // for styling (success=green, error=red)
    } else {
        $_SESSION['message'] = "Failed to delete customer ID $custid";
        $_SESSION['message_type'] = "danger";
    }
    $db->close();
    header("Location: customer.php");
    exit();
}
include_once "head.php";

?>

<body>
    <div class="registration-form">
        <h2 class="form-title">Create Your Account</h2>

        <form action="" method="post" id="frm">
            <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" value="<?php echo $firstName; ?>" name="fname" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" value="<?php echo $lastName; ?>" name="lname" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" value="<?php echo $result['email']; ?>" name="email" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" value="<?php echo $result['phone']; ?>" name="phone">
            </div>

            <div class="form-group">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" value="<?php echo $result['address']; ?>" name="address">
            </div>

            <button type="submit" class="btn-submit">Update</button>

        </form>
    </div>
    <?php include_once "footer.php";   ?>
</body>

</html>