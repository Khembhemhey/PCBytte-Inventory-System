<?php
session_start();

if (isset($_GET['model'])) {

    include "connection.php";

    $model = urldecode($_GET['model']);

    // Check if the item exists in the cart
    if (isset($_SESSION['cart'][$model])) {
        // Fetch the price for the deleted item from the database
        $fetchPriceQuery = "SELECT price FROM unit WHERE model = '$model'";
        $priceResult = mysqli_query($conn, $fetchPriceQuery);
        $priceRow = mysqli_fetch_assoc($priceResult);
        $price = $priceRow['price'];

        // Calculate the subtotal for the deleted item
        $subtotal = $price * $_SESSION['cart'][$model];

        // Remove the item from the cart
        unset($_SESSION['cart'][$model]);

        // Update the total amount by subtracting the subtotal
        $_SESSION['totalAmount'] -= $subtotal;
    }
}

header('Location: ../customer_orders.php');
exit();
?>
