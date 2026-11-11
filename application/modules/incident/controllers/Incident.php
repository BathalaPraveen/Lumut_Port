<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Incident extends CI_Controller {

    public function __construct() {
	parent::__construct();
        isLogin();
        $this->load->model('Incident/incident_model', 'incident_model');
	$this->load->helper('incident_helper');
        $this->load->helper('atar_helper');
	//isLogin();
    }

    public function index() { 
     // echo '<pre>';print_r($_SESSION);exit; 
	   $requestData = $this->input->get();
        $month = $requestData['month'];
        $year = $requestData['year'];
        $terminal = $requestData['terminal'];
		$from_date = $requestData['from_date'];
		$to_date = $requestData['to_date'];
       
        $notifyStatusList = $this->incident_model->getnotifyStatusList();
	    $data = array(
			'pageTitle' => 'Incident Notification',
			'view_file' => 'incident/incident/notifylist',
			'site_title' => 'Incident Notification',
			'current_menu' => 'List Incident Notification',
			'from_date' => $from_date,
			 'to_date' => $to_date,
			// 'ajaxurl' => 'incident/list_notify?type=init',
				'ajaxurl' => 'incident/list_notify?type=init&month=' . $month . '&year=' . $year . '&terminal=' . $terminal. '&from_date=' . $from_date. '&to_date=' . $to_date,

            'notifyStatusList' => $notifyStatusList,
	);

	$this->template->load_table_template($data);
    }
    
    public function IrreverentAction() {
    	
	$data = array(
	    'pageTitle' => 'Incident Notification',
	    'view_file' => 'incident/incident/notifylist',
	    'site_title' => 'Incident Notification',
	    'current_menu' => 'List Incident Notification',
	    'ajaxurl' => 'incident/list_notifyIrreverent?type=init',
	);

	$this->template->load_table_template($data);
    }

    public function list_notifyIrreverent() {
    	$displayType = $this->input->get('type');
	$incidentAction = $this->input->get('incidentAction');
	$table = INC_NOTIFY_INFO;
	$column_order = array(null, 'INCIDENT_NOTIFY_ID', 'LOCATION_ID', 'SPECIFIC_LOCATION_ID', 'EVENT_DATE', 'EVENT_REPORT_NAME', 'STATUS','INCIDENT_REPORT_ID', null);
	$column_search = array('INCIDENT_NOTIFY_ID', 'LOCATION_ID', 'SPECIFIC_LOCATION_ID', 'EVENT_DATE', 'EVENT_REPORT_NAME', 'STATUS','INCIDENT_REPORT_ID');
	$order = array('CREATED_ON' => 'desc');
	$where = ['NOTIFY_STATUS' => 'Y'];
	$options['select'] = array('INCIDENT_NOTIFY_ID', 'FN_GET_LOCATION(LOCATION_ID) as LOCATION', 'FN_SPECIFIC_LOCATION_NAME(SPECIFIC_LOCATION_ID) as SPECIFIC_LOCATION', 'EVENT_DATE', 'EVENT_TIME', 'CREATED_ON', 'EVENT_REPORT_NAME', 'FN_INC_STATUS_NAME(STATUS) as STATUS');
	$listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where, $options);

	$finalDatas = [];
	if (isset($listIncicat) && !empty($listIncicat)) {
	    foreach ($listIncicat as $ltKey => $ltVal) {

		$action = '';
		$id = encryptval($ltVal->INCIDENT_NOTIFY_ID); 
		
		    $action .= " " . anchor('incident/investCheck/' . $id, '<i class="fa fa-search"></i>', array('class' => '', 'title' => 'Investigate'));
		   
		$rows = [];
		$rows[] = $ltVal->INCIDENT_NOTIFY_ID;
		$rows[] = $ltVal->LOCATION;
		$rows[] = $ltVal->SPECIFIC_LOCATION;
		$rows[] = convertDate($ltVal->EVENT_DATE, 'd-m-Y') . ' ' . $ltVal->EVENT_TIME;
		$rows[] = $ltVal->EVENT_REPORT_NAME;
//		$rows[] = ($ltVal->NOTIFY_STATUS == 'Y') ? '<span class="btn btn-success">Notified</span>' : '<span class="btn btn-danger">Disabled</span>';
		$rows[] = '<span class="btn btn-warning">' . $ltVal->STATUS . '</span>';
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

    public function list_notify() {
	$displayType = $this->input->get('type');

	  $year1 = $this->input->get('year');
        $year = !empty($year1) ? $year1 : date('Y');
        $terminal = $this->input->get('terminal');
		$month = $this->input->get('month');
        //echo '<pre>';print_r($displayType);exit;
	$table = 'INCIDENT_NOTIFICATION_DETAILS INN';
        
        $mappedData = [];
        $request = $this->input->post();

        $searchextra = postData($request, 'searchextra');
        if ($searchextra != FALSE && count($searchextra) > 0) {
            foreach ($searchextra as $search) {
                $sName = postData($search, 'name');
                $sValue = postData($search, 'value');
                $mappedData[$sName] = $sValue;
            }
        }
        
        
	$column_order = array(null, 'INN.INCIDENT_NOTIFY_ID','group_concat(E.EVENT_TYPE_NAME) as EVENT_TYPE_NAME', 'INN.LOCATION_ID', 'INN.SPECIFIC_LOCATION_ID', 'INN.EVENT_DATE', 'INN.EVENT_REPORT_NAME', 'INN.STATUS','INN.INCIDENT_REPORT_ID','INN.EVENT_REPORTED_BY','INNLOCATION_ID', null);
	$column_search = array('INN.INCIDENT_NOTIFY_ID','group_concat(E.EVENT_TYPE_NAME) as EVENT_TYPE_NAME', 'INN.LOCATION_ID', 'INN.SPECIFIC_LOCATION_ID', 'INN.EVENT_DATE', 'INN.EVENT_REPORT_NAME', 'INN.STATUS','INN.INCIDENT_REPORT_ID','INN.EVENT_REPORTED_BY','INN.LOCATION_ID');
	$where = [
                    'INN.NOTIFY_STATUS' => 'Y'
		];
        $options['group_by'] = ['INN.INCIDENT_NOTIFY_ID'];
        $order = array('INN.CREATED_ON' => 'desc');
        $testing = [5,7,9,11,6,8,13,12];  
        $stssVerfy = [6,12,11,8];
        $stssApry = [8,12];
        $where = [
                    'INN.NOTIFY_STATUS' => 'Y'
		];
        
        
       // join('membership_type MS','FIND_IN_SET(MS.membership_type_id,M.membership_type_id)>0','left ',false)
        if($displayType == 'init'){
	
        if($_SESSION['userinfo']->USER_TYPE_ID == '6' || $_SESSION['userinfo']->USER_TYPE_ID == '7'  || $_SESSION['userinfo']->USER_TYPE_ID == '1' || $_SESSION['userinfo']->USER_TYPE_ID == '2'  ){
             $where = [
                    'INN.NOTIFY_STATUS' => 'Y'
                    
		];

        }
        
        else{
          
             $where = [
		    'INN.EVENT_REPORTED_BY' => $_SESSION['id'],
                   
		];
        }
        }
       else if($displayType == 'invest'){
           if($_SESSION['userinfo']->USER_TYPE_ID == '6' || $_SESSION['userinfo']->USER_TYPE_ID == '7'  || $_SESSION['userinfo']->USER_TYPE_ID == '1' || $_SESSION['userinfo']->USER_TYPE_ID == '2'  ){
             $where = [
                    'INN.NOTIFY_STATUS' => 'Y'
                    
		];

        }
           
             if($_SESSION['userinfo']->USER_TYPE_ID == '8' && $_SESSION['userinfo']->USER_DESINATION_ID == '22'){
            $options['where_in'] = [
                    'INN.NOTIFY_STATUS' => 'Y',
                     'INN.LOCATION_ID' => '1',
                     'INN.STATUS' => $stssVerfy
                    
		];
             }
             else if($_SESSION['userinfo']->USER_TYPE_ID == '8' && $_SESSION['userinfo']->USER_DESINATION_ID == '18'){
            $options['where_in'] = [
                    'INN.NOTIFY_STATUS' => 'Y',
                     'INN.LOCATION_ID' => '2',
                     'INN.STATUS' => $stssVerfy
                    
		];
             }
             else if( $_SESSION['userinfo']->USER_TYPE_ID == '9'){
            $options['where_in'] = [
                    'INN.NOTIFY_STATUS' => 'Y',
                     'INN.STATUS' => $stssApry
		];
            }
            else{
                $options['where_in'] = [
		    'INN.STATUS' => $testing
	    ];
            }
            
            
        }
	$options['select'] = array('INN.INCIDENT_NOTIFY_ID','group_concat(E.EVENT_TYPE_NAME) as EVENT_TYPE_NAME', 'FN_GET_LOCATION(INN.LOCATION_ID) as LOCATION', 'FN_SPECIFIC_LOCATION_NAME(INN.SPECIFIC_LOCATION_ID) as SPECIFIC_LOCATION', 'INN.EVENT_DATE', 'INN.EVENT_TIME', 'INN.CREATED_ON', 'INN.EVENT_REPORT_NAME', 'FN_INC_STATUS_NAME(INN.STATUS) as STATUS','INN.INCIDENT_REPORT_ID','INN.STATUS as STATUSS','INN.EVENT_REPORTED_BY','INN.LOCATION_ID');
	
        $options['join'] = [
        'INCIDENT_EVENT_TYPE_MASTER AS E'=>['FIND_IN_SET(E.EVENT_TYPE_ID , INN.EVENT_TYPE_IDS)>0','INNER']
           ];
        $where = [
                    'INN.NOTIFY_STATUS' => 'Y'
		];
        $options['group_by'] = ['INN.INCIDENT_NOTIFY_ID']; 
        
        //$options['join'] = ['INCIDENT_EVENT_TYPE_MASTER E','FIND_IN_SET(E.EVENT_TYPE_ID , INN.EVENT_TYPE_IDS)>0',false];
        if($mappedData != FALSE && count($mappedData) > 0){
            $searchStatus = postData($mappedData,'NotifyStatus');
            if($searchStatus > 0){
                 $where['STATUS'] = $searchStatus;
            }
            $startdate = postData($mappedData, 'start_date');
            $enddate = postData($mappedData, 'end_date');
            
       
            if ($startdate != '') {
                $startdate = date('Y-m-d', strtotime($startdate));
                 $where['EVENT_DATE >= '] = $startdate;
               
            }
            if ($enddate != '') {
                $enddate = date('Y-m-d', strtotime($enddate));
                 $where['EVENT_DATE <= '] = $enddate;
            }
            
        }

		   if($terminal != ''){
               $where['`INN`.`LOCATION_ID`'] = $terminal;
              }
            if($year != ''){
               $where['YEAR(`INN`.`CREATED_ON`)'] = $year;
             }
			   if($month != ''){
                $where['MONTHNAME(`INN`.`CREATED_ON`)'] = $month;
                }
	
        $listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where, $options);
    //    echo $this->db->last_query();exit;
//        echo 'M<pre>';print_r($listIncicat);exit; 
        
        $finalDatas = [];
	if (isset($listIncicat) && !empty($listIncicat)) {
	    foreach ($listIncicat as $ltKey => $ltVal) {
            //echo '<pre>';print_r($ltVal);exit;
		$action = '';
		$id = encryptval($ltVal->INCIDENT_NOTIFY_ID);
		
		$statuss = $ltVal->STATUSS;
                $EVENT_REPORTED_BY = $ltVal->EVENT_REPORTED_BY;
                $loctidId = $ltVal->LOCATION_ID;
                //echo '<pre>';print_r($loctidId);
//                echo '<pre>';print_r($_SESSION['id']);exit;
                if($EVENT_REPORTED_BY == $_SESSION['id']){
                    $ReprtId = '1';
                }
                else{
                    $ReprtId = '2';
                }
		//echo '<pre>';print_r($ReprtId);exit;
		if ($displayType == 'init'){

                    //echo 1;exit;
                    if($_SESSION['userinfo']->USER_TYPE_ID == '5'|| $_SESSION['userinfo']->USER_TYPE_ID == '4' || $_SESSION['userinfo']->USER_TYPE_ID == '1' || $_SESSION['userinfo']->USER_TYPE_ID == '2'  ) {
                   if($statuss == "1" && $ReprtId == '1') {
                       //echo 1;exit; 
 $action .= " " . anchor('incident/notify/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));
                       
		        $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteInc', 'title' => 'Delete', 'delt-id' => $id));
                        
                   }
                    else if($statuss == "2"){
                        
                        $action .= " " . anchor('incident/investCheck/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'Notify View'));
                        $action .= " " . anchor('incident/NotifyPdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Notify - PDF','target'=>'_blank')); 
                
		    
		}
                else{
                  $action .= " " . anchor('incident/investCheck/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'Notify View'));
                   $action .= " " . anchor('incident/NotifyPdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Notify - PDF','target'=>'_blank'));   
                }
                    }
                
                
                 
		if($_SESSION['userinfo']->USER_TYPE_ID == '6' || $_SESSION['userinfo']->USER_TYPE_ID == '7'|| $_SESSION['userinfo']->USER_TYPE_ID == '8'){
                    if($statuss == "2"){
                       $action .= " " . anchor('incident/investCheck/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'Notify View'));
                       $action .= " " . anchor('incident/NotifyPdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Notify - PDF','target'=>'_blank')); 
                       $action .= " " . anchor('incident/ActivityList/' . $id, '<i class="fa fa-eye" style="font-size:20px;color:red"></i>', array('class' => '', 'title' => 'ActivityList'));
                       }
                    
                     
                    
//                   else if($statuss != "5"){
//		    $action .= " " . anchor('incident/investCheck/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'Notify View'));
//                    $action .= " " . anchor('incident/ActivityList/' . $id, '<i class="fa fa-eye" style="font-size:20px;color:red"></i>', array('class' => '', 'title' => 'ActivityList'));
//                    $action .= " " . anchor('incident/NotifyPdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Notify - PDF','target'=>'_blank'));
//		}
                else if($statuss == "3"){
               $action .= " " . anchor('incident/investCheck/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'Notify View'));
                $action .= " " . anchor('incident/ActivityList/' . $id, '<i class="fa fa-eye" style="font-size:20px;color:red"></i>', array('class' => '', 'title' => 'ActivityList'));
                $action .= " " . anchor('incident/NotifyPdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Notify - PDF','target'=>'_blank'));
                
                }
                else if($statuss == "1" && $ReprtId == '1'){
                    $action .= " " . anchor('incident/notify/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));
		    $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteInc', 'title' => 'Delete', 'delt-id' => $id));
                    $action .= " " . anchor('incident/investCheck/' . $id, '<i class="fa fa-search"></i>', array('class' => '', 'title' => 'Notify View'));
                    $action .= " " . anchor('incident/ActivityList/' . $id, '<i class="fa fa-eye" style="font-size:20px;color:red"></i>', array('class' => '', 'title' => 'ActivityList'));
                    $action .= " " . anchor('incident/NotifyPdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Notify - PDF','target'=>'_blank'));
                }
                else if($statuss == "1"){
//                    $action .= " " . anchor('incident/notify/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));
//		    $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteInc', 'title' => 'Delete', 'delt-id' => $id));
                    $action .= " " . anchor('incident/investCheck/' . $id, '<i class="fa fa-search"></i>', array('class' => '', 'title' => 'Notify View'));
                    $action .= " " . anchor('incident/ActivityList/' . $id, '<i class="fa fa-eye" style="font-size:20px;color:red"></i>', array('class' => '', 'title' => 'ActivityList'));
                    $action .= " " . anchor('incident/NotifyPdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Notify - PDF','target'=>'_blank')); 
                }
                
                
                else{
                $action .= " " . anchor('incident/investCheck/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'Notify View'));
                $action .= " " . anchor('incident/ActivityList/' . $id, '<i class="fa fa-eye" style="font-size:20px;color:red"></i>', array('class' => '', 'title' => 'ActivityList'));
                $action .= " " . anchor('incident/NotifyPdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Notify - PDF','target'=>'_blank'));
                }
                }
		
                //$action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank'));
                }   else if ($displayType == 'invest'){
                    if($statuss == "12"){
                       $action .= " " . anchor('incident/ViewList/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'ViewList'));
                       $action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank'));

                    }
                    //echo 1;exit;
                    if($_SESSION['userinfo']->USER_TYPE_ID == '6' || $_SESSION['userinfo']->USER_TYPE_ID == '7' || $_SESSION['userinfo']->USER_TYPE_ID == '1' || $_SESSION['userinfo']->USER_TYPE_ID == '2' ) {
                        if($statuss == "5" || $statuss == "7" || $statuss == "9"){
                    
                    $action .= " " . anchor('incident/investigate/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Investigate'));
                    $action .= " " . anchor('incident/ViewList/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'ViewList'));
                    $action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank'));
		}
                else if($statuss == "6" || $statuss == "8" || $statuss == "11"){
                     $action .= " " . anchor('incident/ViewList/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'ViewList'));
                    $action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank'));
                }
                else if($statuss == "13" && $_SESSION['userinfo']->USER_TYPE_ID == '7'){
                    $action .= " " . anchor('incident/investigate/' . $id, '<i class="fa fa-eye" style="color:blue"></i>', array('class' => '', 'title' => 'Investigate'));
                    $action .= " " . anchor('incident/ViewList/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'ViewList'));
                    $action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank')); 
                }
                else if($statuss == "13" && $_SESSION['userinfo']->USER_TYPE_ID == '6'){
                    // $action .= " " . anchor('incident/investigate/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Investigate'));
                    $action .= " " . anchor('incident/ViewList/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'ViewList'));
                    $action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank'));
                }
                
                    }
                    if($loctidId == '1'){
                    
                     if($_SESSION['userinfo']->USER_TYPE_ID == '8' && $_SESSION['userinfo']->USER_DESINATION_ID == '22'){
                        if($statuss == "6" || $statuss == "11" ){
                            $action .= " " . anchor('incident/investigate/' . $id, '<i class="fa fa-eye" style="color:blue"></i>', array('class' => '', 'title' => 'Investigate'));
                            $action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank'));
                            $action .= " " . anchor('incident/ViewList/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'ViewList'));
                        }
                       else if($statuss == "8"){
                       $action .= " " . anchor('incident/ViewList/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'ViewList'));
                       $action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank'));

                    }
                    }
                    }
                  else  if($loctidId == '2'){
                       if($_SESSION['userinfo']->USER_TYPE_ID == '8' && $_SESSION['userinfo']->USER_DESINATION_ID == '18'){
                        if($statuss == "6" || $statuss == "11" ){
                            $action .= " " . anchor('incident/investigate/' . $id, '<i class="fa fa-eye" style="color:blue"></i>', array('class' => '', 'title' => 'Investigate'));
                            $action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank'));
                            $action .= " " . anchor('incident/ViewList/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'ViewList'));
                        }
                        else if($statuss == "8"){
                       $action .= " " . anchor('incident/ViewList/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'ViewList'));
                       $action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank'));

                    }
                    }
                    }
                    else {
                       if($_SESSION['userinfo']->USER_TYPE_ID == '8'){
                        if($statuss == "6" || $statuss == "11" ){
                            $action .= " " . anchor('incident/investigate/' . $id, '<i class="fa fa-eye" style="color:blue"></i>', array('class' => '', 'title' => 'Investigate'));
                            $action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank'));
                            $action .= " " . anchor('incident/ViewList/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'ViewList'));
                        }
                        else if($statuss == "8"){
                       $action .= " " . anchor('incident/ViewList/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'ViewList'));
                       $action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank'));

                    }
                    }
                    } 
                     if($_SESSION['userinfo']->USER_TYPE_ID == '9'){
                        if($statuss == "8"){
                            $action .= " " . anchor('incident/investigate/' . $id, '<i class="fa fa-eye" style="color:blue"></i>', array('class' => '', 'title' => 'Investigate'));
                            $action .= " " . anchor('incident/PdfReport/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'Incident Report - PDF','target'=>'_blank'));
                            $action .= " " . anchor('incident/ViewList/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'ViewList'));
                        }
                    }
                    
            }
                
                
                
                    
                    
                    $rows = [];
                    if($displayType == 'invest'){
            if($ltVal->INCIDENT_REPORT_ID != '' || $statuss == "5" ||  $statuss == "7" || $statuss == "9" || $statuss == "11" || $statuss == "13"||$statuss == "12"){
		    $rows[] = $ltVal->INCIDENT_REPORT_ID;
                    }
                    }else{
                    $rows[] = $ltVal->INCIDENT_NOTIFY_ID;   
                    }
                    if($displayType == 'invest'){
                $rows[] = $ltVal->EVENT_TYPE_NAME;
                    }
		$rows[] = $ltVal->LOCATION;
		$rows[] = $ltVal->SPECIFIC_LOCATION;
		$rows[] = convertDate($ltVal->EVENT_DATE, 'd-m-Y') . ' ' . $ltVal->EVENT_TIME;
		$rows[] = $ltVal->EVENT_REPORT_NAME;
//		$rows[] = ($ltVal->NOTIFY_STATUS == 'Y') ? '<span class="btn btn-success">Notified</span>' : '<span class="btn btn-danger">Disabled</span>';
		$rows[] = '<span class="btn btn-warning">' . $ltVal->STATUS . '</span>';
		$rows[] = $action;
		$finalDatas[] = $rows;
	    }
	}

	if($displayType == 'invest'){
        $output = array(
	    "draw" => $this->input->post('draw'),
	    "recordsTotal" => $this->incident_model->count_all($table, $column_order, $column_search, $order, $where,$options),
	    "recordsFiltered" => $this->common_model->count_filtered($table, $column_order, $column_search, $order, $where,$options),
	    "data" => $finalDatas,
	);  
        }
        
         // echo $this->db->last_query();exit;
      
        
        else if($displayType == 'init'){

	$output = array(
	    "draw" => $this->input->post('draw'),
	    "recordsTotal" => $this->incident_model->count_alls($table, $column_order, $column_search, $order, $where),
	    "recordsFiltered" => $this->common_model->count_filtered($table, $column_order, $column_search, $order, $where),
	    "data" => $finalDatas,
	);
        
        }
	//output to json format
	echo json_encode($output);
    }

    public function notify($id = "") {
	$editData = [];
	if ($id != '') {
	    $optWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => decryptval($id)
	    ];
	    $optWhr['return_type'] = 'row';
	    $editData = $this->common_model->getAlldata(INC_NOTIFY_INFO, ['*', 'FN_DATE_FORMAT(EVENT_DATE) as eventDate'], $optWhr);
            //echo '<pre>';print_r($editData);exit;
	    $incid = postData($editData, 'INCIDENT_ID');
	    $optattWhr['where'] = [
		'INC_NOTIFY_ID' => $incid
	    ];
	    $optattWhr['return_type'] = 'result';
	    $editData->notifyAttachments = $this->common_model->getAlldata(INCIDENT_NOTIFY_ATTACHMENT, ['CONCAT(FILE_PATH,FILE_NAME) as fileset'], $optattWhr);
	    $optattWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => $incid
	    ];
	    $optattWhr['return_type'] = 'result';
            //echo '<pre>';print_r($editData->notifyAttachments);exit;
	    $editData->persons = $this->common_model->getAlldata(INC_NOTIFY_PERSON, ['*'], $optattWhr);
	}
	$this->initialForm($id, $editData);
    }

    function initialForm($id = "", $editData = []) {
	$sessiondata = getCurrentUserDetails();
	$role_id = $this->session->role_id;
	$backUrl = BASE_URL . 'incident';
	$reWhr['where'] = [
	    'INCIDENT_EVENT_STATUS' => 'Y'
	];
	$reWhr['return_type'] = 'result';
	$getEventRelate = $this->common_model->getAlldata(INC_EVENT_RELATE, ['*'], $reWhr);
	$typeWhr['where'] = [
	    'EVENT_TYPE_STATUS' => 'Y'
	];
	$typeWhr['return_type'] = 'result';
	$getEventType = $this->common_model->getAlldata(INC_EVENT_TYPE, ['*'], $typeWhr);
	$EventTypeArray = customFormDropDown($getEventType, 'EVENT_TYPE_ID', 'EVENT_TYPE_NAME');
	$loWhr['where'] = [
	    'TERMINAL_STATUS' => 'Y'
	];
	$loWhr['return_type'] = 'result';
	$getLoc = $this->common_model->getAlldata(LOCATION, ['*'], $loWhr);
	$LocArray = customFormDropDown($getLoc, 'TER_AUTO_ID', 'TERMINAL_SHORTNAME', 'Select Location');
	$spWhr['where'] = [
	    'SPECIFIC_LOC_STATUS' => 'Y'
	];
	$spWhr['return_type'] = 'result';
	$getSpecLoc = $this->common_model->getAlldata(SPECIFIC_LOCATION, ['*'], $spWhr);
	$specLocArray = customFormDropDown($getSpecLoc, 'SL_AUTO_ID', 'SPECIFIC_LOC_NAME', 'Select Location');
	$data = array(
	    'view_file' => 'incident/incident/addnotification',
	    'title' => 'Incident Notification',
	    'current_menu' => 'Incident Notification',
	    'userDetails' => $sessiondata,
	    'editData' => $editData,
	    'role_id' => $role_id,
	    'getEventRelate' => $getEventRelate,
	    'getEventType' => $EventTypeArray,
	    'getLoc' => $LocArray,
	    'getSpecLoc' => $specLocArray,
	    'backUrl' => $backUrl,
	    'id' => $id,
	    'headerfiles' => [
		'css' => [
		    'assets/plugins/clockpicker/clockpicker.css'
		],
		'js' => [
		    'assets/plugins/clockpicker/clockpicker.js'
		],
		'priority' => 'high'
	    ]
	);

	$this->template->load_common_template($data);
    }


	 public function initialsave($id = "") {
    	//echo '<pre>';print_r($_POST);exit;
	global $newIncidentTemplate;
	$postDatas = $this->input->post();
	$user_id = $this->session->id;
	$editId = ($id != "") ? decryptval($id) : '';
	$this->form_validation->set_rules('eventDate', 'Date', 'required');
	$this->form_validation->set_rules('eventTime', 'Time', 'required');
	$this->form_validation->set_rules('eventLocation', 'Location', 'required');
	$this->form_validation->set_rules('specificLocation', 'Specific Location', 'required');
	if (!empty(postData($postDatas, 'eventRelatedTo', []))) {
	    foreach (postData($postDatas, 'eventRelatedTo') as $key => $evt) {
		$this->form_validation->set_rules('eventRelatedTo[' . $key . ']', 'Event Related To', 'required');
	    }
	}
	if (!empty(postData($postDatas, 'eventType', []))) {
	    foreach (postData($postDatas, 'eventType') as $key => $evt) {
		$this->form_validation->set_rules('eventType[' . $key . ']', 'Event Type', 'required');
	    }
	}
	$this->form_validation->set_rules('description', 'Description', 'required');
	//$this->form_validation->set_rules('equipmentInvolved', 'Event Related To', 'required');
        //echo 6;exit;
	if ($this->form_validation->run() == true) {
           // echo 5;exit;
	    $eventDate = $this->input->post('eventDate', true);
	    $eventDate = ($eventDate != '') ? date('Y-m-d', strtotime($eventDate)) : '0000-00-00';
	    $eventNotifyDate = ($eventDate != '') ? date('d-m-Y', strtotime($eventDate)) : '00-00-0000';
	    $eventTime = $this->input->post('eventTime', true);
	    $eventLocation = $this->input->post('eventLocation', true);
//            $evtLct = FN_GET_LOCATION($eventLocation);
//            echo '<pre>';print_r($evtLct);exit;
	    $specificLocation = $this->input->post('specificLocation', true);
	    $specificlocother = $this->input->post('specificlocother', true);
	    $eventRelatedTo = (!empty(postData($postDatas, 'eventRelatedTo', []))) ? implode(',', postData($postDatas, 'eventRelatedTo')) : [];
	    $eventType = (!empty(postData($postDatas, 'eventType', []))) ? implode(',', postData($postDatas, 'eventType')) : [];
	    $evtdescription = $this->input->post('description', true);
	    $immediateAction = $this->input->post('immediateAction', true);
	    $persons = $this->input->post('persons', true);
	    $equipInvolved = $this->input->post('equipmentInvolved', true);
	    $police_check = $this->input->post('police_check', true);
	    $police_caseno = $this->input->post('police_caseno', true);
	    $police_otherinifo = $this->input->post('police_otherinifo', true);
	    $hospital_check = $this->input->post('hospital_check', true);
	    $hospital_caseno = $this->input->post('hospital_caseno', true);
	    $hospital_otherinifo = $this->input->post('hospital_otherinifo', true);
	    $other_check = $this->input->post('other_check', true);
	    $other_caseno = $this->input->post('other_caseno', true);
	    $other_otherinifo = $this->input->post('other_otherinifo', true);
	    $reported_name = $this->input->post('reported_name', true);
	    $reported_cmp = $this->input->post('reported_cmp', true);
	    $reported_desgn = $this->input->post('reported_desgn', true);
	    $reported_activity = $this->input->post('reported_activity', true);
	    $reported_ID_TYPE = $this->input->post('reported_ID_TYPE', true);
	    $reported_icpassno = $this->input->post('reported_icpassno', true);
	    $reported_phoneno = $this->input->post('reported_phoneno', true);
            if($police_check == ''){
                $police_check = 'N';
            }
            if($other_check == ''){
                $other_check = 'N';
            }
            if($hospital_check == ''){
                $hospital_check = 'N';
            }
	    $prefix = 'NOI-' . date('Y');
	    //$notifyId = uniqueIncRefId($prefix, INC_NOTIFY_INFO, 'INCIDENT_ID', 'INCIDENT_ID');
            $notifyId = uniqueIntRefId($prefix, INC_NOTIFY_INFO, 'INCIDENT_ID', 'INCIDENT_ID');
            //echo '<pre>';print_r($notifyId);exit;
	    $updateInitialData = [
		'EVENT_DATE' => $eventDate,
		'EVENT_TIME' => $eventTime,
		'LOCATION_ID' => $eventLocation,
		'SPECIFIC_LOCATION_ID' => $specificLocation,
		'SPECIFIC_LOCATION_OTHER' => $specificlocother,
		'EVENT_RELATED_TO_IDS' => $eventRelatedTo,
		'EVENT_TYPE_IDS' => $eventType,
		'EVENT_DESC' => $evtdescription,
		'IMMEDIATE_ACTION_TAKEN' => $immediateAction,
		'EQUIPMENT_INVOLVED' => $equipInvolved,
		'POLICE' => $police_check,
		'POLICE_CASE_NO' => $police_caseno,
		'POLICE_OTHER_INFO' => $police_otherinifo,
		'HOSPITAL' => $hospital_check,
		'HOSPITAL_CASE_NO' => $hospital_caseno,
		'HOSPITAL_OTHER_INFO' => $hospital_otherinifo,
		'OTHER' => $other_check,
		'OTHER_CASE_NO' => $other_caseno,
		'OTHER_OTHER_INFO' => $other_otherinifo,
		'EVENT_REPORTED_BY' => $user_id,
		'EVENT_REPORT_NAME' => $reported_name,
		'EVENT_REPORT_COMPANY' => $reported_cmp,
		'EVENT_REPORT_DESIGNATION' => $reported_desgn,
		'EVENT_REPORT_ACTIVITY_PERFORMED' => $reported_activity,
		'ID_TYPE' => $reported_ID_TYPE,
		'IC_PASSPORT_NO' => $reported_icpassno,
		'PHONE_NO' => $reported_phoneno,
		'NOTIFY_STATUS' => 'Y',
		'STATUS' => '1',
'PREPARED_DATE' => date('Y-m-d H:i:s'),
'PREPARED_BY' => $_SESSION['id'],
                //'INCIDENT_REPORT_ID' => null,
	    ];
            //echo 3;exit;
	    //echo '<pre>';print_r($updateInitialData);exit;
	    if ($editId != '') {
	    	//echo 1;exit;
		$incId = $editId;
		$updateWhere = [
		    'INCIDENT_NOTIFY_ID' => $editId,
		];
		$updateInitialData['UPDATED_ON'] = date('Y-m-d H:i:s');
		$incId = $this->common_model->updateInfo(INC_NOTIFY_INFO, $updateInitialData, 'INCIDENT_ID', $updateWhere);
               // echo $this->db->last_query();exit;
	    } else {
	    	//echo 2;exit;
		$updateInitialData['INCIDENT_NOTIFY_ID'] = $notifyId;
		$updateInitialData['CREATED_ON'] = date('Y-m-d H:i:s');
		$incId = $this->common_model->updateInfo(INC_NOTIFY_INFO, $updateInitialData, 'INCIDENT_ID');
                //echo $this->db->last_query();exit;
	    }
	    if (!empty($persons)) {
		$remove = $this->db->delete(INCIDENT_NOTIFY_PERSON_DETAILS, ['INCIDENT_NOTIFY_ID' => $incId]);
               // echo $this->db->last_query();exit;
		$personData = [];
		foreach ($persons as $key => $per) {
		    $personData[] = [
			'INCIDENT_NOTIFY_ID' => $incId,
			'PERSON_NAME' => postData($per, 'name', ''),
			'COMPANY' => postData($per, 'cmp', ''),
			'DESINATION' => postData($per, 'desgn', ''),
			'ACTIVITY_BEING_PERFOMED' => postData($per, 'activity', ''),
			'ID_TYPE' => postData($per, 'idtype', ''),
			'IC_PASSPORT_NO' => postData($per, 'idcard', ''),
			'PHONE_NO' => postData($per, 'phone', ''),
			'PERSON_DETAILS_STATUS' => 'Y'
		    ];
		}
               // echo 'M<pre>';print_r($personData);exit;
		 $persons = $this->common_model->batchinsertdata(INC_NOTIFY_PERSON, $personData);
                 //echo '<pre>';print_r($persons);exit;
                if($id == ''){
                    $getss = $notifyId; 
                    $getsss = encryptval($notifyId);
                }
                else{
                   $getss = decryptval($id); 
                   $getsss = $id;
                }
		// Active Table ( User Audits )
		 $user_data['USER_ID']=$_SESSION['id'];
		 $user_data['INCIDENT_NOTIFY_ID_DECRYPT']=$getsss;
		 $user_data['ID'] = $_SESSION['name'];
		 $user_data['INCIDENT_NOTIFY_ID']=$getss;
                $user_data['MODULE']='Incident Notification';
                $user_data['PROCESS']='Insert';
                $details = serialize($personData);
                $user_data['VALUE']="Incident/Accident Investigation Insert".$details;
                $userAudit = $this->incident_model->InsertActiveofUserAudit($user_data);
	    }

	    /* photos upload start */
	     //echo '<pre>';print_r($_FILES);exit;
	    if (!empty($_FILES['photos'])) {
                //$idsd = decryptval($id);
		$path = 'public/module/incident/' . $incId . '/';
		//echo '<pre>';print_r($path);exit;
		$allowedType = 'jpg|png|jpeg';
		$uploadInfo = uploadMultipleimage($_FILES, $path, $type = 'photos', $allowedType, TRUE);
		$uploadError['field_name'] = 'photos';
		$uploadError['error_msg'] = $uploadInfo;
		if ($uploadInfo != FALSE && count($uploadInfo) > 0) {
		    foreach ($uploadInfo as $file) {
			$updateUploadData = [
			    'INC_NOTIFY_ID' => $incId,
			    'FILE_ORG_FILENAME' => postData($file, 'uploadorigname'),
			    'FILE_NAME' => postData($file, 'uploadname'),
			    'FILE_TYPE' => postData($file, 'uploadtype'),
			    'FILE_EXT' => postData($file, 'uploadextension'),
			    'FILE_SIZE' => postData($file, 'filesize'),
			    'FILE_PATH' => postData($file, 'uploadpath'),
			    'ATTACHMENT_STATUS' => 'Y',
			];
                      //echo '<pre>';print_r($updateUploadData);exit;
                        //$remove = $this->db->delete(INCIDENT_NOTIFY_ATTACHMENT, ['INC_NOTIFY_ID' => $incId]);
                        //echo $this->db->last_query();exit;
			$FileUpID = $this->common_model->updateInfo(INC_NOTIFY_ATTACH, $updateUploadData, 'PTW_SEC_ATT_ID');
		    }
		}
	    }
	    /* photos upload end */
	    /* Initial Notification to HSSE Team */
	    if ($editId == 0) {
		$optWhr['where'] = [
		    'INCIDENT_ID' => $incId
		];
		$optWhr['return_type'] = 'row';
		$editData = $this->common_model->getAlldata(INC_NOTIFY_INFO, ['*', 'FN_DATE_FORMAT(EVENT_DATE) as eventDate', 'FN_GET_LOCATION(LOCATION_ID) as locName'], $optWhr);
		//echo '<pre>';print_r($editData);exit;
                
                $incTemp = str_replace('{notify_id}', postData($editData, 'INCIDENT_ID'), $newIncidentTemplate);
		$incTemp = str_replace('{event_date}', postData($editData, 'eventDate'), $incTemp);
		$incTemp = str_replace('{event_time}', postData($editData, 'EVENT_TIME'), $incTemp);
		$incTemp = str_replace('{location_name}', postData($editData, 'locName'), $incTemp);
		$incTemp = str_replace('{specific_loc_name}', postData($editData, 'locName'), $incTemp);
		$incTemp = str_replace('{event_related_to}', postData($editData, 'locName'), $incTemp);
		$incTemp = str_replace('{event_type}', postData($editData, 'locName'), $incTemp);
		$incTemp = str_replace('{event_desc}', $eventTime, $incTemp);
		$incTemp = str_replace('{report_name}', $eventTime, $incTemp);
		$incTemp = str_replace('{designation_name}', $eventTime, $incTemp);
	    }
            
             
	$subject = 'New Incident has been notified with following details :';
        $roldId = '6';
        $MailProcessing = $this->incident_model->getHsseEmail($roldId);

         $userTypeId= ['6'];
        $aemail_id = $this->getIncidentEmailDetails($userTypeId);
        

        if($aemail_id != FALSE){

            foreach($aemail_id as $emKey => $emVal){
                $getEmaildata[] = postData($emVal,'emailList');
                $getNotifydata[] = postData($emVal,'notifyidList');
            }
            //  $emailIds = "hidayat@lumutport.com,rusly@lumutport.com,izudin@lumutport.com,mahesan@lumutport.com,mohdadrin@lumutport.com,asrul@lumutport.com,rafidah@lumutport.com,ganesan.k@lumutport.com,lwtan@lumutport.com,huda@lumutport.com,musalizam@lumutport.com,sulaiman@lumutport.com,taufik@lumutport.com,sudersh@lumutport.com,umesh@lumutport.com";
            $emailIds = "praveenkumar.k@ardhas.com,sarathkumar.sv@ardhas.com";
			// $notify_email_id = implode(',',$getEmaildata);
			// $notify_email_id = implode(',', $getEmaildata) . ',' . $emailIds;

			// print_r($notify_email_id);
			// exit;
			$dbEmails      = explode(',', implode(',', $getEmaildata));
			$manualEmails  = explode(',', $emailIds);

			$allEmails = array_merge($dbEmails, $manualEmails);
			$allEmails = array_map('trim', $allEmails);     
			$allEmails = array_unique($allEmails);          

			$notify_email_id = implode(',', $allEmails);
			// $notify_email_id=

			// print_r($notify_email_id);
			// exit;
            $notify_id = implode(',',$getNotifydata);

            // $implMail = (count($aemail_id->emailList) >0 ) ? implode(',', $aemail_id->emailList) : "";
            // $implNotiid = (count($aemail_id->notifyidList) >0 ) ? implode(',', $aemail_id->notifyidList) : "";

            // $notify_email_id = $implMail;
            // $notify_id = $implNotiid;
        }

        

        //$eveTypeIds = implode(',',$_POST['eventType']);
        //echo 'M<pre>';print_r($getss);exit;
        $eventTypeDt = $this->incident_model->getEventTypes1($eventType,$getsss);
       // echo 'M<pre>';print_r($eventTypeDt);exit;
        // foreach($MailProcessing as $m){
            
        // $HSSEDts =  $this->incident_model->getHSSEDtsEmail($m['USERNAME'] , $dpt = ''  , $desn = '');
        
       
        // foreach ($HSSEDts as $h){
            // $i = '1';
        //foreach($eventTypeDt as $e){
        // $toemail = $h['emailId'];
       
        $LocationName = $this->incident_model->getLocationName($_POST['eventLocation'],$_POST['specificLocation']);
       // echo '<pre>';print_r($LocationName);exit; 
        
        $IncidentStatus = 'New Incident';
        
        $eventDatee = date('d-m-Y',strtotime($eventDate));

        
        $specificLocation = $_POST['specificLocation'];
        if($specificLocation == '-1'){
        	$specLocName = 'Other';
        }
        else{
        	$specLocName = $LocationName['SPECIFIC_LOC_NAME'];
        }
        $idss = decryptval($id);
        
        
        $iddd = $notifyId;
        $idddd = encryptval($iddd);   
        //echo 'A<pre>';print_r($idddd);exit;
       
        
        if($idss == ''){
           $ids =  $notifyId;
           $idsss = $idddd;
           
        }
        else{
            $ids = $idss;
            $idsss = $id;
        }
        
        $message =  'New Incident has been notified with following details :'.'<br>'.'<br>'.'<br>'.
                
                
                    'Notification No             :  ' .$ids .'<br>'.
                    'Event Date                  :  ' .$eventDatee  .'<br>'.
                    'Event Time                  :  ' .$eventTime  .'<br>'.
                    'Location                    :  ' .$LocationName['TERMINAL_SHORTNAME']  .'<br>'.
                    'Specific Location           :  ' .$specLocName  .'<br>'.
                    'Event Type                  :  ' .$eventTypeDt['EVENT_TYPE_NAME'].'<br>'.
                    'Event Description           :  ' .$_POST['description']  .'<br>'.
                    'Incident Status             :  ' .$IncidentStatus  .'<br>'.
                    'Reported By                 :  ' .$_POST['reported_name']  . '  -  '  . $_POST['reported_desgn'] .'<br>';
                
                
                
              //  ;
        
         
        
       //  $tempdata = array(
       //              'view_file' => 'common/email/Notification_mail',
       //              'messageText' => $message,
       //              'footerText' => ''
                   
       //  );
       
       // $template = $this->template->load_email_template($tempdata); 
        
       // // $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
       // $this->email_model->sendEmail($notify_email_id, $subject, $template, $file = "");

                    $emailData = [
            'email' => $notify_email_id,
//            'email' => $emailId,
            'subject' => $subject,
            'message' => $message,
        ];

 $this->sendNotificationEmail($emailData);
       
       $notifyUrl = 'incident/investCheck/'.$idsss;
       
       
        $notifydata = [
            'text' => $message,
            'url' => $notifyUrl,
            'type' => '1',
           // 'notifygroup' => $h['EMP_AUTO_ID'], 
           // 'employee' => $m['LOGIN_ID'],
            'employee' => $notfiy_id,
            'mobilelink' => '',
          ];
          insertNotifications($notifydata);
          // $i ++;
        //}exit;
        // }
        // }//exit;
        
         // echo '<pre>';print_r($notifyUrl);exit;
           if($id !=''){
           $succMsg = 'Updated';
           $editIdd = decryptval($id);
         }
         else{
           $succMsg = 'Created';
           $editIdd = $notifyId;
         }




	    /* Initial Notification to HSSE Team */
        $this->session->set_flashdata("incflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Incident ' . $editIdd . '  '.$succMsg.' successfully</div>');

	    redirect('incident/');   

	
	} else {
	    $this->initialForm($id, $postDatas);
	}
       // redirect('incident/');
    }


public function sendNotificationEmail($data = []) {
   //  echo "<pre>";
   // print_r($data);exit;
    $ci = &get_instance();
    $ci->load->model('Email_model');
    $subject = isset($data['subject']) ? $data['subject'] : '';
    $toemail = isset($data['email']) ? $data['email'] : '';
    $message = isset($data['message']) ? $data['message'] : '';

    $tempdata = array(
        'view_file' => 'common/email/common_mail',
        'messageText' => $message,
        'footerText' => '' 
    );
    $template = $ci->template->load_email_template($tempdata);
    return $ci->email_model->sendEmail($toemail, $subject, $template, $file = "");
}

public  function getIncidentEmailDetails($ids,$type='USERTYPE'){
    $ci = &get_instance();
    $options['join'] = [
       // 'LOGIN_DETAILS AS LD'=>['LD.USER_DESINATION_ID = EMP.EMP_DESIGNATION_ID' ,'INNER']
        'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = EMP.EMP_AUTO_ID' ,'INNER']
        
    ];
    $options['return_type'] = 'result';
    $options['where'] = ['USER_LOG_STATUS'=> 'Y'];
    if($type == 'USERTYPE'){
       
         $options['where_in'] = ['USER_TYPE_ID'=> $ids];
         $options['group_by'] = [
            'DESC'=>'LD.USER_TYPE_ID'
         ];
    }else{
       $options['where_in'] = ['LOGIN_ID'=> $ids];

    }
    
     $details = $ci->common_model->getAlldata('EMPLOYEE_MANAGEMENT as EMP', ['GROUP_CONCAT( DISTINCT EMP_EMAIL_ID) as emailList','GROUP_CONCAT( DISTINCT LOGIN_ID) as notifyidList'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
   // echo "<pre>";
   //  echo $ci->db->last_query();exit;
     return $details;
}    

    public function investRequired($id = "") {
	if ($id != "") {
	    $nid = decryptval($id);
            //echo '<pre>';print_r($_POST);exit; 
	    $optWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => $nid
	    ];
	    $optWhr['return_type'] = 'row';
	    $editData = $this->common_model->getAlldata(INC_NOTIFY_INFO, ['*', 'FN_DATE_FORMAT(EVENT_DATE) as eventDate'], $optWhr);
	    if ($editData) {
		$update = [
		    'INVEST_ENABLE' => 'Y',
		    //
		];
		$updateWhere = [
		    'INCIDENT_ID' => $_POST['INCIDENT_ID']
		];
                if($_POST['INVESTIGATION_ACTION'] == '1'){
			$status = '5';
                        $NOT_REQUIRED_REASON = null;
                        $INVESTIGATION_ACTION = '1';
                        $SEND_TO_ATAR_FROM = null;
		}else if($_POST['INVESTIGATION_ACTION'] == '2'){
			$status = '3';
                        $NOT_REQUIRED_REASON = $_POST['NOT_REQUIRED_REASON'];
                        $INVESTIGATION_ACTION = '2';
                        $SEND_TO_ATAR_FROM = '1';
		}
		else{
			$status = '2';
                        $NOT_REQUIRED_REASON = null;
                        $INVESTIGATION_ACTION = '0';
                        $SEND_TO_ATAR_FROM = null;
		}
		$updateInitialData = [
			'INVESTIGATION_ACTION' => $INVESTIGATION_ACTION,
			'SEND_TO_ATAR_FROM' => $SEND_TO_ATAR_FROM,
                        'NOT_REQUIRED_REASON' => $NOT_REQUIRED_REASON,
                        'STATUS' => $status
		];
		$updates = $this->common_model->updateInfo(INCIDENT_NOTIFICATION_DETAILS, $updateInitialData, 'INCIDENT_ID', $updateWhere);
               // echo $this->db->last_query();exit;
//                echo '<pre>';print_r($updates);exit; 
		$this->session->set_flashdata("incflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Incident ' . $notifyId . ' Notified successfully</div>');

		if($_POST['INVESTIGATION_ACTION'] == '0'){
//                    if($id == ''){
//                    $getss = $notifyId; 
//                    $getsss = encryptval($notifyId);
//                }
//                else{
//                   $getss = decryptval($id); 
//                   $getsss = $id;
//                }
		// Active Table ( User Audits )
		 $user_data['USER_ID']=$_SESSION['id'];
		 $user_data['INCIDENT_NOTIFY_ID_DECRYPT']=$id;
		 $user_data['ID'] = $_SESSION['name'];
		 $user_data['INCIDENT_NOTIFY_ID']=$nid;
                $user_data['MODULE']='Incident Notification';
                $user_data['PROCESS']='Irreverent';
                $details = serialize($personData);
                $user_data['VALUE']="Incident Notification".$details;
                $userAudit = $this->incident_model->InsertActiveofUserAudit($user_data);
                $this->session->set_flashdata("incflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Incident/ Detail investigation Closed - Successfully! </div>');
			redirect('incident/');
		}
		else if($_POST['INVESTIGATION_ACTION'] == '1'){
                  // echo 1;exit; 
                $notifyIdss = substr($nid,4);
                $notifyId = 'INV-' . $notifyIdss;
                //echo '<pre>';print_r($notifyId);exit; 
                //$notifyId = uniqueIntRefId($prefix, INC_NOTIFY_INFO, 'INCIDENT_ID', 'INCIDENT_ID');
                //echo 'M<pre>';print_r($notifyId);exit; 
                
               $ids = decryptval($id); 
               $updateReportId = $this->incident_model->UpdateNotifyReportId($ids,$notifyId); 
               
                 $user_data['USER_ID']=$_SESSION['id'];
		 $user_data['INCIDENT_NOTIFY_ID_DECRYPT']=$id;
		 $user_data['ID'] = $_SESSION['name'];
		 $user_data['INCIDENT_NOTIFY_ID']=$ids;
                 $user_data['MODULE']='Incident Notification';
                 $user_data['PROCESS']='Detail Investigation Required ';
                 $details = serialize($personData);
                 $user_data['VALUE']="Incident Notification".$details;
                 $userAudit = $this->incident_model->InsertActiveofUserAudit($user_data);
               
//               $update
              
        $subject = 'New Incident has been notified with following details :';
       
        $getNotifyDetails = $this->incident_model->getAllNotify($ids);
        //echo '<pre>';print_r($getNotifyDetails);exit;
        $roldId = '7,6,5,9';
        $MailProcessing = $this->incident_model->getHsseEmail($roldId);
        //echo '<pre>';print_r($MailProcessing);exit; 
        foreach($MailProcessing as $m){
           // $dpt = '1';
           // echo '<pre>';print_r($m);exit;
          $HSSEDts =  $this->incident_model->getHSSEDtsEmail($m['USERNAME'] , $dpt ='' , $desn = '');
         // echo 'M<pre>';print_r($HSSEDts);exit;
          foreach($HSSEDts as $h){
          
          $toemail = $h['emailId']; 
        //echo '<pre>';print_r($toemail);exit;
       // echo '<pre>';print_r($HSSEDts);
        $LocationName = $this->incident_model->getLocationName($getNotifyDetails['LOCATION_ID'],$getNotifyDetails['SPECIFIC_LOCATION_ID']);
        //echo 'M<pre>';print_r($LocationName);exit;
	$eventTypeDt = $this->incident_model->getEventTypes1($getNotifyDetails['EVENT_TYPE_IDS'],$id);
                                                                                $IncidentStatus = 'Detailed Investigation Required';
									        $eventDate = date('d-m-Y',strtotime($getNotifyDetails['EVENT_DATE']));
//									
									        $specificLocation = $getNotifyDetails['specificLocation'];
									        if($specificLocation == '-1'){
									        	$specLocName = 'Other';
									        }
									        else{
									        	$specLocName = $LocationName['SPECIFIC_LOC_NAME'];
									        }

$newspecificLocation = $getNotifyDetails['SPECIFIC_LOCATION_ID'];
                                             if($newspecificLocation == '-1'){
                                                $newspecLocName = 'Other';
                                            }
                                            else{
                                                $newspecLocName = $LocationName['SPECIFIC_LOC_NAME'];
                                            }
									        
									            
									        $message = 'New Incident has been notified with following details :' .'<br>'.'<br>'.'<br>'.
                                                                                        
                                                                                        
                                                                                        
                                                                                        
                                                                                            'Notification No             :  ' .$notifyId .'<br>'.
									                    'Event Date                  :  ' .$eventDate  .'<br>'.
									                    'Event Time                  :  ' .$getNotifyDetails['EVENT_TIME']  .'<br>'.
									                    'Location                    :  ' .$LocationName['TERMINAL_SHORTNAME']  .'<br>'.
									                    'Specific Location           :  ' .$newspecLocName  .'<br>'.
                                                                                            'Event Type                  :  ' .$eventTypeDt['EVENT_TYPE_NAME'].'<br>'.
									                    'Event Description           :  ' .$getNotifyDetails['EVENT_DESC']  .'<br>'.
									                    'Incident Status             :  ' .$IncidentStatus  .'<br>'.
									                    'Reported By                 :  ' .$getNotifyDetails['EVENT_REPORT_NAME']  . '  -  '  . $getNotifyDetails['EVENT_REPORT_DESIGNATION'] .'<br>'
									                    ;

									                    									                
									                
									                
									              //  ;
									        
									         
									        
									        $tempdata = array(
									                    'view_file' => 'common/email/Notification_mail',
									                    'messageText' => $message,
									                    'footerText' => ''
									                   
									        );
									       
									       $template = $this->template->load_email_template($tempdata); 
                                                                               $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
       
       $notifyUrl = 'incident/ViewList/'.$id;
       
       
        $notifydata = [
            'text' => $message,
            'url' => $notifyUrl,
            'type' => '1',
            'notifygroup' => $h['EMP_AUTO_ID'],
           'employee' => $m['LOGIN_ID'],
            'mobilelink' => '',
          ];
          insertNotifications($notifydata);
          }
        }
        //  $id = decryptval($notifyId);
          $this->session->set_flashdata("incflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Incident/ Detail investigation Required - Successfully! </div>');
	  redirect('incident/investigate/'.$id);
		}
		else{
                 $user_data['USER_ID']=$_SESSION['id'];
		 $user_data['INCIDENT_NOTIFY_ID_DECRYPT']=$id;
		 $user_data['ID'] = $_SESSION['name'];
		 $user_data['INCIDENT_NOTIFY_ID']=decryptval($id);
                 $user_data['MODULE']='Incident Notification';
                 $user_data['PROCESS']='Detail Investigation NotRequired';
                 $details = serialize($personData);
                 $user_data['VALUE']="Incident Notification".$details;
                 $userAudit = $this->incident_model->InsertActiveofUserAudit($user_data);

            redirect('incident/SendToATARDetails/'.$id);
		}

	    } 

	    
	} 
	   else {
	    redirect('incident/');
	}
    }

    public function investigations() {
        $notifyStatusList = $this->incident_model->getnotifyStatusList();
	$data = array(
	    'pageTitle' => 'Incident/Accident Investigation',
	    'view_file' => 'incident/investigation/list',
	    'site_title' => 'Incident/Accident Investigation',
	    'current_menu' => 'List Incident/Accident Investigation',
	    'ajaxurl' => 'incident/list_notify?type=invest',
            'notifyStatusList' => $notifyStatusList,
	);

	$this->template->load_table_template($data);
    }

    public function investigate($id = "") {
    	
	if ($id == "") {
	    redirect('incident/investigations');
	} else {

	    $sessiondata = getCurrentUserDetails();
	    $role_id = $this->session->role_id;
	    $backUrl = BASE_URL . 'incident/';

	    /* masters start */
	    $reWhr['where'] = [
		'INCIDENT_EVENT_STATUS' => 'Y'
	    ];
	    $reWhr['return_type'] = 'result';
	    $getEventRelate = $this->common_model->getAlldata(INC_EVENT_RELATE, ['*'], $reWhr);
	    $typeWhr['where'] = [
		'EVENT_TYPE_STATUS' => 'Y'
	    ];
	    $typeWhr['return_type'] = 'result';
	    $getEventType = $this->common_model->getAlldata(INC_EVENT_TYPE, ['*'], $typeWhr);
	    $EventTypeArray = customFormDropDown($getEventType, 'EVENT_TYPE_ID', 'EVENT_TYPE_NAME');
	    $loWhr['where'] = [
		'TERMINAL_STATUS' => 'Y'
	    ];
	    $loWhr['return_type'] = 'result';
	    $getLoc = $this->common_model->getAlldata(LOCATION, ['*'], $loWhr);
	    $LocArray = customFormDropDown($getLoc, 'TER_AUTO_ID', 'TERMINAL_SHORTNAME', 'Select Location');
	    $spWhr['where'] = [
		'SPECIFIC_LOC_STATUS' => 'Y'
	    ];
	    $spWhr['return_type'] = 'result';
	    $getSpecLoc = $this->common_model->getAlldata(SPECIFIC_LOCATION, ['*'], $spWhr);
	    $specLocArray = customFormDropDown($getSpecLoc, 'SL_AUTO_ID', 'SPECIFIC_LOC_NAME', 'Select Location');
	    /* masters end */

	    $optWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => decryptval($id)
	    ];
	    $optWhr['return_type'] = 'row';
	    $editData = $this->common_model->getAlldata(INC_NOTIFY_INFO, ['*', 'FN_DATE_FORMAT(EVENT_DATE) as eventDate'], $optWhr);
	    $incid = postData($editData, 'INCIDENT_ID');
	    $optattWhr['where'] = [
		'INC_NOTIFY_ID' => $incid
	    ];
	    $optattWhr['return_type'] = 'result';
	    $editData->notifyAttachments = $this->common_model->getAlldata(INCIDENT_NOTIFY_ATTACHMENT, ['CONCAT(FILE_PATH,FILE_NAME) as fileset'], $optattWhr);
	    $optattWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => $incid
	    ];
	    $optattWhr['return_type'] = 'result';
	    $editData->persons = $this->common_model->getAlldata(INC_NOTIFY_PERSON, ['*'], $optattWhr);
	    $invWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => $incid
	    ];
	    $invWhr['return_type'] = 'row';
	    $investData = array();
	

		// echo $this->db->last_query();
		// exit;
	
		$employeeNameDetails = $this->incident_model->getEmployeeNames();
	    $bodyPartMainData = $this->incident_model->getbodyPartMainData();
            $subBodyPartDts = $this->incident_model->getSubPartMainData();
            //echo '<pre>';print_r($subBodyPartDts);exit;
	    $InvestigationId = $this->incident_model->getInvestigationId($id);
            //echo 'MA<pre>';print_r($id);
            $justId = $id;
	    $detail = $this->incident_model->getEmployeeDetails($InvestigationId['INCIDENT_INVESTIGATION_ID'],$justId='');
            //echo 'MA<pre>';print_r($id);exit; 
	    $checkClassify = explode(',', $detail['IncidentInvestigationData']['INC_CLASSIFICATION']);
	    $New_start_index = '1'; 
	    $incidentClassification = $this->incident_model->getClassificationDetails();
    	    
            $empIdGets = $this->incident_model->getempIdGets($editData->EVENT_REPORTED_BY);
	    //echo '<pre>';print_r($detail);exit;
            //echo 'MS<pre>';print_r($id);exit; 
	    $data = array(
		'view_file' => 'incident/investigation/invest',
		'title' => 'Incident/Accident Investigation',
		'current_menu' => 'Incident/Accident Investigation',
		'userDetails' => $sessiondata,
		'editData' => $editData,
		'investData' => $investData,
		'getEventRelate' => $getEventRelate,
		'getEventType' => $EventTypeArray,
		'getLoc' => $LocArray,
		'getSpecLoc' => $specLocArray,
		'role_id' => $role_id,
		'backUrl' => $backUrl,
		'detail' => $detail,
		'employeeNameDetails' => $employeeNameDetails,
		'bodyPartMainData' => $bodyPartMainData,
                'subBodyPartDts' => $subBodyPartDts,
		'checkClassify' => $checkClassify,
		'incidentClassification' => $incidentClassification,
		'detailcircumstanceDetails' => $detailcircumstanceDetails,
		'id' => $id,
                'empIdGets' =>$empIdGets,
		'headerfiles' => [
		    'css' => [
			'assets/plugins/clockpicker/clockpicker.css'
		    ],
		    'js' => [
			'assets/plugins/clockpicker/clockpicker.js'
		    ],
		    'priority' => 'high'
		]
	    );
        //    echo '<pre>';print_r($data);exit;

	    $this->template->load_common_template($data);
	}
    }
    
       public function investCheck($id = ""){
   	$editData = [];
	if ($id != '') {
	    $optWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => decryptval($id)
	    ];
	    $optWhr['return_type'] = 'row';
	    $editData = $this->common_model->getAlldata(INC_NOTIFY_INFO, ['*', 'FN_DATE_FORMAT(EVENT_DATE) as eventDate'], $optWhr);
	    $incid = postData($editData, 'INCIDENT_ID');
	    $optattWhr['where'] = [
		'INC_NOTIFY_ID' => $incid
	    ];
	    $optattWhr['return_type'] = 'result';
	    $editData->notifyAttachments = $this->common_model->getAlldata(INCIDENT_NOTIFY_ATTACHMENT, ['CONCAT(FILE_PATH,FILE_NAME) as fileset'], $optattWhr);
	    $optattWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => $incid
	    ];
	    $optattWhr['return_type'] = 'result';
	    $editData->persons = $this->common_model->getAlldata(INC_NOTIFY_PERSON, ['*'], $optattWhr);
	}
	$this->initialForms($id, $editData);
   }

   function initialForms($id = "", $editData = []) {
    	//echo 2;exit;
	$sessiondata = getCurrentUserDetails();
	$role_id = $this->session->role_id;
	$backUrl = BASE_URL . 'incident';
	$reWhr['where'] = [
	    'INCIDENT_EVENT_STATUS' => 'Y'
	];
	$reWhr['return_type'] = 'result';
	$getEventRelate = $this->common_model->getAlldata(INC_EVENT_RELATE, ['*'], $reWhr);
	$typeWhr['where'] = [
	    'EVENT_TYPE_STATUS' => 'Y'
	];
	$typeWhr['return_type'] = 'result';
	$getEventType = $this->common_model->getAlldata(INC_EVENT_TYPE, ['*'], $typeWhr);
	$EventTypeArray = customFormDropDown($getEventType, 'EVENT_TYPE_ID', 'EVENT_TYPE_NAME');
	$loWhr['where'] = [
	    'TERMINAL_STATUS' => 'Y'
	];
	$loWhr['return_type'] = 'result';
	$getLoc = $this->common_model->getAlldata(LOCATION, ['*'], $loWhr);
	$LocArray = customFormDropDown($getLoc, 'TER_AUTO_ID', 'TERMINAL_SHORTNAME', 'Select Location');
	$spWhr['where'] = [
	    'SPECIFIC_LOC_STATUS' => 'Y'
	];
	$spWhr['return_type'] = 'result';
	$getSpecLoc = $this->common_model->getAlldata(SPECIFIC_LOCATION, ['*'], $spWhr);
	$specLocArray = customFormDropDown($getSpecLoc, 'SL_AUTO_ID', 'SPECIFIC_LOC_NAME', 'Select Location');
	$data = array(
	    'view_file' => 'incident/incident/Viewnotification',
	    'title' => 'Incident Notification',
	    'current_menu' => 'Incident Notification',
	    'userDetails' => $sessiondata,
	    'editData' => $editData,
	    'role_id' => $role_id,
	    'getEventRelate' => $getEventRelate,
	    'getEventType' => $EventTypeArray,
	    'getLoc' => $LocArray,
	    'getSpecLoc' => $specLocArray,
	    'backUrl' => $backUrl,
	    'id' => $id,
	    'headerfiles' => [
		'css' => [
		    'assets/plugins/clockpicker/clockpicker.css'
		],
		'js' => [
		    'assets/plugins/clockpicker/clockpicker.js'
		],
		'priority' => 'high'
	    ]
	);

	$this->template->load_common_template($data);
    }
    
    public function SendToATARDetails( $id = ''){
// echo 1;exit;

// $uniqAtarwhr = [];
// $atarUniq = uniqueIntRefId('ATAR', 'ATAR_MAIN_FLOW', 'ATAR_AUTO_ID', 'ATAR_AUTO_ID', $uniqAtarwhr);


$idd = decryptval($this->input->post('investId'));
$capa = $this->input->post('attr_r');
$id = decryptval($id);
//echo 'M<pre>';print_r($idd);exit;
$getLocatDetails = $this->incident_model->getLocatDetails($id,$idd);
//echo 'M<pre>';print_r($getLocatDetails);exit;
$data = array();
$data['ATAR_TYPE_ID'] = '4';
$data['ATAR_REPORTER_TYPE_ID'] = $_SESSION['role_id'];
$data['ATAR_REPORTER_ID'] = $_SESSION['id'];
$data['ATAR_REPORTER_DESG_ID'] = $_SESSION['userinfo']->USER_DESINATION_ID;
$data['ATAR_LOC_ID'] = $getLocatDetails['LOCATION_ID'];
$data['ATAR_SPEC_LOC_ID'] = $getLocatDetails['SPECIFIC_LOCATION_ID'];
if($capa !=''){
$data['ATAR_INSP_INC_ID'] = $capa;
}else {
$data['ATAR_INSP_INC_ID'] = '';
}
if($data['ATAR_SPEC_LOC_ID'] == '-1'){
$data['ATAR_SPEC_LOC_OTHER'] = $getLocatDetails['SPECIFIC_LOCATION_OTHER'];
}
// else{
// $data['ATAR_SPEC_LOC_OTHER'] = null;
// }
$data['ATAR_REPORT_DATETIME'] = date('Y-m-d H:i:s');
$data['ATAR_INC_DESC_FINDING'] = $getLocatDetails['EVENT_DESC'];
if($getLocatDetails['NOT_REQUIRED_REASON'] != ''){
$data['ATAR_USEE_WHAT_RECCOM'] = $getLocatDetails['NOT_REQUIRED_REASON'];
}else{
$data['ATAR_USEE_WHAT_RECCOM'] = $this->input->post('activePreventive');
}
$data['ATAR_APP_STATUS'] = '1';
$data['ATAR_STATUS'] = 'Y';
$id = $getLocatDetails['LOCATION_ID'];
$userType = getCurrentUserGroupId();
$module = 'INC';

$locName = getLocationShorName($id);

$atarId = getAtarNumber($module,$locName,$id);
//echo 'M<pre>';print_r($atarId);exit;
$data['ATAR_ID'] = $atarId;

$INCIDENT_ID = $getLocatDetails['INCIDENT_ID'];
 $PrimUpdateId = $this->incident_model->updatePrimaryId($this->input->post('attr_oldcapa'),$capa);

if($PrimUpdateId == ''){
//echo "aaaa";exit;
$ATTR_MailFlow = $this->incident_model->InsertATTRMainDetails($data);
}else {
//echo "hhh";exit;
$ATTR_MailFlow = $this->incident_model->UpdateATTRMainDetails($data,$capa);
}

$deleteChileDetail = $this->incident_model->DeleteATTRUpload($ATTR_MailFlow);

$imgDetail = $this->incident_model->getUploadDetails($INCIDENT_ID);
//echo '<pre>';print_r($imgDetail);exit;


if(isset($imgDetail)){
foreach ($imgDetail as $im) {
//echo '<pre>';print_r($im);exit;
$result['FK_ATAR_MAIN_ID'] = $ATTR_MailFlow;
$result['ATAR_FILENAME'] = $im['FILE_NAME'];
$result['ATAR_FILETYPE'] = $im['FILE_TYPE'];
$result['ATAR_FILE_EXT'] = $im['FILE_EXT'];
$result['ATAR_FILE_SIZE'] = $im['FILE_SIZE'];
$result['ATAR_FILE_PATH'] = $im['FILE_PATH'];
$result['ATAR_ATTACH_STATUS'] = 'Y';


$UploadDetailToATAR = $this->incident_model->UpdateATARUploadDetail($result);

$nid = decryptval($id);
$optWhr['where'] = [
'INCIDENT_NOTIFY_ID' => $nid
];
$optWhr['return_type'] = 'row';
$editData = $this->common_model->getAlldata(INC_NOTIFY_INFO, ['*', 'FN_DATE_FORMAT(EVENT_DATE) as eventDate'], $optWhr);
if ($editData) {
$update = [
'INVEST_ENABLE' => 'Y',
//
];

}
}
}
$updtProfile = $ATTR_MailFlow;
sendAtarNotification($updtProfile);
redirect('incident');

}
     public function ViewList($id = ""){
    	if ($id == "") {
	    redirect('incident/');
	} else {

	    $sessiondata = getCurrentUserDetails();
	    $role_id = $this->session->role_id;
	    $backUrl = BASE_URL . 'incident/investigations';

	    /* masters start */
	    $reWhr['where'] = [
		'INCIDENT_EVENT_STATUS' => 'Y'
	    ];
	    $reWhr['return_type'] = 'result';
	    $getEventRelate = $this->common_model->getAlldata(INC_EVENT_RELATE, ['*'], $reWhr);
	    $typeWhr['where'] = [
		'EVENT_TYPE_STATUS' => 'Y'
	    ];
	    $typeWhr['return_type'] = 'result';
	    $getEventType = $this->common_model->getAlldata(INC_EVENT_TYPE, ['*'], $typeWhr);
	    $EventTypeArray = customFormDropDown($getEventType, 'EVENT_TYPE_ID', 'EVENT_TYPE_NAME');
	    $loWhr['where'] = [
		'TERMINAL_STATUS' => 'Y'
	    ];
	    $loWhr['return_type'] = 'result';
	    $getLoc = $this->common_model->getAlldata(LOCATION, ['*'], $loWhr);
	    $LocArray = customFormDropDown($getLoc, 'TERMINAL_SHORTNAME', 'TERMINAL_SHORTNAME', 'Select Location');
	   // echo '<pre>';print_r($LocArray);exit;
	    $spWhr['where'] = [
		'SPECIFIC_LOC_STATUS' => 'Y'
	    ];
	    $spWhr['return_type'] = 'result';
	    $getSpecLoc = $this->common_model->getAlldata(SPECIFIC_LOCATION, ['*'], $spWhr);
	    $specLocArray = customFormDropDown($getSpecLoc, 'SL_AUTO_ID', 'SPECIFIC_LOC_NAME', 'Select Location');
	    /* masters end */

	    $optWhr['where'] = [ 
		'INCIDENT_NOTIFY_ID' => decryptval($id)
	    ];
	    $optWhr['return_type'] = 'row';
	    $editData = $this->common_model->getAlldata(INC_NOTIFY_INFO, ['*', 'FN_DATE_FORMAT(EVENT_DATE) as eventDate'], $optWhr);
	    $incid = postData($editData, 'INCIDENT_ID');
	    $optattWhr['where'] = [
		'INC_NOTIFY_ID' => $incid
	    ];
	    $optattWhr['return_type'] = 'result';
	    $editData->notifyAttachments = $this->common_model->getAlldata(INCIDENT_NOTIFY_ATTACHMENT, ['CONCAT(FILE_PATH,FILE_NAME) as fileset'], $optattWhr);
	    $optattWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => $incid
	    ];
	    $optattWhr['return_type'] = 'result';
	    $editData->persons = $this->common_model->getAlldata(INC_NOTIFY_PERSON, ['*'], $optattWhr);
	    $invWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => $incid
	    ];
	    $invWhr['return_type'] = 'row';
	    $investData = $this->common_model->getAlldata(INC_INVEST, ['*'], $invWhr);
	    $employeeNameDetails = $this->incident_model->getEmployeeNames();
	    $bodyPartMainData = $this->incident_model->getbodyPartMainData();
	    $InvestigationId = $this->incident_model->getInvestigationId($id);
            $justId = $id;
            $empIdGets = $this->incident_model->getempIdGets($editData->EVENT_REPORTED_BY);
	    $detail = $this->incident_model->getEmployeeDetails($InvestigationId['INCIDENT_INVESTIGATION_ID'],$justId);
            $classFyName = $this->incident_model->getclassFyName($detail['IncidentInvestigationData']['INC_CLASSIFICATION']);
            $UserPrepared = $this->incident_model->getUserPrepared($detail['IncidentInvestigationData']['PREPARED_BY'],$detail['IncidentInvestigationData']['REVIEWED_BY'],$detail['IncidentInvestigationData']['VERIFIED_BY'],$detail['IncidentInvestigationData']['APPROVED_BY']);


	    $UserReviewed = $this->incident_model->getUserReviewed($detail['IncidentInvestigationData']['PREPARED_BY'],$detail['IncidentInvestigationData']['REVIEWED_BY'],$detail['IncidentInvestigationData']['VERIFIED_BY'],$detail['IncidentInvestigationData']['APPROVED_BY']);
	    $UserVerified = $this->incident_model->getUserVerified($detail['IncidentInvestigationData']['PREPARED_BY'],$detail['IncidentInvestigationData']['REVIEWED_BY'],$detail['IncidentInvestigationData']['VERIFIED_BY'],$detail['IncidentInvestigationData']['APPROVED_BY']);
	    $UserApproved = $this->incident_model->getUserApproved($detail['IncidentInvestigationData']['PREPARED_BY'],$detail['IncidentInvestigationData']['REVIEWED_BY'],$detail['IncidentInvestigationData']['VERIFIED_BY'],$detail['IncidentInvestigationData']['APPROVED_BY']);
	    //echo '<pre>';print_r($UserReviewed);exit;
	    $checkClassify = explode(',', $detail['IncidentInvestigationData']['INC_CLASSIFICATION']);
	    $New_start_index = 1; 
	    $incidentClassification = $this->incident_model->getClassificationDetails();
    	
	   
	    $data = array(
		'view_file' => 'incident/investigation/viewList',
		'title' => 'Incident/View Investigation List',
		'current_menu' => 'Incident/View Investigation',
		'userDetails' => $sessiondata,
		'editData' => $editData,
		'investData' => $investData,
		'getEventRelate' => $getEventRelate,
		'getEventType' => $EventTypeArray,
		'getLoc' => $LocArray,
		'getSpecLoc' => $specLocArray,
		'role_id' => $role_id,
		'backUrl' => $backUrl,
		'detail' => $detail,
                'UserPrepared' => $UserPrepared,
		'UserReviewed'=> $UserReviewed,
		'UserVerified' => $UserVerified,
		'UserApproved' => $UserApproved,
		'employeeNameDetails' => $employeeNameDetails,
		'bodyPartMainData' => $bodyPartMainData,
                'subBodyPartDts' => $subBodyPartDts,
		'checkClassify' => $checkClassify,
		'incidentClassification' => $incidentClassification,
                'classFyName' => $classFyName,
		'detailcircumstanceDetails' => $detailcircumstanceDetails,
		'id' => $id,
                'empIdGets' => $empIdGets,
		'headerfiles' => [
		    'css' => [
			'assets/plugins/clockpicker/clockpicker.css'
		    ],
		    'js' => [
			'assets/plugins/clockpicker/clockpicker.js'
		    ],
		    'priority' => 'high'
		]
	    );

	    $this->template->load_common_template($data);
	}
    }
    public function ActivityList($id = ""){
        $nid = decryptval($id);
        $notifyIdss = substr($nid,4);
        $notifyId = 'INV-' . $notifyIdss;
       $activityList = $this->incident_model->getActivityTableList($id);
      // echo '<pre>';print_r($activityList);exit;
       $data = array(
	    'pageTitle' => 'Incident/Activity List',
	    'view_file' => 'incident/investigation/ViewActivitylist',
	    'site_title' => 'Incident/Activity List',
	    'current_menu' => 'List Incident/Accident Investigation',
	    'ajaxurl' => 'incident/ActivityList_notify',
	    'title' => 'Incident/Activity Audits',
	    'activityList' => $activityList,
	);

	$this->template->load_table_template($data);
    }
    public function investSave($id =""){
        //echo 'M<pre>';print_r($_FILES);
     //echo 'M<pre>';print_r($_POST);exit;  
        
    	 //ini_set('display_errors', 1);
         $createdOn = date('Y-m-d H:i:s');
         $updatedOn = date('Y-m-d H:i:s');

         $result = array();

         $result['INC_AUTHORITY_INVOLVED'] = $_POST['authorityInvol'];
         $result['AUTHORITY_INVOLVED_DETAIL'] = $_POST['authorityInvolved'];
         $result['INJURED_PERSON'] = $_POST['INCIDENT_COMPETENCY_ID'];
    	 $result['COMPETENCY_RECORDS'] = $_POST['description'];
	 $result['IMMEDIATE_CAUSES'] = $_POST['immuediateCause'];
    	 $result['POSSIBLE_ROOT_CAUSES'] = $_POST['possibleCause'];
    	 $result['CONTRIBUTE_CAUSAL_FACTOR'] = $_POST['contributingCause'];
    	 $result['HAZARD_RISK_IDENTIFY'] = $_POST['hazardRisk'];
    	 $result['ACCITENT_AVOIDABLE '] = $_POST['accidentAvoidab'];
    	 $result['INVEST_PROPOSED_ACTION'] = $_POST['recommendation'];
    	 $result['INCIDENT_NOTIFY_ID'] =  decryptval($id);
    	 $result['INCIDENT_WORK_RELATED'] = $_POST['workrelated'];
    	 $result['ACTIVITY'] = $_POST['activity'];
    	 $result['EMP_CONT'] = $_POST['empcont'];
    	 $CLASSFICATION_MST_ID = $_POST['CLASSFICATION_MST_ID'];
    	 if(isset($CLASSFICATION_MST_ID)){
    	 $result['INC_CLASSIFICATION'] = implode(',',$CLASSFICATION_MST_ID);
         }
    	 $result['INJURED_PERSON'] = $_POST['InjuredPer'];
    	 $result['ASSET_DETAILS'] = $_POST['assetDetails'];
    	 $result['INVESTIGATION_STATUS'] = 'Y';
    	 $result['CREATED_ON'] = $createdOn;
         $result['UPDATED_ON'] = $updatedOn;
        
         $result['SUMBIT_PROCESS'] = $_POST['SUMBIT_PROCESS'];
         //$result['PREPARED_BY'] = $_SESSION['id'];
	//$result['PREPARED_DATE'] = date('Y-m-d H:i:s');
         $result['REVIEWED_BY'] = '0';
$result['REVIEWED_DATE'] = null;
         $result['REVIEWED_REMARK'] = null;
         $result['REVIEWED_STATUS'] = 'R';
         $result['VERIFIED_BY'] = '0';
$result['VERIFIED_DATE'] = null;
         $result['VERIFIED_REMARK'] = null;
         $result['VERIFIED_STATUS'] = 'R';
         $result['APPROVED_STATUS'] = 'R';
         $result['APPROVED_BY'] = '0';
$result['APPROVED_DATE'] = null;
         $result['APPROVED_REMARK'] = null;
         $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_ID'];
    	
	$SubOptn['where'] = [
            'INCIDENT_NOTIFY_ID' => decryptval($id),
			'NOTIFY_STATUS' => 'Y',
        ];
	$SubOptn['return_type'] = 'row';
        $incid = $this->common_model->getAlldata('INCIDENT_NOTIFICATION_DETAILS', ['PREPARED_BY,PREPARED_DATE'],$SubOptn);
	$result['PREPARED_BY'] = $incid->PREPARED_BY;
	$result['PREPARED_DATE'] = $incid->PREPARED_DATE;




         $incidentInvesId = $this->incident_model->UpdateIncidentSpecificDetails($result);
         //echo '<pre>';print_r($incidentInvesId);exit; 

         $NotifyDetail = $this->incident_model->getNotifyTableData($id , $investId = "");
         //echo '<pre>';print_r($NotifyDetail);exit; 
         $datas = array();
         $datas['INCIDENT_ID'] = $NotifyDetail['INCIDENT_ID'];
         $datas['INCIDENT_NOTIFY_ID'] = $NotifyDetail['INCIDENT_NOTIFY_ID'];
         $datas['EVENT_DATE'] = $NotifyDetail['EVENT_DATE'];
         $datas['EVENT_TIME'] = $NotifyDetail['EVENT_TIME'];
         $datas['LOCATION_ID'] = $NotifyDetail['LOCATION_ID'];
         $datas['SPECIFIC_LOCATION_ID'] = $NotifyDetail['SPECIFIC_LOCATION_ID'];
         $datas['SPECIFIC_LOCATION_OTHER'] = $NotifyDetail['SPECIFIC_LOCATION_OTHER'];
         $datas['INCIDENT_INVESTIGATION_ID'] = $NotifyDetail['INCIDENT_INVESTIGATION_ID'];
         $datas['PREPARED_BY'] = $_SESSION['id'];
         $datas['CREATED_ON'] = $createdOn;
         $datas['UPDATED_ON'] = $updatedOn;

         $datas['INC_AUTHORITY_INVOLVED'] = $NotifyDetail['INC_AUTHORITY_INVOLVED'];
         $datas['AUTHORITY_INVOLVED_DETAIL'] = $NotifyDetail['AUTHORITY_INVOLVED_DETAIL'];
         $datas['INJURED_PERSON'] = $NotifyDetail['INJURED_PERSON'];
    	 $datas['COMPETENCY_RECORDS'] = $NotifyDetail['COMPETENCY_RECORDS'];
	     $datas['IMMEDIATE_CAUSES'] = $NotifyDetail['IMMEDIATE_CAUSES'];
    	 $datas['POSSIBLE_ROOT_CAUSES'] = $NotifyDetail['POSSIBLE_ROOT_CAUSES'];
    	 $datas['CONTRIBUTE_CAUSAL_FACTOR'] = $NotifyDetail['CONTRIBUTE_CAUSAL_FACTOR'];
    	 $datas['HAZARD_RISK_IDENTIFY'] = $NotifyDetail['HAZARD_RISK_IDENTIFY'];
    	 $datas['ACCITENT_AVOIDABLE '] = $NotifyDetail['ACCITENT_AVOIDABLE'];
    	 $datas['INVEST_PROPOSED_ACTION'] = $NotifyDetail['INVEST_PROPOSED_ACTION'];
    	 $datas['INCIDENT_WORK_RELATED'] = $NotifyDetail['INCIDENT_WORK_RELATED'];
    	 $datas['ACTIVITY'] = $NotifyDetail['ACTIVITY'];
    	 $datas['EMP_CONT'] = $NotifyDetail['EMP_CONT'];
    	 $datas['INC_CLASSIFICATION'] = $NotifyDetail['INC_CLASSIFICATION'];
    	 $datas['INJURED_PERSON'] = $NotifyDetail['INJURED_PERSON'];
    	 $datas['ASSET_DETAILS'] = $NotifyDetail['ASSET_DETAILS'];
         if($_POST['SUMBIT_PROCESS'] == '0'){
         $datas['CHANGES_PLACE'] = '0';
         }
         else{
         $datas['CHANGES_PLACE'] = '1';
         }
         $datas['PREPARED_BY'] = $_SESSION['id'];
         $datas['REVIEWED_BY'] = '0';
         $datas['REVIEWED_REMARK'] = null;
         $datas['REVIEWED_STATUS'] = 'R';
         $datas['VERIFIED_BY'] = '0';
         $datas['VERIFIED_REMARK'] = null;
         $datas['VERIFIED_STATUS'] = 'R';
         $datas['APPROVED_STATUS'] = 'R';
         $datas['APPROVED_BY'] = '0';
         $datas['APPROVED_REMARK'] = null;

         $insertHistory = $this->incident_model->insertHistoryForNotifyDetail($datas);

         $result =  array();
         $result['INCIDENT_ID'] = $_POST['INCIDENT_ID'];
         $result['EVENT_DATE']  = date('Y-m-d',strtotime($_POST['eventDate']));
         $result['EVENT_TIME'] = $_POST['eventTime'];
         $result['LOCATION_ID'] = $_POST['eventLocation'];
         $result['SPECIFIC_LOCATION_ID'] = $_POST['specificLocation'];
         $result['SPECIFIC_LOCATION_OTHER'] = $_POST['specificlocother'];
         if($_POST['STATUS_PROCESS'] != ''){
         $result['STATUS'] = $_POST['STATUS_PROCESS'];
         }
         $incidentInvesIddd = $this->incident_model->UpdateIncidentNotify($result);


    	
    	$n =isset($_POST['superiorDatas']) ? max(array_keys($_POST['superiorDatas'])) : 0;
        // $n =max(array_keys(isset($_POST['superiorDatas'])));
      // echo '<pre>';print_r($n);exit;
      
            for($i=0;$i<=$n;$i++)
            {
                if(isset($_POST['superiorDatas'][$i])&&$_POST['superiorDatas'][$i]!=''){
                	$createdOn = date('Y-m-d H:i:s');
                	$updatedOn = date('Y-m-d H:i:s');


                $result = array();
                $result['EMP_ID'] = $_POST['superiorDatas'][$i]['supEmployeeId'];
                $result['NAME'] = $_POST['superiorDatas'][$i]['supEmployeeName'];
                $result['PHONE'] = $_POST['superiorDatas'][$i]['mobile'];
                $result['PRESENT'] = $_POST['superiorDatas'][$i]['present'];
                $result['CREATED_ON'] = $createdOn;
                $result['UPDATED_ON'] = $updatedOn;
               // $result['INC_INVEST_ID'] = decryptval($id);
                
                $result['SUP_STATUS'] = 'Y';
                $result['INCIDENT_SUP_ID'] = $_POST['superiorDatas'][$i]['INCIDENT_SUP_ID'];
                $result['USER_REF_ID'] = $_SESSION['userinfo']->USER_REF_ID;
                $result['INC_INVEST_ID'] = $NotifyDetail['INCIDENT_INVESTIGATION_ID'];
                
                $this->incident_model->UpdateSupervisorDetail($result);

                }

               
            }

            //$n =max(array_keys($_POST['invesEmployeeInform']));
            $n =isset($_POST['invesEmployeeInform']) ? max(array_keys($_POST['invesEmployeeInform'])) : 0;
            
              
            for($i=0;$i<=$n;$i++)
            {
                if(isset($_POST['invesEmployeeInform'][$i])&&$_POST['invesEmployeeInform'][$i]!=''){
                	$createdOn = date('Y-m-d H:i:s');
                	$updatedOn = date('Y-m-d H:i:s');


                $result = array();
                if($_POST['invesEmployeeInform'][$i]['employeeInvesName'] !='0' && $_POST['invesEmployeeInform'][$i]['employeeInvesName']!=''){
                $result['EMP_NAME'] = $_POST['invesEmployeeInform'][$i]['employeeInvesName'];
                $result['EMP_ID'] = $_POST['invesEmployeeInform'][$i]['invesEmployeeid'];
                $result['DESIGNATION_ID'] = $_POST['invesEmployeeInform'][$i]['invesDesignationId'];
                $result['PHONE_NO'] = $_POST['invesEmployeeInform'][$i]['empMobile'];
                $result['INVESTIGATION_TEAM_SUMMARY'] = $_POST['innvesticationSum'];
                $result['CREATED_ON'] = $createdOn;
                $result['UPDATED_ON'] = $updatedOn;
               // $result['INC_INVEST_ID'] = decryptval($id);
                $result['INC_INVEST_ID'] = $NotifyDetail['INCIDENT_INVESTIGATION_ID'];
                $result['INVESTIGATION_TEAM_STATUS'] = 'Y';
                $result['INC_INVESTIGATION_TEAM_ID'] = $_POST['invesEmployeeInform'][$i]['INC_INVESTIGATION_TEAM_ID'];
                if(isset($_FILES['files']) && ($_FILES['files'] !='')){
                    //echo 1;exit;
                    $path = 'public/module/incident/UploadDocument/InvestTeam';
                    $target_dir = $_SERVER['DOCUMENT_ROOT'] ."/". $path;
                    //echo '<pre>';print_r($target_dir);exit; 
                    $upload_filename= $_FILES['files']['name'];
                    $file_type=$_FILES['files']['type'];
                    $file_size = $_FILES['files']['size'];
                    $file_ext=explode('.',$_FILES['files']['name']);
                    $file_ext = $file_ext['1'];
                    $filename = $path.'/'.$upload_filename;
                    $FILE_EXT = pathinfo($filename, PATHINFO_EXTENSION);
                    $tmp = $_FILES['files']['tmp_name'];
                    move_uploaded_file($tmp, $filename);   
                    $result['FILE_PATH'] = $path;
                    $result['FILE_NAME'] = $upload_filename; 
                }

               // $result['USER_REF_ID'] = $_SESSION['userinfo'];
                
                $this->incident_model->UpdateInvestigationTeam($result);

                }
                }

               
            }

           // $n =max(array_keys($_POST['injuredDatas']));
            $n =isset($_POST['injuredDatas']) ? max(array_keys($_POST['injuredDatas'])) : 0;
         
              
            for($i=0;$i<=$n;$i++)
            { 
                
                if(isset($_POST['injuredDatas'][$i])&&$_POST['injuredDatas'][$i]!=''){
                   
                	$createdOn = date('Y-m-d H:i:s');
                	$updatedOn = date('Y-m-d H:i:s');


                $result = array();
               // echo '<pre>';print_r($_POST['injuredDatas'][$i]['SubbodyPart']);exit;
               
                $result['PERSON_NAME '] = $_POST['injuredDatas'][$i]['injuredEmpName'];
                $result['SEX '] = $_POST['injuredDatas'][$i]['injuredGen'];
                $result['AGE'] = $_POST['injuredDatas'][$i]['age'];
                $result['JOB_TITLE'] = $_POST['injuredDatas'][$i]['jobTitle'];
                $result['CITIZENSHIP'] = $_POST['injuredDatas'][$i]['citizenship'];
                $result['ID_TYPE'] = $_POST['injuredDatas'][$i]['injuredIdType'];
                $result['IC_PASSPORT_NO'] = $_POST['injuredDatas'][$i]['passportNo'];
                $result['CONT_COMPANY_NAME'] = $_POST['injuredDatas'][$i]['injuredCompanyName'];
                $result['INJURY_TYPE'] = $_POST['injuredDatas'][$i]['InjuryType'];
                $result['BODY_PART_ID'] = $_POST['injuredDatas'][$i]['bodyPart'];
                $result['SUB_ID'] = $_POST['injuredDatas'][$i]['SubbodyPart'];
                $result['CREATED_ON'] = $createdOn;
                $result['UPDATED_ON'] = $updatedOn;
                $result['INC_INVEST_ID'] = $NotifyDetail['INCIDENT_INVESTIGATION_ID'];
                if($_POST['injuredDatas'][$i]['INVEST_INJURED_PERSON_STATUS'] !=''){
                 $result['INVEST_INJURED_PERSON_STATUS '] = $_POST['injuredDatas'][$i]['INVEST_INJURED_PERSON_STATUS'];
                }else{
                $result['INVEST_INJURED_PERSON_STATUS '] = 'Y';
                } 
                $result['INC_INVEST_INJURED_PERSON_INFO_ID'] = $_POST['injuredDatas'][$i]['INC_INVEST_INJURED_PERSON_INFO_ID'];
//                if(isset($_POST['injuredDatas'][$i]['SubbodyPart']) && $_POST['injuredDatas'][$i]['SubbodyPart'] !=''){ 
//                    $result['INVEST_INJURED_PERSON_STATUS '] = 'N';
//                }
//                else{
//                    $result['INVEST_INJURED_PERSON_STATUS '] = 'Y'; 
//                }
                    
                    
                $injuredId = $this->incident_model->UpdateInjuredPerson($result);
                }

                
            
               
        }
            

            //$n =max(array_keys($_POST['assetDatas']));
            $n =isset($_POST['assetDatas']) ? max(array_keys($_POST['assetDatas'])) : 0;
            //echo '<pre>';print_r($n);exit;
            for($i=0;$i<=$n;$i++)
            {
                if(isset($_POST['assetDatas'][$i])&&$_POST['assetDatas'][$i]!=''){

                	$createdOn = date('Y-m-d H:i:s');
                	$updatedOn = date('Y-m-d H:i:s');


                $result = array();
                $result['DESCRIPTION'] = $_POST['assetDatas'][$i]['assetDescription'];
                $result['NAME_OF_OPERATOR_DRIVER_MASTER'] = $_POST['assetDatas'][$i]['assetNameOfOperator'];
                $result['PHONE_NO'] = $_POST['assetDatas'][$i]['assetPhone'];
                $result['OWNER_COMP_NAME'] = $_POST['assetDatas'][$i]['assetOwner'];
                $result['PLATE_NO'] = $_POST['assetDatas'][$i]['assetPlate'];
                $result['EST_COST_OF_DAMAGE'] = $_POST['assetDatas'][$i]['assetEstimate'];
                $result['CREATED_ON'] = $createdOn;
                $result['UPDATED_ON'] = $updatedOn;
               // $result['INC_INVEST_ID'] = decryptval($id);
                $result['INCIDENT_INVEST_ID'] = $NotifyDetail['INCIDENT_INVESTIGATION_ID'];
                $result['ASSET_DETAIL_STATUS'] = 'Y';
                $result['INC_ASSET_DETAIL_ID'] = $_POST['assetDatas'][$i]['INC_ASSET_DETAIL_ID'];

               // $result['USER_REF_ID'] = $_SESSION['userinfo'];
                
                $this->incident_model->UpdateAssetDetail($result);

                }

               
            }


           // $n =max(array_keys($_POST['personDatas']));
            $n =isset($_POST['personDatas']) ? max(array_keys($_POST['personDatas'])) : 0;
              
            for($i=0;$i<=$n;$i++)
            {
                if(isset($_POST['personDatas'][$i])&&$_POST['personDatas'][$i]!=''){

                	$createdOn = date('Y-m-d H:i:s');
                	$updatedOn = date('Y-m-d H:i:s');


                $result = array();
                $result['EMP_ID'] = $_POST['personDatas'][$i]['perEmployeeId'];
                $result['EMP_NAME'] = $_POST['personDatas'][$i]['perEmployeeName'];
                $result['JOB_TITLE'] = $_POST['personDatas'][$i]['personJobTitle'];
                $result['PHONE'] = $_POST['personDatas'][$i]['personMobile'];
                $result['CREATED_ON'] = $createdOn;
                $result['UPDATED_ON'] = $updatedOn;
               // $result['INC_INVEST_ID'] = decryptval($id);
                
                $result['INTERVIEWED_DETAIL_STATUS'] = 'Y';
                $result['INVEST_INTERVIEWED_DETAIL_ID'] = $_POST['personDatas'][$i]['INVEST_INTERVIEWED_DETAIL_ID'];
                $result['INC_INVEST_ID'] = $NotifyDetail['INCIDENT_INVESTIGATION_ID'];

               // $result['USER_REF_ID'] = $_SESSION['userinfo'];
                
                $this->incident_model->UpdatePersonInterview($result);

                }
               
            }

            //$n =max(array_keys($_POST['activePlanDatas']));
            $n =isset($_POST['activePlanDatas']) ? max(array_keys($_POST['activePlanDatas'])) : 0;
              
            for($i=0;$i<=$n;$i++)
            {
                if(isset($_POST['activePlanDatas'][$i])&&$_POST['activePlanDatas'][$i]!=''){

                	$createdOn = date('Y-m-d H:i:s');
                	$updatedOn = date('Y-m-d H:i:s');


                $result = array();
                $result['CA_PA_DESC'] = $_POST['activePlanDatas'][$i]['activePreventive'];
                $result['RESPOSIBILITY_ID'] = $_POST['activePlanDatas'][$i]['activeResponName'];
                $Activedate = $_POST['activePlanDatas'][$i]['activeDate'];
                $result['DATE_BY_WHEN'] = date('Y-m-d',strtotime($Activedate));
                $result['CREATED_ON'] = $createdOn;
                $result['UPDATED_ON'] = $updatedOn;
               // $result['INC_INVEST_ID'] = decryptval($id);
                $result['INC_INVEST_ID'] = $NotifyDetail['INCIDENT_INVESTIGATION_ID'];
                $result['ACTION_PLAN_STATUS'] = 'Y';
                $result['ACTION_PLAN_ID'] = $_POST['activePlanDatas'][$i]['ACTION_PLAN_ID'];

               // $result['USER_REF_ID'] = $_SESSION['userinfo'];
                
                $this->incident_model->UpdateActivePlanDat($result);

                }

               
            }
            //echo '<pre>';print_r($_POST);exit;
            if(isset($_POST['circumstanceDatas'])){

            //$n =max(array_keys($_POST['circumstanceDatas']));
            $n =isset($_POST['circumstanceDatas']) ? max(array_keys($_POST['circumstanceDatas'])) : 0;
              
            for($i=0;$i<=$n;$i++)
            {
                if(isset($_POST['circumstanceDatas'][$i])&&$_POST['circumstanceDatas'][$i]!=''){

                	$createdOn = date('Y-m-d H:i:s');
                	$updatedOn = date('Y-m-d H:i:s');


                $result = array();
                $result['CIRCUMSTANCE_DESC'] = trim($_POST['circumstanceDatas'][$i]['circumDescrOne']);
                $result['CIRCUMSTANCE_DESC_TWO'] = $_POST['circumstanceDatas'][$i]['circumDescrTwo'];
                $result['CIRCUMSTANCE_DESC_THREE'] = $_POST['circumstanceDatas'][$i]['circumDescrThree'];
                $result['CIRCUMSTANCE_DESC_FOUR'] = $_POST['circumstanceDatas'][$i]['circumDescrFour'];
                $result['CIRCUMSTANCE_DESC_FIVE'] = $_POST['circumstanceDatas'][$i]['circumDescrFive'];
                $result['COUNT_COLUMN'] = $_POST['circumstanceDatas'][$i]['COUNT_COLUMN'];
                $result['CREATED_ON'] = $createdOn;
                $result['UPDATED_ON'] = $updatedOn;
               // $result['INC_INVEST_ID'] = decryptval($id);
                $result['INC_INVEST_ID'] = $NotifyDetail['INCIDENT_INVESTIGATION_ID'];
                $result['CIRCUMSTANCE_STATUS'] = 'Y';
                $result['INC_CIRCUMSTANCE_INFO'] = $_POST['circumstanceDatas'][$i]['INC_CIRCUMSTANCE_INFO'];

               // $result['USER_REF_ID'] = $_SESSION['userinfo'];
                
                $this->incident_model->UpdateCircumstance($result);

                }

               
            }
        }

            // echo 'M<pre>';print_r($_POST['AttachDatas']);exit;
            //$n =max(array_keys($_POST['AttachDatas']));
            $n =isset($_POST['AttachDatas']) ? max(array_keys($_POST['AttachDatas'])) : 0;

            $documents = $_FILES;
            for($i=0;$i<=$n;$i++)
            {
                if(isset($_POST['AttachDatas'][$i])&&$_POST['AttachDatas'][$i]!=''){
                	
						$path = 'public/module/incident/UploadDocument';
						$target_dir = $_SERVER['DOCUMENT_ROOT'] ."/". $path;
                        $flname = explode('.',$documents['AttachDatas']['name'][$i]['uploadFile']);
			 $upflname = $flname[0].'-'.date('Y-m-d h:i:s').'.'.$flname[1];
						
                        $upload_filename = $documents['AttachDatas']['name'][$i]['uploadFile'];
                       
                        $filename = $path . '/' . $upflname;
                        
                        $tmp = $documents['AttachDatas']['tmp_name'][$i]['uploadFile'];
                        // echo 'M<pre>';print_r($tmp);exit;
                        move_uploaded_file($tmp, $filename);
                        $val['file_name'] = $upflname;
                        $val['file_path'] = $path;

                        $createdOn = date('Y-m-d H:i:s');
                	    $updatedOn = date('Y-m-d H:i:s');
                	    $FILE_SIZE = $documents['AttachDatas']['size'][$i]['uploadFile'];
                	    $FILE_EXT = pathinfo($filename, PATHINFO_EXTENSION);
           
		                $result = array();
		                $result['FILE_PATH'] = $path;

		                if($upload_filename == ''){

		                	$result['FILE_ORG_FILENAME'] = $_POST['AttachDatas'][$i]['FILE_NAME'];
		                    $result['FILE_NAME'] = $_POST['AttachDatas'][$i]['FILE_NAME'];
		                    $result['FILE_SIZE'] = $_POST['AttachDatas'][$i]['FILE_SIZE'];
		                    $result['FILE_EXT'] = $_POST['AttachDatas'][$i]['FILE_EXT'];
		                }
		                else if($upload_filename != ''){
		                	$result['FILE_ORG_FILENAME'] = $upflname;
		                    $result['FILE_NAME'] = $upflname;
		                    $result['FILE_SIZE'] = $FILE_SIZE;
		                    $result['FILE_EXT'] = $FILE_EXT;
		                }
		                
		                else{
                            $result['FILE_ORG_FILENAME'] = $_POST['AttachDatas'][$i]['FILE_NAME'];
		                    $result['FILE_NAME'] = $_POST['AttachDatas'][$i]['FILE_NAME'];
		                    $result['FILE_SIZE'] = $_POST['AttachDatas'][$i]['FILE_SIZE'];
		                    $result['FILE_EXT'] = $_POST['AttachDatas'][$i]['FILE_EXT'];
		                }
		                
		                
		                $result['DESCRIPTION'] = $_POST['AttachDatas'][$i]['attachDescription'];
		                $result['CREATED_ON'] = $createdOn;
		                $result['UPDATED_ON'] = $updatedOn;
		                $result['INC_INVEST_ID'] = $NotifyDetail['INCIDENT_INVESTIGATION_ID'];
		                $result['ATTACHMENT_STATUS'] = 'Y'; 
		                $result['INVEST_ATTACHMENT_ID'] = $_POST['AttachDatas'][$i]['INVEST_ATTACHMENT_ID'];


		                $result['INVEST_DOC_TYPE'] = 'ATTACHDOC';

		                $this->incident_model->UpdateAttachDocument($result);

                } 
            }

            // echo '<pre>';print_r($_POST);exit;

            $Rootimage = $_FILES;
            if(isset($_FILES['userfile'])&&$_FILES['userfile']!='')
            {

            $path = 'public/module/incident/UploadDocument/RootUpload';
            
            $target_dir = $_SERVER['DOCUMENT_ROOT'] ."/". $path;
              $flnameroot = explode('.',$Rootimage['userfile']['name']);
	     $upflnameroot = $flnameroot[0].'-'.date('Y-m-d h:i:s').'.'.$flnameroot[1];
            $upload_filename= $Rootimage['userfile']['name'];
            $file_type=$Rootimage['userfile']['type'];
            
            $file_size = $Rootimage['userfile']['size'];

            $file_ext=explode('.',$_FILES['userfile']['name']);

            $file_ext = $file_ext['1'];
            $filename = $path.'/'.$upflnameroot;

             $FILE_EXT = pathinfo($filename, PATHINFO_EXTENSION);
         
             $tmp = $Rootimage['userfile']['tmp_name'];
             move_uploaded_file($tmp, $filename);   

             $createdOn = date('Y-m-d H:i:s');
		     $updatedOn = date('Y-m-d H:i:s');
		   
	         $result = array();
	         $result['FILE_PATH'] = $path;

	         if($upload_filename == ''){
             $result['FILE_ORG_FILENAME'] = $_POST['FILE_NAME'];
	         $result['FILE_NAME'] = $_POST['FILE_NAME'];
	         $result['FILE_SIZE'] = $_POST['FILE_SIZE'];
	         $result['FILE_EXT'] = $_POST['FILE_EXT'];
		    }
		    else if($upload_filename != ''){
		    	$result['FILE_ORG_FILENAME'] = $upflnameroot;
		        $result['FILE_NAME'] = $upflnameroot;
		        $result['FILE_SIZE'] = $FILE_SIZE;
		        $result['FILE_EXT'] = $FILE_EXT;
		    }
		    
		    else{
		     $result['FILE_ORG_FILENAME'] = $_POST['FILE_NAME'];
	         $result['FILE_NAME'] = $_POST['FILE_NAME'];
	         $result['FILE_SIZE'] = $_POST['FILE_SIZE'];
	         $result['FILE_EXT'] = $_POST['FILE_EXT'];
		    }
		                
	         
	         $result['DESCRIPTION'] = null;
	         $result['CREATED_ON'] = $createdOn;
	         $result['UPDATED_ON'] = $updatedOn;
	         $result['INC_INVEST_ID'] = $NotifyDetail['INCIDENT_INVESTIGATION_ID'];
	         $result['ATTACHMENT_STATUS'] = 'Y'; 
	         $result['INVEST_ATTACHMENT_ID'] = $_POST['INVEST_ATTACHMENT_IDD'];
	         $result['INVEST_DOC_TYPE'] = 'ROOTDOC';
             
		       
		    $this->incident_model->UpdateRootAttachDocument($result);

		    // Active Table ( User Audits )
			 $user_data['USER_ID']= $_SESSION['id'];
			 $user_data['INCIDENT_NOTIFY_ID_DECRYPT']=$id;
			 $user_data['ID'] = $_SESSION['name'];
			 $user_data['INCIDENT_NOTIFY_ID']=decryptval($id);
		     $user_data['MODULE']='Incident/Accident Investigation';
		     $user_data['PROCESS']='Insert';
		     $details = serialize($result);
		     $user_data['VALUE']="Incident/Accident Investigation Insert".$details;
		     $userAudit = $this->incident_model->InsertActiveofUserAudit($user_data);      
          
           }

            if($_POST['SUMBIT_PROCESS'] == '1'){
          
             $this->session->set_flashdata("incflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Incident/Accident Investigation Submited successfully! </div>');
             redirect('incident/investigate');
              }
              else{

                 $this->session->set_flashdata("incflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Incident/Accident Investigation Saved Draft successfully!</div>');

              	 redirect('incident/investigate');

              }

	    

	   
               



    }
    
    
   public function DeleteAllDetails(){
//echo 1;exit;
$id = $this->input->post('id');
// echo 'M<pre>';print_r($id);
$table = $this->input->post('table');
// echo 'A<pre>';print_r($table);
$pri_clm = $this->input->post('pri_clm');
$status = $this->input->post('alt_status');

// echo 'H<pre>';print_r($status);exit;
//$remove = $this->db->delete(INCIDENT_NOTIFY_PERSON_DETAILS, ['INCIDENT_NOTIFY_PERSON_ID' => $id]);
//echo $this->db->query();exit;
$delete = $this->incident_model->DeleteAllDetails($id,$table,$pri_clm,$status);

}
    
    public function DeleteAllDetailsPerson(){
$id = $this->input->post('id');
// echo 'M<pre>';print_r($id);
$table = $this->input->post('table');
// echo 'A<pre>';print_r($table);
$pri_clm = $this->input->post('pri_clm');
$status = $this->input->post('alt_status');
//echo 'H<pre>';print_r($pri_clm);exit;
//$remove = $this->db->delete(INCIDENT_NOTIFY_PERSON_DETAILS, ['INCIDENT_NOTIFY_PERSON_ID' => $id]);
//echo $this->db->query();exit;
$delete = $this->incident_model->DeleteAllDetailsPerson($id,$table,$pri_clm,$status);
}
    public function getAjaxsubbodyParts() {
        $partId = $this->input->post('partId');

        $subPartoptn['where'] = [
            'sub.MAIN_BODY_ID' => $partId,
            'subImg.IMG_STATUS' => 'Y',
        ];
        $subPartoptn['join'][INJURIED_SUB_BODY_PARTS . ' as sub'] = ['sub.SUB_ID = subImg.SUB_ID', 'left'];
        $getSubparts = $this->common_model->getAlldata(INJURIED_SUB_BODY_PARTS_IMG . ' as subImg', ['subImg.*'], $subPartoptn);
        echo json_encode($getSubparts);
    }
    public function getAjaxsubbodyImages() {
        $partId = $this->input->post('partId');

        $subPartoptn['where'] = [
            'subImg.IMG_ID' => $partId,
            'subImg.IMG_STATUS' => 'Y',
        ];
        $subPartoptn['return_type'] = 'row';
        $getSubpartimg = $this->common_model->getAlldata(INJURIED_SUB_BODY_PARTS_IMG . ' as subImg', ['subImg.*'], $subPartoptn);
        echo json_encode($getSubpartimg);
    }

    
    public function SubBodyDetail()
    {
    	$getSubBodyPart = $this->incident_model->getSubBodyPart($this->input->post('bodyValue'));
    	//echo '<pre>';print_r($getSubBodyPart);
    	$details = $this->incident_model->getSubBodyDetail();
    	//echo '<pre>';print_r($details);exit;
    	foreach($details as $d){
    	$output = '';
		$output.='<label for="fname" class="form-label">Sub - Part :</label><select class="form-control departments"><br>';
		$output.='<option value="">-- Please Select --</option>';
		
		   foreach ($getSubBodyPart as $rr)
		    {
		    	$selected = '';
                  if($d['SUB_ID'] == $rr['IMG_ID']){
                    $selected = "selected";
                  }
		    $output.='<option '.$selected.' value="' . $rr['IMG_ID'] . '">' . $rr['SUB_BODY_PART'] . '</option>';
		    }
		
		$output.='</select></div>';
		}
		echo $output;
    }
    public function BodyImageDetail(){
    	$getSubBodyPartImage = $this->incident_model->getSubBodyPartImage($this->input->post('SubBodyValue'));
    	$image = $getSubBodyPartImage['BODY_IMG'];
    	$output = '';
		$output.= BASE_URL.$image;
		echo $output;
    }
    
    public function investSaveReview($id = ''){

        // echo '<pre>';print_r($_POST);exit;
    	
    	$createdOn = date('Y-m-d H:i:s');
        $updatedOn = date('Y-m-d H:i:s');
        if($_POST['ReviewAcpRej'] == 'R'){
        	$status = '7';
        } if($_POST['ReviewAcpRej'] == 'A'){
        	$status = '6';
        } if($_POST['VerifiedAcpRej'] == 'R'){
        	$status = '9';
        }
         if($_POST['VerifiedAcpRej'] == 'A'){
        	$status = '8';
        }
         if($_POST['ApprovedAcpRej'] == 'R'){
        	$status = '11';
        }
         if($_POST['ApprovedAcpRej'] == 'A'){
        	$status = '12';
        }

    	if($_POST['reviewdBy'] != ""){

    		$results = array();

			$results['REVIEWED_BY'] = $_SESSION['id'];
$results['REVIEWED_DATE'] = date('Y-m-d H:i:s');
			$results['REVIEWED_REMARK'] = $_POST['reviewdBy'];
			$results['REVIEWED_STATUS'] = $_POST['ReviewAcpRej'];
			$ids = decryptval($id);
			if($_POST['ReviewAcpRej'] == 'R'){
		     $notifyids = $this->incident_model->updateNotify($status,$ids);
			$results['SUMBIT_PROCESS'] = '2';

					 $NotifyDetail = $this->incident_model->getNotifyTableData($id,$_POST['INCIDENT_INVESTIGATION_IDD']);
					 
				     $datas = array();
				     $datas['INCIDENT_ID'] = $NotifyDetail['INCIDENT_ID'];
				     $datas['INCIDENT_NOTIFY_ID'] = $NotifyDetail['INCIDENT_NOTIFY_ID'];
				     $datas['EVENT_DATE'] = $NotifyDetail['EVENT_DATE'];
				     $datas['EVENT_TIME'] = $NotifyDetail['EVENT_TIME'];
				     $datas['LOCATION_ID'] = $NotifyDetail['LOCATION_ID'];
				     $datas['SPECIFIC_LOCATION_ID'] = $NotifyDetail['SPECIFIC_LOCATION_ID'];
				     $datas['SPECIFIC_LOCATION_OTHER'] = $NotifyDetail['SPECIFIC_LOCATION_OTHER'];
				     $datas['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
				     $datas['PREPARED_BY'] = $_SESSION['id'];
				     $datas['CREATED_ON'] = $createdOn;
				     $datas['UPDATED_ON'] = $updatedOn;

				     $datas['INC_AUTHORITY_INVOLVED'] = $NotifyDetail['INC_AUTHORITY_INVOLVED'];
				     $datas['AUTHORITY_INVOLVED_DETAIL'] = $NotifyDetail['AUTHORITY_INVOLVED_DETAIL'];
				     $datas['INJURED_PERSON'] = $NotifyDetail['INJURED_PERSON'];
					 $datas['COMPETENCY_RECORDS'] = $NotifyDetail['COMPETENCY_RECORDS'];
				     $datas['IMMEDIATE_CAUSES'] = $NotifyDetail['IMMEDIATE_CAUSES'];
					 $datas['POSSIBLE_ROOT_CAUSES'] = $NotifyDetail['POSSIBLE_ROOT_CAUSES'];
					 $datas['CONTRIBUTE_CAUSAL_FACTOR'] = $NotifyDetail['CONTRIBUTE_CAUSAL_FACTOR'];
					 $datas['HAZARD_RISK_IDENTIFY'] = $NotifyDetail['HAZARD_RISK_IDENTIFY'];
					 $datas['ACCITENT_AVOIDABLE '] = $NotifyDetail['ACCITENT_AVOIDABLE'];
					 $datas['INVEST_PROPOSED_ACTION'] = $NotifyDetail['INVEST_PROPOSED_ACTION'];
					 $datas['INCIDENT_WORK_RELATED'] = $NotifyDetail['INCIDENT_WORK_RELATED'];
					 $datas['ACTIVITY'] = $NotifyDetail['ACTIVITY'];
					 $datas['EMP_CONT'] = $NotifyDetail['EMP_CONT'];
					 $datas['INC_CLASSIFICATION'] = $NotifyDetail['INC_CLASSIFICATION'];
					 $datas['INJURED_PERSON'] = $NotifyDetail['INJURED_PERSON'];
					 $datas['ASSET_DETAILS'] = $NotifyDetail['ASSET_DETAILS'];
				     $datas['CHANGES_PLACE'] = '2';
				     $datas['PREPARED_BY'] = $_SESSION['id'];
				     $datas['REVIEWED_BY'] = $_SESSION['id'];
				     $datas['REVIEWED_REMARK'] = $_POST['reviewdBy'];
				     $datas['REVIEWED_STATUS'] = $_POST['ReviewAcpRej'];
				     $datas['VERIFIED_BY'] = '0';
				     $datas['VERIFIED_REMARK'] = null;
				     $datas['VERIFIED_STATUS'] = 'R';
				     $datas['APPROVED_STATUS'] = 'R';
				     $datas['APPROVED_BY'] = '0';
				     $datas['APPROVED_REMARK'] = null;

                                     $insertHistory = $this->incident_model->insertHistoryForNotifyDetail($datas);
                                     $justId = $id;
                                     $IncidentSubData = $this->incident_model->getEmployeeDetails($_POST['INCIDENT_INVESTIGATION_IDD'],$justId='');
					 unset($IncidentSubData['IncidentInvestigationData']);
					 unset($IncidentSubData['incidentTeamSummary']);
					 unset($IncidentSubData['injuredPersonStatus']);
					 unset($IncidentSubData['injuredAssetStatus']);

    	             $n =max(array_keys($IncidentSubData['investigationAllDetails']));
              
			            for($i=0;$i<=$n;$i++)
			            {
			                if(isset($IncidentSubData['investigationAllDetails'][$i])&&$IncidentSubData['investigationAllDetails'][$i]!=''){
			                	
			                $result = array();
			                $result['EMP_NAME'] = $IncidentSubData['investigationAllDetails'][$i]['EMP_NAME'];
			                $result['INVES_TEAM_EMP_ID'] = $IncidentSubData['investigationAllDetails'][$i]['EMP_ID'];
			                $result['DESIGNATION_ID'] = $IncidentSubData['investigationAllDetails'][$i]['DESIGNATION_ID'];
			                $result['PHONE_NO'] = $IncidentSubData['investigationAllDetails'][$i]['PHONE_NO'];
			                $result['INVESTIGATION_TEAM_SUMMARY'] = $IncidentSubData['investigationAllDetails'][$i]['INVESTIGATION_TEAM_SUMMARY'];
			                $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
			                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
			                $result['CHANGES_PLACE'] = '1';
							$result['PREPARED_BY'] = $_SESSION['id'];
							$result['REVIEWED_BY'] = $_SESSION['id'];
							$result['REVIEWED_REMARK'] = $_POST['reviewdBy'];
							$result['REVIEWED_STATUS'] = $_POST['ReviewAcpRej'];
							$result['VERIFIED_BY'] = '0';
							$result['VERIFIED_REMARK'] = null;
							$result['VERIFIED_STATUS'] = 'R';
							$result['APPROVED_STATUS'] = 'R';
							$result['APPROVED_BY'] = '0';
							$result['APPROVED_REMARK'] = null;
							$result['SUB_TABLE_NAME'] = 'INCIDENT_INVESTIGATION_TEAM';
			                $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
			              
			                }

                          }
                          $n =max(array_keys($IncidentSubData['superiorAllDetails']));
          
								for($i=0;$i<=$n;$i++)
								{
								if(isset($IncidentSubData['superiorAllDetails'][$i])&&$IncidentSubData['superiorAllDetails'][$i]!=''){

								$result = array();
								$result['EMP_ID'] = $IncidentSubData['superiorAllDetails'][$i]['EMP_ID'];
								$result['NAME'] = $IncidentSubData['superiorAllDetails'][$i]['NAME'];
								$result['PHONE'] = $IncidentSubData['superiorAllDetails'][$i]['PHONE'];
								$result['PRESENT'] = $IncidentSubData['superiorAllDetails'][$i]['PRESENT'];
								$result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
				                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
				                $result['CHANGES_PLACE'] = '1';
								$result['PREPARED_BY'] = $_SESSION['id'];
								$result['REVIEWED_BY'] = $_SESSION['id'];
								$result['REVIEWED_REMARK'] = $_POST['reviewdBy'];
								$result['REVIEWED_STATUS'] = $_POST['ReviewAcpRej'];
								$result['VERIFIED_BY'] = '0';
								$result['VERIFIED_REMARK'] = null;
								$result['VERIFIED_STATUS'] = 'R';
								$result['APPROVED_STATUS'] = 'R';
								$result['APPROVED_BY'] = '0';
								$result['APPROVED_REMARK'] = null;
								$result['SUB_TABLE_NAME'] = 'INCIDENT_SUPERVISOR_SUPERIOR_DETAIL';
								$insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);

								}

								}

					 $n =max(array_keys($IncidentSubData['AssetAllDetails']));
          
						        for($i=0;$i<=$n;$i++)
						        {
						            if(isset($IncidentSubData['AssetAllDetails'][$i])&&$IncidentSubData['AssetAllDetails'][$i]!=''){
						            	
						            $result = array();
						            $result['DESCRIPTION'] = $IncidentSubData['AssetAllDetails'][$i]['DESCRIPTION'];
						            $result['NAME_OF_OPERATOR_DRIVER_MASTER'] = $IncidentSubData['AssetAllDetails'][$i]['NAME_OF_OPERATOR_DRIVER_MASTER'];
						            $result['ASSET_PHONE_NO'] = $IncidentSubData['AssetAllDetails'][$i]['PHONE_NO'];
						            $result['OWNER_COMP_NAME'] = $IncidentSubData['AssetAllDetails'][$i]['OWNER_COMP_NAME'];
						            $result['ASSET_PLATE_NO'] = $IncidentSubData['AssetAllDetails'][$i]['PLATE_NO'];
						            $result['EST_COST_OF_DAMAGE'] = $IncidentSubData['AssetAllDetails'][$i]['EST_COST_OF_DAMAGE'];
						            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
					                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
					                $result['CHANGES_PLACE'] = '1';
									$result['PREPARED_BY'] = $_SESSION['id'];
									$result['REVIEWED_BY'] = $_SESSION['id'];
									$result['REVIEWED_REMARK'] = $_POST['reviewdBy'];
									$result['REVIEWED_STATUS'] = $_POST['ReviewAcpRej'];
									$result['VERIFIED_BY'] = '0';
									$result['VERIFIED_REMARK'] = null;
									$result['VERIFIED_STATUS'] = 'R';
									$result['APPROVED_STATUS'] = 'R';
									$result['APPROVED_BY'] = '0';
									$result['APPROVED_REMARK'] = null;
									$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_ASSET_DETAIL';
						            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
						         
						            }

						 }


					  $n =max(array_keys($IncidentSubData['personInterviewd']));
          
					        for($i=0;$i<=$n;$i++)
					        {
					            if(isset($IncidentSubData['personInterviewd'][$i])&&$IncidentSubData['personInterviewd'][$i]!=''){
					            	
					            $result = array();

					            $result['INTERVIEW_EMP_ID'] = $IncidentSubData['personInterviewd'][$i]['EMP_ID'];
					            $result['INTERVIEW_EMP_NAME'] = $IncidentSubData['personInterviewd'][$i]['EMP_NAME'];
					            $result['INTERVIEW_JOB_TITLE'] = $IncidentSubData['personInterviewd'][$i]['JOB_TITLE'];
					            $result['INTERVIEW_PHONE '] = $IncidentSubData['personInterviewd'][$i]['PHONE'];
					            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
				                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
				                $result['CHANGES_PLACE'] = '1';
								$result['PREPARED_BY'] = $_SESSION['id'];
								$result['REVIEWED_BY'] = $_SESSION['id'];
								$result['REVIEWED_REMARK'] = $_POST['reviewdBy'];
								$result['REVIEWED_STATUS'] = $_POST['ReviewAcpRej'];
								$result['VERIFIED_BY'] = '0';
								$result['VERIFIED_REMARK'] = null;
								$result['VERIFIED_STATUS'] = 'R';
								$result['APPROVED_STATUS'] = 'R';
								$result['APPROVED_BY'] = '0';
								$result['APPROVED_REMARK'] = null;
								$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_INTERVIEWED_DETAIL';
					            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
					         
					            }
					        }
					             $n =max(array_keys($IncidentSubData['activePlanAllDetails']));
          
							        for($i=0;$i<=$n;$i++)
							        {
							            if(isset($IncidentSubData['activePlanAllDetails'][$i])&&$IncidentSubData['activePlanAllDetails'][$i]!=''){
							            	
							            $result = array();
							            
							            $result['CA_PA_DESC'] = $IncidentSubData['activePlanAllDetails'][$i]['CA_PA_DESC'];
							            $result['RESPOSIBILITY_ID'] = $IncidentSubData['activePlanAllDetails'][$i]['RESPOSIBILITY_ID'];
							            $result['DATE_BY_WHEN'] = $IncidentSubData['activePlanAllDetails'][$i]['DATE_BY_WHEN'];
							            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
						                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
						                $result['CHANGES_PLACE'] = '1';
										$result['PREPARED_BY'] = $_SESSION['id'];
										$result['REVIEWED_BY'] = $_SESSION['id'];
										$result['REVIEWED_REMARK'] = $_POST['reviewdBy'];
									 	$result['REVIEWED_STATUS'] = $_POST['ReviewAcpRej'];
										$result['VERIFIED_BY'] = '0';
										$result['VERIFIED_REMARK'] = null;
										$result['VERIFIED_STATUS'] = 'R';
										$result['APPROVED_STATUS'] = 'R';
										$result['APPROVED_BY'] = '0';
										$result['APPROVED_REMARK'] = null;
										$result['SUB_TABLE_NAME'] = 'INCIDENT_ACTION_PLAN';
							            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
							         
							            }
							        }

					 			$n =max(array_keys($IncidentSubData['circumstanceDetails']));
          
									    for($i=0;$i<=$n;$i++)
									    {
									        if(isset($IncidentSubData['circumstanceDetails'][$i])&&$IncidentSubData['circumstanceDetails'][$i]!=''){
									        	
									        $result = array();
									        
									        $result['CIRCUMSTANCE_DESC'] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'];
									        $result['CIRCUMSTANCE_DESC_FIVE'] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'];
									        $result['CIRCUMSTANCE_DESC_FOUR'] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'];
									        $result['CIRCUMSTANCE_DESC_THREE '] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'];
									        $result['CIRCUMSTANCE_DESC_TWO '] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'];
									        $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
							                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
							                $result['CHANGES_PLACE'] = '1';
											$result['PREPARED_BY'] = $_SESSION['id'];
											$result['REVIEWED_BY'] = $_SESSION['id'];
											$result['REVIEWED_REMARK'] = $_POST['reviewdBy'];
											$result['REVIEWED_STATUS'] = $_POST['ReviewAcpRej'];
											$result['VERIFIED_BY'] = '0';
											$result['VERIFIED_REMARK'] = null;
											$result['VERIFIED_STATUS'] = 'R';
											$result['APPROVED_STATUS'] = 'R';
											$result['APPROVED_BY'] = '0';
											$result['APPROVED_REMARK'] = null;
											$result['SUB_TABLE_NAME'] = 'INCIDENT_CIRCUMSTANCE_INFO';
									        $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
									     
									        }
									    }

									    

					             $n =max(array_keys($IncidentSubData['attachAllDetail']));
          
								        for($i=0;$i<=$n;$i++)
								        {
								            if(isset($IncidentSubData['attachAllDetail'][$i])&&$IncidentSubData['attachAllDetail'][$i]!=''){
								            	
								            $result = array();
								            
								            $result['INVEST_DOC_TYPE'] = $IncidentSubData['attachAllDetail'][$i]['INVEST_DOC_TYPE'];
								            $result['FILE_PATH'] = $IncidentSubData['attachAllDetail'][$i]['FILE_PATH'];
								            $result['FILE_ORG_FILENAME'] = $IncidentSubData['attachAllDetail'][$i]['FILE_ORG_FILENAME'];
								            $result['FILE_NAME '] = $IncidentSubData['attachAllDetail'][$i]['FILE_NAME'];
								            $result['FILE_SIZE '] = $IncidentSubData['attachAllDetail'][$i]['FILE_SIZE'];
								            $result['FILE_EXT '] = $IncidentSubData['attachAllDetail'][$i]['FILE_EXT'];
								            $result['DESCRIPTION '] = $IncidentSubData['attachAllDetail'][$i]['DESCRIPTION'];
								            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
							                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
							                $result['CHANGES_PLACE'] = '1';
											$result['PREPARED_BY'] = $_SESSION['id'];
											$result['REVIEWED_BY'] = $_SESSION['id'];
											$result['REVIEWED_REMARK'] = $_POST['reviewdBy'];
											$result['REVIEWED_STATUS'] = $_POST['ReviewAcpRej'];
											$result['VERIFIED_BY'] = '0';
											$result['VERIFIED_REMARK'] = null;
											$result['VERIFIED_STATUS'] = 'R';
											$result['APPROVED_STATUS'] = 'R';
											$result['APPROVED_BY'] = '0';
											$result['APPROVED_REMARK'] = null;
											$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_ATTACHMENT';
								            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
								         
								            }
								        }


								        $n =max(array_keys($IncidentSubData['injuredAllDetails']));
          
								        for($i=0;$i<=$n;$i++)
								        {
								            if(isset($IncidentSubData['injuredAllDetails'][$i])&&$IncidentSubData['injuredAllDetails'][$i]!=''){
								            	
								            $result = array();
								            $result['PERSON_NAME'] = $IncidentSubData['injuredAllDetails'][$i]['PERSON_NAME'];
								            $result['SEX'] = $IncidentSubData['injuredAllDetails'][$i]['SEX'];
								            $result['AGE'] = $IncidentSubData['injuredAllDetails'][$i]['AGE'];
								            $result['JOB_TITLE'] = $IncidentSubData['injuredAllDetails'][$i]['JOB_TITLE'];
								            $result['CITIZENSHIP'] = $IncidentSubData['injuredAllDetails'][$i]['CITIZENSHIP'];
								            $result['ID_TYPE'] = $IncidentSubData['injuredAllDetails'][$i]['ID_TYPE'];
								            $result['IC_PASSPORT_NO'] = $IncidentSubData['injuredAllDetails'][$i]['IC_PASSPORT_NO'];
								            $result['CONT_COMPANY_NAME'] = $IncidentSubData['injuredAllDetails'][$i]['CONT_COMPANY_NAME'];
								            $result['INJURY_TYPE'] = $IncidentSubData['injuredAllDetails'][$i]['INJURY_TYPE'];
								            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
							                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
							                $result['CHANGES_PLACE'] = '1';
											$result['PREPARED_BY'] = $_SESSION['id'];
											$result['REVIEWED_BY'] = $_SESSION['id'];
											$result['REVIEWED_REMARK'] = $_POST['reviewdBy'];
											$result['REVIEWED_STATUS'] = $_POST['ReviewAcpRej'];
											$result['VERIFIED_BY'] = '0';
											$result['VERIFIED_REMARK'] = null;
											$result['VERIFIED_STATUS'] = 'R';
											$result['APPROVED_STATUS'] = 'R';
											$result['APPROVED_BY'] = '0';
											$result['APPROVED_REMARK'] = null;
											$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_INJURED_PERSON_BODY_INFO';
								            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
								         
								            }
								        }



								            $result = array();
								            $result['INVEST_DOC_TYPE'] = $IncidentSubData['rootUpload']['INVEST_DOC_TYPE'];
								            $result['FILE_PATH'] = $IncidentSubData['rootUpload']['FILE_PATH'];
								            $result['FILE_ORG_FILENAME'] = $IncidentSubData['rootUpload']['FILE_ORG_FILENAME'];
								            $result['FILE_NAME '] = $IncidentSubData['rootUpload']['FILE_NAME'];
								            $result['FILE_SIZE '] = $IncidentSubData['rootUpload']['FILE_SIZE'];
								            $result['FILE_EXT '] = $IncidentSubData['rootUpload']['FILE_EXT'];
								            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
							                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
							                $result['CHANGES_PLACE'] = '1';
											$result['PREPARED_BY'] = $_SESSION['id'];
											$result['REVIEWED_BY'] = $_SESSION['id'];
											$result['REVIEWED_REMARK'] = $_POST['reviewdBy'];
											$result['REVIEWED_STATUS'] = $_POST['ReviewAcpRej'];
											$result['VERIFIED_BY'] = '0';
											$result['VERIFIED_REMARK'] = null;
											$result['VERIFIED_STATUS'] = 'R';
											$result['APPROVED_STATUS'] = 'R';
											$result['APPROVED_BY'] = '0';
											$result['APPROVED_REMARK'] = null;
											$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_ATTACHMENT';
								            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
                                                                            
                                                                            // Active Table ( User Audits )
			 $user_data['USER_ID']=$_SESSION['id'];
			 $user_data['INCIDENT_NOTIFY_ID_DECRYPT']=$id;
			 $user_data['ID'] = $_SESSION['name'];
			 $user_data['INCIDENT_NOTIFY_ID']=decryptval($id);
		     $user_data['MODULE']='Workflow and Approval process - Reviewed By - Rejected';
		     $user_data['PROCESS']='Workflow and Approval process - Reviewed By - Rejected';
		     $details = serialize($results);
		     $user_data['VALUE']="Reviewed By - Rejected".$details;
		     $userAudit = $this->incident_model->InsertActiveofUserAudit($user_data); 


										$subject = 'Workflow and Approval process - Reviewed By - Rejected';
									        
                                                                                $roldId = '6';
                                                                                //$roldId = '6';
                                                                                $RejectedIds = $this->incident_model->getHsseEmail($roldId);
                                                                                foreach($RejectedIds as $r){
                                                                                 //$dpt = '4,8';
                                                                                 $HSSEDts =  $this->incident_model->getHSSEDtsEmail($r['USERNAME'] , $dpt= '' , $desn = '');
         
                                                                                foreach($HSSEDts as $h){
                                                                                    $toemail = $h['emailId'];
                                                                                
									        $ids = decryptval($id);
									        $getNotifyDetails = $this->incident_model->getAllNotify($ids);
									       // echo '<pre>';print_r($getNotifyDetails);exit;
									        $LocationName = $this->incident_model->getLocationName($getNotifyDetails['LOCATION_ID'],$getNotifyDetails['SPECIFIC_LOCATION_ID']);
									        $eventTypeDt = $this->incident_model->getEventTypes1($getNotifyDetails['EVENT_TYPE_IDS'],$id);
									        $eventDate = date('d-m-Y',strtotime($getNotifyDetails['EVENT_DATE']));
                                                                                $statusPre = 'Review Rejected';
                                                                                $Prepared = $_SESSION['emp_details']->EMP_NAME . ' - ' . $_SESSION['emp_details']->design_name ;
									        
									        

									        
									        $specificLocation = $getNotifyDetails['SPECIFIC_LOCATION_ID'];
									        if($specificLocation == '-1'){
									        	$specLocName = 'Other';
									        }
									        else{
									        	$specLocName = $LocationName['SPECIFIC_LOC_NAME'];
									        }
									        
									            
									        $message = 'Incident investigation has been submitted with following details :'.'<br>'.'<br>'.'<br>'.
                                                                                        
                                                                                        
                                                                                        'Notification No             :  ' .$ids .'<br>'.
									                    'Event Date                  :  ' .$eventDate  .'<br>'.
									                    'Event Time                  :  ' .$getNotifyDetails['EVENT_TIME']  .'<br>'.
									                    'Location                    :  ' .$LocationName['TERMINAL_SHORTNAME']  .'<br>'.
									                    'Specific Location           :  ' .$specLocName  .'<br>'.
                                                                                            'Event Type                  :  ' .$eventTypeDt['EVENT_TYPE_NAME'].'<br>'.
									                    'Event Description           :  ' .$getNotifyDetails['EVENT_DESC']  .'<br>'.
									                    'Reported By                 :  ' .$getNotifyDetails['EVENT_REPORT_NAME']  . '  -  '  . $getNotifyDetails['EVENT_REPORT_DESIGNATION'] .'<br>'.
									                    'Prepared by                 :  ' .$Prepared .'<br>'.
									                    'Status                 :  ' .$statusPre .'<br>'.
									                    'Remark                   : '.$_POST['reviewdBy'] . '<br>'
									                    ;

									                    									                
									                
									                
									              //  ;
									        
									         
									        
									        $tempdata = array(
									                    'view_file' => 'common/email/Notification_mail',
									                    'messageText' => $message,
									                    'footerText' => ''
									                   
									        );
									       
									       $template = $this->template->load_email_template($tempdata); 
									        
									       $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
 $notifyUrl = 'incident/ViewList/'.$id;
       
       
        $notifydata = [
            'text' => $message,
            'url' => $notifyUrl,
            'type' => '1',
            'notifygroup' => $h['EMP_AUTO_ID'],
           'employee' => $r['LOGIN_ID'],
            'mobilelink' => '',
          ];
          insertNotifications($notifydata);
                                                                                }
                                                                                }




		    }

		    else{
                       // echo 1;exit; 
                        
                         $user_data['USER_ID']=$_SESSION['id'];
			 $user_data['INCIDENT_NOTIFY_ID_DECRYPT']=$id;
			 $user_data['ID'] = $_SESSION['name'];
			 $user_data['INCIDENT_NOTIFY_ID']=decryptval($id);
		     $user_data['MODULE']='Workflow and Approval process - Reviewed By - Approved';
		     $user_data['PROCESS']='Workflow and Approval process - Reviewed By - Approved';
		     $details = serialize($results);
		     $user_data['VALUE']="Reviewed By - Approved".$details;
		     $userAudit = $this->incident_model->InsertActiveofUserAudit($user_data); 
                     $ids = decryptval($id);
                     $notifyids = $this->incident_model->updateNotify($status,$ids);
	             //$results['SUMBIT_PROCESS'] = '2';
		    $results['SUMBIT_PROCESS'] = '3';
		    $subject = 'Workflow and Approval process - Reviewed By - Approved';
                                                                                $roldId = '8';
                                                                                $LocationIdInNotify = $this->incident_model->getLocationIdInNotify($id);
                                                                                //echo 'M<pre>';print_r($LocationIdInNotify);exit;
                                                                                //$roldId = '6,8';
                                                                                $RejectedIds = $this->incident_model->getHsseEmail($roldId);
                                                                                foreach($RejectedIds as $r){
//                                                                                   $dpt = '4';
                                                                                    //$desn = '18';
                                                                                    if($LocationIdInNotify['LOCATION_ID'] == 1){
                                                                                        $desn = '22';
                                                                                    }
                                                                                    else if($LocationIdInNotify['LOCATION_ID'] == 2){
                                                                                        $desn = '18';
                                                                                    }
                                                                                    else{
                                                                                      $desn = '';  
                                                                                    }
                                                                                   
                                                                                   $HSSEDts =  $this->incident_model->getHSSEDtsEmail($r['USERNAME'] , $dpt ='' , $desn );
         
                                                                                foreach($HSSEDts as $h){
                                                                                    $toemail = $h['emailId'];
									       
									        $ids = decryptval($id);
									        $getNotifyDetails = $this->incident_model->getAllNotify($ids);
									         $LocationName = $this->incident_model->getLocationName($getNotifyDetails['LOCATION_ID'],$getNotifyDetails['SPECIFIC_LOCATION_ID']);
									        $eventTypeDt = $this->incident_model->getEventTypes1($getNotifyDetails['EVENT_TYPE_IDS'],$id);
									        $eventDate = date('d-m-Y',strtotime($getNotifyDetails['EVENT_DATE']));
                                                                                $statusPre = 'Review Accepted';
                                                                                $Prepared = $_SESSION['emp_details']->EMP_NAME . ' - ' . $_SESSION['emp_details']->design_name ;
									        
									        

									        
									        $specificLocation = $getNotifyDetails['specificLocation'];
									        if($specificLocation == '-1'){
									        	$specLocName = 'Other';
									        }
									        else{
									        	$specLocName = $LocationName['SPECIFIC_LOC_NAME'];
									        }
									        
									            
									        $message =  'Incident investigation has been submitted with following details :'.'<br>'.'<br>'.'<br>'.
                                                                                        
                                                                                        'Notification No             :  ' .$ids .'<br>'.
									                    'Event Date                  :  ' .$eventDate  .'<br>'.
									                    'Event Time                  :  ' .$getNotifyDetails['EVENT_TIME']  .'<br>'.
									                    'Location                    :  ' .$LocationName['TERMINAL_SHORTNAME']  .'<br>'.
									                    'Specific Location           :  ' .$specLocName  .'<br>'.
                                                                                            'Event Type                  :  ' .$eventTypeDt['EVENT_TYPE_NAME'].'<br>'.
									                    'Event Description           :  ' .$getNotifyDetails['EVENT_DESC']  .'<br>'.
									                    'Reported By                 :  ' .$getNotifyDetails['EVENT_REPORT_NAME']  . '  -  '  . $getNotifyDetails['EVENT_REPORT_DESIGNATION'] .'<br>'.
									                    'Prepared by                 :  ' .$Prepared .'<br>'.
									                    'Status                 :  ' .$statusPre .'<br>'.
									                    'Remark                   : '.$_POST['reviewdBy'] . '<br>'
									                    ;

									                    									                
									                
									                
									              //  ;
									        
									         
									        
									        $tempdata = array(
									                    'view_file' => 'common/email/Notification_mail',
									                    'messageText' => $message,
									                    'footerText' => ''
									                   
									        );
									       
									       $template = $this->template->load_email_template($tempdata); 
									        
									       $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
		
                                                                             $notifyUrl = 'incident/ViewList/'.$id;
       
       
        $notifydata = [
            'text' => $message,
            'url' => $notifyUrl,
            'type' => '1',
            'notifygroup' => $h['EMP_AUTO_ID'],
          'employee' => $r['LOGIN_ID'],
            'mobilelink' => '',
          ];
          insertNotifications($notifydata);   
                                                                                }
                                                                                }
                                                                               
                                                                               
                                                                               
                                                                                }

    	}
    	else if($_POST['verifiedBy'] != ""){
    		unset($_POST['reviewdBy']);
    		unset($_POST['ReviewAcpRej']);
    		$results = array();
    	    $results['VERIFIED_BY'] = $_SESSION['id'];
$results['VERIFIED_DATE'] = date('Y-m-d H:i:s');
    	    $results['VERIFIED_REMARK'] = $_POST['verifiedBy'];
    	    $results['VERIFIED_STATUS'] = $_POST['VerifiedAcpRej'];
    	    if($_POST['VerifiedAcpRej'] == 'R'){
    	    	$createdOn = date('Y-m-d H:i:s');
                $updatedOn = date('Y-m-d H:i:s');
                $ids = decryptval($id);
                $notifyids = $this->incident_model->updateNotify($status,$ids);
    	    $results['SUMBIT_PROCESS'] = '2';

					 $NotifyDetail = $this->incident_model->getNotifyTableData($id,$_POST['INCIDENT_INVESTIGATION_IDD']);
				     //echo '<pre>';print_r($NotifyDetail);exit;
				     $datas = array();
				     $datas['INCIDENT_ID'] = $NotifyDetail['INCIDENT_ID'];
				     $datas['INCIDENT_NOTIFY_ID'] = $NotifyDetail['INCIDENT_NOTIFY_ID'];
				     $datas['EVENT_DATE'] = $NotifyDetail['EVENT_DATE'];
				     $datas['EVENT_TIME'] = $NotifyDetail['EVENT_TIME'];
				     $datas['LOCATION_ID'] = $NotifyDetail['LOCATION_ID'];
				     $datas['SPECIFIC_LOCATION_ID'] = $NotifyDetail['SPECIFIC_LOCATION_ID'];
				     $datas['SPECIFIC_LOCATION_OTHER'] = $NotifyDetail['SPECIFIC_LOCATION_OTHER'];
				     $datas['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
				     $datas['PREPARED_BY'] = $_SESSION['id'];
				     $datas['CREATED_ON'] = $createdOn;
				     $datas['UPDATED_ON'] = $updatedOn;

				     $datas['INC_AUTHORITY_INVOLVED'] = $NotifyDetail['INC_AUTHORITY_INVOLVED'];
				     $datas['AUTHORITY_INVOLVED_DETAIL'] = $NotifyDetail['AUTHORITY_INVOLVED_DETAIL'];
				     $datas['INJURED_PERSON'] = $NotifyDetail['INJURED_PERSON'];
					 $datas['COMPETENCY_RECORDS'] = $NotifyDetail['COMPETENCY_RECORDS'];
				     $datas['IMMEDIATE_CAUSES'] = $NotifyDetail['IMMEDIATE_CAUSES'];
					 $datas['POSSIBLE_ROOT_CAUSES'] = $NotifyDetail['POSSIBLE_ROOT_CAUSES'];
					 $datas['CONTRIBUTE_CAUSAL_FACTOR'] = $NotifyDetail['CONTRIBUTE_CAUSAL_FACTOR'];
					 $datas['HAZARD_RISK_IDENTIFY'] = $NotifyDetail['HAZARD_RISK_IDENTIFY'];
					 $datas['ACCITENT_AVOIDABLE '] = $NotifyDetail['ACCITENT_AVOIDABLE'];
					 $datas['INVEST_PROPOSED_ACTION'] = $NotifyDetail['INVEST_PROPOSED_ACTION'];
					 $datas['INCIDENT_WORK_RELATED'] = $NotifyDetail['INCIDENT_WORK_RELATED'];
					 $datas['ACTIVITY'] = $NotifyDetail['ACTIVITY'];
					 $datas['EMP_CONT'] = $NotifyDetail['EMP_CONT'];
					 $datas['INC_CLASSIFICATION'] = $NotifyDetail['INC_CLASSIFICATION'];
					 $datas['INJURED_PERSON'] = $NotifyDetail['INJURED_PERSON'];
					 $datas['ASSET_DETAILS'] = $NotifyDetail['ASSET_DETAILS'];
				     $datas['CHANGES_PLACE'] = '3';
				     $datas['PREPARED_BY'] = $_SESSION['id'];
				     $datas['REVIEWED_BY'] = $_SESSION['id'];
				     $datas['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
				     $datas['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
				     $datas['VERIFIED_BY'] = $_SESSION['id'];
				     $datas['VERIFIED_REMARK'] = $_POST['verifiedBy'];
				     $datas['VERIFIED_STATUS'] = $_POST['VerifiedAcpRej'];
				     $datas['APPROVED_STATUS'] = 'R';
				     $datas['APPROVED_BY'] = '0';
				     $datas['APPROVED_REMARK'] = null;

         $insertHistory = $this->incident_model->insertHistoryForNotifyDetail($datas);
$justId = $id;
         $IncidentSubData = $this->incident_model->getEmployeeDetails($_POST['INCIDENT_INVESTIGATION_IDD'],$justId='');
					 unset($IncidentSubData['IncidentInvestigationData']);
					 unset($IncidentSubData['incidentTeamSummary']);
					 unset($IncidentSubData['injuredPersonStatus']);
					 unset($IncidentSubData['injuredAssetStatus']);

    	             $n =max(array_keys($IncidentSubData['investigationAllDetails']));
              
			            for($i=0;$i<=$n;$i++)
			            {
			                if(isset($IncidentSubData['investigationAllDetails'][$i])&&$IncidentSubData['investigationAllDetails'][$i]!=''){
			                	
			                $result = array();
			                $result['EMP_NAME'] = $IncidentSubData['investigationAllDetails'][$i]['EMP_NAME'];
			                $result['INVES_TEAM_EMP_ID'] = $IncidentSubData['investigationAllDetails'][$i]['EMP_ID'];
			                $result['DESIGNATION_ID'] = $IncidentSubData['investigationAllDetails'][$i]['DESIGNATION_ID'];
			                $result['PHONE_NO'] = $IncidentSubData['investigationAllDetails'][$i]['PHONE_NO'];
			                $result['INVESTIGATION_TEAM_SUMMARY'] = $IncidentSubData['investigationAllDetails'][$i]['INVESTIGATION_TEAM_SUMMARY'];
			                $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
			                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
			                $result['CHANGES_PLACE'] = '2';
							$result['PREPARED_BY'] = $_SESSION['id'];
						     $result['REVIEWED_BY'] = $_SESSION['id'];
						     $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
				             $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
						     $result['VERIFIED_BY'] = $_SESSION['id'];
						     $result['VERIFIED_REMARK'] = $_POST['verifiedBy'];
						     $result['VERIFIED_STATUS'] = $_POST['VerifiedAcpRej'];
						     $result['APPROVED_STATUS'] = 'R';
						     $result['APPROVED_BY'] = '0';
						     $result['APPROVED_REMARK'] = null;
							$result['SUB_TABLE_NAME'] = 'INCIDENT_INVESTIGATION_TEAM';
			                $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
			              
			                }

                          }
                          $n =max(array_keys($IncidentSubData['superiorAllDetails']));
          
								for($i=0;$i<=$n;$i++)
								{
								if(isset($IncidentSubData['superiorAllDetails'][$i])&&$IncidentSubData['superiorAllDetails'][$i]!=''){

								$result = array();
								$result['EMP_ID'] = $IncidentSubData['superiorAllDetails'][$i]['EMP_ID'];
								$result['NAME'] = $IncidentSubData['superiorAllDetails'][$i]['NAME'];
								$result['PHONE'] = $IncidentSubData['superiorAllDetails'][$i]['PHONE'];
								$result['PRESENT'] = $IncidentSubData['superiorAllDetails'][$i]['PRESENT'];
								$result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
				                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
								$result['CHANGES_PLACE'] = '2';
								$result['PREPARED_BY'] = $_SESSION['id'];
							     $result['REVIEWED_BY'] = $_SESSION['id'];
							      $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
				                  $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
							     $result['VERIFIED_BY'] = $_SESSION['id'];
							     $result['VERIFIED_REMARK'] = $_POST['verifiedBy'];
							     $result['VERIFIED_STATUS'] = $_POST['VerifiedAcpRej'];
							     $result['APPROVED_STATUS'] = 'R';
							     $result['APPROVED_BY'] = '0';
							     $result['APPROVED_REMARK'] = null;
								$result['SUB_TABLE_NAME'] = 'INCIDENT_SUPERVISOR_SUPERIOR_DETAIL';
								$insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);

								}

								}

					 $n =max(array_keys($IncidentSubData['AssetAllDetails']));
          
						        for($i=0;$i<=$n;$i++)
						        {
						            if(isset($IncidentSubData['AssetAllDetails'][$i])&&$IncidentSubData['AssetAllDetails'][$i]!=''){
						            	
						            $result = array();
						            $result['DESCRIPTION'] = $IncidentSubData['AssetAllDetails'][$i]['DESCRIPTION'];
						            $result['NAME_OF_OPERATOR_DRIVER_MASTER'] = $IncidentSubData['AssetAllDetails'][$i]['NAME_OF_OPERATOR_DRIVER_MASTER'];
						            $result['ASSET_PHONE_NO'] = $IncidentSubData['AssetAllDetails'][$i]['PHONE_NO'];
						            $result['OWNER_COMP_NAME'] = $IncidentSubData['AssetAllDetails'][$i]['OWNER_COMP_NAME'];
						            $result['ASSET_PLATE_NO'] = $IncidentSubData['AssetAllDetails'][$i]['PLATE_NO'];
						            $result['EST_COST_OF_DAMAGE'] = $IncidentSubData['AssetAllDetails'][$i]['EST_COST_OF_DAMAGE'];
						            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
					                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
					                $result['CHANGES_PLACE'] = '2';
									$result['PREPARED_BY'] = $_SESSION['id'];
								     $result['REVIEWED_BY'] = $_SESSION['id'];
								      $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
				                      $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
								     $result['VERIFIED_BY'] = $_SESSION['id'];
								     $result['VERIFIED_REMARK'] = $_POST['verifiedBy'];
								     $result['VERIFIED_STATUS'] = $_POST['VerifiedAcpRej'];
								     $result['APPROVED_STATUS'] = 'R';
								     $result['APPROVED_BY'] = '0';
								     $result['APPROVED_REMARK'] = null;
									$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_ASSET_DETAIL';
						            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
						         
						            }

						 }


					  $n =max(array_keys($IncidentSubData['personInterviewd']));
          
					        for($i=0;$i<=$n;$i++)
					        {
					            if(isset($IncidentSubData['personInterviewd'][$i])&&$IncidentSubData['personInterviewd'][$i]!=''){
					            	
					            $result = array();

					            $result['INTERVIEW_EMP_ID'] = $IncidentSubData['personInterviewd'][$i]['EMP_ID'];
					            $result['INTERVIEW_EMP_NAME'] = $IncidentSubData['personInterviewd'][$i]['EMP_NAME'];
					            $result['INTERVIEW_JOB_TITLE'] = $IncidentSubData['personInterviewd'][$i]['JOB_TITLE'];
					            $result['INTERVIEW_PHONE '] = $IncidentSubData['personInterviewd'][$i]['PHONE'];
					            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
				                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
				                $result['CHANGES_PLACE'] = '2';
						    	$result['PREPARED_BY'] = $_SESSION['id'];
							     $result['REVIEWED_BY'] = $_SESSION['id'];
							     $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
				                $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
							     $result['VERIFIED_BY'] = $_SESSION['id'];
							     $result['VERIFIED_REMARK'] = $_POST['verifiedBy'];
							     $result['VERIFIED_STATUS'] = $_POST['VerifiedAcpRej'];
							     $result['APPROVED_STATUS'] = 'R';
							     $result['APPROVED_BY'] = '0';
							     $result['APPROVED_REMARK'] = null;
								$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_INTERVIEWED_DETAIL';
					            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
					         
					            }
					        }
					             $n =max(array_keys($IncidentSubData['activePlanAllDetails']));
          
							        for($i=0;$i<=$n;$i++)
							        {
							            if(isset($IncidentSubData['activePlanAllDetails'][$i])&&$IncidentSubData['activePlanAllDetails'][$i]!=''){
							            	
							            $result = array();
							            
							            $result['CA_PA_DESC'] = $IncidentSubData['activePlanAllDetails'][$i]['CA_PA_DESC'];
							            $result['RESPOSIBILITY_ID'] = $IncidentSubData['activePlanAllDetails'][$i]['RESPOSIBILITY_ID'];
							            $result['DATE_BY_WHEN'] = $IncidentSubData['activePlanAllDetails'][$i]['DATE_BY_WHEN'];
							            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
						                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
						                $result['CHANGES_PLACE'] = '2';
										$result['PREPARED_BY'] = $_SESSION['id'];
									     $result['REVIEWED_BY'] = $_SESSION['id'];
									      $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
				                         $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
									     $result['VERIFIED_BY'] = $_SESSION['id'];
									     $result['VERIFIED_REMARK'] = $_POST['verifiedBy'];
									     $result['VERIFIED_STATUS'] = $_POST['VerifiedAcpRej'];
									     $result['APPROVED_STATUS'] = 'R';
									     $result['APPROVED_BY'] = '0';
									     $result['APPROVED_REMARK'] = null;
										$result['SUB_TABLE_NAME'] = 'INCIDENT_ACTION_PLAN';
							            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
							         
							            }
							        }

					 			$n =max(array_keys($IncidentSubData['circumstanceDetails']));
          
									    for($i=0;$i<=$n;$i++)
									    {
									        if(isset($IncidentSubData['circumstanceDetails'][$i])&&$IncidentSubData['circumstanceDetails'][$i]!=''){
									        	
									        $result = array();
									        
									        $result['CIRCUMSTANCE_DESC'] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'];
									        $result['CIRCUMSTANCE_DESC_FIVE'] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'];
									        $result['CIRCUMSTANCE_DESC_FOUR'] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'];
									        $result['CIRCUMSTANCE_DESC_THREE '] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'];
									        $result['CIRCUMSTANCE_DESC_TWO '] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'];
									        $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
							                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
							                $result['CHANGES_PLACE'] = '2';
											$result['PREPARED_BY'] = $_SESSION['id'];
										     $result['REVIEWED_BY'] = $_SESSION['id'];
										      $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
				                             $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
										     $result['VERIFIED_BY'] = $_SESSION['id'];
										     $result['VERIFIED_REMARK'] = $_POST['verifiedBy'];
										     $result['VERIFIED_STATUS'] = $_POST['VerifiedAcpRej'];
										     $result['APPROVED_STATUS'] = 'R';
										     $result['APPROVED_BY'] = '0';
										     $result['APPROVED_REMARK'] = null;
											$result['SUB_TABLE_NAME'] = 'INCIDENT_CIRCUMSTANCE_INFO';
									        $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
									     
									        }
									    }

					             $n =max(array_keys($IncidentSubData['attachAllDetail']));
          
								        for($i=0;$i<=$n;$i++)
								        {
								            if(isset($IncidentSubData['attachAllDetail'][$i])&&$IncidentSubData['attachAllDetail'][$i]!=''){
								            	
								            $result = array();
								            
								            $result['INVEST_DOC_TYPE'] = $IncidentSubData['attachAllDetail'][$i]['INVEST_DOC_TYPE'];
								            $result['FILE_PATH'] = $IncidentSubData['attachAllDetail'][$i]['FILE_PATH'];
								            $result['FILE_ORG_FILENAME'] = $IncidentSubData['attachAllDetail'][$i]['FILE_ORG_FILENAME'];
								            $result['FILE_NAME '] = $IncidentSubData['attachAllDetail'][$i]['FILE_NAME'];
								            $result['FILE_SIZE '] = $IncidentSubData['attachAllDetail'][$i]['FILE_SIZE'];
								            $result['FILE_EXT '] = $IncidentSubData['attachAllDetail'][$i]['FILE_EXT'];
								            $result['DESCRIPTION '] = $IncidentSubData['attachAllDetail'][$i]['DESCRIPTION'];
								            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
							                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
							                $result['CHANGES_PLACE'] = '2';
											$result['PREPARED_BY'] = $_SESSION['id'];
										     $result['REVIEWED_BY'] = $_SESSION['id'];
										     $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
				                             $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
										     $result['VERIFIED_BY'] = $_SESSION['id'];
										     $result['VERIFIED_REMARK'] = $_POST['verifiedBy'];
										     $result['VERIFIED_STATUS'] = $_POST['VerifiedAcpRej'];
										     $result['APPROVED_STATUS'] = 'R';
										     $result['APPROVED_BY'] = '0';
										     $result['APPROVED_REMARK'] = null;
											$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_ATTACHMENT';
								            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
								         
								            }
								        }

								        $n =max(array_keys($IncidentSubData['injuredAllDetails']));
          
								        for($i=0;$i<=$n;$i++)
								        {
								            if(isset($IncidentSubData['injuredAllDetails'][$i])&&$IncidentSubData['injuredAllDetails'][$i]!=''){
								            	
								            $result = array();
								            $result['PERSON_NAME'] = $IncidentSubData['injuredAllDetails'][$i]['PERSON_NAME'];
								            $result['SEX'] = $IncidentSubData['injuredAllDetails'][$i]['SEX'];
								            $result['AGE'] = $IncidentSubData['injuredAllDetails'][$i]['AGE'];
								            $result['JOB_TITLE'] = $IncidentSubData['injuredAllDetails'][$i]['JOB_TITLE'];
								            $result['CITIZENSHIP'] = $IncidentSubData['injuredAllDetails'][$i]['CITIZENSHIP'];
								            $result['ID_TYPE'] = $IncidentSubData['injuredAllDetails'][$i]['ID_TYPE'];
								            $result['IC_PASSPORT_NO'] = $IncidentSubData['injuredAllDetails'][$i]['IC_PASSPORT_NO'];
								            $result['CONT_COMPANY_NAME'] = $IncidentSubData['injuredAllDetails'][$i]['CONT_COMPANY_NAME'];
								            $result['INJURY_TYPE'] = $IncidentSubData['injuredAllDetails'][$i]['INJURY_TYPE'];
								            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
							                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
							                $result['CHANGES_PLACE'] = '2';
											$result['PREPARED_BY'] = $_SESSION['id'];
										     $result['REVIEWED_BY'] = $_SESSION['id'];
										     $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
				                             $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
										     $result['VERIFIED_BY'] = $_SESSION['id'];
										     $result['VERIFIED_REMARK'] = $_POST['verifiedBy'];
										     $result['VERIFIED_STATUS'] = $_POST['VerifiedAcpRej'];
										     $result['APPROVED_STATUS'] = 'R';
										     $result['APPROVED_BY'] = '0';
										     $result['APPROVED_REMARK'] = null;
											$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_INJURED_PERSON_BODY_INFO';
								            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
								         
								            }
								        }




								            $result = array();
								            $result['INVEST_DOC_TYPE'] = $IncidentSubData['rootUpload']['INVEST_DOC_TYPE'];
								            $result['FILE_PATH'] = $IncidentSubData['rootUpload']['FILE_PATH'];
								            $result['FILE_ORG_FILENAME'] = $IncidentSubData['rootUpload']['FILE_ORG_FILENAME'];
								            $result['FILE_NAME '] = $IncidentSubData['rootUpload']['FILE_NAME'];
								            $result['FILE_SIZE '] = $IncidentSubData['rootUpload']['FILE_SIZE'];
								            $result['FILE_EXT '] = $IncidentSubData['rootUpload']['FILE_EXT'];
								            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
							                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
							                $result['CHANGES_PLACE'] = '2';
											$result['PREPARED_BY'] = $_SESSION['id'];
										     $result['REVIEWED_BY'] = $_SESSION['id'];
										     $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
				                             $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
										     $result['VERIFIED_BY'] = $_SESSION['id'];
										     $result['VERIFIED_REMARK'] = $_POST['verifiedBy'];
										     $result['VERIFIED_STATUS'] = $_POST['VerifiedAcpRej'];
										     $result['APPROVED_STATUS'] = 'R';
										     $result['APPROVED_BY'] = '0';
										     $result['APPROVED_REMARK'] = null;
											$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_ATTACHMENT';
								            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
                                                                            
                       $user_data['USER_ID']=$_SESSION['id'];
			 $user_data['INCIDENT_NOTIFY_ID_DECRYPT']=$id;
			 $user_data['ID'] = $_SESSION['name'];
			 $user_data['INCIDENT_NOTIFY_ID']=decryptval($id);
		     $user_data['MODULE']='Workflow and Approval process - Verified By - Rejected';
		     $user_data['PROCESS']='Workflow and Approval process - Verified By - Rejected';
		     $details = serialize($results);
		     $user_data['VALUE']="Verified By - Rejected".$details;
		     $userAudit = $this->incident_model->InsertActiveofUserAudit($user_data); 

								            $subject = 'Workflow and Approval process - Verified By - Rejected';
                                                                            
                                                                            $roldId = '7,6';
                                                                                $RejectedIds = $this->incident_model->getHsseEmail($roldId);
                                                                                foreach($RejectedIds as $r){
                                                                                   $HSSEDts =  $this->incident_model->getHSSEDtsEmail($r['USERNAME'] , $dpt='' , $desn='');
         
                                                                                foreach($HSSEDts as $h){
                                                                                    $toemail = $h['emailId'];
                                                                                    
									      
									        $ids = decryptval($id);
									        $getNotifyDetails = $this->incident_model->getAllNotify($ids);
									       $LocationName = $this->incident_model->getLocationName($getNotifyDetails['LOCATION_ID'],$getNotifyDetails['SPECIFIC_LOCATION_ID']);
									        $eventTypeDt = $this->incident_model->getEventTypes1($getNotifyDetails['EVENT_TYPE_IDS'],$id);
									        $eventDate = date('d-m-Y',strtotime($getNotifyDetails['EVENT_DATE']));
                                                                                $statusVer = 'Revert with remark';
                                                                                $Verified = $_SESSION['emp_details']->EMP_NAME . ' - ' . $_SESSION['emp_details']->design_name ;
									        
									        

									        
									        $specificLocation = $getNotifyDetails['specificLocation'];
									        if($specificLocation == '-1'){
									        	$specLocName = 'Other';
									        }
									        else{
									        	$specLocName = $LocationName['SPECIFIC_LOC_NAME'];
									        }
									        
									            
									        $message =  'Incident investigation has been submitted with following details :'.'<br>'.'<br>'.'<br>'.
                                                                                        
                                                                                        'Notification No             :  ' .$ids .'<br>'.
									                    'Event Date                  :  ' .$eventDate  .'<br>'.
									                    'Event Time                  :  ' .$getNotifyDetails['EVENT_TIME']  .'<br>'.
									                    'Location                    :  ' .$LocationName['TERMINAL_SHORTNAME']  .'<br>'.
									                    'Specific Location           :  ' .$specLocName  .'<br>'.
                                                                                            'Event Type                  :  ' .$eventTypeDt['EVENT_TYPE_NAME'].'<br>'.
									                    'Event Description           :  ' .$getNotifyDetails['EVENT_DESC']  .'<br>'.
									                    'Reported By                 :  ' .$getNotifyDetails['EVENT_REPORT_NAME']  . '  -  '  . $getNotifyDetails['EVENT_REPORT_DESIGNATION'] .'<br>'.
									                    'Verify by                 :  ' .$Verified .'<br>'.
									                    'Status                 :  ' .$statusVer .'<br>'.
									                    'Remark                   : '.$_POST['verifiedBy'] . '<br>'
									                    ;

									                    									                
									                
									                
									              //  ;
									        
									         
									        
									        $tempdata = array(
									                    'view_file' => 'common/email/Notification_mail',
									                    'messageText' => $message,
									                    'footerText' => ''
									                   
									        );
									       
									       $template = $this->template->load_email_template($tempdata); 
									        
									       $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
 $notifyUrl = 'incident/ViewList/'.$id;
       
       
        $notifydata = [
            'text' => $message,
            'url' => $notifyUrl,
            'type' => '1',
            'notifygroup' => $h['EMP_AUTO_ID'],
           'employee' => $r['LOGIN_ID'],
            'mobilelink' => '',
          ];
          insertNotifications($notifydata);
                                                                                }
                                                                                }
                                                                               
                                                                               
                                                                               
            }
            else{
                
                $user_data['USER_ID']=$_SESSION['id'];
			 $user_data['INCIDENT_NOTIFY_ID_DECRYPT']=$id;
			 $user_data['ID'] = $_SESSION['name'];
			 $user_data['INCIDENT_NOTIFY_ID']=decryptval($id);
		     $user_data['MODULE']='Workflow and Approval process - Verified By - Approved';
		     $user_data['PROCESS']='Workflow and Approval process - Verified By - Approved';
		     $details = serialize($results);
		     $user_data['VALUE']="Verified By - Approved".$details;
		     $userAudit = $this->incident_model->InsertActiveofUserAudit($user_data); 
                
                $ids = decryptval($id);
                $notifyids = $this->incident_model->updateNotify($status,$ids);
            $results['SUMBIT_PROCESS'] = '4';

            $subject = 'Workflow and Approval process - Verified By - Approved';
             $roldId = '9';
                                                                                $RejectedIds = $this->incident_model->getHsseEmail($roldId);
                                                                                foreach($RejectedIds as $r){
                                                                                   $HSSEDts =  $this->incident_model->getHSSEDtsEmail($r['USERNAME'] , $dpt='' , $desn='');
         
                                                                                foreach($HSSEDts as $h){
                                                                                    $toemail = $h['emailId'];
                                                                                    
									        
									        $ids = decryptval($id);
									        $getNotifyDetails = $this->incident_model->getAllNotify($ids);
									       $LocationName = $this->incident_model->getLocationName($getNotifyDetails['LOCATION_ID'],$getNotifyDetails['SPECIFIC_LOCATION_ID']);
									        $eventTypeDt = $this->incident_model->getEventTypes1($getNotifyDetails['EVENT_TYPE_IDS'],$id);
									        $eventDate = date('d-m-Y',strtotime($getNotifyDetails['EVENT_DATE']));
                                                                                $statusVer = 'Verify Accepted';
                                                                                $Verified = $_SESSION['emp_details']->EMP_NAME . ' - ' . $_SESSION['emp_details']->design_name ;
									        
									        

									        
									        $specificLocation = $getNotifyDetails['SPECIFIC_LOCATION_ID'];
									        if($specificLocation == '-1'){
									        	$specLocName = 'Other';
									        }
									        else{
									        	$specLocName = $LocationName['SPECIFIC_LOC_NAME'];
									        }
									        
									            
									        $message =  'Incident investigation has been submitted with following details :'.'<br>'.'<br>'.'<br>'.
                                                                                        
                                                                                        
                                                                                        'Notification No             :  ' .$ids .'<br>'.
									                    'Event Date                  :  ' .$eventDate  .'<br>'.
									                    'Event Time                  :  ' .$getNotifyDetails['EVENT_TIME']  .'<br>'.
									                    'Location                    :  ' .$LocationName['TERMINAL_SHORTNAME']  .'<br>'.
									                    'Specific Location           :  ' .$specLocName  .'<br>'.
                                                                                            'Event Type                  :  ' .$eventTypeDt['EVENT_TYPE_NAME'].'<br>'.
									                    'Event Description           :  ' .$getNotifyDetails['EVENT_DESC']  .'<br>'.
									                    'Reported By                 :  ' .$getNotifyDetails['EVENT_REPORT_NAME']  . '  -  '  . $getNotifyDetails['EVENT_REPORT_DESIGNATION'] .'<br>'.
									                    'Verify by                 :  ' .$Verified .'<br>'.
									                    'Status                 :  ' .$statusVer .'<br>'.
									                    'Remark                   : '.$_POST['verifiedBy'] . '<br>'
									                    ;

									                    									                
									                
									                
									              //  ;
									        
									         
									        
									        $tempdata = array(
									                    'view_file' => 'common/email/Notification_mail',
									                    'messageText' => $message,
									                    'footerText' => ''
									                   
									        );
									       
									       $template = $this->template->load_email_template($tempdata); 
									        
									    $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
         
                                                                            
                                                                           $notifyUrl = 'incident/ViewList/'.$id;
       
       
        $notifydata = [
            'text' => $message,
            'url' => $notifyUrl,
            'type' => '1',
            'notifygroup' => $h['EMP_AUTO_ID'],
           'employee' => $r['LOGIN_ID'],
            'mobilelink' => '',
          ];
          insertNotifications($notifydata);  
                                                                                }
                                                                                }
                                                                            
                                                                            
                                                                                }

    	}
    	else if($_POST['approvedBy'] != ""){
    		unset($_POST['reviewdBy']);
    		unset($_POST['ReviewAcpRej']);
    		unset($_POST['verifiedBy']);
    		unset($_POST['VerifiedAcpRej']);
    		$results = array();
    	    $results['APPROVED_BY'] = $_SESSION['id'];
$results['APPROVED_DATE'] = date('Y-m-d H:i:s');
    	    $results['APPROVED_REMARK'] = $_POST['approvedBy'];
    	    $results['APPROVED_STATUS'] = $_POST['ApprovedAcpRej'];
    	    if($_POST['ApprovedAcpRej'] == 'R'){
    	    	 $createdOn = date('Y-m-d H:i:s');
                 $updatedOn = date('Y-m-d H:i:s');
                 $ids = decryptval($id);
                     $notifyids = $this->incident_model->updateNotify($status,$ids);
    	         $results['SUMBIT_PROCESS'] = '3';

					 $NotifyDetail = $this->incident_model->getNotifyTableData($id,$_POST['INCIDENT_INVESTIGATION_IDD']);
					 
					 $datas = array();
					 $datas['INCIDENT_ID'] = $NotifyDetail['INCIDENT_ID'];
					 $datas['INCIDENT_NOTIFY_ID'] = $NotifyDetail['INCIDENT_NOTIFY_ID'];
					 $datas['EVENT_DATE'] = $NotifyDetail['EVENT_DATE'];
					 $datas['EVENT_TIME'] = $NotifyDetail['EVENT_TIME'];
					 $datas['LOCATION_ID'] = $NotifyDetail['LOCATION_ID'];
					 $datas['SPECIFIC_LOCATION_ID'] = $NotifyDetail['SPECIFIC_LOCATION_ID'];
					 $datas['SPECIFIC_LOCATION_OTHER'] = $NotifyDetail['SPECIFIC_LOCATION_OTHER'];
					 $datas['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
					 $datas['PREPARED_BY'] = $_SESSION['id'];
					 $datas['CREATED_ON'] = $createdOn;
					 $datas['UPDATED_ON'] = $updatedOn;

					 $datas['INC_AUTHORITY_INVOLVED'] = $NotifyDetail['INC_AUTHORITY_INVOLVED'];
					 $datas['AUTHORITY_INVOLVED_DETAIL'] = $NotifyDetail['AUTHORITY_INVOLVED_DETAIL'];
					 $datas['INJURED_PERSON'] = $NotifyDetail['INJURED_PERSON'];
					 $datas['COMPETENCY_RECORDS'] = $NotifyDetail['COMPETENCY_RECORDS'];
					 $datas['IMMEDIATE_CAUSES'] = $NotifyDetail['IMMEDIATE_CAUSES'];
					 $datas['POSSIBLE_ROOT_CAUSES'] = $NotifyDetail['POSSIBLE_ROOT_CAUSES'];
					 $datas['CONTRIBUTE_CAUSAL_FACTOR'] = $NotifyDetail['CONTRIBUTE_CAUSAL_FACTOR'];
					 $datas['HAZARD_RISK_IDENTIFY'] = $NotifyDetail['HAZARD_RISK_IDENTIFY'];
					 $datas['ACCITENT_AVOIDABLE '] = $NotifyDetail['ACCITENT_AVOIDABLE'];
					 $datas['INVEST_PROPOSED_ACTION'] = $NotifyDetail['INVEST_PROPOSED_ACTION'];
					 $datas['INCIDENT_WORK_RELATED'] = $NotifyDetail['INCIDENT_WORK_RELATED'];
					 $datas['ACTIVITY'] = $NotifyDetail['ACTIVITY'];
					 $datas['EMP_CONT'] = $NotifyDetail['EMP_CONT'];
					 $datas['INC_CLASSIFICATION'] = $NotifyDetail['INC_CLASSIFICATION'];
					 $datas['INJURED_PERSON'] = $NotifyDetail['INJURED_PERSON'];
					 $datas['ASSET_DETAILS'] = $NotifyDetail['ASSET_DETAILS'];
					 $datas['CHANGES_PLACE'] = '4';
					 $datas['PREPARED_BY'] = $_SESSION['id'];
					 $datas['REVIEWED_BY'] = $_SESSION['id'];
					 $datas['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
					 $datas['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
					 $datas['VERIFIED_BY'] = $_SESSION['id'];
					 $datas['VERIFIED_REMARK'] = $NotifyDetail['VERIFIED_REMARK'];
					 $datas['VERIFIED_STATUS'] = $NotifyDetail['VERIFIED_STATUS'];
					 $datas['APPROVED_STATUS'] = $_POST['ApprovedAcpRej'];
					 $datas['APPROVED_BY'] = $_SESSION['id'];
					 $datas['APPROVED_REMARK'] = $_POST['approvedBy'];

         $insertHistory = $this->incident_model->insertHistoryForNotifyDetail($datas);
         $justId = $id;
         $IncidentSubData = $this->incident_model->getEmployeeDetails($_POST['INCIDENT_INVESTIGATION_IDD'],$justId='');
					 unset($IncidentSubData['IncidentInvestigationData']);
					 unset($IncidentSubData['incidentTeamSummary']);
					 unset($IncidentSubData['injuredPersonStatus']);
					 unset($IncidentSubData['injuredAssetStatus']);

    	             $n =max(array_keys($IncidentSubData['investigationAllDetails']));
              
			            for($i=0;$i<=$n;$i++)
			            {
			                if(isset($IncidentSubData['investigationAllDetails'][$i])&&$IncidentSubData['investigationAllDetails'][$i]!=''){
			                	
			                $result = array();
			                $result['EMP_NAME'] = $IncidentSubData['investigationAllDetails'][$i]['EMP_NAME'];
			                $result['INVES_TEAM_EMP_ID'] = $IncidentSubData['investigationAllDetails'][$i]['EMP_ID'];
			                $result['DESIGNATION_ID'] = $IncidentSubData['investigationAllDetails'][$i]['DESIGNATION_ID'];
			                $result['PHONE_NO'] = $IncidentSubData['investigationAllDetails'][$i]['PHONE_NO'];
			                $result['INVESTIGATION_TEAM_SUMMARY'] = $IncidentSubData['investigationAllDetails'][$i]['INVESTIGATION_TEAM_SUMMARY'];
			                $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
			                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
			                $result['CHANGES_PLACE'] = '3';
							 $result['PREPARED_BY'] = $_SESSION['id'];
							 $result['REVIEWED_BY'] = $_SESSION['id'];
							 $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
							 $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
							 $result['VERIFIED_BY'] = $_SESSION['id'];
							 $result['VERIFIED_REMARK'] = $NotifyDetail['VERIFIED_REMARK'];
							 $result['VERIFIED_STATUS'] = $NotifyDetail['VERIFIED_STATUS'];
							 $result['APPROVED_STATUS'] = $_POST['ApprovedAcpRej'];
							 $result['APPROVED_BY'] = $_SESSION['id'];
							 $result['APPROVED_REMARK'] = $_POST['approvedBy'];
							$result['SUB_TABLE_NAME'] = 'INCIDENT_INVESTIGATION_TEAM';
			                $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
			              
			                }

                          }
                          $n =max(array_keys($IncidentSubData['superiorAllDetails']));
          
								for($i=0;$i<=$n;$i++)
								{
								if(isset($IncidentSubData['superiorAllDetails'][$i])&&$IncidentSubData['superiorAllDetails'][$i]!=''){

								$result = array();
								$result['EMP_ID'] = $IncidentSubData['superiorAllDetails'][$i]['EMP_ID'];
								$result['NAME'] = $IncidentSubData['superiorAllDetails'][$i]['NAME'];
								$result['PHONE'] = $IncidentSubData['superiorAllDetails'][$i]['PHONE'];
								$result['PRESENT'] = $IncidentSubData['superiorAllDetails'][$i]['PRESENT'];
								$result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
				                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
								$result['CHANGES_PLACE'] = '3';
								 $result['PREPARED_BY'] = $_SESSION['id'];
								 $result['REVIEWED_BY'] = $_SESSION['id'];
								 $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
								 $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
								 $result['VERIFIED_BY'] = $_SESSION['id'];
								 $result['VERIFIED_REMARK'] = $NotifyDetail['VERIFIED_REMARK'];
								 $result['VERIFIED_STATUS'] = $NotifyDetail['VERIFIED_STATUS'];
								 $result['APPROVED_STATUS'] = $_POST['ApprovedAcpRej'];
								 $result['APPROVED_BY'] = $_SESSION['id'];
								 $result['APPROVED_REMARK'] = $_POST['approvedBy'];
							     $result['APPROVED_REMARK'] = null;
								$result['SUB_TABLE_NAME'] = 'INCIDENT_SUPERVISOR_SUPERIOR_DETAIL';
								$insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);

								}

								}

					 $n =max(array_keys($IncidentSubData['AssetAllDetails']));
          
						        for($i=0;$i<=$n;$i++)
						        {
						            if(isset($IncidentSubData['AssetAllDetails'][$i])&&$IncidentSubData['AssetAllDetails'][$i]!=''){
						            	
						            $result = array();
						            $result['DESCRIPTION'] = $IncidentSubData['AssetAllDetails'][$i]['DESCRIPTION'];
						            $result['NAME_OF_OPERATOR_DRIVER_MASTER'] = $IncidentSubData['AssetAllDetails'][$i]['NAME_OF_OPERATOR_DRIVER_MASTER'];
						            $result['ASSET_PHONE_NO'] = $IncidentSubData['AssetAllDetails'][$i]['PHONE_NO'];
						            $result['OWNER_COMP_NAME'] = $IncidentSubData['AssetAllDetails'][$i]['OWNER_COMP_NAME'];
						            $result['ASSET_PLATE_NO'] = $IncidentSubData['AssetAllDetails'][$i]['PLATE_NO'];
						            $result['EST_COST_OF_DAMAGE'] = $IncidentSubData['AssetAllDetails'][$i]['EST_COST_OF_DAMAGE'];
						            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
					                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
					                $result['CHANGES_PLACE'] = '3';
									 $result['PREPARED_BY'] = $_SESSION['id'];
									 $result['REVIEWED_BY'] = $_SESSION['id'];
									 $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
									 $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
									 $result['VERIFIED_BY'] =$_SESSION['id'];
									 $result['VERIFIED_REMARK'] = $NotifyDetail['VERIFIED_REMARK'];
									 $result['VERIFIED_STATUS'] = $NotifyDetail['VERIFIED_STATUS'];
									 $result['APPROVED_STATUS'] = $_POST['ApprovedAcpRej'];
									 $result['APPROVED_BY'] = $_SESSION['id'];
									 $result['APPROVED_REMARK'] = $_POST['approvedBy'];
									$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_ASSET_DETAIL';
						            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
						         
						            }

						 }

						 $n =max(array_keys($IncidentSubData['injuredAllDetails']));
          
						        for($i=0;$i<=$n;$i++)
						        {
						            if(isset($IncidentSubData['injuredAllDetails'][$i])&&$IncidentSubData['injuredAllDetails'][$i]!=''){
						            	
						            $result = array();
						            $result['PERSON_NAME'] = $IncidentSubData['injuredAllDetails'][$i]['PERSON_NAME'];
						            $result['SEX'] = $IncidentSubData['injuredAllDetails'][$i]['SEX'];
						            $result['AGE'] = $IncidentSubData['injuredAllDetails'][$i]['AGE'];
						            $result['JOB_TITLE'] = $IncidentSubData['injuredAllDetails'][$i]['JOB_TITLE'];
						            $result['CITIZENSHIP'] = $IncidentSubData['injuredAllDetails'][$i]['CITIZENSHIP'];
						            $result['ID_TYPE'] = $IncidentSubData['injuredAllDetails'][$i]['ID_TYPE'];
						            $result['IC_PASSPORT_NO'] = $IncidentSubData['injuredAllDetails'][$i]['IC_PASSPORT_NO'];
						            $result['CONT_COMPANY_NAME'] = $IncidentSubData['injuredAllDetails'][$i]['CONT_COMPANY_NAME'];
						            $result['INJURY_TYPE'] = $IncidentSubData['injuredAllDetails'][$i]['INJURY_TYPE'];
						            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
					                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
					                $result['CHANGES_PLACE'] = '3';
									 $result['PREPARED_BY'] = $_SESSION['id'];
									 $result['REVIEWED_BY'] = $_SESSION['id'];
									 $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
									 $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
									 $result['VERIFIED_BY'] = $_SESSION['id'];
									 $result['VERIFIED_REMARK'] = $NotifyDetail['VERIFIED_REMARK'];
									 $result['VERIFIED_STATUS'] = $NotifyDetail['VERIFIED_STATUS'];
									 $result['APPROVED_STATUS'] = $_POST['ApprovedAcpRej'];
									 $result['APPROVED_BY'] = $_SESSION['id'];
									 $result['APPROVED_REMARK'] = $_POST['approvedBy'];
									$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_INJURED_PERSON_BODY_INFO';
						            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
						         
						            }

						 }


					  $n =max(array_keys($IncidentSubData['personInterviewd']));
          
					        for($i=0;$i<=$n;$i++)
					        {
					            if(isset($IncidentSubData['personInterviewd'][$i])&&$IncidentSubData['personInterviewd'][$i]!=''){
					            	
					            $result = array();

					            $result['INTERVIEW_EMP_ID'] = $IncidentSubData['personInterviewd'][$i]['EMP_ID'];
					            $result['INTERVIEW_EMP_NAME'] = $IncidentSubData['personInterviewd'][$i]['EMP_NAME'];
					            $result['INTERVIEW_JOB_TITLE'] = $IncidentSubData['personInterviewd'][$i]['JOB_TITLE'];
					            $result['INTERVIEW_PHONE '] = $IncidentSubData['personInterviewd'][$i]['PHONE'];
					            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
				                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
				                $result['CHANGES_PLACE'] = '3';
								 $result['PREPARED_BY'] = $_SESSION['id'];
								 $result['REVIEWED_BY'] =$_SESSION['id'];
								 $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
								 $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
								 $result['VERIFIED_BY'] = $_SESSION['id'];
								 $result['VERIFIED_REMARK'] = $NotifyDetail['VERIFIED_REMARK'];
								 $result['VERIFIED_STATUS'] = $NotifyDetail['VERIFIED_STATUS'];
								 $result['APPROVED_STATUS'] = $_POST['ApprovedAcpRej'];
								 $result['APPROVED_BY'] = $_SESSION['id'];
								 $result['APPROVED_REMARK'] = $_POST['approvedBy'];
								$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_INTERVIEWED_DETAIL';
					            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
					         
					            }
					        }
					             $n =max(array_keys($IncidentSubData['activePlanAllDetails']));
          
							        for($i=0;$i<=$n;$i++)
							        {
							            if(isset($IncidentSubData['activePlanAllDetails'][$i])&&$IncidentSubData['activePlanAllDetails'][$i]!=''){
							            	
							            $result = array();
							            
							            $result['CA_PA_DESC'] = $IncidentSubData['activePlanAllDetails'][$i]['CA_PA_DESC'];
							            $result['RESPOSIBILITY_ID'] = $IncidentSubData['activePlanAllDetails'][$i]['RESPOSIBILITY_ID'];
							            $result['DATE_BY_WHEN'] = $IncidentSubData['activePlanAllDetails'][$i]['DATE_BY_WHEN'];
							            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
						                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
						                $result['CHANGES_PLACE'] = '3';
							            $result['PREPARED_BY'] = $_SESSION['id'];
										 $result['REVIEWED_BY'] = $_SESSION['id'];
										 $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
										 $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
										 $result['VERIFIED_BY'] = $_SESSION['id'];
										 $result['VERIFIED_REMARK'] = $NotifyDetail['VERIFIED_REMARK'];
										 $result['VERIFIED_STATUS'] = $NotifyDetail['VERIFIED_STATUS'];
										 $result['APPROVED_STATUS'] = $_POST['ApprovedAcpRej'];
										 $result['APPROVED_BY'] = $_SESSION['id'];
										 $result['APPROVED_REMARK'] = $_POST['approvedBy'];
										$result['SUB_TABLE_NAME'] = 'INCIDENT_ACTION_PLAN';
							            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
							         
							            }
							        }

							        $n =max(array_keys($IncidentSubData['attachAllDetail']));
          
								        for($i=0;$i<=$n;$i++)
								        {
								            if(isset($IncidentSubData['attachAllDetail'][$i])&&$IncidentSubData['attachAllDetail'][$i]!=''){
								            	
								            $result = array();
								            
								            $result['INVEST_DOC_TYPE'] = $IncidentSubData['attachAllDetail'][$i]['INVEST_DOC_TYPE'];
								            $result['FILE_PATH'] = $IncidentSubData['attachAllDetail'][$i]['FILE_PATH'];
								            $result['FILE_ORG_FILENAME'] = $IncidentSubData['attachAllDetail'][$i]['FILE_ORG_FILENAME'];
								            $result['FILE_NAME '] = $IncidentSubData['attachAllDetail'][$i]['FILE_NAME'];
								            $result['FILE_SIZE '] = $IncidentSubData['attachAllDetail'][$i]['FILE_SIZE'];
								            $result['FILE_EXT '] = $IncidentSubData['attachAllDetail'][$i]['FILE_EXT'];
								            $result['DESCRIPTION '] = $IncidentSubData['attachAllDetail'][$i]['DESCRIPTION'];
								            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
							                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
							                $result['CHANGES_PLACE'] = '3';
											 $result['PREPARED_BY'] =$_SESSION['id'];
											 $result['REVIEWED_BY'] = $_SESSION['id'];
											 $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
											 $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
											 $result['VERIFIED_BY'] = $_SESSION['id'];
											 $result['VERIFIED_REMARK'] = $NotifyDetail['VERIFIED_REMARK'];
											 $result['VERIFIED_STATUS'] = $NotifyDetail['VERIFIED_STATUS'];
											 $result['APPROVED_STATUS'] = $_POST['ApprovedAcpRej'];
											 $result['APPROVED_BY'] = $_SESSION['id'];
											 $result['APPROVED_REMARK'] = $_POST['approvedBy'];
											$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_ATTACHMENT';
								            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
								         
								            }
								        }
								            $result = array();
								            $result['INVEST_DOC_TYPE'] = $IncidentSubData['rootUpload']['INVEST_DOC_TYPE'];
								            $result['FILE_PATH'] = $IncidentSubData['rootUpload']['FILE_PATH'];
								            $result['FILE_ORG_FILENAME'] = $IncidentSubData['rootUpload']['FILE_ORG_FILENAME'];
								            $result['FILE_NAME '] = $IncidentSubData['rootUpload']['FILE_NAME'];
								            $result['FILE_SIZE '] = $IncidentSubData['rootUpload']['FILE_SIZE'];
								            $result['FILE_EXT '] = $IncidentSubData['rootUpload']['FILE_EXT'];
								            $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
							                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
							                $result['CHANGES_PLACE'] = '3';
											 $result['PREPARED_BY'] = $_SESSION['id'];
											 $result['REVIEWED_BY'] = $_SESSION['id'];
											 $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
											 $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
											 $result['VERIFIED_BY'] = $_SESSION['id'];
											 $result['VERIFIED_REMARK'] = $NotifyDetail['VERIFIED_REMARK'];
											 $result['VERIFIED_STATUS'] = $NotifyDetail['VERIFIED_STATUS'];
											 $result['APPROVED_STATUS'] = $_POST['ApprovedAcpRej'];
											 $result['APPROVED_BY'] = $_SESSION['id'];
											 $result['APPROVED_REMARK'] = $_POST['approvedBy'];
											$result['SUB_TABLE_NAME'] = 'INCIDENT_INVEST_ATTACHMENT';
								            $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);


					 			$n =max(array_keys($IncidentSubData['circumstanceDetails']));
          
									    for($i=0;$i<=$n;$i++)
									    {
									        if(isset($IncidentSubData['circumstanceDetails'][$i])&&$IncidentSubData['circumstanceDetails'][$i]!=''){
									        	
									        $result = array();
									        
									        $result['CIRCUMSTANCE_DESC'] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'];
									        $result['CIRCUMSTANCE_DESC_FIVE'] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'];
									        $result['CIRCUMSTANCE_DESC_FOUR'] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'];
									        $result['CIRCUMSTANCE_DESC_THREE '] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'];
									        $result['CIRCUMSTANCE_DESC_TWO '] = $IncidentSubData['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'];
									        $result['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
							                $result['INCIDENT_NOTIFY_ID'] = decryptval($id);
							                $result['CHANGES_PLACE'] = '3';
											 $result['PREPARED_BY'] = $_SESSION['id'];
											 $result['REVIEWED_BY'] = $_SESSION['id'];
											 $result['REVIEWED_REMARK'] = $NotifyDetail['REVIEWED_REMARK'];
											 $result['REVIEWED_STATUS'] = $NotifyDetail['REVIEWED_STATUS'];
											 $result['VERIFIED_BY'] = $_SESSION['id'];
											 $result['VERIFIED_REMARK'] = $NotifyDetail['VERIFIED_REMARK'];
											 $result['VERIFIED_STATUS'] = $NotifyDetail['VERIFIED_STATUS'];
											 $result['APPROVED_STATUS'] = $_POST['ApprovedAcpRej'];
											 $result['APPROVED_BY'] = $_SESSION['id'];
											 $result['APPROVED_REMARK'] = $_POST['approvedBy'];
											 $result['SUB_TABLE_NAME'] = 'INCIDENT_CIRCUMSTANCE_INFO';
									         $insertHistory = $this->incident_model->insertHistoryForIncidentSubDetail($result);
									     
									        }
									    }
                                                                            
                                                                            $user_data['USER_ID']=$_SESSION['id'];
			 $user_data['INCIDENT_NOTIFY_ID_DECRYPT']=$id;
			 $user_data['ID'] = $_SESSION['name'];
			 $user_data['INCIDENT_NOTIFY_ID']=decryptval($id);
		     $user_data['MODULE']='Workflow and Approval process - Approved By - Rejected';
		     $user_data['PROCESS']='Workflow and Approval process - Approved By - Rejected';
		     $details = serialize($results);
		     $user_data['VALUE']="Approved By - Rejected".$details;
		     $userAudit = $this->incident_model->InsertActiveofUserAudit($user_data); 

									    $subject = 'Workflow and Approval process - Approved By - Rejected';
                                                                            $LocationIdInNotify = $this->incident_model->getLocationIdInNotify($id);
                                                                            $roldId = '8';
                                                                                $RejectedIds = $this->incident_model->getHsseEmail($roldId);
                                                                                 //$dpt = '4,8';
                                                                                 if($LocationIdInNotify['LOCATION_ID'] == 1){
                                                                                        $desn = '22';
                                                                                    }
                                                                                    else if($LocationIdInNotify['LOCATION_ID'] == 2){
                                                                                        $desn = '18';
                                                                                    }
                                                                                    else{
                                                                                      $desn = '';  
                                                                                    }
                                                                                foreach($RejectedIds as $r){
                                                                                   $HSSEDts =  $this->incident_model->getHSSEDtsEmailS($r['USERNAME'] , $dpt='' , $desn);
         
                                                                                foreach($HSSEDts as $h){
                                                                                    $toemail = $h['emailId'];
                                                                                    
									        $ids = decryptval($id);
									        $getNotifyDetails = $this->incident_model->getAllNotify($ids);
									        $LocationName = $this->incident_model->getLocationName($getNotifyDetails['LOCATION_ID'],$getNotifyDetails['SPECIFIC_LOCATION_ID']);
									        $eventTypeDt = $this->incident_model->getEventTypes1($getNotifyDetails['EVENT_TYPE_IDS'],$id);
									        $eventDate = date('d-m-Y',strtotime($getNotifyDetails['EVENT_DATE']));
                                                                                $statusApr = 'Revert with remark';
                                                                                $Approved = $_SESSION['emp_details']->EMP_NAME . ' - ' . $_SESSION['emp_details']->design_name ;
									        
									        

									        
									        $specificLocation = $getNotifyDetails['SPECIFIC_LOCATION_ID'];
									        if($specificLocation == '-1'){
									        	$specLocName = 'Other';
									        }
									        else{
									        	$specLocName = $LocationName['SPECIFIC_LOC_NAME'];
									        }
									        
									            
									        $message =  'Incident investigation has been submitted with following details :'.'<br>'.'<br>'.'<br>'.
                                                                                        
                                                                                        'Notification No             :  ' .$ids .'<br>'.
									                    'Event Date                  :  ' .$eventDate  .'<br>'.
									                    'Event Time                  :  ' .$getNotifyDetails['EVENT_TIME']  .'<br>'.
									                    'Location                    :  ' .$LocationName['TERMINAL_SHORTNAME']  .'<br>'.
									                    'Specific Location           :  ' .$specLocName  .'<br>'.
                                                                                            'Event Type                  :  ' .$eventTypeDt['EVENT_TYPE_NAME'].'<br>'.
									                    'Event Description           :  ' .$getNotifyDetails['EVENT_DESC']  .'<br>'.
									                    'Reported By                 :  ' .$getNotifyDetails['EVENT_REPORT_NAME']  . '  -  '  . $getNotifyDetails['EVENT_REPORT_DESIGNATION'] .'<br>'.
									                    'Approved by                 :  '. $Approved .'<br>'.
									                    'Status                 :  ' .$statusApr .'<br>'.
									                    'Remark                   : '.$_POST['approvedBy'] . '<br>'
									                    ;

									                    									                
									                
									                
									              //  ;
									        
									         
									        
									        $tempdata = array(
									                    'view_file' => 'common/email/Notification_mail',
									                    'messageText' => $message,
									                    'footerText' => ''
									                   
									        );
									       
									       $template = $this->template->load_email_template($tempdata); 
									        
									      $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
 $notifyUrl = 'incident/ViewList/'.$id;
       
       
        $notifydata = [
            'text' => $message,
            'url' => $notifyUrl,
            'type' => '1',
            'notifygroup' => $h['EMP_AUTO_ID'],
           'employee' => $r['LOGIN_ID'],
            'mobilelink' => '',
          ];
          insertNotifications($notifydata);
                                                                                }
                                                                                }
            }
            else{
                
                  $user_data['USER_ID']=$_SESSION['id'];
			 $user_data['INCIDENT_NOTIFY_ID_DECRYPT']=$id;
			 $user_data['ID'] = $_SESSION['name'];
			 $user_data['INCIDENT_NOTIFY_ID']=decryptval($id);
		     $user_data['MODULE']='Workflow and Approval process - Approved By - Approved';
		     $user_data['PROCESS']='Workflow and Approval process - Approved By - Approved';
		     $details = serialize($results);
		     $user_data['VALUE']="Approved By - Approved".$details;
		     $userAudit = $this->incident_model->InsertActiveofUserAudit($user_data); 
                     $ids = decryptval($id);
                     $notifyids = $this->incident_model->updateNotify($status,$ids); 
                     
            $results['SUMBIT_PROCESS'] = '4';

            $subject = 'Workflow and Approval process - Approved By - Approved';
            
            $roldId = '6,7,4,5';
                                                                                $RejectedIds = $this->incident_model->getHsseEmail($roldId);
                                                                                foreach($RejectedIds as $r){
                                                                                    
                                                                                   $HSSEDts =  $this->incident_model->getHSSEDtsEmail($r['USERNAME'] , $dpt='' , $desn='');
        // echo '<pre>';print_r($HSSEDts);exit;
                                                                                foreach($HSSEDts as $h){
                                                                                    
                                                                                    $toemail = $h['emailId'];
									       
									        $ids = decryptval($id);
									        $getNotifyDetails = $this->incident_model->getAllNotify($ids);
									        $LocationName = $this->incident_model->getLocationName($getNotifyDetails['LOCATION_ID'],$getNotifyDetails['SPECIFIC_LOCATION_ID']);
									       // $eventType = $this->incident_model->getEventTypes($getNotifyDetails['EVENT_TYPE_IDS']);
                                                                               
                                                                                $eventTypeDt = $this->incident_model->getEventTypes1($getNotifyDetails['EVENT_TYPE_IDS'],$id);
									        $eventDate = date('d-m-Y',strtotime($getNotifyDetails['EVENT_DATE']));
                                                                                $statusApr = 'Approved';
                                                                                $Approved = $_SESSION['emp_details']->EMP_NAME . ' - ' . $_SESSION['emp_details']->design_name ;
                                                                                
									        
									        

									        
									        $specificLocation = $getNotifyDetails['SPECIFIC_LOCATION_ID'];
									        if($specificLocation == '-1'){
									        	$specLocName = 'Other';
									        }
									        else{
									        	$specLocName = $LocationName['SPECIFIC_LOC_NAME'];
									        }
									        
									            
									        $message =  'Incident investigation has been submitted with following details :'.'<br>'.'<br>'.'<br>'.
                                                                                        
                                                                                        
                                                                                        
                                                                                        'Notification No             :  ' .$ids .'<br>'.
									                    'Event Date                  :  ' .$eventDate  .'<br>'.
									                    'Event Time                  :  ' .$getNotifyDetails['EVENT_TIME']  .'<br>'.
									                    'Location                    :  ' .$LocationName['TERMINAL_SHORTNAME']  .'<br>'.
									                    'Specific Location           :  ' .$specLocName  .'<br>'.
                                                                                            'Event Type                  :  ' .$eventTypeDt['EVENT_TYPE_NAME'].'<br>'.
									                    'Event Description           :  ' .$getNotifyDetails['EVENT_DESC']  .'<br>'.
									                    'Reported By                 :  ' .$getNotifyDetails['EVENT_REPORT_NAME']  . '  -  '  . $getNotifyDetails['EVENT_REPORT_DESIGNATION'] .'<br>'.
									                    'Approved by                 :  ' .$Approved .'<br>'.
									                    'Status                 :  ' .$statusApr .'<br>'.
									                    'Remark                   : '.$_POST['approvedBy'] . '<br>'
									                    ;

									                    									                
									                
									                
									              //  ;
									        
									         
									        
									        $tempdata = array(
									                    'view_file' => 'common/email/Notification_mail',
									                    'messageText' => $message,
									                    'footerText' => ''
									                   
									        );
									       
									       $template = $this->template->load_email_template($tempdata); 
									        
									       $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
           
                                                                                $notifyUrl = 'incident/ViewList/'.$id;
       
       
        $notifydata = [
            'text' => $message,
            'url' => $notifyUrl,
            'type' => '1',
            'notifygroup' => $h['EMP_AUTO_ID'],
           'employee' => $r['LOGIN_ID'],
            'mobilelink' => '',
          ];
          insertNotifications($notifydata);
                                                                                }
                                                                                }
                                                                               
                                                                               
                                                                               
                                                                                }

    	}
    	 
    	//echo '<pre>';print_r($_POST);exit;
    	
    	$results['INCIDENT_INVESTIGATION_ID'] = $_POST['INCIDENT_INVESTIGATION_IDD'];
    	$updateProcess = $this->incident_model->UpadteApprovalProcess($results);

    	 // Active Table ( User Audits )
//			 $user_data['USER_ID']=$_SESSION['id'];
//			 $user_data['INCIDENT_NOTIFY_ID_DECRYPT']=$id;
//			 $user_data['ID'] = $_SESSION['name'];
//			 $user_data['INCIDENT_NOTIFY_ID']=decryptval($id);
//		     $user_data['MODULE']='Workflow and Approval process';
//		     $user_data['PROCESS']='Approval Process';
//		     $details = serialize($results);
//		     $user_data['VALUE']="Workflow and Approval process".$details;
//		     $userAudit = $this->incident_model->InsertActiveofUserAudit($user_data);      

    	if($_POST['ReviewAcpRej'] == 'R'){
          
             $this->session->set_flashdata("incflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Investigation Rejected successfully</div>');
             redirect('incident/investigations');
              }
        else if($_POST['VerifiedAcpRej'] == 'R'){
              $this->session->set_flashdata("incflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Investigation Rejected successfully</div>');
             redirect('incident/investigations');
        }
        else if($_POST['ApprovedAcpRej'] == 'R'){
        	  $this->session->set_flashdata("incflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Investigation Rejected successfully</div>');
             redirect('incident/investigations');
        }
        else if($_POST['ApprovedAcpRej'] == 'A'){
        	$this->session->set_flashdata("incflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span>Investigation Approved successfully</div>');
             redirect('incident/investigations');
        }
        else{

            $this->session->set_flashdata("incflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span>Investigation Approved successfully!</div>');
            redirect('incident/investigations');

        }

    }
     public function FetchEmployeeDetails()
    {
    	
    	$employeeId = $this->input->post('employeeId');
    	$getAllDetails = $this->incident_model->fetchAllDetails($employeeId);
    	echo json_encode($getAllDetails);
    }
    
    public function NotifyPdf($id = ''){

  	$editData = [];
	if ($id != '') {
	    $optWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => decryptval($id)
	    ];
	    $optWhr['return_type'] = 'row';
	    $editData = $this->common_model->getAlldata(INC_NOTIFY_INFO, ['*', 'FN_DATE_FORMAT(EVENT_DATE) as eventDate'], $optWhr);
	    $incid = postData($editData, 'INCIDENT_ID');
	    $optattWhr['where'] = [
		'INC_NOTIFY_ID' => $incid
	    ];
	    $optattWhr['return_type'] = 'result';
	    $editData->notifyAttachments = $this->common_model->getAlldata(INCIDENT_NOTIFY_ATTACHMENT, ['CONCAT(FILE_PATH,FILE_NAME) as fileset'], $optattWhr);
	    $optattWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => $incid
	    ];
	    $optattWhr['return_type'] = 'result';
	    $editData->persons = $this->common_model->getAlldata(INC_NOTIFY_PERSON, ['*'], $optattWhr);
	}

  	$sessiondata = getCurrentUserDetails();
	$role_id = $this->session->role_id;
	$backUrl = BASE_URL . 'incident';
	$reWhr['where'] = [
	    'INCIDENT_EVENT_STATUS' => 'Y'
	];
	$reWhr['return_type'] = 'result';
	$getEventRelate = $this->common_model->getAlldata(INC_EVENT_RELATE, ['*'], $reWhr);
	$typeWhr['where'] = [
	    'EVENT_TYPE_STATUS' => 'Y'
	];
	$typeWhr['return_type'] = 'result';
	$getEventType = $this->common_model->getAlldata(INC_EVENT_TYPE, ['*'], $typeWhr);
	$EventTypeArray = customFormDropDown($getEventType, 'EVENT_TYPE_ID', 'EVENT_TYPE_NAME');
	$loWhr['where'] = [
	    'TERMINAL_STATUS' => 'Y'
	];
	$loWhr['return_type'] = 'result';
	$getLoc = $this->common_model->getAlldata(LOCATION, ['*'], $loWhr);
	$LocArray = customFormDropDown($getLoc, 'TER_AUTO_ID', 'TERMINAL_SHORTNAME', 'Select Location');
	$spWhr['where'] = [
	    'SPECIFIC_LOC_STATUS' => 'Y'
	];
	$spWhr['return_type'] = 'result';
	$getSpecLoc = $this->common_model->getAlldata(SPECIFIC_LOCATION, ['*'], $spWhr);
	$detail = $this->incident_model->getEmployeeDetails($InvestigationId['INCIDENT_INVESTIGATION_ID'],$id);
	$specLocArray = customFormDropDown($getSpecLoc, 'SL_AUTO_ID', 'SPECIFIC_LOC_NAME', 'Select Location');
	$eventRelatedToDt = $this->incident_model->geteventRelatedToDt($editData->EVENT_RELATED_TO_IDS);
	$eventTypeDt = $this->incident_model->geteventTypeDt($editData->EVENT_TYPE_IDS);
        $NotifyId = decryptval($id);
	//echo 'M<pre>';print_r($editData->EVENT_RELATED_TO_IDS);exit;
	$data = array(
	    //'view_file' => 'incident/incident/addnotification',
	    'title' => 'Incident Notification',
	    'current_menu' => 'Incident Notification',
	    'userDetails' => $sessiondata,
	    'editData' => $editData,
	    'role_id' => $role_id,
	    'getEventRelate' => $getEventRelate,
	    'getEventType' => $EventTypeArray,
	    'getLoc' => $LocArray,
	    'getSpecLoc' => $specLocArray,
	    'backUrl' => $backUrl,
	    'detail' => $detail,
	    'id' => $id,
            'NotifyId' => $NotifyId,
	    'eventRelatedToDt'=> $eventRelatedToDt,
	    'eventTypeDt' => $eventTypeDt,
	    'headerfiles' => [
		'css' => [
		    'assets/plugins/clockpicker/clockpicker.css'
		],
		'js' => [
		    'assets/plugins/clockpicker/clockpicker.js'
		],
		'priority' => 'high'
	    ]
	);


	   $html2 = $this->load->view('incident/incident/NotifyPdfView',$data, true);
	   
	    $permitNumber = 'Notify Report';


	    $mpdf2 = $this->pdf->incUpload();
	    $das = $mpdf2->WriteHTML($html2);
	    $path2 = $permitNumber. '.pdf';
            $name = $permitNumber.'.pdf';
            $mpdf2->Output($path2, "I");
	}
        
        public function PdfReport($id = ""){
    	//ini_set('display_errors', 1);
    	//echo '<pre>';print_r($_SESSION);exit;
      
       if ($id == "") {
	    redirect('incident/');
	   } else {

	    $sessiondata = getCurrentUserDetails();
	    $role_id = $this->session->role_id;
	    $backUrl = BASE_URL . 'incident/';

	    /* masters start */
	    $reWhr['where'] = [
		'INCIDENT_EVENT_STATUS' => 'Y'
	    ];
	    $reWhr['return_type'] = 'result';
	    $getEventRelate = $this->common_model->getAlldata(INC_EVENT_RELATE, ['*'], $reWhr);
	    $typeWhr['where'] = [
		'EVENT_TYPE_STATUS' => 'Y'
	    ];
	    $typeWhr['return_type'] = 'result';
	    $getEventType = $this->common_model->getAlldata(INC_EVENT_TYPE, ['*'], $typeWhr);
	    $EventTypeArray = customFormDropDown($getEventType, 'EVENT_TYPE_ID', 'EVENT_TYPE_NAME');
	    $loWhr['where'] = [
		'TERMINAL_STATUS' => 'Y'
	    ];
	    $loWhr['return_type'] = 'result';
	    $getLoc = $this->common_model->getAlldata(LOCATION, ['*'], $loWhr);
	    $LocArray = customFormDropDown($getLoc, 'TERMINAL_SHORTNAME', 'TERMINAL_SHORTNAME', 'Select Location');
	   // echo '<pre>';print_r($LocArray);exit;
	    $spWhr['where'] = [
		'SPECIFIC_LOC_STATUS' => 'Y'
	    ];
	    $spWhr['return_type'] = 'result';
	    $getSpecLoc = $this->common_model->getAlldata(SPECIFIC_LOCATION, ['*'], $spWhr);
	    $specLocArray = customFormDropDown($getSpecLoc, 'SL_AUTO_ID', 'SPECIFIC_LOC_NAME', 'Select Location');
	    /* masters end */

	    $optWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => decryptval($id)
	    ];
	    $optWhr['return_type'] = 'row';
	    $editData = $this->common_model->getAlldata(INC_NOTIFY_INFO, ['*', 'FN_DATE_FORMAT(EVENT_DATE) as eventDate'], $optWhr);
	    $incid = postData($editData, 'INCIDENT_ID');
	    $optattWhr['where'] = [
		'INC_NOTIFY_ID' => $incid
	    ];
	    $optattWhr['return_type'] = 'result';
	    $editData->notifyAttachments = $this->common_model->getAlldata(INCIDENT_NOTIFY_ATTACHMENT, ['CONCAT(FILE_PATH,FILE_NAME) as fileset'], $optattWhr);
	    $optattWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => $incid
	    ];
	    $optattWhr['return_type'] = 'result';
	    $editData->persons = $this->common_model->getAlldata(INC_NOTIFY_PERSON, ['*'], $optattWhr);
	    $invWhr['where'] = [
		'INCIDENT_NOTIFY_ID' => $incid
	    ];
	    $invWhr['return_type'] = 'row';
	    $investData = $this->common_model->getAlldata(INC_INVEST, ['*'], $invWhr);
	    $employeeNameDetails = $this->incident_model->getEmployeeNames();
	    $bodyPartMainData = $this->incident_model->getbodyPartMainData();
	    $InvestigationId = $this->incident_model->getInvestigationId($id);
            $justId = $id;
	    $detail = $this->incident_model->getEmployeeDetails($InvestigationId['INCIDENT_INVESTIGATION_ID'],$justId);
	    $classFyName = $this->incident_model->getclassFyName($detail['IncidentInvestigationData']['INC_CLASSIFICATION']);
	    $UserPrepared = $this->incident_model->getUserPrepared($detail['IncidentInvestigationData']['PREPARED_BY'],$detail['IncidentInvestigationData']['REVIEWED_BY'],$detail['IncidentInvestigationData']['VERIFIED_BY'],$detail['IncidentInvestigationData']['APPROVED_BY']);

	    $UserReviewed = $this->incident_model->getUserReviewed($detail['IncidentInvestigationData']['PREPARED_BY'],$detail['IncidentInvestigationData']['REVIEWED_BY'],$detail['IncidentInvestigationData']['VERIFIED_BY'],$detail['IncidentInvestigationData']['APPROVED_BY']);
	    $UserVerified = $this->incident_model->getUserVerified($detail['IncidentInvestigationData']['PREPARED_BY'],$detail['IncidentInvestigationData']['REVIEWED_BY'],$detail['IncidentInvestigationData']['VERIFIED_BY'],$detail['IncidentInvestigationData']['APPROVED_BY']);
	    $UserApproved = $this->incident_model->getUserApproved($detail['IncidentInvestigationData']['PREPARED_BY'],$detail['IncidentInvestigationData']['REVIEWED_BY'],$detail['IncidentInvestigationData']['VERIFIED_BY'],$detail['IncidentInvestigationData']['APPROVED_BY']);
	    //echo '<pre>';print_r($detail);exit;
            $empIdGets = $this->incident_model->getempIdGets($editData->EVENT_REPORTED_BY);
	    $checkClassify = explode(',', $detail['IncidentInvestigationData']['INC_CLASSIFICATION']);
	    //echo '<pre>';print_r($UserPrepared);exit;
	   // echo '<pre>';print_r($detail);exit;
	    $New_start_index = '1'; 
	    $incidentClassification = $this->incident_model->getClassificationDetails();
	    $NotifyId = decryptval($id);
	   foreach ($incidentClassification as $key => $ic) {
	    	$icid = postData($ic , 'CLASSFICATION_MST_ID');
	    	if(in_array($icid, $checkClassify)){
	    		$incidentClassification[$key]['CHECKED'] = 1;
	    	}
	    	else{
	    		$incidentClassification[$key]['CHECKED'] = 0;
	    	}
	    	
	    	
	     }
    	
	   
	    $data = array(
		
		'editData' => $editData,
		'UserPrepared' => $UserPrepared,
		'UserReviewed'=> $UserReviewed,
		'UserVerified' => $UserVerified,
		'UserApproved' => $UserApproved,

		'investData' => $investData,
		'getEventRelate' => $getEventRelate,
		'getEventType' => $EventTypeArray,
		'getLoc' => $LocArray,
		'getSpecLoc' => $specLocArray,
		'role_id' => $role_id,
		'NotifyId' => $NotifyId,
		'backUrl' => $backUrl,
		'detail' => $detail,
		'employeeNameDetails' => $employeeNameDetails,
		'bodyPartMainData' => $bodyPartMainData,
		'checkClassify' => $checkClassify,
		'incidentClassification' => $incidentClassification,
		'detailcircumstanceDetails' => $detailcircumstanceDetails,
		'classFyName' => $classFyName,
		'id' => $id,
                'empIdGets' => $empIdGets,
	    );

	    $html2 = $this->load->view('incident/investigation/PdfView',$data, true);
	   
	    $permitNumber = 'Incident Report';


	    $mpdf2 = $this->pdf->incUpload();
	    $das = $mpdf2->WriteHTML($html2);
	    $path2 = $permitNumber. '.pdf';
            $name = $permitNumber.'.pdf';
            $mpdf2->Output($path2, "I");
	}
}

public function deleteIncNotifyInfo() {

  
        $deleteId = decryptval($this->input->post('delid'));
	$updtDelete = $this->common_model->updateData(INCIDENT_NOTIFICATION_DETAILS, ['NOTIFY_STATUS' => 'N'], ['INCIDENT_NOTIFY_ID' => $deleteId]);

	if ($updtDelete) {
	    $retData = [
		'status' => true,
		'msgs' => 'Incident Notification Deleted Successfully'
	    ];
	} else {
	    $retData = [
		'status' => false,
		'msgs' => 'Error in deleting Area of classification'
	    ];
	}
	echo json_encode($retData);
    }
    
    public function SpecificLocatDetails(){
                $eventLocation = $this->input->post('eventLocation');
		$specificLocatDetails = $this->incident_model->getSpecificLocatDetails($eventLocation);

                 $testing[] = ['SL_AUTO_ID' => '-1' , 'SPECIFIC_LOC_NAME' => 'Other'];
                 $spp = array_merge($specificLocatDetails , $testing);
		 $output = '';
		 $output.='<label for="fname" class="form-label">Specific Location :</label><select class="form-control" id="specificlocother"><br>';
		 $output.='<option  value="">Please Select</option>';
		   foreach ($spp as $sp)
		    {
                   
				$output.='<option  value="'  . $sp['SL_AUTO_ID'] . '">'. $sp['SPECIFIC_LOC_NAME'] . '</option>';
		    }
		$output.='</select></div>';
		echo $output;
    }
       

 


}
