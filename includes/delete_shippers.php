<?php
include "connection.php";


if (isset($_GET['shippers_id'])) {
    $id = $_GET['shippers_id'];

  
    $query = "DELETE FROM shippers WHERE shippers_id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Deletion successful
        echo "Record deleted successfully.";
        header("location: ../shippers.php");
    } else {
        // Deletion failed
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // ID parameter not provided
    echo "Invalid request.";
}
