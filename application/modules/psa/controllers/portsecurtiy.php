<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class portsecurity extends CI_Controller {

    function __construct() {
         parent::__construct();
        isLogin();
    }
    
    //// Cause Effect master end
    
        //// riskControl master start
    public function index() {
        $data = array(
            'view_file' => 'psa/list_form',
            'site_title' => 'Port Security Access',
            'current_menu' => 'List Port Security Access',
            'ajaxurl' => 'psa/portsecurity/list_psa',
        );

        $this->template->load_table_template($data);
    }

    public function list_psa() {
        $where['ex.CONTROL_STATUS'] = 'Y';
        $table = EXIT_RI_CN . ' as ex';
        $column_order = array('FK_PRO_ID', 'FK_HAZ_TYPE_ID', 'FK_HAZ_ID', 'FK_CAUSE_ID','CONTROL_NAME', 'CREATED_ON', null);
        $column_search = array('FK_PRO_ID', 'FK_HAZ_TYPE_ID', 'FK_HAZ_ID', 'CAUSE_NAME','CONTROL_NAME', 'CREATED_ON'); 
        $order = array('ex.CONTROL_AUTO_ID' => 'desc');
        $optns['select'] = 'ty.HAZ_TYPE_NAME,pro.PRO_NAME,hn.HAZ_NAME,ex.CREATED_ON,ex.FK_CAUSE_ID,cau.CAUSE_NAME,group_concat(DISTINCT(ex.CONTROL_NAME)) as CONTROL_NAME';
        $optns['join'][HAZA_NAME . ' as hn'] = ['hn.HAZ_ID = ex.FK_HAZ_ID', 'left'];
        $optns['join'][HAZA_TYPE . ' as ty'] = ['ty.HAZ_TYPE_AUTO_ID = ex.FK_HAZ_TYPE_ID', 'left'];
        $optns['join'][PRO_ACT_AREA . ' as pro'] = ['pro.PRO_AUTO_ID = ex.FK_PRO_ID', 'left'];
        $optns['join'][HAZA_CAU . ' as cau'] = ['cau.CAUSE_AUTO_ID = ex.FK_CAUSE_ID', 'left'];

        $optns['group_by'] = ['ex.FK_CAUSE_ID'];
        $listResp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $optns);
//        echo $this->db->last_query();exit;
//        echo '<pre>';
//        print_r($listResp);
//        exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listResp) && !empty($listResp)) {
            foreach ($listResp as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->FK_CAUSE_ID);

                $action .= " " . anchor('hirarc/master/addRiskControl/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));

                $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteriskcont', 'title' => 'Delete', 'delt-id' => $id));
//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

                $rows = [];
                $rows[] = ucfirst($ltVal->PRO_NAME);
                $rows[] = ucfirst($ltVal->HAZ_TYPE_NAME);
                $rows[] = ucfirst($ltVal->HAZ_NAME);
                $rows[] = ucfirst($ltVal->CAUSE_NAME);
                $rows[] = ucfirst($ltVal->CONTROL_NAME);
                $rows[] = convertDate($ltVal->CREATED_ON);
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

    public function addpsa($id = '') {
        $did = decryptval($id);
        $getExistdatas = [];
        $getcauseNamedatas = [];

        if ($id != '') {
            $optWhr['where'] = [
                'FK_CAUSE_ID' => $did,
                'CONTROL_STATUS' => 'Y'
            ];
            $optWhr['return_type'] = 'result';
            $getExistdatas = $this->common_model->getAlldata(EXIT_RI_CN , ['*'], $optWhr);
        }
        $hazrtyWhere['where'] = [
            'CAUSE_STATUS' => 'Y'
        ];
        $causeNamedatas = $this->common_model->getAlldata(HAZA_CAU, ['*'], $hazrtyWhere);
        if (is_array($causeNamedatas)) {
            $getcauseNamedatas = customFormDropDown($causeNamedatas, 'CAUSE_AUTO_ID', 'CAUSE_NAME', 'Select Cause Name');
        }
        $data = array(
            'view_file' => 'psa/add_form',
            'current_menu' => 'Add Port Security Access ',
            'getExistdatas' => $getExistdatas,
            'getcauseNamedatas' => $getcauseNamedatas
        );
        $this->template->load_common_template($data);
    }

    public function savepsa($id = '') {

        $did = decryptval($id);
        $exitDatas = $this->input->post('risk');
        $this->form_validation->set_rules('risk[FK_CAUSE_ID]', 'Cause Affect', 'required|trim');
        $this->form_validation->set_rules('risk[contr_name][]', 'Existing Risk Control', 'required|trim|min_length[2]|alpha_dash_space');
//        print_r($exitDatas);
        if ($this->form_validation->run()) {
            $contr_name = postData($exitDatas, 'contr_name');
            $cau_id = postData($exitDatas, 'FK_CAUSE_ID');
            $cntrl_ID = postData($exitDatas, 'CONTROL_AUTO_ID');
            $getCausedatas = [];
            if ($cau_id != '' && $cau_id > 0) {
                $hazWhr['where'] = [
                    'CAUSE_AUTO_ID' => $cau_id,
                    'CAUSE_STATUS' => 'Y'
                ];
                $hazWhr['return_type'] = 'row';
                $getCausedatas = $this->common_model->getAlldata(HAZA_CAU, ['FK_HAZ_ID,FK_PRO_ID,FK_HAZ_TYPE_ID'], $hazWhr);
            }
            if ($did != '' && $did > 0) {
                $CauNameWhr['where'] = [
                    'FK_CAUSE_ID' => $did,
                    'CONTROL_STATUS' => 'Y'
                ];
                $CauNameWhr['return_type'] = 'result';
                $getExistdatas = $this->common_model->getAlldata(EXIT_RI_CN, ['CONTROL_AUTO_ID'], $CauNameWhr);
                foreach ($cntrl_ID as $key => $hazNId) {
                    $cauNaId[] = $hazNId;
                }
                foreach ($getExistdatas as $key => $val) {
                    if (in_array($val->CONTROL_AUTO_ID, $cauNaId) == FALSE) {
                        $uphazadatas = [
                            'CONTROL_STATUS' => 'N'
                        ];
                        $upHWhere = [
                            'CONTROL_AUTO_ID' => $val->CONTROL_AUTO_ID
                        ];
                        $updtProfile = $this->common_model->updateData(EXIT_RI_CN, $uphazadatas, $upHWhere);
                    }
                }
            } 
            foreach ($contr_name as $k => $value) {
                $hazadatas = [
                    'FK_CAUSE_ID' => $cau_id,
                    'FK_HAZ_ID' => $getCausedatas->FK_HAZ_ID,
                    'FK_PRO_ID' => $getCausedatas->FK_PRO_ID,
                    'FK_HAZ_TYPE_ID' => $getCausedatas->FK_HAZ_TYPE_ID,
                    'CONTROL_NAME' => $value
                ];
                if ($cntrl_ID[$k] != '') {
                    $upWhere = [
                        'CONTROL_AUTO_ID' => $cntrl_ID[$k]
                    ];
                    $updtProfile = $this->common_model->updateData(EXIT_RI_CN, $hazadatas, $upWhere);
                } else {
                    $updtProfile = $this->common_model->updateData(EXIT_RI_CN, $hazadatas);
                }
            }

            if ($updtProfile && $updtProfile > 0) {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Existing Risk Control has been Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Existing Risk Control has been Created</div>');
                }
                redirect('hirarc/master/riskControl');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Existing Risk Control cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Existing Risk Control cannot be Created</div>');
                }
                redirect('hirarc/master/riskControl');
            }
        } else {
            $this->addcauseAffect($id);
        }
    }

    public function deletepsa() {
        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(EXIT_RI_CN, ['CONTROL_STATUS' => 'N'], ['FK_CAUSE_ID' => decryptval($deleteId)]);
//        $updtHazNameDelete = $this->common_model->updateData(HAZA_NAME, ['HAZ_STATUS' => 'N'], ['HIR_HAZA_ID' => decryptval($deleteId)]);
        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Existing Risk Control has been deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Existing Risk Control! Try Again later.'
            ];
        }
        echo json_encode($retData);
    }

//// Cause Effect master end
}
