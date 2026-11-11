<?php

defined('INC_EVENT_RELATE') OR define('INC_EVENT_RELATE', 'INCIDENT_EVENT_RELATE_MASTER');
defined('INC_EVENT_TYPE') OR define('INC_EVENT_TYPE', 'INCIDENT_EVENT_TYPE_MASTER');
defined('INC_EVENT_GLOSSARY') OR define('INC_EVENT_GLOSSARY', 'INCIDENT_GLOSSARY_INFO');
defined('INC_NOTIFY_INFO') OR define('INC_NOTIFY_INFO', 'INCIDENT_NOTIFICATION_DETAILS');
defined('INC_NOTIFY_ATTACH') OR define('INC_NOTIFY_ATTACH', 'INCIDENT_NOTIFY_ATTACHMENT');
defined('INC_NOTIFY_PERSON') OR define('INC_NOTIFY_PERSON', 'INCIDENT_NOTIFY_PERSON_DETAILS');
defined('INC_CLASSFICATION') OR define('INC_CLASSFICATION', 'INCIDENT_CLASSFICATION_MASTER');
defined('INC_CIRCUMSTANCE') OR define('INC_CIRCUMSTANCE', 'INCIDENT_CIRCUMSTANCE_INFO');
defined('INC_ACTION_PLAN') OR define('INC_ACTION_PLAN', 'INCIDENT_ACTION_PLAN');
defined('INC_ACTION_PLAN') OR define('INC_ACTION_PLAN', 'INCIDENT_NOTIFY_ATTACHMENT');

defined('LOCATION') OR define('LOCATION', 'TERMINAL_MANAGEMENT');
defined('SPECIFIC_LOCATION') OR define('SPECIFIC_LOCATION', 'SPECIFIC_LOCATION');
defined('REQUIRED') OR define('REQUIRED', ' <span class="text-danger">*</span>');



/* NEW INCIDENT*
 * Notify : notificaion Id
 */

 $incidentPermission =[
    'add' => [3,4,5,6,7,8,9,10,11],
    'approve' => [6,7],
    'fix' => [4,11],
    'unit' => [5],
    'view' => [6,7,8,9]
    
];
$newIncidentTemplate = 'Dear HSSE Team,<br/>New Incident has been notified with following details :<br/>Notification No.:{notify_id}<br/>Event Date :{event_date}<br/>Event Time :{event_time}<br/>Location :{location_name}<br/>Specific Location:{specific_loc_name}<br/>Event Related To :{event_related_to}<br/>Event Type :{event_type}<br/>Event Description :{event_desc}<br/>Reported By{report_name},{designation_name}<br/><br/>System generated Email.<br/><br/>';

$newIncidentReportTemplate = 'Dear Team,<br/>New Incident has been notified with following details :<br/>Notification No.:{notify_id}<br/>Event Date :{event_date}<br/>Event Time :{event_time}<br/>Location :{location_name}<br/>Specific Location:{specific_loc_name}<br/>Event Related To :{event_related_to}<br/>Event Type :{event_type}<br/>Event Description :{event_desc}<br/>Incident Status :{incident_status}<br/>Reported By{report_name},{designation_name}<br/><br/>System generated Email.<br/><br/>';
?>