<?php include_once "hd.php"; ?>

<!-- Add this after the preloder div -->
<div class="container">
    <div id="cartAlert" class="alert alert-success alert-dismissible fade show" style="display:none; position: fixed; top: 20px; right: 20px; z-index: 9999;">
        <span id="alertMessage"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>


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
                    ?>
                    <?php
                    $cat = $db->query("select * from category");
                    ?>
                    <ul>
                        <?php while ($res = $cat->fetch_assoc()) { ?>
                            <li><a href="#"><?php echo $res['cname'] ?></a></li>
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
                    <h2>Product’s Package</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Product’s Package</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Details Section Begin -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <?php
                    if (isset($_GET['pid'])) {
                        $sql = "select * from product where id = '{$_GET['pid']}'";
                        $qr = $db->query($sql);
                    }
                    ?>
                    <div class="product__details__pic__item">
                        <?php while ($row = $qr->fetch_assoc()) { ?>
                            <img class="product__details__pic__item--large"
                                src="./uploads/<?php echo $row['pimage']; ?>" alt="">
                        <?php } ?>
                    </div>
                    <?php
                    $q = $db->query("select pimage from product limit 0,4");
                    ?>
                    <div class="product__details__pic__slider owl-carousel">
                        <?php while ($pd = $q->fetch_assoc()) { ?>
                            <img data-imgbigurl="img/product/details/product-details-2.jpg"
                                src="./uploads/<?php echo $pd['pimage']; ?>" alt="">
                            <!-- <img data-imgbigurl="img/product/details/product-details-3.jpg"
                                    src="img/product/details/thumb-2.jpg" alt="">
                                <img data-imgbigurl="img/product/details/product-details-5.jpg"
                                    src="img/product/details/thumb-3.jpg" alt="">
                                <img data-imgbigurl="img/product/details/product-details-4.jpg"
                                    src="img/product/details/thumb-4.jpg" alt=""> -->
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product__details__text">
                    <h3>Product Details</h3>
                    <div class="product__details__rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        <span>(10 reviews)</span>
                    </div>
                    <?php
                    if (isset($_GET['pid'])) {
                        $sql = "select * from product where id = '{$_GET['pid']}'";
                        $qr = $db->query($sql);
                    }
                    ?>
                    <?php while ($res = $qr->fetch_assoc()) { ?>
                        <div class="product__details__price">₹ <?php echo $res['rate']; ?></div>
                        <p><?php echo $res['pdesc']; ?></p>
                        <!-- <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                </div>
                            </div> -->
                        <a onclick="addtocart(<?php echo $res['id']; ?>)" class="primary-btn">ADD TO CARD</a>
                        <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                    <?php } ?>
                    <ul>
                        <li><b>Availability</b> <span>In Stock</span></li>
                        <li><b>Shipping</b> <span>01 day shipping <samp>Free pickup today</samp></span></li>
                        <!-- <li><b>Weight</b> <span>0.5 kg</span></li> -->
                        <li><b>Share on</b>
                            <div class="share">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                aria-selected="false">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                aria-selected="false">Reviews <span>(10)</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <?php
                                if (isset($_GET['pid'])) {
                                    $sql = "select * from product where id = '{$_GET['pid']}'";
                                    $qr = $db->query($sql);
                                }
                                ?>
                                <h6>Products Description</h6>
                                <?php while ($res = $qr->fetch_assoc()) { ?>
                                    <p><?php echo $res['pdesc']; ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <?php
                                if (isset($_GET['pid'])) {
                                    $sql = "select * from product where id = '{$_GET['pid']}'";
                                    $qr = $db->query($sql);
                                }
                                ?>
                                <h6>Products Infomation</h6>
                                <?php while ($res = $qr->fetch_assoc()) { ?>
                                    <p><?php echo $res['pdesc']; ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Review</h6>
                                <p>A game-changer! This product exceeded my expectations in every way. From its sleek design to its reliable performance, it truly delivers. The quality is top-notch, and it's clear that attention to detail went into its creation.One of the standout features is [mention a key feature], which enhances usability and sets it apart from competitors. Additionally, the ease of use makes it a great choice for both beginners and experienced users alike.If I had to find an area for improvement, I’d say [mention a minor drawback], but it’s nothing that takes away from the overall experience.Overall, I highly recommend this product to anyone looking for [mention the product’s purpose]. It’s definitely worth the investment!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Details Section End -->

<!-- Related Product Section Begin -->
<section class="related-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related__product__title">
                    <h2>Related Product</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            $sql = "select * from product limit 6,4";
            $qr = $db->query($sql);
            while ($res = $qr->fetch_assoc()) {
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="./uploads/<?php echo $res['pimage'] ?>">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#"><?php echo $res['pname']; ?></a></h6>
                            <h5>₹ <?php echo $res['rate'] ?></h5>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="img/product/product-2.jpg">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="img/product/product-3.jpg">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="img/product/product-7.jpg">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div> -->
            <?php } ?>
        </div>
    </div>
</section>
<!-- Related Product Section End -->

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
    function addtocart(pid) {
        // alert(pid);
        $(document).ready(function() {
            $.post("addtocart.php", {
                pid
            }, function(res) {
                // alert(res);

                var data = JSON.parse(res);

                // Update alert with product name
                $('#alertMessage').text(data.product + " added to cart!");
                $('#cartAlert').fadeIn().delay(3000).fadeOut();

                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            })
        });
    }
</script>

</body>

</html>