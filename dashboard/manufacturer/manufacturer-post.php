<?php session_start();

require("../../engine/config.php"); 

$getkey = mysqli_query($conn, "SELECT * FROM information");

$key_variable = mysqli_fetch_array($getkey);

$key = $key_variable['mykey'];

echo $key;

if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) { 
     if($_SESSION['user_role']=='Customer'){
         header("Location: ../customer/customer-dashboard.php");
         exit();
     }

    else{

         $userId = $_SESSION['user_id']; 
         include("../contents/profile-contents.php");

    }

} else { 
     header("Location: ../../index.php"); 
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
     
    <link rel="stylesheet" href="../../assets/css/wholesaler/wholesaler-dashboard.css">
    <link rel="stylesheet" href="../../assets/css/wholesaler/wholesaler-posts.css">

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
                 <img src="<?php echo"../../" .htmlspecialchars($user_image); ?>" class="rounded-circle" width="32" height="32">
                 <span><?php echo htmlspecialchars($user_name); ?></span>
                 <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </nav>
    <!-- Navbar -->
      <?php include ("../components/side-bar.php"); ?>


    <!-- Main Content -->
          <div class="main-content pt-2 my-3 px-2">

              <h6 class='fw-bold mt-5'>Upload product</h6>
              
              <div class="container">

<div class="row"> 

     <div class="col-md-6">
         <br>
      

         <p><input type="checkbox" onclick="discount()" name="Discount">  Discount sales</p>

         <p><input type="checkbox" onclick="foreign()" name="foreign"> Foreign products</p>
         <?php if (date('N') == 7) { ?>
             <p><input type="checkbox" id="toggleButton"> Used products</p>
         <?php } ?>
     </div>

  <div class="col-md-6">
    
     <?php
    
          $vendor = mysqli_query($conn,"select * from user_profile where id = '$user_id' AND user_type !='Customer'");

          if ($vendor) {
     
             while ($dataVendor = mysqli_fetch_array($vendor)) {

                  $vendorName = $dataVendor['user_name'];

                  $vendorImg = $dataVendor['user_image'];

             }

         }

     ?>
    
  </div>

</div>

<div id="popup" class="popup active bg-white px-3 py-2">
<a class="close"  onclick="verify_id()">&times;</a>  

<form method="post" id="formPopup" enctype="multipart/form-data">
<div class="row jumbotron">
<div class="col-md-6">
<h4>Upload passport / Selfie (max:2MB)</h4> 
<p>Please upload a passport size photograph or a selfie to continue. This to reduce spamming and phising. All sellers are required to  upload a valid ID card and a selfie or passport size photograph.</p>
<input type="hidden" name="sid" value="<?php echo$_SESSION['user_id']?>">
<input type="hidden" name="verified" value="0">
<input  type="file" name="img" accept="image/*" capture='environment'>
<br>
<br></div>

<div class="col-md-6">
<h4>Upload Valid ID (max:2MB)</h4>
<p>Please upload any valid ID card. Verification process takes about 6-24 hrs for new sellers account to be active, please bear with us.</p>
<input type="file" name="valid_id"  accept="image/*">


<br><br>
 
</div>
<div class="text-center" style="display: none;" id="loading-image"><img id="loader" height="50" width="80" src="loading-image.GIF"></div>

<button type="submit" name="submit_verify" style="font-size:13px;" class="btn btn-success form-control">Submit</button>

</div>
<br>

</form>
</div>

<br>

<h6>Product details</h6>

<div class="row">
  
<div class="col-md-6">

<form id="form-product">

 <input type="text" class="form-control" name="product_name" placeholder="....Write product Name">

</div>


<div class="col-md-2">

<select name="product_category" id="product_category" style="text-transform: capitalize;" class="form-control">

<option>Choose Category</option>

<?php

$query_category = mysqli_query($conn,"SELECT product_category FROM products");

while ($row = mysqli_fetch_array($query_category)) {
   
?>
<option value="<?php echo$row['product_category']?>"><?php echo$row['product_category']?></option>

<?php

}

?>
</select>


</div>

<div class="col-md-2">
<select style="text-transform: capitalize;" name="product_color" id="product_color" class="form-control">
  <option value="">choose color</option>
  <option value="blue">blue</option>
    <option value="brown">Brown</option>
      <option value="red">Red</option>
        <option value="yellow">Yellow</option>
          <option value="pink">Pink</option>
            <option value="purple">Purple</option>
              <option value="white">White</option>
                <option value="gold">Gold</option>
                  <option value="black">Black</option>
                    <option value="green">Green</option>
                      <option value="magenta">Magenta</option>
                        <option value="orange">Orange</option>
</select>


</div>

<div class='col-md-2'>
    
     <input style="font-size:14px; " type='number' name='quantity' min='0' id='quantity' class='form-control' placeholder='Quantity'>   
      
</div>


</div>


<br>
<h6>Address details</h6>

<div class="row">

<div class="col-md-6"><select name="product_location"  style="font-size: 14px;text-transform: capitalize;"class="form-control">
            <option selected="" value="">Entire Nigeria</option>
        <option value="Kwara">Kwara</option>
        <option value="Kogi">Kogi</option>
          <option value="Oyo">Oyo</option>
            <option value="Kano">Kano</option>
              <option value="Enugu">Enugu</option>
              <option value="Ebonyi">Ebonyi</option>
                <option value="Owerri">Owerri</option>
                  <option value="FCT-Abuja">FCT-Abuja</option>
                    <option value="Osun">Osun</option>
                    <option value="Ogun">Ogun</option>
                      <option value="Lagos">Lagos</option>
                        <option value="Port-Harcourt">Port-Harcourt</option>
                        <option value="Bauchi">Bauchi</option>
                          <option value="Benue">Benue</option>
                            <option value="Borno">Borno</option>
                              <option value="Cross-River">Cross-River</option>
                                <option value="Delta">Delta</option>
                                  <option value="Edo">Edo</option>
                                  <option value="Imo">Imo</option>
                                    <option value="Ondo">Ondo</option>
                                      <option value="Niger">Niger</option>
                                        <option value="Sokoto">Sokoto</option>
                                          <option value="Zamfara">Zamfara</option>
                                          <option value="Kebbi">Kebbi</option>
                                          <option value="Kaduna">Kaduna</option>
                                          <option value="Abia">Abia</option>
                                           <option value="Adamawa">Adamawa</option>
                                            <option value="Akwa-Ibom">Akwa-Ibom</option>
                                            <option value="Anambra">Anambra</option>
                                            <option value="Bauchi">Bauchi</option>
                                            <option value="Gombe">Gombe</option>
                                            <option value="Pleateau">Pleateau</option>
                                            <option value="Rivers">Rivers</option>
                                            <option value="Nassarawa">Nassarawa</option>



        <br>
</select></div>

<div class="col-md-6">

     <input class="form-control" type="text" name="product_address" placeholder="Street / Estate / Neighbourhood"></div>

</div>

<br>
<h6>Price details</h6>

<div class="row">


     <div class="col-md-3">
    
         <input style="font-size:14px" class="form-control" type="number" min="1" minlength="4" name="product_price" id="product_price" placeholder="Price">
   
    </div>

  <div class="col-md-3">
    
      <select name="price_denomination"  class="border border-1 border-mute ">

          <option value="">Denomination</option>
          <option value="200">200</option>
          <option value="500">500</option>
          <option value="1000">1000</option>
    
     </select> 
    
  </div>

  <div class="col-md-3">


  </div>

  <div class="col-md-3">

     <select style="padding:8px;border-radius:3px;" id="discount_hide" class="active border border-1 border-muted" name="discount">

         <option value="">How many percentage</option>
         <option value="10">10</option>
         <option value="20">20</option>
         <option value="30">30</option>
         <option value="40">40</option>
         <option value="50">50</option>
         <option value="60">60</option>
         <option value="70">70</option>
         <option value="80">80</option>
         <option value="90">90</option>

     </select>

 </div>


</div>
<br>

<h6>Phone number</h6>

 <div>
    
     <input style="font-size:14px;" class="form-control" type="number" min="1" minlength="4" name="phone_number" id="phone_number" value="<?php echo$user_contact ?>" placeholder="Phone number">

 </div>

<br>


<div class='mt-3'>
      <h6>Description</h6>
      <textarea style="font-size: 14px;" name="product_details"  rows="5" class="form-control" wrap="physical" placeholder="Describe your product"></textarea><br>
</div>


</div>


<br>
<span class="active" id="discount_hide"><b>How long will the discount last</b><input type="text" name="discount_time"></span>

<br>

<label class="form-control"  style="text-align: center;background-color: rgba(192,192,192,0.8);width: 100%;padding:18px;"><small  id="file-label"  style="font-size: 14px;padding: 1px;background-color: rgba(0,0,0,0.6);color: white;">Upload image (Max 4MB)</small><br></span><span id="fileName"></span><input style="display: none;" type="file" class="form-control" name="imager" accept='image/*'  onchange="updateFileName(this)"></label><br>


<input type="hidden" name="user_id" value="<?php echo$_SESSION['user_id']?>">
<input type="hidden" name="sold" value="0">
<input type="hidden" name="gift_picks" value="0">
<input type="hidden" name="deals" value="0">
<input type="hidden" name="views" value="0">
<input type="hidden" name="likes" value="0">
<input type="hidden" name="featured" value="0">

</div>
</div>


<div id="bom">
    <div id="cy">
         <div class="container text-center">
       
            <?php 
                $getverification = mysqli_query($conn,"select * from verify_seller where sid ='".htmlspecialchars($_SESSION['user_id'])."' and verified = 1 ");
                if ($getverification->num_rows==0) {?> 
                    <a type="submit" name="verify_id" onclick="verify_id()" class="btn btn-success"> Submit </a>
             <?php }else{?>

             <?php 
                $getstatus = mysqli_query($conn,"select * from user_profile");
                if($getstatus){while ($status = mysqli_fetch_array($getstatus)){
                $statusPay = $status['status'];  

                   if($statusPay==0){  ?>
                     <input type="submit" name="submit" value="Submit" class="btn btn-success">
                      <?php } else{ ?> <a onclick='paywithPaystack()' class='btn btn-success'>Pay to proceed (<i class="fa-solid fa-naira-sign"></i>1000)</a> <?php  } }  } }?>
                   
             </div>

     </div>
</div>

</form>

</div>


          </div>

    </div>

    <script>

 $("#product_color").hide(); 
 
 $("#quantity").hide(); 

 $("#product_category").on('change',function(){
    
var productInfo = $(this).val();  

if(productInfo =="building material"){
    
    $("#product_color").hide();
    $("#quantity").show();
    
}

else if(productInfo =="jobs"){$("#product_color").hide();$("#quantity").hide();}

else if(productInfo =="property"){$("#product_color").hide();$("#quantity").hide();}

else if(productInfo =="farm products"){$("#product_color").hide();$("#quantity").show();}

else if(productInfo =="service providers"){$("#product_color").hide();$("#quantity").hide();}

else{
    
   $("#product_color").show(); 
   
    $("#quantity").show();
}
    
 });   
  
</script>


<script type="text/javascript">

$('#form-product').on('submit',function(e){

        e.preventDefault();

        $(".loader").show();
       
        var formdata = new FormData();

      $.ajax({

            type: "POST",

            url: "../../engine/post-products.php",

            data:new FormData(this),

            cache:false,

            processData:false,

            contentType:false,

             success: function(response) {

             $(".loader").hide();

if (response==1) {
                swal({
                       text:"Item(s) uploaded successfully",
                      icon:"success",

              });
                
               $('#bom').load(location.href + " #cy");
               $("#form-product")[0].reset();
               setTimeout(function() {
                window.location.href='mylistings.php'
                }, 500); 
               
              } 

      else{
          swal({icon:"error",
                text:response

  }); 
        }

            },

            error: function(jqXHR, textStatus, errorThrown) {

                console.log(errorThrown);

            }

        })

    });

</script>

<?php $txn_ref = time(); $fee ="1000"; ?>



<script src="https://js.paystack.co/v2/inline.js"></script>

<script>

function paywithPaystack() {
    var id = "<?php echo $_SESSION['user_id']; ?>";
    const paystack = new PaystackPop();
    
    // Paystack options
    var options = { 
        key: "<?php echo htmlspecialchars($key); ?>", // Replace with your Paystack public key
        email: "<?php echo $_SESSION['user_email'] ?>",
        amount: "<?php echo $fee ?>" * 100 , // Amount in kobo (multiply by 100 to convert to kobo)
        currency: "NGN",
        ref: "<?php echo $txn_ref ?>", // Unique reference generated on the server side
        metadata: {
            custom_fields: [
                {
                    display_name: "Mobile Number",
                    variable_name: "mobile_number",
                    value: document.getElementById('phone_number').value // Assuming 'phone_number' is the ID of your input field
                }
            ]
        },
        onSuccess: function(response) {
            // Handle success response
            if (response.status === "success") {
                var ref = response.reference; // Retrieve the payment reference
                window.location.href = "verify-pay.php?status=success&id="+ id+"&reference=" + ref; // Redirect to success page
            } else {
                console.log("Payment not successful");
            }
        },
        onCancel: function() {
            // Handle cancellation
            console.log("Payment canceled");
        }
    };
    
    // Initialize Paystack payment with the provided options
    paystack.newTransaction(options);
}
</script>

<script type="text/javascript">
  
function updateFileName(input) {
var fileName = input.files[0].name;
  document.getElementById('file-label').innerText = fileName;
}

</script>

<script type="text/javascript">
$('#btn-comment').on('click',function(e){
e.preventDefault();
$("#loading-image").show();
    $.ajax({
            type: "POST",
            url: "../../engine/sp-comment.php",
            data:  $("#conv").serialize(),
            success: function(response) {
            $("#loading-image").hide();
            if (response==1) {
          $('#bom').load(location.href + " #cy");
          $("#conv")[0].reset();
           swal({
            text:"Comment added successfully",
            icon:"success",
});
}
else{
swal({

    icon:"error",
  text:response
});
}         
},
           error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);

            }
        });

    });

