<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE);

if (isset($_SESSION['user_id'])) {
    $buyer = $_SESSION['user_id'];
} else {
    $buyer = 1;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shopping Cart</title>
    <?php include("components/links.php");?>
    <link rel="stylesheet" href="assets/css/cart.css">
</head>
<body>
    <?php include("components/navbar.php"); ?>
    
    <div class="cart-container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Cart</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Cart Items -->
            <div class="col-md-8">
                <?php 
                if (!empty($buyer)) {
                    require("engine/config.php");

                    $cart_item = "SELECT cart.itemId, cart.seller_id, cart.noofItem, cart.buyer, 
                                         products.product_id, products.product_name, products.product_image, 
                                         products.product_price, products.product_discount, products.product_location 
                                  FROM cart 
                                  JOIN products ON cart.itemId = products.product_id 
                                  WHERE cart.buyer = ?";

                    if ($stmt = mysqli_prepare($conn, $cart_item)) {
                        mysqli_stmt_bind_param($stmt, "s", $buyer);
                        mysqli_stmt_execute($stmt);
                        $cart = mysqli_stmt_get_result($stmt);

                        $total_price = 0;
                        $VAT = 0;
                        $delivery_fee = 7.54;

                        if ($cart && mysqli_num_rows($cart) > 0) {
                            while ($row = mysqli_fetch_assoc($cart)) {
                                $product_id = $row['product_id'];
                                $product_name = $row['product_name'];
                                $noofItem = $row['noofItem'];
                                $product_image = $row['product_image'];
                                $product_price = ($row['product_price'] * $noofItem);
                                $product_discount = $row['product_discount'];

                                // Calculate price after discount
                                $discounted_price = $product_price - ($product_price * ($product_discount / 100));
                                $subtotal = $discounted_price;

                                // Accumulate total price
                                $total_price += $subtotal;
                                ?>

                                <!-- Cart Item -->
                                <div class="product-card d-flex align-items-center">
                                    <a href="product-details.php?id=<?= $product_id; ?>">
                                        <img src="<?= $product_image; ?>" alt="<?= $product_name; ?>" class="product-image">
                                    </a>
                                    <div class="product-details flex-grow-1 px-3">
                                        <h5><?= $product_name; ?></h5>
                                        <p class="text-muted">Product ID: <?= $product_id; ?></p>
                                        <p><i class="fa fa-naira-sign"></i> <?= number_format($subtotal, 2); ?></p>
                                        <div class="quantity-control d-flex">
                                            <span>Quantity:</span>
                                            <button onclick="subst(this)" class="quantity-btn" data-id="<?= $product_id; ?>">-</button>
                                            <span class="noOfItem" data-id="<?= $product_id; ?>"><?= $noofItem; ?></span>
                                            <button onclick="add(this)" class="quantity-btn" data-id="<?= $product_id; ?>">+</button>
                                        </div>
                                    </div>
                                </div>

                            <?php   
                            }

                            // Calculate VAT (5%)
                            $VAT = $total_price * 0.05;
                            $grand_total = $total_price + $VAT + $delivery_fee;
                        } else {
                            echo "<p>Your cart is empty.</p>";
                        }
                    } else {
                        die('Error in query execution: ' . mysqli_error($conn));
                    }
                }
                ?>
            </div>

            <!-- Order Summary -->
            <div class="col-md-4">
                <div class="summary-card">
                    <h5 class="mb-4">Order Summary</h5>
                    <div class="summary-row">
                        <span>Item Total:</span>
                        <span># <?= number_format($total_price, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>VAT (5%):</span>
                        <span># <?= number_format($VAT, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Delivery:</span>
                        <span># <?= number_format($delivery_fee, 2); ?></span>
                    </div>
                    <hr>
                    <div class="summary-row">
                        <strong>Total Price:</strong>
                        <strong># <?= number_format($grand_total, 2); ?></strong>
                    </div>
                    <a href="checkout-page.php" class="btn btn-dark text-white text-decoration-none w-100 form-control py-2">Check out</a>
                    <?php $_SESSION['total_price'] = $grand_total;  ?>
                    <p class="payment-note">Pay in 30 days. Learn more</p>
                </div>
            </div>
        </div>

        <input type="hidden" name='buyer' id='buyer' value="<?= $buyer; ?>">

    </div>

    <script>
        function add(btn) {
            var itemId = $(btn).data('id'); 
            var buyer = $('#buyer').val();
            var qtyElem = $(".noOfItem[data-id='" + itemId + "']");
            var a = parseInt(qtyElem.text());
            a++;

            $.ajax({
                type: "POST",
                url: "engine/add_to_cart.php",
                data: { 'buyer': buyer, 'itemId': itemId },
                success: function(response) {
                    qtyElem.text(a);
                },
                error: function(xhr, status, error) {
                    console.error("Error adding item: ", error);
                }
            });
        }

        function subst(btn) {
            var itemId = $(btn).data('id');
            var buyer = $('#buyer').val();
            var qtyElem = $(".noOfItem[data-id='" + itemId + "']");
            var b = parseInt(qtyElem.text());

            if (b > 1) {
                b--;
                $.ajax({
                    type: "POST",
                    url: "engine/remove_from_cart.php",
                    data: { 'buyer': buyer, 'itemId': itemId },
                    success: function(response) {
                        qtyElem.text(b);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error removing item: ", error);
                    }
                });
            }
        }
    </script>

</body>
</html>
