<?php
    include "includes/connection.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>PCBYTE - View Inventory</title>
  <link rel="stylesheet" type="text/css" href="dashboard.css?v=p<?php echo time();?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
  <div class="container">
    <?php include('partials/sidebar.php')?>
    <div class="main-content">
        <h3>View Inventory</h3>
        <table class="unit-table">
        <thead>
            <tr>
            <th>Serial Number</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Type</th>
            <th>Suppliers</th>
            <th>Shippers</th>
            <th>Quantity</th>
            <th>Price</th>
            </tr>
        </thead>
        <tbody>
          <?php
        // Fetch data from the 'unit' table
          $query = "SELECT * FROM unit";
          $result = mysqli_query($conn, $query);

          // Loop through the fetched data and populate the table rows dynamically
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['serial_number'] . "</td>";
            echo "<td>" . $row['brand'] . "</td>";
            echo "<td>" . $row['model'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['suppliers'] . "</td>";
            echo "<td>" . $row['shippers'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "</tr>";
          }

          ?>
        </tbody>
        </table>
    </div>
  </div>
</body>
</html>