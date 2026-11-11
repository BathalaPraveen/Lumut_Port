<?php

defined('HMP_MAIN') OR define('HMP_MAIN', 'HMP_MAIN_FLOW');
defined('HMP_STATUS') OR define('HMP_STATUS', 'HMP_MAIN_STATUS');

defined('REC_MAIN') OR define('REC_MAIN', 'REC_MAIN_FLOW');
defined('REC_STATUS') OR define('REC_STATUS', 'REC_MAIN_STATUS');
defined('REC_IMG') OR define('REC_IMG', 'REC_IMAGE_UPLOAD');


 $hmpPermission = [
    'add' => [6, 7]
];
$hmpAccessList = [
    'add' => [4, 5,6,7,8,9]
];

$recPermission = [
    'add' => [6, 7]
];
?>
