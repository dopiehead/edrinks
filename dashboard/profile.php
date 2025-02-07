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
    
     <?php
     $currentPage = 'profile';
     include ("components/side-bar.php");
     
     ?>


    <!-- Main Content -->
    <div class="main-content pt-5">
   
    <div class="container-fluid p-4">
<div id="label">
<div id="messages_home" style="text-align: center;">
<div class="tab">
<a class="tablinks btn btn-primary"  id="defaultOpen" onclick="openCity(event,'London')">My profile</a>
<a class="tablinks btn btn-trash" onclick="openCity(event,'Paris')">Edit Profile</a>

</div>

</div>



<br>

<div id="London" class="tabcontent">

<table style="width: 100%;">
     <thead>
         <tr style="border-top: 2px solid rgba(192,192,192,0.4);border-bottom: 2px solid rgba(192,192,192,0.4);">
              <th style="padding:10px;" class="inbox" id="Home">Personal details</th>
         </tr>
     </thead>
</table>

<br><br>

 <small> <?php echo htmlspecialchars($user_name) ;?></small><br>

<?php if (isset($_SESSION['user_id']) ) {
?>

<small> 2347034497654</small><br>

<small class='fw-bold'><?= htmlspecialchars($_SESSION['user_role']);?></small><br>

<?php
}
?>
<?php if (isset($_SESSION['user_id']) ) {
?>

<small> <?php  echo htmlspecialchars($user_phone);?></small><br>


<small>Dial code +234</small><br>

<?php
}
?>

<small><?php echo htmlspecialchars($user_email);?></small>

   <br>

   <i class="fa-solid fa-user-alt"></i><br>

<form id="editpage-form" method="post">

     <input type="hidden" name="id" value="">
     <input type="file" name="fileupload"><br><br>
<input type="submit" name="submit" id="submit" value="Change photo (Max 4MB)" class="btn btn-success " style="color: white;"><br>

</form>


</div>


<!-- part b  -->

<div id="Paris" class="tabcontent">

<h6>My profile</h6>


<form id="editpage-details">

     <input type="hidden"  name="sid" value="<?php echo htmlspecialchars($user_id); ?>">

     <input type="hidden"  name="user_type" value="<?php echo htmlspecialchars($user_type); ?>">

     <input id="business_name" name="business_name" type="text" class="form-control" value="<?php echo htmlspecialchars($user_name); ?>" placeholder="Business Name"><br>

     <div class='d-flex justify-content-center gap-3 flex-md-row flex-column'>

          <input id="password"  type="password" name="password" class='form-control' placeholder="Password">

          <input id="first_name"  type="password" name="cpassword" class='form-control' placeholder="Confirm Password">

     </div>


     <br>

     <input type="text" name="bank_name" style="font-size:14px;" placeholder="Bank Name" class="form-control" id="bank_name" value="" >

     <br>

     <input type="number" name="account_number" style="font-size:14px;" placeholder="Account Number" class="form-control" value=""  id="account_number">

      <br>

      <h6>Contact information</h6>

 <div class='d-flex justify-content-center gap-3 flex-md-row flex-column'>

      <input type="text" name="country" placeholder="Country" id="contact" class='form-control'>

      <input type="text" name="contact" id="contact"  placeholder="Phone number" class='form-control'>

     <input type="text" name="whatsapp" id="whatsapp" placeholder="Whatsapp" value="" class='form-control'><br>

</div>

<br>

 <input id="business_email" type="email" style="font-size:14px !important" name="" class="form-control" value="<?php echo$user_email?>" placeholder="Email Address"><br>

 <h6> Address Details</h6><br>

 <?php

 require '../engine/connection.php';
 $getStates = mysqli_query($con,"SELECT * from states_in_nigeria GROUP by state");
?>
<select name="location" class=" location address_details form-control" id="location">
<option value="">Entire Nigeria</option>
<?php
while ($states = mysqli_fetch_array($getStates)) {
?>
<option value="<?php echo $states['state']?>"><?php echo $states['state']?></option>
<?php }?>

</select>

   <span id='lg'></span>

<br>
<h6> About Your Organisation</h6><br>

<textarea style="border:1px solid transparent" class="form-control" name="about" placeholder="About Your Organization" wrap="physical"></textarea><br>

<textarea  style="border:1px solid transparent" class="form-control" name="services" placeholder="Services Your Organization Provides...." wrap="physical"></textarea><br>

