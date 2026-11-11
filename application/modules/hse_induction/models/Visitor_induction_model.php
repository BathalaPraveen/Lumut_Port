<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Visitor HSE Induction Model
 * 
 * Handles public visitor registration, HSSE approval workflows, OTP generation,
 * secure token validation, training material retrieval, examination evaluation,
 * permanent snapshot logging, QR code generation, and certificate management.
 */
class Visitor_induction_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        if (file_exists(APPPATH . 'modules/hse_induction/config/constants.php')) {
            $this->load->file(APPPATH . 'modules/hse_induction/config/constants.php');
        }
    }

    /**
     * Get all active terminals for dropdown
     */
    public function get_active_terminals()
    {
        return $this->db->where('TERMINAL_STATUS', 'Y')
                        ->order_by('TERMINAL_NAME', 'ASC')
                        ->get(TERM)
                        ->result();
    }

    /**
     * Get active LMTSB contact persons for dropdown
     */
    public function get_active_lmtsb_employees()
    {
        return $this->db->select('em.EMP_AUTO_ID, em.EMP_ID, em.EMP_NAME, FN_GET_DEPARTMENT_NAME(em.EMP_DEPT_ID) as dept_name, FN_GET_DESIGNATION_NAME(em.EMP_DESIGNATION_ID) as desig_name')
                        ->from(EMPL . ' em')
                        ->where('em.EMP_STATUS', 'Y')
                        ->order_by('em.EMP_NAME', 'ASC')
                        ->get()
                        ->result();
    }

    /**
     * Create a new public visitor registration
     */
    public function create_registration($data)
    {
        $todayStr = date('Ymd');
        $this->db->like('VISITOR_REG_NO', 'LMT-VIS-' . $todayStr, 'after');
        $count = $this->db->count_all_results(HSE_VISITOR_REG);
        $seq = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        $regNo = 'LMT-VIS-' . $todayStr . '-' . $seq;

        // Secure unique access token
        $token = hash('sha256', $regNo . microtime(true) . mt_rand(10000, 99999));

        $contactEmp = null;
        if (!empty($data['CONTACT_PERSON_ID'])) {
            $contactEmp = $this->db->get_where(EMPL, ['EMP_AUTO_ID' => (int)$data['CONTACT_PERSON_ID']])->row();
        }

        $insertData = [
            'VISITOR_REG_NO'      => $regNo,
            'COMPANY_NAME'        => trim($data['COMPANY_NAME']),
            'VISITOR_NAME'        => trim($data['VISITOR_NAME']),
            'IC_PASSPORT_NO'      => trim($data['IC_PASSPORT_NO']),
            'VEHICLE_DETAIL'      => !empty($data['VEHICLE_DETAIL']) ? trim($data['VEHICLE_DETAIL']) : null,
            'EMAIL_ID'            => trim($data['EMAIL_ID']),
            'PHONE_NO'            => trim($data['PHONE_NO']),
            'ADDRESS'             => trim($data['ADDRESS']),
            'VISIT_PURPOSE'       => trim($data['VISIT_PURPOSE']),
            'VISIT_DATETIME'      => !empty($data['VISIT_DATETIME']) ? date('Y-m-d H:i:s', strtotime($data['VISIT_DATETIME'])) : date('Y-m-d H:i:s'),
            'VISIT_DATETIME_END'  => !empty($data['VISIT_DATETIME_END']) ? date('Y-m-d H:i:s', strtotime($data['VISIT_DATETIME_END'])) : (!empty($data['VISIT_DATETIME']) ? date('Y-m-d H:i:s', strtotime($data['VISIT_DATETIME'])) : date('Y-m-d H:i:s')),
            'TERMINAL_ID'         => (int)$data['TERMINAL_ID'],
            'CONTACT_PERSON_ID'   => !empty($data['CONTACT_PERSON_ID']) ? (int)$data['CONTACT_PERSON_ID'] : null,
            'CONTACT_PERSON_NAME' => $contactEmp ? $contactEmp->EMP_NAME : (!empty($data['CONTACT_PERSON_NAME']) ? trim($data['CONTACT_PERSON_NAME']) : null),
            'PDPA_AGREED'         => 'Y',
            'APPROVAL_STATUS'     => 'PENDING',
            'ACCESS_TOKEN'        => $token,
            'INDUCTION_STATUS'    => 'NOT_STARTED',
            'VIDEO_STATUS'        => 'NOT_WATCHED',
            'IP_ADDRESS'          => $this->input->ip_address(),
            'STATUS'              => 'Y',
            'CREATED_ON'          => date('Y-m-d H:i:s'),
        ];

        $this->db->insert(HSE_VISITOR_REG, $insertData);
        $visitorId = $this->db->insert_id();

        return $this->get_visitor_by_id($visitorId);
    }

    /**
     * Get single visitor record by ID
     */
    public function get_visitor_by_id($visitor_id)
    {
        $this->db->select('v.*, tm.TERMINAL_NAME, tm.TERMINAL_SHORTNAME, em.EMP_ID as PIC_EMP_ID, em.EMP_NAME as PIC_EMP_NAME, FN_GET_DEPARTMENT_NAME(em.EMP_DEPT_ID) as PIC_DEPT, FN_GET_DESIGNATION_NAME(em.EMP_DESIGNATION_ID) as PIC_DESIG');
        $this->db->from(HSE_VISITOR_REG . ' v');
        $this->db->join(TERM . ' tm', 'tm.TER_AUTO_ID = v.TERMINAL_ID', 'left');
        $this->db->join(EMPL . ' em', 'em.EMP_AUTO_ID = v.CONTACT_PERSON_ID', 'left');
        $this->db->where('v.VISITOR_ID', (int)$visitor_id);
        return $this->db->get()->row();
    }

    /**
     * Get single visitor record by secure access token
     */
    public function get_visitor_by_token($token)
    {
        $this->db->select('v.*, tm.TERMINAL_NAME, tm.TERMINAL_SHORTNAME, em.EMP_ID as PIC_EMP_ID, em.EMP_NAME as PIC_EMP_NAME, FN_GET_DEPARTMENT_NAME(em.EMP_DEPT_ID) as PIC_DEPT, FN_GET_DESIGNATION_NAME(em.EMP_DESIGNATION_ID) as PIC_DESIG');
        $this->db->from(HSE_VISITOR_REG . ' v');
        $this->db->join(TERM . ' tm', 'tm.TER_AUTO_ID = v.TERMINAL_ID', 'left');
        $this->db->join(EMPL . ' em', 'em.EMP_AUTO_ID = v.CONTACT_PERSON_ID', 'left');
        $this->db->where('v.ACCESS_TOKEN', $token);
        return $this->db->get()->row();
    }

    /**
     * Query all visitors for Admin / HSSE listing with optional filters
     */
    public function get_all_visitors($filters = [])
    {
        $this->db->select('v.*, tm.TERMINAL_NAME, tm.TERMINAL_SHORTNAME, em.EMP_ID as PIC_EMP_ID, em.EMP_NAME as PIC_EMP_NAME, FN_GET_DEPARTMENT_NAME(em.EMP_DEPT_ID) as PIC_DEPT');
        $this->db->from(HSE_VISITOR_REG . ' v');
        $this->db->join(TERM . ' tm', 'tm.TER_AUTO_ID = v.TERMINAL_ID', 'left');
        $this->db->join(EMPL . ' em', 'em.EMP_AUTO_ID = v.CONTACT_PERSON_ID', 'left');

        if (!empty($filters['approval_status'])) {
            $this->db->where('v.APPROVAL_STATUS', $filters['approval_status']);
        }
        if (!empty($filters['induction_status'])) {
            $this->db->where('v.INDUCTION_STATUS', $filters['induction_status']);
        }
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start();
            $this->db->like('v.VISITOR_NAME', $s);
            $this->db->or_like('v.COMPANY_NAME', $s);
            $this->db->or_like('v.IC_PASSPORT_NO', $s);
            $this->db->or_like('v.VISITOR_REG_NO', $s);
            $this->db->or_like('v.EMAIL_ID', $s);
            $this->db->or_like('v.PHONE_NO', $s);
            $this->db->group_end();
        }

        $this->db->order_by('v.VISITOR_ID', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Approve a visitor, generate OTP, set 7-day validity, and return updated record
     */
    public function approve_visitor($visitor_id, $admin_id = null)
    {
        $visitor = $this->get_visitor_by_id($visitor_id);
        if (!$visitor) {
            return false;
        }

        // Generate 6-digit numeric OTP
        $otp = (string)mt_rand(100000, 999999);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

        $updateData = [
            'APPROVAL_STATUS' => 'APPROVED',
            'APPROVED_BY'     => !empty($admin_id) ? (int)$admin_id : null,
            'APPROVED_ON'     => date('Y-m-d H:i:s'),
            'OTP_CODE'        => $otp,
            'OTP_CREATED_AT'  => date('Y-m-d H:i:s'),
            'OTP_EXPIRES_AT'  => $expiresAt,
            'REJECTION_REASON'=> null,
        ];

        $this->db->where('VISITOR_ID', $visitor->VISITOR_ID);
        $this->db->update(HSE_VISITOR_REG, $updateData);

        return $this->get_visitor_by_id($visitor->VISITOR_ID);
    }

    /**
     * Reject a visitor
     */
    public function reject_visitor($visitor_id, $admin_id = null, $reason = '')
    {
        $updateData = [
            'APPROVAL_STATUS' => 'REJECTED',
            'APPROVED_BY'     => !empty($admin_id) ? (int)$admin_id : null,
            'APPROVED_ON'     => date('Y-m-d H:i:s'),
            'REJECTION_REASON'=> trim($reason),
            'OTP_CODE'        => null,
            'OTP_EXPIRES_AT'  => null,
        ];

        $this->db->where('VISITOR_ID', (int)$visitor_id);
        return $this->db->update(HSE_VISITOR_REG, $updateData);
    }

    /**
     * Regenerate and return new OTP for an approved visitor
     */
    public function regenerate_otp($visitor_id)
    {
        $otp = (string)mt_rand(100000, 999999);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

        $this->db->where('VISITOR_ID', (int)$visitor_id);
        $this->db->update(HSE_VISITOR_REG, [
            'OTP_CODE'       => $otp,
            'OTP_CREATED_AT' => date('Y-m-d H:i:s'),
            'OTP_EXPIRES_AT' => $expiresAt,
        ]);

        return $this->get_visitor_by_id($visitor_id);
    }

    /**
     * Verify visitor OTP
     * 
     * Special Rules:
     * 1. If visitor already PASSED: Allows same OTP previously issued so they can view marks & download certificates.
     * 2. If visitor FAILED and returns on a subsequent day: Requires new OTP.
     */
    public function verify_otp($token, $inputOtp)
    {
        $visitor = $this->get_visitor_by_token($token);
        if (!$visitor) {
            return ['status' => false, 'message' => 'Invalid or expired assessment link.'];
        }

        if ($visitor->APPROVAL_STATUS !== 'APPROVED') {
            return ['status' => false, 'message' => 'Your visitor registration is ' . $visitor->APPROVAL_STATUS . ' and has not been approved for HSE Induction yet.'];
        }

        $inputOtp = trim($inputOtp);

        // Passed visitor: Allow previous OTP
        if ($visitor->INDUCTION_STATUS === 'PASSED') {
            if ($visitor->OTP_CODE !== $inputOtp) {
                return ['status' => false, 'message' => 'Invalid OTP. Please enter the OTP provided in your invitation email.'];
            }
            return ['status' => true, 'visitor' => $visitor, 'mode' => 'passed_view'];
        }

        // Failed visitor checking date: If failed on a previous day, require renewed OTP
        if ($visitor->INDUCTION_STATUS === 'FAILED' && !empty($visitor->OTP_CREATED_AT)) {
            $otpDate = date('Y-m-d', strtotime($visitor->OTP_CREATED_AT));
            $today = date('Y-m-d');
            if ($otpDate < $today) {
                // Generate a fresh OTP for the next day retake
                $visitor = $this->regenerate_otp($visitor->VISITOR_ID);
                return [
                    'status' => false,
                    'message' => 'Your previous day attempt session expired. A new OTP has been generated for today\'s re-attempt. Please check your email or contact HSSE.',
                    'new_otp_required' => true
                ];
            }
        }

        // Standard verification
        if ($visitor->OTP_CODE !== $inputOtp) {
            return ['status' => false, 'message' => 'Invalid OTP. Please check the 6-digit code received in your email.'];
        }

        if (!empty($visitor->OTP_EXPIRES_AT) && strtotime($visitor->OTP_EXPIRES_AT) < time()) {
            return ['status' => false, 'message' => 'The OTP code has expired. Please contact Lumut Port HSSE to request a new code.'];
        }

        // Mark OTP verified
        $this->db->where('VISITOR_ID', $visitor->VISITOR_ID);
        $this->db->update(HSE_VISITOR_REG, ['OTP_VERIFIED' => 'Y']);

        return ['status' => true, 'visitor' => $visitor, 'mode' => 'take_exam'];
    }

    /**
     * Get Visitor Training Material from Master (Type 1: Visitor)
     */
    public function get_training_material()
    {
        return $this->db->where('type', 1)
                        ->where('file_status', 'Y')
                        ->order_by('id', 'DESC')
                        ->limit(1)
                        ->get(TRM_UPLOAD_MAS)
                        ->row();
    }

    /**
     * Get Visitor Assessment Questions from Master (Type 1: Visitor)
     */
    public function get_assessment_questions()
    {
        return $this->db->where('type', 1)
                        ->where('question_status', 'Y')
                        ->order_by('id', 'ASC')
                        ->get(TRM_ASS_MAS)
                        ->result();
    }

    /**
     * Record visitor examination attempt with complete question snapshots,
     * calculation, QR code generation, and pass certificate issuance.
     */
    public function record_attempt_with_snapshots($visitor_id, $questions, $submittedAnswers, $timeTaken = 0, $ipAddress = '')
    {
        $visitor = $this->get_visitor_by_id($visitor_id);
        if (!$visitor) {
            return false;
        }

        $this->db->trans_start();

        // Determine attempt number
        $maxAttempt = $this->db->select_max('ATTEMPT_NUMBER', 'max_att')
                               ->where('EMP_AUTO_ID', $visitor->VISITOR_ID)
                               ->where('TYPE_ID', 1)
                               ->get(HSE_IND_ATTEMPTS)->row();
        $attemptNumber = (!empty($maxAttempt->max_att)) ? ((int)$maxAttempt->max_att + 1) : 1;

        $totalQuestions = count($questions);
        $questionsAnswered = 0;
        $correctAnswers = 0;
        $incorrectAnswers = 0;

        $totalAvailableMarks = 100.00;
        $marksPerQuestion = ($totalQuestions > 0) ? round($totalAvailableMarks / $totalQuestions, 2) : 0;
        $marksObtained = 0.00;

        $evaluatedAnswers = [];

        foreach ($questions as $idx => $q) {
            $qNum = $idx + 1;
            $qid = $q->id;

            $selectedOption = isset($submittedAnswers[$qid]) ? (int)$submittedAnswers[$qid] : null;
            $correctOption = (int)$q->correct_ans;

            $isCorrect = 0;
            $marksAwarded = 0.00;

            if ($selectedOption !== null) {
                $questionsAnswered++;
                if ($selectedOption === $correctOption) {
                    $isCorrect = 1;
                    $correctAnswers++;
                    $marksAwarded = $marksPerQuestion;
                    $marksObtained += $marksPerQuestion;
                } else {
                    $incorrectAnswers++;
                }
            }

            $evaluatedAnswers[] = [
                'QUESTION_ID'     => $qid,
                'QUESTION_NUMBER' => $qNum,
                'QUESTION_TEXT'   => $q->question,
                'QUESTION_IMG'    => !empty($q->question_path) ? $q->question_path : (!empty($q->question_img) ? $q->question_img : null),
                'OPTION_A'        => !empty($q->option_a) ? $q->option_a : $q->opt_a,
                'OPTION_A_IMG'    => !empty($q->option_a_path) ? $q->option_a_path : (!empty($q->option_a_img) ? $q->option_a_img : null),
                'OPTION_B'        => !empty($q->option_b) ? $q->option_b : $q->opt_b,
                'OPTION_B_IMG'    => !empty($q->option_b_path) ? $q->option_b_path : (!empty($q->option_b_img) ? $q->option_b_img : null),
                'OPTION_C'        => !empty($q->option_c) ? $q->option_c : $q->opt_c,
                'OPTION_C_IMG'    => !empty($q->option_c_path) ? $q->option_c_path : (!empty($q->option_c_img) ? $q->option_c_img : null),
                'OPTION_D'        => !empty($q->option_d) ? $q->option_d : $q->opt_d,
                'OPTION_D_IMG'    => !empty($q->option_d_path) ? $q->option_d_path : (!empty($q->option_d_img) ? $q->option_d_img : null),
                'SELECTED_OPTION' => $selectedOption,
                'CORRECT_OPTION'  => $correctOption,
                'IS_CORRECT'      => $isCorrect,
                'MARKS_AWARDED'   => $marksAwarded,
            ];
        }

        $percentage = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;
        $isPassed = ($percentage >= 100.00 && $correctAnswers == $totalQuestions);
        $passFailStatus = $isPassed ? 'PASSED' : 'FAILED';

        if ($isPassed) {
            $marksObtained = 100.00;
        }

        // Generate Certificate No & QR Code if Passed
        $certNo = null;
        $qrPath = null;

        if ($isPassed) {
            $certNo = 'LMT-HSE-VIS-' . $visitor->VISITOR_ID . '-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 5));

            $qrDir = 'assets/uploads/hse_induction/qrcodes/';
            $qrFullPath = FCPATH . $qrDir;
            if (!file_exists($qrFullPath)) {
                mkdir($qrFullPath, 0777, true);
            }
            $qrFileName = $certNo . '.png';
            $qrSavePath = $qrFullPath . $qrFileName;
            $qrPath = $qrDir . $qrFileName;

            $this->load->library('ciqrcode', ['cacheable' => false]);
            $qrData = "LUMUT PORT HSSE VISITOR INDUCTION PASS\n" .
                      "Certificate No: " . $certNo . "\n" .
                      "Visitor: " . $visitor->VISITOR_NAME . "\n" .
                      "Company: " . $visitor->COMPANY_NAME . "\n" .
                      "IC/Passport: " . $visitor->IC_PASSPORT_NO . "\n" .
                      "Terminal: " . (!empty($visitor->TERMINAL_NAME) ? $visitor->TERMINAL_NAME : 'Lumut Port') . "\n" .
                      "Visit Date: " . date('d-m-Y H:i', strtotime($visitor->VISIT_DATETIME)) . "\n" .
                      "Score: 100% (PASSED)\n" .
                      "Status: VERIFIED & COMPLIANT\n" .
                      "Authority: Lumut Maritime Terminal HSSE Department";

            $params = [
                'data'     => $qrData,
                'level'    => 'H',
                'size'     => 6,
                'savename' => $qrSavePath
            ];
            $this->ciqrcode->generate($params);
        }

        // 1. Insert Attempt Record in hse_induction_attempts (TYPE_ID = 1 for Visitor)
        $attemptData = [
            'INDUCTION_ID'          => $visitor->VISITOR_ID,
            'EMP_AUTO_ID'           => $visitor->VISITOR_ID,
            'ATTEMPT_NUMBER'        => $attemptNumber,
            'TYPE_ID'               => 1, // Visitor
            'TOTAL_QUESTIONS'       => $totalQuestions,
            'QUESTIONS_ANSWERED'    => $questionsAnswered,
            'CORRECT_ANSWERS'       => $correctAnswers,
            'INCORRECT_ANSWERS'     => $incorrectAnswers,
            'TOTAL_AVAILABLE_MARKS' => $totalAvailableMarks,
            'MARKS_OBTAINED'        => $marksObtained,
            'PERCENTAGE'            => $percentage,
            'PASS_FAIL_STATUS'      => $passFailStatus,
            'TIME_TAKEN_SECONDS'    => $timeTaken,
            'ATTEMPT_COMPLETED_AT'  => date('Y-m-d H:i:s'),
            'CERTIFICATE_NO'        => $certNo,
            'QR_CODE_PATH'          => $qrPath,
            'IP_ADDRESS'            => $ipAddress,
            'CREATED_ON'            => date('Y-m-d H:i:s')
        ];
        $this->db->insert(HSE_IND_ATTEMPTS, $attemptData);
        $attemptId = $this->db->insert_id();

        // 2. Insert Question-by-Question Snapshots in hse_induction_attempt_answers
        foreach ($evaluatedAnswers as $ans) {
            $ans['ATTEMPT_ID']  = $attemptId;
            $ans['EMP_AUTO_ID'] = $visitor->VISITOR_ID;
            $ans['CREATED_ON']  = date('Y-m-d H:i:s');
            $this->db->insert(HSE_IND_ATTEMPT_ANSWERS, $ans);
        }

        // 3. Update Master Record in hse_visitor_registration
        $updateVisitor = [
            'INDUCTION_STATUS' => $passFailStatus,
            'SCORE_PERCENTAGE' => $percentage,
            'TOTAL_QUESTIONS'  => $totalQuestions,
            'CORRECT_ANSWERS'  => $correctAnswers,
            'WRONG_ANSWERS'    => $incorrectAnswers,
            'ATTEMPTS_COUNT'   => $attemptNumber,
            'IP_ADDRESS'       => $ipAddress,
        ];

        $calculatedValidityDate = null;
        if ($isPassed) {
            $updateVisitor['CERTIFICATE_NO'] = $certNo;
            $updateVisitor['QR_CODE_PATH']   = $qrPath;
            $updateVisitor['PASSED_DATE']    = date('Y-m-d H:i:s');

            // Set validity date strictly to the visitor's selected visit end date
            if (!empty($visitor->VISIT_DATETIME_END) && $visitor->VISIT_DATETIME_END != '0000-00-00 00:00:00') {
                $calculatedValidityDate = date('Y-m-d', strtotime($visitor->VISIT_DATETIME_END));
            } elseif (!empty($visitor->VISIT_DATETIME) && $visitor->VISIT_DATETIME != '0000-00-00 00:00:00') {
                $calculatedValidityDate = date('Y-m-d', strtotime($visitor->VISIT_DATETIME));
            } else {
                $calculatedValidityDate = date('Y-m-d');
            }
            $updateVisitor['VALIDITY_DATE'] = $calculatedValidityDate;
        }

        $this->db->where('VISITOR_ID', $visitor->VISITOR_ID);
        $this->db->update(HSE_VISITOR_REG, $updateVisitor);

        $this->db->trans_complete();

        return [
            'attempt_id'        => $attemptId,
            'attempt_number'    => $attemptNumber,
            'status'            => $passFailStatus,
            'is_passed'         => $isPassed,
            'percentage'        => $percentage,
            'correct_answers'   => $correctAnswers,
            'incorrect_answers' => $incorrectAnswers,
            'total_questions'   => $totalQuestions,
            'certificate_no'    => $certNo,
            'qr_code_path'      => $qrPath,
            'validity_date'     => ($isPassed && $calculatedValidityDate) ? date('d-m-Y', strtotime($calculatedValidityDate)) : null
        ];
    }

    /**
     * Reset visitor induction progress to allow retesting
     */
    public function reset_visitor_progress($visitor_id)
    {
        $visitor = $this->get_visitor_by_id($visitor_id);
        if ($visitor && $visitor->INDUCTION_STATUS == 'PASSED') {
            return false;
        }

        $this->db->where('VISITOR_ID', (int)$visitor_id);
        return $this->db->update(HSE_VISITOR_REG, [
            'VIDEO_STATUS'          => 'NOT_WATCHED',
            'VIDEO_WATCHED_SECONDS' => 0,
            'INDUCTION_STATUS'      => 'NOT_STARTED',
        ]);
    }

    /**
     * Get all historical attempts for a visitor
     */
    public function get_visitor_attempts($visitor_id)
    {
        $this->db->where('EMP_AUTO_ID', (int)$visitor_id);
        $this->db->where('TYPE_ID', 1); // Visitor
        $this->db->order_by('ATTEMPT_NUMBER', 'DESC');
        return $this->db->get(HSE_IND_ATTEMPTS)->result();
    }

    /**
     * Get single attempt record for visitor
     */
    public function get_attempt_by_id($attempt_id)
    {
        $this->db->select('att.*, v.VISITOR_NAME as EMP_NAME, v.VISITOR_REG_NO as EMP_ID, v.COMPANY_NAME as dept_name, tm.TERMINAL_NAME as desig_name');
        $this->db->from(HSE_IND_ATTEMPTS . ' att');
        $this->db->join(HSE_VISITOR_REG . ' v', 'v.VISITOR_ID = att.EMP_AUTO_ID', 'left');
        $this->db->join(TERM . ' tm', 'tm.TER_AUTO_ID = v.TERMINAL_ID', 'left');
        $this->db->where('att.ATTEMPT_ID', (int)$attempt_id);
        return $this->db->get()->row();
    }

    /**
     * Get question answers for an attempt
     */
    public function get_attempt_answers($attempt_id)
    {
        $this->db->where('ATTEMPT_ID', (int)$attempt_id);
        $this->db->order_by('QUESTION_NUMBER', 'ASC');
        return $this->db->get(HSE_IND_ATTEMPT_ANSWERS)->result();
    }
}

