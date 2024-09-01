<?php
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connection = mysqli_connect('localhost', 'root', '1234');

    if (!$connection) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    mysqli_select_db($connection, 'PCBYTE-new');

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $encrypted = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email is already taken
    $check_query = "SELECT * FROM users WHERE email = ?";
    $check_stmt = mysqli_prepare($connection, $check_query);
    mysqli_stmt_bind_param($check_stmt, "s", $email);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($result) > 0) {
        $response = [
            'success' => false,
            'message' => 'Email address is already taken.'
        ];
    } else {
        // Use a prepared statement to insert data
        $insert_query = "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
        $insert_stmt = mysqli_prepare($connection, $insert_query);
        mysqli_stmt_bind_param($insert_stmt, "ssss", $firstname, $lastname, $email, $encrypted);

        if (mysqli_stmt_execute($insert_stmt)) {
            $response = [
                'success' => true,
                'message' => $firstname . ' ' . $lastname . ' successfully added to the system.'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Error: ' . mysqli_error($connection)
            ];
        }

        // Close the prepared statement for insertion
        mysqli_stmt_close($insert_stmt);
    }

    // Close the prepared statement for checking and the database connection
    mysqli_stmt_close($check_stmt);
    mysqli_close($connection);

    $_SESSION['response'] = $response;

    header('location: index.php');
    exit; // Important to stop script execution after the redirect
}



?>