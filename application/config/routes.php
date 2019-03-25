<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// authentication
$route[LOGIN_PAGE] = 'auth/login';
$route['logout'] = 'auth/logout';

// users
$route['users'] = 'users/index';