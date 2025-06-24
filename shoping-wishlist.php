<?php include_once "hd.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #dddfeb;
            --text-color: #5a5c69;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
            color: var(--text-color);
        }

        .product-wishlist-container {
            padding: 3rem 0;
            min-height: 70vh;
        }

        .section-head {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-head::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 3px;
            background-color: var(--primary-color);
        }

        .table {
            background-color: white;
            border-radius: 0.35rem;
            overflow: hidden;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border-bottom: none;
            padding: 1rem;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 1.2rem 1rem;
        }

        .table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }

        .table img {
            border-radius: 0.25rem;
            transition: transform 0.3s;
        }

        .table img:hover {
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.375rem 0.75rem;
        }

        .btn-primary:hover {
            background-color: #3a5bd9;
            border-color: #3a5bd9;
        }

        .remove-wishlist-item {
            font-size: 1.1rem;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .proceed-to-cart {
            margin-top: 1.5rem;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
        }

        .empty-result {
            background-color: white;
            padding: 2rem;
            text-align: center;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
            font-size: 1.1rem;
            color: #6c757d;
        }

        .empty-result i {
            font-size: 2rem;
            color: #dddfeb;
            margin-bottom: 1rem;
            display: block;
        }

        @media (max-width: 768px) {
            .section-head {
                font-size: 1.5rem;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #e3e6f0;
                border-radius: 0.35rem;
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem;
            }

            .table tbody td::before {
                content: attr(data-label);
                font-weight: bold;
                margin-right: 1rem;
                color: var(--primary-color);
            }

            .table tbody td img {
                margin-left: auto;
            }
        }
    </style>
</head>

<body>
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
                            <?php } ?>
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

    <div class="product-wishlist-container">
        <div class="container">
            <div class="row">
                <?php if (isset($_SESSION["wishlist"]) && !empty($_SESSION["wishlist"])) { ?>
                    <div class="col-md-12">
                        <h2 class="section-head">My Wishlist</h2>
                        <!-- Wishlist with items -->
                        <table class="table table-bodered">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["wishlist"] as $k => $v) { ?>
                                    <tr>
                                        <td data-label="Product Image">
                                            <img src="./uploads/<?php echo $v['pimage']; ?>" alt="Sample Product" width="100px">
                                        </td>
                                        <td data-label="Product Name"><?php echo $v['pname']; ?></td>
                                        <td data-label="Product Price">₹ <?php echo $v['rate']; ?></td>
                                        <td data-label="Action">
                                            <a class="btn btn-sm btn-primary remove-wishlist-item" onclick="deletewish(<?php echo $v['id']; ?>)">
                                                <i class="fa fa-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <!-- <tr>
                                <td data-label="Product Image">
                                    <img src="product-images/sample-product2.jpg" alt="Sample Product" width="100px">
                                </td>
                                <td data-label="Product Name">Smart Watch Pro</td>
                                <td data-label="Product Price">$249.99</td>
                                <td data-label="Action">
                                    <a class="btn btn-sm btn-primary remove-wishlist-item" href="#" data-id="2">
                                        <i class="fa fa-remove"></i>
                                    </a>
                                </td>
                            </tr> -->
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <!-- Empty wishlist state (commented out) -->
                        <div class="empty-result">
                            <i class="far fa-heart"></i>
                            No products were added to the wishlist.
                        </div>
                    <?php } ?>
                    </div>
                    <a class="btn btn-sm btn-primary proceed-to-cart" href="http://localhost/organic/shoping-cart.php" target="_blank">Proceed to Cart</a>
            </div>
        </div>
    </div>

    <?php include_once "footer.php"; ?>

    <script>
        function deletewish(p) {
            if (confirm('Are you sure you want to remove this item?')) {
                $.post("wishlist.php", {
                    p
                }, function(res) {
                    alert(res);
                    window.location.reload();
                })
            }
        }
    </script>
</body>

</html>