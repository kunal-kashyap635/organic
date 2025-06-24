<?php include_once "hd.php"; ?>

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
<!-- Hero Section End -->

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Shopping Cart</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) { ?>
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($_SESSION["cart"] as $k => $v) {
                                    $total += $v['rate'] * $v['qty'];
                                ?>
                                    <tr>
                                        <td class="shoping__cart__item">
                                            <img src="<?php echo "./uploads/" . $v['pimage']; ?>" alt="" height="150px" width="150px" style="border-radius: 10px;">
                                            <h5><b><?php echo $v['pname']; ?></b></h5>
                                        </td>
                                        <td class="shoping__cart__price">
                                            ₹ <?php echo $v['rate']; ?>
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="text" value="<?php echo $v['qty']; ?>" pid="<?php echo $v['id']; ?>">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="shoping__cart__total">
                                            ₹ <?php echo $v['qty'] * $v['rate']; ?>
                                        </td>
                                        <td class="shoping__cart__item__close">
                                            <a onclick="deletefromcart(<?php echo $v['id'] ?>)"><span class="icon_close"></span></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <!-- <tr>
                                    <td class="shoping__cart__item">
                                        <img src="img/cart/cart-2.jpg" alt="">
                                        <h5>Fresh Garden Vegetable</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        $39.00
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="text" value="1">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        $39.99
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <span class="icon_close"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="img/cart/cart-3.jpg" alt="">
                                        <h5>Organic Bananas</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        $69.00
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="text" value="1">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        $69.99
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <span class="icon_close"></span>
                                    </td>
                                </tr> -->

                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="text-center">
                        <h3 class="mb-5 display-4">Your cart is empty</h3>
                        <a href="http://localhost/organic/index.php" class="primary-btn">Continue Shopping</a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="http://localhost/organic/index.php" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Upadate Cart</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal <span>₹ <?php echo $total; ?></span></li>
                            <li>Total <span>₹ <?php echo $total += 30; ?></span></li>
                            <li><span>₹ 30 is Extra For Shiping Charges</span></li>
                        </ul>
                        <a href="checkout.php" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<!-- Shoping Cart Section End -->

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

<script>
    // function to delete item from cart
    function deletefromcart(p) {
        if (confirm('Are you sure you want to remove this item?')) {
            $.post("addtocart.php", {
                p
            }, function(res) {
                // alert(res);
                window.location.reload();
            })
        }
    }
</script>
</body>

</html>
