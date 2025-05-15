<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
require 'config.php';

if (isset($_SESSION['user_id'])) {
    $buyer = $_SESSION['user_id'];    
} else {
    $buyer = null;
}

if (!empty($_SESSION)) {

    $cart_item = "SELECT COUNT(*) AS num_cart FROM cart WHERE buyer = ? AND payment_status = 0";

    if ($stmt = mysqli_prepare($conn, $cart_item)) {
        mysqli_stmt_bind_param($stmt, "s", $buyer);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $num_cart);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($num_cart > 0) {
            echo "<span id='count'>" . htmlspecialchars($num_cart) . "</span>";    
        }
    } else {
        die("Query failed: " . mysqli_error($conn));
    }
}
?>
