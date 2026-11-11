<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hmp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isLogin();
        $this->load->model('hmp/hmp_model', 'hmp');
        $this->load->helper('hmp_helper');
       
        
       
        
    }
    
    public function hmpInfo() {
        $frmDate = $this->input->post('start_date');
        $toDat = $this->input->post('end_date');

      
        
        $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');
        $status= $this->input->get('status');
        
        $data =[
            'pageTitle' => 'HSSE Master Plan',
            'view_file' => 'hmp/form/list_form',
            'site_title' => 'HSSE Master Plan',
            'current_menu' => 'HSSE Master Plan List',
            // 'ajaxurl' => 'hmp/hmp/listHmp?frmDate='.$frmDate.'&toDat='.$toDat,
            'ajaxurl' => 'hmp/hmp/listHmp?frmDate='.$frmDate.'&toDat='.$toDat.'&terminal='.$terminal.'&year='.$year.'&status='.$status,

        ];

        $this->template->load_table_template($data);
    }
    public function listHmp() {
        $frmDate = $this->input->get('frmDate');
        $toDat = $this->input->get('toDat');
        
        $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');
        $status= $this->input->get('status');
        
        global $hmpAccessList;
        global $hmpPermission;
        $table = HMP_MAIN;

        $userid = getCurrentUserid();
        $user_type = getCurrentUserGroupId();
        
        $column_order = array(null, 'HMP_ID','HMP_NAME','HMP_APP_START_DATE','HMP_APP_END_DATE','FN_GET_LOCATION(HMP_LOC_ID) as loc_name', 'FN_GET_DEPARTMENT_NAME(HMP_DEPT_ID) as dept_name','FN_PTW_STATUS_NAME(HMP_APP_STATUS) as status_Name', null);
        $column_search = array('HMP_ID','HMP_NAME','HMP_APP_START_DATE' ,'HMP_APP_END_DATE','FN_GET_LOCATION(HMP_LOC_ID) as loc_name', 'FN_GET_DEPARTMENT_NAME(HMP_DEPT_ID) as dept_name','FN_PTW_STATUS_NAME(HMP_APP_STATUS) as status_Name');
        $order = array('CREATED_ON' => 'desc');
        
      //  print_r($user_type);
        if (in_array($user_type, $hmpAccessList['add']) || is_admin()) {
            if($user_type == 5){
                 $where = [
                    'HMP_STATUS' => 'Y',
                    'HMP_UNIT_HEAD_ID' => $userid
                ];
            }else if($user_type == 4){
                $where = [
                    'HMP_STATUS' => 'Y',
                    'HMP_EXEC_ID' => $userid
                ];
            }else{
                $where = [
                    'HMP_STATUS' => 'Y'
                ];
            }
           
        }
        
        if($frmDate != ''){
            $where['HMP_APP_START_DATE >='] = converttoDBDate($frmDate);
        }
        if($toDat != ''){
             $where['HMP_APP_END_DATE <='] = converttoDBDate($toDat);
        }
         if($year != ''){
            $where['YEAR(CREATED_ON) ='] = $year;
        }
        if($terminal != ''){
             $where['HMP_LOC_ID ='] = $terminal;
        }
           if($status != ''){
             $where['HMP_APP_STATUS ='] = $status;
        }
        
        $options['select'] = ['HMP_ID','HMP_NAME','HMP_AUTO_ID','HMP_APP_START_DATE' ,'HMP_APP_END_DATE','HMP_APP_STATUS','FN_GET_LOCATION(HMP_LOC_ID) as loc_name', 'FN_GET_DEPARTMENT_NAME(HMP_DEPT_ID) as dept_name','FN_HMP_STATUS(HMP_APP_STATUS) as status_Name']; 
        $listHmp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $options);
    // echo $this->db->last_query();exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listHmp) && !empty($listHmp)) {
            foreach ($listHmp as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->HMP_AUTO_ID);
                
               
                $user_type = getCurrentUserGroupId();
                 if (((in_array($user_type, $hmpPermission['add'])) && $ltVal->HMP_APP_STATUS == '1' ) || (is_admin()  && $ltVal->HMP_APP_STATUS == '1')) {
                $action .= " " . anchor('hmp/hmp/addHmp/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));

                $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteHmp', 'title' => 'Delete', 'delt-id' => $id));
                }
//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";
                $action .= " " . anchor('hmp/hmp/view/' . $id, '<i class="fa fa-eye"></i>', array('title' => 'view'));
                $action .= " " . anchor('hmp/hmp/pdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF','target'=>'_blank'));

                $rows = [];
                $rows[] = $ltVal->HMP_ID;
                 $rows[] = $ltVal->HMP_NAME;
                $rows[] = convertDate($ltVal->HMP_APP_START_DATE);
                $rows[] = convertDate($ltVal->HMP_APP_END_DATE);
                $rows[] = ucfirst($ltVal->loc_name);
                $rows[] = ucfirst($ltVal->dept_name);
                $rows[] = $ltVal->status_Name;
                
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


    public function addHmp($id = '') {
        $did = decryptval($id);
       
        $getuniqueId = getHmpNumber();
        
       
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
       
        
        $getHmpdatas = [];

        if ($id != '') {
            $optWhr['where'] = [
                'HMP_AUTO_ID' => $did,
                'HMP_STATUS' => 'Y'
            ];
            $optWhr['return_type'] = 'row';
            $getHmpdatas = $this->common_model->getAlldata(HMP_MAIN, ['*'], $optWhr);
        }
        
       
        $data = array(
            'view_file' => 'hmp/form/add_form',
            'current_menu' => 'Add Program',
            'getProgramdatas' => $getHmpdatas,
            'getAutoId' => $getuniqueId,
            'locationDetails' => $dropTermname,
            'deptDetails' => $dropDepart,
        );
        $this->template->load_common_template($data);
    }

    public function saveHmp($id = '') {
        $did = decryptval($id);

        $hmpDatas = $this->input->post('pro');
       
        $this->form_validation->set_rules('pro[HMP_ID]', 'Program ID', 'required|trim');
        $this->form_validation->set_rules('pro[HMP_NAME]', 'Program Name', 'required|min_length[2]|max_length[255]|trim');
        $this->form_validation->set_rules('pro[HMP_START_DATE]', 'Program Start Date', 'required|trim');
        $this->form_validation->set_rules('pro[HMP_END_DATE]', 'Program End Date', 'required|trim');
        $this->form_validation->set_rules('pro[HMP_DESC]', 'Program Description', 'required|min_length[2]|trim');
        $this->form_validation->set_rules('pro[HMP_LOC_ID]', 'Terminal', 'required|trim');
        $this->form_validation->set_rules('pro[HMP_DEPT_ID]', 'Department', 'required|trim');
        $this->form_validation->set_rules('pro[HMP_UNIT_HEAD_ID]', 'Unit Head', 'required|trim');
        $this->form_validation->set_rules('pro[HMP_EXEC_ID]', 'Executive', 'required|trim');
        
         
        if ($this->form_validation->run()) {
            $prodatas = [
                
                'HMP_NAME' => postData($hmpDatas, 'HMP_NAME'),
                'HMP_START_DATE' => date('Y-m-d', strtotime(postData($hmpDatas, 'HMP_START_DATE'))),
                'HMP_END_DATE' => date('Y-m-d', strtotime(postData($hmpDatas, 'HMP_END_DATE'))),
                'HMP_DESC' => postData($hmpDatas, 'HMP_DESC'),
                'HMP_LOC_ID' => postData($hmpDatas, 'HMP_LOC_ID'),
                'HMP_DEPT_ID' => postData($hmpDatas, 'HMP_DEPT_ID'),
                'HMP_APP_START_DATE' => date('Y-m-d', strtotime(postData($hmpDatas, 'HMP_START_DATE'))),
                'HMP_APP_END_DATE' => date('Y-m-d', strtotime(postData($hmpDatas, 'HMP_END_DATE'))),
                'HMP_UNIT_HEAD_ID' => postData($hmpDatas, 'HMP_UNIT_HEAD_ID'),
                'HMP_EXEC_ID' => postData($hmpDatas, 'HMP_EXEC_ID'),
                'HMP_APP_STATUS' => 1
            ];
           //print_r($locdatas);exit;
            if ($did != '') {
                $upWhere = [
                    'HMP_AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(HMP_MAIN, $prodatas, $upWhere);
//            echo $this->db->last_query();exit;
            } else {
                $getuniqueId = getHmpNumber();
                $prodatas['HMP_ID'] =$getuniqueId;
                $updtProfile = $this->common_model->updateData(HMP_MAIN, $prodatas);
//                echo $this->db->last_query();exit;
            }
//print_r($updtProfile);exit;
            if ($updtProfile) {
               
                if ($did != '') {
                    $this->session->set_flashdata('hmpflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HSSE Program has been Updated</div>');
                } else {
                     sendHmpNotification($updtProfile);
                    $this->session->set_flashdata('hmpflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HSSE Program has been Created</div>');
                }
                redirect('hmp/hmp/hmpInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('hmpflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HSSE Program cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('hmpflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HSSE Program cannot be Created</div>');
                }
                redirect('hmp/hmp/hmpInfo');
            }
        } else {
            $this->addHmp($id);
        }
    }

    public function deleteHmp() {
        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(HMP_MAIN, ['HMP_STATUS' => 'N'], ['HMP_AUTO_ID' => decryptval($deleteId)]);
        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Program has been deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Program! Try Again later.'
            ];
        }
        echo json_encode($retData);
    }
    
     public function saveStatus($id = '') {
        
        $did = $id;
 
        $hmpDatas = $this->input->post('pro');
       // print_r($hmpDatas);exit;
       
        $this->form_validation->set_rules('pro[HMP_APP_STATUSS]', 'Status', 'required|trim');
     
        if ($this->form_validation->run()) {
            $prodatas = [
                'HMP_APP_STATUS' => postData($hmpDatas, 'HMP_APP_STATUSS'),
                'HMP_APP_START_DATE' => date('Y-m-d', strtotime(postData($hmpDatas, 'HMP_APP_START_DATE'))),
                'HMP_APP_END_DATE' => date('Y-m-d', strtotime(postData($hmpDatas, 'HMP_APP_END_DATE'))),
               
            ];
         
            if ($did != '') {
                $upWhere = [
                    'HMP_AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(HMP_MAIN, $prodatas, $upWhere);
//            echo $this->db->last_query();exit;
            } else {
                $updtProfile = $this->common_model->updateData(HMP_MAIN, $prodatas);
//                echo $this->db->last_query();exit;
            }
//print_r($updtProfile);exit;
            if ($updtProfile) {
                
                if ($did != '') {
                    sendHmpNotification($did);
                    $this->session->set_flashdata('hmpflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HSSE Program Status has been Updated</div>');
                } else {
                    $this->session->set_flashdata('hmpflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HSSE Program Status has been Created</div>');
                }
                redirect('hmp/hmp/hmpInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('hmpflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HSSE Program Status cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('hmpflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HSSE Program Status cannot be Created</div>');
                }
                redirect('hmp/hmp/hmpInfo');
            }
        } else {
            $this->addHmp($id);
        }
    }

    
    
    public function pdf($id ='') {
      
        $editData = FALSE;
        if ($id != '') {
            
            $decryptHmpId = decryptval($id);
            $editData = $this->hmp->getHmpDetails(['HMP_AUTO_ID' => $decryptHmpId], 'row');
        }
       
        $data = [
                'editData' => $editData
            ];
         
         $hmpNumber = postData($editData, 'HMP_ID');
        $html2 = $this->load->view('form/hmp_pdf',$data, true);
    //  echo $html2;
//        exit;
       $mpdf2 = $this->pdf->ptwload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "hmp";
        $file_path = "assets/images/modules/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $hmpNumber. '.pdf';
        $name = $hmpNumber.'.pdf';
        $mpdf2->Output($path2, "I");
//        $data = file_get_contents($path2);
//        force_download($name, $data);
        
    }
   
    public function view($id = '') {
        $editData = FALSE;
        if ($id != '') {
            $decryptHmpId = decryptval($id);
            $editData = $this->hmp->getHmpDetails(['HMP_AUTO_ID' => $decryptHmpId], 'row');
        }

        $data = [
            'view_file' => 'hmp/form/view_report',
            'current_menu' => 'View Program',
            'editData' => $editData
            
        ];

        //  echo "<pre>";
       // print_r($data);exit;

        $this->template->load_common_template($data);
    }

  

}

