<?php

session_start();

require_once __DIR__ . '/../models/Listing.php';
require_once __DIR__ . '/../models/Bid.php';

function placeBid() {
    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        echo json_encode([
            "ok" => false,
            "error" => "Please login first"
        ]);
        exit;
    }

    $buyer_id = $_SESSION['user_id'];

    $listing_id = $_POST['listing_id'] ?? '';
    $amount = $_POST['amount'] ?? '';

    if ($listing_id == '' || $amount == '') {
        echo json_encode([
            "ok" => false,
            "error" => "All fields are required"
        ]);
        exit;
    }

    if (!is_numeric($amount) || $amount <= 0) {
        echo json_encode([
            "ok" => false,
            "error" => "Bid amount must be positive"
        ]);
        exit;
    }

    $listing = getListingById($listing_id);

    if (!$listing) {
        echo json_encode([
            "ok" => false,
            "error" => "Auction not found"
        ]);
        exit;
    }

    if ($listing['status'] != 'active') {
        echo json_encode([
            "ok" => false,
            "error" => "Auction is not active"
        ]);
        exit;
    }

    if (strtotime($listing['end_datetime']) <= time()) {
        echo json_encode([
            "ok" => false,
            "error" => "Auction has expired"
        ]);
        exit;
    }

    if ($buyer_id == $listing['seller_id']) {
        echo json_encode([
            "ok" => false,
            "error" => "You cannot bid on your own auction"
        ]);
        exit;
    }

    if ($amount <= $listing['current_bid']) {
        echo json_encode([
            "ok" => false,
            "error" => "Bid must be greater than current bid"
        ]);
        exit;
    }

    insertBid($listing_id, $buyer_id, $amount);
    updateCurrentBid($listing_id, $amount);

    $bid_count = getBidCount($listing_id);

    echo json_encode([
        "ok" => true,
        "new_bid" => $amount,
        "bid_count" => $bid_count,
        "bidder_name" => $_SESSION['name'] ?? 'You',
        "time" => date("Y-m-d H:i:s")
    ]);
    exit;
}

?>