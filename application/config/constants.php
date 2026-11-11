<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/

//$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
//$http_host = $_SERVER['HTTP_HOST']; 
//if($http_host == 'tsqctc.neoehs.com'){
//  if(preg_match("/http:\/\//",$protocol)){
//    $protocol = 'https://';
//  }
//}
//$baseurl = $protocol.$_SERVER['HTTP_HOST'];
//$baseurl .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
//
//
//defined('HTTPHOST')        OR define('HTTPHOST', $protocol);
//defined('HTTP_HOST')            OR define('HTTP_HOST', $http_host);
//defined('SITE_TITLE')         OR define('SITE_TITLE', 'NITHYA');


/*Database Connectivity*/



$aHttpSever = [
    '192.168.0.250', '103.88.129.32','ardhas.tk','neoembassy.tk','ardhas.cf','52.66.184.170','104.211.139.218'
];
$aHttpsServer = [
    'development.ardhas.com'
];

$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
$http_host = $_SERVER['HTTP_HOST'];

if (in_array($http_host, $aHttpsServer)) {
    if (preg_match("/http:\/\//", $protocol)) {
        $protocol = 'https://';
    }
}

$baseurl = $protocol . $_SERVER['HTTP_HOST'];
$baseurl .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
/*
 * Database Connectivity
 */
$aHost = array_merge($aHttpSever, $aHttpsServer);

if (in_array($http_host, $aHost)) {
//   $active_group = 'ardhas';
    defined('DB_HOST')      OR define('DB_HOST', 'localhost');
   // defined('DB_NAME')      OR define('DB_NAME', 'lumut_port_dev_v1');
//defined('DB_NAME')      OR define('DB_NAME', 'lumut_port_dev_v3_demo');
     defined('DB_NAME')      OR define('DB_NAME', 'v1_lumut_updated');

    defined('DB_USER')      OR define('DB_USER', 'root');
    defined('DB_PASS')      OR define('DB_PASS', 'xQ5}eD6>vD6{mZ4*kK5');
    defined('DB_PREFIX')    OR define('DB_PREFIX', '');
//    defined('IMGSITEURL')   OR define('IMGSITEURL','http://103.88.129.32/Kabani/v1/');
//    
    // defined('SMTP_HOST')            OR define('SMTP_HOST', 'smtp.easycgi.com');
    // defined('SMTP_PORT')            OR define('SMTP_PORT', '587');
    // defined('SMTP_USER')            OR define('SMTP_USER', 'neoehs@ardhas.com');
    // defined('SMTP_PWD')             OR define('SMTP_PWD', "F42z^Y}tcB'Xp%aED>68");
    // defined('SMTP_FROM_ADDR')       OR define('SMTP_FROM_ADDR', 'neoehs@ardhas.com');
//     defined('SMTP_HOST')            or define('SMTP_HOST', 'smtp.easycgi.com');
// defined('SMTP_PORT')            or define('SMTP_PORT', '587');
// defined('SMTP_USER')            or define('SMTP_USER', 'evisa@neoehs.com');
// defined('SMTP_PWD')             or define('SMTP_PWD', "2L%*qJ73i>yi");
// defined('SMTP_FROM_ADDR')       or define('SMTP_FROM_ADDR', 'evisa@neoehs.com');
  defined('SMTP_HOST') or define('SMTP_HOST', 'smtp.gmail.com');
  defined('SMTP_PORT') or define('SMTP_PORT', '587');
  defined('SMTP_USER') or define('SMTP_USER', 'spk0904r@gmail.com');
  defined('SMTP_PWD') or define('SMTP_PWD', 'dtdlxgxervnjracn');
  defined('SMTP_FROM_ADDR') or define('SMTP_FROM_ADDR', 'spk0904r@gmail.com');
  defined('SMTP_FROM_NAME') or define('SMTP_FROM_NAME', 'Praveen');
}
else {
//   $active_group = 'local';
    defined('DB_HOST')      OR define('DB_HOST', '127.0.0.1:3306');
    // defined('DB_HOST') OR define('DB_HOST', 'host.docker.internal:3306');

defined('DB_NAME') OR define('DB_NAME', 'v1_lumut_updated');

defined('DB_USER') OR define('DB_USER', 'root');

defined('DB_PASS') OR define('DB_PASS', '');

defined('DB_PREFIX') OR define('DB_PREFIX', '');
   // defined('DB_NAME')      OR define('DB_NAME', 'lumut_port_dev_v3_demo');
    // defined('DB_NAME')      OR define('DB_NAME', 'V1_lumut_live');
    
   // defined('DB_NAME')      OR define('DB_NAME', 'lumut_port_dev_v1');
    defined('DB_USER')      OR define('DB_USER', 'root');
    defined('DB_PASS')      OR define('DB_PASS', '');
    defined('DB_PREFIX')    OR define('DB_PREFIX', '');
//    defined('IMGSITEURL')   OR define('IMGSITEURL','http://103.88.129.32/Kabani/v1/');
    
    defined('SMTP_HOST')            OR define('SMTP_HOST', 'smtp.gmail.com');
    defined('SMTP_PORT')            OR define('SMTP_PORT', '587');
    defined('SMTP_USER')            OR define('SMTP_USER', 'spk0904r@gmail.com');
    defined('SMTP_PWD')             OR define('SMTP_PWD', 'dtdlxgxervnjracn');
    defined('SMTP_FROM_ADDR')       OR define('SMTP_FROM_ADDR', 'spk0904r@gmail.com');
    defined('SMTP_FROM_NAME')       OR define('SMTP_FROM_NAME', 'LUMUT');
}


