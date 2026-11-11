<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inspection extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(1);
        isLogin();
        $this->load->helper('atar_helper');
        $this->load->helper('inspection_helper');
       
    }
    
    public function index(){
        
         $data = array(
            'view_file' => 'master/inspection_checklist/list_checklist',
            'site_title' => 'Inspection Checklist ',
            'current_menu' => 'List Inspection Checklist ',
            'ajaxurl' => 'inspection/list_inspchecklist',
        );

        $this->template->load_table_template($data);
    }
    
     public function list_inspchecklist() {
        $table = INSP_CL_TYP;
        $column_order = array(null, 'INSP_CHECK_TYP_NAME', 'CREATED_ON', null);
        $column_search = array('INSP_CHECK_TYP_NAME', 'CREATED_ON');
        $order = array('INSP_CHECK_TYP_ID' => 'desc');
        $where = ['INSP_CHECK_TYP_STATUS' => 'Y'];

        $listResp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where);
//echo $this->db->last_query();
//print_R($listResp);
//exit;
        $finalDatas = [];
        $i = 0;
        if(isset($listResp) && !empty($listResp)){
        foreach ($listResp as $ltKey => $ltVal) {
            $i++;
            $action = '';
            $id = encryptval($ltVal->INSP_CHECK_TYP_ID);

            $action .= " " . anchor('inspection/addInsp_checklist/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'resptarget', 'title' => 'Edit'));

            $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteInspchecklist', 'title' => 'Delete', 'delt-id' => $id));
            //$action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

            $rows = [];
//            $rows[] = $i;
            $rows[] = $ltVal->INSP_CHECK_TYP_NAME;
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
    
      public function addInsp_checklist($id = '') {

        $getRespdatas = [];
        if ($id != '') {
            $optWhr['where'] = [
                'INSP_CHECK_TYP_ID' => decryptval($id)
            ];
            $optWhr['return_type'] = 'row';
            $getRespdatas = $this->common_model->getAlldata(INSP_CL_TYP, ['*'], $optWhr);
        }

        $data = array(
            'view_file' => 'master/inspection_checklist/add_checklist',
            'current_menu' => 'Add Inspection Checklist',
            'getRespdatas' => $getRespdatas
        );
        $this->template->load_popup_template($data);
    }
    
     public function saveInsp_checklist() {

        $getrespdatas = $this->input->post('insp');
        $hidEditrespid = postData($getrespdatas, 'hiddenrespID');
        if($hidEditrespid == '') {
             $this->form_validation->set_rules('insp[checklist_name]', 'Checklist Type Name', 'required|min_length[3]|max_length[50]|is_unique[INSP_CHECKLIST_TYPE.INSP_CHECK_TYP_NAME]');
        } else {
        $this->form_validation->set_rules('insp[checklist_name]', 'Checklist Type Name', 'required|min_length[3]|max_length[50]');
        }
// print_r($this->input->post());
        if ($this->form_validation->run() == true) {
            $getrespdatas = $this->input->post('insp');

            $hidEditrespid = postData($getrespdatas, 'hiddenrespID');
            $respdatas = [
                'INSP_CHECK_TYP_NAME' => postData($getrespdatas, 'checklist_name'),
//            'LOC_TYPE_STATUS' => 'Y',
            ];
            $updtWhr = [];
            if ($hidEditrespid != '') {
                $updtWhr = [
                    'INSP_CHECK_TYP_ID' => $hidEditrespid
                ];
            }

            $updRoletyp = $this->common_model->updateData(INSP_CL_TYP, $respdatas, $updtWhr);
//echo $this->db->last_query();
//print_r($updRoletyp);
//exit;
            if (($updRoletyp)) {

                $data = [
                    'status' => true
                ];
                if ($hidEditrespid != '') {
                    $data['flasmsg'] = $this->session->set_flashdata('respflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span><i class="fa fa-check-circle"></i> Success!</span> Inspection Checklist has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('respflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span><i class="fa fa-check-circle"></i> Success!</span> Inspection Checklist has been Created</div>');
                }
            } else {
                $data = [
                    'status' => false
                ];
                if ($hidEditrespid != '') {
                    $data['flasmsg'] = $this->session->set_flashdata('respflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span><i class="fa fa-times-circle"></i> Sorry!</span> Inspection Checklist cannot be Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('respflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span><i class="fa fa-times-circle"></i> Sorry!</span> Inspection Checklist cannot be Created</div>');
                }

//          redirect('master/addLocatype/');
            }
        } else {

            $data = [
                'status' => 'error',
                'checklist_name' => strip_tags(form_error('insp[checklist_name]')),
            ];
        }
        echo json_encode($data);
    }
    
     public function deleteInsp_checklist() {

        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(INSP_CL_TYP, ['INSP_CHECK_TYP_STATUS' => 'N'], ['INSP_CHECK_TYP_ID' => decryptval($deleteId)]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Inspection Checklist deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Inspection Checklist'
            ];
        }
        echo json_encode($retData);
    }
    
    //////insp checklist subtype master start
    public function insp_clsubtype() {
        $data = array(
            'view_file' => 'master/checklist_subtype/list_subtype',
            'site_title' => 'Checklist Subtype',
            'current_menu' => 'List Checklist Subtype',
            'ajaxurl' => 'inspection/list_insp_subtype',
        );

        $this->template->load_table_template($data);
    }

    public function list_insp_subtype() {
        $table = INSP_CL_SUBTYP . ' as subtype';
        $column_order = array(null, 'INSP_CHECK_TYP_NAME', 'INSP_CHECK_SUBTYP_NAME', 'CREATED_ON', null);
        $column_search = array('INSP_CHECK_TYP_NAME', 'INSP_CHECK_SUBTYP_NAME', 'CREATED_ON');
        $order = array('INSP_CHECK_SUBTYP_ID' => 'desc');
        $where = ['INSP_CHECK_SUBTYP_STATUS' => 'Y'];
        $optns['select'] = 'subtype.INSP_CHECK_SUBTYP_ID,subtype.INSP_CHECK_SUBTYP_TYPID,subtype.CREATED_ON,group_concat(subtype.INSP_CHECK_SUBTYP_NAME) as INSP_CHECK_SUBTYP_NAME,typ.INSP_CHECK_TYP_NAME';
        $optns['join'][INSP_CL_TYP . ' as typ'] = ['typ.INSP_CHECK_TYP_ID = subtype.INSP_CHECK_SUBTYP_TYPID', 'left'];
        $optns['group_by'] = 'INSP_CHECK_SUBTYP_TYPID';

        $listInscomp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $optns);

        $finalDatas = [];
        $i = 0;

        if (!empty($listInscomp)) {
            foreach ($listInscomp as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->INSP_CHECK_SUBTYP_TYPID);

                $action .= " " . anchor('inspection/add_insp_subtype/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));

                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deletesubtype', 'title' => 'Delete', 'delt-id' => $id));
                //$action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

                $rows = [];
                $rows[] = $ltVal->INSP_CHECK_TYP_NAME;
                $rows[] = $ltVal->INSP_CHECK_SUBTYP_NAME;
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

    public function add_insp_subtype($id = '') {
        $did = decryptval($id);
        $getSubtypedatas = [];

        $options['where'] = ['INSP_CHECK_TYP_STATUS' => 'Y'];
        $getInsptype = $this->common_model->getAlldata(INSP_CL_TYP, ['*'], $options);
        $dropInsptype = customFormDropDown($getInsptype, 'INSP_CHECK_TYP_ID', 'INSP_CHECK_TYP_NAME', 'Select Checklist Type');


        if ($id != '') {
            $optWhr['where'] = [
                'INSP_CHECK_SUBTYP_TYPID' => $did,
                'INSP_CHECK_SUBTYP_STATUS !=' => 'N'
            ];
            $getSubtypedatas = $this->common_model->getAlldata(INSP_CL_SUBTYP, ['*'], $optWhr);
        }

        $data = array(
            'view_file' => 'master/checklist_subtype/add_subtype',
            'current_menu' => 'Add Checklist Subtype ',
            'getSubtypedatas' => $getSubtypedatas,
            'dropInsptype' => $dropInsptype,
        );
        $this->template->load_common_template($data);
    }

    public function save_insp_subtype($ids = '') {
        $did = decryptval($ids);

        $insprojDatas = $this->input->post('insp');

        $this->form_validation->set_rules('insp[checklist_type]', 'Checklist Type', 'required|trim');
        $subTypedatas = $this->input->post('insp[subtype]');
        $checktyid = $this->input->post('insp[checklist_type]');
        $prevchecktyid = $this->input->post('insp[checklist_typeedit]');

        $subTypeID = $this->input->post('insp[hid_subtyp]');
        
        $subTypeIDnew = [];
        if($prevchecktyid != $checktyid){
            $hidCLidOptn['where'] = [
               'INSP_CHECK_SUBTYP_TYPID' => $checktyid,
               'INSP_CHECK_SUBTYP_STATUS!=' => 'N'
            ];
           $getNewcldatas =  $this->common_model->getAlldata(INSP_CL_SUBTYP,['*'],$hidCLidOptn);
         
           if(isset($getNewcldatas) && !empty($getNewcldatas)){
               foreach($getNewcldatas as $clnKey => $clnVal){
                   $subTypeIDnew[] = $clnVal->INSP_CHECK_SUBTYP_ID;
               }
           }
//           $causeAnalID[] = $causeAnalID;
        }
        
        $subTypeID = array_merge($subTypeID,$subTypeIDnew);
        $subTypeIDArra = [];
        if(!empty($subTypeID)){
            $subTypeIDArra = array_keys($subTypeID);
        }

       
        if ($this->form_validation->run() == true) {

            if($prevchecktyid == $checktyid){
            $optns['where'] = [
                'INSP_CHECK_SUBTYP_TYPID' => $checktyid,
                'INSP_CHECK_SUBTYP_STATUS!=' => 'N'
            ];
            }else{
               $checktyidar[] = $checktyid;
                $prevchecktyidar[] = $prevchecktyid;
                $optns['where_in'] = [
                    'INSP_CHECK_SUBTYP_TYPID' => array_merge($checktyidar,$prevchecktyidar),
                   
                ];
                $optns['where'] = [
                     'INSP_CHECK_SUBTYP_STATUS!=' => 'N'
                ];
            }

            $getAllsubtypdatas = $this->common_model->getAlldata(INSP_CL_SUBTYP, ['*'], $optns);

            if (isset($getAllsubtypdatas) && !empty($getAllsubtypdatas)) {
                foreach ($getAllsubtypdatas as $gsKey => $gsVal) {
                    $editSubtypdataid = $gsVal->INSP_CHECK_SUBTYP_ID;
                    if (!in_array($editSubtypdataid, $subTypeID) && !empty($subTypeID)) {
                        $getDeltid = $editSubtypdataid;
                        $insCdatas = [
                            'INSP_CHECK_SUBTYP_STATUS' => 'N'
                        ];
                        $upWhere = [
                            'INSP_CHECK_SUBTYP_ID' => $getDeltid
                        ];
                        $updtProfile = $this->common_model->updateData(INSP_CL_SUBTYP, $insCdatas, $upWhere);
                    }
                }
            }

            foreach ($subTypedatas as $sKey => $sVal) {
                $insCdatas = [
                    'INSP_CHECK_SUBTYP_TYPID' => postData($insprojDatas, 'checklist_type'),
                    'INSP_CHECK_SUBTYP_NAME' => $sVal,
                ];
                if ($did != '') {


                    if (in_array($sKey, $subTypeIDArra)) {

                        $upWhere = [
                            'INSP_CHECK_SUBTYP_ID' => $subTypeID[$sKey]
                        ];
                        $updtProfile = $this->common_model->updateData(INSP_CL_SUBTYP, $insCdatas, $upWhere);
                    } else {

                        $updtProfile = $this->common_model->updateData(INSP_CL_SUBTYP, $insCdatas);
                    }
//            echo $this->db->last_query();exit;
                } else {
                    $updtProfile = $this->common_model->updateData(INSP_CL_SUBTYP, $insCdatas);
//            echo $this->db->last_query();exit;
                }
            }

            if ($updtProfile) {
                if ($did != '') {
                    $this->session->set_flashdata('clsubflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span><i class="fa fa-check-circle"></i> Success!</span> Checklist Subtype has been Updated</div>');
                } else {
                    $this->session->set_flashdata('clsubflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span><i class="fa fa-check-circle"></i> Success!</span> Checklist Subtype has been Created</div>');
                }
                redirect('inspection/insp_clsubtype');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('clsubflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span<i class="fa fa-times-circle"></i> Sorry!</span> Checklist Subtype cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('clsubflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span><i class="fa fa-times-circle"></i> Sorry!</span> Checklist Subtype cannot be Created</div>');
                }
                redirect('inspection/insp_clsubtype');
            }
        } else {
            $this->add_insp_subtype();
        }
    }

    public function delete_insp_subtype() {
        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(INSP_CL_SUBTYP, ['INSP_CHECK_SUBTYP_STATUS' => 'N'], ['INSP_CHECK_SUBTYP_TYPID' => decryptval($deleteId)]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Inspection Checklist Subtype deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Inspection Checklist Subtype'
            ];
        }
        echo json_encode($retData);
    }

   
//////insp checklist subtype master end
    
    //////insp checklist subtype data master start
    public function insp_clsubtypedata() {
        $data = array(
            'view_file' => 'master/checklist_subtype_data/list_subtype_data',
            'site_title' => 'Checklist Subtype Data',
            'current_menu' => 'List Checklist Subtype Data',
            'ajaxurl' => 'inspection/list_insp_subtypedata',
        );

        $this->template->load_table_template($data);
    }

    public function list_insp_subtypedata() {
        $table = INSP_CL_SUBTYP_DATA . ' as st_data';
        $column_order = array(null, 'INSP_CHECK_TYP_NAME', 'INSP_CHECK_SUBTYP_NAME', 'INSP_SUBTYP_DATA_DESC', 'CREATED_ON', null);
        $column_search = array('INSP_CHECK_TYP_NAME', 'INSP_CHECK_SUBTYP_NAME', 'INSP_SUBTYP_DATA_DESC', 'CREATED_ON');
        $order = array('INSP_SUBTYP_DATA_ID' => 'desc');
        $where = ['INSP_SUBTYP_DATA_STATUS' => 'Y'];
        $optns['select'] = 'st_data.*,group_concat(st_data.INSP_SUBTYP_DATA_DESC) as INSP_SUBTYP_DATA_DESCS,typ.INSP_CHECK_TYP_NAME,subtyp.INSP_CHECK_SUBTYP_NAME';
        $optns['join'][INSP_CL_TYP . ' as typ'] = ['typ.INSP_CHECK_TYP_ID = st_data.INSP_SUBTYP_DATA_TYPID', 'left'];
        $optns['join'][INSP_CL_SUBTYP . ' as subtyp'] = ['subtyp.INSP_CHECK_SUBTYP_ID = st_data.INSP_SUBTYP_DATA_SUBTYPID', 'left'];
        $optns['group_by'] = 'INSP_SUBTYP_DATA_TYPID,INSP_SUBTYP_DATA_SUBTYPID';

        $listInscomp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $optns);

        $finalDatas = [];
        $i = 0;

        if (!empty($listInscomp)) {
            foreach ($listInscomp as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $sid = encryptval($ltVal->INSP_SUBTYP_DATA_SUBTYPID);
                $cid = encryptval($ltVal->INSP_SUBTYP_DATA_TYPID);

                $action .= " " . anchor('inspection/add_insp_subtypedata/' . $sid.'/'.$cid, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));

                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deletesubtypedata', 'title' => 'Delete', 'delt-id' => $sid.'-'.$cid));
                //$action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

                $rows = [];
                $rows[] = $ltVal->INSP_CHECK_TYP_NAME;
                $rows[] = $ltVal->INSP_CHECK_SUBTYP_NAME;
                $rows[] = '<span id="stylDEsc">'.$ltVal->INSP_SUBTYP_DATA_DESCS.'</span>';
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

    public function add_insp_subtypedata($sid = '',$cid="") {
        if($sid != ''){
            $did = decryptval($sid);
        }
        $enchkID = decryptval($cid);
//       echo $did;
//       echo $enchkID;
//       exit;
        $getSubtypedatas = [];

        $optionTyp['where'] = ['INSP_CHECK_TYP_STATUS' => 'Y'];
        $getInsptype = $this->common_model->getAlldata(INSP_CL_TYP, ['*'], $optionTyp);
        $dropInsptype = customFormDropDown($getInsptype, 'INSP_CHECK_TYP_ID', 'INSP_CHECK_TYP_NAME', 'Select Checklist Type');

        $optionsubTyp['where'] = ['INSP_CHECK_SUBTYP_STATUS' => 'Y'];
        $getInsptypedata = $this->common_model->getAlldata(INSP_CL_SUBTYP, ['*'], $optionsubTyp);
        $dropInsptypedata = customFormDropDown($getInsptypedata, 'INSP_CHECK_SUBTYP_ID', 'INSP_CHECK_SUBTYP_NAME', 'Select Checklist Subtype');


        if ($did != 0) {
//            echo $sid;
            $optWhr['where'] = [
                'INSP_SUBTYP_DATA_SUBTYPID' => $did,
                'INSP_SUBTYP_DATA_STATUS !=' => 'N'
            ];
            $getSubtypedatas = $this->common_model->getAlldata(INSP_CL_SUBTYP_DATA, ['*'], $optWhr);
        }else{
           $optWhr['where'] = [
                'INSP_SUBTYP_DATA_TYPID' => $enchkID,
                'INSP_SUBTYP_DATA_STATUS !=' => 'N'
            ];
            $getSubtypedatas = $this->common_model->getAlldata(INSP_CL_SUBTYP_DATA, ['*'], $optWhr); 
        }
//exit;
        $data = array(
            'view_file' => 'master/checklist_subtype_data/add_subtype_data',
            'current_menu' => 'Add Checklist Subtype Data',
            'getSubtypedatas' => $getSubtypedatas,
            'dropInsptypedata' => $dropInsptypedata,
            'dropInsptype' => $dropInsptype,
        );
        $this->template->load_common_template($data);
    }

    public function save_insp_subtypedata($ids = '',$cid='') {
        $did = decryptval($ids);
        
//        echo "<pre>";
//        print_R($this->input->post());
//        exit;

        $insprojDatas = $this->input->post('insp');

        $editSubid = $this->input->post('insp[edit_subtyp]');


        $this->form_validation->set_rules('insp[checklist_type]', 'Checklist Type', 'required|trim');
//        $this->form_validation->set_rules('insp[checklist_subtype]', 'Checklist Subtype', 'required|trim');
        $subTypedatas = $this->input->post('insp[subtype]');

        $checkSubtyid = $this->input->post('insp[checklist_subtype]');
        $prevcheckSubtyid = $this->input->post('insp[checklist_subtypeedit]');
        $prevcheckid = $this->input->post('insp[checklist_typeedit]');

        $subTypeID = $this->input->post('insp[hid_subtyp]');
        
          $subTypeIDnew = [];
        if($checkSubtyid != $prevcheckSubtyid){
            $hidCLidOptn['where'] = [
               'INSP_SUBTYP_DATA_SUBTYPID' => $checkSubtyid,
                'INSP_SUBTYP_DATA_STATUS!=' => 'N'
            ];
           $getNewcldatas =  $this->common_model->getAlldata(INSP_CL_SUBTYP_DATA,['*'],$hidCLidOptn);
         
           if(isset($getNewcldatas) && !empty($getNewcldatas)){
               foreach($getNewcldatas as $clnKey => $clnVal){
                   $subTypeIDnew[] = $clnVal->INSP_SUBTYP_DATA_ID;
               }
           }

        }
        
        $subTypeID = array_merge($subTypeID,$subTypeIDnew);
        
        $subTypeIDArra = [];
        if(!empty($subTypeID)){
            $subTypeIDArra = array_keys($subTypeID);
        }

        if ($this->form_validation->run() == true) {

            if($checkSubtyid == $prevcheckSubtyid){
                if($checkSubtyid != ''){
                    $optns['where'] = [
                        'INSP_SUBTYP_DATA_SUBTYPID' => $checkSubtyid,
                        'INSP_SUBTYP_DATA_STATUS!=' => 'N'
                    ];
                }else{
                    $optns['where'] = [
                        'INSP_SUBTYP_DATA_SUBTYPID' => $checkSubtyid,
                        'INSP_SUBTYP_DATA_TYPID' => postData($insprojDatas, 'checklist_type'),
                        'INSP_SUBTYP_DATA_STATUS!=' => 'N'
                    ];
                }
            
             }else{
                
                $checkSubtyidar[] = $checkSubtyid;
                $prevcheckSubtyidar[] = $prevcheckSubtyid;
                $optns['where_in'] = [
                    'INSP_SUBTYP_DATA_SUBTYPID' => array_merge($checkSubtyidar,$prevcheckSubtyidar),
                   
                ];
                
                $optns['where'] = [
                     'INSP_SUBTYP_DATA_STATUS!=' => 'N'
                ];
                if($prevcheckSubtyid == ''){
                    $optns['where']['INSP_SUBTYP_DATA_TYPID'] = postData($insprojDatas, 'checklist_type');
                }
            }

            $getAllsubtypdatas = $this->common_model->getAlldata(INSP_CL_SUBTYP_DATA, ['*'], $optns);
//            echo "<pre>";
//            echo $this->db->last_query();
//            print_R($getAllsubtypdatas);
//            exit;
            if (isset($getAllsubtypdatas) && !empty($getAllsubtypdatas)) {
                foreach ($getAllsubtypdatas as $gsKey => $gsVal) {
                    $editSubtypdataid = $gsVal->INSP_SUBTYP_DATA_ID;
                    
                    if (!in_array($editSubtypdataid, $subTypeID) && !empty($subTypeID)) {
                        $getDeltid = $editSubtypdataid;
                        $insCdatas = [
                            'INSP_SUBTYP_DATA_STATUS' => 'N'
                        ];
                        $upWhere = [
                            'INSP_SUBTYP_DATA_ID' => $getDeltid
                        ];
                        $updtProfile = $this->common_model->updateData(INSP_CL_SUBTYP_DATA, $insCdatas, $upWhere);
                    }
                }
            }

            foreach ($subTypedatas as $sKey => $sVal) {
                $insCdatas = [
                    'INSP_SUBTYP_DATA_TYPID' => postData($insprojDatas, 'checklist_type'),
                    'INSP_SUBTYP_DATA_SUBTYPID' => postData($insprojDatas, 'checklist_subtype'),
                    'INSP_SUBTYP_DATA_DESC' => $sVal,
                ];
                if ($did != '') {

                    if (in_array($sKey, $subTypeIDArra)) {

                        $upWhere = [
                            'INSP_SUBTYP_DATA_ID' => $subTypeID[$sKey]
                        ];
                        $updtProfile = $this->common_model->updateData(INSP_CL_SUBTYP_DATA, $insCdatas, $upWhere);
                    } else {

                        $updtProfile = $this->common_model->updateData(INSP_CL_SUBTYP_DATA, $insCdatas);
                    }
//            echo $this->db->last_query();exit;
                } else {
                    $updtProfile = $this->common_model->updateData(INSP_CL_SUBTYP_DATA, $insCdatas);
//            echo $this->db->last_query();exit;
                }
            }


            if ($updtProfile) {
                if ($ids != '') {
                    $this->session->set_flashdata('clsubflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span><i class="fa fa-check-circle"></i> Success!</span> Checklist Subtype Data has been Updated</div>');
                } else {
                    $this->session->set_flashdata('clsubflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span><i class="fa fa-check-circle"></i> Success!</span> Checklist Subtype Data has been Created</div>');
                }
                redirect('inspection/insp_clsubtypedata');
            } else {
                if ($ids != '') {
                    $this->session->set_flashdata('clsubflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span><i class="fa fa-times-circle"></i> Sorry!</span> Checklist Subtype Data cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('clsubflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span><i class="fa fa-times-circle"></i> Sorry!</span> Checklist Subtype Data cannot be Created</div>');
                }
                redirect('inspection/insp_clsubtypedata');
            }
        } else {
            $this->add_insp_subtypedata();
        }
    }

    public function delete_insp_subtypedata() {
        $deleteId = $this->input->post('delid');
        
        $expTypids = explode("-",$deleteId);
        $subtypId = $expTypids[0];
        $chkId = $expTypids[1];
        
        $decSubtyp = decryptval($subtypId);
        $decChk = decryptval($chkId);
       
        if($decSubtyp != 0){
            $dataWhr = [
               'INSP_SUBTYP_DATA_SUBTYPID' => $decSubtyp,
               'INSP_SUBTYP_DATA_TYPID' => $decChk,
            ];
        }else{
            $dataWhr = [
                'INSP_SUBTYP_DATA_TYPID' => $decChk
            ];
        }
        $updtDelete = $this->common_model->updateData(INSP_CL_SUBTYP_DATA, ['INSP_SUBTYP_DATA_STATUS' => 'N'], $dataWhr);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Inspection Checklist Subtype Data deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Inspection Checklist Subtype Data'
            ];
        }
        echo json_encode($retData);
    }
    
     public function getAjaxChecksubtyp(){
        $checkTypid = $this->input->post('checkTypid');
        
        $options['where'] = ['INSP_CHECK_SUBTYP_STATUS' => 'Y','INSP_CHECK_SUBTYP_TYPID' => $checkTypid];
        $getInsptypedata = $this->common_model->getAlldata(INSP_CL_SUBTYP, ['*'], $options);
        $dropInsptypedata = customFormDropDown($getInsptypedata, 'INSP_CHECK_SUBTYP_ID', 'INSP_CHECK_SUBTYP_NAME', 'Select Checklist Type Data');

        $chStatus = (!empty($dropInsptypedata)) ? true : false;
        $chdatas = (!empty($dropInsptypedata)) ? $dropInsptypedata : [];
        $checkdatas = [
            'status' => $chStatus,
            'chdatas' => $chdatas,
        ];
        
        echo json_encode($checkdatas);
    }

//////insp checklist subtype data master end
    
    public function Inspectionlist(){
      
        $data = array(
            'view_file' => 'list_inspection',
            'site_title' => 'HSSE Inspection',
            'current_menu' => 'List HSSE Inspection',
            'ajaxurl' => 'inspection/list_inspection',
           
        );

        $this->template->load_table_template($data);
    }
    
    public function list_inspection(){
        $table = HSSE_INSP_MAIN.' as insp';
        $column_order = array(null, 'INSP_ID', 'INSPECTION_DATE', 'INSP_MOD_NAME_NUM','TERMINAL_NAME','DEPT_NAME', null);
        $column_search = array('INSP_ID', 'INSPECTION_DATE', 'INSP_MOD_NAME_NUM','TERMINAL_NAME','DEPT_NAME');
        $order = array('INSP_AUTO_ID' => 'desc');
        $where = ['INSP_STATUS' => 'Y'];
        
        $options['join'][TERM.' as term'] = ['term.TER_AUTO_ID = insp.INSP_TER_ID','left'];
        $options['join'][DEPT.' as dept'] = ['dept.DEPT_AUTO_ID = insp.INSP_DEPT_ID','left'];
        $listLocatn = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where,$options);
       
        $finalDatas = [];
        if(isset($listLocatn) && !empty($listLocatn)){
        foreach ($listLocatn as $ltKey => $ltVal) {

            $action = '';
            $id = $ltVal->INSP_AUTO_ID;
            $verifierid = $ltVal->INSP_VERIFY_ID;
            $curUserId = getParticsessdata('LOGIN_ID');
//         echo "<pre>";
//         print_r(getParticsessdata());
//         exit;
            $eid = encryptval($id);
            
            if($ltVal->INSP_APP_STATUS == 1){
                $inspStatus = '<label class="btn btn-xs btn-info" style="color:#fff">Verify Pending</label>';
                if($verifierid == $curUserId){
                    $action .= " " . anchor('inspection/addInspection/' . $eid, '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));
                }
            }else{
                $inspStatus = '<label class="btn btn-xs btn-success">Verified</label>';
                
                }
                
                if($ltVal->INSP_APP_STATUS != ''){
                    $action .= " " . anchor('inspection/viewInspection/' . $eid, '<i class="fas fa-eye aria-hidden="true"></i>', array('class' => '', 'title' => 'View'));
                }
                if($ltVal->INSP_APP_STATUS != 1){
                    $action .= " " . anchor('inspection/pdfInspection/' . $eid, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF'));
                }
                if(postData($ltVal,'INSP_HSSE_ID') == getParticsessdata('USER_REF_ID')){
             $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteInspection', 'title' => 'Delete', 'delt-id' => $eid));
                }
            $rows = [];
            $rows[] = $ltVal->INSP_ID;
            $rows[] = date("d-m-Y",strtotime($ltVal->INSPECTION_DATE));
            $rows[] = $ltVal->INSP_MOD_NAME_NUM;
            $rows[] = $ltVal->TERMINAL_NAME;
            $rows[] = $ltVal->DEPT_NAME;
            $rows[] = $inspStatus;
           
            $rows[] = $action;
            $finalDatas[] = $rows;
        }
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->common_model->count_all($table, $column_order, $column_search, $order),
            "recordsFiltered" => $this->common_model->count_filtered($table, $column_order, $column_search, $order),
            "data" => $finalDatas,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function addInspection($id = '') {
        
        $did = decryptval($id);
        $uniqInspidwhr = [];
        if ($id != '') {
            $uniqInspidwhr = [
                'INSP_AUTO_ID' => $did
            ];
        }

        $inspidUniq = uniqueIntRefId('INSP',HSSE_INSP_MAIN , 'INSP_AUTO_ID', 'INSP_AUTO_ID', $uniqInspidwhr);
       
        $termOptn['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $getAllterminal = $this->common_model->getAlldata(TERM, ['*'], $termOptn);
        $dropTermname = customFormDropDown($getAllterminal, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');
        
        $deptOptn['where'] = [
            'DEPT_STATUS' => 'Y'
        ];
        $getAlldept = $this->common_model->getAlldata(DEPT, ['*'], $deptOptn);
        $dropDepart = customFormDropDown($getAlldept, 'DEPT_AUTO_ID', 'DEPT_NAME', 'Select Department');
       
        $checkOptn['where'] = [
            'INSP_CHECK_TYP_STATUS' => 'Y'
        ];
        $getChecklistdata = $this->common_model->getAlldata(INSP_CL_TYP,['*'],$checkOptn);
        $dropChecklist = customFormDropDown($getChecklistdata, 'INSP_CHECK_TYP_ID', 'INSP_CHECK_TYP_NAME','Select Checklist Type');

        $hsMainoptn['where'] = [
            'INSP_AUTO_ID' => $did,
            'INSP_STATUS' => 'Y',
        ];
        $hsMainoptn['return_type'] = 'row';
        $getHssemaindatas = $this->common_model->getAlldata(HSSE_INSP_MAIN.' as main',['*'],$hsMainoptn);
       
        $hsChkoptn['where'] = [
            'FK_INSP_ID' => $did,
            'INSP_IMG_STATUS' => 'Y',
        ];
//        $hsChkoptn['return_type'] = 'row';
        $hsChkoptn['join'][INSP_CL_SUBTYP.' as subtyp'] = ['subtyp.INSP_CHECK_SUBTYP_ID = chk.FK_SUB_CAT_ID','left'];
        $hsChkoptn['join'][INSP_CL_SUBTYP_DATA.' as subtypdata'] = ['subtypdata.INSP_SUBTYP_DATA_ID = chk.FK_INSP_QNS_ID','left'];
        $hsChkoptn['group_by'] = 'subtyp.INSP_CHECK_SUBTYP_ID';
        $getEditinspect = $this->common_model->getAlldata(HSSE_INSP_CHK.' as chk',['chk.*,GROUP_CONCAT(DISTINCT subtyp.INSP_CHECK_SUBTYP_NAME) as subTyp,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_ID order by chk.INSP_CHK_AUTO_ID asc) as subTypdataID,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_DESC order by chk.INSP_CHK_AUTO_ID asc) as subTypdata,GROUP_CONCAT(CONCAT(chk.INSP_GOOD_POOR,"-",chk.FK_INSP_QNS_ID)  order by chk.INSP_CHK_AUTO_ID asc) as goodPoor,GROUP_CONCAT(chk.INSP_REMARK order by chk.INSP_CHK_AUTO_ID asc) as remaRk,GROUP_CONCAT(chk.INSP_FILENAME order by chk.INSP_CHK_AUTO_ID asc) as fileName,GROUP_CONCAT(DISTINCT chk.INSP_FILE_PATH order by chk.INSP_CHK_AUTO_ID asc) as filePath,GROUP_CONCAT(chk.INSP_QN_DESC order by chk.INSP_CHK_AUTO_ID asc) as quesDesc'],$hsChkoptn);
      
        if(isset($getEditinspect) && !empty($getEditinspect)){
            foreach($getEditinspect as $gdKey => $gdVal){
                $getSubtypedataID = explode(",",$gdVal->subTypdataID);
                $getSubtypeID = $gdVal->FK_SUB_CAT_ID;
                $getChktypeID = $gdVal->FK_CHK_LIST_ID;
                
                $sdDataoptns['where'] = [
                    'INSP_SUBTYP_DATA_STATUS' => 'Y',
                    'INSP_SUBTYP_DATA_SUBTYPID' => $getSubtypeID,
                    'INSP_SUBTYP_DATA_TYPID' => $getChktypeID,
                ];
            $getSubtydataDet = $this->common_model->getAlldata(INSP_CL_SUBTYP_DATA.' as sd',['GROUP_CONCAT(sd.INSP_SUBTYP_DATA_DESC  order by sd.INSP_SUBTYP_DATA_ID asc SEPARATOR "@") AS SUBTYPEDATADESC,GROUP_CONCAT(sd.INSP_SUBTYP_DATA_ID order by sd.INSP_SUBTYP_DATA_ID asc) AS SUBTYPEDATAID'],$sdDataoptns);
            
                if(isset($getSubtydataDet) && !empty($getSubtydataDet)){
                foreach($getSubtydataDet as $sdKey => $sdVal){
                  $getEditsubData['subTypdataID'][$sdKey] =  $sdVal->SUBTYPEDATAID;
                  $getEditsubData['subTypdata'][$sdKey] =  $sdVal->SUBTYPEDATADESC;

                }
               
                $gdVal->subTypdataID = implode(",",$getEditsubData['subTypdataID']);
                $gdVal->subTypdata = implode(",",$getEditsubData['subTypdata']);
                }
            }
                }
//               echo "<pre>";
//               echo $this->db->last_query();
//               print_R($getEditinspect);
//               exit;
             
        $sessDatas = $this->session->userinfo;
        
                $emplnOptn['where'] = [
                     'EMP_AUTO_ID' => postData($sessDatas,'USER_REF_ID')
                 ];
                 $emplnOptn['return_type'] = 'row';
                 $emplnName = $this->common_model->getAlldata(EMPLOYEE_MANAGEMENT,['EMP_NAME'],$emplnOptn);
        $sessUser = $emplnName->EMP_NAME;
    
        $addmorImgoptns['where'] = [
            'INSP_NOT_IMG_INSP_ID' => $did,
            'INSP_NOT_IMG_STATUS' => 'Y',
        ];
        $getAllmoreimages = $this->common_model->getAlldata(HSSE_INSP_IMAGE,['*'],$addmorImgoptns);
        
        $data = array(
            'view_file' => 'inspection/add_Inspection',
            'current_menu' => 'Add Inspection',
            'dropTermname' => $dropTermname,
            'dropDepart' => $dropDepart,
            'dropChecklist' => $dropChecklist,
            'inspidUniq' => $inspidUniq,
            'getHssemaindatas' => $getHssemaindatas,
            'getEditinspect' => $getEditinspect,
            'sessUser' => $sessUser,
            'getAllmoreimages' => $getAllmoreimages,
           
        );
        $this->template->load_common_template($data);
    }
    
//    public function getAjaxinspSubtyp(){
//       $checklistId = $this->input->post('checklistId');
//       
//       $inspOptns['where'] = [
//           'stypdata.INSP_SUBTYP_DATA_TYPID' => $checklistId,
//           'styp.INSP_CHECK_SUBTYP_STATUS' => 'Y',
//           'stypdata.INSP_SUBTYP_DATA_STATUS' => 'Y',
//       ];
//       
//       $inspOptns['join'][INSP_CL_SUBTYP_DATA.' stypdata'] = ['stypdata.INSP_SUBTYP_DATA_SUBTYPID = styp.INSP_CHECK_SUBTYP_ID','left'];
//       
//       $inspOptns['group_by'] = 'styp.INSP_CHECK_SUBTYP_ID';
//       $data['getAllsubtyp'] = $this->common_model->getAlldata(INSP_CL_SUBTYP.' as styp',['DISTINCT(styp.INSP_CHECK_SUBTYP_NAME ) AS SUBTYPENAME,styp.*,GROUP_CONCAT(stypdata.INSP_SUBTYP_DATA_DESC  order by stypdata.INSP_SUBTYP_DATA_ID asc SEPARATOR "@") AS SUBTYPEDATADESC,GROUP_CONCAT(stypdata.INSP_SUBTYP_DATA_ID order by stypdata.INSP_SUBTYP_DATA_ID asc) AS SUBTYPEDATAID'],$inspOptns);
//
//      
//      echo json_encode($data);
//    }
    public function getAjaxinspSubtyp(){
       $checklistId = $this->input->post('checklistId');
       
      
       $inspOptns['where'] = [
           'stypdata.INSP_SUBTYP_DATA_TYPID' => $checklistId,
           'styp.INSP_CHECK_SUBTYP_STATUS' => 'Y',
           'stypdata.INSP_SUBTYP_DATA_STATUS' => 'Y',
       ];
       
       $inspOptns['join'][INSP_CL_SUBTYP_DATA.' stypdata'] = ['stypdata.INSP_SUBTYP_DATA_SUBTYPID = styp.INSP_CHECK_SUBTYP_ID','left'];
       
       $inspOptns['group_by'] = 'styp.INSP_CHECK_SUBTYP_ID';
       $data['getAllsubtyp'] = $this->common_model->getAlldata(INSP_CL_SUBTYP.' as styp',['DISTINCT(styp.INSP_CHECK_SUBTYP_NAME ) AS SUBTYPENAME,styp.*,GROUP_CONCAT(stypdata.INSP_SUBTYP_DATA_DESC  order by stypdata.INSP_SUBTYP_DATA_ID asc SEPARATOR "@") AS SUBTYPEDATADESC,GROUP_CONCAT(stypdata.INSP_SUBTYP_DATA_ID order by stypdata.INSP_SUBTYP_DATA_ID asc) AS SUBTYPEDATAID'],$inspOptns);

       if(empty($data['getAllsubtyp'])){
          
            $data['getAllsubtyp'] = [];
            $inspOptnsnew['where'] = [
           'stypdata.INSP_SUBTYP_DATA_TYPID' => $checklistId,
//           'styp.INSP_CHECK_SUBTYP_STATUS' => 'Y',
           'stypdata.INSP_SUBTYP_DATA_STATUS' => 'Y',
       ];
       
       $inspOptnsnew['join'][INSP_CL_SUBTYP.' as styp'] = ['styp.INSP_CHECK_SUBTYP_ID = stypdata.INSP_SUBTYP_DATA_SUBTYPID','left'];
     $inspOptnsnew['group_by'] = 'stypdata.INSP_SUBTYP_DATA_SUBTYPID';
       $data['getAllsubtyp'] = $this->common_model->getAlldata(INSP_CL_SUBTYP_DATA.' as stypdata',['DISTINCT(styp.INSP_CHECK_SUBTYP_NAME ) AS SUBTYPENAME,styp.*,GROUP_CONCAT(stypdata.INSP_SUBTYP_DATA_DESC  order by stypdata.INSP_SUBTYP_DATA_ID asc SEPARATOR "@") AS SUBTYPEDATADESC,GROUP_CONCAT(stypdata.INSP_SUBTYP_DATA_ID order by stypdata.INSP_SUBTYP_DATA_ID asc) AS SUBTYPEDATAID'],$inspOptnsnew);
//       echo "<pre>";
//       echo $this->db->last_query();
//       print_R($data);
//       exit;
      if($data['getAllsubtyp'][0]->SUBTYPEDATAID != ''){
          $data['getAllsubtyp'] = $data['getAllsubtyp'];
      }else{
          $data['getAllsubtyp'] = '';
      }
       }
       
      echo json_encode($data);
    }
    
    public function saveInspection($id=''){
       
       
       $hsseId = getParticsessdata('USER_REF_ID');
       $hssetypId = getParticsessdata('USER_TYPE_ID');
//        exit;
        $did = decryptval($id);
        
        $this->form_validation->set_rules('inspec[insp_date]', 'Inspection Date', 'required|trim');
        $this->form_validation->set_rules('inspec[next_inspDate]', 'Next Inspection Date', 'required|trim');
        $this->form_validation->set_rules('inspec[terminal]', 'Terminal', 'required|trim');
        $this->form_validation->set_rules('inspec[modal_no]', 'Modal Name/No', 'required|trim');
        $this->form_validation->set_rules('inspec[depart]', 'Department', 'required|trim');
        $this->form_validation->set_rules('inspec[checklistTyp]', 'Checklist Type', 'required|trim');
       
        if ($this->form_validation->run() == true || $did != '') {
            
           $inspecDet = $this->input->post('inspec');
           $inspecCheckDet = $this->input->post('inspcheck');
          
           if($inspecDet['pmt_date'] != ''){
               $pmaDuedate = date("y-m-d",strtotime($inspecDet['pmt_date']));
           }else{
               $pmaDuedate = '';
           }
           
            $safeUnsafe = postData($inspecDet,'safeStatus');
//                if(isset($safeUnsafe) && !empty($safeUnsafe)){
//                    $safUnsafstat = 1;
//                }else{
//                    $safUnsafstat = 2;
//                }
          
            $insertInsp = [
                'INSP_ID' => postData($inspecDet,'inspec_id'),
                'INSPECTION_DATE' => date('Y-m-d',strtotime($inspecDet['insp_date'])),
                'NXT_INSP_DATE' => date("Y-m-d",strtotime($inspecDet['next_inspDate'])),
                'INSP_HSSE_TYPE_ID' => $hssetypId,
                'INSP_HSSE_ID' => $hsseId,
                'INSP_MOD_NAME_NUM' => postData($inspecDet,'modal_no'),
                'INSP_REG_NUMBER' => postData($inspecDet,'reg_no'),
                'INSP_DRIVER_OPT_NAME' => postData($inspecDet,'driver_name'),
                'INSP_PMA_PMT_NO' => postData($inspecDet,'pmt_no'),
                'INSP_PMA_PMT_DUE_DATE' => $pmaDuedate,
                'INSP_CERT_NUM' => postData($inspecDet,'cert_no'),
                'INSP_COLOUR_CODE_INS_TYPE' => postData($inspecDet,'color_code'),
                'INSP_DESC' => postData($inspecDet,'descr'),
//                'INSP_SAFE_UNSAFE' => $safUnsafstat,
                'INSP_TER_ID' => postData($inspecDet,'terminal'),
                'INSP_DEPT_ID' => postData($inspecDet,'depart'),
                'INSP_CHECKLIST_ID' => postData($inspecDet,'checklistTyp'),
//                'INSP_NOTE_DESC' => postData($inspecDet,'ovrerallNotes'),
                'INSP_VERIFY_ID' => postData($inspecDet,'execName'),
                'INSP_APP_STATUS' => 1,
                'INSP_SAFE_UNSAFE' => $safeUnsafe,
//                'INSP_NOTE_DESC' => postData($inspecDet,'ovrerallNotes'),
            ];
           
            if($did != ''){
//                 $updateHseinspec = $this->common_model->updateData(HSSE_INSP_MAIN,$insertInsp,['INSP_AUTO_ID' => $did]);
            }else{
                 $updateHseinspec = $this->common_model->updateData(HSSE_INSP_MAIN,$insertInsp);
            }
           
            
            $imgDatas = [];
            $addmorimgDatas = [];
          if(isset($_FILES['beforeImages']) && !empty($_FILES['beforeImages'])){
            $imgDatas = uploadMultipleimage($_FILES, 'assets/images/modules/inspection/','beforeImages');
          }
          if(isset($_FILES['addmoreImages']) && !empty($_FILES['addmoreImages'])){
            $addmorimgDatas = uploadMultipleimage($_FILES, 'assets/images/modules/inspection/','addmoreImages');
          }
          
        
//          exit;
            
               $uplImgdatas = '';
               $imgKey = 0;
            foreach($inspecCheckDet as $chKey => $chVal){
                $subTypid = $chKey;
                
                foreach($chVal as $daKey => $daVal){
//                    echo $daKey;
                   $subTypdatastat = postData($daVal,'inspStat');
                   $inspCheckremark = postData($daVal,'inspRemark');
                  
                    $SubtypData = [
                        'FK_CHK_LIST_ID' => postData($inspecDet,'checklistTyp'),
                        'FK_SUB_CAT_ID' => $subTypid,
                        'FK_INSP_QNS_ID' => $daKey,
                        'INSP_GOOD_POOR' => $subTypdatastat,
                        'INSP_REMARK' => $inspCheckremark,
                        'INSP_QN_DESC' => postData($daVal,'beforeDescription'),
                    ];
                    
                     if(postData($daVal,'inspStat') == 2){
                         if(!empty($imgDatas)){
                               $imgUplname =  $imgDatas[$imgKey]['uploadname'];
                               $imgUplpath =  $imgDatas[$imgKey]['uploadpath'];
                               $imgUplext =  $imgDatas[$imgKey]['uploadextension'];
                               $imgUplsize =  $imgDatas[$imgKey]['filesize'];
                              
                               $SubtypData['INSP_FILENAME'] = $imgUplname;
                               $SubtypData['INSP_FILE_EXT'] = $imgUplext;
                               $SubtypData['INSP_FILE_PATH'] = $imgUplpath;
                               $SubtypData['INSP_FILE_SIZE'] = $imgUplsize;
                         }
                      $imgKey++;
                       
                     }
                   if($did != ''){
//                       $this->common_model->updateData(HSSE_INSP_CHK,$SubtypData);
                   }else{
                       $SubtypData['FK_INSP_ID'] = $updateHseinspec;
//                       if($subTypdatastat == 1 && $inspCheckremark != ''){
                        $this->common_model->updateData(HSSE_INSP_CHK,$SubtypData);
//                        echo $this->db->last_query();
//                       }elseif($subTypdatastat != 1){
//                            $this->common_model->updateData(HSSE_INSP_CHK,$SubtypData);
//                       }
                   }
               
                 }
             }
             
             if(isset($addmorimgDatas) && !empty($addmorimgDatas)){
                 foreach($addmorimgDatas as $imaddKey => $imaddVal){
                               $imgmorUplname =  $imaddVal['uploadname'];
                               $imgmorUplpath = $imaddVal['uploadpath'];
                               $imgmorUplext =  $imaddVal['uploadextension'];
                               $imgmorUplsize =  $imaddVal['filesize'];
                               
                               $insertMorimages = [
                                   'INSP_NOT_IMG_INSP_ID' => $updateHseinspec,
                                   'INSP_NOT_IMG_FILENAME' => $imgmorUplname,
                                   'INSP_NOT_IMG_FILEPATH' => $imgmorUplpath,
                                   'INSP_NOT_IMG_FILEEXT' => $imgmorUplext,
                                   'INSP_NOT_IMG_FILESIZE' => $imgmorUplsize,
                               ];
                              
                             $this->common_model->updateData(HSSE_INSP_IMAGE,$insertMorimages);
                         
                              
                 }
             }
           
             
              if ($id == '') {
                  
                  $emplOptn['where'] = [
                      'log.LOGIN_ID' => postData($inspecDet,'execName'),
                      'log.USER_LOGIN_TYP' => 0
                  ];
                  $emplOptn['return_type'] = 'row';
                  $emplOptn['join'][LOGIN.' as log'] = ['log.USER_REF_ID = emp.EMP_AUTO_ID','left'];
                 $empldatas = $this->common_model->getAlldata(EMPL.' as emp',['*'],$emplOptn);
//                echo "<pre>";
//                echo $this->db->last_query();
//                print_r($empldatas);
//                exit;
                  $idata['emplmailID'] = postData($empldatas,'EMP_EMAIL_ID');
                $idata['emplName'] = postData($empldatas,'EMP_NAME');
                
                 $loctOptn['where'] = [
                     'TER_AUTO_ID' => postData($inspecDet,'terminal')
                 ];
                 $loctOptn['return_type'] = 'row';
                 $locName = $this->common_model->getAlldata(TERM,['TERMINAL_NAME'],$loctOptn);
                 
                 $deptnOptn['where'] = [
                     'DEPT_AUTO_ID' => postData($inspecDet,'depart')
                 ];
                 $deptnOptn['return_type'] = 'row';
                 $deptnName = $this->common_model->getAlldata(DEPT,['DEPT_NAME'],$deptnOptn);
                 
                 $chklOptn['where'] = [
                     'INSP_CHECK_TYP_ID' => postData($inspecDet,'checklistTyp')
                 ];
                 $chklOptn['return_type'] = 'row';
                 $chklName = $this->common_model->getAlldata(INSP_CL_TYP,['INSP_CHECK_TYP_NAME'],$chklOptn);
                 
                 /////////// new notification start
//               $idata['notifyMsg'] = 'Inspection ID '.postData($inspecDet,'inspec_id').'  has been Assigned to '.$idata['emplName'].' for verification with following details :';
               $idata['notifyMsg'] = 'HSSE Inspection is submitted for verification with following details :'
                       . '<br><br><b>Inspection ID : </b>'.postData($inspecDet,'inspec_id')
                       .'<br><b>Inspection Date : </b>'.date('d-m-Y',strtotime($inspecDet['insp_date']))
                       .'<br><b>Next Inspection Date : </b>'.date("d-m-Y",strtotime($inspecDet['next_inspDate']))
                       .'<br><b>Inspected by : </b>'.postData($inspecDet,'insp_by')
                       .'<br><b>Terminal : </b>'.$locName->TERMINAL_NAME
                       .'<br><b>Department : </b>'.$deptnName->DEPT_NAME
                       .'<br><b>To be verified by : </b>'.$idata['emplName']
                       .'<br><b>Status : </b> Verify Pending';
                $idata['url'] = 'inspection/addInspection/'. encryptval($updateHseinspec);
                 $idata['moduleName'] = 'inspection';
                 $idata['notifytoID'] = postData($empldatas,'LOGIN_ID');
                 $idata['inspId'] = (isset($did) && !empty($did)) ? $did : $updateHseinspec;
                 
                 if(postData($inspecDet,'pmt_date') != ''){
                   $pmaPmtdudate =   date("d-m-Y",strtotime($inspecDet['pmt_date']));
                 }else{
                     $pmaPmtdudate = '';
                 }
                 
                 
                 
                 /////////// new notification end
                
                $idata['messageText'] = 'New inspection checklist has been created and waiting for you to verify with following details:'
                        . '<br><br><br><b>INSPECTION ID : </b>'.postData($inspecDet,'inspec_id')
                        . '<br><b>INSPECTION DATE : </b>'.date('d-m-Y',strtotime($inspecDet['insp_date']))
                        . '<br><b>INSPECTED BY: </b>'.postData($inspecDet,'insp_by')
                        . '<br><b>NEXT INSPECTION DATE: </b>'.date("d-m-Y",strtotime($inspecDet['next_inspDate']))
                        . '<br><b>MODEL NAME/NO: </b>'.postData($inspecDet,'modal_no')
                        . '<br><b>REGISTRATION NO: </b>'.postData($inspecDet,'reg_no')
                        . '<br><b>DRIVER/OPERATOR NAME: </b>'.postData($inspecDet,'driver_name')
                        . '<br><b>PMA/PMT NO: </b>'.postData($inspecDet,'pmt_no')
                        . '<br><b>PMA/PMT DUE DATE: </b>'.$pmaPmtdudate
                        . '<br><b>CERTIFICATE NO: </b>'.postData($inspecDet,'cert_no')
                        . '<br><b>COLOR CODE: </b>'.postData($inspecDet,'color_code')
                        . '<br><b>DESCRIPTION: </b>'.postData($inspecDet,'descr')
                        . '<br><b>LOCATION: </b>'.$locName->TERMINAL_NAME
                        . '<br><b>DEPARTMENT/DIVISION: </b>'.$deptnName->DEPT_NAME
                        . '<br><b>INSPECTION CHECKLIST: </b>'.$chklName->INSP_CHECK_TYP_NAME
                        .'<br><br><br>This is system generated E-mail, do not reply to this email.';
                
               
                
                $idata['subject'] = 'VAULT - HSSE Inspection';
                
  
            internalNotificationOverall($idata);  
            //////////// mail notification start
            
                 ///// notification end
                
                $data = [
                    'status' => true
                ];
                if ($newEmpdetID != '') {
                    $data['flasmsg'] = $this->session->set_flashdata('inspcTn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Inspection has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inspcTn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> New Inspection has been created</div>');
                }
                 redirect('inspection/Inspectionlist');
            }else{
              
                ////////////// notification to hsse
               
               $updateMainchk = [
                   'INSP_APP_STATUS' => 2,
//                   'INSP_SAFE_UNSAFE' => $safUnsafstat,
                   'INSP_NOTE_DESC' => postData($inspecDet,'ovrerallNotes'),
                   ];
               $this->common_model->updateData(HSSE_INSP_MAIN,$updateMainchk,['INSP_AUTO_ID' => $did]);
                $insptOptns['where'] = [
                    'INSP_AUTO_ID' => $did
                ];
                $insptOptns['return_type'] = 'row';
                $insptOptns['join'][TERM.' as term'] = ['term.TER_AUTO_ID = main.INSP_TER_ID','left'];
                $insptOptns['join'][DEPT.' as dept'] = ['dept.DEPT_AUTO_ID = main.INSP_DEPT_ID','left'];
                $insptOptns['join'][INSP_CL_TYP.' as chk'] = ['chk.INSP_CHECK_TYP_ID = main.INSP_CHECKLIST_ID','left'];
                $insptOptns['join'][EMPL.' as emp'] = ['emp.EMP_AUTO_ID = main.INSP_HSSE_ID','left'];
                $insptOptns['join'][USER_LOG.' as log'] = ['log.LOGIN_ID = main.INSP_VERIFY_ID','left'];
                $insptOptns['join'][EMPL.' as exec'] = ['exec.EMP_AUTO_ID = log.USER_REF_ID','left'];
//                $insptOptns['join'][EMPL.' as exec'] = ['exec.EMP_AUTO_ID = main.INSP_VERIFY_ID','left'];
                $inspecDetnew = $this->common_model->getAlldata(HSSE_INSP_MAIN.' as main',['main.*,term.TERMINAL_NAME,dept.DEPT_NAME,chk.INSP_CHECK_TYP_NAME,emp.EMP_NAME as hsseName,emp.EMP_EMAIL_ID as hsseMail,exec.EMP_NAME as execName'],$insptOptns);
                 
                
                 $idata['emplmailID'] = postData($inspecDetnew,'hsseMail');
                $idata['emplName'] = postData($inspecDetnew,'hsseName');
               
                 /////////// new notification start
               $idata['notifyMsg'] = 'HSSE Inspection has been successfully verified by with following details :'
                                        . '<br><br><b>Inspection ID : </b>'.postData($inspecDetnew,'INSP_ID')
                                        .'<br><b>Inspection Date : </b>'.date('d-m-Y',strtotime($inspecDetnew->INSPECTION_DATE))
                                        .'<br><b>Next Inspection Date : </b>'.date("d-m-Y",strtotime($inspecDetnew->NXT_INSP_DATE))
                                        .'<br><b>Inspected by : </b>'.postData($inspecDetnew,'hsseName')
                                        .'<br><b>Terminal : </b>'.postData($inspecDetnew,'TERMINAL_NAME')
                                        .'<br><b>Department : </b>'.postData($inspecDetnew,'DEPT_NAME')
                                        .'<br><b>verified by : </b>'.postData($inspecDetnew,'execName')
                                        .'<br><b>Status : </b> Verified';
               $idata['url'] = 'inspection/addInspection/'. $id;
                 $idata['moduleName'] = 'inspection';
                 
                 $loginOptns['where'] = [
                     'USER_REF_ID' =>postData($inspecDetnew,'INSP_HSSE_ID'),
                     'USER_LOGIN_TYP' => 0
                 ];
                 $loginOptns['return_type'] = 'row';
                 $getLogid = $this->common_model->getAlldata(LOGIN,['*'],$loginOptns);
                 $idata['notifytoID'] = postData($getLogid,'LOGIN_ID');
                 $idata['inspId'] = postData($inspecDetnew,'INSP_AUTO_ID');
                 
                 if(postData($inspecDetnew,'INSP_PMA_PMT_DUE_DATE') != ''){
                   $pmaPmtdudate =   date("d-m-Y",strtotime($inspecDet['pmt_date']));
                 }else{
                     $pmaPmtdudate = '';
                 }
                 /////////// new notification end
               
                $idata['messageText'] = 'The inspection checklist created by you has been verified details are as follows :'
                        . '<br><br><br><b>INSPECTION ID : </b>'.postData($inspecDetnew,'INSP_ID')
                        . '<br><b>INSPECTION DATE : </b>'.date('d-m-Y',strtotime($inspecDetnew->INSPECTION_DATE))
                        . '<br><b>INSPECTED BY: </b>'.postData($inspecDetnew,'hsseName')
                        . '<br><b>NEXT INSPECTION DATE: </b>'.date("d-m-Y",strtotime($inspecDetnew->NXT_INSP_DATE))
                        . '<br><b>MODEL NAME/NO: </b>'.postData($inspecDetnew,'INSP_MOD_NAME_NUM')
                        . '<br><b>REGISTRATION NO: </b>'.postData($inspecDetnew,'INSP_REG_NUMBER')
                        . '<br><b>DRIVER/OPERATOR NAME: </b>'.postData($inspecDetnew,'INSP_DRIVER_OPT_NAME')
                        . '<br><b>PMA/PMT NO: </b>'.postData($inspecDetnew,'INSP_PMA_PMT_NO')
                        . '<br><b>PMA/PMT DUE DATE: </b>'.$pmaPmtdudate
                        . '<br><b>CERTIFICATE NO: </b>'.postData($inspecDetnew,'INSP_CERT_NUM')
                        . '<br><b>COLOR CODE: </b>'.postData($inspecDetnew,'INSP_COLOUR_CODE_INS_TYPE')
                        . '<br><b>DESCRIPTION: </b>'.postData($inspecDetnew,'INSP_DESC')
                        . '<br><b>LOCATION: </b>'.postData($inspecDetnew,'TERMINAL_NAME')
                        . '<br><b>DEPARTMENT/DIVISION: </b>'.postData($inspecDetnew,'DEPT_NAME')
                        . '<br><b>INSPECTION CHECKLIST: </b>'.postData($inspecDetnew,'INSP_CHECK_TYP_NAME')
                        .'<br><br><br>This is system generated E-mail, do not reply to this email.';
                
                $idata['subject'] = 'VAULT - HSSE Inspection';
                
  
            internalNotificationOverall($idata);  
            //////////// mail notification start
            
                 ///// notification end
                
                $data = [
                    'status' => true
                ];
               
                    $data['flasmsg'] = $this->session->set_flashdata('inspcTn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Inspection verified successfully</div>');
                redirect('inspection/Inspectionlist');
            }
        }else{
            $this->addInspection($id='');
        }
        
       
    }
    
    public function deleteInspection(){
         $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(HSSE_INSP_MAIN, ['INSP_STATUS' => 'N'], ['INSP_AUTO_ID' => decryptval($deleteId)]);
        $updtDeletechecklist = $this->common_model->updateData(HSSE_INSP_CHK, ['INSP_IMG_STATUS' => 'N'], ['FK_INSP_ID' => decryptval($deleteId)]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Inspection  deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Inspection '
            ];
        }
        echo json_encode($retData);
    }
    
   public function viewInspection($id=""){
       $did = decryptval($id);
       
       $insptOptns['where'] = [
                    'INSP_AUTO_ID' => $did
                ];
        $insptOptns['return_type'] = 'row';
        $insptOptns['join'][TERM.' as term'] = ['term.TER_AUTO_ID = main.INSP_TER_ID','left'];
        $insptOptns['join'][DEPT.' as dept'] = ['dept.DEPT_AUTO_ID = main.INSP_DEPT_ID','left'];
        $insptOptns['join'][INSP_CL_TYP.' as chk'] = ['chk.INSP_CHECK_TYP_ID = main.INSP_CHECKLIST_ID','left'];
        $insptOptns['join'][EMPL.' as emp'] = ['emp.EMP_AUTO_ID = main.INSP_HSSE_ID','left'];
        $insptOptns['join'][USER_LOG.' as log'] = ['log.LOGIN_ID = main.INSP_VERIFY_ID','left'];
        $insptOptns['join'][EMPL.' as exec'] = ['exec.EMP_AUTO_ID = log.USER_REF_ID','left'];
        
        $InspBasicDet = $this->common_model->getAlldata(HSSE_INSP_MAIN.' as main',['main.*,term.TERMINAL_NAME,dept.DEPT_NAME,chk.INSP_CHECK_TYP_NAME,emp.EMP_NAME as hsseName,emp.EMP_EMAIL_ID as hsseMail,exec.EMP_NAME as execName'],$insptOptns);
       
        /////////////checklist start
 
        $hsChkoptn['where'] = [
            'FK_INSP_ID' => $did,
            'INSP_IMG_STATUS' => 'Y',
        ];
//        $hsChkoptn['return_type'] = 'row';
        $hsChkoptn['join'][INSP_CL_SUBTYP.' as subtyp'] = ['subtyp.INSP_CHECK_SUBTYP_ID = chk.FK_SUB_CAT_ID','left'];
        $hsChkoptn['join'][INSP_CL_SUBTYP_DATA.' as subtypdata'] = ['subtypdata.INSP_SUBTYP_DATA_ID = chk.FK_INSP_QNS_ID','left'];
        $hsChkoptn['group_by'] = 'subtyp.INSP_CHECK_SUBTYP_ID';
        $getEditinspect = $this->common_model->getAlldata(HSSE_INSP_CHK.' as chk',['chk.*,GROUP_CONCAT(DISTINCT subtyp.INSP_CHECK_SUBTYP_NAME) as subTyp,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_ID order by chk.INSP_CHK_AUTO_ID asc) as subTypdataID,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_DESC order by chk.INSP_CHK_AUTO_ID asc) as subTypdata,GROUP_CONCAT(CONCAT(chk.INSP_GOOD_POOR,"@",chk.FK_INSP_QNS_ID)  order by chk.INSP_CHK_AUTO_ID asc) as goodPoor,GROUP_CONCAT(CONCAT(chk.INSP_REMARK,"@",chk.FK_INSP_QNS_ID) order by chk.INSP_CHK_AUTO_ID asc) as remaRk,GROUP_CONCAT(chk.INSP_FILENAME order by chk.INSP_CHK_AUTO_ID asc) as fileName,GROUP_CONCAT(DISTINCT chk.INSP_FILE_PATH order by chk.INSP_CHK_AUTO_ID asc) as filePath,GROUP_CONCAT(chk.INSP_QN_DESC order by chk.INSP_CHK_AUTO_ID asc) as quesDesc'],$hsChkoptn);
      
        
        $addmorImgoptns['where'] = [
            'INSP_NOT_IMG_INSP_ID' => $did,
            'INSP_NOT_IMG_STATUS' => 'Y',
        ];
        $getAllmoreimages = $this->common_model->getAlldata(HSSE_INSP_IMAGE,['*'],$addmorImgoptns);
        
        
        if(isset($getEditinspect) && !empty($getEditinspect)){
            foreach($getEditinspect as $gdKey => $gdVal){
                $getSubtypedataID = explode(",",$gdVal->subTypdataID);
                $getSubtypeID = $gdVal->FK_SUB_CAT_ID;
                $getChktypeID = $gdVal->FK_CHK_LIST_ID;
                
                $sdDataoptns['where'] = [
                    'INSP_SUBTYP_DATA_STATUS' => 'Y',
                    'INSP_SUBTYP_DATA_SUBTYPID' => $getSubtypeID,
                    'INSP_SUBTYP_DATA_TYPID' => $getChktypeID,
                ];
            $getSubtydataDet = $this->common_model->getAlldata(INSP_CL_SUBTYP_DATA.' as sd',['GROUP_CONCAT(sd.INSP_SUBTYP_DATA_DESC  order by sd.INSP_SUBTYP_DATA_ID asc SEPARATOR "@") AS SUBTYPEDATADESC,GROUP_CONCAT(sd.INSP_SUBTYP_DATA_ID order by sd.INSP_SUBTYP_DATA_ID asc) AS SUBTYPEDATAID'],$sdDataoptns);
            
                if(isset($getSubtydataDet) && !empty($getSubtydataDet)){
                foreach($getSubtydataDet as $sdKey => $sdVal){
                  $getEditsubData['subTypdataID'][$sdKey] =  $sdVal->SUBTYPEDATAID;
                  $getEditsubData['subTypdata'][$sdKey] =  $sdVal->SUBTYPEDATADESC;

                }
               
                $gdVal->subTypdataID = implode(",",$getEditsubData['subTypdataID']);
                $gdVal->subTypdata = implode(",",$getEditsubData['subTypdata']);
                }
            }
        }
       
        /////////////checklist end
      
        $data = array(
            'view_file' => 'inspection/view_Inspection',
            'current_menu' => 'View Inspection',
            'InspBasicDet' => $InspBasicDet,
            'InspectionDet' => $getEditinspect,
            'getAllmoreimages' => $getAllmoreimages,
           
        );
        $this->template->load_common_template($data);
   }
   
   public function pdfInspection($id=""){
      $did = decryptval($id);
       
       $insptOptns['where'] = [
                    'INSP_AUTO_ID' => $did
                ];
        $insptOptns['return_type'] = 'row';
        $insptOptns['join'][TERM.' as term'] = ['term.TER_AUTO_ID = main.INSP_TER_ID','left'];
        $insptOptns['join'][DEPT.' as dept'] = ['dept.DEPT_AUTO_ID = main.INSP_DEPT_ID','left'];
        $insptOptns['join'][INSP_CL_TYP.' as chk'] = ['chk.INSP_CHECK_TYP_ID = main.INSP_CHECKLIST_ID','left'];
        $insptOptns['join'][EMPL.' as emp'] = ['emp.EMP_AUTO_ID = main.INSP_HSSE_ID','left'];
        $insptOptns['join'][USER_LOG.' as log'] = ['log.LOGIN_ID = main.INSP_VERIFY_ID','left'];
        $insptOptns['join'][EMPL.' as exec'] = ['exec.EMP_AUTO_ID = log.USER_REF_ID','left'];
        $InspBasicDet = $this->common_model->getAlldata(HSSE_INSP_MAIN.' as main',['main.*,term.TERMINAL_NAME,dept.DEPT_NAME,chk.INSP_CHECK_TYP_NAME,emp.EMP_NAME as hsseName,emp.EMP_EMAIL_ID as hsseMail,exec.EMP_NAME as execName'],$insptOptns);
        
        $addmorImgoptns['where'] = [
            'INSP_NOT_IMG_INSP_ID' => $did,
            'INSP_NOT_IMG_STATUS' => 'Y',
        ];
        $getAllmoreimages = $this->common_model->getAlldata(HSSE_INSP_IMAGE,['*'],$addmorImgoptns);
        
        
        $pdfUniqname = postData($InspBasicDet,'INSP_ID');
        /////////////checklist start
 
        $hsChkoptn['where'] = [
            'FK_INSP_ID' => $did,
            'INSP_IMG_STATUS' => 'Y',
        ];
//        $hsChkoptn['return_type'] = 'row';
        $hsChkoptn['join'][INSP_CL_SUBTYP.' as subtyp'] = ['subtyp.INSP_CHECK_SUBTYP_ID = chk.FK_SUB_CAT_ID','left'];
        $hsChkoptn['join'][INSP_CL_SUBTYP_DATA.' as subtypdata'] = ['subtypdata.INSP_SUBTYP_DATA_ID = chk.FK_INSP_QNS_ID','left'];
        $hsChkoptn['group_by'] = 'subtyp.INSP_CHECK_SUBTYP_ID';
        $getEditinspect = $this->common_model->getAlldata(HSSE_INSP_CHK.' as chk',['chk.*,GROUP_CONCAT(DISTINCT subtyp.INSP_CHECK_SUBTYP_NAME) as subTyp,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_ID order by chk.INSP_CHK_AUTO_ID asc) as subTypdataID,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_DESC order by chk.INSP_CHK_AUTO_ID asc) as subTypdata,GROUP_CONCAT(CONCAT(chk.INSP_GOOD_POOR,"@",chk.FK_INSP_QNS_ID)  order by chk.INSP_CHK_AUTO_ID asc) as goodPoor,GROUP_CONCAT(CONCAT(chk.INSP_REMARK,"@",chk.FK_INSP_QNS_ID) order by chk.INSP_CHK_AUTO_ID asc) as remaRk,GROUP_CONCAT(chk.INSP_FILENAME order by chk.INSP_CHK_AUTO_ID asc) as fileName,GROUP_CONCAT(DISTINCT chk.INSP_FILE_PATH order by chk.INSP_CHK_AUTO_ID asc) as filePath,GROUP_CONCAT(chk.INSP_QN_DESC order by chk.INSP_CHK_AUTO_ID asc) as quesDesc'],$hsChkoptn);
      
        if(isset($getEditinspect) && !empty($getEditinspect)){
            foreach($getEditinspect as $gdKey => $gdVal){
                $getSubtypedataID = explode(",",$gdVal->subTypdataID);
                $getSubtypeID = $gdVal->FK_SUB_CAT_ID;
                $getChktypeID = $gdVal->FK_CHK_LIST_ID;
                
                $sdDataoptns['where'] = [
                    'INSP_SUBTYP_DATA_STATUS' => 'Y',
                    'INSP_SUBTYP_DATA_SUBTYPID' => $getSubtypeID,
                    'INSP_SUBTYP_DATA_TYPID' => $getChktypeID,
                ];
            $getSubtydataDet = $this->common_model->getAlldata(INSP_CL_SUBTYP_DATA.' as sd',['GROUP_CONCAT(sd.INSP_SUBTYP_DATA_DESC  order by sd.INSP_SUBTYP_DATA_ID asc SEPARATOR "@") AS SUBTYPEDATADESC,GROUP_CONCAT(sd.INSP_SUBTYP_DATA_ID order by sd.INSP_SUBTYP_DATA_ID asc) AS SUBTYPEDATAID'],$sdDataoptns);
            
                if(isset($getSubtydataDet) && !empty($getSubtydataDet)){
                foreach($getSubtydataDet as $sdKey => $sdVal){
                  $getEditsubData['subTypdataID'][$sdKey] =  $sdVal->SUBTYPEDATAID;
                  $getEditsubData['subTypdata'][$sdKey] =  $sdVal->SUBTYPEDATADESC;

                }
               
                $gdVal->subTypdataID = implode(",",$getEditsubData['subTypdataID']);
                $gdVal->subTypdata = implode(",",$getEditsubData['subTypdata']);
                }
            }
        }
        
        $data=[
            'InspBasicDet'=>$InspBasicDet,
            'InspectionDet'=>$getEditinspect,
            'getAllmoreimages'=>$getAllmoreimages,
        ];
//        echo "<pre>";
//        print_R($data);
//        exit;
        $html2 = $this->load->view('inspection_report',$data, true);
//        echo $html2;exit;
        $mpdf2 = $this->pdf->ptwload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "inspection";
        $file_path = "assets/uploads/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $file_path . 'Inspection-' . $did . '-' . $currenttime . '.pdf';
//        $name = 'Inspection-' . $currenttime . '.pdf';
        $name = 'Inspection-' . $pdfUniqname . '.pdf';
        $mpdf2->Output($path2, "F");
        $data = file_get_contents($path2);
        force_download($name, $data);
   }
   
   ///////////// monthly inspection start
    public function Inspectionlistmonthly(){
      
        $data = array(
            'view_file' => 'monthly_inspection/list_inspection',
            'site_title' => 'Monthly Inspection',
            'current_menu' => 'List Monthly Inspection',
            'ajaxurl' => 'inspection/list_inspectionmonthly',
           
        );

        $this->template->load_table_template($data);
    }
    
    public function list_inspectionmonthly(){
        $table = MON_INSP_MAIN.' as insp';
        $column_order = array(null, 'MON_INSP_ID', 'MON_INSPECTION_DATE', 'TERMINAL_NAME','SPECIFIC_LOC_NAME', null);
        $column_search = array('MON_INSP_ID', 'MON_INSPECTION_DATE','TERMINAL_NAME','SPECIFIC_LOC_NAME');
        $order = array('MON_INSP_AUTO_ID' => 'desc');
        $where = ['MON_INSP_STATUS' => 'Y'];
        $options['group_by'] = ['MON_INSP_AUTO_ID'];
        
       $getUsertypid = getCurrentUserGroupId();
       $getUserid = getParticsessdata('USER_REF_ID');
       $gteDesigid = getParticsessdata('USER_DESINATION_ID');
       
//       echo $getUsertypid;
       if($getUsertypid == 7){
            $where['MON_INSP_APP_STATUS !='] = '-1';
            $options['where_in']['MON_INSP_REVIEW_ID'] = [$getUserid,0];

       }
       if($getUsertypid == 6){
            $options['where_in']['MON_INSP_HSSE_ID'] = [$getUserid,0];
         
       }
       if($getUsertypid == 8){
//           $where['MON_INSP_VERIFY_ID'] =  $getUserid;
//            $options['where'] = [
//               'MON_INSP_APP_STATUS !=' => '-1'
//           ];
//            $options['orwhere'] = [
//               'MON_INSP_VERIFY_ID' => $getUserid,
//               'MON_INSP_VERIFY_ID' => null
//           ];
            $where['MON_INSP_APP_STATUS !='] = '-1';
            $options['where_in']['MON_INSP_VERIFY_ID'] = [$getUserid,0];
         
       }
       if($getUsertypid == 9){
//           $where['MON_INSP_APPROVER_ID'] =  $getUserid;
//           $options['where'] = [
//               'MON_INSP_APP_STATUS !=' => '-1'
//           ];
//            $options['orwhere'] = [
//               'MON_INSP_APPROVER_ID' => $getUserid,
//               'MON_INSP_APPROVER_ID' => null
//           ];
         $where['MON_INSP_APP_STATUS !='] = '-1';
         $where['MON_INSP_APP_STATUS >='] = 3;
         $options['where_in']['MON_INSP_APPROVER_ID'] = [$getUserid,0];
       }
       
       if($gteDesigid == 18){
           
            $where['MON_INSP_TER_ID'] = 2;
           $where['MON_INSP_APP_STATUS !='] = '-1';
       }
       if($gteDesigid == 22){
           $where['MON_INSP_TER_ID'] = 1;
           $where['MON_INSP_APP_STATUS !='] = '-1';
           
       }
        $options['join'][TERM.' as term'] = ['term.TER_AUTO_ID = insp.MON_INSP_TER_ID','left'];
//        $options['join'][SPE_LOC.' as loc'] = ['loc.SL_AUTO_ID = insp.MON_INSP_SPE_LOC_ID','left'];
        $options['join'][SPE_LOC.' as loc'] = ['find_in_set(loc.SL_AUTO_ID,insp.MON_INSP_SPE_LOC_ID) > 0','left'];
//        $options['join'][LOGIN.' as log'] = ['log.USER_REF_ID = insp.MON_INSP_SPE_LOC_ID','left'];
        $options['select'] = ['MON_INSP_ID,MON_INSPECTION_DATE,TERMINAL_NAME,	FN_SPEC_LOCATION_GROUP(MON_INSP_SPE_LOC_ID) as specLocatn,insp.*'];
        $listLocatn = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where,$options);
//    echo "<pre>";
//    echo $gteDesigid;
//    echo $this->db->last_query();
//    print_R($listLocatn);
//    exit;
        $userTypid = getParticsessdata('USER_TYPE_ID');
        
//        echo "<pre>";
//        print_R(getParticsessdata());
//        exit;
        $finalDatas = [];
        if(isset($listLocatn) && !empty($listLocatn)){
        foreach ($listLocatn as $ltKey => $ltVal) {

            $action = '';
            $id = $ltVal->MON_INSP_AUTO_ID;
            
            $monreviewID = $ltVal->MON_INSP_REVIEW_ID;
            $monverifierID = $ltVal->MON_INSP_VERIFY_ID;
            $monapproverID = $ltVal->MON_INSP_APPROVER_ID;
            $monHSSEID = $ltVal->MON_INSP_HSSE_ID;
//          echo $userTypid;
//          echo $gteDesigid;
            $eid = encryptval($id);
            
            if($ltVal->MON_INSP_APP_STATUS == 1){
                $inspStatus = '<label class="btn btn-xs btn-info" style="color:#fff">Review Pending</label>';
               if($monreviewID != '0'){
                   if($getUserid == $monreviewID){
                   $action .= " " . anchor('inspection/addMonthlyinspection/' . $eid, '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));
                }
               }else{
                if($userTypid == 7 && ($gteDesigid == 26)){
                    $action .= " " . anchor('inspection/addMonthlyinspection/' . $eid, '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));
                }
               }
            }elseif($ltVal->MON_INSP_APP_STATUS == 2){
                $inspStatus = '<label class="btn btn-xs btn-info" style="color:#fff">Verify Pending</label>';
                 if($monverifierID != '0'){
                     if($getUserid == $monverifierID){
                          $action .= " " . anchor('inspection/addMonthlyinspection/' . $eid, '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));
                     }
                 }else{
                     
                    if($userTypid == 8 && ($gteDesigid == 22 || $gteDesigid == 18)){
                        $action .= " " . anchor('inspection/addMonthlyinspection/' . $eid, '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));
                     }
                 }
            }elseif($ltVal->MON_INSP_APP_STATUS == 3){
                $inspStatus = '<label class="btn btn-xs btn-info" style="color:#fff">Approve Pending</label>';
               if($monapproverID != '0'){
                     if($getUserid == $monapproverID){
                          $action .= " " . anchor('inspection/addMonthlyinspection/' . $eid, '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));
                     }
               }else{
                if($userTypid == 9 && $gteDesigid == 40){
                $action .= " " . anchor('inspection/addMonthlyinspection/' . $eid, '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));
               }
               }  
            }elseif($ltVal->MON_INSP_APP_STATUS == -4){
                $inspStatus = '<label class="btn btn-xs btn-danger" style="color:#fff">Approver Rejected</label>';
                 if($getUserid == $monverifierID){
                    $action .= " " . anchor('inspection/addMonthlyinspection/' . $eid, '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));
                 }
            }elseif($ltVal->MON_INSP_APP_STATUS == -3){
                $inspStatus = '<label class="btn btn-xs btn-danger" style="color:#fff">Verifier Rejected</label>';
                if($getUserid == $monreviewID){
                    $action .= " " . anchor('inspection/addMonthlyinspection/' . $eid, '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));
                }
            }elseif($ltVal->MON_INSP_APP_STATUS == -2){
                $inspStatus = '<label class="btn btn-xs btn-danger" style="color:#fff">Reviewer Rejected</label>';
                if($getUserid == $monHSSEID){
                $action .= " " . anchor('inspection/addMonthlyinspection/' . $eid, '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));
                }
                
            }elseif($ltVal->MON_INSP_APP_STATUS == 4){
                $inspStatus = '<label class="btn btn-xs btn-success">Approved</label>';
                
                }
                elseif($ltVal->MON_INSP_APP_STATUS == -1){
                       $inspStatus = '<label class="btn btn-xs btn-warning" style="color:#fff">Pending</label>';
                if($getUserid == $monHSSEID){
                       $action .= " " . anchor('inspection/addMonthlyinspection/' . $eid, '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));
                    }
                }
               
                if($ltVal->MON_INSP_APP_STATUS != '' && $ltVal->MON_INSP_APP_STATUS != -1){
                    $action .= " " . anchor('inspection/viewInspectionmonthly/' . $eid, '<i class="fas fa-eye aria-hidden="true"></i>', array('class' => '', 'title' => 'View'));
                     $action .= " " . anchor('inspection/monthlyInspactivity/' . $eid, '<i class="fa fa-list-alt" aria-hidden="true"></i>', array('class' => '', 'title' => 'Activity'));
                }
               // if($ltVal->MON_INSP_APP_STATUS == 4){
                     $action .= " " . anchor('inspection/pdfInspectionmonthly/' . $eid, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF'));
              //  }
                 if($getUserid == $monHSSEID){
                    $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteInspection', 'title' => 'Delete', 'delt-id' => $eid));
                }
            $rows = [];
            $rows[] = $ltVal->MON_INSP_ID;
            $rows[] = date("d-m-Y",strtotime($ltVal->MON_INSPECTION_DATE));
            $rows[] = $ltVal->TERMINAL_NAME;
//            $rows[] = $ltVal->specLocatn;
            $rows[] = $inspStatus;
//            }
            $rows[] = $action;
            $finalDatas[] = $rows;
        }
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->common_model->count_all($table, $column_order, $column_search, $order),
            "recordsFiltered" => $this->common_model->count_filtered($table, $column_order, $column_search, $order),
            "data" => $finalDatas,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function addMonthlyinspection($id=''){
        
        $did = decryptval($id);
         $uniqInspidwhr = [];
        if ($id != '') {
            $uniqInspidwhr = [
                'MON_INSP_AUTO_ID' => $did
            ];
        }

        $inspidUniq = uniqueIntRefId('MON-INSP',MON_INSP_MAIN , 'MON_INSP_AUTO_ID', 'MON_INSP_AUTO_ID', $uniqInspidwhr);
       
        $termOptn['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $getAllterminal = $this->common_model->getAlldata(TERM, ['*'], $termOptn);
        $dropTermname = customFormDropDown($getAllterminal, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');
        
        $loctOptn['where'] = [
            'SPECIFIC_LOC_STATUS' => 'Y'
        ];
        $getAllloct = $this->common_model->getAlldata(SPE_LOC, ['*'], $loctOptn);
        $dropLocation = customFormDropDown($getAllloct, 'SL_AUTO_ID', 'SPECIFIC_LOC_NAME', '');
      
        $checkOptn['where'] = [
            'INSP_CHECK_TYP_STATUS' => 'Y'
        ];
        $getChecklistdata = $this->common_model->getAlldata(INSP_CL_TYP,['*'],$checkOptn);
        $dropChecklist = customFormDropDown($getChecklistdata, 'INSP_CHECK_TYP_ID', 'INSP_CHECK_TYP_NAME','Select Checklist Type');

        $sessDatas = $this->session->userinfo;
        
                $emplnOptn['where'] = [
                     'EMP_AUTO_ID' => postData($sessDatas,'USER_REF_ID')
                 ];
                 $emplnOptn['return_type'] = 'row';
                 $emplnName = $this->common_model->getAlldata(EMPLOYEE_MANAGEMENT,['EMP_NAME'],$emplnOptn);
        $sessUser = $emplnName->EMP_NAME;
        
        $monMainoptn['where'] = [
            'MON_INSP_AUTO_ID' => $did
        ];
        $monMainoptn['return_type'] = 'row';
       $getHssemaindatas =  $this->common_model->getAlldata(MON_INSP_MAIN,['*'],$monMainoptn);
       
       $hsChkoptn['where'] = [
            'FK_MON_INSP_ID' => $did,
            'MON_INSP_IMG_STATUS' => 'Y',
        ];

        $hsChkoptn['join'][INSP_CL_SUBTYP.' as subtyp'] = ['subtyp.INSP_CHECK_SUBTYP_ID = chk.FK_MON_SUB_CAT_ID','left'];
        $hsChkoptn['join'][INSP_CL_SUBTYP_DATA.' as subtypdata'] = ['subtypdata.INSP_SUBTYP_DATA_ID = chk.FK_MON_INSP_QNS_ID','left'];
        $hsChkoptn['group_by'] = 'subtyp.INSP_CHECK_SUBTYP_ID';
        $getEditinspect = $this->common_model->getAlldata(MON_INSP_CHK.' as chk',['chk.*,GROUP_CONCAT(CONCAT(chk.MON_INSP_CHK_AUTO_ID,"@",chk.FK_MON_INSP_QNS_ID)) as checkListid,GROUP_CONCAT(DISTINCT subtyp.INSP_CHECK_SUBTYP_NAME) as subTyp,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_ID order by chk.MON_INSP_CHK_AUTO_ID asc) as subTypdataID,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_DESC order by chk.MON_INSP_CHK_AUTO_ID asc SEPARATOR "@") as subTypdata,GROUP_CONCAT(CONCAT(chk.MON_INSP_SCORE,"@",chk.FK_MON_INSP_QNS_ID)  order by subtypdata.INSP_SUBTYP_DATA_ID asc) as scoreValue,GROUP_CONCAT(CONCAT(chk.MON_INSP_ATAR,"@",chk.FK_MON_INSP_QNS_ID)  order by subtypdata.INSP_SUBTYP_DATA_ID asc) as atarStatus,GROUP_CONCAT(chk.MON_INSP_REMARK order by chk.MON_INSP_CHK_AUTO_ID asc SEPARATOR "@") as remaRk,GROUP_CONCAT(CONCAT(chk.MON_INSP_FILENAME,"@",chk.FK_MON_INSP_QNS_ID) order by chk.MON_INSP_CHK_AUTO_ID asc) as fileName,GROUP_CONCAT(DISTINCT chk.MON_INSP_FILE_PATH order by chk.MON_INSP_CHK_AUTO_ID asc) as filePath'],$hsChkoptn);
//echo "<pre>";
//echo $this->db->last_query();
//print_R($getEditinspect);
//exit;
//        if(isset($getEditinspect) && !empty($getEditinspect)){
//            foreach($getEditinspect as $gdKey => $gdVal){
//                $getSubtypedataID = explode(",",$gdVal->subTypdataID);
//                $getSubtypeID = $gdVal->FK_MON_SUB_CAT_ID;
//                $getChktypeID = $gdVal->FK_MON_CHK_LIST_ID;
//                
//                $sdDataoptns['where'] = [
//                    'INSP_SUBTYP_DATA_STATUS' => 'Y',
//                    'INSP_SUBTYP_DATA_SUBTYPID' => $getSubtypeID,
//                    'INSP_SUBTYP_DATA_TYPID' => $getChktypeID,
//                ];
//            $getSubtydataDet = $this->common_model->getAlldata(INSP_CL_SUBTYP_DATA.' as sd',['GROUP_CONCAT(sd.INSP_SUBTYP_DATA_DESC  order by sd.INSP_SUBTYP_DATA_ID asc SEPARATOR "@") AS SUBTYPEDATADESC,GROUP_CONCAT(sd.INSP_SUBTYP_DATA_ID order by sd.INSP_SUBTYP_DATA_ID asc) AS SUBTYPEDATAID'],$sdDataoptns);
//            
//            echo $this->db->last_query();
//            print_R($getSubtydataDet);
//                if(isset($getSubtydataDet) && !empty($getSubtydataDet)){
//                foreach($getSubtydataDet as $sdKey => $sdVal){
//                  $getEditsubData['subTypdataID'][$sdKey] =  $sdVal->SUBTYPEDATAID;
//                  $getEditsubData['subTypdata'][$sdKey] =  $sdVal->SUBTYPEDATADESC;
//
//                }
//               
//                $gdVal->subTypdataID = implode(",",$getEditsubData['subTypdataID']);
//                $gdVal->subTypdata = implode(",",$getEditsubData['subTypdata']);
//                }
//            }
//        }
        
        $atarDatas = [];
      
        if($id != ''){
        $atarDataoptn['where'] = [
            'ATAR_INSP_INC_ID' => $did,
            'ATAR_STATUS' => 'Y',
        ];
//        $atarDataoptn['order_by'] = 'ATAR_INSP_SUBCAT_ID ';
        
        $atarDatas = $this->common_model->getAlldata(ATAR_MAIN,['*'],$atarDataoptn,"","","ATAR_INSP_SUBCAT_ID","asc");
       //   echo "<pre>";
//   echo $this->db->last_query();
//   print_r($atarDatas);
//   exit;
        }
         
//        
         $data = array(
            'view_file' => 'inspection/monthly_inspection/add_Inspection',
            'current_menu' => 'Add Monthly Inspection',
            'dropTermname' => $dropTermname,
            'dropLocation' => $dropLocation,
            'dropChecklist' => $dropChecklist,
            'inspidUniq' => $inspidUniq,
            'sessUser' => $sessUser,
            'getHssemaindatas' => $getHssemaindatas,
            'getEditinspect' => $getEditinspect,
            'atarDatas' => $atarDatas,
          );
        $this->template->load_common_template($data);
    }
    
    public function saveInspectionmonthly($id=''){
         $did = decryptval($id);
//        echo "<pre>";
//        echo $did;
//        print_r($this->input->post());
//        print_R($_FILES);
//         exit;
        
          $UserId = getParticsessdata('USER_REF_ID');
         $UsertypId = getParticsessdata('USER_TYPE_ID');
//        exit;
       
        
        $this->form_validation->set_rules('inspec[insp_date]', 'Inspection Date', 'required|trim');
         $this->form_validation->set_rules('inspec[terminal]', 'Terminal', 'required|trim');
        $this->form_validation->set_rules('inspec[location]', 'Location', 'required|trim');
        $this->form_validation->set_rules('inspec[checklistTyp]', 'Checklist Type', 'required|trim');
       
        if ($this->form_validation->run() == true || $id != '') {
            
            $inspDatas = $this->input->post('inspec');
            $inspecCheckDet = $this->input->post('inspcheck');
            
            $getInspstatus = getInspectionmonthlystatus($did);
            
            $monthlyInspstatus = $getInspstatus->MON_INSP_APP_STATUS;
            
             $checkTpeid =  postData($inspDatas,'checklistTyp','disab');
                if(isset($checkTpeid) && $checkTpeid != '' && $checkTpeid != 'disab'){
                    $checkTpeidfinal = $checkTpeid;
                }else{
                   
                    $checkTpeidfinal =  postData($inspDatas,'hidenchecklistTyp'); 
                }
           
            if($monthlyInspstatus != 1){
             
                $speciLoc = postData($inspDatas,'location');
                if($speciLoc != ''){
                    $implLoc = implode(",",$speciLoc);
                }else{
                    $implLoc = '';
                }
            $insertInspec = [
                
                'MON_INSPECTION_DATE' => date('Y-m-d',strtotime($inspDatas['insp_date'])),
                'MON_INSP_HSSE_TYPE_ID' => $UsertypId,
                'MON_INSP_HSSE_ID' => $UserId,
//                'MON_INSP_TER_ID' => postData($inspDatas,'terminal'),
//                'MON_INSP_SPE_LOC_ID' => $implLoc,
//                'MON_INSP_SPE_LOC_OTHER' => postData($inspDatas,'locationOther'),
                'MON_INSP_CHECKLIST_ID' => $checkTpeidfinal,
             
            ];
            
            
             $reviewStat = postData($inspDatas,'Reviewstatus');
                if($reviewStat == -1){
                    $insertInspec['MON_INSP_APP_STATUS'] = -1;
                }else{
                     $insertInspec['MON_INSP_APP_STATUS'] = 1;
                }
            }
            
            if($monthlyInspstatus == ''){
                 $insertInspec['MON_INSP_TER_ID'] = postData($inspDatas,'terminal');
                 $insertInspec['MON_INSP_SPE_LOC_ID'] = $implLoc;
                 $insertInspec['MON_INSP_SPE_LOC_OTHER'] = postData($inspDatas,'locationOther');
                    
            }
            
            if($id != ''){
                
                $reviewStat = postData($inspDatas,'Reviewstatus');
                $reviewComnt = postData($inspDatas,'reviewComment');
                $veriComnt = postData($inspDatas,'verifyComment');
                $apprComnt = postData($inspDatas,'approveComment');
                
                if(empty($reviewStat)){
                    $insertActivity = [
                        'MON_ACT_INSP_ID' => $did,
                        'MON_ACT_INSP_HSSE_ID' => $UserId,
                        'MON_ACT_INSP_HSSE_DATE' => date('Y-m-d H:i:s'),
                    ];
                }
                
                if(!empty($reviewStat) && !empty($reviewComnt) && ($reviewStat == 2 || $reviewStat == -2)){
                    $insertInspec = [
                        'MON_INSP_REVIEW_TYPE_ID' => $UsertypId,
                        'MON_INSP_REVIEW_ID' => $UserId,
                        'MON_INSP_REVIEW_REASON' => $reviewComnt,
//                        'MON_INSP_APP_STATUS' => 2,
                    ];
                    
                    $insertActivity = [
                        'MON_ACT_INSP_ID' => $did,
                        'MON_ACT_INSP_REVIEWER_ID' => $UserId,
                        'MON_ACT_INSP_REVIEWER_COMMNET' => $reviewComnt,
                        'MON_ACT_INSP_REVIEW_DATE' => date('Y-m-d H:i:s'),
                    ];
                    
                    if($reviewStat == 2){
                       $insertInspec['MON_INSP_APP_STATUS'] = 2;
                       $insertActivity['MON_ACT_INSP_ACC_REJ_STATUS'] = 1;
                    }else{
                        $insertInspec['MON_INSP_APP_STATUS'] = -2;
                        $insertActivity['MON_ACT_INSP_ACC_REJ_STATUS'] = 2;
                    }
                   
                }elseif(!empty($reviewStat) && !empty($veriComnt) && ($reviewStat == 3 || $reviewStat == -3)){
                     $insertInspec = [
                        'MON_INSP_VERIFY_TYPE_ID' => $UsertypId,
                        'MON_INSP_VERIFY_ID' => $UserId,
                        'MON_INSP_VERIFY_REASON' => $veriComnt,
//                        'MON_INSP_APP_STATUS' => 2,
                    ];
                     
                      $insertActivity = [
                          'MON_ACT_INSP_ID' => $did,
                        'MON_ACT_INSP_VERIFIER_ID' => $UserId,
                        'MON_ACT_INSP_VERIFIER_COMMENT' => $veriComnt,
                        'MON_ACT_INSP_VERIFY_DATE' => date('Y-m-d H:i:s'),
                    ];
                    
                    if($reviewStat == 3){
                       $insertInspec['MON_INSP_APP_STATUS'] = 3;
                       $insertActivity['MON_ACT_INSP_ACC_REJ_STATUS'] = 1;
                    }else{
                        $insertInspec['MON_INSP_APP_STATUS'] = -3;
                        $insertActivity['MON_ACT_INSP_ACC_REJ_STATUS'] = 2;
                    }
                }elseif(!empty($reviewStat) && !empty($apprComnt) && ($reviewStat == 4 || $reviewStat == -4)){
                     $insertInspec = [
                        'MON_INSP_APPROVER_TYPE_ID' => $UsertypId,
                        'MON_INSP_APPROVER_ID' => $UserId,
                        'MON_INSP_APPROVER_REASON' => $apprComnt,
//                        'MON_INSP_APP_STATUS' => 2,
                    ];
                     $insertActivity = [
                         'MON_ACT_INSP_ID' => $did,
                        'MON_ACT_INSP_APPROVER_ID' => $UserId,
                        'MON_ACT_INSP_APPROVER_COMMENT' => $apprComnt,
                        'MON_ACT_INSP_APPROVE_DATE' => date('Y-m-d H:i:s'),
                    ];
                    
                    if($reviewStat == 4){
                       $insertInspec['MON_INSP_APP_STATUS'] = 4;
                       $insertActivity['MON_ACT_INSP_ACC_REJ_STATUS'] = 1;
                    }else{
                        $insertInspec['MON_INSP_APP_STATUS'] = -4;
                        $insertActivity['MON_ACT_INSP_ACC_REJ_STATUS'] = 2;
                    }
                }
                $updateMainwhere = [
                    'MON_INSP_AUTO_ID' => $did
                ];
//                if(postData($inspDatas,'hidenchecklistTyp') != $checkTpeid){
//                    $updateMaininspec = $this->common_model->updateData(MON_INSP_MAIN,['MON_INSP_STATUS' => 'N'],$updateMainwhere);
//                    $insertInspec['MON_INSP_ID'] = $did;
//                    $updateMaininspec = $this->common_model->updateData(MON_INSP_MAIN,$insertInspec);
//                }else{
                    $updateMaininspec = $this->common_model->updateData(MON_INSP_MAIN,$insertInspec,$updateMainwhere);
//                }
                $updateActivityinspec = $this->common_model->updateData(MON_ACTIVITY,$insertActivity);
            }else{
                $uniqInspidwhr = [];
                $inspidUniq = uniqueIntRefId('MON-INSP',MON_INSP_MAIN , 'MON_INSP_AUTO_ID', 'MON_INSP_AUTO_ID', $uniqInspidwhr);
                $insertInspec['MON_INSP_ID'] = $inspidUniq;
                $updateMaininspec = $this->common_model->updateData(MON_INSP_MAIN,$insertInspec);
                if($reviewStat != -1){
                $insertMainAct = [
                    'MON_ACT_INSP_ID' => $updateMaininspec,
                    'MON_ACT_INSP_HSSE_ID' => $UserId,
                    'MON_ACT_INSP_HSSE_DATE' => date('Y-m-d H:i:s'),
                ];
                $updateMainactivity = $this->common_model->updateData(MON_ACTIVITY,$insertMainAct);
                }
            }
            
            
            $imgDatas = [];
          if(isset($_FILES) && !empty($_FILES)){
            $imgDatas = uploadMultipleimage($_FILES, 'assets/images/modules/inspection/monthly/','beforeImages');
          }
//            print_R($imgDatas);
//            exit;
               $uplImgdatas = '';
               $imgKey = 0;
               
               if($did != ''){
               if(postData($inspDatas,'hidenchecklistTyp') != $checkTpeid){
                   $statusArr = [2,-2,3,-3,4,-4,''];
                   if(!in_array($reviewStat,$statusArr)){
                     $this->common_model->updateData(ATAR_MAIN,['ATAR_STATUS' => 'N'],['ATAR_INSP_INC_ID' => $did]);
              
                   }
                   }
               }
//               exit;
//               if(isset($inspecCheckDet) && !empty($inspecCheckDet)){
            foreach($inspecCheckDet as $chKey => $chVal){
                $subTypid = $chKey;
                
                foreach($chVal as $daKey => $daVal){
//                    echo $daKey;
                   $inspeScore = postData($daVal,'inspScore');
                   $inspCheckremark = postData($daVal,'inspComment');
                   $inspAtarcheck = postData($daVal,'inspAtar');
                   $inspAtareditID = postData($daVal,'inspAtarEditid');
                   $inspEditfinal = postData($daVal,'inspEditid');
                   $inspEditatarLoc = postData($daVal,'atarLocation');
                   if($inspEditatarLoc == '-1'){
                    $inspEditatarLocname = postData($daVal,'atarLocname');
                   }else{
                       $inspEditatarLocname = '';
                   }
                   if($inspAtarcheck == 'on'){
                       $atarCheckval = 'Y';
                   }else{
                       $atarCheckval = 'N';
                   }
//                   echo $inspEditfinal;
//                   echo $inspeScore;
                   if($inspEditfinal != '' && $inspeScore == '3'){
                       
                       $this->common_model->updateData(MON_INSP_CHK,['MON_INSP_SCORE' => 3],['MON_INSP_CHK_AUTO_ID' => $inspEditfinal]);
                   }
                   
//                   if($inspeScore != '3'){
                  
                    $SubtypData = [
                        'FK_MON_CHK_LIST_ID' => $checkTpeidfinal,
                        'FK_MON_SUB_CAT_ID' => $subTypid,
                        'FK_MON_INSP_QNS_ID' => $daKey,
                        'MON_INSP_SCORE' => $inspeScore,
                        'MON_INSP_REMARK' => $inspCheckremark,
                        'MON_INSP_ATAR' => $atarCheckval,
                    ];
                    
                    ///////////atar insert
                    
                    
                     $atarInsert = [
//                        'ATAR_ID' => $atarId,
                        'ATAR_TYPE_ID' => 3,
                        'ATAR_REPORTER_TYPE_ID' => getParticsessdata('USER_TYPE_ID'),
                        'ATAR_REPORTER_ID' => getParticsessdata('USER_REF_ID'),
                        'ATAR_REPORTER_DESG_ID' => getParticsessdata('USER_DESINATION_ID'),
                        'ATAR_LOC_ID' => postData($inspDatas,'terminal'),
//                        'ATAR_SPEC_LOC_ID' => postData($inspDatas,'location'),
                        'ATAR_SPEC_LOC_ID' => $inspEditatarLoc,
                        'ATAR_SPEC_LOC_OTHER' => $inspEditatarLocname,
                        'ATAR_REPORT_DATETIME' => date('Y-m-d H:i:s'),
                        'ATAR_USEE_WHAT_RECCOM' => postData($daVal,'inspComment'),
                        'ATAR_INC_DESC_FINDING' => postData($daVal,'inspSubtypedata'),
                        'ATAR_INSP_SUBCAT_ID' => $daKey,
                        'ATAR_APP_STATUS' => 1,
                    ];
                     
                     $atarImgData = [
                         'ATAR_FILE_TYPE' => 1
                     ];


                   
                    ///////////atar insert
                    
                     if($inspeScore != '-1' && $inspeScore != 3){
                         if(!empty($imgDatas[$imgKey])){
                               $imgUplname =  $imgDatas[$imgKey]['uploadname'];
                               $imgUplpath =  $imgDatas[$imgKey]['uploadpath'];
                               $imgUplext =  $imgDatas[$imgKey]['uploadextension'];
                               $imgUplsize =  $imgDatas[$imgKey]['filesize'];
                              
                               $SubtypData['MON_INSP_FILENAME'] = $imgUplname;
                               $SubtypData['MON_INSP_FILE_EXT'] = $imgUplext;
                               $SubtypData['MON_INSP_FILE_PATH'] = $imgUplpath;
                               $SubtypData['MON_INSP_FILE_SIZE'] = $imgUplsize;
                               
                               $atarImgData['ATAR_FILENAME'] = $imgUplname;
                               $atarImgData['ATAR_FILE_EXT'] = $imgUplext;
                               $atarImgData['ATAR_FILE_SIZE'] = $imgUplsize;
                               $atarImgData['ATAR_FILE_PATH'] = $imgUplpath;
                         }
                      $imgKey++;
                     }
                     if($inspeScore == 3 || $inspeScore == -1){
                         $SubtypData['MON_INSP_FILENAME'] = '';
                               $SubtypData['MON_INSP_FILE_EXT'] = '';
                               $SubtypData['MON_INSP_FILE_PATH'] = '';
                               $SubtypData['MON_INSP_FILE_SIZE'] = '';
                     }
                   
                   if($did != ''){
                     
                       if(!empty($inspecCheckDet)){
                           if($reviewStat != '' && postData($inspDatas,'hidenchecklistTyp') != $checkTpeid){
                                   $this->common_model->updateData(MON_INSP_CHK,['MON_INSP_IMG_STATUS' => 'N'],['FK_MON_INSP_ID' => $did,'FK_MON_CHK_LIST_ID' => postData($inspDatas,'hidenchecklistTyp')]);
//                                    $this->common_model->updateData(MON_INSP_CHK,$SubtypData);
                               
                           }
                        
                           if($inspEditfinal != '' && ($reviewStat == '' || $reviewStat == -1)){
                               if(postData($inspDatas,'hidenchecklistTyp') != $checkTpeid && $checkTpeid != 'disab'){
                                   $SubtypData['FK_MON_INSP_ID'] = $did;
                                    $this->common_model->updateData(MON_INSP_CHK,$SubtypData);
                               }else{
                                $this->common_model->updateData(MON_INSP_CHK,$SubtypData,['MON_INSP_CHK_AUTO_ID' => $inspEditfinal]);
                               }
                           }
                           if($inspEditfinal == '' && ($reviewStat == '' || $reviewStat == -1 )){
                               if(postData($inspDatas,'hidenchecklistTyp') != $checkTpeid){
                                   $SubtypData['FK_MON_INSP_ID'] = $did;
                                    $this->common_model->updateData(MON_INSP_CHK,$SubtypData);
                               }
                           }
//                           else{
//                               $SubtypData['FK_MON_INSP_ID'] = $did;
//                               $this->common_model->updateData(MON_INSP_CHK,$SubtypData);
//                           }
                           

//                           if(postData($inspDatas,'hidenchecklistTyp') != $checkTpeid){
//                               $this->common_model->updateData(ATAR_MAIN,['ATAR_STATUS' => 'N'],['ATAR_INSP_INC_ID' => $did]);
//                               $atarInsert['ATAR_INSP_INC_ID'] = $did;
//                               $this->common_model->updateData(ATAR_MAIN,$atarInsert);
//                           }else{
//                            $atarInsert['ATAR_INSP_INC_ID'] = $did;
//                            if($inspAtareditID != ''){
//                                $this->common_model->updateData(ATAR_MAIN,$atarInsert,['ATAR_AUTO_ID' => $inspAtareditID]);
//                            }
//                           }
                        
//                           if(postData($inspDatas,'hidenchecklistTyp') != $checkTpeid){
////                               $this->common_model->updateData(ATAR_IMG,$atarImgData,['FK_ATAR_MAIN_ID' => $inspAtareditID]);
//                           }else{
//                               if($inspAtareditID != ''){
//                                $this->common_model->updateData(ATAR_IMG,$atarImgData,['FK_ATAR_MAIN_ID' => $inspAtareditID]);
//                            }
//                           }
                           
                           ///////////////atar insert and update start
                            if(postData($inspDatas,'hidenchecklistTyp') != $checkTpeid){
//                                echo "vvvvv----------->".$atarCheckval;
//                                print_R($atarInsert);
//                                exit;
//                               $this->common_model->updateData(ATAR_MAIN,['ATAR_STATUS' => 'N'],['ATAR_INSP_INC_ID' => $did]);
                              if($atarCheckval == 'Y'){
                               $atarInsert['ATAR_INSP_INC_ID'] = $did;
                                $module = 'INS';
                                $locName = getLocationShorName(postData($inspDatas,'terminal'));
                                $atarId = getAtarNumber($module,$locName,postData($inspDatas,'terminal'));
//                               $atarId = 'ATAR-0001';
                                
                                if($inspAtareditID != ''){
                                    $mainAtarinsert = $this->common_model->updateData(ATAR_MAIN,$atarInsert,['ATAR_AUTO_ID' =>$inspAtareditID,'ATAR_APP_STATUS' =>1]);
                                    $finAtaroptionS['where'] = [
                                        'ATAR_AUTO_ID' => $inspAtareditID
                                    ];
                                    $finAtaroptionS['return_type'] = 'row';
                                  $mainAtarstatusdet =   $this->common_model->getAlldata(ATAR_MAIN,['*'],$finAtaroptionS);
                                if(postData($mainAtarstatusdet,'ATAR_APP_STATUS') == 1){
                                    $this->common_model->updateData(ATAR_IMG,$atarImgData,['FK_ATAR_MAIN_ID' =>$inspAtareditID]);
                                }
                               
                                }else{
                                    $atarInsert['ATAR_ID'] = $atarId;
                                    $mainAtarinsert = $this->common_model->updateData(ATAR_MAIN,$atarInsert);
                               
                                    $atarImgData['FK_ATAR_MAIN_ID'] = $mainAtarinsert;
                                    $this->common_model->updateData(ATAR_IMG,$atarImgData);
                                }
                               
                              }else{
                                  if($inspAtareditID != ''){
                                      if($inspeScore == 3 || $inspeScore == '-1'){
                                          $this->common_model->updateData(ATAR_MAIN,['ATAR_STATUS' => 'N'],['ATAR_AUTO_ID'  => $inspAtareditID]);
                                      }
                                  }
                              }
                           }
                           elseif($inspAtareditID != ''){
//                               echo $inspAtareditID;exit;
                               $finAtaroptionS['where'] = [
                                        'ATAR_AUTO_ID' => $inspAtareditID
                                    ];
                               $finAtaroptionS['return_type'] = 'row';
                               $mainAtarstatusdet =   $this->common_model->getAlldata(ATAR_MAIN,['*'],$finAtaroptionS);
                               
                               if($atarCheckval == 'N' && $inspAtareditID != ''){
                                   $this->common_model->updateData(ATAR_MAIN,['ATAR_STATUS' => 'N'],['ATAR_AUTO_ID' => $inspAtareditID,'ATAR_APP_STATUS' =>1]);
                                  
                                   if(postData($mainAtarstatusdet,'ATAR_APP_STATUS') == 1){
                                        $this->common_model->updateData(ATAR_IMG,['ATAR_ATTACH_STATUS' => 'N'],['FK_ATAR_MAIN_ID' => $inspAtareditID]);
                                   } 
                               }else{
                               $atarInsert['ATAR_INSP_INC_ID'] = $did;
                               
                               $module = 'INS';
                                $locName = getLocationShorName(postData($inspDatas,'terminal'));
                                $atarId = getAtarNumber($module,$locName,postData($inspDatas,'terminal'));
//                               $atarId = 'ATAR-0001';
//                                $atarInsert['ATAR_ID'] = $atarId;
                               $this->common_model->updateData(ATAR_MAIN,$atarInsert,['ATAR_AUTO_ID' => $inspAtareditID,'ATAR_APP_STATUS' =>1]);
                               if(postData($mainAtarstatusdet,'ATAR_APP_STATUS') == 1){
                               $this->common_model->updateData(ATAR_IMG,$atarImgData,['FK_ATAR_MAIN_ID' => $inspAtareditID]);
                               }
                               }
                            }
                           ///////////////atar insert and update end
                           

                       }
                   }else{
                       $SubtypData['FK_MON_INSP_ID'] = $updateMaininspec;
                     
                        $this->common_model->updateData(MON_INSP_CHK,$SubtypData);
                        
                        if($inspeScore != 3 && $inspeScore != '-1' && $atarCheckval == 'Y') {
                            
                    $module = 'INS';
                    $locName = getLocationShorName(postData($inspDatas,'terminal'));
                    $atarId = getAtarNumber($module,$locName,postData($inspDatas,'terminal'));
                            
//                            $atarId = 'ATAR-0001';
                           
                        $atarInsert['ATAR_INSP_INC_ID'] = $updateMaininspec;
                        $atarInsert['ATAR_ID'] = $atarId;
                        $insertAtarmain = $this->common_model->updateData(ATAR_MAIN,$atarInsert);
                        sendAtarNotification($insertAtarmain);
                        $atarImgData['FK_ATAR_MAIN_ID'] = $insertAtarmain;
                        $this->common_model->updateData(ATAR_IMG,$atarImgData);
                        }
                    }
//                }
               
                 }
             }
//             }
//             exit;
             ////////////////////notifivcation and mail start
//             exit;
              if ($id == '' && $reviewStat == '') {
                  
//                  $empldatas = getUserdetbyDesig([26]);
                  $empldatas = getEmpbytypdes([7],[26]);
//                 echo "<pre>";
//                 print_R($empldatas);
//                 exit;
                 foreach($empldatas as $emKey => $emVal){
                     $empMailID[] = postData($emVal,'EMP_EMAIL_ID');
                     $empNotifyto[] = postData($emVal,'LOGIN_ID');
                 }
                  $idata['emplmailID'] = implode(",",$empMailID);

                  $monInspOptns['where'] = [
                    'MON_INSP_AUTO_ID' => $updateMaininspec
                ];
                $monInspOptns['return_type'] = 'row';
                $monInspOptns['join'][TERM.' as term'] = ['term.TER_AUTO_ID = main.MON_INSP_TER_ID','left'];
//                $monInspOptns['join'][SPE_LOC.' as loct'] = ['loct.SL_AUTO_ID = main.MON_INSP_SPE_LOC_ID','left'];
                $monInspOptns['join'][SPE_LOC.' loct'] = ['find_in_set(loct.SL_AUTO_ID,main.MON_INSP_SPE_LOC_ID) > 0','left'];
                $monInspOptns['join'][INSP_CL_TYP.' as chk'] = ['chk.INSP_CHECK_TYP_ID = main.MON_INSP_CHECKLIST_ID','left'];
                $monInspOptns['join'][EMPL.' as empl'] = ['empl.EMP_AUTO_ID = main.MON_INSP_HSSE_ID','left'];
      
                $monInspdet = $this->common_model->getAlldata(MON_INSP_MAIN.' as main',['main.*,term.TERMINAL_NAME,chk.INSP_CHECK_TYP_NAME,GROUP_CONCAT(loct.SPECIFIC_LOC_NAME) as specLoctn,empl.EMP_NAME'],$monInspOptns);
              
////////noti start
                    $idata['notifyMsg'] = 'New Monthly inspection checklist has been created and waiting for you to review with following details:'
                                         .'<br><br><br><b>Inspection ID : </b>'.postData($monInspdet,'MON_INSP_ID')
                                        . '<br><b>Inspection Date : </b>'.date('d-m-Y',strtotime(postData($monInspdet,'MON_INSPECTION_DATE')))
                                        . '<br><b>Inspected by: </b>'.postData($monInspdet,'EMP_NAME')
                                        . '<br><b>Terminal: </b>'.postData($monInspdet,'TERMINAL_NAME')
                                        . '<br><b>Specific Location: </b>'.postData($monInspdet,'specLoctn')
                                        . '<br><b>Inspection Checklist: </b>'. postData($monInspdet,'INSP_CHECK_TYP_NAME')
                                        .'<br>';
                 
                $idata['url'] = 'inspection/addMonthlyinspection/'. encryptval($updateMaininspec);
                 $idata['moduleName'] = 'inspection';
                 $idata['notifytoID'] = implode(",",$empNotifyto);
                 $idata['inspId'] = (isset($did) && !empty($did)) ? $did : $updateMaininspec;
                 
                 //////noti end
               
                /////// mail start
                 $systMail ='This is system generated E-mail, do not reply to this email.';
                $idata['messageText'] = $idata['notifyMsg'].'<br><br><br>'.$systMail;
                $idata['subject'] = 'VAULT - Monthly Inspection';
                /////// mail end
//                echo "<pre>";
//                print_R($idata);
//                exit;
              internalNotificationOverall($idata);  
           
                $data = [
                    'status' => true
                ];
                if ($newEmpdetID != '') {
                    $data['flasmsg'] = $this->session->set_flashdata('inspcTn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Inspection has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inspcTn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> New Inspection has been created</div>');
                }
              
            }else if($reviewStat != '-1'){
                
                $monInspOptns['where'] = [
                    'MON_INSP_AUTO_ID' => $did
                ];
                $monInspOptns['return_type'] = 'row';
                $monInspOptns['join'][TERM.' as term'] = ['term.TER_AUTO_ID = main.MON_INSP_TER_ID','left'];
//                $monInspOptns['join'][SPE_LOC.' as loct'] = ['loct.SL_AUTO_ID = main.MON_INSP_SPE_LOC_ID','left'];
                $monInspOptns['join'][SPE_LOC.' loct'] = ['find_in_set(loct.SL_AUTO_ID,main.MON_INSP_SPE_LOC_ID) > 0','left'];
                $monInspOptns['join'][INSP_CL_TYP.' as chk'] = ['chk.INSP_CHECK_TYP_ID = main.MON_INSP_CHECKLIST_ID','left'];
                $monInspOptns['join'][EMPL.' as empl'] = ['empl.EMP_AUTO_ID = main.MON_INSP_HSSE_ID','left'];
      
                $monInspdet = $this->common_model->getAlldata(MON_INSP_MAIN.' as main',['main.*,term.TERMINAL_NAME,chk.INSP_CHECK_TYP_NAME,GROUP_CONCAT(loct.SPECIFIC_LOC_NAME) as specLoctn,empl.EMP_NAME'],$monInspOptns);
                
                $monTerminal = postData($monInspdet,'TERMINAL_NAME');
//                $monSpeclocation = postData($monInspdet,'SPECIFIC_LOC_NAME');
                $monSpeclocation = postData($monInspdet,'specLoctn');
                $monChecklist = postData($monInspdet,'INSP_CHECK_TYP_NAME');
                $monHseexec = postData($monInspdet,'MON_INSP_HSSE_ID');
                $monReviewerid = postData($monInspdet,'MON_INSP_REVIEW_ID');
                $monVerifierid = postData($monInspdet,'MON_INSP_VERIFY_ID');
                $monApproverid = postData($monInspdet,'MON_INSP_APPROVER_ID');
//                echo "gfdgfdhgf";
//                echo $monReviewerid;
//                echo $reviewStat;
               
                ////////hsse exe submit
                if($reviewStat == ''){
                    if($monReviewerid != '0'){
                        $emplOptns['where'] = [
                            'emp.EMP_AUTO_ID' => $monReviewerid,
                            'log.USER_LOGIN_TYP' => 0
                        ];
                        $emplOptns['return_type'] = 'row';
                        $emplOptns['join'][LOGIN.' as log'] = ['emp.EMP_AUTO_ID = log.USER_REF_ID','left'];
                        $empldatas = $this->common_model->getAlldata(EMPL.' as emp',['*'],$emplOptns);
                        $empMailID[] = postData($empldatas,'EMP_EMAIL_ID');
                        $empNotifyto[] = postData($empldatas,'LOGIN_ID');
                        $notiInimsg = 'Monthly inspection checklist has been Re-prepared and waiting for you to review with following details:';
                  
                }else{
                  
//                        $empldatas = getUserdetbyDesig([26]);
                        $empldatas = getEmpbytypdes([7],[26]);
                       
                        foreach($empldatas as $emKey => $emVal){
                            $empMailID[] = postData($emVal,'EMP_EMAIL_ID');
                            $empNotifyto[] = postData($emVal,'LOGIN_ID');
                        }
                        $notiInimsg = 'New Monthly inspection checklist has been created and waiting for you to review with following details:';
                     }
                   
                  $idata['emplmailID'] = implode(",",$empMailID);
                  
                  
                  ////////noti start
                    
                 
                }
                
                ///// reviewer accepted
                if($reviewStat == 2){
                    if($monVerifierid != '0'){
                        $emplOptns['where'] = [
                            'emp.EMP_AUTO_ID' => $monVerifierid,
                            'log.USER_LOGIN_TYP' => 0
                        ];
                        $emplOptns['return_type'] = 'row';
                        $emplOptns['join'][LOGIN.' as log'] = ['emp.EMP_AUTO_ID = log.USER_REF_ID','left'];
                        $empldatas = $this->common_model->getAlldata(EMPL.' as emp',['*'],$emplOptns);
                        $empMailID[] = postData($empldatas,'EMP_EMAIL_ID');
                        $empNotifyto[] = postData($empldatas,'LOGIN_ID');
                    }else{
                        if(postdata($monInspdet,'MON_INSP_TER_ID') == 1){
//                           $empldatas = getUserdetbyDesig([22]); 
                           $empldatas = getEmpbytypdes([8],[22]);
                        }else{
//                            $empldatas = getUserdetbyDesig([18]);
                            $empldatas = getEmpbytypdes([8],[18]);
                        }
                       
                        foreach($empldatas as $emKey => $emVal){
                            $empMailID[] = postData($emVal,'EMP_EMAIL_ID');
                            $empNotifyto[] = postData($emVal,'LOGIN_ID');
                        }
                     }
                    
                
                  $idata['emplmailID'] = implode(",",$empMailID);

                ////////noti start
                    $notiInimsg = 'Monthly inspection checklist has been Reviewed and waiting for you to Verfiy with following details:';
                    $otherNotidet = '<b>Reviewer Approve comment : </b>'.postData($monInspdet,'MON_INSP_REVIEW_REASON') ;              
                }
                
                //////////reviewer reject
                if($reviewStat == -2){
                    
                 $emplOptns['where'] = [
                            'emp.EMP_AUTO_ID' => $monHseexec,
                            'log.USER_LOGIN_TYP' => 0
                        ];
                  $emplOptns['return_type'] = 'row';
                  $emplOptns['join'][LOGIN.' as log'] = ['emp.EMP_AUTO_ID = log.USER_REF_ID','left'];
                 $empldatas = $this->common_model->getAlldata(EMPL.' as emp',['*'],$emplOptns);
                 
//                 foreach($empldatas as $emKey => $emVal){
                     $empMailID[] = postData($empldatas,'EMP_EMAIL_ID');
                     $empNotifyto[] = postData($empldatas,'LOGIN_ID');
//                 }
                  $idata['emplmailID'] = implode(",",$empMailID);

                ////////noti start
                    $notiInimsg = 'Monthly inspection checklist has been Rejected by reviewer  with following details:';
                    $otherNotidet = '<b>Reviewer Reject comment : </b>'.postData($monInspdet,'MON_INSP_REVIEW_REASON') ;              
               
                    }
                ///// verifier accepted
                if($reviewStat == 3){
                    if($monApproverid != '0'){
                        $emplOptns['where'] = [
                            'EMP_AUTO_ID' => $monApproverid,
                            'log.USER_LOGIN_TYP' => 0
                        ];
                        $emplOptns['return_type'] = 'row';
                        $emplOptns['join'][LOGIN.' as log'] = ['emp.EMP_AUTO_ID = log.USER_REF_ID','left'];
                        $empldatas = $this->common_model->getAlldata(EMPL.' as emp',['*'],$emplOptns);
                        $empMailID[] = postData($empldatas,'EMP_EMAIL_ID');
                        $empNotifyto[] = postData($empldatas,'LOGIN_ID');
                    }else{
//                        $empldatas = getUserdetbyDesig([40]);
                        $empldatas = getEmpbytypdes([9],[40]);
                        foreach($empldatas as $emKey => $emVal){
                            $empMailID[] = postData($emVal,'EMP_EMAIL_ID');
                            $empNotifyto[] = postData($emVal,'LOGIN_ID');
                        }
                    }
                
                 
                  $idata['emplmailID'] = implode(",",$empMailID);
                  
                ////////noti start
                    $notiInimsg = 'Monthly inspection checklist has been Verified and waiting for you to Approve with following details:';
                    $otherNotidet = '<b>Verifier Approve comment : </b>'.postData($monInspdet,'MON_INSP_VERIFY_REASON') ;              
                }
                ///// verifier reject
                if($reviewStat == -3){
                   
                        $emplOptns['where'] = [
                            'EMP_AUTO_ID' => $monReviewerid,
                            'log.USER_LOGIN_TYP' => 0
                        ];
                        $emplOptns['return_type'] = 'row';
                        $emplOptns['join'][LOGIN.' as log'] = ['emp.EMP_AUTO_ID = log.USER_REF_ID','left'];
                        $empldatas = $this->common_model->getAlldata(EMPL.' as emp',['*'],$emplOptns);
                   
                
//                 foreach($empldatas as $emKey => $emVal){
                     $empMailID[] = postData($empldatas,'EMP_EMAIL_ID');
                     $empNotifyto[] = postData($empldatas,'LOGIN_ID');
//                 }
                  $idata['emplmailID'] = implode(",",$empMailID);
                  
                ////////noti start
                    $notiInimsg = 'Monthly inspection checklist has been Rejected by Verifier with following details:';
                    $otherNotidet = '<b>Verifier Reject comment : </b>'.postData($monInspdet,'MON_INSP_VERIFY_REASON') ;              
                }
                
                ///////////approver accepted
                if($reviewStat == 4){
                
                     $emplOptns['where'] = [
                            'EMP_AUTO_ID' => $monHseexec,
                            'log.USER_LOGIN_TYP' => 0
                        ];
                     $emplOptns['return_type'] = 'row';
                     $emplOptns['join'][LOGIN.' as log'] = ['emp.EMP_AUTO_ID = log.USER_REF_ID','left'];
                    $empldatas = $this->common_model->getAlldata(EMPL.' as emp',['*'],$emplOptns);
                    
                  $idata['emplmailID'] = postData($empldatas,'EMP_EMAIL_ID');
                  $empNotifyto[] = postData($empldatas,'LOGIN_ID');

                ////////noti start
                    $notiInimsg = 'Monthly inspection has been Approved with following details:';
                    $otherNotidet = '<b>Approver Approve comment : </b>'.postData($monInspdet,'MON_INSP_APPROVER_REASON') ;              
                }
                ///////////approver reject
                if($reviewStat == -4){
                
                     $emplOptns['where'] = [
                            'EMP_AUTO_ID' => $monVerifierid,
                            'log.USER_LOGIN_TYP' => 0
                        ];
                     $emplOptns['return_type'] = 'row';
                     $emplOptns['join'][LOGIN.' as log'] = ['emp.EMP_AUTO_ID = log.USER_REF_ID','left'];
                     $empldatas = $this->common_model->getAlldata(EMPL.' as emp',['*'],$emplOptns);
                  $idata['emplmailID'] = postData($empldatas,'EMP_EMAIL_ID');
                  $empNotifyto[] = postData($empldatas,'LOGIN_ID');

                ////////noti start
                    $notiInimsg = 'Monthly inspection has been Rejected by approver with following details:';
                    $otherNotidet = '<b>Approver Reject comment : </b>'.postData($monInspdet,'MON_INSP_APPROVER_REASON') ;              
                }
                
                $commonNoti = '<br><br><b>Inspection ID : </b>'.postData($inspDatas,'inspec_id')
                                        . '<br><b>Inspection Date : </b>'.date('d-m-Y',strtotime(postdata($monInspdet,'MON_INSPECTION_DATE')))
                                        . '<br><b>Inspected by: </b>'.postData($inspDatas,'insp_by')
                                        . '<br><b>Terminal: </b>'.$monTerminal
                                        . '<br><b>Specific Location: </b>'.$monSpeclocation
                                        . '<br><b>Inspection Checklist: </b>'.$monChecklist
                                        .'<br>';
                $idata['notifyMsg'] = $notiInimsg.''.$commonNoti.''.$otherNotidet;
                $idata['url'] = 'inspection/addMonthlyinspection/'. $id;
                 $idata['moduleName'] = 'inspection';
                 $idata['notifytoID'] = implode(",",$empNotifyto);
                 $idata['inspId'] = (isset($did) && !empty($did)) ? $did : $updateMaininspec;
                
                 //////noti end
               
                /////// mail start
                 $systMail ='This is system generated E-mail, do not reply to this email.';
                $idata['messageText'] = $idata['notifyMsg'].'<br><br><br>'.$systMail;
                $idata['subject'] = 'VAULT - Monthly Inspection';
                /////// mail end
               
              internalNotificationOverall($idata);
              
            }
             ////////////////////notifivcation and mail end
//            exit;
             redirect('inspection/Inspectionlistmonthly');
             
        }else{
            $this->addMonthlyinspection($id);
        }
        
    }
   
     public function deleteInspectionmonthly(){
         $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(MON_INSP_MAIN, ['MON_INSP_STATUS' => 'N'], ['MON_INSP_AUTO_ID' => decryptval($deleteId)]);
        $updtDeletechecklist = $this->common_model->updateData(MON_INSP_CHK, ['MON_INSP_IMG_STATUS' => 'N'], ['FK_MON_INSP_ID' => decryptval($deleteId)]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Monthly Inspection  deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Monthly Inspection '
            ];
        }
        echo json_encode($retData);
    }
    
   public function viewInspectionmonthly($id=""){
       $did = decryptval($id);
       
//       $insptOptns['where'] = [
//                    'INSP_AUTO_ID' => $did
//                ];
//        $insptOptns['return_type'] = 'row';
//        $insptOptns['join'][TERM.' as term'] = ['term.TER_AUTO_ID = main.INSP_TER_ID','left'];
//        $insptOptns['join'][DEPT.' as dept'] = ['dept.DEPT_AUTO_ID = main.INSP_DEPT_ID','left'];
//        $insptOptns['join'][INSP_CL_TYP.' as chk'] = ['chk.INSP_CHECK_TYP_ID = main.INSP_CHECKLIST_ID','left'];
//        $insptOptns['join'][EMPL.' as emp'] = ['emp.EMP_AUTO_ID = main.INSP_HSSE_ID','left'];
//        $insptOptns['join'][EMPL.' as exec'] = ['exec.EMP_AUTO_ID = main.INSP_VERIFY_ID','left'];
//        $InspBasicDet = $this->common_model->getAlldata(HSSE_INSP_MAIN.' as main',['main.*,term.TERMINAL_NAME,dept.DEPT_NAME,chk.INSP_CHECK_TYP_NAME,emp.EMP_NAME as hsseName,emp.EMP_EMAIL_ID as hsseMail,exec.EMP_NAME as execName'],$insptOptns);
        
        
        $monMainoptn['where'] = [
            'MON_INSP_AUTO_ID' => $did
        ];
        $monMainoptn['return_type'] = 'row';
        $monMainoptn['join'][TERM.' as term'] = ['term.TER_AUTO_ID = main.MON_INSP_TER_ID','left'];
//        $monMainoptn['join'][SPE_LOC.' as loct'] = ['loct.SL_AUTO_ID = main.MON_INSP_SPE_LOC_ID','left'];
        $monMainoptn['join'][SPE_LOC.' loct'] = ['find_in_set(loct.SL_AUTO_ID,main.MON_INSP_SPE_LOC_ID) > 0','left'];
        $monMainoptn['join'][INSP_CL_TYP.' as chk'] = ['chk.INSP_CHECK_TYP_ID = main.MON_INSP_CHECKLIST_ID','left'];


        
//$monMainoptn['join'][LOGIN_DETAILS.' as LD'] = ['LD.LOGIN_ID = main.MON_INSP_HSSE_ID','left'];
        $monMainoptn['join'][EMPL.' as empl'] = ['empl.EMP_AUTO_ID = main.MON_INSP_HSSE_ID','left'];
        $InspBasicDet =  $this->common_model->getAlldata(MON_INSP_MAIN.' as main',['main.*,term.TERMINAL_NAME,chk.INSP_CHECK_TYP_NAME,GROUP_CONCAT(loct.SPECIFIC_LOC_NAME) as specLoctn,empl.EMP_NAME'],$monMainoptn);



        /////////////checklist start
 //echo "<pre>";
 //echo $this->db->last_query();
 //print_R($InspBasicDet); exit;
        $hsChkoptn['where'] = [
            'FK_MON_INSP_ID' => $did,
            'MON_INSP_IMG_STATUS' => 'Y',
        ];

        $hsChkoptn['join'][INSP_CL_SUBTYP.' as subtyp'] = ['subtyp.INSP_CHECK_SUBTYP_ID = chk.FK_MON_SUB_CAT_ID','left'];
        $hsChkoptn['join'][INSP_CL_SUBTYP_DATA.' as subtypdata'] = ['subtypdata.INSP_SUBTYP_DATA_ID = chk.FK_MON_INSP_QNS_ID','left'];
        $hsChkoptn['group_by'] = 'subtyp.INSP_CHECK_SUBTYP_ID';
//        $getEditinspect = $this->common_model->getAlldata(MON_INSP_CHK.' as chk',['chk.*,GROUP_CONCAT(DISTINCT CONCAT(chk.MON_INSP_CHK_AUTO_ID,"@",chk.FK_MON_INSP_QNS_ID)) as checkListid,GROUP_CONCAT(DISTINCT subtyp.INSP_CHECK_SUBTYP_NAME) as subTyp,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_ID order by chk.MON_INSP_CHK_AUTO_ID asc) as subTypdataID,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_DESC order by chk.MON_INSP_CHK_AUTO_ID asc) as subTypdata,GROUP_CONCAT(CONCAT(chk.MON_INSP_SCORE,"@",chk.FK_MON_INSP_QNS_ID)  order by chk.MON_INSP_CHK_AUTO_ID asc) as scoreValue,GROUP_CONCAT(CONCAT(chk.MON_INSP_ATAR,"@",chk.FK_MON_INSP_QNS_ID)  order by subtypdata.INSP_SUBTYP_DATA_ID asc) as atarStatus,GROUP_CONCAT(chk.MON_INSP_REMARK order by chk.MON_INSP_CHK_AUTO_ID asc) as remaRk,GROUP_CONCAT(CONCAT(chk.MON_INSP_FILENAME,"@",chk.FK_MON_INSP_QNS_ID) order by chk.MON_INSP_CHK_AUTO_ID asc) as fileName,GROUP_CONCAT(DISTINCT chk.MON_INSP_FILE_PATH order by chk.MON_INSP_CHK_AUTO_ID asc) as filePath'],$hsChkoptn);

         $getEditinspect = $this->common_model->getAlldata(MON_INSP_CHK.' as chk',['chk.*,GROUP_CONCAT(CONCAT(chk.MON_INSP_CHK_AUTO_ID,"@",chk.FK_MON_INSP_QNS_ID)) as checkListid,GROUP_CONCAT(DISTINCT subtyp.INSP_CHECK_SUBTYP_NAME) as subTyp,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_ID order by chk.MON_INSP_CHK_AUTO_ID asc) as subTypdataID,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_DESC order by chk.MON_INSP_CHK_AUTO_ID asc SEPARATOR "@") as subTypdata,GROUP_CONCAT(CONCAT(chk.MON_INSP_SCORE,"@",chk.FK_MON_INSP_QNS_ID)  order by subtypdata.INSP_SUBTYP_DATA_ID asc) as scoreValue,GROUP_CONCAT(CONCAT(chk.MON_INSP_ATAR,"@",chk.FK_MON_INSP_QNS_ID)  order by subtypdata.INSP_SUBTYP_DATA_ID asc) as atarStatus,GROUP_CONCAT(chk.MON_INSP_REMARK order by chk.MON_INSP_CHK_AUTO_ID asc) as remaRk,GROUP_CONCAT(CONCAT(chk.MON_INSP_FILENAME,"@",chk.FK_MON_INSP_QNS_ID) order by chk.MON_INSP_CHK_AUTO_ID asc) as fileName,GROUP_CONCAT(DISTINCT chk.MON_INSP_FILE_PATH order by chk.MON_INSP_CHK_AUTO_ID asc) as filePath'],$hsChkoptn);
//        if(isset($getEditinspect) && !empty($getEditinspect)){
//            foreach($getEditinspect as $gdKey => $gdVal){
//                $getSubtypedataID = explode(",",$gdVal->subTypdataID);
//                $getSubtypeID = $gdVal->FK_MON_SUB_CAT_ID;
//                $getChktypeID = $gdVal->FK_MON_CHK_LIST_ID;
//                
//                $sdDataoptns['where'] = [
//                    'INSP_SUBTYP_DATA_STATUS' => 'Y',
//                    'INSP_SUBTYP_DATA_SUBTYPID' => $getSubtypeID,
//                    'INSP_SUBTYP_DATA_TYPID' => $getChktypeID,
//                ];
//            $getSubtydataDet = $this->common_model->getAlldata(INSP_CL_SUBTYP_DATA.' as sd',['GROUP_CONCAT(sd.INSP_SUBTYP_DATA_DESC  order by sd.INSP_SUBTYP_DATA_ID asc SEPARATOR "@") AS SUBTYPEDATADESC,GROUP_CONCAT(sd.INSP_SUBTYP_DATA_ID order by sd.INSP_SUBTYP_DATA_ID asc) AS SUBTYPEDATAID'],$sdDataoptns);
//            
////            echo $this->db->last_query();
////            print_R($getSubtydataDet);
//                if(isset($getSubtydataDet) && !empty($getSubtydataDet)){
//                foreach($getSubtydataDet as $sdKey => $sdVal){
//                  $getEditsubData['subTypdataID'][$sdKey] =  $sdVal->SUBTYPEDATAID;
//                  $getEditsubData['subTypdata'][$sdKey] =  $sdVal->SUBTYPEDATADESC;
//
//                }
//               
//                $gdVal->subTypdataID = implode(",",$getEditsubData['subTypdataID']);
//                $gdVal->subTypdata = implode(",",$getEditsubData['subTypdata']);
//                }
//            }
//        }
        /////////////checklist end


        $monActoptns['where'] = [
           'MON_INSP_AUTO_ID' => $did
       ];
       $monActoptns['join'][EMPL.' as empHsse'] = ['empHsse.EMP_AUTO_ID = mains.MON_INSP_REVIEW_ID','left'];
       $monActoptns['join'][EMPL.' as empRev'] = ['empRev.EMP_AUTO_ID = mains.MON_INSP_REVIEW_ID','left'];
       $monActoptns['join'][EMPL.' as empVeri'] = ['empVeri.EMP_AUTO_ID = mains.MON_INSP_VERIFY_ID','left'];
       $monActoptns['join'][EMPL.' as empAppr'] = ['empAppr.EMP_AUTO_ID = mains.MON_INSP_APPROVER_ID','left'];
       $activityDet = $this->common_model->getAlldata(MON_INSP_MAIN.' as mains',['mains.*,mains.MON_INSP_ID,empHsse.EMP_NAME as HSSEname,empRev.EMP_NAME as revName,empVeri.EMP_NAME as verifName,empAppr.EMP_NAME as apprName'],$monActoptns);
       
      
        $data = array(
            'view_file' => 'inspection/monthly_inspection/view_Inspection',
            'current_menu' => 'View Monthly Inspection',
            'InspBasicDet' => $InspBasicDet,
            'InspectionDet' => $getEditinspect,
           'activityDet' => $activityDet, 
           
        );
        $this->template->load_common_template($data);
   }
   
   public function pdfInspectionmonthly($id=""){
      $did = decryptval($id);
       
        $monMainoptn['where'] = [
            'MON_INSP_AUTO_ID' => $did
        ];
        $monMainoptn['return_type'] = 'row';
        $monMainoptn['join'][TERM.' as term'] = ['term.TER_AUTO_ID = main.MON_INSP_TER_ID','left'];
//        $monMainoptn['join'][SPE_LOC.' as loct'] = ['loct.SL_AUTO_ID = main.MON_INSP_SPE_LOC_ID','left'];
        $monMainoptn['join'][SPE_LOC.' loct'] = ['find_in_set(loct.SL_AUTO_ID,main.MON_INSP_SPE_LOC_ID) > 0','left'];
        $monMainoptn['join'][INSP_CL_TYP.' as chk'] = ['chk.INSP_CHECK_TYP_ID = main.MON_INSP_CHECKLIST_ID','left'];
        $monMainoptn['join'][EMPL.' as empl'] = ['empl.EMP_AUTO_ID = main.MON_INSP_HSSE_ID','left'];
        $InspBasicDet =  $this->common_model->getAlldata(MON_INSP_MAIN.' as main',['main.*,term.TERMINAL_NAME,chk.INSP_CHECK_TYP_NAME,GROUP_CONCAT(loct.SPECIFIC_LOC_NAME) as specLoctn,empl.EMP_NAME'],$monMainoptn);
        
        $pdfUniqid = postData($InspBasicDet,'MON_INSP_ID');
        /////////////checklist start
 
        $hsChkoptn['where'] = [
            'FK_MON_INSP_ID' => $did,
            'MON_INSP_IMG_STATUS' => 'Y',
        ];

        $hsChkoptn['join'][INSP_CL_SUBTYP.' as subtyp'] = ['subtyp.INSP_CHECK_SUBTYP_ID = chk.FK_MON_SUB_CAT_ID','left'];
        $hsChkoptn['join'][INSP_CL_SUBTYP_DATA.' as subtypdata'] = ['subtypdata.INSP_SUBTYP_DATA_ID = chk.FK_MON_INSP_QNS_ID','left'];
        $hsChkoptn['group_by'] = 'subtyp.INSP_CHECK_SUBTYP_ID';
//        $getEditinspect = $this->common_model->getAlldata(MON_INSP_CHK.' as chk',['chk.*,GROUP_CONCAT(CONCAT(chk.MON_INSP_CHK_AUTO_ID,"@",chk.FK_MON_INSP_QNS_ID)) as checkListid,GROUP_CONCAT(DISTINCT subtyp.INSP_CHECK_SUBTYP_NAME) as subTyp,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_ID order by chk.MON_INSP_CHK_AUTO_ID asc) as subTypdataID,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_DESC order by chk.MON_INSP_CHK_AUTO_ID asc) as subTypdata,GROUP_CONCAT(CONCAT(chk.MON_INSP_SCORE,"@",chk.FK_MON_INSP_QNS_ID)  order by chk.MON_INSP_CHK_AUTO_ID asc) as scoreValue,GROUP_CONCAT(chk.MON_INSP_REMARK order by chk.MON_INSP_CHK_AUTO_ID asc) as remaRk,GROUP_CONCAT(CONCAT(chk.MON_INSP_FILENAME,"@",chk.FK_MON_INSP_QNS_ID) order by chk.MON_INSP_CHK_AUTO_ID asc) as fileName,GROUP_CONCAT(DISTINCT chk.MON_INSP_FILE_PATH order by chk.MON_INSP_CHK_AUTO_ID asc) as filePath'],$hsChkoptn);

        $getEditinspect = $this->common_model->getAlldata(MON_INSP_CHK.' as chk',['chk.*,GROUP_CONCAT(CONCAT(chk.MON_INSP_CHK_AUTO_ID,"@",chk.FK_MON_INSP_QNS_ID)) as checkListid,GROUP_CONCAT(DISTINCT subtyp.INSP_CHECK_SUBTYP_NAME) as subTyp,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_ID order by chk.MON_INSP_CHK_AUTO_ID asc) as subTypdataID,GROUP_CONCAT(subtypdata.INSP_SUBTYP_DATA_DESC order by chk.MON_INSP_CHK_AUTO_ID asc SEPARATOR "@") as subTypdata,GROUP_CONCAT(CONCAT(chk.MON_INSP_SCORE,"@",chk.FK_MON_INSP_QNS_ID)  order by subtypdata.INSP_SUBTYP_DATA_ID asc) as scoreValue,GROUP_CONCAT(CONCAT(chk.MON_INSP_ATAR,"@",chk.FK_MON_INSP_QNS_ID)  order by subtypdata.INSP_SUBTYP_DATA_ID asc) as atarStatus,GROUP_CONCAT(chk.MON_INSP_REMARK order by chk.MON_INSP_CHK_AUTO_ID asc) as remaRk,GROUP_CONCAT(CONCAT(chk.MON_INSP_FILENAME,"@",chk.FK_MON_INSP_QNS_ID) order by chk.MON_INSP_CHK_AUTO_ID asc) as fileName,GROUP_CONCAT(DISTINCT chk.MON_INSP_FILE_PATH order by chk.MON_INSP_CHK_AUTO_ID asc) as filePath'],$hsChkoptn);
//        if(isset($getEditinspect) && !empty($getEditinspect)){
//            foreach($getEditinspect as $gdKey => $gdVal){
//                $getSubtypedataID = explode(",",$gdVal->subTypdataID);
//                $getSubtypeID = $gdVal->FK_MON_SUB_CAT_ID;
//                $getChktypeID = $gdVal->FK_MON_CHK_LIST_ID;
//                
//                $sdDataoptns['where'] = [
//                    'INSP_SUBTYP_DATA_STATUS' => 'Y',
//                    'INSP_SUBTYP_DATA_SUBTYPID' => $getSubtypeID,
//                    'INSP_SUBTYP_DATA_TYPID' => $getChktypeID,
//                ];
//            $getSubtydataDet = $this->common_model->getAlldata(INSP_CL_SUBTYP_DATA.' as sd',['GROUP_CONCAT(sd.INSP_SUBTYP_DATA_DESC  order by sd.INSP_SUBTYP_DATA_ID asc SEPARATOR "@") AS SUBTYPEDATADESC,GROUP_CONCAT(sd.INSP_SUBTYP_DATA_ID order by sd.INSP_SUBTYP_DATA_ID asc) AS SUBTYPEDATAID'],$sdDataoptns);
//            
////            echo $this->db->last_query();
////            print_R($getSubtydataDet);
//                if(isset($getSubtydataDet) && !empty($getSubtydataDet)){
//                foreach($getSubtydataDet as $sdKey => $sdVal){
//                  $getEditsubData['subTypdataID'][$sdKey] =  $sdVal->SUBTYPEDATAID;
//                  $getEditsubData['subTypdata'][$sdKey] =  $sdVal->SUBTYPEDATADESC;
//
//                }
//               
//                $gdVal->subTypdataID = implode(",",$getEditsubData['subTypdataID']);
//                $gdVal->subTypdata = implode(",",$getEditsubData['subTypdata']);
//                }
//            }
//        }
        
     $monActoptnss['where'] = [
           'mains.MON_INSP_AUTO_ID' => $did
       ];
       $monActoptnss['join'][EMPL.' as empHssee'] = ['empHssee.EMP_AUTO_ID = mains.MON_INSP_REVIEW_ID','left'];
       $monActoptnss['join'][EMPL.' as empRevv'] = ['empRevv.EMP_AUTO_ID = mains.MON_INSP_REVIEW_ID','left'];
       $monActoptnss['join'][EMPL.' as empVerii'] = ['empVerii.EMP_AUTO_ID = mains.MON_INSP_VERIFY_ID','left'];
       $monActoptnss['join'][EMPL.' as empApprr'] = ['empApprr.EMP_AUTO_ID = mains.MON_INSP_APPROVER_ID','left'];
       $activityDets = $this->common_model->getAlldata(MON_INSP_MAIN.' as mains',['mains.*,mains.MON_INSP_ID,empHssee.EMP_NAME as HSSEname,empRevv.EMP_NAME as revName,empVerii.EMP_NAME as verifName,empApprr.EMP_NAME as apprName'],$monActoptnss);
       

       $monActoptns['where'] = [
           'MON_ACT_INSP_ID' => $did
       ];
       $monActoptns['join'][MON_INSP_MAIN.' as main'] = ['main.MON_INSP_AUTO_ID = act.MON_ACT_INSP_ID','left'];
       $monActoptns['join'][EMPL.' as empHsse'] = ['empHsse.EMP_AUTO_ID = act.MON_ACT_INSP_HSSE_ID','left'];
       $monActoptns['join'][EMPL.' as empRev'] = ['empRev.EMP_AUTO_ID = act.MON_ACT_INSP_REVIEWER_ID','left'];
       $monActoptns['join'][EMPL.' as empVeri'] = ['empVeri.EMP_AUTO_ID = act.MON_ACT_INSP_VERIFIER_ID','left'];
       $monActoptns['join'][EMPL.' as empAppr'] = ['empAppr.EMP_AUTO_ID = act.MON_ACT_INSP_APPROVER_ID','left'];
       $activityDet = $this->common_model->getAlldata(MON_ACTIVITY.' as act',['act.*,act.MON_ACT_INSP_HSSE_DATE as HSSEdate,main.MON_INSP_ID,empHsse.EMP_NAME as HSSEname,empRev.EMP_NAME as revName,empVeri.EMP_NAME as verifName,empAppr.EMP_NAME as apprName'],$monActoptns);
       
        
        $data=[
            'InspBasicDet'=>$InspBasicDet,
            'InspectionDet'=>$getEditinspect,
            'activityDet'=>$activityDet,
	    'activityDets' => $activityDets,
        ];
//        echo "<pre>";
//        print_R($data);
//        exit;
        $html2 = $this->load->view('monthly_inspection/inspection_report',$data, true);
//        echo "<pre>";
//        echo $html2;
//        exit;
        $mpdf2 = $this->pdf->ptwload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "inspection";
        $file_path = "assets/uploads/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $file_path . 'Inspection-' . $did . '-' . $currenttime . '.pdf';
//        $name = 'Inspection-' . $currenttime . '.pdf';
        $name = 'Inspection-' . $pdfUniqid . '.pdf';
        $mpdf2->Output($path2, "F");
        $data = file_get_contents($path2);
        force_download($name, $data);
   }
   
   public function updateAtarinspection(){

//       echo "<pre>";
//       print_r($this->input->post());
//       print_r($_FILES);
//       exit;
       
       $atartId = $this->input->post('atarId');
       $isUnsend = $this->input->post('unsend');
       $isSend = $this->input->post('send');
       $newSend = $this->input->post('newsend');
       $checklistId = $this->input->post('checklistId');
       $terminal = $this->input->post('terminal');
       $location = $this->input->post('location');
       $comnt = $this->input->post('comntData');
       $score = $this->input->post('checklistScore');
       $inspId = $this->input->post('inspId');
       $subtypId = $this->input->post('subtypId');
       $userImg = $this->input->post('userImg');
       $subtypeDatadesc = $this->input->post('subtypeDatadesc');
       $speciLocatn = $this->input->post('speciLocatn');
       if($speciLocatn == '-1'){
           $speciLocatnother = $this->input->post('speciLocatnother');
       }else{
           $speciLocatnother = '';
       }
       
      
       if($isUnsend){
           
            $atargetOptns['where'] = [
                'ATAR_AUTO_ID' => $atartId,
            ];
            $atargetOptns['return_type'] = 'row';
           $atarDet =  $this->common_model->getAlldata(ATAR_MAIN,['*'],$atargetOptns);
           $atarStatus = postData($atarDet,'ATAR_APP_STATUS');
           $atarDeletestatus = postData($atarDet,'ATAR_STATUS');
           if($atarStatus > 1 && $atarDeletestatus == 'Y'){
               $data = [
                   'status' => false,
                   'msg' => 'Sorry ! ATAR is in progress,cannot unsend',
               ];
           }else{
              $updateAtar = $this->common_model->updateData(ATAR_MAIN,['ATAR_STATUS' => 'N'],[ 'ATAR_AUTO_ID' => $atartId]);
           
              $updateAtarimg = $this->common_model->updateData(ATAR_IMG,['ATAR_ATTACH_STATUS' => 'N'],['FK_ATAR_MAIN_ID' => $atartId]);
             
              $monChkdatas = [
                  'MON_INSP_ATAR' => 'N',
//                  'MON_INSP_IMG_STATUS' => 'N',
//                  'MON_INSP_SCORE' => 'N',
              ];
              $monChkoptns  = [
                  'MON_INSP_CHK_AUTO_ID' => $checklistId
              ];
              $updateMonchk = $this->common_model->updateData(MON_INSP_CHK,$monChkdatas,$monChkoptns);
              $data = [
                   'status' => true,
                   'msg' => 'Unsend to ATAR successfully',
               ];
                      
           }
       }
       
       /////////////send to atar
       if($isSend){
            $atargetOptns['where'] = [
                'ATAR_AUTO_ID' => $atartId,
            ];
            $atargetOptns['return_type'] = 'row';
           $atarDet =  $this->common_model->getAlldata(ATAR_MAIN,['*'],$atargetOptns);
           $atarStatus = postData($atarDet,'ATAR_APP_STATUS');
           $atarDeletestatus = postData($atarDet,'ATAR_STATUS');
           if($atarStatus > 1 && $atarDeletestatus == 'Y'){
               $data = [
                   'status' => false,
                   'msg' => 'Sorry ! ATAR is in progress,cannot send',
               ];
           }else{
               
               $insAtardatas = [
                   'ATAR_REPORTER_TYPE_ID' => getParticsessdata('USER_TYPE_ID'),
                   'ATAR_REPORTER_ID' => getParticsessdata('USER_REF_ID'),
                   'ATAR_REPORTER_DESG_ID' => getParticsessdata('USER_DESINATION_ID'),
                   'ATAR_LOC_ID' => $terminal,
//                   'ATAR_SPEC_LOC_ID' => $location,
                   'ATAR_SPEC_LOC_ID' => $speciLocatn,
                   'ATAR_SPEC_LOC_OTHER' => $speciLocatnother,
                   'ATAR_REPORT_DATETIME' => date('Y-m-d H:i:s'),
                   'ATAR_USEE_WHAT_RECCOM' => $comnt,
                   'ATAR_STATUS' => 'Y',
                   'ATAR_APP_STATUS' => 1,
               ];
               
               $module = 'INS';
               $locName = getLocationShorName($terminal);
               $atarID = getAtarNumber($module,$locName,$terminal);
//               $atarID = 'ATAR-0001';
               
               $insAtardatas['ATAR_ID'] = $atarID;
               
              $updateAtar = $this->common_model->updateData(ATAR_MAIN,$insAtardatas,[ 'ATAR_AUTO_ID' => $atartId]);
              
              $monChkdatas = [
                  'MON_INSP_ATAR' => 'Y',
                  'MON_INSP_SCORE' => $score,
                  'MON_INSP_REMARK' => $comnt,
              ];
              $monChkoptns  = [
                  'MON_INSP_CHK_AUTO_ID' => $checklistId
              ];
              $updateMonchk = $this->common_model->updateData(MON_INSP_CHK,$monChkdatas,$monChkoptns);
              $data = [
                   'status' => true,
                   'msg' => 'Send to ATAR successfully',
               ];
                      
           }
       }
       
       /////////////////send new to atar
       
       if($newSend){
           $module = 'INS';
          $locName = getLocationShorName($terminal);
          $atarID = getAtarNumber($module,$locName,$terminal);
//           $atarID = 'ATAR-001';
            $insAtardatas = [
                   'ATAR_ID' => $atarID,
                   'ATAR_TYPE_ID' => 3,
                   'ATAR_REPORTER_TYPE_ID' => getParticsessdata('USER_TYPE_ID'),
                   'ATAR_REPORTER_ID' => getParticsessdata('USER_REF_ID'),
                   'ATAR_REPORTER_DESG_ID' => getParticsessdata('USER_DESINATION_ID'),
                   'ATAR_LOC_ID' => $terminal,
//                   'ATAR_SPEC_LOC_ID' => $location,
                   'ATAR_SPEC_LOC_ID' => $speciLocatn,
                   'ATAR_SPEC_LOC_OTHER' => $speciLocatnother,
                   'ATAR_REPORT_DATETIME' => date('Y-m-d H:i:s'),
                   'ATAR_USEE_WHAT_RECCOM' => $comnt,
                   'ATAR_INC_DESC_FINDING' => $subtypeDatadesc,
                   'ATAR_INSP_INC_ID' => $inspId,
                   'ATAR_INSP_SUBCAT_ID' => $subtypId,
                   'ATAR_STATUS' => 'Y',
                 'ATAR_APP_STATUS' => 1,
               ];
              $insertAtar = $this->common_model->updateData(ATAR_MAIN,$insAtardatas);
              
              $atarImgData = [
                  'FK_ATAR_MAIN_ID' => $insertAtar,
                  'ATAR_FILE_TYPE' => 1,
              ];
                  //////////////atar and check image  start
              if($userImg != ""){
                 $expUserimgpath = explode("/",strrev($userImg),2);
                 $expUserimg = explode("/",$userImg);
                  
                
                  $atarImgData['ATAR_FILENAME'] = end($expUserimg);
                  $atarImgData['ATAR_FILE_PATH'] = strrev($expUserimgpath[1]).'/';
                 $imgDatas[$imgKey] =  []; 
              }else{
                  $imgDatas = uploadMultipleimage($_FILES, 'assets/images/modules/inspection/monthly/','beforeImages');
              }
              
      
               $imgKey = 0;
        if(!empty($imgDatas[$imgKey])){
                               $imgUplname =  $imgDatas[$imgKey]['uploadname'];
                               $imgUplpath =  $imgDatas[$imgKey]['uploadpath'];
                               $imgUplext =  $imgDatas[$imgKey]['uploadextension'];
                               $imgUplsize =  $imgDatas[$imgKey]['filesize'];
                              
                               
                               $atarImgData['ATAR_FILENAME'] = $imgUplname;
                               $atarImgData['ATAR_FILE_EXT'] = $imgUplext;
                               $atarImgData['ATAR_FILE_SIZE'] = $imgUplsize;
                               $atarImgData['ATAR_FILE_PATH'] = $imgUplpath;
        }
            ///////////////////////////////atar and check image  start
        $insertAtarimage = $this->common_model->updateData(ATAR_IMG,$atarImgData);
              
              $monChkdatas = [
                  'MON_INSP_ATAR' => 'Y',
                  'MON_INSP_SCORE' => $score,
                  'MON_INSP_REMARK' => $comnt,
              ];
              $monChkoptns  = [
                  'MON_INSP_CHK_AUTO_ID' => $checklistId
              ];
              if(!empty($imgDatas[$imgKey])){
                  $monChkdatas['MON_INSP_FILENAME'] = $imgUplname;
                  $monChkdatas['MON_INSP_FILE_EXT'] = $imgUplext;
                  $monChkdatas['MON_INSP_FILE_PATH'] = $imgUplpath;
                  $monChkdatas['MON_INSP_FILE_SIZE'] = $imgUplsize;
              }
              $updateMonchk = $this->common_model->updateData(MON_INSP_CHK,$monChkdatas,$monChkoptns);
              $data = [
                   'status' => true,
                   'msg' => 'Send to ATAR successfully',
                   'atarID' => $insertAtar,
               ];
              
       }
       
       echo json_encode($data);
   }
   
   public function monthlyInspactivity($id=""){
       
       $did = decryptval($id);
       $monActoptns['where'] = [
           'MON_ACT_INSP_ID' => $did
       ];
       $monActoptns['join'][MON_INSP_MAIN.' as main'] = ['main.MON_INSP_AUTO_ID = act.MON_ACT_INSP_ID','left'];
       $monActoptns['join'][EMPL.' as empHsse'] = ['empHsse.EMP_AUTO_ID = act.MON_ACT_INSP_HSSE_ID','left'];
       $monActoptns['join'][EMPL.' as empRev'] = ['empRev.EMP_AUTO_ID = act.MON_ACT_INSP_REVIEWER_ID','left'];
       $monActoptns['join'][EMPL.' as empVeri'] = ['empVeri.EMP_AUTO_ID = act.MON_ACT_INSP_VERIFIER_ID','left'];
       $monActoptns['join'][EMPL.' as empAppr'] = ['empAppr.EMP_AUTO_ID = act.MON_ACT_INSP_APPROVER_ID','left'];
       $activityDet = $this->common_model->getAlldata(MON_ACTIVITY.' as act',['act.*,act.MON_ACT_INSP_HSSE_DATE as HSSEdate,main.MON_INSP_ID,empHsse.EMP_NAME as HSSEname,empRev.EMP_NAME as revName,empVeri.EMP_NAME as verifName,empAppr.EMP_NAME as apprName'],$monActoptns);
       
//       echo "<pre>";
//       echo $this->db->last_query();
//       print_R($activityDet);
//       exit;
       $data = array(
            'view_file' => 'inspection/monthly_inspection/inspection_activity',
            'current_menu' => 'Add Monthly Inspection',
            'activityDet' => $activityDet,
            
        );
        $this->template->load_common_template($data);
   }
  
   ///////////// monthly inspection end
}
