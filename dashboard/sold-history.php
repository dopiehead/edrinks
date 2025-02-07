<?php session_start();
     if(isset($_SESSION['user_id'])){
         $userId = $_SESSION['user_id'];
         require("../engine/config.php");
         include("contents/profile-contents.php");
         
     }

     else{
         header("Location:../../index.php");
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
    <div class="main-content pt-3 my-4 px-2">

    <h6 class='fw-bold mt-5 mb-3'>My products</h6>
     
    <div class='d-flex justify-content-evenly align-items-center flex-wrap gap-3 mt-1'>
    <?php 
         $query = "SELECT 
         products.product_id AS product_id, 
         products.product_name AS product_name, 
         products.product_location AS product_location , 
         products.product_price AS product_price, 
         products.product_image AS product_image, 
         products.product_views AS product_views,  
         products.product_discount AS discount, 
         cart.itemId AS itemId,         
         cart.noofItem AS cart_no_of_items,
         cart.seller_id AS seller_id,
         cart.payment_status AS payment_status
         FROM products 
         INNER JOIN cart ON cart.itemId = products.product_id 
         WHERE cart.seller_id = ? AND cart.payment_status = 1";
         $myproducts = $conn->prepare($query);
         $myproducts->bind_param('i', $userId); // Use 'i' to bind the userId as an integer
         $myproducts->execute();
         $myProductsResult = $myproducts->get_result(); // Get the result set
         $myProductsCount = $myProductsResult->num_rows; // Get the number of products
  
        if($myProductsCount>0){
 
    // Loop through the products
             while ($product = $myProductsResult->fetch_assoc()) {   ?>
        
                 <div class='card'>
                     <div class='card-image'>
                <!-- Output product image, using htmlspecialchars to escape it and prevent XSS -->
                         <a href='../product-details.php?id=<?php echo htmlspecialchars(base64_encode($product['product_id'])); ?>'><img src='<?php echo"../". htmlspecialchars($product['product_image'], ENT_QUOTES, 'UTF-8'); ?>'></a>
                     </div>
                     <div class='card-body'>
                <!-- Product name -->
                         <h5 class='card-title'><?= htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                <!-- Product price with currency symbol, formatted as a number -->
                         <p class='card-text'>Price: <i class='fas fa-naira-sign'></i><?= number_format($product['product_price'], 2); ?></p>
                         <p class='card-text'>Location: <i class='fas map-marker'></i><?= htmlspecialchars($product['product_location']); ?></p>
                 </div>
             </div>

         <?php

         }



        }

         else{

              echo "<h3 class='text-center mt-5 text-secondary'>No products found.</h3>";

         
    }
    


    ?>
</div>

 



    </div>



    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    </body>
    </html>