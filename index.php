<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include ("components/links.php"); ?>
   <link rel="stylesheet" href="assets/css/business-improvement.css">
   <link rel="stylesheet" href="assets/css/categories.css">
   <link rel="stylesheet" href="assets/css/states-we-cover.css">
   <link rel="stylesheet" href="assets/css/brands-and-deals.css">
   <link rel="stylesheet" href="assets/css/products.css">
   <link rel="stylesheet" href="assets/css/banner-edrinks.css">
   <link rel="stylesheet" href="assets/css/product-list.css">
   <link rel="stylesheet" href="assets/css/banner-signup.css">
   <link rel="stylesheet" href="assets/css/why-banner.css">
  <title>e-Drink Navbar</title>
</head>
<body>
     <?php include ("components/navbar.php"); ?>
     <?php include ("components/hero-section.php"); ?>
     <?php include ("components/business-improvement.php"); ?>
     <?php include ("components/categories.php"); ?>
     <?php include ("components/states-we-cover.php"); ?>
     <?php include ("components/brands-and-deals.php"); ?>
    
     <?php include ("components/banner.php"); ?>
     <?php include ("components/product-list.php"); ?>
     <?php include ("components/banner-signup.php"); ?>
     <?php include ("components/why-banner.php");?>
     <?php include ("components/newsletter.php");?>
     <?php include ("components/footer.php"); ?>
     <a class="btn-down" onclick="topFunction()"><i class='fa fa-arrow-up'></i></a>
     <script src='assets/js/index.js'></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script> 
     <script src="assets/js/scroll.js"></script>
    
</body>
</html>