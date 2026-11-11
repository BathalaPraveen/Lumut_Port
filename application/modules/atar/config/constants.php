<?php

defined('ATAR_IMG') OR define('ATAR_IMG', 'ATAR_IMAGE_UPLOAD');
defined('ATAR_FLOW') OR define('ATAR_FLOW', 'ATAR_MAIN_FLOW');
defined('ATAR_CAT') OR define('ATAR_CAT', 'ATAR_CATEGORY');
defined('ATAR_OBS') OR define('ATAR_OBS', 'ATAR_OBSERVATION_FLOW');
defined('DASH_SLIDER') OR define('DASH_SLIDER', 'DASHBOARD_IMAGE_UPLOAD');

//$atarStatusType = [
//    '4'=>'Action Pending',
//    '2'=>'Irrelevant',
//    '3'=>'Close'
//];

$atarPermission =[
    'add' => [3,4,5,6,7,8,9,10,11],
    'approve' => [6,7],
    'fix' => [4,11],
    'unit' => [5],
    'view' => [6,7,8,9]
    
];



?>