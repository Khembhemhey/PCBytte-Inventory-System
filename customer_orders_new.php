<?php
include "includes/connection.php";
$mysqli = $conn;
$query = "SELECT model, brand, quantity, type, price FROM unit";
$result = $mysqli->query($query);

if ($result) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $row['price'] = (float)$row['price']; // Convert price to a float
        $data[] = $row;
    }
    echo '<script>';
    echo 'const data = ' . json_encode($data) . ';';
    echo '</script>';
} else {
    echo "Error: " . $mysqli->error;
}

// Close the database connection

session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <title>PCBYTE - Customer Orders</title>
    <link rel="stylesheet" type="text/css" href="dashboard.css?v=p<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="customer_order_css.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <style>
        .unit-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 20px;
        }

        .unit-box {
            border: 1px solid black;
            padding: 10px;
        }

        .unit-box h3 {
            margin: 0;
            padding-bottom: 5px;
            border-bottom: 1px solid black;
        }

        .unit-box p {
            margin: 5px 0;
        }

        .add-to-cart-btn {
            display: inline-block;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .cart {
            margin-top: 20px;
            border: 1px solid black;
            padding: 10px;
        }

        .cart h3 {
            margin-top: 0;
        }

        .cart-item {
            margin-bottom: 10px;
        }

                /* Modal styles */
                /* Styles for the modal */
        #checkout-modal {
            display: none; /* Hide the modal by default */
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Semi-transparent background */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        /* Close button */
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

        /* Checkout heading */
        h2 {
            text-align: center;
        }

        /* Cart items table */
        .cart-items {
            margin-top: 20px;
        }

        .cart-items table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-items th,
        .cart-items td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Empty cart message */
        .cart-items p {
            text-align: center;
        }

        /* Checkout button */
        .checkout-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .checkout-btn:hover {
            background-color: #45a049;
        }


        .card {
            border: 1px solid white;
            padding: 10px;
            margin: 10px;
            width: 300px;
            box-shadow: 0px 0px 5px #888888;
        }

        /* Style for the card attributes */
        .attribute {
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div class="container">
        <?php include('partials/sidebar.php')?>

        <div class="main-content">
            <h2>Unit List</h2>
            <div id="cardContainer" class="unit-container">
            

            <div class="cart">
                <h3>Cart</h3>
                <?php
                // Start the session

                // Check if the cart session variable is set
                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    echo '<table>';
                    echo '<tr><th>Quantity</th><th>Model</th><th>Price</th><th>Action</th></tr>';
                    $totalAmount = 0; // Initialize the total amount variable
                    foreach ($_SESSION['cart'] as $model => $quantity) {
                        // Fetch the price for the current unit from the database
                        $fetchPriceQuery = "SELECT price FROM unit WHERE model = '$model'";
                        $priceResult = mysqli_query($conn, $fetchPriceQuery);
                        $priceRow = mysqli_fetch_assoc($priceResult);
                        $price = $priceRow['price'];
                
                        // Calculate the subtotal for the current item
                        $subtotal = $price * $quantity;
                
                        // Display the cart item with price and subtotal
                        echo '<tr>';
                        echo '<td>' . $quantity . '</td>';
                        echo '<td>' . $model . '</td>';
                        echo '<td>₱ ' . $price . '</td>'; // Display the price
                        echo '<td><a href="includes/delete_item.php?model=' . urlencode($model) . '">Delete</a></td>';
                        echo '</tr>';
                
                        // Accumulate the subtotal to calculate the total amount
                        $totalAmount += $subtotal;
                    }
                
                    echo '</table>';

                    // Store the total amount in a session variable
                    $_SESSION['totalAmount'] = $totalAmount;
                
                    // Display the total amount
                    echo '<p>Total Amount: ₱ ' . $totalAmount . '</p>';
                } else {
                    echo '<p>Your cart is empty.</p>';
                }                            
                ?>
                 <?php
                // Display the checkout button if the cart is not empty
                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    echo '<form method="POST">';
                    echo '<button id="checkout-btn" class="checkout-btn">Checkout</button>';
                    echo '</form>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

<!-- modal form -->

<div id="checkout-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Checkout</h2>
        <div id="cartDisplay">
            <!-- Cart content will be displayed here -->
        </div>

        <form method="POST" action="checkout.php">
            <!-- Your additional form fields -->
            <button id="check-success" type="submit" name="checkout" class="checkout-btn">Checkout</button>
        </form>
    </div>
</div>


<!-- Modal for Success Alert -->
<div id="success-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Success</h2>
        <p id="success-message"></p>
    </div>
</div>
<!-- Existing code... -->

<!-- Modal for Success Alert -->
<div id="success-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Success</h2>
        <p id="success-message"></p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script src="customer_order_js.js"></script> -->


  // Get the modal element
  <script>
        // Function to create a card for a single data item
        function createCard(data) {
            const card = document.createElement('div');
            card.className = 'card';
            card.innerHTML = `
                <p class="attribute">Model: <span>${data.model}</span></p>
                <p class="attribute">Brand: <span>${data.brand}</span></p>
                <p class="attribute">Quantity: <span>${data.quantity}</span></p>
                <p class="attribute">Type: <span>${data.type}</span></p>
                <p class="attribute">Price per Unit: $<span>${data.price.toFixed(2)}</span></p>
                <button id="addToCartButton" onclick="addToCart(${JSON.stringify(data)})">Add to Cart</button>
            `;

            return card;
        }

        const cardContainer = document.getElementById('cardContainer'); // Moved this line here

        data.forEach(item => {
            const card = createCard(item);
            cardContainer.appendChild(card);
        });

        // Initialize an empty cart array
        let cart = [];

        // Function to add an item to the cart
        function addToCart(item) {
            // Check if the item is already in the cart
            const existingItem = cart.find(cartItem => cartItem.model === item.model);
            
            if (existingItem) {
                
                // If item exists, update the quantity
                existingItem.quantity += 1;
            } else {
                // If item doesn't exist, add it to the cart
                cart.push({ ...item, quantity: 1 });
            }
            console.log('Adding to cart:', selectedItem);
            // You can update the cart display here
            updateCartDisplay();
        }

        // Function to handle the checkout process
        function checkout() {
            // You can implement payment processing here if needed
            // Display a confirmation or payment form
            // Reset the cart or take any other necessary actions
        }

            // Function to generate a receipt
        function generateReceipt() {
            const receiptContainer = document.getElementById('receiptContainer'); // Replace with your receipt container element
            
            // Check if the cart is not empty
            if (cart.length > 0) {
                let receiptHTML = '<h2>Receipt</h2><ul>';
                let totalAmount = 0;
                
                // Loop through items in the cart
                cart.forEach(item => {
                    const subtotal = item.price * item.quantity;
                    receiptHTML += `<li>${item.model} (Quantity: ${item.quantity}) - $${subtotal.toFixed(2)}</li>`;
                    totalAmount += subtotal;
                });
                
                receiptHTML += `</ul><p>Total Amount: $${totalAmount.toFixed(2)}</p>`;
                receiptContainer.innerHTML = receiptHTML;
            } else {
                receiptContainer.innerHTML = '<p>Your cart is empty.</p>';
            }
        }
            // Function to update the cart display
        function updateCartDisplay() {
            const cartDisplay = document.getElementById('cartDisplay');
            
            // Check if the cart is not empty
            if (cart.length > 0) {
                let cartHTML = '<h3>Shopping Cart</h3><ul>';
                
                // Loop through items in the cart and display them
                cart.forEach(item => {
                    cartHTML += `<li>${item.model} (Quantity: ${item.quantity}) - $${(item.price * item.quantity).toFixed(2)}</li>`;
                });
                
                cartHTML += '</ul>';
                
                // Set the HTML content of the cartDisplay element
                cartDisplay.innerHTML = cartHTML;
            } else {
                // If the cart is empty, display a message
                cartDisplay.innerHTML = '<p>Your cart is empty.</p>';
            }
        }




    </script>

  
</html>
