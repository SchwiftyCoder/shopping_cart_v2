<?php
include 'header.php';

//get only id and quantity data from cart
        $select_cart = "select * from cart;";
$result_set = mysqli_query($db_connection, $select_cart);
if (mysqli_num_rows($result_set) > 0) {
    while ($row = mysqli_fetch_assoc($result_set)) {
        // Access each row's data 
        $id = $row['id'];
        $name = $row['name'];
        $image_url = $row['image_url'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        
        $update_inventory_quantity = "UPDATE inventory SET quantity = quantity + $quantity WHERE id = $id;";
        $insert_inventory = "INSERT INTO inventory (id, name, image_url, quantity, price) 
        VALUES ('$id', '$name', '$image_url', $quantity, $price);";
        //check if the id exists in the database, then we just update the quantity else insert a whole new row
        // SQL query to check if the ID exists in the inventory table
        $id_if_exists = "SELECT 1 FROM inventory WHERE id = $id";

        // Execute the query
        $result = $db_connection->query($id_if_exists);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // The ID exists in the inventory table, update only the quantity 
            mysqli_query($db_connection, $update_inventory_quantity);
        } else {
            // The ID does not exist in the inventory table, thus insert new row
            mysqli_query($db_connection, $insert_inventory);
        }
    }

    //clear the cart table
    mysqli_query($db_connection, "TRUNCATE cart;");

    //redirect to the cart page
    header('Location: cart.php');
}




?>