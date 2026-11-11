<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isLogin();
        $this->load->model('atar/atar_model', 'atar');
        $this->load->helper('atar_helper');
    }
    
    public function useeInfo() {
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
        'LD.USER_LOGIN_TYP'=>'0',
         ];
        $options['return_type'] = 'result';
        $options['join'] = [
            'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = EMP.EMP_AUTO_ID','INNER']
        ];
        $actvity = $this->common_model->getAlldata('EMPLOYEE_MANAGEMENT AS EMP', ['LD.LOGIN_ID','EMP.EMP_AUTO_ID','EMP.EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
    
        $dropdownempDetails = customFormDropDown($actvity,'LOGIN_ID','EMP_NAME','Select Reporter Name');

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



        $data =[
            'getUseeCatInfo' => $dropUsee,
            'getLocInfo' => $dropTermname,
            'getUactCatInfo' => $dropUact,
            'getempEmployeeList' => $dropdownempDetails,
             'getcntrEmployeeList' => $dropcntrdownDetails,
            'getEmployeeAssignedList' => $assigneddropdownDetails,
            'pageTitle' => 'ATAR [ U-See U-Act ]',
            'view_file' => 'atar/usee/list_form',
            'site_title' => 'ATAR [ U-See U-Act ]',
            'current_menu' => 'ATAR [ U-See U-Act ] List',
            'ajaxurl' => 'atar/usee/listUsee?Month=' . $month . '&Year=' . $year . '&Terminal=' . $terminal

        ];

        $this->template->load_table_template($data);
    }
    public function listUsee() {
        global $atarPermission;
        $user_type = getCurrentUserGroupId();
        $userid = getCurrentUserid();
        //   print_r($user_type);
        //  print_r($userid);exit;
       
        $table = ATAR_FLOW;
        // $column_order = array(null, 'ATAR_ID','ATAR_USEE_WHAT_RECCOM','ATAR_UACT_WHAT','FN_ATAR_USEE_CATEGORY_NAME(ATAR_USEE_CAT_ID) as usee_type','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'ATAR_REPORT_DATETIME','FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN `Contractor`.`CONT_NAME` ELSE  `Reporter`.`EMP_NAME` END)', null);
        // $column_search = array('ATAR_ID','ATAR_USEE_WHAT_RECCOM','ATAR_UACT_WHAT','FN_ATAR_USEE_CATEGORY_NAME(ATAR_USEE_CAT_ID) as usee_type','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'ATAR_REPORT_DATETIME', 'FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN `Contractor`.`CONT_NAME` ELSE  `Reporter`.`EMP_NAME` END)');
         $column_order = array(null, 'ATAR_ID', 'FN_GET_LOCATION(ATAR_LOC_ID)', 'ATAR_REPORT_DATETIME', 'FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name', null);
        $column_search = array('ATAR_ID', 'FN_GET_LOCATION(ATAR_LOC_ID)', 'ATAR_REPORT_DATETIME', 'FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name');

       
        $order = array('`ATAR_MAIN_FLOW`.CREATED_ON' => 'desc');
        
          if (in_array($user_type, $atarPermission['add']) || is_admin()) {
            if (in_array($user_type, $atarPermission['view']) || is_admin()) {
                    $where = [
                        'ATAR_STATUS' => 'Y',
                        'ATAR_TYPE_ID' => 1
                    ];
            }elseif(in_array($user_type, $atarPermission['fix'])){
                 $options['orwhere'] = [
                         'ATAR_ASSIGN_HOD_ID' => $userid,
                         'ATAR_TYPE_ID' => 1,
                         'ATAR_REPORTER_ID' => $userid
                    ];
                $options['where'] = [
                        'ATAR_STATUS' => 'Y',
                        'ATAR_TYPE_ID' => 1
                    ];
            }elseif(in_array($user_type, $atarPermission['unit'])){
                 $options['orwhere'] = [
                        'ATAR_ASSIGN_UNIT_ID' => $userid,
                       //  'ATAR_TYPE_ID' => 1,
                         'ATAR_REPORTER_ID' => $userid
                    ];
               $options['where'] = [
                        'ATAR_STATUS' => 'Y',
                        'ATAR_TYPE_ID' => 1
                    ];
            }elseif(in_array($user_type, $atarPermission['approve'])){
                 $where = [
                        'ATAR_STATUS' => 'Y',
                        'ATAR_TYPE_ID' => 1
                        
                    ];
            }else{
                $where = [
                    'ATAR_STATUS' => 'Y',
                    'ATAR_TYPE_ID' => 1,
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
           
            $ATAR_LOC_ID = postData($mappedData, 'ATAR_LOC_ID');
            $ATAR_SPEC_LOC_ID = postData($mappedData, 'ATAR_SPEC_LOC_ID');
            $ATAR_USEE_CAT_ID = postData($mappedData, 'ATAR_USEE_CAT_ID');
            $ATAR_UACT_CAT_ID = postData($mappedData, 'ATAR_UACT_CAT_ID');


            $ATAR_REPORTER_EMP_ID = postData($mappedData, 'reporter_emp_name');
            $ATAR_REPORTER_CONT_ID = postData($mappedData, 'reporter_cntr_name');

            $assigned_person_name = postData($mappedData, 'assigned_person_name');

            //  $options['where'] = [];
            if ($ATAR_LOC_ID) {
                $options['where'] = [
                    'ATAR_LOC_ID' => $ATAR_LOC_ID
                ];
                 $options['where']['ATAR_TYPE_ID'] = 1;
            }
            if ($ATAR_SPEC_LOC_ID>0) {
                $options['where']['ATAR_SPEC_LOC_ID'] = $ATAR_SPEC_LOC_ID;
               $options['where']['ATAR_TYPE_ID'] = 1;
            }

            if ($ATAR_USEE_CAT_ID) {
                $options['where']["ATAR_USEE_CAT_ID"] = $ATAR_USEE_CAT_ID;
                 $options['where']['ATAR_TYPE_ID'] = 1;
            }

            if ($ATAR_UACT_CAT_ID) {
                $options['where']["ATAR_UACT_CAT_ID"] = $ATAR_UACT_CAT_ID;
                 $options['where']['ATAR_TYPE_ID'] = 1;
            }

             if ($ATAR_REPORTER_EMP_ID) {
                $options['where']["ATAR_REPORTER_ID"] = $ATAR_REPORTER_EMP_ID;
                 $options['where']['ATAR_TYPE_ID'] = 1;
            }
              if ($ATAR_REPORTER_CONT_ID) {
                $options['where']["ATAR_REPORTER_ID"] = $ATAR_REPORTER_CONT_ID;
                 $options['where']['ATAR_TYPE_ID'] = 1;
            }
            if ($assigned_person_name > 0) {
                $options['where']["ATAR_ASSIGN_HOD_ID"] = $assigned_person_name;
                 $options['where']['ATAR_TYPE_ID'] = 1;
            }
        //  echo "<pre>"; print_r($options);exit;
        } 

        

        // $where["DATE_FORMAT(ATAR_REPORT_DATETIME, '%Y-%m')="] = date('Y-m', strtotime($year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT)));
        if (!empty($terminal)) {
            $where['ATAR_LOC_ID='] = $terminal;
        }


        
    $options['join'] = [
 		'LOGIN_DETAILS AS LD'=>['LD.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS Reporter'=>['Reporter.EMP_AUTO_ID = LD.USER_REF_ID','LEFT'],


        'LOGIN_DETAILS AS LD3'=>['LD3.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
        'CONTRACTOR_DETAILS AS Contractor'=>['Contractor.CONT_AUTO_ID = LD3.USER_REF_ID','LEFT']];

        
        $options['select'] = ['ATAR_ID','ATAR_AUTO_ID','ATAR_USEE_WHAT_RECCOM','ATAR_UACT_WHAT','FN_ATAR_USEE_CATEGORY_NAME(ATAR_USEE_CAT_ID) as usee_type','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'ATAR_REPORT_DATETIME','FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN `Contractor`.`CONT_NAME` ELSE  `Reporter`.`EMP_NAME` END) as Reporter']; 

        $listUsee = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $options);
// print_r($user_type);exit;
    //    echo $this->db->last_query();exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listUsee) && !empty($listUsee)) {
            foreach ($listUsee as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->ATAR_AUTO_ID);

              //  $action .= " " . anchor('atar/usee/addUsee/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));

             //   $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteUsee', 'title' => 'Delete', 'delt-id' => $id));
//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";
                $action .= " " . anchor('atar/usee/view/' . $id, '<i class="fa fa-eye"></i>', array('title' => 'view'));
              
                $action .= " " . anchor('atar/usee/pdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF','target'=>'_blank'));

                $rows = [];
                $rows[] = $ltVal->ATAR_ID;
                $rows[] = ucfirst($ltVal->usee_type);
                $rows[] = ucfirst($ltVal->loc_name);
                $rows[] = ucfirst($ltVal->ATAR_USEE_WHAT_RECCOM);
                $rows[] = ucfirst($ltVal->ATAR_UACT_WHAT);

                $rows[] = date('d-m-Y H:i:s', strtotime($ltVal->ATAR_REPORT_DATETIME));
                $rows[] = $ltVal->Reporter;
                $rows[] = $ltVal->status_Name;
                
                $rows[] = $action;
                $finalDatas[] = $rows;
            }
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            // "recordsTotal" => $this->common_model->count_all($table, $column_order, $column_search, $order, $where,$options),
            // "recordsFiltered" => $this->common_model->count_filtered($table, $column_order, $column_search, $order,$where,$options),
              "recordsTotal" => $this->common_model->count_all($table, $column_order, $column_search, $order, $where,$options),
            "recordsFiltered" => $this->common_model->count_filtered($table, $column_order, $column_search, $order, $where,$options),

            "data" => $finalDatas,
        );
        //output to json format
        echo json_encode($output);
    }
    public function addUsee($id = '') {
        $did = decryptval($id);
       //$did =1;
       //  print_r($_FILES[]);
        $sessiondata = getCurrentUserDetails();
        $userid = getCurrentUserid();
        $currentDateTime = date('d-m-Y H:i:s');
        $dropTermname = $dropSpec = $dropUsee = $dropUact = $getUseeActdatas = $getAlluseeimage = $getAlluactimage = [];
        
        $getAllterminal = $this->atar->getLocation();
        $dropTermname = customFormDropDown($getAllterminal, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');
       
        $getAllspec = $this->atar->getSpecificLocation();
        $dropSpec = customFormDropDown($getAllspec, 'SL_AUTO_ID', 'SPECIFIC_LOC_NAME', 'Select Specific Location');
       
        
        $getAllusee = $this->atar->getUseeCategory();
        $dropUsee = customFormDropDown($getAllusee, 'ATAR_CAT_AUTO_ID', 'ATAR_CAT_NAME_EN', 'Select U-See Type');
       
        $getAlluact = $this->atar->getActCategory();
        $dropUact = customFormDropDown($getAlluact, 'ATAR_CAT_AUTO_ID', 'ATAR_CAT_NAME_EN', 'Select U-Act Type');


        if ($did != '') {
            $getUseeActdatas = $this->atar->getUseeDetails(['ATAR_AUTO_ID' => $did], 'row');

            $getAlluseeimage = $this->atar->getUseeImageBefore($did);
            $getAlluactimage = $this->atar->getUactImageBefore($did);
          
        }

        $data = array(
            'view_file' => 'atar/usee/add_form',
            'current_menu' => 'Add ATAR [ U-See U-Act ]',
            'getUserInfo' => $sessiondata,
            'getUserId' => $userid,
            'currentDateTime' => $currentDateTime,
            'getLocInfo' => $dropTermname,
            'getSpecLocInfo' => $dropSpec,
            'getUseeCatInfo' => $dropUsee,
            'getUactCatInfo' => $dropUact,
            'getUseeActdatas' => $getUseeActdatas,
            'getAlluseeimage' => $getAlluseeimage,
            'getAlluactimage' => $getAlluactimage
        );
               
       // echo "<pre>";
     //   print_r($data);exit;
        
        $this->template->load_common_template($data);
    }
    public function saveUsee($id = '') {
        $did = decryptval($id);
    

        $useeDatas = $this->input->post('usee');
        
        $userType = getCurrentUserGroupId();
        $module = 'USUA';

        $locName = getLocationShorName(postData($useeDatas, 'ATAR_LOC_ID'));
         
        $atarId = getAtarNumber($module,$locName,postData($useeDatas, 'ATAR_LOC_ID'));
        
              
       
      // $userid = getCurrentUserid();
        //$sessiondata = getCurrentUserDetails();
        

        $this->form_validation->set_rules('usee[ATAR_LOC_ID]', 'Location', 'required|trim');
        $this->form_validation->set_rules('usee[ATAR_SPEC_LOC_ID]', 'Specific Location', 'required|trim');
        $this->form_validation->set_rules('usee[ATAR_REPORT_DATETIME]', 'DATE and Time', 'required|trim');
        $this->form_validation->set_rules('usee[ATAR_USEE_CAT_ID]', 'U-See Type', 'required|trim');
        $this->form_validation->set_rules('usee[ATAR_USEE_WHAT_RECCOM]', 'What did I see?', 'required|min_length[2]|trim');
        $this->form_validation->set_rules('usee[ATAR_UACT_CAT_ID]', 'U-Act Type', 'required|trim');
        $this->form_validation->set_rules('usee[ATAR_UACT_WHAT]', 'What did I Do?', 'required|min_length[2]|trim');
     
        $date_time = postData($useeDatas, 'ATAR_REPORT_DATETIME');
        if ($this->form_validation->run()) {
            $useeResdatas = [
                'ATAR_TYPE_ID' => 1,
                'ATAR_ID' => $atarId,
                'ATAR_REPORTER_TYPE_ID' => $userType,
                'ATAR_REPORTER_ID' => postData($useeDatas, 'ATAR_REPORTER_ID'),
                'ATAR_REPORTER_DESG_ID' => postData($useeDatas, 'USER_DESINATION_ID'),
                'ATAR_LOC_ID' => postData($useeDatas, 'ATAR_LOC_ID'),
                'ATAR_SPEC_LOC_ID' => postData($useeDatas, 'ATAR_SPEC_LOC_ID'),
                'ATAR_SPEC_LOC_OTHER' => postData($useeDatas, 'ATAR_SPEC_LOC_OTHER'),
                
                'ATAR_REPORT_DATETIME' => date('Y-m-d H:i:s', strtotime($date_time)),
                'ATAR_USEE_CAT_ID' => postData($useeDatas, 'ATAR_USEE_CAT_ID'),
                'ATAR_USEE_WHAT_RECCOM' => postData($useeDatas, 'ATAR_USEE_WHAT_RECCOM'),
                'ATAR_UACT_CAT_ID' => postData($useeDatas, 'ATAR_UACT_CAT_ID'),
                'ATAR_UACT_WHAT' => postData($useeDatas, 'ATAR_UACT_WHAT'),
                'ATAR_APP_STATUS' => 1
            ];
            
            if ($did != '') {
                $upWhere = [
                    'ATAR_AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(ATAR_FLOW, $useeResdatas, $upWhere);
//            echo $this->db->last_query();exit;
            } else {
                $updtProfile = $this->common_model->updateData(ATAR_FLOW, $useeResdatas);
//                echo $this->db->last_query();exit;
            }
            
             // print_r($imgUseeDatasImage);exit;
            $imgUseeDatasImage = [];
            if(isset($_FILES) && !empty($_FILES)){
              $imgUseeDatasImage = uploadMultipleimage($_FILES, 'assets/images/modules/atar/images/usee/before_usee/','useeimage');
            }
         
            if ($imgUseeDatasImage != FALSE && count($imgUseeDatasImage) > 0) {
                foreach ($imgUseeDatasImage as $file) {
                    $updateUploadData = [
                        'FK_ATAR_MAIN_ID' => $updtProfile,
                        'ATAR_FILE_TYPE' => 1,
                        'ATAR_FILENAME' => postData($file, 'uploadname'),
                        'ATAR_FILETYPE' => postData($file, 'uploadtype'),
                        'ATAR_FILE_EXT' => postData($file, 'uploadextension'),
                        'ATAR_FILE_SIZE' => postData($file, 'filesize'),
                        'ATAR_FILE_PATH' => postData($file, 'uploadpath')
                    ];
                 
                    $this->common_model->updateData(ATAR_IMG, $updateUploadData);
                }
            }
            
            $imgUActDatasImage = [];
            
          
            if(isset($_FILES) && !empty($_FILES)){
              $imgUActDatasImage = uploadMultipleimage($_FILES, 'assets/images/modules/atar/images/usee/before_uact/','uactimage');
            }
        
            if ($imgUActDatasImage != FALSE && count($imgUActDatasImage) > 0) {
                foreach ($imgUActDatasImage as $fileAct) {
                    $updateUploadActData = [
                        'FK_ATAR_MAIN_ID' => $updtProfile,
                        'ATAR_FILE_TYPE' => 2,
                        'ATAR_FILENAME' => postData($fileAct, 'uploadname'),
                        'ATAR_FILETYPE' => postData($fileAct, 'uploadtype'),
                        'ATAR_FILE_EXT' => postData($fileAct, 'uploadextension'),
                        'ATAR_FILE_SIZE' => postData($fileAct, 'filesize'),
                        'ATAR_FILE_PATH' => postData($fileAct, 'uploadpath')
                    ];
                 
                    $this->common_model->updateData(ATAR_IMG, $updateUploadActData);
                }
            }

            if ($updtProfile) {
                sendAtarNotification($updtProfile);
                    
                if ($did != '') {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> U-See U-Act has been Updated</div>');
                } else {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> U-See U-Act has been Created</div>');
                }
                redirect('atar/usee/useeInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> U-See U-Act cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> U-See U-Act cannot be Created</div>');
                }
                redirect('atar/usee/useeInfo');
            }
        } else {
            $this->useeInfo($id);
        }
    }
    
    public function pdf($id ='') {
      
        $editData = $getusee = $getuact= $getuafter = FALSE;
        if ($id != '') {
            
            $decryptUseeId = decryptval($id);
            $editData = $this->atar->getUseeDetails(['ATAR_AUTO_ID' => $decryptUseeId], 'row');
        }
     
          //echo $this->db->last_query();exit;
        
        $getusee =  $this->atar->getUseeImageBefore($decryptUseeId);
        $getuact = $this->atar->getUactImageBefore($decryptUseeId);
        $getuafter = $this->atar->getUseeactImageAfter($decryptUseeId);

      //  print_r($editData);
      

        $data = [
                'editData' => $editData,
                'getuseeimage' => $getusee,
                'getuactimage' => $getuact,
                'getuafterimage' => $getuafter
            
            ];
        
       //  echo "<pre>";
       //print_r($data);exit;
         
         $atarNumber = postData($editData, 'ATAR_ID');
        $html2 = $this->load->view('atar/usee/usee_pdf',$data, true);
    // echo $html2;
     // exit;
       $mpdf2 = $this->pdf->ptwload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "usee";
        $file_path = "assets/images/modules/atar/pdf/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $atarNumber. '.pdf';
        $name = $atarNumber.'.pdf';
        $mpdf2->Output($path2, "I");
//        $data = file_get_contents($path2);
//        force_download($name, $data);
        
    }

 
     public function view($id ='') {
      
        $editData = $getusee = $getuact= $getuafter = FALSE;
        if ($id != '') {
            
            $decryptUseeId = decryptval($id);
            $editData = $this->atar->getUseeDetails(['ATAR_AUTO_ID' => $decryptUseeId], 'row');
        
            $getusee =  $this->atar->getUseeImageBefore($decryptUseeId);
            $getuact = $this->atar->getUactImageBefore($decryptUseeId);
            $getuafter = $this->atar->getUseeactImageAfter($decryptUseeId);
            
            
            $getAllMainCat = $this->atar->getMainCategory();
        //    print_r($getAllMainCat);exit;
            $dropMainCat = customFormDropDown($getAllMainCat, 'ATAR_CAT_AUTO_ID', 'ATAR_CAT_NAME_EN', 'Select Category');
            

        }
     
          //echo $this->db->last_query();exit;
       

        $data = [
            'view_file' => 'atar/usee/view_report',
            'current_menu' => 'View ATAR [ U-See U-Act ]',
            'editData' => $editData,
            'getuseeimage' => $getusee,
            'getuactimage' => $getuact,
            'getuafterimage' => $getuafter,
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
                    }elseif($StatId == 3){
                        sendAtarNotificationClose($did);
                    }
                
                if ($did != '') {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> U-See U-Act has been Updated</div>');
                } else {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> U-See U-Act has been Created</div>');
                }
                redirect('atar/usee/useeInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> U-See U-Act cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> U-See U-Act cannot be Created</div>');
                }
                redirect('atar/usee/useeInfo');
            }
        } else {
            $this->useeInfo($id);
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
              $imgUActDatasImage = uploadMultipleimage($_FILES, 'assets/images/modules/atar/images/usee/after/','useeafterfix');
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
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> U-See U-Act has been Updated</div>');
                } else {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> U-See U-Act has been Created</div>');
                }
                redirect('atar/usee/useeInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> U-See U-Act cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> U-See U-Act cannot be Created</div>');
                }
                redirect('atar/usee/useeInfo');
            }
        } else {
            $this->useeInfo($id);
        }
    }
    public function saveApproveDetails($id = '') {
        
        $did = $id;

        $afterFixapproveDatas = $this->input->post('useeapprove');
        $approve = postData($afterFixapproveDatas, 'approve');
        $reject = postData($afterFixapproveDatas, 'reject');
        
   //    print_r($this->input->post());
     //  print_r($afterFixapproveDatas);
//        
      //  exit;
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
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> U-See U-Act has been Updated</div>');
                } else {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> U-See U-Act has been Created</div>');
                }
                redirect('atar/usee/useeInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> U-See U-Act cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> U-See U-Act cannot be Created</div>');
                }
                redirect('atar/usee/useeInfo');
            }
        } else {
            $this->useeInfo($id);
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
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> U-See U-Act has been Updated</div>');
                } else {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> U-See U-Act has been Created</div>');
                }
                redirect('atar/usee/useeInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> U-See U-Act cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> U-See U-Act cannot be Created</div>');
                }
                redirect('atar/usee/useeInfo');
            }
        } else {
            $this->useeInfo($id);
        }
    }

    
}


