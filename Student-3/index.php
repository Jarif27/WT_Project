<?php

session_start();

/*
Demo login.
Task 1 login system merge করার আগে test করার জন্য।
Buyer Sarah = user id 3.ss
*/
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 3;
    $_SESSION['name'] = "Buyer Sarah";
    $_SESSION['seller_verified'] = 0;
}

require_once __DIR__ . '/controllers/AuctionController.php';

browsePage();

?>