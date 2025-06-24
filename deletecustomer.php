<?php
session_start();
include_once "db.php";
$db = db();

$custid = $_GET['cid'] ? $_GET['cid'] : null;

if ($custid) {

    $qr = $db->query("delete from users where id = '$custid'");

    if ($qr) {
        $_SESSION['message'] = "Customer ID $custid deleted successfully";
        $_SESSION['message_type'] = "success"; // for styling (success=green, error=red)
    } else {
        $_SESSION['message'] = "Failed to delete customer ID $custid";
        $_SESSION['message_type'] = "danger";
    }
} else {
    $_SESSION['message'] = "No customer ID provided";
    $_SESSION['message_type'] = "warning";
}

$db->close();
header("Location: customer.php");
exit();
?>