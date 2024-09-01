<?php
// include the database connection file
include "includes/connection.php";

// check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // retrieve the form data
    $supplier_name = $_POST["supplier_name"];
    $contact_person = $_POST["contact_person"];
    $contact_number = $_POST["contact_number"];
    $email_address = $_POST["email_address"];
    $address = $_POST["address"];

    // prepare the stored procedure call
    $stmt = $conn->prepare("CALL InsertSupplier(?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $supplier_name, $contact_person, $contact_number, $email_address, $address);

    // execute the stored procedure
    if ($stmt->execute()) {
        // redirect to the homepage or display a success message
        header("Location: suppliers.php");
        exit();
    } else {
        // handle the case where the stored procedure fails
        echo "Error: " . $stmt->error;
    }

    // close the statement
    $stmt->close();
}

// close the database connection
mysqli_close($conn);
?>