defined('TEST_MODE')       OR define('TEST_MODE', TRUE);
defined('TEST_EMAILID')       OR define('TEST_EMAILID', 'mkesav.ardhas@gmail.com,harsine.ardhas@gmail.com,nithyashreemukund.ardhas@gmail.com,suganya.p@ardhas.com');

defined('BASE_URL')            OR define('BASE_URL', $baseurl);
defined('DEFAULT_LANG')   OR define('DEFAULT_LANG', 'english');
defined('SITE_TITLE')         OR define('SITE_TITLE', 'NEOEHS');

//$tablePrefix = 'kab_';
//defined('TAB_PRE')            OR define('TAB_PRE', $tablePrefix);
//Template design
defined('LAYOUT_PLUG_PATH')           OR define('LAYOUT_PLUG_PATH', BASE_URL.'assets/plugins/');
defined('LAYOUT_PLUG_PATH_CSS')           OR define('LAYOUT_PLUG_PATH_CSS', BASE_URL.'assets/dist/css/');
defined('LAYOUT_PLUG_PATH_JS')           OR define('LAYOUT_PLUG_PATH_JS', BASE_URL.'assets/dist/js/');
defined('LAYOUT_PLUG_PATH_IMG')           OR define('LAYOUT_PLUG_PATH_IMG', BASE_URL.'assets/dist/img/');

//own js
defined('PDF_IMG_PATH')            OR define('PDF_IMG_PATH', FCPATH.'assets/images/modules/');
defined('IMG_PATH')            OR define('IMG_PATH', BASE_URL.'assets/images/modules/');
defined('GEN_IMG_PATH')            OR define('GEN_IMG_PATH', BASE_URL.'assets/images/');
defined('CSS_PATH')            OR define('CSS_PATH', BASE_URL.'assets/css/');
defined('JS_PATH')             OR define('JS_PATH', BASE_URL.'assets/js/');


defined('ICON_PATH')         OR define('ICON_PATH', BASE_URL.'assets/icons/');
defined('UPLOAD')         OR define('UPLOAD', BASE_URL.'assets/upload/');
defined('USER_LOG')         OR define('USER_LOG', 'LOGIN_DETAILS');
defined('COMP_PROF')         OR define('COMP_PROF', 'COMPANY_PROFILE');

defined('NOTI')            OR define('NOTI', 'NOTIFICATION');
defined('NOTI_LOG')        OR define('NOTI_LOG', 'NOTIFICATION_LOG');

require_once (APPPATH.'modules/incident/config/constants.php');
require_once (APPPATH.'modules/ptw/config/constants.php');
require_once (APPPATH.'modules/master/config/constants.php');
require_once (APPPATH.'modules/atar/config/constants.php');
require_once (APPPATH.'modules/hmp/config/constants.php');

