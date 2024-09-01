<!-- Manage Inventory -->

<?php
include "connection.php";


if (isset($_GET['unit_id'])) {
    $id = $_GET['unit_id'];

  
    $query = "DELETE FROM unit WHERE unit_id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Deletion successful
        echo "Record deleted successfully.";
        header("location: ../manage_orders.php");
    } else {
        // Deletion failed
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // ID parameter not provided
    echo "Invalid request.";
}
