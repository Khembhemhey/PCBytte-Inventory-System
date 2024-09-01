<?php
session_start();
include "includes/connection.php";

// Check if the cart session variable is set
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Start the transaction
    mysqli_begin_transaction($conn);

    try {
        // Perform the checkout process
        // ...

        $totalItems = count($_SESSION['cart']);
        
        foreach ($_SESSION['cart'] as $model => $quantity) {
            // Retrieve the current quantity of the product from the database
            $query = "SELECT quantity FROM unit WHERE model = '$model' FOR UPDATE";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $currentQuantity = $row['quantity'];

            $fetchPriceQuery = "SELECT price FROM unit WHERE model = '$model'";
            $priceResult = mysqli_query($conn, $fetchPriceQuery);
            $priceRow = mysqli_fetch_assoc($priceResult);
            $price = $priceRow['price'];

            // Calculate the new quantity after checkout
            $newQuantity = $currentQuantity - $quantity;
            $prices = $price * $quantity;

            // Update the quantity in the database
            $updateQuery = "UPDATE unit SET quantity = $newQuantity WHERE model = '$model'";
            if (!mysqli_query($conn, $updateQuery)) {
                throw new Exception("Error updating quantity: " . mysqli_error($conn));
            }

            // Get the current date and time
            $dateNow = date('Y-m-d');
            $totalAmount = $_SESSION['totalAmount'];

            // Prepare the insert query for the transactions table
            $insertTransaction = "INSERT INTO transactions (transaction_id, date_time, items_purchased, total_amount) VALUES ('$transaction_id', '$dateNow', '$quantity', '$prices')";

            // Execute the insert query
            if (!mysqli_query($conn, $insertTransaction)) {
                throw new Exception("Error inserting transaction: " . mysqli_error($conn));
            }
        }

        // Commit the transaction if everything is successful
        mysqli_commit($conn);

        // Clear the cart session variable after successful checkout
        $_SESSION['cart'] = [];

        // Set the success message
        $message = 'Checkout process completed successfully.';

        // Redirect to the customer_orders.php page with the success message as a query parameter
        header("Location: customer_orders.php?message=" . urlencode($message));
        exit;
    } catch (Exception $e) {
        // An error occurred, rollback the transaction
        mysqli_rollback($conn);

        // Handle the error as needed
        echo "Transaction failed: " . $e->getMessage();
    }
} else {
    // Redirect to the cart page if the cart is empty
    header("Location: customer_orders.php");
    exit;
}
?>
