<?php session_start(); ?>

<?php include_once "db.php"; ?>

<?php

if (isset($_POST['pid'])) {

    $db = db();
    $sql = "select * from product where id = '{$_POST['pid']}'";
    $qr = $db->query($sql)->fetch_assoc();

    $_SESSION["wishlist"][$_POST['pid']] = $qr;
    $wish = count($_SESSION['wishlist']);

    echo $qr['pname'];
}

?>

<?php 
if(isset($_POST['p'])){
    unset($_SESSION["wishlist"][$_POST['p']]);
    echo "Item removed from Wishlist";
}
?>