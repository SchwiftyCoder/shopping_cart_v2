<?php
$page_title = "Home";
include 'header_v2.php';

?>
<section id="products">
    <h2>Products</h2>
    <?php
    //Execute an SQL query to fetch the data from the "inventory" table
    $select_query = "SELECT * FROM inventory";
    $result_set = mysqli_query($db_connection, $select_query);

    // Step 3: Loop through the result set to fetch each row
    if (mysqli_num_rows($result_set) > 0) {
        while ($row = mysqli_fetch_assoc($result_set)) {
            // Access each row's data
            $id = $row['id'];
            $name = $row['name'];
            $quantity = $row['quantity'];
            $price = $row['price'];
            $image_url = $row['image_url'];
            $description = $row['description'];


            echo '<div class="product">
            <img src="' . $image_url . '" alt="Product 1">
            <h3>' . $name . '</h3>
            <p>Price: &dollar;' . $price . '</p>';
            if ($quantity > 0) {
                echo '<p>Availability: In stock</p>
                        <form action="add_to_cart.php" method="post">
                        <input type="hidden" name="product_id" value="' . $id . '"> 
                        <input type="submit" value="Add to Cart">
                    </form>
                    </div>';
            } else {
                echo '<p class="out-of-stock">Availability: Out of stock</p>
                        <form> 
                        <input type="submit" value="Add to Cart" disabled>
                    </form>
                    </div>';
            }
        }
    } else {
        echo "No data found in the inventory.";
    }

    // Close the connection
    // mysqli_close($db_connection);
    ?>

</section>



<?php
include 'footer.php';
?>