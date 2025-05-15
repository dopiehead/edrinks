<?php 
session_start();
require 'engine/config.php';

error_reporting(E_ALL ^ E_NOTICE);

// Sanitize input values using prepared statements
$product_name = trim($_POST['product_name']);
$product_category = trim($_POST['product_category']);
$product_color = trim($_POST['product_color'] ?? '');
$product_location = trim($_POST['product_location']);
$product_address = trim($_POST['product_address']);
$product_price = trim($_POST['product_price']);
$quantity = trim($_POST['quantity']);
$price_denomination = trim($_POST['price_denomination'] ?? '');
$phone_number = trim($_POST['phone_number'] ?? '');
$product_details = trim($_POST['product_details'] ?? '');
$discount = trim($_POST['discount'] ?? '');
$userid = trim($_POST['user_id'] ?? '');
$sold = trim($_POST['sold'] ?? '');
$views = trim($_POST['views'] ?? '');
$deals = trim($_POST['deals'] ?? '');
$likes = trim($_POST['likes'] ?? '');
$gift_picks = trim($_POST['gift_picks'] ?? '');
$featured = trim($_POST['featured'] ?? '');
$status = isset($_POST['status']) ? intval($_POST['status']) : 0; // Ensure integer (0 or 1)
$status = $status == 1 ? 0 : 1; // Toggle status value
$date = date("D, F d, Y g:iA");

// Ensure phone number is a valid integer
$phone_number = ctype_digit($phone_number) ? (int) $phone_number : 0;

// Validate required fields
if (empty($product_name) || empty($product_details) || empty($product_price) || empty($product_location) || empty($phone_number)) { 
    die("All fields are required.");
}

if (strlen($product_name) > 20) {
    die("Item name limit exceeded, must be at most 20 characters.");
}

// Handle Image Upload
$imageFolder = "uploads/";
$basename = basename($_FILES["imager"]["name"]);
$imagePath = $imageFolder . $basename;
$file_extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
$allowed_extensions = ["jpg", "jpeg", "png"];
$maxsize = 5 * 1024 * 1024; // 5MB
$image_temp_name = $_FILES["imager"]["tmp_name"];
$imageSize = $_FILES["imager"]["size"];

// Image validation
if (!file_exists($image_temp_name)) {
    die("Choose an image file to upload.");
} elseif (!in_array($file_extension, $allowed_extensions)) {
    die("Please upload a valid image (PNG or JPEG only).");
} elseif ($imageSize > $maxsize) {
    die("Image file size limit exceeded. Please upload an image under 5MB.");
}

// Move the uploaded image
if (!move_uploaded_file($image_temp_name, $imagePath)) {
    die("Image upload failed.");
}

// Check for duplicate product
$check_query = "SELECT * FROM item_detail WHERE product_name = ? AND product_details = ? AND user_id = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("ssi", $product_name, $product_details, $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("You cannot post the same content twice.");
}
$stmt->close();

// Insert new product
$insert_query = "INSERT INTO item_detail 
    (user_id, product_name, product_category, product_color, product_location, product_address, product_price, price_denomination, product_image, phone_number, product_details, quantity, discount, gift_picks, sold, likes, views, deals, featured, status, date_added) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($insert_query);
$stmt->bind_param("issssssssissiiiiiiisi", $userid, $product_name, $product_category, $product_color, $product_location, $product_address, $product_price, $price_denomination, $imagePath, $phone_number, $product_details, $quantity, $discount, $gift_picks, $sold, $likes, $views, $deals, $featured, $status, $date);

if ($stmt->execute()) {
    echo "1"; // Success
} else {
    echo "Item was not posted.";
}

$stmt->close();
$conn->close();
?>
