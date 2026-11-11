<?php

function getAtarNumber($module,$locName,$locationId){
    
    $ci = & get_instance();
    $ci->db->select('COUNT(ATAR_AUTO_ID) as counts');
    $ci->db->where(['ATAR_LOC_ID'=>$locationId]);
    $result = $ci->db->get(ATAR_FLOW)->row();
    $maxid = $result->counts;
    $maxid = $maxid + 1;
    $returnId = str_pad($maxid, 4, 0, STR_PAD_LEFT);
    $year = date('y');
//echo  $ci->db->last_query();exit;
    return $module.'-'.$locName.'-'. $year.'-'.$returnId;
}
//function getExecutiveUnitHead($return){
//    $ci = & get_instance();
//    $userTypeId= ['4','5','11'];
//    $options['where_in'] = [
//        'LD.USER_TYPE_ID'=> $userTypeId,
//        'EMP.EMP_LOGIN_STATUS'=>'E',
//    ];
//    
//    $options['return_type'] = 'result';
//    $options['join'] = [
//         'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = EMP.EMP_AUTO_ID','INNER']
//    ];
//     $actvity = $ci->common_model->getAlldata('EMPLOYEE_MANAGEMENT AS EMP', ['LD.LOGIN_ID','EMP.EMP_AUTO_ID','EMP.EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
//  
//     if($return == 'drop'){
//         return $dropdownDetails = customFormDropDown($actvity,'LOGIN_ID','EMP_NAME','Select Executive / Unit Head');
//    }else{
//        return $actvity;
//    }
//}

