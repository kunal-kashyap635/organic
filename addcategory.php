<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 10px;
        }

        .category-form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .form-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            font-weight: 500;
            margin-top: 20px;
        }

        .form-check-input {
            width: 50px;
            height: 25px;
        }
    </style>
</head>


<?php
include_once "head.php";

include_once "db.php";
$msg = null;
if (isset($_POST['cname'])) {

    $db = db();
    $cname = $_POST['cname'];

    // print_r($_FILES);

    if ($_FILES['fileupload']['name'] != "") {
        move_uploaded_file($_FILES['fileupload']['tmp_name'], "./category/" . $_FILES['fileupload']['name']);
    }

    $cimage = $_FILES['fileupload']['name'];

    $sql = "insert into category(cname,cimage) values('$cname','$cimage')";
    $qr = $db->query($sql);

    $msg = $qr ? " '{$cname}' category Inserted successfully" : "some error in execution";

    $db->close();
}


?>

<body>
    <div class="category-form-container">
        <h2 class="form-title">Add Category</h2>

        <form action="" enctype="multipart/form-data" method="post" id="frm">
            <!-- Category Name -->
            <div class="mb-3">
                <label for="categoryName" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="categoryName" name="cname" placeholder="Enter category name" required>
            </div>

            <!-- Category Image -->
            <div class="mb-3">
                <label for="categoryImage" class="form-label">Category Image</label>
                <input type="file" name="fileupload" class="form-control" id="categoryImage" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="categoryDescription" class="form-label">Description (Optional)</label>
                <textarea class="form-control" id="categoryDescription" name="cdesc" rows="3" placeholder="Enter category description"></textarea>
            </div>

            <!-- alert message -->
            <div class="mb-3">
                <?php echo isset($msg) ? "<p class='alert alert-success'>$msg</p>" : null; ?>
            </div>

            <button type="submit" class="btn btn-primary btn-submit">Add Category</button>
        </form>
    </div>
    <br>
    <?php include_once "footer.php"; ?>
</body>

</html>