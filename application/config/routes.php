<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/* Route for PCT static pages*/
$route['default_controller'] = 'frontend/index/index';
$route['our-role'] = 'frontend/aboutus/role';
$route['protecting-you'] = 'frontend/aboutus/protect';
$route['why-pacific-coast-title'] = 'frontend/aboutus/pacific';
$route['about-us'] = 'frontend/aboutus/about';
$route['join-our-team'] = 'frontend/aboutus/joinOurTeam';
$route['residential-title'] = 'frontend/residential/title';
$route['escrow-settlement'] = 'frontend/residential/escrowSettlement';
$route['what-is-title-insurance'] = 'frontend/residential/titleInsurance';
$route['benefits-title-insurance'] = 'frontend/residential/benefitsTitleInsurance';
$route['life-of-title-search'] = 'frontend/residential/lifeOfTitleSearch';
$route['top-10-title-problems'] = 'frontend/residential/topTitleProblems';
$route['what-is-escrow'] = 'frontend/residential/whatIsEscrow';
$route['life-of-escrow'] = 'frontend/residential/lifeOfEscrow';
$route['escrow-terms'] = 'frontend/residential/escrowTerms';
$route['commercial-services'] = 'frontend/commercial/commercialServices';
$route['commercial-resources'] = 'frontend/commercial/commercialResources';
$route['commercial-expertise'] = 'frontend/commercial/commercialExpertise';
$route['blank-forms'] = 'frontend/agentResources/blankForms';
$route['educational-booklets'] = 'frontend/agentResources/educationalBooklets';
$route['flyer-center'] = 'frontend/agentResources/flyerCenter';
$route['recording-fees'] = 'frontend/agentResources/recordingFees';
$route['rate-book'] = 'frontend/agentResources/rateBook';
$route['training-center'] = 'frontend/agentResources/trainingCenter';
$route['downey'] = 'frontend/contact/downey';
$route['orange'] = 'frontend/contact/orange';
$route['oxnard'] = 'frontend/contact/oxnard';
$route['sandiego'] = 'frontend/contact/sandiego';
$route['glendale'] = 'frontend/contact/glendale';

/* Route for PCT-Order Frontside*/
$route['order'] = 'frontend/order/home/index';
$route['dashboard'] = 'frontend/order/home/dashboard';
$route['order/login'] = 'frontend/order/login/index';
$route['do_login'] = 'frontend/order/login/do_login';
$route['logout'] = 'frontend/order/home/logout';
$route['home/getSearchResults'] = 'frontend/order/home/getSearchResults';
$route['home/checkEmail'] = 'frontend/order/home/checkEmail';
$route['home/getCustomerNumber'] = 'frontend/order/home/getCustomerNumber';
$route['agent/getAgentDetails'] = 'frontend/order/agent/getAgentDetails';
$route['home/getCustomerDetails'] = 'frontend/order/home/getCustomerDetails';
$route['home/getDetailsByName'] = 'frontend/order/home/getDetailsByName';
$route['order-submit'] = 'frontend/order/home/orderSubmit';
$route['createService'] = 'frontend/order/TitlePoint/createService';
$route['getRequestSummaries'] = 'frontend/order/TitlePoint/getRequestSummaries';
$route['getResultById'] = 'frontend/order/TitlePoint/getResultById';
$route['imageCreateRequest'] = 'frontend/order/TitlePoint/imageCreateRequest';
$route['getRequestStatus'] = 'frontend/order/TitlePoint/getRequestStatus';
$route['generateImage'] = 'frontend/order/TitlePoint/generateImage';
$route['notifyAdmin'] = 'frontend/order/home/notifyAdmin';
$route['select-files'] = 'frontend/order/dashboard/selectFiles';
$route['getFiles'] = 'frontend/order/dashboard/getFiles';
$route['recordings'] = 'frontend/order/dashboard/recordings';
$route['order/get-recordings'] = 'frontend/order/dashboard/get_recordings';
$route['review-prelim'] = 'frontend/order/resware/reviewPrelim';
$route['instrumentService'] = 'frontend/order/TitlePoint/instrumentService';
$route['attach-files'] = 'frontend/order/dashboard/attach_files';
$route['get-orders'] = 'frontend/order/dashboard/get_orders';
$route['upload-documents/:num'] = 'frontend/order/dashboard/upload_documents';
$route['files-upload'] = 'frontend/order/dashboard/files_upload';
$route['fees'] = 'frontend/order/dashboard/fees';
$route['get-transaction-orders'] = 'frontend/order/dashboard/get_transaction_orders';
$route['get-fees/:num'] = 'frontend/order/dashboard/get_fees';
$route['get-fee-estimate-pdf'] = 'frontend/order/dashboard/get_fee_estimate_pdf';
$route['import-orders'] = 'frontend/order/cron/import_orders';
$route['notes'] = 'frontend/order/dashboard/notes';
$route['get-notes-orders'] = 'frontend/order/dashboard/get_notes_orders';
$route['get-notes/:num'] = 'frontend/order/dashboard/get_notes';
$route['create-note'] = 'frontend/order/dashboard/create_note';
$route['proposed-insured'] = 'frontend/order/dashboard/proposed_insured';
$route['get-proposed-orders'] = 'frontend/order/dashboard/get_proposed_orders';
$route['generate-proposed-insured/:num'] = 'frontend/order/dashboard/generate_proposed_insured';

/* Route for PCT-Order backend*/
$route['order/admin'] = 'admin/order/home/login';
$route['order/admin/home/do_login'] = 'admin/order/home/do_login';
$route['order/admin/dashboard'] = 'admin/order/home/dashboard';
$route['order/admin/import'] = 'admin/order/home/import';
$route['order/admin/import-lenders'] = 'admin/order/home/import_lenders';
$route['order/admin/lenders'] = 'admin/order/home/lenders';
$route['order/admin/agents'] = 'admin/order/agent/index';
$route['order/admin/edit-agent/:num'] = 'admin/order/agent/edit';
$route['order/admin/import-agents'] = 'admin/order/agent/import_agents';
$route['order/admin/logout'] = 'admin/order/home/logout';



/* Route for PCT-Order backend*/
$route['calculator'] = 'frontend/calc/welcome/index';  
$route['calculator/signup'] = 'frontend/calc/welcome/signup';  
$route['calculator/dashboard'] = 'frontend/calc/welcome/dashboard';  
$route['calculator/logout'] = 'frontend/calc/welcome/logout'; 
$route['calculator/view_quote/:num'] = 'frontend/calc/welcome/view_quote';
$route['calculator/admin_login'] = 'frontend/calc/welcome/admin_login';  
$route['calculator/admin_dashboard'] = 'admin/calc/admin/admin_dashboard';
$route['calculator/admin/title_rates'] = 'admin/calc/admin/title_rates'; 
$route['calculator/admin_dashboard_submit'] = 'admin/calc/admin/admin_dashboard_submit'; 
$route['calculator/admin/import_title_rates'] = 'admin/calc/admin/import_title_rates'; 
$route['calculator/admin/edit_title_rates/:num'] = 'admin/calc/admin/edit_title_rates'; 
$route['calculator/admin/resale_rates'] = 'admin/calc/admin/resale_rates'; 
$route['calculator/admin/add_resale_rates'] = 'admin/calc/admin/add_resale_rates'; 
$route['calculator/admin/edit_resale_rates/:num'] = 'admin/calc/admin/edit_resale_rates'; 
$route['calculator/admin/refinance_rates'] = 'admin/calc/admin/refinance_rates'; 
$route['calculator/admin/add_refinance_rates'] = 'admin/calc/admin/add_refinance_rates'; 
$route['calculator/admin/edit_refinance_rates/:num'] = 'admin/calc/admin/edit_refinance_rates'; 
$route['calculator/admin/fees'] = 'admin/calc/admin/fees'; 
$route['calculator/admin/add_fees'] = 'admin/calc/admin/add_fees'; 
$route['calculator/admin/edit_fees/:num'] = 'admin/calc/admin/edit_fees'; 
$route['calculator/admin_logout'] = 'admin/calc/admin/admin_logout'; 



$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;






