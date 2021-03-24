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
$route['dashboard'] = 'frontend/order/dashboard/index';
$route['special-dashboard'] = 'frontend/order/dashboard/index';
$route['order/login'] = 'frontend/order/login/index';
$route['order/login_test'] = 'frontend/order/login/loginTest';
$route['do_login'] = 'frontend/order/login/do_login';
$route['do_login_test'] = 'frontend/order/login/do_login_test';
$route['change-password/:any'] = 'frontend/order/login/change_password';
$route['logout'] = 'frontend/order/home/logout';
$route['home/getSearchResults'] = 'frontend/order/home/getSearchResults';
$route['home/checkEmail'] = 'frontend/order/home/checkEmail';
$route['home/getCustomerNumber'] = 'frontend/order/home/getCustomerNumber';
$route['agent/getAgentDetails'] = 'frontend/order/agent/getAgentDetails';
$route['home/getCustomerDetails'] = 'frontend/order/home/getCustomerDetails';
$route['home/getDetailsByName'] = 'frontend/order/home/getDetailsByName';
$route['order-submit/:num'] = 'frontend/order/home/orderSubmit';
$route['createService'] = 'frontend/order/TitlePoint/createService';
$route['getRequestSummaries'] = 'frontend/order/TitlePoint/getRequestSummaries';
$route['getResultById'] = 'frontend/order/TitlePoint/getResultById';
$route['imageCreateRequest'] = 'frontend/order/TitlePoint/imageCreateRequest';
$route['getRequestStatus'] = 'frontend/order/TitlePoint/getRequestStatus';
$route['generateImage'] = 'frontend/order/TitlePoint/generateImage';
$route['notifyAdmin'] = 'frontend/order/home/notifyAdmin';
$route['prelim-files'] = 'frontend/order/dashboard/prelimFiles';
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
$route['generate-proposed-insured'] = 'frontend/order/dashboard/generate_proposed_insured';
$route['cpl-dashboard'] = 'frontend/order/dashboard/cpl';
$route['get-orders-cpl'] = 'frontend/order/dashboard/get_orders_cpl';
$route['create-cpl/:num'] = 'frontend/order/dashboard/create_cpl';
$route['download-cpl-pdf'] = 'frontend/order/dashboard/donloadCplPdf';
$route['add-lender-order'] = 'frontend/order/dashboard/addLenderOnOrder';
$route['add-order-details'] = 'frontend/order/dashboard/add_order_details';
$route['get-orders-prelim'] = 'frontend/order/dashboard/get_orders_prelim';
$route['review-file/:num'] = 'frontend/order/dashboard/review_file';
$route['import-orders-all-users'] = 'frontend/order/cron/import_orders_all_users';
$route['summary'] = 'frontend/order/dashboard/summary';
$route['prelim'] = 'frontend/order/dashboard/prelim';
$route['load-doc'] = 'frontend/order/dashboard/load_doc';
$route['legal-vesting'] = 'frontend/order/dashboard/legal_vesting';
$route['plat-map'] = 'frontend/order/dashboard/plat_map';
$route['download-document'] = 'frontend/order/dashboard/download_document';
$route['resware-fetch-data'] = 'frontend/order/ReviewPrelim/fetchData';
$route['test-mail'] = 'frontend/order/ReviewPrelim/testMail';
$route['generate-plat-map'] = 'frontend/order/dashboard/generate_plat_map';
$route['get-order-details'] = 'frontend/order/dashboard/get_order_details';
$route['update-order-details'] = 'frontend/order/dashboard/update_order_details';
$route['get-order-details-cpl'] = 'frontend/order/dashboard/getOrderDetailsCpl';
$route['create-cpl-for-natic/:num'] = 'frontend/order/dashboard/createCPlForNatic';
$route['import-product-types'] = 'frontend/order/cron/import_product_types';
$route['check-update-password'] = 'frontend/order/cron/check_update_password';
$route['generate-grant-deed'] = 'frontend/order/TitlePoint/generateGrantDeed';
$route['get-product-types'] = 'frontend/order/home/getProductTypes';
$route['update-user-details'] = 'frontend/order/cron/update_user_details';
$route['create-cpl-for-fnf/:num'] = 'frontend/order/dashboard/createCPlForFnf';
$route['update-password'] = 'frontend/order/cron/updatePassword';
$route['company-information'] = 'frontend/order/cron/getCompanyInformation';
$route['generate-tax-doc'] = 'frontend/order/TitlePoint/generateTaxDoc';
$route['home/checkDuplicateOrder'] = 'frontend/order/home/checkDuplicateOrder';
$route['special-lender-dashboard'] = 'frontend/order/SpecialDashboard/index';
$route['get-special-lenders-orders'] = 'frontend/order/SpecialDashboard/get_special_lenders_orders';
$route['special-dashboard/logout'] = 'frontend/order/SpecialDashboard/logout';
$route['generate-cpl/:any'] = 'frontend/order/dashboardMail/generateCplFromMail';
$route['generate-fees/:any'] = 'frontend/order/dashboardMail/generateFeesFromMail';
$route['add-lender-order-mail'] = 'frontend/order/dashboardMail/addLenderOnOrder';
$route['get-order-details-cpl-mail'] = 'frontend/order/dashboardMail/getOrderDetailsCpl';
$route['create-cpl-for-fnf-mail/:num'] = 'frontend/order/dashboardMail/createCPlForFnf';
$route['create-cpl-mail/:num'] = 'frontend/order/dashboardMail/create_cpl';
$route['create-cpl-for-natic-mail/:num'] = 'frontend/order/dashboardMail/createCPlForNatic';
$route['proposed-insured/:any'] = 'frontend/order/dashboardMail/proposedInsured';
$route['getDetailsByName'] = 'frontend/order/dashboardMail/getDetailsByName';
$route['update-remote-file-numbers'] = 'frontend/order/cron/updateRemoteFileNumberForAllOrders';
$route['generate-mail-proposed-insured'] = 'frontend/order/dashboardMail/generate_mail_proposed_insured';
$route['add-mail-order-details'] = 'frontend/order/dashboardMail/add_mail_order_details';
$route['get-sales-orders'] = 'frontend/order/dashboard/get_sales_orders';
$route['import-sales-rep-orders'] = 'frontend/order/cron/import_sales_rep_orders';
$route['get-partners'] = 'frontend/order/dashboard/get_partners';
$route['import-all-sales-rep-orders'] = 'frontend/order/cron/import_all_sales_rep_orders';
$route['get-sales-rep-orders-count'] = 'frontend/order/dashboard/get_sales_rep_orders_count';
$route['export-users/:any'] = 'frontend/order/cron/exportUsers';
$route['borrower-information/:any'] = 'frontend/order/dashboardMail/borrowerInformation';
$route['borrower-information/:any/:any'] = 'frontend/order/dashboardMail/borrowerInformation';
$route['generate-verification-code'] = 'frontend/order/dashboardMail/generate_verification_code';
$route['code-verification'] = 'frontend/order/dashboardMail/code_verification';
$route['borrower-details'] = 'frontend/order/dashboardMail/borrowerDetails';
$route['borrower-info-submit'] = 'frontend/order/dashboardMail/borrowerInfoSubmit';
$route['generic-landing-page'] = 'frontend/order/dashboardMail/genericLandingPage';
$route['get-order-information/:any'] = 'frontend/order/cron/getOrderInformation';
$route['update-order-status'] = 'frontend/order/cron/updateOrderStatus';
$route['create-order-safewire'] = 'frontend/order/dashboardMail/createOrderSafewire';
$route['get-safewire-order-status'] = 'frontend/order/dashboardMail/getSafewireOrderStatus';
$route['update-safewire-orders-status'] = 'frontend/order/cron/updateSafewireStatusForAllorders';
$route['update-prelim-action/:num'] = 'frontend/order/dashboard/updatePrelimAction';
$route['send-mail-escrow-users'] = 'frontend/order/cron/sendMailEscrowUsers';

