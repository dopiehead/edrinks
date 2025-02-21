<?php session_start();
error_reporting(E_ALL ^ E_NOTICE);
require 'engine/config.php';
$sid = mysqli_real_escape_string($conn,$_POST['sid']);
$first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
$user_type = mysqli_real_escape_string($conn,$_POST['user_type']);
$business_name = mysqli_real_escape_string($conn,$_POST['business_name']);
$password = mysqli_real_escape_string($conn,$_POST['password']);
$cpassword =  mysqli_real_escape_string($conn,$_POST['cpassword']);
$secret_password = sha1(md5($password));
$country=mysqli_real_escape_string($conn,$_POST['country']);
$account_number=mysqli_real_escape_string($conn,$_POST['account_number']);
$bank_name=mysqli_real_escape_string($conn,$_POST['bank_name']);
$contact=mysqli_real_escape_string($conn,$_POST['contact']);
$whatsapp=mysqli_real_escape_string($conn,$_POST['whatsapp']);
$location=mysqli_real_escape_string($conn,$_POST['location']);
$lga=mysqli_real_escape_string($conn,$_POST['lga']);
$charge = mysqli_real_escape_string($conn,$_POST['pricing']);
$about=mysqli_real_escape_string($conn,$_POST['about']);  
$services=mysqli_real_escape_string($conn,$_POST['services']);
$days=mysqli_real_escape_string($conn,$_POST['days']);
$opening_time=mysqli_real_escape_string($conn,$_POST['opening_time']);
$closing_time=mysqli_real_escape_string($conn,$_POST['closing_time']);
$facebook=mysqli_real_escape_string($conn,$_POST['facebook']);
$twitter=mysqli_real_escape_string($conn,$_POST['twitter']);
$linkedin=mysqli_real_escape_string($conn,$_POST['linkedin']);
$instagram=mysqli_real_escape_string($conn,$_POST['instagram']);
$date = date("D, F d, Y g:iA", strtotime('+1 hours'));

if(strlen($first_name)>22){echo "character number limit exceeded"; }
elseif (strlen($first_name)>22) {
echo "character number limit exceeded"; }
elseif ($password!=$cpassword) {echo "Password mismatch";}
elseif($contact==''){echo "Contact field cannot be empty";}
elseif($location==''){echo "Location field cannot be empty";}

else{

$sql="insert into user_information values ('','".htmlspecialchars($sid)."','".htmlspecialchars($first_name)."','".htmlspecialchars($user_type)."','".htmlspecialchars($business_name)."','".htmlspecialchars($about)."','".htmlspecialchars($secret_password)."','".htmlspecialchars($country)."','".htmlspecialchars($contact)."','".htmlspecialchars($charge)."','".htmlspecialchars($bank_name)."','".htmlspecialchars($account_number)."','".htmlspecialchars($whatsapp)."','".htmlspecialchars($location)."','".htmlspecialchars($lga)."','".htmlspecialchars($facebook)."','".htmlspecialchars($twitter)."','".htmlspecialchars($linkedin)."','".htmlspecialchars($instagram)."','".htmlspecialchars($days)."','".htmlspecialchars($opening_time)."','".htmlspecialchars($closing_time)."','".htmlspecialchars($date)."')";


   $insert = mysqli_query($conn,$sql);


if (isset($_SESSION['id'])) {

$update = mysqli_query($conn,"UPDATE user_profile SET user_name='".htmlspecialchars($first_name)."',user_phone='".htmlspecialchars($contact)."', user_password ='".htmlspecialchars($secret_password)."' WHERE id ='".htmlspecialchars($sid)."'");

}

if (isset($_SESSION['sp_id'])) {

$update = mysqli_query($conn,"UPDATE service_providers SET sp_name='".htmlspecialchars($first_name)."',pricing='".htmlspecialchars($charge)."',sp_phonenumber1='".htmlspecialchars($contact)."',sp_password ='".htmlspecialchars($secret_password)."',sp_location='".htmlspecialchars($location)."',bank_name='".htmlspecialchars($bank_name)."',account_number='".htmlspecialchars($account_number)."' WHERE sp_id ='".htmlspecialchars($sid)."'");
}


if (isset($_SESSION['business_id'])) {
	
$update = mysqli_query($conn,"UPDATE vendor_profile SET business_name='".htmlspecialchars($business_name)."',business_contact='".htmlspecialchars($contact)."',business_password ='".htmlspecialchars($secret_password)."',company_description='".htmlspecialchars($about)."' WHERE id ='".htmlspecialchars($sid)."'");
}


if ($insert) { echo "1";
  }
else{ echo mysqli_error($insert);}



//;


}
?>