</script>

<script>
  
function installment() {
 $("#installment_plan").toggleClass("active");}

function discount() {

  $("#discount_hide").toggleClass("active");}

function verify_id() {
$('#popup').toggleClass('active');
}

function used() {
$('#play').toggleClass('active');
}

</script>

<script>
  
$('#formPopup').on('submit',function(e){

        e.preventDefault();

        $("#loading-image").show();
        
        var formdata = new FormData();

      $.ajax({

            type: "POST",

            url: "seller-verify.php",

            data:new FormData(this),

            cache:false,

            processData:false,

            contentType:false,

             success: function(data) {

             $("#loading-image").hide();

            
if (data==1) {

        
             swal({
                       text:"Image upload successful. We will revert back shortly",
                      icon:"success",

              });
                
               $('#bom').load(location.href + " #cy");
               $("#formPopup")[0].reset();
               $("#formPopup").removeClass("active");
} 

else{
          swal({

            icon:"error",
            text:data}); 
 }

            },

            error: function(jqXHR, textStatus, errorThrown) {

                console.log(errorThrown);

            }

        })

    });

</script>

<script>
  
function btn_weekly(){
$('.drop_down_weekly').toggleClass('active');
}

function btn_monthly(){
$('.drop_down_monthly').toggleClass('active');
}

