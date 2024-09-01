<?php
    include "includes/connection.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>PCBYTE - Shippers</title>
  <link rel="stylesheet" type="text/css" href="dashboard.css?v=p<?php echo time();?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
  <div class="container">
    <?php include('partials/sidebar.php')?>
    
    <div class="main-content">
        <h3>Shippers</h3>
        <table class="unit-table">
        <thead>
            <tr>
            <th>Shipper ID</th>
            <th>Shipper Name</th>
            <!-- <th>Contact Person</th> -->
            <th>Contact Number</th>
            <th>Email Address</th>
            <th>Address</th>
            <th>Actions</th>
            </tr>
        </thead>
        <tbody>
          <?php
        // Fetch data from the 'unit' table
          $query = "SELECT * FROM shippers";
          $result = mysqli_query($conn, $query);

          // Loop through the fetched data and populate the table rows dynamically
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['shippers_id'] . "</td>";
            echo "<td>" . $row['shippers_name'] . "</td>";
            /* echo "<td>" . $row['contact_person'] . "</td>"; */
            echo "<td>" . $row['contact_number'] . "</td>";
            echo "<td>" . $row['email_address'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>
                    <a href='includes/edit_shippers.php?shippers_id=" . $row['shippers_id'] . "'><i class='fas fa-edit'></i></a>
                    <a href='includes/delete_shippers.php?shippers_id=" . $row['shippers_id'] . "'><i class='fas fa-trash'></i></a>
                  </td>"; // Links to edit.php and delete.php passing the record's unit_id
            echo "</tr>";
          }

          ?>
        </tbody>
        </table>

        <button class="add-unit-button" onclick="openModal()">Add Shippers</button>

      <!-- Modal form -->
        <div id="unitModal" class="modal">
          <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add Shippers</h2>
            <form action="add_shippers.php" method="POST">

              <label for="shippers_name">Shipper Name:</label>
              <input type="text" id="shippers_name" name="shippers_name" required>

              <label for="contact_person">Contact Person:</label>
              <input type="text" id="contact_person" name="contact_person" required>

              <label for="contact_number">Contact Number:</label>
              <input type="text" id="contact_number" name="contact_number" required>

              <label for="email_address">Email Address:</label>
              <input type="text" id="email_address" name="email_address" required>

              <label for="address">Address:</label>
              <input type="text" id="address" name="address" required>

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
