<?php
// <---- HSE Induction Module Constants Start ---->
defined('BASEPATH') OR exit('No direct script access allowed');

// Contractor & Employee Batch Tables
defined('HSE_CONT_BATCH')    OR define('HSE_CONT_BATCH', 'hse_contractor_batch');
defined('HSE_CONT_EMP')      OR define('HSE_CONT_EMP', 'hse_contractor_employee');
defined('HSE_CONT_EMP_LOG')  OR define('HSE_CONT_EMP_LOG', 'hse_contractor_employee_log');

// Contractor & Certificate Tables
defined('CONT_DET')          OR define('CONT_DET', 'CONTRACTOR_DETAILS');
defined('OTHER_CONT')        OR define('OTHER_CONT', 'COMPETENCY_CERTIFICATE');
defined('COMP_CERTI')        OR define('COMP_CERTI', 'COMPETENCY_CERTIFICATE');

// Master Tables
defined('TERM')              OR define('TERM', 'TERMINAL_MANAGEMENT');
defined('NATION')            OR define('NATION', 'EMPLOYEE_NATIONALITY');
defined('DESIG')             OR define('DESIG', 'DESIGNATION');
defined('LOGIN')             OR define('LOGIN', 'LOGIN_DETAILS');
defined('NOTI')              OR define('NOTI', 'NOTIFICATION');
defined('EMPL')              OR define('EMPL', 'EMPLOYEE_MANAGEMENT');

// Training Master Tables
defined('TRM_TYPE_MAS')      OR define('TRM_TYPE_MAS', 'trm_type_master');
defined('TRM_UPLOAD_MAS')    OR define('TRM_UPLOAD_MAS', 'trm_upload_master');
defined('TRM_ASS_MAS')       OR define('TRM_ASS_MAS', 'trm_assessment_master');

// Employee Induction Tables
defined('HSE_EMP_INDUCTION')         OR define('HSE_EMP_INDUCTION', 'hse_employee_induction');
defined('HSE_EMP_INDUCTION_LOG')     OR define('HSE_EMP_INDUCTION_LOG', 'hse_employee_induction_log');
defined('HSE_IND_ATTEMPTS')          OR define('HSE_IND_ATTEMPTS', 'hse_induction_attempts');
defined('HSE_IND_ATTEMPT_ANSWERS')  OR define('HSE_IND_ATTEMPT_ANSWERS', 'hse_induction_attempt_answers');
defined('HSE_VISITOR_REG')          OR define('HSE_VISITOR_REG', 'hse_visitor_registration');

// <---- HSE Induction Module Constants End ---->
