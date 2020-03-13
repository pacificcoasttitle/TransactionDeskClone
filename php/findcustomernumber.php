<?php

    include dirname(__FILE__).'/../config/database.php';

    $email = isset($_POST['CustomerEmail']) && !empty($_POST['CustomerEmail']) ? $_POST['CustomerEmail'] : '';

    $query = $conn->query("SELECT customer_number FROM customer_basic_details WHERE email_address = '".$email."' AND status = 1");

    $data = array();
    if($query->num_rows > 0)
    {
        while($row = $query->fetch_assoc())
        {
            $customer_number = isset($row['customer_number']) && !empty($row['customer_number']) ? $row['customer_number'] : '';
            $data['customer_number'] = $customer_number;
        }
    }

    echo json_encode($data);
?>