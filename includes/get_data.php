<?php
// Connect to the MySQL database
include "connection.php";

// Query to retrieve data from the table
$query = "SELECT model, brand, quantity, type, price FROM unit";
$result = $mysqli->query($query);

if ($result) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(array("error" => "Database query error"));
}

// Close the database connection
$mysqli->close();
?>
