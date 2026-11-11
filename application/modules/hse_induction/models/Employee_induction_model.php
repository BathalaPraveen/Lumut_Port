<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Employee Induction Model
 * 
 * Handles database operations for Employee HSE Induction, training material tracking,
 * permanent attempt logging, and historical question snapshotting.
 */
class Employee_induction_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('common/common_model', 'common_model');
    }

    /**
     * Check if any passed induction has completed its validity date.
     * If validity is completed/expired, mark it as EXPIRED and dynamically add
     * a new renewal row below it so the employee can attend again for the new cycle.
     */
    public function check_and_create_renewal_cycles()
    {
        $today = date('Y-m-d');
        // Find passed inductions whose validity date is expired
        $expiredList = $this->db->select('*')
                                ->from(HSE_EMP_INDUCTION)
                                ->where('INDUCTION_STATUS', 'PASSED')
                                ->where('VALIDITY_DATE IS NOT NULL', null, false)
                                ->where('VALIDITY_DATE !=', '0000-00-00')
                                ->where('VALIDITY_DATE <', $today)
                                ->where('STATUS', 'Y')
                                ->get()->result();

        if (!empty($expiredList)) {
            foreach ($expiredList as $exp) {
                // Update old row to EXPIRED
                $this->db->where('ID', $exp->ID)->update(HSE_EMP_INDUCTION, [
                    'INDUCTION_STATUS' => 'EXPIRED',
                    'UPDATED_ON'       => date('Y-m-d H:i:s')
                ]);

                // Check if a newer row already exists for this employee
                $newer = $this->db->where('EMP_AUTO_ID', $exp->EMP_AUTO_ID)
                                  ->where('TYPE_ID', $exp->TYPE_ID)
                                  ->where('ID >', $exp->ID)
                                  ->where('STATUS', 'Y')
                                  ->get(HSE_EMP_INDUCTION)->row();

                if (!$newer) {
                    // Create new dynamic renewal row below the existing row
                    $newCycle = [
                        'EMP_AUTO_ID'           => $exp->EMP_AUTO_ID,
                        'LOGIN_ID'              => $exp->LOGIN_ID,
                        'TYPE_ID'               => $exp->TYPE_ID,
                        'INDUCTION_STATUS'      => 'NOT_STARTED',
                        'VIDEO_STATUS'          => 'NOT_WATCHED',
                        'VIDEO_WATCHED_SECONDS' => 0,
                        'TOTAL_QUESTIONS'       => 0,
                        'CORRECT_ANSWERS'       => 0,
                        'WRONG_ANSWERS'         => 0,
                        'SCORE_PERCENTAGE'      => null,
                        'ATTEMPTS'              => 0,
                        'STATUS'                => 'Y',
                        'CREATED_ON'            => date('Y-m-d H:i:s'),
                        'UPDATED_ON'            => date('Y-m-d H:i:s')
                    ];
                    $this->db->insert(HSE_EMP_INDUCTION, $newCycle);
                }
            }
        }
    }

    /**
     * Get or create master induction status record for an employee
     */
    public function get_or_create_induction($emp_auto_id, $login_id = null, $type_id = 2, $induction_id = null)
    {
        if (!empty($induction_id)) {
            $row = $this->db->where('ID', $induction_id)->where('STATUS', 'Y')->get(HSE_EMP_INDUCTION)->row();
            if ($row) {
                return $row;
            }
        }

        $this->db->where('EMP_AUTO_ID', $emp_auto_id);
        $this->db->where('TYPE_ID', $type_id);
        $this->db->where('STATUS', 'Y');
        $this->db->order_by('ID', 'desc');
        $row = $this->db->get(HSE_EMP_INDUCTION)->row();

        if ($row) {
            return $row;
        }

        $data = [
            'EMP_AUTO_ID'           => $emp_auto_id,
            'LOGIN_ID'              => $login_id,
            'TYPE_ID'               => $type_id,
            'INDUCTION_STATUS'      => 'NOT_STARTED',
            'VIDEO_STATUS'          => 'NOT_WATCHED',
            'VIDEO_WATCHED_SECONDS' => 0,
            'TOTAL_QUESTIONS'       => 0,
            'CORRECT_ANSWERS'       => 0,
            'WRONG_ANSWERS'         => 0,
            'SCORE_PERCENTAGE'      => 0.00,
            'ATTEMPTS'              => 0,
            'STATUS'                => 'Y',
            'CREATED_ON'            => date('Y-m-d H:i:s'),
            'UPDATED_ON'            => date('Y-m-d H:i:s')
        ];
        $this->db->insert(HSE_EMP_INDUCTION, $data);
        $insert_id = $this->db->insert_id();

        return $this->db->get_where(HSE_EMP_INDUCTION, ['ID' => $insert_id])->row();
    }

    /**
     * Get current induction status record
     */
    public function get_induction($emp_auto_id, $type_id = 2, $induction_id = null)
    {
        if (!empty($induction_id)) {
            $row = $this->db->where('ID', $induction_id)->get(HSE_EMP_INDUCTION)->row();
            if ($row) {
                return $row;
            }
        }
        $this->db->where('EMP_AUTO_ID', $emp_auto_id);
        $this->db->where('TYPE_ID', $type_id);
        $this->db->order_by('ID', 'desc');
        return $this->db->get(HSE_EMP_INDUCTION)->row();
    }

    /**
     * Get dynamic training material from Master based on induction type
     */
    public function get_training_material($type_id = 2)
    {
        // 1. By type id
        $this->db->where('type', $type_id);
        $this->db->where('file_status', 'Y');
        $this->db->order_by('id', 'desc');
        $file = $this->db->get(TRM_UPLOAD_MAS)->row();
        if ($file) {
            return $file;
        }

        // 2. By type name (e.g. 'Employee')
        $typeRow = $this->db->get_where(TRM_TYPE_MAS, ['id' => $type_id])->row();
        if ($typeRow) {
            $this->db->where('type', $typeRow->type);
            $this->db->where('file_status', 'Y');
            $this->db->order_by('id', 'desc');
            $file = $this->db->get(TRM_UPLOAD_MAS)->row();
            if ($file) {
                return $file;
            }
        }

        // 3. Fallback to latest active file
        $this->db->where('file_status', 'Y');
        $this->db->order_by('id', 'desc');
        return $this->db->get(TRM_UPLOAD_MAS)->row();
    }

    /**
     * Get dynamic questions from Master based on induction type
     */
    public function get_assessment_questions($type_id = 2)
    {
        // 1. By type id
        $this->db->where('type', $type_id);
        $this->db->where('question_status', 'Y');
        $this->db->order_by('id', 'asc');
        $questions = $this->db->get(TRM_ASS_MAS)->result();
        if (!empty($questions)) {
            return $questions;
        }

        // 2. By type name
        $typeRow = $this->db->get_where(TRM_TYPE_MAS, ['id' => $type_id])->row();
        if ($typeRow) {
            $this->db->where('type', $typeRow->type);
            $this->db->where('question_status', 'Y');
            $this->db->order_by('id', 'asc');
            $questions = $this->db->get(TRM_ASS_MAS)->result();
            if (!empty($questions)) {
                return $questions;
            }
        }

        // 3. Fallback to all active questions
        $this->db->where('question_status', 'Y');
        $this->db->order_by('id', 'asc');
        return $this->db->get(TRM_ASS_MAS)->result();
    }

    /**
     * Update video progress
     */
    public function update_video_progress($emp_auto_id, $type_id = 2, $status = 'COMPLETED', $seconds = 0, $induction_id = null)
    {
        $induction = $this->get_induction($emp_auto_id, $type_id, $induction_id);
        
        // NEVER overwrite status if already PASSED!
        if ($induction && $induction->INDUCTION_STATUS == 'PASSED') {
            return true;
        }

        if (!empty($induction_id)) {
            $this->db->where('ID', $induction_id);
        } else {
            $this->db->where('EMP_AUTO_ID', $emp_auto_id);
            $this->db->where('TYPE_ID', $type_id);
            $this->db->order_by('ID', 'desc')->limit(1);
        }

        $updateData = [
            'VIDEO_STATUS'          => $status,
            'VIDEO_WATCHED_SECONDS' => $seconds,
            'UPDATED_ON'            => date('Y-m-d H:i:s')
        ];

        if (!$induction || $induction->INDUCTION_STATUS != 'PASSED') {
            $updateData['INDUCTION_STATUS'] = ($status == 'COMPLETED') ? 'IN_PROGRESS' : 'NOT_STARTED';
        }

        $this->db->update(HSE_EMP_INDUCTION, $updateData);
        return true;
    }

    /**
     * Reset induction to allow re-attending from Step 1 (Only for FAILED / NOT_STARTED)
     */
    public function reset_induction($emp_auto_id, $type_id = 2, $induction_id = null)
    {
        $induction = $this->get_induction($emp_auto_id, $type_id, $induction_id);
        
        // NEVER reset a PASSED induction that is still within active validity!
        if ($induction && $induction->INDUCTION_STATUS == 'PASSED') {
            $today = date('Y-m-d');
            if (!empty($induction->VALIDITY_DATE) && $induction->VALIDITY_DATE >= $today) {
                return false;
            }
        }

        if (!empty($induction_id)) {
            $this->db->where('ID', $induction_id);
        } else {
            $this->db->where('EMP_AUTO_ID', $emp_auto_id);
            $this->db->where('TYPE_ID', $type_id);
            $this->db->order_by('ID', 'desc')->limit(1);
        }
        $this->db->update(HSE_EMP_INDUCTION, [
            'VIDEO_STATUS'          => 'NOT_WATCHED',
            'VIDEO_WATCHED_SECONDS' => 0,
            'INDUCTION_STATUS'      => 'NOT_STARTED',
            'UPDATED_ON'            => date('Y-m-d H:i:s')
        ]);
        return true;
    }

    /**
     * Permanently record an assessment attempt with complete historical snapshotting
     * 
     * Even if master questions or options are later modified or deleted, previously
     * submitted attempts preserve the original question text, options, employee selection,
     * correct answer, and marks awarded.
     */
    public function record_attempt_with_snapshots($emp_auto_id, $type_id, $questions, $submittedAnswers, $timeTaken = 0, $ipAddress = '', $induction_id = null)
    {
        $empAutoId = (int)$emp_auto_id;
        $this->db->trans_start();

        $induction = $this->get_or_create_induction($emp_auto_id, null, $type_id, $induction_id);

        // Determine attempt number
        $maxAttempt = $this->db->select_max('ATTEMPT_NUMBER', 'max_att')
                               ->where('EMP_AUTO_ID', $emp_auto_id)
                               ->where('TYPE_ID', $type_id)
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
            $qid = $q->id;
            $selectedOpt = isset($submittedAnswers[$qid]) ? trim((string)$submittedAnswers[$qid]) : '';
            $correctOpt = trim((string)$q->correct_ans);

            if ($selectedOpt !== '') {
                $questionsAnswered++;
            }

            $isCorrect = ($selectedOpt !== '' && $selectedOpt === $correctOpt);
            if ($isCorrect) {
                $correctAnswers++;
                $marksObtained += $marksPerQuestion;
            } else {
                $incorrectAnswers++;
            }

            // Map option texts
            $optTexts = [
                '1' => !empty($q->option_a) ? $q->option_a : 'Option A',
                '2' => !empty($q->option_b) ? $q->option_b : 'Option B',
                '3' => !empty($q->option_c) ? $q->option_c : 'Option C',
                '4' => !empty($q->option_d) ? $q->option_d : 'Option D',
            ];

            $selectedText = isset($optTexts[$selectedOpt]) ? $optTexts[$selectedOpt] : 'Not Answered';
            $correctText = isset($optTexts[$correctOpt]) ? $optTexts[$correctOpt] : '';

            $evaluatedAnswers[] = [
                'QUESTION_ID'          => $qid,
                'QUESTION_NUMBER'      => ($idx + 1),
                'QUESTION_TEXT'        => $q->question,
                'QUESTION_IMG'         => !empty($q->question_img) ? $q->question_img : null,
                'OPTION_A'             => !empty($q->option_a) ? $q->option_a : null,
                'OPTION_A_IMG'         => !empty($q->option_a_img) ? $q->option_a_img : null,
                'OPTION_B'             => !empty($q->option_b) ? $q->option_b : null,
                'OPTION_B_IMG'         => !empty($q->option_b_img) ? $q->option_b_img : null,
                'OPTION_C'             => !empty($q->option_c) ? $q->option_c : null,
                'OPTION_C_IMG'         => !empty($q->option_c_img) ? $q->option_c_img : null,
                'OPTION_D'             => !empty($q->option_d) ? $q->option_d : null,
                'OPTION_D_IMG'         => !empty($q->option_d_img) ? $q->option_d_img : null,
                'SELECTED_OPTION'      => $selectedOpt,
                'SELECTED_OPTION_TEXT' => $selectedText,
                'CORRECT_OPTION'       => $correctOpt,
                'CORRECT_OPTION_TEXT'  => $correctText,
                'IS_CORRECT'           => $isCorrect ? 1 : 0,
                'MARKS_ALLOCATED'      => $marksPerQuestion,
                'MARKS_AWARDED'        => $isCorrect ? $marksPerQuestion : 0.00
            ];
        }

        // Standard percentage calculation
        $percentage = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0.00;
        $isPassed = ($percentage >= 100.00 && $correctAnswers == $totalQuestions);
        $passFailStatus = $isPassed ? 'PASSED' : 'FAILED';

        if ($isPassed) {
            $marksObtained = 100.00;
        }

        // Generate Certificate No & QR Code if Passed
        $certNo = null;
        $qrPath = null;

        if ($isPassed) {
            $certNo = 'LMT-HSE-EMP-' . $empAutoId . '-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 5));

            $qrDir = 'assets/uploads/hse_induction/qrcodes/';
            $qrFullPath = FCPATH . $qrDir;
            if (!file_exists($qrFullPath)) {
                mkdir($qrFullPath, 0777, true);
            }
            $qrFileName = $certNo . '.png';
            $qrSavePath = $qrFullPath . $qrFileName;
            $qrPath = $qrDir . $qrFileName;

            $empObj = $this->db->get_where(EMPL, ['EMP_AUTO_ID' => $empAutoId])->row();
            $empName = $empObj ? $empObj->EMP_NAME : 'Employee';
            $empCode = $empObj ? $empObj->EMP_ID : '';

            $this->load->library('ciqrcode', ['cacheable' => false]);
            $qrData = "LUMUT PORT HSSE INDUCTION CERTIFICATE\n" .
                      "Certificate No: " . $certNo . "\n" .
                      "Employee: " . $empName . " (" . $empCode . ")\n" .
                      "Type: Employee HSE Induction\n" .
                      "Score: 100% (PASSED)\n" .
                      "Date: " . date('d-m-Y') . "\n" .
                      "Valid Until: " . date('d-m-Y', strtotime('+1 year')) . "\n" .
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

        // 1. Insert Attempt Record in hse_induction_attempts
        $attemptData = [
            'INDUCTION_ID'          => $induction->ID,
            'EMP_AUTO_ID'           => $empAutoId,
            'ATTEMPT_NUMBER'        => $attemptNumber,
            'TYPE_ID'               => $type_id,
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
            $ans['EMP_AUTO_ID'] = $empAutoId;
            $ans['CREATED_ON']  = date('Y-m-d H:i:s');
            $this->db->insert(HSE_IND_ATTEMPT_ANSWERS, $ans);
        }

        // 3. Update Master Record in hse_employee_induction
        $updateInduction = [
            'INDUCTION_STATUS'  => $passFailStatus,
            'TOTAL_QUESTIONS'   => $totalQuestions,
            'CORRECT_ANSWERS'   => $correctAnswers,
            'WRONG_ANSWERS'     => $incorrectAnswers,
            'SCORE_PERCENTAGE'  => $percentage,
            'ATTEMPTS'          => $attemptNumber,
            'LAST_ATTEMPT_DATE' => date('Y-m-d H:i:s'),
            'UPDATED_ON'        => date('Y-m-d H:i:s')
        ];

        if ($isPassed) {
            $updateInduction['CERTIFICATE_NO'] = $certNo;
            $updateInduction['QR_CODE_PATH']   = $qrPath;
            $updateInduction['PASSED_DATE']     = date('Y-m-d H:i:s');
            $updateInduction['VALIDITY_DATE']   = date('Y-m-d', strtotime('+1 year'));
        }

        $this->db->where('ID', $induction->ID);
        $this->db->update(HSE_EMP_INDUCTION, $updateInduction);

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
            'validity_date'     => $isPassed ? date('d-m-Y', strtotime('+1 year')) : null
        ];
    }

    /**
     * Get all historical attempts for an employee
     */
    public function get_employee_attempts($emp_auto_id, $type_id = 2)
    {
        $this->db->where('EMP_AUTO_ID', $emp_auto_id);
        if ($type_id) {
            $this->db->where('TYPE_ID', $type_id);
        }
        $this->db->order_by('ATTEMPT_NUMBER', 'DESC');
        return $this->db->get(HSE_IND_ATTEMPTS)->result();
    }

    /**
     * Get single attempt summary record
     */
    public function get_attempt_by_id($attempt_id)
    {
        $this->db->select('att.*, em.EMP_ID, em.EMP_NAME, FN_GET_DEPARTMENT_NAME(em.EMP_DEPT_ID) as dept_name, FN_GET_DESIGNATION_NAME(em.EMP_DESIGNATION_ID) as desig_name');
        $this->db->from(HSE_IND_ATTEMPTS . ' att');
        $this->db->join(EMPL . ' em', 'em.EMP_AUTO_ID = att.EMP_AUTO_ID', 'left');
        $this->db->where('att.ATTEMPT_ID', $attempt_id);
        return $this->db->get()->row();
    }

    /**
     * Get question-by-question historical snapshot answers for an attempt
     */
    public function get_attempt_answers($attempt_id)
    {
        $this->db->where('ATTEMPT_ID', $attempt_id);
        $this->db->order_by('QUESTION_NUMBER', 'ASC');
        return $this->db->get(HSE_IND_ATTEMPT_ANSWERS)->result();
    }
}

