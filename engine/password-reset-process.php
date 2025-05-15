<?php

require("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $new_password = trim($_POST['new_password']);

    if (!empty($user_id) && !empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Update the password and remove the reset token
        $stmt = $conn->prepare("UPDATE user_profile SET user_password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $user_id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Password reset successfully. Redirecting to login..."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to reset password. Please try again."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid input."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
