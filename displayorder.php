<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['id'] ?? header("location: login.php");
include_once "hd.php";
include_once "db.php";
?>

<?php

$userId = $_SESSION['id'];
$db = db();

// First get all order headers
$orderHeaders = $db->query("SELECT DISTINCT orders.orderid, users.id, users.name, orders.orderamt, orders.status, orders.orderdate FROM orders JOIN users ON orders.custid = users.id WHERE custid = '$userId'  ORDER BY orders.orderdate DESC");

$orders = [];
if ($orderHeaders->num_rows > 0) {
    while ($order = $orderHeaders->fetch_assoc()) {
        // Get items for each order
        $itemsQuery = $db->query("
            SELECT prodid, prodname, qty, price, amount 
            FROM orderdetail 
            WHERE orderid = '{$order['orderid']}'
        ");

        $items = [];
        while ($item = $itemsQuery->fetch_assoc()) {
            $items[] = $item;
        }

        $order['items'] = $items;
        $order['item_count'] = count($items);
        $orders[] = $order;
    }
}

// print_r($orders); // Now this will show proper structure

?>

<!-- Hero Section Begin -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All departments</span>
                    </div>
                    <?php
                    include_once "db.php";
                    $db = db();
                    $sql = "select * from category";
                    $qr = $db->query($sql);
                    ?>
                    <ul>
                        <?php while ($res = $qr->fetch_assoc()) { ?>
                            <li><a href="#"><?php echo $res['cname']; ?></a></li>
                            <!-- <li><a href="#">Vegetables</a></li>
                                <li><a href="#">Fruit & Nut Gifts</a></li>
                                <li><a href="#">Fresh Berries</a></li>
                                <li><a href="#">Ocean Foods</a></li>
                                <li><a href="#">Butter & Eggs</a></li>
                                <li><a href="#">Fastfood</a></li>
                                <li><a href="#">Fresh Onion</a></li>
                                <li><a href="#">Papayaya & Crisps</a></li>
                                <li><a href="#">Oatmeal</a></li>
                                <li><a href="#">Fresh Bananas</a></li> -->
                        <?php }
                        $db->close();
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                All Categories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="What do yo u need?">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+91 8080808080</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Orders Summary</h2>
                    <div class="breadcrumb__option">
                        <a href="index.php">Home</a>
                        <span>Orders Summary</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Order summary Section Begin -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
         body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .order-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s;
            overflow: hidden;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .order-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
        }

        .order-number {
            font-weight: bold;
            color: #333;
            font-size: 1.1rem;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-underprocess {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-delivered {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .order-details {
            padding: 20px;
        }

        .order-summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .order-meta {
            flex: 1;
        }

        .order-meta p {
            margin-bottom: 5px;
        }

        .order-items {
            flex: 2;
        }

        .items-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .item-card {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .item-card:hover {
            background-color: #f0f0f0;
            transform: translateX(5px);
        }

        .item-image {
            width: 60px;
            height: 60px;
            background-color: #ddd;
            border-radius: 5px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
            font-size: 1.5rem;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .item-meta {
            display: flex;
            justify-content: space-between;
            color: #666;
            font-size: 0.9rem;
        }

        .order-actions {
            padding: 15px;
            border-top: 1px solid #eee;
            display: flex;
            gap: 10px;
            background-color: #f8f9fa;
        }

        .invoice-modal .modal-body {
            padding: 30px;
        }

        .print-only {
            display: none;
        }

        @media print {
            .no-print {
                display: none;
            }

            .print-only {
                display: block;
            }

            body {
                background-color: white;
                padding: 20px;
            }
        }

        .item-count-badge {
            background-color: #6c757d;
            color: white;
            border-radius: 10px;
            padding: 3px 8px;
            font-size: 0.8rem;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">My Orders</h1>
            <a href="index.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </div>

        <?php if (empty($orders)): ?>
            <div class="alert alert-info">
                You haven't placed any orders yet. <a href="products.php" class="alert-link">Browse products</a> to get started.
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($orders as $order): ?>
                    <div class="col-md-12 mb-3">
                        <div class="order-card">
                            <div class="order-header">
                                <span class="order-number">Order #<?php echo $order['orderid']; ?></span>
                                <span class="item-count-badge">
                                    <?php echo $order['item_count']; ?> item<?php echo $order['item_count'] > 1 ? 's' : ''; ?>
                                </span>
                                <span class="status-badge status-<?php echo $order['status']; ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </div>
                            <div class="order-details">
                                <div class="order-summary">
                                    <div class="order-meta">
                                        <p><strong>Order Date:</strong> <?php echo date('M j, Y g:i A', strtotime($order['orderdate'])); ?></p>
                                        <p><strong>Total Amount:</strong> ₹<?php echo number_format($order['orderamt'], 2); ?></p>
                                        <p><strong>Order Status:</strong> ₹<?php echo $order['status']; ?></p>
                                    </div>
                                    <div class="order-items">
                                        <ul class="items-list">
                                            <?php foreach ($order['items'] as $item): ?>
                                                <li class="item-card">
                                                    <div class="item-image">
                                                        <i class="fas fa-box-open"></i>
                                                    </div>
                                                    <div class="item-details">
                                                        <div class="item-name"><?php echo $item['prodname']; ?></div>
                                                        <div class="item-meta">
                                                            <span>Qty: <?php echo $item['qty']; ?></span>
                                                            <span>Price: ₹<?php echo number_format($item['price'], 2); ?></span>
                                                            <span>Total: ₹<?php echo number_format($item['amount'], 2); ?></span>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="order-actions no-print">
                                <a href="invoice.php?action=view&order_id=<?php echo $order['orderid']; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-invoice"></i> View Invoice
                                </a>
                                <a href="invoice.php?action=download&order_id=<?php echo $order['orderid']; ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <!-- order summary Section End -->

    <!-- Footer Section Begin -->
    <?php include_once "footer.php"; ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>