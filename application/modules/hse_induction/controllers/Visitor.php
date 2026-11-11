<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Visitor HSE Induction Controller (Internal Management)
 * 
 * Manages visitor registrations inside the HSE Induction module for HSSE and Superadmin:
 * Reviewing pending visitor applications, approving/rejecting visitors, generating/resending OTPs,
 * monitoring induction completion, and viewing/downloading Port Passes and Certificates.
 */
class Visitor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        isLogin();

        $this->load->model('hse_induction/Visitor_induction_model', 'visitor_model');
        $this->load->model('email_model');
        $this->load->library(['form_validation', 'session', 'pagination']);
        $this->load->helper(['url', 'form']);
    }

    /**
     * Check if current user is Super Admin (1, 2, 'SUP') or HSSE (6, 7, HSSE dept)
     */
    private function is_superadmin_or_hsse()
    {
        $userinfo = isset($this->session->userinfo) ? $this->session->userinfo : null;
        $userTypeId = ($userinfo && isset($userinfo->USER_TYPE_ID)) ? (int)$userinfo->USER_TYPE_ID : 0;

        $allowedRoles = [1, 2, 6, 7];
        $isSuperAdmin = ($userTypeId === 1 || $userTypeId === 2 || (isset($userinfo->USER_LOG_USER_TYPE) && $userinfo->USER_LOG_USER_TYPE === 'SUP'));
        $isHsse = ($userTypeId === 6 || $userTypeId === 7 || (isset($userinfo->DEPT_NAME) && stripos($userinfo->DEPT_NAME, 'HSSE') !== false));

        return (in_array($userTypeId, $allowedRoles, true) || $isSuperAdmin || $isHsse);
    }

    /**
     * List all visitors with status, approval controls, and examination results.
     * Super Admin and HSSE roles see full visitor records.
     * All other users see an empty table like other modules.
     */
    public function index()
    {
        $canManageVisitors = $this->is_superadmin_or_hsse();

        $approvalFilter = $this->input->get('approval_status');
        $inductionFilter = $this->input->get('induction_status');
        $search = $this->input->get('search');

        $filters = [];
        if (!empty($approvalFilter)) {
            $filters['approval_status'] = $approvalFilter;
        }
        if (!empty($inductionFilter)) {
            $filters['induction_status'] = $inductionFilter;
        }
        if (!empty($search)) {
            $filters['search'] = $search;
        }

        if ($canManageVisitors) {
            $visitors = $this->visitor_model->get_all_visitors($filters);

            // Counts for dashboard summary widgets
            $allCount = count($this->visitor_model->get_all_visitors());
            $pendingCount = count($this->visitor_model->get_all_visitors(['approval_status' => 'PENDING']));
            $approvedCount = count($this->visitor_model->get_all_visitors(['approval_status' => 'APPROVED']));
            $passedCount = count($this->visitor_model->get_all_visitors(['induction_status' => 'PASSED']));
        } else {
            // Other users except Super Admin and HSSE: display empty table with zeroed counts
            $visitors = [];
            $allCount = 0;
            $pendingCount = 0;
            $approvedCount = 0;
            $passedCount = 0;
        }

        $data = [
            'view_file'         => 'hse_induction/visitor/list_visitor',
            'site_title'        => 'Visitor HSE Induction Management',
            'current_menu'      => 'Visitor',
            'visitors'          => $visitors,
            'filters'           => $filters,
            'allCount'          => $allCount,
            'pendingCount'      => $pendingCount,
            'approvedCount'     => $approvedCount,
            'passedCount'       => $passedCount,
            'canManageVisitors' => $canManageVisitors,
        ];

        $this->template->load_common_template($data);
    }

    /**
     * Approve visitor registration and dispatch OTP + assessment link
     */
    public function approve($visitor_id = 0)
    {
        if (!$this->is_superadmin_or_hsse()) {
            $this->session->set_flashdata('error_msg', 'Access Denied: Super Admin or HSSE role required.');
            redirect('hse_induction/visitor');
            return;
        }

        $visitor = $this->visitor_model->get_visitor_by_id((int)$visitor_id);
        if (!$visitor) {
            $this->session->set_flashdata('error_msg', 'Visitor record not found.');
            redirect('hse_induction/visitor');
            return;
        }

        $userinfo = $this->session->userinfo;
        $adminId = isset($userinfo->LOGIN_ID) ? $userinfo->LOGIN_ID : 1;

        $approvedVisitor = $this->visitor_model->approve_visitor($visitor->VISITOR_ID, $adminId);

        // Send Email Invitation with OTP and Link
        $this->_send_approval_email($approvedVisitor);

        $successMsg = 'Visitor <strong>' . htmlspecialchars($approvedVisitor->VISITOR_NAME) . '</strong> approved successfully! ' .
                      'Assessment link and OTP (<strong>' . $approvedVisitor->OTP_CODE . '</strong>) have been sent to ' . htmlspecialchars($approvedVisitor->EMAIL_ID) . '.';
        $this->session->set_flashdata('success_msg', $successMsg);
        redirect('hse_induction/visitor');
    }

    /**
     * Reject visitor registration (No email sent; only PDF dossier available)
     */
    public function reject($visitor_id = 0)
    {
        if (!$this->is_superadmin_or_hsse()) {
            $this->session->set_flashdata('error_msg', 'Access Denied: Super Admin or HSSE role required.');
            redirect('hse_induction/visitor');
            return;
        }

        $visitor = $this->visitor_model->get_visitor_by_id((int)$visitor_id);
        if (!$visitor) {
            $this->session->set_flashdata('error_msg', 'Visitor record not found.');
            redirect('hse_induction/visitor');
            return;
        }

        $reason = $this->input->post('rejection_reason');
        $userinfo = $this->session->userinfo;
        $adminId = isset($userinfo->LOGIN_ID) ? $userinfo->LOGIN_ID : 1;

        $this->visitor_model->reject_visitor($visitor->VISITOR_ID, $adminId, $reason);

        $this->session->set_flashdata('success_msg', 'Visitor application for <strong>' . htmlspecialchars($visitor->VISITOR_NAME) . '</strong> has been rejected.');
        redirect('hse_induction/visitor');
    }

    /**
     * Resend OTP and assessment invitation
     */
    public function resend_otp($visitor_id = 0)
    {
        if (!$this->is_superadmin_or_hsse()) {
            $this->session->set_flashdata('error_msg', 'Access Denied: Super Admin or HSSE role required.');
            redirect('hse_induction/visitor');
            return;
        }

        $visitor = $this->visitor_model->get_visitor_by_id((int)$visitor_id);
        if (!$visitor) {
            $this->session->set_flashdata('error_msg', 'Visitor record not found.');
            redirect('hse_induction/visitor');
            return;
        }

        if ($visitor->APPROVAL_STATUS != 'APPROVED') {
            $this->session->set_flashdata('error_msg', 'Cannot resend OTP. Visitor application is not in Approved status.');
            redirect('hse_induction/visitor');
            return;
        }

        $renewed = $this->visitor_model->regenerate_otp($visitor->VISITOR_ID);
        $this->_send_approval_email($renewed);

        $msg = 'New OTP (<strong>' . $renewed->OTP_CODE . '</strong>) and assessment link re-sent to ' . htmlspecialchars($renewed->EMAIL_ID) . '.';
        $this->session->set_flashdata('success_msg', $msg);
        redirect('hse_induction/visitor');
    }

    /**
     * View Pass, Certificate, and Assessment Audit Log for a visitor
     */
    public function view_pass($visitor_id = 0)
    {
        if (!$this->is_superadmin_or_hsse()) {
            $this->session->set_flashdata('error_msg', 'Access Denied: Super Admin or HSSE role required.');
            redirect('hse_induction/visitor');
            return;
        }

        $visitor = $this->visitor_model->get_visitor_by_id((int)$visitor_id);
        if (!$visitor) {
            $this->session->set_flashdata('error_msg', 'Visitor record not found.');
            redirect('hse_induction/visitor');
            return;
        }

        $attempts = $this->visitor_model->get_visitor_attempts($visitor->VISITOR_ID);

        $data = [
            'view_file'    => 'hse_induction/visitor/view_induction_pass',
            'site_title'   => 'Visitor Pass & Certificate - ' . $visitor->VISITOR_NAME,
            'current_menu' => 'Visitor',
            'visitor'      => $visitor,
            'attempts'     => $attempts,
        ];

        $this->template->load_common_template($data);
    }

    /**
     * Download Visitor Port Pass PDF Only
     */
    public function pass_pdf($visitor_id = 0)
    {
        if (!$this->is_superadmin_or_hsse()) {
            $this->session->set_flashdata('error_msg', 'Access Denied: Super Admin or HSSE role required.');
            redirect('hse_induction/visitor');
            return;
        }

        $visitor = $this->visitor_model->get_visitor_by_id((int)$visitor_id);
        if (!$visitor) {
            $this->session->set_flashdata('error_msg', 'Visitor record not found.');
            redirect('hse_induction/visitor');
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
     * Download Visitor Certificate PDF Only
     */
    public function certificate_pdf($visitor_id = 0)
    {
        if (!$this->is_superadmin_or_hsse()) {
            $this->session->set_flashdata('error_msg', 'Access Denied: Super Admin or HSSE role required.');
            redirect('hse_induction/visitor');
            return;
        }

        $visitor = $this->visitor_model->get_visitor_by_id((int)$visitor_id);
        if (!$visitor) {
            $this->session->set_flashdata('error_msg', 'Visitor record not found.');
            redirect('hse_induction/visitor');
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
     * Download Full Record / Dossier PDF
     */
    public function pdf($visitor_id = 0)
    {
        if (!$this->is_superadmin_or_hsse()) {
            $this->session->set_flashdata('error_msg', 'Access Denied: Super Admin or HSSE role required.');
            redirect('hse_induction/visitor');
            return;
        }

        $visitor = $this->visitor_model->get_visitor_by_id((int)$visitor_id);
        if (!$visitor) {
            $this->session->set_flashdata('error_msg', 'Visitor record not found.');
            redirect('hse_induction/visitor');
            return;
        }

        $attempts = $this->visitor_model->get_visitor_attempts($visitor->VISITOR_ID);

        $data = [
            'visitor'  => $visitor,
            'attempts' => $attempts,
        ];

        $this->load->library('pdf');
        $html = $this->load->view('hse_induction/visitor/pdf_visitor_pass', $data, true);
        $mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 10, 10, 0, 0);
        $mpdf->WriteHTML($html);

        $cleanReg = preg_replace('/[^a-zA-Z0-9_-]/', '_', $visitor->VISITOR_REG_NO);
        $fileName = 'HSE-VisitorRecord-' . $cleanReg . '-' . date('d-m-Y') . '.pdf';

        if (ob_get_length()) {
            ob_end_clean();
        }
        $mpdf->Output($fileName, 'I');
    }

    /**
     * View detailed question-by-question breakdown of a visitor attempt
     */
    public function attempt_details($attempt_id = 0)
    {
        $attempt = $this->visitor_model->get_attempt_by_id((int)$attempt_id);
        if (!$attempt) {
            $this->session->set_flashdata('error_msg', 'Attempt record not found.');
            redirect('hse_induction/visitor');
            return;
        }

        $visitor = $this->visitor_model->get_visitor_by_id($attempt->EMP_AUTO_ID);
        $answers = $this->visitor_model->get_attempt_answers($attempt->ATTEMPT_ID);

        $data = [
            'view_file'         => 'hse_induction/visitor/attempt_details',
            'site_title'        => 'Attempt #' . $attempt->ATTEMPT_NUMBER . ' Answers Preview - ' . $visitor->VISITOR_NAME,
            'current_menu'      => 'Visitor',
            'attempt'           => $attempt,
            'visitor'           => $visitor,
            'answers'           => $answers,
            'is_internal_admin' => true,
        ];

        $this->template->load_common_template($data);
    }

    /**
     * Download Attempt Evaluation Breakdown PDF
     */
    public function attempt_pdf($attempt_id = 0)
    {
        $attempt = $this->visitor_model->get_attempt_by_id((int)$attempt_id);
        if (!$attempt) {
            $this->session->set_flashdata('error_msg', 'Attempt record not found.');
            redirect('hse_induction/visitor');
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

    /**
     * Helper to send approval email with OTP and access link
     */
    private function _send_approval_email($visitor)
    {
        if (empty($visitor->EMAIL_ID)) {
            return;
        }

        $subject = 'Approved: Lumut Port HSE Induction Assessment Invitation & OTP [Reg: ' . $visitor->VISITOR_REG_NO . ']';
        $accessUrl = BASE_URL . 'hse_induction/visitor_registration/verify/' . $visitor->ACCESS_TOKEN;

        $msg = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden;">
            <div style="background-color: #161D26; color: #FEC001; padding: 20px; text-align: center;">
                <h2 style="margin: 0; font-size: 20px;">LUMUT MARITIME TERMINAL</h2>
                <p style="margin: 5px 0 0 0; color: #fff; font-size: 13px;">HSSE DEPARTMENT - VISITOR SAFETY CLEARANCE</p>
            </div>
            <div style="padding: 24px; color: #334155; line-height: 1.6;">
                <p>Dear <strong>' . htmlspecialchars($visitor->VISITOR_NAME) . '</strong> (' . htmlspecialchars($visitor->COMPANY_NAME) . '),</p>
                <p>Your visitor registration for Lumut Maritime Terminal premises has been <strong>APPROVED</strong> by the HSSE Department.</p>
                <p>Prior to terminal entry, you are required to complete the mandatory online <strong>HSE Induction Briefing and Assessment</strong>.</p>
                
                <div style="background-color: #f8fafc; border: 2px dashed #0284c7; border-radius: 8px; padding: 18px; margin: 20px 0; text-align: center;">
                    <span style="font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">Your Assessment One-Time Password (OTP)</span>
                    <div style="font-size: 32px; font-weight: bold; color: #0284c7; letter-spacing: 6px; margin: 8px 0; font-family: monospace;">' . $visitor->OTP_CODE . '</div>
                    <span style="font-size: 11px; color: #dc2626;">Valid for 7 days. Do not share this OTP with others.</span>
                </div>

                <div style="text-align: center; margin: 25px 0;">
                    <a href="' . $accessUrl . '" style="background-color: #0284c7; color: #ffffff; padding: 14px 28px; text-decoration: none; font-weight: bold; border-radius: 6px; display: inline-block; font-size: 15px;">
                        Start HSE Induction Assessment &rarr;
                    </a>
                </div>

                <div style="background-color: #f1f5f9; border-radius: 6px; padding: 12px 16px; margin: 20px 0; font-size: 12.5px;">
                    <strong>Visit Schedule Details:</strong>
                    <ul style="margin: 6px 0 0 16px; padding: 0;">
                        <li><strong>Registration No:</strong> ' . htmlspecialchars($visitor->VISITOR_REG_NO) . '</li>
                        <li><strong>Terminal:</strong> ' . (!empty($visitor->TERMINAL_NAME) ? htmlspecialchars($visitor->TERMINAL_NAME) : 'Lumut Port') . '</li>
                        <li><strong>Scheduled Visit:</strong> ' . date('d-m-Y H:i', strtotime($visitor->VISIT_DATETIME)) . '</li>
                        <li><strong>Contact Person (LMTSB):</strong> ' . (!empty($visitor->PIC_EMP_NAME) ? htmlspecialchars($visitor->PIC_EMP_NAME) : (!empty($visitor->CONTACT_PERSON_NAME) ? htmlspecialchars($visitor->CONTACT_PERSON_NAME) : '-')) . '</li>
                    </ul>
                </div>

                <p style="font-size: 12px; color: #64748b;">
                    <strong>Mandatory Requirements:</strong> You must view the entire HSE Induction briefing material and achieve a <strong>100% score</strong> on the assessment exam to generate your official Port Pass.
                </p>
            </div>
            <div style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px; text-align: center; font-size: 11px; color: #94a3b8;">
                &copy; ' . date('Y') . ' Lumut Maritime Terminal Sdn Bhd. All rights reserved.
            </div>
        </div>';

        $this->email_model->sendEmail($visitor->EMAIL_ID, $subject, $msg, "");
    }
}

