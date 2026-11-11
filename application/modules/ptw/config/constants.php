<?php

defined('PTW_M_AOC') OR define('PTW_M_AOC', 'PTW_MSTR_AREA_CLASSIFICATION');
defined('PTW_M_HA_CAT') OR define('PTW_M_HA_CAT', 'PTW_MSTR_HZRD_ACTIVITY_CAT');
defined('PTW_M_HA') OR define('PTW_M_HA', 'PTW_MSTR_HZRD_ACTIVITY');
defined('PTW_M_HAI') OR define('PTW_M_HAI', 'PTW_MSTR_HZRD_CHKLIST');
defined('PTW_M_ADOCS') OR define('PTW_M_ADOCS', 'PTW_MSTR_ADDITION_DOCS');
defined('PTW_M_WPP_CAT') OR define('PTW_M_WPP_CAT', 'PTW_MSTR_WPP_CATEGORY');
defined('PTW_M_WPP_ITEMS') OR define('PTW_M_WPP_ITEMS', 'PTW_MSTR_WPP_ITEMS');
defined('PTW_M_PPE_CAT') OR define('PTW_M_PPE_CAT', 'PTW_MSTR_PPE_CATEGORY');
defined('PTW_M_PPE_ITEMS') OR define('PTW_M_PPE_ITEMS', 'PTW_MSTR_PPE_ITEMS');
defined('PTW_M_STATUS') OR define('PTW_M_STATUS', 'PTW_MSTR_STATUS');

defined('PTW_TBL') OR define('PTW_TBL', 'PTW');
defined('PTW_SEC_ATTACH') OR define('PTW_SEC_ATTACH', 'PTW_SECTION_ATTACHMENTS');
defined('PTW_CS_GAS_RESULT') OR define('PTW_CS_GAS_RESULT', 'PTW_CS_GAS_RESULT');
defined('PTW_CS_PERSONNEL') OR define('PTW_CS_PERSONNEL', 'PTW_CS_PERSONNEL');
defined('PTW_PPE') OR define('PTW_PPE', 'PTW_PPE');
defined('PTW_PPE_UPLS') OR define('PTW_PPE_UPLS', 'PTW_PPE_UPLOADS');
defined('PTW_WS_PREPARE') OR define('PTW_WS_PREPARE', 'PTW_WORKSITE_PREPARATION');
defined('PTW_WS_PREPARE_ATT') OR define('PTW_WS_PREPARE_ATT', 'PTW_WORKSITE_PREPARATION_ATTACHMENTS');
defined('PTW_WORK_HA') OR define('PTW_WORK_HA', 'PTW_WORK_HAZARD_ACITIVITIES');
defined('PTW_WORK_HA_ATT') OR define('PTW_WORK_HA_ATT', 'PTW_WORK_HAZARD_ACITIVITIES_ATTACHMENTS');
defined('PTW_SANC_DOCS') OR define('PTW_SANC_DOCS', 'PTW_SANCTION_DOCS');
defined('PTW_SANC_TOOL_DOCS') OR define('PTW_SANC_TOOL_DOCS', 'PTW_SANCTION_TOOL_DOCS');
defined('WORK_HA_HIRARC') OR define('WORK_HA_HIRARC', 'PTW_WORK_HAZARD_ACITIVITIES_HIRARC');

defined('PTW_WORK_HA_CC') OR define('PTW_WORK_HA_CC', 'PTW_WORK_HAZARD_ACITIVITIES_CC');
defined('PTW_WORK_HA_CC_ATT') OR define('PTW_WORK_HA_CC_ATT', 'PTW_WORK_HAZARD_ACITIVITIES_CC_ATTACHMENT');
defined('PTW_WORK_HA_CC_CS') OR define('PTW_WORK_HA_CC_CS', 'PTW_WORK_HAZARD_ACITIVITIES_CONFINED_SPACE');

defined('PTW_DATE_FORMAT') OR define('PTW_DATE_FORMAT', 'd-m-Y');
defined('PTW_TIME_FORMAT') OR define('PTW_TIME_FORMAT', 'h:i a');
defined('LOADING_IMG') OR define('LOADING_IMG', BASE_URL.'assets/images/loader.gif');

$aPermitType = [
    '1'=>'NORMAL',
    '2'=>'CRITICAL'
];

$aHseVerify = [
    'SAFE' => 'SAFE for above type of work at the time of inspection',
    'NOTSAFE'=>'NOT SAFE/ REJECTED for above type of work at the time of inspection'
];

/*
 * Section -3
 */
