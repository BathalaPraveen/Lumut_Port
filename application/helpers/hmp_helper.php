<?php

function sendHmpNotification($hmp_id) {
    $ci = &get_instance();
    
    
    $option['where'] = ['HMP_AUTO_ID' => $hmp_id];
    $option['return_type'] = 'row';
    $option['join'] = [
    'LOGIN_DETAILS AS LD'=>['LD.LOGIN_ID = '.HMP_MAIN.'.HMP_UNIT_HEAD_ID','LEFT'],
    'EMPLOYEE_MANAGEMENT AS EMP'=>['EMP.EMP_AUTO_ID = LD.USER_REF_ID','LEFT'],
    'LOGIN_DETAILS AS LD1'=>['LD1.LOGIN_ID = '.HMP_MAIN.'.HMP_EXEC_ID','LEFT'],
    'EMPLOYEE_MANAGEMENT AS EMP1'=>['EMP1.EMP_AUTO_ID = LD1.USER_REF_ID','LEFT'],

    ];
    $aOption = $option + $option;
    $hmpdetails = $ci->common_model->getAlldata(HMP_MAIN, ['*', 'FN_GET_LOCATION(HMP_LOC_ID) as loc_name', 'FN_GET_DEPARTMENT_NAME(HMP_DEPT_ID) as dept_name','EMP.EMP_NAME as unithead','EMP.EMP_EMAIL_ID as unithead_email','LD.LOGIN_ID as unithead_id','LD1.LOGIN_ID as exec_id','EMP1.EMP_NAME as executive'], $aOption);
// echo "<pre>";
//    print_r($hmpdetails);exit;
    if ($hmpdetails != FALSE) {
        $HMP_ID = postData($hmpdetails, 'HMP_ID');
        $HMP_NAME = postData($hmpdetails, 'HMP_NAME');
        $HMP_DESC = postData($hmpdetails, 'HMP_DESC');
        $HMP_APP_START_DATE = date('d-m-Y', strtotime(postData($hmpdetails, 'HMP_APP_START_DATE')));
        $HMP_APP_END_DATE = date('d-m-Y', strtotime(postData($hmpdetails, 'HMP_APP_END_DATE')));
        $executive = postData($hmpdetails, 'executive');
        $unithead = postData($hmpdetails, 'unithead');
        $HMP_APP_STATUS = postData($hmpdetails, 'HMP_APP_STATUS');
        $loc_name = postData($hmpdetails, 'loc_name');
        
        if($HMP_APP_STATUS == 1){
            $HMP_APP_STATUS_RES = 'Pending';
        } elseif($HMP_APP_STATUS == 2){
            $HMP_APP_STATUS_RES = 'Completed';
        } elseif($HMP_APP_STATUS == 3){
            $HMP_APP_STATUS_RES = 'Overdue';
        } elseif($HMP_APP_STATUS == 4){
            $HMP_APP_STATUS_RES = 'Postpone';
        }
        $unithead_email = postData($hmpdetails, 'unithead_email');
        $EMP_EMAIL_ID = postData($hmpdetails, 'EMP_EMAIL_ID');
        
        $email_address = [$unithead_email,$EMP_EMAIL_ID];
        
        $unithead_id = postData($hmpdetails, 'unithead_id');
        $EMP_AUTO_ID = postData($hmpdetails, 'exec_id');
        
        $notify_ids = [$EMP_AUTO_ID,$unithead_id];
        $notify_id = (count($notify_ids) >0 ) ? implode(',', $notify_ids) : "";
        $notify_email_id = (count($email_address) >0 ) ? implode(',', $email_address) : "";
      

    }

    $encHmp = encryptval($hmp_id);
    $notifyUrl = '';
    $employeeEmail = FALSE;
    $ptwFooterMailContent = '<br/>This is system generated E-mail, do not reply to this email.<br/>';
    switch ($HMP_APP_STATUS) {
        case '1':
            /* Pending */
            $notifyMessage = 'New program has been created by HSSE department with following detials :<br/><br/><b>HSSE Program ID : </b> ' . $HMP_ID . '<br/> <b>HSSE Program Description : </b> ' . $HMP_DESC . ' <br/><b>Program Start Date : </b> ' . $HMP_APP_START_DATE . ' <br/><b>Program End Date : </b> ' . $HMP_APP_END_DATE . '<br/><b>Location : </b> ' . $loc_name . ' <br/><b>Head of Department/Manager/Asst. Manager : </b> ' . $unithead . ' <br/><b>Engineer/Executive/Supervisor : </b> ' . $executive . ' <br/><b>Status : </b> ' . $HMP_APP_STATUS_RES . ' <br/>';
            $notifyUrl = 'hmp/hmp/view_report/' . $encHmp;
            $subject = 'New Program - ID - ' . $HMP_ID . ' has been created';
            $employeeEmail = TRUE;
            $notfiy_id = $notify_id;
            $emailId = $notify_email_id;
            break;
         case '2':
            /* Pending */
            $notifyMessage = 'New program has been created by HSSE department with following detials :<br/><br/><b>HSSE Program ID : </b> ' . $HMP_ID . '<br/> <b>HSSE Program Description : </b> ' . $HMP_DESC . ' <br/><b>Program Start Date : </b> ' . $HMP_APP_START_DATE . ' <br/><b>Program End Date : </b> ' . $HMP_APP_END_DATE . '<br/><b>Location : </b> ' . $loc_name . ' <br/><b>Head of Department/Manager/Asst. Manager : </b> ' . $unithead . ' <br/><b>Engineer/Executive/Supervisor : </b> ' . $executive . ' <br/><b>Status : </b> ' . $HMP_APP_STATUS_RES . ' <br/>';
            $notifyUrl = 'hmp/hmp/view_report/' . $encHmp;
            $subject = 'New Program - ID - ' . $HMP_ID . ' has been created';
            $employeeEmail = TRUE;
            $notfiy_id = $notify_id;
            $emailId = $notify_email_id;
            break;
         case '3':
            /* Pending */
            $notifyMessage = 'New program has been created by HSSE department with following detials :<br/><br/><b>HSSE Program ID : </b> ' . $HMP_ID . '<br/> <b>HSSE Program Description : </b> ' . $HMP_DESC . ' <br/><b>Program Start Date : </b> ' . $HMP_APP_START_DATE . ' <br/><b>Program End Date : </b> ' . $HMP_APP_END_DATE . '<br/><b>Location : </b> ' . $loc_name . ' <br/><b>Head of Department/Manager/Asst. Manager : </b> ' . $unithead . ' <br/><b>Engineer/Executive/Supervisor : </b> ' . $executive . ' <br/><b>Status : </b> ' . $HMP_APP_STATUS_RES . ' <br/>';
            $notifyUrl = 'hmp/hmp/view_report/' . $encHmp;
            $subject = 'New Program - ID - ' . $HMP_ID . ' has been created';
            $employeeEmail = TRUE;
            $notfiy_id = $notify_id;
            $emailId = $notify_email_id;
            break;
         case '4':
            /* Pending */
            $notifyMessage = 'New program has been created by HSSE department with following detials :<br/><br/><b>HSSE Program ID : </b> ' . $HMP_ID . '<br/> <b>HSSE Program Description : </b> ' . $HMP_DESC . ' <br/><b>Program Start Date : </b> ' . $HMP_APP_START_DATE . ' <br/><b>Program End Date : </b> ' . $HMP_APP_END_DATE . '<br/><b>Location : </b> ' . $loc_name . ' <br/><b>Head of Department/Manager/Asst. Manager : </b> ' . $unithead . ' <br/><b>Engineer/Executive/Supervisor : </b> ' . $executive . ' <br/><b>Status : </b> ' . $HMP_APP_STATUS_RES . ' <br/>';
            $notifyUrl = 'hmp/hmp/view_report/' . $encHmp;
            $subject = 'New Program - ID - ' . $HMP_ID . ' has been created';
            $employeeEmail = TRUE;
            $notfiy_id = $notify_id;
            $emailId = $notify_email_id;
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


    if ($employeeEmail) {
        $emailData = [
            'email' => $notify_email_id,
//            'email' => $emailId,
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


function getHmpNumber(){
    $ci = & get_instance();
    $ci->db->select('COUNT(HMP_AUTO_ID) as counts');
    $result = $ci->db->get(HMP_MAIN)->row();
    $maxid = $result->counts;
   
    $maxid = $maxid + 1;
    $returnId = str_pad($maxid, 4, 0, STR_PAD_LEFT);
    return 'HP'.$returnId;
}

function getRecNumber(){
    $ci = & get_instance();
    $ci->db->select('COUNT(REC_AUTO_ID) as counts');
    $result = $ci->db->get(REC_MAIN)->row();
    $maxid = $result->counts;
   
    $maxid = $maxid + 1;
    $returnId = str_pad($maxid, 4, 0, STR_PAD_LEFT);
    return 'REC'.$returnId;
}


// function getExecutive($return){
//       $ci = & get_instance();
//     $options['where']=[
//         'LD.USER_TYPE_ID'=>4,
//         'EMP.EMP_LOGIN_STATUS'=>'E',
//     ];
//     $options['return_type'] = 'result';
//     $options['join'] = [
//         'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = EMP.EMP_AUTO_ID','INNER']
//     ];
//     $actvity = $ci->common_model->getAlldata('EMPLOYEE_MANAGEMENT AS EMP', ['LD.LOGIN_ID','EMP.EMP_AUTO_ID','EMP.EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
  
//     if($return == 'drop'){
//         return $dropdownDetails = customFormDropDown($actvity,'LOGIN_ID','EMP_NAME','Select Executive');
//     }else{
//         return $actvity;
//     }
// }

function getUnitHead($return){
      $ci = & get_instance();
    $options['where']=[
        'LD.USER_TYPE_ID'=>5,
        'EMP.EMP_LOGIN_STATUS'=>'E',
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



