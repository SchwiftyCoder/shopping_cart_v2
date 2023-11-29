<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the product_id is provided in the form data
    if (isset($_POST["product_id"]) && !empty($_POST["product_id"])) {
        // Get the product_id from the form data
        $product_id = $_POST["product_id"];

        // Check if the product exists in the session
        if (isset($_SESSION["cart"][$product_id])) {
            // Get the quantity from the session
            $quantity_in_session = $_SESSION["cart"][$product_id]["quantity"];

            // Update the quantity in the database
            $update_query = "UPDATE inventory SET quantity = quantity + $quantity_in_session WHERE id = $product_id";

            // Execute the update query
            if (mysqli_query($db_connection, $update_query)) {
                // Quantity updated successfully
                echo "Quantity updated successfully.";
            } else {
                // Failed to update quantity
                echo "Error updating quantity: " . mysqli_error($db_connection);
            }

            // Remove the product from the session
            unset($_SESSION["cart"][$product_id]);
        } else {
            // Product not found in the session
            echo "Product not found in the cart.";
        }
    }

    // Clear the entire session
    session_destroy();
    header('Location: cart_v2.php');
}
?>
