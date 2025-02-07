<?php
 header('Content-Type: application/json');
 error_reporting(E_ALL);
 ini_set('display_errors', 1);

 require("config.php");

 $response = ["status" => "error", "message" => "Something went wrong."];

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $user_type = trim($_POST['user_type']);

    if (!empty($email) && !empty($user_type)) {
        // Check if email exists
        if ($stmt = $conn->prepare("SELECT id, user_type FROM user_profile WHERE user_email = ? AND user_type = ? LIMIT 1")) {
            $stmt->bind_param("ss", $email, $user_type);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) { 
                 $stmt->bind_result($user_id, $retrieved_user_type);
                 $stmt->fetch();

                 // Generate reset token
                 $reset_token = bin2hex(random_bytes(32));
                 $token_expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

                 // Store reset token in database
                 if ($update_stmt = $conn->prepare("UPDATE user_profile SET reset_token = ?, reset_token_expiry = ? WHERE id = ?")) {
                     $update_stmt->bind_param("ssi", $reset_token, $token_expiry, $user_id);
                    
                     if ($update_stmt->execute()) {
                        // Create reset link
                        $reset_link = "http://yourwebsite.com/verify.php?token=" . $reset_token;

                        // Send email
                        $subject = "Password Reset Request";
                        $message = "Hello,\n\nYou requested a password reset. Click the link below to reset your password:\n\n" . $reset_link . "\n\nThis link expires in 1 hour.";
                        $headers = "From: support@yourwebsite.com\r\nContent-Type: text/plain; charset=UTF-8";

                        if (mail($email, $subject, $message, $headers)) {
                            $response = ["status" => "success", "message" => "Reset link sent to your email."];
                        } else {
                            error_log("Mail failed to send to: $email");
                            $response = ["status" => "error", "message" => "Failed to send email. Please try again."];
                        }
                    } else {
                        $response = ["status" => "error", "message" => "Database error, try again later."];
                    }
                    $update_stmt->close();
                }
            } else {
                $response = ["status" => "error", "message" => "Email not found."];
            }
            $stmt->close();
        } else {
            $response = ["status" => "error", "message" => "Database query failed: " . $conn->error];
        }
    } else {
        $response = ["status" => "error", "message" => "Please enter an email and user type."];
    }
}

$conn->close();
echo json_encode($response);
?>
