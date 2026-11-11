<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Daily extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isLogin();
        $this->load->model('atar/atar_model', 'atar');
        $this->load->helper('atar_helper');
    }
    
    public function dailyInfo() {
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
             'getLocInfo' => $dropTermname,
              'getempEmployeeList' => $dropdownempDetails,
             'getcntrEmployeeList' => $dropcntrdownDetails,
            'getEmployeeAssignedList' => $assigneddropdownDetails,
            'pageTitle' => 'ATAR [ Daily Observation ]',
            'view_file' => 'atar/daily/list_form',
            'site_title' => 'ATAR [ Daily Observation ]',
            'current_menu' => 'ATAR [ Daily Observation ] List',
            'ajaxurl' => 'atar/daily/listDaily',
        ];

        $this->template->load_table_template($data);
    }
    public function listDaily() {
         global $atarPermission;
        $user_type = getCurrentUserGroupId();
        $userid = getCurrentUserid();
        
        $table = ATAR_FLOW;
        $column_order = array(null, 'ATAR_ID','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'ATAR_REPORT_DATETIME','FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name', null);
        $column_search = array('ATAR_ID','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'ATAR_REPORT_DATETIME', 'FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name');
          $order = array('`ATAR_MAIN_FLOW`.CREATED_ON' => 'desc');
             if (in_array($user_type, $atarPermission['add']) || is_admin()) {
            if (in_array($user_type, $atarPermission['view']) || is_admin()) {
                    $where = [
                        'ATAR_STATUS' => 'Y',
                        'ATAR_TYPE_ID' => 2
                    ];
            }elseif(in_array($user_type, $atarPermission['fix'])){
                  $options['where'] = [
                        'ATAR_STATUS' => 'Y',
                        'ATAR_TYPE_ID' => 2
                    ];
                 $options['orwhere'] = [
                        'ATAR_ASSIGN_HOD_ID' => $userid,
                         'ATAR_REPORTER_ID' => $userid
                    ];
               
            }elseif(in_array($user_type, $atarPermission['unit'])){
                $options['where'] = [
                        'ATAR_STATUS' => 'Y',
                        'ATAR_TYPE_ID' => 2
                    ];
                 $options['orwhere'] = [
                        'ATAR_ASSIGN_UNIT_ID' => $userid,
                         'ATAR_REPORTER_ID' => $userid
                    ];
                
            }elseif(in_array($user_type, $atarPermission['approve'])){
                 $where = [
                        'ATAR_STATUS' => 'Y',
                        'ATAR_TYPE_ID' => 2
                        
                    ];
            }else{
                $where = [
                    'ATAR_STATUS' => 'Y',
                    'ATAR_TYPE_ID' => 2,
                    'ATAR_REPORTER_ID' => $userid
                ];
            }
        }

       $mappedData = [];
        $request = $this->input->post();
        // $where = [];
        $searchextra = postData($request, 'searchextra');

        //  echo "<pre>"; print_r($options);exit;

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



            $ATAR_REPORTER_EMP_ID = postData($mappedData, 'reporter_emp_name');
            $ATAR_REPORTER_CONT_ID = postData($mappedData, 'reporter_cntr_name');
            $assigned_person_name = postData($mappedData, 'assigned_person_name');

            //  $options['where'] = [];
            if ($ATAR_LOC_ID) {
                $options['where'] = [
                    'ATAR_LOC_ID' => $ATAR_LOC_ID,
                ];
                 $options['where']['ATAR_TYPE_ID'] = 2;
            }
            if ($ATAR_SPEC_LOC_ID>0) {
                $options['where']['ATAR_SPEC_LOC_ID'] = $ATAR_SPEC_LOC_ID;
                $options['where']['ATAR_TYPE_ID'] = 2;

            }

             if ($ATAR_REPORTER_EMP_ID) {
                $options['where']["ATAR_REPORTER_ID"] = $ATAR_REPORTER_EMP_ID;
                 $options['where']['ATAR_TYPE_ID'] = 2;
            }
              if ($ATAR_REPORTER_CONT_ID) {
                $options['where']["ATAR_REPORTER_ID"] = $ATAR_REPORTER_CONT_ID;
                 $options['where']['ATAR_TYPE_ID'] = 2;
            }
            if ($assigned_person_name > 0) {
                $options['where']["ATAR_ASSIGN_HOD_ID"] = $assigned_person_name;
                 $options['where']['ATAR_TYPE_ID'] = 2;
            }

        }
      $options['join'] = [
 		'LOGIN_DETAILS AS LD'=>['LD.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS Reporter'=>['Reporter.EMP_AUTO_ID = LD.USER_REF_ID','LEFT'],


        'LOGIN_DETAILS AS LD3'=>['LD3.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
        'CONTRACTOR_DETAILS AS Contractor'=>['Contractor.CONT_AUTO_ID = LD3.USER_REF_ID','LEFT']];

        $options['select'] = ['ATAR_AUTO_ID','ATAR_ID','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'ATAR_REPORT_DATETIME','FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN `Contractor`.`CONT_NAME` ELSE  `Reporter`.`EMP_NAME` END) as Reporter']; 
        $listUsee = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $options);
       echo $this->db->last_query();exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listUsee) && !empty($listUsee)) {
            foreach ($listUsee as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->ATAR_AUTO_ID);

              //  $action .= " " . anchor('atar/daily/addDaily/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));

            //    $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteDaily', 'title' => 'Delete', 'delt-id' => $id));
//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";
                 $action .= " " . anchor('atar/daily/view/' . $id, '<i class="fa fa-eye"></i>', array('title' => 'view'));
              
                $action .= " " . anchor('atar/daily/pdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF','target'=>'_blank'));

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

    public function addDaily($id = '') {
        $did = decryptval($id);
   //   $did =4;
        $obsdetails = [];
        
        $sessiondata = getCurrentUserDetails();
        $userid = getCurrentUserid();
        $currentDateTime = date('d-m-Y H:i:s');
        $dropTermname = $dropSpec = $getUseeActdatas = $getAlluseeimage = $getAlluactimage = [];
        
        $getAllterminal = $this->atar->getLocation();
        $dropTermname = customFormDropDown($getAllterminal, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');
       
        $getAllspec = $this->atar->getSpecificLocation();
        $dropSpec = customFormDropDown($getAllspec, 'SL_AUTO_ID', 'SPECIFIC_LOC_NAME', 'Select Specific Location');

        if ($did != '') {
            $getDailyActdatas = $this->atar->getUseeDetails(['ATAR_AUTO_ID' => $did], 'row');
            $autoId = $getDailyActdatas->ATAR_AUTO_ID;
            
            $where = [
                'FK_ATAR_MAIN_ID' => $autoId
            ];
            
            $option['where'] = $where;
            $option['return_type'] = 'row';
            $obsdetails = $this->common->getAlldata(ATAR_OBS, ['*'], $option);
  
         // echo "<pre>";
       // print_r($obsdetails);exit;
            $getAlldailyimage = $this->atar->getUseeImageBefore($did);
         
        }

        $data = array(
            'view_file' => 'atar/daily/add_form',
            'current_menu' => 'Add ATAR [ Daily Observation ]',
            'getUserInfo' => $sessiondata,
            'getUserId' => $userid,
            'currentDateTime' => $currentDateTime,
            'getLocInfo' => $dropTermname,
            'getSpecLocInfo' => $dropSpec,
            'getDailyActdatas' => $getDailyActdatas,
            'getAlldailyimage' => $getAlldailyimage,
            'obsdetails' => $obsdetails
        );
               
       
        
        $this->template->load_common_template($data);
    }
    
    public function saveDaily($id = '') {
        $did = decryptval($id);
        $udailyDatas = $this->input->post('udaily');
      //  echo "<pre>";
      //  print_r($udailyDatas);exit;
        $userType = getCurrentUserGroupId();
        $module = 'OBS';

        $locName = getLocationShorName(postData($udailyDatas, 'ATAR_LOC_ID'));
         
        $atarId = getAtarNumber($module,$locName,postData($udailyDatas, 'ATAR_LOC_ID'));
        
              
       
      // $userid = getCurrentUserid();
        //$sessiondata = getCurrentUserDetails();
        

        $this->form_validation->set_rules('udaily[ATAR_LOC_ID]', 'Location', 'required|trim');
        $this->form_validation->set_rules('udaily[ATAR_SPEC_LOC_ID]', 'Specific Location', 'required|trim');
        $this->form_validation->set_rules('udaily[ATAR_REPORT_DATETIME]', 'DATE and Time', 'required|trim');
        $this->form_validation->set_rules('udaily[ATAR_INC_DESC_FINDING]', 'Finding/ Observation', 'required|min_length[2]|trim');
        $this->form_validation->set_rules('udaily[ATAR_USEE_WHAT_RECCOM]', 'Recommendations', 'required|min_length[2]|trim');
     
        $date_time = postData($udailyDatas, 'ATAR_REPORT_DATETIME');
        if ($this->form_validation->run()) {
            $udailyResdatas = [
                'ATAR_TYPE_ID' => 2,
                'ATAR_ID' => $atarId,
                'ATAR_REPORTER_TYPE_ID' => $userType,
                'ATAR_REPORTER_ID' => postData($udailyDatas, 'ATAR_REPORTER_ID'),
                'ATAR_REPORTER_DESG_ID' => postData($udailyDatas, 'USER_DESINATION_ID'),
                'ATAR_LOC_ID' => postData($udailyDatas, 'ATAR_LOC_ID'),
                'ATAR_SPEC_LOC_ID' => postData($udailyDatas, 'ATAR_SPEC_LOC_ID'),
                  'ATAR_SPEC_LOC_OTHER' => postData($udailyDatas, 'ATAR_SPEC_LOC_OTHER'),
              
                
                'ATAR_REPORT_DATETIME' => date('Y-m-d H:i:s', strtotime($date_time)),
                'ATAR_USEE_WHAT_RECCOM' => postData($udailyDatas, 'ATAR_USEE_WHAT_RECCOM'),
                'ATAR_INC_DESC_FINDING' => postData($udailyDatas, 'ATAR_INC_DESC_FINDING'),
                'ATAR_APP_STATUS' => 1
            ];
          //  print_r($udailyResdatas);exit;
            if ($did != '') {
                $upWhere = [
                    'ATAR_AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(ATAR_FLOW, $udailyResdatas, $upWhere);
//            echo $this->db->last_query();exit;
            } else {
                $updtProfile = $this->common_model->updateData(ATAR_FLOW, $udailyResdatas);
//                echo $this->db->last_query();exit;
            }
            
            $udailyObsResdatas = [
                'PERMIT_TO_WORK' => postData($udailyDatas, 'PERMIT_TO_WORKS'),
                'ACCESS' => postData($udailyDatas, 'ACCESSS'),
                'HEALTH' => postData($udailyDatas, 'HEALTHS'),
                'EXCAVATION' => postData($udailyDatas, 'EXCAVATIONS'),
                'FIRE' => postData($udailyDatas, 'FIRES'),
                'GASES' => postData($udailyDatas, 'GASESS'),
                'HOUSEKEEPING' => postData($udailyDatas, 'HOUSEKEEPINGS'),
                'HAZARDOUS' => postData($udailyDatas, 'HAZARDOUSS'),
                'PPE' => postData($udailyDatas, 'PPES'),
                'ELECTRICAL' => postData($udailyDatas, 'ELECTRICALS'),
                'POWER' => postData($udailyDatas, 'POWERS'),
                'SAFETY' => postData($udailyDatas, 'SAFETYS'),
                'PLANT' => postData($udailyDatas, 'PLANTS'),
                'HAND' => postData($udailyDatas, 'HANDS'),
                'LIFTING' => postData($udailyDatas, 'LIFTINGS'),
                'WORK_AT_HEIGHT' => postData($udailyDatas, 'WORK_AT_HEIGHTS'),
                'SCAFFOLDING' => postData($udailyDatas, 'SCAFFOLDINGS'),
                'RADIATION' => postData($udailyDatas, 'RADIATIONS'),
                'BARRIERS' => postData($udailyDatas, 'BARRIERSS'),
                'ENVIRONMENT' => postData($udailyDatas, 'ENVIRONMENTS'),
                'OTHERS' => postData($udailyDatas, 'OTHERSS'),
                'OTH' => postData($udailyDatas, 'OTHS'),
                'FK_ATAR_MAIN_ID' => $updtProfile
            ];
             $updtObs = $this->common_model->updateData(ATAR_OBS, $udailyObsResdatas);
//             
             // print_r($imgUseeDatasImage);exit;
            $imgDailyDatasImage = [];
            if(isset($_FILES) && !empty($_FILES)){
              $imgDailyDatasImage = uploadMultipleimage($_FILES, 'assets/images/modules/atar/images/daily/before/','udailyimage');
            }
         
            if ($imgDailyDatasImage != FALSE && count($imgDailyDatasImage) > 0) {
                foreach ($imgDailyDatasImage as $file) {
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

            if ($updtProfile) {
                sendAtarNotification($updtProfile);
                if ($did != '') {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Daily Observation has been Updated</div>');
                } else {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Daily Observation has been Created</div>');
                }
                redirect('atar/daily/dailyInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Daily Observation cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('atarflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Daily Observation cannot be Created</div>');
                }
                redirect('atar/daily/dailyInfo');
            }
        } else {
            $this->addDaily($id);
        }
    }
    
    
    public function pdf($id ='') {
      
        $editData = $getudaily = $getudailyafter =$obsdetails = FALSE;
        if ($id != '') {
            
            $decryptUseeId = decryptval($id);
          //  print_r($decryptUseeId);exit;
            $editData = $this->atar->getUseeDetails(['ATAR_AUTO_ID' => $decryptUseeId], 'row');
            $autoId = $editData->ATAR_AUTO_ID;
            
            $where = [
                'FK_ATAR_MAIN_ID' => $autoId
            ];
            
            $option['where'] = $where;
            $option['return_type'] = 'row';
            $obsdetails = $this->common->getAlldata(ATAR_OBS, ['*'], $option);
            
            $getudaily =  $this->atar->getUseeImageBefore($decryptUseeId);
            $getudailyafter = $this->atar->getUseeactImageAfter($decryptUseeId);
        }
     
          //echo $this->db->last_query();exit;
        
       

      //  print_r($editData);
      

        $data = [
                'editData' => $editData,
                'obsdetails' => $obsdetails,
                'getudailyimage' => $getudaily,
                'getudailyafterimage' => $getudailyafter
            ];
        
       //  echo "<pre>";
       //print_r($data);exit;
         
         $atarNumber = postData($editData, 'ATAR_ID');
        $html2 = $this->load->view('atar/daily/daily_pdf',$data, true);
    //  echo $html2;
//        exit;
       $mpdf2 = $this->pdf->ptwload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "daily";
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
      
        $editData = $getudaily = $getuafterdaily = $obsdetails = $getAllMainCat = FALSE;
        if ($id != '') {
            
            $decryptUseeId = decryptval($id);
            $editData = $this->atar->getUseeDetails(['ATAR_AUTO_ID' => $decryptUseeId], 'row');
        
            $autoId = $editData->ATAR_AUTO_ID;
            
            $where = [
                'FK_ATAR_MAIN_ID' => $autoId
            ];
            
            $option['where'] = $where;
            $option['return_type'] = 'row';
            $obsdetails = $this->common->getAlldata(ATAR_OBS, ['*'], $option);
            
              
            $getudaily =  $this->atar->getUseeImageBefore($decryptUseeId);
            $getuafterdaily = $this->atar->getUseeactImageAfter($decryptUseeId);
            $getAllMainCat = $this->atar->getMainCategory();
        //    print_r($getAllMainCat);exit;
            $dropMainCat = customFormDropDown($getAllMainCat, 'ATAR_CAT_AUTO_ID', 'ATAR_CAT_NAME_EN', 'Select Category');
            
            
        }
     
          //echo $this->db->last_query();exit;
      
      //  print_r($editData);
      

        $data = [
            'view_file' => 'atar/daily/view_report',
            'current_menu' => 'View ATAR [ Daily Observation ]',
            'editData' => $editData,
            'obsdetails' => $obsdetails,
            'getudailyimage' => $getudaily,
            'getuafterimage' => $getuafterdaily,
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
                   if($StatId == 3 && $hodDatasId == ""){
                    	sendAtarNotificationClose($did);
                    }
                
                if ($did != '') {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Daily Observation has been Updated</div>');
                } else {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Daily Observation has been Created</div>');
                }
                redirect('atar/daily/dailyInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Daily Observation cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Daily Observation cannot be Created</div>');
                }
                redirect('atar/daily/dailyInfo');
            }
        } else {
            $this->dailyInfo($id);
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
              $imgUActDatasImage = uploadMultipleimage($_FILES, 'assets/images/modules/atar/images/daily/after/','useeafterfix');
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
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Daily Observation has been Updated</div>');
                } else {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Daily Observation has been Created</div>');
                }
                redirect('atar/daily/dailyInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Daily Observation cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Daily Observation cannot be Created</div>');
                }
                redirect('atar/daily/dailyInfo');
            }
        } else {
            $this->dailyInfo($id);
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
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Daily Observation has been Updated</div>');
                } else {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Daily Observation has been Created</div>');
                }
                redirect('atar/daily/dailyInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Daily Observation cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Daily Observation cannot be Created</div>');
                }
                redirect('atar/daily/dailyInfo');
            }
        } else {
            $this->dailyInfo($id);
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
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Daily Observation has been Updated</div>');
                } else {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Daily Observation has been Created</div>');
                }
                redirect('atar/daily/dailyInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Daily Observation cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('dailyflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Daily Observation cannot be Created</div>');
                }
                redirect('atar/daily/dailyInfo');
            }
        } else {
            $this->dailyInfo($id);
        }
    }


}


