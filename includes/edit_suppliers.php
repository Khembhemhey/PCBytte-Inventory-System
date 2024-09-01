<?php
include "connection.php";


if (isset($_GET['supplier_id'])) {
    $supplier_id = $_GET['supplier_id'];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $supplier_id = $_POST["supplier_id"];
        $supplier_name = $_POST["supplier_name"];
        $contact_person = $_POST["contact_person"];
        $contact_number = $_POST["contact_number"];
        $email_address = $_POST["email_address"];
        $address = $_POST["address"];


        $query = "UPDATE supplier SET 
        supplier_id = '$supplier_id',
        supplier_name = '$supplier_name',
        contact_person = '$contact_person',
        contact_number = '$contact_number',
        email_address = '$email_address',
        address = '$address' WHERE supplier_id = '$supplier_id'";


        
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Update successful
            echo "Record updated successfully.";
            header("location: ../suppliers.php");
        } else {
            // Update failed
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {

        $query = "SELECT * FROM supplier WHERE supplier_id = '$supplier_id'";
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
                <a id="back" href="../suppliers.php"><i class="fa fa-arrow-left"></i> Go back</a>
                <br>
                
                <!-- <h3>Edit Inventory Details</h3> -->
                <form method="POST">
                    <label>Supplier ID:</label>
                    <input type="text" name="supplier_id" value="<?php echo $row['supplier_id']; ?>"><br>

                    <label>Supplier Name:</label>
                    <input type="text" name="supplier_name" value="<?php echo $row['supplier_name']; ?>"><br>

                    <label>Contact Person:</label>
                    <input type="text" name="contact_person" value="<?php echo $row['contact_person']; ?>"><br>

                    <label>Contact Number:</label>
                    <input type="text" name="contact_number" value="<?php echo $row['contact_number']; ?>"><br>

                    <label>Email Address:</label>
                    <input type="text" name="email_address" value="<?php echo $row['email_address']; ?>"><br>

                    <label>Address:</label>
                    <input type="text" name="address" value="<?php echo $row['address']; ?>"><br>


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
