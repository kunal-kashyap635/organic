<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['id'] ?? header("location: login.php");
include "hd.php";

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
                    <h2>Checkout</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <?php
        if (isset($_SESSION['id'])) {

            $db = db();

            $ur = $db->query("select * from users where id={$_SESSION['id']}")->fetch_assoc();

            $adr = $db->query("select * from address where custid={$_SESSION['id']}")->fetch_assoc();

            // Split the full name into parts
            $nameParts = explode(' ', $ur['name']);
            $firstName = $nameParts[0];
            $lastName = implode(' ', array_slice($nameParts, 1)); // Handle multiple last names

        }
        ?>
        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form action="#" id="frm">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Fist Name<span>*</span></p>
                                    <input type="text" name="fname" required value="<?php echo $firstName ?? ""; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Last Name<span>*</span></p>
                                    <input type="text" name="lname" required value="<?php echo $lastName ?? ""; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Address<span>*</span></p>
                            <input type="text" name="address" required class="checkout__input__add" value="<?php echo $adr['address'] ?? ""; ?>">
                        </div>
                        <div class="checkout__input">
                            <p>Town/City<span>*</span></p>
                            <input type="text" name="city" required value="<?php echo $adr['city'] ?? ""; ?>">
                        </div>
                        <div class="checkout__input">
                            <p>Country/State<span>*</span></p>
                            <input type="text" name="country" required value="<?php echo $adr['country'] ?? ""; ?>">
                        </div>
                        <div class="checkout__input">
                            <p>Postcode / ZIP<span>*</span></p>
                            <input type="text" name="pincode" required value="<?php echo $adr['pincode'] ?? ""; ?>">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone<span>*</span></p>
                                    <input type="text" name="mobile" required value="<?php echo $ur['phone'] ?? ""; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="text" required value="<?php echo $ur['email'] ?? ""; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Order notes<span>*</span></p>
                            <textarea name="note" class="form-control" spellcheck="false" cols="30" rows="11" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <?php
                            if (isset($_SESSION["cart"])) {
                                $total = 0;
                                foreach ($_SESSION["cart"] as $k => $v) {
                                    $total += $v['rate'] * $v['qty'];
                            ?>
                                    <ul>
                                        <li><?php echo $v['pname']; ?> <span>₹ <?php echo $v['rate']; ?></span></li>
                                        <!-- <li>Fresh Vegetable <span>$151.99</span></li>
                                <li>Organic Bananas <span>$53.99</span></li> -->
                                    </ul>
                            <?php }
                            } ?>
                            <div class="checkout__order__subtotal">Subtotal <span>₹ <?php echo $total; ?></span></div>
                            <div class="checkout__order__total">Total <span>₹ <?php echo $total + 30; ?></span></div>
                            <div class="checkout__order__total">₹ 30 extra for shipping charge</div>
                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Cash On Delivery
                                    <input type="radio" id="payment" name="payment" value="cod">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Online Payment
                                    <input type="radio" id="paypal" name="payment" value="online">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <!-- Your existing button (no form needed) -->
                            <button type="button" class="site-btn" onclick="checkout()">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->

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
    // function to check where checkout condition
    function checkout() {

        // Get the selected payment method
        const paymentMethod = document.querySelector('input[name="payment"]:checked');

        if (!paymentMethod) {
            alert('Please select a payment method', 'danger');
            return;
        }

        // Prepare data to send
        const data = {
            checkout: 'checkout',
            payment: paymentMethod.value,
            fname: document.querySelector('input[name="fname"]').value,
            lname: document.querySelector('input[name="lname"]').value,
            address: document.querySelector('input[name="address"]').value,
            city: document.querySelector('input[name="city"]').value,
            country: document.querySelector('input[name="country"]').value,
            pincode: document.querySelector('input[name="pincode"]').value,
            mobile: document.querySelector('input[name="mobile"]').value,
            note: document.querySelector('textarea[name="note"]').value
        };

        $.ajax({
            url: "addtocart.php",
            type: "POST",
            data: data,
            success: function(res) {
                alert(res);
                document.write(res);
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    }
</script>
</body>

</html>

