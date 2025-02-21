<?php 

$user_id = $user['id'] ?? null;
$user_name = $user['user_name'] ?? 'N/A';
$user_email = $user['user_email'] ?? 'N/A';
$user_type = $user['user_type'] ?? 'N/A';
$user_image = $user['user_image'] ?? 'default.jpg'; // Default image if not available
$user_phone = $user['user_phone'] ?? 'N/A';
$user_location = $user['user_location'] ?? 'Unknown';
$user_address = $user['user_address'] ?? 'Unknown';
$user_rating = $user['user_rating'] ?? 0; // Default rating to 0
$verified = $user['verified'] ?? 0; // Default to unverified
$date_added = $user['date_added'] ?? date("Y-m-d H:i:s"); // Use current date if missing
?>
