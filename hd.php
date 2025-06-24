<?php 
if (session_status() === PHP_SESSION_NONE) 
{
    session_start();
}
?>

<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("location: ./");
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani Website</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> organi29@gmail.com</li>
                                <li>Free Shipping for all Order of ₹ 700</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            </div>
                            <div class="header__top__right__language">
                                <img src="img/language.png" alt="">
                                <div>English</div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="#">Spanish</a></li>
                                    <li><a href="#">English</a></li>
                                </ul>
                            </div>

                            <?php if (isset($_SESSION['name'])) { ?>
                                <div class="header__top__right__auth">
                                    <a href="?logout"><i class="fa fa-user"></i> Logout</a>
                                </div>
                            <?php } else { ?>
                                <div class="header__top__right__auth">
                                    <a href="http://localhost/organic/login.php" target="_blank"><i class="fa fa-user"></i> Login</a>
                                </div>
                            <?php } ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="./index.html"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="./index.html">Home</a></li>
                            <li><a href="./shop-grid.html">Shop</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="header__menu__dropdown">
                                    <li><a href="http://localhost/organic/shop-grid.php" target="_blank">Shop Details</a></li>
                                    <li><a href="http://localhost/organic/shoping-cart.php" target="_blank">Shoping Cart</a></li>
                                    <li><a href="http://localhost/organic/shoping-wishlist.php" target="_blank">Shoping Wishlist</a></li>
                                    <li><a href="http://localhost/organic/checkout.php" target="_blank">Check Out</a></li>
                                    <li><a href="http://localhost/organic/displayorder.php" target="_blank">Orders</a></li>
                                    <li><a href="http://localhost/organic/blog-details.php" target="_blank">Blog Details</a></li>
                                </ul>
                            </li>
                            <li><a href="http://localhost/organic/blog.php" target="_blank">Blog</a></li>
                            <li><a href="http://localhost/organic/contact.php" target="_blank">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="http://localhost/organic/shoping-wishlist.php" target="_blank"><i class="fa fa-heart"></i> <span><?php echo isset($_SESSION["wishlist"]) ? count($_SESSION["wishlist"]) : "0"; ?></span></a></li>
                            <li><a href="http://localhost/organic/shoping-cart.php" target="_blank"><i class="fa fa-shopping-bag"></i> <span><?php echo isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : "0"; ?></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->