<?php session_start(); 
require ("../engine/config.php");
$get_notifications = $conn->prepare("SELECT * FROM user_notifications WHERE recipient_id = ? and pending = 0");
if($get_notifications->bind_param("i",$_SESSION['user_id'])):
    $get_notifications->execute();
    $result = $get_notifications->get_result(); ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|sofia|Trirong|Poppins">
    <title>Notifications</title>
    <style>
        body{
            font-family: poppins;
        }
    </style>
</head>
<body class='bg-light'>

     <div class='container mt-4'>

          
  <?php  while($row = $result->fetch_assoc()): ?>
          
    
          <div class='px-2 py-2 d-flex justify-content-center align-items-center flex-row flex-column bg-white shadow-md gap-3'>
              <span>From: <b class='text-danger'>Admin</b></span>
             <div class='d-flex justify-content-between align-items-center'>
                 <span class='text-primary fa fa-bell fa-2x'></span>
                 <span class='text-secondary fw-bold'><?= htmlspecialchars($row['message']) ?></span>
                  <span class='text-dark text-sm'><?= htmlspecialchars($row['date']) ?></span>
             </div>
          </div>

  <?php 
         endwhile;
          
        else: ?>
           
            <div class='w-100 shadow-md py-3 px-2'>
             
              <p class='text-secondary'>You have no new notification</p>
            
            </div>


    <?php   
    
          endif; 

   ?>
          
     </div>

</body>
</html>