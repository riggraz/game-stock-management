<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'products/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// products
$route['products'] = 'products/index';

// users
$route['users'] = 'users/index';

// authentication
$route[LOGIN_PAGE] = 'auth/login';
$route['logout'] = 'auth/logout';