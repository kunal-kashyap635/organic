<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .action-buttons {
            white-space: nowrap;
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

        .table-responsive {
            margin: 20px 0;
        }

        .table thead th {
            background-color: #0d6efd;
            color: white;
            vertical-align: middle;
        }
    </style>
</head>

<body>

    <?php
    include_once "head.php";
    include_once "db.php";
    $db = db();
    ?>

    <?php
    $msg = null;
    if (isset($_GET['del'])) {
        $sql = "delete from product where id = '{$_GET['del']}'";
        $qr = $db->query($sql);
        if ($qr) {
            $msg = "record deleted successfully....";
        } else {
            $msg = "error in deletion";
        }
    }
    ?>

    <?php echo isset($msg) ? "<p class='alert alert-success'>$msg</p>" : null; ?>

    <div class="container-fluid mt-3">
        <?php
        // records per page
        $recordsPerPage = 6;

        // Current page number
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

        // Calculate the starting record index
        $startFrom = ($currentPage - 1) * $recordsPerPage;

        // Fetch student data with pagination
        $sql = "select * from product limit $startFrom, $recordsPerPage";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
        ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Id</th>
                            <th>Product Name</th>
                            <th>Product Description</th>
                            <th>Product Mrp</th>
                            <th>Product Rate</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['pname'] ?></td>
                                <td><?php echo $row['pdesc'] ?></td>
                                <td><?php echo $row['mrp'] ?></td>
                                <td><?php echo $row['rate'] ?></td>
                                <td class="action-buttons">
                                    <a href="updateproduct.php?upd=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Update</a>
                                    <a href="?del=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
            echo '<div class="alert alert-info">No records found.</div>';
        }

        // Pagination links
        $sql = "select count(*) as total FROM product";
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

        // Close the connection
        $db->close();
        ?>
        <?php include_once "footer.php"; ?>
    </div>
</body>

</html>