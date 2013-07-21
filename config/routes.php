<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
| 	www.your-site.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://www.codeigniter.com/user_guide/general/routing.html
*/

/* public */
$route['metrouni/faculty(/:any)?'] = 'faculty$1';

/* admin */
$route['metrouni/admin/persons(/:any)?'] = 'admin_persons$1';
$route['metrouni/admin/faculties(/:any)?'] = 'admin_faculties$1';
$route['metrouni/admin/semesters(/:any)?'] = 'admin_semesters$1';
$route['metrouni/admin/hours(/:any)?'] = 'admin_hours$1';