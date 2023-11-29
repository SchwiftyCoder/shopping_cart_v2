<?php
session_start();
include 'config/database_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the product_id is provided in the form data
    if (isset($_POST["product_id"]) && !empty($_POST["product_id"])) {
        // Get the product_id from the form data
        $product_id = $_POST["product_id"];

        // Fetch product details from the database based on the product_id
        // Assuming you have a database connection established

        // Execute a query to get the product details based on the $product_id
        $select_query = "SELECT * FROM inventory WHERE id = $product_id";
        $result_set = mysqli_query($db_connection, $select_query);

        if ($result_set) {
            // Check if the product exists in the inventory
            if (mysqli_num_rows($result_set) > 0) {
                // Fetch the product details
                $row = mysqli_fetch_assoc($result_set);
                $name = $row['name'];

                // Create an array with the product details
                $product = array(
                    "name" => $name,
                    "image_url" => $row['image_url'], // Set the image_url value
                    "quantity" => 1,
                    "price" => $row['price'], // Set the price value
                );

                // Check if the cart session variable is set
                if (isset($_SESSION["cart"])) {
                    // Check if the product already exists in the cart
                    if (isset($_SESSION["cart"][$product_id])) {
                        // If the product exists, increment its quantity
                        $_SESSION["cart"][$product_id]["quantity"]++;

                        // Update the quantity in the inventory table
                        $quantity = $_SESSION["cart"][$product_id]["quantity"];
                        $update_query = "UPDATE inventory SET quantity = quantity - 1 WHERE id = '$product_id'";
                        mysqli_query($db_connection, $update_query);
                    } else {
                        // If the product doesn't exist, add it to the cart
                        $_SESSION["cart"][$product_id] = $product;

                        // Update the quantity in the inventory table
                        $update_query = "UPDATE inventory SET quantity = quantity - 1 WHERE id = '$product_id'";
                        mysqli_query($db_connection, $update_query);
                    }
                } else {
                    // If the cart session variable doesn't exist, create it and add the product
                    $_SESSION["cart"] = array($product_id => $product);

                    // Update the quantity in the inventory table
                    $update_query = "UPDATE inventory SET quantity = quantity - 1 WHERE id = '$product_id'";
                    mysqli_query($db_connection, $update_query);
                }

                // Redirect the user back to the products page after adding to cart
                header("Location: cart_v2.php");
                exit();
            } else {
                // Product not found in the inventory
                echo "Product not found.";
            }

            // Close the result set
            mysqli_free_result($result_set);
        } else {
            // Failed to execute the query
            echo "Error executing the query: " . mysqli_error($db_connection);
        }

        // Close the database connection
        mysqli_close($db_connection);
    }
}

header('Location: cart_v2.php');
exit();
?>
