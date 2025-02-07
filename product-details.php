<?php session_start(); 
 
 require("engine/config.php");

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $buyer = $_SESSION['user_id'];
    $getbuyer = $conn->prepare("SELECT * FROM user_profile WHERE id = ?");
    $getbuyer->bind_param("i", $buyer); // "i" denotes an integer parameter
    $getbuyer->execute();
    $result = $getbuyer->get_result();
    if ($result->num_rows > 0) {
        while ($user = $result->fetch_assoc()) {
            include("contents/user-contents.php");
        }
    }

    $getbuyer->close(); // Close the prepared statement
} else {
    $buyer = null;
}

if (isset($_GET['id'])) {
      
      $productid = base64_decode($_GET['id']);

    if (empty($productid)) {
         header("Location:index.php");
          exit; 
    } else {

         $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
         $stmt->bind_param("i", $productid); // "i" for integer type
         $stmt->execute();
         $result = $stmt->get_result();
         $product = $result->fetch_assoc(); // Fetch the product data

        if ($product) {
             include("contents/product-contents.php");

             $get_seller_details = $conn->prepare("SELECT * FROM user_profile WHERE id = ?");
             $get_seller_details->bind_param("i", $poster_id); 
             $get_seller_details->execute();
             $result = $get_seller_details->get_result();
             $seller = $result->fetch_assoc();
             include ("contents/seller-contents.php");


        } else {
             echo "Product not found.";
             header("Location:index.php");
             exit;  // Exit the script if the product is not found
        }

        $stmt->close(); // Close the prepared statement
    }
} else {
        echo "Invalid request.";
        header("Location:index.php");
}
?>


<?php 
// Increment the product view count
$update_product = $conn->prepare("UPDATE products SET product_views = product_views + 1 WHERE product_id =?"); 
$update_product->bind_param('i', $productid);  // Bind the product ID
$update_product->execute();  // Execute the update query
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product-details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/product-details.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php include("components/links.php"); ?>

</head>
<body>
<?php include("components/navbar.php");?>
    <div class="product-container">
        <div class="row">
            <!-- Product Image -->
            <div class="col-md-6 mb-4">
                <img src="<?php echo htmlspecialchars($product_image); ?>" alt="edrinks" class="product-image">
            </div>
           
            <!-- Product Details -->
            <div class="col-md-6">
                 <div class="store-name"><a href='store.php?id=<?php echo htmlspecialchars($poster_id); ?>'><?php echo htmlspecialchars($seller_details_name); ?></a> - <span class='fw-bold'><?php echo htmlspecialchars($user_type); ?></span></div>
                 <h1 class="product-title text-capitalize"><?php echo htmlspecialchars($product_name); ?></h1>
                 <div class="product-price"><i class='fa fa-naira-sign'></i>
                  
                 <?php
                    if (isset($discountPercentage) && $discountPercentage > 0): 
                          echo"<span style='text-decoration:line-through'>". htmlspecialchars($product_price * $quantity). "</span> " .htmlspecialchars($discountedPrice * $quantity);
                     else:  
                           echo htmlspecialchars(number_format($product_price * $quantity));
                     endif;
                 ?>
                 
                </div>

                 <div class='d-flex justify-content-evenly gap-1 '>
                     <div class='-content-center align-items-center d-block'>


                         <input type="button" value="-" id="subs" class="btn btn-light" onclick="subst()">&nbsp;
                         <input type="number" class="onlyNumber w-25 border border-mute"  max="<?= htmlspecialchars($quantity); ?>" id="noofitem" value="<?php if(!empty($quantity)): echo htmlspecialchars($quantity);   else : echo ""; endif;  ?>" name="noofitem">&nbsp;
                         <input type="button" value="+" id="adds" onclick="add()" class="btn btn-light">  
                                                 
                         <input type="hidden" name="items_per_id" id="items_per_id" value="<?php if($user_type =='wholesaler'){ echo  htmlspecialchars($items_per_id); } else{ echo "";} ?>"> 
                         <input type="hidden" name="seller_type" id="seller_type" class='seller_type' value="<?php echo htmlspecialchars($seller_details_type); ?>">
                         <input type="hidden" name="userid" id="seller" value="<?php echo $poster_id ?>">
                         <input type="hidden" name="buyer" id="buyer" value="<?php echo $buyer ?>">

                     </div> 
                     <?php
                          if (isset($_SESSION['user_id'])) {
    // Ensure the session user ID is different from the seller's ID
                              if ($_SESSION['user_id'] == $seller_details) {
                     ?>
                                  <button disabled class="add-to-cart">You Posted this product</button> 
                     <?php   
                             } 
                             
                             else{ ?>
                              
                                <button id="<?php echo htmlspecialchars($product_id); ?>" class="add-to-cart btn-add"><span class='spinner-border text-warning'></span> <span class='add-note'>ADD TO CART </span></button>

                     <?php    }

                         } else { // If user is not logged in
                               $redirecturl = htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, "UTF-8"); ?>
                               <a href="sign-in.php?details=<?php echo $redirecturl; ?>" class="add-to-cart text-white" id="">ADD TO CART</a>  
                     <?php
                             }
                     ?>
                     
                </div>

                <div class="description-section">
                    <h2 class="description-title">Description</h2>
                    <p class="description-text">
                        <?php echo htmlspecialchars($product_details); ?>
                    </p>

                    <div class="tags">
                        <span class="tag">Drink</span>
                        <span class="tag">Soft drink</span>
                        <span class="tag">Yellow</span>
                        <span class="tag">Fruit</span>
                        <span class="tag">Cheap</span>
                    </div>

                    <div class="stats">
                        <div class="stat-item">
                            <i class="fas fa-eye"></i>
                            <span><?php echo htmlspecialchars($product_views); ?></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-heart"></i>
                            <span><?php echo htmlspecialchars($product_likes); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include("components/newsletter.php"); ?>

<?php include("components/footer.php"); ?>

<script type="text/javascript">
	function add() {
    var a = $("#noofitem").val();
    a++;
    if (a && a >= 1) {

        $("#subs").removeAttr("disabled");
    }
    $("#noofitem").val(a);
};

function subst() {
    var b = $("#noofitem").val();
    // this is wrong part
    if (b && b >= 1) {
        b--;
        $("#noofitem").val(b);
    }
    else {
        $("#subs").attr("disabled", "disabled");
    }
};

</script>

<script type="text/javascript">
 
$(document).ready(function() {
     $(".spinner-border").hide();
     $('.numbering').load('engine/item-numbering.php');
     $('.btn-add').click(function() {
        
         let itemId = $(this).attr('id');
         let seller_id = $('#seller').val();
         let noofitem = $('#noofitem').val();
         let seller_type = $('#seller_type').val();
         let buyer = $('#buyer').val();

        
         var data =

         { 
             'itemId': itemId, 
             'seller_id': seller_id,       
             'seller_type':seller_type,
             'noofitem': noofitem,
             'buyer':buyer 
         };
        
      $.ajax({
             type: "POST",
             url: "engine/cart-process.php",
             data:data,
             cache: false,
             success: function(response) {

                if (response == 1) {

                    swal({
                         title:"Success",
                         icon: "success",
                         text: "Item(s) has been added successfully"
                    });
                    
                    $('.numbering').load('engine/item-numbering.php');
                } else {
                    swal({
                        title:"Notice",
                        icon: "warning",
                        text: response
                    });
                }
            }
        });
    });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script> 
</body>
</html>