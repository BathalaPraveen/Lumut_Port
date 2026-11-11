<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gts_report extends CI_Controller {

    function __construct() {
        parent::__construct();
        isLogin();
    }

    public function index() {
        $data = array(
            'pageTitle' => 'GTS Report',
            'view_file' => 'gts_report/list_form',
            'site_title' => ' GTS Report',
            'current_menu' => 'List GTS Report',
            'ajaxurl' => 'gts/gts_report/list_gts_loc_point',
        );

        $this->template->load_table_template($data);
    }

    public function list_gts_loc_point() { 
        ini_set("display_errors",1);
        $table = GTS_MAIN . ' as gt';
        $column_order = array('EMP_ID', 'EMP_NAME', 'd.DESIGNATION_NAME', 'TERMINAL_NAME', 'LOCA_POINT', 'GTS_DATE_TIME', null);
        $column_search = array('EMP_ID', 'EMP_NAME', 'd.DESIGNATION_NAME', 'TERMINAL_NAME', 'LOCA_POINT', 'GTS_DATE_TIME');
        $order = ['gt.GTS_AUTO_ID' => 'DESC'];
        $where = ['gt.GTS_MAIN_STATUS' => 'Y'];
        $options['join'][GTS . ' as g'] = ['g.UNIQ_ID = gt.FK_POINT_ID_QR_CODE', 'left'];
        $options['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = g.TERM_ID', 'left'];

        $options['join'][LOGIN . ' as LD'] = ['LD.LOGIN_ID = gt.FK_NOTIFY_ID', 'left'];
        $options['join'][EMPLOYEE_MANAGEMENT . ' as e'] = ['e.EMP_AUTO_ID = LD.USER_REF_ID', 'left'];
        
        $options['join'][LOGIN . ' as LD2'] = ['LD2.LOGIN_ID = gt.FK_NOTIFY_ID', 'left'];
        $options['join'][CONT_DET . ' as cn'] = ['cn.CONT_AUTO_ID = LD2.USER_REF_ID', 'left'];
      

        $options['join'][DESIG . ' as d'] = ['d.DESIGNATION_ID = e.EMP_DESIGNATION_ID', 'left'];
        $options['join'][DESIG . ' as de'] = ['de.DESIGNATION_ID = cn.CONT_DESIGNATION', 'left'];
        $options['select'] = 'g.UNIQ_ID,g.POINT_ID,g.LOCA_POINT,t.TERMINAL_NAME,gt.FK_NOTIFY_TYPE_ID,gt.GTS_AUTO_ID,gt.GTS_DATE_TIME,cn.CONT_ID,cn.CONT_NAME,e.EMP_ID,e.EMP_NAME,d.DESIGNATION_NAME as des,de.DESIGNATION_NAME as desig';
        $listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where, $options);
       //echo $this->db->last_query();exit;
        $finalDatas = [];
        if (isset($listIncicat) && !empty($listIncicat)) {
            foreach ($listIncicat as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->GTS_AUTO_ID;

                $action .= " " . anchor('gts/gts_report/view_report/' . encryptval($id), '<i class="fa fa-eye"></i>', array('class' => 'gts_target', 'title' => 'View'));
//                if ($ltVal->Qr_status == 2) {
                $action .= " " . anchor('gts/gts_report/print_pdf/' . encryptval($id), '<i class="fas fa-file-pdf"></i>', array('class' => 'pdf_gen', 'title' => 'Print QR Code'));
//                }
//                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'delete_gts', 'title' => 'Delete', 'delt-id' => $id));


                $rows = [];
                $rows[] = ($ltVal->FK_NOTIFY_TYPE_ID == 11) ? $ltVal->CONT_ID : $ltVal->EMP_ID;
                $rows[] = ($ltVal->FK_NOTIFY_TYPE_ID == 11) ? $ltVal->CONT_NAME : $ltVal->EMP_NAME;
                //$rows[] = ($ltVal->FK_NOTIFY_TYPE_ID == 11) ? $ltVal->desig : $ltVal->des;
                $rows[] = $ltVal->TERMINAL_NAME;
                $rows[] = $ltVal->LOCA_POINT;
                $rows[] = convertDate($ltVal->GTS_DATE_TIME, 'd-m-Y');
                $rows[] = convertDate($ltVal->GTS_DATE_TIME, 'h:i:s');
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

    public function view_report($id = '') {
        $getgtslocdatas = [];
        if ($id != '') {
            $options['where'] = ['gt.GTS_AUTO_ID' => decryptval($id)];
            $options['where']['gt.GTS_MAIN_STATUS'] = 'Y';
            $options['join'][GTS . ' as g'] = ['g.UNIQ_ID = gt.FK_POINT_ID_QR_CODE', 'left'];
            $options['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = g.TERM_ID', 'left'];
            $options['join'][GTS_MA_UP . ' as gtu'] = ['gtu.FK_GTS_MAIN = gt.GTS_AUTO_ID', 'left'];
           
 $options['join'][LOGIN . ' as LD'] = ['LD.LOGIN_ID = gt.FK_NOTIFY_ID', 'left'];
        $options['join'][EMPLOYEE_MANAGEMENT . ' as e'] = ['e.EMP_AUTO_ID = LD.USER_REF_ID', 'left'];
        
        $options['join'][LOGIN . ' as LD2'] = ['LD2.LOGIN_ID = gt.FK_NOTIFY_ID', 'left'];
        $options['join'][CONT_DET . ' as cn'] = ['cn.CONT_AUTO_ID = LD2.USER_REF_ID', 'left'];

            $options['join'][DESIG . ' as d'] = ['d.DESIGNATION_ID = e.EMP_DESIGNATION_ID', 'left'];
            $options['join'][DESIG . ' as de'] = ['de.DESIGNATION_ID = cn.CONT_DESIGNATION', 'left'];
            $select = ['g.UNIQ_ID,g.POINT_ID,g.LOCA_POINT,t.TERMINAL_NAME,gt.FK_NOTIFY_TYPE_ID,gt.GTS_DATE_TIME,cn.CONT_ID,cn.CONT_NAME,e.EMP_ID,e.EMP_NAME,d.DESIGNATION_NAME as des,de.DESIGNATION_NAME as desig,gtu.GTS_FILE_PATH,gtu.GTS_FILENAME,gtu.GTS_FILE_EXT'];
            $getgtslocdatas = $this->common_model->getAlldata(GTS_MAIN . ' as gt', $select, $options);
           // echo $this->db->last_query(); exit;
        }
        $data = array(
            'view_file' => 'gts_report/view_report',
            'current_menu' => 'View GTS Report',
            'getgtslocdatas' => $getgtslocdatas
        );
        $this->template->load_common_template($data);
    }

    public function print_pdf($id = '') {
        $did = decryptval($id);

        if ($did != '' && $did > 0) {
            if ($id != '') {
                $options['where'] = ['gt.GTS_AUTO_ID' => decryptval($id)];
                $options['where']['gt.GTS_MAIN_STATUS'] = 'Y';
                $options['join'][GTS . ' as g'] = ['g.UNIQ_ID = gt.FK_POINT_ID_QR_CODE', 'left'];
                $options['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = g.TERM_ID', 'left'];
                $options['join'][GTS_MA_UP . ' as gtu'] = ['gtu.FK_GTS_MAIN = gt.GTS_AUTO_ID', 'left'];

              $options['join'][LOGIN . ' as LD'] = ['LD.LOGIN_ID = gt.FK_NOTIFY_ID', 'left'];
        $options['join'][EMPLOYEE_MANAGEMENT . ' as e'] = ['e.EMP_AUTO_ID = LD.USER_REF_ID', 'left'];
        
        $options['join'][LOGIN . ' as LD2'] = ['LD2.LOGIN_ID = gt.FK_NOTIFY_ID', 'left'];
        $options['join'][CONT_DET . ' as cn'] = ['cn.CONT_AUTO_ID = LD2.USER_REF_ID', 'left'];

                $options['join'][DESIG . ' as d'] = ['d.DESIGNATION_ID = e.EMP_DESIGNATION_ID', 'left'];
                $options['join'][DESIG . ' as de'] = ['de.DESIGNATION_ID = cn.CONT_DESIGNATION', 'left'];
                $select = ['g.UNIQ_ID,g.POINT_ID,g.LOCA_POINT,t.TERMINAL_NAME,gt.FK_NOTIFY_TYPE_ID,gt.GTS_DATE_TIME,cn.CONT_ID,cn.CONT_NAME,e.EMP_ID,e.EMP_NAME,d.DESIGNATION_NAME as des,de.DESIGNATION_NAME as desig,gtu.GTS_FILE_PATH,gtu.GTS_FILENAME,gtu.GTS_FILE_EXT'];
                $getgtslocdatas = $this->common_model->getAlldata(GTS_MAIN . ' as gt', $select, $options);
            }
        }
        $PdfData = [
            'gtslocdatas' => $getgtslocdatas
        ];
        $html2 = $this->load->view('gts/gts_report/print_pdf', $PdfData, true);
//        print_r($html2);
//        exit;
        $mpdf2 = $this->pdf->gtsUpload();
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

}
