<?php
// Include the Razorpay PHP library
include_once "db.php";
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

function paynow($pay)
{

// Initialize Razorpay with your key and secret
$api_key = 'rzp_test_xxxxxxxxxxxxxxx';
$api_secret = 'xxxxxxxxxxxxxxxxxxxxx';

$api = new Api($api_key, $api_secret);

// Create an order
$order = $api->order->create([
    'amount' => $pay['amount'], // amount in paise (100 paise = 1 rupee)
    'currency' => 'INR',
    'receipt' => $pay['rzp_receipt']
]);

// Get the order ID
$order_id = $order->id;

$db = db();
$db->query("update orders set rzp_orderid='$order_id' where orderid={$pay['orderid']}");

// Set your callback URL
$callback_url = "http://localhost/organic/verify.php";
// $callback_url = "https://projects.mmiit.in/organicveg/verify.php";

// Include Razorpay Checkout.js library
echo '<script src="https://checkout.razorpay.com/v1/checkout.js"></script>';

// Create a payment button with Checkout.js
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
// echo '<button class="btn border-secondary py-3 px-4 mt-3 text-uppercase w-100 text-danger" onclick="startPayment()">PayNow</button>';
echo '<div class="d-flex justify-content-start mt-4">
    <button class="btn bg-success border-secondary text-uppercase text-white" onclick="startPayment()">
        PayNow
    </button>
</div>';

// Add a script to handle the payment
echo '<script>
    function startPayment() {
        var options = {
            key: "' . $api_key . '",
            amount: ' . $order->amount . ',
            currency: "' . $order->currency . '",
            name: "Organic",
            description: "Payment for your order",
            image: "https://cdn.razorpay.com/logos/GhRQcyean79PqE_medium.png",
            order_id: "' . $order_id . '",
            theme:
            {
                "color": "#738276"
            },
            callback_url: "' . $callback_url . '",
            prefill:
            {
             name:"'.$pay["name"].'",
             email:"'.$pay["email"].'",
             contact:"'.$pay["contact"].'" 
            },
        };
        var rzp = new Razorpay(options);
        rzp.open();
    }
</script>';
}
?>
