<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Masters extends CI_Controller {

    public function __construct() {
	parent::__construct();
	isLogin();
    }

    public function areaClassification() {
	$deleteURL = BASE_URL("ptw/masters/deleteAOC");
	$data = array(
	    'pageTitle' => 'Area of Classification',
	    'view_file' => 'master/area_classify/list',
	    'site_title' => 'Area of Classification',
	    'current_menu' => 'List Area of Classification',
	    'ajaxurl' => 'ptw/masters/listAOC',
	    'deleteURL' => $deleteURL,
	);
	$this->template->load_table_template($data);
    }

    public function listAOC() {
	$table = PTW_M_AOC;
	$column_order = array(null, 'CLS_NAME', 'CREATED_ON', null);
	$column_search = array('CLS_NAME', 'CREATED_ON');
	$order = array('CLS_ID' => 'DESC');
	$where = ['STATUS' => 'Y'];

	$mlist = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where);
	$finalDatas = [];
	if (isset($mlist) && !empty($mlist)) {
	    foreach ($mlist as $ltKey => $ltVal) {
		$action = '';
		$id = encryptval($ltVal->CLS_ID);

		$action .= " " . anchor('ptw/masters/addAOC/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'inc_event_target', 'title' => 'Edit'));

		$action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteAOC', 'title' => 'Delete', 'delt-id' => $id));


		$rows = [];
		$rows[] = $ltVal->CLS_NAME;
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

//    public function checkAOC() {
//	$_POST = $_GET;
//	$cls_title = $this->input->post('cls_title');
//	$editId = $this->input->post('editId');
//	if ($editId >0) {
//	    $this->form_validation->set_rules('cls_title', 'Area of Classification', 'trim|required|is_unique['. PTW_M_AOC .'.CLS_NAME.CLS_ID.'. $editId .'.STATUS.N]', array(
//		'required' => 'You have not provided %s.',
//		'is_unique' => 'This %s already exists.'
//		    )
//	    );
//	} else {
//	    $this->form_validation->set_rules('cls_title', 'Area of Classification', 'trim|required|is_unique['. PTW_M_AOC .'.CLS_NAME.STATUS.N]', array(
//		'required' => 'You have not provided %s.',
//		'is_unique' => 'This %s already exists.'
//		    )
//	    );
//	}
//	if ($this->form_validation->run() == true) {
//	    exit;
//	}else{
//	    print_r($this->form_validation->error_array());
//	    exit;
//	}
//	print_r($this->form_validation->run());exit;
//	echo json_encode($this->form_validation->run());
//    }

    public function addAOC($id = "") {
	$getAOCdatas = [];
	if ($id != '') {
	    $editID = decryptval($id);
	    $optWhr['where'] = [
		'CLS_ID' => $editID
	    ];
	    $optWhr['return_type'] = 'row';
	    $getAOCdatas = $this->common_model->getAlldata(PTW_M_AOC, ['*'], $optWhr);
	}
	$data = array(
	    'view_file' => 'ptw/master/area_classify/add',
	    'current_menu' => 'Add Area of Classification',
	    'getAOCdatas' => $getAOCdatas
	);
	$this->template->load_popup_template($data);
    }

    public function saveAOC() {
	$getaocdatas = $this->input->post();
	$editId = postData($getaocdatas, 'cls_id', '');
	if ($editId != "") {
	    $this->form_validation->set_rules('cls_title', 'Area of Classification', 'required|alpha_dash_space|min_length[3]|max_length[50]|is_unique[' . PTW_M_AOC . '.CLS_NAME.STATUS.N.CLS_ID !=.' . $editId . ']');
	} else {
	    $this->form_validation->set_rules('cls_title', 'Area of Classification', 'required|alpha_dash_space|min_length[3]|max_length[50]|is_unique[' . PTW_M_AOC . '.CLS_NAME.STATUS.N]');
	}
	if ($this->form_validation->run() == true) {
	    $updateData = [
		'CLS_NAME' => postData($getaocdatas, 'cls_title')
	    ];
	    $updtWhr = [];
	    if ($editId != "") {
		$updtWhr = [
		    'CLS_ID' => $editId
		];
	    }
	    $updateInfo = $this->common_model->updateData(PTW_M_AOC, $updateData, $updtWhr, $editId);
	    if ($updateInfo >= 1) {
		$data = [
		    'status' => true
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('aocflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Area of Classification has been Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('aocflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Area of Classification has been Created</div>');
		}
	    } else {
		$data = [
		    'status' => false
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('aocflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Area of Classification cannot be Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('aocflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Area of Classification cannot be Created</div>');
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

    public function deleteAOC() {
	$deleteId = decryptval($this->input->post('delid'));
	$updtDelete = $this->common_model->updateData(PTW_M_AOC, ['STATUS' => 'N'], ['CLS_ID' => $deleteId]);

	if ($updtDelete) {
	    $retData = [
		'status' => true,
		'msgs' => 'Area of classification deleted Successfully'
	    ];
	} else {
	    $retData = [
		'status' => false,
		'msgs' => 'Error in deleting Area of classification'
	    ];
	}
	echo json_encode($retData);
    }

    public function hazrdActivities() {
	$deleteURL = BASE_URL("ptw/masters/deleteHA");
	$data = array(
	    'pageTitle' => 'Hazard Activities',
	    'view_file' => 'master/hzrd_activities/list',
	    'site_title' => 'Hazard Activities',
	    'current_menu' => 'List Hazard Activities',
	    'ajaxurl' => 'ptw/masters/listHA',
	    'addLink' => 'ptw/masters/addHA',
	    'deleteURL' => $deleteURL,
	);
	$this->template->load_table_template($data);
    }

    public function listHA() {
	$table = PTW_M_HA;
	$column_order = array(null,  'HZRDA_NAME', 'CREATED_ON', null);
	$column_search = array( 'HZRDA_NAME','CAT_NAME','PTYPE');
	$order = array('HZRDA_ID' => 'DESC');
	$where = [PTW_M_HA.'.STATUS' => 'Y'];
        $options['join'] = [
            PTW_M_HA_CAT.' as cat' =>['cat.HZRDAC_ID = '.PTW_M_HA.'.HZRDAC_REF_ID ','left']
        ];
        $options['select'] = [
            PTW_M_HA.'.*','CAT_NAME',PTW_M_HA.'.CREATED_ON'
        ];

	$mlist = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where,$options);
        
	$finalDatas = [];
	if (isset($mlist) && !empty($mlist)) {
	    foreach ($mlist as $ltKey => $ltVal) {
		$action = '';
		$id = encryptval($ltVal->HZRDA_ID);

		$action .= " " . anchor('ptw/masters/addHA/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'inc_event_target', 'title' => 'Edit'));

		$action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteHA', 'title' => 'Delete', 'delt-id' => $id));


		$rows = [];
		
		$rows[] = $ltVal->PTYPE;
		$rows[] = $ltVal->HZRDA_NAME;
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

    public function addHA($id = "") {
	$getHAdatas = [];
	if ($id != '') {
	    $editID = decryptval($id);
	    $optWhr['where'] = [
		'HZRDA_ID' => $editID
	    ];
	    $optWhr['return_type'] = 'row';
	    $getHAdatas = $this->common_model->getAlldata(PTW_M_HA, ['*'], $optWhr);
	}
        $optWhre['return_type'] = 'result';
        $optWhre['where'] = [
		'STATUS' => 'Y'
	    ];
	$getHACatDetails = $this->common_model->getAlldata(PTW_M_HA_CAT, ['*'], $optWhre);
        $getCatInfo = customFormDropDown($getHACatDetails, 'HZRDAC_ID', 'CAT_NAME',[''=>'Select Activity Category']);
	$data = array(
	    'view_file' => 'ptw/master/hzrd_activities/add',
	    'current_menu' => 'Add Hazard Activities',
	    'getHAdatas' => $getHAdatas,
	    'getHACatDetails' => $getCatInfo
	);
	$this->template->load_popup_template($data);
    }

    public function saveHA() {
	$gethadatas = $this->input->post();
	$editId = postData($gethadatas, 'ha_id', '');
	$hzrdrefId = postData($gethadatas, 'hzrdrefId', 0);
	if ($editId != "") {
	    $this->form_validation->set_rules('hatitle', 'Activity', 'required|addr_line|min_length[3]|max_length[50]|is_unique[' . PTW_M_HA . '.HZRDA_NAME.STATUS.N.HZRDA_ID !=.' . $editId . ']');
	} else {
	    $this->form_validation->set_rules('hatitle', 'Activity', 'required|addr_line|min_length[3]|max_length[50]|is_unique[' . PTW_M_HA . '.HZRDA_NAME.STATUS.N]');
	}
//	$this->form_validation->set_rules('hzrdtype', 'Hazard Type', 'required');
        if($hzrdrefId == 2){
            $this->form_validation->set_rules('hasChecklist', 'Checklist', 'required');
        }
	
	if ($this->form_validation->run() == true) {
	    $updateData = [
		'HZRDAC_REF_ID' => postData($gethadatas, 'hzrdrefId'),
		'PTYPE' => postData($gethadatas, 'hzrdtype'),
		'HZRDA_NAME' => postData($gethadatas, 'hatitle'),
		'HZRDA_CHKLST' => (string)postData($gethadatas, 'hasChecklist')
	    ];
	    $updtWhr = [];
	    if ($editId != "") {
		$updtWhr = [
		    'HZRDA_ID' => $editId
		];
	    }
	    $updateInfo = $this->common_model->updateData(PTW_M_HA, $updateData, $updtWhr, $editId);
	    if ($updateInfo >= 1) {
		$data = [
		    'status' => true
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('haflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Hazard Activities has been Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('haflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Hazard Activities has been Created</div>');
		}
	    } else {
		$data = [
		    'status' => false
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('haflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Hazard Activities cannot be Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('haflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Hazard Activities cannot be Created</div>');
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

    public function deleteHA() {
	$deleteId = decryptval($this->input->post('delid'));
	$updtDelete = $this->common_model->updateData(PTW_M_HA, ['STATUS' => 'N'], ['HZRDA_ID' => $deleteId]);

	if ($updtDelete) {
	    $retData = [
		'status' => true,
		'msgs' => 'Hazard Activities deleted successfully'
	    ];
	} else {
	    $retData = [
		'status' => false,
		'msgs' => 'Error in deleting Hazard Activities'
	    ];
	}
	echo json_encode($retData);
    }

    public function hazardActivityItems() {
	$deleteURL = BASE_URL("ptw/masters/deleteHAI");
	$data = array(
	    'pageTitle' => 'Hazard activities Items',
	    'view_file' => 'master/hzrd_checklist/list',
	    'site_title' => 'Hazard activities Items',
	    'current_menu' => 'Hazard activities Items',
	    'ajaxurl' => 'ptw/masters/listhai',
	    'addLink' => 'ptw/masters/addhai',
	    'deleteURL' => $deleteURL,
	);
	$this->template->load_table_template($data);
    }

    public function listhai() {
	$table = PTW_M_HAI;
	$column_order = array(null, 'FN_PTW_HA_CATEGORY_NAME(REF_HZRDA_ID)', 'HZRDA_CHKL_NAME', 'CREATED_ON', null);
	$column_search = array('FN_PTW_HA_CATEGORY_NAME(REF_HZRDA_ID)', 'HZRDA_CHKL_NAME', 'CREATED_ON');
	$order = array('HZRDA_ITEM_ID' => 'DESC');
	$where = ['STATUS' => 'Y'];
	$options['select'] = ['HZRDA_ITEM_ID', 'FN_PTW_HA_CATEGORY_NAME(REF_HZRDA_ID) as CATNAME', 'HZRDA_CHKL_NAME', 'CREATED_ON'];

	$listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where, $options);
	$finalDatas = [];
	if (isset($listIncicat) && !empty($listIncicat)) {
	    foreach ($listIncicat as $ltKey => $ltVal) {

		$action = '';
		$id = encryptval($ltVal->HZRDA_ITEM_ID);
		$action .= " " . anchor('ptw/masters/addhai/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'inc_event_target', 'title' => 'Edit'));

		$action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteHAI', 'title' => 'Delete', 'delt-id' => $id));


		$rows = [];
//		$rows[] = $ltVal->CATNAME;
		$rows[] = $ltVal->HZRDA_CHKL_NAME;
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

    public function addhai($id = "") {
	$getWpidatas = [];
	if ($id != '') {
	    $editID = decryptval($id);
	    $optWhr['where'] = [
		'HZRDA_ITEM_ID' => $editID
	    ];
	    $optWhr['return_type'] = 'row';
	    $getWpidatas = $this->common_model->getAlldata(PTW_M_HAI, ['*'], $optWhr);
	}
	$catOpt['where'] = [
	    'STATUS' => 'Y',
	    'HZRDA_CHKLST' => 'Y',
	    'HZRDA_TYPE' => 'CRITICAL'
	];
	$getCatdatas = $this->common_model->getAlldata(PTW_M_HA, ['*'], $catOpt);
	$catDrops = customFormDropDown($getCatdatas, 'HZRDA_ID', 'HZRDA_NAME', 'Select Category');
	$data = array(
	    'view_file' => 'ptw/master/hzrd_checklist/add',
	    'current_menu' => 'Add Hazard Activity Item',
	    'getCatdatas' => $catDrops,
	    'getWpidatas' => $getWpidatas
	);
	$this->template->load_popup_template($data);
    }

    public function savehai() {
	$gethadatas = $this->input->post();
	$editId = postData($gethadatas, 'hac_id', '');
	if ($editId != "") {
	    $this->form_validation->set_rules('hachklst', 'Checklist Name', 'required|description_line|min_length[3]|max_length[200]|is_unique[' . PTW_M_HAI . '.HZRDA_CHKL_NAME.STATUS.N.HZRDA_ITEM_ID != .' . $editId . ']');
	} else {
	    $this->form_validation->set_rules('hachklst', 'Checklist Name', 'required|description_line|min_length[3]|max_length[200]|is_unique[' . PTW_M_HAI . '.HZRDA_CHKL_NAME.STATUS.N]');
	}
//	$this->form_validation->set_rules('hzrdtype', 'Hazard Type', 'required');
	if ($this->form_validation->run() == true) {
	    $updateData = [
//		'REF_HZRDA_ID' => postData($gethadatas, 'hzrdtype'),
		'HZRDA_CHKL_NAME' => postData($gethadatas, 'hachklst')
	    ];
	    $updtWhr = [];
	    if ($editId != "") {
		$updtWhr = [
		    'HZRDA_ITEM_ID' => $editId
		];
	    }
	    $updateInfo = $this->common_model->updateData(PTW_M_HAI, $updateData, $updtWhr, $editId);
	    if ($updateInfo >= 1) {
		$data = [
		    'status' => true
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('haiflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Item has been Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('haiflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Item has been Created</div>');
		}
	    } else {
		$data = [
		    'status' => false
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('haiflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Item cannot be Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('haiflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Item cannot be Created</div>');
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

    public function deleteHAI() {
	$deleteId = decryptval($this->input->post('delid'));
	$updtDelete = $this->common_model->updateData(PTW_M_HAI, ['STATUS' => 'N'], ['HZRDA_ITEM_ID' => $deleteId]);

	if ($updtDelete) {
	    $retData = [
		'status' => true,
		'msgs' => 'Item deleted successfully'
	    ];
	} else {
	    $retData = [
		'status' => false,
		'msgs' => 'Error in deleting Item'
	    ];
	}
	echo json_encode($retData);
    }

    public function attachments() {
	$deleteURL = BASE_URL("ptw/masters/deleteAT");
	$data = array(
	    'pageTitle' => 'Attachments',
	    'view_file' => 'master/attachments/list',
	    'site_title' => 'Attachments',
	    'current_menu' => 'List Attachments',
	    'ajaxurl' => 'ptw/masters/listAT',
	    'deleteURL' => $deleteURL,
	);
	$this->template->load_table_template($data);
    }

    public function listAT() {
	$table = PTW_M_ADOCS;
	$column_order = array(null, 'ADD_DOC_PTW_TYPE','ADD_DOC_CATEGORY', 'ADD_DOC_NAME', 'CREATED_ON', null);
	$column_search = array('ADD_DOC_PTW_TYPE','ADD_DOC_CATEGORY', 'ADD_DOC_NAME');
	$order = array('ADD_DOC_ID' => 'DESC');
	$where = ['STATUS' => 'Y'];

	$mlist = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where);

	$finalDatas = [];
	if (isset($mlist) && !empty($mlist)) {
	    foreach ($mlist as $ltKey => $ltVal) {
		$action = '';
		$id = encryptval($ltVal->ADD_DOC_ID);

		$action .= " " . anchor('ptw/masters/addAT/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'inc_event_target', 'title' => 'Edit'));

		$action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteAT', 'title' => 'Delete', 'delt-id' => $id));


		$rows = [];
		$rows[] = $ltVal->ADD_DOC_PTW_TYPE;
		$rows[] = $ltVal->ADD_DOC_CATEGORY;
		$rows[] = $ltVal->ADD_DOC_NAME;
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

    public function addAT($id = "") {
	$getATdatas = [];
	if ($id != '') {
	    $editID = decryptval($id);
	    $optWhr['where'] = [
		'ADD_DOC_ID' => $editID
	    ];
	    $optWhr['return_type'] = 'row';
	    $getATdatas = $this->common_model->getAlldata(PTW_M_ADOCS, ['*'], $optWhr);
	}
	$data = array(
	    'view_file' => 'ptw/master/attachments/add',
	    'current_menu' => 'Add Documents',
	    'getATdatas' => $getATdatas
	);
	$this->template->load_popup_template($data);
    }

    public function saveAT() {
	$gethadatas = $this->input->post();
	$editId = postData($gethadatas, 'doc_id', '');
	$ptwtype = postData($gethadatas, 'docptwtype', '');
	if ($editId != "") {
	    $this->form_validation->set_rules('docname', 'Document Name', 'required|description_line|min_length[3]|max_length[50]|is_unique[' . PTW_M_ADOCS . '.ADD_DOC_NAME.STATUS.N.ADD_DOC_ID != .' . $editId . '.ADD_DOC_ID != .' . $editId . ']');
	} else {
	    $this->form_validation->set_rules('docname', 'Document Name', 'required|description_line|min_length[3]|max_length[50]|is_unique[' . PTW_M_ADOCS . '.ADD_DOC_NAME.STATUS.N]');
	}
	$this->form_validation->set_rules('doccat', 'Document Category', 'required');
	$this->form_validation->set_rules('docptwtype', 'Document Type', 'required');
	if ($this->form_validation->run() == true) {
	    $updateData = [
		'ADD_DOC_PTW_TYPE' => postData($gethadatas, 'docptwtype'),
		'ADD_DOC_CATEGORY' => postData($gethadatas, 'doccat'),
		'ADD_DOC_NAME' => postData($gethadatas, 'docname')
	    ];
	    $updtWhr = [];
	    if ($editId != "") {
		$updtWhr = [
		    'ADD_DOC_ID' => $editId
		];
	    }
	    $updateInfo = $this->common_model->updateData(PTW_M_ADOCS, $updateData, $updtWhr, $editId);
	    if ($updateInfo >= 1) {
		$data = [
		    'status' => true
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('atflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Additional Documents has been Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('atflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Additional Documents has been Created</div>');
		}
	    } else {
		$data = [
		    'status' => false
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('atflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Additional Documents cannot be Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('atflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Additional Documents cannot be Created</div>');
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

    public function deleteAT() {
	$deleteId = decryptval($this->input->post('delid'));
	$updtDelete = $this->common_model->updateData(PTW_M_ADOCS, ['STATUS' => 'N'], ['ADD_DOC_ID' => $deleteId]);

	if ($updtDelete) {
	    $retData = [
		'status' => true,
		'msgs' => 'Additional Documents deleted successfully'
	    ];
	} else {
	    $retData = [
		'status' => false,
		'msgs' => 'Error in deleting Additional Documents'
	    ];
	}
	echo json_encode($retData);
    }

    public function wppcats() {
	$deleteURL = BASE_URL("ptw/masters/deleteWPPC");
	$data = array(
	    'pageTitle' => 'Worksite preparation/ precautions Category',
	    'view_file' => 'master/wpp/cat/list',
	    'site_title' => 'Worksite preparation/ precautions Category',
	    'current_menu' => 'List Worksite preparation/ precautions Category',
	    'ajaxurl' => 'ptw/masters/listwppc',
	    'addLink' => 'ptw/masters/addwppc',
	    'deleteURL' => $deleteURL,
	);
	$this->template->load_table_template($data);
    }

    public function listwppc() {
	$table = PTW_M_WPP_CAT;
	$column_order = array(null, 'WPPC_NAME', 'CREATED_ON', null);
	$column_search = array('WPPC_NAME', 'CREATED_ON');
	$order = array('WPPC_ID' => 'DESC');
	$where = ['STATUS' => 'Y'];

	$mlist = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where);

	$finalDatas = [];
	if (isset($mlist) && !empty($mlist)) {
	    foreach ($mlist as $ltKey => $ltVal) {
		$action = '';
		$id = encryptval($ltVal->WPPC_ID);

		$action .= " " . anchor('ptw/masters/addwppc/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'inc_event_target', 'title' => 'Edit'));

		$action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteWPPC', 'title' => 'Delete', 'delt-id' => $id));


		$rows = [];
		$rows[] = $ltVal->WPPC_NAME;
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

    public function addwppc($id = "") {
	$getAwdatas = [];
	if ($id != '') {
	    $editID = decryptval($id);
	    $optWhr['where'] = [
		'WPPC_ID' => $editID
	    ];
	    $optWhr['return_type'] = 'row';
	    $getAwdatas = $this->common_model->getAlldata(PTW_M_WPP_CAT, ['*'], $optWhr);
	}
	$data = array(
	    'view_file' => 'ptw/master/wpp/cat/add',
	    'current_menu' => 'Add Worksite preparation/ precautions Category',
	    'getAwdatas' => $getAwdatas
	);
	$this->template->load_popup_template($data);
    }

    public function savewppc() {
	$gethadatas = $this->input->post();
	$editId = postData($gethadatas, 'wppc_id', '');
	if ($editId != "") {
	    $this->form_validation->set_rules('wppc_cat', 'Category', 'required|description_line|min_length[3]|max_length[50]|is_unique[' . PTW_M_WPP_CAT . '.WPPC_NAME.STATUS.N.WPPC_ID != .' . $editId . ']');
	} else {
	    $this->form_validation->set_rules('wppc_cat', 'Category', 'required|description_line|min_length[3]|max_length[50]|is_unique[' . PTW_M_WPP_CAT . '.WPPC_NAME.STATUS.N]');
	}
	if ($this->form_validation->run() == true) {
	    $updateData = [
		'WPPC_NAME' => postData($gethadatas, 'wppc_cat')
	    ];
	    $updtWhr = [];
	    if ($editId != "") {
		$updtWhr = [
		    'WPPC_ID' => $editId
		];
	    }
	    $updateInfo = $this->common_model->updateData(PTW_M_WPP_CAT, $updateData, $updtWhr, $editId);
	    if ($updateInfo >= 1) {
		$data = [
		    'status' => true
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('wppcflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Category has been Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('wppcflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Category has been Created</div>');
		}
	    } else {
		$data = [
		    'status' => false
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('wppcflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Category cannot be Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('wppcflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Category cannot be Created</div>');
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

    public function deleteWPPC() {
	$deleteId = decryptval($this->input->post('delid'));
	$updtDelete = $this->common_model->updateData(PTW_M_WPP_CAT, ['STATUS' => 'N'], ['WPPC_ID' => $deleteId]);

	if ($updtDelete) {
            
            $updtDeleteItem = $this->common_model->updateData(PTW_M_WPP_ITEMS, ['STATUS' => 'N'], ['REF_WPPC_ID' => $deleteId]);
                     
	    $retData = [
		'status' => true,
		'msgs' => 'Category deleted successfully'
	    ];
	} else {
	    $retData = [
		'status' => false,
		'msgs' => 'Error in deleting Category'
	    ];
	}
	echo json_encode($retData);
    }

    public function wppitems() {
	$deleteURL = BASE_URL("ptw/masters/deleteWPPI");
	$data = array(
	    'pageTitle' => 'Worksite preparation/ precautions Items',
	    'view_file' => 'master/wpp/items/list',
	    'site_title' => 'Worksite preparation/ precautions Items',
	    'current_menu' => 'List Worksite preparation/ precautions Items',
	    'ajaxurl' => 'ptw/masters/listwppi',
	    'addLink' => 'ptw/masters/addwppi',
	    'deleteURL' => $deleteURL,
	);
	$this->template->load_table_template($data);
    }

    public function listwppi() {
	$table = PTW_M_WPP_ITEMS;
	$column_order = array(null, 'FN_PTW_WPP_CATEGORY_NAME(REF_WPPC_ID)', 'WPPI_NAME', 'CREATED_ON', null);
	$column_search = array('FN_PTW_WPP_CATEGORY_NAME(REF_WPPC_ID)', 'WPPI_NAME', 'CREATED_ON');
	$order = array('WPPI_ID' => 'DESC');
	$where = ['STATUS' => 'Y'];
	$options['select'] = ['WPPI_ID', 'FN_PTW_WPP_CATEGORY_NAME(REF_WPPC_ID) as CATNAME', 'WPPI_NAME', 'CREATED_ON'];

	$listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where, $options);

	$finalDatas = [];
	if (isset($listIncicat) && !empty($listIncicat)) {
	    foreach ($listIncicat as $ltKey => $ltVal) {

		$action = '';
		$id = encryptval($ltVal->WPPI_ID);
		$action .= " " . anchor('ptw/masters/addwppi/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'inc_event_target', 'title' => 'Edit'));

		$action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteWPPI', 'title' => 'Delete', 'delt-id' => $id));


		$rows = [];
		$rows[] = $ltVal->CATNAME;
		$rows[] = $ltVal->WPPI_NAME;
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

    public function addwppi($id = "") {
	$getWpidatas = [];
	if ($id != '') {
	    $editID = decryptval($id);
	    $optWhr['where'] = [
		'WPPI_ID' => $editID
	    ];
	    $optWhr['return_type'] = 'row';
	    $getWpidatas = $this->common_model->getAlldata(PTW_M_WPP_ITEMS, ['*'], $optWhr);
	}
	$catOpt['where'] = [
	    'STATUS' => 'Y'
	];
	$getCatdatas = $this->common_model->getAlldata(PTW_M_WPP_CAT, ['*'], $catOpt);
	$catDrops = customFormDropDown($getCatdatas, 'WPPC_ID', 'WPPC_NAME', 'Select Category');
       
	$data = array(
	    'view_file' => 'ptw/master/wpp/items/add',
	    'current_menu' => 'Add Worksite preparation/ precautions Item',
	    'getCatdatas' => $catDrops,
	    'getWpidatas' => $getWpidatas
	);
	$this->template->load_popup_template($data);
    }

    public function savewppi() {
	$gethadatas = $this->input->post();
	$editId = postData($gethadatas, 'wppi_id', '');
	if ($editId != "") {
	    $this->form_validation->set_rules('itemname', 'Item Name', 'required|alpha_dash_space_slash_bracket|min_length[3]|max_length[50]|is_unique[' . PTW_M_WPP_ITEMS . '.WPPI_NAME.STATUS.N.WPPI_ID != .' . $editId . ']');
	} else {
	    $this->form_validation->set_rules('itemname', 'Item Name', 'required|alpha_dash_space_slash_bracket|min_length[3]|max_length[50]|is_unique[' . PTW_M_WPP_ITEMS . '.WPPI_NAME.STATUS.N]');
	}
	$this->form_validation->set_rules('category', 'Category', 'required');
	if ($this->form_validation->run() == true) {
	    $updateData = [
		'REF_WPPC_ID' => postData($gethadatas, 'category'),
		'WPPI_NAME' => postData($gethadatas, 'itemname')
	    ];
	    $updtWhr = [];
	    if ($editId != "") {
		$updtWhr = [
		    'WPPI_ID' => $editId
		];
	    }
	    $updateInfo = $this->common_model->updateData(PTW_M_WPP_ITEMS, $updateData, $updtWhr, $editId);
	    if ($updateInfo >= 1) {
		$data = [
		    'status' => true
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('wppiflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Item has been Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('wppiflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Item has been Created</div>');
		}
	    } else {
		$data = [
		    'status' => false
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('wppiflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Item cannot be Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('wppiflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Item cannot be Created</div>');
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

    public function deleteWPPI() {
	$deleteId = decryptval($this->input->post('delid'));
	$updtDelete = $this->common_model->updateData(PTW_M_WPP_ITEMS, ['STATUS' => 'N'], ['WPPI_ID' => $deleteId]);

	if ($updtDelete) {
	    $retData = [
		'status' => true,
		'msgs' => 'Item deleted successfully'
	    ];
	} else {
	    $retData = [
		'status' => false,
		'msgs' => 'Error in deleting Item'
	    ];
	}
	echo json_encode($retData);
    }
    public function ppecats() {
	$deleteURL = BASE_URL("ptw/masters/deletePPEC");
	$data = array(
	    'pageTitle' => 'Personal Protective Equipment Category',
	    'view_file' => 'master/ppe/cat/list',
	    'site_title' => 'Personal Protective Equipment Category',
	    'current_menu' => 'List Personal Protective Equipment Category',
	    'ajaxurl' => 'ptw/masters/listppec',
	    'addLink' => 'ptw/masters/addppec',
	    'deleteURL' => $deleteURL,
	);
	$this->template->load_table_template($data);
    }

    public function listppec() {
	$table = PTW_M_PPE_CAT;
	$column_order = array(null, 'PPEC_NAME', 'CREATED_ON', null);
	$column_search = array('PPEC_NAME', 'CREATED_ON');
	$order = array('PPEC_ID' => 'DESC');
	$where = ['STATUS' => 'Y'];

	$mlist = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where);

	$finalDatas = [];
	if (isset($mlist) && !empty($mlist)) {
	    foreach ($mlist as $ltKey => $ltVal) {
		$action = '';
		$id = encryptval($ltVal->PPEC_ID);

		$action .= " " . anchor('ptw/masters/addppec/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'inc_event_target', 'title' => 'Edit'));

		$action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deletePPEC', 'title' => 'Delete', 'delt-id' => $id));


		$rows = [];
		$rows[] = $ltVal->PPEC_NAME;
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

    public function addppec($id = "") {
	$getAwdatas = [];
	if ($id != '') {
	    $editID = decryptval($id);
	    $optWhr['where'] = [
		'PPEC_ID' => $editID
	    ];
	    $optWhr['return_type'] = 'row';
	    $getAwdatas = $this->common_model->getAlldata(PTW_M_PPE_CAT, ['*'], $optWhr);
	}
	$data = array(
	    'view_file' => 'ptw/master/ppe/cat/add',
	    'current_menu' => 'Add Personal Protective Equipment Category',
	    'getAwdatas' => $getAwdatas
	);
	$this->template->load_popup_template($data);
    }

    public function saveppec() {
	$gethadatas = $this->input->post();
	$editId = postData($gethadatas, 'ppec_id', '');
	if ($editId != "") {
	    $this->form_validation->set_rules('ppec_cat', 'Category', 'required|description_line|min_length[3]|max_length[50]|is_unique[' . PTW_M_PPE_CAT . '.PPEC_NAME.STATUS.N.PPEC_ID != .' . $editId . ']');
	} else {
	    $this->form_validation->set_rules('ppec_cat', 'Category', 'required|description_line|min_length[3]|max_length[50]|is_unique[' . PTW_M_PPE_CAT . '.PPEC_NAME.STATUS.N]');
	}
	if ($this->form_validation->run() == true) {
	    $updateData = [
		'PPEC_NAME' => postData($gethadatas, 'ppec_cat')
	    ];
	    $updtWhr = [];
	    if ($editId != "") {
		$updtWhr = [
		    'PPEC_ID' => $editId
		];
	    }
	    $updateInfo = $this->common_model->updateData(PTW_M_PPE_CAT, $updateData, $updtWhr, $editId);
	    if ($updateInfo >= 1) {
		$data = [
		    'status' => true
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('catflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Category has been Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('catflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Category has been Created</div>');
		}
	    } else {
		$data = [
		    'status' => false
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('catflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Category cannot be Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('catflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Category cannot be Created</div>');
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

    public function deletePPEC() {
	$deleteId = decryptval($this->input->post('delid'));
	$updtDelete = $this->common_model->updateData(PTW_M_PPE_CAT, ['STATUS' => 'N'], ['PPEC_ID' => $deleteId]);

	if ($updtDelete) {
             $updtDeleteItem = $this->common_model->updateData(PTW_M_PPE_ITEMS, ['STATUS' => 'N'], ['REF_PPEC_ID' => $deleteId]);
	    $retData = [
		'status' => true,
		'msgs' => 'Category deleted successfully'
	    ];
	} else {
	    $retData = [
		'status' => false,
		'msgs' => 'Error in deleting Category'
	    ];
	}
	echo json_encode($retData);
    }

    public function ppeitems() {
	$deleteURL = BASE_URL("ptw/masters/deletePPEI");
	$data = array(
	    'pageTitle' => 'Personal Protective Equipment Items',
	    'view_file' => 'master/ppe/items/list',
	    'site_title' => 'Personal Protective Equipment Items',
	    'current_menu' => 'List Personal Protective Equipment Items',
	    'ajaxurl' => 'ptw/masters/listppei',
	    'addLink' => 'ptw/masters/addppei',
	    'deleteURL' => $deleteURL,
	);
	$this->template->load_table_template($data);
    }

    public function listppei() {
	$table = PTW_M_PPE_ITEMS;
	$column_order = array(null, 'FN_PTW_PPE_CATEGORY_NAME(REF_PPEC_ID)', 'PPEI_NAME', 'CREATED_ON', null);
	$column_search = array('FN_PTW_PPE_CATEGORY_NAME(REF_PPEC_ID)', 'PPEI_NAME', 'CREATED_ON');
	$order = array('PPEI_ID' => 'DESC');
	$where = ['STATUS' => 'Y'];
	$options['select'] = ['PPEI_ID', 'FN_PTW_PPE_CATEGORY_NAME(REF_PPEC_ID) as CATNAME', 'PPEI_NAME', 'CREATED_ON'];

	$listIncicat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where, $options);

	$finalDatas = [];
	if (isset($listIncicat) && !empty($listIncicat)) {
	    foreach ($listIncicat as $ltKey => $ltVal) {

		$action = '';
		$id = encryptval($ltVal->PPEI_ID);
		$action .= " " . anchor('ptw/masters/addppei/' . $id, '<i class="fa fa-edit"></i>', array('class' => 'inc_event_target', 'title' => 'Edit'));

		$action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deletePPEI', 'title' => 'Delete', 'delt-id' => $id));


		$rows = [];
		$rows[] = $ltVal->CATNAME;
		$rows[] = $ltVal->PPEI_NAME;
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

    public function addppei($id = "") {
	$getppeidatas = [];
	if ($id != '') {
	    $editID = decryptval($id);
	    $optWhr['where'] = [
		'PPEI_ID' => $editID
	    ];
	    $optWhr['return_type'] = 'row';
	    $getppeidatas = $this->common_model->getAlldata(PTW_M_PPE_ITEMS, ['*'], $optWhr);
	}
	$catOpt['where'] = [
	    'STATUS' => 'Y'
	];
	$getCatdatas = $this->common_model->getAlldata(PTW_M_PPE_CAT, ['*'], $catOpt);
	$catDrops = customFormDropDown($getCatdatas, 'PPEC_ID', 'PPEC_NAME', 'Select Category');
	$data = array(
	    'view_file' => 'ptw/master/ppe/items/add',
	    'current_menu' => 'Add Personal Protective Equipment Item',
	    'getCatdatas' => $catDrops,
	    'getppeidatas' => $getppeidatas
	);
	$this->template->load_popup_template($data);
    }

    public function saveppei() {
	$getppeidatas = $this->input->post();
	$editId = postData($getppeidatas, 'ppei_id', '');
	if ($editId != "") {
	    $this->form_validation->set_rules('itemname', 'Item Name', 'required|alpha_dash_space_slash_bracket|min_length[3]|max_length[50]|is_unique[' . PTW_M_PPE_ITEMS . '.PPEI_NAME.STATUS.N.PPEI_ID != .' . $editId . ']');
	} else {
	    $this->form_validation->set_rules('itemname', 'Item Name', 'required|alpha_dash_space_slash_bracket|min_length[3]|max_length[50]|is_unique[' . PTW_M_PPE_ITEMS . '.PPEI_NAME.STATUS.N]');
	}
	$this->form_validation->set_rules('category', 'Category', 'required');
	$this->form_validation->set_rules('mandate', 'Mandate', 'required');
	if ($this->form_validation->run() == true) {
	    $updateData = [
		'REF_PPEC_ID' => postData($getppeidatas, 'category'),
		'PPEI_NAME' => postData($getppeidatas, 'itemname'),
		'PPEI_MANDATE' => (string)postData($getppeidatas, 'mandate','N')
	    ];
	    $updtWhr = [];
	    if ($editId != "") {
		$updtWhr = [
		    'PPEI_ID' => $editId
		];
	    }
	    $updateInfo = $this->common_model->updateData(PTW_M_PPE_ITEMS, $updateData, $updtWhr, $editId);
	    if ($updateInfo >= 1) {
		$data = [
		    'status' => true
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('ppeitemflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Item has been Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('ppeitemflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Item has been Created</div>');
		}
	    } else {
		$data = [
		    'status' => false
		];
		if ($editId != '') {
		    $data['flasmsg'] = $this->session->set_flashdata('ppeitemflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Item cannot be Updated</div>');
		} else {
		    $data['flasmsg'] = $this->session->set_flashdata('ppeitemflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Item cannot be Created</div>');
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

    public function deletePPEI() {
	$deleteId = decryptval($this->input->post('delid'));
	$updtDelete = $this->common_model->updateData(PTW_M_PPE_ITEMS, ['STATUS' => 'N'], ['PPEI_ID' => $deleteId]);

	if ($updtDelete) {
	    $retData = [
		'status' => true,
		'msgs' => 'Item deleted successfully'
	    ];
	} else {
	    $retData = [
		'status' => false,
		'msgs' => 'Error in deleting Item'
	    ];
	}
	echo json_encode($retData);
    }

}
