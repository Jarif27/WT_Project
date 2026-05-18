<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Auction System</title>

    <link rel="stylesheet" href="/Task-3/Student-3/public/css/style.css">
</head>
<body>

<div class="navbar">

    <h2>Online Auction</h2>

    <div>

        <a href="/Task-3/Student-3/index.php?page=browse">
            Browse Auctions
        </a>

        <a href="/Task-3/Student-3/index.php?page=my_bids">
            My Bids
        </a>

        <?php if (isset($_SESSION['user_id'])) { ?>

            <span class="user-text">
                Hi, <?php echo $_SESSION['name']; ?>
            </span>

            <a href="/Task-3/Student-3/logout.php">
                Logout
            </a>

        <?php } else { ?>

            <span class="user-text">
                Demo Login Active
            </span>

        <?php } ?>

    </div>

</div>

<div class="container">