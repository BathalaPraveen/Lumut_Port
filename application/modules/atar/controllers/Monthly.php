<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isLogin();
        $this->load->model('atar/atar_model', 'atar');
        $this->load->helper('atar_helper');
    }

    public function monthlyInfo() {
          $requestData = $this->input->get();
        $month = $requestData['month'];
        $year = $requestData['year'];
        $terminal = $requestData['terminal'];


         $dropTermname = $dropSpec = $dropUsee = $dropUact = $getUseeActdatas = $getAlluseeimage = $getAlluactimage = [];

        $getAllterminal = $this->atar->getLocation();
        $dropTermname = customFormDropDown($getAllterminal, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');

        $getAllusee = $this->atar->getUseeCategory();
        $dropUsee = customFormDropDown($getAllusee, 'ATAR_CAT_AUTO_ID', 'ATAR_CAT_NAME_EN', 'Select U-See Type');

        $getAlluact = $this->atar->getActCategory();
        $dropUact = customFormDropDown($getAlluact, 'ATAR_CAT_AUTO_ID', 'ATAR_CAT_NAME_EN', 'Select U-Act Type');


        $options['where']=[  
        'EMP.EMP_LOGIN_STATUS'=>'E',
        'EMP.EMP_STATUS'=>'Y',
         ];
        $options['return_type'] = 'result';
        
        $actvity = $this->common_model->getAlldata('EMPLOYEE_MANAGEMENT AS EMP', ['EMP.EMP_AUTO_ID','EMP.EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
    
        $dropdownempDetails = customFormDropDown($actvity,'EMP_AUTO_ID','EMP_NAME','Select Reporter Name');


        $options['where']=[  
            'CONT.CON_LOGIN_STATUS'=>'E',
            'CONT.CONT_STATUS'=>'Y',
            'LD.USER_LOGIN_TYP'=>'1',
         ];
        $options['return_type'] = 'result';
        $options['join'] = [
            'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = CONT.CONT_AUTO_ID','INNER']
        ];
        $actvity = $this->common_model->getAlldata('CONTRACTOR_DETAILS AS CONT', ['LD.LOGIN_ID','CONT.CONT_AUTO_ID','CONT.CONT_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
    
        // $dropcntrdownDetails = customFormDropDown($actvity,'CONT_ID','CONT_NAME','Select Reporter Name');
        $dropcntrdownDetails = customFormDropDown($actvity, 'LOGIN_ID', 'CONT_NAME', 'Select Reporter Name');


    //     echo $this->db->last_query();
    //    print_r( $dropcntrdownDetails);
    //     exit;

         $options['where']=[  
        'EMP.EMP_LOGIN_STATUS'=>'E',
        'EMP.EMP_STATUS'=>'Y',
         ];
        $options['return_type'] = 'result';
        $options['join'] = [
            'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = EMP.EMP_AUTO_ID','INNER']
        ];
        $actvity = $this->common_model->getAlldata('EMPLOYEE_MANAGEMENT AS EMP', ['LD.LOGIN_ID','EMP.EMP_AUTO_ID','EMP.EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
    
        $assigneddropdownDetails = customFormDropDown($actvity,'LOGIN_ID','EMP_NAME','Select Assigned Person');



        $data = [
            'getLocInfo' => $dropTermname,
            'getempEmployeeList' => $dropdownempDetails,
             'getcntrEmployeeList' => $dropcntrdownDetails,
            'getEmployeeAssignedList' => $assigneddropdownDetails,
            'pageTitle' => 'ATAR [ Monthly Inspection ]',
            'view_file' => 'atar/monthly/list_form',
            'site_title' => 'ATAR [ Monthly Inspection ]',
            'current_menu' => 'ATAR [ Monthly Inspection ] List',
            'ajaxurl' => 'atar/monthly/listMonthly',
        ];

        $this->template->load_table_template($data);
    }

    public function listMonthly() {
          global $atarPermission;
        $user_type = getCurrentUserGroupId();
        $userid = getCurrentUserid();

        $table = ATAR_FLOW;
        $column_order = array(null, 'ATAR_ID', 'FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'ATAR_REPORT_DATETIME', 'FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name', null);
        $column_search = array('ATAR_ID', 'FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'ATAR_REPORT_DATETIME', 'FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name');
        $order = array(ATAR_FLOW. '.CREATED_ON' => 'desc');
         if (in_array($user_type, $atarPermission['add']) || is_admin()) {
            if (in_array($user_type, $atarPermission['view']) || is_admin()) {
                    $where = [
                        'ATAR_STATUS' => 'Y',
                        'ATAR_TYPE_ID' => 3
                    ];
            }elseif(in_array($user_type, $atarPermission['fix'])){
                 $options['orwhere'] = [
                        'ATAR_ASSIGN_HOD_ID' => $userid,
                          'ATAR_TYPE_ID' => 3,
                         'ATAR_REPORTER_ID' => $userid
                    ];
                 $options['where'] = [
                        'ATAR_STATUS' => 'Y',
                        'ATAR_TYPE_ID' => 3
                    ];
            }elseif(in_array($user_type, $atarPermission['unit'])){
                 $options['orwhere'] = [
                        'ATAR_ASSIGN_UNIT_ID' => $userid,
                          'ATAR_TYPE_ID' => 3,
                         'ATAR_REPORTER_ID' => $userid
                    ];
                $options['where'] = [
                        'ATAR_STATUS' => 'Y',
                        'ATAR_TYPE_ID' => 3
                    ];
            }elseif(in_array($user_type, $atarPermission['approve'])){
                 $where = [
                        'ATAR_STATUS' => 'Y',
                        'ATAR_TYPE_ID' => 3
                        
                    ];
            }else{
                $where = [
                    'ATAR_STATUS' => 'Y',
                    'ATAR_TYPE_ID' => 3,
                    'ATAR_REPORTER_ID' => $userid
                ];
            }
        }
             $mappedData = [];
        $request = $this->input->post();
        // $where = [];
        $searchextra = postData($request, 'searchextra');

        // echo "<pre>";
        // print_r($searchextra);
        // exit;

        if ($searchextra != FALSE && count($searchextra) > 0) {
            foreach ($searchextra as $search) {
                $sName = postData($search, 'name');
                $sValue = postData($search, 'value');
                $mappedData[$sName] = $sValue;
            }
        }


        if ($mappedData != FALSE && count($mappedData) > 0) {
            // print_r($mappedData);
            // exit;
           
            $ATAR_LOC_ID = postData($mappedData, 'ATAR_LOC_ID');
            $ATAR_SPEC_LOC_ID = postData($mappedData, 'ATAR_SPEC_LOC_ID');



            $ATAR_REPORTER_EMP_ID = postData($mappedData, 'reporter_emp_name');
            $ATAR_REPORTER_CONT_ID = postData($mappedData, 'reporter_cntr_name');

            $assigned_person_name = postData($mappedData, 'assigned_person_name');

            //  $options['where'] = [];
            if ($ATAR_LOC_ID) {
                $options['where'] = [
                    'ATAR_LOC_ID' => $ATAR_LOC_ID
                ];
                 $options['where']['ATAR_TYPE_ID'] = 3;

            }
            if ($ATAR_SPEC_LOC_ID>0) {
                $options['where']['ATAR_SPEC_LOC_ID'] = $ATAR_SPEC_LOC_ID;
                 $options['where']['ATAR_TYPE_ID'] = 3;
            }

            if ($ATAR_REPORTER_EMP_ID) {
                $options['where']["ATAR_REPORTER_ID"] = $ATAR_REPORTER_EMP_ID;
                 $options['where']['ATAR_TYPE_ID'] = 3;

            }
              if ($ATAR_REPORTER_CONT_ID) {
                $options['where']["ATAR_REPORTER_ID"] = $ATAR_REPORTER_CONT_ID;
                 $options['where']['ATAR_TYPE_ID'] = 3;

            }
            if ($assigned_person_name > 0) {
                $options['where']["ATAR_ASSIGN_HOD_ID"] = $assigned_person_name;
                 $options['where']['ATAR_TYPE_ID'] = 3;

            }
//  echo "<pre>"; print_r($options);exit;
        }

          $options['join'] = [
 		// 'LOGIN_DETAILS AS LD'=>['LD.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
        // 'EMPLOYEE_MANAGEMENT AS Reporter'=>['Reporter.EMP_AUTO_ID = LD.USER_REF_ID','LEFT'],
'EMPLOYEE_MANAGEMENT AS Reporter'=>['Reporter.EMP_AUTO_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],

        'LOGIN_DETAILS AS LD3'=>['LD3.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
        'CONTRACTOR_DETAILS AS Contractor'=>['Contractor.CONT_AUTO_ID = LD3.USER_REF_ID','LEFT']];
        
        $options['select'] = ['ATAR_AUTO_ID','ATAR_ID', 'FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'ATAR_REPORT_DATETIME', 'FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN `Contractor`.`CONT_NAME` ELSE  `Reporter`.`EMP_NAME` END) as Reporter'];
        $listUsee = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $options);
        //    echo $this->db->last_query();exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listUsee) && !empty($listUsee)) {
            foreach ($listUsee as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->ATAR_AUTO_ID);

                
               // $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteMonthly', 'title' => 'Delete', 'delt-id' => $id));
                $action .= " " . anchor('atar/monthly/view/' . $id, '<i class="fa fa-eye"></i>', array('title' => 'view'));
              
                $action .= " " . anchor('atar/monthly/pdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF','target'=>'_blank'));

//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

                $rows = [];
                $rows[] = $ltVal->ATAR_ID;
                $rows[] = ucfirst($ltVal->loc_name);
                $rows[] = date('d-m-Y H:i:s', strtotime($ltVal->ATAR_REPORT_DATETIME));
                $rows[] = $ltVal->Reporter;
                $rows[] = $ltVal->status_Name;

                $rows[] = $action;
                $finalDatas[] = $rows;
            }
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->common_model->count_all($table, $column_order, $column_search, $order, $where,$options),
            "recordsFiltered" => $this->common_model->count_filtered($table, $column_order, $column_search, $order, $where,$options),
            "data" => $finalDatas,
        );
        //output to json format
        echo json_encode($output);
    }

    public function pdf($id = '') {

        $editData = $getumonthly = $getumonthlyafter =  FALSE;
        if ($id != '') {

            $decryptUseeId = decryptval($id);
            //  print_r($decryptUseeId);exit;
            $editData = $this->atar->getUseeMonthlyDetails(['ATAR_AUTO_ID' => $decryptUseeId], 'row');
            
            $getumonthly = $this->atar->getUseeImageBefore($decryptUseeId);
            $getumonthlyafter = $this->atar->getUseeactImageAfter($decryptUseeId);
        }

        //echo $this->db->last_query();exit;
        //  print_r($editData);


        $data = [
            'editData' => $editData,
            'getumonthlyimage' => $getumonthly,
            'getumonthlyafterimage' => $getumonthlyafter
        ];

        //  echo "<pre>";
        //print_r($data);exit;

        $atarNumber = postData($editData, 'ATAR_ID');
        $html2 = $this->load->view('atar/monthly/monthly_pdf', $data, true);
        //  echo $html2;
//        exit;
        $mpdf2 = $this->pdf->load();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "monthly";
        $file_path = "assets/images/modules/atar/pdf/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $atarNumber . '.pdf';
        $name = $atarNumber . '.pdf';
        $mpdf2->Output($path2, "I");
//        $data = file_get_contents($path2);
//        force_download($name, $data);
    }

    public function view($id = '') {

        $editData = $getumonthly = $getuaftermonthly  = $getAllMainCat = FALSE;
        if ($id != '') {

            $decryptUseeId = decryptval($id);
            $editData = $this->atar->getUseeMonthlyDetails(['ATAR_AUTO_ID' => $decryptUseeId], 'row');
       //  echo $this->db->last_query();exit;
            
            $getumonthly = $this->atar->getUseeImageBefore($decryptUseeId);
        $getuaftermonthly = $this->atar->getUseeactImageAfter($decryptUseeId);
        
         $getAllMainCat = $this->atar->getMainCategory();
        //    print_r($getAllMainCat);exit;
            $dropMainCat = customFormDropDown($getAllMainCat, 'ATAR_CAT_AUTO_ID', 'ATAR_CAT_NAME_EN', 'Select Category');
          
        }

       

          

        //  print_r($editData);


        $data = [
            'view_file' => 'atar/monthly/view_report',
            'current_menu' => 'View ATAR [ Monthly Inspection ]',
            'editData' => $editData,
            'getumonthlyimage' => $getumonthly,
            'getuafterimage' => $getuaftermonthly,
            'getmainCat' => $dropMainCat
        ];

        //  echo "<pre>";
        //print_r($data);exit;

        $this->template->load_common_template($data);
    }
     public function saveStatus($id = '') {
        
        $did = $id;
        //echo "dsgdsgsgsgs";exit;
 
        $statusDatas = $this->input->post('usee');
         $useeCatDatass = $this->input->post('useeCat');
        $useeCatDatas = postData($useeCatDatass, 'ATAR_MAIN_CAT_ID');
        
        $ATAR_HSSE_TYPE_ID = getCurrentUserGroupId();
        $ATAR_HSSE_ID = getCurrentUserid();
        $hodDatasId = postData($statusDatas, 'ATAR_ASSIGN_HOD_ID');
        $unitDatasId = postData($statusDatas, 'ATAR_ASSIGN_UNIT_ID');
        
        $optWhr['where'] = [
            'LOGIN_ID' => $hodDatasId
        ];
        $optWhr['return_type'] = 'row';
        $gethoddatas = $this->common_model->getAlldata(USER_LOG, ['*'], $optWhr);
        $hodDatasGroupId = $gethoddatas->USER_TYPE_ID;
        
       
       
        $this->form_validation->set_rules('usee[ATAR_APP_STATUSS]', 'Status', 'required|trim');
     
        if ($this->form_validation->run()) {
            $useedatas = [
                'ATAR_HSSE_TYPE_ID' => $ATAR_HSSE_TYPE_ID,
                'ATAR_HSSE_ID' => $ATAR_HSSE_ID,
                'ATAR_HSSE_DATE' => date('Y-m-d', strtotime(postData($statusDatas, 'ATAR_HSSE_DATE'))),
                'ATAR_APP_STATUS' => postData($statusDatas, 'ATAR_APP_STATUSS'),
                'ATAR_ASSIGN_HOD_TYPE_ID' => $hodDatasGroupId,
                'ATAR_ASSIGN_HOD_ID' => $hodDatasId,
                'ATAR_ASSIGN_UNIT_ID' => $unitDatasId,
                'ATAR_MAIN_CAT_ID' => $useeCatDatas,
                
            ];
//            echo "<pre>";exit;
//          print_r();exit;
            if ($did != '') {
                $upWhere = [
                    'ATAR_AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(ATAR_FLOW, $useedatas, $upWhere);
//            echo $this->db->last_query();exit;
            } else {
                $updtProfile = $this->common_model->updateData(ATAR_FLOW, $useedatas);
//                echo $this->db->last_query();exit;
            }
//print_r($updtProfile);exit;
            if ($updtProfile) {
                   $optWhr['where'] = [
                        'ATAR_AUTO_ID' => $did
                    ];
                    $optWhr['return_type'] = 'row';
                    $getStatdatas = $this->common_model->getAlldata(ATAR_FLOW, ['*'], $optWhr);
                    $StatId = $getStatdatas->ATAR_APP_STATUS;
                    if($StatId == 4){
                        sendAtarNotification($did);
                    }
                
                if ($did != '') {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HSSE Monthly Inspection has been Updated</div>');
                } else {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HSSE Monthly Inspection has been Created</div>');
                }
                redirect('atar/monthly/monthlyInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HSSE Monthly Inspection cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HSSE Monthly Inspection cannot be Created</div>');
                }
                redirect('atar/monthly/monthlyInfo');
            }
        } else {
            $this->monthlyInfo($id);
        }
    }
    public function saveCADetails($id = '') {
        
        $did = $id;

        $afterFixDatas = $this->input->post('useeafterfix');
       
//      
      
        $this->form_validation->set_rules('useeafterfix[ATAR_ASSIGN_HOD_DESC]', 'Description', 'required|trim');
     
        if ($this->form_validation->run()) {
          //     print_r($afterFixDatas);exit;
            $useeCA = [
                'ATAR_ASSIGN_HOD_DATE' => date('Y-m-d'),
                'ATAR_APP_STATUS' => 5,
                'ATAR_ASSIGN_HOD_DESC' => postData($afterFixDatas, 'ATAR_ASSIGN_HOD_DESC')
            ];
          //    print_r($useeCA);
//        print_r($_FILES);
//        
   //   exit;
            if(isset($_FILES) && !empty($_FILES)){
              $imgUActDatasImage = uploadMultipleimage($_FILES, 'assets/images/modules/atar/images/monthly/after/','useeafterfix');
            }
      
            if ($imgUActDatasImage != FALSE && count($imgUActDatasImage) > 0) {
                foreach ($imgUActDatasImage as $fileAct) {
                    $updateUploadActData = [
                        'FK_ATAR_MAIN_ID' => $did,
                        'ATAR_FILE_TYPE' => 3,
                        'ATAR_FILENAME' => postData($fileAct, 'uploadname'),
                        'ATAR_FILETYPE' => postData($fileAct, 'uploadtype'),
                        'ATAR_FILE_EXT' => postData($fileAct, 'uploadextension'),
                        'ATAR_FILE_SIZE' => postData($fileAct, 'filesize'),
                        'ATAR_FILE_PATH' => postData($fileAct, 'uploadpath')
                    ];
                 
                    $this->common_model->updateData(ATAR_IMG, $updateUploadActData);
                }
            }

//            echo "<pre>";exit;
//          print_r();exit;
            if ($did != '') {
                $upWhere = [
                    'ATAR_AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(ATAR_FLOW, $useeCA, $upWhere);
//            echo $this->db->last_query();exit;
            } else {
                $updtProfile = $this->common_model->updateData(ATAR_FLOW, $useeCA);
//                echo $this->db->last_query();exit;
            }
            
//print_r($updtProfile);exit;
            if ($updtProfile) {
               sendAtarNotification($did);
                if ($did != '') {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HSSE Monthly Inspection has been Updated</div>');
                } else {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HSSE Monthly Inspection has been Created</div>');
                }
                redirect('atar/monthly/monthlyInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HSSE Monthly Inspection cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HSSE Monthly Inspection cannot be Created</div>');
                }
               redirect('atar/monthly/monthlyInfo');
            }
        } else {
            $this->monthlyInfo($id);
        }
    }
    public function saveApproveDetails($id = '') {
        
        $did = $id;

        $afterFixapproveDatas = $this->input->post('useeapprove');
        $approve = postData($afterFixapproveDatas, 'approve');
        $reject = postData($afterFixapproveDatas, 'reject');
        
//        print_r($afterFixapproveDatas);
//        
//        exit;
//       
        $this->form_validation->set_rules('useeapprove[ATAR_ASSIGN_HSSE_DESC]', 'Reason', 'required|trim');
     
        if ($this->form_validation->run()) {
          //     print_r($afterFixDatas);exit;
            if($approve == "Approve"){
                $useeApprove = [
                    'ATAR_APP_STATUS' => 3,
                    'ATAR_ASSIGN_HSSE_DESC' => postData($afterFixapproveDatas, 'ATAR_ASSIGN_HSSE_DESC')
                ];
            }elseif ($reject == "Reject") {
                $useeApprove = [
                    'ATAR_APP_STATUS' => 7,
                    'ATAR_REJECT_HSSE_DESC' => postData($afterFixapproveDatas, 'ATAR_ASSIGN_HSSE_DESC')
                ];
            }
            
          //  print_r($useeApprove);exit;
            if ($did != '') {
                $upWhere = [
                    'ATAR_AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(ATAR_FLOW, $useeApprove, $upWhere);
//            echo $this->db->last_query();exit;
            } else {
                $updtProfile = $this->common_model->updateData(ATAR_FLOW, $useeApprove);
//                echo $this->db->last_query();exit;
            }
            
//print_r($updtProfile);exit;
            if ($updtProfile) {
                sendAtarNotification($did);
                if ($did != '') {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HSSE Monthly Inspection has been Updated</div>');
                } else {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HSSE Monthly Inspection has been Created</div>');
                }
                redirect('atar/monthly/monthlyInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HSSE Monthly Inspection cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HSSE Monthly Inspection cannot be Created</div>');
                }
                redirect('atar/monthly/monthlyInfo');
            }
        } else {
            $this->monthlyInfo($id);
        }
    }
    public function saveCatDetails($id = '') {
        $did = $id;
        $useeCatDatas = $this->input->post('useeCat');
      
//        print_r($useeCatDatas);       
//        exit;
//       
        $this->form_validation->set_rules('useeCat[ATAR_MAIN_CAT_ID]', 'Category', 'required|trim');
     
        if ($this->form_validation->run()) {
            $useeCatRes = [
                'ATAR_MAIN_CAT_ID' => postData($useeCatDatas, 'ATAR_MAIN_CAT_ID')
            ];

          //  print_r($useeApprove);exit;
            if ($did != '') {
                $upWhere = [
                    'ATAR_AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(ATAR_FLOW, $useeCatRes, $upWhere);
//            echo $this->db->last_query();exit;
            } else {
                $updtProfile = $this->common_model->updateData(ATAR_FLOW, $useeCatRes);
//                echo $this->db->last_query();exit;
            }
            
//print_r($updtProfile);exit;
            if ($updtProfile) {
                sendAtarNotification($did);
                if ($did != '') {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HSSE Monthly Inspection has been Updated</div>');
                } else {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> HSSE Monthly Inspection has been Created</div>');
                }
                redirect('atar/monthly/monthlyInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HSSE Monthly Inspection cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('monthlyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> HSSE Monthly Inspection cannot be Created</div>');
                }
                redirect('atar/monthly/monthlyInfo');
            }
        } else {
            $this->monthlyInfo($id);
        }
    }



}

