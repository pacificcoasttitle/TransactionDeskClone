<?php
include dirname(__FILE__).'/../config/database.php';

$customer_no = isset($_POST['customer_no']) && !empty($_POST['customer_no']) ? $_POST['customer_no'] : '';
 
// Fetch matched data from the database 
$query = $conn->query("SELECT * FROM customer_basic_details WHERE customer_number = '".$customer_no."' AND status = 1 ORDER BY id ASC"); 

// Generate array with skills data 
$data = array(); 
if($query->num_rows > 0)
{ 
    while($row = $query->fetch_assoc()){

        $data['id'] = isset($row['id']) && !empty($row['id']) ? $row['id'] : '';

        /*$value = '';
        if(isset($row['customer_number']) && !empty($row['customer_number']))
        {
            $value = $row['customer_number'];

            if(isset($row['email_address']) && !empty($row['email_address']))
            {
                $value .= ' - '.$row['email_address'];
            }
        }

        $data['value'] = $value;
*/
        $data['customer_number'] = isset($row['customer_number']) && !empty($row['customer_number']) ? $row['customer_number'] : '';
        $data['first_name'] = isset($row['first_name']) && !empty($row['first_name']) ? $row['first_name'] : '';
        $data['last_name'] = isset($row['last_name']) && !empty($row['last_name']) ? $row['last_name'] : '';
        $data['telephone_no'] = isset($row['telephone_no']) && !empty($row['telephone_no']) ? $row['telephone_no'] : '';
        $data['email_address'] = isset($row['email_address']) && !empty($row['email_address']) ? $row['email_address'] : '';
        $data['company_name'] = isset($row['company_name']) && !empty($row['company_name']) ? $row['company_name'] : '';
        $data['street_address'] = isset($row['street_address']) && !empty($row['street_address']) ? $row['street_address'] : '';
        $data['city'] = isset($row['city']) && !empty($row['city']) ? $row['city'] : '';
        $data['zip_code'] = isset($row['zip_code']) && !empty($row['zip_code']) ? $row['zip_code'] : '';
        $data['is_escrow'] = isset($row['is_escrow']) && !empty($row['is_escrow']) ? $row['is_escrow'] : 0;
        // array_push($customerInfo, $data); 
    } 
}
// Return results as json encoded array 
echo json_encode($data); 
?>