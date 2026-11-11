<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LumutCron extends CI_Controller
{

    public function cronUpdateOA2PTW()
    {
        global $aPermitType, $ptwInitialTemplate, $ptwHseVerificationTemplate, $ptwOAVerificationTemplate, $ptwFinalTemplate, $ptwFooterMailContent;
        $currentDateTime = date('Y-m-d H:i:s');
        $options['where'] = [
            'STATUS' => '2',
            'OA1_APPROVAL_STATUS' => 'Y',
            'OA2_APPROVAL_STATUS' => 'N',
            'OA1_APPROVAL_EXP_TIME <=' => $currentDateTime
        ];

        $options['join'] = [
            'LOGIN_DETAILS AS LD' => ['LD.LOGIN_ID = ' . PTW_TBL . '.OA2', 'INNER'],
            'EMPLOYEE_MANAGEMENT AS EMP' => ['EMP.EMP_AUTO_ID = LD.USER_REF_ID', 'INNER']

        ];
        $ptwDetails = $this->common_model->getAlldata(PTW_TBL, [PTW_TBL . '.*', '(CASE WHEN PERMIT_TYPE = "1" THEN "Normal PTW" ELSE "Critical PTW" END) as PERMIT_TYPE_NAME', 'FN_GET_AREA_CLASSIFICATION_NAME(AREA_OF_CLASSIFICATION) as AREA_OF_CLASSIFICATION_NAME', 'FN_PTW_STATUS_NAME(STATUS) as STATUS_NAME', 'EMP.EMP_NAME', 'EMP.EMP_EMAIL_ID'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
        $aResponse = [];
        if ($ptwDetails != FALSE) {
            foreach ($ptwDetails as $row) {

                $ptwTypeName = postData($row, 'PERMIT_TYPE_NAME');
                $ptwStartDate = postData($row, 'START_DATE');
                $ptwEndDate = postData($row, 'END_DATE');

                $displayStartDate = convertDate($ptwStartDate, $format = 'd-m-Y');
                $displayEndDate = convertDate($ptwEndDate, $format = 'd-m-Y');
                $locationName = postData($row, 'LOCATION_NAME');
                $specificLocationName = postData($row, 'SPECIFIC_WORKSITE');
                $areaClassificationName = postData($row, 'AREA_OF_CLASSIFICATION_NAME');
              
                $requsterName = postData($row, 'APPLICANT_NAME');
                $requesterDesignation = postData($row, 'APPLICANT_DESIGNATION_NAME');
                $statusName = strip_tags(postData($row, 'STATUS_NAME'));
                $hseName = postData($row, 'SHO_HSE_NAME');
                $hseDesignationName = strip_tags(postData($row, 'HSE_DESIGNATION_NAME'));
                $OAName = postData($row, 'OA_NAME');
                $OADesignationName = postData($row, 'OA_DESIGNATION_NAME');
                $remarks = postData($row, 'SHO_HSE_REMARKS');
                $permitNumber = postData($row, 'LIVE_PERMIT_NO');
                $userType = postData($row, 'APPLICANT_USER_TYPE_ID');
                $PTWStatus = postData($row, 'STATUS');
                $PTWId = postData($row, 'PTW_ID');
                $OA1 = postData($row, 'OA1');
                $OA2 = postData($row, 'OA2');
                $applicatUserId = postData($row, 'CREATED_BY');
                $HseUserId = postData($row, 'SHO_HSE_USER_LOGIN_ID');
                $OAUserId = postData($row, 'OA_USER_LOGIN_ID');
                $permitTypeId = postData($row, 'PERMIT_TYPE');
                $email = postData($row, 'EMP_EMAIL_ID');

                $OAName = postData($row, 'EMP_NAME');


                $updateData = [
                    'OA2_APPROVAL_STATUS' => 'Y',
                ];
                $updateWhere = [
                    'PTW_ID' => $PTWId,
                    'STATUS' => '2',
                    'OA1_APPROVAL_STATUS' => 'Y',
                ];
                $updateInfo = FALSE;
                $exeQuery = '';
                if (count($updateWhere) > 0) {
                    $this->db->where($updateWhere);
                    $this->db->update(PTW_TBL, $updateData);
                    $updateInfo = $this->db->affected_rows();
                    $exeQuery = $this->db->last_query();
                }

                if ($updateInfo > 0) {
                    $aNotifyData = [
                        '{permitNumber}' => $permitNumber,
                        '{ptwTypeName}' => $ptwTypeName,
                        '{ptwStartDate}' => $displayStartDate,
                        '{ptwEndDate}' => $displayEndDate,
                        '{locationName}' => $locationName,
                        '{specificLocationName}' => $specificLocationName,
                        '{areaClassification}' => $areaClassificationName,
                       
                        '{requsterName}' => $requsterName,
                        '{requesterDesignation}' => $requesterDesignation,
                        '{statusName}' => $statusName,
                        '{hseName}' => $hseName,
                        '{hseDesignation}' => $hseDesignationName,
                        '{oaName}' => $OAName,
                        '{oaDesignation}' => $OADesignationName,
                        '{remarks}' => $remarks,
                    ];

                    $employeeTo = [];
                    $groupUserTypeTo = [];
                    $encPTWID = encryptval($PTWId);
                    $notifyUrl = '';
                    $notifypermitType = isset($aPermitType[$permitTypeId]) ? $aPermitType[$permitTypeId] : '';
                    $notifyMessage = str_replace(array_keys($aNotifyData), array_values($aNotifyData), $ptwHseVerificationTemplate);

                    $employeeTo = [$OA2];
                    $notifyGroupTo = (is_array($groupUserTypeTo) && count($groupUserTypeTo) > 0) ? implode(',', $groupUserTypeTo) : '';
                    $notifyEmployeeTo = (is_array($employeeTo) && count($employeeTo) > 0) ? implode(',', $employeeTo) : '';
                    $notifyUrl = 'ptw/permit/verify/' . $encPTWID . '?type=' . $notifypermitType;
                    $notifydata = [
                        'text' => $notifyMessage,
                        'url' => $notifyUrl,
                        'type' => 1,
                        'employee' => $notifyEmployeeTo,
                        'mobilelink' => '',
                    ];
                    insertNotifications($notifydata);


                    $toemail = $email;
                    $subject = $ptwTypeName . ':' . $permitNumber . ' Waiting for your approval';
                    $emailMessage = $notifyMessage . $ptwFooterMailContent;
                    $data = array(
                        'view_file' => 'common/email/common_mail',
                        'messageText' => $emailMessage,
                        'footerText' => ''

                    );
                    $template = $this->template->load_email_template($data);
                    $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
                    $aResponse['success'][$PTWId]['Id'] = $PTWId;
                } else {
                    $aResponse['error'][$PTWId]['Id'] = $PTWId;
                    $aResponse['error'][$PTWId]['exQuery'] = $exeQuery;
                }
            }
        }
        echo '<pre>';
        echo 'UPDATE OA';
        echo '<br/>';
        echo '=========';
        echo '<br/>';
        print_r($aResponse);
        echo '</pre>';
    }

    public function autoClosePTW()
    {

        $updateData = [
            'STATUS' => '7',
            'PTW_CLOSE_TYPE' => 'AUTO',
        ];
        $updateWhere = [

            'STATUS != ' => '7',
            'DATEDIFF(CURRENT_DATE,SHO_HSE_DATE) >=' => 7,
        ];
        $updateInfo = FALSE;
        $exeQuery = '';
        if (count($updateWhere) > 0) {
            $this->db->where($updateWhere);
            $this->db->update(PTW_TBL, $updateData);
            $updateInfo = $this->db->affected_rows();
            $exeQuery = $this->db->last_query();
        }

        if ($updateInfo > 0) {
            echo $updateInfo . ' PTW auto close updated';
        } else if ($updateInfo < 0) {
            echo 'Error in update';
            echo '<br/>';
            $toemail = 'mkesav.ardhas@gmail.com';
            $subject = 'PTW Auto close update Failed';
            $emailMessage = 'Kindly check the below query for refrence: <br/> <br/> <b>QUERY SQL : </b>' . $exeQuery;
            $data = array(
                'view_file' => 'common/email/common_mail',
                'messageText' => $emailMessage,
                'footerText' => ''

            );
            $template = $this->template->load_email_template($data);
            $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
        } else {
            echo 'No PTW Found';
        }
    }


    public function autoRecMailNotification()
    {
        //echo "sdsd";exit;
        $termOptn['where'] = [
            'REC_STATUS' => 'Y',
            'REC_NOT' => '1'
        ];
        $getAllRec = $this->common_model->getAlldata(REC_MAIN, ['*'], $termOptn);
        $current_date = date('Y-m-d');
        //echo date('Y-m-d', strtotime($current_date. ' + 30 days'));exit; 
        $aResponse = [];
        if (!empty($getAllRec)) {
            foreach ($getAllRec as $getRec) {
                $expiry_date = $getRec->REC_EXP_DATE;
                $current_date = date('Y-m-d');
                $notifydate = date('Y-m-d', strtotime($expiry_date . '-  30 days'));

                $REC_AUTO_ID = $getRec->REC_AUTO_ID;
                $REC_ID = $getRec->REC_ID;
                $REC_NAME = $getRec->REC_NAME;
                $REC_EXP_DATE = $getRec->REC_EXP_DATE;

                $userTypeId = ['6', '7'];
                $aemail_id = $this->getRecEmailDetails($userTypeId);
                //print_r($aemail_id); exit;
                if ($aemail_id != FALSE) {
                    $notify_email_id = $aemail_id->emailList;
                    $notify_id = $aemail_id->notifyidList;
                }

                $encRec = encryptval($REC_AUTO_ID);
                $notifyUrl = '';
                $employeeEmail = FALSE;
                $ptwFooterMailContent = '<br/>This is system generated E-mail, do not reply to this email.<br/>';

                if (strtotime($current_date) == strtotime($notifydate)) {

                    $notifyMessage = 'Record Master has been going to expire, details are as follows :<br/><br/><b>Record ID : </b> ' . $REC_ID . '<br/> <b>Record Name : </b> ' . $REC_NAME . ' <br/><b>Expiry Date : </b> ' . $REC_EXP_DATE  . ' <br/>';
                    $notifyUrl = 'hmp/rec/addRec/' . $encRec;
                    $subject = 'Record Master - ID - ' . $REC_ID . ' - Expire Notification';

                    $employeeEmail = TRUE;
                    $notfiy_id = $notify_id;
                    $emailId = $notify_email_id;

                    $notifydata = [
                        'text' => $notifyMessage,
                        'url' => $notifyUrl,
                        'type' => 1,
                        'notifygroup' => '',
                        'employee' => $notfiy_id,
                        'mobilelink' => '',
                    ];
                    insertNotifications($notifydata);



                    $emailMessage = $notifyMessage . $ptwFooterMailContent;
                    if ($employeeEmail) {


                        //  print_r($emailData);exit;

                        $toemail = $notify_email_id;
                        $message = $emailMessage;

                        $tempdata = array(
                            'view_file' => 'common/email/common_mail',
                            'messageText' => $message,
                            'footerText' => ''
                        );
                        //print_r($toemail);exit;
                        $template = $this->template->load_email_template($tempdata);

                        $this->email_model->sendEmail($toemail, $subject, $template, $file = "");
                        $aResponse['success'][$REC_AUTO_ID]['Id'] = $REC_AUTO_ID;
                    }
                }
            }
        }
    }

    public function getRecEmailDetails($ids, $type = 'USERTYPE')
    {
        $ci = &get_instance();
        $options['join'] = [
            // 'LOGIN_DETAILS AS LD'=>['LD.USER_DESINATION_ID = EMP.EMP_DESIGNATION_ID' ,'INNER']
            'LOGIN_DETAILS AS LD' => ['LD.USER_REF_ID = EMP.EMP_AUTO_ID', 'INNER']

        ];
        $options['return_type'] = 'row';

        if ($type == 'USERTYPE') {
            $options['where_in'] = ['USER_TYPE_ID' => $ids];
            // $options['group_by'] = [
            //    'DESC'=>'LD.USER_TYPE_ID'
            // ];
        } else {
            $options['where_in'] = ['LOGIN_ID' => $ids];
        }
        $details = $ci->common_model->getAlldata('EMPLOYEE_MANAGEMENT as EMP', ['GROUP_CONCAT( DISTINCT EMP_EMAIL_ID) as emailList', 'GROUP_CONCAT( DISTINCT LOGIN_ID) as notifyidList'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
        //echo $ci->db->last_query();
        return $details;
    }

    public function autoDeletelogs()
    {
        $this->load->helper('file');

        $folder_path = APPPATH . 'logs';
        $files = glob($folder_path . '/*');
        // echo "<pre>";
        // print_r($files);exit;
        $now   = time();

        foreach ($files as $file) {
            if (is_file($file)) {
                if ($now - filemtime($file) >= 60 * 60 * 24 * 60) {
                    unlink($file);
                }
            }
        }
    }

    public function autoDeleteGts()
    {
        //$this->load->helper('file');

        $folder_path = 'assets/images/modules/gts/images';
        $files = glob($folder_path . '/*');
        //        echo "<pre>";
        //        print_r($files);
        //        print_r($folder_path);
        //        
        //        exit;
        $now   = time();

        foreach ($files as $file) {
            if (is_file($file)) {
                if ($now - filemtime($file) >= 60 * 60 * 24 * 150) { // 6 month
                    unlink($file);
                }
            }
        }
    }

    public function autoDeleteTracking()
    {
        $this->db->where('timestamp <', "UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 90 DAY))", false);
        $this->db->delete('usertracking');
        // echo $this->db->last_query();exit;
        //SELECT *,DATE_FORMAT(FROM_UNIXTIME(`timestamp`), '%Y-%m-%d') FROM `usertracking`
        //  DELETE FROM usertracking WHERE timestamp < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 90 DAY))
    }


    //http://localhost:81/Lumut_Port/vault_feb_live/vault/LumutCron/autoDeleteTracking
    //http://104.211.139.218/Lumut_Port/Dev/V1/LumutCron/autoDeleteTracking


}
