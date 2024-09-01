<?php
include "connection.php";

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $serial_number = $_POST['serial_number'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $type = $_POST['type'];
        $quantity = $_POST['quantity'];
        $suppliers = $_POST['suppliers'];
        $shippers = $_POST['shippers'];
        $price = $_POST['price'];

        $query = "UPDATE unit SET serial_number = '$serial_number', brand = '$brand', model = '$model', type = '$type', suppliers = '$suppliers', shippers = '$shippers',quantity = '$quantity', price = '$price' WHERE unit_id = '$unit_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Update successful
            echo "Record updated successfully.";
            header("location: ../manage_orders.php");
            exit; // Add this line to stop further execution after redirection
        } else {
            // Update failed
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        $query = "SELECT * FROM unit WHERE unit_id = '$unit_id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <link rel="stylesheet" type="text/css" href="../dashboard.css?v=p<?php echo time(); ?>">
            <link rel="stylesheet" type="text/css" href="../css/edit.css?v=p<?php echo time(); ?>">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
        </head>
        <body>
        <div class="container">
            <div class="main-content">
                <a id="back" href="../manage_orders.php"><i class="fa fa-arrow-left"></i> Go back</a>
                <br>
                <h3>Edit Inventory Details</h3>
                <form method="POST">
                    <label>Serial Number:</label>
                    <input type="text" name="serial_number" value="<?php echo $row['serial_number']; ?>"><br>

                    <label>Brand:</label>
                    <input type="text" name="brand" value="<?php echo $row['brand']; ?>"><br>

                    <label>Model:</label>
                    <input type="text" name="model" value="<?php echo $row['model']; ?>"><br>

                    <label>Type:</label>
                    <input type="text" name="type" value="<?php echo $row['type']; ?>"><br>

                    <label for="suppliers">Suppliers:</label>
                    <select id="suppliers" name="suppliers" required>
                        <option value="<?php echo $row['suppliers']?>">== Select Supplier ==</option>
                        <?php
                        // Fetch supplier data from the database
                        $sql_suppliers = "SELECT supplier_id, supplier_name FROM supplier";
                        $result_suppliers = mysqli_query($conn, $sql_suppliers);

                        // Loop through the fetched supplier data and populate the dropdown list
                        while ($row_supplier = mysqli_fetch_assoc($result_suppliers)) {
                            $supplierID = $row_supplier['supplier_id'];
                            $supplierName = $row_supplier['supplier_name'];
                            echo '<option value="'.$supplierName .'">'.$supplierName.'</option>';
                        }
                        ?>
                    </select>

                    <label for="shippers">Shippers:</label>
                    <select id="shippers" name="shippers" required>
                        <option value="<?php echo $row['shippers']?>">== Select Shippers ==</option>
                        <?php
                        // Fetch shipper data from the database
                        $sql_shippers = "SELECT shippers_id, shippers_name FROM shippers";
                        $result_shippers = mysqli_query($conn, $sql_shippers);

                        // Loop through the fetched shipper data and populate the dropdown list
                        while ($row_shipper = mysqli_fetch_assoc($result_shippers)) {
                            $shipperID = $row_shipper['shippers_id'];
                            $shipperName = $row_shipper['shippers_name'];
                            echo '<option value="'.$shipperName.'">'.$shipperName.'</option>';
                        }
                        ?>
                    </select>

                    <label>Quantity:</label>
                    <input type="text" name="quantity" value="<?php echo $row['quantity']; ?>">

                    <label>Price:</label>
                    <input type="text" name="price" value="<?php echo $row['price']; ?>">
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
