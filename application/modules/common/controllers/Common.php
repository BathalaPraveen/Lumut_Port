<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

    public function index() {

        $this->load->view('login/login_form/add_login_form');
    }

    public function getAjaxDepartment(){
        $terminalID = $this->input->post('terminalID');

        $options['where'] = [
            'DEPT_STATUS' => 'Y',
            'FK_TERMINAL_ID' => $terminalID,
        ];
        $getDeptnames = $this->common_model->getAlldata(DEPT, ['*'], $options);

        $deptdatas = '<option value="">Select Department</option>';

        if ($getDeptnames) {

            foreach ($getDeptnames as $cKey => $cVal) {
                $deptdatas .= '<option value="' . $cVal->DEPT_AUTO_ID . '">' . $cVal->DEPT_NAME . '</option>';
//        print_r($statedatas);
            }
            $returnData = [
                'status' => true,
                'deptdatas' => $deptdatas,
            ];
        } else {
            $returnData = [
                'status' => false,
                'deptdatas' => $deptdatas,
            ];
        }
        echo json_encode($returnData);
    }
    public function getAjaxLocation(){
        $terminalID = $this->input->post('terminalID');
        $multiple = $this->input->post('multiple');
//        $loctId = $this->input->post('loctId');

        $options['where'] = [
            'SPECIFIC_LOC_STATUS' => 'Y',
            'FK_TERMINAL_ID' => $terminalID,
        ];
        $getLoctnames = $this->common_model->getAlldata(SPEC_LOC, ['*'], $options);

       if($multiple){
           $loctdatas = '';
       }else{
           $loctdatas = '<option>Select Location</option>';
       }
        

        if ($getLoctnames) {

            foreach ($getLoctnames as $cKey => $cVal) {
               
                $loctdatas .= '<option value="' . $cVal->SL_AUTO_ID . '" >' . $cVal->SPECIFIC_LOC_NAME . '</option>';
//        print_r($statedatas);
            }
            $loctdatas .= '<option value="-1">Others</option>';
            $returnData = [
                'status' => true,
                'loctdatas' => $loctdatas,
            ];
        } else {
            $loctdatas .= '<option value="-1">Others</option>';
            $returnData = [
                'status' => false,
                'loctdatas' => $loctdatas,
            ];
        }
        echo json_encode($returnData);
    }
   
    
}
