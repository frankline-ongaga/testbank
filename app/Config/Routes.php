<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
//$routes->set404Override('My404'); // Custom 404 controller

// Static Pages
$routes->get('/', 'Home::index');

$routes->get('pricing', 'Home::pricing');
$routes->get('order_now', 'Home::order_now');
$routes->get('how_it_works', 'Home::how_it_works');
$routes->get('client', 'Home::client');
$routes->get('technical_order', 'Home::technical_order');
$routes->get('terms', 'Home::terms');
$routes->get('privacy', 'Home::privacy');
$routes->get('about_us', 'Home::about_us');
$routes->get('refund_policy', 'Home::refund_policy');
$routes->get('blog', 'Home::blog');
$routes->get('samples', 'Home::sample_papers');
$routes->get('tutors', 'Home::tutors');
$routes->get('courses', 'Home::courses');
$routes->get('teas', 'Home::teas');
$routes->get('nclex', 'Home::nclex');
$routes->get('hesi2', 'Home::hesi2');
$routes->get('reviews', 'Home::reviews');

// Dynamic route with one segment
$routes->get('sample_details/(:any)', 'Home::sample_details/$1');

// Dynamic route with two segments
$routes->get('sitemap/(:any)/(:any)', 'Home::sitemap/$1/$2');

// Static sitemap
$routes->get('sitemap_loc', 'Home::sitemap_loc');

//client

$routes->get('client', 'Client::index');
$routes->get('client/profile', 'Client::profile');
$routes->post('client/updateProfile', 'Client::updateProfile');
$routes->get('logout', 'Client::logout');


//api
$routes->get('api/category/(:num)', 'Api::get_categories_content/$1');


//admin
$routes->get('admin', 'Admin::index');
$routes->get('admin/viewUsers', 'Admin::viewUsers');
$routes->get('admin/addUser', 'Admin::addUser');
$routes->post('admin/saveUser', 'Admin::saveUser');
$routes->get('admin/editUser/(:num)', 'Admin::editUser/$1');
$routes->post('admin/updateUser', 'Admin::updateUser');
$routes->get('admin/deleteUser/(:num)', 'Admin::deleteUser/$1');