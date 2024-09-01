<?php
include "includes/connection.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>PCBYTE - Manage Inventory</title>
    <link rel="stylesheet" type="text/css" href="dashboard.css?v=p<?php echo time();?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php include('partials/sidebar.php')?>
        <div class="main-content">
            <h3>Manage Inventory</h3>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch data from the 'unit' table
                    $query = "SELECT * FROM unit";
                    $result = mysqli_query($conn, $query);

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
                        echo "<td>
                            <a href='includes/edit.php?unit_id=" . $row['unit_id'] . "'><i class='fas fa-edit'></i></a>
                            <a href='#' onclick='openDeleteModal(" . $row['unit_id'] . ")'><i class='fas fa-trash'></i></a>
                        </td>"; // Links to edit.php and delete.php passing the record's unit_id
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for delete confirmation -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <h2>Confirmation</h2>
            <p>Are you sure you want to delete this record?</p>
            <div class="modal-buttons">
                <a id="deleteConfirmBtn" href="#"><button class="confirm">Yes</button></a>
                <button class="cancel" onclick="closeDeleteModal()">Cancel</button>
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

        // Function to open the delete confirmation modal
        function openDeleteModal(unitId) {
            var deleteConfirmBtn = document.getElementById("deleteConfirmBtn");
            deleteConfirmBtn.href = 'includes/delete.php?unit_id=' + unitId;
            document.getElementById("deleteModal").style.display = "block";
        }

        // Function to close the delete confirmation modal
        function closeDeleteModal() {
            document.getElementById("deleteModal").style.display = "none";
        }
    </script>
</body>
</html>
