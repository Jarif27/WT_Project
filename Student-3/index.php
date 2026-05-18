<?php

session_start();

require_once __DIR__ . '/controllers/AuctionController.php';
require_once __DIR__ . '/controllers/MyBidController.php';

$page = $_GET['page'] ?? 'browse';
$id = $_GET['id'] ?? null;

switch ($page) {

    case 'browse':
        browsePage();
        break;

    case 'detail':
        if ($id) {
            detailPage($id);
        } else {
            echo "Auction ID missing";
        }
        break;

    case 'my_bids':
        myBidsPage();
        break;

    default:
        browsePage();
        break;
}
?>