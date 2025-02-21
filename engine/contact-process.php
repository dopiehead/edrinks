<?php 
require 'config.php';

$name = mysqli_real_escape_string($conn, $_POST['name']);
$message = mysqli_real_escape_string($conn, $_POST['message']);
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
$date = (new DateTime())->modify('+1 hour')->format('D, F d'); // Date formatting

// Validate required fields
if (empty($name) || empty($message) || empty($email) || empty($subject)) {
     echo "All fields are required";
     exit;
}

// Validate individual fields
if ($name == '') {
     echo "Name field is required";    
     exit;
} elseif ($email == '') {
     echo "Email field is required";
     exit;
} elseif ($message == '') {
     echo "Message field is required";
     exit;
} elseif ($subject == '') {
     echo "Subject field is required";
     exit;
}

// Check for duplicate submission
$get_com = $conn->prepare("SELECT * FROM member_message WHERE compose = ? AND email = ? AND name = ? AND subject = ?");
$get_com->bind_param("ssss", $message, $email, $name, $subject);
$get_com->execute();
$res = $get_com->get_result()->num_rows;

if ($res == 1) {
     echo "You cannot post the same message twice.";
} else {
    // Insert new message into the database
     $stmt = $conn->prepare("INSERT INTO member_message (name, subject, compose, email, user_type, date) VALUES (?, ?, ?, ?, ?, ?)");
     $stmt->bind_param("ssssss", $name, $subject, $message, $email, $user_type, $date);

    if ($stmt->execute()) {
         echo "1"; // Success message
    } else {
         echo "Message was not sent. Error: " . $stmt->error;
    }
}
?>
