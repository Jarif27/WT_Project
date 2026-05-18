<?php

require_once __DIR__ . '/../config/database.php';

function getActiveListings() {
    global $conn;

    $sql = "SELECT listings.*, categories.name AS category_name
            FROM listings
            LEFT JOIN categories ON listings.category_id = categories.id
            WHERE listings.status = 'active'
            AND listings.end_datetime > NOW()
            ORDER BY listings.created_at DESC";

    return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function getListingById($id) {
    global $conn;

    $sql = "SELECT listings.*, 
            categories.name AS category_name,
            users.name AS seller_name,
            users.email AS seller_email
            FROM listings
            LEFT JOIN categories ON listings.category_id = categories.id
            LEFT JOIN users ON listings.seller_id = users.id
            WHERE listings.id = ?";

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