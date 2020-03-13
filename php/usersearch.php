<?php
    include dirname(__FILE__).'/../config/database.php';

    // Get search term 
    $searchTerm = $_GET['term'];

    // Fetch matched data from the database 
    $query = $conn->query("SELECT *, CONCAT(first_name, ' ',last_name, ' - ',email_address) AS value, CONCAT(first_name, ' ',last_name) AS full_name FROM customer_basic_details WHERE first_name LIKE '%".$searchTerm."%' AND status = 1 AND is_escrow = 0 ORDER BY first_name ASC");

    $userInfo = array(); 
    if($query->num_rows > 0)
    { 
        while($row = $query->fetch_assoc())
        {
            $data['id'] = isset($row['id']) && !empty($row['id']) ? $row['id'] : '';
            
            $data['value'] = isset($row['value']) && !empty($row['value']) ? $row['value'] : '';

            $data['name'] = isset($row['full_name']) && !empty($row['full_name']) ? $row['full_name'] : '';
            $data['email_address'] = isset($row['email_address']) && !empty($row['email_address']) ? $row['email_address'] : '';
            $data['telephone_no'] = isset($row['telephone_no']) && !empty($row['telephone_no']) ? $row['telephone_no'] : '';
            $data['company'] = isset($row['company_name']) && !empty($row['company_name']) ? $row['company_name'] : '';
            array_push($userInfo, $data); 
        } 
    } 

    // Return results as json encoded array 
    echo json_encode($userInfo); 
?>