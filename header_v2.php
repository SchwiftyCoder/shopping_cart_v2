<?php
session_start();
include 'config/database_connection.php';

// Calculate the total items in the cart from the session data
$total_items_in_cart = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product) {
        $total_items_in_cart += $product['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?></title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php" class="store-name">Squanchy Superstore</a></li>
            <li><a href="index.php">Products</a></li>
            <li><a href="cart.php">Cart(<?php echo $total_items_in_cart; ?> items)</a></li>
        </ul>
    </nav>


    <script>
        // hide 000webhost banner from this js 
        window.onload = () => {
            let bannerNode = document.querySelector('[alt="www.000webhost.com"]').parentNode.parentNode;
            bannerNode.parentNode.removeChild(bannerNode);
        }
    </script>