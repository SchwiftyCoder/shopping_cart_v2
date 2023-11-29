<?php

include 'config/database_connection.php';

//generate random date in the future
function computeETA($minDaysAhead = 1, $maxDaysAhead = 365) {
    $minTimestamp = time() + ($minDaysAhead * 86400); // 86400 seconds in a day
    $maxTimestamp = time() + ($maxDaysAhead * 86400);
    $randomTimestamp = mt_rand($minTimestamp, $maxTimestamp);
    
    return date('Y-m-d', $randomTimestamp);
}

//generate tracting number
function generateTrackingNumber($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    
    $charactersLength = strlen($characters);
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    return $randomString;
}

// Check if the Checkout button is clicked
if (isset($_POST['checkout'])) {
    // Query to select all rows from the cart table
    $select_query = "SELECT * FROM cart";
    $result_set = mysqli_query($db_connection, $select_query);

    if ($result_set) { 
        if (mysqli_num_rows($result_set) > 0) {
            while ($row = mysqli_fetch_assoc($result_set)) {
                // Access each row's data 
                $name = $row['name'];
                $image_url = $row['image_url'];
                $quantity = $row['quantity'];
                $price = $row['price'];
            
                //generate a dummy date and tracking number
                $eta = computeETA();
                $tracking_number = generateTrackingNumber(); // Assign a generated tracking number
            
                //insert each row into the orders table
                $orders_insert_query = "INSERT INTO orders (name, image_url, quantity, price, ETA, tracking_number)  VALUES ('$name', '$image_url', '$quantity', '$price', '$eta', '$tracking_number')";
                // SQL query to insert data into the orders table
                $insert_query = mysqli_query($db_connection, $orders_insert_query);
            
                // Check if the insertion was successful
                if (!$insert_query) {
                    // Handle the case where the insertion failed.
                    echo "Error inserting data into the orders table: " . mysqli_error($db_connection); 
                    // break;
                }
            }
        } else {
            echo "No items in cart at this time";
        }
    } else {
        // Handle the case where the query failed.
        echo "Error executing the checkout process.";
    }

    //clear the cart table
    mysqli_query($db_connection, "TRUNCATE cart;");

    //redirect to the order page once done
    // header('Location: orders.php');
}
