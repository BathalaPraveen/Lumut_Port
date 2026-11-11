<?php
// <---- New code: HSE Induction Module Controller Start ---->
defined('BASEPATH') OR exit('No direct script access allowed');

class Hse_induction extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(1);
        isLogin();
    }
    
    public function index() {
        $data = array(
            'view_file' => 'contractor/list_contractor',
            'site_title' => 'HSE Induction - Contractor',
            'current_menu' => 'Contractor',
            'ajaxurl' => 'hse_induction/list_contractor',
        );

        $this->template->load_table_template($data);
    }
    
    public function list_contractor() {
        $table = CONT_DET . ' as cont';
        $column_order = array(null, 'CONT_ID', 'CONT_COMPANY', 'CONT_NAME', 'CONT_EMAIL_ID', 'CONT_PHONE_NO', null);
        $column_search = array('CONT_ID', 'CONT_COMPANY', 'CONT_NAME', 'CONT_EMAIL_ID', 'CONT_PHONE_NO');
        $order = array('CREATED_ON' => 'desc');
        // <---- New code: Only list CONT_TYPE = 2 and CONT_STATUS = Y ---->
        $where = [
            'CONT_STATUS' => 'Y',
            'CONT_TYPE' => 2
        ];
        
        $listDept = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where);

        $finalDatas = [];
        if (isset($listDept) && !empty($listDept)) {
            foreach ($listDept as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->CONT_AUTO_ID;
                $contLogstat = $ltVal->CON_LOGIN_STATUS;
                
                          
                if ($contLogstat == 'P') {
                    $titileStat = 'Pending Approval';
                    $badgeClass = 'badge-warning';
                } elseif ($contLogstat == 'E') {
                    $titileStat = 'Approved';
                    $badgeClass = 'badge-success';
                } elseif ($contLogstat == 'S') {
                    $titileStat = 'Suspended / Banned';
                    $badgeClass = 'badge-danger';
                } else {
                    $titileStat = 'Rejected';
                    $badgeClass = 'badge-danger';
                }


                if ($contLogstat == 'E') {
                $action .= " " . anchor('hse_induction/contractor_employees/' . encryptval($id), '<i class="fas fa-user-plus text-success" aria-hidden="true"></i>', array('class' => '', 'title' => 'Contractor Employees'));
                }
                $action .= " " . anchor('hse_induction/viewContractor/' . encryptval($id), '<i class="fas fa-eye" aria-hidden="true"></i>', array('class' => '', 'title' => 'View'));
                $action .= " " . anchor('hse_induction/pdfContractor/' . encryptval($id), '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF'));
                
                $rows = [];
                $rows[] = $ltVal->CONT_ID;
                $rows[] = $ltVal->CONT_COMPANY;
                $rows[] = $ltVal->CONT_NAME;
                $rows[] = $ltVal->CONT_EMAIL_ID;
                $rows[] = $ltVal->CONT_PHONE_NO;
                $rows[] = '<span class="badge ' . $badgeClass . '">' . $titileStat . '</span> ';
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
        echo json_encode($output);
    }

    public function viewContractor($id = "") {
        $did = decryptval($id);
        
        $emplOptns['where'] = [
            'cont.CONT_AUTO_ID' => $did,
        ];
        $emplOptns['return_type'] = 'row';
        $getEmploydetails = $this->common_model->getAlldata(CONT_DET . ' as cont', ['cont.*'], $emplOptns);
        
        $othercertiDet['where'] = [
            'CERT_USER_ID' => $did,
            'CERT_USER_TYPE' => 'CONT',
            'CERT_COMMON_STATUS' => 'Y',
        ];
        $getOthercertdet = $this->common_model->getAlldata(COMP_CERTI . ' as certi', ['*'], $othercertiDet);
        
        $data = array(
            'view_file' => 'contractor/view_contractor',
            'current_menu' => 'View Contractor',
            'getEmploydetails' => $getEmploydetails,
            'getOthercertdet' => $getOthercertdet,
            'emplLogindet' => $this->common_model->getAlldata(LOGIN, ['*'], ['where' => ['USER_REF_ID' => $did, 'USER_TYPE_ID' => 12], 'return_type' => 'row']),
            'encrypted_id' => $id
        );
        $this->template->load_common_template($data);
    }

    // <---- New code: Approve Contractor Flow Start ---->
    public function approveContractor($id = '') {
        $did = decryptval($id);
        if (empty($did)) {
            redirect('hse_induction');
        }

        $post = $this->input->post();
        $password = postData($post, 'password');

        if (empty($password)) {
            $this->session->set_flashdata('error_msg', 'Password is required to approve contractor account.');
            redirect('hse_induction/viewContractor/' . $id);
        }

        $contractor = $this->db->get_where(CONT_DET, ['CONT_AUTO_ID' => $did])->row();
        if (!$contractor) {
            redirect('hse_induction');
        }

        // Update contractor status to Approved (E)
        $this->common_model->updateData(CONT_DET, ['CON_LOGIN_STATUS' => 'E'], ['CONT_AUTO_ID' => $did]);

        // Check if login already exists
        $existLogin = $this->db->get_where(LOGIN, [
            'USER_REF_ID' => $did,
            'USER_TYPE_ID' => 12
        ])->row();

        $logData = [
            'USER_REF_ID' => $did,
            'USER_TYPE_ID' => 12, // Company Contractor
            'USER_DESINATION_ID' => 0,
            'USERNAME' => $contractor->CONT_ID,
            'ENCRYPT_PASSWORD' => md5($password),
            'ORG_PWD' => $password,
            'USER_LOGIN_TYP' => 1,
            'USER_LOG_STATUS' => 'Y'
        ];

        if ($existLogin) {
            $this->common_model->updateData(LOGIN, $logData, ['LOGIN_ID' => $existLogin->LOGIN_ID]);
        } else {
            $this->common_model->updateData(LOGIN, $logData);
        }

        // Send Email Notification with credentials
        $toMail = !empty($contractor->CONT_EMAIL_ID) ? $contractor->CONT_EMAIL_ID : $contractor->CONT_COMP_EMAIL;
        $contName = !empty($contractor->CONT_NAME) ? $contractor->CONT_NAME : $contractor->CONT_COMPANY;

        $emailMsg = "Dear <b>" . $contName . "</b>,<br><br>" .
                    "Your Company / Contractor Registration (<b>" . $contractor->CONT_COMPANY . "</b>) has been <b>APPROVED</b> by Lumut Port HSSE Team.<br><br>" .
                    "Below are your login credentials to access the portal:<br><br>" .
                    "<b>Portal URL:</b> <a href='" . BASE_URL . "login' target='_blank'>" . BASE_URL . "login</a><br>" .
                    "<b>Username:</b> " . $contractor->CONT_ID . "<br>" .
                    "<b>Password:</b> " . $password . "<br><br>" .
                    "Please keep your credentials safe and do not share them with unauthorized persons.<br><br>" .
                    "Thanks & Regards,<br>" .
                    "<b>Lumut Port HSSE Team</b><br>" .
                    "<small>This is a system generated email, please do not reply.</small>";

        $idata = [
            'emplmailID' => $toMail,
            'emplName' => $contName,
            'messageText' => $emailMsg,
            'subject' => 'LUMUT PORT - CONTRACTOR REGISTRATION APPROVED',
            'mainModule' => 'masterMod'
        ];
        internalNotificationOverall($idata);

        // <---- New code: Send In-App & Email Notification to Super Admin (USER_TYPE_ID = 1) and Admin (USER_TYPE_ID = 2) Start ---->
        $adminUsers = $this->db->select('l.LOGIN_ID, em.EMP_EMAIL_ID, em.EMP_NAME')
                               ->from(LOGIN . ' l')
                               ->join('employee_management em', 'em.EMP_AUTO_ID = l.USER_REF_ID', 'left')
                               ->where_in('l.USER_TYPE_ID', [1, 2])
                               ->where('l.USER_LOG_STATUS', 'Y')
                               ->get()->result_array();

        $adminLoginIds = !empty($adminUsers) ? implode(',', array_filter(array_column($adminUsers, 'LOGIN_ID'))) : '3';

        $adminNotifyDesc = 'Contractor Registration has been <b>APPROVED</b>:<br/><br/>' .
                           '<b>Company Name:</b> ' . $contractor->CONT_COMPANY . '<br/>' .
                           '<b>Contractor ID:</b> ' . $contractor->CONT_ID . '<br/>' .
                           '<b>Contact Person:</b> ' . $contName . '<br/>' .
                           '<b>Email:</b> ' . $toMail . '<br/>' .
                           '<b>Status:</b> Approved (Active)';

        $maxNoti = $this->db->select_max('NOTIFICATION_ID', 'max_id')->get(NOTI)->row();
        $nextNotiId = (!empty($maxNoti->max_id)) ? ((int)$maxNoti->max_id + 1) : 1;

        $notifyData = [
            'NOTIFICATION_ID' => $nextNotiId,
            'NOTIFICATION_DESC' => $adminNotifyDesc,
            'NOTIFICATION_TYPE' => '1',
            'NOTIFICATION_GROUP_CATID' => '1',
            'NOTIFICATION_EMPLOYEE_ID' => $adminLoginIds,
            'NOTIFICATION_HREF' => 'hse_induction/viewContractor/' . $id,
            'NOTIFICATION_MOBILE_LINK' => '',
            'NOTIFICATION_TASK_TYPE' => 'CONTRACTOR',
            'NOTIFICATION_IS_PUBLIC' => 1,
            'NOTIFICATION_STATUS' => 'Y',
            'CREATED_ON' => date('Y-m-d H:i:s'),
            'UPDATED_ON' => date('Y-m-d H:i:s')
        ];
        $this->db->insert(NOTI, $notifyData);

        // Email to Super Admin / Admin if email exists
        if (!empty($adminUsers)) {
            foreach ($adminUsers as $adm) {
                if (!empty($adm['EMP_EMAIL_ID'])) {
                    $admMailData = [
                        'emplmailID' => $adm['EMP_EMAIL_ID'],
                        'emplName' => !empty($adm['EMP_NAME']) ? $adm['EMP_NAME'] : 'Administrator',
                        'messageText' => "Hello Administrator,<br><br>The contractor registration for <b>" . $contractor->CONT_COMPANY . "</b> (ID: <b>" . $contractor->CONT_ID . "</b>) has been <b>APPROVED</b>.<br><br><a href='" . BASE_URL . "hse_induction/viewContractor/" . $id . "' target='_blank'>Click here to view contractor details</a><br><br>Thanks & Regards,<br><b>Lumut Port HSSE Team</b>",
                        'subject' => 'LUMUT PORT - CONTRACTOR REGISTRATION APPROVED: ' . $contractor->CONT_COMPANY,
                        'mainModule' => 'masterMod'
                    ];
                    internalNotificationOverall($admMailData);
                }
            }
        }
        // <---- New code: Send In-App & Email Notification to Super Admin and Admin End ---->

        $this->session->set_flashdata('success_msg', 'Contractor approved successfully and login credentials sent to ' . $toMail);
        redirect('hse_induction/viewContractor/' . $id);
    }
    // <---- New code: Approve Contractor Flow End ---->

    // <---- New code: Reject Contractor Flow Start ---->
    public function rejectContractor($id = '') {
        $did = decryptval($id);
        if (empty($did)) {
            redirect('hse_induction');
        }

        $post = $this->input->post();
        $reason = postData($post, 'reject_reason');

        if (empty($reason)) {
            $this->session->set_flashdata('error_msg', 'Rejection reason is required.');
            redirect('hse_induction/viewContractor/' . $id);
        }

        $contractor = $this->db->get_where(CONT_DET, ['CONT_AUTO_ID' => $did])->row();
        if (!$contractor) {
            redirect('hse_induction');
        }

        // Update contractor status to Rejected (D) and record reason
        $this->common_model->updateData(CONT_DET, [
            'CON_LOGIN_STATUS' => 'D',
            'CONT_REJECT_REASON' => $reason
        ], ['CONT_AUTO_ID' => $did]);

        // If login exists, disable it
        $this->common_model->updateData(LOGIN, ['USER_LOG_STATUS' => 'N'], [
            'USER_REF_ID' => $did,
            'USER_TYPE_ID' => 12
        ]);

        // Send Email Notification with rejection reason & edit link
        $toMail = !empty($contractor->CONT_EMAIL_ID) ? $contractor->CONT_EMAIL_ID : $contractor->CONT_COMP_EMAIL;
        $contName = !empty($contractor->CONT_NAME) ? $contractor->CONT_NAME : $contractor->CONT_COMPANY;
        $editUrl = BASE_URL . 'company_registration/edit/' . $id;

        $emailMsg = "Dear <b>" . $contName . "</b>,<br><br>" .
                    "Your Company / Contractor Registration (<b>" . $contractor->CONT_COMPANY . "</b> - <b>" . $contractor->CONT_ID . "</b>) has been reviewed and <b>REJECTED</b> by Lumut Port HSSE Team.<br><br>" .
                    "<b>Reason for Rejection:</b><br>" .
                    "<blockquote style='background:#fdf2f2; border-left:4px solid #e02424; padding:10px 15px; margin:10px 0;'>" .
                    nl2br(htmlspecialchars($reason)) .
                    "</blockquote><br>" .
                    "Please click the link below to update your company details / re-upload the required documents and re-submit your registration:<br><br>" .
                    "👉 <b>Edit Registration Link:</b> <a href='" . $editUrl . "' target='_blank' style='background:#2563eb; color:#fff; padding:8px 16px; text-decoration:none; border-radius:4px; display:inline-block;'>Update & Re-Submit Application</a><br><br>" .
                    "Direct Link: " . $editUrl . "<br><br>" .
                    "Thanks & Regards,<br>" .
                    "<b>Lumut Port HSSE Team</b><br>" .
                    "<small>This is a system generated email, please do not reply.</small>";

        $idata = [
            'emplmailID' => $toMail,
            'emplName' => $contName,
            'messageText' => $emailMsg,
            'subject' => 'LUMUT PORT - CONTRACTOR REGISTRATION STATUS: REJECTED',
            'mainModule' => 'masterMod'
        ];
        internalNotificationOverall($idata);

        // <---- New code: Send In-App & Email Notification to Super Admin (USER_TYPE_ID = 1) and Admin (USER_TYPE_ID = 2) Start ---->
        $adminUsers = $this->db->select('l.LOGIN_ID, em.EMP_EMAIL_ID, em.EMP_NAME')
                               ->from(LOGIN . ' l')
                               ->join('employee_management em', 'em.EMP_AUTO_ID = l.USER_REF_ID', 'left')
                               ->where_in('l.USER_TYPE_ID', [1, 2])
                               ->where('l.USER_LOG_STATUS', 'Y')
                               ->get()->result_array();

        $adminLoginIds = !empty($adminUsers) ? implode(',', array_filter(array_column($adminUsers, 'LOGIN_ID'))) : '3';

        $adminNotifyDesc = 'Contractor Registration has been <b class="text-danger">REJECTED</b>:<br/><br/>' .
                           '<b>Company Name:</b> ' . $contractor->CONT_COMPANY . '<br/>' .
                           '<b>Contractor ID:</b> ' . $contractor->CONT_ID . '<br/>' .
                           '<b>Contact Person:</b> ' . $contName . '<br/>' .
                           '<b>Rejection Reason:</b> ' . htmlspecialchars($reason) . '<br/>' .
                           '<b>Status:</b> Rejected (Awaiting Re-submission)';

        $maxNoti = $this->db->select_max('NOTIFICATION_ID', 'max_id')->get(NOTI)->row();
        $nextNotiId = (!empty($maxNoti->max_id)) ? ((int)$maxNoti->max_id + 1) : 1;

        $notifyData = [
            'NOTIFICATION_ID' => $nextNotiId,
            'NOTIFICATION_DESC' => $adminNotifyDesc,
            'NOTIFICATION_TYPE' => '1',
            'NOTIFICATION_GROUP_CATID' => '1',
            'NOTIFICATION_EMPLOYEE_ID' => $adminLoginIds,
            'NOTIFICATION_HREF' => 'hse_induction/viewContractor/' . $id,
            'NOTIFICATION_MOBILE_LINK' => '',
            'NOTIFICATION_TASK_TYPE' => 'CONTRACTOR',
            'NOTIFICATION_IS_PUBLIC' => 1,
            'NOTIFICATION_STATUS' => 'Y',
            'CREATED_ON' => date('Y-m-d H:i:s'),
            'UPDATED_ON' => date('Y-m-d H:i:s')
        ];
        $this->db->insert(NOTI, $notifyData);

        // Email to Super Admin / Admin if email exists
        if (!empty($adminUsers)) {
            foreach ($adminUsers as $adm) {
                if (!empty($adm['EMP_EMAIL_ID'])) {
                    $admMailData = [
                        'emplmailID' => $adm['EMP_EMAIL_ID'],
                        'emplName' => !empty($adm['EMP_NAME']) ? $adm['EMP_NAME'] : 'Administrator',
                        'messageText' => "Hello Administrator,<br><br>The contractor registration for <b>" . $contractor->CONT_COMPANY . "</b> (ID: <b>" . $contractor->CONT_ID . "</b>) has been <b>REJECTED</b>.<br><br><b>Reason:</b> " . nl2br(htmlspecialchars($reason)) . "<br><br><a href='" . BASE_URL . "hse_induction/viewContractor/" . $id . "' target='_blank'>Click here to view contractor details</a><br><br>Thanks & Regards,<br><b>Lumut Port HSSE Team</b>",
                        'subject' => 'LUMUT PORT - CONTRACTOR REGISTRATION REJECTED: ' . $contractor->CONT_COMPANY,
                        'mainModule' => 'masterMod'
                    ];
                    internalNotificationOverall($admMailData);
                }
            }
        }
        // <---- New code: Send In-App & Email Notification to Super Admin and Admin End ---->

        $this->session->set_flashdata('success_msg', 'Contractor registration rejected. Rejection email with edit link sent to ' . $toMail);
        redirect('hse_induction/viewContractor/' . $id);
    }
    // <---- New code: Reject Contractor Flow End ---->

    // <---- New code: Suspend / Ban Contractor Flow Start ---->
    public function suspendBanContractor($id = '') {
        $did = decryptval($id);
        if (empty($did)) {
            redirect('hse_induction');
        }

        $post = $this->input->post();
        $reason = postData($post, 'ban_reason');
        $label = 'Suspended / Banned';

        if (empty($reason)) {
            $this->session->set_flashdata('error_msg', 'Reason is required to suspend/ban the contractor.');
            redirect('hse_induction/viewContractor/' . $id);
        }

        $contractor = $this->db->get_where(CONT_DET, ['CONT_AUTO_ID' => $did])->row();
        if (!$contractor) {
            redirect('hse_induction');
        }

        // Single status 'S' for Suspended / Banned
        $this->common_model->updateData(CONT_DET, [
            'CON_LOGIN_STATUS' => 'S',
            'CONT_BAN_REASON' => $reason
        ], ['CONT_AUTO_ID' => $did]);

        // Disable login account if exists
        $this->common_model->updateData(LOGIN, ['USER_LOG_STATUS' => 'N'], [
            'USER_REF_ID' => $did,
            'USER_TYPE_ID' => 12
        ]);

        // Send Email Notification to Contractor
        $toMail = !empty($contractor->CONT_EMAIL_ID) ? $contractor->CONT_EMAIL_ID : $contractor->CONT_COMP_EMAIL;
        $contName = !empty($contractor->CONT_NAME) ? $contractor->CONT_NAME : $contractor->CONT_COMPANY;

        $emailMsg = "Dear <b>" . $contName . "</b>,<br><br>" .
                    "Please be advised that your contractor account for <b>" . $contractor->CONT_COMPANY . "</b> (ID: <b>" . $contractor->CONT_ID . "</b>) has been <b>SUSPENDED / BANNED</b> by Lumut Port HSSE Team.<br><br>" .
                    "<b>Reason for Suspension / Ban:</b><br>" .
                    "<blockquote style='background:#fdf2f2; border-left:4px solid #dc2626; padding:10px 15px; margin:10px 0;'>" .
                    nl2br(htmlspecialchars($reason)) .
                    "</blockquote><br>" .
                    "Your portal access has been disabled. For any clarification or appeals, please contact the Lumut Port HSSE Department directly.<br><br>" .
                    "Thanks & Regards,<br>" .
                    "<b>Lumut Port HSSE Team</b><br>" .
                    "<small>This is a system generated email, please do not reply.</small>";

        $idata = [
            'emplmailID' => $toMail,
            'emplName' => $contName,
            'messageText' => $emailMsg,
            'subject' => 'LUMUT PORT - CONTRACTOR STATUS: SUSPENDED / BANNED',
            'mainModule' => 'masterMod'
        ];
        internalNotificationOverall($idata);

        // Send In-App & Email Notification to Super Admin and Admin
        $adminUsers = $this->db->select('l.LOGIN_ID, em.EMP_EMAIL_ID, em.EMP_NAME')
                               ->from(LOGIN . ' l')
                               ->join('employee_management em', 'em.EMP_AUTO_ID = l.USER_REF_ID', 'left')
                               ->where_in('l.USER_TYPE_ID', [1, 2])
                               ->where('l.USER_LOG_STATUS', 'Y')
                               ->get()->result_array();

        $adminLoginIds = !empty($adminUsers) ? implode(',', array_filter(array_column($adminUsers, 'LOGIN_ID'))) : '3';

        $adminNotifyDesc = 'Contractor has been <b class="text-danger">SUSPENDED / BANNED</b>:<br/><br/>' .
                           '<b>Company Name:</b> ' . $contractor->CONT_COMPANY . '<br/>' .
                           '<b>Contractor ID:</b> ' . $contractor->CONT_ID . '<br/>' .
                           '<b>Contact Person:</b> ' . $contName . '<br/>' .
                           '<b>Reason:</b> ' . htmlspecialchars($reason) . '<br/>' .
                           '<b>Status:</b> Suspended / Banned';

        $maxNoti = $this->db->select_max('NOTIFICATION_ID', 'max_id')->get(NOTI)->row();
        $nextNotiId = (!empty($maxNoti->max_id)) ? ((int)$maxNoti->max_id + 1) : 1;

        $notifyData = [
            'NOTIFICATION_ID' => $nextNotiId,
            'NOTIFICATION_DESC' => $adminNotifyDesc,
            'NOTIFICATION_TYPE' => '1',
            'NOTIFICATION_GROUP_CATID' => '1',
            'NOTIFICATION_EMPLOYEE_ID' => $adminLoginIds,
            'NOTIFICATION_HREF' => 'hse_induction/viewContractor/' . $id,
            'NOTIFICATION_MOBILE_LINK' => '',
            'NOTIFICATION_TASK_TYPE' => 'CONTRACTOR',
            'NOTIFICATION_IS_PUBLIC' => 1,
            'NOTIFICATION_STATUS' => 'Y',
            'CREATED_ON' => date('Y-m-d H:i:s'),
            'UPDATED_ON' => date('Y-m-d H:i:s')
        ];
        $this->db->insert(NOTI, $notifyData);

        if (!empty($adminUsers)) {
            foreach ($adminUsers as $adm) {
                if (!empty($adm['EMP_EMAIL_ID'])) {
                    $admMailData = [
                        'emplmailID' => $adm['EMP_EMAIL_ID'],
                        'emplName' => !empty($adm['EMP_NAME']) ? $adm['EMP_NAME'] : 'Administrator',
                        'messageText' => "Hello Administrator,<br><br>The contractor <b>" . $contractor->CONT_COMPANY . "</b> (ID: <b>" . $contractor->CONT_ID . "</b>) has been <b>SUSPENDED / BANNED</b>.<br><br><b>Reason:</b> " . nl2br(htmlspecialchars($reason)) . "<br><br><a href='" . BASE_URL . "hse_induction/viewContractor/" . $id . "' target='_blank'>Click here to view contractor details</a><br><br>Thanks & Regards,<br><b>Lumut Port HSSE Team</b>",
                        'subject' => 'LUMUT PORT - CONTRACTOR SUSPENDED / BANNED: ' . $contractor->CONT_COMPANY,
                        'mainModule' => 'masterMod'
                    ];
                    internalNotificationOverall($admMailData);
                }
            }
        }

        $this->session->set_flashdata('success_msg', 'Contractor successfully Suspended / Banned. Notification sent.');
        redirect('hse_induction/viewContractor/' . $id);
    }
    // <---- New code: Suspend / Ban Contractor Flow End ---->

    
       public function pdfContractor($id = '') {
        $did = decryptval($id);
        
        $emplOptns['where'] = [
            'cont.CONT_AUTO_ID' => $did,
        ];
        $emplOptns['return_type'] = 'row';
        $getEmploydetails = $this->common_model->getAlldata(CONT_DET . ' as cont', ['cont.*'], $emplOptns);
        
        $othercertiDet['where'] = [
            'CERT_USER_ID' => $did,
            'CERT_USER_TYPE' => 'CONT',
            'CERT_COMMON_STATUS' => 'Y',
        ];
        $getOthercertdet = $this->common_model->getAlldata(OTHER_CONT . ' as certi', ['*'], $othercertiDet);
        
        $data = [
            'getEmploydetails' => $getEmploydetails,
            'getOthercertdet' => $getOthercertdet,
        ];
        $html2 = $this->load->view('contractor/pdf_contractor', $data, true);
        $mpdf2 = $this->pdf->ptwload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "contractor";
        $file_path = "assets/uploads/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $file_path . 'Contractor-' . $did . '-' . $currenttime . '.pdf';
        $name = 'Contractor-' . $currenttime . '.pdf';
        $mpdf2->Output($path2, "F");
        $data = file_get_contents($path2);
        force_download($name, $data);
    }


    //  PK Code 

    public function contractor_employees($id = "") {
        $did = decryptval($id);
        if (empty($did) && is_numeric($id)) {
            $did = $id;
        }

        $emplOptns['where'] = [
            'cont.CONT_AUTO_ID' => $did,
        ];
        $emplOptns['return_type'] = 'row';
        $contractor = $this->common_model->getAlldata(CONT_DET . ' as cont', ['cont.*'], $emplOptns);
        if (empty($contractor) && is_numeric($id)) {
            $emplOptns['where'] = ['cont.CONT_AUTO_ID' => $id];
            $contractor = $this->common_model->getAlldata(CONT_DET . ' as cont', ['cont.*'], $emplOptns);
            if (!empty($contractor)) {
                $did = $id;
            }
        }

        if (empty($contractor)) {
            $this->session->set_flashdata('contractor', '<div class="alert alert-danger">Contractor not found.</div>');
            redirect('hse_induction');
        }

        $data = array(
            'view_file' => 'contractor/list_employees',
            'site_title' => 'Contractor Employees',
            'current_menu' => 'Contractor Employees',
            'ajaxurl' => 'hse_induction/list_employees_ajax/' . encryptval($did),
            'contractor' => $contractor,
            'contractor_id' => $did,
        );

        $this->template->load_table_template($data);
    }

    public function list_employees_ajax($id = "") {
        $did = decryptval($id);
        $table = 'hse_contractor_batch';
        $column_order = array(null, 'BATCH_NO', 'CREATED_ON', 'APPROVAL_STATUS', null);
        $column_search = array('BATCH_NO');
        $order = array('BATCH_AUTO_ID' => 'desc');
        $where = [
            'CONT_AUTO_ID' => $did,
            'STATUS' => 'Y'
        ];

        $list = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where);

        $finalDatas = [];
        if (isset($list) && !empty($list)) {
            $sno = $this->input->post('start') + 1;
            foreach ($list as $b) {
                $batchIdEnc = encryptval($b->BATCH_AUTO_ID);
                $appStatus = isset($b->APPROVAL_STATUS) ? (int)$b->APPROVAL_STATUS : 1;

                if ($appStatus == 2) {
                    $statusBadge = '<span class="badge badge-success">Approved</span>';
                } elseif ($appStatus == 3) {
                    $statusBadge = '<span class="badge badge-danger">Rejected</span>';
                } else {
                    $statusBadge = '<span class="badge badge-warning">Pending Approval</span>';
                }

                $action = '';
                // Only show Edit icon if Batch is NOT approved (1=Pending or 3=Rejected)
                if ($appStatus != 2) {
                    $action .= " " . anchor('hse_induction/edit_contractor_batch/' . $batchIdEnc, '<i class="fa fa-edit"></i>', array('title' => 'Edit Batch & Employees'));
                }
                $action .= " " . anchor('hse_induction/view_contractor_batch/' . $batchIdEnc, '<i class="fas fa-eye"></i>', array('title' => 'View Batch & Employees'));
                $action .= " " . anchor('hse_induction/pdf_contractor_batch/' . $batchIdEnc, '<i class="fas fa-file-pdf"></i>', array('title' => 'Export PDF', 'target' => '_blank'));

                $rows = [];
                $rows[] = $sno++;
                $rows[] = '<span class="badge badge-primary font-weight-bold" style="font-size:13px;">' . htmlspecialchars($b->BATCH_NO) . '</span>';
                // Payment and Validity hidden from listing as requested
                // $rows[] = htmlspecialchars($b->PAYMENT);
                // $rows[] = ($b->VALIDITY_DATE && $b->VALIDITY_DATE != '0000-00-00') ? date('d-m-Y', strtotime($b->VALIDITY_DATE)) : '-';
                $rows[] = date('d-m-Y H:i', strtotime($b->CREATED_ON));
                $rows[] = $statusBadge;
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
        echo json_encode($output);
    }

    public function add_contractor_employee($id = "") {
        $did = decryptval($id);

        $emplOptns['where'] = [
            'cont.CONT_AUTO_ID' => $did,
        ];
        $emplOptns['return_type'] = 'row';
        $contractor = $this->common_model->getAlldata(CONT_DET . ' as cont', ['cont.*'], $emplOptns);

        if (empty($contractor)) {
            $this->session->set_flashdata('contractor', '<div class="alert alert-danger">Contractor not found.</div>');
            redirect('hse_induction');
        }

        // Calculate next autoincrement BATCH-X for this contractor
        $batchQuery = $this->db->query("SELECT MAX(CAST(SUBSTRING_INDEX(BATCH_NO, '-', -1) AS UNSIGNED)) as max_batch FROM hse_contractor_batch WHERE CONT_AUTO_ID = " . (int)$did)->row();
        $nextBatchNum = ($batchQuery && $batchQuery->max_batch) ? ((int)$batchQuery->max_batch + 1) : 1;
        $nextBatch = 'BATCH-' . $nextBatchNum;

        // Fetch Nationalities
        $nationalities = $this->common_model->getAlldata(NATION, ['*'], ['where' => ['NATIONALITY_STATUS' => 'Y']]);

        // Fetch Terminals
        $terminals = $this->common_model->getAlldata(TERM, ['*'], ['where' => ['TERMINAL_STATUS' => 'Y']]);

        $data = array(
            'view_file' => 'contractor/add_contractor_employee',
            'site_title' => 'Add Contractor Employee',
            'current_menu' => 'Contractor Employees',
            'contractor' => $contractor,
            'contractor_id' => $did,
            'next_batch' => $nextBatch,
            'nationalities' => $nationalities,
            'terminals' => $terminals,
        );

        $this->template->load_common_template($data);
    }

    public function save_contractor_employee($id = "") {
        $did = decryptval($id);
        $employees = $this->input->post('emp');
        $created_by = $this->session->userdata('user_id');

        $common_batch_no = $this->input->post('common_batch_no');
        $common_payment = $this->input->post('common_payment');
        $common_validity = $this->input->post('common_validity');
        $ack_status = ($this->input->post('ack_status') == 'Y') ? 'Y' : 'N';

        $validity_date = NULL;
        if (!empty($common_validity)) {
            $validity_date = date('Y-m-d', strtotime($common_validity));
        }

        if (empty($employees) || !is_array($employees)) {
            $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">No employee data received.</div>');
            redirect('hse_induction/contractor_employees/' . encryptval($did));
        }

        $upload_dir = 'assets/uploads/hse_induction/employees/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $config['upload_path'] = $upload_dir;
        $config['allowed_types'] = '*';
        $config['max_size'] = 51200; // 50MB
        $this->load->library('upload');

        $insertedCount = 0;

        // First insert Batch Log record into hse_contractor_batch
        $batchData = array(
            'CONT_AUTO_ID' => $did,
            'BATCH_NO' => !empty($common_batch_no) ? $common_batch_no : 'BATCH-1',
            'PAYMENT' => $common_payment,
            'VALIDITY_DATE' => $validity_date,
            'TOTAL_EMPLOYEES' => 0,
            'APPROVAL_STATUS' => 1,
            'ACK_STATUS' => $ack_status,
            'STATUS' => 'Y',
            'CREATED_BY' => $created_by,
            'CREATED_ON' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('hse_contractor_batch', $batchData);
        $batchAutoId = $this->db->insert_id();

        foreach ($employees as $idx => $emp) {
            if (empty($emp['emp_name'])) {
                continue;
            }

            // Single file upload helper
            $passport_ic = $this->_do_upload('passport_ic_' . $idx, $config);
            $photo = $this->_do_upload('photo_' . $idx, $config);
            $work_permit = $this->_do_upload('work_permit_' . $idx, $config);

            // Competency cert single uploads
            $cert_forklift = $this->_do_upload('cert_forklift_' . $idx, $config);
            $cert_crane = $this->_do_upload('cert_crane_' . $idx, $config);
            $cert_agtes = $this->_do_upload('cert_agtes_' . $idx, $config);
            $cert_aesp = $this->_do_upload('cert_aesp_' . $idx, $config);
            $cert_scaffolder = $this->_do_upload('cert_scaffolder_' . $idx, $config);

            // Multiple uploads: Others
            $others_docs = $this->_do_multi_upload('others_' . $idx, $config);
            // Multiple uploads: Other Competency Documents
            $cert_other = $this->_do_multi_upload('cert_other_' . $idx, $config);

            // Terminals
            $terminals_str = !empty($emp['terminals']) ? $emp['terminals'] : '';

            $dob_val = !empty($emp['dob']) ? date('Y-m-d', strtotime($emp['dob'])) : NULL;

            $insertData = array(
                'CONT_AUTO_ID' => $did,
                'BATCH_AUTO_ID' => $batchAutoId,
                'BATCH_NO' => !empty($common_batch_no) ? $common_batch_no : 'BATCH-1',
                'EMP_NAME' => $emp['emp_name'],
                'EMP_EMAIL' => !empty($emp['email']) ? $emp['email'] : NULL,
                'EMP_PHONE' => !empty($emp['phone']) ? $emp['phone'] : NULL,
                'ID_TYPE' => !empty($emp['id_type']) ? $emp['id_type'] : 'NRIC',
                'ID_NUMBER' => !empty($emp['id_number']) ? $emp['id_number'] : NULL,
                'GENDER' => !empty($emp['gender']) ? $emp['gender'] : NULL,
                'DOB' => $dob_val,
                'DESIGNATION' => !empty($emp['designation']) ? $emp['designation'] : NULL,
                'NATIONALITY_ID' => !empty($emp['nationality']) ? $emp['nationality'] : NULL,
                'NATIONALITY_OTHER' => !empty($emp['nationality_other']) ? $emp['nationality_other'] : NULL,
                'RELIGION' => !empty($emp['religion']) ? $emp['religion'] : NULL,
                'RACE' => !empty($emp['race']) ? $emp['race'] : NULL,
                'MARITAL_STATUS' => !empty($emp['marital_status']) ? $emp['marital_status'] : NULL,
                'WORK_EXPERIENCE' => !empty($emp['work_experience']) ? $emp['work_experience'] : NULL,
                'EMERGENCY_NAME' => !empty($emp['emergency_name']) ? $emp['emergency_name'] : NULL,
                'EMERGENCY_RELATIONSHIP' => !empty($emp['emergency_relationship']) ? $emp['emergency_relationship'] : NULL,
                'EMERGENCY_PHONE' => !empty($emp['emergency_phone']) ? $emp['emergency_phone'] : NULL,
                'EMERGENCY_ADDRESS' => !empty($emp['emergency_address']) ? $emp['emergency_address'] : NULL,
                'TERMINALS' => $terminals_str,
                'PASSPORT_IC_FILE' => $passport_ic,
                'PHOTO_FILE' => $photo,
                'OTHER_DOCS' => !empty($others_docs) ? json_encode($others_docs) : NULL,
                'CERT_FORKLIFT' => $cert_forklift,
                'CERT_CRANE' => $cert_crane,
                'CERT_AGTES' => $cert_agtes,
                'CERT_AESP' => $cert_aesp,
                'CERT_SCAFFOLDER' => $cert_scaffolder,
                'CERT_OTHER' => !empty($cert_other) ? json_encode($cert_other) : NULL,
                'WORK_PERMIT_FILE' => $work_permit,
                'PAYMENT' => $common_payment,
                'VALIDITY_DATE' => $validity_date,
                'APPROVAL_STATUS' => 1,
                'ACK_STATUS' => $ack_status,
                'STATUS' => 'Y',
                'CREATED_BY' => $created_by,
                'CREATED_ON' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('hse_contractor_employee', $insertData);
            $insertedEmpId = $this->db->insert_id();

            // Insert into Employee Log table
            $logData = $insertData;
            $logData['ACTION_TYPE'] = 'ADD';
            $logData['EMP_AUTO_ID'] = $insertedEmpId;
            $logData['LOGGED_BY'] = $created_by;
            $logData['LOGGED_ON'] = date('Y-m-d H:i:s');
            unset($logData['CREATED_BY'], $logData['CREATED_ON']);
            $this->db->insert('hse_contractor_employee_log', $logData);

            $insertedCount++;
        }

        // Update total employees in batch
        $this->db->update('hse_contractor_batch', ['TOTAL_EMPLOYEES' => $insertedCount], ['BATCH_AUTO_ID' => $batchAutoId]);

        // Send In-App & Email Notification to Super Admin (1), Admin (2), and HSSE Roles (6, 7)
        $contractor = $this->db->get_where(CONT_DET, ['CONT_AUTO_ID' => $did])->row();
        $compName = $contractor ? $contractor->CONT_COMPANY : '';
        $contIdCode = $contractor ? $contractor->CONT_ID : '';
        $batchEncId = encryptval($batchAutoId);

        $adminUsers = $this->db->select('l.LOGIN_ID, em.EMP_EMAIL_ID, em.EMP_NAME')
                               ->from(LOGIN . ' l')
                               ->join('employee_management em', 'em.EMP_AUTO_ID = l.USER_REF_ID', 'left')
                               ->where_in('l.USER_TYPE_ID', [1, 2, 6, 7])
                               ->where('l.USER_LOG_STATUS', 'Y')
                               ->get()->result_array();

        $adminLoginIds = !empty($adminUsers) ? implode(',', array_filter(array_column($adminUsers, 'LOGIN_ID'))) : '3';

        $notifyDesc = 'New Contractor Employee Batch Submitted (<b>' . htmlspecialchars($common_batch_no) . '</b>):<br/><br/>' .
                      '<b>Company:</b> ' . htmlspecialchars($compName) . ' (' . htmlspecialchars($contIdCode) . ')<br/>' .
                      '<b>Total Employees:</b> ' . $insertedCount . '<br/>' .
                      '<b>Status:</b> <span class="badge badge-warning">Pending Approval</span>';

        $maxNoti = $this->db->select_max('NOTIFICATION_ID', 'max_id')->get(NOTI)->row();
        $nextNotiId = (!empty($maxNoti->max_id)) ? ((int)$maxNoti->max_id + 1) : 1;

        $notifyData = [
            'NOTIFICATION_ID' => $nextNotiId,
            'NOTIFICATION_DESC' => $notifyDesc,
            'NOTIFICATION_TYPE' => '1',
            'NOTIFICATION_GROUP_CATID' => '1',
            'NOTIFICATION_EMPLOYEE_ID' => $adminLoginIds,
            'NOTIFICATION_HREF' => 'hse_induction/view_contractor_batch/' . $batchEncId,
            'NOTIFICATION_MOBILE_LINK' => '',
            'NOTIFICATION_TASK_TYPE' => 'CONTRACTOR_BATCH',
            'NOTIFICATION_IS_PUBLIC' => 1,
            'NOTIFICATION_STATUS' => 'Y',
            'CREATED_ON' => date('Y-m-d H:i:s'),
            'UPDATED_ON' => date('Y-m-d H:i:s')
        ];
        $this->db->insert(NOTI, $notifyData);

        if (!empty($adminUsers)) {
            foreach ($adminUsers as $adm) {
                if (!empty($adm['EMP_EMAIL_ID'])) {
                    $admMailData = [
                        'emplmailID' => $adm['EMP_EMAIL_ID'],
                        'emplName' => !empty($adm['EMP_NAME']) ? $adm['EMP_NAME'] : 'Administrator',
                        'messageText' => "Hello Administrator / HSSE Team,<br><br>A new Contractor Employee Batch (<b>" . htmlspecialchars($common_batch_no) . "</b>) with <b>" . $insertedCount . "</b> employee(s) has been submitted for company <b>" . htmlspecialchars($compName) . "</b> (ID: <b>" . htmlspecialchars($contIdCode) . "</b>).<br><br><b>Status:</b> Pending Approval<br><br><a href='" . BASE_URL . "hse_induction/view_contractor_batch/" . $batchEncId . "' target='_blank'>Click here to view and approve/reject batch</a><br><br>Thanks & Regards,<br><b>Lumut Port HSSE Team</b>",
                        'subject' => 'LUMUT PORT - NEW CONTRACTOR EMPLOYEE BATCH PENDING APPROVAL: ' . $compName,
                        'mainModule' => 'masterMod'
                    ];
                    internalNotificationOverall($admMailData);
                }
            }
        }

        $this->session->set_flashdata('employee_msg', '<div class="alert alert-success">Batch ' . htmlspecialchars($common_batch_no) . ' with ' . $insertedCount . ' Contractor Employee(s) added successfully! Status: Pending Approval.</div>');
        redirect('hse_induction/contractor_employees/' . encryptval($did));
    }

    private function _do_upload($field_name, $config) {
        if (!isset($_FILES[$field_name]) || empty($_FILES[$field_name]['name'])) {
            return NULL;
        }
        $raw_name = $_FILES[$field_name]['name'];
        $clean_name = time() . '_' . rand(100, 999) . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $raw_name);
        $config['file_name'] = $clean_name;
        $this->upload->initialize($config);
        if ($this->upload->do_upload($field_name)) {
            $data = $this->upload->data();
            return $config['upload_path'] . $data['file_name'];
        }

        // Direct move fallback if CI upload validation rejects MIME or extension
        if (isset($_FILES[$field_name]['tmp_name']) && is_uploaded_file($_FILES[$field_name]['tmp_name'])) {
            $target = rtrim($config['upload_path'], '/') . '/' . $clean_name;
            if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $target)) {
                return $target;
            }
        }
        return NULL;
    }

    private function _do_multi_upload($field_name, $config) {
        $files = [];
        if (!isset($_FILES[$field_name]) || empty($_FILES[$field_name]['name']) || !is_array($_FILES[$field_name]['name'])) {
            return $files;
        }
        $count = count($_FILES[$field_name]['name']);
        for ($i = 0; $i < $count; $i++) {
            if (empty($_FILES[$field_name]['name'][$i])) continue;

            $raw_name = $_FILES[$field_name]['name'][$i];
            $clean_name = time() . '_' . $i . '_' . rand(100, 999) . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $raw_name);

            $_FILES['single_file']['name'] = $raw_name;
            $_FILES['single_file']['type'] = $_FILES[$field_name]['type'][$i];
            $_FILES['single_file']['tmp_name'] = $_FILES[$field_name]['tmp_name'][$i];
            $_FILES['single_file']['error'] = $_FILES[$field_name]['error'][$i];
            $_FILES['single_file']['size'] = $_FILES[$field_name]['size'][$i];

            $config['file_name'] = $clean_name;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('single_file')) {
                $data = $this->upload->data();
                $files[] = $config['upload_path'] . $data['file_name'];
            } elseif (isset($_FILES[$field_name]['tmp_name'][$i]) && is_uploaded_file($_FILES[$field_name]['tmp_name'][$i])) {
                // Direct fallback
                $target = rtrim($config['upload_path'], '/') . '/' . $clean_name;
                if (move_uploaded_file($_FILES[$field_name]['tmp_name'][$i], $target)) {
                    $files[] = $target;
                }
            }
        }
        return $files;
    }
        private function get_batch_by_param($batch_id_or_enc) {
        $batch = null;
        $batchAutoId = decryptval($batch_id_or_enc);
        if ($batchAutoId) {
            $batch = $this->db->get_where('hse_contractor_batch', ['BATCH_AUTO_ID' => $batchAutoId])->row();
        }
        if (empty($batch) && is_numeric($batch_id_or_enc)) {
            $batch = $this->db->get_where('hse_contractor_batch', ['BATCH_AUTO_ID' => $batch_id_or_enc])->row();
        }
        return $batch;
    }

    public function edit_contractor_batch($batch_id = "") {
        $batch = $this->get_batch_by_param($batch_id);
        // if (empty($batch)) {
        //     $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Batch not found.</div>');
        //     redirect('hse_induction');
        // }
        $batchAutoId = $batch->BATCH_AUTO_ID;

        $did = $batch->CONT_AUTO_ID;
        $contractor = $this->db->get_where(CONT_DET, ['CONT_AUTO_ID' => $did])->row();

        // Fetch employees under this batch
        $employees = $this->db->get_where('hse_contractor_employee', ['BATCH_AUTO_ID' => $batchAutoId, 'STATUS' => 'Y'])->result();
        if (empty($employees)) {
            // fallback by BATCH_NO & CONT_AUTO_ID
            $employees = $this->db->get_where('hse_contractor_employee', ['CONT_AUTO_ID' => $did, 'BATCH_NO' => $batch->BATCH_NO, 'STATUS' => 'Y'])->result();
        }

        // Fetch Nationalities & Terminals
        $nationalities = $this->common_model->getAlldata(NATION, ['*'], ['where' => ['NATIONALITY_STATUS' => 'Y']]);
        $terminals = $this->common_model->getAlldata(TERM, ['*'], ['where' => ['TERMINAL_STATUS' => 'Y']]);

        $data = array(
            'view_file' => 'contractor/edit_contractor_batch',
            'site_title' => 'Edit Contractor Batch - ' . $batch->BATCH_NO,
            'current_menu' => 'Contractor Employees',
            'contractor' => $contractor,
            'contractor_id' => $did,
            'batch' => $batch,
            'employees' => $employees,
            'nationalities' => $nationalities,
            'terminals' => $terminals,
        );

        $this->template->load_common_template($data);
    }

    public function update_contractor_batch($batch_id = "") {
        $batch = $this->get_batch_by_param($batch_id);
        // if (empty($batch)) {
        //     $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Batch not found.</div>');
        //     redirect('hse_induction');
        // }
        $batchAutoId = $batch->BATCH_AUTO_ID;

        $did = $batch->CONT_AUTO_ID;
        $employees = $this->input->post('emp');
        $created_by = $this->session->userdata('user_id');

        $common_batch_no = $batch->BATCH_NO;
        $common_payment = $this->input->post('common_payment');
        $common_validity = $this->input->post('common_validity');
        $validity_date = !empty($common_validity) ? date('Y-m-d', strtotime($common_validity)) : NULL;

        $upload_dir = 'assets/uploads/hse_induction/employees/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $config['upload_path'] = $upload_dir;
        $config['allowed_types'] = '*';
        $config['max_size'] = 51200; // 50MB
        $this->load->library('upload');

        $activeEmpIds = [];
        $savedCount = 0;

        if (!empty($employees) && is_array($employees)) {
            foreach ($employees as $idx => $emp) {
                if (empty($emp['emp_name'])) continue;

                $empAutoId = !empty($emp['emp_auto_id']) ? (int)$emp['emp_auto_id'] : 0;
                $existingEmp = ($empAutoId > 0) ? $this->db->get_where('hse_contractor_employee', ['EMP_AUTO_ID' => $empAutoId])->row() : null;

                // File uploads (keep existing if no new upload)
                $passport_ic = $this->_do_upload('passport_ic_' . $idx, $config);
                if (!$passport_ic && $existingEmp) $passport_ic = $existingEmp->PASSPORT_IC_FILE;

                $photo = $this->_do_upload('photo_' . $idx, $config);
                if (!$photo && $existingEmp) $photo = $existingEmp->PHOTO_FILE;

                $work_permit = $this->_do_upload('work_permit_' . $idx, $config);
                if (!$work_permit && $existingEmp) $work_permit = $existingEmp->WORK_PERMIT_FILE;

                $cert_forklift = $this->_do_upload('cert_forklift_' . $idx, $config);
                if (!$cert_forklift && $existingEmp) $cert_forklift = $existingEmp->CERT_FORKLIFT;

                $cert_crane = $this->_do_upload('cert_crane_' . $idx, $config);
                if (!$cert_crane && $existingEmp) $cert_crane = $existingEmp->CERT_CRANE;

                $cert_agtes = $this->_do_upload('cert_agtes_' . $idx, $config);
                if (!$cert_agtes && $existingEmp) $cert_agtes = $existingEmp->CERT_AGTES;

                $cert_aesp = $this->_do_upload('cert_aesp_' . $idx, $config);
                if (!$cert_aesp && $existingEmp) $cert_aesp = $existingEmp->CERT_AESP;

                $cert_scaffolder = $this->_do_upload('cert_scaffolder_' . $idx, $config);
                if (!$cert_scaffolder && $existingEmp) $cert_scaffolder = $existingEmp->CERT_SCAFFOLDER;

                // Multi uploads: check retained existing files + append newly uploaded files
                $retained_others = isset($emp['existing_others']) && is_array($emp['existing_others']) ? $emp['existing_others'] : [];
                $new_others = $this->_do_multi_upload('others_' . $idx, $config);
                // If existing_others inputs weren't submitted (e.g. legacy/direct), fallback to existingEmp
                if (!isset($emp['existing_others']) && $existingEmp && !empty($existingEmp->OTHER_DOCS)) {
                    $fallback = json_decode($existingEmp->OTHER_DOCS, true);
                    if (is_array($fallback)) $retained_others = $fallback;
                }
                $all_others = array_values(array_filter(array_merge($retained_others, $new_others)));

                $retained_cert_other = isset($emp['existing_cert_other']) && is_array($emp['existing_cert_other']) ? $emp['existing_cert_other'] : [];
                $new_cert_other = $this->_do_multi_upload('cert_other_' . $idx, $config);
                if (!isset($emp['existing_cert_other']) && $existingEmp && !empty($existingEmp->CERT_OTHER)) {
                    $fallback = json_decode($existingEmp->CERT_OTHER, true);
                    if (is_array($fallback)) $retained_cert_other = $fallback;
                }
                $all_cert_other = array_values(array_filter(array_merge($retained_cert_other, $new_cert_other)));

                $terminals_str = !empty($emp['terminals']) ? $emp['terminals'] : '';

                $dob_val = !empty($emp['dob']) ? date('Y-m-d', strtotime($emp['dob'])) : NULL;

                $empData = array(
                    'CONT_AUTO_ID' => $did,
                    'BATCH_AUTO_ID' => $batchAutoId,
                    'BATCH_NO' => $common_batch_no,
                    'EMP_NAME' => $emp['emp_name'],
                    'EMP_EMAIL' => !empty($emp['email']) ? $emp['email'] : NULL,
                    'EMP_PHONE' => !empty($emp['phone']) ? $emp['phone'] : NULL,
                    'ID_TYPE' => !empty($emp['id_type']) ? $emp['id_type'] : 'NRIC',
                    'ID_NUMBER' => !empty($emp['id_number']) ? $emp['id_number'] : NULL,
                    'GENDER' => !empty($emp['gender']) ? $emp['gender'] : NULL,
                    'DOB' => $dob_val,
                    'DESIGNATION' => !empty($emp['designation']) ? $emp['designation'] : NULL,
                    'NATIONALITY_ID' => !empty($emp['nationality']) ? $emp['nationality'] : NULL,
                    'NATIONALITY_OTHER' => !empty($emp['nationality_other']) ? $emp['nationality_other'] : NULL,
                    'RELIGION' => !empty($emp['religion']) ? $emp['religion'] : NULL,
                    'RACE' => !empty($emp['race']) ? $emp['race'] : NULL,
                    'MARITAL_STATUS' => !empty($emp['marital_status']) ? $emp['marital_status'] : NULL,
                    'WORK_EXPERIENCE' => !empty($emp['work_experience']) ? $emp['work_experience'] : NULL,
                    'EMERGENCY_NAME' => !empty($emp['emergency_name']) ? $emp['emergency_name'] : NULL,
                    'EMERGENCY_RELATIONSHIP' => !empty($emp['emergency_relationship']) ? $emp['emergency_relationship'] : NULL,
                    'EMERGENCY_PHONE' => !empty($emp['emergency_phone']) ? $emp['emergency_phone'] : NULL,
                    'EMERGENCY_ADDRESS' => !empty($emp['emergency_address']) ? $emp['emergency_address'] : NULL,
                    'TERMINALS' => $terminals_str,
                    'PASSPORT_IC_FILE' => $passport_ic,
                    'PHOTO_FILE' => $photo,
                    'OTHER_DOCS' => !empty($all_others) ? json_encode($all_others) : NULL,
                    'CERT_FORKLIFT' => $cert_forklift,
                    'CERT_CRANE' => $cert_crane,
                    'CERT_AGTES' => $cert_agtes,
                    'CERT_AESP' => $cert_aesp,
                    'CERT_SCAFFOLDER' => $cert_scaffolder,
                    'CERT_OTHER' => !empty($all_cert_other) ? json_encode($all_cert_other) : NULL,
                    'WORK_PERMIT_FILE' => $work_permit,
                    'PAYMENT' => $common_payment,
                    'VALIDITY_DATE' => $validity_date,
                    'STATUS' => 'Y',
                );

                $targetEmpId = null;
                $actionType = 'ADD';
                if ($empAutoId > 0 && $existingEmp) {
                    $this->db->update('hse_contractor_employee', $empData, ['EMP_AUTO_ID' => $empAutoId]);
                    $activeEmpIds[] = $empAutoId;
                    $targetEmpId = $empAutoId;
                    $actionType = 'EDIT';
                } else {
                    $empData['CREATED_BY'] = $created_by;
                    $empData['CREATED_ON'] = date('Y-m-d H:i:s');
                    $this->db->insert('hse_contractor_employee', $empData);
                    $targetEmpId = $this->db->insert_id();
                    $activeEmpIds[] = $targetEmpId;
                    $actionType = 'ADD';
                }

                // Insert full snapshot log into hse_contractor_employee_log
                $logData = $empData;
                $logData['ACTION_TYPE'] = $actionType;
                $logData['EMP_AUTO_ID'] = $targetEmpId;
                $logData['LOGGED_BY'] = $created_by;
                $logData['LOGGED_ON'] = date('Y-m-d H:i:s');
                unset($logData['CREATED_BY'], $logData['CREATED_ON']);
                $this->db->insert('hse_contractor_employee_log', $logData);

                $savedCount++;
            }
        }

        // Soft-delete removed employees from this batch
        if (!empty($activeEmpIds)) {
            $this->db->where('BATCH_AUTO_ID', $batchAutoId);
            $this->db->where_not_in('EMP_AUTO_ID', $activeEmpIds);
            $this->db->update('hse_contractor_employee', ['STATUS' => 'N']);
        }

        // Update Batch header
        $this->db->update('hse_contractor_batch', [
            'PAYMENT' => $common_payment,
            'VALIDITY_DATE' => $validity_date,
            'TOTAL_EMPLOYEES' => $savedCount,
            'UPDATED_ON' => date('Y-m-d H:i:s')
        ], ['BATCH_AUTO_ID' => $batchAutoId]);

        $this->session->set_flashdata('employee_msg', '<div class="alert alert-success">Batch ' . htmlspecialchars($common_batch_no) . ' updated successfully with ' . $savedCount . ' Employee(s)!</div>');
        redirect('hse_induction/contractor_employees/' . encryptval($did));
    }

    public function view_contractor_batch($batch_id = "") {
        $batch = $this->get_batch_by_param($batch_id);
        // if (empty($batch)) {
        //     $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Batch not found.</div>');
        //     redirect('hse_induction');
        // }
        $batchAutoId = $batch->BATCH_AUTO_ID;

        $did = $batch->CONT_AUTO_ID;
        $contractor = $this->db->get_where(CONT_DET, ['CONT_AUTO_ID' => $did])->row();
        $employees = $this->db->get_where('hse_contractor_employee', ['BATCH_AUTO_ID' => $batchAutoId, 'STATUS' => 'Y'])->result();
        if (empty($employees)) {
            $employees = $this->db->get_where('hse_contractor_employee', ['CONT_AUTO_ID' => $did, 'BATCH_NO' => $batch->BATCH_NO, 'STATUS' => 'Y'])->result();
        }

        $nationalities = $this->common_model->getAlldata(NATION, ['*'], ['where' => ['NATIONALITY_STATUS' => 'Y']]);
        $nat_map = [];
        if (!empty($nationalities)) {
            foreach ($nationalities as $n) {
                $nat_map[$n->NATIONALITY_ID] = $n->NATIONALITY_NAME;
            }
        }

        $data = array(
            'view_file' => 'contractor/view_contractor_batch',
            'site_title' => 'View Batch - ' . $batch->BATCH_NO,
            'current_menu' => 'Contractor Employees',
            'contractor' => $contractor,
            'contractor_id' => $did,
            'batch' => $batch,
            'employees' => $employees,
            'nat_map' => $nat_map,
        );

        $this->template->load_common_template($data);
    }

    public function pdf_contractor_batch($batch_id = "") {
        $batch = $this->get_batch_by_param($batch_id);
        // if (empty($batch)) {
        //     $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Batch not found.</div>');
        //     redirect('hse_induction');
        // }
        $batchAutoId = $batch->BATCH_AUTO_ID;

        $did = $batch->CONT_AUTO_ID;
        $contractor = $this->db->get_where(CONT_DET, ['CONT_AUTO_ID' => $did])->row();
        $employees = $this->db->get_where('hse_contractor_employee', ['BATCH_AUTO_ID' => $batchAutoId, 'STATUS' => 'Y'])->result();
        if (empty($employees)) {
            $employees = $this->db->get_where('hse_contractor_employee', ['CONT_AUTO_ID' => $did, 'BATCH_NO' => $batch->BATCH_NO, 'STATUS' => 'Y'])->result();
        }

        $nationalities = $this->common_model->getAlldata(NATION, ['*'], ['where' => ['NATIONALITY_STATUS' => 'Y']]);
        $nat_map = [];
        if (!empty($nationalities)) {
            foreach ($nationalities as $n) {
                $nat_map[$n->NATIONALITY_ID] = $n->NATIONALITY_NAME;
            }
        }

        $data = array(
            'contractor' => $contractor,
            'batch' => $batch,
            'employees' => $employees,
            'nat_map' => $nat_map,
        );

        $html = $this->load->view('contractor/pdf_contractor_batch', $data, true);
        $mpdf = $this->pdf->ptwload();
        $mpdf->WriteHTML($html);

        $folder_path = "assets/uploads/hse_induction/batch_pdf/";
        if (!file_exists($folder_path)) {
            mkdir($folder_path, 0777, true);
        }

        $file_name = 'Batch-' . $batch->BATCH_NO . '-' . date('d-m-Y') . '.pdf';
        $file_full_path = $folder_path . $file_name;
        $mpdf->Output($file_full_path, "F");

        $pdf_content = file_get_contents($file_full_path);
        force_download($file_name, $pdf_content);
    }

    // <---- New code: Approve Contractor Batch Flow Start ---->
    public function approve_contractor_batch($batch_id = '') {
        $batch = $this->get_batch_by_param($batch_id);
        if (empty($batch)) {
            $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Batch not found.</div>');
            redirect('hse_induction');
        }

        $batchAutoId = $batch->BATCH_AUTO_ID;
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type_id');

        // Update batch status to Approved (2)
        $this->db->update('hse_contractor_batch', [
            'APPROVAL_STATUS' => 2,
            'REJECT_REASON' => NULL,
            'ACTION_BY' => $user_id,
            'ACTION_ON' => date('Y-m-d H:i:s')
        ], ['BATCH_AUTO_ID' => $batchAutoId]);

        // Update all employees in this batch
        $this->db->update('hse_contractor_employee', [
            'APPROVAL_STATUS' => 2
        ], ['BATCH_AUTO_ID' => $batchAutoId]);

        // Contractor details for email
        $contractor = $this->db->get_where(CONT_DET, ['CONT_AUTO_ID' => $batch->CONT_AUTO_ID])->row();
        $toMail = !empty($contractor->CONT_EMAIL_ID) ? $contractor->CONT_EMAIL_ID : $contractor->CONT_COMP_EMAIL;
        $contName = !empty($contractor->CONT_NAME) ? $contractor->CONT_NAME : $contractor->CONT_COMPANY;

        $emailMsg = "Dear <b>" . $contName . "</b>,<br><br>" .
                    "Your Contractor Employee Batch <b>" . htmlspecialchars($batch->BATCH_NO) . "</b> (Total: " . $batch->TOTAL_EMPLOYEES . " employees) for company <b>" . htmlspecialchars($contractor->CONT_COMPANY) . "</b> has been <b style='color:#15803d;'>APPROVED</b> by Lumut Port HSSE Team.<br><br>" .
                    "The inducted personnel are now eligible for operations subject to port safety regulations.<br><br>" .
                    "Thanks & Regards,<br>" .
                    "<b>Lumut Port HSSE Team</b><br>" .
                    "<small>This is a system generated email, please do not reply.</small>";

        $idata = [
            'emplmailID' => $toMail,
            'emplName' => $contName,
            'messageText' => $emailMsg,
            'subject' => 'LUMUT PORT - CONTRACTOR BATCH APPROVED: ' . $batch->BATCH_NO,
            'mainModule' => 'masterMod'
        ];
        internalNotificationOverall($idata);

        $this->session->set_flashdata('employee_msg', '<div class="alert alert-success">Batch ' . htmlspecialchars($batch->BATCH_NO) . ' has been APPROVED successfully!</div>');
        redirect('hse_induction/view_contractor_batch/' . $batch_id);
    }

    // <---- New code: Reject Contractor Batch Flow Start ---->
    public function reject_contractor_batch($batch_id = '') {
        $batch = $this->get_batch_by_param($batch_id);
        if (empty($batch)) {
            $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Batch not found.</div>');
            redirect('hse_induction');
        }

        $batchAutoId = $batch->BATCH_AUTO_ID;
        $reason = $this->input->post('reject_reason');
        $user_id = $this->session->userdata('user_id');

        if (empty($reason)) {
            $this->session->set_flashdata('employee_msg', '<div class="alert alert-danger">Rejection reason is required.</div>');
            redirect('hse_induction/view_contractor_batch/' . $batch_id);
        }

        // Update batch status to Rejected (3)
        $this->db->update('hse_contractor_batch', [
            'APPROVAL_STATUS' => 3,
            'REJECT_REASON' => $reason,
            'ACTION_BY' => $user_id,
            'ACTION_ON' => date('Y-m-d H:i:s')
        ], ['BATCH_AUTO_ID' => $batchAutoId]);

        // Update all employees in this batch
        $this->db->update('hse_contractor_employee', [
            'APPROVAL_STATUS' => 3
        ], ['BATCH_AUTO_ID' => $batchAutoId]);

        // Contractor details for email
        $contractor = $this->db->get_where(CONT_DET, ['CONT_AUTO_ID' => $batch->CONT_AUTO_ID])->row();
        $toMail = !empty($contractor->CONT_EMAIL_ID) ? $contractor->CONT_EMAIL_ID : $contractor->CONT_COMP_EMAIL;
        $contName = !empty($contractor->CONT_NAME) ? $contractor->CONT_NAME : $contractor->CONT_COMPANY;

        $emailMsg = "Dear <b>" . $contName . "</b>,<br><br>" .
                    "Your Contractor Employee Batch <b>" . htmlspecialchars($batch->BATCH_NO) . "</b> for company <b>" . htmlspecialchars($contractor->CONT_COMPANY) . "</b> has been <b style='color:#dc2626;'>REJECTED</b> by Lumut Port HSSE Team.<br><br>" .
                    "<b>Reason for Rejection:</b><br>" .
                    "<blockquote style='background:#fdf2f2; border-left:4px solid #dc2626; padding:10px 15px; margin:10px 0;'>" .
                    nl2br(htmlspecialchars($reason)) .
                    "</blockquote><br>" .
                    "Please login to the portal and update the batch / upload valid documents to re-submit for approval.<br><br>" .
                    "Thanks & Regards,<br>" .
                    "<b>Lumut Port HSSE Team</b><br>" .
                    "<small>This is a system generated email, please do not reply.</small>";

        $idata = [
            'emplmailID' => $toMail,
            'emplName' => $contName,
            'messageText' => $emailMsg,
            'subject' => 'LUMUT PORT - CONTRACTOR BATCH REJECTED: ' . $batch->BATCH_NO,
            'mainModule' => 'masterMod'
        ];
        internalNotificationOverall($idata);

        $this->session->set_flashdata('employee_msg', '<div class="alert alert-warning">Batch ' . htmlspecialchars($batch->BATCH_NO) . ' has been REJECTED. Contractor notified.</div>');
        redirect('hse_induction/view_contractor_batch/' . $batch_id);
    }
}
// <---- New code: HSE Induction Module Controller End ---->
