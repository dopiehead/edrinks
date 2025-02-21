<?php 
session_start();
require 'engine/config.php';

// Validate User ID
if (!isset($_POST['id']) || empty($_POST['id']) || !ctype_digit($_POST['id'])) {
    die("Invalid user ID.");
}

$myid = $_POST['id']; // Already validated as integer

// Determine Upload Folder (Default)
$imageFolder = "uploads/";

// If user session exists, set folder for buyers
if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $imageFolder = "uploads/buyers/";
}

// Validate File Upload
if (!isset($_FILES["fileupload"]) || $_FILES["fileupload"]["error"] !== UPLOAD_ERR_OK) {
    die("Error uploading file.");
}

$maxsize = 4 * 1024 * 1024; // 4MB
$basename = basename($_FILES["fileupload"]["name"]);
$imagePath = $imageFolder . $basename;
$imageExtension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
$allowed_extensions = ["jpg", "jpeg", "png"];

if (!in_array($imageExtension, $allowed_extensions)) {
    die("Please upload a valid image (PNG or JPEG only).");
}

if ($_FILES["fileupload"]["size"] > $maxsize) {
    die("Image file size exceeds the 4MB limit.");
}

$image_temp_name = $_FILES["fileupload"]["tmp_name"];

// Move file securely
if (!move_uploaded_file($image_temp_name, $imagePath)) {
    die("File upload failed.");
}

// Update user profile image using prepared statement
$sql = "UPDATE user_profile SET user_image = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $imagePath, $myid);

if ($stmt->execute()) {
    // Update session image if user is logged in
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $_SESSION['image'] = $imagePath;
    }
    echo "Profile picture updated successfully.";
} else {
    echo "Error updating picture.";
}

// Close statement
$stmt->close();
$conn->close();
?>
