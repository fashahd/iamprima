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

//Login
$route['default_controller'] 	= 'login/form';
$route['validation'] 			= 'login/validation';
$route['register']              = 'login/register';

//Home
$route['home']					= 'dashboard/front';

//User
$route['profile']				= 'user/myProfile';
$route['account']				= 'user/myAccount';
$route['changePassword']        = 'user/changePassword';
$route['updatepersonal']        = 'user/updatepersonal';
$route['updateApparel']         = 'user/updateApparel';
$route['updateHealth']          = 'user/updateHealth';
$route['updatePB']              = 'user/updatePB';
$route['setGroup'] 		        = 'selection/setGroup';
$route['unsetGroup'] 		    = 'selection/unsetGroup';
$route['setAtlet'] 		        = 'selection/setAtlet';

//Wellness
$route['wellness']              = 'wellness/dataWellness';
$route['filterWellness']        = 'wellness/filterWellness';
$route['grafikWellness']        = 'wellness/grafikWellness';
$route['createWellness']        = 'wellness/createWellness';
$route['saveWellness'] 	        = 'wellness/saveWellness';
$route['getWellnessCalendar']   = 'wellness/getWellnessCalendar';
$route['getModalWellness']      = 'wellness/getModalWellness';

//Training Load
$route['monotonyData'] 	        = 'monotony/monotonyDataTable';
$route['training']	 	        = 'monotony/dataMonotony';
$route['filterMonotony']        = 'monotony/filterMonotony';
$route['createTraining']        = 'monotony/stepOne';
$route['stepTwo']	 	        = 'monotony/stepTwo';
$route['stepThree']	 	        = 'monotony/stepThree';
$route['saveMonotony']	        = 'monotony/saveMonotony';
$route['setAtletMonotony']	    = 'monotony/setAtletMonotony';

//Performance Profiling
$route['profiling'] 	        = 'performance/profiling';
$route['createProfiling']     = 'performance/create';

//Recovery Management
$route['recovery'] 	    = 'recovery/recoveryData';
$route['recoveryTable'] = 'recovery/recoveryTable';
$route['createRecovery'] = 'recovery/createRecovery';

//PMC
$route['pmc'] = 'pmc/dataMonotony';

//Error
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
