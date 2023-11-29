<?php
// Start the session
//session_start();
$page_title = "Cart";
include 'header_v2.php';


?>

<section id="cart">
    <h2>Shopping Cart</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Picture</th>
            <th>Quantity</th>
            <th>Price (each)</th>
        </tr>
        <?php
        $cart_total = 0.0;
        $has_items_in_cart = false; // Flag to track if there are items in the cart

        // Check if the cart session variable is set and not empty
        if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
            // Loop through the cart session data and display each item
            foreach ($_SESSION["cart"] as $product_id => $product) {
                $name = $product["name"];
                $image_url = $product["image_url"];
                $quantity = $product["quantity"];
                $price = $product["price"];

                // Compute the total dollar cost of items in the cart
                $cart_total += ($quantity * $price);

                echo '<tr>
                    <td>' . $name . '</td>
                    <td><img src="' . $image_url . '" alt="' . $name . '" class="cart-image"></td>
                    <td>' . $quantity . '</td>
                    <td>' . $price . '</td>
                </tr>';

                $has_items_in_cart = true; // Set the flag to true since there are items in the cart
            }
        } else {
            echo '<tr><td colspan="4">No items placed in cart at this time</td></tr>';
        }
        ?>

        <tr class="total-row">
            <td colspan="3">Total</td>
            <td>&dollar;<?php echo $cart_total; ?></td>
        </tr>
        <tr id="right">
            <td colspan="4">
                <div id="clear_cart" class="inline-div">
                    <form action="clear_cart_v2.php" method="post">
                        <input type="submit" name="clear_cart" value="Clear Cart" <?php if (!$has_items_in_cart) echo 'disabled'; ?>>
                    </form>
                </div>
                <div class="checkout inline-div">
                    <form action="checkout_v2.php" method="post">
                        <input type="submit" name="checkout" value="Checkout" <?php if (empty($_SESSION["cart"])) echo 'disabled'; ?>>
                    </form>
                </div>
            </td>
        </tr>
    </table>
</section>

<?php
include 'footer.php';
?>
