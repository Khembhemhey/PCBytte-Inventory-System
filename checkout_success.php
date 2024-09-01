<?php
session_start();
include "includes/connection.php";

// Check if the checkout form is submitted
if (isset($_POST['checkout'])) {
    // Get the cart items from the session
    $cartItems = $_SESSION['cart'];

    // Perform the checkout process
    // ...

    // Clear the cart session variable after successful checkout
    $_SESSION['cart'] = [];

    // Redirect to the checkout success page and pass the cart items as URL parameters
    $redirectURL = "checkout_success.php?items=" . urlencode(serialize($cartItems));
    header("Location: $redirectURL");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PCBYTE - Checkout</title>
    <link rel="stylesheet" type="text/css" href="checkout_success_css.css">

    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
        }

        /* Close button style */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Checkout</h1>

    <?php
    // Display the cart items
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        echo '<h2>Cart</h2>';
        echo '<table>';
        echo '<tr><th>Quantity</th><th>Model</th><th>Action</th></tr>';
        foreach ($_SESSION['cart'] as $model => $quantity) {
            echo '<tr>';
            echo '<td>' . $quantity . '</td>';
            echo '<td>' . $model . '</td>';
            echo '<td><a href="includes/delete_item.php?model=' . urlencode($model) . '">Delete</a></td>';
            echo '</tr>';
        }
        echo '</table>';

        // Checkout button to open the modal
        echo '<button onclick="openModal()">Checkout</button>';
    } else {
        echo '<p>Your cart is empty.</p>';
    }
    ?>

    <!-- The Modal -->
    <div id="checkoutModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Checkout</h2>
            <form method="POST" action="checkout.php">
                <!-- Add your checkout form fields here -->
                <!-- Example: Name, Address, Payment details, etc. -->
                <label for="name">Name:</label>
                <input type="text" name="name" required>
                <br>
                <label for="address">Address:</label>
                <input type="text" name="address" required>
                <br>
                <label for="payment">Payment Details:</label>
                <input type="text" name="payment" required>
                <br>
                <button type="submit" name="checkout">Submit</button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript functions to open and close the modal
        function openModal() {
            document.getElementById("checkoutModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("checkoutModal").style.display = "none";
        }
    </script>
</body>
</html>
