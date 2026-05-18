<?php

require_once __DIR__ . '/../../models/Listing.php';
require_once __DIR__ . '/../../models/Bid.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id = $_GET['id'] ?? 0;

$listing = getListingById($id);

if (!$listing) {
    die("Auction not found");
}

$bids = getLastTenBids($id);

$winner = null;

if ($listing['winner_bid_id']) {
    $winner = getWinnerBid($listing['winner_bid_id']);
}

require_once __DIR__ . '/../partials/header.php';

?>

<h1><?php echo $listing['title']; ?></h1>

<div class="detail-box">

    <img class="detail-img"
         src="/Task-3/public/uploads/<?php echo $listing['image_path']; ?>"
         alt="Auction Image">

    <div>

        <p>
            <strong>Description:</strong>
            <?php echo $listing['description']; ?>
        </p>

        <p>
            <strong>Seller:</strong>
            <?php echo $listing['seller_name']; ?>
        </p>

        <p>
            <strong>Category:</strong>
            <?php echo $listing['category_name']; ?>
        </p>

        <p>
            <strong>Current Highest Bid:</strong>

            $<span id="currentBid">
                <?php echo $listing['current_bid']; ?>
            </span>
        </p>

        <p>
            <strong>Bid Count:</strong>

            <span id="bidCount">
                <?php echo $listing['bid_count']; ?>
            </span>
        </p>

        <p>
            <strong>Time Remaining:</strong>

            <span class="countdown"
                  data-end="<?php echo $listing['end_datetime']; ?>">
            </span>
        </p>

        <?php if (
            $listing['status'] == 'active' &&
            strtotime($listing['end_datetime']) > time()
        ) { ?>

            <div class="bid-box">

                <input type="number"
                       id="bidAmount"
                       placeholder="Enter your bid amount">

                <input type="hidden"
                       id="listingId"
                       value="<?php echo $listing['id']; ?>">

                <button id="placeBidBtn">
                    Place Bid
                </button>

                <p id="bidMessage"></p>

            </div>

        <?php } else { ?>

            <p class="ended">
                Auction Ended
            </p>

            <?php if (
                $listing['reserve_price'] != null &&
                $listing['current_bid'] < $listing['reserve_price']
            ) { ?>

                <p class="danger">
                    Reserve Not Met
                </p>

            <?php } else { ?>

                <?php if ($winner) { ?>

                    <p class="success">
                        Winner:
                        <?php echo $winner['winner_name']; ?>
                    </p>

                <?php } ?>

            <?php } ?>

        <?php } ?>

    </div>

</div>

<h2>Bid History</h2>

<table>

    <thead>
        <tr>
            <th>Bidder</th>
            <th>Amount</th>
            <th>Time</th>
        </tr>
    </thead>

    <tbody id="bidHistory">

        <?php foreach ($bids as $bid) { ?>

            <tr>

                <td>
                    <?php echo $bid['bidder_name']; ?>
                </td>

                <td>
                    $<?php echo $bid['amount']; ?>
                </td>

                <td>
                    <?php echo $bid['created_at']; ?>
                </td>

            </tr>

        <?php } ?>

    </tbody>

</table>

<script src="/Task-3/public/js/bid.js"></script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>