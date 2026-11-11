<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isLogin();
    }

    /*
     * Process Activity Area Start
     */

    public function gts_loc_point() {
        $data = array(
            'pageTitle' => 'GTS Location Point',
            'view_file' => 'gts_loc_point/list_form',
            'site_title' => 'GTS Location Point Related Info',
            'current_menu' => 'List GTS Location Point',
            'ajaxurl' => 'gts/master/list_gts_loc_point',
        );

        $this->template->load_table_template($data);
    }

    public function list_gts_loc_point() {
        $table = GTS . ' as g';
        $column_order = array('POINT_ID', 'TERM_ID', 'LOCA_POINT', null);
        $column_search = array('POINT_ID','TERM_ID', 'LOCA_POINT');
        $order = array('g.UNIQ_ID' => 'desc');
        $where = ['GTS_STATUS' => 'Y'];
        $options['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = g.TERM_ID', 'left'];
        $options['select'] = 'g.TERM_ID,g.UNIQ_ID,g.POINT_ID,g.LOCA_POINT,t.TERMINAL_NAME';
        $listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where,$options);
//        echo $this->db->last_query();exit;
        $finalDatas = [];
        if (isset($listIncicat) && !empty($listIncicat)) {
            foreach ($listIncicat as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->UNIQ_ID;

                $action .= " " . anchor('gts/master/add_gts_loc_point/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'gts_target', 'title' => 'Edit'));

                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteactpro', 'title' => 'Delete', 'delt-id' => $id));


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

    public function add_gts_loc_point($id = '') {
        $getprocessdatas = [];
        if ($id != '') {
            $optWhr['where'] = [
                'UNIQ_ID' => $id
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
        $gts_uniq_id = uniqueRefId('GTS', GTS, 'UNIQ_ID');
        $data = array(
            'view_file' => 'gts_loc_point/add_form',
            'current_menu' => 'Add GTS Location Point',
            'getgtslocdatas' => $getgtslocdatas,
            'getterminalNamedatas' => $getterminalNamedatas,
            'gts_uniq_id' => $gts_uniq_id
        );
        $this->template->load_popup_template($data);
    }

    public function save_gts_loc_point() {
        $getgtsactdatas = $this->input->post('gts');
        $getproactId = $this->input->post('UNIQ_ID');
        if ($getproactId && $getproactId != '0') {
            $this->form_validation->set_rules('gts[LOCA_POINT]', 'GTS Location Point', 'required|min_length[3]|max_length[100]');
        } else {
            $this->form_validation->set_rules('gts[LOCA_POINT]', 'GTS Location Point', 'required|min_length[3]|max_length[100]|is_unique[' . GTS . '.LOCA_POINT]');
        }
        $this->form_validation->set_rules('gts[TERMIN_ID]', 'Terminal Name', 'required');

        if ($this->form_validation->run()) {
            $updateData = [
                'POINT_ID' => postData($getgtsactdatas,'POINT_ID'),
                'LOCA_POINT' => postData($getgtsactdatas,'LOCA_POINT'),
                'TERM_ID' => postData($getgtsactdatas,'TERMIN_ID')
            ];
            $updtWhr = [];
            if ($getproactId > 0) { 
                $updtWhr = [
                    'UNIQ_ID' => $getproactId
                ];
            }

            $updateInfo = $this->common_model->updateData(GTS, $updateData, $updtWhr, 'UNIQ_ID');

            if (!empty($updateInfo)) {

                $data = [
                    'status' => true
                ];
                if ($getproactId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> GTS Location Point has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> GTS Location Point has been Created</div>');
                }
            } else {
                $data = [
                    'status' => false
                ];
                if ($getproactId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> GTS Location Point cannot be Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> GTS Location Point cannot be Created</div>');
                }
            }
        } else {
            $errors = $this->form_validation->error_array();
            $data = [
                'status' => 'error',
                'errors' => $errors,
            ];
        }
        echo json_encode($data);
    }

    public function delete_gts_loc_point() {

        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(GTS, ['GTS_STATUS' => 'N'], ['UNIQ_ID' => $deleteId]);

        if ($updtDelete) { 
            $retData = [
                'status' => true,
                'msgs' => 'GST Location Point has been deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting GST Location Point'
            ]; 
        }
        echo json_encode($retData);
    }
}
