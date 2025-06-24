<?php session_start() ?>

<?php
include_once "db.php";
include_once "paynow.php";
?>

<?php

if (isset($_POST['pid'])) {

    $db = db();
    $sql = "select * from product where id = '{$_POST['pid']}'";
    $qr = $db->query($sql)->fetch_assoc();

    $_SESSION["cart"][$_POST['pid']] = $qr;
    $_SESSION["cart"][$_POST['pid']]['qty'] = 1;

    echo $qr['pname'];
}

?>

<?php
if (isset($_POST['newVal']) && isset($_POST['pid'])) {

    $pid = $_POST['pid'];
    $qty = $_POST['newVal'];

    if (isset($_SESSION["cart"][$pid])) {
        // Update the quantity in the session
        $_SESSION["cart"][$pid]['qty'] = $qty;
        echo "Cart Updated Successfully....";
    }
}

?>

<?php
if (isset($_POST['p'])) {
    unset($_SESSION["cart"][$_POST['p']]);
    echo "Item Deleted Successfully..";
}
?>


<?php

if (isset($_POST['checkout'])) {

    if (! isset($_SESSION["cart"]) || count($_SESSION["cart"]) < 1) {
        echo "Cart is empty cant proceed.....";
        return;
    }

    if ($_POST['payment'] == "cod") {

        // geeting orderid
        $orderno = ordergenerator();

        // unset the cart
        unset($_SESSION['cart']);

        // echo "Payment is on COD";

        $db = db();
        $qr = $db->query("select orderamt from orders where orderid = '$orderno'")->fetch_assoc();

        // Redirect to thank you page with more details
        header("Location: thanku.php?payment_method=cod&order_id=" . $orderno . "&status=success&amount=" . $qr['orderamt'] . "");
        exit();

    } else {

        $db = db();
        $orderno = ordergenerator();
        unset($_SESSION['cart']);

        $qr = $db->query("UPDATE orders SET rzp_receipt=CONCAT('rzp',orderid+100000) WHERE orderid='$orderno'");

        $qr1 = $db->query("SELECT orderid,orderamt,rzp_receipt,name,phone,email FROM orders INNER JOIN users ON orders.custid=users.id WHERE orderid='$orderno'")->fetch_assoc();
        // echo "<button class='btn border-secondary py-3 px-4 mt-3 text-uppercase w-100 text-danger' id='pay'> Paynow </button>";
        $pay = array();
        $pay["amount"] = $qr1['orderamt'] * 100;
        $pay["rzp_receipt"] = $qr1['rzp_receipt'];
        $pay["name"] = $qr1['name'];
        $pay["contact"] = $qr1['phone'];
        $pay["email"] = $qr1['email'];
        $pay["orderid"] = $qr1['orderid'];
        // print_r($pay);
        paynow($pay);
        // echo "Payment is on Online";
    }
}

function ordergenerator()
{
    $db = db();
    $qc = $db->query("select count(name) as cnt from address where custid='{$_SESSION['id']}'")->fetch_assoc();

    if ($qc['cnt'] < 1) {
        $name = $_POST['fname'] . ' ' . $_POST['lname'];
        $qr = $db->query("insert into address(custid,name,address,city,country,pincode,mobile) values('{$_SESSION['id']}','$name','{$_POST['address']}','{$_POST['city']}','{$_POST['country']}','{$_POST['pincode']}','{$_POST['mobile']}')");
    } else {
        $name = $_POST['fname'] . ' ' . $_POST['lname'];
        $qr = $db->query("update address set name='$name',address='{$_POST['address']}',city='{$_POST['city']}',country='{$_POST['country']}',pincode='{$_POST['pincode']}',mobile='{$_POST['mobile']}' where custid='{$_SESSION['id']}'");
    }

    $qr = $db->query("select * from orders where custid='{$_SESSION['id']}' and status='NEW'")->fetch_assoc();

    if (! isset($qr['orderid'])) {
        $q = "insert into orders(custid,orderdate,expdelivery,status,times,paymode) values('{$_SESSION['id']}',curdate(),DATE_ADD(CURDATE(), INTERVAL 1 DAY),'NEW',NOW(),'{$_POST['payment']}')";
        $qr = $db->query($q);
        if ($qr) {
            $qr = $db->query("select * from orders where custid='{$_SESSION['id']}' and status='NEW'")->fetch_assoc();
            $oid = $qr['orderid'];
        }
    } else {
        $oid = $qr['orderid'];
    }

    foreach ($_SESSION['cart'] as $k => $v) {

        $amt = $v['qty'] * $v['rate'];
        $qr = $db->query("insert into orderdetail(orderid,prodid,prodname,price,qty,amount) values('{$oid}','{$v['id']}','{$v['pname']}','{$v['rate']}','{$v['qty']}','{$amt}')");
    }


    if ($qr) {

        $qr = $db->query("select sum(amount) as amt from orderdetail where orderid='$oid'")->fetch_assoc();
        $qr = $db->query("update orders set orderamt='{$qr['amt']}' where orderid='$oid'");
        echo "Your order is successfully created order id =$oid thank you for shopping";
        echo conf($oid) ? "mail sent successfully" : "there was some error in mail sending";
        return $oid;
    } else {
        echo "0";
    }
    // echo isset($_SESSION['uid']) ? "" : "Order Posting error..."; 
}

?>

<?php
function conf($oid)
{
    $db = db();
    $qr = $db->query("select email from users inner join orders on orders.custid=users.id where orderid=$oid")->fetch_assoc();

    // include_once("mail1.php");
    include_once("mail.php");

    // $my_var = file_get_contents("https://projects.mmiit.in/organicveg/table.php?oid=$oid");

    $my_var = file_get_contents("http://localhost/organic/table.php?oid=$oid");

    return mailer($my_var, $qr['email'], "Your Organic order No. $oid is confirmed ");
    // echo $qr['email'];
}
?>
