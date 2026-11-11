<?php

defined('FACE_PERSON')           OR define('FACE_PERSON', 'persons');
defined('BASEPATH') OR exit('No direct script access allowed');

// $config['compreface_url'] = 'http://YOUR_COMPREFACE_SERVER:8000/api/v1/recognition';
//local//
// $config['compreface_url'] = 'http://127.0.0.1:8000/api/v1/recognition';
// $config['compreface_api_key'] = 'be33cac7-36bd-4e5d-90f0-804a5a450fe6';

//server //
$config['compreface_url'] = 'https://devtest.neoehs.com/api/v1/recognition';
$config['compreface_api_key'] = '866bf34f-1a3d-4eb2-b85d-2cf098e70af6';

$config['compreface_threshold'] = 0.99;
?>