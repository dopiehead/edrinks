<?php
require("engine/config.php");
session_start();

// Ensure necessary GET parameters are provided
if (isset($_GET['status'], $_GET['reference'], $_GET['id'], $_GET['user_type'], $_GET['amount'])) {
    $reference = htmlspecialchars($_GET['reference']);
    $status = htmlspecialchars($_GET['status']);
    $amount = (float)$_GET['amount'];
    $user_type = htmlspecialchars($_GET['user_type']);
    $user_id = (int)$_GET['id']; // Ensure user ID is an integer
    $date_added = date('Y-m-d H:i:s');

    if (!$user_id) {
        echo "<p>User ID is not valid. Please check your login status.</p>";
        exit;
    }

    if ($status === 'success') {
        // Update payment status in the cart
        $update = $conn->prepare("UPDATE cart SET payment_status = 1 WHERE buyer = ?");
        $update->bind_param("i", $user_id);
        $update->execute();
        $update->close();

        // Fetch product details from the user's cart
        $cart_query = $conn->prepare("SELECT itemId, noofItem FROM cart WHERE buyer = ?");
        $cart_query->bind_param("i", $user_id);
        $cart_query->execute();
        $cart_result = $cart_query->get_result();

        while ($row = $cart_result->fetch_assoc()) {
            $product_id = $row['itemId'];
            $noofitem = $row['noofItem'];

            // Update product stock
            $updateStock = $conn->prepare("UPDATE products SET product_quantity = product_quantity - ? WHERE product_id = ?");
            $updateStock->bind_param("ii", $noofitem, $product_id);
            $updateStock->execute();
            $updateStock->close();
        }

        $cart_query->close();

        // Insert buyer receipt
        $user_name = $_SESSION['user_name'] ?? "Unknown User"; // Fetch actual username from session

        $get_buyer_receipt = $conn->prepare("INSERT INTO buyer_receipt (reference_no, client_name, client_id, amount, date_added) VALUES (?, ?, ?, ?, ?)");
        $get_buyer_receipt->bind_param("ssdi", $reference, $user_name, $user_id, $amount, $date_added);
        $get_buyer_receipt->execute();
        $get_buyer_receipt->close();

        ?>
        <div class='container-fluid checkmark-container d-flex justify-content-center align-items-center gap-2 p-5 h-100'>
            <div class='card shadow bg-white px-4 py-2 d-flex flex-column gap-2' style="max-width: 500px; width: 100%;">
                <div class='text-center d-flex justify-content-center'>
                    <span class='border border-success border-3 rounded-circle fs-3 px-3 py-2 text-success checkmark-circle'>
                        <i class="fa fa-check"></i>
                    </span>
                </div>

                <div class='d-flex justify-content-between'>
                    <span>Transaction Reference</span>
                    <span class='fw-bold'><?php echo htmlspecialchars($reference); ?></span>
                </div>

                <div class='d-flex justify-content-between'>
                    <span>Client's Name</span>
                    <span class='text-capitalize fw-bold'><?php echo htmlspecialchars($user_name); ?></span>
                </div>

                <p class='mt-4 text-secondary'>
                    Your payment has been processed successfully. Your order is confirmed.
                </p>

                <?php 
                // Define dashboard links
                $dashboardLinks = [
                    "Wholesaler" => "wholesaler/wholesaler-dashboard.php",
                    "Distributor" => "distributor/distributor-dashboard.php",
                    "Manufacturer" => "dashboard/manufacturer-dashboard.php",
                    "Importer" => "importer/importer-dashboard.php",
                ];
                
                $dashboardLink = $dashboardLinks[$user_type] ?? "general/dashboard.php"; // Default to general dashboard
                ?>

                <p class='text-center text-secondary'>
                    <a href='<?php echo $dashboardLink; ?>' class='text-secondary text-decoration-none'>Back to Dashboard</a>
                </p>
            </div>
        </div>
        <?php

    } else {
        echo "<p>Payment failed or was canceled. Please try again.</p>";
    }
} else {
    echo "<p>Invalid request. Please check your payment details and try again.</p>";
}

$conn->close();
?>
