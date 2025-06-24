<?php
include_once "head.php";
include_once "db.php";

// Get parameters from URL
$paymentMethod = $_GET['payment_method'] ?? '';
$orderId = $_GET['order_id'] ?? '';
$status = $_GET['status'] ?? '';
$amt = $_GET['amount'] ?? '';

$db = db();
$qr = $db->query("update orders set status = 'UNDER PROCESS' where orderid = '$orderId'");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        .thank-you-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .cod-notice {
            background-color: #fff8e1;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <h1>Thank You for Your Order!</h1>
        
        <?php if ($status === 'success'): ?>
            <?php if (! empty($orderId)): ?>
                <p>Your order ID: <strong><?php echo htmlspecialchars($orderId); ?></strong></p>
            <?php endif; ?>
            
            <?php if ($paymentMethod === 'cod'): ?>
                <div class="cod-notice">
                    <h3>Cash on Delivery Instructions</h3>
                    <p>Please have the exact amount ready when our delivery agent arrives.</p>
                    <p>We'll contact you shortly to confirm your delivery details.</p>
                    <p>Amount To Be Paid is ₹ <?php echo $amt; ?></p>
                </div>
            <?php endif; ?>
            
            <p>We've received your order and will process it shortly.</p>
        <?php else: ?>
            <p>There was an issue processing your order. Please contact customer support.</p>
        <?php endif; ?>
        
        <a href="/organic/">Continue shopping</a>
    </div>
    <?php include_once "footer.php"; ?>
</body>
</html>
