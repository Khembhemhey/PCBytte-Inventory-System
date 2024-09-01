<?php
include "includes/connection.php";

// Fetch data from the 'transactions' table, grouping by order_id and selecting the latest transaction per order
$query = "SELECT MAX(transaction_id) AS latest_transaction_id, transaction_id FROM transactions GROUP BY transaction_id";
$result = mysqli_query($conn, $query);

// Initialize total amount variable
$totalAmount = 0;

?>

<!DOCTYPE html>
<html>
<head>
    <title>PCBYTE - Sales Transactions</title>
    <link rel="stylesheet" type="text/css" href="dashboard.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php include('partials/sidebar.php')?>
        <div class="main-content">
            <h3>Sales Transactions</h3>
            <table class="unit-table">
                <thead>
                    <tr>
                        <th>Sales ID</th>
                        <th>Date and Time</th>
                        <th>Items Purchased</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $latest_transaction_id = $row['latest_transaction_id'];

                        // Retrieve the details of the latest transaction for this order
                        $transactionQuery = "SELECT * FROM transactions WHERE transaction_id = $latest_transaction_id";
                        $transactionResult = mysqli_query($conn, $transactionQuery);
                        $transaction = mysqli_fetch_assoc($transactionResult);

                        echo "<tr>";
                        echo "<td>" . $latest_transaction_id . "</td>";
                        echo "<td>" . $transaction['date_time'] . "</td>";
                        echo "<td>" . $transaction['items_purchased'] . "</td>";
                        echo "<td>" . $transaction['total_amount'] . "</td>";
                        echo "</tr>";

                        // Add the total amount of the current transaction to the totalAmount variable
                        $totalAmount += $transaction['total_amount'];
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total Amount:</td>
                        <td><?php echo $totalAmount; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
