<?php session_start();
     if(isset($_SESSION['user_id'])){
         $userId = $_SESSION['user_id'];
         require("../engine/config.php");
         include("contents/profile-contents.php");
         
     }

     else{
         header("Location:../index.php");
         exit();
     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesaler Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>
    <link rel="stylesheet" href="../assets/css/wholesaler/wholesaler-dashboard.css">
    <link rel="stylesheet" href="../assets/css/wholesaler/wholesaler-products.css">

</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-orange fw-bold" href="#">Edrinks</a>
            <div class="position-relative d-flex align-items-center">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="Search">
            </div>
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-bell text-secondary"></i>
                <img src="<?php echo"../" .htmlspecialchars($user_image); ?>" class="rounded-circle" width="32" height="32">
                <span><?php echo htmlspecialchars($user_name); ?></span>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </nav>
    <!-- Navbar -->
      <?php include ("components/side-bar.php"); ?>


    <!-- Main Content -->
    <div class="main-content pt-5 my-3 px-2">
        
    <div id="label">

    <?php
// Prepare your SQL query with a placeholder for the buyer parameter
$sql = "SELECT 
         products.product_id AS product_id, 
         products.product_name AS product_name, 
         products.product_location AS product_location , 
         products.product_price AS product_price, 
         products.product_image AS product_image, 
         products.product_views AS product_views,  
         products.product_discount AS discount, 
         cart.itemId AS itemId,         
         cart.noofItem AS cart_no_of_items,
         cart.buyer AS buyer,
         cart.payment_status AS payment_status
        FROM products 
        INNER JOIN cart ON cart.itemId = products.product_id 
        WHERE cart.buyer = ? AND cart.payment_status = 1";

// Prepare the statement
if ($stmt = $conn->prepare($sql)) {
 
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    $getorderlist = $stmt->get_result();

    $stmt->close();
} else {
    // Handle errors with preparing the statement
    echo "Error preparing statement: " . $conn->error;
    exit; // Optionally exit if there is an error.
}

echo "<h3 class='mt-3'>Order History</h3>";
echo "<h6 class='mt-2' style='text-align:right'><b>" . $getorderlist->num_rows . " Item(s)</b></h6><br>";

if ($getorderlist && $getorderlist->num_rows > 0) {
    ?>
    <div class='container d-flex justify-content-evenly'>

        <?php

        while ($data = $getorderlist->fetch_assoc()) {

            echo "<div style='width:250px;' id='package mt-2 d-flex flex-row flex-column'>";
            
            $price = $data['product_price'];           
            
            // Show discount if available
            if ($data['discount'] > 0) {
         
            } else {
                // Assuming you want to show product views if there is no discount.
                // Note: In your SELECT you have 'product_views' from products, so adjust accordingly.

            }
            ?>
            
            <!-- Update the link to use the correct product id column -->
            <a href='../product-details.php?id=<?php echo htmlspecialchars (base64_encode($data["product_id"])); ?>' target='_blank'>
                <img loading='lazy' id='imgitem' class='w-100' src="<?php echo"../" .htmlspecialchars($data['product_image']); ?>">
            </a>

            <span id='nameitem'><a target='_blank' href='product-details.php?id="<?= htmlspecialchars($data['product_id']); ?>"'> <?= htmlspecialchars($data['product_name'])?></a></span><br>
            <?php
            // Display price details
            if ($data['discount'] > 0) {
                // Original price with strikethrough
                echo "<span style='text-decoration:line-through;' id='priceitem'>&#8358;" . $price . "</span> ";
                // Discounted price
                $discountedPrice = round($price - ($data['discount'] / 100 * $price));
                echo "<span id='priceitem'>&#8358;" . $discountedPrice . "</span><br>";


            } else {
                echo "<span id='priceitem'>&#8358;" . $price . "</span> ";
              
            }
    
            // Product name and location

            echo "<span id='locitem'>" . $data['product_location'] . "</span><br>";
    
            echo "</div>";
        }
        ?>
    </div>
    <?php
} else {
    echo "<br><strong>You have no item in your order history</strong>";
}
?>

 
    </div>

  </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    </body>
    </html>