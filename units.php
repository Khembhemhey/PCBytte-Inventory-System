<?php
    include "includes/connection.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>PCBYTE - Add Products</title>
  <link rel="stylesheet" type="text/css" href="dashboard.css?v=p<?php echo time();?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
  <div class="container">
    <?php include('partials/sidebar.php')?>
    <link rel="stylesheet" type="text/css" href="units_css.css">
    
    <div class="main-content">
        <h3>Add Products</h3>  
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
            echo "<td>₱ " . $row['price'] . "</td>";
            echo "</tr>";
          }

          ?>
        </tbody>
        </table>

        <button class="add-unit-button" onclick="openModal()">Add Products</button>

      <!-- Modal form -->
        <div id="unitModal" class="modal">
          <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add Product</h2>
            <form action="add_unit.php" method="POST">
              <label for="serial-number">Serial Number:</label>
              <input type="text" id="serial-number" name="serial_number" required>

              <label for="brand">Brand:</label>
              <input type="text" id="brand" name="brand" required>

              <label for="model">Model:</label>
              <input type="text" id="model" name="model" required>

              <label for="type">Type:</label>
              <input type="text" id="type" name="type" required>

              <label for="suppliers">Suppliers:</label>
              <select id="suppliers" name="suppliers" required>
                <option>== Select Supplier ==</option>

                <?php
                // Fetch supplier data from the database
                $sql_suppliers = "SELECT supplier_id, supplier_name FROM supplier";
                $result_suppliers = mysqli_query($conn, $sql_suppliers);

                // Loop through the fetched supplier data and populate the dropdown list
                while ($row = mysqli_fetch_assoc($result_suppliers)) {
                  $supplierID = $row['supplier_id'];
                  $supplierName = $row['supplier_name'];
                  echo '<option value="'.$supplierName .'">'.$supplierName.'</option>';
                }
                ?>
                
              </select>
              
            
              <label for="shippers">Shippers:</label>
              <select id="shippers" name="shippers" required>
                <option>== Select Shippers ==</option>

                <?php
                // Fetch supplier data from the database
                $sql_shippers = "SELECT shippers_id, shippers_name FROM shippers";
                $result_shippers = mysqli_query($conn, $sql_shippers);

                // Loop through the fetched supplier data and populate the dropdown list
                while ($row = mysqli_fetch_assoc($result_shippers)) {
                  $shipperID = $row['shippers_id'];
                  $shipperName = $row['shippers_name'];
                  echo '<option value="'.$shipperName .'">'.$shipperName.'</option>';
                }
                ?>
              </select>

              <label for="quantity">Quantity:</label>
              <input type="number" id="quantity" name="quantity" required>

              <label for="price">Price:</label>
              <input type="text" pattern="[0-9]+(\.[0-9]{1,2})?" name="price" required>

              <input type="submit" value="Add">
            </form>
          </div>
      </div>
    </div>
  </div>

  <script>
    // Modal functions
    function openModal() {
      document.getElementById("unitModal").style.display = "block";
    }

    function closeModal() {
      document.getElementById("unitModal").style.display = "none";
    }
  </script>
</body>
</html>
