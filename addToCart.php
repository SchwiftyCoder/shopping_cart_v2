<?php

include 'config/database_connection.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ensure that the inventory ID is provided
    if (isset($_POST["product_id"])) {
        // Get the inventory ID and quantity from the form
        $inventory_id = $_POST["product_id"]; 

        // Check if the product ID exists in the cart table
        $check_cart_query = "SELECT id FROM cart WHERE inventory_id = $inventory_id";
        $check_cart_result = mysqli_query($db_connection, $check_cart_query);

        if (mysqli_num_rows($check_cart_result) > 0) {
            // If the product ID already exists in the cart, update the quantity instead of adding a new row
            $update_quantity_query = "UPDATE cart SET quantity = quantity + 1 WHERE inventory_id = $inventory_id";
            $update_quantity_result = mysqli_query($db_connection, $update_quantity_query); 
        } else {
            // If the product ID does not exist in the cart, insert a new row
            $inventory_to_cart_move = "INSERT INTO cart (inventory_id, name, price, quantity, image_url)
                        SELECT id, name, price, 1, image_url FROM inventory WHERE id = $inventory_id;";
            $inventory_cart_move_query = mysqli_query($db_connection, $inventory_to_cart_move);
        }
        
        $update_inventory = "UPDATE inventory SET quantity = quantity - 1 WHERE id = $inventory_id";
        
        //decrease quantity in inventory
        $update_inventory_query = mysqli_query($db_connection, $update_inventory);

        //redirect to the cart page
        header('Location: cart.php');

        // Close the database connection
        mysqli_close($db_connection);
    } else {
        echo "Invalid input data.";
    }
}


?>