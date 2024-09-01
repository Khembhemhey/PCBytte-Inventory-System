<?php
session_start();
include('connection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the model, quantity, and quantity_available are provided
    if (isset($_POST['model']) && isset($_POST['quantity']) && isset($_POST['quantity_available'])) {
        $model = $_POST['model'];
        $quantity = $_POST['quantity'];
        $quantity_available = $_POST['quantity_available'];

        // Check if the cart session variable exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array(); // Initialize the cart as an empty array
        }

        // Check if the quantity requested is within the available quantity
        if ($quantity > 0 && $quantity <= $quantity_available) {
            // Add the item to the cart with the specified quantity
            $_SESSION['cart'][$model] = $quantity;

            // Update the quantity in the unit boxes
            $new_quantity = $quantity_available - $quantity;
            // Update the quantity in the database
            $update_query = "UPDATE unit SET quantity = $new_quantity WHERE model = '$model'";
            mysqli_query($conn, $update_query);
        } else {
            // Display an error message for invalid quantity
            echo ("Invalid quantity. Please enter a valid quantity.");
        }
    }
}

// Redirect back to the unit list page
header("Location: ../customer_orders.php");
exit();
?>
