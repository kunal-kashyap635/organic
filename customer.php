<?php
session_start();
include_once "db.php";
include_once "head.php";


$searchQuery = ''; // Initialize variables
$result = null; // Initialize result variable
$db = db(); // Initialize database connection

// Check if search query exists
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {

    $searchQuery = trim($_GET['search_query']);
    $sql = "SELECT * FROM users WHERE (name LIKE ? OR email LIKE ?)";
    $stmt = $db->prepare($sql);

    // Add wildcards to search term
    $searchTerm = "%{$searchQuery}%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();

    $result = $stmt->get_result();
}

// If no search, get all customers (optional - you might want to remove this if you only want to show results after search)
if (! isset($result)) {

    // records per page
    $recordsPerPage = 10;

    // Current page number
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

    // Calculate the starting record index
    $startFrom = ($currentPage - 1) * $recordsPerPage;

    $sql = "SELECT * FROM users limit $startFrom , $recordsPerPage";
    $result = $db->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Panel - Organic Products</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --primary-color: #4e8cff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --white-color: #ffffff;
            --border-radius: 0.375rem;
            --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #495057;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 30px auto;
            background: var(--white-color);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
        }

        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-color), #3a7bd5);
            color: var(--white-color);
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .dashboard-title {
            font-size: 1.75rem;
            font-weight: 600;
            margin: 0;
        }

        .search-container {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .search-form {
            display: flex;
            gap: 0.5rem;
        }

        .search-form input {
            padding: 0.5rem 1rem;
            border: 1px solid #ced4da;
            border-radius: var(--border-radius);
            min-width: 250px;
            transition: var(--transition);
        }

        .search-form input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 140, 255, 0.25);
            outline: none;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #3a7bd5;
            border-color: #3a7bd5;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: var(--white-color);
        }

        .dashboard-content {
            padding: 1.5rem;
        }

        .customer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .customer-table thead th {
            background-color: #f1f5f9;
            color: #64748b;
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
        }

        .customer-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: var(--transition);
        }

        .customer-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .customer-table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background-color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: bold;
        }

        .badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            border-radius: 50rem;
        }

        .badge-success {
            background-color: var(--success-color);
            color: white;
        }

        .badge-warning {
            background-color: var(--warning-color);
            color: #212529;
        }

        .badge-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 3rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
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

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--white-color);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .stat-card .stat-title {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }

        .stat-card .stat-change {
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .stat-card .stat-change.positive {
            color: var(--success-color);
        }

        .stat-card .stat-change.negative {
            color: var(--danger-color);
        }

        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .search-container {
                width: 100%;
                justify-content: center;
            }

            .search-form {
                width: 100%;
            }

            .search-form input {
                flex-grow: 1;
            }

            .customer-table thead {
                display: none;
            }

            .customer-table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #e2e8f0;
                border-radius: var(--border-radius);
            }

            .customer-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid #e2e8f0;
            }

            .customer-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #64748b;
                margin-right: 1rem;
            }

            .customer-table tbody td:last-child {
                border-bottom: none;
            }

            .action-buttons {
                justify-content: flex-end;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">
                <i class="fas fa-users me-2"></i>Customer Panel
            </h1>

            <div class="search-container">
                <form method="get" class="search-form">
                    <div class="input-group">
                        <input type="text" name="search_query" class="form-control" placeholder="Search customers..." value="<?= htmlspecialchars($searchQuery) ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <?php if (! empty($searchQuery)): ?>
                            <a href="?" class="btn btn-outline-primary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="dashboard-content">
            <!-- Stats Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-title">Total Customers</div>
                    <div class="stat-value">1,248</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> 12% from last month
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Active Customers</div>
                    <div class="stat-value">984</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> 5% from last month
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">New This Month</div>
                    <div class="stat-value">156</div>
                    <div class="stat-change negative">
                        <i class="fas fa-arrow-down"></i> 3% from last month
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Avg. Orders</div>
                    <div class="stat-value">3.2</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> 8% from last month
                    </div>
                </div>
            </div>

            <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-' . $_SESSION['message_type'] . ' alert-dismissible fade show" role="alert">
            ' . $_SESSION['message'] . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>';

            // Clear the message so it doesn't show again on refresh
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            }
            ?>

            <!-- Customers Table -->
            <div class="table-responsive">
                <table class="customer-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td data-label="Customer">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="customer-avatar">
                                                <?= strtoupper(substr($row['name'], 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="fw-bold"><?= htmlspecialchars($row['name']) ?></div>
                                                <small class="text-muted">ID: <?= $row['id'] ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Email"><?= htmlspecialchars($row['email']) ?></td>
                                    <td data-label="Phone"><?= ! empty($row['phone']) ? htmlspecialchars($row['phone']) : '<span class="text-muted">N/A</span>' ?></td>
                                    <td data-label="Location"><?= !empty($row['address']) ? htmlspecialchars($row['address']) : '<span class="text-muted">N/A</span>' ?></td>
                                    <td data-label="Status">
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle me-1"></i> Active
                                        </span>
                                    </td>
                                    <td data-label="Actions">
                                        <div class="action-buttons">
                                            <a class="btn btn-sm btn-outline-primary" href="view.php?cid=<?php echo $row['id']; ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-sm btn-outline-secondary" href="updatecustomer.php?cid=<?php echo $row['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn-outline-danger" href="deletecustomer.php?cid=<?php echo $row['id']; ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-user-slash"></i>
                                        <h4>No customers found</h4>
                                        <p><?= !empty($searchQuery) ? 'Try a different search term' : 'Add your first customer to get started' ?></p>
                                        <button class="btn btn-primary mt-2">
                                            <i class="fas fa-plus me-2"></i>Add Customer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php
            if (! isset($_GET['search_query'])) {
                $sql = "select count(*) as total FROM users";
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
            }
            $db->close();
            ?>
        </div>
    </div>
</body>

</html>

<?php
include_once "footer.php";
?>