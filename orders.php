<?php

//$db = db();
// $qr = $db->query("SELECT orders.orderid, users.id, users.name, orders.orderamt, orders.status, orders.orderdate, orderdetail.prodid, 
// orderdetail.prodname, orderdetail.qty, orderdetail.price, orderdetail.amount FROM orders JOIN users ON orders.custid = users.id 
// JOIN orderdetail ON orders.orderid = orderdetail.orderid ORDER BY orders.orderdate DESC")->fetch_assoc();

?>

<?php

session_start();
include_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {

    $db = db();

    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];
    $successMsg = null;
    $errorMsg = null;

    // Validate and sanitize input
    $allowedStatuses = ['PENDING', 'UNDER PROCESS', 'COMPLETED', 'CANCELLED', 'DELIVERED'];

    if (in_array($newStatus, $allowedStatuses)) {
        $stmt = $db->prepare("UPDATE orders SET status = ? WHERE orderid = ?");
        $stmt->bind_param("si", $newStatus, $orderId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['successMsg'] = "order id $orderId updated successfully!";
        } else {
            $_SESSION['errorMsg'] = "Failed to update order status.";
        }
        $stmt->close();
    } else {
        $_SESSION['errorMsg'] = "Invalid status selected.";  // Store in session
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
include_once "head.php";

// Initialize variables
$searchQuery = '';
$whereClause = '';

// Check if search query exists
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {

    $searchQuery = trim($_GET['search_query']);

    // Prepare the search query for SQL (with parameter binding for security)
    $searchParam = "%{$searchQuery}%";

    // Create WHERE clause to search by order ID or customer name
    $whereClause = "WHERE (orders.orderid LIKE ? OR users.name LIKE ?)";
}

$db = db();

// records per page
$recordsPerPage = 50;

// Current page number
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting record index
$startFrom = ($currentPage - 1) * $recordsPerPage;

// Build the base query
$query = "SELECT orders.orderid, users.id, users.name, orders.orderamt, orders.status, orders.orderdate, 
          orderdetail.prodid, orderdetail.prodname, orderdetail.qty, orderdetail.price, orderdetail.amount 
          FROM orders JOIN users ON orders.custid = users.id JOIN orderdetail ON orders.orderid = orderdetail.orderid";

// Add WHERE clause if there's a search query
if (! empty($whereClause)) {
    $query .= " $whereClause ";
}

// Complete the query
$query .= " ORDER BY orders.orderdate DESC  limit $startFrom , $recordsPerPage";

// Prepare the statement
$stmt = $db->prepare($query);

// Bind parameters if searching
if (! empty($whereClause)) {
    $stmt->bind_param("ss", $searchParam, $searchParam);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary - Organic Products</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .order-container {
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            color: #2e7d32;
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .order-card {
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
        }

        .order-header {
            background-color: #E8F5E9;
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-table th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: left;
        }

        .order-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .order-table tr:hover {
            background-color: #f9f9f9;
        }

        .order-table tr:hover {
            background-color: orange;
        }

        .status-pending {
            color: #FFA000;
            font-weight: bold;
        }

        .status-completed {
            color: #2E7D32;
            font-weight: bold;
        }

        .status-cancelled {
            color: #C62828;
            font-weight: bold;
        }

        .status-under-process {
            color: #0277BD;
            font-weight: bold;
        }

        .status-delivered {
            color: gray;
            font-weight: bold;
        }

        .no-orders {
            text-align: center;
            padding: 40px;
            color: #757575;
        }

        .nice-select {
            display: none !important;
        }

        select {
            display: block !important;
        }

        .status-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .status-label {
            margin-right: 10px;
        }

        .status-form {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-select {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
            height: 34px;
            /* Match button height */
        }

        .update-btn {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            height: 34px;
            /* Match select height */
        }

        .update-btn:hover {
            background-color: purple;
        }

        .alert {
            margin: 20px 0;
            padding: 15px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .alert-error {
            background-color: #f2dede;
            color: #a94442;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .page-title {
            color: #2e7d32;
            margin: 0;
            padding: 0;
            border-bottom: none;
            text-align: left;
        }

        .search-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-form {
            display: flex;
            gap: 10px;
        }

        .search-form input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 250px;
        }

        .search-form button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #45a049;
        }

        .clear-search {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .clear-search:hover {
            background-color: #45a049;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .pagination .page-item .page-link {
            border-radius: 50%;
            margin: 0 3px;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</head>

<body>
    <div class="order-container">
        <div class="header-container">
            <h3 class="page-title">Order Summary - Organic Products</h3>

            <div class="search-container">
                <form method="get" class="search-form">
                    <input type="text" name="search_query" placeholder="Search by Order ID or Name" value="<?= htmlspecialchars($searchQuery) ?>">
                    <button type="submit">Search</button>
                    <?php if (! empty($searchQuery)): ?>
                        <a href="?" class="clear-search">Clear</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <?php
        if (isset($_SESSION['successMsg'])) {
            echo '<div class="alert alert-success">' . $_SESSION['successMsg'] . '</div>';
            unset($_SESSION['successMsg']);  // Clear after displaying
        }

        // Display error message from session
        if (isset($_SESSION['errorMsg'])) {
            echo '<div class="alert alert-error">' . $_SESSION['errorMsg'] . '</div>';
            unset($_SESSION['errorMsg']);  // Clear after displaying
        }

        if ($result->num_rows > 0) {
            $currentOrderId = null;

            while ($row = $result->fetch_assoc()) {

                if ($currentOrderId != $row['orderid']) {
                    // Close previous order if exists
                    if ($currentOrderId !== null) {
                        echo '</tbody></table></div>';
                    }

                    // Start new order
                    $currentOrderId = $row['orderid'];
                    $statusClass = 'status-' . strtolower(str_replace(' ', '-', $row['status']));
        ?>

                    <div class="order-card">
                        <div class="order-header">
                            <h3>Order #<?= $row['orderid'] ?> - <?= htmlspecialchars($row['name']) ?></h3>
                            <p>Order Date: <?= date('F j, Y, g:i a', strtotime($row['orderdate'])) ?></p>
                            <div class="status-container">
                                <span class="status-label">Status: <span class="<?= $statusClass ?>"><?= $row['status'] ?></span></span>
                                <form method="post" class="status-form">
                                    <input type="hidden" name="order_id" value="<?= $row['orderid'] ?>">
                                    <select name="new_status" class="status-select">
                                        <option value="UNDER PROCESS" <?= $row['status'] == 'UNDER PROCESS' ? 'selected' : '' ?>>Under Process</option>
                                        <option value="PENDING" <?= $row['status'] == 'PENDING' ? 'selected' : '' ?>>Pending</option>
                                        <option value="COMPLETED" <?= $row['status'] == 'COMPLETED' ? 'selected' : '' ?>>Completed</option>
                                        <option value="CANCELLED" <?= $row['status'] == 'CANCELLED' ? 'selected' : '' ?>>Cancelled</option>
                                        <option value="DELIVERED" <?= $row['status'] == 'DELIVERED' ? 'selected' : '' ?>>Delivered</option>
                                    </select>
                                    <button type="submit" name="update_status" class="update-btn">Update</button>
                                </form>
                            </div>
                        </div>

                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                        }

                        // Display order details
                            ?>
                            <tr>
                                <td><?= $row['prodid'] ?></td>
                                <td><?= htmlspecialchars($row['prodname']) ?></td>
                                <td><?= $row['qty'] ?></td>
                                <td>₹ <?= number_format($row['price'], 2) ?></td>
                                <td>₹ <?= number_format($row['amount'], 2) ?></td>
                            </tr>
                    <?php
                }
                // Close last order
                echo '</tbody></table></div>';
            } else {
                echo '<div class="no-orders"><p>';
                if (! empty($searchQuery)) {
                    echo 'No orders found matching "' . htmlspecialchars($searchQuery) . '"';
                } else {
                    echo 'No orders found.';
                }
                echo '</p></div>';
            }
                    ?>
                    </div>
                    <?php
                    $sql = "select count(*) as total FROM orders";
                    $row = $db->query($sql)->fetch_assoc();
                    $totalRecords = $row["total"];
                    $totalPages = ceil($totalRecords / $recordsPerPage);

                    if ($totalPages > 1) {
                        echo '<div class="pagination-container">';
                        echo '<nav aria-label="Page navigation">';
                        echo '<ul class="pagination">';

                        // Previous button
                        if ($currentPage > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '">&laquo;</a></li>';
                        }

                        // Page numbers
                        for ($i = 1; $i <= $totalPages; $i++) {
                            $active = ($i == $currentPage) ? 'active' : '';
                            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                        }

                        // Next button
                        if ($currentPage < $totalPages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '">&raquo;</a></li>';
                        }

                        echo '</ul>';
                        echo '</nav>';
                        echo '</div>';
                    }
                    ?>
</body>
</html>

<?php
include_once "footer.php";
?>

