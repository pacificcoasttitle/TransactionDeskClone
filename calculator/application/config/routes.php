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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller']              = 'welcome';
$route['about']                           = "welcome/about_e_portfolio";
$route['get_cities']                      = "welcome/get_cities";
$route['terms']                           = "welcome/terms_of_services";
$route['privacy-policy']                  = "welcome/data_protection";
$route['login']                           = "welcome/login";
$route['signup']                          = "welcome/register";
$route['faqs']                            = "welcome/faq";
$route['contact']                         = "welcome/contact";
$route['career']                          = "welcome/career";
$route['view-job/(:any)/(:any)']          = "welcome/career_inner/$1";
$route['view-external-job/(:any)/(:any)'] = "welcome/external_career_inner/$1";
$route['search']                          = "welcome/search";
$route['all-profiles/(:any)']             = "user/all_e_portfolio/$1";
$route['speciality/(:any)/(:any)']        = "user/e_portfolios/$1/$2";
$route['speciality/(:any)']               = "user/e_portfolios/$1";
$route['user-articles/(:any)']            = "user/user_articles/$1";
$route['all-profiles']                    = "user/all_e_portfolio";
$route['deposit-manage-content']          = "welcome/deposit_manage_content";
$route['independent-peer-review']         = "welcome/independent_peer_review";
$route['become-reviewer']                 = "welcome/become_reviewer";
$route['publish-sell']                    = "welcome/publish_sell";
$route['manuscript-development']          = "welcome/manuscript_development";
$route['editing']                         = "welcome/editing";
$route['translation']                     = "welcome/translation";
$route['formatting']                      = "welcome/formatting";
$route['figure_prep']                     = "welcome/figure_prep";
$route['hire-us']                         = "welcome/charges";
$route['speciality-articles/(:any)']      = "welcome/specialty/$1";
$route['articles']                        = "welcome/index1";
$route['user']                            = "user/index";
$route['my-profile']                      = "user/index";
$route['logout']                          = "welcome/logout";
$route['dashboard']                       = "user/dashboard";
$route['uploaded-articles']               = "user/dashboard";
$route['downloaded-articles']             = "user/downloaded_articles";
$route['purchased-articles']              = "user/purchased_articles";
$route['saved-articles']                  = "user/saved_articles";
$route['edit-profile']                    = "user/edit_profile";
$route['edit-bank-profile']               = "user/edit_bank_profile";
$route['create-my-profile']               = "user/create_my_e_portfolio";
$route['uplaod-articles']                 = "user/upload_article";
$route['change-password']                 = "user/change_password";
$route['support']                         = "welcome/support";
$route['view-ticket-thread/(:any)']       = "welcome/view_ticket_thread/$1";
$route['peer-review-steps']               = "welcome/peer_review_steps";
$route['manuscript-submission']           = "welcome/manuscript_submission";
$route['job-reference']                   = "welcome/job_reference";
$route['submit-resume']                   = "welcome/submit_resume";
$route['request-quote']                   = "welcome/request_quote";
$route['become_reviewer_apply']           = "welcome/become_reviewer_apply";
$route['multimedia']                      = "welcome/coming_soon"; //"welcome/multimedia";
$route['media-stories']                   = "welcome/coming_soon"; //"welcome/storymedia";
$route['books']                           = "welcome/coming_soon"; //"welcome/books";
$route['events']                          = "welcome/coming_soon"; //"welcome/events";
$route['societies']                       = "welcome/coming_soon"; //"welcome/ngos";
$route['institutions']                    = "welcome/coming_soon";// "welcome/institutions";
$route['view-book/(:any)']                = "welcome/coming_soon"; //"welcome/view_book/$1";
$route['buy-book/(:any)']                 = "welcome/coming_soon";//"welcome/buy_book/$1";
$route['order-summary/(:any)']            = "welcome/coming_soon";//"user/order_summary/$1";
$route['get-access-book/(:any)']          = "welcome/coming_soon";//"welcome/get_access/$1";
$route['article-proforma']                = "welcome/coming_soon";//"welcome/proforma";
$route['general-proforma']                = "welcome/coming_soon";//"welcome/general_proforma";
$route['external-jobs']                   = "welcome/external_jobs";
$route['post-external-job']               = "welcome/post_external_job";
$route['get-article-info/(:any)']         = "user/view_article/$1";
$route['search-elsevier-article']         = "welcome/search_elsevier_article";

$route['coming-soon'] = "welcome/coming_soon";

$route['404_override'] = "welcome/error";
$route['translate_uri_dashes'] = FALSE;
