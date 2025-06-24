<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .product-form-container {
            max-width: 800px;
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

        .form-select {
            padding: 10px 15px;
            height: auto;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            font-weight: 500;
            margin-top: 20px;
        }

        .price-fields {
            display: flex;
            gap: 15px;
        }

        .price-fields .form-group {
            flex: 1;
        }

        @media (max-width: 768px) {
            .price-fields {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>

<?php
include_once "head.php";

include_once "db.php";
$msg = null;
if (isset($_POST['pname'])) {
    $db = db();

    $pname = $_POST['pname'];
    $cat = $_POST['category'];
    $desc = $_POST['pdesc'];
    $mrp = $_POST['pmrp'];
    $dis = $_POST['pdis'];
    $rate = $_POST['prate'];

    if ($_FILES['fileupload']['name'] != "") {

        // move_uploaded_file($_FILES['fileupload']['tmp_name'], "./uploads/" . $_FILES['fileupload']['name']);

        $uploadDir = "./uploads/";
        $originalFile = $_FILES['fileupload']['tmp_name'];
        $imageName = $_FILES['fileupload']['name'];

        // Load the original image
        $sourceImage = imagecreatefromstring(file_get_contents($originalFile));

        // Create a blank image with the desired size (474x314)
        $resizedImage = imagecreatetruecolor(474, 314);

        // Resize and copy the original image into the new one
        imagecopyresampled(
            $resizedImage,
            $sourceImage,
            0,
            0,
            0,
            0,
            474,
            314, // New width & height
            imagesx($sourceImage),
            imagesy($sourceImage) // Original width & height
        );

        // Generate a unique filename
        $newFileName = $_FILES['fileupload']['name'];
        $targetPath = $uploadDir . $newFileName;

        // Save the resized image
        imagejpeg($resizedImage, $targetPath, 90); // 90 = quality (1-100)

        // Free up memory
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);
    }

    $pimage = $newFileName;

    $sql = "insert into product(cat,pname,pdesc,mrp,disc,rate,pimage) values('$cat','$pname','$desc','$mrp','$dis','$rate','$pimage')";
    $qr = $db->query($sql);

    $msg = $qr ? "'{$pname}' inserted successfully.." : "Error in some exceution...";

    $db->close();
}
?>

<body>
    <div class="product-form-container">
        <h2 class="form-title">Add Product</h2>

        <form action="" enctype="multipart/form-data" method="post" id="frm">
            <!-- Product Name -->
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="pname" placeholder="Enter product name" required>
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="productCategory" class="form-label">Category</label>

                <?php
                include_once "db.php";
                $db = db();
                $sql = "select * from category";
                $qr = $db->query($sql);
                ?>
                <select class="form-select" id="productCategory" name="category" required>
                    <?php while ($res = $qr->fetch_assoc()) { ?>
                        <option value="<?php echo $res['id'];  ?>"><?php echo $res['cname']; ?></option> <?php } ?>
                </select>
                <?php $db->close(); ?>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="productDescription" class="form-label">Description</label>
                <textarea class="form-control" id="productDescription" name="pdesc" rows="3" placeholder="Enter product description"></textarea>
            </div>

            <!-- Price Fields -->
            <div class="price-fields mb-3">
                <div class="form-group">
                    <label for="productMRP" class="form-label">MRP (₹)</label>
                    <input type="number" class="form-control" id="productMRP" name="pmrp" placeholder="Enter MRP" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label for="productDiscount" class="form-label">Discount (%)</label>
                    <input type="number" class="form-control" id="productDiscount" name="pdis" placeholder="Enter discount" min="0" max="100" value="0">
                </div>
                <div class="form-group">
                    <label for="productRate" class="form-label">Selling Price (₹)</label>
                    <input type="number" class="form-control" id="productRate" name="prate" placeholder="Calculated price" readonly>
                </div>
            </div>

            <!-- Product Image -->
            <div class="mb-3">
                <label for="productImage" class="form-label">Product Image</label>
                <input type="file" name="fileupload" class="form-control" id="productImage" required>
            </div>

            <!-- alert message -->
            <div class="mb-3">
                <?php echo isset($msg) ? "<p class='alert alert-success'>$msg</p>" : null; ?>
            </div>

            <button type="submit" class="btn btn-primary btn-submit">Add Product</button>
        </form>
    </div>

    <?php // include_once "footer.php";  
    ?>

    <script>
        // Calculate selling price when MRP or Discount changes
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