/* Route for PCT-Order backend*/
$route['order/admin'] = 'admin/order/home/login';
$route['order/admin/home/do_login'] = 'admin/order/home/do_login';
$route['order/admin/dashboard'] = 'admin/order/home/index';
$route['order/admin/escrow'] = 'admin/order/home/dashboard';
$route['order/admin/import'] = 'admin/order/home/import';
$route['order/admin/import-lenders'] = 'admin/order/home/import_lenders';
$route['order/admin/lenders'] = 'admin/order/home/lenders';
$route['order/admin/agents'] = 'admin/order/agent/index';
$route['order/admin/edit-agent/:num'] = 'admin/order/agent/edit';
$route['order/admin/import-agents'] = 'admin/order/agent/import_agents';
$route['order/admin/logout'] = 'admin/order/home/logout';
$route['order/admin/sales-rep'] = 'admin/order/sales/index';
$route['order/admin/get-sales-rep-list'] = 'admin/order/sales/get_sales_rep_list';
$route['order/admin/add-sales-rep'] = 'admin/order/sales/add_sales_rep';
$route['order/admin/edit-sales-rep/:num'] = 'admin/order/sales/edit_sales_rep';
$route['order/admin/title-officers'] = 'admin/order/title/index';
$route['order/admin/get-title-officer-list'] = 'admin/order/title/get_title_officer_list';
$route['order/admin/add-title-officer'] = 'admin/order/title/add_title_officer';
$route['order/admin/edit-title-officer/:num'] = 'admin/order/title/edit_title_officer';
$route['order/admin/credentials-check'] = 'admin/order/customer/index';
$route['order/admin/lv-log'] = 'admin/order/TitlePoint/index';
$route['order/admin/primary-check'] = 'admin/order/home/primaryCheck';
$route['order/admin/get-user-check-list'] = 'admin/order/home/get_user_check_list';
$route['order/admin/orders(/:any)?'] = 'admin/order/order/orders';
$route['order/admin/get-order-list'] = 'admin/order/order/get_order_list';
$route['order/admin/cpl-documents'] = 'admin/order/home/cpl_document';
$route['order/admin/order-details/:num'] = 'admin/order/order/order_details';
$route['order/admin/export-orders'] = 'admin/order/order/export_orders';
$route['order/admin/new-users'] = 'admin/order/home/newUsers';
$route['order/admin/add-new-user'] = 'admin/order/home/addNewUser';
$route['order/admin/grant-deed-documents'] = 'admin/order/home/grant_deed_document';
$route['order/admin/lv-documents'] = 'admin/order/home/lv_document';
$route['order/admin/master-users'] = 'admin/order/home/masterUsers';
$route['order/admin/add-new-master-user'] = 'admin/order/home/addNewMasterUser';
$route['order/admin/tax-log'] = 'admin/order/TitlePoint/taxLog';
$route['order/admin/tax-documents'] = 'admin/order/home/tax_document';
$route['order/admin/grant-deed-log'] = 'admin/order/TitlePoint/grantDeedLog';
$route['order/admin/curative-documents'] = 'admin/order/home/curative_document';
$route['order/admin/companies'] = 'admin/order/home/companies';
$route['order/admin/add-company'] = 'admin/order/home/addCompany';
$route['order/admin/incorrect-users'] = 'admin/order/home/incorrect_users';
$route['order/admin/partner-api-log'] = 'admin/order/order/partnerApiLogs';
$route['order/admin/update-order-details'] = 'admin/order/order/update_order_details';
$route['order/admin/fees'] = 'admin/order/fees/index';
$route['order/admin/add-fee'] = 'admin/order/fees/add_fee';
$route['order/admin/edit-fee/:num'] = 'admin/order/fees/edit_fee';
$route['order/admin/import-underwriters'] = 'admin/order/home/import_underwriters';
$route['order/admin/update-underwriter'] = 'admin/order/home/updateUnderwriter';
$route['order/admin/fees-types'] = 'admin/order/FeesTypes/index';
$route['order/admin/add-fee-type'] = 'admin/order/FeesTypes/add_fee_type';
$route['order/admin/edit-fee-type/:num'] = 'admin/order/FeesTypes/edit_fee_type';
$route['order/admin/code-book'] = 'admin/order/CodeBook/index';
$route['order/admin/add-code-book'] = 'admin/order/CodeBook/add_code_book';
$route['order/admin/import-code-book'] = 'admin/order/CodeBook/import_code_book';
$route['order/admin/update-type'] = 'admin/order/CodeBook/updateType';
$route['order/admin/cpl-proposed-users'] = 'admin/order/home/cplProposedUsers';
$route['order/admin/edit-cpl-proposed-user/:num'] = 'admin/order/home/editCplProposedUser';
$route['order/admin/reject-cpl-proposed-user/:num'] = 'admin/order/home/rejectCplProposedUser';
$route['order/admin/edit-code-book/:num'] = 'admin/order/CodeBook/editCodeBook';
$route['order/admin/send-password'] = 'admin/order/home/sendPassword';
$route['order/admin/resware-admin-credential'] = 'admin/order/home/reswareAdminCredential';
$route['order/admin/edit-master-user/:num'] = 'admin/order/home/editMasterUser';
$route['order/admin/import-orders'] = 'admin/order/home/importOrders';
$route['order/admin/cpl-error-logs'] = 'admin/order/order/cplErrorLogs';
$route['order/admin/get-cpl-error-logs'] = 'admin/order/order/getCplErrorLogs';
$route['order/admin/update-transaction'] = 'admin/order/home/updateTransaction';
$route['order/admin/rules-manager'] = 'admin/order/rulesManager/index';
$route['order/admin/notifications'] = 'admin/order/home/notifications';
$route['order/admin/safewire-orders'] = 'admin/order/order/safewireOrders';
$route['order/admin/get-safewire-orders-list'] = 'admin/order/order/get_safewire_orders_list';
$route['store-deliverables'] = 'admin/order/home/storeDeliverables';


$route['order/admin/get-realtors-list'] = 'admin/order/home/get_realtors_list';


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