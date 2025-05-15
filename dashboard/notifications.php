<?php session_start(); 

require ("../engine/config.php");
$get_notifications = $conn->prepare("SELECT * FROM user_notifications WHERE recipient_id = ? and pending = 0");
if($get_notifications->bind_param("i",$_SESSION['user_id'])){
    $get_notifications->execute();
    $result = $get_notifications->get_result(); ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|sofia|Trirong|Poppins">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat|sofia|Trirong|Poppins">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>
    <title>Notifications</title>
    <style>
        body{
            font-family: poppins;
        }
    </style>
</head>
<body class='bg-light'>

     <div class='container mt-4 w-100'>
        
  <?php  while($row = $result->fetch_assoc()): ?>
        
          <div class='px-2 py-2 d-flex justify-content-center align-items-center flex-row flex-column bg-white shadow-lg bg-white gap-3'>
              <span>From: <b class='text-danger'>Admin</b></span>

             <div style =' display:flex; justify-content:space-between;' class='align-items-center w-100'>
                 <span class='text-primary fa fa-bell fa-2x'></span>
                 <h6 class='text-secondary fw-bold'><?= htmlspecialchars($row['message']) ?></h6>
                  <span class='text-dark text-sm text-capitalize'><?= htmlspecialchars($row['date']) ?></span>
             </div>
               <div class='d-flex justify-content-end w-100'>
                    <a style='cursor:pointer' class='btn-delete' id='<?= htmlspecialchars($row['id']) ?>'><span class='fa fa-trash  text-danger p-1'></span></a>
               </div>


          </div>

      </div>

  <?php 
         endwhile;
          
  ?>
    <?php   
    
        }

        else { ?>

        <div clsss='container'>

        <div class='w-100 shadow-lg d-flex align-items-center justify-content-center  p-4'>
         
             <span class='text-secondary'>You have no new notification</span>
        
        </div>

    </div>

    <?php

        }

   ?>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.10/sweetalert2.min.js" integrity="sha512-M60HsJC4M4A8pgBOj7oC/lvJXuOc9CraWXdD4PF+KNmKl8/Mnz6AH9FANgi4SJM6D9rqPvgQt4KRFR1rPN+EUw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script>

         $(".btn-delete").click(function(){
           let id = $(this).attr("id");
            $.ajax({
                    url:"delete-notification.php?id=" + id,
                    method:"POST",
                    data:{id:id},
                    success:function(data){
                        if(data==1){
                            swal.Fire({
                                title:"Success",
                                text:"Notification has been deleted successfully",
                                icon:"success"

                            });
                        }
                        else{
                             
                             swal.Fire({

                                 title:"Notice",
                                 text:data,
                                 icon:"warning"

                                
                             });

                        }
                    }
      

            })
            
         });


      </script>    


</body>
</html>