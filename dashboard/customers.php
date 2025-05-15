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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|sofia|Trirong|Poppins">
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
            <a href='notifications.php'><i class="fas fa-bell text-secondary"></i></a>
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
             buyer_receipt.client_name,
             buyer_receipt.client_id, 
             products.poster_id,
             user_profile.id,
             user_profile.user_name AS username,
             user_profile.user_image AS user_img,
             user_profile.user_address AS userAddress
             FROM buyer_receipt 
             JOIN user_profile ON user_profile.id = buyer_receipt.client_id
             JOIN products ON products.poster_id = user_profile.id
             WHERE products.poster_id = ?";

         $myproducts = $conn->prepare($query);
         $myproducts->bind_param('i', $userId); // Bind as an integer
         $myproducts->execute();
         $myProductsResult = $myproducts->get_result(); // Get result set
         $myProductsCount = $myProductsResult->num_rows; // Get the number of products

         // Loop through the products
         while ($user = $myProductsResult->fetch_assoc()) { ?>

             <div style='width:250px' class='mt-3 border border-1 border-muted pb-3 d-flex flex-row flex-column gap-1'>
                 <img class='w-100' src="<?= "../".$user['user_img'] ?>" alt="">
                 <div class='d-flex flex-row flex-column px-2 py-1'>
                     <span class='fw-bold'><?= htmlspecialchars($user['username']); ?></span>
                     <span class='text-muted'><?= htmlspecialchars($user['userAddress']);?></span>
                 </div>
             </div>
     <?php
     
      }

     ?>

</div>

 



    </div>



    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    </body>
    </html>