defined('WPP_BASIC_REQ_OTHER_ID') OR define('WPP_BASIC_REQ_OTHER_ID', 33);
defined('WPP_BASIC_REQ_GASTESTER_ID') OR define('WPP_BASIC_REQ_GASTESTER_ID', 34);
defined('WPP_ISOLATION_CRITICAL_OTHER_ID') OR define('WPP_ISOLATION_CRITICAL_OTHER_ID', 35);
defined('ICON_PATH') OR define('ICON_PATH', BASE_URL.'/assets/icons/');

/*
 * User Type
 * 1 ==> Super Admin
 * 2 ==> Admin
 * 3 ==> Normal User
 * 4 ==> Executive User
 * 5 ==> Unit Heads
 * 6 ==> HSSE User
 * 7 ==> HSSE Head/Reviewer
 * 8 ==> Verifier User
 * 9 ==> Approver User
 * 10 ==> Guard User
 * 11 ==> Contractor User
 * 
 * 
 */

$aPTWPermission =[
    'approve' => [5,6,7],
    'stop' => [6,7],
    'verfication_a' => [6],
    'verfication_b' => [5],
    'work_supervisor' => [5], 
    'acknowledge' => [4,11],
    'close' => [4,11],
    'view' => [4,5,6,7,8,9,11],
    'add' => [4,11],
    'edit' => [4,11],
    
];

/* PTW Initial Section*
 * Notify : notificaion Id
 */
$ptwInitialTemplate = '{ptwTypeName} has been submitted with following details :<br/><br/><b>PTW No.:</b> {permitNumber}<br/> <b>Date Start :</b> {ptwStartDate} to <b>Date End : </b>{ptwEndDate}<br/><b>Location : </b> {locationName}<br/><b>Specific Location: </b>{specificLocationName} <br/> <b>Area Classification : </b>{areaClassification} <br/><b>Work Description : </b>{workdescription} <br/> <b>PTW Request By: </b> {requsterName}, {requesterDesignation} <br/> <b>Status : </b> {statusName} <br/>';

$ptwHseVerificationTemplate = '{ptwTypeName} has been submitted with following details :<br/><br/><b>PTW No.:</b> {permitNumber}<br/> <b>Date Start :</b> {ptwStartDate} to <b>Date End : </b>{ptwEndDate}<br/><b>Location : </b> {locationName}<br/><b>Specific Location: </b>{specificLocationName} <br/> <b>Area Classification : </b>{areaClassification} <br/> <b>PTW Request By: </b> {requsterName}, {requesterDesignation} <br/> <b>Verification By :</b> {hseName}, {hseDesignation} <br/><b>Status : </b> {statusName} <br/>';

$ptwOAVerificationTemplate = '{ptwTypeName} has been submitted with following details :<br/><br/><b>PTW No.:</b> {permitNumber}<br/> <b>Date Start :</b> {ptwStartDate} to <b>Date End : </b>{ptwEndDate}<br/><b>Location : </b> {locationName}<br/><b>Specific Location: </b>{specificLocationName} <br/> <b>Area Classification : </b>{areaClassification} <br/> <b>PTW Request By: </b> {requsterName}, {requesterDesignation} <br/> <b>Verification By :</b> {hseName}, {hseDesignation}  / {oaName}, {oaDesignation}<br/><b>Status : </b> {statusName} <br/>';

$ptwFinalTemplate = '{ptwTypeName} has been submitted with following details :<br/><br/><b>PTW No.:</b> {permitNumber}<br/> <b>Date Start :</b> {ptwStartDate} to <b>Date End : </b>{ptwEndDate}<br/><b>Location : </b> {locationName}<br/><b>Specific Location: </b>{specificLocationName} <br/> <b>Area Classification : </b>{areaClassification} <br/> <b>PTW Request By: </b> {requsterName}, {requesterDesignation} <br/> <b>Verification By :</b> {hseName}, {hseDesignation}  / {oaName}, {oaDesignation}<br/><b>Status : </b> {statusName} <br/> <b>Remark :</b> {remarks} <br/>';


$aNotifyData = [
    '{ptwTypeName}'=> '',
    '{ptwStartDate}'=> '',
    '{ptwEndDate}'=> '',
    '{locationName}'=> '',
    '{specificLocationName}'=> '',
    '{areaClassification}'=> '',
    '{requsterName}'=> '',
    '{requesterDesignation}'=> '',
    '{statusName}'=> '',
    '{hseName}'=> '',
    '{hseDesignation}'=> '',
    '{oaName}'=> '',
    '{oaDesignation}'=> '',
    '{remarks}'=> '',
];

$ptwFooterMailContent = '<br/>This is system generated E-mail, do not reply to this email.<br/>';
defined('DEFAULT_IMG_PNG') OR define('DEFAULT_IMG_PNG', GEN_IMG_PATH.'no-image.png');

?>