/* REST API */
defined('APIURL') OR define('APIURL', 'lumut-api');
defined('LUMAPIPATH') OR define('LUMAPIPATH', APPPATH . 'modules/' . APIURL . '/');
defined('APK_TOKEN') OR define('APK_TOKEN', 'APK_TOKEN_DETAILS');

///////////////////////mobile api

////////////table names start
defined('DEPT') OR define('DEPT', 'DEPARTMENT');
defined('TERM') OR define('TERM', 'TERMINAL_MANAGEMENT');
defined('GENDER') OR define('GENDER', 'GENDER_MASTER');
defined('NATION') OR define('NATION', 'EMPLOYEE_NATIONALITY');
defined('DESIG') OR define('DESIG', 'DESIGNATION');
defined('EMPL') OR define('EMPL', 'EMPLOYEE_MANAGEMENT');
defined('COMP_CERTI') OR define('COMP_CERTI', 'COMPETENCY_CERTIFICATE');
defined('CONT_DET') OR define('CONT_DET', 'CONTRACTOR_DETAILS');
defined('UTYPE_DESIG') OR define('UTYPE_DESIG', 'USER_TYPE_DESIGNATION');
defined('UTYPE') OR define('UTYPE', 'USER_TYPE');
defined('LOGIN') OR define('LOGIN', 'LOGIN_DETAILS');
defined('INSP_CL_TYP') OR define('INSP_CL_TYP', 'INSP_CHECKLIST_TYPE');
defined('INSP_CL_SUBTYP') OR define('INSP_CL_SUBTYP', 'INSP_CHECKLIST_SUBTYPE');
defined('INSP_CL_SUBTYP_DATA') OR define('INSP_CL_SUBTYP_DATA', 'INSP_CHECKLIST_SUBTYPE_DATA');
defined('HSSE_INSP_MAIN') OR define('HSSE_INSP_MAIN', 'INSP_NOT_MAIN_FLOW');
defined('HSSE_INSP_CHK') OR define('HSSE_INSP_CHK', 'INSP_NOT_CHK_FLOW');
defined('HSSE_INSP_IMAGE') OR define('HSSE_INSP_IMAGE', 'INSP_NOT_IMAGE_DETAILS');
defined('MON_INSP_MAIN') OR define('MON_INSP_MAIN', 'INSP_MON_MAIN_FLOW');
defined('MON_INSP_CHK') OR define('MON_INSP_CHK', 'INSP_MON_CHK_FLOW');
defined('SPE_LOC') OR define('SPE_LOC', 'SPECIFIC_LOCATION');
defined('ATAR_MAIN') OR define('ATAR_MAIN', 'ATAR_MAIN_FLOW');
defined('ATAR_IMG') OR define('ATAR_IMG', 'ATAR_IMAGE_UPLOAD');
defined('MON_ACTIVITY') OR define('MON_ACTIVITY', 'MONTHLY_INSPECTION_ACTIVITY_DETAILS');
defined('SPEC_LOC') OR define('SPEC_LOC', 'SPECIFIC_LOCATION');
defined('PSA_ENTRY') OR define('PSA_ENTRY', 'PORT_SEC_ACC_ENTRY_DETAILS');
/* Trainings Module Constants */
defined('TRM_TYPE_MAS') or define('TRM_TYPE_MAS', 'trm_type_master');
defined('TRM_UPLOAD_MAS') or define('TRM_UPLOAD_MAS', 'trm_upload_master');
defined('TRM_ASS_MAS') or define('TRM_ASS_MAS', 'trm_assessment_master');
defined('HSE_EMP_INDUCTION') or define('HSE_EMP_INDUCTION', 'hse_employee_induction');
defined('HSE_IND_ATTEMPTS') or define('HSE_IND_ATTEMPTS', 'hse_induction_attempts');
defined('HSE_IND_ATTEMPT_ANSWERS') or define('HSE_IND_ATTEMPT_ANSWERS', 'hse_induction_attempt_answers');
defined('HSE_VISITOR_REG') or define('HSE_VISITOR_REG', 'hse_visitor_registration');
////////////table names end


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


$severity = [''=>'Select Severity','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'];
$likelhood = [''=>'Select Likelihood','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'];
$vechical_type = [''=>'Select Vechical Type','1'=>'Motor Cycle','2'=>'Car','3'=>'Lorry','4'=>'No Vehicle','5'=>'Others'];

// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
