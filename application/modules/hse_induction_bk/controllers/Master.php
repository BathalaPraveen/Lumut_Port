<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        isLogin();
        $this->load->model('hse_induction/Training_model', 'training_model');
        $this->load->model('common/common_model', 'common_model');
    }

    /* ==============================================================
     * TYPE MASTER (DYNAMIC)
     * ============================================================== */
    public function type()
    {
        $data = array(
            'view_file' => 'hse_induction/master/type/list_type',
            'site_title' => 'Type List',
            'page_title' => 'TYPE LIST',
            'current_menu' => 'Type',
            'ajaxurl' => 'hse_induction/master/type_list',
        );

        $this->template->load_table_template($data);
    }

    public function type_list()
    {
        $table = TRM_TYPE_MAS . ' as mastype';
        $column_order = array(null, 'type', 'DATE_FORMAT(mastype.created_on,"%d-%m-%Y")', null);
        $column_search = array('mastype.type', 'DATE_FORMAT(mastype.created_on,"%d-%m-%Y")');
        $order = array('id' => 'desc');
        $where = ['type_status' => 'Y'];
        $optns = ['select' => 'mastype.*'];

        $listCat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where, $optns);

        $finalDatas = [];
        $i = 0;

        if (!empty($listCat)) {
            foreach ($listCat as $ltVal) {
                $i++;
                $id = encryptval($ltVal->id);
                $action = '';
                $action .= " " . anchor('hse_induction/master/add_type/' . $id, '<i class="fa fa-edit text-primary"></i>', array('class' => 'resptarget', 'title' => 'Edit'));
                $action .= " " . anchor('javascript:void(0)', '<i class="fa fa-trash text-danger ml-2"></i>', array('class' => 'deleteType', 'title' => 'Delete', 'delt-id' => $id));

                $rows = [];
                $rows[] = $ltVal->type;
                $rows[] = date("d-m-Y", strtotime($ltVal->created_on));
                $rows[] = $action;
                $finalDatas[] = $rows;
            }
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->common_model->count_all($table, $column_order, $column_search, $order, $where, $optns),
            "recordsFiltered" => $this->common_model->count_filtered($table, $column_order, $column_search, $order, $where, $optns),
            "data" => $finalDatas,
        );
        echo json_encode($output);
    }

    public function add_type($id = '')
    {
        $did = decryptval($id);
        $getCategories = [];

        if ($id != '') {
            $optWhr['return_type'] = 'row';
            $optWhr['where'] = [
                'id' => $did,
                'type_status !=' => 'N'
            ];
            $getCategories = $this->common_model->getAlldata(TRM_TYPE_MAS, ['*'], $optWhr);
        }

        $data = array(
            'view_file' => 'hse_induction/master/type/add_type',
            'current_menu' => 'Add Type',
            'getCategories' => $getCategories,
        );
        $this->template->load_popup_template($data);
    }

    public function save_type()
    {
        $getrespdatas = $this->input->post('main_mas');
        $hidEditrespid = postData($getrespdatas, 'hiddenrespID');
        $typeName = trim(postData($getrespdatas, 'type'));

        if (empty($typeName)) {
            echo json_encode(['status' => false, 'msgs' => 'Type name is required']);
            exit();
        }

        $checkWhr['where'] = [
            'LOWER(type)' => strtolower($typeName),
            'type_status !=' => 'N'
        ];
        if (!empty($hidEditrespid)) {
            $checkWhr['where']['id !='] = $hidEditrespid;
        }
        $existing = $this->common_model->getAlldata(TRM_TYPE_MAS, ['id'], $checkWhr);
        if (!empty($existing)) {
            echo json_encode(['status' => false, 'msgs' => 'Type name already exists! Please enter a unique name.']);
            exit();
        }

        $respdatas = [
            'type' => $typeName,
            'type_status' => 'Y'
        ];

        $updtWhr = [];
        if ($hidEditrespid != '') {
            $updtWhr = ['id' => $hidEditrespid];
            $updCategory = $this->common_model->updateData(TRM_TYPE_MAS, $respdatas, $updtWhr);
        } else {
            $updCategory = $this->common_model->updateData(TRM_TYPE_MAS, $respdatas, []);
        }

        if ($updCategory) {
            $this->session->set_flashdata('typeflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span><i class="fa fa-check-circle"></i> Success!</span> Type Master Saved Successfully</div>');
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false, 'msgs' => 'Error saving Type']);
        }
        exit();
    }

    public function delete_type()
    {
        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(TRM_TYPE_MAS, ['type_status' => 'N'], ['id' => decryptval($deleteId)]);

        if ($updtDelete) {
            $retData = ['status' => true, 'msgs' => 'Type deleted successfully'];
        } else {
            $retData = ['status' => false, 'msgs' => 'Error deleting Type'];
        }
        echo json_encode($retData);
    }

    /* ==============================================================
     * PPT / VIDEO
     * ============================================================== */
    public function ppt()
    {
        $opt['where'] = ['type_status' => 'Y'];
        $typeList = $this->common_model->getAlldata(TRM_TYPE_MAS, ['id', 'type'], $opt);
        $dropType = ['' => 'Select Type'];
        if (!empty($typeList)) {
            foreach ($typeList as $t) {
                $dropType[$t->id] = $t->type;
            }
        }

        $data = array(
            'view_file' => 'hse_induction/master/ppt/list_ppt',
            'current_menu' => 'PPT / Video',
            'site_title' => 'PPT / Video',
            'dropType' => $dropType,
        );

        $this->template->load_common_template($data);
    }

    public function getFileDetails()
    {
        $TypeId = $this->input->post('type');
        $getFile = [];

        if (!empty($TypeId)) {
            $optWhr['where'] = [
                'type' => $TypeId,
                'file_status !=' => 'N'
            ];
            $optWhr['return_type'] = 'row';
            $getFile = $this->common_model->getAlldata(TRM_UPLOAD_MAS, ['*'], $optWhr);
        }

        echo json_encode($getFile);
        exit();
    }

    public function save_ppt()
    {
        $getrespdatas = $this->input->post('main_mas');
        $hidEditrespid = postData($getrespdatas, 'upload_id_edit');

        $other_image = $this->input->post('other_user_img');
        $type = $this->input->post('type');

        $imgDatasother = [];

        if (isset($_FILES) && !empty($_FILES) && isset($_FILES['upload_file']['name']) && !empty($_FILES['upload_file']['name'])) {
            $imgDatasother = uploadImage(
                $filename = 'upload_file',
                $imgUploadpath = 'assets/images/modules/training/uploads',
                $allowedTyp = "*"
            );

            $filePath = pathinfo($imgDatasother, PATHINFO_DIRNAME);
            $fileName = pathinfo($imgDatasother, PATHINFO_FILENAME);
            $fileExt  = pathinfo($imgDatasother, PATHINFO_EXTENSION);

            $respdatas = [
                'upload_file' => $imgDatasother,
                'type' => $type,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_ext' => $fileExt,
            ];

            if ($other_image) {
                $existingImagePath = $other_image;
                $existingImageName = basename($existingImagePath);
                $existingImageFullPath = FCPATH . 'assets/images/modules/training/uploads/' . $existingImageName;

                if (file_exists($existingImageFullPath)) {
                    unlink($existingImageFullPath);
                }
            }
        } else if ($other_image) {
            $imgDatasother = $other_image;

            $respdatas = [
                'upload_file' => $imgDatasother,
                'type' => $type,
            ];
        } else {
            $imgDatasother = '';

            $respdatas = [
                'upload_file' => $imgDatasother,
                'type' => $type,
            ];
        }

        $updtWhr = [];
        if ($hidEditrespid != '') {
            $updtWhr = [
                'id' => $hidEditrespid
            ];
        }

        $updUpload = $this->common_model->updateData(TRM_UPLOAD_MAS, $respdatas, $updtWhr);

        if (($updUpload)) {
            $this->session->set_flashdata('uploadflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span><i class="fa fa-check-circle"></i> Success!</span> Uploaded Successfully</div>');
        } else {
            $this->session->set_flashdata('uploadflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span><i class="fa fa-times-circle"></i> Sorry!</span> Upload Failed, Try Again</div>');
        }

        redirect('hse_induction/master/ppt');
    }

    /* ==============================================================
     * ASSESSMENT Q/A
     * ============================================================== */
    public function assessment()
    {
        $data = array(
            'view_file' => 'hse_induction/master/assessment/list_assessment',
            'current_menu' => 'Assessment Q/A',
            'site_title' => 'Question List',
            'ajaxurl' => 'hse_induction/master/assessmentList',
        );

        $this->template->load_table_template($data);
    }

    public function assessmentList()
    {
        $table = TRM_ASS_MAS . ' as tm';
        $column_order = array(null, 'tym.type', 'tm.question', 'DATE_FORMAT(tm.created_on,"%d-%m-%Y")', null);
        $column_search = array('tym.type', 'tm.question', 'DATE_FORMAT(tm.created_on,"%d-%m-%Y")');
        $order = array('id' => 'desc');
        $where = array('tm.question_status' => 'Y');
        $options['select'] = ['tm.*', 'tym.type as dynamic_type_name'];
        $options['join'] = [
            TRM_TYPE_MAS . ' as tym' => ['tym.id = tm.type', 'left']
        ];

        $listCat = $this->common_model->get_datatables($table, $column_order, $column_search, $order, $where, $options);

        $finalDatas = [];
        $i = 0;

        if (!empty($listCat)) {
            foreach ($listCat as $ltVal) {
                $i++;
                $id = encryptval($ltVal->id);
                $action = '';
                $action .= " " . anchor('hse_induction/master/addQuestion/' . $id, '<i class="fa fa-edit text-primary"></i>', array('title' => 'Edit'));
                $action .= " " . anchor('javascript:void(0)', '<i class="fa fa-trash text-danger ml-2"></i>', array('class' => 'deleteQuestion', 'title' => 'Delete', 'delt-id' => $id));
                $typeName = !empty($ltVal->dynamic_type_name) ? $ltVal->dynamic_type_name : $ltVal->type;

                $rows = [];
                $rows[] = $typeName;
                $rows[] = $ltVal->question;
                $rows[] = date("d-m-Y", strtotime($ltVal->created_on));
                $rows[] = $action;
                $finalDatas[] = $rows;
            }
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->common_model->count_all($table, $column_order, $column_search, $order, $where, $options),
            "recordsFiltered" => $this->common_model->count_filtered($table, $column_order, $column_search, $order, $where, $options),
            "data" => $finalDatas,
        );

        echo json_encode($output);
    }

    public function addQuestion($id = "")
    {
        $getQuestion = [];
        $did = decryptval($id);

        if ($id != '') {
            $optWhr['where'] = [
                'id' => $did,
                'question_status !=' => 'N'
            ];
            $optWhr['return_type'] = 'row';
            $getQuestion = $this->common_model->getAlldata(TRM_ASS_MAS, ['*'], $optWhr);
        }

        $opt['where'] = ['type_status' => 'Y'];
        $typeList = $this->common_model->getAlldata(TRM_TYPE_MAS, ['id', 'type'], $opt);
        $dropType = ['' => 'Select Type'];
        if (!empty($typeList)) {
            foreach ($typeList as $t) {
                $dropType[$t->id] = $t->type;
            }
        }

        $data = array(
            'view_file' => 'hse_induction/master/assessment/add_assessment',
            'current_menu' => 'Assessment Q/A',
            'site_title' => ($id != '') ? 'Edit Question' : 'Add Question',
            'editData' => $getQuestion,
            'dropType' => $dropType,
        );

        $this->template->load_common_template($data);
    }

    public function addOptimg($val = '', $optin = '')
    {
        $data = array(
            'view_file' => 'hse_induction/master/assessment/add_img',
            'current_menu' => 'Add Images',
            'opt_val' => $val,
            'optin' => $optin,
        );

        $this->template->load_popup_template($data);
    }

    public function qaimag()
    {
        $option = $this->input->post('option');
        $optionn = $this->input->post('optionn');
        $imgPath = $this->uploadQuestImage('file');
        $aResponse['result'] = $imgPath;
        $aResponse['option'] = $option;
        $aResponse['optionn'] = $optionn;
        $imgSrc = BASE_URL . $imgPath;
        $aResponse['image'] = '<img src="' . $imgSrc . '" style="width:93px;height:75px;""/> <a href="javascript:void(0)"><i class="fa fa-trash del_img text-danger" data-id="' . $option . '" altr="' . $optionn . '"></a></i>';
        echo json_encode($aResponse);
        exit;
    }

    private function uploadQuestImage($filename = '', $audid = '')
    {
        $this->load->library('upload');

        if (isset($_FILES[$filename]['name']) && $_FILES[$filename]['name'] == '') {
            return $this->input->post($filename . '_photo');
        }

        $mpath = "assets/images/modules/training";
        if (!file_exists(FCPATH . $mpath)) {
            mkdir(FCPATH . $mpath, 0777, true);
        }

        $fpath = $mpath . '/question';
        if (!file_exists(FCPATH . $fpath)) {
            mkdir(FCPATH . $fpath, 0777, true);
        }

        $uploadPath = $fpath . $audid;
        $config['upload_path'] = FCPATH . $uploadPath;

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $config['allowed_types'] = '*';
        $config['encrypt_name'] = TRUE;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload($filename)) {
            return FALSE;
        }

        $upload_data = $this->upload->data();
        $imgName = isset($upload_data['file_name']) ? $upload_data['file_name'] : FALSE;

        return $imgName ? $uploadPath . '/' . $imgName : '';
    }

    public function save_assessment()
    {
        $main = $this->input->post('main_mas');
        $data = $this->input->post();

        if (!empty($data)) {
            $updateWhr = [];
            $edit_id = isset($main['ass_id_edit']) ? $main['ass_id_edit'] : '';

            $option1 = isset($data['mod_ans_1']) && !empty($data['mod_ans_1']) ? $data['mod_ans_1'] : (isset($data['mod_img_1']) ? $data['mod_img_1'] : '');
            $option2 = isset($data['mod_ans_2']) && !empty($data['mod_ans_2']) ? $data['mod_ans_2'] : (isset($data['mod_img_2']) ? $data['mod_img_2'] : '');
            $option3 = isset($data['mod_ans_3']) && !empty($data['mod_ans_3']) ? $data['mod_ans_3'] : (isset($data['mod_img_3']) ? $data['mod_img_3'] : '');
            $option4 = isset($data['mod_ans_4']) && !empty($data['mod_ans_4']) ? $data['mod_ans_4'] : (isset($data['mod_img_4']) ? $data['mod_img_4'] : '');

            $insertData = [
                'question'      => isset($data['QN_NAME']) ? $data['QN_NAME'] : '',
                'type'          => isset($data['type']) ? $data['type'] : '1',
                'question_img'  => !empty($data['mod_ques_image']) ? $data['mod_ques_image'] : NULL,
                'question_path' => !empty($data['mod_ques_image']) ? pathinfo($data['mod_ques_image'], PATHINFO_DIRNAME) : NULL,

                'option_a'      => (strpos($option1, 'assets/') !== false) ? NULL : $option1,
                'option_a_img'  => (strpos($option1, 'assets/') !== false) ? $option1 : NULL,
                'option_a_path' => (strpos($option1, 'assets/') !== false) ? pathinfo($option1, PATHINFO_DIRNAME) : NULL,

                'option_b'      => (strpos($option2, 'assets/') !== false) ? NULL : $option2,
                'option_b_img'  => (strpos($option2, 'assets/') !== false) ? $option2 : NULL,
                'option_b_path' => (strpos($option2, 'assets/') !== false) ? pathinfo($option2, PATHINFO_DIRNAME) : NULL,

                'option_c'      => (strpos($option3, 'assets/') !== false) ? NULL : $option3,
                'option_c_img'  => (strpos($option3, 'assets/') !== false) ? $option3 : NULL,
                'option_c_path' => (strpos($option3, 'assets/') !== false) ? pathinfo($option3, PATHINFO_DIRNAME) : NULL,

                'option_d'      => (strpos($option4, 'assets/') !== false) ? NULL : $option4,
                'option_d_img'  => (strpos($option4, 'assets/') !== false) ? $option4 : NULL,
                'option_d_path' => (strpos($option4, 'assets/') !== false) ? pathinfo($option4, PATHINFO_DIRNAME) : NULL,

                'correct_ans'   => isset($data['corret_ans']) ? $data['corret_ans'] : '',
            ];

            if (!empty($edit_id)) {
                $updateWhr = ['id' => $edit_id];
                $updAssess = $this->common_model->updateData(TRM_ASS_MAS, $insertData, $updateWhr);
            } else {
                $updAssess = $this->common_model->updateData(TRM_ASS_MAS, $insertData, []);
            }
        }

        if (($updAssess)) {
            $this->session->set_flashdata('assessmentflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span><i class="fa fa-check-circle"></i> Success!</span> Assessment Question has been Updated</div>');
        } else {
            $this->session->set_flashdata('assessmentflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span><i class="fa fa-times-circle"></i> Sorry!</span> Assessment Question cannot be Updated</div>');
        }

        redirect('hse_induction/master/assessment');
    }

    public function delete_assessment_master()
    {
        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(TRM_ASS_MAS, ['question_status' => 'N'], ['id' => decryptval($deleteId)]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Training Question deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Training Question'
            ];
        }
        echo json_encode($retData);
    }
}



