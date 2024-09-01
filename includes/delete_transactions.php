<?php
include "connection.php";


if (isset($_GET['transaction_id'])) {
    $id = $_GET['transaction_id'];

  
    $query = "DELETE FROM transactions WHERE transaction_id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Deletion successful
        echo "Record deleted successfully.";
        header("location: ../transactions.php");
    } else {
        // Deletion failed
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // ID parameter not provided
    echo "Invalid request.";
}