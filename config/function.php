<?php

function check_login($con)
{
    if (isset($_SESSION['user_id']))
    {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";
        $result = pg_query($con, $query);
        
        if ($result && pg_num_rows($result) > 0)
        {
            $user_data = pg_fetch_assoc($result);
            return $user_data;
        }
    }
    header("Location: index.php");
    die();
}

?>
