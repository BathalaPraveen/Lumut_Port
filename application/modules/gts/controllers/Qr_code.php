<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Qr_code extends CI_Controller {

    function __construct() {
        parent::__construct();
        isLogin();
    }

    public function index() {
        $data = array(
            'pageTitle' => 'GTS Point QR code',
            'view_file' => 'qrcode/list_form',
            'site_title' => ' GTS Point QR code',
            'current_menu' => 'List  GTS Point QR code',
            'ajaxurl' => 'gts/qr_code/list_gts_loc_point',
        );

        $this->template->load_table_template($data);
    }

    public function list_gts_loc_point() {
        $table = GTS . ' as g';
        $column_order = array('POINT_ID', 'TERM_ID', 'LOCA_POINT', null);
        $column_search = array('POINT_ID', 'TERM_ID', 'LOCA_POINT');
        $order = array('g.CREATED_ON' => 'desc');
        $where = ['GTS_STATUS' => 'Y'];
        $where['Qr_status'] = 2;
        $options['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = g.TERM_ID', 'left'];
        $options['select'] = 'g.TERM_ID,g.Qr_status,g.UNIQ_ID,g.POINT_ID,g.LOCA_POINT,t.TERMINAL_NAME';
        $listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where, $options);
//        echo $this->db->last_query();exit;
        $finalDatas = [];
        if (isset($listIncicat) && !empty($listIncicat)) {
            foreach ($listIncicat as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->UNIQ_ID;

                $action .= " " . anchor('gts/qr_code/addqrcode/' . encryptval($id), '<i class="fa fa-edit"></i>', array('class' => 'gts_target', 'title' => 'Edit'));
                if ($ltVal->Qr_status == 2) {
                    $action .= " " . anchor('gts/qr_code/genqrcode/' . encryptval($id), '<i class="fa fa-print"></i>', array('class' => 'pdf_gen', 'title' => 'Print QR Code'));
                }
                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'delete_gts', 'title' => 'Delete', 'delt-id' => $id));


                $rows = [];
                $rows[] = $ltVal->POINT_ID;
                $rows[] = $ltVal->TERMINAL_NAME;
                $rows[] = $ltVal->LOCA_POINT;
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

    public function getAjaxpoint() {
        $terID = $this->input->post('terId');
        $editId = $this->input->post('editId');
        
        if($editId != '') {
            $options['where'] = [
            'GTS_STATUS' => 'Y',
            'TERM_ID' => $terID
        ];
        } else {
           $options['where'] = [
            'GTS_STATUS' => 'Y',
            'Qr_status' => '1',
            'TERM_ID' => $terID,
        ]; 
        }
        
        $getStatenames = $this->common_model->getAlldata(GTS, ['*'], $options);

        $statedatas = '<option>Select GTS Point Point</option>';

        if ($getStatenames) {

            foreach ($getStatenames as $stKey => $stVal) {
                if ($stVal->UNIQ_ID == $editId) {
                    $statedatas .= '<option value="' . $stVal->UNIQ_ID . '" selected="' . $editId . '">' . $stVal->LOCA_POINT . '</option>';
                } else {
                    $statedatas .= '<option value="' . $stVal->UNIQ_ID . '">' . $stVal->LOCA_POINT . '</option>';
                }
            }
            $returnData = [
                'status' => true,
                'pointdatas' => $statedatas,
            ];
        } else {
            $returnData = [
                'status' => false,
                'pointdatas' => $statedatas,
            ];
        }

        echo json_encode($returnData);
    }

    public function addqrcode($id = '') {
        $getgtslocdatas = [];
        if ($id != '') {
            $optWhr['where'] = [
                'UNIQ_ID' => decryptval($id)
            ];
            $optWhr['return_type'] = 'row';
            $getgtslocdatas = $this->common_model->getAlldata(GTS, ['*'], $optWhr);
        }
        $terminWhere['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $terNamedatas = $this->common_model->getAlldata(TERM, ['*'], $terminWhere);
        if (is_array($terNamedatas)) {
            $getterminalNamedatas = customFormDropDown($terNamedatas, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');
        }
        if ($id != "") {
            $gtsWhere['where'] = [
                'GTS_STATUS' => 'Y'
            ];
        } else {
            $gtsWhere['where'] = [
                'GTS_STATUS' => 'Y',
                'Qr_status' => 1
            ];
        }

        $gtsdatas = $this->common_model->getAlldata(GTS, ['*'], $gtsWhere);
        if (is_array($gtsdatas)) {
            $gtspointdatas = customFormDropDown($gtsdatas, 'UNIQ_ID', 'LOCA_POINT', 'Select GTS Point Name');
        }
        $data = array(
            'view_file' => 'qrcode/add_form',
            'current_menu' => 'Add GTS Point QR code',
            'getgtslocdatas' => $getgtslocdatas,
            'getterminalNamedatas' => $getterminalNamedatas,
            'gtspointdatas' => $gtspointdatas
        );
        $this->template->load_common_template($data);
    }

    public function saveqrcode() {
        $getgtsactdatas = $this->input->post('gts');
        $getGtsId = $this->input->post('EditID');
        $pointId = $this->input->post('pointID');
        $this->form_validation->set_rules('gts[gts_point]', 'GTS Location Point', 'required');
        $this->form_validation->set_rules('gts[TERMIN_ID]', 'Terminal Name', 'required');
        $piont_id = postData($getgtsactdatas, 'gts_point');
        if ($piont_id != '') {
            $gtsWhere['where'] = [
                'UNIQ_ID' => $piont_id
            ];
            $getunqId = $this->common_model->getAlldata(GTS, ['UNIQ_ID,POINT_ID'], $gtsWhere);
        }
        if ($this->form_validation->run()) {
            $qrfilepath = "assets/images/QRCODE/";
            $qrPath = FCPATH . $qrfilepath;
            $this->load->library('ciqrcode');

            $qr_image = ($pointId != '') ? $pointId . '.png' : $getunqId->POINT_ID . '.png';
            $params['data'] = ($piont_id != '') ? $piont_id : $getunqId->UNIQ_ID;
            $params['level'] = 'H';
            $params['size'] = 720;
            $params['savename'] = $qrPath . $qr_image;

            if (!file_exists($qrPath)) {
                mkdir($qrPath, 0777);
            }
            if ($this->ciqrcode->generate($params)) {
                $qrfullpath = $qrfilepath . $qr_image;
                $qrInfo = [
                    'QR_IMG' => $qr_image,
                    'QR_IMG_PATH' => $qrfullpath,
                    'Qr_status' => 2
                ];
                $qrCond = [
                    'UNIQ_ID' => ($getGtsId != '') ? $getGtsId : $piont_id,
                ];
                $update = $this->common_model->updateData(GTS, $qrInfo, $qrCond, 'UNIQ_ID');
            }
            if (!empty($update)) {
                $data['flasmsg'] = $this->session->set_flashdata('qrcode', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> QR Code for GTS Location Point has been Updated</div>');
            } else {
                $data['flasmsg'] = $this->session->set_flashdata('qrcode', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> QR Code for GTS Location Point cannot be Created</div>');
            }
            redirect('gts/qr_code');
        } else {
            $data['flasmsg'] = $this->session->set_flashdata('qrcode', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Unable to create QR Code for GTS Location Point</div>');
            redirect('gts/qr_code');
        }
    }

    public function delete_gts_loc_point() {

        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(GTS, ['Qr_status' => 1,'GTS_STATUS' => 'N'], ['UNIQ_ID' => $deleteId]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'GTS POINT QR CODE has been deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting GTS POINT QR CODE'
            ];
        }
        echo json_encode($retData);
    }

    public function genqrcode($id = '') {
        $did = decryptval($id);

        if ($did != '' && $did > 0) {
            $getgtslocdatas = [];
            if ($id != '') {
                $optWhr['where'] = [
                    'g.UNIQ_ID' => $did
                ];
                $optWhr['return_type'] = 'row';
                $optWhr['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = g.TERM_ID', 'left'];
                $getgtslocdatas = $this->common_model->getAlldata(GTS . ' as g', ['g.*,t.TERMINAL_NAME'], $optWhr);
            }
        }
        $PdfData = [
            'gtslocdatas' => $getgtslocdatas
        ];
        $html2 = $this->load->view('gts/qrcode/print_qr', $PdfData, true);
//        print_r($html2);
//        exit;
        $mpdf2 = $this->pdf->QrUpload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "QRCODE";
        $file_path = "assets/images/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $file_path . 'QR-' . $id . '-' . $currenttime . '.pdf';
        $name = 'QR-' . $currenttime . '.pdf';
        $mpdf2->Output($path2, "I");
//        $data = file_get_contents($path2);
//        force_download($name, $data);
    }

}