function getExecutiveUnitHead($return){
    $ci = & get_instance();
    $userTypeId= ['4','11'];
    $options['where_in'] = [
        'LD.USER_TYPE_ID'=> $userTypeId,
        'LD.USER_LOG_STATUS' => "Y"

       
    ];
   
    $options['return_type'] = 'result';
    $options['join'] = [
         'EMPLOYEE_MANAGEMENT AS EMP'=>['EMP.EMP_AUTO_ID = LD.USER_REF_ID AND LD.USER_LOGIN_TYP = "0"','LEFT'],
         'CONTRACTOR_DETAILS AS CON'=>['CON.CONT_AUTO_ID = LD.USER_REF_ID AND LD.USER_LOGIN_TYP = "1"','LEFT'],
         'USER_TYPE AS TYP'=>['TYP.USER_TYPE_ID = LD.USER_TYPE_ID','LEFT']
    ];
    $actvity = $ci->common_model->getAlldata('LOGIN_DETAILS AS LD ', ['USER_TYPE_NAME','LD.LOGIN_ID', '(CASE WHEN `LD`.`USER_TYPE_ID` = 11 THEN `CON`.`CONT_NAME` ELSE  `EMP`.`EMP_NAME` END) as EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
  
     if($return == 'drop'){
         //echo $ci->db->last_query();exit;
         $opName = 'Select Executive / Contractor';
         $aResponse = [''=>$opName];
         if($actvity != FALSE && count($actvity) > 0){
             foreach($actvity as $row){
                 $logid = postData($row,'LOGIN_ID');
                 $nameEmp = postData($row,'EMP_NAME');
                 $typeID = postData($row,'USER_TYPE_NAME');
                 $aResponse[$typeID][$logid] = $nameEmp;
             }
         }
         return $aResponse;
         
    }else{
        return $actvity;
    }
}

function getExecutiveUnitHeadAssignedPerson($return){
    $ci = & get_instance();
    $userTypeId= ['4','11'];
    $options['where_in'] = [
        'LD.USER_TYPE_ID'=> $userTypeId,
        'LD.USER_LOG_STATUS' => "Y"

       
    ];
   
    $options['return_type'] = 'result';
    $options['join'] = [
         'EMPLOYEE_MANAGEMENT AS EMP'=>['EMP.EMP_AUTO_ID = LD.USER_REF_ID AND LD.USER_LOGIN_TYP = "0"','LEFT'],
         'CONTRACTOR_DETAILS AS CON'=>['CON.CONT_AUTO_ID = LD.USER_REF_ID AND LD.USER_LOGIN_TYP = "1"','LEFT'],
         'USER_TYPE AS TYP'=>['TYP.USER_TYPE_ID = LD.USER_TYPE_ID','LEFT']
    ];
    $actvity = $ci->common_model->getAlldata('LOGIN_DETAILS AS LD ', ['USER_TYPE_NAME','LD.LOGIN_ID', '(CASE WHEN `LD`.`USER_TYPE_ID` = 11 THEN `CON`.`CONT_NAME` ELSE  `EMP`.`EMP_NAME` END) as EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");

     if($return == 'drop'){
         //echo $ci->db->last_query();exit;
         $opName = 'Select Executive / Contractor';
         $aResponse = [''=>$opName];
         if($actvity != FALSE && count($actvity) > 0){
             foreach($actvity as $row){
                 $logid = postData($row,'LOGIN_ID');
                 $nameEmp = postData($row,'EMP_NAME');
                 $typeID = postData($row,'USER_TYPE_NAME');
                 $aResponse[$typeID][$logid] = $nameEmp;
             }
         }
         return $aResponse;
         
    }else{
        return $actvity;
    }
}

function getAtarUnitHead($return){
     $ci = & get_instance();
    $options['where']=[
        'LD.USER_TYPE_ID'=>5,
        'EMP.EMP_LOGIN_STATUS'=>'E',
'EMP.EMP_STATUS'=>'Y'
    ];
    $options['return_type'] = 'result';
    $options['join'] = [
        'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = EMP.EMP_AUTO_ID','INNER']
    ];
    $actvity = $ci->common_model->getAlldata('EMPLOYEE_MANAGEMENT AS EMP', ['LD.LOGIN_ID','EMP.EMP_AUTO_ID','EMP.EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
  
    if($return == 'drop'){
        return $dropdownDetails = customFormDropDown($actvity,'LOGIN_ID','EMP_NAME','Select Unit Head');
    }else{
        return $actvity;
    }
}


function getLocationShorName($locationId){
    $ci = & get_instance();
    $options['where']=[
        'TER_AUTO_ID'=>$locationId,
        'TERMINAL_STATUS'=>'Y'
    ];
    $options['return_type'] = 'row';
     $details = $ci->common_model->getAlldata('TERMINAL_MANAGEMENT', ['TERMINAL_SHORTNAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");

     return ($details != FALSE) ? $details->TERMINAL_SHORTNAME : 'LOC';
}


function sendAtarNotification($atar_id) {
    // echo $atar_id;
    // exit;
    $ci = &get_instance();
    
    
    $option['where'] = ['ATAR_AUTO_ID' => $atar_id];
    $option['return_type'] = 'row';
    $option['join'] = [
    'LOGIN_DETAILS AS LD'=>['LD.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
    'EMPLOYEE_MANAGEMENT AS Reporter'=>['Reporter.EMP_AUTO_ID = LD.USER_REF_ID','LEFT'],

    'LOGIN_DETAILS AS LD1'=>['LD1.LOGIN_ID = '.ATAR_FLOW.'.ATAR_HSSE_ID','LEFT'],
    'EMPLOYEE_MANAGEMENT AS Hsse'=>['Hsse.EMP_AUTO_ID = LD1.USER_REF_ID','LEFT'],
    
     'LOGIN_DETAILS AS LD5'=>['LD5.LOGIN_ID = '.ATAR_FLOW.'.ATAR_ASSIGN_UNIT_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS Unithead'=>['Unithead.EMP_AUTO_ID = LD5.USER_REF_ID','LEFT'],
        
    'LOGIN_DETAILS AS LD2'=>['LD2.LOGIN_ID = '.ATAR_FLOW.'.ATAR_ASSIGN_HOD_ID','LEFT'],
    'EMPLOYEE_MANAGEMENT AS Hod'=>['Hod.EMP_AUTO_ID = LD2.USER_REF_ID','LEFT'],
        
     'LOGIN_DETAILS AS LD4'=>['LD4.LOGIN_ID = '.ATAR_FLOW.'.ATAR_ASSIGN_HOD_ID','LEFT'],
    'CONTRACTOR_DETAILS AS Hodcon'=>['Hodcon.CONT_AUTO_ID = LD4.USER_REF_ID','LEFT'],
        
        
    'LOGIN_DETAILS AS LD3'=>['LD3.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
    'CONTRACTOR_DETAILS AS Contractor'=>['Contractor.CONT_AUTO_ID = LD3.USER_REF_ID','LEFT'],
   
    ];
    
    $aOption = $option + $option;
    $atardetails = $ci->common_model->getAlldata(ATAR_FLOW, ['*', 'Contractor.CONT_NAME AS contractor_name','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN `Contractor`.`CONT_NAME` ELSE  `Reporter`.`EMP_NAME` END) as Reporter','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'FN_SPECIFIC_LOCATION_NAME(ATAR_SPEC_LOC_ID) as spec_loc_name','Reporter.EMP_NAME as empName','Hsse.EMP_NAME as Hsse','Unithead.EMP_NAME as Unithead','Unithead.EMP_EMAIL_ID as unithead_email','(CASE WHEN `LD4`.`USER_TYPE_ID` = 11 THEN `Hodcon`.`CONT_NAME` ELSE  `Hod`.`EMP_NAME` END) as Hod','(CASE WHEN `LD4`.`USER_TYPE_ID` = 11 THEN `Hodcon`.`CONT_EMAIL_ID` ELSE  `Hod`.`EMP_EMAIL_ID` END) as hod_email','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN Contractor.CONT_DESIGNATION ELSE  FN_GET_DESIGNATION_NAME(ATAR_REPORTER_DESG_ID) END) as desig','FN_ATAR_USEE_CATEGORY_NAME(ATAR_USEE_CAT_ID) as usee','FN_ATAR_UACT_CATEGORY_NAME(ATAR_UACT_CAT_ID) as uact','FN_ATAR_MAIN_CATEGORY_NAME(ATAR_MAIN_CAT_ID) as mainCat'], $aOption);
// echo "<pre>";
// echo $ci->db->last_query();
//    print_r($atardetails);exit;
    if ($atardetails != FALSE) {
        $ATAR_ID = postData($atardetails, 'ATAR_ID');
        $Reporter = postData($atardetails, 'Reporter');
        $loc_name = postData($atardetails, 'loc_name');
        $ATAR_REPORT_DATETIME = date('d-m-Y H:i:s', strtotime(postData($atardetails, 'ATAR_REPORT_DATETIME')));
        
        $usee = postData($atardetails, 'usee');
        $uact = postData($atardetails, 'uact');
        $ATAR_USEE_WHAT_RECCOM = postData($atardetails, 'ATAR_USEE_WHAT_RECCOM');
        $ATAR_UACT_WHAT = postData($atardetails, 'ATAR_UACT_WHAT');
        $ATAR_APP_STATUS = postData($atardetails, 'ATAR_APP_STATUS');
        $ATAR_TYPE_ID = postData($atardetails, 'ATAR_TYPE_ID');
        $ATAR_INC_DESC_FINDING = postData($atardetails, 'ATAR_INC_DESC_FINDING');
        $ATAR_ASSIGN_HOD_ID = postData($atardetails, 'ATAR_ASSIGN_HOD_ID');
        $ATAR_ASSIGN_UNIT_ID = postData($atardetails, 'ATAR_ASSIGN_UNIT_ID');
        $ATAR_SPEC_LOC_OTHER = postData($atardetails, 'ATAR_SPEC_LOC_OTHER');
        $spec_loc_names = postData($atardetails, 'spec_loc_name');
        
        if($ATAR_SPEC_LOC_OTHER != ""){
            $spec_loc_name = $ATAR_SPEC_LOC_OTHER;
        }else{
            $spec_loc_name = $spec_loc_names;
        }
        
        $hod_email = postData($atardetails, 'hod_email');
        $unithead_email = postData($atardetails, 'unithead_email');
        $ATAR_ASSIGN_HOD_DATE = postData($atardetails, 'ATAR_ASSIGN_HOD_DATE');
        $ATAR_ASSIGN_HOD_DESC = postData($atardetails, 'ATAR_ASSIGN_HOD_DESC');
        $ATAR_ASSIGN_HSSE_DESC = postData($atardetails, 'ATAR_ASSIGN_HSSE_DESC');
        $ATAR_REJECT_HSSE_DESC = postData($atardetails, 'ATAR_REJECT_HSSE_DESC');
        
        $ATAR_HSSE_DATE = date('d-m-Y', strtotime(postData($atardetails, 'ATAR_HSSE_DATE')));
       
       
        
        $userTypeId= ['6','7'];
        $aemail_id = getAtarEmailDetails($userTypeId);
        if($aemail_id != FALSE){
            $notify_email_id = $aemail_id->emailList;
            $notify_id = $aemail_id->notifyidList;
        }
        //print_r($a) ;exit;
        
        $email_address = [$unithead_email,$hod_email];
        $notify_hod_ids = [$ATAR_ASSIGN_UNIT_ID,$ATAR_ASSIGN_HOD_ID];
        $notify_hod_id = (count($notify_hod_ids) >0 ) ? implode(',', $notify_hod_ids) : "";
        $notify_hod_email_id = (count($email_address) >0 ) ? implode(',', $email_address) : "";
     // print_r($notify_hod_id);
     // print_r($notify_hod_email_id);
     // exit;
 
    }

    $encAtar = encryptval($atar_id);
    $notifyUrl = '';
    $employeeEmail = FALSE;
    $ptwFooterMailContent = '<br/>This is system generated E-mail, do not reply to this email.<br/>';
    // echo $ATAR_APP_STATUS ;
    // exit;
    switch ($ATAR_APP_STATUS) {
        case '1':
            /* Pending */
            if($ATAR_TYPE_ID == 1){
                $notifyMessage = 'New U-See U-Act has been created, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>U-See : </b> ' . $usee . ' <br/><b>What did he see : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>U-Act : </b> ' . $uact . ' <br/><b>What did he act : </b> ' . $ATAR_UACT_WHAT . ' <br/>';
                $notifyUrl = 'atar/usee/view/' . $encAtar;
                $subject = 'New U-See U-Act - ID - ' . $ATAR_ID . ' has been created';
            }elseif($ATAR_TYPE_ID == 2){
                $notifyMessage = 'New HSSE Daily Observation has been created, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/>';
                $notifyUrl = 'atar/daily/view/' . $encAtar;
                $subject = 'New HSSE Daily Observation - ID - ' . $ATAR_ID . ' has been created';
            }elseif($ATAR_TYPE_ID == 3){
                $notifyMessage = 'New HSSE Monthly Inspection has been created, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/>';
                $notifyUrl = 'atar/monthly/view/' . $encAtar;
                $subject = 'New HSSE Monthly Inspection - ID - ' . $ATAR_ID . ' has been created';
            }elseif($ATAR_TYPE_ID == 4){
                $notifyMessage = 'New Incident Management has been created, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/>';
                $notifyUrl = 'atar/incident/view/' . $encAtar;
                $subject = 'New Incident Management - ID - ' . $ATAR_ID . ' has been created';
              
            }
            $employeeEmail = TRUE;
            $notfiy_id = $notify_id;
            $emailId =  $notify_email_id;
            // echo "<pre>";
            // print_r($emailId);
            // exit;
            break;
       
        case '4':
            /* accept */
             if($ATAR_TYPE_ID == 1){
                $notifyMessage = 'HSSE has been assigned activity for the action, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>U-See : </b> ' . $usee . ' <br/><b>What did he see : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>U-Act : </b> ' . $uact . ' <br/><b>What did he act : </b> ' . $ATAR_UACT_WHAT . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/>';
                $notifyUrl = 'atar/usee/view/' . $encAtar;
                $subject = 'U-See U-Act - ID - ' . $ATAR_ID . ' has been assigned';
            }elseif($ATAR_TYPE_ID == 2){
                $notifyMessage = 'HSSE has been assigned activity for the action, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/>';
                $notifyUrl = 'atar/daily/view/' . $encAtar;
                $subject = 'HSSE Daily Observation - ID - ' . $ATAR_ID . ' has been assigned';
            }elseif($ATAR_TYPE_ID == 3){
                $notifyMessage = 'HSSE has been assigned activity for the action, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/>';
                $notifyUrl = 'atar/monthly/view/' . $encAtar;
                $subject = 'HSSE Monthly Inspection - ID - ' . $ATAR_ID . ' has been assigned';
            }elseif($ATAR_TYPE_ID == 4){
                $notifyMessage = 'HSSE has been assigned activity for the action, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/>';
                $notifyUrl = 'atar/incident/view/' . $encAtar;
                $subject = 'Incident Management - ID - ' . $ATAR_ID . ' has been assigned';
            }
            

         
            $employeeEmail = TRUE;
            $notfiy_id = $notify_hod_id;
            $emailId = $notify_hod_email_id;
            break;
        case '5':
            /* waiting for approval */
             if($ATAR_TYPE_ID == 1){
                $notifyMessage = 'HSSE has been waiting to approve, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>U-See : </b> ' . $usee . ' <br/><b>What did he see : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>U-Act : </b> ' . $uact . ' <br/><b>What did he act : </b> ' . $ATAR_UACT_WHAT . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/><b>Description entered by HOD : </b> ' . $ATAR_ASSIGN_HOD_DESC . ' <br/>';
                $notifyUrl = 'atar/usee/view/' . $encAtar;
                $subject = 'U-See U-Act - ID - ' . $ATAR_ID . ' has been waiting for approval';
            }elseif($ATAR_TYPE_ID == 2){
                $notifyMessage = 'HSSE has been waiting to approve, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/><b>Description entered by HOD : </b> ' . $ATAR_ASSIGN_HOD_DESC . ' <br/>';
                $notifyUrl = 'atar/daily/view/' . $encAtar;
                $subject = 'HSSE Daily Observation - ID - ' . $ATAR_ID . ' has been waiting for approval';
            }elseif($ATAR_TYPE_ID == 3){
                $notifyMessage = 'HSSE has been waiting to approve, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/><b>Description entered by HOD : </b> ' . $ATAR_ASSIGN_HOD_DESC . ' <br/>';
                $notifyUrl = 'atar/monthly/view/' . $encAtar;
                $subject = 'HSSE Monthly Inspection - ID - ' . $ATAR_ID . ' has been waiting for approval';
            }elseif($ATAR_TYPE_ID == 4){
                $notifyMessage = 'HSSE has been waiting to approve, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/><b>Description entered by HOD : </b> ' . $ATAR_ASSIGN_HOD_DESC . ' <br/>';
                $notifyUrl = 'atar/incident/view/' . $encAtar;
                $subject = 'Incident Management - ID - ' . $ATAR_ID . ' has been waiting for approval';
            }
            
            $employeeEmail = TRUE;
             $notfiy_id = $notify_id;
            $emailId = $notify_email_id;
            break;
        case '7':
            /* rejected */
            if($ATAR_TYPE_ID == 1){
                $notifyMessage = 'HSSE has been "Rejected" the action item :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>U-See : </b> ' . $usee . ' <br/><b>What did he see : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>U-Act : </b> ' . $uact . ' <br/><b>What did he act : </b> ' . $ATAR_UACT_WHAT . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/><b>Description entered by HOD : </b> ' . $ATAR_ASSIGN_HOD_DESC . ' <br/><b>Description entered by HSSE : </b> ' .$ATAR_REJECT_HSSE_DESC . ' <br/>';
                $notifyUrl = 'atar/usee/view/' . $encAtar;
                $subject = 'U-See U-Act - ID - ' . $ATAR_ID . ' has been rejected';
            }elseif($ATAR_TYPE_ID == 2){
                $notifyMessage = 'HSSE has been "Rejected" the action item :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/><b>Description entered by HOD : </b> ' . $ATAR_ASSIGN_HOD_DESC . ' <br/><b>Description entered by HSSE : </b> ' .$ATAR_REJECT_HSSE_DESC . ' <br/>';
                $notifyUrl = 'atar/daily/view/' . $encAtar;
                $subject = 'HSSE Daily Observation - ID - ' . $ATAR_ID . ' has been rejected';
            }elseif($ATAR_TYPE_ID == 3){
                $notifyMessage = 'HSSE has been "Rejected" the action item :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/><b>Description entered by HOD : </b> ' . $ATAR_ASSIGN_HOD_DESC . ' <br/><b>Description entered by HSSE : </b> ' .$ATAR_REJECT_HSSE_DESC . ' <br/>';
                $notifyUrl = 'atar/monthly/view/' . $encAtar;
                $subject = 'HSSE Monthly Inspection - ID - ' . $ATAR_ID . ' has been rejected';
            }elseif($ATAR_TYPE_ID == 4){
                $notifyMessage = 'HSSE has been "Rejected" the action item :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/><b>Description entered by HOD : </b> ' . $ATAR_ASSIGN_HOD_DESC . ' <br/><b>Description entered by HSSE : </b> ' .$ATAR_REJECT_HSSE_DESC . ' <br/>';
                $notifyUrl = 'atar/incident/view/' . $encAtar;
                $subject = 'Incident Management - ID - ' . $ATAR_ID . ' has been rejected';
            }
            $employeeEmail = TRUE;
            $notfiy_id = $notify_hod_id;
            $emailId = $notify_hod_email_id;
            break;
        case '3':
            /* approved */
            if($ATAR_TYPE_ID == 1){
                $notifyMessage = 'HSSE has been "Approved" the action item and "Closed" the U-See U-Act, details are as follows:<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>U-See : </b> ' . $usee . ' <br/><b>What did he see : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>U-Act : </b> ' . $uact . ' <br/><b>What did he act : </b> ' . $ATAR_UACT_WHAT . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/><b>Description entered by HOD : </b> ' . $ATAR_ASSIGN_HOD_DESC . ' <br/><b>Description entered by HSSE : </b> ' .$ATAR_ASSIGN_HSSE_DESC . ' <br/>';
                $notifyUrl = 'atar/usee/view/' . $encAtar;
                $subject = 'U-See U-Act - ID - ' . $ATAR_ID . ' has been approved and closed';
            }elseif($ATAR_TYPE_ID == 2){
                $notifyMessage = 'HSSE has been "Approved" the action item and "Closed" the HSSE Daily Observation, details are as follows:<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/><b>Description entered by HOD : </b> ' . $ATAR_ASSIGN_HOD_DESC . ' <br/><b>Description entered by HSSE : </b> ' .$ATAR_ASSIGN_HSSE_DESC . ' <br/>';
                $notifyUrl = 'atar/daily/view/' . $encAtar;
                $subject = 'HSSE Daily Observation - ID - ' . $ATAR_ID . ' has been approved and closed';
            }elseif($ATAR_TYPE_ID == 3){
                $notifyMessage = 'HSSE has been "Approved" the action item and "Closed" the HSSE Monthly Inspection, details are as follows:<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/><b>Description entered by HOD : </b> ' . $ATAR_ASSIGN_HOD_DESC . ' <br/><b>Description entered by HSSE : </b> ' .$ATAR_ASSIGN_HSSE_DESC . ' <br/>';
                $notifyUrl = 'atar/monthly/view/' . $encAtar;
                $subject = 'HSSE Monthly Inspection - ID - ' . $ATAR_ID . ' has been approved and closed';
            }elseif($ATAR_TYPE_ID == 4){
                $notifyMessage = 'HSSE has been "Approved" the action item and "Closed" the Incident Management, details are as follows:<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>Targeted Date to complete action : </b> ' . $ATAR_HSSE_DATE . ' <br/><b>Description entered by HOD : </b> ' . $ATAR_ASSIGN_HOD_DESC . ' <br/><b>Description entered by HSSE : </b> ' .$ATAR_ASSIGN_HSSE_DESC . ' <br/>';
                $notifyUrl = 'atar/incident/view/' . $encAtar;
                $subject = 'Incident Management - ID - ' . $ATAR_ID . ' has been approved and closed';
            }
            $employeeEmail = TRUE;
            $notfiy_id = $notify_hod_id;
            $emailId = $notify_hod_email_id;
            break;
       
                
        
       
    }

    $notifydata = [
        'text' => $notifyMessage,
        'url' => $notifyUrl,
        'type' => 1,
        'notifygroup' => '',
        'employee' => $notfiy_id,
        'mobilelink' => '',
    ];
    insertNotifications($notifydata);

    /* Email Template Details */

    
    $emailMessage = $notifyMessage . $ptwFooterMailContent;
// print_r($notifydata);
// print_r($emailMessage);exit;

    if ($employeeEmail) {
        $emailData = [

         //   'email' => $notify_email_id,
          'email' => $emailId,
            'subject' => $subject,
            'message' => $emailMessage,
        ];
       sendNotificationEmail($emailData);
    }
    return TRUE;
}

function sendAtarNotificationClose($atar_id) {
    $ci = &get_instance();
    
    
    $option['where'] = ['ATAR_AUTO_ID' => $atar_id];
    $option['return_type'] = 'row';
    $option['join'] = [
    'LOGIN_DETAILS AS LD'=>['LD.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
    'EMPLOYEE_MANAGEMENT AS Reporter'=>['Reporter.EMP_AUTO_ID = LD.USER_REF_ID','LEFT'],

    'LOGIN_DETAILS AS LD1'=>['LD1.LOGIN_ID = '.ATAR_FLOW.'.ATAR_HSSE_ID','LEFT'],
    'EMPLOYEE_MANAGEMENT AS Hsse'=>['Hsse.EMP_AUTO_ID = LD1.USER_REF_ID','LEFT'],
    
     'LOGIN_DETAILS AS LD5'=>['LD5.LOGIN_ID = '.ATAR_FLOW.'.ATAR_ASSIGN_UNIT_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS Unithead'=>['Unithead.EMP_AUTO_ID = LD5.USER_REF_ID','LEFT'],
        
    'LOGIN_DETAILS AS LD2'=>['LD2.LOGIN_ID = '.ATAR_FLOW.'.ATAR_ASSIGN_HOD_ID','LEFT'],
    'EMPLOYEE_MANAGEMENT AS Hod'=>['Hod.EMP_AUTO_ID = LD2.USER_REF_ID','LEFT'],
        
     'LOGIN_DETAILS AS LD4'=>['LD4.LOGIN_ID = '.ATAR_FLOW.'.ATAR_ASSIGN_HOD_ID','LEFT'],
    'CONTRACTOR_DETAILS AS Hodcon'=>['Hodcon.CONT_AUTO_ID = LD4.USER_REF_ID','LEFT'],
        
        
    'LOGIN_DETAILS AS LD3'=>['LD3.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
    'CONTRACTOR_DETAILS AS Contractor'=>['Contractor.CONT_AUTO_ID = LD3.USER_REF_ID','LEFT'],
   
    ];
    
    $aOption = $option + $option;
    $atardetails = $ci->common_model->getAlldata(ATAR_FLOW, ['*', 'Contractor.CONT_NAME AS contractor_name','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN `Contractor`.`CONT_NAME` ELSE  `Reporter`.`EMP_NAME` END) as Reporter','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'FN_SPECIFIC_LOCATION_NAME(ATAR_SPEC_LOC_ID) as spec_loc_name','Reporter.EMP_NAME as empName','Hsse.EMP_NAME as Hsse','Unithead.EMP_NAME as Unithead','Unithead.EMP_EMAIL_ID as unithead_email','(CASE WHEN `LD4`.`USER_TYPE_ID` = 11 THEN `Hodcon`.`CONT_NAME` ELSE  `Hod`.`EMP_NAME` END) as Hod','(CASE WHEN `LD4`.`USER_TYPE_ID` = 11 THEN `Hodcon`.`CONT_EMAIL_ID` ELSE  `Hod`.`EMP_EMAIL_ID` END) as hod_email','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN Contractor.CONT_DESIGNATION ELSE  FN_GET_DESIGNATION_NAME(ATAR_REPORTER_DESG_ID) END) as desig','FN_ATAR_USEE_CATEGORY_NAME(ATAR_USEE_CAT_ID) as usee','FN_ATAR_UACT_CATEGORY_NAME(ATAR_UACT_CAT_ID) as uact','FN_ATAR_MAIN_CATEGORY_NAME(ATAR_MAIN_CAT_ID) as mainCat'], $aOption);
// echo "<pre>";
  //  print_r($atardetails);exit;
    if ($atardetails != FALSE) {
        $ATAR_ID = postData($atardetails, 'ATAR_ID');
        $Reporter = postData($atardetails, 'Reporter');
        $loc_name = postData($atardetails, 'loc_name');
        $ATAR_REPORT_DATETIME = date('d-m-Y H:i:s', strtotime(postData($atardetails, 'ATAR_REPORT_DATETIME')));
        
        $usee = postData($atardetails, 'usee');
        $uact = postData($atardetails, 'uact');
        $ATAR_USEE_WHAT_RECCOM = postData($atardetails, 'ATAR_USEE_WHAT_RECCOM');
        $ATAR_UACT_WHAT = postData($atardetails, 'ATAR_UACT_WHAT');
        $ATAR_APP_STATUS = postData($atardetails, 'ATAR_APP_STATUS');
        $ATAR_TYPE_ID = postData($atardetails, 'ATAR_TYPE_ID');
        $ATAR_INC_DESC_FINDING = postData($atardetails, 'ATAR_INC_DESC_FINDING');
        $ATAR_ASSIGN_HOD_ID = postData($atardetails, 'ATAR_ASSIGN_HOD_ID');
        $ATAR_ASSIGN_UNIT_ID = postData($atardetails, 'ATAR_ASSIGN_UNIT_ID');
        $ATAR_SPEC_LOC_OTHER = postData($atardetails, 'ATAR_SPEC_LOC_OTHER');
        $spec_loc_names = postData($atardetails, 'spec_loc_name');
        
        if($ATAR_SPEC_LOC_OTHER != ""){
            $spec_loc_name = $ATAR_SPEC_LOC_OTHER;
        }else{
            $spec_loc_name = $spec_loc_names;
        }
        
        $hod_email = postData($atardetails, 'hod_email');
        $unithead_email = postData($atardetails, 'unithead_email');
        $ATAR_ASSIGN_HOD_DATE = postData($atardetails, 'ATAR_ASSIGN_HOD_DATE');
        $ATAR_ASSIGN_HOD_DESC = postData($atardetails, 'ATAR_ASSIGN_HOD_DESC');
        $ATAR_ASSIGN_HSSE_DESC = postData($atardetails, 'ATAR_ASSIGN_HSSE_DESC');
        $ATAR_REJECT_HSSE_DESC = postData($atardetails, 'ATAR_REJECT_HSSE_DESC');
        
        $ATAR_HSSE_DATE = date('d-m-Y', strtotime(postData($atardetails, 'ATAR_HSSE_DATE')));
       
       
        
        $userTypeId= ['6','7'];
        $aemail_id = getAtarEmailDetails($userTypeId);
        if($aemail_id != FALSE){
            $notify_email_id = $aemail_id->emailList;
            $notify_id = $aemail_id->notifyidList;
        }
        //print_r($a) ;exit;
        
        $email_address = [$unithead_email,$hod_email];
        $notify_hod_ids = [$ATAR_ASSIGN_UNIT_ID,$ATAR_ASSIGN_HOD_ID];
        $notify_hod_id = (count($notify_hod_ids) >0 ) ? implode(',', $notify_hod_ids) : "";
        $notify_hod_email_id = (count($email_address) >0 ) ? implode(',', $email_address) : "";
     // print_r($notify_hod_id);
     // print_r($notify_hod_email_id);
     // exit;
 
    }

    $encAtar = encryptval($atar_id);
    $notifyUrl = '';
    $employeeEmail = FALSE;
    $ptwFooterMailContent = '<br/>This is system generated E-mail, do not reply to this email.<br/>';
    switch ($ATAR_APP_STATUS) {
            case '3':
            /* just close */
            if($ATAR_TYPE_ID == 1){
                $notifyMessage = 'HSSE has been "Closed" the U-See U-Act, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>U-See : </b> ' . $usee . ' <br/><b>What did he see : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/><b>U-Act : </b> ' . $uact . ' <br/><b>What did he act : </b> ' . $ATAR_UACT_WHAT . ' <br/>';
                $notifyUrl = 'atar/usee/view/' . $encAtar;
                $subject = 'U-See U-Act - ID - ' . $ATAR_ID . ' has been closed';
            }elseif($ATAR_TYPE_ID == 2){
                $notifyMessage = 'HSSE has been "Closed" the HSSE Daily Observation, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/>';
                $notifyUrl = 'atar/daily/view/' . $encAtar;
                $subject = 'HSSE Daily Observation - ID - ' . $ATAR_ID . ' has been closed';
            }elseif($ATAR_TYPE_ID == 3){
                $notifyMessage = 'HSSE has been "Closed" the HSSE Monthly Inspection, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/>';
                $notifyUrl = 'atar/monthly/view/' . $encAtar;
                $subject = 'HSSE Monthly Inspection - ID - ' . $ATAR_ID . ' has been closed';
            }elseif($ATAR_TYPE_ID == 4){
                $notifyMessage = 'HSSE has been "Closed" the Incident Management, details are as follows :<br/><br/><b>ATAR ID : </b> ' . $ATAR_ID . '<br/> <b>Reporter Name : </b> ' . $Reporter . ' <br/><b>Location : </b> ' . $loc_name . ' <br/><b>Specific Location : </b> ' . $spec_loc_name . '<br/><b>Date & Time : </b> ' . $ATAR_REPORT_DATETIME . ' <br/><b>Finding/ Observation : </b> ' . $ATAR_INC_DESC_FINDING . ' <br/><b>Recommendations : </b> ' . $ATAR_USEE_WHAT_RECCOM . ' <br/>';
                $notifyUrl = 'atar/incident/view/' . $encAtar;
                $subject = 'Incident Management - ID - ' . $ATAR_ID . ' has been closed';
                // $emailIds = "hidayat@lumutport.com,rusly@lumutport.com,izudin@lumutport.com,mahesan@lumutport.com,mohdadrin@lumutport.com,asrul@lumutport.com,rafidah@lumutport.com,ganesan.k@lumutport.com,lwtan@lumutport.com,huda@lumutport.com,musalizam@lumutport.com,sulaiman@lumutport.com,taufik@lumutport.com,sudersh@lumutport.com,umesh@lumutport.com";
            }
            
            $employeeEmail = TRUE;
            $notfiy_id = $notify_id;
            // $emailId = $notify_email_id;
             $emailId =  $notify_email_id;
            break;   
 
       
    }

    $notifydata = [
        'text' => $notifyMessage,
        'url' => $notifyUrl,
        'type' => 1,
        'notifygroup' => '',
        'employee' => $notfiy_id,
        'mobilelink' => '',
    ];
    insertNotifications($notifydata);

    /* Email Template Details */

    
    $emailMessage = $notifyMessage . $ptwFooterMailContent;

    $combinedEmails = array_merge(
        explode(',', $notify_email_id),
        explode(',', $emailId)
    );

    $combinedEmails = array_unique(array_map('trim', $combinedEmails));

// Join back to a single comma-separated string
    $finalEmails = implode(',', $combinedEmails);




    if ($employeeEmail) {
        $emailData = [
          //  'email' => $notify_email_id,
           // 'email' => $emailId,
            'email' => $finalEmails,
            'subject' => $subject,
            'message' => $emailMessage,
        ];
       sendNotificationEmail($emailData);
    }
    return TRUE;
}

function sendNotificationEmail($data = []) {
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


function getAtarEmailDetails($ids,$type='USERTYPE'){
    $ci = &get_instance();
    $options['join'] = [
        'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = EMP.EMP_AUTO_ID' ,'INNER']
        
    ];
    $options['return_type'] = 'row';
   
    if($type == 'USERTYPE'){
         $options['where_in'] = ['USER_TYPE_ID'=> $ids];
         $options['group_by'] = [
            'DESC'=>'LD.USER_TYPE_ID'
         ];
    }else{
       $options['where_in'] = ['LOGIN_ID'=> $ids];
    }
     $details = $ci->common_model->getAlldata('EMPLOYEE_MANAGEMENT as EMP', ['GROUP_CONCAT( DISTINCT EMP_EMAIL_ID) as emailList','GROUP_CONCAT( DISTINCT LOGIN_ID) as notifyidList'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
    // echo $ci->db->last_query();
    // exit;
     return $details;
}



