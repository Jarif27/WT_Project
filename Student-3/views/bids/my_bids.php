<?php

require_once __DIR__ . '/../../models/Bid.php';
require_once __DIR__ . '/../../models/User.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {

    header("location: /Task-3/index.php");
    exit;
}

$buyer_id = $_SESSION['user_id'];

$myBids = getMyBids($buyer_id);

require_once __DIR__ . '/../partials/header.php';

?>

<h1>My Bids</h1>

<table>

    <thead>

        <tr>
            <th>Auction</th>
            <th>My Highest Bid</th>
            <th>Current Bid</th>
            <th>Status</th>
        </tr>

    </thead>

    <tbody>

        <?php foreach ($myBids as $row) { ?>

            <?php

                $statusText = "";
                $statusClass = "";

                if ($row['status'] == 'active') {

                    if ($row['my_highest_bid'] == $row['current_bid']) {

                        $statusText = "Leading";
                        $statusClass = "success";

                    } else {

                        $statusText = "Outbid";
                        $statusClass = "danger";
                    }

                } else {

                    if (
                        $row['reserve_price'] != null &&
                        $row['current_bid'] < $row['reserve_price']
                    ) {

                        $statusText = "Reserve Not Met";
                        $statusClass = "danger";

                    } else {

                        $winner = getWinnerBid($row['winner_bid_id']);

                        if (
                            $winner &&
                            $winner['buyer_id'] == $buyer_id
                        ) {

                            $statusText = "🏆 You Won!";
                            $statusClass = "success";

                        } else {

                            $statusText = "Lost";
                            $statusClass = "danger";
                        }
                    }
                }

            ?>

            <tr>

                <td>

                    <a href="/Task-3/views/auctions/detail.php?id=<?php echo $row['listing_id']; ?>">

                        <?php echo $row['title']; ?>

                    </a>

                </td>

                <td>

                    $<?php echo $row['my_highest_bid']; ?>

                </td>

                <td>

                    $<?php echo $row['current_bid']; ?>

                </td>

                <td>

                    <span class="<?php echo $statusClass; ?>">

                        <?php echo $statusText; ?>

                    </span>

                    <?php
                        if ($statusText == "🏆 You Won!") {
                    ?>

                        <div style="margin-top:10px;">

                            Seller:
                            <?php echo $row['seller_name']; ?>

                            <br>

                            Contact:
                            <?php echo $row['seller_email']; ?>

                        </div>

                    <?php } ?>

                </td>

            </tr>

        <?php } ?>

    </tbody>

</table>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>