<?php

    include dirname(__FILE__).'/../config/database.php';

    $email = isset($_GET['CustomerEmail']) && !empty($_GET['CustomerEmail']) ? $_GET['CustomerEmail'] : '';

    $query = $conn->query("SELECT * FROM customer_basic_details WHERE email_address = '".$email."' AND status = 1"); 
    if($query->num_rows > 0)
    {    

        echo 'true'; 
    }
    else
    {
        echo 'false';
    }
?>