<?php
session_start();
// error_reporting(E_ALL ^ E_NOTICE);
require("config.php");


error_reporting(E_ALL);        // Report all errors
ini_set('display_errors', 1);  // Display errors on the page





// Redirect if user is not logged in
if (!isset($_SESSION["user_id"])) { 
    echo "<script>location.href='sign-in.php'</script>";
    exit();
}

$txn_ref = time();
$buyer = $_SESSION['user_id'];
$product_price = 0;

// Fetch payment key
$getkey = $conn->prepare("SELECT mykey FROM mykeys");
$getkey->execute();
$result = $getkey->get_result();
$mykey = $result->fetch_assoc()['mykey'] ?? '';

// Fetch buyer details
$getbuyer = $conn->prepare("SELECT id, user_name, user_email, user_address, user_type FROM user_profile WHERE id = ?");
$getbuyer->bind_param("s", $buyer);
$getbuyer->execute();
$result = $getbuyer->get_result();
$user = $result->fetch_assoc();
$userId = $user['id'];
$userName = $user['user_name'];
$userEmail = $user['user_email'];
$userAddress = $user['user_address'];
$userType = $user['user_type'];

// Fetch cart items
$cart_query = "SELECT cart.itemId, cart.noofItem, cart.payment_status, products.product_name, products.product_image, 
                products.product_price, products.product_discount 
                FROM cart 
                JOIN products ON cart.itemId = products.product_id 
                WHERE cart.buyer = ? AND cart.payment_status = 0";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param("s", $buyer);
$stmt->execute();
$cart_items = $stmt->get_result();

// Calculate Total
$VAT = 0;
$delivery_fee = 7.54;

?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include("components/links.php"); ?>
    <title>Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/checkout-page.css">
</head>
<body>
    <?php include("components/navbar.php"); ?>
    
    <div class="container py-4">
        <a onclick="history.back()" class="btn btn-secondary mb-4 mt-2">Back</a>
        
        <h4>Billing Information</h4>
        <form id="paymentForm" method="post">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="fullname" class="form-control" placeholder="Full Name" value="<?= htmlspecialchars($userName); ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="address" class="form-control text-capitalize" placeholder="Address" value="<?= htmlspecialchars($userAddress); ?>" required>
                </div>
            </div>
            
            <h4 class="mt-4">Order Summary</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $cart_items->fetch_assoc()): ?>
                        <?php 
                            $subtotal = $product['product_price'] * $product['noofItem']; 
                            $product_price += $subtotal;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($product['product_name']); ?></td>
                            <td>&#8358;<?= number_format($product['product_price']); ?></td>
                            <td><?= $product['noofItem']; ?></td>
                            <td>&#8358;<?= number_format($subtotal); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><b>Subtotal</b></td>
                        <td>&#8358;<?= number_format($product_price); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>VAT (5%)</b></td>
                        <td>&#8358;<?= number_format($product_price * 0.05, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Delivery Fee</b></td>
                        <td>&#8358;<?= number_format($delivery_fee, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Total</b></td>
                        <td>&#8358;<?= number_format($product_price + ($product_price * 0.05) + $delivery_fee, 2); ?></td>
                          <?php $totalamount =number_format($product_price + ($product_price * 0.05) + $delivery_fee, 2); ?>
                    </tr>
                </tfoot>
            </table>
            <input type="hidden" name="user_id" id="user_id" value="<?= htmlspecialchars($buyer); ?>">
            <input type="hidden" name="user_type" id="user_type" value="<?= htmlspecialchars($userType); ?>">
            <input type="hidden" name="amount" id="amount" value="<?= htmlspecialchars($totalamount); ?>">
            <?php $_SESSION['amount'] = $totalamount; ?>
            <button type="submit" name="submit" class="btn btn-primary w-100 mt-2">Place Order</button>
        </form>
    </div>

    <?php include("components/footer.php"); ?>

    <script src="https://js.paystack.co/v2/inline.js"></script>
    <script>
    $(document).ready(function () {
        $('.numbering').load('engine/item-numbering.php');
        $('#paymentForm').submit(function (e) {
            e.preventDefault();

            let id = $('#user_id').val();
            let user_type = $('#user_type').val();
            let amount = "<?= htmlspecialchars($totalamount * 100); ?>"; // Ensuring amount is defined
            let paystack = new PaystackPop();

            paystack.newTransaction({
                key: "<?= htmlspecialchars($mykey); ?>",
                email: "<?= htmlspecialchars($userEmail); ?>",
                amount: amount,  // Fixed amount issue
                currency: "NGN",
                ref: "<?= $txn_ref; ?>",
                onSuccess: function(response) {
                    window.location.href = "verify-transaction.php?status=success&reference=" + 
                        encodeURIComponent(response.reference) + 
                        "&id=" + encodeURIComponent(id) + 
                        "&user_type=" + encodeURIComponent(user_type) + 
                        "&amount=" + encodeURIComponent(amount);
                },
                onCancel: function() {
                    alert("Payment was canceled.");
                }
            });
        });
    });
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script> 
</body>
</html>
