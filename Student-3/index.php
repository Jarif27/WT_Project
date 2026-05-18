<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['name'] = "Demo User";
}

require_once __DIR__ . '/models/Listing.php';

$listings = getActiveListings();

?>

<?php include "views/partials/header.php"; ?>

<h1>Auction Browse</h1>

<div class="listing-grid">

<?php foreach ($listings as $l) { ?>

    <div class="auction-card">
        <h3><?= $l['title'] ?></h3>
        <p>Category: <?= $l['category_name'] ?></p>
        <p>Bid: $<?= $l['current_bid'] ?></p>

        <a href="views/auctions/detail.php?id=<?= $l['id'] ?>" class="btn">
            View
        </a>
    </div>

<?php } ?>

</div>

<?php include "views/partials/footer.php"; ?>