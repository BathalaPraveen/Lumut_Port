<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isLogin();
    }
    /*
     * Event Related Name
     */
    public function event_related_info() {
        $data = array(
            'pageTitle' => 'Incident Event Related Info',
            'view_file' => 'master/event_related/list_form',
            'site_title' => 'Incident Event Related Info',
            'current_menu' => 'List Incident Event Related Info',
            'ajaxurl' => 'incident/master/list_event_related',
        );

        $this->template->load_table_template($data);
    }

    public function list_event_related() {
        $table = INC_EVENT_RELATE;
        $column_order = array(null, 'INCIDENT_EVENT_NAME', 'CREATED_ON', null);
        $column_search = array('INCIDENT_EVENT_NAME', 'CREATED_ON');
        $order = array('CREATED_ON' => 'DESC');
        $where = ['INCIDENT_EVENT_STATUS' => 'Y'];

        $listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where);

        $finalDatas = [];
        if (isset($listIncicat) && !empty($listIncicat)) {
            foreach ($listIncicat as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->INCIDENT_EVENT_ID;

                $action .= " " . anchor('incident/master/addIncEventRelatedInfo/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'inc_event_target', 'title' => 'Edit'));

                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteInccat', 'title' => 'Delete', 'delt-id' => $id));
               

                $rows = [];
                $rows[] = $ltVal->INCIDENT_EVENT_NAME;
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

    public function addIncEventRelatedInfo($id = '') {
        $getInccatdatas = [];
        if ($id != '') {
            $optWhr['where'] = [
                'INCIDENT_EVENT_ID' => $id
            ];
            $optWhr['return_type'] = 'row';
            $getInccatdatas = $this->common_model->getAlldata(INC_EVENT_RELATE, ['*'], $optWhr);
        }

        $data = array(
            'view_file' => 'incident/master/event_related/add_form',
            'current_menu' => 'Add Incident Category',
            'getInccatdatas' => $getInccatdatas
        );
        $this->template->load_popup_template($data);
    }
    
    public function saveIncEventRelate(){
       $getInccatdatas = $this->input->post();
       $editId = postData($getInccatdatas, 'inc_event_id');
       
       if ($editId > 0) {
          $this->form_validation->set_rules('inci_event_related', 'Incident Event Related Name', 'required|min_length[3]|max_length[50]|is_unique[' . INC_EVENT_RELATE . '.INCIDENT_EVENT_NAME.INCIDENT_EVENT_ID.' . $editId . '.INCIDENT_EVENT_STATUS != .N]');
         
        } else {
          $this->form_validation->set_rules('inci_event_related', 'Incident Event Related Name', 'required|min_length[3]|max_length[50]|is_unique['.INC_EVENT_RELATE.'.INCIDENT_EVENT_NAME.INCIDENT_EVENT_STATUS.N]');
        }
        

        if ($this->form_validation->run() == true) {
           
            $updateData = [
                'INCIDENT_EVENT_NAME' => postData($getInccatdatas, 'inci_event_related'),
               
            ];
            $updtWhr = [];
            if ($editId > 0) {
                $updtWhr = [
                    'INCIDENT_EVENT_ID' => $editId
                ];
            }


            $updateInfo = $this->common_model->updateData(INC_EVENT_RELATE, $updateData, $updtWhr, 'INCIDENT_EVENT_ID');
            
            if (!empty($updateInfo)) {

                $data = [
                    'status' => true
                ];
                if ($editId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Incident Event Related Name has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Incident Event Related Name has been Created</div>');
                }
            } else {
                $data = [
                    'status' => false
                ];
                if ($editId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Incident Event Related Name cannot be Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inccatflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Incident Event Related Name cannot be Created</div>');
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
    
    public function deleteIncEventRelatedInfo() {

        $deleteId = $this->input->post('delid');
        //echo '<pre>';print_r($deleteId);exit;
        $updtDelete = $this->common_model->updateData(INC_EVENT_RELATE, ['INCIDENT_EVENT_STATUS' => 'N'], ['INCIDENT_EVENT_ID' => $deleteId]);
        //echo '<pre>';print_r($updtDelete);exit;

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Incident Event Related Name deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Incident Event Related Name'
            ];
        }
        echo json_encode($retData);
    }
    
    /*
     * Glossary of Incident Related Terms
     */
    public function event_related_term() {
        $data = array(
            'pageTitle' => 'Incident Event Related Term',
            'view_file' => 'master/event_related_term/list_form',
            'site_title' => 'Incident Event Related Term',
            'current_menu' => 'List Incident Event Related Term',
            'ajaxurl' => 'incident/master/list_event_related_term',
        );

        $this->template->load_table_template($data);
    }

    public function list_event_related_term() {
        $table = INC_EVENT_GLOSSARY;
        $column_order = array(null, 'GLOSSARY_NAME','FN_INC_EVENT_RELATED_NAME(INC_EVENT_RELATED_ID)', 'CREATED_ON', null);
        $column_search = array('GLOSSARY_NAME', 'FN_INC_EVENT_RELATED_NAME(INC_EVENT_RELATED_ID)','CREATED_ON');
        $order = array('GLOSSARY_INFO_ID' => 'DESC');
        $where = ['GLOSSARY_STATUS' => 'Y'];
        $options['select'] = ['GLOSSARY_INFO_ID', 'GLOSSARY_NAME','FN_INC_EVENT_RELATED_NAME(INC_EVENT_RELATED_ID) as CAT_NAME', 'CREATED_ON'];

        $listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where,$options);

        $finalDatas = [];
        if (isset($listIncicat) && !empty($listIncicat)) {
            foreach ($listIncicat as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->GLOSSARY_INFO_ID;

                $action .= " " . anchor('incident/master/addIncEventRelatedTerm/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'inc_event_target', 'title' => 'Edit'));

                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteInccat', 'title' => 'Delete', 'delt-id' => $id));
               

                $rows = [];
                $rows[] = $ltVal->GLOSSARY_NAME;
                $rows[] = $ltVal->CAT_NAME;
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
    
    
    public function addIncEventRelatedTerm($id = '') {
        $getInccatdatas = [];
        if ($id != '') {
            $optWhr['where'] = [
                'GLOSSARY_INFO_ID' => $id
            ];
            $optWhr['return_type'] = 'row';
            $getInccatdatas = $this->common_model->getAlldata(INC_EVENT_GLOSSARY, ['*'], $optWhr);
        }
        $opteWhr['where'] = ['INCIDENT_EVENT_STATUS' => 'Y'];
        $eventReltedList = $this->common_model->getAlldata(INC_EVENT_RELATE, ['*'], $opteWhr);
        //echo '<pre>';print_r($eventReltedList);exit;
        $eventRelatedListInfo = customFormDropDown($eventReltedList,'INCIDENT_EVENT_ID','INCIDENT_EVENT_NAME','Select Incident Event Related Name');
        $data = array(
            'view_file' => 'incident/master/event_related_term/add_form',
            'current_menu' => 'Add Incident Event Related Term',
            'eventReltedList' => $eventRelatedListInfo,
            'getInccatdatas' => $getInccatdatas
        );
       
        $this->template->load_popup_template($data);
    }
    
    public function saveIncEventRelatedTerm(){
        $getInccatdatas = $this->input->post();
       $editId = postData($getInccatdatas, 'edit_id');
       $eventRealId = postData($getInccatdatas, 'inci_event_related');
       
       if ($editId > 0) {
          $this->form_validation->set_rules('inci_event_related_term', 'Incident Event Related Term', 'required|min_length[3]|max_length[50]|is_unique[' . INC_EVENT_GLOSSARY . '.GLOSSARY_NAME.GLOSSARY_INFO_ID.' . $editId . '.GLOSSARY_STATUS.N.INC_EVENT_RELATED_ID = .'.$eventRealId.']');
         
        } else {
          $this->form_validation->set_rules('inci_event_related_term', 'Incident Event Related Term', 'required|min_length[3]|max_length[50]|is_unique['.INC_EVENT_GLOSSARY.'.GLOSSARY_NAME.GLOSSARY_STATUS.N.INC_EVENT_RELATED_ID = .'.$eventRealId.']');
        }
        

        if ($this->form_validation->run() == true) {
          
            $updateData = [
                'GLOSSARY_NAME' => postData($getInccatdatas, 'inci_event_related_term'),
                'INC_EVENT_RELATED_ID' => $eventRealId,
               
            ];
            $updtWhr = [];
            if ($editId > 0) {
                $updtWhr = [
                    'GLOSSARY_INFO_ID' => $editId
                ];
            }


            $updateInfo = $this->common_model->updateData(INC_EVENT_GLOSSARY, $updateData, $updtWhr, 'GLOSSARY_INFO_ID');
            
            if (!empty($updateInfo)) {

                $data = [
                    'status' => true
                ];
                if ($editId  > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inceventtermflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Incident Event Related Term has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inceventtermflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Incident Event Related Term has been Created</div>');
                }
            } else {
                $data = [
                    'status' => false
                ];
                if ($editId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inceventtermflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Incident Event Related Term cannot be Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inceventtermflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Incident Event Related Term cannot be Created</div>');
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
    

    public function deleteIncEventTerm() {

        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(INC_EVENT_GLOSSARY, ['GLOSSARY_STATUS' => 'N'], ['GLOSSARY_INFO_ID' => $deleteId]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Incident Event Related Term deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Incident Event Related Term'
            ];
        }
        echo json_encode($retData);
    }
    
    /*
     * Event Type
     */
    public function event_type() {
        $data = array(
            'pageTitle' => 'Incident Event Type',
            'view_file' => 'master/event_type/list_form',
            'site_title' => 'Incident Event Type',
            'current_menu' => 'List Incident Event Type',
            'ajaxurl' => 'incident/master/list_event_type',
        );

        $this->template->load_table_template($data);
    }

    public function list_event_type() {
        $table = INC_EVENT_TYPE;
        $column_order = array(null, 'EVENT_TYPE_NAME', 'CREATED_ON', null);
        $column_search = array('EVENT_TYPE_NAME', 'CREATED_ON');
        $order = array('CREATED_ON' => 'desc');
        $where = ['EVENT_TYPE_STATUS' => 'Y'];

        $listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where);

        $finalDatas = [];
        if (isset($listIncicat) && !empty($listIncicat)) {
            foreach ($listIncicat as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->EVENT_TYPE_ID;

                $action .= " " . anchor('incident/master/addIncEventType/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'inc_event_target', 'title' => 'Edit'));

                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteInccat', 'title' => 'Delete', 'delt-id' => $id));
               

                $rows = [];
                $rows[] = $ltVal->EVENT_TYPE_NAME;
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

    public function addIncEventType($id = '') {
        $getInccatdatas = [];
        if ($id != '') {
            $optWhr['where'] = [
                'EVENT_TYPE_ID' => $id
            ];
            $optWhr['return_type'] = 'row';
            $getInccatdatas = $this->common_model->getAlldata(INC_EVENT_TYPE, ['*'], $optWhr);
        }

        $data = array(
            'view_file' => 'incident/master/event_type/add_form',
            'current_menu' => 'Add Incident Event Type',
            'getInccatdatas' => $getInccatdatas
        );
        $this->template->load_popup_template($data);
    }
    
    public function saveIncEventType(){
       $getInccatdatas = $this->input->post();
       $editId = postData($getInccatdatas, 'inc_event_type_id');
       
       if ($editId > 0) {
          $this->form_validation->set_rules('inci_event_type', 'Incident Event Type', 'required|min_length[3]|max_length[50]|is_unique[' . INC_EVENT_TYPE . '.EVENT_TYPE_NAME.EVENT_TYPE_ID.' . $editId . '.EVENT_TYPE_STATUS != .N]');
         
        } else {
          $this->form_validation->set_rules('inci_event_type', 'Incident Event Type', 'required|min_length[3]|max_length[50]|is_unique['.INC_EVENT_TYPE.'.EVENT_TYPE_NAME.EVENT_TYPE_STATUS.N]');
        }
        

        if ($this->form_validation->run() == true) {
           
            $updateData = [
                'EVENT_TYPE_NAME' => postData($getInccatdatas, 'inci_event_type'),
               
            ];
            $updtWhr = [];
            if ($editId > 0) {
                $updtWhr = [
                    'EVENT_TYPE_ID' => $editId
                ];
            }


            $updateInfo = $this->common_model->updateData(INC_EVENT_TYPE, $updateData, $updtWhr, 'EVENT_TYPE_ID');
            
            if (!empty($updateInfo)) {

                $data = [
                    'status' => true
                ];
                if ($editId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inceventtypeflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Incident Event Type has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inceventtypeflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Incident Event Type has been Created</div>');
                }
            } else {
                $data = [
                    'status' => false
                ];
                if ($editId > 0) {
                    $data['flasmsg'] = $this->session->set_flashdata('inceventtypeflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Incident Event Type cannot be Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('inceventtypeflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Incident Event Type cannot be Created</div>');
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
    
    public function deleteIncEventType() {

        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(INC_EVENT_TYPE, ['EVENT_TYPE_STATUS' => 'N'], ['EVENT_TYPE_ID' => $deleteId]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Incident Event Type deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Incident Event Type'
            ];
        }
        echo json_encode($retData);
    }
    
     /*
     * Glossary of Incident Related Terms
     */
    public function incident_classfication() {
        $data = array(
            'pageTitle' => 'Incident Classification',
            'view_file' => 'master/incident_classification/list_form',
            'site_title' => 'Incident Classification',
            'current_menu' => 'List Incident Classification',
            'ajaxurl' => 'incident/master/list_incident_classification',
        );

        $this->template->load_table_template($data);
    }

    public function list_incident_classification() {
        $table = INC_CLASSFICATION;
        $column_order = array(null, 'CLASSFICATION_NAME', 'CREATED_ON', null);
        $column_search = array('CLASSFICATION_NAME','CREATED_ON');
        $order = array('CREATED_ON' => 'DESC');
        $where = ['CLASSFICATION_STATUS' => 'Y'];
       
        $listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where,$options);

        $finalDatas = [];
        if (isset($listIncicat) && !empty($listIncicat)) {
            foreach ($listIncicat as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->CLASSFICATION_MST_ID;

//                $action .= " " . anchor('incident/master/addIncEventRelatedTerm/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'inc_event_target', 'title' => 'Edit'));

                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteInccat', 'title' => 'Delete', 'delt-id' => $id));
               

                $rows = [];
                $rows[] = $ltVal->CLASSFICATION_NAME;
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

     public function deleteIncClassification() {

        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(INC_CLASSFICATION, ['CLASSFICATION_STATUS' => 'N'], ['CLASSFICATION_MST_ID' => $deleteId]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Incident Classification deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Incident Classification'
            ];
        }
        echo json_encode($retData);
    }
    
}
