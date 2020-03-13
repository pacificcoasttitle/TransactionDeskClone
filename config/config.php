<?php
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
	    $link = "https"; 
	else
	    $link = "http"; 
	  
	// Here append the common URL characters. 
	$link .= "://"; 
	  
	// Append the host(domain name, ip) to the URL. 
	$link .= $_SERVER['HTTP_HOST']; 
	  
	// Append the requested resource location to the URL 
	$link .= $_SERVER['REQUEST_URI']; 
	$file_info = pathinfo($link);

	if(isset($file_info['extension']) && !empty($file_info['extension'])) 
	{
		$link = dirname($link).'/';
	}
	define("BASE_URL", $link);
	define('BASE_URL_MAIN','http://pct.com/');

	/* Start TP API */
	define("TP_CREATE_SERVICE_ENDPOINT",'https://www.titlepoint.com/TitlePointServices/TpsService.asmx/CreateService4?');
	define("TP_TAX_CREATE_SERVICE_ENDPOINT",'https://www.titlepoint.com/TitlePointServices/TpsService.asmx/CreateService3?');
	define("TP_REQUEST_SUMMARY_ENDPOINT",'https://www.titlepoint.com/TitlePointServices/TpsService.asmx/GetRequestSummaries?');
	define("TP_GET_RESULT_BY_ID",'https://www.titlepoint.com/TitlePointServices/TpsService.asmx/GetResultByID?');
	define("TP_GET_RESULT_BY_ID_3",'https://www.titlepoint.com/TitlePointServices/TpsService.asmx/GetResultByID3?');
	define("TP_USERNAME",'pctxmltrial01');
	define("TP_PASSWORD",'Mf9w6R7Tbq');
	define("SERVICE_TYPE",'TitlePoint.LegalAndVesting2');
	define("TAX_SEARCH_SERVICE_TYPE",'TitlePoint.Geo.Tax');

	/* Image API */
	define('TP_IMAGE_ENDPOINT', 'https://www.titlepoint.com/TitlePointServices/tpsgenerateimage.asmx/CreateRequest3?');
	define('TP_IMAGE_REQUEST_STATUS', 'https://www.titlepoint.com/TitlePointServices/tpsgenerateimage.asmx/GetRequestStatus?');
	define('TP_GENERATE_IMAGE', 'https://www.titlepoint.com/titlepointservices/TpsGenerateImage.asmx/GetGeneratedImage?');
	
	/* Image API */
	/* Start TP API */

	/* Start Resware API */
	define('PLACE_ORDER_API','http://clients.pacificcoasttitle.com/api/orders/');
	/* End Resware API */
?>