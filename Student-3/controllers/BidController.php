<?php

session_start();

require_once __DIR__ . '/../models/Listing.php';
require_once __DIR__ . '/../models/Bid.php';

function placeBid() {
    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["ok" => false, "error" => "Login required"]);
        exit;
    }

    $buyer_id = $_SESSION['user_id'];
    $listing_id = $_POST['listing_id'];
    $amount = $_POST['amount'];

    $listing = getListingById($listing_id);

    if (!$listing) {
        echo json_encode(["ok" => false, "error" => "Auction not found"]);
        exit;
    }

    if ($amount <= $listing['current_bid']) {
        echo json_encode(["ok" => false, "error" => "Bid must be higher"]);
        exit;
    }

    if ($listing['seller_id'] == $buyer_id) {
        echo json_encode(["ok" => false, "error" => "Cannot bid your own item"]);
        exit;
    }

    if (strtotime($listing['end_datetime']) < time()) {
        echo json_encode(["ok" => false, "error" => "Auction ended"]);
        exit;
    }

    insertBid($listing_id, $buyer_id, $amount);
    updateCurrentBid($listing_id, $amount);

    $count = getBidCount($listing_id);

    echo json_encode([
        "ok" => true,
        "new_bid" => $amount,
        "bid_count" => $count,
        "bidder_name" => $_SESSION['name']
    ]);
}

?>