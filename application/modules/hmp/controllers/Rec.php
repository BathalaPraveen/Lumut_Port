<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rec extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isLogin();
        $this->load->model('hmp/hmp_model', 'hmp');
        $this->load->helper('hmp_helper');
    }

    public function recInfo() {

        $data = [
            'pageTitle' => 'HSSE Record Master',
            'view_file' => 'hmp/form/list_form_rec',
            'site_title' => 'HSSE Record Master',
            'current_menu' => 'HSSE Record Master List',
            'ajaxurl' => 'hmp/rec/listRec'
        ];

        $this->template->load_table_template($data);
    }

    public function listRec() {

        global $recPermission;
        $table = REC_MAIN;

        $userid = getCurrentUserid();
        $user_type = getCurrentUserGroupId();

        $column_order = array(null, 'REC_ID', 'REC_NAME', 'FN_GET_LOCATION(REC_TER_ID) as loc_name', 'REC_REC_DATE', 'REC_EXP_DATE', 'FN_REC_STATUS(REC_MAIN_STATUS) as status_Name', null);
        $column_search = array('REC_ID', 'REC_NAME', 'FN_GET_LOCATION(REC_TER_ID) as loc_name', 'REC_REC_DATE', 'REC_EXP_DATE', 'FN_REC_STATUS(REC_MAIN_STATUS) as status_Name');
        $order = array('CREATED_ON' => 'desc');

        //  print_r($user_type);
        if (in_array($user_type, $recPermission['add']) || is_admin()) {
            $where = [
                'REC_STATUS' => 'Y'
            ];
        }


        $options['select'] = ['REC_ID', 'REC_NAME', 'REC_AUTO_ID', 'REC_MAIN_STATUS', 'REC_EXP_DATE', 'REC_REC_DATE', 'FN_GET_LOCATION(REC_TER_ID) as loc_name', 'FN_REC_STATUS(REC_MAIN_STATUS) as status_Name'];
        $listHmp = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where, $options);
        // echo $this->db->last_query();exit;
        $finalDatas = [];
        $i = 0;
        if (isset($listHmp) && !empty($listHmp)) {
            foreach ($listHmp as $ltKey => $ltVal) {
                $i++;
                $action = '';
                $id = encryptval($ltVal->REC_AUTO_ID);


                $user_type = getCurrentUserGroupId();

                if (((in_array($user_type, $recPermission['add'])) && $ltVal->REC_MAIN_STATUS == '1' ) || (is_admin() && $ltVal->REC_MAIN_STATUS == '1')) {
                    $action .= " " . anchor('hmp/rec/addRec/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));

                    $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteHmp', 'title' => 'Delete', 'delt-id' => $id));
                }
//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";
                $action .= " " . anchor('hmp/rec/view/' . $id, '<i class="fa fa-eye"></i>', array('title' => 'view'));
                $action .= " " . anchor('hmp/rec/pdf/' . $id, '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF', 'target' => '_blank'));

                $rows = [];
                $rows[] = $ltVal->REC_ID;
                $rows[] = $ltVal->REC_NAME;
                $rows[] = ucfirst($ltVal->loc_name);
                $rows[] = convertDate($ltVal->REC_REC_DATE);
                $rows[] = convertDate($ltVal->REC_EXP_DATE);

                $date_now = date("Y-m-d"); 

                if ($date_now < $ltVal->REC_EXP_DATE) {
                    $status = '<label class="btn btn-xs btn-success" style="color:#fff">Valid</label>';
                }else{
                    $status =  '<label class="btn btn-xs btn-danger" style="color:#fff">Expired</label>';
                }
                
                
                $rows[] = $status;

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

    public function addRec($id = '') {

        $did = decryptval($id);

        $getuniqueId = getRecNumber();

        $termOptn['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $getAllterminal = $this->common_model->getAlldata(TERM, ['*'], $termOptn);
        $dropTermname = customFormDropDown($getAllterminal, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');

$idTypeData = [
            '' => 'Select Alert',
            '1' => 'Yes',
            '2' => 'No'
        ];

        $getRecdatas = [];

        if ($did != '') {
            $optWhr['where'] = [
                'REC_AUTO_ID' => $did,
                'REC_STATUS' => 'Y'
            ];
            $optWhr['return_type'] = 'row';
            $getRecdatas = $this->common_model->getAlldata(REC_MAIN, ['*'], $optWhr);
        }


        if ($did != '') {
            $getAlluseeimage = [];
            $getAlluseeimage = $this->hmp->getRecordImage($did);
        }
        // print_r($getAlluseeimage);exit;
        $data = array(
            'view_file' => 'hmp/form/add_form_rec',
            'current_menu' => 'Add Record Master',
            'getProgramdatas' => $getRecdatas,
            'getAutoId' => $getuniqueId,
            'getOthercertdet' => $getAlluseeimage,
            'locationDetails' => $dropTermname,
            'idTypeData' => $idTypeData,
        );
        $this->template->load_common_template($data);
    }

    public function deleteRecordcerti() {
        $certiId = $this->input->post('certiId');
        $delCerti = $this->common_model->updateData(REC_IMG, ['REC_ATTACH_STATUS' => 'N'], ['REC_IMG_ID' => $certiId]);

        if ($delCerti) {
            if ($certiId == $delCerti) {
                $datResp = [
                    'status' => true,
                    'msg' => 'Record Master Upload Deleted Successfully',
                ];
            } else {
                $datResp = [
                    'status' => false,
                    'msg' => 'Error in Deleting Record Master Upload',
                ];
            }
        } else {
            $datResp = [
                'status' => false,
                'msg' => 'Error in Deleting Record Master Upload',
            ];
        }
        echo json_encode($datResp);
    }

    public function saveRec($id = '') {
//         echo "<pre>";
////        print_R($this->input->post());
//        print_R($_FILES);
//        exit;
        $this->form_validation->set_rules('pro[REC_TER_ID]', 'Terminal', 'required|trim');
        $this->form_validation->set_rules('pro[REC_NAME]', 'Record Name', 'required|trim');
        $REC_REPORTER_ID = getCurrentUserid();

        $empDatas = $this->input->post('pro');
        $certiDatas = $this->input->post('certi');

        if ($this->form_validation->run() == true) {

            $did = decryptval($id);


            $inserEmpldatas = [
                'REC_NAME' => postData($empDatas, 'REC_NAME'),
                'REC_TER_ID' => postData($empDatas, 'REC_TER_ID'),
                'REC_REC_DATE' => date('Y-m-d', strtotime(postData($empDatas, 'REC_REC_DATE'))),
                'REC_EXP_DATE' => date('Y-m-d', strtotime(postData($empDatas, 'REC_EXP_DATE'))),
                'REC_MOD_NAME' => postData($empDatas, 'REC_MOD_NAME'),
                'REC_LOC_NAME' => postData($empDatas, 'REC_LOC_NAME'),
                'REC_DESC' => postData($empDatas, 'REC_DESC'),
                'REC_NOT' => postData($empDatas, 'REC_NOT'),
                'REC_CREATOR_ID' => $REC_REPORTER_ID,
                'REC_MAIN_STATUS' => 1
            ];

            if ($did != '') {
                $updtEmpl = $this->common_model->updateData(REC_MAIN, $inserEmpldatas, ['REC_AUTO_ID' => $did]);
            } else {
                $getuniqueId = getRecNumber();
                $inserEmpldatas['REC_ID'] = $getuniqueId;
                $updtEmpl = $this->common_model->updateData(REC_MAIN, $inserEmpldatas);
            }

            if (isset($certiDatas) && !empty($certiDatas)) {
                $imgDatasother = [];
                if (isset($_FILES) && !empty($_FILES)) {
                    $imgDatasother = uploadMultipleimage($_FILES, 'assets/images/modules/hmp/rec/', 'oth_competency_certi');
                }


//                echo "<pre>";
//                print_R($imgDatasother);
//                print_R($certiDatas);
//                exit;
                $imgKey = 0;

                foreach ($certiDatas as $cKey => $cVal) {
                    /////////image upload start

                    if (!empty($imgDatasother[$imgKey])) {

                        $imgUplname = $imgDatasother[$imgKey]['uploadname'];
                        $imgUplpath = $imgDatasother[$imgKey]['uploadpath'];
                        $imgUplext = $imgDatasother[$imgKey]['uploadextension'];
                        $imgUplsize = $imgDatasother[$imgKey]['filesize'];
                        $insertOthercerti['REC_FILENAME'] = $imgUplname;
                        $insertOthercerti['REC_FILE_PATH'] = $imgUplpath;
                        $insertOthercerti['REC_FILE_EXT'] = $imgUplext;
                        $insertOthercerti['REC_FILE_SIZE'] = $imgUplsize;
                    } else {
                        $userImgs = $this->input->post('other_user_img');
                        $uplImgdatas = $userImgs[$imgKey];
                    }

                   
                    /////////image upload end
//               print_R($insertOthercerti);
                    if ($did != '') {
                        if(!empty($imgDatasother[$imgKey])){
		                $othCompIDedit = postData($cVal, 'other_compCerti_ID');
		                if (isset($othCompIDedit) && !empty($othCompIDedit)) {
		                    $othercertiWhere['REC_IMG_ID'] = $othCompIDedit;
		                    $othercertiWhere['FK_REC_MAIN_ID'] = $did;
		                    $updateOthercert = $this->common_model->updateData(REC_IMG, $insertOthercerti, $othercertiWhere);
		                } else {
		                    $insertOthercerti['FK_REC_MAIN_ID'] = $did;
		                    $updateOthercert = $this->common_model->updateData(REC_IMG, $insertOthercerti);
		                }
                        }
                    } else {
                        $insertOthercerti['FK_REC_MAIN_ID'] = $updtEmpl;

                        $updateOthercert = $this->common_model->updateData(REC_IMG, $insertOthercerti);
                    }
		$imgKey++;
                }
            }

            if ($updtEmpl) {

                if ($did != '') {
                    $this->session->set_flashdata('hmpflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Record Master has been Updated</div>');
                } else {
                    $this->session->set_flashdata('hmpflash', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Record Master has been Created</div>');
                }
                redirect('hmp/rec/recInfo');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('hmpflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Record Master cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('hmpflash', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Record Master cannot be Created</div>');
                }
                redirect('hmp/rec/recInfo');
            }
        } else {
            $this->addRec($id);
        }
    }

    public function deleteRec() {
        $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(REC_MAIN, ['REC_STATUS' => 'N'], ['REC_AUTO_ID' => decryptval($deleteId)]);
        $updtImgDelete = $this->common_model->updateData(REC_IMG, ['REC_STATUS' => 'N'], ['FK_REC_MAIN_ID' => decryptval($deleteId)]);
        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Record Master has been deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Record Master! Try Again later.'
            ];
        }
        echo json_encode($retData);
    }

   

    public function pdf($id = '') {

        $editData = FALSE;
        if ($id != '') {

      $decryptRecId = decryptval($id);
            $editData = $this->hmp->getRecDetails(['REC_AUTO_ID' => $decryptRecId], 'row');
            $getimage = $this->hmp->getRecordImage($decryptRecId);
            }

        $data = [
            'editData' => $editData,
            'getOthercertdet' => $getimage,
            
        ];

        $hmpNumber = postData($editData, 'REC_ID');
        $html2 = $this->load->view('form/hmp_pdf_rec', $data, true);
        //  echo $html2;
//        exit;
        $mpdf2 = $this->pdf->ptwload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "rec";
        $file_path = "assets/images/modules/hmp/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $hmpNumber . '.pdf';
        $name = $hmpNumber . '.pdf';
        $mpdf2->Output($path2, "I");
//        $data = file_get_contents($path2);
//        force_download($name, $data);
    }

    public function view($id = '') {
       
        if ($id != '') {
            $decryptRecId = decryptval($id);
            $editData = $this->hmp->getRecDetails(['REC_AUTO_ID' => $decryptRecId], 'row');
            $getimage = $this->hmp->getRecordImage($decryptRecId);
        }

        $data = [
            'view_file' => 'hmp/form/view_report_rec',
            'current_menu' => 'View Record Master',
            'editData' => $editData,
            'getOthercertdet' => $getimage,
        ];

         // echo "<pre>";
         //print_r($data);exit;

        $this->template->load_common_template($data);
    }

}