function ini_pay(){
$('.initial_payment_dropdown').toggleClass('active');
}

function sub(){
$('.sub_payment_dropdown').toggleClass('active');
}

function btn_duration() {
$('.duration_form').toggleClass('active');
} 

</script>






<script>
  
$('.month').on('click',function() {
var month = $(this).attr('id');
var price = $('#product_price').val();
var math = Math.round(price/month);
$('#initial_payment').val(math);
$('#subsequent_payment').val(math);
$('#duration').val(month);
});

</script>



<script>
  
$('.week').on('click',function() {
var week = $(this).attr('id');
var price = $('#product_price').val();
var math = Math.round(price/week);
$('#initial_payment').val(math);
$('#subsequent_payment').val(math);
$('#duration').val(week);

});

</script>

<script>

function openbar() {
 
 $(".overlay").toggle();  
 
}
     
    
</script>



<script>
$(document).ready(function() {
    $('#toggleButton').change(function() {
        var isChecked = $(this).prop('checked') ? 1 : 0; // Convert boolean to 1 or 0
        
        // AJAX call to update server
        $.ajax({
            type: "POST",
            url: "postads-process.php", // PHP script to handle update
            data: { status: isChecked },
            success: function(response) {
                console.log("Status updated successfully: " + response);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status, error);
            }
        });
    });
});
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    </body>
    </html>