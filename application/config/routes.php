<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin'] = 'auth/login';
$route['admin/users'] = 'auth/users';
$route['admin/user_profile'] = 'auth/user_profile';

$route['admin/dashboard'] = 'dashboard/index';

$route['admin/personnel'] = 'personnel/index';
$route['admin/personnel_attendace/(:num)'] = 'personnel/personnel_attendance/$1';
$route['create_personnel'] = 'personnel/create';

$route['admin/attendance'] = 'attendance/index';
$route['admin/generate_dtr'] = 'attendance/generate_dtr';
$route['admin/generate_dtr/(:num)'] = 'attendance/generate_dtr/$1';

$route['admin/biometrics'] = 'biometrics/index';
$route['admin/generate_bio'] = 'biometrics/generate_bioreport';
