<?php
include "connection.php";


if (isset($_GET['supplier_id'])) {
    $id = $_GET['supplier_id'];

  
    $query = "DELETE FROM supplier WHERE supplier_id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Deletion successful
        echo "Record deleted successfully.";
        header("location: ../suppliers.php");
    } else {
        // Deletion failed
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // ID parameter not provided
    echo "Invalid request.";
}
