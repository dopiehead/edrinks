<?php
// Product Details
      $product_id = $product['product_id'];
      $poster_id = $product['poster_id'];
      $product_name = $product['product_name'];
      $product_rating = $product['product_rating'];
      $product_price = $product['product_price'];
      $product_image = $product['product_image'];
      $product_details = $product['product_details'];
      $product_category = $product['product_category'];
      $product_location = $product['product_location'];
      $product_address = $product['product_address'];
      $product_color = $product['product_color'];
      $quantity_sold = $product['quantity_sold'];
      $gift_picks = $product['gift_picks'];
      $sold = $product['sold'];
      $product_views = $product['product_views'];
      $product_likes = $product['product_likes'];
      $discountPercentage = max(0, min(100, (float)$product['product_discount']));
      $originalPrice = max(0, (float)$product['product_price']);
      $quantity = $product['product_quantity'];
      $discountAmount = ($discountPercentage / 100) * $originalPrice;
      $discountedPrice = $originalPrice - $discountAmount;
      $featured_product = $product['featured_product'];
      $product_date = $product['product_date'];

?>

