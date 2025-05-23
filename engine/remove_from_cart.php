<?php 

require 'engine/config.php';

session_start(); // Start session at the top

// Validate POST input
if (!isset($_POST['buyer'], $_POST['itemId'])) {
     die("Invalid request.");
}

// Sanitize input
$buyer = trim($_POST['buyer']);
$itemId = trim($_POST['itemId']);

// Update cart (Decrement item count) using prepared statements
$update_cart_query = "UPDATE cart SET itemId = itemId - 1 WHERE itemId = ? AND buyer = ?";
$stmt = $conn->prepare($update_cart_query);
$stmt->bind_param("ss", $itemId, $buyer);

if ($stmt->execute()) {
    // Select updated cart info
     $select_cart_query = "SELECT buyer, itemId FROM cart WHERE itemId = ? AND buyer = ?";
     $stmt = $conn->prepare($select_cart_query);
     $stmt->bind_param("ss", $itemId, $buyer);
     $stmt->execute();

     $result = $stmt->get_result();
     while ($row = $result->fetch_assoc()) {
         $_SESSION['itemId'] = $row['itemId'];
    }
} else {
      echo "Error updating cart: " . $conn->error;
}

// Close statement & connection
$stmt->close();
$conn->close();
?>
