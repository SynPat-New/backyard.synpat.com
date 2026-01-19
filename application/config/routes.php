<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = "dashboard";
/*$route['admin'] = "outsource/dataentry";*/
$route['manager'] = "manager_dataentry/index";
$route['manager/index'] = "manager_dataentry/index";
$route['manager/start'] = "manager_dataentry/start_project";
$route['manager/create'] = "manager_dataentry/create_project";
$route['manager/upload_file'] = "manager_dataentry/project_file_upload";
$route['manager/dataentry/update_data'] = "manager_dataentry/update_data";
$route['manager/dataentry/invitation'] = "manager_dataentry/invitation";
$route['manager/dataentry/find_user_data'] = "manager_dataentry/find_user_data";
$route['manager/dataentry/addTemplate'] = "manager_dataentry/addTemplate";
$route['manager/dataentry/sendMassEmail'] = "manager_dataentry/sendMassEmail";
$route['manager/start/(:any)'] = "manager_dataentry/start_project/$1";
$route['manager/account'] = "manager_dataentry/account/";
$route['manager/account/(:any)'] = "manager_dataentry/account/$1";
$route['manager/account_all'] = "manager_dataentry/account_all";
$route['manager/update_project'] = "manager_dataentry/update_project";
$route['manager/mass_payment'] = "manager_dataentry/mass_payment";
$route['manager/project_status'] = "manager_dataentry/project_status";
$route['manager/change_status'] = "manager_dataentry/change_status";
$route['manager/show_me'] = "manager_dataentry/show_me";
$route['manager/login'] = "manager_login/index";
$route['manager/login/login'] = "manager_login/login";
$route['manager/logout'] = "manager_dataentry/logout";
$route['manager/u_singleton'] = "manager_dataentry/u_singleton";
$route['outsource'] = "outsource_dataentry/start_project";
$route['outsource/dataentry'] = "outsource_dataentry/start_project";
$route['outsource/dataentry/logout'] = "outsource_dataentry/logout";
$route['outsource/dataentry/start'] = "outsource_dataentry/start_project";
$route['outsource/dataentry/show_me'] = "outsource_dataentry/show_me";
$route['outsource/dataentry/update_verification_history'] = "outsource_dataentry/updateDropHistory";
$route['outsource/dataentry/start/(:any)'] = "outsource_dataentry/start_project/$1";
$route['outsource/dataentry/temp/(:any)'] = "outsource_dataentry/temp_project/$1";
$route['outsource/dataentry/mydata/(:any)'] = "outsource_dataentry/mydata/$1";
$route['outsource/dataentry/update_data'] = "outsource_dataentry/update_data";
$route['outsource/dataentry/update_singleton'] = "outsource_dataentry/u_singleton";
$route['outsource/dataentry/dialer'] = "outsource_dataentry/dialer_list";
$route['outsource/dataentry/call_verified'] = "outsource_dataentry/call_verified";
$route['outsource/dataentry/verify_email'] = "outsource_dataentry/check_email";
$route['outsource/dataentry/bounce_back'] = "outsource_dataentry/bounce_email";
$route['outsource/dataentry/check_bounce_emails'] = "outsource_dataentry/check_bounce_emails";
$route['outsource/dataentry/profile'] = "outsource_dataentry/profile";
$route['outsource/dataentry/ws_data'] = "outsource_dataentry/ws_data";
$route['outsource/login'] = "outsource_login/index";
$route['outsource/login/index'] = "outsource_login/index";
$route['outsource/register'] = "outsource_login/register";
$route['outsource/forget'] = "outsource_login/forget";
$route['outsource/activate'] = "outsource_login/login";
$route['outsource/resend_activation_code'] = "outsource_login/resend_activation_code";
$route['outsource/activate/(:any)'] = "outsource_login/activate/$1";
$route['outsource/request/(:any)'] = "outsource_login/request/$1";
$route['outsource/change_password'] = "outsource_login/change_password";
$route['outsource/login/login'] = "outsource_login/login";
$route['outsource/login/logout'] = "outsource_login/logout";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */