<?php
include_once "head.php";
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;

// print_r($_REQUEST);
echo "<br>";

verify();
?>



<?php
function verify()
{
    include_once "db.php";
    $db = db();
    // Include the Razorpay PHP library

    // Initialize Razorpay with your key and secret
    $api_key = 'rzp_test_E3GOhpUxaH16Is';
    $api_secret = 'fdpHBQU2BzA95mRPe5SIxTsF';

    $api = new Api($api_key, $api_secret);

    // Check if payment is successful
    $success = true;

    $error = null;

    // Get the payment ID and the signature from the callback
    // $ordid=$_POST['razorpay_order_id'];
    $payment_id = $_POST['razorpay_payment_id'];
    $razorpay_signature = $_POST['razorpay_signature'];


    try {
        // Verify the payment
        $attributes = array(
            'razorpay_order_id' => $_POST['razorpay_order_id'],
            'razorpay_payment_id' => $payment_id,
            'razorpay_signature' => $razorpay_signature
        );

        $api->utility->verifyPaymentSignature($attributes);
    } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Signature Verification Failed';
    }

    if ($success) {
        // Payment is successful, update your database or perform other actions

        // Fetch the payment details
        $payment = $api->payment->fetch($payment_id);

        // You can access payment details like $payment->amount, $payment->status, etc.
        $amount_paid = $payment->amount / 100; // Convert amount from paise to rupees


        // print_r((array) $payment);
        $qchk = $db->query("select * from orders where rzp_orderid='{$_POST['razorpay_order_id']}'")->fetch_assoc();
        $oamt = $qchk['orderamt'];

        $pstat = ($oamt == $amount_paid) ? "success" : "Amount Mismatch";
        $qr = $db->query("update orders set payid='$payment_id',paystatus='$pstat',payamt='$amount_paid',paysign='$razorpay_signature',status='UNDER PROCESS' where rzp_orderid='{$_POST['razorpay_order_id']}' and status='NEW' ");
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
                .payment-success {
                    background-color: #e8f5e9;
                    padding: 15px;
                    margin: 20px 0;
                    border-left: 4px solid #4caf50;
                }
            </style>
        </head>
        <body>
            <div class="thank-you-container">
                <h1>Thank You for Your Order!</h1>
                
                <div class="payment-success">
                    <h3>Online Payment Successful</h3>
                    <p style="color: blue;">Your order ID: <strong><?php echo htmlspecialchars($qchk['orderid']); ?></strong></p>
                    <p style="color: blue;">Order Amount: ₹ <?php echo htmlspecialchars($oamt); ?></p>
                    <p style="color: green;">Paid Amount: ₹ <?php echo htmlspecialchars($amount_paid); ?></p>
                </div>
                
                <p>We've received your payment and will process your order shortly.</p>
                <a href="/organic/">Continue shopping</a>
            </div>
        <?php
    } else {
        // Payment failed, handle accordingly
        ?>
        <div class="thank-you-container">
            <h1>Payment Failed</h1>
            <div style="background-color: #ffebee; padding: 15px; margin: 20px 0; border-left: 4px solid #f44336;">
                <h3 style="color: #d32f2f;">Error: <?php echo htmlspecialchars($error); ?></h3>
                <p>Please try again or contact customer support.</p>
            </div>
            <a href="/organic/">Return to store</a>
        </div>
        <?php
    }
}
include_once "footer.php";
?>
