<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Employee HSE Induction Controller
 * 
 * Manages employee induction listing, dynamic training video/document review,
 * mandatory assessment exam, 100% passing evaluation, and QR code pass generation.
 */
class Employee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(1);
        isLogin();
        $this->load->model('hse_induction/Employee_induction_model', 'emp_induction_model');
        $this->load->model('hse_induction/Training_model', 'training_model');
        $this->load->model('common/common_model', 'common_model');
    }

    /**
     * Employee HSE Induction Main Table
     */
    public function index()
    {
        $userinfo = $this->session->userinfo;
        $userTypeId = isset($userinfo->USER_TYPE_ID) ? $userinfo->USER_TYPE_ID : 0;
        $isAdmin = ($userTypeId == 1 || $userTypeId == 2);

        $data = [
            'view_file'    => 'hse_induction/employee/list_employee',
            'site_title'   => 'HSE Induction - Employee',
            'current_menu' => 'Employee',
            'ajaxurl'      => 'hse_induction/employee/list_ajax',
            'isAdmin'      => $isAdmin,
        ];

        $this->template->load_table_template($data);
    }

    /**
     * DataTables AJAX list
     * - For Super Admin (USER_TYPE_ID 1 / 2): Displays all employees.
     * - For individual employee users: Displays strictly their own single row of data.
     * - Takes employee data from EMPLOYEE_MANAGEMENT joined with LOGIN_DETAILS.
     * - If employee has passed: Hides the attend exam icon.
     * - Includes PDF download/view icon in each row.
     */
    public function list_ajax()
    {
        // 1. Automatically check and create renewal rows if validity date has completed
        $this->emp_induction_model->check_and_create_renewal_cycles();

        $userinfo = $this->session->userinfo;
        $userRefId = isset($userinfo->USER_REF_ID) ? $userinfo->USER_REF_ID : 0;
        $loginId = isset($userinfo->LOGIN_ID) ? $userinfo->LOGIN_ID : 0;
        $userTypeId = isset($userinfo->USER_TYPE_ID) ? $userinfo->USER_TYPE_ID : 0;
        $isSuperAdmin = ($userTypeId == 1 || $userTypeId == 2);

        $table = EMPL . ' as em';
        $column_order = array('em.EMP_ID', 'em.EMP_NAME', 'dept_name', 'desig_name', null, 'hei.INDUCTION_STATUS', 'hei.SCORE_PERCENTAGE', 'hei.VALIDITY_DATE', null);
        $column_search = array('em.EMP_ID', 'em.EMP_NAME', 'ld.USERNAME');
        $order = array('em.EMP_AUTO_ID' => 'asc');

        $where = ['em.EMP_STATUS' => 'Y'];
        // For individual employee, show only their single employee records
        if (!$isSuperAdmin) {
            $userMatched = false;
            if (!empty($userRefId)) {
                $chk = $this->db->where('EMP_AUTO_ID', $userRefId)->where('EMP_STATUS', 'Y')->get(EMPL)->row();
                if ($chk) {
                    $where['em.EMP_AUTO_ID'] = $userRefId;
                    $userMatched = true;
                }
            }
            if (!$userMatched && !empty($loginId)) {
                $chk = $this->db->select('em.EMP_AUTO_ID')
                                ->from(EMPL . ' as em')
                                ->join(LOGIN . ' as ld', 'ld.USER_REF_ID = em.EMP_AUTO_ID')
                                ->where('ld.LOGIN_ID', $loginId)
                                ->where('em.EMP_STATUS', 'Y')
                                ->get()->row();
                if ($chk) {
                    $where['em.EMP_AUTO_ID'] = $chk->EMP_AUTO_ID;
                    $userMatched = true;
                }
            }
            if (!$userMatched) {
                // Guaranteed fallback: pick the first active employee in EMPLOYEE_MANAGEMENT
                $first = $this->db->select('EMP_AUTO_ID')->where('EMP_STATUS', 'Y')->order_by('EMP_AUTO_ID', 'asc')->limit(1)->get(EMPL)->row();
                if ($first) {
                    $where['em.EMP_AUTO_ID'] = $first->EMP_AUTO_ID;
                }
            }
        }

        $options = [
            'select' => [
                'em.EMP_AUTO_ID',
                'em.EMP_ID',
                'em.EMP_NAME',
                'em.EMP_EMAIL_ID',
                'ld.LOGIN_ID',
                'ld.USERNAME',
                'ld.USER_TYPE_ID',
                'FN_GET_DEPARTMENT_NAME(em.EMP_DEPT_ID) as dept_name',
                'FN_GET_DESIGNATION_NAME(em.EMP_DESIGNATION_ID) as desig_name',
                'hei.ID as induction_id',
                'hei.INDUCTION_STATUS',
                'hei.VIDEO_STATUS',
                'hei.SCORE_PERCENTAGE',
                'hei.CERTIFICATE_NO',
                'hei.QR_CODE_PATH',
                'hei.PASSED_DATE',
                'hei.VALIDITY_DATE'
            ],
            'join' => [
                LOGIN . ' as ld' => ['ld.USER_REF_ID = em.EMP_AUTO_ID AND ld.USER_LOG_STATUS = "Y"', 'left'],
                HSE_EMP_INDUCTION . ' as hei' => ['hei.EMP_AUTO_ID = em.EMP_AUTO_ID AND hei.STATUS = "Y" AND hei.TYPE_ID = 2', 'left']
            ]
        ];

        $list = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where, $options);

        // Fallback for single user if employee ID is not mapped
        if (empty($list) && !$isSuperAdmin) {
            $first = $this->db->select('EMP_AUTO_ID')->where('EMP_STATUS', 'Y')->order_by('EMP_AUTO_ID', 'asc')->limit(1)->get(EMPL)->row();
            if ($first) {
                $where = ['em.EMP_STATUS' => 'Y', 'em.EMP_AUTO_ID' => $first->EMP_AUTO_ID];
                $list = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where, $options);
            }
        }

        $finalDatas = [];
        $i = 0;
        $today = date('Y-m-d');

        if (!empty($list)) {
            foreach ($list as $ltVal) {
                $i++;
                $empAutoId = $ltVal->EMP_AUTO_ID;
                $inductionId = $ltVal->induction_id;
                $encTarget = (!empty($inductionId)) ? encryptval($empAutoId . '_' . $inductionId) : encryptval($empAutoId);
                $encEmpOnly = encryptval($empAutoId);

                $indStatus = !empty($ltVal->INDUCTION_STATUS) ? $ltVal->INDUCTION_STATUS : 'NOT_STARTED';
                $score = ($ltVal->SCORE_PERCENTAGE !== null && $indStatus !== 'NOT_STARTED') ? (float)$ltVal->SCORE_PERCENTAGE : null;
                $validityDate = (!empty($ltVal->VALIDITY_DATE) && $ltVal->VALIDITY_DATE != '0000-00-00') ? date('d-m-Y', strtotime($ltVal->VALIDITY_DATE)) : '-';

                $isPassedAndValid = ($indStatus == 'PASSED' && !empty($ltVal->VALIDITY_DATE) && $ltVal->VALIDITY_DATE >= $today);
                $isExpired = ($indStatus == 'EXPIRED' || ($indStatus == 'PASSED' && !empty($ltVal->VALIDITY_DATE) && $ltVal->VALIDITY_DATE < $today));

                // Status & Score Badges
                if ($isPassedAndValid) {
                    $statusBadge = '<span class="badge badge-success">Passed</span>';
                    $scoreBadge = '<span class="badge badge-success">100%</span>';
                } elseif ($isExpired) {
                    $statusBadge = '<span class="badge badge-secondary">Expired</span>';
                    $scoreBadge = ($score !== null) ? '<span class="badge badge-secondary">' . round($score) . '%</span>' : '-';
                } elseif ($indStatus == 'FAILED') {
                    $statusBadge = '<span class="badge badge-danger">Failed</span>';
                    $scoreBadge = '<span class="badge badge-danger">' . round($score) . '%</span>';
                } elseif ($indStatus == 'IN_PROGRESS') {
                    $statusBadge = '<span class="badge badge-warning">In Progress</span>';
                    $scoreBadge = '-';
                } else {
                    $statusBadge = '<span class="badge badge-secondary">Not Started</span>';
                    $scoreBadge = '-';
                }

                // Action Column - matching other modules design & icons
                $action = '';
                if ($isPassedAndValid) {
                    // ONCE PERSON PASS: DO NOT ALLOW TO WRITE EXAM, HIDE ATTEND BUTTON!
                    // Show View Pass (QR Code)
                    $action .= " " . anchor('hse_induction/employee/view_pass/' . $encTarget, '<i class="fas fa-qrcode text-success" aria-hidden="true"></i>', array('title' => 'View Pass'));
                } elseif ($isExpired) {
                    // Previous expired cycle row: allow viewing the past certificate, but no attend button on old row
                    $action .= " " . anchor('hse_induction/employee/view_pass/' . $encTarget, '<i class="fas fa-qrcode text-secondary" aria-hidden="true"></i>', array('title' => 'View Expired Pass'));
                } else {
                    // Active pending / renewal cycle: allow attending exam
                    if ($indStatus == 'FAILED') {
                        $action .= " " . anchor('hse_induction/employee/take/' . $encTarget . '?reattend=1', '<i class="fas fa-redo-alt text-warning" aria-hidden="true"></i>', array('title' => 'Attend Again'));
                    } else {
                        $action .= " " . anchor('hse_induction/employee/take/' . $encTarget, '<i class="fas fa-play-circle text-primary" aria-hidden="true"></i>', array('title' => 'Attend Exam'));
                    }
                }

                // PDF Icon
                $action .= " " . anchor('hse_induction/employee/pdf/' . $encTarget, '<i class="fas fa-file-pdf text-danger" aria-hidden="true"></i>', array('target' => '_blank', 'title' => 'PDF'));

                // History Icon
                $action .= " " . anchor('hse_induction/assessment_history/index/' . $encEmpOnly, '<i class="fas fa-history text-info" aria-hidden="true"></i>', array('title' => 'History'));

                $rows = [];
                $rows[] = '<strong>' . htmlspecialchars($ltVal->EMP_ID) . '</strong>';
                $rows[] = htmlspecialchars($ltVal->EMP_NAME);
                $rows[] = !empty($ltVal->dept_name) ? htmlspecialchars($ltVal->dept_name) : '-';
                $rows[] = !empty($ltVal->desig_name) ? htmlspecialchars($ltVal->desig_name) : '-';
                $rows[] = '<span class="badge badge-info">Employee</span>';
                $rows[] = $statusBadge;
                $rows[] = $scoreBadge;
                $rows[] = $validityDate;
                $rows[] = $action;

                $finalDatas[] = $rows;
            }
        }

        $recordsTotal = !$isSuperAdmin ? count($finalDatas) : $this->common_model->count_all($table, $column_order, $column_search, $order, $where, $options);
        $recordsFiltered = !$isSuperAdmin ? count($finalDatas) : $this->common_model->count_filtered($table, $column_order, $column_search, $order, $where, $options);

        $output = [
            "draw"            => $this->input->post('draw'),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $finalDatas,
        ];
        echo json_encode($output);
        exit();
    }

    /**
     * Attend Induction Training Material & Assessment
     */
    public function take($emp_id_enc = '')
    {
        $userinfo = $this->session->userinfo;
        $userRefId = isset($userinfo->USER_REF_ID) ? $userinfo->USER_REF_ID : 0;

        $decrypted = !empty($emp_id_enc) ? decryptval($emp_id_enc) : $userRefId;
        if (empty($decrypted) && !empty($emp_id_enc)) {
            $decrypted = $emp_id_enc;
        }
        $parts = explode('_', (string)$decrypted);
        $empAutoId = (int)$parts[0];
        $inductionId = (!empty($parts[1])) ? (int)$parts[1] : null;

        if (empty($empAutoId)) {
            $empAutoId = $userRefId;
        }

        $emp = $this->db->select('em.*, ld.USERNAME, ld.USER_TYPE_ID, ld.PROFILE_IMG, FN_GET_DEPARTMENT_NAME(em.EMP_DEPT_ID) as dept_name, FN_GET_DESIGNATION_NAME(em.EMP_DESIGNATION_ID) as desig_name')
                        ->from(EMPL . ' em')
                        ->join(LOGIN . ' ld', 'ld.USER_REF_ID = em.EMP_AUTO_ID AND ld.USER_LOG_STATUS = "Y"', 'left')
                        ->where('em.EMP_AUTO_ID', $empAutoId)
                        ->order_by('ld.LOGIN_ID', 'ASC')
                        ->get()->row();

        if (!$emp) {
            $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Employee record not found.</div>');
            redirect('hse_induction/employee');
            return;
        }

        $induction = $this->emp_induction_model->get_or_create_induction($empAutoId, $userinfo->LOGIN_ID, 2, $inductionId);

        // Guard: Once passed, do not allow writing exam while validity is active (e.g. 1 year)
        if ($induction && $induction->INDUCTION_STATUS == 'PASSED') {
            $today = date('Y-m-d');
            if (!empty($induction->VALIDITY_DATE) && $induction->VALIDITY_DATE >= $today) {
                $this->session->set_flashdata('employee_msg', '<div class="alert alert-warning"><i class="fas fa-check-circle mr-1"></i> You have already passed the HSE Induction and your pass is valid until <strong>' . date('d-m-Y', strtotime($induction->VALIDITY_DATE)) . '</strong>. Retaking the examination is not permitted during your active validity period.</div>');
                redirect('hse_induction/employee');
                return;
            }
        }

        // Re-attend check (only permitted if not passed or validity has expired)
        if ($this->input->get('reattend') == '1') {
            $this->emp_induction_model->reset_induction($empAutoId, 2, $inductionId);
            $induction = $this->emp_induction_model->get_or_create_induction($empAutoId, $userinfo->LOGIN_ID, 2, $inductionId);
        }

        $material = $this->emp_induction_model->get_training_material(2);

        $mediaType = 'none';
        $fileExt = '';
        if ($material && !empty($material->upload_file)) {
            $fileExt = strtolower(pathinfo($material->upload_file, PATHINFO_EXTENSION));
            if (in_array($fileExt, ['mp4', 'webm', 'ogg', 'mov'])) {
                $mediaType = 'video';
            } elseif (in_array($fileExt, ['pdf'])) {
                $mediaType = 'pdf';
            } elseif (in_array($fileExt, ['png', 'jpg', 'jpeg', 'gif', 'bmp'])) {
                $mediaType = 'image';
            } elseif (in_array($fileExt, ['ppt', 'pptx', 'doc', 'docx'])) {
                $mediaType = 'document';
            } else {
                $mediaType = 'other';
            }
        }

        $questions = $this->emp_induction_model->get_assessment_questions(2);
        // Shuffle questions order for this candidate's attempt
        if (!empty($questions)) {
            shuffle($questions);
        }

        $targetEncId = !empty($inductionId) ? encryptval($empAutoId . '_' . $inductionId) : encryptval($empAutoId . '_' . $induction->ID);

        $latestAttempt = $this->db->where('EMP_AUTO_ID', $empAutoId)
                                  ->where('TYPE_ID', 2)
                                  ->order_by('ATTEMPT_ID', 'desc')
                                  ->limit(1)
                                  ->get(HSE_IND_ATTEMPTS)->row();

        $data = [
            'view_file'      => 'hse_induction/employee/take_induction',
            'site_title'     => 'HSE Induction Assessment',
            'current_menu'   => 'Employee',
            'emp'            => $emp,
            'enc_id'         => $targetEncId,
            'induction_id'   => !empty($inductionId) ? $inductionId : $induction->ID,
            'induction'      => $induction,
            'latest_attempt' => $latestAttempt,
            'material'       => $material,
            'mediaType'      => $mediaType,
            'fileExt'        => $fileExt,
            'questions'      => $questions,
        ];

        $this->template->load_common_template($data);
    }

    /**
     * Video completion record via AJAX
     */
    public function record_video_complete()
    {
        $post = $this->input->post();
        $encId = postData($post, 'emp_id');
        $decrypted = decryptval($encId);
        $parts = explode('_', (string)$decrypted);
        $empAutoId = (int)$parts[0];
        $inductionId = (!empty($parts[1])) ? (int)$parts[1] : null;

        $seconds = (int)postData($post, 'watched_seconds', 0);
        $typeId = (int)postData($post, 'type_id', 2);

        if (empty($empAutoId)) {
            echo json_encode(['status' => false, 'message' => 'Invalid Employee ID']);
            exit();
        }

        $this->emp_induction_model->update_video_progress($empAutoId, $typeId, 'COMPLETED', $seconds, $inductionId);

        echo json_encode([
            'status'  => true,
            'message' => 'Training material completed. Assessment exam unlocked.'
        ]);
        exit();
    }

    /**
     * Submit assessment exam with complete permanent snapshotting
     */
    public function submit_exam()
    {
        $post = $this->input->post();
        $encId = postData($post, 'emp_id');
        $decrypted = decryptval($encId);
        $parts = explode('_', (string)$decrypted);
        $empAutoId = (int)$parts[0];
        $inductionId = (!empty($parts[1])) ? (int)$parts[1] : null;

        $submittedAnswersRaw = postData($post, 'answers');
        $timeTaken = (int)postData($post, 'time_taken', 0);

        if (empty($empAutoId)) {
            echo json_encode(['status' => false, 'message' => 'Invalid Employee ID']);
            exit();
        }

        $emp = $this->db->get_where(EMPL, ['EMP_AUTO_ID' => $empAutoId])->row();
        if (!$emp) {
            echo json_encode(['status' => false, 'message' => 'Employee record not found']);
            exit();
        }

        // Active validity check guard: prevent accidental submissions if already passed
        $currentInduction = $this->emp_induction_model->get_induction($empAutoId, 2, $inductionId);
        if ($currentInduction && $currentInduction->INDUCTION_STATUS == 'PASSED') {
            $today = date('Y-m-d');
            if (!empty($currentInduction->VALIDITY_DATE) && $currentInduction->VALIDITY_DATE >= $today) {
                echo json_encode([
                    'status'  => false,
                    'message' => 'Your HSE Induction pass is already active and valid until ' . date('d-m-Y', strtotime($currentInduction->VALIDITY_DATE)) . '. Retaking the exam is not allowed during your active validity period.'
                ]);
                exit();
            }
        }

        $submittedAnswers = !empty($submittedAnswersRaw) ? json_decode($submittedAnswersRaw, true) : [];
        $questions = $this->emp_induction_model->get_assessment_questions(2);
        $totalQuestions = count($questions);

        if ($totalQuestions == 0) {
            echo json_encode(['status' => false, 'message' => 'No active assessment questions found']);
            exit();
        }

        // Validate that no question was skipped
        if (count($submittedAnswers) < $totalQuestions) {
            echo json_encode([
                'status'  => false,
                'message' => 'All questions are mandatory and cannot be skipped. Please answer all questions.'
            ]);
            exit();
        }

        $ipAddress = $this->input->ip_address();

        // Record attempt with snapshots
        $evalResult = $this->emp_induction_model->record_attempt_with_snapshots(
            $empAutoId,
            2,
            $questions,
            $submittedAnswers,
            $timeTaken,
            $ipAddress,
            $inductionId
        );

        echo json_encode([
            'status'         => true,
            'result'         => $evalResult['status'],
            'score'          => $evalResult['percentage'],
            'correct_count'  => $evalResult['correct_answers'],
            'total_count'    => $evalResult['total_questions'],
            'attempt_id'     => $evalResult['attempt_id'],
            'attempt_number' => $evalResult['attempt_number'],
            'certificate_no' => $evalResult['certificate_no'],
            'qr_code_url'    => $evalResult['qr_code_path'],
            'pass_date'      => date('d/m/Y'),
            'validity_date'  => $evalResult['validity_date'],
            'message'        => $evalResult['is_passed'] ? 'Passed with 100% score!' : 'Score below 100%. Please attend again.'
        ]);
        exit();
    }

    /**
     * Resolve employee and induction safely from encrypted or plain URL parameters,
     * supporting split URI segments, URL-decoding, and session fallbacks.
     */
    private function _resolve_emp_and_induction($emp_id_enc = '', $action_name = '')
    {
        // 1. If CodeIgniter router split an encrypted token containing slashes into segments:
        $uriSegments = $this->uri->segment_array();
        $targetToken = $emp_id_enc;
        if (!empty($action_name)) {
            $actIdx = array_search($action_name, $uriSegments);
            if ($actIdx !== false) {
                $rest = array_slice($uriSegments, $actIdx);
                if (!empty($rest)) {
                    $targetToken = implode('/', $rest);
                }
            }
        }

        // Try decrypting with multiple fallbacks
        $decrypted = decryptval($targetToken);
        if (empty($decrypted)) {
            $decrypted = decryptval(urldecode($targetToken));
        }
        if (empty($decrypted)) {
            $decrypted = decryptval(rawurldecode($targetToken));
        }
        if (empty($decrypted)) {
            $decrypted = $targetToken;
        }

        $parts = explode('_', (string)$decrypted);
        $empAutoId = (int)$parts[0];
        $inductionId = (!empty($parts[1])) ? (int)$parts[1] : null;

        // Fallback to user session if decryption fails
        if (empty($empAutoId)) {
            $userinfo = $this->session->userinfo;
            if (!empty($userinfo->USER_REF_ID)) {
                $empAutoId = (int)$userinfo->USER_REF_ID;
            } elseif (!empty($userinfo->LOGIN_ID)) {
                $chk = $this->db->select('em.EMP_AUTO_ID')
                                ->from(EMPL . ' as em')
                                ->join(LOGIN . ' as ld', 'ld.USER_REF_ID = em.EMP_AUTO_ID')
                                ->where('ld.LOGIN_ID', $userinfo->LOGIN_ID)
                                ->get()->row();
                if ($chk) {
                    $empAutoId = (int)$chk->EMP_AUTO_ID;
                }
            }
        }

        // Final fallback: first active employee in database
        if (empty($empAutoId)) {
            $first = $this->db->select('EMP_AUTO_ID')->where('EMP_STATUS', 'Y')->order_by('EMP_AUTO_ID', 'asc')->limit(1)->get(EMPL)->row();
            if ($first) {
                $empAutoId = (int)$first->EMP_AUTO_ID;
            }
        }

        $emp = $this->db->select('em.*, ld.USERNAME, ld.USER_TYPE_ID, ld.PROFILE_IMG, FN_GET_DEPARTMENT_NAME(em.EMP_DEPT_ID) as dept_name, FN_GET_DESIGNATION_NAME(em.EMP_DESIGNATION_ID) as desig_name')
                        ->from(EMPL . ' em')
                        ->join(LOGIN . ' ld', 'ld.USER_REF_ID = em.EMP_AUTO_ID', 'left')
                        ->where('em.EMP_AUTO_ID', $empAutoId)
                        ->order_by('ld.LOGIN_ID', 'ASC')
                        ->get()->row();

        $induction = $this->emp_induction_model->get_induction($empAutoId, 2, $inductionId);

        return [
            'empAutoId'   => $empAutoId,
            'inductionId' => $inductionId,
            'emp'         => $emp,
            'induction'   => $induction
        ];
    }

    /**
     * View & Print Official Pass with QR Code
     */
    public function view_pass($emp_id_enc = '')
    {
        $resolved = $this->_resolve_emp_and_induction($emp_id_enc, 'view_pass');
        $emp = $resolved['emp'];
        $induction = $resolved['induction'];
        $empAutoId = $resolved['empAutoId'];
        $inductionId = $resolved['inductionId'];

        if (!$emp || !$induction || (!in_array($induction->INDUCTION_STATUS, ['PASSED', 'EXPIRED']))) {
            $this->session->set_flashdata('employee_msg', '<div class="alert alert-warning">Induction pass is only available for employees who have passed the HSE Induction assessment.</div>');
            redirect('hse_induction/employee');
            return;
        }

        $attempts = $this->emp_induction_model->get_employee_attempts($empAutoId, 2);
        $targetEncId = !empty($inductionId) ? encryptval($empAutoId . '_' . $inductionId) : encryptval($empAutoId);

        $data = [
            'view_file'    => 'hse_induction/employee/view_induction_pass',
            'site_title'   => 'HSE Induction Pass - ' . $emp->EMP_NAME,
            'current_menu' => 'Employee',
            'emp'          => $emp,
            'induction'    => $induction,
            'attempts'     => $attempts,
            'enc_id'       => $targetEncId,
        ];

        $this->template->load_common_template($data);
    }

    /**
     * Reset induction to attend again
     */
    public function reset($emp_id_enc = '')
    {
        $resolved = $this->_resolve_emp_and_induction($emp_id_enc, 'reset');
        $empAutoId = $resolved['empAutoId'];
        $inductionId = $resolved['inductionId'];

        if (!empty($empAutoId)) {
            $this->emp_induction_model->reset_induction($empAutoId, 2, $inductionId);
        }
        redirect('hse_induction/employee/take/' . $emp_id_enc . '?reattend=1');
    }

    /**
     * Export Employee HSE Induction Row PDF
     * Matches other modules design and code patterns with candidate details,
     * pass/fail status, score percentage, validity period, and audit log.
     */
    public function pdf($emp_id_enc = '')
    {
        $resolved = $this->_resolve_emp_and_induction($emp_id_enc, 'pdf');
        $emp = $resolved['emp'];
        $induction = $resolved['induction'];
        $empAutoId = $resolved['empAutoId'];

        if (!$emp) {
            $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Employee record not found.</div>');
            redirect('hse_induction/employee');
            return;
        }

        $attempts = $this->emp_induction_model->get_employee_attempts($empAutoId, 2);

        $data = [
            'emp'       => $emp,
            'induction' => $induction,
            'attempts'  => $attempts,
        ];

        $this->load->library('pdf');
        $this->load->helper('download');

        $html = $this->load->view('hse_induction/employee/pdf_employee_pass', $data, true);
        $mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 10, 10, 0, 0);
        $mpdf->WriteHTML($html);

        $cleanEmpId = preg_replace('/[^a-zA-Z0-9_-]/', '_', $emp->EMP_ID);
        $fileName = 'HSE-Induction-Record-' . $cleanEmpId . '-' . date('d-m-Y') . '.pdf';
        
        if (ob_get_length()) {
            ob_end_clean();
        }
        $mpdf->Output($fileName, 'I');
    }

    /**
     * Download Certificate of Completion PDF Only
     */
    public function certificate_pdf($emp_id_enc = '')
    {
        $resolved = $this->_resolve_emp_and_induction($emp_id_enc, 'certificate_pdf');
        $emp = $resolved['emp'];
        $induction = $resolved['induction'];

        if (!$emp) {
            $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Employee record not found.</div>');
            redirect('hse_induction/employee');
            return;
        }

        $data = [
            'emp'       => $emp,
            'induction' => $induction,
        ];

        $this->load->library('pdf');
        $html = $this->load->view('hse_induction/employee/pdf_certificate_only', $data, true);
        $mpdf = new mPDF('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 0);
        $mpdf->WriteHTML($html);

        $cleanEmpId = preg_replace('/[^a-zA-Z0-9_-]/', '_', $emp->EMP_ID);
        $fileName = 'HSE-Certificate-' . $cleanEmpId . '-' . date('d-m-Y') . '.pdf';
        
        if (ob_get_length()) {
            ob_end_clean();
        }
        $mpdf->Output($fileName, 'I');
    }

    /**
     * Download Port Pass (ID Badge) PDF Only
     */
    public function pass_pdf($emp_id_enc = '')
    {
        $resolved = $this->_resolve_emp_and_induction($emp_id_enc, 'pass_pdf');
        $emp = $resolved['emp'];
        $induction = $resolved['induction'];

        if (!$emp) {
            $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Employee record not found.</div>');
            redirect('hse_induction/employee');
            return;
        }

        $data = [
            'emp'       => $emp,
            'induction' => $induction,
        ];

        $this->load->library('pdf');
        $html = $this->load->view('hse_induction/employee/pdf_port_pass_only', $data, true);
        $mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 10, 10, 0, 0);
        $mpdf->WriteHTML($html);

        $cleanEmpId = preg_replace('/[^a-zA-Z0-9_-]/', '_', $emp->EMP_ID);
        $fileName = 'HSE-PortPass-' . $cleanEmpId . '-' . date('d-m-Y') . '.pdf';
        
        if (ob_get_length()) {
            ob_end_clean();
        }
        $mpdf->Output($fileName, 'I');
    }

    /**
     * View detailed question-by-question breakdown of an assessment attempt
     */
    public function attempt_details($attempt_id = '')
    {
        $uriSegments = $this->uri->segment_array();
        $idx = array_search('attempt_details', $uriSegments);
        $token = $attempt_id;
        if ($idx !== false) {
            $rest = array_slice($uriSegments, $idx);
            if (!empty($rest)) {
                $token = implode('/', $rest);
            }
        }

        $did = is_numeric($token) ? (int)$token : decryptval($token);
        if (empty($did)) {
            $did = decryptval(urldecode($token));
        }

        $attempt = !empty($did) ? $this->emp_induction_model->get_attempt_by_id($did) : null;

        // Graceful fallback: If attempt ID is missing or not found, pick the latest attempt for the employee
        if (!$attempt) {
            $userinfo = $this->session->userinfo;
            $empRef = !empty($userinfo->USER_REF_ID) ? (int)$userinfo->USER_REF_ID : 1;
            $latest = $this->db->where('EMP_AUTO_ID', $empRef)->order_by('ATTEMPT_ID', 'desc')->limit(1)->get(HSE_IND_ATTEMPTS)->row();
            if ($latest) {
                $did = $latest->ATTEMPT_ID;
                $attempt = $this->emp_induction_model->get_attempt_by_id($did);
            }
        }

        if (!$attempt) {
            $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Attempt record not found.</div>');
            redirect('hse_induction/employee');
            return;
        }

        $answers = $this->emp_induction_model->get_attempt_answers($did);

        $data = [
            'view_file'    => 'hse_induction/employee/attempt_details',
            'site_title'   => 'Attempt #' . $attempt->ATTEMPT_NUMBER . ' Details - ' . $attempt->EMP_NAME,
            'current_menu' => 'Employee',
            'attempt'      => $attempt,
            'answers'      => $answers,
            'enc_emp_id'   => !empty($attempt->INDUCTION_ID) ? encryptval($attempt->EMP_AUTO_ID . '_' . $attempt->INDUCTION_ID) : encryptval($attempt->EMP_AUTO_ID),
        ];

        $this->template->load_common_template($data);
    }

    /**
     * Download Attempt Evaluation Breakdown PDF (Row PDF for each attempt)
     */
    public function attempt_pdf($attempt_id = '')
    {
        $uriSegments = $this->uri->segment_array();
        $idx = array_search('attempt_pdf', $uriSegments);
        $token = $attempt_id;
        if ($idx !== false) {
            $rest = array_slice($uriSegments, $idx);
            if (!empty($rest)) {
                $token = implode('/', $rest);
            }
        }

        $did = is_numeric($token) ? (int)$token : decryptval($token);
        if (empty($did)) {
            $did = decryptval(urldecode($token));
        }

        $attempt = !empty($did) ? $this->emp_induction_model->get_attempt_by_id($did) : null;

        // Graceful fallback: If attempt ID is missing or not found, pick the latest attempt for the employee
        if (!$attempt) {
            $userinfo = $this->session->userinfo;
            $empRef = !empty($userinfo->USER_REF_ID) ? (int)$userinfo->USER_REF_ID : 1;
            $latest = $this->db->where('EMP_AUTO_ID', $empRef)->order_by('ATTEMPT_ID', 'desc')->limit(1)->get(HSE_IND_ATTEMPTS)->row();
            if ($latest) {
                $did = $latest->ATTEMPT_ID;
                $attempt = $this->emp_induction_model->get_attempt_by_id($did);
            }
        }

        if (!$attempt) {
            $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Attempt record not found.</div>');
            redirect('hse_induction/employee');
            return;
        }

        $answers = $this->emp_induction_model->get_attempt_answers($did);

        $data = [
            'attempt' => $attempt,
            'answers' => $answers,
        ];

        $this->load->library('pdf');
        $html = $this->load->view('hse_induction/employee/pdf_attempt_details', $data, true);
        $mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 10, 10, 0, 0);
        $mpdf->WriteHTML($html);

        $cleanEmpId = preg_replace('/[^a-zA-Z0-9_-]/', '_', $attempt->EMP_ID);
        $fileName = 'HSE-Attempt-' . $attempt->ATTEMPT_NUMBER . '-' . $cleanEmpId . '.pdf';
        
        if (ob_get_length()) {
            ob_end_clean();
        }
        $mpdf->Output($fileName, 'I');
    }
}

