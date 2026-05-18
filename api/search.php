<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../models/Listing.php';

$q = $_GET['q'] ?? '';

$listings = searchListings($q);

echo json_encode($listings);

?>