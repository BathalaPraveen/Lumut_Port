<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require LUMAPIPATH . 'libraries/REST_Controller.php';

class Login extends REST_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(1);
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->common_model->api_log($this->post());

        $this->load->model('login/Login_model', 'login');
        $this->load->model('common/common_model', 'common');
    }

    public function index_post() {

        $username = $this->post('username');
        $password = $this->post('password');
        
        if (!empty($username) && !empty($password)) {
            $username = $username;
            $pass = $password;

            $auth = $this->login->auth($username, $pass);

            if (($auth != FALSE) && ($auth != 'deactivated')) {
                $session_data = [
                    'id' => $auth->LOGIN_ID,
                    'name' => $auth->USERNAME,
                    'role_id' => $auth->USER_TYPE_ID,
                    'userinfo' => $auth
                ];
                $userTypeId = $auth->USER_TYPE_ID;
                
                if ($userTypeId == 11) {
                    $where = [
                        'CONT_AUTO_ID' => $auth->USER_REF_ID
                    ];
                    $option['where'] = $where;
                    $option['return_type'] = 'row';
                    $details = $this->common->getAlldata('CONTRACTOR_DETAILS', ['*','CONT_DESIGNATION as design_name'], $option);
                    $session_data['emp_details'] = $details;
                    $options['where'] = [
                        'CERT_USER_ID' => $auth->USER_REF_ID,
                        'CERT_USER_TYPE' => 'CONT',
                        'CERT_TYPE' => 'MAIN'
                    ];
                    $options['return_type'] = 'row';
                    $certdetails = $this->common->getAlldata('COMPETENCY_CERTIFICATE', ['*', 'DATE_FORMAT(CERT_START_DATE,"%d-%m-%Y") as CERTSTART_DATE', 'DATE_FORMAT(CERT_END_DATE,"%d-%m-%Y") as CERTEND_DATE'], $options);
                    $userData = [
                      //  'ID' => postData($details, 'CONT_AUTO_ID'),
                        'ID' => $auth->LOGIN_ID,
                        'GEN_AUTO_ID' => postData($details, 'CONT_ID'),
                        'USER_TYPE_ID' => $auth->USER_TYPE_ID,
                        'NAME' => postData($details, 'CONT_NAME'),
                        'DESIGNATIONID' => 0,
                        'DESIGNATION' => postData($details, 'design_name'),
                        'COMPANY' => postData($details, 'CONT_COMPANY'),
                        'ID_TYPE' => postData($details, 'CONT_ID_TYPE'),
                        'ID_NUMBER' => postData($details, 'CONT_ID_NUMBER'),
                        'PHONE_NUMBER' => postData($details, 'CONT_PHONE_NO'),
                        'DEPTNAMEID' => '',
                        'DEPTNAME' => '',
                        'CERT_STATUS' => postData($certdetails, 'CERT_COMMON_STATUS'),
                        'CERT_STARTDATE' => postData($details, 'CERTSTART_DATE'),
                        'CERT_ENDDATE' => postData($details, 'CERTEND_DATE'),
                        'LOGIN_STATUS' => postData($details, 'CON_LOGIN_STATUS')
                    ];
                } else {
                    $empwhere = [
                        'EMP_AUTO_ID' => $auth->USER_REF_ID
                    ];
                    $option['where'] = $empwhere;
                    $option['return_type'] = 'row';
                    $empData = $this->common->getAlldata(EMPL, ['*', 'FN_GET_DESIGNATION_NAME(EMP_DESIGNATION_ID) as design_name', 'FN_GET_DEPARTMENT_NAME(EMP_DEPT_ID) as depart_name'], $option);
                    $session_data['emp_details'] = $empData;
                    $options['where'] = [
                        'CERT_USER_ID' => $auth->USER_REF_ID,
                        'CERT_USER_TYPE' => 'EMP',
                        'CERT_TYPE' => 'MAIN'
                    ];
                    $options['return_type'] = 'row';
                    $certdetails = $this->common->getAlldata('COMPETENCY_CERTIFICATE', ['*', 'DATE_FORMAT(CERT_START_DATE,"%d-%m-%Y") as CERTSTART_DATE', 'DATE_FORMAT(CERT_END_DATE,"%d-%m-%Y") as CERTEND_DATE'], $options);
                    $userData = [
                      //  'ID' => postData($empData, 'EMP_AUTO_ID'),
                          'ID' => $auth->LOGIN_ID,
                        'GEN_AUTO_ID' => postData($empData, 'EMP_ID'),
                        'USER_TYPE_ID' => $auth->USER_TYPE_ID,
                        'NAME' => postData($empData, 'EMP_NAME'),
                        'DESIGNATIONID' => postData($empData, 'EMP_DESIGNATION_ID'),
                        'DESIGNATION' => postData($empData, 'design_name'),
                        'COMPANY' => '',
                        'ID_TYPE' => '',
                        'ID_NUMBER' => '',
                        'PHONE_NUMBER' => '',
                        'DEPTNAMEID' => postData($empData, 'EMP_DEPT_ID'),
                        'DEPTNAME' => postData($empData, 'depart_name'),
                        'CERT_STATUS' => postData($certdetails, 'CERT_COMMON_STATUS'),
                        'CERT_STARTDATE' => postData($details, 'CERTSTART_DATE'),
                        'CERT_ENDDATE' => postData($details, 'CERTEND_DATE'),
                        'LOGIN_STATUS' => postData($empData, 'EMP_LOGIN_STATUS')
                    ];
                }
                //print_r();exit;
                if($userData['LOGIN_STATUS'] == 'E'){
                    $message = [
                        'UserData' => $userData,
                        'status' => TRUE,
                        'message' => 'login success',
                    ];
                }else{
                    $message = [
                        'UserData' => (object)[],
                        'status' => FALSE,
                        'message' => 'login failure.Login Access not enabled'
                    ];
                }
                
            }else if ($auth == 'deactivated') {
                $message = [
                    'UserData' => (object)[],
                    'status' => FALSE,
                    'message' => 'Account Deactivated'
                ]; 
            } else {
                $message = [
                    'UserData' => (object)[],
                    'status' => FALSE,
                    'message' => 'Invalid User'
                ];
                
            }
            

            $this->set_response($message, REST_Controller::HTTP_CREATED); 
        }
    }
    public function register_token_post() {

        $user_id = $this->post('userid');
        $token = $this->post('devicetoken');



        if ($user_id != '' && $token != '') {

            $data = [
                'APK_TOKEN' => $token,
                'APK_USER_ID' => $user_id
            ];

            $where = [
                'APK_USER_ID' => $user_id
            ];

            $optioninitial['where'] = [
                'APK_USER_ID' => $user_id
            ];


            $optioninitial['return_type'] = 'row';
            $user_token = $this->common_model->getAlldata(APK_TOKEN, ['*'], $optioninitial);

            if (isset($user_token) && $user_token != '') {



                $uwhere = [
                    //'token' => $token,
                    'APK_USER_ID' => $user_id
                ];

                $register = $this->common_model->updateData(APK_TOKEN, $data, $uwhere);
            } else {

                $register = $this->common_model->updateData(APK_TOKEN, $data);
            }

            if (!empty($register) && $register > 0) {

                $message = array(
                    'status' => TRUE,
                    'message' => 'Success! Token has been created',
                );

                $this->set_response($message, REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
            } else {

                $message = array(
                    'status' => FALSE,
                    'message' => 'Sorry! Token not been created'
                );

                $this->set_response($message, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

}
