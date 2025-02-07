<?php

session_start();

require("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email = trim($_POST['email']);

    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, user_name, user_password, user_type FROM user_profile WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $user_name, $hashed_password, $user_role);

        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                // Store user details in session
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $user_name;
                $_SESSION['user_role'] = $user_role;

                echo json_encode(["status" => "success", "user_role" => $user_role]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid password."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "User not found."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
    }
}

$conn->close();
?>
