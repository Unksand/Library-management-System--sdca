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
$route['default_controller'] = 'Auth/login';
$route['auth/main'] = 'Auth/main';
$route['admin/dashboard'] = 'Dashboard/Auth';
$route['admin/manage_issued_books'] = 'Auth/manage_issued_books';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['auth/add_category'] = 'Auth/add_category';
$route['auth/manage_categories'] = 'Auth/manage_categories';
$route['auth/add_author'] = 'Auth/add_author';
$route['auth/manage_authors'] = 'Auth/manage_authors';
$route['Auth/edit-author/(:num)'] = 'Auth/edit_author/$1';
$route['auth/add_book'] = 'Auth/add_book';
$route['auth/search_books'] = 'Auth/search_books';
$route['auth/manage_books'] = 'Auth/manage_books';
$route['auth/issue_book'] = 'Auth/issue_book';
$route['auth/manage_issued_books'] = 'Auth/manage_issued_books';
$route['Auth/update_issue_bookdeails/(:num)'] = 'Auth/update_issue_bookdeails/$1';
$route['Auth/school-programs'] = 'Auth/school_programs';
$route['Auth/reg-students'] = 'Auth/reg_students';
$route['Auth/reg-staff'] = 'Auth/reg_staff';
$route['auth/block_student/(:num)'] = 'auth/block_student/$1';
$route['auth/activate_student/(:num)'] = 'auth/activate_student/$1';
$route['auth/student_history/(:any)'] = 'Auth/student_history/$1';
$route['auth/change_password'] = 'Auth/change_password';
$route['auth/analytics'] = 'Analytics/index';