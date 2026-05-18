<?php

require_once __DIR__ . '/../config/database.php';

function getActiveListings() {
    global $conn;

    $sql = "SELECT listings.*, categories.name AS category_name,
            COUNT(bids.id) AS bid_count
            FROM listings
            LEFT JOIN categories ON listings.category_id = categories.id
            LEFT JOIN bids ON listings.id = bids.listing_id
            WHERE listings.status = 'active'
            AND listings.end_datetime > NOW()
            GROUP BY listings.id
            ORDER BY listings.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getActiveListingsByCategory($category_id) {
    global $conn;

    $sql = "SELECT listings.*, categories.name AS category_name,
            COUNT(bids.id) AS bid_count
            FROM listings
            LEFT JOIN categories ON listings.category_id = categories.id
            LEFT JOIN bids ON listings.id = bids.listing_id
            WHERE listings.status = 'active'
            AND listings.end_datetime > NOW()
            AND listings.category_id = ?
            GROUP BY listings.id
            ORDER BY listings.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$category_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchListings($keyword) {
    global $conn;

    $sql = "SELECT listings.*, categories.name AS category_name,
            COUNT(bids.id) AS bid_count
            FROM listings
            LEFT JOIN categories ON listings.category_id = categories.id
            LEFT JOIN bids ON listings.id = bids.listing_id
            WHERE listings.status = 'active'
            AND listings.end_datetime > NOW()
            AND listings.title LIKE ?
            GROUP BY listings.id
            ORDER BY listings.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute(["%$keyword%"]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getListingById($id) {
    global $conn;

    $sql = "SELECT listings.*, 
            categories.name AS category_name,
            users.name AS seller_name,
            users.email AS seller_email,
            COUNT(bids.id) AS bid_count
            FROM listings
            LEFT JOIN categories ON listings.category_id = categories.id
            LEFT JOIN users ON listings.seller_id = users.id
            LEFT JOIN bids ON listings.id = bids.listing_id
            WHERE listings.id = ?
            GROUP BY listings.id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateCurrentBid($listing_id, $amount) {
    global $conn;

    $sql = "UPDATE listings SET current_bid = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    return $stmt->execute([$amount, $listing_id]);
}

?>