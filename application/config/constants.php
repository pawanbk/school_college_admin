<?php

defined('BASEPATH') OR exit('No direct script access allowed');

defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



// User default password
define('DEFAULT_USER_PASSWORD', 'jobkunja@12345');

//defining constant for employee service type
define('SERVICE_TYPE_MASTER', [
	'PERMANENT' 				=> ['text'=>'Permanent', 'id'=>'1'],
	'PROBATION' 				=> ['text'=>'Probation', 'id'=>'2'],
	'CONTRACT' 					=> ['text'=>'Contract', 'id'=>'3'],
	'INTERN_TRAINEE' 		=> ['text'=>'Intern/Trainee', 'id'=>'4']
]);


//defining constant for employee service event
define('SERVICE_EVENT_MASTER', [
	'APPOINTED' 														=> ['text'=>'Appointed', 'id'=>'1'],
	'TRANSFER' 															=> ['text'=>'Transfer', 'id'=>'2'],
	'PROMOTION' 														=> ['text'=>'Promotion', 'id'=>'3'],
	'SUSPEND' 															=> ['text'=>'Suspend', 'id'=>'4'],
	'DEMOTION_DISCIPLINARY_ACTION' 					=> ['text'=>'Demotion/Disciplinary Action', 'id'=>'5'],
	'RESIGNATION' 													=> ['text'=>'Resignation', 'id'=>'6'],
	'TERMINATED' 														=> ['text'=>'Terminated', 'id'=>'7'],
	'PERMANENT' 														=> ['text'=>'Permanent', 'id'=>'8'],
	'RETIREMENT' 														=> ['text'=>'Retirement', 'id'=>'9'],
	'OTHER'	 																=> ['text'=>'Other', 'id'=>'10'],
	'RE-JOINED'	 														=> ['text'=>'Re-Joined', 'id'=>'11'],
	'BRANCH-TRANSFER'	 											=> ['text'=>'Branch Transfer', 'id'=>'12'],
	'COMPANY-TRANSFER'	 										=> ['text'=>'Company Transfer', 'id'=>'13'],
	'SERVICE_TYPE_CHANGED'	 								=> ['text'=>'Service Type Changed', 'id'=>'14'],
	'DEPARTMENT/UNIT_DESIGNATION_CHANGED'	 	=> ['text'=>'Re-Joined', 'id'=>'15'],
	'PERFORMANCE-REVIEWED'	 	              => ['text'=>'Performance-reviewed', 'id'=>'16'],
]); 


/*defined('ALLOW_EMPLOYEE_ENTRY_SYNC')  OR define('ALLOW_EMPLOYEE_ENTRY_SYNC', 'Y'); // use if want to merge with exiting system*/


//defining constant for employee service event
define('MENU_TYPE', [
	'OUTER' 	=> 'outer',
	'INNER' 	=> 'inner',
]);

//defining constant for employee marital status 
define('MARITAL_STATUS',[
	'SINGLE' 		=> 'single',
	'MARRIED' 	=> 'married',
	'DIVORCED' 	=> 'divorced',
	'WIDOWED' 	=>'widowed'
]);

//defining constant for employement status 
define('EMPLOYEMENT_STATUS',[
	'PENDING' 			=> 'pending',
	'EMPLOYED' 			=> 'employed',
	'NOT-EMPLOYED' 	=>'not-employed',
	'SUSPENDED' 		=>'suspended',
	'RETIRED' 			=>'retired',
]);

//defining constant for employee service type
define('GENDER_MASTER', [
	'MALE'	=> ['text'=>'Male', 'id'=>'1'],
	'FEMALE'	=> ['text'=>'Female', 'id'=>'2'],
	'OTHER'	=> ['text'=>'Other', 'id'=>'3'],
]);

// Defining Nepali Month
define('NEPALI_MONTH', [
	'BAISAKH' 		=> ['text'=>'Baisakh', 'id'=>'01'],
	'JESTHA' 			=> ['text'=>'Jestha', 'id'=>'02'],
	'ASADH' 			=> ['text'=>'Asadh', 'id'=>'03'],
	'SHRAWAN' 		=> ['text'=>'Shrawan', 'id'=>'04'],
	'BHADRA' 			=> ['text'=>'Bhadra', 'id'=>'05'],
	'ASHWIN' 			=> ['text'=>'Ashwin', 'id'=>'06'],
	'KARTIK' 			=> ['text'=>'Kartik', 'id'=>'07'],
	'MANGSHIR' 		=> ['text'=>'Mangshir', 'id'=>'08'],
	'POUSH' 			=> ['text'=>'Poush', 'id'=>'09'],
	'MAGH' 				=> ['text'=>'Magh', 'id'=>'10'],
	'FALGUN' 			=> ['text'=>'Falgun', 'id'=>'11'],
	'CHAITRA' 		=> ['text'=>'Chaitra', 'id'=>'12'],
]);

// Defining Nepali Month
define('ENGLISH_MONTH', [
	'JANUARY' 		=> ['text'=>'January', 'id'=>'01'],
	'FEBRUARY' 		=> ['text'=>'February', 'id'=>'02'],
	'MARCH' 			=> ['text'=>'March', 'id'=>'03'],
	'APRIL' 			=> ['text'=>'April', 'id'=>'04'],
	'MAY' 				=> ['text'=>'May', 'id'=>'05'],
	'JUNE' 				=> ['text'=>'June', 'id'=>'06'],
	'JULY' 				=> ['text'=>'July', 'id'=>'07'],
	'AUGUST' 			=> ['text'=>'August', 'id'=>'08'],
	'SEPTEMBER' 	=> ['text'=>'September', 'id'=>'09'],
	'OCTOBER' 		=> ['text'=>'October', 'id'=>'10'],
	'NOVEMBER' 		=> ['text'=>'November', 'id'=>'11'],
	'DECEMBER' 		=> ['text'=>'December', 'id'=>'12'],
]);


define('SWITCH_USER_PERMISSION', [
	'empId' => [1]
]);

define('MENU_SETUP_PERMISSION', [
	'empId' => [1]
]);



