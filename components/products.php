    <?php require ("engine/config.php"); ?>
    <div class="container">
        <!-- Filters -->
        <div class="filters-section">
            <div class="d-flex flex-wrap align-items-center">
                <select name='categories' class="filter-button">
                     <option value="">All Categories</option>
                     <option value="wholesale">Wholesale</option>
                     <option value="imported">Imported</option>
                     <option value="manufacturer">Manufacturer</option>
                </select>

                <select name='price_range' class="filter-button">
                     <option value="10000-50000">Less than  <i class='fa fa-naira-sign'></i>50000</option>
                     <option value="50000 - 100000">Less than <i class='fa fa-naira-sign'></i>100000</option>
                     <option value="100000 - 500000">Less than <i class='fa fa-naira-sign'></i>500000</option>
                     <option value="500000 - 1000000">Less than <i class='fa fa-naira-sign'></i>1000000</option>
                </select>


                 <?php 

                      $get_drink = $conn->prepare("SELECT COUNT(*) AS count, product_name FROM products GROUP BY product_name");

                      $get_drink->execute();

                      $result = $get_drink->get_result();
                 ?>

                 <select name='brands' class="filter-button">

                      <option value="">Brand</option>

                 <?php while ($brand = $result->fetch_assoc()) { ?>

                      <option value="<?php echo htmlspecialchars($brand['product_name']); ?>">

                  <?php echo htmlspecialchars($brand['product_name']) . " (" . htmlspecialchars($brand['count']) . ")"; ?>

                      </option>

                 <?php } ?>

                 </select>


                <select name='drink_type' class="filter-button">
                      <option value="">Drink Type</option>
                      <option value="soft drink">Soft drink</option>
                      <option value="">Alcoholic</option>
                      <option value="">Non-alcoholic</option>                
                </select>

                <span class="ms-auto items-count">24 items</span>
            </div>
        </div>

       
        <!-- Products Grid -->
        <?php

             require("engine/config.php");
             $stmt = $conn->prepare("SELECT * FROM products");
             $stmt->execute();

             $result = $stmt->get_result();
   
             if ($result) { ?>

                 <div class="row">

         <?php 
                 while ($product = $result->fetch_assoc()) {
        
                      include("contents/product-contents.php");
         ?>

        <!-- Product Card 1 -->
        <div class="col-md-3 col-sm-6">
            <div class="product-card">
                <a href='product-details.php?id=<?php echo htmlspecialchars (base64_encode($product_id)); ?>'><img src="<?php echo htmlspecialchars($product_image); ?>" alt="Coca-Cola" class="product-image"></a>
                <button id='<?php echo htmlspecialchars (base64_encode($product_id)); ?>' class="share-button">
                    <i class="bi bi-share"></i>
                </button>
                <div class="rating-box px-2">
                    <i class="bi bi-star-fill text-warning"></i>
                    <span><?php echo htmlspecialchars($product_rating); ?></span>
                    <i class="bi bi-heart-fill text-danger ms-2"></i>
                    <span><?php echo htmlspecialchars($product_likes); ?></span>
                </div>
                <h3 class="px-2 product-title text-capitalize"><?php echo htmlspecialchars($product_name); ?></h3>
                <div class="product-price px-2"><i class='fa fa-naira-sign'></i><?php echo htmlspecialchars($product_price); ?></div>
            </div>
        </div>
    <?php

    }
    }

    // Close the statement
    $stmt->close();
?>


            <!-- Add more product cards here -->
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
