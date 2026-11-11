<?php

defined('PRO_ACT_AREA')           OR define('PRO_ACT_AREA', 'HIRARC_PRO_ACT_AREA');
defined('HAZA_TYPE')           OR define('HAZA_TYPE', 'HIRARC_HAZARD_TYPE');
defined('HAZA_NAME')           OR define('HAZA_NAME', 'HIRARC_HAZARD_NAME');
defined('HAZA')           OR define('HAZA', 'HIRARC_HAZARD');
defined('HAZA_CAU')           OR define('HAZA_CAU', 'HIRARC_CAUSE_EFFECT');
defined('EXIT_RI_CN')           OR define('EXIT_RI_CN', 'HIRARC_EX_RISK_CONTROL'); 
defined('RISK_RATE')           OR define('RISK_RATE', 'HIRARC_RISK_RATE'); 
defined('HIR_COM')           OR define('HIR_COM', 'HIRARC_COMPANY'); 
defined('HIR_MAIN')           OR define('HIR_MAIN', 'HIRARC_MAIN_FLOW'); 
defined('HIR_RISK')           OR define('HIR_RISK', 'HIRARC_RISK_PRO_FLOW');  

/*NEW INCIDENT*
* Notify : notificaion Id
*/
$newIncidentTemplate = 'Dear HSSE Team,<br/>New Incident has been notified with following details :<br/>Notification No.:{notify_id}<br/>Event Date :{event_date}<br/>Event Time :{event_time}<br/>Location :{location_name}<br/>Specific Location:{specific_loc_name}<br/>Event Related To :{event_related_to}<br/>Event Type :{event_type}<br/>Event Description :{event_desc}<br/>Reported By{report_name},{designation_name}<br/><br/>System generated Email.<br/><br/>';

$newIncidentReportTemplate = 'Dear Team,<br/>New Incident has been notified with following details :<br/>Notification No.:{notify_id}<br/>Event Date :{event_date}<br/>Event Time :{event_time}<br/>Location :{location_name}<br/>Specific Location:{specific_loc_name}<br/>Event Related To :{event_related_to}<br/>Event Type :{event_type}<br/>Event Description :{event_desc}<br/>Incident Status :{incident_status}<br/>Reported By{report_name},{designation_name}<br/><br/>System generated Email.<br/><br/>';
global $severity;
global $likelhood;
 $severity = [''=>'Select Severity','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'];
$likelhood = [''=>'Select Likelihood','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'];


?>