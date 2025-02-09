<?php
require("config.php");

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $search = $_GET['q'];
    $searchTerms = explode(" ", $search);

    // Start query
    $query = "SELECT * FROM products WHERE sold = 0 AND (";

    // Dynamic conditions for multiple keywords
    $conditions = [];
    $params = [];
    $paramTypes = "";

    foreach ($searchTerms as $text) {
        $conditions[] = "(product_name LIKE ? OR product_category LIKE ? OR product_location LIKE ? OR product_details LIKE ?)";
        $paramTypes .= "ssss";
        $text = "%$text%";
        array_push($params, $text, $text, $text, $text);
    }

    // Append conditions to query
    $query .= implode(" AND ", $conditions) . ") ORDER BY product_id DESC LIMIT 3";

    // Prepare statement
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        die("SQL Error: " . $conn->error);
    }

    // Bind parameters dynamically
    $stmt->bind_param($paramTypes, ...$params);

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if products found
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['product_id'];
            $name = $row['product_name'];
            $price = $row['product_price'];
            $image = $row['product_image'];
            $discountPercentage = max(0, min(100, (float)$row['product_discount']));
            $originalPrice = max(0, (float)$row['product_price']);
            $quantity = $row['product_quantity'];
            $discountAmount = ($discountPercentage / 100) * $originalPrice;
            $discountedPrice = $originalPrice - $discountAmount;
            
            ?>
            <div class='package d-flex flex-row flex-column gap-1 px-2 mt-2 border-bottom border-mute pb-2'>
         
                <span>
                    <a class='text-sm text-decoration-none text-orange text-capitalize fw-bold' href="product-details.php?id=<?= base64_encode($id); ?>">
                        <?= htmlspecialchars($name); ?>

                    </a>
                 </span>
                <span class='text-secondary'>

                     <?php if($discountPercentage > 0 ): ?>

                         <i class="fas fa-naira-sign"></i> <?= ($discountedPrice * $quantity); ?>

                     <?php else : ?>  

                         <i class="fas fa-naira-sign"></i> <?= number_format($price, 2) * ($quantity); ?>

                     <?php endif;?>
                </span>

                <span class='text-sm'>
                    <?php if($quantity>0): ?>
                   <b>instock :</b>  <?= htmlspecialchars($quantity) ?> Item(s)
                    <?php endif; ?>
                </span>
            </div>
        <?php
        }
        ?>
        <div class='text-right px-2 py-2'>
             <a class='text-decoration-none text-secondary px-2 rounded-2 py-1 btn-dark text-white text-sm' href="products.php?search=<?= $_GET['q']; ?>">See more <i class='fa fa-arrow-right'></i></a>
        </div>
    <?php
    } else { 
        echo "<p>No products found.</p>";
    }

    $stmt->close();
}
?>
