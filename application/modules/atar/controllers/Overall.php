<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Overall extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isLogin();
        $this->load->model('atar/atar_model', 'atar');
        $this->load->helper('atar_helper');
    }
    
  
    public function exportPdf() {
      
        $editDataUnsafe =$getCountData = $editDataenv = $editDatamachine =$editDatahouse=$editDatacondition= FALSE;


        $editDataUnsafe = $this->atar->getUseeDetails( ['ATAR_MAIN_CAT_ID' => 10,'ATAR_STATUS' => 'Y'], 'result');

//echo $this->db->last_query();exit;

        $editDatamachine = $this->atar->getUseeDetails(['ATAR_MAIN_CAT_ID' => 11,'ATAR_STATUS' => 'Y' ], 'result');
       
        $editDatahouse = $this->atar->getUseeDetails(['ATAR_MAIN_CAT_ID' => 12,'ATAR_STATUS' => 'Y' ], 'result');
  //print_r($editDatahouse);exit;      
        $editDatacondition = $this->atar->getUseeDetails(['ATAR_MAIN_CAT_ID' => 13,'ATAR_STATUS' => 'Y' ], 'result');
        
        $editDataenv = $this->atar->getUseeDetails(['ATAR_MAIN_CAT_ID' => 14,'ATAR_STATUS' => 'Y' ], 'result');

      
        $options['return_type'] = 'row';
        $getCountData = $this->common_model->getAlldata('ATAR_MAIN_FLOW', ["count(IF(`ATAR_APP_STATUS` = 3 AND `ATAR_MAIN_CAT_ID` = 10  AND `ATAR_STATUS` = 'Y',`ATAR_AUTO_ID`, NULL)) unsafeActcount","count(IF(`ATAR_APP_STATUS` = 3 AND `ATAR_MAIN_CAT_ID` = 11  AND `ATAR_STATUS` = 'Y',`ATAR_AUTO_ID`, NULL)) machcount","count(IF(`ATAR_APP_STATUS` = 3 AND `ATAR_MAIN_CAT_ID` = 12  AND `ATAR_STATUS` = 'Y',`ATAR_AUTO_ID`, NULL)) housecount","count(IF(`ATAR_APP_STATUS` = 3 AND `ATAR_MAIN_CAT_ID` = 13  AND `ATAR_STATUS` = 'Y',`ATAR_AUTO_ID`, NULL)) unsafeConcount","count(IF(`ATAR_APP_STATUS` = 3 AND `ATAR_MAIN_CAT_ID` = 14  AND `ATAR_STATUS` = 'Y',`ATAR_AUTO_ID`, NULL)) envcount"], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
//echo $this->db->last_query();exit;
       // print_r($getCountData);exit;

        $data = [
                'editDataUnsafe' => $editDataUnsafe,
                'editDatamachine' => $editDatamachine,
                'editDatahouse' => $editDatahouse,
                'editDatacondition' => $editDatacondition,
                'editDataenv' => $editDataenv,
                'editCountCat' => $getCountData
            
            ];
        
       //  echo "<pre>";
      // print_r($data);exit;
         
         
        $html2 = $this->load->view('atar/overall/overall_pdf',$data, true);
    //  echo $html2;
//        exit;
      $mpdf2 = $this->pdf->ptwload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "atar";
        $file_path = "assets/images/modules/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $file_path . 'ATAR-' . $currenttime . '.pdf';
        $name =  'ATAR-' . $currenttime . '.pdf';
        $mpdf2->Output($path2, "I");
//        $data = file_get_contents($path2);
//        force_download($name, $data);
        
    }

    public function overallInfo() {
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
        $options['join'] = [
            'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = EMP.EMP_AUTO_ID','INNER']
        ];
        $actvity = $this->common_model->getAlldata('EMPLOYEE_MANAGEMENT AS EMP', ['LD.LOGIN_ID','EMP.EMP_AUTO_ID','EMP.EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
    
        $dropdownDetails = customFormDropDown($actvity,'LOGIN_ID','EMP_NAME','Select Reporter Name');


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
            'getEmployeeList' => $dropdownDetails,
            'getEmployeeAssignedList' => $assigneddropdownDetails,
            'pageTitle' => 'ATAR [ Overall Report ]',
            'view_file' => 'atar/overall/list_form',
            'site_title' => 'ATAR [ Overall Report ]',
            'current_menu' => 'ATAR [ Overall Report ] List',
            'ajaxurl' => 'atar/overall/listOverall',
        ];

        $this->template->load_table_template($data);
    }
    public function listOverall() {
        
        $table = ATAR_FLOW;
        $column_order = array(null, 'ATAR_ID','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'ATAR_REPORT_DATETIME','FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name', null);
        $column_search = array('ATAR_ID','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'ATAR_REPORT_DATETIME', 'FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name');
        $order = array('CREATED_ON' => 'desc');
        $where = [
            'ATAR_STATUS' => 'Y'
            ];
        $where['ATAR_MAIN_CAT_ID != '] = "";

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



            $ATAR_REPORTER_ID = postData($mappedData, 'reporter_name');
            $assigned_person_name = postData($mappedData, 'assigned_person_name');

            //  $options['where'] = [];
            if ($ATAR_LOC_ID) {
                $options['where'] = [
                    'ATAR_LOC_ID' => $ATAR_LOC_ID
                ];
            }
            if ($ATAR_SPEC_LOC_ID>0) {
                $options['where']['ATAR_SPEC_LOC_ID'] = $ATAR_SPEC_LOC_ID;
            }

            if ($ATAR_REPORTER_ID) {
                $options['where']["ATAR_REPORTER_ID"] = $ATAR_REPORTER_ID;
            }
            if ($assigned_person_name > 0) {
                $options['where']["ATAR_ASSIGN_HOD_ID"] = $assigned_person_name;
            }
//  echo "<pre>"; print_r($options);exit;
        }
        
        $options['select'] = ['ATAR_ID','ATAR_TYPE_ID','ATAR_AUTO_ID','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'ATAR_REPORT_DATETIME','FN_ATAR_STATUS(ATAR_APP_STATUS) as status_Name','FN_ATAR_MAIN_CATEGORY_NAME(ATAR_MAIN_CAT_ID) as cat_Name']; 
        $listUsee = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $options);
   //    echo $this->db->last_query();exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listUsee) && !empty($listUsee)) {
            foreach ($listUsee as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->ATAR_AUTO_ID);
                if($ltVal->ATAR_TYPE_ID == 1){
                    $action .= " " . anchor('atar/usee/view/' . $id, '<i class="fa fa-eye"></i>', array('title' => 'view'));
                    $action .= " " . anchor('atar/usee/pdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF','target'=>'_blank'));
                }elseif($ltVal->ATAR_TYPE_ID == 2){
                    $action .= " " . anchor('atar/daily/view/' . $id, '<i class="fa fa-eye"></i>', array('title' => 'view'));
                    $action .= " " . anchor('atar/daily/pdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF','target'=>'_blank'));
                }elseif($ltVal->ATAR_TYPE_ID == 3){
                    $action .= " " . anchor('atar/monthly/view/' . $id, '<i class="fa fa-eye"></i>', array('title' => 'view'));
                    $action .= " " . anchor('atar/monthly/pdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF','target'=>'_blank'));
                }elseif($ltVal->ATAR_TYPE_ID == 4){
                    $action .= " " . anchor('atar/incident/view/' . $id, '<i class="fa fa-eye"></i>', array('title' => 'view'));
                    $action .= " " . anchor('atar/incident/pdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF','target'=>'_blank'));
                }
            
                $rows = [];
                $rows[] = $ltVal->cat_Name;
                $rows[] = ucfirst($ltVal->loc_name);
                $rows[] = date('d-m-Y H:i:s', strtotime($ltVal->ATAR_REPORT_DATETIME));
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
    
}


