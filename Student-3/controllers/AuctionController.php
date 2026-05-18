<?php

require_once __DIR__ . '/../models/Listing.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Bid.php';

function browsePage() {
    $categories = getAllCategories();
    $listings = getActiveListings();

    require_once __DIR__ . '/../views/auctions/browse.php';
}

function detailPage($id) {
    $listing = getListingById($id);

    if (!$listing) {
        die("Auction not found");
    }

    $bids = getLastTenBids($id);

    require_once __DIR__ . '/../views/auctions/detail.php';
}

?>