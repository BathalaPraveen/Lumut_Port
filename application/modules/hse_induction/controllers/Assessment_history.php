<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Assessment History Controller
 * 
 * Manages permanent employee assessment attempt history, audit tracking,
 * and historical question-by-question response breakdown.
 */
class Assessment_history extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(1);
        isLogin();
        $this->load->model('hse_induction/Employee_induction_model', 'emp_induction_model');
        $this->load->model('common/common_model', 'common_model');
    }

    /**
     * History list for an employee
     */
    public function index($emp_id_enc = '')
    {
        $userinfo = $this->session->userinfo;
        $userRefId = isset($userinfo->USER_REF_ID) ? $userinfo->USER_REF_ID : 0;

        $empAutoId = !empty($emp_id_enc) ? decryptval($emp_id_enc) : $userRefId;
        if (empty($empAutoId)) {
            $empAutoId = $userRefId;
        }

        $emp = $this->db->select('em.*, FN_GET_DEPARTMENT_NAME(em.EMP_DEPT_ID) as dept_name, FN_GET_DESIGNATION_NAME(em.EMP_DESIGNATION_ID) as desig_name')
                        ->from(EMPL . ' em')
                        ->where('em.EMP_AUTO_ID', $empAutoId)
                        ->get()->row();

        if (!$emp) {
            $this->session->set_flashdata('error_msg', 'Employee not found.');
            redirect('hse_induction/employee');
        }

        $attempts = $this->emp_induction_model->get_employee_attempts($empAutoId, 2);
        $induction = $this->emp_induction_model->get_induction($empAutoId, 2);

        $data = [
            'view_file'    => 'hse_induction/employee/history_view',
            'site_title'   => 'Assessment History - ' . $emp->EMP_NAME,
            'current_menu' => 'Employee',
            'emp'          => $emp,
            'enc_id'       => encryptval($empAutoId),
            'induction'    => $induction,
            'attempts'     => $attempts,
        ];

        $this->template->load_common_template($data);
    }

    /**
     * View detailed question-by-question breakdown of a specific attempt
     */
    public function attempt_details($attempt_id = '')
    {
        $did = is_numeric($attempt_id) ? (int)$attempt_id : decryptval($attempt_id);
        $attempt = !empty($did) ? $this->emp_induction_model->get_attempt_by_id($did) : null;

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
            $this->session->set_flashdata('error_msg', 'Attempt record not found.');
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
            'enc_emp_id'   => encryptval($attempt->EMP_AUTO_ID),
        ];

        $this->template->load_common_template($data);
    }

    /**
     * Quick AJAX Modal View for attempt details
     */
    public function attempt_modal($attempt_id = '')
    {
        $did = is_numeric($attempt_id) ? $attempt_id : decryptval($attempt_id);
        $attempt = $this->emp_induction_model->get_attempt_by_id($did);
        $answers = $this->emp_induction_model->get_attempt_answers($did);

        $data = [
            'attempt' => $attempt,
            'answers' => $answers,
        ];

        $this->load->view('hse_induction/employee/attempt_modal', $data);
    }

    /**
     * Download Attempt Evaluation Breakdown PDF
     */
    public function attempt_pdf($attempt_id = '')
    {
        $did = is_numeric($attempt_id) ? (int)$attempt_id : decryptval($attempt_id);
        $attempt = !empty($did) ? $this->emp_induction_model->get_attempt_by_id($did) : null;

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
            $this->session->set_flashdata('error_msg', 'Attempt record not found.');
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
        
        $mpdf->Output($fileName, 'I');
    }
}