<br>

 <h6>Availability</h6><br>

 <div class='d-flex justify-content-center gap-3 flex-md-row flex-column'>

      <select name="days" class='form-control' id="time">

         <option value="days">Days</option>
         <option value="monday">Monday</option>
         <option value="tuesday">Tuesday</option>
         <option value="wednesday">Wednesday</option>
         <option value="thursday">Thursday</option>
         <option value="friday">Friday</option>
         <option value="saturday">Saturday</option>
         <option value="sunday">Sunday</option>

     </select>   

     <input id="time" type="text" name="opening_time" class='form-control' placeholder="Opening Time in :am/:pm"> 

     <input id="time" type="text" name="closing_time" class='form-control' placeholder="Closing Time in :am/:pm"><br>

</div>

<br>

 <h6>Social Media</h6><br>


 <div class='d-flex justify-content-center flex-md-row flex-column gap-3'>
     <input id="links" type="text" name="facebook" placeholder="Facebook" class='form-control' value="">
     <input id="links" type="text" name="twitter" placeholder="Twitter" class='form-control' value="">
     <input id="links" type="text" name="linkedin" placeholder="Linkedin " class='form-control' value="">
     <input id="links" type="text" name="instagram" placeholder="Instagram" class='form-control' value="">
 </div>


 <br>
 <div style="display: none;" class="loading-image text-center" id="loading-image"><img id="loader" height="50" width="50" src="loading-image.GIF"></div>

 <div class="container  d-flex justify-content-start gap-3" style="text-align:left;font-size:0.9rem;">
     <a class="btn btn-danger" onclick="cancel()">Cancel</a>
     <a id="btn-submit" class="btn btn-success">Submit</a>
 </div>

</form>

</div>
</div>
</div>


    </div>



    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>


<script>

function openCity(evt, cityName) {
var i, tabcontent, tablinks;
tabcontent = document.getElementsByClassName("tabcontent");
for (i = 0; i < tabcontent.length; i++) {
tabcontent[i].style.display = "none";
 }
tablinks = document.getElementsByClassName("tablinks");
for (i = 0; i < tablinks.length; i++) {
 tablinks[i].className = tablinks[i].className.replace(" active", "");
 }
document.getElementById(cityName).style.display = "block";
evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
</script>






<script type="text/javascript">

$('#editpage-form').on('submit',function(e){

if (confirm("Are you sure to change this?")) {

 e.preventDefault();

$(".loading-image").show();


var formdata = new FormData();
   $.ajax({
           type: "POST",

           url: "../../engine/changeprofilepic.php",

           data:new FormData(this),

           cache:false,

           processData:false,

           contentType:false,

           success: function(response) {

           $(".loading-image").hide();

          if(response==1){

            swal({

          text:"Image has been changed",
          icon:"success",
        });
       $('#bom').load(location.href + " #my");
}

else
 { 
  swal({
            icon:"error",
            text:response

           });
            $("#editpage-form")[0].reset();      

            }
 }
        });
 }
    });

</script>

<script type="text/javascript">

$('#lg').html("<select  id='lga' class='lga address_details form-control'><option>Business Axis</option></select>");
  
$('.location').on('change',function() {
  
var location = $(this).val();

      $.ajax({


          type:"POST",

            url:"engine/get-lga.php",

            data:{'location':location},

            success:function(data) {

              $('#lg').html(data);
              
            }


     });

});

</script>


<script type="text/javascript">

  $('#btn-submit').on('click',function(){
      
       $(".loading-image").show();

      $.ajax({

            type: "POST",

            url: "edit-page.php",

            data:  $("#editpage-details").serialize(),

            cache:false,

            contentType: "application/x-www-form-urlencoded",

             success: function(response) {
             
             if (response==1) {

            
            swal({
              
              text:"Details update is saved",

              icon:"success",

            });
           $("#editpage-details")[0].reset();
           
            $(".loading-image").hide();

           
              


              $("#myformx").hide();



          }
            
            

             else{

              swal({

                   text:response,
                   icon:"error",

              });
             }

            },

            error: function(jqXHR, textStatus, errorThrown) {

                console.log(errorThrown);

            }

        })

    });


</script>


<script>
  
function cancel() {

     $("#editpage-details")[0].reset();
}
</script>
</body>
</html>