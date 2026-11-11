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
}
