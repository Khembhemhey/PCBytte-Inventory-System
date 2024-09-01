<?php
    include "includes/connection.php";

    if (isset($_POST['username']) && isset($_POST['password'])) {
        
        $user = $_POST['username'];
        $pass = $_POST['password'];

        mysqli_query($conn,"INSERT INTO user
                        (user_id, username, password)
                        VALUES (NULL, '{$user}', {$pass})");

        header("location: index.php");
    }
?>