<?php
$page_title = "Cart";
include 'header.php';

?>

<section id="cart">
    <h2>Shopping Cart</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Picture</th>
            <th>Quanity</th>
            <th>Price (each)</th>
        </tr>
        <?php
        //dynamically create rows of cart items
        $select_query = "SELECT * FROM cart";
        $result_set = mysqli_query($db_connection, $select_query);

        //Loop through the result set to fetch each row
        $cart_total = 0.0;
        if (mysqli_num_rows($result_set) > 0) {
            while ($row = mysqli_fetch_assoc($result_set)) {
                // Access each row's data 
                $name = $row['name'];
                $image_url = $row['image_url']; 
                $quantity = $row['quantity'];
                $price = $row['price'];

                //compute the total dollar cost of items in the cart
                $cart_total += ($quantity * $price);

                echo '<tr>
                    <td>' . $name . '</td> 
                    <td><img src="' . $image_url . '" alt="' . $name . '" class="cart-image"></td> 
                    <td>' . $quantity . '</td> 
                    <td>' . $price . '</td> 
                    </tr>';
            
            }
        } else {
            echo "No items placed in cart at this time";
        }
        ?> 

        <tr class="total-row">
            <td colspan="3">Total</td>
            <td>&dollar;<?php echo $cart_total ;?></td>
        </tr>
        <tr id="right">
            <td colspan="4">
                <div id="clear_cart" class="inline-div">
                    <form action="clear_cart.php" method="post">
                        <input type="submit" name="clear_cart" value="Clear Cart">
                    </form>
                </div>
                <div class="checkout inline-div">
                    <form action="orders.php" method="post">
                        <input type="submit" name="checkout" value="Checkout" <?php if($total_items_in_cart == 0) echo 'disabled' ;?>>
                    </form>
                </div>
            </td>
        </tr>
    </table>
</section>


<?php
include 'footer.php';
?>