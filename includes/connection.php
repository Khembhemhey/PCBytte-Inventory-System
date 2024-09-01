<?php
    $host = "localhost";
    $port = "5432"; // Default PostgreSQL port
    $dbname = "ecommerce";
    $user = "postgres";
    $password = "Kimbeme14!";

    $conn_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";

    $conn = pg_connect($conn_string);

    if (!$conn) {
        die("Connection Failed: " . pg_last_error());
    }
?>
