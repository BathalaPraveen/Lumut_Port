<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        error_reporting(0);
        $this->load->library(array('form_validation', 'user_agent'));
        $this->load->model('Login_model', 'login');
        $this->load->model('common/common_model', 'common');
        $this->load->helper(array('form'));
    }

    public function index()
    {

        $userdata = $this->session->userinfo;

        $login = $userdata->LOGIN_ID;
        if ($login != '') {
            redirect('dashboard');
        } else {

            $data = array(
                'view_file' => 'login/login_form/add_login_form',
                'title' => 'Login Form',
                'current_menu' => 'Login Form'
            );
            $this->template->load_login_template($data);
        }
    }

    public function LoginSubmit()
    {
        //echo '<pre>';print_r($_SESSION);exit;
        $PostData = $this->input->post();

        if (!empty($PostData['username']) && !empty($PostData['password'])) {
            $username = $PostData['username'];
            $pass = $PostData['password'];
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
                    $details = $this->common->getAlldata('CONTRACTOR_DETAILS', ['*', 'CONT_DESIGNATION as design_name'], $option);
                    $session_data['emp_details'] = $details;
                    $options['where'] = [
                        'CERT_USER_ID' => $auth->USER_REF_ID,
                        'CERT_USER_TYPE' => 'CONT',
                        'CERT_TYPE' => 'MAIN'
                    ];
                    $options['return_type'] = 'row';
                    $certdetails = $this->common->getAlldata('COMPETENCY_CERTIFICATE', ['*', 'DATE_FORMAT(CERT_START_DATE,"%d-%m-%Y") as CERTSTART_DATE', 'DATE_FORMAT(CERT_END_DATE,"%d-%m-%Y") as CERTEND_DATE'], $options);
                    $userData = [
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
                        'CERT_ENDDATE' => postData($details, 'CERTEND_DATE')
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
                        'NAME' => postData($empData, 'EMP_NAME'),
                        'DESIGNATIONID' => postData($empData, 'EMP_DESIGNATION_ID'),
                        'DESIGNATION' => postData($empData, 'design_name'),
                        'COMPANY' => 'Lumut Maritime Terminal Sdn Bhd',
                        'ID_TYPE' => '',
                        'ID_NUMBER' => '',
                        'PHONE_NUMBER' => '',
                        'DEPTNAMEID' => postData($empData, 'EMP_DEPT_ID'),
                        'DEPTNAME' => postData($empData, 'depart_name'),
                        'CERT_STATUS' => postData($certdetails, 'CERT_COMMON_STATUS'),
                        'CERT_STARTDATE' => postData($details, 'CERTSTART_DATE'),
                        'CERT_ENDDATE' => postData($details, 'CERTEND_DATE')
                    ];
                }
                $session_data['user_details'] = $userData;
                //              $session_data['role_permissions'] = getRolePermissions($check->role);
                $this->session->set_userdata($session_data);


                /* track table data */
                $ip = $this->input->ip_address();
                $session_id = session_id();
                if ($this->agent->is_browser()) {
                    $agent = $this->agent->browser() . ' ' . $this->agent->version();
                } elseif ($this->agent->is_robot()) {
                    $agent = $this->agent->robot();
                } elseif ($this->agent->is_mobile()) {
                    $agent = $this->agent->mobile();
                } else {
                    $agent = 'Unidentified User Agent';
                }
                $agentPlatform = $this->agent->platform();


                $trackData = [
                    'user_id' => $auth->LOGIN_ID,
                    'login_time' => date('Y-m-d h:i:s'),
                    'ip' => $ip,
                    'session_id' => $session_id,
                    'user_agent' => $agent,
                    'user_platform' => $agentPlatform
                ];
                //                $insertTrackData = $this->common->updateInfo(LOG_TRACK, $trackData);
                $session = $this->session->userdata['id'];

                if (isset($session) && $session != '') {
                    $this->session->set_flashdata('Messges', 'Login Successfully');
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('Messges', 'User session not found');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('Messges', 'Username and Password Not Matched!');
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('Messges', 'Username and Password required!');
            redirect('login');
            //            exit;
        }
    }

    public function logout()
    {
        $session_id = session_id();

        //        $trackData = [
        //            'logout_time' => date('Y-m-d h:i:s')
        //        ];
        //        $this->db->where('session_id', $session_id);
        //        $this->db->update(LOGTRACK, $trackData);
        $user_data = $this->session->userdata();
        $this->session->unset_userdata($user_data);
        $this->session->sess_destroy();
        redirect('login');
    }
    public function forgetPassword()
    {
        ini_set('display_errors', 1);

        $forgetUser = $this->input->post('forgetUser');
        $csrf_osh_name = $this->input->post('csrf_osh_name');

        $output = '';
        if ($forgetUser == '') {

            $output .= '<div class="alert alert-danger">
                    <button class="close" data-close="alert"> X </button>
                    <span>Please enter the valid Username</span>
                </div>';

            echo $output;
        } else {



            $n_rows = $this->common->Checkbasicinfo($forgetUser);
            $forgotEncrypValue = encryptval($forgetUser);

            if ($n_rows != 0) {

                $updateEncryptPass = $this->common->CheckforgotEncrypValue($forgetUser, $forgotEncrypValue);

                $output .= '<div class="alert alert-success msg-show">
                            <button class="close" data-close="alert"> X </button>
                           <span>Kindly Check Your Mail! </span>
                         </div>
                         <div class="form-group col-md-8"  style="display: inline-block;text-align: right;padding: 30px 0 0 0;width:100%;">
                         
                     </div>';
                echo $output;
                //        $otpArray = array ("0123" , "0234");

                //send mail process - conformation .

                $subject = 'Forgot password Process';
                $toemail = isset($n_rows['emailId']) ? $n_rows['emailId'] : '';
                //        foreach($otpArray as $otp){

                $message =  'This is Password Reset Mail.If you need Means Kindly click This url.'  . '<br>' . '<br>' . '<br>' . '<center>' .

                    '_______________________________________________________________________________________' . '<br>' . '<br>' .



                    BASE_URL() . 'login/resetPassword/' . $forgotEncrypValue . '<br>' . '<br>' .

                    '_______________________________________________________________________________________' . '</center>'

                    . '<br>' . 'Your Encrypt Password is : ' . $forgotEncrypValue;;



                $tempdata = array(
                    'view_file' => 'common/email/common_mail',
                    'messageText' => $message,
                    'footerText' => ''

                );

                $template = $this->template->load_email_template($tempdata);

                return  $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
            } else {
                $output .= '<div class="alert alert-danger msg-show">
                            <button class="close" data-close="alert"> X </button>
                           <span>Sorry your Username does not exist !! Kindly check ! </span>
                         </div>
                         <div class="form-group col-md-8"  style="display: inline-block;text-align: right;padding: 30px 0 0 0;width:100%;">
                         
                     </div>';
                echo $output;
            }
        }
    }
    public function resetPassword($forgotEncrypValue = '')
    {
        $userdata = $this->session->userinfo;

        $login = $userdata->LOGIN_ID;
        if ($login != '') {
            redirect('dashboard');
        } else {

            $data = array(
                'view_file' => 'login/login_form/forget_login_form',
                'title' => 'Login Form',
                'current_menu' => 'Login Form'
            );
            $this->template->load_login_template($data);
        }
    }
    public function forgetPasswordProcess()
    {

        $encryptMsg = $this->input->post('encryptMsg');
        $forgetUser = decryptval($encryptMsg);

        $passwordDet = $this->input->post('passwordDet');
        // echo 'M<pre>';print_r($passwordDet);
        $confirmPass = $this->input->post('confirmPass');
        //echo 'A<pre>';print_r($confirmPass);exit;
        // $pass = $confirmPass;
        $CheckExpiredOrNot = $this->common->CheckExpiredOrNot($forgetUser, $encryptMsg);

        if ($CheckExpiredOrNot['ENCRYPT_OTP_PASSWORD'] != "") {
            if ($forgetUser != '') {

                $n_rows = $this->common->Checkbasicinfo($forgetUser);
                //     echo '<pre>';print_r($n_rows);exit;

                if ($n_rows != 0) {

                    $output .= '<div>
                             <input type="password" name="passwordDet" id="passwordDet" class="form-control passwordDet" value="" placeholder="Please Enter New Password" maxlength="40">
                          </div><br>';
                    $output .= '<div>
                             <input type="password" name="confirmPass" id="confirmPass" class="form-control confirmPass" value="" placeholder="Please Confirm Password" maxlength="40">
                          </div>';
                    echo $output;
                } else {
                    $output .= '<div class="alert alert-danger msg-show">
                            <button class="close" data-close="alert"> X </button>
                           <span>Sorry your Username does not exist !! Kindly check ! </span>
                         </div>
                         <div class="form-group col-md-8"  style="display: inline-block;text-align: right;padding: 30px 0 0 0;width:100%;">
                         
                     </div>';
                    echo $output;
                }
            }

            $output = '';
            if ($passwordDet != $confirmPass) {
                $output .= '<div class="alert alert-danger msg-show">
                            <button class="close" data-close="alert"> X </button>
                           <span> Password Mismatch !</span>
                         </div>
                         <div class="form-group col-md-8"  style="display: inline-block;text-align: right;padding: 30px 0 0 0;width:100%;">
                         
                     </div>';
                echo $output;
            } else if ($forgetUser != '' &&  $passwordDet != '' && $confirmPass != '') {

                $uppercase = preg_match('@[A-Z]@', $passwordDet);
                $number    = preg_match('@[0-9]@', $passwordDet);
                $lowercase    = preg_match('@[a-z]@', $passwordDet);
                $spll    = preg_match('@[^\da-zA-Z]@', $passwordDet);

                if (!$uppercase || !$spll || !$number || !$lowercase || strlen($passwordDet) < 8) {
                    $output .= '<div class="alert alert-danger msg-show">
                            <button class="close" data-close="alert"> X </button>
                           <span>Please Enter Atlease One Uppercase, Lowercase, Number, Special Character & Minimum Length 8!</span>
                         </div>
                         <div class="form-group col-md-8"  style="display: inline-block;text-align: right;padding: 30px 0 0 0;width:100%;">
                         
                     </div>';
                    echo $output;
                } else {


                    $passwordUpdation = $this->common->UpdateNewPassword($forgetUser, $passwordDet);

                    $updateEncryptPassword = $this->common->CheckforgotEncrypValueEmpty($forgetUser, $encryptMsg);


                    $output .= '<div class="alert alert-success msg-show">
                            <button class="close" data-close="alert"> X </button>
                           <span>Successfully Updated Password!</span>
                         </div>
                         <div class="form-group col-md-8"  style="display: inline-block;text-align: right;padding: 30px 0 0 0;width:100%;">
                         
                          </div>';
                    echo $output;

                    //send mail process - conformation .

                    $subject = 'Password Successfully Changed';
                    $toemail = isset($n_rows['emailId']) ? $n_rows['emailId'] : '';

                    $message = 'Your password has been reset successfully. You can login with the below credentials:' . '<br>' .
                        ' Username:'    . $forgetUser . '<br>' .
                        'Password:'    . $passwordDet . '<br>';



                    $tempdata = array(
                        'view_file' => 'common/email/common_mail',
                        'messageText' => $message,
                        'footerText' => ''

                    );

                    $template = $this->template->load_email_template($tempdata);

                    return  $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
                }
            } else if ($forgetUser == '') {

                $output .= '<div class="alert alert-danger">
                    <button class="close" data-close="alert"> X </button>
                    <span>Kindly enter your Encrypt Password!</span>
                </div>';

                echo $output;
            }
        } else {
            $output .= '<div class="alert alert-danger msg-show">
                            <button class="close" data-close="alert"> X </button>
                           <span> Your Encrypt Password is Expired!</span>
                         </div>
                         <div class="form-group col-md-8"  style="display: inline-block;text-align: right;padding: 30px 0 0 0;width:100%;">
                         
                     </div>';
            echo $output;
        }
    }
}
