<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 50%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ffb524;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #81c408;
  color: white;
}
</style>
</head>
<body>
    <?php include_once "db.php"; 
    $db = db();
    ?>

<h2>ORDER DETAILES</h2>

<?php
$oid=$_GET['oid'];

 $id=$db->query("select * from orders where orderid='$oid' ")->fetch_assoc();
//  $r=qq("select * from orders where orderid='5' and custid='25'")->fetch_assoc();
 $cn=$db->query("select * from users where id='{$id['custid']}'")->fetch_assoc();
 $od=$db->query("select * from orderdetail where orderid='$oid'");
 $tot=0;
 $qty=0;

?>

<table id='customers'>
  <tr>
    <th>Customer Name :</th>
    <td><?php echo $cn['name']; ?> </td>
    <td></td>
   <th>Customer Id :</th>
   <td><?php echo $id['custid']; ?></td>
  </tr>
   <tr>
    <th>Order No. :</th>
    <td><?php echo $id['orderid']; ?></td>
    <td></td>
   <th>Order Date :</th>
   <td><?php echo $id['orderdate']; ?></td>
  </tr>
  <tr>
    <th>Expdelivery :</th>
    <td><?php echo $id['expdelivery']; ?></td>
    <td></td>
   <th>Paymode :</th>
   <td><?php echo $id['paymode']; ?></td>
  </tr>
  <tr>
    <td colspan='5' align='center'><b>PRODUCT DETAILS</b></td>
  </tr>
  <tr>
    <th>S.No.</th>
    <th>Product Name</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Amount</th>
  </tr>

    <?php  while ($res=$od->fetch_assoc())
    { $tot+=$res['amount'];
        $qty+=$res['qty'];
    ?>
  <tr>
    <td><?php echo $res['oid']; ?></td>
    <td><?php echo $res['prodname']; ?></td>
    <td><?php echo $res['price']; ?></td>
   <td><?php echo $res['qty']; ?></td>
   <td><?php echo $res['amount']; ?></td>
  </tr>
  
<?php } ?>

<tr>
   <th>Total</th>
   <th></th>
   <th></th>
   <th><?php echo $qty ;?></th>
   <th>Rs.<?php echo $tot ;?></th>
</tr>

</table>


</body>
</html>