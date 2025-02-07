<?php

 require("config.php");

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize user inputs
     $user_name = trim($_POST['user_name']);
     $user_email = trim($_POST['user_email']);
     $user_password = $_POST['user_password'];
     $user_type = trim($_POST['user_type']);
     $reset_token = $_POST['reset_token']?? " ";
     $reset_token_expiry = $_POST['reset_token_expiry']??"  ";
     $user_image = isset($_POST['user_image']) ? trim($_POST['user_image']) : "";
     $user_phone = isset($_POST['user_phone']) ? trim($_POST['user_phone']) : "";
     $user_location = isset($_POST['user_location']) ? trim($_POST['user_location']) : "";
     $user_address = isset($_POST['user_address']) ? trim($_POST['user_address']) : "";
     $user_rating = isset($_POST['user_rating']) ? floatval($_POST['user_rating']) : 0;
     $verified = isset($_POST['verified']) ? intval($_POST['verified']) : 0;
     $sold_items = 0;
     $vkey = md5(time() . $user_email); // Unique verification key
     $date_added = date("Y-m-d H:i:s");

    // Validate required fields
    if (!empty($user_name) && !empty($user_email) && !empty($user_password) && !empty($user_type)) {
        
        // Validate email format
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
             echo json_encode(["status" => "error", "message" => "Invalid email format."]);
             exit;
        }
        
        // Validate password strength (at least 8 characters, at least one number)
        if (strlen($user_password) < 8 || !preg_match('/[0-9]/', $user_password)) {
             echo json_encode(["status" => "error", "message" => "Password must be at least 8 characters long and contain at least one number."]);
             exit;
        }

         // Check if email already exists
         $checkEmail = $conn->prepare("SELECT id FROM user_profile WHERE user_email = ?");
         $checkEmail->bind_param("s", $user_email);
         $checkEmail->execute();
         $checkEmail->store_result();

        if ($checkEmail->num_rows > 0) {
             echo json_encode(["status" => "error", "message" => "Email already exists."]);
        } else {
            // Hash password before saving to the database
             $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

            // Insert new user into database
            $stmt = $conn->prepare("INSERT INTO user_profile 
            (user_name,
             user_email,
              user_password, 
              user_type,
               user_image,
                user_phone,
                 user_location, 
                 user_address, 
                 user_rating,
                 sold_items, 
                 verified,
                  vkey, 
                  reset_token,
                   reset_token_expiry, 
                   date_added) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }
        
        $stmt->bind_param("ssssssississsss", 
            $user_name, 
            $user_email, 
            $hashed_password, 
            $user_type, 
            $user_image, 
            $user_phone, 
            $user_location, 
            $user_address, 
            $user_rating,  // If float, change "i" to "d"
            $sold_items,
            $verified, 
            $vkey, 
            $reset_token,
            $reset_token_expiry,
            $date_added
        ); 
            if ($stmt->execute()) {
                 echo json_encode(["status" => "success", "message" => "Registration successful!"]);
            } else {
                 error_log("Error executing query: " . $stmt->error); // Log the error for debugging
                 echo json_encode(["status" => "error", "message" => "Something went wrong, please try again later."]);
            }

            $stmt->close();
        }
         $checkEmail->close();
    } else {
         echo json_encode(["status" => "error", "message" => "All required fields must be filled."]);
    }
}

$conn->close();
?>
