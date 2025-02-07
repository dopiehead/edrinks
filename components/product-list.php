
    <div class="container py-4">
        <!-- Header -->
        <h1 class="text-center mb-3" style="color: var(--primary-purple)">Trending deals for your bulk request</h1>
        <p class="text-center mb-4">Where do you want to hold the event?</p>

        <!-- Location Select -->
        <div class="mb-3">
            <select class="location-select">
                <option>Ikeja Lagos</option>

            </select>
        </div>

        <!-- Search Bar -->
        <div class="search-container mb-4">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="fas fa-wine-bottle"></i>
                </span>
                <input type="text" class="form-control" placeholder="Search a kind of drink">
                <button class="btn btn-outline-secondary" type="button">Search</button>
            </div>
        </div>

        <?php
              require("engine/config.php");
              $stmt = $conn->prepare("SELECT * FROM products");
              $stmt->execute();
              $result = $stmt->get_result();
              if ($result) { 
         ?>
                   <div class="row">        
         <?php 
                  while ($product = $result->fetch_assoc()) {
        
                      include("contents/product-contents.php");
         ?>
            <!-- Product Card 1 -->
            <div class="col-md-3">
                <div class="product-card position-relative">
                     <div class="d-flex justify-content-between position-absolute w-100 p-2">
                         <span class='text-primary fa fa-eye'> <?php echo htmlspecialchars($product_views); ?></span>
                          <span class='text-danger fa fa-heart'> <?php echo htmlspecialchars($product_likes); ?></span>
                     </div>
                     <a href='product-details.php?id=<?php echo htmlspecialchars (base64_encode($product_id)); ?>'><img src="<?php echo htmlspecialchars($product_image); ?>" class="product-image w-100" alt="Hands Up Bottle"></a>
                    <div class="p-3">
                        <h5 class='text-capitalize fw-bold'><?php echo htmlspecialchars($product_name); ?> -Bottle</h5>
                        <div class="star-rating">
                            ★★★☆☆
                        </div>
                        <p class="text-muted"><i class='fa fa-naira-sign'></i><?php echo htmlspecialchars($product_price); ?>/per crate</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="quantity-control">
                                 <div class='d-flex gap-1'>
                                     <button class="quantity-btn border-0" onclick="subtract(this)" id="subtractBtn" disabled>-</button>
                                     <input type="number" class="quantity-input w-25 border border-1 border-primary" value="1" min="1" onchange="checkValue(this)">
                                     <button class="quantity-btn border-0" onclick="add(this)">+</button> </div>
                            </div>
                            <button class=" btn btn-primary text-white buy-button">Buy</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php

             }
         }

                $stmt->close();
         ?>

            <!-- Add two more product cards to complete the row -->
            <!-- Product Cards 3 & 4 with the same structure -->
        </div>

        <!-- See More Button -->
        <div class="text-end mt-3">
            <button class="see-more">see more</button>
        </div>
    </div>
    <br><br>
