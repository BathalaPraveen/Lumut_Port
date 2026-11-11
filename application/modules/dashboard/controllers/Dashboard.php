<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common/common_model');
        $this->load->model('dashboard_model');
        isLogin();
    }

    public function index()
    {
        $userdata = $this->session->userinfo;
        $login = $userdata->LOGIN_ID;

        $search = $this->input->post();

        if ($login != '') {

            $userdata = $this->session->userinfo;
            $role = $userdata->USER_TYPE_ID;

            // SEARCH FILTER
            if (
                $this->input->post('terminal') ||
                $this->input->post('year') ||
                $this->input->post('from_date') ||
                $this->input->post('to_date')
            ) {

                $terminal  = $this->input->post('terminal');
                $year      = $this->input->post('year');
                $from_date = $this->input->post('from_date');
                $to_date   = $this->input->post('to_date');

                // STORE SESSION
                $this->session->set_userdata('dashboard_terminal', $terminal);
                $this->session->set_userdata('dashboard_year', $year);
                $this->session->set_userdata('dashboard_from_date', $from_date);
                $this->session->set_userdata('dashboard_to_date', $to_date);

                redirect('dashboard');
                return;
            }

            // GET SESSION VALUES
            $terminal  = $this->session->userdata('dashboard_terminal')
                ? $this->session->userdata('dashboard_terminal')
                : '';

            $year = $this->session->userdata('dashboard_year')
                ? $this->session->userdata('dashboard_year')
                : '';

            $from_date = $this->session->userdata('dashboard_from_date')
                ? $this->session->userdata('dashboard_from_date')
                : '';

            $to_date = $this->session->userdata('dashboard_to_date')
                ? $this->session->userdata('dashboard_to_date')
                : '';

            // CLEAR SESSION
            $this->session->unset_userdata('dashboard_terminal');
            $this->session->unset_userdata('dashboard_year');
            $this->session->unset_userdata('dashboard_from_date');
            $this->session->unset_userdata('dashboard_to_date');

            // FUNCTION CALL
            $this->main_dashboard($terminal, $year, $from_date, $to_date);

        } else {

            redirect('login');
        }
    }

    public function generateCaptcha()
    {
        $this->load->helper('captcha');
        $mpath = 'public/captcha/';
        if (!file_exists(FCPATH . $mpath)) {
            @mkdir(FCPATH . $mpath, 0755, true);
        }
        // Captcha configuration
        $config = array(
            'img_path' => $mpath,
            'img_url' => BASE_URL . $mpath,
            'img_width' => '150',
            'img_height' => 50,
            'word_length' => 5,
            'font_size' => 18,
            'img_id' => 'Imageid',
            'pool' => '0123456789',
            'colors' => array(
                'text' => array(0, 0, 0),
            )
        );
        $captcha = create_captcha($config);

        // Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);
        return $captcha['image'];
    }

    public function captcharefresh()
    {
        echo $this->generateCaptcha();
    }

    public function profile($error = ['captcha_error' => ''])
    {

        $captchaCode = $this->generateCaptcha();
        $userdata = $this->session->userinfo;


        $userTypeId = postData($userdata, 'USER_TYPE_ID');
        $userRefId = postData($userdata, 'USER_REF_ID');
        $userLoginId = postData($userdata, 'LOGIN_ID');
        $options['return_type'] = 'row';
        $options['where'] = [
            'LOGIN_ID' => $userLoginId,
        ];
        if ($userTypeId == 11) {
            $options['join'] = [
                'CONTRACTOR_DETAILS as cont' => ['cont.CONT_AUTO_ID = LD.USER_REF_ID', 'INNER']
            ];
            $options['join'][COMP_CERTI . ' as cert'] = ['cert.CERT_USER_ID = cont.CONT_AUTO_ID', 'left'];
            $options['join'][DESIG . ' as desg'] = ['desg.DESIGNATION_ID = cont.CONT_DESIGNATION', 'left'];
            $options['join'][NATION . ' as nation'] = ['nation.NATIONALITY_ID = cont.CONT_NATIONALITY', 'left'];
            $options['join'][GENDER . ' as gend'] = ['gend.GENDER_ID = cont.CONT_GENDER', 'left'];
            $param = ['LD.LOGIN_ID,LD.PROFILE_IMG,LD.USERNAME,USER_REF_ID,USER_LOGIN_TYP,USER_TYPE_ID,USER_DESINATION_ID,cont.*,cert.*,desg.DESIGNATION_NAME,gend.GENDER_NAME,nation.NATIONALITY_NAME'];
        } else {
            $options['join'] = [
                'EMPLOYEE_MANAGEMENT as emp' => ['emp.EMP_AUTO_ID = LD.USER_REF_ID', 'INNER']
            ];
            $options['join'][COMP_CERTI . ' as cert'] = ['cert.CERT_USER_ID = emp.EMP_AUTO_ID', 'left'];
            $options['join'][DESIG . ' as desg'] = ['desg.DESIGNATION_ID = emp.EMP_DESIGNATION_ID', 'left'];
            $options['join'][DEPT . ' as dept'] = ['dept.DEPT_AUTO_ID = emp.EMP_DEPT_ID', 'left'];
            $options['join'][NATION . ' as nation'] = ['nation.NATIONALITY_ID = emp.EMP_NATIONALITY', 'left'];
            $options['join'][GENDER . ' as gend'] = ['gend.GENDER_ID = emp.EMP_GENDER', 'left'];
            $options['join'][TERM . ' as term'] = ['term.TER_AUTO_ID = emp.EMP_LOC_ID', 'left'];
            $param = ['LD.LOGIN_ID,LD.PROFILE_IMG,LD.USERNAME,USER_REF_ID,USER_LOGIN_TYP,USER_TYPE_ID,USER_DESINATION_ID,emp.*,cert.*,desg.DESIGNATION_NAME,dept.DEPT_NAME,gend.GENDER_NAME,term.TERMINAL_NAME,nation.NATIONALITY_NAME'];
        }

        $profileInfo = $this->common_model->getAlldata('LOGIN_DETAILS as LD', $param, $options, $limit = "", $offset = "", $orderby = "", $disporder = "");



        $data = array(
            'view_file' => 'profile',
            'title' => 'Profile',
            'current_menu' => 'Profile',
            'captchaCode' => $captchaCode,
            'profileInfo' => $profileInfo,
            'userTypeId' => $userTypeId,
            'userdata' => $userdata
        );
        $dispData = $error + $data;
        $this->template->load_common_template($dispData);
    }

    public function savepassword()
    {
        $userdata = $this->session->userinfo;
        // If captcha form is submitted
        if ($this->input->post('passsubmit')) {
            $inputCaptcha = $this->input->post('captcha');
            $sessCaptcha = $this->session->userdata('captchaCode');
            if ($inputCaptcha === $sessCaptcha) {

                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[8]|matches[password]');

                if ($this->form_validation->run() == true) {

                    $userTypeId = postData($userdata, 'USER_REF_ID');
                    $loginId = postData($userdata, 'LOGIN_ID');
                    $password = $this->input->post('password');

                    $updateData = [
                        'ENCRYPT_PASSWORD' => md5($password),
                        'ORG_PWD' => $password,
                    ];

                    $userWhere = [
                        'LOGIN_ID' => $loginId
                    ];


                    $update = $this->common_model->updateData('LOGIN_DETAILS', $updateData, $userWhere);
                    if ($update) {
                        $this->session->set_flashdata('profilemsg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Password update successfully. </div>');
                        redirect('dashboard/profile/');
                    } else {
                        $this->session->set_flashdata('profilemsg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Password update failed </div>');
                        redirect('dashboard/profile/');
                    }
                } else {
                    $error['captcha_error'] = '';
                    $this->profile($error);
                }
            } else {
                $error['captcha_error'] = 'Captcha code does not match, please try again.';
                $this->profile($error);
            }
        }
    }

    public function savePhoto()
    {

        $userdata = $this->session->userinfo;
        if ($this->input->post('photosubmit')) {
            if (isset($_FILES['profileImg']) && count($_FILES['profileImg']) > 0) {
                $profileImage = uploadImage($filename = 'profileImg', $imgUploadpath = 'assets/images/profile', $allowedTyp = "png|jpg|jpeg");

                $loginId = postData($userdata, 'LOGIN_ID');
                $updateData = [
                    'PROFILE_IMG' => $profileImage,
                ];

                $userWhere = [
                    'LOGIN_ID' => $loginId
                ];

                $update = $this->common_model->updateData('LOGIN_DETAILS', $updateData, $userWhere);
                if ($update) {
                    if ($profileImage != '') {
                        $userdata->PROFILE_IMG = $profileImage;
                        $session_data['user_details'] = $userdata;
                        $this->session->set_userdata($session_data);
                    }

                    $this->session->set_flashdata('profilemsg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> User Profile update successfully. </div>');
                    redirect('dashboard/profile/');
                } else {
                    $this->session->set_flashdata('profilemsg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> User Profile update failed </div>');
                    redirect('dashboard/profile/');
                }
            } else {
                $this->session->set_flashdata('profilemsg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> User Profile update failed </div>');
                redirect('dashboard/profile/');
            }
        }
    }

    public function getPTWStatusCounts($terminal = '', $year = '', $from = '', $to = '')
    {

        $Currentyear =  !empty($year) ? $year : date('Y');
        $options['where'] = [
            'PERMIT_TYPE' => '1',
            'PTW_STATUS' => 'Y',
            'YEAR(`CREATED_ON`)' => $Currentyear,
        ];

        // DATE FILTER
        if (!empty($from)) {
            $options['where']['DATE(START_DATE) >='] = $from;
        }

        if (!empty($to)) {
            $options['where']['DATE(END_DATE) <='] = $to;
        }

        $userType = getCurrentUserGroupId();
        $userid = getCurrentUserid();
        switch ($userType) {
            case 4:
                $options['where']['CREATED_BY'] = $userid;

                break;
            case 5:
                $options['where']['OA_USER_LOGIN_ID'] = $userid;

                break;
            case 6:
                $options['where']['SHO_HSE_USER_LOGIN_ID'] = $userid;

                break;
            case 11:
                $options['where']['CREATED_BY'] = $userid;

                break;

            default:
                break;
        }
        if (!empty($terminal)) {
            $options['where']['LOCATION'] = $terminal;
        }

        $options['return_type'] = 'row';
        return $actvity = $this->common_model->getAlldata('PTW', ["count(IF(`PTW_STATUS` = 'Y',`PTW_ID`, NULL)) totalptwcount", "count(IF(`STATUS` = 6 AND `PTW_STATUS` = 'Y',`PTW_ID`, NULL)) activeptwcount", "count(IF(`STATUS` = 7 AND `PTW_STATUS` = 'Y',PTW_ID, NULL)) completeptwcount", "count(IF(`PTW_STATUS` = 'Y' AND `STATUS` = 1 OR `PTW_STATUS` = 'Y' AND `STATUS` = 2 OR `PTW_STATUS` = 'Y' AND `STATUS` = 4 ,PTW_ID, NULL)) pendingptwcount", "count(IF(`STATUS` = 8 AND `PTW_STATUS` = 'Y',`PTW_ID`, NULL)) stopptwcount"], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
    }
    public function getPTWStatusCountsCrtical($terminal = '', $year = '', $from = '', $to = '')
    {

        $Currentyear =  !empty($year) ? $year : date('Y');

        $options['where'] = [
            'PERMIT_TYPE' => '2',
            'PTW_STATUS' => 'Y',
            'YEAR(`CREATED_ON`)' => $Currentyear,
        ];

        // DATE FILTER
        if (!empty($from)) {
            $options['where']['DATE(START_DATE) >='] = $from;
        }

        if (!empty($to)) {
            $options['where']['DATE(END_DATE) <='] = $to;
        }
        $userType = getCurrentUserGroupId();
        $userid = getCurrentUserid();
        switch ($userType) {
            case 4:
                $options['where']['CREATED_BY'] = $userid;

                break;
            case 5:
                $options['where']['OA_USER_LOGIN_ID'] = $userid;

                break;
            case 6:
                $options['where']['SHO_HSE_USER_LOGIN_ID'] = $userid;

                break;
            case 11:
                $options['where']['CREATED_BY'] = $userid;

                break;

            default:
                break;
        }

        if (!empty($terminal)) {
            $options['where']['LOCATION'] = $terminal;
        }
        $options['return_type'] = 'row';
        return $actvity = $this->common_model->getAlldata('PTW', ["count(IF(`PTW_STATUS` = 'Y',`PTW_ID`, NULL)) totalptwcount", "count(IF(`STATUS` = 6 AND `PTW_STATUS` = 'Y',`PTW_ID`, NULL)) activeptwcount", "count(IF(`STATUS` = 7 AND `PTW_STATUS` = 'Y',PTW_ID, NULL)) completeptwcount", "count(IF(`PTW_STATUS` = 'Y' AND `STATUS` = 1 OR `PTW_STATUS` = 'Y' AND `STATUS` = 2 OR  `PTW_STATUS` = 'Y' AND `STATUS` = 4 ,PTW_ID, NULL)) pendingptwcount", "count(IF(`STATUS` = 8 AND `PTW_STATUS` = 'Y',`PTW_ID`, NULL)) stopptwcount"], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
        // echo '<pre>';
        // print_r($this->db->last_query());
        // exit;
    }

    // public function getHIRARCStatusCounts() {
    //     $Currentyear = date("Y"); 
    //     $options['where'] = [
    //         'HIRARC_STATUS' => 'Y',
    //         'YEAR(`CREATED_ON`)'=> $Currentyear,
    //     ];
    //     $userType = getCurrentUserGroupId();
    //     $userid = getCurrentUserid();

    //     switch ($userType) {
    //         case is_admin() :
    //              $options['where'] = [
    //                     'HIRARC_STATUS' => 'Y',
    // 		'YEAR(`CREATED_ON`)'=> $Currentyear,
    //                 ];
    //             break;
    //         case 4:
    //            $options['where'] = [
    //                     'CREATED_BY' => $userid,
    // 		'YEAR(`CREATED_ON`)'=> $Currentyear,
    //                 ];

    //             break;
    //         case 5:
    //             $options['where'] = [
    //                     'HOD_ID' => $userid,
    // 		'YEAR(`CREATED_ON`)'=> $Currentyear,
    //                 ];

    //             break;
    //         case 6 || 7:
    //             $options['where'] = [
    //                     'HSSE_ID' => $userid,
    // 		'YEAR(`CREATED_ON`)'=> $Currentyear,
    //                 ];

    //             break;
    //         case 11:
    //             $options['where'] = [
    //                     'CREATED_BY' => $userid,
    // 		'YEAR(`CREATED_ON`)'=> $Currentyear,
    //                 ];

    //             break;

    //         default:
    //             break;
    //     }

    //     $options['return_type'] = 'row';
    //     return $actvity = $this->common_model->getAlldata('HIRARC_MAIN_FLOW', ["count(IF(`HIRARC_STATUS` = 'Y',`MAIN_AUTO_ID`, NULL)) totalhirarccount"], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
    // }
    public function getHIRARCStatusCounts($terminal = '', $year = '', $from = '', $to = '')
    {
        $Currentyear =  !empty($year) ? $year : date('Y');
        $options['where'] = [
            'HIRARC_STATUS' => 'Y',
            'YEAR(`CREATED_ON`)' => $Currentyear,
        ];
        
        $userType = getCurrentUserGroupId();
        $userid = getCurrentUserid();

        switch ($userType) {
            case is_admin():
                $options['where'] = [
                    'HIRARC_STATUS' => 'Y',
                    'YEAR(`CREATED_ON`)' => $Currentyear,
                ];

                break;
            case 4:
                $options['where'] = [
                    'CREATED_BY' => $userid,
                    'YEAR(`CREATED_ON`)' => $Currentyear,
                ];

                break;
            case 5:
                $options['where'] = [
                    'HOD_ID' => $userid,
                    'YEAR(`CREATED_ON`)' => $Currentyear,
                ];

                break;
            case 6 || 7:
                $options['where'] = [
                    'HSSE_ID' => $userid,
                    'YEAR(`CREATED_ON`)' => $Currentyear,
                ];

                break;
            case 11:
                $options['where'] = [
                    'CREATED_BY' => $userid,
                    'YEAR(`CREATED_ON`)' => $Currentyear,
                ];

                break;

            default:
                break;
        }

        if (!empty($terminal)) {
            $options['where']['FK_TERMINAL_ID'] = $terminal;
        }
          // DATE FILTER
        if (!empty($from)) {
            $options['where']['DATE(CREATED_ON) >='] = $from;
        }

        if (!empty($to)) {
            $options['where']['DATE(CREATED_ON) <='] = $to;
        }
        $options['return_type'] = 'row';
        $actvity = $this->common_model->getAlldata('HIRARC_MAIN_FLOW', ["count(IF(`HIRARC_STATUS` = 'Y',`MAIN_AUTO_ID`, NULL)) totalhirarccount"], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
        // echo $this->db->last_query();
        // exit;
        return $actvity;
    }

    private function getHmpInfo()
    {

        $start_date = date("Y-m-d", strtotime($this->input->get('start')));
        $end_date = date("Y-m-d", strtotime($this->input->get('end')));
        $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');

        global $hmpAccessList;
        global $hmpPermission;
        $table = HMP_MAIN;

        $userid = getCurrentUserid();
        $user_type = getCurrentUserGroupId();

        if (in_array($user_type, $hmpAccessList['add']) || is_admin()) {
            if ($user_type == 5) {
                $where = [
                    'HMP_STATUS' => 'Y',
                    'HMP_UNIT_HEAD_ID' => $userid,
                    'HMP_APP_START_DATE >= ' => $start_date,
                    'HMP_APP_START_DATE <= ' => $end_date,
                ];
            } else if ($user_type == 4) {
                $where = [
                    'HMP_STATUS' => 'Y',
                    'HMP_EXEC_ID' => $userid,
                    'HMP_APP_START_DATE >= ' => $start_date,
                    'HMP_APP_START_DATE <= ' => $end_date,
                ];
            } else {
                $where = [
                    'HMP_STATUS' => 'Y',
                    'HMP_APP_START_DATE >= ' => $start_date,
                    'HMP_APP_START_DATE <= ' => $end_date,
                ];
            }
        }

        if (!empty($terminal)) {
            $options['where']['HMP_LOC_ID'] = $terminal;
        }
        if (!empty($year)) {
            $options['where']['YEAR(CREATED_ON)'] = $year;
        }

        $options['where'] =  $where;
        $options['return_type'] = 'result';
        $programInfo = $this->common_model->getAlldata('HMP_MAIN_FLOW', ['*'], $options);
        // echo $this->db->last_query();

        if ($programInfo != FALSE && count($programInfo) > 0) {
            foreach ($programInfo as $row) {
                $pid = postData($row, 'HMP_AUTO_ID');
                $title = postData($row, 'HMP_ID');
                $startDate = postData($row, 'HMP_APP_START_DATE');
                $endDate = postData($row, 'END_DATE');
                $url = 'hmp/hmp/view/' . encryptval($pid);
                $events[] = [
                    'title' => $title,
                    'url' => $url,
                    'start' => $startDate,
                    'end' => $endDate,
                ];
            }
        }
        return $events;
    }
    private function getAtarInfo()
    {
        global $atarPermission;

        $start_date = date("Y-m-d", strtotime($this->input->get('start')));
        $end_date = date("Y-m-d", strtotime($this->input->get('end')));
        $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');

        $user_type = getCurrentUserGroupId();
        $userid = getCurrentUserid();


        if (in_array($user_type, $atarPermission['add']) || is_admin()) {
            if (in_array($user_type, $atarPermission['view']) || is_admin()) {
                $options['where'] = [

                    'ATAR_STATUS' => 'Y',
                    'ATAR_REPORT_DATETIME >= ' => $start_date,
                    'ATAR_REPORT_DATETIME <= ' => $end_date,
                ];
            } elseif (in_array($user_type, $atarPermission['fix'])) {
                $options['orwhere'] = [

                    'ATAR_ASSIGN_HOD_ID' => $userid,
                    'ATAR_REPORTER_ID' => $userid,
                    'ATAR_REPORT_DATETIME >= ' => $start_date,
                    'ATAR_REPORT_DATETIME <= ' => $end_date,
                ];
                $options['where'] = [
                    'ATAR_STATUS' => 'Y',
                    'ATAR_REPORT_DATETIME >= ' => $start_date,
                    'ATAR_REPORT_DATETIME <= ' => $end_date,
                ];
            } elseif (in_array($user_type, $atarPermission['approve'])) {
                $options['where'] = [
                    'ATAR_STATUS' => 'Y',
                    'ATAR_REPORT_DATETIME >= ' => $start_date,
                    'ATAR_REPORT_DATETIME <= ' => $end_date,
                ];
            } else {
                $options['where'] = [
                    'ATAR_STATUS' => 'Y',
                    'ATAR_REPORTER_ID' => $userid,
                    'ATAR_REPORT_DATETIME >= ' => $start_date,
                    'ATAR_REPORT_DATETIME <= ' => $end_date,
                ];
            }
        }
        if (!empty($terminal)) {
            $options['where']['ATAR_LOC_ID'] = $terminal;
        }
        if (!empty($year)) {
            $options['where']['YEAR(CREATED_ON)'] = $year;
        }



        $getatarinfo = $this->common_model->getAlldata('ATAR_MAIN_FLOW', ["*,COUNT(ATAR_AUTO_ID) as atar_count"], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");

        // echo $this->db->last_query();
        //        echo "<pre>";
        //        print_r($getatarinfo);exit;
        $events = [];
        if ($getatarinfo != FALSE && count($getatarinfo) > 0) {
            foreach ($getatarinfo as $row) {
                $pid = postData($row, 'ATAR_AUTO_ID');
                $title = postData($row, 'ATAR_ID');
                $startDate = date('Y-m-d', strtotime(postData($row, 'ATAR_REPORT_DATETIME')));

                $endDate = postData($row, 'ATAR_HSSE_DATE');
                $urldirect = postData($row, 'ATAR_TYPE_ID');
                if ($urldirect == 1) {
                    $url = 'atar/usee/view/' . encryptval($pid);
                } elseif ($urldirect == 2) {
                    $url = 'atar/daily/view/' . encryptval($pid);
                } elseif ($urldirect == 3) {
                    $url = 'atar/monthly/view/' . encryptval($pid);
                } elseif ($urldirect == 4) {
                    $url = 'atar/incident/view/' . encryptval($pid);
                }


                $events[] = [
                    'title' => $title,
                    'url' => $url,
                    'start' => $startDate,
                    'end' => $endDate,
                ];
            }
        }
        return $events;
    }

    private function getHirarcInfo()
    {
        //         global $hirarcPermission;

        $start_date = date("Y-m-d", strtotime($this->input->get('start')));
        $end_date = date("Y-m-d", strtotime($this->input->get('end')));
        $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');

        $user_type = getCurrentUserGroupId();
        $userid = getCurrentUserid();


        switch ($user_type) {
            case is_admin():
                $options['where']['HIRARC_STATUS'] = 'Y';
                $options['where']['CREATED_DATE >= '] = $start_date;
                $options['where']['CREATED_DATE <= '] = $end_date;

                break;
            case 4:
                $options['where']['CREATED_BY'] = $userid;
                $options['where']['CREATED_DATE >= '] = $start_date;
                $options['where']['CREATED_DATE <= '] = $end_date;

                break;
            case 5:
                $options['where']['HOD_ID'] = $userid;
                $options['where']['CREATED_DATE >= '] = $start_date;
                $options['where']['CREATED_DATE <= '] = $end_date;

                break;
            case 6 || 7:
                $options['where']['HSSE_ID'] = $userid;
                $options['where']['CREATED_DATE >= '] = $start_date;
                $options['where']['CREATED_DATE <= '] = $end_date;

                break;
            case 11:
                $options['where']['CREATED_BY'] = $userid;
                $options['where']['CREATED_DATE >= '] = $start_date;
                $options['where']['CREATED_DATE <= '] = $end_date;

                break;

            default:
                break;
        }

        if (!empty($terminal)) {
            $options['where']['FK_TERMINAL_ID'] = $terminal;
        }
        if (!empty($year)) {
            $options['where']['YEAR(CREATED_ON)'] = $year;
        }


        $gethirarcinfo = $this->common_model->getAlldata('HIRARC_MAIN_FLOW', ["*"], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");

        //               echo $this->db->last_query();
        //        echo "<pre>";
        //        print_r($gethirarcinfo);exit;
        $events = [];
        if ($gethirarcinfo != FALSE && count($gethirarcinfo) > 0) {
            foreach ($gethirarcinfo as $row) {
                $pid = postData($row, 'MAIN_AUTO_ID');
                $title = postData($row, 'HIRARC_ID');
                $startDate = date('Y-m-d', strtotime(postData($row, 'CREATED_DATE')));

                $endDate = postData($row, 'HSSE_DATE');
                $urldirect = postData($row, 'HIRARC_FLOW_STATUS');
                if ($urldirect != 0) {
                    $url = 'hirarc/hirarc/view_report/' . encryptval($pid);
                }


                $events[] = [
                    'title' => $title,
                    'url' => $url,
                    'start' => $startDate,
                    'end' => $endDate,
                ];
            }
        }
        return $events;
    }

    public function program_pie_dashboard($terminal = '', $year = '',$from = '', $to = '')
    {
        global $hmpAccessList;
        $user_type = getCurrentUserGroupId();
        $userid    = getCurrentUserid();
        $changeinteryear = !empty($year) ? $year : date('Y');

        // build options
        $options = [];
        $options['where'] = [];

        // DATE FILTER
        if (!empty($from)) {
            $options['where']['DATE(HMP_APP_START_DATE) >='] = $from;
        }

        if (!empty($to)) {
            $options['where']['DATE(HMP_APP_END_DATE) <='] = $to;
        }

        // user access based conditions
        if (in_array($user_type, $hmpAccessList['add']) || is_admin()) {
            if ($user_type == 5) {
                $options['where']['HMP_STATUS'] = 'Y';
                $options['where']['HMP_UNIT_HEAD_ID'] = $userid;
            } else if ($user_type == 4) {
                $options['where']['HMP_STATUS'] = 'Y';
                $options['where']['HMP_EXEC_ID'] = $userid;
            } else {
                $options['where']['HMP_STATUS'] = 'Y';
            }
        }

        // ✅ add year filter
        if (!empty($changeinteryear)) {
            $options['where']["YEAR(CREATED_ON)"] = $changeinteryear;
        }

        // ✅ add terminal filter
        if (!empty($terminal)) {
            $options['where']["HMP_LOC_ID"] = $terminal;
        }

        $options['return_type'] = 'row';

        $getInterventionData = $this->common_model->getAlldata(
            'HMP_MAIN_FLOW',
            [
                "count(IF(`HMP_APP_STATUS` = 1 AND `HMP_STATUS` = 'Y',`HMP_AUTO_ID`, NULL)) Pendingcount",
                "count(IF(`HMP_APP_STATUS` = 2 AND `HMP_STATUS` = 'Y',`HMP_AUTO_ID`, NULL)) Completedcount",
                "count(IF(`HMP_APP_STATUS` = 3 AND `HMP_STATUS` = 'Y',`HMP_AUTO_ID`, NULL)) Overduecount",
                "count(IF(`HMP_APP_STATUS` = 4 AND `HMP_STATUS` = 'Y',`HMP_AUTO_ID`, NULL)) Postponecount"
            ],
            $options
        );

        // Debug check
        // echo $this->db->last_query(); exit;

        $ProgramCountOverdue   = ($getInterventionData != FALSE) ? postdata($getInterventionData, 'Overduecount', 0) : 0;
        $ProgramCountComplete  = ($getInterventionData != FALSE) ? postdata($getInterventionData, 'Completedcount', 0) : 0;
        $ProgramCountPostpone  = ($getInterventionData != FALSE) ? postdata($getInterventionData, 'Postponecount', 0) : 0;
        $ProgramCountPending   = ($getInterventionData != FALSE) ? postdata($getInterventionData, 'Pendingcount', 0) : 0;

        $piedata = [
            $ProgramCountOverdue,
            $ProgramCountComplete,
            $ProgramCountPostpone,
            $ProgramCountPending,
        ];
        return $piedata;
    }


    public function totalAtarCount($terminal = '', $year = '' , $from, $to)
    {
        global $atarPermission;
        $user_type = getCurrentUserGroupId();
        $userid = getCurrentUserid();

        $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $colorcode = ['#FF0F00', '#FF6600', '#FF9E01', '#FCD202', '#F8FF01', '#B0DE09', '#04D215', '#0D8ECF', '#0D52D1', '#2A0CD0', '#8A0CCF', '#CD0D74'];
        $default_array = [];

        foreach ($month as $c => $mon) {
            $default_array[] = [
                'month' => $mon,
                'count' => 0,
                'color' => $colorcode[$c]
            ];
        }

        // $changeinteryearoverall = date('Y');
        $changeinteryearoverall = !empty($year) ? $year : date('Y');


        if (in_array($user_type, $atarPermission['add']) || is_admin()) {
            if (in_array($user_type, $atarPermission['view']) || is_admin()) {
                $options['where'] = [
                    "YEAR(ATAR_REPORT_DATETIME)" => $changeinteryearoverall,
                    'ATAR_STATUS' => 'Y'
                ];
            } elseif (in_array($user_type, $atarPermission['fix'])) {
                $options['orwhere'] = [
                    'ATAR_ASSIGN_HOD_ID' => $userid,
                    'ATAR_REPORTER_ID' => $userid
                ];
                $options['where'] = [
                    "YEAR(ATAR_REPORT_DATETIME)" => $changeinteryearoverall,
                    'ATAR_STATUS' => 'Y'
                ];
            } elseif (in_array($user_type, $atarPermission['unit'])) {
                $options['orwhere'] = [
                    'ATAR_ASSIGN_UNIT_ID' => $userid,
                    'ATAR_REPORTER_ID' => $userid
                ];
                $options['where'] = [
                    "YEAR(ATAR_REPORT_DATETIME)" => $changeinteryearoverall,
                    'ATAR_STATUS' => 'Y'
                ];
            } elseif (in_array($user_type, $atarPermission['approve'])) {
                $options['where'] = [
                    "YEAR(ATAR_REPORT_DATETIME)" => $changeinteryearoverall,
                    'ATAR_STATUS' => 'Y'
                ];
            } else {
                $options['where'] = [
                    "YEAR(ATAR_REPORT_DATETIME)" => $changeinteryearoverall,
                    'ATAR_STATUS' => 'Y',
                    'ATAR_REPORTER_ID' => $userid
                ];
            }
        }

        // DATE FILTER
        if (!empty($from)) {
            $options['where']['DATE(CREATED_ON) >='] = $from;
        }

        if (!empty($to)) {
            $options['where']['DATE(CREATED_ON) <='] = $to;
        }
        if (!empty($terminal)) {
            $options['where']['ATAR_LOC_ID'] = $terminal;
        }



        $options['group_by'] = 'YEAR(ATAR_REPORT_DATETIME),MONTH(ATAR_REPORT_DATETIME)';

        $options['order_by'] = [
            "DESC" => 'MONTH(ATAR_REPORT_DATETIME)'
        ];

        // $options['select'] = ['COUNT(ATAR_AUTO_ID) as atar_count','YEAR(ATAR_REPORT_DATETIME) as year','MONTHNAME(ATAR_REPORT_DATETIME) as month']; 
        //  $getobserdata = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $options);

        $getobserdata = $this->common_model->getAlldata('ATAR_MAIN_FLOW', ["COUNT(ATAR_AUTO_ID) as atar_count,YEAR(ATAR_REPORT_DATETIME) as year,MONTHNAME(ATAR_REPORT_DATETIME) as month"], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
        // echo $this->db->last_query();exit;
        if ($getobserdata != FALSE && count($getobserdata) > 0) {
            foreach ($getobserdata as $key => $obsvalue) {
                //print_r($obsvalue);exit;
                $obserdata[$obsvalue->month] = (array) $obsvalue;
                $monthval[] = $obsvalue->month;
            }
        }

        if (is_array($getobserdata)) {
            foreach ($month as $key => $value) {
                if (in_array($value, $monthval)) {
                    $obserData[] = array(
                        'month' => $value,
                        'count' => $obserdata[$value]['atar_count'],
                        'color' => $colorcode[$key]
                    );
                } else {
                    $obserData[] = array(
                        'month' => $value,
                        'count' => 0,
                        'color' => $colorcode[$key]
                    );
                }
            }
            $finalobserdata = json_encode($obserData);
        } else {
            $finalobserdata = json_encode($default_array);
        }
        return $finalobserdata;
    }

    public function atarCountDisplay($terminal = '', $year = '',$from, $to)
    {
        global $atarPermission;
        $user_type = getCurrentUserGroupId();
        $userid = getCurrentUserid();
        // $Currentyear = date("Y"); 
        $Currentyear =  !empty($year) ? $year : date('Y');




        if (in_array($user_type, $atarPermission['add']) || is_admin()) {
            if (in_array($user_type, $atarPermission['view']) || is_admin()) {
                $options['where'] = [
                    'ATAR_STATUS' => 'Y',
                    'ATAR_APP_STATUS !=' => 2,
                    'YEAR(`CREATED_ON`)' => $Currentyear,
                ];
            } elseif (in_array($user_type, $atarPermission['fix'])) {
                $options['orwhere'] = [
                    'ATAR_ASSIGN_HOD_ID' => $userid,
                    'ATAR_REPORTER_ID' => $userid,
                    'YEAR(`CREATED_ON`)' => $Currentyear,
                ];
                $options['where'] = [
                    'ATAR_STATUS' => 'Y',
                    'ATAR_APP_STATUS !=' => 2,
                    'YEAR(`CREATED_ON`)' => $Currentyear,
                ];
            } elseif (in_array($user_type, $atarPermission['unit'])) {
                $options['orwhere'] = [
                    'ATAR_ASSIGN_UNIT_ID' => $userid,
                    'ATAR_REPORTER_ID' => $userid,
                    'YEAR(`CREATED_ON`)' => $Currentyear,
                ];
                $options['where'] = [
                    'ATAR_STATUS' => 'Y',
                    'ATAR_APP_STATUS !=' => 2,
                    'YEAR(`CREATED_ON`)' => $Currentyear,
                ];
            } elseif (in_array($user_type, $atarPermission['approve'])) {
                $options['where'] = [
                    'ATAR_STATUS' => 'Y',
                    'ATAR_APP_STATUS !=' => 2,
                    'YEAR(`CREATED_ON`)' => $Currentyear,

                ];
            } else {
                $options['where'] = [
                    'ATAR_STATUS' => 'Y',
                    'ATAR_REPORTER_ID' => $userid,
                    'ATAR_APP_STATUS !=' => 2,
                    'YEAR(`CREATED_ON`)' => $Currentyear,
                ];
            }
        }

           // DATE FILTER
        if (!empty($from)) {
            $options['where']['DATE(CREATED_ON) >='] = $from;
        }

        if (!empty($to)) {
            $options['where']['DATE(CREATED_ON) <='] = $to;
        }
        if (!empty($terminal)) {
            $options['where']['LOCATION_ID'] = $terminal;
        }



        $options['return_type'] = 'row';
        $getatarinfo = $this->common_model->getAlldata('ATAR_MAIN_FLOW', ["COUNT(ATAR_AUTO_ID) as atar_count"], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");



        return $getatarinfo;
    }

    public function incidentbarCounts($terminal = '', $year = '',$from = '', $to = '')
    {
       
        $year1       = $year;
        $year        = !empty($year1) ? $year1 : date('Y');
        $terminal    = $terminal;
        $displayType = $this->input->get('type');
//   print_r($terminal);
//         exit;
       

        $testing     = [5, 7, 9, 11, 6, 8, 13, 12];
        $stssVerfy   = [6, 12, 11, 8];
        $stssApry    = [8, 12];

        $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $colorcode = ['#0c0a0a', '#f186f3', '#91d79d', '#d3cd14', '#eb755a', '#3accd3', '#4b82b1b3', '#e1873c', '#712edf', '#3ed792', '#0f61b9', '#cd2ce1'];

        $default_array = [];
        foreach ($month as $c => $mon) {
            $default_array[] = [
                'month' => $mon,
                'count' => 0,
                'color' => $colorcode[$c]
            ];
        }

        $changeinteryearoverall = !empty($year) ? $year : date('Y');

        // build options
        $options = [];
        $options['where'] = [];

        // ✅ add terminal condition
        if (!empty($terminal)) {
            $options['where']['LOCATION_ID'] = $terminal;
        }
          // DATE FILTER
    if (!empty($from)) {
        $options['where']['DATE(CREATED_ON) >='] = $from;
    }

    if (!empty($to)) {
        $options['where']['DATE(CREATED_ON) <='] = $to;
    }

        // ✅ add year condition
        if (!empty($changeinteryearoverall)) {
            $options['where']['YEAR(CREATED_ON)'] = $changeinteryearoverall;
        }

        // ✅ display type conditions
        if ($displayType == 'init') {
            if (in_array($_SESSION['userinfo']->USER_TYPE_ID, [6, 7, 1, 2])) {
                $options['where']['NOTIFY_STATUS'] = 'Y';
            } else {
                $options['where']['EVENT_REPORTED_BY'] = $_SESSION['id'];
            }
        } elseif ($displayType == 'invest') {
            if (in_array($_SESSION['userinfo']->USER_TYPE_ID, [6, 7, 1, 2])) {
                $options['where']['NOTIFY_STATUS'] = 'Y';
            }

            if ($_SESSION['userinfo']->USER_TYPE_ID == '8' && $_SESSION['userinfo']->USER_DESINATION_ID == '22') {
                $options['where']['LOCATION_ID'] = '1';
                $options['where_in'] = ['STATUS' => $stssVerfy];
            } elseif ($_SESSION['userinfo']->USER_TYPE_ID == '8' && $_SESSION['userinfo']->USER_DESINATION_ID == '18') {
                $options['where']['LOCATION_ID'] = '2';
                $options['where_in'] = ['STATUS' => $stssVerfy];
            } elseif ($_SESSION['userinfo']->USER_TYPE_ID == '9') {
                $options['where_in'] = ['STATUS' => $stssApry];
            } else {
                $options['where_in'] = ['STATUS' => $testing];
            }
        }

        // ✅ ensure NOTIFY_STATUS always applied
        if (!isset($options['where']['NOTIFY_STATUS'])) {
            $options['where']['NOTIFY_STATUS'] = 'Y';
        }

        $options['group_by'] = 'YEAR(CREATED_ON),MONTH(CREATED_ON)';
        $options['order_by'] = ["DESC" => 'MONTH(CREATED_ON)'];

        $getobserdata = $this->common_model->getAlldata(
            'INCIDENT_NOTIFICATION_DETAILS',
            ["COUNT(INCIDENT_ID) as atar_count,YEAR(CREATED_ON) as year,MONTHNAME(CREATED_ON) as month"],
            $options
        );

        // Debug SQL
        // echo $this->db->last_query();exit;

        if ($getobserdata != FALSE && count($getobserdata) > 0) {
            foreach ($getobserdata as $key => $obsvalue) {
                $obserdata[$obsvalue->month] = (array) $obsvalue;
                $monthval[] = $obsvalue->month;
            }
        }

        if (is_array($getobserdata)) {
            foreach ($month as $key => $value) {
                if (isset($monthval) && in_array($value, $monthval)) {
                    $obserData[] = array(
                        'month' => $value,
                        'count' => $obserdata[$value]['atar_count'],
                        'color' => $colorcode[$key]
                    );
                } else {
                    $obserData[] = array(
                        'month' => $value,
                        'count' => 0,
                        'color' => $colorcode[$key]
                    );
                }
            }
            $finalobserdata = json_encode($obserData);
        } else {
            $finalobserdata = json_encode($default_array);
        }
        return $finalobserdata;
    }


        public function inspecCountDisplay($terminal = '', $year = '',$from, $to)
        {
            global $atarPermission;
            $user_type = getCurrentUserGroupId();
            $userid = getCurrentUserid();
            $Currentyear = !empty($year) ? $year : date('Y');

            $options['where'] = [
                'INSP_STATUS' => 'Y',
                'YEAR(`CREATED_ON`)' => $Currentyear,
            ];
            //    $userType = getCurrentUserGroupId();
            //    $userid = getCurrentUserid();
            if (!empty($terminal)) {
                $options['where']['INSP_TER_ID'] = $terminal;
            }
               // DATE FILTER
            if (!empty($from)) {
                $options['where']['DATE(CREATED_ON) >='] = $from;
            }

            if (!empty($to)) {
                $options['where']['DATE(CREATED_ON) <='] = $to;
            }


            $options['return_type'] = 'row';
            $inspectionInfo = $this->common_model->getAlldata(HSSE_INSP_MAIN, ['count(INSP_AUTO_ID) as inspecnot_count'], $options);

            $optionsmon['where'] = [
                'MON_INSP_STATUS' => 'Y',
                'YEAR(`CREATED_ON`)' => $Currentyear,
            ];
            if (!empty($terminal)) {
                $optionsmon['where']['MON_INSP_TER_ID'] = $terminal;
            }
            $optionsmon['return_type'] = 'row';
            $inspectionmonInfo = $this->common_model->getAlldata(MON_INSP_MAIN, ['count(MON_INSP_AUTO_ID) as inspecmain_count'], $optionsmon);

            $norInspcount = postData($inspectionInfo, 'inspecnot_count');
            $mainInspcount = postData($inspectionmonInfo, 'inspecmain_count');

            $finalInspcount['inspec_count'] = $norInspcount + $mainInspcount;
            //        echo sum(postData($inspectionInfo,'inspecnot_count'),postData($inspectionmonInfo,'inspecmain_count'));

            return $finalInspcount;
        }
    public function sliderData()
    {
        $getAllslider = [];
        $desigOptn['where'] = [
            'SLI_STATUS' => 'Y'
        ];
        $getAllslider = $this->common_model->getAlldata(DASH_SLIDER, ['*'], $desigOptn);
        return $getAllslider;
    }

       public function main_dashboard($terminal = '', $year = '',$from = '',$to='')
    {
        // $ptwCounts = $this->getPTWStatusCounts($terminal, $year);
        // $ptwCountsCritical = $this->getPTWStatusCountsCrtical($terminal, $year);
       
        // $hirarcCounts = $this->getHIRARCStatusCounts($terminal, $year);

        // // $calendarInfo = $this->getCalendarInfo();
        // $piedata = $this->program_pie_dashboard($terminal, $year);
        // $atarCountdata = $this->totalAtarCount($terminal, $year);
        // $AtarCountDisplaydata = $this->atarCountDisplay($terminal, $year);
        // $inspecCountDisplaydata = $this->inspecCountDisplay($terminal, $year);
        // $incidentCount = $this->incidentNotifyCount($terminal, $year);
        // $incidentbarCount = $this->incidentbarCounts($terminal, $year);
        // $sliderData = $this->sliderData();

        $ptwCounts              = $this->getPTWStatusCounts($terminal, $year, $from, $to);

        $ptwCountsCritical      = $this->getPTWStatusCountsCrtical($terminal, $year, $from, $to);

        $hirarcCounts           = $this->getHIRARCStatusCounts($terminal, $year, $from, $to);

        $piedata                = $this->program_pie_dashboard($terminal, $year, $from, $to);

        $atarCountdata          = $this->totalAtarCount($terminal, $year, $from, $to);

        $AtarCountDisplaydata   = $this->atarCountDisplay($terminal, $year, $from, $to);

        $inspecCountDisplaydata = $this->inspecCountDisplay($terminal, $year, $from, $to);

        $incidentCount          = $this->incidentNotifyCount($terminal, $year, $from, $to);

        $incidentbarCount       = $this->incidentbarCounts($terminal, $year, $from, $to);

        $sliderData             = $this->sliderData();

        //new

          $userCounts = $this->getUserCounts($terminal, $year, $from, $to);


        $terminWhere['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $terNamedatas = $this->common_model->getAlldata(TERM, ['*'], $terminWhere);
        if (is_array($terNamedatas)) {
            $getterminalNamedatas = customFormDropDown($terNamedatas, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');
        }

        // echo 'M<pre>';print_r($userCounts);exit;
        $data = array(
            // 'calendarInfo' => $calendarInfo,
            'view_file' => 'dashboard/dashboard',
            'title' => 'Dashboard',
            'current_menu' => 'Dashboard',
            'ptwCounts' => $ptwCounts,
            'ptwCountsCritical' => $ptwCountsCritical,
            'getterminalNamedatas' => $getterminalNamedatas,
            'programpiedata' => $piedata,
            'atarCountdata' => $atarCountdata,
            'AtarCountDisplaydata' => $AtarCountDisplaydata,
            'totalInspeccount' => $inspecCountDisplaydata,
            'incidentbarCount' => $incidentbarCount,
            'incidentCount' => $incidentCount,
            'hirarcCounts' => $hirarcCounts,
            'userCounts' => $userCounts,
            'sliderData' => $sliderData,
            'terminal' => $terminal,
            'year' => $year,
            'from_date' =>$from,
            'to_date' =>$to,
            'headerfiles' => array(
                "css" => array(
                    //"assets/plugins/jvectormap/jquery-jvectormap.css",
                    // "assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css",
                    //  "assets/plugins/bootstrap-daterangepicker/daterangepicker.css",
                ),
                "js" => array(
                    "assets/plugins/amcharts/amcharts.js",
                    "assets/plugins/amcharts/serial.js",
                    "assets/plugins/amcharts/pie.js",
                    "assets/plugins/amcharts/themes/light.js"
                ),
                "priority" => 'high'
            )
        );

        $this->template->load_common_template($data);
    }

     public function getUserCounts($terminal = '', $year = '', $from_date = '', $to_date = '')
    {
        $data = array();

        $use_filter = (!empty($from_date) && !empty($to_date));

        // =========================
        // EXTERNAL USERS
        // =========================

        // TOTAL
        $this->db->reset_query();
        $this->db->select('COUNT(DISTINCT LD.USER_REF_ID) as total');
        $this->db->from('LOGIN_DETAILS LD');
        $this->db->join('EMPLOYEE_MANAGEMENT EM', 'EM.EMP_AUTO_ID = LD.USER_REF_ID');
        $this->db->where('LD.USER_LOGIN_TYP', 0);
        $this->db->where('EM.EMP_STATUS', 'Y');
        $this->db->where('EM.EMP_LOGIN_STATUS', 'E');

        if (!empty($terminal)) {
            $this->db->where('EM.EMP_LOC_ID', $terminal);
        }

        if ($use_filter) {
            $this->db->where('LD.CREATED_ON >=', $from_date . ' 00:00:00');
            $this->db->where('LD.CREATED_ON <=', $to_date . ' 23:59:59');
        }

        if (!empty($year)) {
            $this->db->where('YEAR(LD.CREATED_ON)', $year);
        }

        $query = $this->db->get();
        $data['employee_total'] = ($query) ? $query->row()->total : 0;


        // TODAY
        $this->db->reset_query();
        $this->db->select('COUNT(DISTINCT LD.USER_REF_ID) as total');
        $this->db->from('LOGIN_DETAILS LD');
        $this->db->join('EMPLOYEE_MANAGEMENT EM', 'EM.EMP_AUTO_ID = LD.USER_REF_ID');
        $this->db->where('LD.USER_LOGIN_TYP', 0);
        $this->db->where('EM.EMP_STATUS', 'Y');
        $this->db->where('EM.EMP_LOGIN_STATUS', 'E');
        $this->db->where('LD.CREATED_ON >=', date('Y-m-d') . ' 00:00:00');
        $this->db->where('LD.CREATED_ON <=', date('Y-m-d') . ' 23:59:59');

        $query = $this->db->get();
        $data['employee_today'] = ($query) ? $query->row()->total : 0;


        // MONTH
        $this->db->reset_query();
        $this->db->select('COUNT(DISTINCT LD.USER_REF_ID) as total');
        $this->db->from('LOGIN_DETAILS LD');
        $this->db->join('EMPLOYEE_MANAGEMENT EM', 'EM.EMP_AUTO_ID = LD.USER_REF_ID');
        $this->db->where('LD.USER_LOGIN_TYP', 0);
        $this->db->where('EM.EMP_STATUS', 'Y');
        $this->db->where('EM.EMP_LOGIN_STATUS', 'E');
        $this->db->where('MONTH(LD.CREATED_ON)', date('m'));
        $this->db->where('YEAR(LD.CREATED_ON)', date('Y'));

        $query = $this->db->get();
        $data['employee_month'] = ($query) ? $query->row()->total : 0;


        // =========================
        // INTERNAL USERS
        // =========================

        // TOTAL
        $this->db->reset_query();
        $this->db->select('COUNT(DISTINCT LD.USER_REF_ID) as total');
        $this->db->from('LOGIN_DETAILS LD');
        $this->db->join('CONTRACTOR_DETAILS CD', 'CD.CONT_AUTO_ID = LD.USER_REF_ID');
        $this->db->where('LD.USER_LOGIN_TYP', 1);
        $this->db->where('CD.CON_LOGIN_STATUS', 'E');
        $this->db->where('CD.CONT_STATUS', 'Y');

        if ($use_filter) {
            $this->db->where('LD.CREATED_ON >=', $from_date . ' 00:00:00');
            $this->db->where('LD.CREATED_ON <=', $to_date . ' 23:59:59');
        }

        if (!empty($year)) {
            $this->db->where('YEAR(LD.CREATED_ON)', $year);
        }

        $query = $this->db->get();
        $data['contracter_total'] = ($query) ? $query->row()->total : 0;


        // TODAY
        $this->db->reset_query();
        $this->db->select('COUNT(DISTINCT LD.USER_REF_ID) as total');
        $this->db->from('LOGIN_DETAILS LD');
        $this->db->join('CONTRACTOR_DETAILS CD', 'CD.CONT_AUTO_ID = LD.USER_REF_ID');
        $this->db->where('LD.USER_LOGIN_TYP', 1);
        $this->db->where('CD.CON_LOGIN_STATUS', 'E');
        $this->db->where('CD.CONT_STATUS', 'Y');
        $this->db->where('LD.CREATED_ON >=', date('Y-m-d') . ' 00:00:00');
        $this->db->where('LD.CREATED_ON <=', date('Y-m-d') . ' 23:59:59');

        $query = $this->db->get();
        $data['contracter_today'] = ($query) ? $query->row()->total : 0;


        // MONTH
        $this->db->reset_query();
        $this->db->select('COUNT(DISTINCT LD.USER_REF_ID) as total');
        $this->db->from('LOGIN_DETAILS LD');
        $this->db->join('CONTRACTOR_DETAILS CD', 'CD.CONT_AUTO_ID = LD.USER_REF_ID');
        $this->db->where('LD.USER_LOGIN_TYP', 1);
        $this->db->where('CD.CON_LOGIN_STATUS', 'E');
        $this->db->where('CD.CONT_STATUS', 'Y');
        $this->db->where('MONTH(LD.CREATED_ON)', date('m'));
        $this->db->where('YEAR(LD.CREATED_ON)', date('Y'));

        $query = $this->db->get();
        $data['contracter_month'] = ($query) ? $query->row()->total : 0;

        return $data;
    }

    public function notify($id = '')
    {

        $userid = getCurrentUserid();
        $userGroupId = getCurrentUserGroupId();
        $allRead = $this->input->get('all');
        if (isset($allRead)) {
            if ($allRead == 'notify') {
                $getNotificationCount = getUnreadNotification();
            }
            if ($allRead == 'task') {
                $getNotificationCount = getUnreadTask();
            }
            $NotifyIds = (isset($getNotificationCount->notify_ids) && !empty($getNotificationCount->notify_ids)) ? explode(',', $getNotificationCount->notify_ids) : array();

            if (count($NotifyIds) > 0) {
                foreach ($NotifyIds as $val) {
                    $notifyData = array(
                        'NOTIFICATION_USER_MASTER_ID' => $userid,
                        'NOTIFICATION_LOG_NOTI_ID' => $val,
                        'CREATED_ON' => date('Y-m-d H:i:s')
                    );
                    $data[] = $notifyData;
                }
                $this->db->insert_batch(NOTI_LOG, $data);
            }
        }

        $noId = decryptval($id);
        $notificationInfo = array();
        if ($noId != FALSE) {
            $where = array('where' => array('NOTIFICATION_ID' => $noId));
            $notificationInfo = getNotificationInfo('*', $where);
        }

        if ($notificationInfo != false) {
            $aherf = (isset($notificationInfo->NOTIFICATION_HREF) && $notificationInfo->NOTIFICATION_HREF != '') ? $notificationInfo->NOTIFICATION_HREF : false;
            $nid = (isset($notificationInfo->NOTIFICATION_ID) && $notificationInfo->NOTIFICATION_ID != '') ? $notificationInfo->NOTIFICATION_ID : false;
            if ($aherf != '') {
                $data = array(
                    'NOTIFICATION_USER_MASTER_ID' => $userid,
                    'NOTIFICATION_LOG_NOTI_ID' => $nid,
                    'CREATED_ON' => date('Y-m-d H:i:s')
                );
                $condition = array(
                    'NOTIFICATION_USER_MASTER_ID' => $userid,
                    'NOTIFICATION_LOG_NOTI_ID' => $nid
                );
                $insert = $this->common_model->updateInfo(NOTI_LOG, $data, 'NOTIFICATION_LOG_ID', $condition);

                /////new code start
                $getNotificationCount = getUnreadNotification();
                $NotifyIds = (isset($getNotificationCount->notify_ids) && !empty($getNotificationCount->notify_ids)) ? explode(',', $getNotificationCount->notify_ids) : array();

                if (count($NotifyIds) > 0) {
                    foreach ($NotifyIds as $val) {
                        if ($val != $noId) {
                            $notifyData = array(
                                'NOTIFICATION_USER_MASTER_ID' => $userid,
                                'NOTIFICATION_LOG_NOTI_ID' => $val,
                                'CREATED_ON' => date('Y-m-d H:i:s')
                            );
                            $datanew[] = $notifyData;
                        }
                    }
                    $this->db->insert_batch(NOTI_LOG, $datanew);
                }
                /////new code end
                if ($insert) {
                    $redirectUrl = BASE_URL . $aherf;
                    redirect($redirectUrl);
                    exit;
                }
            }
        }

        if (isset($allRead)) {
            if ($allRead == 'notify') {
                //                $data = array(
                //                    'view_file' => 'notification/notify_list',
                //                    'current_menu' => '',
                //                    'ajaxurl' => 'dashboard/notifyList?id=1',
                //                );
                //                $this->template->load_table_template($data);
                redirect(BASE_URL . 'dashboard');
            }
            if ($allRead == 'task') {
                //                $data = array(
                //                    'view_file' => 'notification/notify_list',
                //                    'current_menu' => '',
                //                    'ajaxurl' => 'dashboard/notifyList?id=2',
                //                );
                //                $this->template->load_table_template($data);
                redirect(BASE_URL . 'dashboard');
            }
        }
    }

    public function notifyList()
    {
        $option = [];
        $userid = getCurrentUserid();
        $msgtype = $_GET['id'];
        $noWhere = array('where' => array('NOTIFICATION_TYPE' => $msgtype), 'orwhere' => array('NOTIFICATION_GROUP_CATID =' => '', 'NOTIFICATION_EMPLOYEE_ID' => ''));
        if (!is_admin()) {
            $option['find_in_set'] = array('NOTIFICATION_EMPLOYEE_ID' => $userid);
        }
        $notification = $this->common_model->get_datatables_notify($noWhere, $option);
        $no = $_POST['start'];
        $data_inc = array();
        foreach ($notification as $notify) {
            $action = '';
            $notifyData = array();

            //$row_inc[] = $no;
            $notifyData[] = $notify->NOTIFICATION_DESC;
            $notifyData[] = timeago($notify->CREATED_ON);
            $notifyData[] = $action;
            $data_inc[] = $notifyData;
        }

        $output_inc = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->common_model->count_all_notify(),
            "recordsFiltered" => $this->common_model->count_filtered_notify(),
            "data" => $data_inc,
        );
        //output to json format
        echo json_encode($output_inc);
    }

    public function getCalendarInfo()
    {

        // print_r($_GET);
        // exit;

        $output_arrays = [];
        $notifyEventt = $this->getNotifyInfo();
        $permitEventt = $this->getPTWInfo();
        $normalInspecc = $this->getInspInfo();
        $monthlyInspecc = $this->getInspmonthlyInfo();
        $hmpEventt = $this->getHmpInfo();
        $atarEventt = $this->getAtarInfo();
        $hirarcEventt = $this->getHirarcInfo();

        $permitEvent = ($permitEventt != FALSE) ? $permitEventt : [];
        $atarEvent = ($atarEventt != FALSE) ? $atarEventt : [];
        $hmpEvent = ($hmpEventt != FALSE) ? $hmpEventt : [];
        $monthlyInspec = ($monthlyInspecc != FALSE) ? $monthlyInspecc : [];
        $normalInspec = ($normalInspecc != FALSE) ? $normalInspecc : [];
        $hirarcEvent = ($hirarcEventt != FALSE) ? $hirarcEventt : [];
        $notifyEvent = ($notifyEventt != FALSE) ? $notifyEventt : [];

        $HSEEvent = [];
        // echo '<pre>';print_r($notifyEvent);exit;
        // $output_arrays = array_merge($output_arrays, $notifyEvent,$permitEvent, $normalInspec,$atarEvent,$hmpEvent,$monthlyInspec,$hirarcEvent);

        // $output_arrays = ($notifyEvent != FALSE)? $notifyEvent : [];
        //  $output_arrays = ($permitEvent != FALSE)? $permitEvent : [];

        $output_arrays = array_merge($output_arrays, $notifyEvent, $permitEvent, $monthlyInspec, $normalInspec, $hmpEvent, $atarEvent, $hirarcEvent);

        //echo '<pre>';print_r($output_arrays);

        echo json_encode($output_arrays);
        exit;
        exit;
    }

    private function getPTWInfo()
    {
        $start_date = date("Y-m-d", strtotime($this->input->get('start')));
        $end_date = date("Y-m-d", strtotime($this->input->get('end')));
        $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');


        $options['where'] = [
            'PTW_STATUS' => 'Y',
            'START_DATE >= ' => $start_date,
            'START_DATE <= ' => $end_date,

        ];
        if (!empty($terminal)) {
            $options['where']['LOCATION'] = $terminal;
        }
        if (!empty($year)) {
            $options['where']['YEAR(CREATED_ON)'] = $year;
        }

        $userType = getCurrentUserGroupId();
        $userid = getCurrentUserid();
        switch ($userType) {
            case 4:
                $options['where']['CREATED_BY'] = $userid;
                $options['where']['START_DATE >= '] = $start_date;
                $options['where']['START_DATE <= '] = $end_date;



                break;
            case 5:
                $options['where']['OA_USER_LOGIN_ID'] = $userid;
                $options['where']['START_DATE >= '] = $start_date;
                $options['where']['START_DATE <= '] = $end_date;

                break;
            case 6:
                $options['where']['SHO_HSE_USER_LOGIN_ID'] = $userid;
                $options['where']['START_DATE >= '] = $start_date;
                $options['where']['START_DATE <= '] = $end_date;

                break;
            case 11:
                $options['where']['CREATED_BY'] = $userid;
                $options['where']['START_DATE >= '] = $start_date;
                $options['where']['START_DATE <= '] = $end_date;

                break;

            default:
                break;
        }
        $options['return_type'] = 'result';
        $pertmitInfo = $this->common_model->getAlldata('PTW', ['*'], $options);

        $events = [];
        if ($pertmitInfo != FALSE && count($pertmitInfo) > 0) {
            foreach ($pertmitInfo as $row) {
                $pid = postData($row, 'PTW_ID');
                $title = postData($row, 'LIVE_PERMIT_NO');
                $startDate = postData($row, 'START_DATE');
                $endDate = postData($row, 'END_DATE');
                $url = 'ptw/permit/view/' . encryptval($pid);
                $events[] = [
                    'title' => $title,
                    'url' => $url,
                    'start' => $startDate,
                    'end' => $endDate,
                ];
            }
        }
        return $events;
    }

    private function getInspInfo()
    {
        $start_date = date("Y-m-d", strtotime($this->input->get('start')));
        $end_date = date("Y-m-d", strtotime($this->input->get('end')));
        $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');

        $options['where'] = [
            'INSP_STATUS' => 'Y',
            'INSPECTION_DATE >= ' => $start_date,
            'INSPECTION_DATE <= ' => $end_date,
        ];
        //    $userType = getCurrentUserGroupId();
        //    $userid = getCurrentUserid();

        if (!empty($terminal)) {
            $options['where']['INSP_TER_ID'] = $terminal;
        }
        if (!empty($year)) {
            $options['where']['YEAR(CREATED_ON)'] = $year;
        }


        $options['return_type'] = 'result';
        $inspectionInfo = $this->common_model->getAlldata(HSSE_INSP_MAIN, ['*'], $options);

        $insps = [];
        if ($inspectionInfo != FALSE && count($inspectionInfo) > 0) {
            foreach ($inspectionInfo as $row) {
                $pid = postData($row, 'INSP_AUTO_ID');
                $title = postData($row, 'INSP_ID');
                $startDate = postData($row, 'INSPECTION_DATE');
                $endDate = postData($row, 'INSPECTION_DATE');
                $url = 'inspection/viewInspection/' . encryptval($pid);
                $insps[] = [
                    'title' => $title,
                    'url' => $url,
                    'start' => $startDate,
                    'end' => $endDate,
                ];
            }
        }
        return $insps;
    }

    private function getInspmonthlyInfo()
    {
        $start_date = date("Y-m-d", strtotime($this->input->get('start')));
        $end_date = date("Y-m-d", strtotime($this->input->get('end')));
        $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');

        $options['where'] = [
            'MON_INSP_STATUS' => 'Y',
            'MON_INSPECTION_DATE >= ' => $start_date,
            'MON_INSPECTION_DATE <= ' => $end_date,
        ];
        //    $userType = getCurrentUserGroupId();
        //    $userid = getCurrentUserid();

        if (!empty($terminal)) {
            $optionsmon['where']['MON_INSP_TER_ID'] = $terminal;
        }
        if (!empty($year)) {
            $options['where']['YEAR(CREATED_ON)'] = $year;
        }
        $options['return_type'] = 'result';
        $inspectionInfo = $this->common_model->getAlldata(MON_INSP_MAIN, ['*'], $options);

        $moninsps = [];
        if ($inspectionInfo != FALSE && count($inspectionInfo) > 0) {
            foreach ($inspectionInfo as $row) {
                $pid = postData($row, 'MON_INSP_AUTO_ID');
                $title = postData($row, 'MON_INSP_ID');
                $startDate = postData($row, 'MON_INSPECTION_DATE');
                $endDate = postData($row, 'MON_INSPECTION_DATE');
                $url = 'inspection/viewInspectionmonthly/' . encryptval($pid);
                $moninsps[] = [
                    'title' => $title,
                    'url' => $url,
                    'start' => $startDate,
                    'end' => $endDate,
                ];
            }
        }
        return $moninsps;
    }

    private function getNotifyInfo()
    {

        $start_date = date("Y-m-d", strtotime($this->input->get('start')));
        $end_date = date("Y-m-d", strtotime($this->input->get('end')));

        //  echo $start_date;
        //  echo $end_date;
        //  exit;

        $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');

        $options['where'] = [
            'NOTIFY_STATUS' => 'Y',
            'EVENT_DATE >= ' => $start_date,
            'EVENT_DATE <= ' => $end_date,
        ];
        if (!empty($terminal)) {
            $options['where']['LOCATION_ID'] = $terminal;
        }
        if (!empty($year)) {
            $options['where']['YEAR(CREATED_ON)'] = $year;
        }

        $userType = getCurrentUserGroupId();
        $userid = getCurrentUserid();
        //    switch ($userType) {
        //        case 4:
        //            $options['where']['CREATED_BY'] = $userid;
        //
        //            break;
        //        case 5:
        //            $options['where']['OA_USER_LOGIN_ID'] = $userid;
        //
        //            break;
        //        case 6:
        //            $options['where']['SHO_HSE_USER_LOGIN_ID'] = $userid;
        //
        //            break;
        //        case 11:
        //            $options['where']['CREATED_BY'] = $userid;
        //
        //            break;
        //
        //        default:
        //            break;
        //    }

        $options['return_type'] = 'result';
        $NotifyInfo = $this->common_model->getAlldata('INCIDENT_NOTIFICATION_DETAILS', ['*'], $options);
        // echo $this->db->last_query();
        // exit;
        $events = [];
        if ($NotifyInfo != FALSE && count($NotifyInfo) > 0) {
            foreach ($NotifyInfo as $row) {
                $nid = postData($row, 'INCIDENT_ID');
                $title = postData($row, 'INCIDENT_NOTIFY_ID');
                $startDate = postData($row, 'EVENT_DATE');
                $endDate = postData($row, 'EVENT_DATE');
                $INVESTIGATION_ACTION = postData($row, 'INVESTIGATION_ACTION');
                if ($INVESTIGATION_ACTION != '1') {
                    $url = 'incident/investCheck/' . encryptval($title);
                } else {
                    $url = 'incident/ViewList/' . encryptval($title);
                }


                $events[] = [
                    'title' => $title,
                    'url' => $url,
                    'start' => $startDate,
                    'end' => $endDate,
                ];
            }
        }
        // print_r($events);
        // exit;
        return $events;
    }
    public function  incidentNotifyCount($terminal = '', $year = '', $from = '', $to = '')
    {
        $countNotify = $this->common_model->getCountForNotify($terminal, $year,$from, $to);
        //echo 'Myt<pre>';print_r($countNotify);exit; 
        return $countNotify;
    }
}
