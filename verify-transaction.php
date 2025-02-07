<?php 
session_start();
require("engine/config.php");

// Verify session and required parameters
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
} ?>

<html lang="en">
<head>
     <meta charset="UTF-8">
     <?php include("components/links.php") ?>

     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Ti+M7gDqTcHpFtdkA2k8w5lJ6pB6GMD6MMcY2uH6+oVBmQGx0n5v6t+2T9F+Jp6Xr" crossorigin="anonymous">

    <title>Verify Transaction</title>
</head>
<body>
<?php include("components/navbar.php");

// Ensure necessary GET parameters are provided
if (isset($_GET['status'], $_GET['reference'], $_GET['id'], $_GET['user_type'], $_GET['amount'])) {
    $reference = htmlspecialchars($_GET['reference']);
    $status = htmlspecialchars($_GET['status']);
    $amount = (float)$_GET['amount'];
    $user_type = htmlspecialchars($_GET['user_type']);
    $user_id = (int)$_GET['id']; // Ensure user ID is an integer
    $date_added = date('Y-m-d H:i:s');

    $buyer = $_SESSION['user_id'];

    if (!$user_id) {
        echo "<p>User ID is not valid. Please check your login status.</p>";
        exit;
    }

    if ($status === 'success') {
        // Update payment status in the cart
        foreach ($_SESSION['itemId'] as $itemId) {
            $update = $conn->prepare("UPDATE cart SET payment_status = 1 WHERE buyer = ? AND itemId = ?");
            $update->bind_param("ii", $user_id, $itemId);
            $update->execute();
            $update->close();
        }

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
        $user_name = $_SESSION['user_name']; // Fetch actual username from session

        $get_buyer_receipt = $conn->prepare("INSERT INTO buyer_receipt (reference_no, client_name, client_id, amount, date_added) VALUES (?, ?, ?, ?, ?)");
        $get_buyer_receipt->bind_param("ssdss", $reference, $user_name, $user_id, $amount, $date_added);
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
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   <!-- Bootstrap JS -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-sqbdl9O7SB5dGQHENc8l1KZ/qB5elS5JtWZXeO4XOZ5WrJX6nU6RWxDJxjffm2pM" crossorigin="anonymous"></script>
 </body>
</html>
