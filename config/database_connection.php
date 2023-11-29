<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'pma');
    define('DB_PASSWORD', 'brtfc');
    define('DB_NAME', 'squanchy_inventory'); 
    define('DB_PORT', 3306);

    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
    
    if($db_connection->connect_errno == 0){
        // prit out the text in quote to test database connection
        // echo 'Connection Successful!';
    }
    else {
        die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
    }

    // $db_connection->close();

?>
