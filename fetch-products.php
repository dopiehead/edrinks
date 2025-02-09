<?php
require __DIR__ . '/engine/config.php';  // Ensure this file exists

$num_per_page = 4;  // Define the number of products per page
$condition = "SELECT * FROM products WHERE sold = 0";


if (isset($_POST['search']) && !empty($_POST['search'])) {

     $search = explode(" ",$conn->real_escape_string($_POST['search'])) ;

      foreach($search as $text) {

          $condition .= " AND (`product_name` LIKE '%".$text."%' OR `product_category` LIKE '%".$text."%' OR `product_location` LIKE '%".$text."%' OR `product_details` LIKE '%".$text."%' OR `product_location` LIKE '%".$text."%' OR `product_address` LIKE '%".$text."%')";

    } 
}


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


if (isset($_POST['product_location']) && !empty($_POST['product_location'])) {
    $product_location = explode(" ", $_POST['product_location']);
   foreach ($product_location as $location) {
        $condition .= " AND product_location LIKE '%" . $conn->real_escape_string($location) . "%' OR product_address LIKE '%" . $conn->real_escape_string($location). "%'";
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
                <button id="<?= base64_decode(htmlspecialchars($product_id)); ?>" class="share-button open-share-popup">
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

<!-- Share Popup -->
<div id="popup-share" class="popup-share position-fixed top-50 start-50 translate-middle bg-white shadow-lg rounded-4 p-4" style="display: none; max-width: 350px; width: 90%; height:400px;">
    <!-- Close Button -->
    <span class="close-popup position-absolute top-0 end-0 me-3 mt-2 fs-3 text-danger" style="cursor: pointer;">&times;</span>

    <!-- Share Content -->
    <div class="popup-inner d-flex flex-column align-items-center text-center">
        <h4 class="text-dark fw-bold mb-3">Share This Product</h4>

        <div class="d-flex flex-column gap-3 w-100">
            <a id="share-facebook" target="_blank" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-facebook"></i> Share on Facebook
            </a>
            <a id="share-twitter" target="_blank" class="btn btn-info text-white w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-twitter"></i> Share on Twitter
            </a>
            <a id="share-linkedin" target="_blank" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-linkedin"></i> Share on LinkedIn
            </a>
            <button id="copy-link" class="btn btn-secondary w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-clipboard"></i> Copy Link
            </button>
        </div>
    </div>
</div>

<!-- jQuery & Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const sharePopup = $("#popup-share");
        const closePopup = $(".close-popup");
        const openPopupBtn = $(".open-share-popup");
        const copyLinkBtn = $("#copy-link");

        // Open and close popup with smooth animation
        openPopupBtn.on("click", function () {
            sharePopup.fadeIn(300).css("display", "flex");
        });

        closePopup.on("click", function () {
            sharePopup.fadeOut(300);
        });

        $(window).on("click", function (e) {
            if ($(e.target).is(sharePopup)) sharePopup.fadeOut(300);
        });

        // Dynamic Share Links
        const productURL = encodeURIComponent(window.location.href);
        $("#share-facebook").attr("href", `https://www.facebook.com/sharer/sharer.php?u=${productURL}`);
        $("#share-twitter").attr("href", `https://twitter.com/intent/tweet?url=${productURL}`);
        $("#share-linkedin").attr("href", `https://www.linkedin.com/sharing/share-offsite/?url=${productURL}`);

        // Copy to Clipboard with Tooltip
        copyLinkBtn.on("click", function () {
            navigator.clipboard.writeText(window.location.href).then(() => {
                copyLinkBtn.text("Copied! ✅").addClass("btn-success").removeClass("btn-secondary");
                setTimeout(() => {
                    copyLinkBtn.text("Copy Link").removeClass("btn-success").addClass("btn-secondary");
                }, 2000);
            });
        });
    });
</script>

<!-- Bootstrap 5 & Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
