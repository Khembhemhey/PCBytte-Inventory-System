<?php
// include the database connection file
include "includes/connection.php";

// check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // retrieve the form data
    $serialNumber = $_POST["serial_number"];
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $type = $_POST["type"];
    $suppliers = $_POST["suppliers"];
    $shippers = $_POST["shippers"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    // prepare the call to the stored procedure
    $stmt = $conn->prepare("CALL InsertUnit(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssid", $serialNumber, $brand, $model, $type, $suppliers, $shippers, $quantity, $price);

    // execute the stored procedure
    $stmt->execute();

    // get the result
    $stmt->bind_result($result);
    $stmt->fetch();

    // close the statement
    $stmt->close();

    // handle the result as needed
    if ($result == 'Success') {
        // redirect to the homepage or display a success message
        header("Location: manage_orders.php");
        exit();
    } else {
        // handle the case where the stored procedure fails
        echo $result;
    }
}

// close the database connection
mysqli_close($conn);
?>
