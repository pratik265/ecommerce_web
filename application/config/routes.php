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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ========================================
// USER PANEL ROUTES (Clean URLs)
// ========================================

// Authentication routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';
$route['profile'] = 'auth/profile';

// Product routes
$route['products'] = 'home/products';
$route['product/(:any)'] = 'home/product/$1';

// Blog routes
$route['blogs'] = 'home/blogs';
$route['blog/(:any)'] = 'home/blog/$1';

// Cart and checkout routes
$route['cart'] = 'home/cart';
$route['checkout'] = 'home/checkout';
$route['add_to_cart'] = 'home/add_to_cart';
$route['update_cart'] = 'home/update_cart';
$route['place_order'] = 'home/place_order';
$route['order/success/(:num)'] = 'home/order_success/$1';

// Search route
$route['search'] = 'home/search';

// ========================================
// ADMIN PANEL ROUTES (All start with /admin)
// ========================================

// Admin authentication
$route['admin/login'] = 'auth/admin_login';
$route['admin/logout'] = 'auth/admin_logout';

// Admin main routes
$route['admin'] = 'admin/dashboard';
$route['admin/dashboard'] = 'admin/dashboard';

// Admin user management
$route['admin/users'] = 'admin/users';
$route['admin/users/block/(:num)'] = 'admin/block_user/$1';
$route['admin/users/unblock/(:num)'] = 'admin/unblock_user/$1';
$route['admin/users/delete/(:num)'] = 'admin/delete_user/$1';

// Admin product management
$route['admin/products'] = 'admin/products';
$route['admin/products/add'] = 'admin/add_product';
$route['admin/products/edit/(:num)'] = 'admin/edit_product/$1';
$route['admin/products/delete/(:num)'] = 'admin/delete_product/$1';

// Admin blog management
$route['admin/blogs'] = 'admin/blogs';
$route['admin/blogs/add'] = 'admin/add_blog';
$route['admin/blogs/edit/(:num)'] = 'admin/edit_blog/$1';
$route['admin/blogs/delete/(:num)'] = 'admin/delete_blog/$1';

// Admin order management
$route['admin/orders'] = 'admin/orders';
$route['admin/orders/view/(:num)'] = 'admin/view_order/$1';
$route['admin/orders/update-status/(:num)'] = 'admin/update_order_status/$1';

// Admin export functionality
$route['admin/export_orders_pdf'] = 'admin/export_orders_pdf';
$route['admin/export_orders_excel'] = 'admin/export_orders_excel';
$route['admin/export_order_pdf/(:num)'] = 'admin/export_order_pdf/$1';
$route['admin/export_reports_pdf'] = 'admin/export_reports_pdf';
$route['admin/export_reports_excel'] = 'admin/export_reports_excel';
$route['admin/export_products_pdf'] = 'admin/export_products_pdf';
$route['admin/export_products_excel'] = 'admin/export_products_excel';

// Admin reports
$route['admin/reports'] = 'admin/reports';

// Chat Routes
$route['chat'] = 'chat/index';
$route['chat/send_message'] = 'chat/send_message';
$route['chat/get_messages'] = 'chat/get_messages';
$route['chat/check_new_messages'] = 'chat/check_new_messages';

// Admin Chat Routes
$route['admin/chat'] = 'admin/chat';
$route['admin/chat_room/(:num)'] = 'admin/chat_room/$1';
$route['admin/send_admin_message'] = 'admin/send_admin_message';
$route['admin/get_room_messages/(:num)'] = 'admin/get_room_messages/$1';
$route['admin/check_admin_new_messages/(:num)'] = 'admin/check_admin_new_messages/$1';
$route['admin/delete_chat_room/(:num)'] = 'admin/delete_chat_room/$1';
