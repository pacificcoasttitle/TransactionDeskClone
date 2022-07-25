<?php
if(!function_exists('checkRemoteFile')){
	function checkRemoteFile($url)
	{
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    // don't download content
	    curl_setopt($ch, CURLOPT_NOBODY, 1);
	    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	    $result = curl_exec($ch);
	    curl_close($ch);
	    if($result !== FALSE)
	    {
	        return true;
	    }
	    else
	    {
	        return false;
	    }
	}
}
if(!function_exists('separateZipRoute')) {
	function separateZipRoute($mixedVal,$zip)
	{
		$mixedVal = trim($mixedVal);
		$zip = trim($zip);
		$position = strpos($mixedVal, $zip);
		$returned_str = $mixedVal;
		if ($position !== false) {
			$returned_str = substr_replace( $mixedVal, '-', strlen($zip), 0 );
		}
		elseif(strlen($mixedVal) > 5) {
			$returned_str = substr_replace( $mixedVal, '-', -4, 0 );
		}
		return $returned_str;
		

	}
}
if(!function_exists('convertTimezone')) {
	function convertTimezone($dateTime,$format = 'm/d/Y h:i:s A')
	{
		$default_timezone = $to_timezone = 'America/Los_Angeles';
		$to_timezone = 'America/Los_Angele';
		if(!empty($_COOKIE['user_timezone'])) {
			$to_timezone = $_COOKIE['user_timezone'];
		}
		$date = new DateTime($dateTime);
		try {
			$date->setTimezone(new DateTimeZone($to_timezone));
		} catch (\Throwable $th) {
			$date->setTimezone(new DateTimeZone($default_timezone));
		}
		return $date->format($format);
	}
}
if(!function_exists('getUserName')) {
	function getUserName($id)
	{
		
		$CI = get_instance();
		$CI->load->model('admin/order/customer_basic_details_model');
		$user = $CI->customer_basic_details_model->get($id);
		if($user) {
			return $user->first_name.' '.$user->last_name;
		}
		else {
			return '';
		}
	}
}
