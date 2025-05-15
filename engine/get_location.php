<?php
if(isset($_POST['location']) && !empty($_POST['location'])) {
    require("config.php");

    $location = $conn->real_escape_string($_POST['location']);
    $query = "SELECT COUNT(*) FROM products WHERE sold = 0 AND product_location LIKE ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($query);
    $locationParam = "%{$location}%"; // Add wildcards for LIKE operator
    $stmt->bind_param("s", $locationParam);
    
    // Execute and fetch result
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    
    // Check if products exist
    echo ($count > 0) ? "1" : "0";

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
