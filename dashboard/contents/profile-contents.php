<?php
     if(isset($_SESSION['user_id'])){
        
         $query = "SELECT * FROM user_profile WHERE id = ?";
         $stmt = $conn->prepare($query);
         if(!$stmt){
             echo "User profile not found";
         }
         $stmt->bind_param('i', $userId);
         $stmt->execute();
         // Fetch the result
         $result = $stmt->get_result();
         if ($row = $result->fetch_assoc()) {
             // Assign user data from $row
             $user_id = $row['id'];
             $user_name = $row['user_name'];
             $user_email = $row['user_email'];
             $user_password = $row['user_password'];
             $user_type = $row['user_type'];
             $user_image = $row['user_image'];
             $user_phone = $row['user_phone'];
             $user_location = $row['user_location'];
             $lga = $row['lga'];
             $user_address = $row['user_address'];
             $user_rating = $row['user_rating'];
             $verified = $row['verified'];
             $date_added = $row['date_added'];
         } else {
              echo "No user found.";
         }
         
     }
?>