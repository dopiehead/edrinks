<?php
require __DIR__ . '/engine/config.php';  // Ensure this file exists

$num_per_page = 4;  // Define the number of products per page
$condition = "SELECT * FROM products WHERE sold = 0";

// Filtering by category
if (isset($_POST['categories']) && !empty($_POST['categories'])) {
     $categories = explode(" ", $_POST['categories']);
     foreach ($categories as $cat) {
         $condition .= " AND poster_type LIKE '%" . $conn->real_escape_string($cat) . "%'";
    }
}

// Filtering by brand
if (isset($_POST['brands']) && !empty($_POST['brands'])) {
     $brands = explode(" ", $_POST['brands']);
     foreach ($brands as $brand) {
          $condition .= " AND product_name LIKE '%" . $conn->real_escape_string($brand) . "%'";
    }
}

// Filtering by drink type
if (isset($_POST['drink_type']) && !empty($_POST['drink_type'])) {
     $drink_types = explode(" ", $_POST['drink_type']);
    foreach ($drink_types as $drink) {
         $condition .= " AND product_category LIKE '%" . $conn->real_escape_string($drink) . "%'";
    }
}

// Filtering by price range
if (isset($_POST['price_range']) && !empty($_POST['price_range'])) {
    switch ($_POST['price_range']) {
        case '10000-50000':
            $condition .= " AND product_price BETWEEN 10000 AND 50000";
            break;
        case '50000-100000':
            $condition .= " AND product_price BETWEEN 50000 AND 100000";
            break;
        case '100000-500000':
            $condition .= " AND product_price BETWEEN 100000 AND 500000";
            break;
        case '500000-1000000':
            $condition .= " AND product_price BETWEEN 500000 AND 1000000";
            break;
    }
}


if (isset($_POST['sort'])) {
    $sort = mysqli_real_escape_string($conn, $_POST['sort']);

    switch ($sort) {
        case 'promo':
             $condition .= " AND product_discount > 0";
             break;
        
        case 'featured':
             $condition .= " AND featured_product = 1";
             break;
        
        case 'recent':
             $condition .= " ORDER BY `featured_product` DESC, `product_id` DESC";
             break;
        
        case 'views':
             $condition .= " ORDER BY `featured_product` DESC, `product_views` DESC";
             break;
        
        case 'highest':
             $condition .= " ORDER BY `featured_product` DESC, CAST(`product_price` AS DECIMAL(10,2)) DESC";
             break;
        
        case 'lowest':
             $condition .= " ORDER BY `featured_product` DESC, CAST(`product_price` AS DECIMAL(10,2)) ASC";
             break;


        case 'ratings':
                 $condition .= " ORDER BY `featured_product` DESC, CAST(`product_ratings` AS DECIMAL(10,2)) ASC";
                 break;
        
        default:
             $condition .= " ORDER BY `featured_product` DESC, `product_id` DESC";
             break;
    }
} else {
      $condition .= " ORDER BY `featured_product` DESC, `product_id` DESC";
}

// Pagination setup
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$initial_page = ($page - 1) * $num_per_page;

// Final query with pagination
$condition .= " LIMIT $initial_page, $num_per_page";

print_r($condition);

$stmt = $conn->prepare($condition);
if (!$stmt) {
     die("Query Error: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();

// Display products
if ($result->num_rows > 0) {
    
     $count = $result->num_rows;
     echo"<div class='text-right text-sm text-secondary my-3'>";
     echo $count." Items";
     echo"</div>";


     echo '<div class="row">';
    while ($product = $result->fetch_assoc()) {
         $product_id = base64_encode($product['product_id']);
         $discountPercentage = max(0, min(100, (float)$product['product_discount']));
         $originalPrice = max(0, (float)$product['product_price']);
         $quantity = $product['product_quantity'];
         $discountAmount = ($discountPercentage / 100) * $originalPrice;
         $discountedPrice = $originalPrice - $discountAmount;
        ?>
        <div class="col-md-3 col-sm-6">
            <div class="product-card">
                <a href="product-details.php?id=<?= htmlspecialchars($product_id); ?>">
                    <img src="<?= htmlspecialchars($product['product_image']); ?>" alt="<?= htmlspecialchars($product['product_name']); ?>" class="product-image">
                </a>
                <button id="<?= htmlspecialchars($product_id); ?>" class="share-button">
                    <i class="bi bi-share"></i>
                </button>
                <div class="rating-box px-2">
                    <i class="bi bi-star-fill text-warning"></i>
                    <span><?= htmlspecialchars($product['product_rating']); ?></span>
                    <i class="bi bi-heart-fill text-danger ms-2"></i>
                    <span><?= htmlspecialchars($product['product_likes']); ?></span>
                </div>
                <h3 class="px-2 product-title text-capitalize"><?= htmlspecialchars($product['product_name']); ?></h3>
                
                <div class="product-price px-2 d-flex justify-content-between">
                     <span>   
                          <i class='fa fa-naira-sign'></i>  
                          <?php if($discountPercentage > 0): ?>    
                               <?= htmlspecialchars($product['product_price'] * $quantity); ?>
                          <?php else: ?>
                                <?= htmlspecialchars($discountedPrice * $quantity); ?>
                          <?php endif; ?>

                     </span>

                     <span class='text-muted'>
                      
                          <?= htmlspecialchars($quantity). " Units"; ?>

                     </span>

                 </div>
            </div>
        </div>
        <?php
    }
    echo '</div>';
} else {
    echo "<p class='text-center'>No products found.</p>";
}
$stmt->close();

// Pagination Logic
$pageres = $conn->query("SELECT COUNT(*) as total FROM products WHERE sold = 0");
$numpage = $pageres->fetch_assoc()['total'];
$total_num_page = ceil($numpage / $num_per_page);

if ($total_num_page > 1) {
    echo "<div class='pagination mt-2 mb-4 text-center'>";
    
    if ($page > 1) {
        echo '<span id="page_num"><a class="btn-success prev" id="' . ($page - 1) . '">&lt;</a></span>';
    }

    for ($i = 1; $i <= $total_num_page; $i++) {
        if ($i == $page) {
            echo '<span id="page_num"><a class="btn-success active-button" id="' . $i . '">' . $i . '</a></span>';
        } else {
            echo '<span id="page_num"><a class="btn-success" id="' . $i . '">' . $i . '</a></span>';
        }
    }

    if ($page < $total_num_page) {
        echo '<span id="page_num"><a class="btn-success next" id="' . ($page + 1) . '">&gt;</a></span>';
    }

    echo "</div>";
}
?>
