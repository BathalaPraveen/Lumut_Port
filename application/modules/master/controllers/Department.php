<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(1);
        isLogin();
        $this->load->model('common/common_model');
    }
    
    public function department(){
        
        $data = array(
            'view_file' => 'department/list_department',
            'site_title' => 'Department ',
            'current_menu' => 'List Department ',
            'ajaxurl' => 'master/department/list_department',
        );

        $this->template->load_table_template($data);
    }
    
    public function list_department(){
        $table = DEPT.' as dept';
        $column_order = array(null, 'DEPT_ID', 'TERMINAL_NAME','DEPT_NAME', 'DEPT_EMAIL_ID', null);
        $column_search = array('DEPT_ID', 'TERMINAL_NAME','DEPT_NAME', 'DEPT_EMAIL_ID');
        $order = array('dept.CREATED_ON' => 'desc');
        $where = ['DEPT_STATUS' => 'Y'];
        $optns['join'][TERM.' as term'] = ['term.TER_AUTO_ID = dept.FK_TERMINAL_ID','left'];
        
        $listDept = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where,$optns);
//echo "<pre>";
//echo $this->db->last_query();
        $finalDatas = [];
        if (isset($listDept) && !empty($listDept)) {
            foreach ($listDept as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->DEPT_AUTO_ID;

                $action .= " " . anchor('master/department/addDepartment/' . encryptval($id), '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));

                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteDepartment', 'title' => 'Delete', 'delt-id' => $id));
                //$action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

                $rows = [];
//            $rows[] = $ltVal->USER_ROLE_ID;
                $rows[] = $ltVal->DEPT_ID;
                $rows[] = $ltVal->TERMINAL_NAME;
                $rows[] = $ltVal->DEPT_NAME;
                $rows[] = $ltVal->DEPT_EMAIL_ID;
                $rows[] = $action;
                $finalDatas[] = $rows;
            }
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->common_model->count_all($table, $column_order, $column_search, $order, $where),
            "recordsFiltered" => $this->common_model->count_filtered($table, $column_order, $column_search, $order, $where),
            "data" => $finalDatas,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function addDepartment($id=""){
        
        $did = decryptval($id);
        $uniqDeptwhr = [];
        if ($id != '') {
            $uniqDeptwhr = [
                'DEPT_ID' => $did
            ];
        }

        $deptUniq = uniqueIntRefId('DEPT', DEPT, 'DEPT_AUTO_ID', 'DEPT_AUTO_ID', $uniqDeptwhr);
        
        $termOptn['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $getAllterminal = $this->common_model->getAlldata(TERM, ['*'], $termOptn);
        $dropTermname = customFormDropDown($getAllterminal, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');

        $getDeptoptn['where'] = [
            'DEPT_AUTO_ID' => $did
        ]; 
        $getDeptoptn['return_type'] = 'row';
        $getAlldeptDatas = $this->common_model->getAlldata(DEPT,['*'],$getDeptoptn);
         $data = array(
            'view_file' => 'department/add_department',
            'current_menu' => 'Add Department ',
             'deptUniq' => $deptUniq,
             'dropTermname' => $dropTermname,
             'getAlldeptDatas' => $getAlldeptDatas,
           
        );
        $this->template->load_common_template($data);
    }
    
    public function insertDepartment($id=""){
        $this->form_validation->set_rules('dept[term_name]', 'Terminal Name', 'required|trim');
        $this->form_validation->set_rules('dept[dept_name]', 'DepartmentName', 'required|min_length[2]|max_length[50]|alpha_dash_space|trim');
        $deptDatas = $this->input->post('dept');
       
        if ($this->form_validation->run() == true) {
            
            $did = decryptval($id);
            $insertDeptdatas = [
//                'DEPT_ID' => postData($deptDatas,'dept_uniqid'),
                'FK_TERMINAL_ID' => postData($deptDatas,'term_name'),
                'DEPT_NAME' => postData($deptDatas,'dept_name'),
                'DEPT_EMAIL_ID' => postData($deptDatas,'mail_id'),
                'DEPT_DESC' => postData($deptDatas,'dept_desc'),
            ];
            if($did != ''){
               $updtDept = $this->common_model->updateData(DEPT,$insertDeptdatas,['DEPT_AUTO_ID' => $did]);
            }else{
                $insertDeptdatas['DEPT_ID'] = postData($deptDatas,'dept_uniqid');
               $updtDept = $this->common_model->updateData(DEPT,$insertDeptdatas);
            }
            
            if ($updtDept) {
               
                if ($did != '') {
                    $data['flasmsg'] = $this->session->set_flashdata('department', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Department has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('department', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Department has been Created</div>');
                }
                redirect('master/department/department');
            } else {
                
                if ($did != '') {
                    $data['flasmsg'] = $this->session->set_flashdata('department', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Sorry!</span> Department cannot be Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('department', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Sorry!</span> Department cannot be Created</div>');
                }
                redirect('master/department/department');
            }  
             
        }else{
            $this->addDepartment($id);
        }
    }
    public function deleteDepartment($id=""){
         $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(DEPT, ['DEPT_STATUS' => 'N'], ['DEPT_AUTO_ID' => $deleteId]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Department deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Department'
            ];
        }
        echo json_encode($retData);
    }
    
}