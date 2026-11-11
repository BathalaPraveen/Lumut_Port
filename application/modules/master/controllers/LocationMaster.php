<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class locationMaster extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(1);
//        $this->load->model('master_model');
        $this->load->model('common/common_model');
//        $this->load->library('pdf');
        isLogin();
    }

    //// Specific location master start
    public function Index() {
        $data = array(
            'view_file' => 'spec_location/list_location',
            'site_title' => 'Location',
            'current_menu' => 'List Location  ',
            'ajaxurl' => 'master/LocationMaster/list_location',
        );

        $this->template->load_table_template($data);
    }

    public function list_location() {
        $where['SPECIFIC_LOC_STATUS'] = 'Y';
        $table = SPEC_LOC . ' as loc';
        $column_order = array('SPECIFIC_LOC_ID', 'SPECIFIC_LOC_NAME', 'TERMINAL_NAME','CREATED_ON', null);
        $column_search = array('SPECIFIC_LOC_ID', 'SPECIFIC_LOC_NAME','TERMINAL_NAME', 'CREATED_ON');
        $order = array('SL_AUTO_ID' => 'desc');
        $optns['select'] = 'loc.SL_AUTO_ID,loc.SPECIFIC_LOC_ID,loc.SPECIFIC_LOC_NAME,loc.CREATED_ON,t.TERMINAL_NAME';
        $optns['join'][TER_MAN . ' as t'] = ['t.TER_AUTO_ID = loc.FK_TERMINAL_ID', 'left'];

        $listResp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $optns);
//        echo $this->db->last_query();exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listResp) && !empty($listResp)) {
            foreach ($listResp as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->SL_AUTO_ID);

                $action .= " " . anchor('master/LocationMaster/addLocation/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));

                 $action .= " " . anchor('master/LocationMaster/view/' . $id, '<i class="fa fa-eye"></i>', array('title' => 'view'));


            $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteLocation', 'title' => 'Delete', 'delt-id' => $id));
//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

                $rows = [];
                $rows[] = $ltVal->SPECIFIC_LOC_ID;
                $rows[] = ucfirst($ltVal->SPECIFIC_LOC_NAME);
                $rows[] = ucfirst($ltVal->TERMINAL_NAME);
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

    public function addLocation($id = '') {
        $did = decryptval($id);
        $getLocationdatas = [];
        $getTerminaldatas = [];

        if ($id != '') {
            $optWhr['where'] = [
                'SL_AUTO_ID' => $did,
                'SPECIFIC_LOC_STATUS' => 'Y'
            ];
            $optWhr['return_type'] = 'row';
            $getLocationdatas = $this->common_model->getAlldata(SPEC_LOC, ['*'], $optWhr);
        }
        $getuniqueId = uniqueRefId('LOCA', SPEC_LOC, 'SL_AUTO_ID');
        $TermWhere['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $Terminaldatas = $this->common_model->getAlldata(TER_MAN, ['*'], $TermWhere);
        if(is_array($Terminaldatas)){
            $getTerminaldatas = customFormDropDown($Terminaldatas, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');
        }
        $data = array(
            'view_file' => 'spec_location/add_location',
            'current_menu' => 'Add Location ',
            'getLocationdatas' => $getLocationdatas,
            'getTerminaldatas' => $getTerminaldatas,
            'getAutoId' => $getuniqueId
        );
        $this->template->load_common_template($data);
    }

    public function saveLocation($id = '') {

        $did = decryptval($id);

        $specloctnDatas = $this->input->post('loc');

        $this->form_validation->set_rules('loc[FK_TERMINAL_ID]', 'Terminal Name', 'required|trim');
        $this->form_validation->set_rules('loc[SPECIFIC_LOC_NAME]', 'Location Name', 'required|min_length[2]|max_length[100]|alpha_dash_space');
        $this->form_validation->set_rules('loc[SPECIFIC_LOC_DESC]', 'Specific Location Description', 'trim');

        if ($this->form_validation->run()) {
            $locdatas = [
                'SPECIFIC_LOC_ID' => postData($specloctnDatas, 'SPECIFIC_LOC_ID'),
                'FK_TERMINAL_ID' => postData($specloctnDatas, 'FK_TERMINAL_ID'),
                'SPECIFIC_LOC_NAME' => postData($specloctnDatas, 'SPECIFIC_LOC_NAME'),
                'SPECIFIC_LOC_DESC' => postData($specloctnDatas, 'SPECIFIC_LOC_DESC')
            ];
//            print_r($locdatas);exit;
            if ($did != '') {
                $upWhere = [
                    'SL_AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(SPEC_LOC, $locdatas, $upWhere);
//            echo $this->db->last_query();exit;
            } else {
                $updtProfile = $this->common_model->updateData(SPEC_LOC, $locdatas);
//                echo $this->db->last_query();exit;
            }

            if ($updtProfile) {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Specific Location has been Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Specific Location has been Created</div>');
                }
                redirect('master/locationMaster');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Specific Location cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Specific Location cannot be Created</div>');
                }
                redirect('master/locationMaster');
            }
        } else {
            $this->addLocation($id);
        }
    }

    public function deleteLocation() {
        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(SPEC_LOC, ['SPECIFIC_LOC_STATUS' => 'N'], ['SL_AUTO_ID' => decryptval($deleteId)]);
        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Specific Location has been deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Specific Location! Try Again later.'
            ];
        }
        echo json_encode($retData);
    }

     public function view($id = '') {
        $editData = FALSE;
        if ($id != '') {
            
            $did = decryptval($id);
        //   print_r($did);exit;
            $option['where'] = [
                'SL_AUTO_ID' => $did
            ];
            $table = SPEC_LOC . ' as SPEC';
            $col = ['SPEC.*,TER.TERMINAL_NAME'];
            $option['join'][TER_MAN . ' as TER'] = ['TER.TER_AUTO_ID = SPEC.FK_TERMINAL_ID', 'left'];
            
            $option['return_type'] = 'row';
            $specificdetails = $this->common_model->getAllData($table, $col, $option, '', '', 'SL_AUTO_ID', 'DESC');
            $specificInfo = (isset($specificdetails) && $specificdetails != '') ? $specificdetails : [];
       
        //print_r($specificInfo);exit;
        
        }

        $data = [
            'view_file' => 'master/spec_location/view_report',
            'current_menu' => 'View Specific Location',
            'editData' => $specificInfo
            
        ];

        //  echo "<pre>";
       // print_r($data);exit;

        $this->template->load_common_template($data);
    }



//// Specific location master end
}
