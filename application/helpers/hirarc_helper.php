<?php

function getExecutiveIdetails($return, $whr = '') {
    $ci = & get_instance();
    $options['where'] = [
        'LD.USER_TYPE_ID' => 4,
        'EMP.EMP_LOGIN_STATUS' => 'E',
    ];
    if ($whr != '') {
        $options['where'] = [
            'EMP.EMP_AUTO_ID' => $whr
        ];
    }
    $options['return_type'] = 'result';
    $options['join'] = [
        'USER_TYPE_DESIGNATION AS UT' => ['UT.USER_DESIGN_ID = EMP.EMP_DESIGNATION_ID', 'INNER'],
        'LOGIN_DETAILS AS LD' => ['LD.USER_DESINATION_ID = EMP.EMP_DESIGNATION_ID', 'INNER']
    ];
    $actvity = $ci->common_model->getAlldata('EMPLOYEE_MANAGEMENT AS EMP', ['LD.LOGIN_ID', 'EMP.EMP_AUTO_ID', 'EMP.EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
    //echo $ci->db->last_query();exit;
    if ($return == 'drop') {
        return $dropdownDetails = customFormDropDown($actvity, 'LOGIN_ID', 'EMP_NAME', 'Select Executive');
    } else {
        return $actvity;
    }
}

function getUnitHeadIdetails($return) {
      $ci = & get_instance();
    $options['where']=[
        'LD.USER_TYPE_ID'=>5,
        'EMP.EMP_LOGIN_STATUS'=>'E',
    ];
    $options['return_type'] = 'result';
    $options['join'] = [
        'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = EMP.EMP_AUTO_ID','INNER']
    ];
    $actvity = $ci->common_model->getAlldata('EMPLOYEE_MANAGEMENT AS EMP', ['LD.LOGIN_ID', 'EMP.EMP_AUTO_ID', 'EMP.EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
//    echo $ci->db->last_query();exit; 
    if ($return == 'drop') {
        return $dropdownDetails = customFormDropDown($actvity, 'LOGIN_ID', 'EMP_NAME', 'Select Unit Head');
    } else {
        return $actvity;
    }
}

function sendHirarcNotification($hirarc_id) {
    $ci = &get_instance();

    $tab = HIR_MAIN . ' as h';
    $select = ['h.MAIN_AUTO_ID,h.HIRARC_ID,t.TERMINAL_NAME,d.DEPT_NAME,c.COM_NAME,em.EMP_EMAIL_ID as creater_mail,e.EMP_EMAIL_ID,h.PRO_ACT_LOC,h.HOD_ID,h.OTH_COMP_NAME,h.CREATED_BY,h.HIRARC_FLOW_STATUS'];
    $options['join'][HIR_COM . ' as c'] = ['c.COM_AUTO_ID = h.FK_COMP_ID', 'left'];
    $options['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = h.FK_TERMINAL_ID', 'left'];
    $options['join'][DEPT . ' as d'] = ['d.DEPT_AUTO_ID = h.FK_DEPT_ID', 'left'];
    $options['join'][USER_LOG . ' as u'] = ['u.LOGIN_ID = h.HOD_ID', 'left'];
    $options['join'][USER_LOG . ' as us'] = ['us.LOGIN_ID = h.CREATED_BY', 'left'];
    $options['join'][EMPL . ' as e'] = ['e.EMP_AUTO_ID = u.USER_REF_ID', 'left'];
    $options['join'][EMPL . ' as em'] = ['em.EMP_AUTO_ID = us.USER_REF_ID', 'left'];
//    $options['join'][PRO_ACT_AREA . ' as p'] = ['p.PRO_AUTO_ID = h.PRO_ACT_LOC', 'left'];
    $options['return_type'] = 'row';
    $options['where'] = [
        'MAIN_AUTO_ID' => $hirarc_id,
        'HIRARC_STATUS' => 'Y'
    ];
    $hir_details = $ci->common_model->getAlldata($tab, $select, $options);

    if ($hir_details != FALSE) {
        $HIRID = postData($hir_details, 'MAIN_AUTO_ID');
        $HIRARC_ID = postData($hir_details, 'HIRARC_ID');
        $TERMINAL_NAME = postData($hir_details, 'TERMINAL_NAME');
        $DEPT_NAME = postData($hir_details, 'DEPT_NAME');
        $COM_NAME = postData($hir_details, 'COM_NAME');
        $PRO_NAME = postData($hir_details, 'PRO_ACT_LOC');
        $HIRARCStatus = postData($hir_details, 'HIRARC_FLOW_STATUS');
        $HOD_ID = postData($hir_details, 'HOD_ID');
        $CREATED_BY = postData($hir_details, 'CREATED_BY');
        $EMP_EMAIL_ID = postData($hir_details, 'EMP_EMAIL_ID');
        $creater_mail = postData($hir_details, 'creater_mail');
    }

    $encHIRID = encryptval($HIRID);
    $notifyUrl = '';
    $employeeEmail = FALSE;
    $ptwFooterMailContent = '<br/>This is system generated E-mail, do not reply to this email.<br/>';
    switch ($HIRARCStatus) {
//        case '1':
//            /* Pending */
//            $notifyMessage = 'New HIRARC has been created and waiting for your approval with following details  :<br/><br/><b>Company : </b> ' . $COM_NAME . '<br/> <b>HIRARC No. : </b> ' . $HIRARC_ID . ' <br/><b>Location : </b> ' . $TERMINAL_NAME . ' <br/><b>Department : </b> ' . $DEPT_NAME . '<br/><b>Process/Location/Activity : </b> ' . $PRO_NAME . ' <br/>';
//            $notifyUrl = 'hirarc/hirarc/view_report/' . $encHIRID;
//            $subject = 'New HIRARC - ID - ' . $HIRARC_ID . ' has been created';
//            $employeeEmail = TRUE;
//            break;
        case '2':
            /* Executive submitted */
            $notifyMessage = 'New HIRARC has been completed by an engineer and waiting for your approval with following details :<br/><br/><b>Company : </b> ' . $COM_NAME . '<br/> <b>HIRARC No. : </b> ' . $HIRARC_ID . ' <br/><b>Location : </b> ' . $TERMINAL_NAME . ' <br/><b>Department : </b> ' . $DEPT_NAME . '<br/><b>Process/Location/Activity : </b> ' . $PRO_NAME . ' <br/>';
            $notifyUrl = 'hirarc/hirarc/view_report/' . $encHIRID;
            $employeeEmail = TRUE;
            $subject = 'HIRARC - ID - ' . $HIRARC_ID . ' has been completed by an engineer and waiting for your approval';
            $notfiy_id = $HOD_ID;
            $emailId = $EMP_EMAIL_ID;
            break; 
        case '3':
            /* HOD Approved */
            $notifyMessage = 'New HIRARC has been Approved with following details  :<br/><br/><b>Company : </b> ' . $COM_NAME . '<br/> <b>HIRARC No. : </b> ' . $HIRARC_ID . ' <br/><b>Location : </b> ' . $TERMINAL_NAME . ' <br/><b>Department : </b> ' . $DEPT_NAME . '<br/><b>Process/Location/Activity : </b> ' . $PRO_NAME . ' <br/>';
            $notifyUrl = 'hirarc/hirarc/view_report/' . $encHIRID;
            $employeeEmail = TRUE;
            $subject = 'HIRARC - ID - ' . $HIRARC_ID . ' has been Approved By HOD';
            $notfiy_id = $CREATED_BY;
                
            $notfiy_details = getUsertypdesigEmplId(['6,7']);
            foreach ($notfiy_details as $key => $email) {
                $HSSEmailId[] = $email->EMP_EMAIL_ID;
            } 
            array_push($HSSEmailId, $creater_mail);
            $emailId = $HSSEmailId;
            break;
        case '-3':
            /* HOD Rejected */
            $notifyMessage = 'New HIRARC has been Rejected by HOD with following details  :<br/><br/><b>Company : </b> ' . $COM_NAME . '<br/> <b>HIRARC No. : </b> ' . $HIRARC_ID . ' <br/><b>Location : </b> ' . $TERMINAL_NAME . ' <br/><b>Department : </b> ' . $DEPT_NAME . '<br/><b>Process/Location/Activity : </b> ' . $PRO_NAME . ' <br/>';
            $notifyUrl = 'hirarc/hirarc/view_report/' . $encHIRID;
            $employeeEmail = TRUE;
            $subject = 'HIRARC - ID - ' . $HIRARC_ID . ' has been Rejected By HOD';
            $notfiy_id = $CREATED_BY;
            $emailId = $creater_mail;
            break;

        case '4':
            /* HSSE Approved */
            $notifyMessage = 'New HIRARC has been Approved by HSSE Team with following details  :<br/><br/><b>Company : </b> ' . $COM_NAME . '<br/> <b>HIRARC No. : </b> ' . $HIRARC_ID . ' <br/><b>Location : </b> ' . $TERMINAL_NAME . ' <br/><b>Department : </b> ' . $DEPT_NAME . '<br/><b>Process/Location/Activity : </b> ' . $PRO_NAME . ' <br/>';
            $notifyUrl = 'hirarc/hirarc/view_report/' . $encHIRID;
            $employeeEmail = TRUE;
            $subject = 'HIRARC - ID - ' . $HIRARC_ID . ' has been Approved By HSSE';
            $notfiy_id = $CREATED_BY;
            $emailId = $creater_mail;
            break;
        case '-4':
            /* HSSE Rejected */
            $notifyMessage = 'New HIRARC has been Rejected by HSSE Team with following details  :<br/><br/><b>Company : </b> ' . $COM_NAME . '<br/> <b>HIRARC No. : </b> ' . $HIRARC_ID . ' <br/><b>Location : </b> ' . $TERMINAL_NAME . ' <br/><b>Department : </b> ' . $DEPT_NAME . '<br/><b>Process/Location/Activity : </b> ' . $PRO_NAME . ' <br/>';
            $notifyUrl = 'hirarc/hirarc/view_report/' . $encHIRID;
            $employeeEmail = TRUE;
            $subject = 'HIRARC - ID - ' . $HIRARC_ID . ' has been Rejected By HSSE';
            $notfiy_id = $CREATED_BY;
            $emailId = $creater_mail;
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
    if ($HIRARCStatus == 3) {
        $notifydata['notifygroup'] = '6,7';
        $notifydata['employee'] = '0';
    }
    insertNotifications($notifydata);

    /* Email Template Details */


    $emailMessage = $notifyMessage . $ptwFooterMailContent;


    if ($employeeEmail) {
        $emailData = [
//            'email' => ["gokulardhas@gmail.com", "harsine.ardhas@gmail.com"],
            'email' => $emailId,
            'subject' => $subject,
            'message' => $emailMessage,
        ];
        sendNotificationEmail($emailData);
    }
    return TRUE;
}

function sendNotificationEmail($data = []) {
    $ci = &get_instance();
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

function getUsertypdesigEmplId($typid = []) {
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->from(DESIG . ' as des');
    $ci->db->join(UTYPE_DESIG . ' as udes', 'udes.USER_DESIGN_ID = des.DESIGNATION_ID', 'left');
    $ci->db->where_in('udes.USER_TYPE_ID', $typid);
    $ci->db->where('udes.USER_TYPE_DESIGNATION_STATUS', 'Y');
    $query = $ci->db->get();
//       echo $ci->db->last_query();exit;
//       $exeDropdown = [];
    if ($query->num_rows() > 0) {
        $execDatas = $query->result();

        foreach ($execDatas as $exKey => $exVal) {
            $desigId[] = $exVal->DESIGNATION_ID;
        }
        if (isset($desigId) && !empty($desigId)) {
            $ci->db->select("EMP_DESIGNATION_ID,EMP_EMAIL_ID");
            $ci->db->from(EMPL);
            $ci->db->where_in('EMP_DESIGNATION_ID', $desigId);
            $emplDet = $ci->db->get();
            if ($emplDet->num_rows() > 0) {
                $getEmpl = $emplDet->result();
                return $getEmpl;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}

function GetUniqueIdSequ($key_name, $ter_name, $dept_name, $dept_Id, $did = '') {

    $ci = & get_instance();
    $ci->db->select('count(MAIN_AUTO_ID) as total');
    $ci->db->from(HIR_MAIN);
    if ($dept_Id != '') {
        $ci->db->where('FK_DEPT_ID', $dept_Id);
    }
    $ci->db->group_by('FK_DEPT_ID');
    $query = $ci->db->get();
//    echo $ci->db->last_query();exit; 
    if ($query->num_rows() > 0) {
        $result = $query->row();
        if ($did != '') {
            $val = $result->total;
        } else {
            $val = $result->total + 1;
        }
    } else {
        $val = 1;
    }
    $length = strlen($val);

    if ($length == 1) {
        $newapp = $key_name . '/' . $ter_name . '/' . $dept_name . '/' . '000';
    } else if ($length == 2) {
        $newapp = $key_name . '/' . $ter_name . '/' . $dept_name . '/' . '00';
    }
    $new_cr_id = $newapp . $val;

    return $new_cr_id;
}

function getAllHazardDatas($row_id,$hirarc_id ) {
    $ci = & get_instance();
    $ci->db->select('HAZ_ID,HAZ_NAME');
    $ci->db->from(HAZA_NAME);
    if ($row_id != '' && $hirarc_id != '') {
        $ci->db->where('MAIN_HIRARC_ID', $hirarc_id);
        $ci->db->where('ROW_ID', $row_id);
    }
    $query = $ci->db->get();
//    echo $ci->db->last_query();exit; 
    if ($query->num_rows() > 0) {
        $result = $query->result();
    }
    return $result;
}

function getAllCauseDatas($row_id,$hirarc_id ) {
    $ci = & get_instance();
    $ci->db->select('CAUSE_AUTO_ID,CAUSE_NAME');
    $ci->db->from(HAZA_CAU);
    if ($row_id != '' && $hirarc_id != '') {
        $ci->db->where('MAIN_HIRARC_ID', $hirarc_id);
        $ci->db->where('ROW_ID', $row_id);
    }
    $query = $ci->db->get();
//    echo $ci->db->last_query();exit; 
    if ($query->num_rows() > 0) {
        $result = $query->result();
    }
    return $result;
}


function getAllExitingDatas($row_id,$hirarc_id ) {
    $ci = & get_instance();
    $ci->db->select('CONTROL_AUTO_ID,CONTROL_NAME');
    $ci->db->from(EXIT_RI_CN);
    if ($row_id != '' && $hirarc_id != '') {
        $ci->db->where('MAIN_HIRARC_ID', $hirarc_id);
        $ci->db->where('ROW_ID', $row_id);
    }
    $query = $ci->db->get();
//    echo $ci->db->last_query();exit; 
    if ($query->num_rows() > 0) {
        $result = $query->result();
    }
    return $result;
}