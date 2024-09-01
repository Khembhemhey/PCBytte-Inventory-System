<?php
include "includes/connection.php";
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

    </style>
</head>
<body>
    <div class="container">
        <?php include('partials/sidebar.php')?>

        <div class="main-content">
            <h2>Unit List</h2>
            <div class="unit-container">
                <?php
                // Fetch data from the 'unit' table
                $query = "SELECT model, brand, quantity, type, price FROM unit";
                $result = mysqli_query($conn, $query);

                // Loop through the fetched data and populate the unit boxes dynamically
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="unit-box">';
                    echo '<h3>Model: ' . $row['model'] . '</h3>';
                    echo '<p>Brand: ' . $row['brand'] . '</p>';
                    echo '<p>Quantity: ' . $row['quantity'] . '</p>';
                    echo '<p>Type: ' . $row['type'] . '</p>';
                    echo '<p>Price: ₱ ' . $row['price'] . '</p>';
                    echo '<form action="includes/add_to_cart.php" method="POST">';
                    echo '<input type="hidden" name="model" value="' . $row['model'] . '">';
                    echo '<input type="hidden" name="quantity_available" value="' . $row['quantity'] . '">';
                    echo '<label for="quantity">Quantity:</label>';
                    echo '<input type="number" name="quantity" min="1" max="' . $row['quantity'] . '">';
                    echo '<button type="submit" class="add-to-cart-btn">Add to Cart</button>';
                    echo '</form>';
                    echo '</div>';
                }
                ?>
            </div>

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
        <!-- Inside the checkout-modal -->
        <h2>Checkout</h2>
        <div class="cart-items">
            <table>
                <tr>
                    <th>Quantity</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                <!-- This table will be filled dynamically using AJAX -->
            </table>
        </div>
        <!-- <p>Total Amount: ₱ <span id="total-amount">0</span></p> -->


        
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

<script>
  // Get the modal element
  const modal = document.getElementById('checkout-modal');

  // Get the button that triggers the modal
  const checkoutBtn = document.getElementById('checkout-btn');

  
  const successBtn = document.getElementById('check-success');

  // Get the <span> element that closes the modal
  const closeBtn = document.getElementsByClassName('close')[0];

  // Function to open the modal and display cart items
  function openModal(event) {
    event.preventDefault(); // Prevent form submission

    // Fetch cart items using AJAX or any other method
    // and update the contents of the "cart-items" div
    const cartItemsContainer = document.querySelector('.cart-items');
    fetch('includes/get_cart_item.php') // Replace with your server-side script to fetch cart items
      .then(response => response.text())
      .then(data => {
        cartItemsContainer.innerHTML = data;
        modal.style.display = 'block';
      });
  }

  // Function to close the modal
  function closeModal() {
    modal.style.display = 'none';
  }

  // Event listeners
  checkoutBtn.addEventListener('click', openModal);
  closeBtn.addEventListener('click', closeModal);
  window.addEventListener('click', (event) => {
    if (event.target === modal) {
      closeModal();
    }
  });



         // Get the success modal element
  const successModal = document.getElementById('success-modal');

        // Function to open the success modal
        function openSuccessModal(message) {
        // Set the success message
        $('#success-message').text(message);
        successModal.style.display = 'block';
        }

        // Function to close the success modal
        function closeSuccessModal() {
        successModal.style.display = 'none';
        }

        // Event listener for the close button of the success modal
        successModal.querySelector('.close').addEventListener('click', closeSuccessModal);

        // Update the checkout button event listener to display the success modal
        checkoutBtn.addEventListener('click', () => {
        openModal(event);
        successBtn.addEventListener('click', ()=>{
            openSuccessModal('Checkout process completed successfully.'); // Set the success message
        });

    });

</script>
  
</html>
