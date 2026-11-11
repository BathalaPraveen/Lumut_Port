<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Psa_report extends CI_Controller {

    function __construct() {
        parent::__construct();
        isLogin();
        $this->load->helper('exp_excel_helper');
    }

    public function psa_guard() {
        $ic_no = $this->input->post('ic_no');
        $name = $this->input->post('name');
         $stat = $this->input->post('stat');
       $frmdate = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $icwhr['where'] = [
            'VEC_STATUS' => 'Y'
        ];
        $terNamedatas = $this->common_model->getAlldata(PR_SEC, ['*'], $icwhr);
        if (is_array($terNamedatas)) {
            $getNamedatas = customFormDropDown($terNamedatas, 'AUTO_ID', 'NAME', 'Select Name');
            $getIcdatas = customFormDropDown($terNamedatas, 'AUTO_ID', 'PASS_NO', 'Select IC/Passport No');
        }

        $user_type = getCurrentUserGroupId();

        $data = array(
            'view_file' => 'psa/psa_guard/list_form',
            'site_title' => 'Port Security Access',
            'current_menu' => 'List Port Security Access',
            'ajaxurl' => 'psa/psa_report/list_psa_guard?ic_no=' . $ic_no . '&name=' . $name. '&stat=' . $stat . '&from_date=' . $frmdate . '&to_date=' . $to_date,
            'getNamedatas' => $getNamedatas,
            'getIcdatas' => $getIcdatas,
            'ic_no' => $ic_no,
            'name' => $name,
            'stat' => $stat,
            'frmdate'=>$frmdate,
            'to_date'=>$to_date,
            'user_type' => $user_type,
        );

        $this->template->load_table_template($data);
    }

   public function list_psa_guard() {
        $user_type = getCurrentUserGroupId();
       // print_r($user_type);

        $ic_no = $this->input->get('ic_no');
        $name = $this->input->get('name');
         $stat = $this->input->get('stat');
        $frmdate = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        //$where = ['p.VEC_STATUS' => 'Y'];
        if ($ic_no != '') {
                 $where['p.AUTO_ID'] = $ic_no;
        }
        if ($name != '') {
           
                 $where['p.AUTO_ID'] = $name;
        }
        if ($stat != '') {
            if($stat == 1){
                $currentDate = date("Y-m-d");
                
                $where['date(p.IND_DUE_DATE) <'] = $currentDate;
               
            }else if($stat == 2){
                $currentDate = date("Y-m-d");

                $where['date(p.IND_DUE_DATE) >='] = $currentDate;
                
               
            }
            
        }
            if($frmdate != '') {
           $where['p.CREATED_ON >='] = converttoDBDate($frmdate,'Y-m-d');
        }
        if($to_date != '') {
            $where['p.CREATED_ON <='] = converttoDBDate($to_date,'Y-m-d');
        }

        

        
        
        $table = PR_SEC . ' as p';
        $column_order = array('PORT_UNQ_ID', 'NAME', 'PASS_NO', 'COMP_NAME', 'TERMINAL_NAME','ACK_BY' ,null);
        $column_search = array('PORT_UNQ_ID', 'NAME', 'PASS_NO', 'COMP_NAME', 'TERMINAL_NAME','ACK_BY');
        $order = array('p.AUTO_ID' => 'desc');

        $optns['select'] = 'p.*,t.TERMINAL_NAME,c.CERT_COMMON_STATUS,c.CERT_END_DATE';
        $optns['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = p.TERMIN_ID', 'left'];
        $optns['join'][PSA_CERTI . ' as c'] = ['c.CERT_PORT_ACCESS_ID = p.AUTO_ID', 'left'];

$optns['group_by'] = ['p.AUTO_ID'];

        if( ($user_type != 1 )){
           // echo "DFgdf";
            $currentDate = date("Y-m-d");
          //  $where['c.CERT_END_DATE >= '] = $currentDate;
            $where['date(p.IND_DUE_DATE) >='] = $currentDate;
            $where['p.VEC_STATUS'] = 'Y';
          
        }else{
            $where['p.VEC_STATUS'] = 'Y';
        }


        
        $listResp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $optns);
     //   echo $this->db->last_query();exit; 
       // echo '<pre>';
       // print_r($listResp);
       // exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listResp) && !empty($listResp)) {
            foreach ($listResp as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->AUTO_ID);

                $action .= " " . anchor('psa/psa_report/add_psa_guard/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));
                $action .= " " . anchor('psa/psa_report/view_report/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'View'));
                $action .= " " . anchor('psa/psa_report/print_pdf/' . $id, '<i class="fas fa-file-pdf"></i>', array('class' => '', 'title' => 'pdf'));

               $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deletepsa', 'title' => 'Delete', 'delt-id' => $id));
            //    $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

                $rows = [];
                $rows[] = ucfirst($ltVal->PORT_UNQ_ID);
                $rows[] = ucfirst($ltVal->NAME);
                $rows[] = ucfirst($ltVal->PASS_NO);
                $rows[] = date("d-m-Y", strtotime($ltVal->IND_DUE_DATE));;
                $rows[] = ucfirst($ltVal->COMP_NAME);
                $rows[] = ucfirst($ltVal->TERMINAL_NAME);
                $rows[] = ucfirst($ltVal->ACK_BY);
                
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
    public function add_psa_guard($id = '') {
        global $vechical_type;
        $did = decryptval($id);
        $getPsadatas = [];
        $getterminalNamedatas = [];

        if ($id != '') {
            $optWhr['where'] = [
                'AUTO_ID' => $did,
                'VEC_STATUS' => 'Y'
            ];
            $optWhr['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = p.TERMIN_ID', 'left'];
            $optWhr['return_type'] = 'row';
            $getPsadatas = $this->common_model->getAlldata(PR_SEC.' as p', ['p.*,t.TERMINAL_NAME'], $optWhr);
        }
        $terminWhere['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $terNamedatas = $this->common_model->getAlldata(TERM, ['*'], $terminWhere);
        if (is_array($terNamedatas)) {
            $getterminalNamedatas = customFormDropDown($terNamedatas, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');
        }
        
        $othercertiDet['where'] = [
            'CERT_PORT_ACCESS_ID' => $did,
           'CERT_COMMON_STATUS' => 'Y',
           ];
        $getOthercertdet = $this->common_model->getAlldata(PSA_CERTI.' as certi',['*'],$othercertiDet);
        
        $data = array(
            'view_file' => 'psa/psa_guard/add_form',
            'current_menu' => 'Add Port Security Access ',
            'getPsadatas' => $getPsadatas,
            'vechical_type' => $vechical_type,
            'geterminalNamedatas' => $getterminalNamedatas,
            'getOthercertdet' => $getOthercertdet,
        );
        $this->template->load_common_template($data);
    }

    public function save_psa_guard($id = '') {

        $did = decryptval($id);
        $portDatas = $this->input->post('port');
        $vec_sub = $this->input->post('vec_sub');
//        echo $vec_sub;exit;
        $this->form_validation->set_rules('port[VEC_TYPE]', 'Vechical Type', 'required|trim');
        $this->form_validation->set_rules('port[VEC_OTHER]', 'Vechical Other Name', 'min_length[3]|max_length[200]|trim|alpha_dash_space');
        $this->form_validation->set_rules('port[VEC_NO]', 'Vechical No', 'min_length[3]|max_length[20]');
        $this->form_validation->set_rules('port[PURPOSE]', 'Purpose', 'trim|min_length[3]|max_length[255]|alpha_dash_space');
//        print_r($exitDatas);
        if ($this->form_validation->run()) {

            $hazadatas = [
                'VEC_TYPE' => postData($portDatas, 'VEC_TYPE'),
                'VEC_OTHER' => postData($portDatas, 'VEC_OTHER'),
                'VEC_NO' => postData($portDatas, 'VEC_NO'),
                'PURPOSE' => postData($portDatas, 'PURPOSE'),
                'VEC_EN_EX_STATUS' => ($vec_sub == 1) ? 1 : 2
            ]; 
            if($vec_sub == 1) {
                $hazadatas['VEC_ENTRY_DATE_TIME'] =  converttoDBDate(date('d-m-Y H:i:s'), 'Y-m-d H:i:s');
            } else {
                $hazadatas['VEC_EXIT_DATE_TIME'] =  converttoDBDate(date('d-m-Y H:i:s'), 'Y-m-d H:i:s');
            }
            if ($did != '') {
                $upWhere = [
                    'AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(PR_SEC, $hazadatas, $upWhere);
            } else {
                $updtProfile = $this->common_model->updateData(PR_SEC, $hazadatas);
            }

            if ($updtProfile && $updtProfile > 0) {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Vehicle Details has been Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Vehicle Details has been Created</div>');
                }
                redirect('psa/psa_report/psa_guard');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Vehicle Details cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Vehicle Details cannot be Created</div>');
                }
                redirect('psa/psa_report/psa_guard');
            }
        } else {
            $this->add_psa_guard($id);
        }
    }

    public function view_report($id = '') {
        $did = decryptval($id);
        $getPsadatas = [];
        $getterminalNamedatas = [];

        if ($id != '') {
            $optns['where'] = [
                'AUTO_ID' => $did,
                'VEC_STATUS' => 'Y'
            ];
            $table = PR_SEC . ' as p';
            $optns['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = p.TERMIN_ID', 'left'];
            $orderby = 'p.CREATED_ON';
            $getPsadatas = $this->common_model->getAlldata($table, ['p.*,t.TERMINAL_NAME'], $optns, '', '', $orderby, 'DESC');
        }
        $idTypeData = [
            '' => 'Select ID Type',
            '1' => 'IC No',
            '2' => 'Passport No'
        ];
        
        $othercertiDet['where'] = [
            'CERT_PORT_ACCESS_ID' => $did,
           'CERT_COMMON_STATUS' => 'Y',
           ];
        $getOthercertdet = $this->common_model->getAlldata(PSA_CERTI.' as certi',['*'],$othercertiDet);
        
        $data = array(
            'view_file' => 'psa/psa_report/view_report',
            'current_menu' => 'View Port Security Access ',
            'getPsadatas' => $getPsadatas,
            'idTypeData' => $idTypeData,
            'geterminalNamedatas' => $getterminalNamedatas,
            'getOthercertdet' => $getOthercertdet,
        );
        $this->template->load_common_template($data);
    }

    public function print_pdf($id = '') {
        $did = decryptval($id);

        if ($id != '') {
            $optns['where'] = [
                'AUTO_ID' => $did,
                'VEC_STATUS' => 'Y'
            ];
            $table = PR_SEC . ' as p';
            $optns['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = p.TERMIN_ID', 'left'];
            $orderby = 'p.CREATED_ON';
            $getPsadatas = $this->common_model->getAlldata($table, ['p.*,t.TERMINAL_NAME'], $optns, '', '', $orderby, 'DESC');
        }
        $idTypeData = [
            '' => 'Select ID Type',
            '1' => 'IC No',
            '2' => 'Passport No'
        ];
        
        $othercertiDet['where'] = [
            'CERT_PORT_ACCESS_ID' => $did,
            'CERT_COMMON_STATUS' => 'Y',
           
            ];
        $getOthercertdet = $this->common_model->getAlldata(PSA_CERTI.' as certi',['*'],$othercertiDet);
        
        $PdfData = [
            'getPsadatas' => $getPsadatas,
            'idTypeData' => $idTypeData,
            'getOthercertdet' => $getOthercertdet,
        ];
        $html2 = $this->load->view('psa/psa_guard/print_pdf', $PdfData, true);
//        print_r($html2);
//        exit;
        $mpdf2 = $this->pdf->ptwUpload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "gts";
        $file_path = "assets/images/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $file_path . 'gts-' . $id . '-' . $currenttime . '.pdf';
        $name = 'gts-' . $currenttime . '.pdf';
        $mpdf2->Output($path2, "I");
//        $data = file_get_contents($path2);
//        force_download($name, $data);
    }

    public function exportExcel() {
        global $vechical_type;
        $table = PR_SEC . ' as p';
        $optns['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = p.TERMIN_ID', 'left'];
        $orderby = 'p.CREATED_ON';
        $listResp = $this->common_model->getAlldata($table, ['p.*,t.TERMINAL_NAME'], $optns, '', '', $orderby, 'DESC');
//        echo $this->db->last_query();
//        echo '<pre>';
//        print_r($listResp);exit;
        foreach ($listResp as $val) {
            $i++;
            $aResultColumn = [];
            $NAME = postData($val, 'NAME');
            $ID_TYPE = postData($val, 'ID_TYPE');
            if ($ID_TYPE == '1') {
                $id_name = 'IC';
            } else if ($ID_TYPE == '2') {
                $id_name = 'Passport';
            }
            $PASS_NO = postData($val, 'PASS_NO');
            $COMP_NAME = postData($val, 'COMP_NAME');
            $DESIG = postData($val, 'DESIG');
            $TERMINAL_NAME = postData($val, 'TERMINAL_NAME');
            $IND_DATE = postData($val, 'IND_DATE');
            $IND_DUE_DATE = postData($val, 'IND_DUE_DATE');
            $VEC_ENTRY_DATE_TIME = postData($val, 'VEC_ENTRY_DATE_TIME');
            $VEC_EXIT_DATE_TIME = postData($val, 'VEC_EXIT_DATE_TIME');
            $VEC_TYPE = postData($val, 'VEC_TYPE');
            $VEC_NO = postData($val, 'VEC_NO');
            $PURPOSE = postData($val, 'PURPOSE');
            $aResultColumn['data']['Name']['value'] = $NAME;
            $aResultColumn['data']['ID Type']['value'] = $id_name;
            $aResultColumn['data']['IC/Passport number']['value'] = $PASS_NO;
            $aResultColumn['data']['Company Name']['value'] = $COMP_NAME;
            $aResultColumn['data']['Designation']['value'] = $DESIG;
            $aResultColumn['data']['Location']['value'] = $TERMINAL_NAME;
            $aResultColumn['data']['Induction Date']['type'] = 'Date';
            $aResultColumn['data']['Induction Date']['value'] = convertDate($IND_DATE, 'd-m-Y');
            $aResultColumn['data']['Induction Due Date']['type'] = 'Date';
            $aResultColumn['data']['Induction Due Date']['value'] = convertDate($IND_DUE_DATE, 'd-m-Y');
            $aResultColumn['data']['Date In']['type'] = 'Date';
            $aResultColumn['data']['Date In']['value'] = convertDate($VEC_ENTRY_DATE_TIME, 'd-m-Y');
            $aResultColumn['data']['Date Out']['type'] = 'Date';
            $aResultColumn['data']['Date Out']['value'] = convertDate($VEC_EXIT_DATE_TIME, 'd-m-Y');
            $aResultColumn['data']['Time In']['type'] = 'Time';
            $aResultColumn['data']['Time In']['value'] = date('h:i:s', strtotime($VEC_ENTRY_DATE_TIME));
            $aResultColumn['data']['Time Out']['type'] = 'Time';
            $aResultColumn['data']['Time Out']['value'] = date('h:i:s', strtotime($VEC_EXIT_DATE_TIME));
            $aResultColumn['data']['Vehicle Type']['value'] = $vechical_type[$VEC_TYPE];
            $aResultColumn['data']['Vehicle Number']['value'] = $VEC_NO;
            $aResultColumn['data']['Purpose']['value'] = $PURPOSE;
            $aResultColumns[] = $aResultColumn;

            $aResultHeading = array_keys($aResultColumn['data']);
            $exportData = [
                'export' => $aResultColumns,
                'heading' => $aResultHeading,
            ];
            
        }
$res = exportExcel($exportData, 'PORT SECURITY ACCESS');
    }

    public function exportPdf() {
        global $vechical_type;
        $table = PR_SEC . ' as p';
        $optns['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = p.TERMIN_ID', 'left'];
        $orderby = 'p.CREATED_ON';
        $listResp = $this->common_model->getAlldata($table, ['p.*,t.TERMINAL_NAME'], $optns, '', '', $orderby, 'DESC');
        $PdfData = [
            'vechical_type' => $vechical_type,
            'listResp' => $listResp
        ];
        $html2 = $this->load->view('psa/psa_report/print_report', $PdfData, true);
//        print_r($html2);
//        exit;
        $mpdf2 = $this->pdf->load();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "PSA";
        $file_path = "assets/images/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $file_path . 'PSA-' . $currenttime . '.pdf';
        $name = 'PSA-' . $currenttime . '.pdf';
        $mpdf2->Output($path2, "I");
//        $data = file_get_contents($path2);
//        force_download($name, $data);
    }

}
