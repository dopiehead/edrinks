<?php 
session_start();
include 'config.php';

// Sanitize inputs
$itemId = (int) ($_POST['itemId'] ?? 0);
$seller_id = mysqli_real_escape_string($conn, $_POST['seller_id'] ?? '');
$noofitem = (int) ($_POST['noofitem'] ?? 0);
$seller_type = mysqli_real_escape_string($conn, $_POST['seller_type'] ?? '');
$buyer = mysqli_real_escape_string($conn, $_POST['buyer'] ?? '');
$payment_status = 0;
$date_added = date('Y-m-d H:i:s');
$amount = $_SESSION['amount'];

// Ensure required fields are filled
if ($itemId > 0 && $noofitem > 0 && !empty($seller_id) && !empty($seller_type) && !empty($buyer)) {
    
    // Check if the item is already in the cart
    $checkStmt = $conn->prepare("SELECT noofItem FROM cart WHERE itemId = ? AND buyer = ?");
    $checkStmt->bind_param("ii", $itemId, $buyer);
    $checkStmt->execute();
    $checkStmt->store_result();
    
    if ($checkStmt->num_rows > 0) {
        // Item already exists in cart, update quantity
        $checkStmt->bind_result($existing_quantity);
        $checkStmt->fetch();
        $new_quantity = $existing_quantity + $noofitem;

        $updateStmt = $conn->prepare("UPDATE cart SET noofItem = ?, date_added = ? WHERE itemId = ? AND buyer = ?");
        $updateStmt->bind_param("isii", $new_quantity, $date_added, $itemId, $buyer);
        
        if ($updateStmt->execute()) {
            echo "1"; // Success response
        } else {
            error_log("Error updating cart item: " . $updateStmt->error);
            echo "Failed to update cart item";
        }
        
        $updateStmt->close();
    } else {
        // Item does not exist in cart, insert a new row
        $insertStmt = $conn->prepare("INSERT INTO cart (itemId, seller_id, seller_type, noofItem, buyer, payment_status, date_added) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertStmt->bind_param("iisssis", $itemId, $seller_id, $seller_type, $noofitem, $buyer, $payment_status, $date_added);
        
        if ($insertStmt->execute()) {
            $_SESSION['itemId'][] = $itemId;

            $_SESSION['seller_id'][] = $seller_id;
            $_SESSION['seller_type'][] = $seller_type;
            $_SESSION['noofitem'][] = $noofitem;
            $_SESSION['buyer'][] = $buyer;
            $_SESSION['date_added'][] = $date_added;
            echo "1"; // Success response
        } else {
            error_log("Error adding item to cart: " . $insertStmt->error);
            echo "Failed to add item(s) to the cart";
        }

        $insertStmt->close();
    }
    
    $checkStmt->close();
} else {
    echo "All fields are required";
}
?>
