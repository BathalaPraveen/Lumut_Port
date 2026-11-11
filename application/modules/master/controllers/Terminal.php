<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Terminal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(1);
//        $this->load->model('master_model');
//        $this->load->model('project/project_model');
//        $this->load->library('pdf');
        isLogin();
    }

    public function designation_info() {
        $data = array(
            'pageTitle' => 'Designation',
            'view_file' => 'master/designation/list_form',
            'site_title' => 'Designation Info',
            'current_menu' => 'Designation List',
            'ajaxurl' => 'master/terminal/list_designation',
        );

        $this->template->load_table_template($data);
    }
    
    public function list_designation() {
        $table = DES.' as des';
        $column_order = array(null, 'DES_GENERATE_ID','USER_TYPE_NAME','DESIGNATION_NAME', 'CREATED_ON', null);
        $column_search = array('DES_GENERATE_ID','USER_TYPE_NAME','DESIGNATION_NAME' ,'CREATED_ON');
        $order = array('des.CREATED_ON' => 'desc');
        $where = ['DESIGNATION_STATUS' => 'Y'];
        
        $optns['join'][UTYPE.' as typ'] = ['typ.USER_TYPE_ID = des.DES_USER_TYPE','left'];

        $listDes = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where,$optns);
//echo "<pre>";
//echo $this->db->last_query();
//print_R($listDes);
//exit;
        $finalDatas = [];
        if (isset($listDes) && !empty($listDes)) {
            foreach ($listDes as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->DESIGNATION_ID;
                
                $uid = $ltVal->DES_USER_TYPE;

                $action .= " " . anchor('master/terminal/addDesc/' . $id.'/'.$uid, '<i class="fa fa-edit"></i>', array('class' => 'designation', 'title' => 'Edit'));

                 $action .= " " . anchor('master/terminal/viewDes/' . encryptval($id), '<i class="fa fa-eye"></i>', array('title' => 'view'));
             
              
                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteDes', 'title' => 'Delete', 'delt-id' => $id.'-'.$uid));
               
                $rows = [];
                $rows[] = $ltVal->DES_GENERATE_ID;
                $rows[] = $ltVal->USER_TYPE_NAME;
                $rows[] = $ltVal->DESIGNATION_NAME;
               
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
    
    public function addDesc($id = '',$uid='') {
        $getDesdatas = [];
       
        $getuniqueId = uniqueRefId('DES', DES, 'DESIGNATION_ID');

        $utypOptns['where'] = [
            'USER_TYPE_STATUS' => 'Y'
        ];
        $getAllusertyp = $this->common_model->getAlldata(UTYPE.' as utyp',['*'],$utypOptns);
        $dropUsertp = customFormDropDown($getAllusertyp, 'USER_TYPE_ID', 'USER_TYPE_NAME', 'Select User Role');

        if ($id != '') {
            $optWhr['where'] = [
                'DESIGNATION_ID' => $id
            ];
            $optWhr['return_type'] = 'row';
            $getDesdatas = $this->common_model->getAlldata(DES, ['*'], $optWhr);
        }
        if($uid != ''){
            $utypOptn['where'] = [
                'USER_TYPE_ID' => $uid,
                'USER_DESIGN_ID' => $id,
            ];
            $utypOptn['return_type'] = 'row';
           $utypDesdatas = $this->common_model->getAlldata(UTYPE_DESIG,['*'],$utypOptn);
        }
        
       

        $data = array(
            'view_file' => 'master/designation/add_form',
            'current_menu' => 'Add Desgination',
            'getDesdatas' => $getDesdatas,
            'getAutoId' => $getuniqueId,
            'dropUsertp' => $dropUsertp,
            'utypDesdatas' => $utypDesdatas,
        );
        $this->template->load_popup_template($data);
    }
    
    public function saveDesc(){
       $getDesdatas = $this->input->post();


       $editId = postData($getDesdatas, 'ter_id');
       $usertypId = postData($getDesdatas, 'user_typ');
       $usertypDesId = postData($getDesdatas, 'uDes_editid');
//       echo "<pre>";
//print_R($getDesdatas);
//exit;
       
       if ($editId > 0) {
 $this->form_validation->set_rules('des_name', 'Desgination Name', 'required|alpha_dash_space|min_length[2]|max_length[100]');
          
        } else {
          $this->form_validation->set_rules('des_name', 'Desgination Name', 'required|alpha_dash_space|min_length[2]|max_length[100]');
        }
        
        $getuniqueId = uniqueRefId('DES', DES, 'DESIGNATION_ID');

        if ($this->form_validation->run() == true) {
           
            $updateData = [
                'DESIGNATION_NAME' => postData($getDesdatas, 'des_name'),
                'DES_USER_TYPE' => postData($getDesdatas, 'user_typ'),
//                'DES_GENERATE_ID' => $getuniqueId,
                'DESIGNATION_REMARK' => postData($getDesdatas, 'des_remark'),
               
            ];
            $updtWhr = [];
            if ($editId > 0) {
                
                $updtWhr = [
                    'DESIGNATION_ID' => $editId
                ];
            }else{
                $updateData['DES_GENERATE_ID'] = $getuniqueId;
            }


//            $updateInfo = $this->common_model->updateData(DES, $updateData, $updtWhr, 'DESIGNATION_ID');
            $updateInfo = $this->common_model->updateData(DES, $updateData, $updtWhr);
            
            //////////// user typ designation start
                $usrTypins = [
                    'USER_TYPE_ID' => $usertypId,
//                    'USER_DESIGN_ID' => $updateInfo,
                ];
                if ($editId > 0) {
                    $usrTypins['USER_DESIGN_ID'] = $editId;
if(!empty($usertypDesId)){
                        $this->common_model->updateData(UTYPE_DESIG,$usrTypins,['USER_TYPE_DESIGNATION_ID' => $usertypDesId]);
                   }else{
                       $this->common_model->updateData(UTYPE_DESIG,$usrTypins);
                   }
                   // $this->common_model->updateData(UTYPE_DESIG,$usrTypins,['USER_TYPE_DESIGNATION_ID' => $usertypDesId]);
                }else{
                    $usrTypins['USER_DESIGN_ID'] = $updateInfo;
                    $this->common_model->updateData(UTYPE_DESIG,$usrTypins);
                }
            //////////// user typ designation end
            if (!empty($updateInfo)) {

                $data = [
                    'status' => true
                ];
                if ($editId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Designation Name has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Designation Name has been Created</div>');
                }
            } else {
                $data = [
                    'status' => false
                ];
                if ($editId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Designation Name cannot be Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Designation Name cannot be Created</div>');
                }

            }
        } else {
            $errors = $this->form_validation->error_array();
            $data = [
                'status' => 'error',
                'errors' => $errors,
            ];
        }
        echo json_encode($data);
    }
    
    public function deleteDesignation() {

        $deleteId = $this->input->post('delid');
        
        $expTypids = explode("-",$deleteId);
        $desId = $expTypids[0];
        $utypid = $expTypids[1];
        
        $updtDelete = $this->common_model->updateData(DES, ['DESIGNATION_STATUS' => 'N'], ['DESIGNATION_ID' => $desId]);
        $updtDeleteTyp = $this->common_model->updateData(UTYPE_DESIG, ['USER_TYPE_DESIGNATION_STATUS' => 'N'], ['USER_DESIGN_ID' => $desId,'USER_TYPE_ID' => $utypid]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Designation Name deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Designation Name'
            ];
        }
        echo json_encode($retData);
    }


    
     public function terminalInfo() {


        $checkOptn['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        
        $getterstdata = $this->common_model->getAlldata(TER_MAN, ['*'], $checkOptn);
         $data =[
            'pageTitle' => 'Terminal Management',
            'view_file' => 'master/terminal/list_form',
            'site_title' => 'Terminal Management',
            'current_menu' => 'Terminal List',
            'ajaxurl' => 'master/terminal/listTerminal',
        ];

        $this->template->load_table_template($data);
    }
    public function listTerminal() {
        
        $table = TER_MAN;
        $column_order = array(null, 'TERMINAL_ID','TERMINAL_NAME','TERMINAL_EMAIL','TERMINAL_PHONE', 'CREATED_ON', null);
        $column_search = array('TERMINAL_ID','TERMINAL_NAME' ,'TERMINAL_EMAIL','TERMINAL_PHONE','CREATED_ON');
        $order = array('CREATED_ON' => 'desc');
        $where = ['TERMINAL_STATUS' => 'Y'];

        $listResp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $optns);
//        echo $this->db->last_query();exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listResp) && !empty($listResp)) {
            foreach ($listResp as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->TER_AUTO_ID);

                $action .= " " . anchor('master/terminal/addTerminal/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));
                $action .= " " . anchor('master/terminal/view/' . $id, '<i class="fa fa-eye"></i>', array('title' => 'view'));
              
                $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteTerminal', 'title' => 'Delete', 'delt-id' => $id));
//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

                $rows = [];
                $rows[] = $ltVal->TERMINAL_ID;
                $rows[] = ucfirst($ltVal->TERMINAL_NAME);
                $rows[] = $ltVal->TERMINAL_EMAIL;
                $rows[] = $ltVal->TERMINAL_PHONE;
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

    public function addTerminal($id = '') {
        $did = decryptval($id);
       
        $getTerminaldatas = [];

        if ($id != '') {
            $optWhr['where'] = [
                'TER_AUTO_ID' => $did,
                'TERMINAL_STATUS' => 'Y'
            ];
            $optWhr['return_type'] = 'row';
            $getTerminaldatas = $this->common_model->getAlldata(TER_MAN, ['*'], $optWhr);
        }
        $getuniqueId = uniqueRefId('TER', TER_MAN, 'TER_AUTO_ID');
       
        $data = array(
            'view_file' => 'master/terminal/add_form',
            'current_menu' => 'Add Terminal',
            'getTerminaldatas' => $getTerminaldatas,
            'getAutoId' => $getuniqueId
        );
        $this->template->load_common_template($data);
    }

    public function saveTerminal($id = '') {
        $did = decryptval($id);

        $specterminalDatas = $this->input->post('ter');

        $this->form_validation->set_rules('ter[TERMINAL_NAME]', 'Terminal Name', 'required|min_length[2]|max_length[100]|trim');
        $this->form_validation->set_rules('ter[TERMINAL_SHORTNAME]', 'Terminal Short Name', 'required|min_length[1]|max_length[5]|trim');
        $this->form_validation->set_rules('ter[TERMINAL_EMAIL]', 'Terminal Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('ter[TERMINAL_PHONE]', 'Terminal Phone Number', 'required|numeric|trim');
        $this->form_validation->set_rules('ter[TERMINAL_MOBILE]', 'Terminal Mobile Number', 'required|numeric|trim');
        $this->form_validation->set_rules('ter[TERMINAL_ZIPCODE]', 'Terminal PIN Code', 'required|numeric|trim');
        $this->form_validation->set_rules('ter[TERMINAL_ADDRESS]', 'Terminal Address', 'required|min_length[2]|trim');
     
        if ($this->form_validation->run()) {
            $terdatas = [
                'TERMINAL_ID' => postData($specterminalDatas, 'TERMINAL_ID'),
                'TERMINAL_SHORTNAME' => postData($specterminalDatas, 'TERMINAL_SHORTNAME'),
                'TERMINAL_NAME' => postData($specterminalDatas, 'TERMINAL_NAME'),
                'TERMINAL_EMAIL' => postData($specterminalDatas, 'TERMINAL_EMAIL'),
                'TERMINAL_PHONE' => postData($specterminalDatas, 'TERMINAL_PHONE'),
                'TERMINAL_MOBILE' => postData($specterminalDatas, 'TERMINAL_MOBILE'),
                'TERMINAL_ZIPCODE' => postData($specterminalDatas, 'TERMINAL_ZIPCODE'),
                'TERMINAL_ADDRESS' => postData($specterminalDatas, 'TERMINAL_ADDRESS')
            ];
//            print_r($locdatas);exit;
            if ($did != '') {
                $upWhere = [
                    'TER_AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(TER_MAN, $terdatas, $upWhere);
//            echo $this->db->last_query();exit;
            } else {
                $updtProfile = $this->common_model->updateData(TER_MAN, $terdatas);
//                echo $this->db->last_query();exit;
            }

            if ($updtProfile) {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Terminal has been Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Terminal has been Created</div>');
                }
                redirect('master/terminal/terminalinfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Terminal cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Terminal cannot be Created</div>');
                }
                redirect('master/terminal/terminalinfo');
            }
        } else {
            $this->addLocation($id);
        }
    }

    public function deleteTerminal() {
        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(TER_MAN, ['TERMINAL_STATUS' => 'N'], ['TER_AUTO_ID' => decryptval($deleteId)]);
        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Terminal has been deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Terminal! Try Again later.'
            ];
        }
        echo json_encode($retData);
    }
    
     public function view($id = '') {
        $editData = FALSE;
        if ($id != '') {
            $did = decryptval($id);
           
             $optWhr['where'] = [
                'TER_AUTO_ID' => $did,
                'TERMINAL_STATUS' => 'Y'
            ];
            $optWhr['return_type'] = 'row';
            $editData = $this->common_model->getAlldata(TER_MAN, ['*'], $optWhr);
        }

        $data = [
            'view_file' => 'master/terminal/view_report',
            'current_menu' => 'View Terminal',
            'editData' => $editData
            
        ];

        //  echo "<pre>";
       // print_r($data);exit;

        $this->template->load_common_template($data);
    }

   public function viewDes($id = '') {
    
        $editData = FALSE;
        if ($id != '') {
            $did = decryptval($id);
           
             $optWhr['where'] = [
                'DESIGNATION_ID' => $did
            ];
            $optWhr['return_type'] = 'row';
            $optWhr['join'][UTYPE.' as utyp'] = ['utyp.USER_TYPE_ID = des.DES_USER_TYPE','left'];
            $editData = $this->common_model->getAlldata(DES.' as des', ['*'], $optWhr);
           
        }

        $data = [
            'view_file' => 'master/designation/view_report',
            'current_menu' => 'View Designation',
            'editData' => $editData
            
        ];

        //  echo "<pre>";
       // print_r($data);exit;

        $this->template->load_common_template($data);
    }


    

            }
