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
 
    public function process_act_area() {
        $data = array(
            'pageTitle' => 'Process Activity Area',
            'view_file' => 'master/process_act_area/list_form',
            'site_title' => 'Process Activity Area Related Info',
            'current_menu' => 'List Process Activity Area',
            'ajaxurl' => 'hirarc/master/list_process_act',
        );

        $this->template->load_table_template($data);
    }

    public function list_process_act() {
        $table = PRO_ACT_AREA;
        $column_order = array(null, 'PRO_NAME', 'CREATED_ON', null);
        $column_search = array('PRO_NAME', 'CREATED_ON');
        $order = array('CREATED_ON' => 'desc');
        $where = ['PRO_STATUS' => 'Y'];

        $listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where);

        $finalDatas = [];
        if (isset($listIncicat) && !empty($listIncicat)) {
            foreach ($listIncicat as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->PRO_AUTO_ID;

                $action .= " " . anchor('hirarc/master/addActivityProArea/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'pro_act_target', 'title' => 'Edit'));

                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteactpro', 'title' => 'Delete', 'delt-id' => $id));


                $rows = [];
                $rows[] = $ltVal->PRO_NAME;
                $rows[] = convertDate($ltVal->CREATED_ON);
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

    public function addActivityProArea($id = '') {
        $getprocessdatas = [];
        if ($id != '') {
            $optWhr['where'] = [
                'PRO_AUTO_ID' => $id
            ];
            $optWhr['return_type'] = 'row';
            $getprocessdatas = $this->common_model->getAlldata(PRO_ACT_AREA, ['*'], $optWhr);
        }

        $data = array(
            'view_file' => 'hirarc/master/process_act_area/add_form',
            'current_menu' => 'Add Process Activity Area Name',
            'getprocessdatas' => $getprocessdatas
        );
        $this->template->load_popup_template($data);
    }

    public function saveActivityProArea() {
        $getproactdatas = $this->input->post('pro_act');
        $getproactId = $this->input->post('PRO_AUTO_ID');
        if ($getproactId && $getproactId != '0') {
            $this->form_validation->set_rules('pro_act', 'Activity Process Area Name', 'required|alpha_dash_space|min_length[3]|max_length[50]');
        } else {
            $this->form_validation->set_rules('pro_act', 'Activity Process Area Name', 'required|alpha_dash_space|min_length[3]|max_length[50]|is_unique[' . PRO_ACT_AREA . '.PRO_NAME]');
        }


        if ($this->form_validation->run()) {
            $updateData = [
                'PRO_NAME' => $getproactdatas
            ];
            $updtWhr = [];
            if ($getproactId > 0) {
                $updtWhr = [
                    'PRO_AUTO_ID' => $getproactId
                ];
            }

            $updateInfo = $this->common_model->updateData(PRO_ACT_AREA, $updateData, $updtWhr, 'PRO_AUTO_ID');

            if (!empty($updateInfo)) {

                $data = [
                    'status' => true
                ];
                if ($getproactId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Process Activity Area has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Process Activity Area has been Created</div>');
                }
            } else {
                $data = [
                    'status' => false
                ];
                if ($getproactId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Process Activity Area cannot be Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Process Activity Area cannot be Created</div>');
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

    public function deleteActivityProArea() {

        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(PRO_ACT_AREA, ['PRO_STATUS' => 'N'], ['PRO_AUTO_ID' => $deleteId]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Process Activity Area deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Process Activity Area'
            ];
        }
        echo json_encode($retData);
    }

    /*
     * Activity Area Process End
     */
    /*
     * hazard Start
     */

    public function hazard_type() {
        $data = array(
            'pageTitle' => 'Type of Activity',
            'view_file' => 'master/hazard_type/list_form', 
            'site_title' => 'HIRARC Type of Activity',
            'current_menu' => 'List Type of Activity',
            'ajaxurl' => 'hirarc/master/list_Hazard_type',
        );

        $this->template->load_table_template($data);
    }

    public function list_Hazard_type() {
        $table = HAZA_TYPE;
        $column_order = array('HAZ_TYPE_NAME', 'CREATED_ON', null);
        $column_search = array('HAZ_TYPE_NAME', 'CREATED_ON');
        $order = array('CREATED_ON' => 'desc');
        $where = ['HAZ_TYPE_STATUS' => 'Y'];

        $listHazard = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where);

        $finalDatas = [];
        if (isset($listHazard) && !empty($listHazard)) {
            foreach ($listHazard as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->HAZ_TYPE_AUTO_ID;

                $action .= " " . anchor('hirarc/master/addHazardType/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'haz_target', 'title' => 'Edit'));

                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deletehazard', 'title' => 'Delete', 'delt-id' => $id));


                $rows = [];
                $rows[] = $ltVal->HAZ_TYPE_NAME;
                $rows[] = convertDate($ltVal->CREATED_ON);
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

    public function addHazardType($id = '') {
        $getHazardatas = [];
        if ($id != '') {
            $optWhr['where'] = [
                'HAZ_TYPE_AUTO_ID' => $id
            ];
            $optWhr['return_type'] = 'row';
            $getHazardatas = $this->common_model->getAlldata(HAZA_TYPE, ['*'], $optWhr);
        }

        $data = array(
            'view_file' => 'hirarc/master/hazard_type/add_form',
            'current_menu' => 'Add Hazard Type Name',
            'getHazardatas' => $getHazardatas
        );
        $this->template->load_popup_template($data);
    }

    public function saveHazardType() {
        $gethazarName = $this->input->post('haz_name');
        $gethazarId = $this->input->post('HAZ_TYPE_AUTO_ID');
        if ($gethazarId && $gethazarId != '0') {
            $this->form_validation->set_rules('haz_name', 'Hazard Name', 'required|alpha_dash_space|min_length[1]|max_length[50]');
        } else {
            $this->form_validation->set_rules('haz_name', 'Hazard Name', 'required|alpha_dash_space|min_length[1]|max_length[50]|is_unique[' . HAZA_TYPE . '.HAZ_TYPE_NAME]');
        }


        if ($this->form_validation->run()) {
            $updateData = [
                'HAZ_TYPE_NAME' => $gethazarName
            ];
            $updtWhr = [];
            if ($gethazarId > 0) {
                $updtWhr = [
                    'HAZ_TYPE_AUTO_ID' => $gethazarId
                ];
            }

            $updateInfo = $this->common_model->updateData(HAZA_TYPE, $updateData, $updtWhr, 'HAZ_TYPE_AUTO_ID');

            if (!empty($updateInfo)) {

                $data = [
                    'status' => true
                ];
                if ($gethazarId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Type of Activity has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Type of Activity has been Created</div>');
                }
            } else {
                $data = [
                    'status' => false
                ];
                if ($gethazarId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Hazard Type cannot be Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Hazard Type cannot be Created</div>');
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

    public function deleteHazardType() {

        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(HAZA_TYPE, ['HAZ_TYPE_STATUS' => 'N'], ['HAZ_TYPE_AUTO_ID' => $deleteId]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Hazard Type deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Hazard Type'
            ];
        }
        echo json_encode($retData);
    }

    /*
     * hazard Type End
     */

    //// Hazard master start
    public function hazard() {
        $data = array(
            'view_file' => 'master/hazard/list_hazard',
            'site_title' => 'Hazard',
            'current_menu' => 'List Hazard ',
            'ajaxurl' => 'hirarc/master/list_hazard',
        );

        $this->template->load_table_template($data);
    }

    public function list_hazard() {
        $where['haz.HAZ_STATUS'] = 'Y';
        $hwhere['haz.HAZ_STATUS'] = 'Y';
        $hwhere['hn.HAZ_STATUS'] = 'Y';
        $table = HAZA . ' as haz';
        $column_order = array('PRO_AUTO_ID', 'HAZ_TYPE_AUTO_ID', 'HAZ_NAME', 'CREATED_ON', null);
        $column_search = array('PRO_AUTO_ID', 'HAZ_TYPE_AUTO_ID', 'HAZ_NAME', 'CREATED_ON');
        $order = array('HAZ_AUTO_ID' => 'desc');
        $optns['select'] = 'ty.HAZ_TYPE_NAME,pro.PRO_AUTO_ID,pro.PRO_NAME,haz.CREATED_ON,haz.HAZ_AUTO_ID,group_concat(hn.HAZ_NAME) as HAZ_NAME';
        $optns['join'][HAZA_TYPE . ' as ty'] = ['ty.HAZ_TYPE_AUTO_ID = haz.FK_HAZ_TYPE_ID', 'left'];
        $optns['join'][PRO_ACT_AREA . ' as pro'] = ['find_in_set(pro.PRO_AUTO_ID ,haz.FK_PRO_ID) > 0', 'left'];
        $optns['join'][HAZA_NAME . ' as hn'] = ['hn.HIR_HAZA_ID = haz.HAZ_AUTO_ID', 'left'];
        $optns['group_by'] = ['pro.PRO_AUTO_ID'];
        $listResp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $hwhere, $optns);
//        echo $this->db->last_query();exit;
//        echo '<pre>';
//        print_r($listResp);
//        exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listResp) && !empty($listResp)) {
            foreach ($listResp as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->HAZ_AUTO_ID);
                $pid = encryptval($ltVal->PRO_AUTO_ID);

                $action .= " " . anchor('hirarc/master/addhazard/' . $id . '/' . $pid, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));

                $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteLocation', 'title' => 'Delete', 'delt-id' => $id));
//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

                $rows = [];
                $rows[] = ucfirst($ltVal->PRO_NAME);
                $rows[] = ucfirst($ltVal->HAZ_TYPE_NAME);
                $rows[] = ucfirst($ltVal->HAZ_NAME);
                $rows[] = convertDate($ltVal->CREATED_ON);
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

    public function addhazard($id = '', $pid = '') {
        $did = decryptval($id);
        $proId = decryptval($pid);
//        print_r($proId);exit;
        $getHazarddatas = [];
        $getprocessdatas = [];
        $getHazardTypedatas = [];

        if ($id != '') {
            $optWhr['where'] = [
                'h.HAZ_AUTO_ID' => $did,
                'h.HAZ_STATUS' => 'Y',
                'hn.HAZ_STATUS' => 'Y'
            ];
            $optWhr['return_type'] = 'result';
            $optWhr['join'][HAZA_NAME . ' as hn'] = ['hn.HIR_HAZA_ID = h.HAZ_AUTO_ID', 'left'];
            $getHazarddatas = $this->common_model->getAlldata(HAZA . ' as h', ['h.*,hn.HAZ_NAME,hn.HAZ_ID'], $optWhr);
        }
//        echo '<pre>';
//        print_r($getHazarddatas);
//        exit;
        $TermWhere['where'] = [
            'PRO_STATUS' => 'Y'
        ];
        $processdatas = $this->common_model->getAlldata(PRO_ACT_AREA, ['*'], $TermWhere);
        if (is_array($processdatas)) {
            $getprocessdatas = customFormDropDown($processdatas, 'PRO_AUTO_ID', 'PRO_NAME', 'Select Activity/Process/Area Name');
        }
        $hazrtyWhere['where'] = [
            'HAZ_TYPE_STATUS' => 'Y'
        ];
        $hazardTypedatas = $this->common_model->getAlldata(HAZA_TYPE, ['*'], $hazrtyWhere);
        if (is_array($hazardTypedatas)) {
            $getHazardTypedatas = customFormDropDown($hazardTypedatas, 'HAZ_TYPE_AUTO_ID', 'HAZ_TYPE_NAME', 'Select Hazard Type');
        }
        $data = array(
            'view_file' => 'master/hazard/add_hazard',
            'current_menu' => 'Add Hazard ',
            'getHazarddatas' => $getHazarddatas,
            'getprocessdatas' => $getprocessdatas,
            'getHazardTypedatas' => $getHazardTypedatas,
            'proId' => $proId,
        );
        $this->template->load_common_template($data);
    }

    public function savehazard($id = '') {

        $did = decryptval($id);
//        print_r($did);exit;
        $hazDatas = $this->input->post('haz');
        $this->form_validation->set_rules('haz[FK_PRO_ID]', 'Process/Activity/Area Name', 'required|trim');
        $this->form_validation->set_rules('haz[FK_HAZ_TYPE_ID]', 'Hazard Type', 'required|trim');
        $this->form_validation->set_rules('haz[haz_name][]', 'Hazard Name', 'required|trim|min_length[2]|max_length[100]|alpha_dash_space');

        if ($this->form_validation->run()) {

            if ($did != '') {
                $hwhr['where'] = [
                    'HAZ_AUTO_ID' => $did
                ];
                $getAllData = $this->common_model->getAlldata(HAZA, ['*'], $hwhr);
                $proVal = explode(',', $getAllData[0]->FK_PRO_ID);
                if (in_array(postData($hazDatas, 'FK_PRO_ID'), $proVal)) {
                    $locdatas = [
                        'FK_HAZ_TYPE_ID' => postData($hazDatas, 'FK_HAZ_TYPE_ID')
                    ];
                } else {
                    array_push($proVal, postData($hazDatas, 'FK_PRO_ID'));

                    $proValF = implode(',', $proVal);
                    $locdatas = [
                        'FK_PRO_ID' => $proValF,
                        'FK_HAZ_TYPE_ID' => postData($hazDatas, 'FK_HAZ_TYPE_ID')
                    ];
                }
                $upWhere = [
                    'HAZ_AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(HAZA, $locdatas, $upWhere);
//            echo $this->db->last_query();exit;
            } else {
                $updtProfile = $this->common_model->updateData(HAZA, $locdatas);
//                echo $this->db->last_query();exit;
            }
            $haz_name = postData($hazDatas, 'haz_name');
            $haz_id = postData($hazDatas, 'HAZ_ID');
            if ($did != '') {
                $hazNameWhr['where'] = [
                    'HIR_HAZA_ID' => $did,
                    'HAZ_STATUS' => 'Y'
                ];
                $hazNameWhr['return_type'] = 'result';
                $getHazardNamedatas = $this->common_model->getAlldata(HAZA_NAME, ['HAZ_ID'], $hazNameWhr);
                foreach ($haz_id as $key => $hazNId) {
                    $hazNaId[] = $hazNId;
                }
                foreach ($getHazardNamedatas as $key => $val) {
                    if (in_array($val->HAZ_ID, $hazNaId) == FALSE) {
                        $uphazadatas = [
                            "HAZ_STATUS" => 'N'
                        ];
                        $upHWhere = [
                            'HAZ_ID' => $val->HAZ_ID
                        ];
                        $updtdetails = $this->common_model->updateData(HAZA_NAME, $uphazadatas, $upHWhere);
                    }
                }
            }
            if ($updtProfile && $updtProfile > 0) {
                foreach ($haz_name as $key => $value) {
                    $hazadatas = [
                        'HIR_HAZA_ID' => ($did != '') ? $did : $updtProfile,
                        'HAZ_NAME' => $value
                    ];
                    if ($haz_id[$key] != '') {
                        $upWhere = [
                            'HAZ_ID' => $haz_id[$key]
                        ];
                        $updProfile = $this->common_model->updateData(HAZA_NAME, $hazadatas, $upWhere);
                    } else {
                        $updProfile = $this->common_model->updateData(HAZA_NAME, $hazadatas);
                    }
                }
            }

            if ($updProfile && $updProfile > 0) {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Hazard Name has been Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Hazard Name has been Created</div>');
                }
                redirect('hirarc/master/hazard');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Hazard Name cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Hazard Name cannot be Created</div>');
                }
                redirect('hirarc/master/hazard');
            }
        } else {
            $this->addhazard($id);
        }
    }

    public function deleteHazard() {
        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(HAZA, ['HAZ_STATUS' => 'N'], ['HAZ_AUTO_ID' => decryptval($deleteId)]);
        $updtHazNameDelete = $this->common_model->updateData(HAZA_NAME, ['HAZ_STATUS' => 'N'], ['HIR_HAZA_ID' => decryptval($deleteId)]);
        if ($updtDelete && $updtHazNameDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Hazard has been deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Hazard! Try Again later.'
            ];
        }
        echo json_encode($retData);
    }

//// Hazard master end
    //// causeAffect master start
    public function causeAffect() {
        $data = array(
            'view_file' => 'master/causeAffect/list_causeAffect',
            'site_title' => 'Cause Affect',
            'current_menu' => 'List Cause Affect ',
            'ajaxurl' => 'hirarc/master/list_causeAffect',
        );

        $this->template->load_table_template($data);
    }

    public function list_causeAffect() {
        $where['cau.CAUSE_STATUS'] = 'Y';
        $table = HAZA_CAU . ' as cau';
        $column_order = array('FK_PRO_ID', 'FK_HAZ_TYPE_ID', 'FK_HAZ_ID', 'CAUSE_NAME', 'CREATED_ON', null);
        $column_search = array('FK_PRO_ID', 'FK_HAZ_TYPE_ID', 'FK_HAZ_ID', 'CAUSE_NAME', 'CREATED_ON');
        $order = array('cau.CAUSE_AUTO_ID' => 'desc');
        $optns['select'] = 'ty.HAZ_TYPE_NAME,pro.PRO_NAME,hn.HAZ_NAME,cau.CREATED_ON,cau.FK_HAZ_ID,group_concat(DISTINCT(cau.CAUSE_NAME)) as CAUSE_NAME';
        $optns['join'][HAZA_NAME . ' as hn'] = ['hn.HAZ_ID = cau.FK_HAZ_ID', 'left'];
        $optns['join'][HAZA_TYPE . ' as ty'] = ['ty.HAZ_TYPE_AUTO_ID = cau.FK_HAZ_TYPE_ID', 'left'];
        $optns['join'][PRO_ACT_AREA . ' as pro'] = ['pro.PRO_AUTO_ID = cau.FK_PRO_ID', 'left'];

        $optns['group_by'] = ['cau.FK_HAZ_ID'];
        $listResp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $optns);
//        echo $this->db->last_query();exit;
//        echo '<pre>';
//        print_r($listResp);
//        exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listResp) && !empty($listResp)) {
            foreach ($listResp as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->FK_HAZ_ID);

                $action .= " " . anchor('hirarc/master/addcauseAffect/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));

                $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deletecause', 'title' => 'Delete', 'delt-id' => $id));
//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

                $rows = [];
                $rows[] = ucfirst($ltVal->PRO_NAME);
                $rows[] = ucfirst($ltVal->HAZ_TYPE_NAME);
                $rows[] = ucfirst($ltVal->HAZ_NAME);
                $rows[] = ucfirst($ltVal->CAUSE_NAME);
                $rows[] = convertDate($ltVal->CREATED_ON);
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

    public function addcauseAffect($id = '') {
        $did = decryptval($id);
        $getCausedatas = [];
        $getHazardNamedatas = [];

        if ($id != '') {
            $optWhr['where'] = [
                'c.FK_HAZ_ID' => $did,
                'c.CAUSE_STATUS' => 'Y',
                'hn.HAZ_STATUS' => 'Y'
            ];
            $optWhr['return_type'] = 'result';
            $optWhr['join'][HAZA_NAME . ' as hn'] = ['hn.HAZ_ID = c.FK_HAZ_ID', 'left'];
            $getCausedatas = $this->common_model->getAlldata(HAZA_CAU . ' as c', ['c.*'], $optWhr);
        }

        $hazrtyWhere['where'] = [
            'HAZ_STATUS' => 'Y'
        ];
        $hazardNamedatas = $this->common_model->getAlldata(HAZA_NAME, ['*'], $hazrtyWhere);
        if (is_array($hazardNamedatas)) {
            $getHazardNamedatas = customFormDropDown($hazardNamedatas, 'HAZ_ID', 'HAZ_NAME', 'Select Hazard Name');
        }
        $data = array(
            'view_file' => 'master/causeAffect/add_causeAffect',
            'current_menu' => 'Add Cause Affect ',
            'getCausedatas' => $getCausedatas,
            'getHazardNamedatas' => $getHazardNamedatas
        );
        $this->template->load_common_template($data);
    }

    public function savecauseAffect($id = '') {

        $did = decryptval($id);
        $cauDatas = $this->input->post('cau');
        $this->form_validation->set_rules('cau[FK_HAZ_ID]', 'Hazard Name', 'required|trim');
        $this->form_validation->set_rules('cau[cau_name][]', 'Cause Affect Name', 'required|trim|min_length[2]|max_length[200]|alpha_dash_space');
//        print_r($cauDatas); exit;
        if ($this->form_validation->run()) {
            $cau_name = postData($cauDatas, 'cau_name');
            $haz_id = postData($cauDatas, 'FK_HAZ_ID');
            $cau_ID = postData($cauDatas, 'CAUSE_AUTO_ID');
            if ($haz_id != '' && $haz_id > 0) {
                $hazWhr['where'] = [
                    'HAZ_ID' => $haz_id,
                    'HAZ_STATUS' => 'Y'
                ];
                $hazWhr['return_type'] = 'row';
                $getHazardNamedatas = $this->common_model->getAlldata(HAZA_NAME, ['HIR_HAZA_ID'], $hazWhr);
                $hazDWhr['where'] = [
                    'HAZ_AUTO_ID' => $getHazardNamedatas->HIR_HAZA_ID,
                    'HAZ_STATUS' => 'Y'
                ];
                $hazDWhr['return_type'] = 'row';
                $getHazdatas = $this->common_model->getAlldata(HAZA, ['FK_PRO_ID,FK_HAZ_TYPE_ID'], $hazDWhr);
            }
            if ($did != '' && $did > 0) {
                $CauNameWhr['where'] = [
                    'FK_HAZ_ID' => $did,
                    'CAUSE_STATUS' => 'Y'
                ];
                $CauNameWhr['return_type'] = 'result';
                $getCausedatas = $this->common_model->getAlldata(HAZA_CAU, ['CAUSE_AUTO_ID'], $CauNameWhr);
                foreach ($cau_ID as $key => $hazNId) {
                    $cauNaId[] = $hazNId;
                }
                foreach ($getCausedatas as $key => $val) {
                    if (in_array($val->CAUSE_AUTO_ID, $cauNaId) == FALSE) {
                        $uphazadatas = [
                            'CAUSE_STATUS' => 'N'
                        ];
                        $upHWhere = [
                            'CAUSE_AUTO_ID' => $val->CAUSE_AUTO_ID
                        ];
                        $updtProfile = $this->common_model->updateData(HAZA_CAU, $uphazadatas, $upHWhere);
                    }
                }
            }

            foreach ($cau_name as $k => $value) {
                $hazadatas = [
                    'FK_HAZ_ID' => $haz_id,
                    'FK_PRO_ID' => $getHazdatas->FK_PRO_ID,
                    'FK_HAZ_TYPE_ID' => $getHazdatas->FK_HAZ_TYPE_ID,
                    'CAUSE_NAME' => $value
                ];
                if ($cau_ID[$k] != '') {
                    $upWhere = [
                        'CAUSE_AUTO_ID' => $cau_ID[$k]
                    ];
                    $updtProfile = $this->common_model->updateData(HAZA_CAU, $hazadatas, $upWhere);
                } else {
                    $updtProfile = $this->common_model->updateData(HAZA_CAU, $hazadatas);
                }
            }

            if ($updtProfile && $updtProfile > 0) {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Cause Effect has been Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Cause Effect has been Created</div>');
                }
                redirect('hirarc/master/causeAffect');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Cause Effect cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Cause Effect cannot be Created</div>');
                }
                redirect('hirarc/master/causeAffect');
            }
        } else {
            $this->addcauseAffect($id);
        }
    }

    public function deleteCauseAff() {
        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(HAZA_CAU, ['CAUSE_STATUS' => 'N'], ['FK_HAZ_ID' => decryptval($deleteId)]);
//        $updtHazNameDelete = $this->common_model->updateData(HAZA_NAME, ['HAZ_STATUS' => 'N'], ['HIR_HAZA_ID' => decryptval($deleteId)]);
        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Cause Effect has been deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Cause Effect! Try Again later.'
            ];
        }
        echo json_encode($retData);
    }

//// Cause Effect master end
    //// riskControl master start
    public function riskControl() {
        $data = array(
            'view_file' => 'master/riskcontrol/list_riskcontrol',
            'site_title' => 'Risk Control',
            'current_menu' => 'List Risk Control ',
            'ajaxurl' => 'hirarc/master/list_RiskControl',
        );

        $this->template->load_table_template($data);
    }

    public function list_RiskControl() {
        $where['ex.CONTROL_STATUS'] = 'Y';
        $table = EXIT_RI_CN . ' as ex';
        $column_order = array('FK_PRO_ID', 'FK_HAZ_TYPE_ID', 'FK_HAZ_ID', 'FK_CAUSE_ID', 'CONTROL_NAME', 'CREATED_ON', null);
        $column_search = array('FK_PRO_ID', 'FK_HAZ_TYPE_ID', 'FK_HAZ_ID', 'CAUSE_NAME', 'CONTROL_NAME', 'CREATED_ON');
        $order = array('ex.CONTROL_AUTO_ID' => 'desc');
        $optns['select'] = 'ty.HAZ_TYPE_NAME,pro.PRO_NAME,hn.HAZ_NAME,ex.CREATED_ON,ex.FK_CAUSE_ID,cau.CAUSE_NAME,group_concat(DISTINCT(ex.CONTROL_NAME)) as CONTROL_NAME';
        $optns['join'][HAZA_NAME . ' as hn'] = ['hn.HAZ_ID = ex.FK_HAZ_ID', 'left'];
        $optns['join'][HAZA_TYPE . ' as ty'] = ['ty.HAZ_TYPE_AUTO_ID = ex.FK_HAZ_TYPE_ID', 'left'];
        $optns['join'][PRO_ACT_AREA . ' as pro'] = ['pro.PRO_AUTO_ID = ex.FK_PRO_ID', 'left'];
        $optns['join'][HAZA_CAU . ' as cau'] = ['cau.CAUSE_AUTO_ID = ex.FK_CAUSE_ID', 'left'];

        $optns['group_by'] = ['ex.FK_CAUSE_ID'];
        $listResp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $optns);
//        echo $this->db->last_query();exit;
//        echo '<pre>';
//        print_r($listResp);
//        exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listResp) && !empty($listResp)) {
            foreach ($listResp as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->FK_CAUSE_ID);

                $action .= " " . anchor('hirarc/master/addRiskControl/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));

                $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteriskcont', 'title' => 'Delete', 'delt-id' => $id));
//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

                $rows = [];
                $rows[] = ucfirst($ltVal->PRO_NAME);
                $rows[] = ucfirst($ltVal->HAZ_TYPE_NAME);
                $rows[] = ucfirst($ltVal->HAZ_NAME);
                $rows[] = ucfirst($ltVal->CAUSE_NAME);
                $rows[] = ucfirst($ltVal->CONTROL_NAME);
                $rows[] = convertDate($ltVal->CREATED_ON);
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

    public function addRiskControl($id = '') {
        $did = decryptval($id);
        $getExistdatas = [];
        $getcauseNamedatas = [];

        if ($id != '') {
            $optWhr['where'] = [
                'FK_CAUSE_ID' => $did,
                'CONTROL_STATUS' => 'Y'
            ];
            $optWhr['return_type'] = 'result';
            $getExistdatas = $this->common_model->getAlldata(EXIT_RI_CN, ['*'], $optWhr);
        }
        $hazrtyWhere['where'] = [
            'CAUSE_STATUS' => 'Y'
        ];
        $causeNamedatas = $this->common_model->getAlldata(HAZA_CAU, ['*'], $hazrtyWhere);
        if (is_array($causeNamedatas)) {
            $getcauseNamedatas = customFormDropDown($causeNamedatas, 'CAUSE_AUTO_ID', 'CAUSE_NAME', 'Select Cause Name');
        }
        $data = array(
            'view_file' => 'master/riskcontrol/add_riskcontrol',
            'current_menu' => 'Add Existing Risk Control ',
            'getExistdatas' => $getExistdatas,
            'getcauseNamedatas' => $getcauseNamedatas
        );
        $this->template->load_common_template($data);
    }

    public function saveRiskControl($id = '') {

        $did = decryptval($id);
        $exitDatas = $this->input->post('risk');
        $this->form_validation->set_rules('risk[FK_CAUSE_ID]', 'Cause Affect', 'required|trim');
        $this->form_validation->set_rules('risk[contr_name][]', 'Existing Risk Control', 'required|trim|min_length[2]|alpha_dash_space');
//        print_r($exitDatas);
        if ($this->form_validation->run()) {
            $contr_name = postData($exitDatas, 'contr_name');
            $cau_id = postData($exitDatas, 'FK_CAUSE_ID');
            $cntrl_ID = postData($exitDatas, 'CONTROL_AUTO_ID');
            $getCausedatas = [];
            if ($cau_id != '' && $cau_id > 0) {
                $hazWhr['where'] = [
                    'CAUSE_AUTO_ID' => $cau_id,
                    'CAUSE_STATUS' => 'Y'
                ];
                $hazWhr['return_type'] = 'row';
                $getCausedatas = $this->common_model->getAlldata(HAZA_CAU, ['FK_HAZ_ID,FK_PRO_ID,FK_HAZ_TYPE_ID'], $hazWhr);
            }
            if ($did != '' && $did > 0) {
                $CauNameWhr['where'] = [
                    'FK_CAUSE_ID' => $did,
                    'CONTROL_STATUS' => 'Y'
                ];
                $CauNameWhr['return_type'] = 'result';
                $getExistdatas = $this->common_model->getAlldata(EXIT_RI_CN, ['CONTROL_AUTO_ID'], $CauNameWhr);
                foreach ($cntrl_ID as $key => $hazNId) {
                    $cauNaId[] = $hazNId;
                }
                foreach ($getExistdatas as $key => $val) {
                    if (in_array($val->CONTROL_AUTO_ID, $cauNaId) == FALSE) {
                        $uphazadatas = [
                            'CONTROL_STATUS' => 'N'
                        ];
                        $upHWhere = [
                            'CONTROL_AUTO_ID' => $val->CONTROL_AUTO_ID
                        ];
                        $updtProfile = $this->common_model->updateData(EXIT_RI_CN, $uphazadatas, $upHWhere);
                    }
                }
            }
            foreach ($contr_name as $k => $value) {
                $hazadatas = [
                    'FK_CAUSE_ID' => $cau_id,
                    'FK_HAZ_ID' => $getCausedatas->FK_HAZ_ID,
                    'FK_PRO_ID' => $getCausedatas->FK_PRO_ID,
                    'FK_HAZ_TYPE_ID' => $getCausedatas->FK_HAZ_TYPE_ID,
                    'CONTROL_NAME' => $value
                ];
                if ($cntrl_ID[$k] != '') {
                    $upWhere = [
                        'CONTROL_AUTO_ID' => $cntrl_ID[$k]
                    ];
                    $updtProfile = $this->common_model->updateData(EXIT_RI_CN, $hazadatas, $upWhere);
                } else {
                    $updtProfile = $this->common_model->updateData(EXIT_RI_CN, $hazadatas);
                }
            }

            if ($updtProfile && $updtProfile > 0) {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Existing Risk Control has been Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Existing Risk Control has been Created</div>');
                }
                redirect('hirarc/master/riskControl');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Existing Risk Control cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Existing Risk Control cannot be Created</div>');
                }
                redirect('hirarc/master/riskControl');
            }
        } else {
            $this->addcauseAffect($id);
        }
    }

    public function deleteRiskControl() {
        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(EXIT_RI_CN, ['CONTROL_STATUS' => 'N'], ['FK_CAUSE_ID' => decryptval($deleteId)]);
//        $updtHazNameDelete = $this->common_model->updateData(HAZA_NAME, ['HAZ_STATUS' => 'N'], ['HIR_HAZA_ID' => decryptval($deleteId)]);
        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Existing Risk Control has been deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Existing Risk Control! Try Again later.'
            ];
        }
        echo json_encode($retData);
    }

//// Cause Effect master end

    /*
     * riskmatrix Start
     */

    public function riskmatrix() {
        $data = array(
            'pageTitle' => 'Risk Matrix',
            'view_file' => 'master/riskmatrix/list_form',
            'site_title' => 'Risk Matrix Info',
            'current_menu' => 'List Risk Matrix',
            'ajaxurl' => 'hirarc/master/list_riskmatrix',
        );

        $this->template->load_table_template($data);
    }

    public function list_riskmatrix() {
        $table = RISK_RATE;
        $column_order = array('SEVERITY', 'LIKELIHOOD', 'RISK_RATE', 'RISK_LEVEL_COL_CODE', 'CREATED_ON', null);
        $column_search = array('SEVERITY', 'LIKELIHOOD', 'RISK_RATE', 'RISK_LEVEL_COL_CODE', 'CREATED_ON');
        $order = array('CREATED_ON' => 'desc');
        $where = ['RISK_RATE_STATUS' => 'Y'];

        $listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where);

        $finalDatas = [];
        if (isset($listIncicat) && !empty($listIncicat)) {
            foreach ($listIncicat as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->RISK_RATE_AUTO_ID;

                $action .= " " . anchor('hirarc/master/addriskmatrix/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'risk_target', 'title' => 'Edit'));

                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteriskm', 'title' => 'Delete', 'delt-id' => $id));


                $rows = [];
                $rows[] = $ltVal->SEVERITY;
                $rows[] = $ltVal->LIKELIHOOD;
                $rows[] = $ltVal->RISK_RATE;
                $rows[] = '<div style="background-color:' . $ltVal->RISK_LEVEL_COL_CODE . ';width: 91%;height: 20px;"></div>';
                $rows[] = convertDate($ltVal->CREATED_ON);
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

    public function addriskmatrix($id = '') {
        global $severity;
        global $likelhood;
        $getriskratedatas = [];
        if ($id != '') {
            $optWhr['where'] = [
                'RISK_RATE_AUTO_ID' => $id
            ];
            $optWhr['return_type'] = 'row';
            $getriskratedatas = $this->common_model->getAlldata(RISK_RATE, ['*'], $optWhr);
        }

        $data = array(
            'view_file' => 'hirarc/master/riskmatrix/add_form',
            'current_menu' => 'Add Risk Matrix',
            'getriskratedatas' => $getriskratedatas,
            'severity' => $severity,
            'likelhood' => $likelhood
        );
        $this->template->load_popup_template($data);
    }

    public function saveriskmatrix() {
        $sev = $this->input->post('SEVERITY');
        $likel = $this->input->post('LIKELIHOOD');
        $risk = $this->input->post('RISK_RATE');
        $colr = $this->input->post('COLOR_CODE');
        $getproactId = $this->input->post('RISK_RATE_AUTO_ID');

        $this->form_validation->set_rules('SEVERITY', 'Severity', 'required|trim');
        $this->form_validation->set_rules('LIKELIHOOD', 'Likelhood', 'required|trim');

        if ($this->form_validation->run()) {
            $updateData = [
                'SEVERITY' => $sev,
                'LIKELIHOOD' => $likel,
                'RISK_RATE' => $risk,
                'RISK_LEVEL_COL_CODE' => $colr
            ];
            $updtWhr = [];
            if ($getproactId > 0) {
                $updtWhr = [
                    'RISK_RATE_AUTO_ID' => $getproactId
                ];
            }

            $updateInfo = $this->common_model->updateData(RISK_RATE, $updateData, $updtWhr, 'RISK_RATE_AUTO_ID');

            if (!empty($updateInfo)) {

                $data = [
                    'status' => true
                ];
                if ($getproactId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Risk Matrix has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Risk Matrix has been Created</div>');
                }
            } else {
                $data = [
                    'status' => false
                ];
                if ($getproactId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Risk Matrix cannot be Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Risk Matrix cannot be Created</div>');
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

    public function deleteriskmatrix() {

        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(RISK_RATE, ['RISK_RATE_STATUS' => 'N'], ['RISK_RATE_AUTO_ID' => $deleteId]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Risk Matrix deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Risk Matrix'
            ];
        }
        echo json_encode($retData);
    }

    /*
     * Risk Matrix End
     */
}
