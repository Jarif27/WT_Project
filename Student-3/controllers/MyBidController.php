<?php

require_once __DIR__ . '/../models/Bid.php';
require_once __DIR__ . '/../models/User.php';

function myBidsPage() {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("location: ../../index.php");
        exit;
    }

    $buyer_id = $_SESSION['user_id'];
    $myBids = getMyBids($buyer_id);

    require_once __DIR__ . '/../views/bids/my_bids.php';
}

?>