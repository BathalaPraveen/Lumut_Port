<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Visitor Registration & Public Induction Controller
 * 
 * Manages public visitor registration outside the application, OTP verification,
 * interactive non-skippable HSE training video playback, examination evaluation,
 * and visitor pass/certificate downloads.
 * 
 * Uses standard CodeIgniter HMVC pattern (no custom routes required in routes.php).
 */
class Visitor_registration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->load->model('hse_induction/Visitor_induction_model', 'visitor_model');
        $this->load->model('email_model');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    /**
     * Public Visitor Registration Form
     * URL: hse_induction/visitor_registration
     */
    public function index()
    {
        $terminals = $this->visitor_model->get_active_terminals();
        $employees = $this->visitor_model->get_active_lmtsb_employees();

        $data = [
            'site_title' => 'Visitor HSE Induction Registration - Lumut Port',
            'terminals'  => $terminals,
            'employees'  => $employees,
        ];

        $this->load->view('hse_induction/visitor/public_register', $data);
    }

    /**
     * Alias for index()
     */
    public function register()
    {
        $this->index();
    }

    /**
     * Save Visitor Registration Submission
     * URL: hse_induction/visitor_registration/save
     */
    public function save()
    {
        $post = $this->input->post();

        $this->form_validation->set_rules('COMPANY_NAME', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('VISITOR_NAME', 'Visitor Name', 'trim|required');
        $this->form_validation->set_rules('IC_PASSPORT_NO', 'IC/Passport No.', 'trim|required');
        $this->form_validation->set_rules('EMAIL_ID', 'Email ID', 'trim|required|valid_email');
        $this->form_validation->set_rules('PHONE_NO', 'Phone No', 'trim|required');
        $this->form_validation->set_rules('ADDRESS', 'Address', 'trim|required');
        $this->form_validation->set_rules('VISIT_PURPOSE', 'Visit Purpose', 'trim|required');
        $this->form_validation->set_rules('VISIT_DATETIME', 'Visit Start Date & Time', 'trim|required');
        $this->form_validation->set_rules('VISIT_DATETIME_END', 'Visit End Date & Time', 'trim|required');
        $this->form_validation->set_rules('TERMINAL_ID', 'Terminal', 'trim|required|numeric');
        $this->form_validation->set_rules('CONTACT_PERSON_ID', 'Person of Contact (from LMTSB)', 'trim|required|numeric');
        $this->form_validation->set_rules('PDPA_AGREED', 'PDPA Policy Agreement', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error_msg', validation_errors());
            redirect('hse_induction/visitor_registration');
            return;
        }

        if (strtotime($post['VISIT_DATETIME_END']) < strtotime($post['VISIT_DATETIME'])) {
            $this->session->set_flashdata('error_msg', 'Visit End Date & Time must be equal to or after Visit Start Date & Time.');
            redirect('hse_induction/visitor_registration');
            return;
        }

        $visitor = $this->visitor_model->create_registration($post);

        $data = [
            'site_title' => 'Registration Submitted - Lumut Port',
            'visitor'    => $visitor,
        ];

        $this->load->view('hse_induction/visitor/registration_success', $data);
    }

    /**
     * OTP Verification Screen
     * URL: hse_induction/visitor_registration/verify/{token}
     */
    public function verify($token = '')
    {
        if (empty($token)) {
            show_404();
            return;
        }

        $visitor = $this->visitor_model->get_visitor_by_token($token);
        if (!$visitor) {
            show_error('Invalid or expired assessment link. Please check the URL provided in your invitation email.', 404, 'Assessment Link Not Found');
            return;
        }

        // Check if certificate/pass has expired
        $isExpired = false;
        if (!empty($visitor->VALIDITY_DATE) && $visitor->VALIDITY_DATE != '0000-00-00') {
            if (strtotime($visitor->VALIDITY_DATE) < strtotime(date('Y-m-d'))) {
                $isExpired = true;
            }
        }
        if ($visitor->INDUCTION_STATUS === 'EXPIRED') {
            $isExpired = true;
        }

        $isPassed = ($visitor->INDUCTION_STATUS === 'PASSED');

        // If already passed and session is already verified, redirect straight to download page
        if ($isPassed && !$isExpired && $this->session->userdata('visitor_verified_' . $token)) {
            redirect('hse_induction/visitor_registration/attend/' . $token);
            return;
        }

        $data = [
            'site_title' => $isExpired ? 'Certificate Expired - Lumut Port' : ($isPassed ? 'Access Port Pass & Certificate - Lumut Port' : 'Verify OTP - HSE Induction Assessment'),
            'visitor'    => $visitor,
            'token'      => $token,
            'is_expired' => $isExpired,
            'is_passed'  => $isPassed,
        ];

        $this->load->view('hse_induction/visitor/verify_otp', $data);
    }

    /**
     * Process Submitted OTP
     * URL: hse_induction/visitor_registration/verify_otp
     */
    public function verify_otp()
    {
        $token = $this->input->post('token');
        $otp = $this->input->post('otp_code');

        if (empty($token) || empty($otp)) {
            $this->session->set_flashdata('error_msg', 'Please enter your 6-digit OTP code.');
            redirect('hse_induction/visitor_registration/verify/' . $token);
            return;
        }

        $result = $this->visitor_model->verify_otp($token, $otp);

        if (!$result['status']) {
            $this->session->set_flashdata('error_msg', $result['message']);
            redirect('hse_induction/visitor_registration/verify/' . $token);
            return;
        }

        // Mark session as verified for this token
        $this->session->set_userdata('visitor_verified_' . $token, true);

        redirect('hse_induction/visitor_registration/attend/' . $token);
    }

    /**
     * Main Visitor Assessment Page (Step 1 Training -> Step 2 Exam -> Step 3 Result & Pass)
     * URL: hse_induction/visitor_registration/attend/{token}
     */
    public function attend($token = '')
    {
        if (empty($token)) {
            show_404();
            return;
        }

        $visitor = $this->visitor_model->get_visitor_by_token($token);
        if (!$visitor) {
            show_404();
            return;
        }

        // Verify session authorization
        if (!$this->session->userdata('visitor_verified_' . $token) && $this->input->get('preview') != '1') {
            redirect('hse_induction/visitor_registration/verify/' . $token);
            return;
        }

        // Check if certificate/pass has expired
        $isExpired = false;
        if (!empty($visitor->VALIDITY_DATE) && $visitor->VALIDITY_DATE != '0000-00-00') {
            if (strtotime($visitor->VALIDITY_DATE) < strtotime(date('Y-m-d'))) {
                $isExpired = true;
            }
        }
        if ($visitor->INDUCTION_STATUS === 'EXPIRED') {
            $isExpired = true;
        }

        if ($isExpired) {
            redirect('hse_induction/visitor_registration/verify/' . $token);
            return;
        }

        // Retake query parameter check (Strictly forbidden if already passed)
        if ($this->input->get('reattend') == '1') {
            if ($visitor->INDUCTION_STATUS === 'PASSED') {
                redirect('hse_induction/visitor_registration/attend/' . $token);
                return;
            } else {
                $this->visitor_model->reset_visitor_progress($visitor->VISITOR_ID);
                $visitor = $this->visitor_model->get_visitor_by_id($visitor->VISITOR_ID);
            }
        }

        // Training Material (Type 1: Visitor)
        $material = $this->visitor_model->get_training_material();
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

        // Questions (Type 1: Visitor)
        $questions = $this->visitor_model->get_assessment_questions();
        if (!empty($questions)) {
            shuffle($questions);
        }

        // Fetch latest attempt if any
        $latestAttempt = $this->db->where('EMP_AUTO_ID', $visitor->VISITOR_ID)
                                  ->where('TYPE_ID', 1)
                                  ->order_by('ATTEMPT_ID', 'DESC')
                                  ->limit(1)
                                  ->get(HSE_IND_ATTEMPTS)->row();

        $data = [
            'site_title'     => 'HSE Induction Assessment - ' . $visitor->VISITOR_NAME,
            'visitor'        => $visitor,
            'token'          => $token,
            'material'       => $material,
            'mediaType'      => $mediaType,
            'fileExt'        => $fileExt,
            'questions'      => $questions,
            'latest_attempt' => $latestAttempt,
        ];

        $this->load->view('hse_induction/visitor/take_induction', $data);
    }

    /**
     * AJAX: Record Visitor Video Completion
     * URL: hse_induction/visitor_registration/record_video_complete
     */
    public function record_video_complete()
    {
        $token = $this->input->post('token');
        $seconds = (int)$this->input->post('seconds');

        $visitor = $this->visitor_model->get_visitor_by_token($token);
        if (!$visitor) {
            echo json_encode(['status' => false, 'message' => 'Visitor not found']);
            exit();
        }

        $this->db->where('VISITOR_ID', $visitor->VISITOR_ID);
        $this->db->update(HSE_VISITOR_REG, [
            'VIDEO_STATUS'          => 'COMPLETED',
            'VIDEO_WATCHED_SECONDS' => $seconds,
            'INDUCTION_STATUS'      => ($visitor->INDUCTION_STATUS == 'PASSED') ? 'PASSED' : 'IN_PROGRESS'
        ]);

        echo json_encode(['status' => true, 'message' => 'Training material marked as completed']);
        exit();
    }

    /**
     * AJAX: Submit Visitor Examination Answers
     * URL: hse_induction/visitor_registration/submit_exam
     */
    public function submit_exam()
    {
        $token = $this->input->post('token');
        $submittedAnswersRaw = $this->input->post('answers');
        $timeTaken = (int)$this->input->post('time_taken', 0);

        $visitor = $this->visitor_model->get_visitor_by_token($token);
        if (!$visitor) {
            echo json_encode(['status' => false, 'message' => 'Invalid Visitor Token']);
            exit();
        }

        $submittedAnswers = !empty($submittedAnswersRaw) ? json_decode($submittedAnswersRaw, true) : [];
        $questions = $this->visitor_model->get_assessment_questions();
        $totalQuestions = count($questions);

        if ($totalQuestions == 0) {
            echo json_encode(['status' => false, 'message' => 'No active assessment questions found for Visitor']);
            exit();
        }

        if (count($submittedAnswers) < $totalQuestions) {
            echo json_encode(['status' => false, 'message' => 'All questions are mandatory and cannot be skipped.']);
            exit();
        }

        $ipAddress = $this->input->ip_address();

        $evalResult = $this->visitor_model->record_attempt_with_snapshots(
            $visitor->VISITOR_ID,
            $questions,
            $submittedAnswers,
            $timeTaken,
            $ipAddress
        );

        // If Passed: Email QR Code Pass to Visitor
        if ($evalResult['is_passed']) {
            $this->_send_pass_email($visitor, $evalResult);
        }

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
            'message'        => $evalResult['is_passed'] ? 'Congratulations! You have passed the HSE Induction.' : 'Score below 100%. Please re-attend.'
        ]);
        exit();
    }

    /**
     * Send email with Pass & Certificate details upon passing
     */
    private function _send_pass_email($visitor, $evalResult)
    {
        if (empty($visitor->EMAIL_ID)) {
            return;
        }

        $subject = 'Official Lumut Port HSE Induction Pass - ' . $visitor->VISITOR_NAME;
        $passUrl = BASE_URL . 'hse_induction/visitor_registration/attend/' . $visitor->ACCESS_TOKEN;

        $msg = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden;">
            <div style="background-color: #161D26; color: #FEC001; padding: 20px; text-align: center;">
                <h2 style="margin: 0;">LUMUT MARITIME TERMINAL</h2>
                <p style="margin: 5px 0 0 0; color: #fff; font-size: 13px;">HSSE DEPARTMENT - OFFICIAL VISITOR HSE INDUCTION PASS</p>
            </div>
            <div style="padding: 24px; color: #334155; line-height: 1.6;">
                <p>Dear <strong>' . htmlspecialchars($visitor->VISITOR_NAME) . '</strong>,</p>
                <p>Congratulations! You have successfully completed the <strong>Lumut Port HSE Induction</strong> with a score of <strong>100%</strong>.</p>
                <div style="background-color: #f0fdf4; border: 1px solid #86efac; border-radius: 6px; padding: 14px; margin: 18px 0;">
                    <p style="margin: 0; color: #166534; font-weight: bold;">Certificate No: ' . htmlspecialchars($evalResult['certificate_no']) . '</p>
                    <p style="margin: 4px 0 0 0; color: #166534; font-size: 13px;">Status: <strong>VERIFIED & COMPLIANT</strong></p>
                    <p style="margin: 4px 0 0 0; color: #166534; font-size: 13px;">Scheduled Visit: ' . date('d-m-Y H:i', strtotime($visitor->VISIT_DATETIME)) . '</p>
                    <p style="margin: 4px 0 0 0; color: #166534; font-size: 13px;">Terminal: ' . (!empty($visitor->TERMINAL_NAME) ? htmlspecialchars($visitor->TERMINAL_NAME) : 'Lumut Port') . '</p>
                </div>
                <p>You can view and download your official <strong>Port Pass (ID Badge)</strong> and <strong>Certificate of Completion</strong> at any time using the link below:</p>
                <div style="text-align: center; margin: 25px 0;">
                    <a href="' . $passUrl . '" style="background-color: #2563eb; color: #ffffff; padding: 12px 24px; text-decoration: none; font-weight: bold; border-radius: 6px; display: inline-block;">
                        Download Official Pass & Certificate
                    </a>
                </div>
                <p style="font-size: 12px; color: #64748b;">Note: Please visibly display your Port Pass ID badge or keep the scannable QR code available on your mobile device at all times while within Lumut Maritime Terminal premises.</p>
            </div>
            <div style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px; text-align: center; font-size: 11px; color: #94a3b8;">
                &copy; ' . date('Y') . ' Lumut Maritime Terminal Sdn Bhd. All rights reserved.
            </div>
        </div>';

        $this->email_model->sendEmail($visitor->EMAIL_ID, $subject, $msg, "");
    }

    /**
     * Download Visitor Port Pass PDF
     * URL: hse_induction/visitor_registration/pass_pdf/{token_or_id}
     */
    public function pass_pdf($token_or_id = '')
    {
        $visitor = is_numeric($token_or_id) ? $this->visitor_model->get_visitor_by_id($token_or_id) : $this->visitor_model->get_visitor_by_token($token_or_id);
        if (!$visitor) {
            show_404();
            return;
        }

        // Check if certificate/pass has expired
        $isExpired = false;
        if (!empty($visitor->VALIDITY_DATE) && $visitor->VALIDITY_DATE != '0000-00-00') {
            if (strtotime($visitor->VALIDITY_DATE . ' 23:59:59') < time()) {
                $isExpired = true;
            }
        }
        if (!empty($visitor->VISIT_DATETIME_END) && strtotime($visitor->VISIT_DATETIME_END) < time()) {
            $isExpired = true;
        }
        if ($visitor->INDUCTION_STATUS === 'EXPIRED') {
            $isExpired = true;
        }

        if ($isExpired) {
            redirect('hse_induction/visitor_registration/verify/' . $visitor->ACCESS_TOKEN);
            return;
        }

        $data = [
            'visitor' => $visitor,
        ];

        $this->load->library('pdf');
        $html = $this->load->view('hse_induction/visitor/pdf_port_pass_only', $data, true);
        $mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 10, 10, 0, 0);
        $mpdf->WriteHTML($html);

        $cleanReg = preg_replace('/[^a-zA-Z0-9_-]/', '_', $visitor->VISITOR_REG_NO);
        $fileName = 'HSE-VisitorPass-' . $cleanReg . '.pdf';

        if (ob_get_length()) {
            ob_end_clean();
        }
        $mpdf->Output($fileName, 'I');
    }

    /**
     * Download Visitor Certificate PDF
     * URL: hse_induction/visitor_registration/certificate_pdf/{token_or_id}
     */
    public function certificate_pdf($token_or_id = '')
    {
        $visitor = is_numeric($token_or_id) ? $this->visitor_model->get_visitor_by_id($token_or_id) : $this->visitor_model->get_visitor_by_token($token_or_id);
        if (!$visitor) {
            show_404();
            return;
        }

        // Check if certificate/pass has expired
        $isExpired = false;
        if (!empty($visitor->VALIDITY_DATE) && $visitor->VALIDITY_DATE != '0000-00-00') {
            if (strtotime($visitor->VALIDITY_DATE . ' 23:59:59') < time()) {
                $isExpired = true;
            }
        }
        if (!empty($visitor->VISIT_DATETIME_END) && strtotime($visitor->VISIT_DATETIME_END) < time()) {
            $isExpired = true;
        }
        if ($visitor->INDUCTION_STATUS === 'EXPIRED') {
            $isExpired = true;
        }

        if ($isExpired) {
            redirect('hse_induction/visitor_registration/verify/' . $visitor->ACCESS_TOKEN);
            return;
        }

        $data = [
            'visitor' => $visitor,
        ];

        $this->load->library('pdf');
        $html = $this->load->view('hse_induction/visitor/pdf_certificate_only', $data, true);
        $mpdf = new mPDF('utf-8', 'A4', 0, '', 0, 0, 0, 0, 0, 0);
        $mpdf->WriteHTML($html);

        $cleanReg = preg_replace('/[^a-zA-Z0-9_-]/', '_', $visitor->VISITOR_REG_NO);
        $fileName = 'HSE-VisitorCertificate-' . $cleanReg . '.pdf';

        if (ob_get_length()) {
            ob_end_clean();
        }
        $mpdf->Output($fileName, 'I');
    }

    /**
     * View Question-by-Question Answers Preview (Candidate Answers vs Correct Answers)
     * URL: hse_induction/visitor_registration/attempt_details/{token_or_att_id}
     */
    public function attempt_details($token_or_att_id = '')
    {
        $attempt = null;
        $visitor = null;

        if (is_numeric($token_or_att_id)) {
            $attempt = $this->visitor_model->get_attempt_by_id((int)$token_or_att_id);
            if ($attempt) {
                $visitor = $this->visitor_model->get_visitor_by_id($attempt->EMP_AUTO_ID);
            }
        } else {
            $visitor = $this->visitor_model->get_visitor_by_token($token_or_att_id);
            if ($visitor) {
                $latest = $this->db->where('EMP_AUTO_ID', $visitor->VISITOR_ID)
                                   ->where('TYPE_ID', 1)
                                   ->order_by('ATTEMPT_ID', 'DESC')
                                   ->limit(1)
                                   ->get(HSE_IND_ATTEMPTS)->row();
                if ($latest) {
                    $attempt = $this->visitor_model->get_attempt_by_id($latest->ATTEMPT_ID);
                }
            }
        }

        if (!$attempt || !$visitor) {
            show_404();
            return;
        }

        $answers = $this->visitor_model->get_attempt_answers($attempt->ATTEMPT_ID);

        $data = [
            'site_title'        => 'Attempt #' . $attempt->ATTEMPT_NUMBER . ' Answers Preview - ' . $visitor->VISITOR_NAME,
            'attempt'           => $attempt,
            'visitor'           => $visitor,
            'answers'           => $answers,
            'is_internal_admin' => false,
        ];

        $this->load->view('hse_induction/visitor/attempt_details', $data);
    }

    /**
     * Download Attempt Evaluation Breakdown PDF
     * URL: hse_induction/visitor_registration/attempt_pdf/{attempt_id}
     */
    public function attempt_pdf($attempt_id = '')
    {
        $attempt = $this->visitor_model->get_attempt_by_id((int)$attempt_id);
        if (!$attempt) {
            show_404();
            return;
        }

        $visitor = $this->visitor_model->get_visitor_by_id($attempt->EMP_AUTO_ID);
        $answers = $this->visitor_model->get_attempt_answers($attempt->ATTEMPT_ID);

        $data = [
            'attempt' => $attempt,
            'visitor' => $visitor,
            'answers' => $answers,
        ];

        $this->load->library('pdf');
        $html = $this->load->view('hse_induction/visitor/pdf_attempt_details', $data, true);
        $mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 10, 10, 0, 0);
        $mpdf->WriteHTML($html);

        $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $visitor ? $visitor->VISITOR_NAME : 'Visitor');
        $fileName = 'HSE-VisitorAttempt-' . $attempt->ATTEMPT_NUMBER . '-' . $cleanName . '.pdf';

        if (ob_get_length()) {
            ob_end_clean();
        }
        $mpdf->Output($fileName, 'I');
    }
}

