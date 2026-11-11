<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Training_model extends CI_Model
{

    public function __construct()
    {
        $this->load->model('common/common_model', 'common');
        parent::__construct();
    }


    public function getrcategory_project($type)
    {
        $this->db->select('id,topic');
        $this->db->where('topic_status', 'Y');
        $this->db->where('fk_type_id', $type);
        return $this->db->get(TRM_TOPIC_MAS)->result_array();
    }

    public function getUseeImageBefore_project($did = '')
    {
        $where = [
            'FK_OBS_MAIN_ID' => $did,
            'OBS_FILE_TYPE' => 1,
            'OBS_ATTACH_STATUS' => 'Y'
        ];
        $option['where'] = $where;
        $option['return_type'] = 'result';
        return $details = $this->common->getAlldata(OBS_IMG_SEE, ['*'], $option);
    }



    public function getUseeactImageAfter_project($did = '', $obs_assigner_id)
    {
        $where = [
            'fk_obs_main_id' => $did,
            'obs_file_type' => '3',
            'obs_attach_status' => 'Y'
        ];
        if ($obs_assigner_id) {
            $where['obs_assigner_id'] = $obs_assigner_id;
        }
        $option['where'] = $where;
        $option['return_type'] = 'result';
        return $details = $this->common->getAlldata(OBS_IMG_SEE, ['*'], $option);
    }

    public function getUseeDetails_project($where, $type, $option = [])
    {
        $option['where'] = $where;
        $option['return_type'] = $type;
        $option['join'] = [

            LOGIN . ' AS LD' => ['LD.LOGIN_ID = ' . TRM_FLOW_SEE . '.TR_reporter_id', 'LEFT'],
            EMPL . ' AS Reporter' => ['Reporter.EMP_AUTO_ID = LD.USER_REF_ID', 'LEFT'],

            TRM_TYPE_MAS . ' AS TM' => ['TM.id = ' . TRM_FLOW_SEE . ' .tr_type_id', 'LEFT'],
            // TRM_CAT_MAS . ' AS TC' => ['TC.id = ' . TRM_FLOW_SEE . ' .tr_cat_id', 'LEFT'],

            // 'LOGIN_DETAILS AS LD4'=>['LD4.LOGIN_ID = '.OBS_FLOW.'.obs_assigner_id','LEFT'],
            // 'CONTRACTOR_DETAILS AS Hodcon'=>['Hodcon.CONT_AUTO_ID = LD4.USER_REF_ID','LEFT'],


            // 'LOGIN_DETAILS AS LD3'=>['LD3.LOGIN_ID = '.OBS_FLOW.'.obs_reporter_id','LEFT'],
            // 'CONTRACTOR_DETAILS AS Contractor'=>['Contractor.CONT_AUTO_ID = LD3.USER_REF_ID','LEFT'],

        ];
        $aOption = $option + $option;

        return $details = $this->common->getAlldata(TRM_FLOW_SEE, [
            '*',
            'Reporter.EMP_NAME` as Reporter',
            'FN_COMP_NAME(tr_comp_id) as comp_name',
            'FN_AREA_NAME(tr_area_id) as area_name',
            'FN_BUILD_NAME(tr_building_id) as building_name',
            'FN_GET_DEPARTMENT_NAME(tr_dept_id) as dep_name',
            'FN_PROJECT_NAME_MULTI(tr_project_id) as proj_name',
            'Reporter.EMP_NAME as empName',
            'FN_GET_DESIGNATION_NAME(tr_reporter_desg_id) as desig',
            'TM.type as tr_type_name',
            // 'TC.category as tr_cat_name'
        ], $aOption);
    }

    public function getEmpUseeDetails_project($where, $type, $option = [])
    {
        $option['where'] = $where;
        $option['return_type'] = $type;
        $option['join'] = [

            LOGIN . ' AS LD' => ['LD.LOGIN_ID = ' . TRM_EMP_FLOW_SEE . '.tr_reporter_id', 'LEFT'],
            EMPL . ' AS Reporter' => ['Reporter.EMP_AUTO_ID = LD.USER_REF_ID', 'LEFT'],

            // TRM_TYPE_MAS . ' AS TM' => ['TM.id = ' . TRM_FLOW_SEE . ' .tr_type_id', 'LEFT'],
            // TRM_CAT_MAS . ' AS TC' => ['TC.id = ' . TRM_FLOW_SEE . ' .tr_cat_id', 'LEFT'],

            // 'LOGIN_DETAILS AS LD4'=>['LD4.LOGIN_ID = '.OBS_FLOW.'.obs_assigner_id','LEFT'],
            // 'CONTRACTOR_DETAILS AS Hodcon'=>['Hodcon.CONT_AUTO_ID = LD4.USER_REF_ID','LEFT'],


            // 'LOGIN_DETAILS AS LD3'=>['LD3.LOGIN_ID = '.OBS_FLOW.'.obs_reporter_id','LEFT'],
            // 'CONTRACTOR_DETAILS AS Contractor'=>['Contractor.CONT_AUTO_ID = LD3.USER_REF_ID','LEFT'],

        ];
        $aOption = $option + $option;

        return $details = $this->common->getAlldata(TRM_EMP_FLOW_SEE, [
            '*',
            'Reporter.EMP_NAME` as Reporter',
            'FN_COMP_NAME(tr_comp_id) as comp_name',
            'FN_AREA_NAME(tr_area_id) as area_name',
            'FN_BUILD_NAME(tr_building_id) as building_name',
            'FN_GET_DEPARTMENT_NAME(tr_dept_id) as dep_name',
            'FN_PROJECT_NAME_MULTI(tr_project_id) as proj_name',
            'Reporter.EMP_NAME as empName',
            'FN_GET_DESIGNATION_NAME(tr_reporter_desg_id) as desig',
         
        ], $aOption);
    }







    public function UpdateFeedback($data)
    {
        if ($data['id'] != '') {
            $this->db->where('id', $data['id']);
            $this->db->update(TRM_FB_FORM, $data);
        } else {

            $this->db->insert(TRM_FB_FORM, $data);
        }
    }

    /* ==============================================================
     * HSE EMPLOYEE INDUCTION METHODS
     * ============================================================== */

    public function get_employee_induction($emp_auto_id, $type_id = 2)
    {
        $this->db->where('EMP_AUTO_ID', $emp_auto_id);
        $this->db->where('TYPE_ID', $type_id);
        $this->db->where('STATUS', 'Y');
        return $this->db->get(HSE_EMP_INDUCTION)->row();
    }

    public function get_or_create_employee_induction($emp_auto_id, $login_id = null, $type_id = 2)
    {
        $existing = $this->get_employee_induction($emp_auto_id, $type_id);
        if ($existing) {
            return $existing;
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

    public function get_training_material($type_id = 2)
    {
        // 1. Try matching by type id
        $this->db->where('type', $type_id);
        $this->db->where('file_status', 'Y');
        $this->db->order_by('id', 'desc');
        $file = $this->db->get(TRM_UPLOAD_MAS)->row();
        if ($file) {
            return $file;
        }

        // 2. Try matching by type name (e.g. 'Employee')
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

        // 3. Fallback to latest active upload
        $this->db->where('file_status', 'Y');
        $this->db->order_by('id', 'desc');
        return $this->db->get(TRM_UPLOAD_MAS)->row();
    }

    public function get_assessment_questions($type_id = 2)
    {
        // 1. Try matching by type id
        $this->db->where('type', $type_id);
        $this->db->where('question_status', 'Y');
        $this->db->order_by('id', 'asc');
        $questions = $this->db->get(TRM_ASS_MAS)->result();
        if (!empty($questions)) {
            return $questions;
        }

        // 2. Try matching by type name
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

    public function update_video_progress($emp_auto_id, $type_id = 2, $status = 'COMPLETED', $seconds = 0)
    {
        $this->db->where('EMP_AUTO_ID', $emp_auto_id);
        $this->db->where('TYPE_ID', $type_id);
        $this->db->update(HSE_EMP_INDUCTION, [
            'VIDEO_STATUS'          => $status,
            'VIDEO_WATCHED_SECONDS' => $seconds,
            'INDUCTION_STATUS'      => ($status == 'COMPLETED') ? 'IN_PROGRESS' : 'NOT_STARTED',
            'UPDATED_ON'            => date('Y-m-d H:i:s')
        ]);
        return true;
    }

    public function record_induction_attempt($emp_auto_id, $type_id, $total, $correct, $score, $passed, $answers = array(), $cert_no = null, $qr_path = null)
    {
        $current = $this->get_or_create_employee_induction($emp_auto_id, null, $type_id);
        $attempt_no = ($current && $current->ATTEMPTS) ? ((int)$current->ATTEMPTS + 1) : 1;

        $updateData = [
            'TOTAL_QUESTIONS'   => $total,
            'CORRECT_ANSWERS'   => $correct,
            'WRONG_ANSWERS'     => ($total - $correct),
            'SCORE_PERCENTAGE'  => $score,
            'ATTEMPTS'          => $attempt_no,
            'INDUCTION_STATUS'  => $passed ? 'PASSED' : 'FAILED',
            'LAST_ATTEMPT_DATE' => date('Y-m-d H:i:s'),
            'UPDATED_ON'        => date('Y-m-d H:i:s')
        ];

        if ($passed) {
            $updateData['CERTIFICATE_NO'] = $cert_no;
            $updateData['QR_CODE_PATH']   = $qr_path;
            $updateData['PASSED_DATE']     = date('Y-m-d H:i:s');
            $updateData['VALIDITY_DATE']   = date('Y-m-d', strtotime('+1 year'));
        }

        $this->db->where('EMP_AUTO_ID', $emp_auto_id);
        $this->db->where('TYPE_ID', $type_id);
        $this->db->update(HSE_EMP_INDUCTION, $updateData);

        // Record in log table
        $logData = [
            'INDUCTION_ID'      => $current ? $current->ID : 0,
            'EMP_AUTO_ID'       => $emp_auto_id,
            'TYPE_ID'           => $type_id,
            'ATTEMPT_NO'        => $attempt_no,
            'TOTAL_QUESTIONS'   => $total,
            'CORRECT_ANSWERS'   => $correct,
            'WRONG_ANSWERS'     => ($total - $correct),
            'SCORE_PERCENTAGE'  => $score,
            'RESULT_STATUS'     => $passed ? 'PASSED' : 'FAILED',
            'SUBMITTED_ANSWERS' => !empty($answers) ? json_encode($answers) : null,
            'CREATED_ON'        => date('Y-m-d H:i:s')
        ];
        $this->db->insert(HSE_EMP_INDUCTION_LOG, $logData);

        return $this->get_employee_induction($emp_auto_id, $type_id);
    }

    public function reset_induction($emp_auto_id, $type_id = 2)
    {
        $this->db->where('EMP_AUTO_ID', $emp_auto_id);
        $this->db->where('TYPE_ID', $type_id);
        $this->db->update(HSE_EMP_INDUCTION, [
            'VIDEO_STATUS'          => 'NOT_WATCHED',
            'VIDEO_WATCHED_SECONDS' => 0,
            'INDUCTION_STATUS'      => 'NOT_STARTED',
            'UPDATED_ON'            => date('Y-m-d H:i:s')
        ]);
        return true;
    }
}
