<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hirarc extends CI_Controller {

    function __construct() {
        parent::__construct();
        isLogin();
        $this->load->helper('hirarc_helper');
        global $status_drop;
        global $hirarcPermission;
        global $legalDatas;
        global $statusDatas;
        global $RecoCntrlDatas;
        $statusDatas = [
            '' => 'Select Status',
            '1' => 'Open',
            '2' => 'Close'
        ];
        $RecoCntrlDatas = [
            '' => 'Select Recommended Control/Opportunities',
            '1' => ' N/A',
            '2' => 'Yes'
        ];
        $legalDatas = [
            '1' => 'OSHA 1994',
            '2' => 'FMA 1967',
            '3' => 'EQA 1974',
            '4' => 'N/A'
        ];
        $status_drop = [
            '' => 'Select Status',
            '1' => 'HIRARC Task Completed',
            '2' => 'HOD Approval Pending',
            '3' => 'HOD Approved',
            '4' => 'HIRARC Completed',
            '-3' => 'HOD Rejected',
            '-4' => 'HSSE Rejected',
        ];
        $hirarcPermission = [
            'approve' => [6, 7],
            'view' => [4, 5, 6, 7, 8, 9],
            'add' => [4]
        ];
    }

    //// port start
    public function index() {
//        echo '<pre>';
//        print_r($_SESSION);exit;
        $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');
        $status = $this->input->post('status');
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');

        global $status_drop;
        global $hirarcPermission;
        $data = array(
            'view_file' => 'hirarc/flow/list_form',
            'site_title' => 'HIRARC',
            'current_menu' => 'List HIRARC',
            // 'ajaxurl' => 'hirarc/hirarc/list_hirarc?status=' . $status,
            'ajaxurl' => 'hirarc/hirarc/list_hirarc?status=' . $status .'&terminal='.$terminal.'&year='.$year.'&from_date='.$from_date.'&to_date='.$to_date,
            'status' => $status,
            'status_drop' => $status_drop,
            'hirarcPermission' => $hirarcPermission
        );

        $this->template->load_table_template($data);
    }

    public function list_hirarc() {
        global $hirarcPermission;
        $user_type = getCurrentUserGroupId();
//        echo '<pre>';
//        print_r($user_type);
//        exit;
       $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');
        $st = $this->input->get('status');
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $where = ['h.HIRARC_STATUS' => 'Y'];
        if (!is_admin() && getCurrentUserGroupId() == $hirarcPermission['add'][0]) {
            $where['h.CREATED_BY'] = $_SESSION['userinfo']->LOGIN_ID;
        }
        if (!is_admin() && getCurrentUserGroupId() == '5') {
            $where['h.HOD_ID'] = $_SESSION['userinfo']->LOGIN_ID;
        }
        if ($st != '') {
            $where['h.HIRARC_FLOW_STATUS'] = $st;
        }
         if($terminal != ''){
             $where['h.FK_TERMINAL_ID'] = $terminal;
        }
       if($year != ''){
           $where['YEAR(h.CREATED_ON)'] = $year;
        }

        if (!empty($from_date)) {
            $where['DATE(h.CREATED_ON) >='] = $from_date;
        }

        if (!empty($to_date)) {
            $where['DATE(h.CREATED_ON) <='] = $to_date;
        }
        $table = HIR_MAIN . ' as h';
        $column_order = array('HIRARC_ID', 'FK_TERMINAL_ID', 'FK_DEPT_ID', 'HIRARC_FLOW_STATUS', 'HIRARC_STATUS', null);
        $column_search = array('HIRARC_ID', 'FK_TERMINAL_ID', 'FK_DEPT_ID', 'HIRARC_FLOW_STATUS', 'HIRARC_STATUS');
        $order = array('h.MAIN_AUTO_ID' => 'desc');
        $optns['select'] = 'h.*,t.TERMINAL_NAME,d.DEPT_NAME';
        $optns['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = h.FK_TERMINAL_ID', 'left'];
        $optns['join'][DEPT . ' as d'] = ['d.DEPT_AUTO_ID = h.FK_DEPT_ID', 'left'];
        $listResp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $optns);
//        echo $this->db->last_query();exit; 
//        echo '<pre>';
//        print_r($listResp);
//       exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listResp) && !empty($listResp)) {
            foreach ($listResp as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->MAIN_AUTO_ID);
                if (in_array($user_type, $hirarcPermission['add']) && ($ltVal->HIRARC_FLOW_STATUS == '-4' && $ltVal->IS_REJECTED == 2)) {
                    $action .= " " . anchor('hirarc/hirarc/add_hirarc/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));
                }
                
                if (in_array($user_type, $hirarcPermission['add']) && ($ltVal->HIRARC_FLOW_STATUS == 1 && $ltVal->IS_REJECTED == 2)) {
                    $action .= " " . anchor('hirarc/hirarc/add_exce/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));
                } elseif (in_array($user_type, $hirarcPermission['add']) && ($ltVal->HIRARC_FLOW_STATUS == 1)) {
                    $action .= " " . anchor('hirarc/hirarc/add_exce/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));
                }
                
                $action .= " " . anchor('hirarc/hirarc/view_report/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'View'));
                $action .= " " . anchor('hirarc/hirarc/pdf_report/' . $id, '<i class="fas fa-file-pdf"></i>', array('class' => '', 'title' => 'View', 'target' => '_blank'));
                $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deletepsa', 'title' => 'Delete', 'delt-id' => $id));
//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";
                if ($ltVal->HIRARC_FLOW_STATUS == '1') {
                    $hirarc_st = '<label class="btn btn-xs btn-primary">HIRARC Task Completed</label>';
                    $task_st = '<label class="btn btn-xs btn-primary"> Task Pending</label>';
                } elseif ($ltVal->HIRARC_FLOW_STATUS == '2') {
                    $hirarc_st = '<label class="btn btn-xs btn-primary">HOD Approval Pending</label>';
                    $task_st = '<label class="btn btn-xs btn-primary"> Task Pending</label>';
                } elseif ($ltVal->HIRARC_FLOW_STATUS == '3') {
                    $hirarc_st = '<label class="btn btn-xs btn-primary">HOD Approved</label>';
                    $task_st = '<label class="btn btn-xs btn-primary"> Task Approved</label>';
                } elseif ($ltVal->HIRARC_FLOW_STATUS == '4') {
                    $hirarc_st = '<label class="btn btn-xs btn-primary">HIRARC Completed</label>';
                    $task_st = '<label class="btn btn-xs btn-primary"> Task Approved</label>';
                } elseif ($ltVal->HIRARC_FLOW_STATUS == '-3') {
                    $hirarc_st = '<label class="btn btn-xs btn-warning">HOD Rejected</label>';
                    $task_st = '<label class="btn btn-xs btn-warning"> Task Close</label>';
                } elseif ($ltVal->HIRARC_FLOW_STATUS == '-4') {
                    $hirarc_st = '<label class="btn btn-xs btn-warning">HSSE Rejected</label>';
                    $task_st = '<label class="btn btn-xs btn-warning"> Task Close</label>';
                }
                $rows = [];
                $rows[] = ucfirst($ltVal->HIRARC_ID);
                $rows[] = ucfirst($ltVal->DEPT_NAME);
                $rows[] = ucfirst($ltVal->TERMINAL_NAME);
                $rows[] = ucfirst($ltVal->PRO_ACT_LOC);
                $rows[] = $task_st;
                $rows[] = $hirarc_st;
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

    public function add_hirarc($id = '') {
        $did = decryptval($id);
        $gethirarcdatas = [];
        $getterminalNamedatas = [];
        $getCompanyNamedatas = [];
        $getDeptNamedatas = [];
        $getProcessNamedatas = [];

        if ($id != '') {
            $optWhr['where'] = [
                'MAIN_AUTO_ID' => $did,
                'HIRARC_STATUS' => 'Y'
            ];
            $optWhr['return_type'] = 'row';
            $gethirarcdatas = $this->common_model->getAlldata(HIR_MAIN, ['*'], $optWhr);
        }
        $terminWhere['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $terNamedatas = $this->common_model->getAlldata(TERM, ['*'], $terminWhere);
        if (is_array($terNamedatas)) {
            $getterminalNamedatas = customFormDropDown($terNamedatas, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');
        }
        $companyinWhere['where'] = [
            'COM_STATUS' => 'Y'
        ];
        $CompanyNamedatas = $this->common_model->getAlldata(HIR_COM, ['*'], $companyinWhere);
        if (is_array($CompanyNamedatas)) {
            $getCompanyNamedatas = customFormDropDown($CompanyNamedatas, 'COM_AUTO_ID', 'COM_NAME', 'Select Company Name');
        }
        $deptinWhere['where'] = [
            'DEPT_STATUS' => 'Y'
        ];
        $deptNamedatas = $this->common_model->getAlldata(DEPT, ['*'], $deptinWhere);
        if (is_array($deptNamedatas)) {
            $getDeptNamedatas = customFormDropDown($deptNamedatas, 'DEPT_AUTO_ID', 'DEPT_NAME', 'Select Department Name');
        }
        $deptinWhere['where'] = [
            'PRO_STATUS' => 'Y'
        ];
        $processNamedatas = $this->common_model->getAlldata(PRO_ACT_AREA, ['*'], $deptinWhere);

        if (is_array($processNamedatas)) {
            $getProcessNamedatas = customFormDropDown($processNamedatas, 'PRO_AUTO_ID', 'PRO_NAME', 'Select Process/Location/Activity  Name');
        }
        $empList = getUnitHeadIdetails('drop');
        $data = array(
            'view_file' => 'hirarc/flow/add_form',
            'current_menu' => 'Add Hirarc ',
            'gethirarcdatas' => $gethirarcdatas,
            'empList' => $empList,
            'geterminalNamedatas' => $getterminalNamedatas,
            'getCompanyNamedatas' => $getCompanyNamedatas,
            'getDeptNamedatas' => $getDeptNamedatas,
            'getProcessNamedatas' => $getProcessNamedatas,
        );
        $this->template->load_common_template($data);
    }

    public function save_hirarc($id = '') {

        $did = decryptval($id);
        $company_Id = $this->input->post('company_Id');
        $other = $this->input->post('other');
        $TER_ID = $this->input->post('Ter_ID');
        $dept_Id = $this->input->post('dept_Id');
        $pro_name = $this->input->post('pro_name');
        $hod_Id = $this->input->post('emp_Id');
        $this->form_validation->set_rules('company_Id', 'Company name', 'required|trim');
        $this->form_validation->set_rules('Ter_ID', 'Terminal', 'required|trim');
        $this->form_validation->set_rules('other', 'Other', 'trim|alpha_dash_space|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('dept_Id', 'Department Name', 'required|trim');
        $this->form_validation->set_rules('pro_name', 'Process/Location/Activity', 'required|trim');
        $this->form_validation->set_rules('emp_Id', 'Employee', 'required|trim');
//        print_r($exitDatas);
        $key_name = 'HIRARC';
        if ($TER_ID == '1') {
            $ter_name = 'LMT';
        } elseif ($TER_ID == '2') {
            $ter_name = 'LBT';
        } else {
            $ter_name = 'LMT2';
        }
        $dept_name = '';
        $deptinWhere['where'] = [
            'DEPT_STATUS' => 'Y'
        ];
        if ($dept_Id != '') {
            $deptinWhere['where']['DEPT_AUTO_ID'] = $dept_Id;
        }
        $deptNamedatas = $this->common_model->getAlldata(DEPT, ['DEPT_NAME'], $deptinWhere);

        if ($deptNamedatas != '') {
            $dept_name = mb_substr(strtoupper($deptNamedatas[0]->DEPT_NAME), '0', '4');
        }
        $getUniqueId = GetUniqueIdSequ($key_name, $ter_name, $dept_name, $dept_Id, $did);
        if ($this->form_validation->run()) {
            $hazadatas = [
                'HIRARC_ID' => $getUniqueId,
                'FK_COMP_ID' => $company_Id,
                'OTH_COMP_NAME' => $other,
                'FK_TERMINAL_ID' => $TER_ID,
                'FK_DEPT_ID' => $dept_Id,
                'PRO_ACT_LOC' => $pro_name,
                'HOD_ID' => $hod_Id,
                'HIRARC_FLOW_STATUS' => 1,
                'CREATED_BY' => $_SESSION['userinfo']->LOGIN_ID,
                'CREATED_DATE' => date('Y-m-d')
            ];
            if ($did != '') {
                $upWhere = [
                    'MAIN_AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(HIR_MAIN, $hazadatas, $upWhere);
            } else {
                $updtProfile = $this->common_model->updateData(HIR_MAIN, $hazadatas);
            }
            if ($updtProfile && $updtProfile > 0) {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HIRARC has been Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HIRARC has been Created</div>');
                }
                redirect((decryptval($id) != '' && decryptval($id) != '0') ? 'hirarc/add_exce/' . $id : 'hirarc/add_exce/' . encryptval($updtProfile));
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HIRARC cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HIRARC cannot be Created</div>');
                }
                redirect('hirarc/hirarc');
            }
        } else {
            $this->add_hirarc($id);
        }
    }

    public function view_report($id = '') {
//        echo '<pre>';
//        print_r($this->session);
//        exit;
        $currnt_user_login_Id = $this->session->id;
        $did = decryptval($id);
        $hir_details = [];
        $hir_flow_details = [];
        if ($id != '') {
            $tab = HIR_MAIN . ' as h';
            $select = ['h.MAIN_AUTO_ID,h.HIRARC_ID,t.TERMINAL_NAME,d.DEPT_NAME,h.PRO_ACT_LOC,c.COM_NAME,e.EMP_NAME,h.HOD_ID,h.OTH_COMP_NAME,h.CREATED_BY,h.HIRARC_FLOW_STATUS,h.HSSE_REJ_RES'];
            $options['join'][HIR_COM . ' as c'] = ['c.COM_AUTO_ID = h.FK_COMP_ID', 'left'];
            $options['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = h.FK_TERMINAL_ID', 'left'];
            $options['join'][DEPT . ' as d'] = ['d.DEPT_AUTO_ID = h.FK_DEPT_ID', 'left'];
            $options['join'][LOGIN . ' as l'] = ['l.LOGIN_ID = h.HOD_ID', 'left'];
            $options['join'][EMPL . ' as e'] = ['e.EMP_AUTO_ID = l.USER_REF_ID', 'left'];
//            $options['join'][PRO_ACT_AREA . ' as p'] = ['p.PRO_AUTO_ID = h.PRO_ACT_LOC', 'left'];
            $options['return_type'] = 'row';
            $options['where'] = [
                'MAIN_AUTO_ID' => $did,
                'HIRARC_STATUS' => 'Y'
            ];
            $hir_details = $this->common_model->getAlldata($tab, $select, $options);
            $table = HIR_RISK . ' as r';
            $selects = ['r.*,h.HAZ_TYPE_NAME'];
            $option['join'][HAZA_TYPE . ' as h'] = ['h.HAZ_TYPE_AUTO_ID = r.FK_HAZ_TYPE_ID', 'left'];
            $option['return_type'] = 'result';
            $option['group_by'] = ['r.RP_AUTO_ID'];
            $option['where'] = [
                'r.FK_HIRARC_MAIN_ID' => $did,
                'r.RISK_PRO_STATUS' => 'Y'
            ];
            $hir_flow_details = $this->common_model->getAlldata($table, $selects, $option);
//            echo $this->db->last_query();exit;
        }
        global $legalDatas;
        global $statusDatas;
        $data = array(
            'view_file' => 'hirarc/flow/view_report',
            'current_menu' => 'View HIRARC Report ',
            'hir_details' => $hir_details,
            'hir_flow_details' => $hir_flow_details,
            'currnt_user_login_Id' => $currnt_user_login_Id,
            'legalDatas' => $legalDatas,
            'statusDatas' => $statusDatas
        );
        $this->template->load_common_template($data);
    }

    public function update_status($id = '') {
        $status_val = $this->input->post('hod_app');
        $hsse_rej = $this->input->post('hsse_rej');
        $did = decryptval($id);
        switch ($status_val) {
            case 1:
                $status = 3;
                $data = [
                    'HOD_DATE' => converttoDBDate(date('d-m-Y H:i:s'), 'Y-m-d H:i:s')
                ];
                $msg = 'HIRARC has been Approved';
                break;
            case 2:
                $status = -3;
                $data = [
                    'HOD_DATE' => converttoDBDate(date('d-m-Y H:i:s'), 'Y-m-d H:i:s')
                ];
                $msg = 'HIRARC has been Rejected';
                break;
            case 3:
                $status = 4;
                $hsse_ID = getCurrentUserid();
                $data = [
                    'HSSE_ID' => $hsse_ID,
                    'HSSE_DATE' => converttoDBDate(date('d-m-Y H:i:s'), 'Y-m-d H:i:s')
                ];
                $msg = 'HIRARC has been Approved';
                break;
            case 4:
                $status = -4;
                $hsse_ID = getCurrentUserid();
                $data = [
                    'HSSE_ID' => $hsse_ID,
                    'HSSE_REJ_RES' => $hsse_rej,
                    'IS_REJECTED' => 2,
                    'HSSE_DATE' => converttoDBDate(date('d-m-Y H:i:s'), 'Y-m-d H:i:s')
                ];
                $msg = 'HIRARC has been Rejected';
                break;
            default:
                $status = 1;
                break;
        }
        if ($status_val !== '' && $status_val > 0) {
            $data['HIRARC_FLOW_STATUS'] = $status;
            if ($did !== '' && $did != '0') {
                $where = array(
                    'MAIN_AUTO_ID' => $did
                );
                $table = HIR_MAIN;
                $update = $this->common_model->updatedata($table, $data, $where);
            }
        }
        if ($update && $update > 0) {
            if (sendHirarcNotification($did)) {
                $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span>' . $msg . ' </div>');
                redirect('hirarc/hirarc/view_report/' . $id);
            } else {
                $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span>' . $msg . '! Try Again Later.</div>');
                redirect('hirarc/hirarc/view_report/' . $id);
            }
        } else {
            $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> ' . $msg . '! Try Again Later.</div>');
            redirect('hirarc/hirarc/view_report/' . $id);
        }
    }

    public function add_exce($id = '') {
        $did = decryptval($id);
        $hir_details = [];
        $hir_flow_details = [];
        $getterminalNamedatas = [];
        $getCompanyNamedatas = [];
        $getDeptNamedatas = [];
        $getProcessNamedatas = [];
        $getHazaTypedatas = [];
        $getHazadatas = [];
        $getCausedatas = [];


        if ($id != '') {
            $tab = HIR_MAIN . ' as h';
            $select = ['h.MAIN_AUTO_ID,h.HIRARC_ID,t.TERMINAL_NAME,d.DEPT_NAME,c.COM_NAME,e.EMP_NAME,h.PRO_ACT_LOC,h.HOD_ID,h.OTH_COMP_NAME,h.CREATED_BY,h.HIRARC_FLOW_STATUS'];
            $options['join'][HIR_COM . ' as c'] = ['c.COM_AUTO_ID = h.FK_COMP_ID', 'left'];
            $options['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = h.FK_TERMINAL_ID', 'left'];
            $options['join'][DEPT . ' as d'] = ['d.DEPT_AUTO_ID = h.FK_DEPT_ID', 'left'];
            $options['join'][LOGIN . ' as l'] = ['l.LOGIN_ID = h.HOD_ID', 'left'];
            $options['join'][EMPL . ' as e'] = ['e.EMP_AUTO_ID = l.USER_REF_ID', 'left'];
//            $options['join'][PRO_ACT_AREA . ' as p'] = ['p.PRO_AUTO_ID = h.PRO_ACT_LOC', 'left'];
            $options['return_type'] = 'row';
            $options['where'] = [
                'MAIN_AUTO_ID' => $did,
                'HIRARC_STATUS' => 'Y'
            ];
            $hir_details = $this->common_model->getAlldata($tab, $select, $options);

            $table = HIR_RISK;
            $selects = ['*'];
            $option['return_type'] = 'result';
            $option['group_by'] = ['RP_AUTO_ID'];
            $option['where'] = [
                'FK_HIRARC_MAIN_ID' => $did,
                'RISK_PRO_STATUS' => 'Y'
            ];
            $hir_flow_details = $this->common_model->getAlldata($table, $selects, $option);
        }
        $terminWhere['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $terNamedatas = $this->common_model->getAlldata(TERM, ['*'], $terminWhere);
        if (is_array($terNamedatas)) {
            $getterminalNamedatas = customFormDropDown($terNamedatas, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');
        }
        $companyinWhere['where'] = [
            'COM_STATUS' => 'Y'
        ];
        $CompanyNamedatas = $this->common_model->getAlldata(HIR_COM, ['*'], $companyinWhere);
        if (is_array($CompanyNamedatas)) {
            $getCompanyNamedatas = customFormDropDown($CompanyNamedatas, 'COM_AUTO_ID', 'COM_NAME', 'Select Company Name');
        }
        $deptinWhere['where'] = [
            'DEPT_STATUS' => 'Y'
        ];
        $deptNamedatas = $this->common_model->getAlldata(DEPT, ['*'], $deptinWhere);
        if (is_array($deptNamedatas)) {
            $getDeptNamedatas = customFormDropDown($deptNamedatas, 'DEPT_AUTO_ID', 'DEPT_NAME', 'Select Department Name');
        }
        $deptinWhere['where'] = [
            'PRO_STATUS' => 'Y'
        ];
        $processNamedatas = $this->common_model->getAlldata(PRO_ACT_AREA, ['*'], $deptinWhere);

        if (is_array($processNamedatas)) {
            $getProcessNamedatas = customFormDropDown($processNamedatas, 'PRO_AUTO_ID', 'PRO_NAME', 'Select Process/Activity/Area  Name');
        }

        $hazaWhere['where'] = [
            'HAZ_TYPE_STATUS' => 'Y'
        ];
        $hazardtypedatas = $this->common_model->getAlldata(HAZA_TYPE, ['*'], $hazaWhere);

        if (is_array($hazardtypedatas)) {
            $getHazaTypedatas = customFormDropDown($hazardtypedatas, 'HAZ_TYPE_AUTO_ID', 'HAZ_TYPE_NAME', 'Select R/NR/E');
        }

        $causeWhere['where'] = [
            'CAUSE_STATUS' => 'Y'
        ];
        $caudatas = $this->common_model->getAlldata(HAZA_CAU, ['*'], $causeWhere);

        if (is_array($caudatas)) {
            $getCausedatas = customFormDropDown($caudatas, 'CAUSE_AUTO_ID', 'CAUSE_NAME', 'Select Cause Effect');
        }

        $ExriskWhere['where'] = [
            'HAZ_STATUS' => 'Y'
        ];
        $exitdatas = $this->common_model->getAlldata(EXIT_RI_CN, ['*'], $ExriskWhere);

        // echo $this->db->last_query();
        // exit;
        if (is_array($exitdatas)) {
            $getExRiCntdatas = customFormDropDown($exitdatas, 'CONTROL_AUTO_ID', 'CONTROL_NAME', 'Select Hazard Name');
        }
        $empList = getUsertypdesigEmpl('5');
        global $legalDatas;
        global $statusDatas;
        $data = array(
            'view_file' => 'hirarc/exc_flow/add_form',
            'current_menu' => 'Add Executive Hirarc ',
            'hir_details' => $hir_details,
            'empList' => $empList,
            'geterminalNamedatas' => $getterminalNamedatas,
            'getCompanyNamedatas' => $getCompanyNamedatas,
            'getDeptNamedatas' => $getDeptNamedatas,
            'getProcessNamedatas' => $getProcessNamedatas,
            'getHazaTypedatas' => $getHazaTypedatas,
            'getCausedatas' => $getCausedatas,
            'getHazadatas' => $getHazadatas,
            'getExRiCntdatas' => $getExRiCntdatas,
            'legalDatas' => $legalDatas,
            'statusDatas' => $statusDatas,
            'hir_flow_details' => $hir_flow_details
        );
        $this->template->load_common_template($data);
    }

    public function saverisk($id = '') {
        $did = decryptval($id);
        $risk = $this->input->post('risk');
        if (is_array($risk) && $risk != '') {
            $this->form_validation->set_rules('risk[1][pro_Id]', 'Process', 'required');
            $this->form_validation->set_rules('risk[1][rnr_Id]', 'R/NR/E', 'required');
            $this->form_validation->set_rules('risk[1][haz_name][]', 'Hazard Type', 'required');
            $this->form_validation->set_rules('risk[1][cause_name][]', 'Cause', 'required');
            $this->form_validation->set_rules('risk[1][risk_name][]', 'Risk', 'required');
            $this->form_validation->set_rules('risk[1][legal]', 'legal', 'required');
            if ($this->form_validation->run()) {
                $deletExitingRiskData = $this->db->simple_query('Delete from ' . HIR_RISK . ' where FK_HIRARC_MAIN_ID = ' . $did);
                $deletExitingHazData = $this->db->simple_query('Delete from ' . HAZA_NAME . ' where MAIN_HIRARC_ID = ' . $did);
                $deletExitingCauData = $this->db->simple_query('Delete from ' . HAZA_CAU . ' where MAIN_HIRARC_ID = ' . $did);
                $deletExitingCntlData = $this->db->simple_query('Delete from ' . EXIT_RI_CN . ' where MAIN_HIRARC_ID = ' . $did);
//                print_r($deletExitingRiskData);exit;
//                if ($deletExitingRiskData) {
                    foreach ($risk as $key => $val) {
                        if (is_array(postData($val, 'legal'))) {
                            foreach (array_filter(postData($val, 'legal')) as $k => $valu) {
                                $legal_val = implode(',', array_filter(postData($val, 'legal')));
                            }
                        }
                        if (postData($val, 'cntrl_opt') == 2) {
                            $person_name = postData($val, 'person_name');
                            $duedate = converttoDBDate(postData($val, 'duedate'));
                            $status = postData($val, 'status');
                            $ctrloptTxt = postData($val, 'cntrl_opt_text');
                        } else {
                            $person_name = '';
                            $duedate = '';
                            $status = '';
                            $ctrloptTxt = '';
                        }
                        $data = [
                            'FK_HIRARC_MAIN_ID' => $did,
                            'FK_PRO_ACT_NAME' => postData($val, 'pro_Id'),
                            'FK_HAZ_TYPE_ID' => postData($val, 'rnr_Id'),
                            'FK_LEGAL_ID' => $legal_val,
                            'SEVERITY' => postData($val, 'seve'),
                            'LIKELIHOOD' => postData($val, 'likel'),
                            'FK_RISK_RATE' => postData($val, 'risk_val'),
                            'FK_RISK_LEVEL_COL_CODE' => postData($val, 'color'),
                            'RECOMMENED_CONTROL' => postData($val, 'cntrl_opt'),
                            'RECOMMENED_CONTROL_TEXT' => $ctrloptTxt,
                            'PERSON_INCHARGE' => $person_name,
                            'DUE_DATE' => $duedate,
                            'RISK_PRO_END_STATUS' => $status
                        ];
//                        echo '<pre>';
//                        print_r($data);
                        $updateData = $this->common_model->updateData(HIR_RISK, $data);
//                        echo $this->db->last_query();exit;
                        if ($updateData && $updateData != 0) {
                            $hazname = postData($val, 'haz_name');
//                            if ($deletExitingHazData) {
                                foreach ($hazname as $h => $haz) {
                                    $haz_data = array(
                                        'MAIN_HIRARC_ID' => $did,
                                        'ROW_ID' => $updateData,
                                        'HAZ_NAME' => $haz
                                    );
                                    $updateHazData = $this->common_model->updateData(HAZA_NAME, $haz_data);
                                }
//                            }
                            $cause_name = postData($val, 'cause_name');
//                            if ($deletExitingCauData) {
                                foreach ($cause_name as $c => $cau) {
                                    $cause_data = array(
                                        'MAIN_HIRARC_ID' => $did,
                                        'ROW_ID' => $updateData,
                                        'CAUSE_NAME' => $cau
                                    );
                                    $updateCauData = $this->common_model->updateData(HAZA_CAU, $cause_data);
                                }
//                            }
                            $risk_name = postData($val, 'risk_name');

//                            if ($deletExitingCntlData) {
                                foreach ($risk_name as $r => $ris) {
                                    $cntrl_data = array(
                                        'MAIN_HIRARC_ID' => $did,
                                        'ROW_ID' => $updateData,
                                        'CONTROL_NAME' => $ris
                                    );
                                    $updateCntrlData = $this->common_model->updateData(EXIT_RI_CN, $cntrl_data);
                                }
//                            }
                        }
                    }
//                } else {
//                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Unable to complete Risk Analysis Process! Try Again Later.</div>');
//                    redirect('hirarc/hirarc');
//                }
            }

            if ($updateData) {
                $sdata = [
                    'HIRARC_FLOW_STATUS' => 2
                ];
                $whr = [
                    'MAIN_AUTO_ID' => $did
                ];
                $statusUpdate = $this->common_model->updateData(HIR_MAIN, $sdata, $whr);
                if ($statusUpdate && $statusUpdate > 0) {
                    if (sendHirarcNotification($did)) {
                        $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span>Risk Analysis Process has been successfully completed</div>');
                        redirect('hirarc/hirarc');
                    } else {
                        $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Unable to complete Risk Analysis Process! Try Again Later.</div>');
                        redirect('hirarc/hirarc');
                    }
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Unable to Risk Analysis Process! Try Again Later.</div>');
                    redirect('hirarc/hirarc');
                }
            }
        }
    }

    public function getAjaxdatas() {
        $pro_val = $this->input->post('pro_val');
        $rnr_val = $this->input->post('rnr_val');
        $getHazadatas = '';
        if ($rnr_val !== '' && $pro_val !== '') {
            $hazardWhere['where'] = [
                'h.HAZ_STATUS' => 'Y',
                'h.FK_PRO_ID' => $pro_val,
                'h.FK_HAZ_TYPE_ID' => $rnr_val
            ];
            $hazardWhere['join'][HAZA_NAME . ' as n'] = ['n.HIR_HAZA_ID = h.HAZ_AUTO_ID', 'left'];
            $hazarddatas = $this->common_model->getAlldata(HAZA . ' as h', ['n.HAZ_ID,n.HAZ_NAME'], $hazardWhere);
            $editId = '';
            if (is_array($hazarddatas)) {
                $getHazadatas .= '<option value="">Select Hazard</option>';
                foreach ($hazarddatas as $stKey => $stVal) {
                    if ($stVal->UNIQ_ID == $editId) {
                        $getHazadatas .= '<option value="' . $stVal->HAZ_ID . '" selected="' . $editId . '">' . $stVal->HAZ_NAME . '</option>';
                    } else {

                        $getHazadatas .= '<option value="' . $stVal->HAZ_ID . '">' . $stVal->HAZ_NAME . '</option>';
                    }
                }
            }
            if ($getHazadatas != '') {
                $data = [
                    'hazardDatas' => $getHazadatas,
                    'status' => true
                ];
            } else {
                $data = [
                    'hazardDatas' => '',
                    'status' => FALSE
                ];
            }
            echo json_encode($data);
        } else {
            $data = [
                'hazardDatas' => '',
                'status' => FALSE
            ];
            echo json_encode($data);
        }
    }

    public function getAjaxExitdatas() {
        $haz_val = $this->input->post('haz_val');
        $getexdatas = '';
        if ($haz_val != '') {
            $hazardWhere['where'] = [
                'CAUSE_STATUS' => 'Y',
                'FK_HAZ_ID' => $haz_val
            ];
            $getExitdatas = $this->common_model->getAlldata(HAZA_CAU, ['*'], $hazardWhere);
            $editId = '';
            if (is_array($getExitdatas)) {
                $getexdatas .= '<option value="">Select Cause Effect</option>';
                foreach ($getExitdatas as $stKey => $stVal) {
                    if ($stVal->CAUSE_AUTO_ID == $editId) {
                        $getexdatas .= '<option value="' . $stVal->CAUSE_AUTO_ID . '" selected="' . $editId . '">' . $stVal->CAUSE_NAME . '</option>';
                    } else {

                        $getexdatas .= '<option value="' . $stVal->CAUSE_AUTO_ID . '">' . $stVal->CAUSE_NAME . '</option>';
                    }
                }
            }
            if ($getexdatas != '') {
                $data = [
                    'getexdatas' => $getexdatas,
                    'status' => true
                ];
            } else {
                $data = [
                    'getexdatas' => '',
                    'status' => FALSE
                ];
            }
            echo json_encode($data);
        } else {
            $data = [
                'getexdatas' => '',
                'status' => FALSE
            ];
            echo json_encode($data);
        }
    }

    public function getAjaxriskdatas() {
        $exit_val = $this->input->post('exit_val');
        $geriskdatas = '';
        if ($exit_val != '') {
            $hazardWhere['where'] = [
                'CONTROL_STATUS' => 'Y',
                'FK_CAUSE_ID' => $exit_val
            ];
            $getRiskdatas = $this->common_model->getAlldata(EXIT_RI_CN, ['*'], $hazardWhere);
            $editId = '';
            if (is_array($getRiskdatas)) {
//                $geriskdatas .= '<option value="">Select Existing Control</option>';
                foreach ($getRiskdatas as $stKey => $stVal) {
                    if ($stVal->CONTROL_AUTO_ID == $editId) {
                        $geriskdatas .= '<option value="' . $stVal->CONTROL_AUTO_ID . '" selected="' . $editId . '">' . $stVal->CONTROL_NAME . '</option>';
                    } else {

                        $geriskdatas .= '<option value="' . $stVal->CONTROL_AUTO_ID . '">' . $stVal->CONTROL_NAME . '</option>';
                    }
                }
            }
            if ($geriskdatas != '') {
                $data = [
                    'geriskdatas' => $geriskdatas,
                    'status' => true
                ];
            } else {
                $data = [
                    'geriskdatas' => '',
                    'status' => FALSE
                ];
            }
            echo json_encode($data);
        } else {
            $data = [
                'geriskdatas' => [],
                'status' => FALSE
            ];
            echo json_encode($data);
        }
    }

    public function getriskmatrixColor() {
        $seve_val = $this->input->post('seve_val');
        $likel_val = $this->input->post('likel_val');
        $getRiskratedatas = '';
        if ($seve_val != '' && $likel_val != '') {
            $hazardWhere['where'] = [
                'RISK_RATE_STATUS' => 'Y',
                'SEVERITY' => $seve_val,
                'LIKELIHOOD' => $likel_val
            ];
            $getRiskratedatas = $this->common_model->getAlldata(RISK_RATE, ['RISK_RATE,RISK_LEVEL_COL_CODE'], $hazardWhere);
            if ($getRiskratedatas !== '') {
                $data = [
                    'risk_rate' => $getRiskratedatas[0]->RISK_RATE,
                    'clr_code' => $getRiskratedatas[0]->RISK_LEVEL_COL_CODE,
                    'status' => true
                ];
            } else {
                $data = [
                    'risk_rate' => '',
                    'clr_code' => '',
                    'status' => FALSE
                ];
            }
            echo json_encode($data);
        } else {
            $data = [
                'risk_rate' => '',
                'clr_code' => '',
                'status' => FALSE
            ];
            echo json_encode($data);
        }
    }

    public function pdf_report($id = '') {
        $did = decryptval($id);

        if ($id != '') {
            $tab = HIR_MAIN . ' as h';
            $select = ['h.MAIN_AUTO_ID,h.HIRARC_ID,t.TERMINAL_NAME,h.PRO_ACT_LOC,h.CREATED_ON,d.DEPT_NAME,c.COM_NAME,de.DESIGNATION_NAME as ds_na,ds.DESIGNATION_NAME as des_name,em.EMP_NAME as cnd_by,e.EMP_NAME,p.PRO_NAME,h.HOD_ID,h.OTH_COMP_NAME,h.CREATED_BY,h.HIRARC_FLOW_STATUS'];
            $options['join'][HIR_COM . ' as c'] = ['c.COM_AUTO_ID = h.FK_COMP_ID', 'left'];
            $options['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = h.FK_TERMINAL_ID', 'left'];
            $options['join'][DEPT . ' as d'] = ['d.DEPT_AUTO_ID = h.FK_DEPT_ID', 'left'];
            $options['join'][LOGIN . ' as l'] = ['l.LOGIN_ID = h.HOD_ID', 'left'];
            $options['join'][LOGIN . ' as ln'] = ['ln.LOGIN_ID = h.CREATED_BY', 'left'];
            $options['join'][EMPL . ' as e'] = ['e.EMP_AUTO_ID = l.USER_REF_ID', 'left'];
            $options['join'][EMPL . ' as em'] = ['em.EMP_AUTO_ID = ln.USER_REF_ID', 'left'];
            $options['join'][DESIG . ' as de'] = ['de.DESIGNATION_ID = e.EMP_DESIGNATION_ID', 'left'];
            $options['join'][DESIG . ' as ds'] = ['ds.DESIGNATION_ID = em.EMP_DESIGNATION_ID', 'left'];
            $options['join'][PRO_ACT_AREA . ' as p'] = ['p.PRO_AUTO_ID = h.PRO_ACT_LOC', 'left'];
            $options['return_type'] = 'row';
            $options['where'] = [
                'MAIN_AUTO_ID' => $did,
                'HIRARC_STATUS' => 'Y'
            ];
            $hir_details = $this->common_model->getAlldata($tab, $select, $options);

            $hir_details = $this->common_model->getAlldata($tab, $select, $options);
            $table = HIR_RISK . ' as r';
            $selects = ['r.*,h.HAZ_TYPE_NAME'];
            $option['join'][HAZA_TYPE . ' as h'] = ['h.HAZ_TYPE_AUTO_ID = r.FK_HAZ_TYPE_ID', 'left'];
            $option['return_type'] = 'result';
            $option['group_by'] = ['r.RP_AUTO_ID'];
            $option['where'] = [
                'r.FK_HIRARC_MAIN_ID' => $did,
                'r.RISK_PRO_STATUS' => 'Y'
            ];
            $hir_flow_details = $this->common_model->getAlldata($table, $selects, $option);
        }
        $PdfData = [
            'hir_details' => $hir_details,
            'hir_flow_details' => $hir_flow_details
        ];
        $html2 = $this->load->view('hirarc/exc_flow/print_pdf', $PdfData, true);
//        print_r($html2);
//        exit;
        $mpdf2 = $this->pdf->load();
        $mpdf2->setAutoTopMargin='stretch';
        $mpdf2->shrink_tables_to_fit = 1;
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "HIRARC";
        $file_path = "assets/images/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $file_path . 'HIRARC-' . $id . '-' . $currenttime . '.pdf';
        $name = 'HIRARC-' . $currenttime . '.pdf';
        $mpdf2->Output($path2, "I");
        $data = file_get_contents($path2);
        force_download($name, $data);
    }
    
    public function deletehirarc(){
         $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(HIR_MAIN, ['HIRARC_STATUS' => 'N'], ['MAIN_AUTO_ID' => decryptval($deleteId)]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'HIRARC deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting HIRARC'
            ];
        }
        echo json_encode($retData);
    }

}
