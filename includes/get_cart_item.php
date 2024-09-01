<?php
session_start();
include "connection.php"; // Include your database connection script

// Check if the cart session variable is set
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    echo '<table>';
    echo '<tr>
    <th>Quantity</th>
    <th>Model</th>
    <th>Price</th>
    <th>Action</th>
    </tr>';
    $totalAmount = 0; // Initialize the total amount variable

    foreach ($_SESSION['cart'] as $model => $quantity) {
        // Fetch the price for the current unit from the database
        $fetchPriceQuery = "SELECT price FROM unit WHERE model = '$model'";
        $priceResult = mysqli_query($conn, $fetchPriceQuery);

        // Check if the query was successful
        if ($priceResult) {
            $priceRow = mysqli_fetch_assoc($priceResult);
            $price = $priceRow['price'];

            
            // Calculate the subtotal for the current item
            $subtotal = $price * $quantity;

            echo '<tr>';
            echo '<td>' . $quantity . '</td>';
            echo '<td>' . $model . '</td>';
            echo '<td>₱ ' . $price . '</td>';
            echo '<td><a href="delete_item.php?model=' . urlencode($model) . '">Delete</a></td>';
            echo '</tr>';

            // Accumulate the subtotal to calculate the total amount
            $totalAmount += $subtotal;
        } else {
            // Handle errors in case the query fails
            echo '<tr>';
            echo '<td colspan="4">Error fetching price for ' . $model . '</td>';
            echo '</tr>';
        }
    }

    echo '</table>';

    // Display the total amount
    echo '<p>Total Amount: ₱ ' . $totalAmount . '</p>';
} else {
    echo '<p>Your cart is empty.</p>';
}
?>
