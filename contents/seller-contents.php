<?php 
$seller_details = $seller['id'] ?? null;
$seller_details_name = $seller['user_name'] ?? 'N/A';
$seller_details_email = $seller['user_email'] ?? 'N/A';
$seller_details_type = $seller['user_type'] ?? 'N/A';
$seller_details_image = $seller['user_image'] ?? 'default.jpg'; // Default image if not available
$seller_details_phone = $seller['user_phone'] ?? 'N/A';
$seller_details_location = $seller['user_location'] ?? 'Unknown';
$seller_details_address = $seller['user_address'] ?? 'Unknown';
$seller_details_rating = $seller['user_rating'] ?? 0; // Default rating to 0
$seller_details_verified = $seller['verified'] ?? 0; // Default to unverified
$seller_details_date_added = $seller['date_added'] ?? date("Y-m-d H:i:s");
?>