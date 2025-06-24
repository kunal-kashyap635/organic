<?php
include_once 'head.php';
include_once "db.php";

// Get the customer ID from URL parameter
$custid = $_GET['cid'] ? $_GET['cid'] : null;

if (!$custid) {
    // If no customer ID is provided, redirect back
    header("Location: customers.php");
    exit();
}

$db = db();
$sql = "select users.id , users.name, users.email , users.phone , users.address , address.city , address.country , address.pincode from users inner join address on users.id = address.custid where id = '$custid'";

$qr = $db->query($sql);

if ($qr->num_rows > 0) {
    $customer = $qr->fetch_assoc();
} else {
    // If no customer found with that ID
    echo "<div class='alert alert-danger'>Customer not found</div>";
    exit();
}
$db->close();

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Customer Details</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Basic Information</h5>
                            <p><strong>ID:</strong> <?php echo htmlspecialchars($customer['id']); ?></p>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($customer['name']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($customer['phone']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Additional Details</h5>
                            <p><strong>Address:</strong> <?php echo htmlspecialchars($customer['address']) ?? ""; ?></p>
                            <p><strong>City:</strong> <?php echo htmlspecialchars($customer['city']) ?? ""; ?></p>
                            <p><strong>State:</strong> <?php echo htmlspecialchars($customer['country']) ?? ""; ?></p>
                            <p><strong>Zip Code:</strong> <?php echo htmlspecialchars($customer['pincode']) ?? ""; ?></p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="customer.php" class="btn btn-secondary">Back to Customers</a>
                        <a href="updatecustomer.php?cid=<?php echo $customer['id']; ?>" class="btn btn-primary">Edit Customer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include_once "footer.php"; ?>