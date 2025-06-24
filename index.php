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
<section class="hero">
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
                    $sq = $db->query("select * from category");
                    ?>
                    <ul>
                        <?php while ($cat = $sq->fetch_assoc()) { ?>
                            <li><a href="#"><?php echo $cat['cname']; ?></a></li>
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
                <div class="hero__item set-bg" data-setbg="img/hero/banner.jpg">
                    <div class="hero__text">
                        <span>FRUIT FRESH</span>
                        <h2>Vegetable <br />100% Organic</h2>
                        <p>Free Pickup and Delivery Available</p>
                        <a href="#" class="primary-btn">SHOP NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <?php
            $sql = "select * from category";
            $qr = $db->query($sql);
            ?>
            <div class="categories__slider owl-carousel">
                <?php while ($res = $qr->fetch_assoc()) { ?>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="./category/<?php echo $res['cimage'];  ?>">
                            <h5><a href="#"><?php echo $res['cname'];  ?></a></h5>
                        </div>
                    </div>
                <?php } ?>
                <!-- <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/cat-2.jpg">
                            <h5><a href="#">Dried Fruit</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/cat-3.jpg">
                            <h5><a href="#">Vegetables</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/cat-4.jpg">
                            <h5><a href="#">drink fruits</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/cat-5.jpg">
                            <h5><a href="#">drink fruits</a></h5>
                        </div>
                    </div> -->

            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Featured Product</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        <?php
                        $q = $db->query("select * from category");
                        while ($row = $q->fetch_assoc()) { ?>
                            <li data-filter=".<?php echo $row['cname'] ?>"><?php echo $row['cname']; ?></li>
                        <?php } ?>
                        <!-- <li data-filter=".fresh-meat">Fresh Meat</li>
                            <li data-filter=".vegetables">Vegetables</li>
                            <li data-filter=".fastfood">Fastfood</li> -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            <?php
            $q1 = $db->query("select product.id , product.pname , product.rate , product.pimage , category.cname FROM product INNER JOIN category ON product.cat = category.id");
            while ($row1 = $q1->fetch_assoc()) {
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mix <?php echo $row1['cname']; ?>">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="./uploads/<?php echo $row1['pimage']; ?>">
                            <ul class="featured__item__pic__hover">
                                <li><a onclick="wishlist(<?php echo $row1['id']; ?>)"><i class="fa fa-heart"></i></a></li>
                                <li><a href="shop-details.php?pid=<?php echo $row1['id']; ?>"><i class="fa fa-retweet"></i></a></li>
                                <li><a onclick="addtocart(<?php echo $row1['id']; ?>)"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#"><?php echo $row1['pname']; ?></a></h6>
                            <h5>₹ <?php echo $row1['rate']; ?></h5>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- <div class="col-lg-3 col-md-4 col-sm-6 mix vegetables fastfood">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="img/featured/feature-2.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix vegetables fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="img/featured/feature-3.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix fastfood oranges">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="img/featured/feature-4.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix fresh-meat vegetables">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="img/featured/feature-5.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fastfood">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="img/featured/feature-6.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix fresh-meat vegetables">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="img/featured/feature-7.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mix fastfood vegetables">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="img/featured/feature-8.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div> -->

        </div>
    </div>
</section>
<!-- Featured Section End -->

<!-- Banner Begin -->
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="img/banner/banner-1.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="img/banner/banner-2.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Latest Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <?php
                            $q2 = $db->query("select * from product order by id desc limit 0,3");
                            while ($row2 = $q2->fetch_assoc()) {
                            ?>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="./uploads/<?php echo $row2['pimage']; ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $row2['pname']; ?></h6>
                                        <span>₹ <?php echo $row2['rate'];  ?></span>
                                    </div>
                                </a>
                            <?php } ?>
                            <!-- <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a> -->
                        </div>
                        <div class="latest-prdouct__slider__item">
                            <?php
                            $q2 = $db->query("select * from product order by id desc limit 3,3");
                            while ($row2 = $q2->fetch_assoc()) {
                            ?>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="./uploads/<?php echo $row2['pimage']; ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $row2['pname']; ?></h6>
                                        <span>₹ <?php echo $row2['rate'];  ?></span>
                                    </div>
                                </a>
                            <?php } ?>
                            <!-- <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Top Rated Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <?php
                            $q2 = $db->query("select * from product order by id desc limit 6,3");
                            while ($row2 = $q2->fetch_assoc()) {
                            ?>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="./uploads/<?php echo $row2['pimage']; ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $row2['pname']; ?></h6>
                                        <span>₹ <?php echo $row2['rate'];  ?></span>
                                    </div>
                                </a>
                            <?php } ?>
                            <!-- <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a> -->
                        </div>
                        <div class="latest-prdouct__slider__item">
                            <?php
                            $q2 = $db->query("select * from product order by id desc limit 9,3");
                            while ($row2 = $q2->fetch_assoc()) {
                            ?>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="./uploads/<?php echo $row2['pimage']; ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $row2['pname']; ?></h6>
                                        <span>₹ <?php echo $row2['rate'];  ?></span>
                                    </div>
                                </a>
                            <?php } ?>
                            <!-- <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Review Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <?php
                            $q2 = $db->query("select * from product order by id desc limit 0,3");
                            while ($row2 = $q2->fetch_assoc()) {
                            ?>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="./uploads/<?php echo $row2['pimage']; ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $row2['pname']; ?></h6>
                                        <span>₹ <?php echo $row2['rate'];  ?></span>
                                    </div>
                                </a>
                            <?php } ?>
                            <!-- <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a> -->
                        </div>
                        <div class="latest-prdouct__slider__item">
                            <?php
                            $q2 = $db->query("select * from product order by id desc limit 9,3");
                            while ($row2 = $q2->fetch_assoc()) {
                            ?>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="./uploads/<?php echo $row2['pimage']; ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $row2['pname']; ?></h6>
                                        <span>₹ <?php echo $row2['rate'];  ?></span>
                                    </div>
                                </a>
                            <?php } ?>
                            <!-- <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest Product Section End -->

<!-- Blog Section Begin -->
<section class="from-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title from-blog__title">
                    <h2>From The Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="img/blog/blog-1.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 2,2025</li>
                            <li><i class="fa fa-comment-o"></i> 15</li>
                        </ul>
                        <h5><a href="#">Cooking tips make cooking simple</a></h5>
                        <p>A handy guide that transforms complex recipes into easy, doable steps. Whether you're a beginner or a seasoned cook, these practical tips save time, reduce stress, and help you create delicious meals with confidence. Simplify your kitchen experience and enjoy cooking like never before!</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="img/blog/blog-2.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 2,2025</li>
                            <li><i class="fa fa-comment-o"></i> 9</li>
                        </ul>
                        <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
                        <p>Discover efficient, crowd-friendly breakfast ideas to effortlessly feed a large group. From make-ahead casseroles to buffet-style spreads, these six methods ensure a delicious, stress-free morning meal—perfect for events, gatherings, or busy households. Save time, minimize hassle, and keep everyone satisfied!</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="img/blog/blog-3.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 6,2025</li>
                            <li><i class="fa fa-comment-o"></i> 12</li>
                        </ul>
                        <h5><a href="#">Visit the clean farm in the India</a></h5>
                        <p> Experience sustainable agriculture at its finest! Explore lush, eco-friendly farms across India where organic practices, fresh produce, and serene landscapes come together. Perfect for agritourism enthusiasts, families, or anyone seeking a peaceful escape into nature. Discover the beauty of responsible farming—book your visit today!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->

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
                alert(res);

                // Update alert with product name
                $('#alertMessage').text(res + " added to cart!");
                $('#cartAlert').fadeIn().delay(3000).fadeOut();
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            })
        });
    }

    function wishlist(pid) {
        // alert(pid);
        $(document).ready(function() {
            $.post("wishlist.php", {
                pid
            }, function(res) {
                // alert(res);

                // Update alert with product name
                $('#alertMessage').text(res + " added to Wishlist!");
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

