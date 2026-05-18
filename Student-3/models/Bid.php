<?php

require_once __DIR__ . '/../config/database.php';

function insertBid($listing_id, $buyer_id, $amount) {

    global $conn;

    $sql = "INSERT INTO bids
            (listing_id, buyer_id, amount, created_at)
            VALUES (?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        $listing_id,
        $buyer_id,
        $amount
    ]);
}

function getBidCount($listing_id) {

    global $conn;

    $sql = "SELECT COUNT(*) AS total
            FROM bids
            WHERE listing_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->execute([$listing_id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row['total'];
}

function getLastTenBids($listing_id) {

    global $conn;

    $sql = "SELECT bids.*,
            users.name AS bidder_name

            FROM bids

            INNER JOIN users
            ON bids.buyer_id = users.id

            WHERE bids.listing_id = ?

            ORDER BY bids.created_at DESC

            LIMIT 10";

    $stmt = $conn->prepare($sql);

    $stmt->execute([$listing_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getBuyerHighestBid($listing_id, $buyer_id) {

    global $conn;

    $sql = "SELECT MAX(amount) AS highest_bid
            FROM bids
            WHERE listing_id = ?
            AND buyer_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        $listing_id,
        $buyer_id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getMyBids($buyer_id) {

    global $conn;

    $sql = "SELECT 
                listings.id AS listing_id,
                listings.title,
                listings.current_bid,
                listings.status,
                listings.winner_bid_id,
                listings.reserve_price,
                listings.end_datetime,

                users.name AS seller_name,
                users.email AS seller_email,

                MAX(bids.amount) AS my_highest_bid

            FROM bids

            INNER JOIN listings
            ON bids.listing_id = listings.id

            INNER JOIN users
            ON listings.seller_id = users.id

            WHERE bids.buyer_id = ?

            GROUP BY listings.id

            ORDER BY listings.created_at DESC";

    $stmt = $conn->prepare($sql);

    $stmt->execute([$buyer_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getWinnerBid($winner_bid_id) {

    global $conn;

    $sql = "SELECT bids.*,

            users.name AS winner_name,
            users.email AS winner_email

            FROM bids

            INNER JOIN users
            ON bids.buyer_id = users.id

            WHERE bids.id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->execute([$winner_bid_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>