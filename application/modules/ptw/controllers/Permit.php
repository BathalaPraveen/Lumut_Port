<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Permit extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isLogin();
        $this->load->model('ptw/permit_model', 'permit');
        $this->load->helper('permit_helper');
        $this->load->helper('string_helper');
        $this->load->helper('exp_excel_helper');
        ini_set('memory_limit','-1');

    }
    
    public function normalList() {
        global $aPTWPermission;
        $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');
        $status = $this->input->get('status');
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');


        $userType = getCurrentUserGroupId();
        $ptwStatusList = getPTWStatus('drop');
        

        if (in_array($userType, $aPTWPermission['view']) || in_array($userType, $aPTWPermission['add']) || in_array($userType, $aPTWPermission['edit']) || is_admin()) {
            $deleteURL = BASE_URL("ptw/permit/deletepermit");
            $addURL = BASE_URL('ptw/permit/?type=NORMAL');
            $addPermission = (in_array($userType, $aPTWPermission['add']) || is_admin()) ? TRUE : FALSE;
            $data = array(
                'addPermission' => $addPermission,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'addButtonTitle' => 'Apply Normal PTW',
                'pageTitle' => 'Normal PTW',
                'view_file' => 'form/ptw_list',
                'site_title' => 'Normal PTW',
                'current_menu' => 'List Normal PTW',
                // 'ajaxurl' => 'ptw/permit/listPTW?type=NORMAL',
                'ajaxurl' => 'ptw/permit/listPTW?type=NORMAL&terminal='.$terminal.'&year='.$year.'&status='.$status,
                'deleteURL' => $deleteURL,
                'addURL' => $addURL,
                'statusList' => $ptwStatusList,
            );
            // print_r($data);
            // exit;
            $this->template->load_table_template($data);
        } else {
            $this->session->set_flashdata('dashboardmsg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> You don\'t have permission to access this permit </div>');
            redirect('dashboard');
        }
    }

    public function criticalList() {
        global $aPTWPermission;

        $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');
        $status = $this->input->get('status');
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');


        $userType = getCurrentUserGroupId();
        $ptwStatusList = getPTWStatus('drop');
        if (in_array($userType, $aPTWPermission['view']) || in_array($userType, $aPTWPermission['add']) || in_array($userType, $aPTWPermission['edit']) || is_admin()) {
            $deleteURL = BASE_URL("ptw/permit/deletepermit");
            $addURL = BASE_URL('ptw/permit/?type=CRITICAL');
             $addPermission = (in_array($userType, $aPTWPermission['add']) || is_admin()) ? TRUE : FALSE;
            $data = array(
                'pageTitle' => 'Critical PTW',
                'addButtonTitle' => 'Apply Critical PTW',
                'addPermission' => $addPermission,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'view_file' => 'form/ptw_list',
                'site_title' => 'Critical PTW',
                'current_menu' => 'List Critical PTW',
                // 'ajaxurl' => 'ptw/permit/listPTW?type=CRITICAL',
                'ajaxurl' => 'ptw/permit/listPTW?type=CRITICAL&terminal='.$terminal.'&year='.$year.'&status='.$status,

                'deleteURL' => $deleteURL,
                'addURL' => $addURL,
                'statusList' => $ptwStatusList,
            );
            $this->template->load_table_template($data);
        } else {
            $this->session->set_flashdata('dashboardmsg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> You don\'t have permission to access this permit </div>');
            redirect('dashboard');
        }
    }

    public function listPTW() {
        $userType = getCurrentUserGroupId();
         $userid = getCurrentUserid();

         $terminal = $this->input->get('terminal');
        $year = $this->input->get('year');
        $status = $this->input->get('status');


        global $aPermitType, $aPTWPermission;
        $table = PTW_TBL;
        $permitType = $this->input->get('type');
        $permitTypeId = array_search($permitType, ($aPermitType));
        
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
        
        
        $column_order = array('LIVE_PERMIT_NO', 'FN_GET_LOCATION(LOCATION)', 'SPECIFIC_WORKSITE', 'CREATED_ON', 'APPLICANT_NAME', 'FN_PTW_STATUS_NAME(STATUS)', null);
        
        $aColumnSearch = array('LIVE_PERMIT_NO', 'FN_GET_LOCATION(LOCATION)', 'SPECIFIC_WORKSITE', 'CREATED_ON', 'APPLICANT_NAME', 'FN_PTW_STATUS_NAME(STATUS)');
        $order = array('PTW_ID' => 'DESC');
        $where = [
            'PERMIT_TYPE' => $permitTypeId,
            'PTW_STATUS' => 'Y'
        ];
        $userType = getCurrentUserGroupId();
        if(in_array($userType, [4,11])){
            $where['APPLICANT_USER_TYPE_ID'] = $userType;
            $where['CREATED_BY'] = $userid;
        }
        
        if($mappedData != FALSE && count($mappedData) > 0){
            $searchStatus = postData($mappedData,'status');
            if($searchStatus > 0){
                 $where['STATUS'] = $searchStatus;
            }
            $startdate = postData($mappedData, 'start_date');
            $enddate = postData($mappedData, 'end_date');
       
            if ($startdate != '') {
                $startdate = date('Y-m-d', strtotime($startdate));
                 $where['START_DATE >= '] = $startdate;
               
            }
            if ($enddate != '') {
                $enddate = date('Y-m-d', strtotime($enddate));
                 $where['END_DATE <= '] = $enddate;
            }
        }

            if($year != ''){
            $where['YEAR(CREATED_ON) ='] = $year;
        }
        if($terminal != ''){
             $where['LOCATION ='] = $terminal;
        }

         if($status == 1){
            // echo "jsjs";
            // exit;
            //  $where['STATUS ='] = $status;
             $options['where_in'] = ['STATUS'=>[1,2,4]];
        }

        if($status != 1 && $status!=''){
             $where['STATUS ='] = $status;
        }
        
        $options['select'] = array('PTW_ID', 'LIVE_PERMIT_NO', 'FN_GET_LOCATION(LOCATION) as loc_name', 'SPECIFIC_WORKSITE', 'CREATED_ON', 'APPLICANT_NAME', 'PERMIT_TYPE', 'FN_PTW_STATUS_NAME(STATUS) as status_Name', 'CREATED_BY', 'STATUS', 'OA1', 'OA2','OA1_APPROVAL_STATUS','OA1_APPROVAL_EXP_TIME','OA2_APPROVAL_STATUS');
        $mlist = $this->common_model->get_datatables($table, $column_order, $aColumnSearch, $order, $where, $options);

        // echo $this->db->last_query();
        // exit;
              
        $finalDatas = [];
        if (isset($mlist) && !empty($mlist)) {
            foreach ($mlist as $ltKey => $ltVal) {
                $action = '';
                $id = encryptval($ltVal->PTW_ID);
                $permit_type = postData($ltVal, 'PERMIT_TYPE');
                $createdBy = postData($ltVal, 'CREATED_BY');
                $status = postData($ltVal, 'STATUS');
                $OA1 = postData($ltVal, 'OA1');
                $OA2 = postData($ltVal, 'OA2');
                $OA1AppStatus = postData($ltVal, 'OA1_APPROVAL_STATUS');
                $OA2AppStatus = postData($ltVal, 'OA2_APPROVAL_STATUS');
                $OA1AppExpTime = postData($ltVal, 'OA1_APPROVAL_EXP_TIME');
                
                $flipPermit = array_flip($aPermitType);
                $permitName = array_search($permit_type, $flipPermit);
                $currentDateTime = date('Y-m-d H:i:s');

                if (in_array($userType, $aPTWPermission['approve'])) { /* HSSE Team Approvement */
                    $editTitle = '';
                    if ($status == 1 && in_array($userType, $aPTWPermission['verfication_a'])  ) {
                        $verify = TRUE;
                        $editTitle = 'HSE Verification';
                    } else if ($status == 2 && ($userid == $OA1 || $userid == $OA2 )) {
                       // if($userid == $OA1 && $OA1AppStatus == 'Y' && strtotime($OA1AppExpTime)>= strtotime($currentDateTime)){
                        if($userid == $OA1 && $OA1AppStatus == 'Y'){
                            $verify = TRUE;
                        }else if(($OA2AppStatus == 'Y' && $userid == $OA2) || ($OA2AppStatus == 'N' && $userid == $OA2 && strtotime($OA1AppExpTime)< strtotime($currentDateTime))){
                           $verify = TRUE; 
                        }else{
                            $verify = FALSE;
                        }
                        
                        $editTitle = 'OA Verification';
                    } else if (in_array($status, [6, 8]) && in_array($userType, $aPTWPermission['stop'])) {
                        $verify = TRUE;
                        $editTitle = 'Permit Stoppage/Cancel/Re-activate Permit';
                    } else {
                        $verify = FALSE;
                    }
                    if ($verify) {
                        $action .= " " . anchor('ptw/permit/verify/' . $id . '?type=' . $permitName, '<i class="fa fa-edit"></i>', array('title' => $editTitle));
                    }
                } else if (in_array($userType, $aPTWPermission['add']) && $userid == $createdBy && in_array($status, [1, 3, 4, 5, 6, 10])) { /* Applied Person edit permissio */
                    if ($status == 4) { /* Ack the PTW */
                        $action .= " " . anchor('ptw/permit/verify/' . $id . '?type=' . $permitName, '<i class="fa fa-edit"></i>', array('title' => 'Acknowledge'));
                    } else if (in_array($status, [6,10])) {
                        $action .= " " . anchor('ptw/permit/verify/' . $id . '?type=' . $permitName, '<i class="fa fa-edit"></i>', array('title' => 'Close'));
                    } else {
                        $action .= " " . anchor('ptw/permit/index/' . $id . '?type=' . $permitName, '<i class="fa fa-edit"></i>', array('title' => 'Edit'));
                        $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteptw', 'title' => 'Delete', 'delt-id' => $id));
                    }
                }else if(is_admin()){
                    if($status != 7){
                     $action .= " " . anchor('ptw/permit/verify/' . $id . '?type=' . $permitName, '<i class="fa fa-edit"></i>', array('title' => 'Acknowledge'));
                     $action .= " " . anchor('ptw/permit/index/' . $id . '?type=' . $permitName, '<i class="fa fa-edit"></i>', array('title' => 'Edit'));
                      $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteptw', 'title' => 'Delete', 'delt-id' => $id));
                    }
                } else {
                    
                }
                $action .= " " . anchor('ptw/permit/view/' . $id, '<i class="fa fa-eye"></i>', array('title' => 'view'));
                 $action .= " " . anchor('ptw/permit/pdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF','target'=>'_blank'));

                $rows = [];
                $rows[] = postData($ltVal, 'LIVE_PERMIT_NO');
                $rows[] = postData($ltVal, 'loc_name');
                $rows[] = postData($ltVal, 'SPECIFIC_WORKSITE');
                $rows[] = date('d-m-Y H:i:s', strtotime($ltVal->CREATED_ON));
                $rows[] = postData($ltVal, 'APPLICANT_NAME');
                $rows[] = postData($ltVal, 'status_Name');
                $rows[] = $action;
                $finalDatas[] = $rows;
            }
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->common_model->count_filtered($table, $column_order, $aColumnSearch, $order, $where,$options),
            "recordsFiltered" => $this->common_model->count_filtered($table, $column_order, $aColumnSearch, $order, $where,$options),
            "data" => $finalDatas,
        );
       
        //output to json format
        echo json_encode($output);
    }

    public function deletepermit() {
        $deleteId = decryptval($this->input->post('delid'));
        $updtDelete = $this->common_model->updateData(PTW_TBL, ['PTW_STATUS' => 'N'], ['PTW_ID' => $deleteId]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Permit deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Permit'
            ];
        }
        echo json_encode($retData);
    }

    /*
     * PTW - Normal and Critical
     * Section 1 to section 5 for Normal PTW
     * Section 1 to section 6 for Critical PTW
     * 
     * This function for add/edit PTW
     * 
     */
    public function index($id = '') {
        global $aPermitType, $aPTWPermission;
        $userType = getCurrentUserGroupId();

        $sessiondata = getCurrentUserDetails();
      
        $permitType = $this->input->get('type');
        $permitTypeId = array_search($permitType, ($aPermitType));
        switch ($permitTypeId) {
            case 1:
                $backURL = BASE_URL.'ptw/permit/normalList';
                $permitTypeName = 'Normal PTW';
                break;
            case 2:
                $backURL = BASE_URL.'ptw/permit/criticalList';
                $permitTypeName = 'Critical PTW';
                break;

            default:
                $backURL = BASE_URL.'dashboard';
                break;
        }
        
        
        $certificateStatus = postData($sessiondata, 'CERT_STATUS');
        

        $locationDetails = $this->permit->getLocation();
        $locationDropdownDetails = customFormDropDown($locationDetails, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Location');

        $specificlocationDetails = $this->permit->getSpecificLocation();
        $speclocationDropdownDetails = customFormDropDown($specificlocationDetails, 'SL_AUTO_ID', 'SPECIFIC_LOC_NAME', 'Select Specific Location');

        $areaClassification = $this->permit->getAreaClassification();
        $hazardActivity = getHazardActivitiesCategory($permitType);

        $editData = FALSE;
        $secattachment = FALSE;
        $hazardActivityInfo = FALSE;
        $hazardActivityHirarcInfo = FALSE;
        $hazardActivityCheckListInfo = FALSE;
        $hazardActivityCheckListInfo = FALSE;
        $wppInfo = FALSE;
        $ppeCheckListInfo = FALSE;
        $userid = getCurrentUserid();
        if ($id != '') {
            $decryptPtwId = decryptval($id);
            $editoption = [];
            if(is_admin()){
                $checkWhere = ['PTW_ID' => $decryptPtwId];
            }else{
               $checkWhere = ['PTW_ID' => $decryptPtwId,'CREATED_BY'=>$userid]; 
               $editoption['where_in'] = ['STATUS' => [1,3,5]];
            }
            $editData = $this->permit->getPTWInfo($checkWhere, 'row',$editoption);
            
            if($editData == FALSE){
                $redirectURL = 'ptw/permit/?type='.$permitType;
                redirect($redirectURL);
                return true;
            }
           
            $secattachment = $this->permit->getPTWSecAttachment(['REF_PTW_ID' => $decryptPtwId,'ATTACH_STATUS'=>'Y'], 'result');
            $hazardActivityCheckListInfo = $this->permit->getHzActivityCheckList(['REF_PTW_ID' => $decryptPtwId,'HZ_STATUS'=>'Y'], 'result');

            $hazardActivityOther = $this->permit->getHZActivityOther($decryptPtwId);

            $hazardActivityHirarcInfo = $this->permit->getPTWHzActivityHirarcInfo(['PTW_ID' => $decryptPtwId], 'row');
            
            $hazardActivityHirarcResultInfo = $this->permit->getPTWHzActivityHirarcDetails(['PTW_ID' => $decryptPtwId], 'result');

            $hzActivityInfo = $this->permit->getHzActivityInfo(['REF_PTW_ID' => $decryptPtwId], 'result');
            $wppInfo = $this->permit->getWPPInfo(['REF_PTW_ID' => $decryptPtwId,'WPP_STATUS'=>'Y'], 'result');
            $wppCheckListInfo = $this->permit->getWPPCheckList(['REF_PTW_ID' => $decryptPtwId,'WPP_STATUS'=>'Y'], 'result');

            $ppeCheckListInfo = $this->permit->getPPECheckList(['REF_PTW_ID' => $decryptPtwId,'PPE_STATUS'=>'Y'], 'result');
            $ppeInfo = $this->permit->getPPEInfo(['REF_PTW_ID' => $decryptPtwId,'PPE_STATUS'=>'Y'], 'result');
        }

        $additionalData = [
            'hazardActivityOther' => $hazardActivityOther,
            'hazardActivityCheckListInfo' => $hazardActivityCheckListInfo,
            'hazardActivityHirarcInfo' => $hazardActivityHirarcInfo,
            'hazardActivityResultHirarcInfo' => $hazardActivityHirarcResultInfo,
            'hzActivityAttachment' => $hzActivityAttachment,
            'hzActivityInfo' => $hzActivityInfo,
            'wppCheckListInfo' => $wppCheckListInfo,
            'wppInfo' => $wppInfo,
            'ppeCheckListInfo' => $ppeCheckListInfo,
            'ppeInfo' => $ppeInfo,
        ];

        $addPermission = (in_array($userType, $aPTWPermission['add'])) ? TRUE : FALSE;
        $editPermission = (in_array($userType, $aPTWPermission['edit'])) ? TRUE : FALSE;
        
        if ($certificateStatus == 'Y' && in_array($permitTypeId, [1, 2])  && ($addPermission == TRUE || $editPermission == TRUE) || is_admin()) {
            $applicantdate = date(PTW_DATE_FORMAT);
            $applicanttime = date(PTW_TIME_FORMAT);
            $deleteURL = BASE_URL("ptw/permit/deleteDoc");
            $data = [
                'editId' => $id,
                'deleteURL' => $deleteURL,
                'backURL' => $backURL,
                'ptw_id' => $decryptPtwId,
                'view_file' => 'form/add_form',
                'permitType' => $permitType,
                'current_menu' => 'permit',
                'userDetails' => $sessiondata,
                'applicantdate' => $applicantdate,
                'applicanttime' => $applicanttime,
                'locationDetails' => $locationDropdownDetails,
                'specificLocDetails' => $speclocationDropdownDetails,
                'areaClassification' => $areaClassification,
                'hazardActivity' => $hazardActivity,
                'editData' => $editData,
                'sectionAttachment' => $secattachment,
                'additionalData' => $additionalData,
                'form_action_url' => 'ptw/permit/save/' . $id . '?type=' . $permitType,
                'hirarcURL' => BASE_URL.'ptw/permit/getHirarcInfo'
            ];
            $this->template->load_common_template($data);
        } elseif (empty($certificateStatus)  && in_array($permitTypeId, [1, 2])) {
              $this->session->set_flashdata('permitflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Your certification status invalid,kindly update your certificate and try again. </div>');
            redirect($backURL);
        
    } else {
            $this->session->set_flashdata('permitflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> You don\'t have permission to access this permit </div>');
            redirect($backURL);
        }
    }
    
    
    /*
     * PTW - Normal and Critical
     * Section 5 to section 10 for Normal PTW
     * Section 5 to section 6 to section 10 for Critical PTW
     * 
     * This function apprival section and confined space and stop/cancel
     * 
     */

    public function verify($id = '') {
        global $aPermitType, $aPTWPermission;
        $userType = getCurrentUserGroupId();

        $sessiondata = getCurrentUserDetails();
       
        $permitType = $this->input->get('type');
        $permitTypeId = array_search($permitType, ($aPermitType));
        $certificateStatus = postData($sessiondata, 'CERT_STATUS');

        switch ($permitTypeId) {
            case 1:
                $backURL = BASE_URL.'ptw/permit/normalList';
                $permitTypeName = 'Normal PTW';
                break;
            case 2:
                $backURL = BASE_URL.'ptw/permit/criticalList';
                $permitTypeName = 'Critical PTW';
                break;

            default:
                $backURL = BASE_URL.'dashboard';
                break;
        }

        $locationDetails = $this->permit->getLocation();
        $locationDropdownDetails = customFormDropDown($locationDetails, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Location');

        $specificlocationDetails = $this->permit->getSpecificLocation();
        $speclocationDropdownDetails = customFormDropDown($specificlocationDetails, 'SL_AUTO_ID', 'SPECIFIC_LOC_NAME', 'Select Specific Location');

        $areaClassification = $this->permit->getAreaClassification();
        $hazardActivity = getHazardActivitiesCategory($permitType);

        $editData = FALSE;
        $secattachment = FALSE;
        $hazardActivityInfo = FALSE;
        $hazardActivityHirarcInfo = FALSE;
        $hazardActivityCheckListInfo = FALSE;
        $wppInfo = FALSE;
        $ppeCheckListInfo = FALSE;
        if ($id != '') {
            $decryptPtwId = decryptval($id);
            $editData = $this->permit->getPTWInfo(['PTW_ID' => $decryptPtwId, 'PERMIT_TYPE' => $permitTypeId], 'row');
            $secattachment = $this->permit->getPTWSecAttachment(['REF_PTW_ID' => $decryptPtwId,'ATTACH_STATUS'=>'Y'], 'result');
            $hazardActivityCheckListInfo = $this->permit->getHzActivityCheckList(['REF_PTW_ID' => $decryptPtwId,'HZ_STATUS'=>'Y'], 'result');

            $hazardActivityOther = $this->permit->getHZActivityOther($decryptPtwId);

            $hazardActivityHirarcInfo = $this->permit->getPTWHzActivityHirarcInfo(['PTW_ID' => $decryptPtwId], 'row');
            
            $hazardActivityHirarcResultInfo = $this->permit->getPTWHzActivityHirarcDetails(['PTW_ID' => $decryptPtwId], 'result');

            $hzActivityInfo = $this->permit->getHzActivityInfo(['REF_PTW_ID' => $decryptPtwId], 'result');
            $wppInfo = $this->permit->getWPPInfo(['REF_PTW_ID' => $decryptPtwId,'WPP_STATUS'=>'Y'], 'result');
            $wppCheckListInfo = $this->permit->getWPPCheckList(['REF_PTW_ID' => $decryptPtwId,'WPP_STATUS'=>'Y'], 'result');

            $ppeCheckListInfo = $this->permit->getPPECheckList(['REF_PTW_ID' => $decryptPtwId,'PPE_STATUS'=>'Y'], 'result');
            $ppeInfo = $this->permit->getPPEInfo(['REF_PTW_ID' => $decryptPtwId,'PPE_STATUS'=>'Y'], 'result');
        }
       

        $additionalData = [
            'hazardActivityOther' => $hazardActivityOther,
            'hazardActivityCheckListInfo' => $hazardActivityCheckListInfo,
            'hazardActivityHirarcInfo' => $hazardActivityHirarcInfo,
            'hazardActivityHirarcResultInfo' => $hazardActivityHirarcResultInfo,
            'hzActivityAttachment' => $hzActivityAttachment,
            'hzActivityInfo' => $hzActivityInfo,
            'wppCheckListInfo' => $wppCheckListInfo,
            'wppInfo' => $wppInfo,
            'ppeCheckListInfo' => $ppeCheckListInfo,
            'ppeInfo' => $ppeInfo,
        ];
        $approvePermission = (in_array($userType, $aPTWPermission['approve'])) ? TRUE : FALSE;
        $OA1AppStatus = postData($editData, 'OA1_APPROVAL_STATUS');
        $OA2AppStatus = postData($editData, 'OA2_APPROVAL_STATUS');
        $OA1AppExpTime = postData($editData, 'OA1_APPROVAL_EXP_TIME');
        $PTWCurrentStatus = postData($editData, 'STATUS');
        $OA1 = postData($editData, 'OA1');
        $OA2 = postData($editData, 'OA2');
        $userid = getCurrentUserid();
        $currentDateTime = date('Y-m-d H:i:s');
        
        /*To check OA Verification time for 8 hours*/
        $QAVeifyPermission = FALSE;
        if($PTWCurrentStatus == 2){
           // if($userid == $OA1 && $OA1AppStatus == 'Y' && strtotime($OA1AppExpTime)>= strtotime($currentDateTime)){
if($userid == $OA1 && $OA1AppStatus == 'Y'){
                $QAVeifyPermission = TRUE;
            }else if(($OA2AppStatus == 'Y' && $userid == $OA2) || ($OA2AppStatus == 'N' && $userid == $OA2 && strtotime($OA1AppExpTime)< strtotime($currentDateTime))){
               $QAVeifyPermission = TRUE; 
            }else{
                $QAVeifyPermission = FALSE;
            }
        }
        
        $pType = postData($editData, 'PERMIT_TYPE');
        $CSStatus = postData($editData, 'CONFINED_SPACE');
        $CSCompletion = postData($editData, 'CONFINED_SPACE_COMPLETION');
        
        $formAction = $formAppAction = 'ptw/permit/approval/' . $id . '?type=' . $permitType;
        $confinedSpaceTotalCount = 2;
       
        if($PTWCurrentStatus == 6 && $pType == 2 && $CSStatus == 'Y' && $CSCompletion == 'N')        {
            $formAction = 'ptw/permit/confinedSpaceSave/' . $id . '?type=' . $permitType;
        }
         

        if ( is_admin() || ( $certificateStatus == 'Y' && $editData != FALSE && (in_array($permitTypeId, [1, 2])  || $approvePermission == TRUE))) {
            $applicantdate = date(PTW_DATE_FORMAT);
            $applicanttime = date(PTW_TIME_FORMAT);
            $data = [
                'editId' => $id,
                'backURL' => $backURL,
                'ptw_id' => $decryptPtwId,
                'view_file' => 'approve/approve_form',
                'permitType' => $permitType,
                'current_menu' => 'permit',
                'userDetails' => $sessiondata,
                'applicantdate' => $applicantdate,
                'applicanttime' => $applicanttime,
                'locationDetails' => $locationDropdownDetails,
                'specificLocDetails' => $speclocationDropdownDetails,
                'areaClassification' => $areaClassification,
                'hazardActivity' => $hazardActivity,
                'editData' => $editData,
                'sectionAttachment' => $secattachment,
                'additionalData' => $additionalData,
                'QAVeifyPermission' => $QAVeifyPermission,
                'confinedSpaceTotalCount' => $confinedSpaceTotalCount,
                'form_action_url' => $formAction,
                'approval_action_url' => $formAppAction
            ];
            $this->template->load_common_template($data);
        } else {
           
            $this->session->set_flashdata('permitflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> You don\'t have permission to access this permit </div>');
            $returnURL = ($permitTypeId == 1) ? 'ptw/permit/normalList' : 'ptw/permit/criticalList';
            redirect($returnURL);
        }
    }

    public function approval($id = '') {
        global $aPermitType, $aPTWPermission;
        $userType = getCurrentUserGroupId();
        $uploadError = [];
        $permitType = $this->input->post('permitType');
        $permitTypeId = array_search($permitType, ($aPermitType));
        switch ($permitTypeId) {
            case 1:
                $returnURL = BASE_URL.'ptw/permit/normalList';
                $permitTypeName = 'Normal PTW';
                break;
            case 2:
                $returnURL = BASE_URL.'ptw/permit/criticalList';
                $permitTypeName = 'Critical PTW';
                break;

            default:
                $returnURL = BASE_URL.'dashboard';
                $permitTypeName = 'PTW';
                break;
        }


        $getPermitData = $this->input->post();
        $editId = postData($getPermitData, 'ptw_id');
       
        $sessiondata = getCurrentUserDetails();
        $submitaction = postData($getPermitData, 'submitaction');
        $submitreaction = postData($getPermitData, 'submitreaction');
        if(is_admin() && $submitreaction == 'reactive'){
            $submitaction = 'reactive';
        }
//        echo '<pre>';
//        print_r($sessiondata);
//        print_r($this->input->post());
//        exit;
        if ($id != '') {
            $decryptPtwId = decryptval($id);
            $editData = $this->permit->getPTWInfo(['PTW_ID' => $decryptPtwId, 'PERMIT_TYPE' => $permitTypeId], 'row');
            $PTWStatus = postData($editData, 'STATUS');
            $PTWID = postData($editData, 'PTW_ID');
            $section7A = (in_array($userType, $aPTWPermission['verfication_a']) || is_admin()) ? TRUE : FALSE;
            $section7B = (in_array($userType, $aPTWPermission['verfication_b']) || is_admin()) ? TRUE : FALSE;
            $acknowledge = (in_array($userType, $aPTWPermission['acknowledge']) || is_admin()) ? TRUE : FALSE;
            $stop = (in_array($userType, $aPTWPermission['stop']) || is_admin()) ? TRUE : FALSE;
            $PTWClose = (in_array($userType, $aPTWPermission['close']) || is_admin()) ? TRUE : FALSE;
            $closeBtn = postData($getPermitData, 'close');
            $userDesignationName = postData($sessiondata,'DESIGNATION');
            $userDesignationId = postData($sessiondata,'DESIGNATIONID');
            $userid = getCurrentUserid();
            
             $permitId = postData($editData, 'LIVE_PERMIT_NO');
            
            /* HSE LOGIN Verification section 7 - A */
            if ($PTWStatus == 1 && $section7A) {
                $this->form_validation->set_rules('hse_verify', 'HSE Verify', 'required');
                if ($this->form_validation->run() == true) {

                    $hse_verify = postData($getPermitData, 'hse_verify');
                    $hse_remark = postData($getPermitData, 'hse_remark');
                    $verification_hse_name = postData($getPermitData, 'verification_hse_name');
                    $verification_hse_date = postData($getPermitData, 'verification_hse_date');
                    $verification_hse_time = postData($getPermitData, 'verification_hse_time');
                    $approve = postData($getPermitData, 'approve');
                    $reject = postData($getPermitData, 'reject');
                     $rejectStatus = 0;
                    if ($approve != '') {
                        $status = 2;
                       
                    } else if ($reject != '') {
                        $status = 3;
                        $rejectStatus = 1;
                    }


                    $verifyADate = converttoDBDate($verification_hse_date, 'Y-m-d');
                    $verifyATime = converttoDBDate($verification_hse_time, 'H:i:s');

                    $updateData = [
                        'HSE_DESIGNATION_NAME' => $userDesignationName,
                        'SHO_HSE_DESIGNATION_ID' => $userDesignationId,
                        'SHO_HSE_USER_LOGIN_ID' => $userid,
                        'SHO_HSE_VERIFY' => $hse_verify,
                        'SHO_HSE_REMARKS' => $hse_remark,
                        'SHO_HSE_NAME' => $verification_hse_name,
                        'SHO_HSE_DATE' => $verifyADate,
                        'SHO_HSE_TIME' => $verifyATime,
                        'HSE_REJECT' => $rejectStatus,
                        'STATUS' => $status
                    ];
                    
                    if($status == 2){
                        $updateData['OA1_APPROVAL_STATUS'] = 'Y';
                        $updateData['OA1_APPROVAL_EXP_TIME'] = date('Y-m-d H:i:s', strtotime('12 hour'));
                    }

                    $updateWhere = [
                        'PTW_ID' => $PTWID,
                        'STATUS' => 1
                    ];

                    $ptwID = $this->common_model->updateInfo(PTW_TBL, $updateData, 'PTW_ID', $updateWhere);
                    $sendNotify = TRUE;
                    

                    if ($ptwID) {
                        if ($sendNotify) {
                        $notifyData = [
                          'permitTypeName' =>$permitTypeName,
                          'permitId' =>$PTWID,
                          ];
                          sendNotification($notifyData);
                        }
                        if($status == 2){
                         $this->session->set_flashdata("permitflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> ' . $permitTypeName . ' HSE Verification Accepted Successfully</div>');   
                        }else{
                            $this->session->set_flashdata("permitflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> ' . $permitTypeName . ' HSE Verification Rejected Successfully</div>');
                        }
                        

                        redirect($returnURL);
                    } else {
                        $this->session->set_flashdata("permitflash", '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Error!</span> ' . $permitTypeName . ' Verification Failed</div>');
                        redirect($returnURL);
                    }
                } else {
                    $this->verify($id);
                }
            } else if ($PTWStatus == 2 && $section7B) { /* Unit Head LOGIN Verification section 7 - B */
                $this->form_validation->set_rules('qa_declaration', 'OA Declaration', 'required');
                if ($this->form_validation->run() == true) {

                    $qa_declaration = postData($getPermitData, 'qa_declaration');
                    $qa_remark = postData($getPermitData, 'qa_remark');

                    $qa_name = postData($getPermitData, 'qa_name');
                    $qa_date = postData($getPermitData, 'qa_date');
                    $qa_time = postData($getPermitData, 'qa_time');
                    $approve = postData($getPermitData, 'approve');
                    $reject = postData($getPermitData, 'reject');
                     $rejectStatus = 0;
                    if ($approve != '') {
                        $status = 4;
                    } else if ($reject != '') {
                        $status = 5;
                        $rejectStatus = 1;
                    }


                    $verifyBDate = converttoDBDate($qa_date, 'Y-m-d');
                    $verifyBTime = converttoDBDate($qa_time, 'H:i:s');

                    $updateData = [
                        'OA_DESIGNATION_NAME' => $userDesignationName,
                        'OA_DESIGNATION_ID' => $userDesignationId,
                        'OA_USER_LOGIN_ID' => $userid,
                        'OA_DECLARATION' => $qa_declaration,
                        'OA_NAME' => $qa_name,
                        'OA_REMARKS' => $qa_remark,
                        'OA_DATE' => $verifyBDate,
                        'OA_TIME' => $verifyBTime,
                        'OA_REJECT' => $rejectStatus,
                        'STATUS' => $status
                    ];

                    $updateWhere = [
                        'PTW_ID' => $PTWID,
                        'STATUS' => 2
                    ];

                    $ptwID = $this->common_model->updateInfo(PTW_TBL, $updateData, 'PTW_ID', $updateWhere);
                    $sendNotify = TRUE;
                    if ($ptwID) {
                        if ($sendNotify) {
                         $notifyData = [
                        'permitTypeName' =>$permitTypeName,
                        'permitId' =>$PTWID,
                        ];
                        sendNotification($notifyData);
                      }
                      if($status == 4){
                         $this->session->set_flashdata("permitflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> ' . $permitTypeName . ' QA Verification Accepted Successfully</div>');
                        }else{
                           $this->session->set_flashdata("permitflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> ' . $permitTypeName . ' QA Verification Rejected Successfully</div>');
                        }
                        

                        redirect($returnURL);
                    } else {
                        $this->session->set_flashdata("permitflash", '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Error!</span> ' . $permitTypeName . ' QA Verification Failed</div>');
                        redirect($returnURL);
                    }
                } else {
                    $this->verify($id);
                }
            } else if ($PTWStatus == 4 && $acknowledge) { /* Ack from emp/contractor section 9 */
                $this->form_validation->set_rules('work_supervisor_declaration', 'Work Supervisor Declaration', 'required');
                if ($this->form_validation->run() == true) {

                    $work_supervisor_declaration = postData($getPermitData, 'work_supervisor_declaration');

                    $work_supervisor_name = postData($getPermitData, 'work_supervisor_name');
                    $work_supervisor_date = postData($getPermitData, 'work_supervisor_date');
                    $work_supervisor_time = postData($getPermitData, 'work_supervisor_time');
                    $acknowledge = postData($getPermitData, 'acknowledge');

                    $status = 6;


                    $WSDate = converttoDBDate($work_supervisor_date, 'Y-m-d');
                    $WSTime = converttoDBDate($work_supervisor_time, 'H:i:s');

                    $updateData = [
                        'WORK_SUPERVISOR_DECLARATION' => $work_supervisor_declaration,
                        'WORK_SUPERVISOR_NAME' => $work_supervisor_name,
                        'WORK_SUPERVISOR_DATE' => $WSDate,
                        'WORK_SUPERVISOR_TIME' => $WSTime,
                        'WS_USER_LOGIN_ID' => $userid,
                        'STATUS' => $status
                    ];

                    $updateWhere = [
                        'PTW_ID' => $PTWID,
                        'STATUS' => 4
                    ];

                    $ptwID = $this->common_model->updateInfo(PTW_TBL, $updateData, 'PTW_ID', $updateWhere);
                    $sendNotify = TRUE;
                    

                    if ($ptwID) {
                        if ($sendNotify) {
                        $notifyData = [
                          'permitTypeName' =>$permitTypeName,
                          'permitId' =>$PTWID,
                          ];
                          sendNotification($notifyData);
                        }
                        $this->session->set_flashdata("permitflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> ' . $permitTypeName . ' Work Supervisor Acknowledge Permit Successfully</div>');

                        redirect($returnURL);
                    } else {
                        $this->session->set_flashdata("permitflash", '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Error!</span> ' . $permitTypeName . ' Work Supervisor Acknowledge Permit Failed</div>');
                        redirect($returnURL);
                    }
                } else {
                    $this->verify($id);
                }
            } else if ($PTWStatus >= 4 && $PTWStatus != 8 && $stop == TRUE && ($closeBtn !='Submit & Close' ||( $submitaction !='close' && $submitaction !=''))) { /* Stoppage section 9 */
               
                $this->form_validation->set_rules('stop_cancel_declaration', 'Permit Stoppage/Cancel Permit', 'required');
                $this->form_validation->set_rules('stop_comments', 'Comments', 'required');
                if ($this->form_validation->run() == true) {

                    $stop_cancel_declaration = postData($getPermitData, 'stop_cancel_declaration');
                    $stop_comments = postData($getPermitData, 'stop_comments');

                    $stop_work_name = postData($getPermitData, 'stop_work_name');
                    $stop_work_date = postData($getPermitData, 'stop_work_date');
                    $stop_work_time = postData($getPermitData, 'stop_work_time');
                    $submitaction = postData($getPermitData, 'submitaction');
                    
                    if ($submitaction == 'stop') {
                        $status = 8;
                    } else {
                        $status = 9;
                    }



                    $STOPDate = converttoDBDate($stop_work_date, 'Y-m-d');
                    $STOPTime = converttoDBDate($stop_work_time, 'H:i:s');

                    $updateData = [
                        'STOPWORKORDER_DECLARATION' => $stop_cancel_declaration,
                        'STOPWORKORDER_REASON' => $stop_comments,
                        'STOPWORKORDER_NAME' => $stop_work_name,
                        'STOPWORKORDER_DATE' => $STOPDate,
                        'STOPWORKORDER_TIME' => $STOPTime,
                        'STATUS' => $status
                    ];

                    if($status == 8){
                        $updateData['STOP_USER_LOGIN_ID'] = $userid;
                    }else{
                        $updateData['CANCEL_USER_LOGIN_ID'] = $userid;

                    }

                    $updateWhere = [
                        'PTW_ID' => $PTWID,
                    ];

                    $ptwID = $this->common_model->updateInfo(PTW_TBL, $updateData, 'PTW_ID', $updateWhere);
                    $sendNotify = TRUE;
                    if ($ptwID) {
                        
                        if ($sendNotify) {
                          $notifyData = [
                            'permitTypeName' =>$permitTypeName,
                            'permitId' =>$PTWID,
                            ];
                            sendNotification($notifyData);
                          }
                        $this->session->set_flashdata("permitflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> ' . $permitTypeName . ' Permit Stoppage/Cancel Permit Successfully</div>');

                        redirect($returnURL);
                    } else {
                        $this->session->set_flashdata("permitflash", '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Error!</span> ' . $permitTypeName . ' Permit Stoppage/Cancel Permit Failed</div>');
                        redirect($returnURL);
                    }
                } else {
                    $this->verify($id);
                }
            } else if ($PTWStatus >= 8 && $stop == TRUE && ($closeBtn !='Submit & Close' ||( $submitaction !='close' && $submitaction !=''))) { /* reactivate section 9 */
                $this->form_validation->set_rules('reactivate_cancel_declaration', 'Permit Stoppage/Cancel Permit', 'required');
                $this->form_validation->set_rules('reactivate_comments', 'Comments', 'required');
                if ($this->form_validation->run() == true) {

                    $reactivate_cancel_declaration = postData($getPermitData, 'reactivate_cancel_declaration');
                    $reactivate_comments = postData($getPermitData, 'reactivate_comments');

                    $reactivate_name = postData($getPermitData, 'reactivate_name');
                    $reactivate_date = postData($getPermitData, 'reactivate_date');
                    $reactivate_time = postData($getPermitData, 'reactivate_time');
                   
                    $submitaction = postData($getPermitData, 'submitreaction');
                    
                    if ($submitaction == 'reactive') {
                        $status = 10;
                    } else {
                        $status = 9;
                    }



                    $REACTDate = converttoDBDate($reactivate_date, 'Y-m-d');
                    $REACTTime = converttoDBDate($reactivate_time, 'H:i:s');

                    $updateData = [
                        'REACTIVATE_DECLARATION' => $reactivate_cancel_declaration,
                        'REACTIVATE_REASON' => $reactivate_comments,
                        'REACTIVATER_NAME' => $reactivate_name,
                        'REACTIVATER_DATE' => $REACTDate,
                        'REACTIVATER_TIME' => $REACTTime,
                        'STATUS' => $status
                    ];
                    if($status == 10){
                        $updateData['REACTIVATE_USER_ID'] = $userid;
                    }else{
                        $updateData['CANCEL_USER_LOGIN_ID'] = $userid;

                    }
                     
                    $updateWhere = [
                        'PTW_ID' => $PTWID,
                    ];

                    $ptwID = $this->common_model->updateInfo(PTW_TBL, $updateData, 'PTW_ID', $updateWhere);
                    if ($ptwID) {
                        $sendNotify = TRUE;
                        if ($sendNotify) {
                          $notifyData = [
                            'permitTypeName' =>$permitTypeName,
                            'permitId' =>$PTWID,
                            ];
                            sendNotification($notifyData);
                          }
                        $this->session->set_flashdata("permitflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> ' . $permitTypeName . 'Permit Reactivate/Cancel Permit Successfully</div>');

                        redirect($returnURL);
                    } else {
                        $this->session->set_flashdata("permitflash", '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Error!</span> ' . $permitTypeName . ' Permit Reactivate/Cancel Permit Failed</div>');
                        redirect($returnURL);
                    }
                } else {
                    $this->verify($id);
                }
            } else if (in_array($PTWStatus, [6,7, 10]) && $PTWClose == TRUE && ($closeBtn =='Submit & Close' || $submitaction =='close' && $submitaction !='')) { /* PTW Close */
                $this->form_validation->set_rules('work_complete_declaration', 'WORK SUPERVISOR (WS) ', 'required');

                if ($this->form_validation->run() == true) {

                    $work_complete_declaration = postData($getPermitData, 'work_complete_declaration');
                    $work_complete_name = postData($getPermitData, 'work_complete_name');
                    $work_complete_date = postData($getPermitData, 'work_complete_date');
                    $work_complete_time = postData($getPermitData, 'work_complete_time');
                    $close = postData($getPermitData, 'close');
                    $status = 7;
                    $CloseDate = converttoDBDate($work_complete_date, 'Y-m-d');
                    $CloseTime = converttoDBDate($work_complete_time, 'H:i:s');

                    $updateData = [
                        'WORK_COMPLETION' => ($work_complete_declaration == 1) ? '1' : '0',
                        'WORK_COMPLETE_NAME' => $work_complete_name,
                        'WORK_COMPLETE_DATE' => $CloseDate,
                        'WORK_COMPLETE_TIME' => $CloseTime,
                        'WORK_COMPLETE_USER_LOGIN_ID' => $userid,
                        'PTW_CLOSE_TYPE' => 'MANUAL',
                        'STATUS' => $status
                    ];

                    $updateWhere = [
                        'PTW_ID' => $PTWID,
                    ];

                    $ptwID = $this->common_model->updateInfo(PTW_TBL, $updateData, 'PTW_ID', $updateWhere);
                    if ($ptwID) {
                       
                        if (!empty($_FILES['permit_sactioning_form'])) {
                            $path = 'public/module/PTW/' . $ptwID . '/';
                            $allowedType = 'jpg|png|jpeg|pdf';
                            $type = 'permit_sactioning_form';
                            $totaluploddoc = 0;
                            $fname = strtolower(trim('permit_sactioning_form')).'_'.$permitId;
                          $uploadInfo = uploadMultipleDoc($_FILES, $path,$type, $allowedType, TRUE,TRUE,$fname,$totaluploddoc);
                            $uploadError['field_name'] = 'permit_sactioning_form';
                            $uploadError['error_msg'] = $uploadInfo;


                            if ($uploadInfo != FALSE && count($uploadInfo) > 0) {
                                foreach ($uploadInfo as $file) {
                                    $isImage = (isset($file['is_image'])) ? $file['is_image'] : 0;
                                    $updateUploadData = [
                                        'REF_PTW_ID' => $ptwID,
                                        'SD_FILENAME' => postData($file, 'uploadname'),
                                        'SD_FILETYPE' => postData($file, 'uploadtype'),
                                        'SD_FILE_EXT' => postData($file, 'uploadextension'),
                                        'SD_FILE_SIZE' => postData($file, 'filesize'),
                                        'SD_FILE_PATH' => postData($file, 'uploadpath'),
                                        'SD_ORIG_FILENAME' => postData($file, 'orig_name'),
                                        'IS_IMAGE' => $isImage,
                                    ];
                                    $updatePTWUploadWhere = [
                                        'REF_PTW_WH_ID' => $ptwID,
                                        'SD_FILENAME' => postData($file, 'uploadname'),
                                        'SD_FILE_PATH' => postData($file, 'uploadpath'),
                                    ];
                                    $PTW_SAN_ID = $this->common_model->updateInfo(PTW_SANC_DOCS, $updateUploadData, 'PTW_SD_ID', $updatePTWUploadWhere);
                                }
                            }
                        }
                        if (!empty($_FILES['permit_sactioning_form1'])) {

                            $path = 'public/module/PTW/' . $ptwID . '/';
                            $allowedType = 'jpg|png|jpeg|pdf';
                            $type = 'permit_sactioning_form1';
                            $totaluploddoc = 0;
                            $fname = strtolower(trim('permit_toolbox_talk_form')).'_'.$permitId;
                          $uploadInfo = uploadMultipleDoc($_FILES, $path,$type, $allowedType, TRUE,TRUE,$fname,$totaluploddoc);
                            $uploadError['field_name'] = 'permit_sactioning_form1';
                            $uploadError['error_msg'] = $uploadInfo;


                            if ($uploadInfo != FALSE && count($uploadInfo) > 0) {
                                foreach ($uploadInfo as $file) {
                                    $isImage = (isset($file['is_image'])) ? $file['is_image'] : 0;
                                    $updateUploadData = [
                                        'REF_PTW_ID' => $ptwID,
                                        'SD_FILENAME' => postData($file, 'uploadname'),
                                        'SD_FILETYPE' => postData($file, 'uploadtype'),
                                        'SD_FILE_EXT' => postData($file, 'uploadextension'),
                                        'SD_FILE_SIZE' => postData($file, 'filesize'),
                                        'SD_FILE_PATH' => postData($file, 'uploadpath'),
                                        'SD_ORIG_FILENAME' => postData($file, 'orig_name'),
                                        'IS_IMAGE' => $isImage,
                                    ];
                                    $updatePTWUploadWhere = [
                                        'REF_PTW_WH_ID' => $ptwID,
                                        'SD_FILENAME' => postData($file, 'uploadname'),
                                        'SD_FILE_PATH' => postData($file, 'uploadpath'),
                                    ];
                                    $PTW_SAN_IDS = $this->common_model->updateInfo(PTW_SANC_TOOL_DOCS, $updateUploadData, 'PTW_SD_ID', $updatePTWUploadWhere);
                                }
                            }
                        }
                    }

                    if ($ptwID) {
                        $sendNotify = TRUE;
                        if ($sendNotify) {
                          $notifyData = [
                            'permitTypeName' =>$permitTypeName,
                            'permitId' =>$PTWID,
                            ];
                            sendNotification($notifyData);
                          }
                        $this->session->set_flashdata("permitflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> ' . $permitTypeName . 'Permit Closed Successfully</div>');

                        redirect($returnURL);
                    } else {
                        $this->session->set_flashdata("permitflash", '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Error!</span> ' . $permitTypeName . ' Permit Closed Failed</div>');
                        redirect($returnURL);
                    }
                } else {
                    $this->verify($id);
                }
            } else {
                $this->session->set_flashdata("permitflash", '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Error!</span> ' . $permitTypeName . ' Verification Failed</div>');
                redirect($returnURL);
            }
        }
    }

    public function save() {
        ini_set('memory_limit','-1');
        ini_set("post_max_size", "500M");
        ini_set("upload_max_filesize", "500M");
        ini_set('max_file_uploads', 500);
        $userid = getCurrentUserid();
        $userType = getCurrentUserGroupId();
        global $aPermitType;
        $uploadError = [];
        $permitType = $this->input->post('permitType');
        $permitTypeId = array_search($permitType, ($aPermitType));
        switch ($permitTypeId) {
            case 1:
                $returnURL = 'ptw/permit/normalList';
                $permitTypeName = 'Normal PTW';
                break;
            case 2:
                $returnURL = 'ptw/permit/criticalList';
                $permitTypeName = 'Critical PTW';
                break;

            default:
                $returnURL = 'dashboard';
                $permitTypeName = 'PTW';
                break;
        }
        $notifyData = [
            'permitTypeName' =>$permitTypeName,
            'permitId' =>0,
        ];

        $getPermitData = $this->input->post();
        $editId = postData($getPermitData, 'ptw_id');

        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('specific_location', 'Specific Location', 'required|alpha_dash_space|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'End Date', 'required');
        $this->form_validation->set_rules('area_classification', 'Area Classification', 'required');
        $this->form_validation->set_rules('work_description', 'Work Description', 'required');
        $this->form_validation->set_rules('hazardActivities_additional_doc[24]', 'HIRARC', 'required');
        $this->form_validation->set_rules('hazardActivities_additional_doc[25]', 'Work Method Statement', 'required');

    //    echo '<pre>';
    //    print_r($getPermitData);
    // //    print_r($_FILES);
    //    exit;

        $sessiondata = $this->session->userinfo;
        $refUsrType = postData($sessiondata, 'USER_TYPE_ID');

        $PTWUserType = (in_array($refUsrType, [4, 1, 2])) ? 'EMP' : 'CONT';

        $sendNotify = FALSE;

        if ($this->form_validation->run() == true) {
           
            $locationId = postData($getPermitData, 'location');
            $designation = postData($getPermitData, 'designation');
            $applicationName = postData($getPermitData, 'applicant_name');
            $designationId = postData($getPermitData, 'designationId');
            $sectionId = postData($getPermitData, 'sectionId');
            $companyName = postData($getPermitData, 'company_name');
            $specific_location = postData($getPermitData, 'specific_location');
            $start_date = postData($getPermitData, 'start_date');
            $end_date = postData($getPermitData, 'end_date');
            $area_classification = postData($getPermitData, 'area_classification');
            $work_description = postData($getPermitData, 'work_description');
            $special_work_instruction = postData($getPermitData, 'special_work_instruction');
            $special_work_instruction_option = postData($getPermitData, 'specialworkinstruction_option');
            $OA1 = postData($getPermitData, 'operation_authority_1');
            $OA2 = postData($getPermitData, 'operation_authority_2');
            $initial_pa_name = postData($getPermitData, 'initial_pa_name');
            $initial_pa_date = postData($getPermitData, 'initial_pa_date');
            $initial_pa_time = postData($getPermitData, 'initial_pa_time');
            $initial_declaration = postData($getPermitData, 'initial_declaration');


            $startDate = ($start_date != '') ? converttoDBDate($start_date) : '0000-00-00';
            $endDate = ($end_date != '') ? converttoDBDate($end_date) : '0000-00-00';

            $initialDate = converttoDBDate($initial_pa_date, 'Y-m-d');
            $initialTime = converttoDBDate($initial_pa_time, 'H:i:s');
           
            /*
             * Section 1
             * 
             */
            
            if($special_work_instruction_option == 0){
               $special_work_instruction = ''; 
            }
             $locName = getLocationShorName($locationId);
            $updatePTWBasicData = [
                'PERMIT_TYPE' => $permitTypeId,
                'APPLICANT_NAME' => $applicationName,
                'DESIGNATION' => $designationId,
                'APPLICANT_DESIGNATION_NAME' => $designation,
                'APPLICANT_USER_TYPE_ID' => $userType,
                'SECTION' => $sectionId,
                'LOCATION' => $locationId,
                'LOCATION_NAME' => $locName,
                'COMPANY_NAME' => $companyName,
                'SPECIFIC_WORKSITE' => $specific_location,
                'START_DATE' => $startDate,
                'END_DATE' => $endDate,
                'AREA_OF_CLASSIFICATION' => $area_classification,
                'WORK_DESCRIPTION' => $work_description,
                'SPECIFIC_WORK_INSTRUCTION' => $special_work_instruction,
                'OA1' => $OA1,
                'OA2' => $OA2,
                'INITIAL_DECLARATION' => $initial_declaration,
                'INITIAL_PA_NAME' => $initial_pa_name,
                'INITIAL_PA_DATE' => $initialDate,
                'INITIAL_PA_TIME' => $initial_pa_time,
                'CREATED_BY' => $userid,
                'CONFINED_SPACE' => 'N',
                'SPECIFIC_WORK_INSTRUCTION_OPTION' => $special_work_instruction_option,
                'STATUS' => 1,
            ];

		 ///////////////// new code start
            $addmorimgDatas = [];
            if(isset($_FILES['addmoreImages']) && !empty($_FILES['addmoreImages'])){
            $addmorimgDatas = uploadMultipleimage($_FILES, 'public/module/PTW/','addmoreImages');
          }
         
          
          if(isset($addmorimgDatas) && !empty($addmorimgDatas)){
              foreach($addmorimgDatas as $imaddKey => $imaddVal){
                               $imgmorUplname =  $imaddVal['uploadname'];
                               $imgmorUplpath = $imaddVal['uploadpath'];
                               $imgmorUplext =  $imaddVal['uploadextension'];
                               $imgmorUplsize =  $imaddVal['filesize'];
                               
                               $updatePTWBasicData['SEC1_FILENAME'] = $imgmorUplname;
                               $updatePTWBasicData['SEC1_FILEPATH'] = $imgmorUplpath;
                               $updatePTWBasicData['SEC1_FILEEXT'] = $imgmorUplext;
                               $updatePTWBasicData['SEC1_FILESIZE'] = $imgmorUplsize;
                               
                 }
          }
          ///////////////// new code end

             $insertStatus = FALSE;
           
            if ($editId > 0) {
                $updatePTWWhere = [
                    'PTW_ID' => $editId,
                ];
                $checkWhere = [
                    'PTW_ID' => $editId,
                ];
                $editoption = [];
                $editData = $this->permit->getPTWInfo($checkWhere, 'row',$editoption);
                $permitId = postData($editData,'LIVE_PERMIT_NO');

                $updatePTWBasicData['UPDATED_ON'] = date('Y-m-d H:i:s');
                $sendNotify = TRUE;
                
            } else {
               
                $permitId = getPermitNumber($locName,$locationId);
                $updatePTWWhere = [
                    'LIVE_PERMIT_NO' => $permitId,
                ];
                $updatePTWBasicData['SYSTEM_PERMIT_NO'] = $permitId;
                $updatePTWBasicData['LIVE_PERMIT_NO'] = $permitId;
                $updatePTWBasicData['CREATED_ON'] = date('Y-m-d H:i:s');
                $sendNotify = TRUE;
                $insertStatus = TRUE;
            }


            $ptwID = $this->common_model->updateInfo(PTW_TBL, $updatePTWBasicData, 'PTW_ID', $updatePTWWhere);
            
            $notifyData['permitId'] = $ptwID;
           

            /*
             * Section 1 - Specic Document Upload
             * 
             */
            if (!empty($_FILES['section_upload_documents'])) {
                $path = 'public/module/PTW/' . $ptwID . '/';
                $allowedType = 'jpg|png|jpeg|pdf';
                $fname = 'special_work_instruction_'.$permitId;
                
                if($special_work_instruction_option == 1){
                
                $uploadInfo = uploadMultipleDoc($_FILES, $path, $type = 'section_upload_documents', $allowedType, TRUE,TRUE,$fname,0);
                $uploadError['field_name'] = 'section_upload_documents';
                $uploadError['error_msg'] = $uploadInfo;
                //$this->session->set_flashdata("permituploadErrflash", $uploadError);
                // return $this->index($editId);
                
                if ($uploadInfo != FALSE && count($uploadInfo) > 0) {
                    foreach ($uploadInfo as $file) {

                        $isImage = (isset($file['is_image'])) ? $file['is_image'] : 0;
                        $updateUploadData = [
                            'REF_PTW_ID' => $ptwID,
                            'ATTACH_TYPE' => 'SPECWORK',
                            'SEC_FILENAME' => postData($file, 'uploadname'),
                            'SEC_FILETYPE' => postData($file, 'uploadtype'),
                            'SEC_FILE_EXT' => postData($file, 'uploadextension'),
                            'SEC_FILE_SIZE' => postData($file, 'filesize'),
                            'SEC_FILE_PATH' => postData($file, 'uploadpath'),
                            'SEC_ORIG_FILENAME' => postData($file, 'orig_name'),
                            'IS_IMAGE' => $isImage,
                            'ATTACH_STATUS' => 'Y',
                        ];

                        $updatePTWUploadWhere = [
                            'REF_PTW_ID' => $ptwID,
                            'ATTACH_TYPE' => 'SPECWORK',
                        ];
                        $ptwUpID = $this->common_model->updateInfo(PTW_SEC_ATTACH, $updateUploadData, 'PTW_SEC_ATT_ID', $updatePTWUploadWhere);
                    }
                 }
                }else{
                    $updateUploadData = [
                            'ATTACH_STATUS' => 'N',
                        ];
                    $updatePTWUploadWhere = [
                            'REF_PTW_ID' => $ptwID,
                            'ATTACH_TYPE' => 'SPECWORK',
                        ];
                        $ptwUpID = $this->common_model->updateInfo(PTW_SEC_ATTACH, $updateUploadData, 'PTW_SEC_ATT_ID', $updatePTWUploadWhere);
                }
            }

            /*
             * Section 2
             */

            $hazard_activity_ref_id = postData($getPermitData, 'hazard_activity_ref_id');
            $hzActClearanceCertList = postData($getPermitData, 'hazActClearanceCert');

            if ($hazard_activity_ref_id != FALSE && count($hazard_activity_ref_id) > 0) {
                foreach ($hazard_activity_ref_id as $hkey => $hval) {
                    switch ($hval) {
                        case 1:
                            $fname = 'hazardActivities_routine';
                            break;
                        case 2:
                            $fname = 'hazardActivities_cc';
                            break;
                        case 3:
                            $fname = 'hazardActivities_additional_doc';
                            break;

                        default:
                            break;
                    }
                    $hazardActivity = $this->input->post($fname);
                    
                     /*Change status to "N" for uncheck checklist based on key*/  
                   if ($editId > 0) {
                        $HZCheckListInfo = $this->permit->getHzActivityCheckList(['REF_PTW_ID' => $ptwID,'HZ_STATUS'=>'Y'], 'result');
                        $existCheckListId = [];
                        if($HZCheckListInfo != FALSE){
                            foreach($HZCheckListInfo as $k => $v){
                                $pid = postData($v,'WH_REF_ID');
                                $checkListIds = postData($v,'checkListIds');
                                $explodeCkId = ($checkListIds != FALSE) ? explode(',',$checkListIds): [];
                                $existCheckListId[$pid] = $explodeCkId; 
                                
                            }
                        }
                        
                        $arrayDiff = array_diff($existCheckListId[$hval], $hazardActivity);
                            if($arrayDiff != FALSE && count($arrayDiff) > 0){
                               
                                 $updateTrash = [
                                       'HZ_STATUS' => 'N',
                                  ];
                                  $updateTrashWhere = [
                                     'REF_PTW_ID' => $ptwID,
                                     'WH_REF_ID' => $hval,
                                     'HZ_STATUS' => 'Y',
                                  ];
                                  $this->db->where_in('WH_CHKLST_ID',$arrayDiff);
                                  $this->db->where($updateTrashWhere);
                                  $this->db->update(PTW_WORK_HA, $updateTrash);
                                  
                             }
                             
                             /*
                              * Confined Space Unchecked
                              */
                        if(in_array(19, $arrayDiff)){
                            $updtPTWMain = [
                                      'CONFINED_SPACE'=>'N',
                                      'GAS_TEST_DECLARATION'=>0,
                                      'CONFINED_SPACE_COMPLETION'=>"N",
                                  ];
                                  $updtPTWMainWhere = [
                                      'PTW_ID'=>$ptwID
                                  ];
                                 
                                  $this->db->where($updtPTWMainWhere);
                                  $this->db->update(PTW_TBL, $updtPTWMain);
                                  
                                  $delWhere = [
                                                'REF_PTW_ID' => $ptwID,
                                                'WH_REF_ID' => 2,
                                                'WH_CHKLST_ID' => 19,
                                            ];
                                 $this->permit->deleteInfo(PTW_WORK_HA, $delWhere);
                                  
                             
                                 $delWhere = [ 
                                     'REF_PTW_ID' => $ptwID,
                                                
                                  ];
                                  $this->permit->deleteInfo(PTW_WORK_HA_CC_CS, $delWhere);
                                  
                                  
                        }
                        
                       
                }


                    if ($hazardActivity != FALSE && count($hazardActivity) > 0) {
                        foreach ($hazardActivity as $haKey => $haVal) {

                            $updateHazard = [
                                'REF_PTW_ID' => $ptwID,
                                'WH_REF_ID' => $hval,
                                'WH_CHKLST_ID' => $haVal,
                                'HZ_STATUS' => 'Y',
                            ];

                            $updatePTWHZWhere = [
                                'REF_PTW_ID' => $ptwID,
                                'WH_REF_ID' => $hval,
                                'WH_CHKLST_ID' => $haVal,
                                'HZ_STATUS' => 'Y',
                            ];


                            switch ($hval) {
                                case 1:
                                    if ($haVal == -1) {
                                        $hazardActivityOther = $this->input->post('other_hazardActivities_routine');

                                        if ($hazardActivityOther != FALSE && count($hazardActivityOther) > 0) {
                                            $delWhere = [
                                                'REF_PTW_ID' => $ptwID,
                                                'WH_REF_ID' => $hval,
                                                'WH_CHKLST_ID' => $haVal,
                                            ];
                                            $this->permit->deleteInfo(PTW_WORK_HA, $delWhere);

                                            foreach ($hazardActivityOther as $key => $val) {
                                                if ($val != '') {
                                                    $updateHazard['WH_CHKLIST_TEXT'] = $val;
                                                    $updatePTWHZWhere['WH_CHKLIST_TEXT'] = $val;
                                                }

                                                $ptwHZID = $this->common_model->updateInfo(PTW_WORK_HA, $updateHazard, 'PTW_WH_ID', $updatePTWHZWhere);
                                            }
                                        }
                                    } else {
                                        $ptwHZID = $this->common_model->updateInfo(PTW_WORK_HA, $updateHazard, 'PTW_WH_ID', $updatePTWHZWhere);
                                    }
                                    $uploadDoc = FALSE;
                                    break;
                                case 2:

                                    $ptwHZID = $this->common_model->updateInfo(PTW_WORK_HA, $updateHazard, 'PTW_WH_ID', $updatePTWHZWhere);
                                    
                                    $checkCertClerKey= array_key_exists($haVal, $hzActClearanceCertList);
                                    if($checkCertClerKey){
                                        $checkListCC = $this->input->post('checklist_'.$haVal);
                                        if($checkListCC != FALSE && count($checkListCC) > 0){
                                            foreach($checkListCC as $ccVal){
                                                //PTW_WORK_HA_CC
                                               $updateHazardCC = [
                                                'REF_PTW_WH_ID' => $ptwHZID,
                                                'CHECKLIST_ID' => $ccVal
                                               ];

                                                $updatePTWHZCCWhere = [
                                                   'REF_PTW_WH_ID' => $ptwHZID,
                                                   'CHECKLIST_ID' => $ccVal
                                                ];
                                                $ptwHZCCID = $this->common_model->updateInfo(PTW_WORK_HA_CC, $updateHazardCC, 'PTW_HAC_ID', $updatePTWHZCCWhere);
                                            }
                                            
                                        }
                                        //$haVal
                                        /*
                                 * Section 2 - Document Upload
                                 * 
                                 */
                                if (!empty($_FILES['upload_photo_' . $haVal])) {
                                    $path = 'public/module/PTW/' . $ptwID . '/';
                                    $allowedType = 'jpg|png|jpeg|pdf';
                                    
                                    
                                    $utype = 'upload_photo_' . $haVal;
                                    
                                    $catNameList = $this->input->post('hazard_activity_ref_cat_name');
                                    $uploddocName = isset($catNameList[$haVal]) ? $catNameList[$haVal] : 'uplod_photo_'.$haVal;
                                    $totaluploddoc = 0;
                                    $fname = strtolower(trim($uploddocName)).'_'.$permitId;
                $uploadInfo = uploadMultipleDoc($_FILES, $path,$utype, $allowedType, TRUE,TRUE,$fname,$totaluploddoc);
                                    $uploadError['field_name'] = 'section_upload_documents';
                                    $uploadError['error_msg'] = $uploadInfo;
                                   

                                    if ($uploadInfo != FALSE && count($uploadInfo) > 0) {
                                        foreach ($uploadInfo as $file) {
                                            $updateUploadData = [
                                                'REF_PTW_WH_ID' => $ptwHZID,
                                                'WHCA_CATEGORY' => $haVal,
                                                'WHCA_FILENAME' => postData($file, 'uploadname'),
                                                'WHCA_ORIG_FILENAME' => postData($file, 'uploadtype'),
                                                'WHCA_FILE_EXT' => postData($file, 'uploadextension'),
                                                'WHCA_FILE_SIZE' => postData($file, 'filesize'),
                                                'WHCA_FILE_PATH' => postData($file, 'uploadpath'),
                                            ];
                                            $updatePTWUploadWhere = [
                                                'REF_PTW_WH_ID' => $ptwID,
                                                'WHCA_CATEGORY' => $ptwHZID,
                                                'WHCA_FILENAME' => postData($file, 'uploadname'),
                                                'WHCA_FILE_PATH' => postData($file, 'uploadpath'),
                                            ];
                                            $PTW_WHCA_ATT_ID = $this->common_model->updateInfo(PTW_WORK_HA_CC_ATT, $updateUploadData, 'WHCA_ID', $updatePTWUploadWhere);
                                        }
                                    }
                                }
                                /*
                                 * Confined Space
                                 */
                                
                      $confined_space  =  $this->input->post('confined_space');
                      $gas_test_declaration  =  $this->input->post('gas_test_declaration');
                               
                       if($haVal == 19 && $confined_space != FALSE && count($confined_space) >0){
                           foreach($confined_space as $cskey => $csrow){
                             $csDate = postData($csrow,'date');
                             $csTime = postData($csrow,'time');
                             $csLel = postData($csrow,'lel');
                             $csO2 = postData($csrow,'O2');
                             $csH2S = postData($csrow,'H2S');
                             $csCO = postData($csrow,'CO');
                             $csAgtName = postData($csrow,'agt_name');
                             
                               $initialDate = converttoDBDate($csDate, 'Y-m-d');
                               $initialTime = converttoDBDate($csTime, 'H:i:s');
                             $updateCS = [
                                 'REF_PTW_ID'=>$ptwID,
                                 'REF_PTW_WH_ID'=>$ptwHZID,
                                 'WHA_CATEGORY_ID'=>$haVal,
                                 'WHA_REF_ID'=>$cskey,
                                 'CS_DATE'=>$initialDate,
                                 'CS_TIME'=>$initialTime,
                                 'CS_LEL'=>$csLel,
                                 'CS_O2'=>$csO2,
                                 'CS_H2S'=>$csH2S,
                                 'CS_CO'=>$csCO,
                                 'CS_AGT_NAME'=>$csAgtName,
                                 'STATUS'=>'Y',
                             ];
                             
                             $updateCSWhere = [
                                 'REF_PTW_ID'=>$ptwID,
                                 'REF_PTW_WH_ID'=>$ptwHZID,
                                 'WHA_CATEGORY_ID'=>$haVal,
                                 'WHA_REF_ID'=>$cskey,
                             ];
                              $ptwHZCSID = $this->common_model->updateInfo(PTW_WORK_HA_CC_CS, $updateCS, 'WHA_CONFINED_SPACE_ID', $updateCSWhere);
                              
                              if($ptwHZCSID){
                                  $updtPTWMain = [
                                      'CONFINED_SPACE'=>'Y',
                                      'GAS_TEST_DECLARATION'=>$gas_test_declaration,
                                  ];
                                  $updtPTWMainWhere = [
                                      'PTW_ID'=>$ptwID
                                  ];
                                 
                                  $this->db->where($updtPTWMainWhere);
                                  $this->db->update(PTW_TBL, $updtPTWMain);
                              }
                           }
                       }
                                        
                                    }
                                    
                                    
                                    $uploadDoc = FALSE;
                                    break;

                                case 3:

                                    if ($haVal == 26) {
                                        $other_hazard_desc = $this->input->post('other_hazard_desc');
                                        $updateHazard['WH_CHKLIST_TEXT'] = $other_hazard_desc;
                                        $ptwHZID = $this->common_model->updateInfo(PTW_WORK_HA, $updateHazard, 'PTW_WH_ID', $updatePTWHZWhere);
                                    }else if ($haVal == 33) { //other_isolation_desc
                                        $other_isolation_desc = $this->input->post('other_isolation_desc');
                                        $updateHazard['WH_CHKLIST_TEXT'] = $other_isolation_desc;
                                        $ptwHZID = $this->common_model->updateInfo(PTW_WORK_HA, $updateHazard, 'PTW_WH_ID', $updatePTWHZWhere);
                                    }else if ($haVal == 34) { // Gas Tester Name
                                        $gas_tester_name = $this->input->post('gas_tester_name');
                                        $updateHazard['WH_CHKLIST_TEXT'] = $gas_tester_name;
                                        $ptwHZID = $this->common_model->updateInfo(PTW_WORK_HA, $updateHazard, 'PTW_WH_ID', $updatePTWHZWhere);
                                    }else if ($haVal == 24) {
                                        $hirarc_reports = $this->input->post('hirarc_reports');
                                        $hirarc_type = $this->input->post('hirarc_type');
                                        $htype = ($hirarc_type == 1) ? 'EMP' : 'CONT';
                                        $updateHazard['HIRAC_TYPE'] = $htype;


                                        $ptwHZID = $this->common_model->updateInfo(PTW_WORK_HA, $updateHazard, 'PTW_WH_ID', $updatePTWHZWhere);


                                        $delWhere = [
                                            'PTW_ID' => $ptwID,
                                            'PTW_WH_REF_ID' => $ptwHZID,
                                        ];
                                        $this->permit->deleteInfo(WORK_HA_HIRARC, $delWhere);

                                        if ($hirarc_reports != FALSE && count($hirarc_reports) > 0 && $hirarc_type == 1) {


                                            foreach ($hirarc_reports as $key => $hrVal) {

                                                $updateReport = [
                                                    'PTW_ID' => $ptwID,
                                                    'PTW_WH_REF_ID' => $ptwHZID,
                                                    'HIRAC_TYPE' => $hirarc_type,
                                                    'HIRARC_ID' => $hrVal,
                                                    'STATUS' => 'Y',
                                                ];
                                                $updateReportWhre = [
                                                    'PTW_ID' => $ptwID,
                                                    'PTW_WH_REF_ID' => $ptwHZID,
                                                    'HIRAC_TYPE' => $hirarc_type,
                                                    'HIRARC_ID' => $hrVal,
                                                ];
                                                $ptwHZREPID = $this->common_model->updateInfo(WORK_HA_HIRARC, $updateReport, 'PTW_WHAH_ID', $updateReportWhre);
                                            }
                                        }
                                        $uploadDoc = TRUE;
                                    }else{
                                         $ptwHZID = $this->common_model->updateInfo(PTW_WORK_HA, $updateHazard, 'PTW_WH_ID', $updatePTWHZWhere);
                                    $uploadDoc = TRUE;
                                    }

                                    break;


                                default:
                                    break;
                            }
                             
                            if ($uploadDoc) {
                                /*
                                 * Section 2 - Document Upload
                                 * 
                                 */
                                if (!empty($_FILES['upload_documents_' . $haVal])) {
                                    $path = 'public/module/PTW/' . $ptwID . '/';
                                    $allowedType = 'jpg|png|jpeg|pdf';
                                    
                                    
                                    $utype = 'upload_documents_' . $haVal;
                                    
                                    $catNameList = $this->input->post('hazard_activity_ref_cat_name');
                                    $uploddocName = isset($catNameList[$haVal]) ? $catNameList[$haVal] : 'uplod_doc_'.$haVal;
                                    $totaluploddoc = 0;
                                    $fname = strtolower(trim($uploddocName)).'_'.$permitId;
                $uploadInfo = uploadMultipleDoc($_FILES, $path,$utype, $allowedType, TRUE,TRUE,$fname,$totaluploddoc);
                                    $uploadError['field_name'] = 'section_upload_documents';
                                    $uploadError['error_msg'] = $uploadInfo;
                                   

                                    if ($uploadInfo != FALSE && count($uploadInfo) > 0) {
                                        foreach ($uploadInfo as $file) {
                                            $updateUploadData = [
                                                'REF_PTW_WH_ID' => $ptwHZID,
                                                'WHA_CATEGORY' => $haVal,
                                                'WHA_FILENAME' => postData($file, 'uploadname'),
                                                'WHA_FILETYPE' => postData($file, 'uploadtype'),
                                                'WHA_FILE_EXT' => postData($file, 'uploadextension'),
                                                'WHA_FILE_SIZE' => postData($file, 'filesize'),
                                                'WHA_FILE_PATH' => postData($file, 'uploadpath'),
                                            ];
                                            $updatePTWUploadWhere = [
                                                'REF_PTW_WH_ID' => $ptwID,
                                                'WHA_CATEGORY' => $ptwHZID,
                                                'WHA_FILENAME' => postData($file, 'uploadname'),
                                                'WHA_FILE_PATH' => postData($file, 'uploadpath'),
                                            ];
                                            $PTW_WH_ATT_ID = $this->common_model->updateInfo(PTW_WORK_HA_ATT, $updateUploadData, 'PTW_WH_ATT_ID', $updatePTWUploadWhere);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }


            /*
             * Section 3
             */

            $wpp_ref_id = postData($getPermitData, 'wpp_ref_id');
            if ($wpp_ref_id != FALSE && count($wpp_ref_id) > 0) {
                /*Change status to "N" for uncheck checklist based on key*/  
                   if ($editId > 0) {
                        $wppCheckListInfo = $this->permit->getWPPCheckList(['REF_PTW_ID' => $ptwID,'WPP_STATUS'=>'Y'], 'result');
                        $existCheckListId = [];
                        if($wppCheckListInfo != FALSE){
                            foreach($wppCheckListInfo as $k => $v){
                                $pid = postData($v,'WSP_CATEGORY_ID');
                                $checkListIds = postData($v,'checkListIds');
                                $explodeCkId = ($checkListIds != FALSE) ? explode(',',$checkListIds): [];
                                $existCheckListId[$pid] = $explodeCkId; 
                                 /*Remove uncheck checkbox on edit*/
                                 $fname = 'wpp_checklist_' . $pid;
                                 $WPPCurrentData = $this->input->post($fname);
                                 if($WPPCurrentData == FALSE){
                                      $updateTrash = [
                                         'WPP_STATUS' => 'N',
                                      ];
                                    $updateTrashWhere = [
                                       'REF_PTW_ID' => $ptwID,
                                       'WPP_STATUS' => 'Y',
                                    ];
                                    $this->db->where_in('WSP_CATEGORY_ID',[$pid]);
                                    $this->db->where($updateTrashWhere);
                                    $this->db->update(PTW_WS_PREPARE, $updateTrash);
                                   
                                 }
                            }
                        }
                       
                }
                
               
                
                foreach ($wpp_ref_id as $wppkey => $wppval) {
                    $fname = 'wpp_checklist_' . $wppval;
                    $WPPData = $this->input->post($fname);

                    if ($WPPData != FALSE && count($WPPData) > 0) {
                        /*Remove uncheck checkbox on edit*/
                        if ($editId > 0) {
                            
                            $arrayDiff = (is_array($existCheckListId[$wppval])) ? array_diff($existCheckListId[$wppval], $WPPData) : FALSE;
                            if($arrayDiff != FALSE && count($arrayDiff) > 0){
                               
                               
                                 $updateTrash = [
                                       'WPP_STATUS' => 'N',
                                  ];
                                  $updateTrashWhere = [
                                     'REF_PTW_ID' => $ptwID,
                                     'WSP_CATEGORY_ID' => $wppval,
                                     'WPP_STATUS' => 'Y',
                                  ];
                                  $this->db->where_in('WSP_ITEM_ID',$arrayDiff);
                                  $this->db->where($updateTrashWhere);
                                  $this->db->update(PTW_WS_PREPARE, $updateTrash);
                                  
                             }
                            
                             
                        }

                        foreach ($WPPData as $WPPCheckKey => $WPPCheckID) {
                            $uploadDoc = FALSE;

                            $updateWPP = [
                                'REF_PTW_ID' => $ptwID,
                                'WSP_CATEGORY_ID' => $wppval,
                                'WSP_ITEM_ID' => $WPPCheckID,
                                'WPP_STATUS' => "Y",
                            ];

                            $updateWPPWhere = [
                                'REF_PTW_ID' => $ptwID,
                                'WSP_CATEGORY_ID' => $wppval,
                                'WSP_ITEM_ID' => $WPPCheckID,
                                'WPP_STATUS' => "Y",
                            ];

                            // To chech other details for Section A in WPP
                            if ($WPPCheckID == WPP_BASIC_REQ_OTHER_ID) {
                                $otherWPPDesc = $this->input->post('other_basic_req');
                                $updateWPP['WSP_ITEM_LABEL'] = $otherWPPDesc;
                            } elseif ($WPPCheckID == WPP_BASIC_REQ_GASTESTER_ID) {
                                $gastesterName = $this->input->post('gas_tester_name');
                                $updateWPP['WSP_ITEM_LABEL'] = $gastesterName;
                            } elseif ($WPPCheckID == WPP_ISOLATION_CRITICAL_OTHER_ID) {
                                $other_isolation_desc = $this->input->post('other_isolation_desc');
                                $updateWPP['WSP_ITEM_LABEL'] = $other_isolation_desc;
                            }



                            $WPPID = $this->common_model->updateInfo(PTW_WS_PREPARE, $updateWPP, 'PTW_WS_P_ID', $updateWPPWhere);
                            $uploadDoc = TRUE;

                            /*
                             * Section 3 - Document Upload
                             * 
                             */
                            if ($uploadDoc != FALSE && $WPPID != FALSE && $WPPID > 0) {

                                $WPPUploadFileName = 'wpp_upload_documents_' . $WPPCheckID;
                                if (!empty($_FILES[$WPPUploadFileName])) {
                                    $path = 'public/module/PTW/' . $ptwID . '/';
                                    $type = $WPPUploadFileName;
                                    $allowedType = 'jpg|png|jpeg|pdf';
                                   
                                    $catNameList = $this->input->post('wpp_ref_cat_name');
                                    $uploddocName = isset($catNameList[$WPPCheckID]) ? $catNameList[$WPPCheckID] : 'wpp_uplod_doc_'.$WPPCheckID;
                                    $totaluploddoc = 0;
                                    $fname = strtolower(trim($uploddocName)).'_'.$permitId;
                                  $uploadInfo = uploadMultipleDoc($_FILES, $path,$type, $allowedType, TRUE,TRUE,$fname,$totaluploddoc);
                                    $uploadError['field_name'] = 'wpp_upload_documents';
                                    $uploadError['error_msg'] = $uploadInfo;


                                    if ($uploadInfo != FALSE && count($uploadInfo) > 0) {
                                        foreach ($uploadInfo as $file) {
                                            $updateUploadData = [
                                                'REF_PTW_WS_P_ID' => $WPPID,
                                                'WSPA_FILENAME' => postData($file, 'uploadname'),
                                                'WSPA_FILETYPE' => postData($file, 'uploadtype'),
                                                'WSPA_FILE_EXT' => postData($file, 'uploadextension'),
                                                'WSPA_FILE_SIZE' => postData($file, 'filesize'),
                                                'WSPA_FILE_PATH' => postData($file, 'uploadpath'),
                                            ];
                                            $updateWPPUploadWhere = [
                                                'REF_PTW_WS_P_ID' => $WPPID,
                                                'WSPA_FILENAME' => postData($file, 'uploadname'),
                                                'WSPA_FILE_PATH' => postData($file, 'uploadpath'),
                                            ];
                                            $WPP_ATT_ID = $this->common_model->updateInfo(PTW_WS_PREPARE_ATT, $updateUploadData, 'PTW_WS_P_ATT_ID', $updateWPPUploadWhere);
                                        }
                                    }
                                }
                            } // upload End
                        }
                    }
                }
            } // End of section-3

            /*
             * Section 4
             */
            $PPE_ref_id = postData($getPermitData, 'PPE_ref_id');
            if ($PPE_ref_id != FALSE && count($PPE_ref_id) > 0) {
                
                  /*Change status to "N" for uncheck checklist based on key*/  
                   if ($editId > 0) {
                        $ppeCheckListInfo = $this->permit->getPPECheckList(['REF_PTW_ID' => $ptwID,'PPE_STATUS'=>'Y'], 'result');
                        $existCheckListId = [];
                        if($ppeCheckListInfo != FALSE){
                            foreach($ppeCheckListInfo as $k => $v){
                                $pid = postData($v,'PPE_CAT_ID');
                                $checkListIds = postData($v,'checkListIds');
                                $explodeCkId = ($checkListIds != FALSE) ? explode(',',$checkListIds): [];
                                $existCheckListId[$pid] = $explodeCkId; 
                            }
                        }  
                  
                $existingCheckKey = (is_array($existCheckListId)) ? array_keys($existCheckListId) : [];
                $currentCheckKey = (is_array($PPE_ref_id)) ? array_keys($PPE_ref_id) : [];
                $aDiffCheckKey = array_diff($existingCheckKey,$currentCheckKey);
                    if($aDiffCheckKey != FALSE && count($aDiffCheckKey) > 0){
                         $updateTrash = [
                                      'PPE_STATUS' => 'N',
                                 ];
                                 $updateTrashWhere = [
                                    'REF_PTW_ID' => $ptwID,
                                    'PPE_STATUS' => 'Y',
                                 ];
                                 $this->db->where_in('PPE_CAT_ID',$aDiffCheckKey);
                                 $this->db->where($updateTrashWhere);
                                 $this->db->update(PTW_PPE, $updateTrash);
                    }
                }
                foreach ($PPE_ref_id as $ppeKey => $ppeItem) {
                    if (is_array($ppeItem) && count($ppeItem) > 0) {
                      /*Change status to "N" for uncheck the Item*/  
                        if ($editId > 0) { 
                            $arrayDiff = (is_array($existCheckListId[$ppeKey])) ? array_diff($existCheckListId[$ppeKey], $ppeItem['checklist']) : FALSE;
                            if($arrayDiff != FALSE && count($arrayDiff) > 0){
                                 $updateTrash = [
                                       'PPE_STATUS' => 'N',
                                  ];
                                  $updateTrashWhere = [
                                     'REF_PTW_ID' => $ptwID,
                                     'PPE_CAT_ID' => $ppeKey,
                                     'PPE_STATUS' => 'Y',
                                  ];
                                  $this->db->where_in('PPE_ITEM_ID',$arrayDiff);
                                  $this->db->where($updateTrashWhere);
                                  $this->db->update(PTW_PPE, $updateTrash);
                             }
                                
                        }
                        foreach ($ppeItem['checklist'] as $ppeKeys => $ppeCheckList) {
                            $uploadDoc = FALSE;
                             

                            $updatePPE = [
                                'REF_PTW_ID' => $ptwID,
                                'PPE_CAT_ID' => $ppeKey,
                                'PPE_ITEM_ID' => $ppeCheckList,
                                'PPE_STATUS' => 'Y',
                                'PPE_CHECKED' => 1,
                            ];

                            $updatePPEWhere = [
                                'REF_PTW_ID' => $ptwID,
                                'PPE_CAT_ID' => $ppeKey,
                                'PPE_ITEM_ID' => $ppeCheckList,
                                'PPE_STATUS' => 'Y',
                                'PPE_CHECKED' => 1,
                            ];
                            $uploadDoc = FALSE;
                            if ($ppeKey == -1) {
                                $other_ppe_desc = $this->input->post('other_ppe_desc');
                                $updatePPE['PPE_ITEM_OTHER'] = $other_ppe_desc;
                                $uploadDoc = TRUE;
                            }

                            $PPEID = $this->common_model->updateInfo(PTW_PPE, $updatePPE, 'PTW_PPE_ID', $updatePPEWhere);
                            if ($uploadDoc) {
                                if ($uploadDoc != FALSE && $PPEID != FALSE && $PPEID > 0) {

                                    $PPEUploadFileName = 'ppe_upload_documents_' . $ppeKey;
                                    if (!empty($_FILES[$PPEUploadFileName])) {
                                        $path = 'public/module/PTW/' . $ptwID . '/';
                                        $type = $PPEUploadFileName;
                                        $allowedType = 'jpg|png|jpeg|pdf';
                                        $catNameList = $this->input->post('ppe_ref_cat_name');
                                    $uploddocName = isset($catNameList[$ppeKey]) ? $catNameList[$ppeKey] : 'ppe_uplod_doc_'.$ppeKey;
                                    $totaluploddoc = 0;
                                    $fname = strtolower(trim($uploddocName)).'_'.$permitId;
                                  $uploadInfo = uploadMultipleDoc($_FILES, $path,$type, $allowedType, TRUE,TRUE,$fname,$totaluploddoc);
                                        $uploadError['field_name'] = 'ppe_upload_documents_';
                                        $uploadError['error_msg'] = $uploadInfo;


                                        if ($uploadInfo != FALSE && count($uploadInfo) > 0) {
                                            foreach ($uploadInfo as $file) {
                                                $updateUploadData = [
                                                    'REF_PTW_ID' => $PPEID,
                                                    'PPEA_FILENAME' => postData($file, 'uploadname'),
                                                    'PPEA_FILETYPE' => postData($file, 'uploadtype'),
                                                    'PPEA_FILE_EXT' => postData($file, 'uploadextension'),
                                                    'PPEA_FILE_SIZE' => postData($file, 'filesize'),
                                                    'PPEA_FILE_PATH' => postData($file, 'uploadpath'),
                                                ];
                                                $updateWPPUploadWhere = [
                                                    'REF_PTW_WS_P_ID' => $WPPID,
                                                    'PPEA_FILENAME' => postData($file, 'uploadname'),
                                                    'PPEA_FILE_PATH' => postData($file, 'uploadpath'),
                                                ];
                                                $PPE_ATT_ID = $this->common_model->updateInfo(PTW_PPE_UPLS, $updateUploadData, 'PTW_PPE_UP_ID', $updateWPPUploadWhere);
                                            }
                                        }
                                    }
                                } // upload End
                            }
                        }
                    }
                }
            }// End of section-4
            if ($sendNotify) {
                sendNotification($notifyData);
            }
            if($insertStatus){
                 $this->session->set_flashdata("permitflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> ' . $permitTypeName . ' Created Successfully</div>');
            }else{
                 $this->session->set_flashdata("permitflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> ' . $permitTypeName . ' Updated Successfully</div>');
            }
           

            redirect($returnURL);
        } else {

            $this->index($editId);
        }
    }
    
    /*
     * Section -6 confined space save only
     */
    
    public function confinedSpaceSave($id =''){
         global $aPermitType, $aPTWPermission;
        $userType = getCurrentUserGroupId();
        $uploadError = [];
        $permitType = $this->input->post('permitType');
        $permitTypeId = array_search($permitType, ($aPermitType));
        switch ($permitTypeId) {
            case 1:
                $returnURL = BASE_URL.'ptw/permit/normalList';
                $permitTypeName = 'Normal PTW';
                break;
            case 2:
                $returnURL = BASE_URL.'ptw/permit/criticalList';
                $permitTypeName = 'Critical PTW';
                break;

            default:
                $returnURL = BASE_URL.'dashboard';
                $permitTypeName = 'PTW';
                break;
        }


        $getPermitData = $this->input->post();
        $editId = postData($getPermitData, 'ptw_id');
        $sessiondata = getCurrentUserDetails();
        
        if ($id != '') {
            $decryptPtwId = decryptval($id);
            $editData = $this->permit->getPTWInfo(['PTW_ID' => $decryptPtwId, 'PERMIT_TYPE' => $permitTypeId], 'row');
            $PTWStatus = postData($editData, 'STATUS');
            $PTWID = postData($editData, 'PTW_ID');
            
            $PTWClose = (in_array($userType, $aPTWPermission['close']) || is_admin()) ? TRUE : FALSE;
            $haVal = 19;
            $csWhere = [
                'REF_PTW_ID'=>$PTWID,
                'WHA_CATEGORY_ID'=>$haVal,
                'WHA_REF_ID'=>'-1'
            ];
            $confinedSpaceInfo = $this->permit->getPTWHZConfinedSpaceInfo($csWhere,'row');
            $ptwID = $PTWID;
           
            $ptwHZID = postData($confinedSpaceInfo,'REF_PTW_WH_ID');
            $confinedSpaceBtn = postData($getPermitData, 'confinedSpace');
            if($confinedSpaceBtn == 'Submit'){
                                 /*
                                 * Confined Space
                                 */
                                
                      $confined_space  =  $this->input->post('confined_space');
                      
                       if($confined_space != FALSE && count($confined_space) >0){
                           
                           foreach($confined_space as $cskey => $csrow){
                             $csDate = postData($csrow,'date');
                             $csTime = postData($csrow,'time');
                             $csLel = postData($csrow,'lel');
                             $csO2 = postData($csrow,'O2');
                             $csH2S = postData($csrow,'H2S');
                             $csCO = postData($csrow,'CO');
                             $csAgtName = postData($csrow,'agt_name');
                             
                               $initialDate = converttoDBDate($csDate, 'Y-m-d');
                               $initialTime = converttoDBDate($csTime, 'H:i:s');
                             $updateCS = [
                                 'REF_PTW_ID'=>$ptwID,
                                 'REF_PTW_WH_ID'=>$ptwHZID,
                                 'WHA_CATEGORY_ID'=>$haVal,
                                 'WHA_REF_ID'=>$cskey,
                                 'CS_DATE'=>$initialDate,
                                 'CS_TIME'=>$initialTime,
                                 'CS_LEL'=>$csLel,
                                 'CS_O2'=>$csO2,
                                 'CS_H2S'=>$csH2S,
                                 'CS_CO'=>$csCO,
                                 'CS_AGT_NAME'=>$csAgtName,
                                 'STATUS'=>'Y',
                             ];
                             
                             $updateCSWhere = [
                                 'REF_PTW_ID'=>$ptwID,
                                 'REF_PTW_WH_ID'=>$ptwHZID,
                                 'WHA_CATEGORY_ID'=>$haVal,
                                 'WHA_REF_ID'=>$cskey,
                             ];
                              $ptwHZCSID = $this->common_model->updateInfo(PTW_WORK_HA_CC_CS, $updateCS, 'WHA_CONFINED_SPACE_ID', $updateCSWhere);
                              
                              if($ptwHZCSID > 0 && $cskey == 6){
                                  $updtPTWMain = [
                                      'CONFINED_SPACE_COMPLETION'=>'Y',
                                  ];
                                  $updtPTWMainWhere = [
                                      'PTW_ID'=>$ptwID
                                  ];
                                 
                                  $this->db->where($updtPTWMainWhere);
                                  $this->db->update(PTW_TBL, $updtPTWMain);
                              }
                           }
                       }
                      if($ptwHZCSID){ 
                        $this->session->set_flashdata("permitflash", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> ' . $permitTypeName . ' Confined Space Updated Successfully</div>');
            redirect($returnURL);
                      }else{
                           $this->session->set_flashdata("permitflash", '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Failed!</span> ' . $permitTypeName . ' Confined Space Updated Failed</div>');
            redirect($returnURL);
                      }
            }
        }
    }

    public function deleteDoc() {

        $delId = $this->input->post('delId');
        $delRef = $this->input->post('delRef');
        $delType = $this->input->post('delType');
        $delFilepath = $this->input->post('delFilepath');
        $updtDelete = FALSE;
        switch ($delType) {
            case 'HZATTACH':
               $decId = decryptval($delId);
               $decRefId = decryptval($delRef);
               
               if($decId > 0 && $decRefId > 0){
                    $delWhere = [
                    'PTW_WH_ATT_ID' => $decId,
                    'REF_PTW_WH_ID' => $decRefId,
                ];
              $updtDelete =  $this->permit->deleteInfo(PTW_WORK_HA_ATT, $delWhere);
                if($updtDelete){
                    if(file_exists(FCPATH.$delFilepath)){
                    @unlink(FCPATH.$delFilepath);
                   }
                }
                
               }
                break;
                
                case 'WPPATTACH':
               $decId = decryptval($delId);
               $decRefId = decryptval($delRef);
               
               if($decId > 0 && $decRefId > 0){
                    $delWhere = [
                    'PTW_WS_P_ATT_ID' => $decId,
                    'REF_PTW_WS_P_ID' => $decRefId,
                ];
              $updtDelete =  $this->permit->deleteInfo(PTW_WS_PREPARE_ATT, $delWhere);
                if($updtDelete){
                    if(file_exists(FCPATH.$delFilepath)){
                    @unlink(FCPATH.$delFilepath);
                   }
                }
                
               }
                break;
                
                case 'PPEATTACH':
               $decId = decryptval($delId);
               $decRefId = decryptval($delRef);
               
               if($decId > 0 && $decRefId > 0){
                    $delWhere = [
                    'PTW_PPE_UP_ID' => $decId,
                    'REF_PTW_ID' => $decRefId,
                ];
              $updtDelete =  $this->permit->deleteInfo(PTW_PPE_UPLS, $delWhere);
                if($updtDelete){
                    if(file_exists(FCPATH.$delFilepath)){
                    @unlink(FCPATH.$delFilepath);
                   }
                }
                
               }
                break;
                case 'HZCCATTACH':
               $decId = decryptval($delId);
               $decRefId = decryptval($delRef);
               
               if($decId > 0 && $decRefId > 0){
                    $delWhere = [
                    'WHCA_ID' => $decId,
                    'REF_PTW_WH_ID' => $decRefId,
                ];
              $updtDelete =  $this->permit->deleteInfo(PTW_WORK_HA_CC_ATT, $delWhere);
                if($updtDelete){
                    if(file_exists(FCPATH.$delFilepath)){
                    @unlink(FCPATH.$delFilepath);
                   }
                }
                
               }
                break;
                
                

            default:
                break;
        }


        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Document Deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting document'
            ];
        }
        echo json_encode($retData);
    }
    
    
    public function view($id){
        global $aPermitType, $aPTWPermission;
        $userType = getCurrentUserGroupId();

        $sessiondata = getCurrentUserDetails();
        $certificateStatus = postData($sessiondata, 'CERT_STATUS');

        $editData = FALSE;
        $secattachment = FALSE;
        $hazardActivityInfo = FALSE;
        $hazardActivityHirarcInfo = FALSE;
        $hazardActivityCheckListInfo = FALSE;
        $wppInfo = FALSE;
        $ppeCheckListInfo = FALSE;
        if ($id != '') {
            $decryptPtwId = decryptval($id);
            $editData = $this->permit->getPTWDetails(['PTW_ID' => $decryptPtwId], 'row');
            $secattachment = $this->permit->getPTWSecAttachment(['REF_PTW_ID' => $decryptPtwId], 'result');
            
            $permitTypeId = postData($editData,'PERMIT_TYPE');
            $permitType = ($permitTypeId > 0 && isset($aPermitType[$permitTypeId])) ? $aPermitType[$permitTypeId] : 'BOTH';
            
            $hazardActivity = getHazardActivitiesCategory($permitType);
            
            $hazardActivityCheckListInfo = $this->permit->getHzActivityCheckList(['REF_PTW_ID' => $decryptPtwId,'HZ_STATUS'=>'Y'], 'result');

            $hazardActivityOther = $this->permit->getHZActivityOther($decryptPtwId);

            $hazardActivityHirarcInfo = $this->permit->getPTWHzActivityHirarcDetails(['PTW_ID' => $decryptPtwId], 'result');

            $hzActivityInfo = $this->permit->getHzActivityInfo(['REF_PTW_ID' => $decryptPtwId], 'result');
            $wppInfo = $this->permit->getWPPInfo(['REF_PTW_ID' => $decryptPtwId,'WPP_STATUS'=>'Y'], 'result');
            $wppCheckListInfo = $this->permit->getWPPCheckList(['REF_PTW_ID' => $decryptPtwId,'WPP_STATUS'=>'Y'], 'result');

            $ppeCheckListInfo = $this->permit->getPPECheckList(['REF_PTW_ID' => $decryptPtwId,'PPE_STATUS'=>'Y'], 'result');
            $ppeInfo = $this->permit->getPPEInfo(['REF_PTW_ID' => $decryptPtwId,'PPE_STATUS'=>'Y'], 'result');
            $ptwSancFormInfo = $this->permit->getPTWSANCFormAttachment(['REF_PTW_ID' => $decryptPtwId], 'result');
            $ptwSancFormInfo1 = $this->permit->getPTWSANCFormAttachment1(['REF_PTW_ID' => $decryptPtwId], 'result');
        
            
        }
        
        $permitTypeId = postData($editData,'PERMIT_TYPE');
        
        switch ($permitTypeId) {
            case 1:
                $backURL = BASE_URL.'ptw/permit/normalList';
                $permitTypeName = 'Normal PTW';
                break;
            case 2:
                $backURL = BASE_URL.'ptw/permit/criticalList';
                $permitTypeName = 'Critical PTW';
                break;

            default:
                $backURL = BASE_URL.'dashboard';
                break;
        }

        $additionalData = [
            'sectionAttachment' => $secattachment,
             'hazardActivity' => $hazardActivity,
            'hazardActivityOther' => $hazardActivityOther,
            'hazardActivityCheckListInfo' => $hazardActivityCheckListInfo,
            'hazardActivityHirarcInfo' => $hazardActivityHirarcInfo,
            'hzActivityAttachment' => $hzActivityAttachment,
            'hzActivityInfo' => $hzActivityInfo,
            'wppCheckListInfo' => $wppCheckListInfo,
            'wppInfo' => $wppInfo,
            'ppeCheckListInfo' => $ppeCheckListInfo,
            'ppeInfo' => $ppeInfo,
            'ptwSancFormInfo' => $ptwSancFormInfo,
            'ptwSancFormInfo1' => $ptwSancFormInfo1,
        ];
        $viewPermission = (in_array($userType, $aPTWPermission['view'])) ? TRUE : FALSE;
               

        if ( is_admin() || $viewPermission == TRUE ) {
            
            $data = [
                'editId' => $id,
                'backURL' => $backURL,
                'view_file' => 'form/ptw_view',
                'permitTypeName' => $permitTypeName,
                'permitType' => $permitType,
                'current_menu' => 'permit',
                'userDetails' => $sessiondata,
                'editData' => $editData,
                'additionalData' => $additionalData
                
            ];
            $this->template->load_common_template($data);
        } else {
            
            $this->session->set_flashdata('permitflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> You don\'t have permission to access this permit </div>');
            redirect($backURL);
        }
    }
    
    
    public function pdf($id ='') {
       
       global $aPermitType, $aPTWPermission;
        $userType = getCurrentUserGroupId();

        $sessiondata = getCurrentUserDetails();
        $permitType = $this->input->get('type');
        $permitTypeId = array_search($permitType, ($aPermitType));
        $certificateStatus = postData($sessiondata, 'CERT_STATUS');

        
        

        $editData = FALSE;
        $secattachment = FALSE;
        $hazardActivityInfo = FALSE;
        $hazardActivityHirarcInfo = FALSE;
        $hazardActivityCheckListInfo = FALSE;
        $wppInfo = FALSE;
        $ppeCheckListInfo = FALSE;
        if ($id != '') {
            $decryptPtwId = decryptval($id);
            $editData = $this->permit->getPTWDetails(['PTW_ID' => $decryptPtwId], 'row');
            $secattachment = $this->permit->getPTWSecAttachment(['REF_PTW_ID' => $decryptPtwId], 'result');
            $hazardActivityCheckListInfo = $this->permit->getHzActivityCheckList(['REF_PTW_ID' => $decryptPtwId,'HZ_STATUS'=>'Y'], 'result');
            
            
             $permitTypeId = postData($editData,'PERMIT_TYPE');
            $permitType = ($permitTypeId > 0 && isset($aPermitType[$permitTypeId])) ? $aPermitType[$permitTypeId] : 'BOTH';
            
             $hazardActivity = getHazardActivitiesCategory($permitType);

            $hazardActivityOther = $this->permit->getHZActivityOther($decryptPtwId);

            $hazardActivityHirarcInfo = $this->permit->getPTWHzActivityHirarcDetails(['PTW_ID' => $decryptPtwId], 'result');

            $hzActivityInfo = $this->permit->getHzActivityInfo(['REF_PTW_ID' => $decryptPtwId], 'result');
            $wppInfo = $this->permit->getWPPInfo(['REF_PTW_ID' => $decryptPtwId,'WPP_STATUS'=>'Y'], 'result');
            $wppCheckListInfo = $this->permit->getWPPCheckList(['REF_PTW_ID' => $decryptPtwId,'WPP_STATUS'=>'Y'], 'result');

            $ppeCheckListInfo = $this->permit->getPPECheckList(['REF_PTW_ID' => $decryptPtwId,'PPE_STATUS'=>'Y'], 'result');
            $ppeInfo = $this->permit->getPPEInfo(['REF_PTW_ID' => $decryptPtwId,'PPE_STATUS'=>'Y'], 'result');
            $ptwSancFormInfo = $this->permit->getPTWSANCFormAttachment(['REF_PTW_ID' => $decryptPtwId], 'result');
            $ptwSancFormInfo1 = $this->permit->getPTWSANCFormAttachment1(['REF_PTW_ID' => $decryptPtwId], 'result');
        }
        
        $permitTypeId = postData($editData,'PERMIT_TYPE');
        
        switch ($permitTypeId) {
            case 1:
                $backURL = BASE_URL.'ptw/permit/normalList';
                $permitTypeName = 'Normal PTW';
                break;
            case 2:
                $backURL = BASE_URL.'ptw/permit/criticalList';
                $permitTypeName = 'Critical PTW';
                break;

            default:
                $backURL = BASE_URL.'dashboard';
                break;
        }

        $additionalData = [
            'sectionAttachment' => $secattachment,
             'hazardActivity' => $hazardActivity,
            'hazardActivityOther' => $hazardActivityOther,
            'hazardActivityCheckListInfo' => $hazardActivityCheckListInfo,
            'hazardActivityHirarcInfo' => $hazardActivityHirarcInfo,
            'hzActivityAttachment' => $hzActivityAttachment,
            'hzActivityInfo' => $hzActivityInfo,
            'wppCheckListInfo' => $wppCheckListInfo,
            'wppInfo' => $wppInfo,
            'ppeCheckListInfo' => $ppeCheckListInfo,
            'ppeInfo' => $ppeInfo,
            'ptwSancFormInfo' => $ptwSancFormInfo,
            'ptwSancFormInfo1' => $ptwSancFormInfo1
        ];
        
        $data = [
                'editId' => $id,
                'permitType' => $permitType,
                'backURL' => $backURL,
                'userDetails' => $sessiondata,
                'editData' => $editData,
                'additionalData' => $additionalData
                
            ];
         
         $permitNumber = postData($editData, 'LIVE_PERMIT_NO');
        $html2 = $this->load->view('form/ptw_pdf',$data, true);
//        echo $html2;
//        exit;
        $mpdf2 = $this->pdf->ptwload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "PTW";
        $file_path = "assets/uploads/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $permitNumber. '.pdf';
        $name = $permitNumber.'.pdf';
        $mpdf2->Output($path2, "I");
//        $data = file_get_contents($path2);
//        force_download($name, $data);
        
    }

    
    public function generate_excel()
    {
        $userType = getCurrentUserGroupId();
        $userid = getCurrentUserid();

        global $aPermitType;
        $table = PTW_TBL;
         $request = $this->input->get();
        // $permitType = 'NORMAL';
        $permitType = postData($request, 'type');
        echo $permitType;
        exit;
        $permitTypeId = array_search($permitType, ($aPermitType));

       
        // print_r($request);
        // exit;

        $column_order = array('LIVE_PERMIT_NO', 'FN_GET_LOCATION(LOCATION)', 'SPECIFIC_WORKSITE', 'CREATED_ON', 'APPLICANT_NAME', 'FN_PTW_STATUS_NAME(STATUS)', null);

        $aColumnSearch = array('LIVE_PERMIT_NO', 'FN_GET_LOCATION(LOCATION)', 'SPECIFIC_WORKSITE', 'CREATED_ON', 'APPLICANT_NAME', 'FN_PTW_STATUS_NAME(STATUS)');
        $order = array('PTW_ID' => 'DESC');
        $where = [
            'PERMIT_TYPE' => $permitTypeId,
            'PTW_STATUS' => 'Y'
        ];
        $userType = getCurrentUserGroupId();
        if (in_array($userType, [4, 11])) {
            $where['APPLICANT_USER_TYPE_ID'] = $userType;
            $where['CREATED_BY'] = $userid;
        }

        $searchStatus = postData($request, 'searchstatus');
        $startdate = postData($request, 'start_date');
        $enddate = postData($request, 'end_date');

        $year=postData($request, 'year');
        $terminal=postData($request, 'terminal');
        $status=postData($request, 'status');



        if ($searchStatus > 0) {
            $where['STATUS'] = $searchStatus;
        }

        if ($startdate != '') {
            $startdate = date('Y-m-d', strtotime($startdate));
            $where['START_DATE >= '] = $startdate;
        }
        if ($enddate != '') {
            $enddate = date('Y-m-d', strtotime($enddate));
            $where['END_DATE <= '] = $enddate;
        }

        if ($year != '') {
            $where['YEAR(CREATED_ON) ='] = $year;
        }
        if ($terminal != '') {
            $where['LOCATION ='] = $terminal;
        }

        if ($status == 1) {
            $options['where_in'] = ['STATUS' => [1, 2, 4]];
        }

        if ($status != 1 && $status != '') {
            $where['STATUS ='] = $status;
        }



        $options['select'] = array('PTW_ID', 'LIVE_PERMIT_NO', 'FN_GET_LOCATION(LOCATION) as loc_name', 'SPECIFIC_WORKSITE', 'WORK_DESCRIPTION', 'CREATED_ON', 'APPLICANT_NAME', 'END_DATE', 'PERMIT_TYPE', 'FN_PTW_STATUS_NAME(STATUS) as status_Name', 'CREATED_BY', 'STATUS', 'OA1', 'OA2', 'OA1_APPROVAL_STATUS', 'OA1_APPROVAL_EXP_TIME', 'OA2_APPROVAL_STATUS');
        $mlist = $this->common_model->get_datatables($table, $column_order, $aColumnSearch, $order, $where, $options);

        //     $objPHPExcel = new PHPExcel();
        //     $sheet = $objPHPExcel->getActiveSheet();

        //     // Set headers
        //     $sheet->setCellValue('A1', 'Permit No');
        //     $sheet->setCellValue('B1', 'Location');
        //     $sheet->setCellValue('C1', 'Sub Location');
        //     $sheet->setCellValue('D1', 'Work Description');
        //     // $sheet->setCellValue('E1', 'Created On');
        //     $sheet->setCellValue('F1', 'PTW Applicant');
        //     $sheet->setCellValue('G1', 'End Date');

        //     $rowCount = 2;
        //     foreach ($mlist as $data) {
        //         $sheet->setCellValue('A' . $rowCount, $data->LIVE_PERMIT_NO);
        //         $sheet->setCellValue('B' . $rowCount, $data->loc_name);
        //         $sheet->setCellValue('C' . $rowCount, $data->SPECIFIC_WORKSITE);
        //         $sheet->setCellValue('D' . $rowCount, $data->WORK_DESCRIPTION);
        //         // $sheet->setCellValue('E' . $rowCount, date('d-m-Y H:i:s', strtotime($data->CREATED_ON)));
        //         $sheet->setCellValue('F' . $rowCount, $data->APPLICANT_NAME);
        //         $sheet->setCellValue('G' . $rowCount, $data->END_DATE);
        //         $rowCount++;
        //     }

        //   // Download file
        //     $filename = '' . 'NEOEHS - Normal PTW' . '.xls';
        //     header('Content-Type: application/vnd.ms-excel');
        //     header("Content-Disposition: attachment; filename=\"$filename\"");
        //     header('Cache-Control: max-age=0');

        //     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //     $objWriter->save('php://output');
        //     exit;

        $aResultColumns = [];

        foreach ($mlist as $val) {
            $aResultColumn = [];

            $aResultColumn['data']['Permit No']['value'] = $val->LIVE_PERMIT_NO;
            $aResultColumn['data']['Location']['value'] = $val->loc_name;
            $aResultColumn['data']['Sub Location']['value'] = $val->SPECIFIC_WORKSITE;
            $aResultColumn['data']['Work Description']['value'] = $val->WORK_DESCRIPTION;
            // $aResultColumn['data']['Created On']['type'] = 'DateTime';
            // $aResultColumn['data']['Created On']['value'] = date('d-m-Y H:i:s', strtotime($val->CREATED_ON));
            $aResultColumn['data']['PTW Applicant']['value'] = $val->APPLICANT_NAME;
            $aResultColumn['data']['End Date']['type'] = 'Date';
            $aResultColumn['data']['End Date']['value'] = date('d-m-Y', strtotime($val->END_DATE));

            $aResultColumns[] = $aResultColumn;
        }

        $aResultHeading = array_keys($aResultColumns[0]['data']); // Set headings from first record

        $exportData = [
            'export' => $aResultColumns,
            'heading' => $aResultHeading,
        ];

        $res = exportExcel($exportData, 'NEOEHS - Normal PTW');
    }
    
    public function getHirarcInfo(){
        
       $aResponse = [
                'status' => false,
                'msgs' => 'please try again',
                'result' => ''
            ];  
       $currentId = $this->input->post('currentId');
       if($currentId != FALSE && count($currentId) > 0){
        $option['where_in'] = ['MAIN_AUTO_ID'=>$currentId];
        $option['return_type'] = 'result';
        $details = $this->common_model->getAlldata('HIRARC_MAIN_FLOW', ['*'], $option);
        if($details != FALSE && count($details) > 0){
            $tabdata = '';
            $i = 0;
            foreach ($details as $row){
                $refid = postData($row,'HIRARC_ID');
                $id = postData($row,'MAIN_AUTO_ID');
                $action =  " " . anchor(BASE_URL.'hirarc/hirarc/pdf_report/'. encryptval($id), '<i class="fa fa-eye"></i>', array('title' => 'view','target'=>'_new'));
                $i++;
                $tabdata .='<tr class="hirarcReports" id="hirac_'.$id.'">';
                $tabdata .='<td>'.$i.'</td>';
                $tabdata .='<td>'.$refid.'</td>';
                $tabdata .='<td>'.$action.'</td>';
                $tabdata .='</tr>';
            }
            
             $aResponse = [
                'status' => true,
                'msgs' => 'HIRARC Info',
                'result' => $tabdata
            ];
        }
       }else{
           $tabdata = '<tr><td colspan="3" align="Center">No record found</td></tr>';
           $aResponse = [
                'status' => true,
                'msgs' => 'No record found',
                'result' => $tabdata
            ];
       }
        echo json_encode($aResponse);
        exit;
        
    }
  
    public function generateSancFormPdf($id ='') {
        
       global $aPermitType, $aPTWPermission;
        $userType = getCurrentUserGroupId();

        $sessiondata = getCurrentUserDetails();
        $permitType = $this->input->get('type');
        $permitTypeId = array_search($permitType, ($aPermitType));
        $certificateStatus = postData($sessiondata, 'CERT_STATUS');

         $hazardActivity = getHazardActivitiesCategory($permitType);
        

        $editData = FALSE;
        $secattachment = FALSE;
        $hazardActivityInfo = FALSE;
        $hazardActivityHirarcInfo = FALSE;
        $hazardActivityCheckListInfo = FALSE;
        $wppInfo = FALSE;
        $ppeCheckListInfo = FALSE;
        if ($id != '') {
            $decryptPtwId = decryptval($id);
            $editData = $this->permit->getPTWDetails(['PTW_ID' => $decryptPtwId], 'row');
           
           
        }
        $permitNumber = postData($editData, 'LIVE_PERMIT_NO');
        
        $permitTypeId = postData($editData,'PERMIT_TYPE');
        
        switch ($permitTypeId) {
            case 1:
                $backURL = BASE_URL.'ptw/permit/normalList';
                $permitTypeName = 'Normal PTW';
                break;
            case 2:
                $backURL = BASE_URL.'ptw/permit/criticalList';
                $permitTypeName = 'Critical PTW';
                break;

            default:
                $backURL = BASE_URL.'dashboard';
                break;
        }

        
        
        $data = [
                'editId' => $id,
                'backURL' => $backURL,
                'userDetails' => $sessiondata,
                'editData' => $editData,
              
                
            ];
         
         
        $html2 = $this->load->view('form/ptw_sanc_form',$data, true);
//        echo $html2;
//        exit;
        $mpdf2 = $this->pdf->ptwload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "PTW";
        $file_path = "assets/uploads/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $permitNumber.'-sancform.pdf';
        $name = $permitNumber . '-Sanctioning-form.pdf';
        $mpdf2->Output($file_path.$path2, "F");
        $data = file_get_contents($file_path.$path2);
        force_download($name, $data);
        
    }       
}

