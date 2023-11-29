<?php
include 'config/database_connection.php';
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
            <!-- <li><a href="index.php"><img src="your-logo.png" alt="Squanchy Superstore Logo" class="store-logo"></a></li> -->
            <li><a href="index.php" class="store-name">Squanchy Superstore</a></li>
            <li><a href="index.php">Products</a></li>
            </li>
            <!-- <li><a href="orders.php">Orders</a></li> -->
            <li><a href="cart.php">Cart(<?php
                                        $total_items_in_cart = 0;
                                        // Query to get the total rows in the "cart" table
                                        $cart_total = "SELECT SUM(quantity) AS total_quantity FROM cart";
                                        $result = $db_connection->query($cart_total);

                                        if ($result) {
                                            // Fetch the result row as an associative array
                                            $row = mysqli_fetch_assoc($result);

                                            // Get the total rows from the "total_rows" column
                                            $total_items_in_cart = $row['total_quantity'];

                                            // Close the result set
                                            $result->close();

                                            // Close the database connection (if not needed further)
                                            // $db_connection->close();
                                        } else {
                                            echo "Error executing the query: " . $db_connection->error;
                                        }
                                        echo $total_items_in_cart;
                                        ?>)</a>
            </li>
        </ul>
    </nav>

    <script>
    // hide 000webhost banner from this js 
window.onload = () => {
    let bannerNode = document.querySelector('[alt="www.000webhost.com"]').parentNode.parentNode;
    bannerNode.parentNode.removeChild(bannerNode);
}
</script>