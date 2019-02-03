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

/*
* Write your custom routes below this line.
*/

/*
* Please do not edit the routes below.
*/

$route['default_controller'] = "main";
$route['404_override'] = '';

//Gallery Routes
$route['gallery'] = 'gallery';
$route['gallery/(:any)'] = 'gallery/$1';
$route['admin/gallery'] = 'gallerya';
$route['admin/gallery_data'] = 'gallerya/gallery_data';
$route['admin/gallery_data/(:num)'] = 'gallerya/gallery_data/$1';
$route['admin/gallery/(:any)'] = 'gallerya/$1';
/********************** arul  26-04-2014 *************************************/
$route['document/(:any)']='document/$1';
/********dhiru 26-04-14 *******/
$route['group'] = 'group/manage';
$route['group/(:any)'] = 'group/$1';
$route['document'] = 'document/manage';




$route['manage_users/(:any)'] = 'manage_users/$1';
$route['external_users/(:any)'] = 'external_users/$1';
$route['roles/(:any)'] = 'roles/$1';
$route['support/(:any)'] = 'support/$1';
$route['send_contact_ajax'] = 'main/send_contact_ajax';
$route['install'] = 'install';
$route['main/(:any)'] = 'main/$1';
$route['admin'] = 'admin';
$route['admin/(:any)'] = 'admin/$1';
$route['user/(:any)'] = 'user/$1';

$route['register'] = 'main/register';
$route['login'] = 'main/login';
$route['home'] = 'main/login';
$route['login_error'] = 'main/login_error';
$route['logout'] = 'main/logout';
$route['activate/(:any)'] = 'main/activate/$1';
$route['page/(:any)'] = 'main/page/$1';
$route['password/(:any)'] = 'main/reset_password/$1';
$route['(:any)'] = 'main/page/$1';




/****************** my routers start ************************/

$route["readme"]='install/readme';


/* End of file routes.php */
/* Location: ./application/config/routes.php */