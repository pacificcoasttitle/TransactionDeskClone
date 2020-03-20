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


$route['default_controller'] = 'frontend/login/index';
$route['order'] = 'frontend/home/index';
$route['dashboard'] = 'frontend/home/dashboard';
$route['login'] = 'frontend/login/index';
$route['do_login'] = 'frontend/login/do_login';
$route['logout'] = 'frontend/home/logout';
$route['home/getSearchResults'] = 'frontend/home/getSearchResults';
$route['home/checkEmail'] = 'frontend/home/checkEmail';
$route['home/getCustomerNumber'] = 'frontend/home/getCustomerNumber';
$route['agent/getAgentDetails'] = 'frontend/agent/getAgentDetails';
$route['home/getCustomerDetails'] = 'frontend/home/getCustomerDetails';
$route['home/getDetailsByName'] = 'frontend/home/getDetailsByName';
$route['order-submit'] = 'frontend/home/orderSubmit';
$route['createService'] = 'frontend/TitlePoint/createService';
$route['getRequestSummaries'] = 'frontend/TitlePoint/getRequestSummaries';
$route['getResultById'] = 'frontend/TitlePoint/getResultById';
$route['imageCreateRequest'] = 'frontend/TitlePoint/imageCreateRequest';
$route['getRequestStatus'] = 'frontend/TitlePoint/getRequestStatus';
$route['generateImage'] = 'frontend/TitlePoint/generateImage';

$route['index'] = 'frontend/index/index';

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


$route['admin'] = 'admin/home/login';
$route['admin/dashboard'] = 'admin/home/dashboard';
$route['admin/import'] = 'admin/home/import';
$route['admin/import-lenders'] = 'admin/home/import_lenders';
$route['admin/lenders'] = 'admin/home/lenders';
$route['admin/agents'] = 'admin/agent/index';
$route['admin/edit-agent/:num'] = 'admin/agent/edit';
$route['admin/import-agents'] = 'admin/agent/import_agents';
$route['admin/logout'] = 'admin/home/logout';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
