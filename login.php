<?php 
session_start(); 
include "includes/connection.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$user = validate($_POST['username']);
	$pass = validate($_POST['password']);

    $sql = "SELECT * FROM user WHERE username='$user' AND password='$pass'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['username'] === $user && $row['password'] === $pass) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['user_id'];
            header("Location: homepage.php");
            exit();
        }else{
            header("Location: index.php?error=Incorrect username or password");
            exit();
        }
    }else{
        header("Location: index.php?error=Incorrect username or password");
        exit();
}
	
}else{
	header("Location: index.php");
	exit();
}