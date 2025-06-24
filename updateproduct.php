<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .form-control:disabled {
            background-color: #fff;
            border: none;
        }

        .edit-mode {
            border: 1px solid #ced4da;
            background-color: #fff;
        }
    </style>
</head>

<?php
include_once "head.php";
include_once "db.php";
$db = db();
?>

<?php
if (isset($_GET['upd'])) {
    $sql = "select * from product where id = '{$_GET['upd']}'";
    $qr = $db->query($sql)->fetch_assoc();
}
?>

<?php
$msg = null;
if (isset($_POST['id'])) {

    $name = $_POST['pname'];
    $desc = $_POST['pdesc'];
    $mrp = $_POST['mrp'];
    $discount = $_POST['disc'];
    $rate = $_POST['rate'];

    if($_FILES['pimg']['name'] != ""){
        move_uploaded_file($_FILES['pimg']['tmp_name'],'./uploads' . $_FILES['pimg']['name']);
    }

    $file = $_FILES['pimg']['name'];

    $sql = "update product set pname = '$name' , pdesc = '$desc' , mrp = '$mrp' , disc = '$discount' , rate = '$rate' , pimage = '$file' where id = '{$_POST['id']}'";

    $qr = $db->query($sql);

    $msg = $qr ? " '{$name}' Updated Successfully..." : "Updation Failed...";
}
?>

<?php $db->close(); ?>

<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Update Product</h3>
                    </div>
                    <div class="card-body">
                        <form id="productForm" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <input type="hidden" name="id" value="<?php echo $qr['id'] ?? ''; ?>">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="pname" value="<?php echo $qr['pname'] ?? ''; ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="productDescription" name="pdesc" rows="3" disabled><?php echo $qr['pdesc'] ?? ''; ?></textarea>
                            </div>

                            <!-- Image Preview and Upload -->
                            <div class="mb-3">
                                <label class="form-label">Product Image</label>
                                <?php if (isset($qr['pimage']) && !empty($qr['pimage'])): ?>
                                    <img src="./uploads/<?php echo $qr['pimage']; ?>" class="image-preview d-block mb-3" id="imagePreview">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/200" class="image-preview d-block" id="imagePreview">
                                <?php endif; ?>
                                <input type="file" class="form-control d-none" id="productImage" name="pimg" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="productPrice" class="form-label">MRP (₹)</label>
                                <input type="number" class="form-control" id="productMRP" name="mrp" value="<?php echo $qr['mrp'] ?? ''; ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="productDiscount" class="form-label">Discount</label>
                                <input type="number" class="form-control" id="productDiscount" name="disc" value="<?php echo $qr['disc'] ?? ''; ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="productRate" class="form-label">Rate (₹)</label>
                                <input type="number" class="form-control" id="productRate" name="rate" value="<?php echo $qr['rate'] ?? ''; ?>" disabled>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-primary" id="editBtn">Edit</button>
                                <button type="submit" class="btn btn-success" id="updBtn" disabled>Update Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "footer.php" ?>
    <script>
        // functionality of edit button
        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('editBtn');
            const saveBtn = document.getElementById('updBtn');
            const form = document.getElementById('productForm');
            const inputs = form.querySelectorAll('input, textarea');
            const imageInput = document.getElementById('productImage');
            const imagePreview = document.getElementById('imagePreview');

            let isEditMode = false;

            editBtn.addEventListener('click', function() {
                isEditMode = !isEditMode;

                if (isEditMode) {
                    // Enable editing
                    inputs.forEach((input) => {
                        input.disabled = false;
                        input.classList.add('edit-mode');
                    });
                    imageInput.disabled = false;
                    imageInput.classList.add('edit-mode');
                    imageInput.classList.remove('d-none');
                    saveBtn.disabled = false;
                    editBtn.textContent = 'Cancel';
                    editBtn.classList.remove('btn-primary');
                    editBtn.classList.add('btn-secondary');
                } else {
                    // Disable editing
                    inputs.forEach((input) => {
                        input.disabled = true;
                        input.classList.remove('edit-mode');
                    });
                    imageInput.disabled = true;
                    imageInput.classList.remove('edit-mode');
                    imageInput.classList.add('d-none');
                    saveBtn.disabled = true;
                    editBtn.textContent = 'Edit';
                    editBtn.classList.remove('btn-secondary');
                    editBtn.classList.add('btn-primary');
                }
            });
        });

        // Image preview functionality Show a message when no image is selected
        // imageInput.addEventListener('change', function() {
        //     const file = this.files[0];
        //     if (file) {
        //         const reader = new FileReader();
        //         reader.onload = function(e) {
        //             imagePreview.src = e.target.result;
        //             imagePreview.style.display = 'block'; // Ensure it's visible
        //         }
        //         reader.readAsDataURL(file);
        //     } else {
        //         // Show placeholder when no file is selected
        //         imagePreview.src = 'https://via.placeholder.com/200';
        //     }
        // });

        // functionality of calculating mrp and rate
        const mrpInput = document.getElementById('productMRP');
        const discountInput = document.getElementById('productDiscount');
        const rateInput = document.getElementById('productRate');

        function calculateSellingPrice() {
            const mrp = parseFloat(mrpInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            const sellingPrice = mrp - (mrp * discount / 100);
            rateInput.value = sellingPrice.toFixed(2);
        }

        mrpInput.addEventListener('input', calculateSellingPrice);
        discountInput.addEventListener('input', calculateSellingPrice);
    </script>
</body>
</html>