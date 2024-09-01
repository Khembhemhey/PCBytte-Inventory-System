<?php
include "connection.php";


if (isset($_GET['transaction_id'])) {
    $transaction_id  = $_GET['transaction_id'];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $date_time = $_POST["date_time"];
        $items_purchased = $_POST["items_purchased"];
        $payment_method = $_POST["payment_method"];
        $total_amount = $_POST["total_amount"];
        $status = $_POST["status"];
        
        $query = "UPDATE transactions SET 
        transaction_id  = '$transaction_id',
        date_time = '$date_time',
        items_purchased = '$items_purchased',
        payment_method = '$payment_method',
        total_amount = '$total_amount',
        status = '$status' WHERE transaction_id  = '$transaction_id '";
        
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Update successful
            echo "Record updated successfully.";
            header("location: ../transactions.php");
        } else {
            // Update failed
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {

        $query = "SELECT * FROM transactions WHERE transaction_id  = '$transaction_id '";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        ?>

        <!DOCTYPE html>
        <html>
        <head>
          <link rel="stylesheet" type="text/css" href="../dashboard.css?v=p<?php echo time();?>">
          <link rel="stylesheet" type="text/css" href="../css/edit.css?v=p<?php echo time();?>">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
        </head>
        <body>
          <div class="container">
            <div class="main-content">
                <a id="back" href="../transactions.php"><i class="fa fa-arrow-left"></i> Go back</a>
                <br>
                
                <!-- <h3>Edit Inventory Details</h3> -->
                <form method="POST">
                    <label>Transactions ID:</label>
                    <input type="text" name="transaction_id" value="<?php echo $row['transaction_id']; ?>" readonly><br>

                    <label>Date and Time:</label>
                    <input type="datetime-local" name="date_time" value="<?php echo $row['date_time']; ?>"><br>

                    <label>Items Purchased:</label>
                    <input type="text" name="items_purchased" value="<?php echo $row['items_purchased']; ?>"><br>

                    <label>Total Amount:</label>
                    <input type="text" name="total_amount" value="<?php echo $row['total_amount']; ?>"><br>

                    <label>Status:</label>
                    <input type="text" name="status" value="<?php echo $row['status']; ?>"><br>

                    <input type="submit" value="Update">
                </form>
            </div>
          </div>
        </body>
        </html>

        <?php
    }
} else {
    // unit_id parameter not provided
    echo "Invalid request.";
}
?>
