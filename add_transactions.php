<?php
// include the database connection file
include "includes/connection.php";

// check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // retrieve the form data
  $receipt_id = $_POST["receipt_id"];
  $customer_name = $_POST["customer_name"];
  $date_time = $_POST["date_time"];
  $items_purchased = $_POST["items_purchased"];
  $discount = $_POST["discount"];
  $total_amount = $_POST["total_amount"];


  // prepare the insert query
  $query = "INSERT INTO transactions (receipt_id, customer_name, date_time, items_purchased, discount, total_amount) VALUES ('$receipt_id', '$customer_name', '$date_time', '$items_purchased', '$discount', '$total_amount')";

  
  // execute the query
  if (mysqli_query($conn, $query)) {
    // redirect to the homepage or display a success message
    header("Location: transactions.php");
    exit();
  }
  else {
    // handle the case where the query fails
    echo "Error: " . mysqli_error($conn);
  }
}

// close the database connection
mysqli_close($conn);
?>




