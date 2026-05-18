<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../models/Listing.php';

$category_id = $_GET['category_id'] ?? '';

if ($category_id == '') {
    $listings = getActiveListings();
} else {
    $listings = getActiveListingsByCategory($category_id);
}

echo json_encode($listings);

?>