<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Portsecurity extends CI_Controller {

    function __construct() {
        parent::__construct();
        isLogin();
    }

    //// port start
    public function index() {
        $frmdate = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $data = array(
            'view_file' => 'psa/psa_user/list_form',
            'site_title' => 'Port Security Access',
            'current_menu' => 'List Port Security Access',
            'ajaxurl' => 'psa/portsecurity/list_psa?from_date=' . $frmdate . '&to_date=' . $to_date,
            'frmdate' => $frmdate,
            'to_date' => $to_date
        );

        $this->template->load_table_template($data);
    }

    public function list_psa() {
        $frmdate = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        $where = ['p.VEC_STATUS' => 'Y'];
        if($frmdate != '') {
           $where['p.CREATED_ON >='] = converttoDBDate($frmdate,'Y-m-d');
        }
        if($to_date != '') {
            $where['p.CREATED_ON <='] = converttoDBDate($to_date,'Y-m-d');
        }
        $table = PR_SEC . ' as p';
        $column_order = array('PORT_UNQ_ID', 'NAME', 'PASS_NO', 'COMP_NAME', 'TERMINAL_NAME', null);
        $column_search = array('PORT_UNQ_ID', 'NAME', 'PASS_NO', 'COMP_NAME', 'TERMINAL_NAME');
        $order = array('p.AUTO_ID' => 'desc');
        $optns['select'] = 'p.*,t.TERMINAL_NAME';
        $optns['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = p.TERMIN_ID', 'left'];
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
                $id = encryptval($ltVal->AUTO_ID);

                $action .= " " . anchor('psa/portsecurity/addpsa/' . $id, '<i class="fa fa-edit"></i>', array('class' => '', 'title' => 'Edit'));
                $action .= " " . anchor('psa/portsecurity/view_report/' . $id, '<i class="fa fa-eye"></i>', array('class' => '', 'title' => 'View'));
//                $action .= "  " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deletepsa', 'title' => 'Delete', 'delt-id' => $id));
//                $action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";

                $rows = [];
                $rows[] = ucfirst($ltVal->PORT_UNQ_ID);
                $rows[] = ucfirst($ltVal->NAME);
                $rows[] = ucfirst($ltVal->PASS_NO);
                $rows[] = ucfirst($ltVal->COMP_NAME);
                $rows[] = ucfirst($ltVal->TERMINAL_NAME);
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

    public function addpsa($id = '') {
        $did = decryptval($id);
        $getPsadatas = [];
        $getterminalNamedatas = [];

        if ($id != '') {
            $optWhr['where'] = [
                'AUTO_ID' => $did,
                'VEC_STATUS' => 'Y'
            ];
            $optWhr['return_type'] = 'row';
            $getPsadatas = $this->common_model->getAlldata(PR_SEC, ['*'], $optWhr);
            
             $othercertiDet['where'] = [
            'CERT_PORT_ACCESS_ID' => $did,
            'CERT_COMMON_STATUS' => 'Y',
            ];
        $getOthercertdet = $this->common_model->getAlldata(PSA_CERTI.' as certi',['*'],$othercertiDet);
        }
        $terminWhere['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $terNamedatas = $this->common_model->getAlldata(TERM, ['*'], $terminWhere);
        if (is_array($terNamedatas)) {
            $getterminalNamedatas = customFormDropDown($terNamedatas, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');
        }
        $portUniqId = uniqueRefId('PORT', PR_SEC, 'AUTO_ID');
        $idTypeData = [
            '' => 'Select ID Type',
            '1' => 'IC No',
            '2' => 'Passport No'
        ];
        $data = array(
            'view_file' => 'psa/psa_user/add_form',
            'current_menu' => 'Add Port Security Access ',
            'getPsadatas' => $getPsadatas,
            'portUniqId' => $portUniqId,
            'idTypeData' => $idTypeData,
            'geterminalNamedatas' => $getterminalNamedatas,
            'getOthercertdet' => $getOthercertdet,
        );
        $this->template->load_common_template($data);
    }

    public function savepsa($id = '') {
//       echo "<pre>";
//       print_R($this->input->post());
//       print_R($_FILES);
//       exit;
        $did = decryptval($id);
        $portDatas = $this->input->post('port');
        $certiDatas = $this->input->post('certi');
        $this->form_validation->set_rules('port[NAME]', 'Name', 'required|trim|min_length[3]|max_length[200]|alpha_dash_space');
        $this->form_validation->set_rules('port[ID_TYPE]', 'ID Type', 'required|trim');
        $this->form_validation->set_rules('port[PASS_NO]', 'IC/Passport No', 'required|trim|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('port[COMP_NAME]', 'Company Name', 'required|trim|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('port[DESIG]', 'Designation', 'required|trim|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('port[TERMIN_ID]', 'Terminal Name', 'required|trim');
        $this->form_validation->set_rules('port[IND_DATE]', 'Induction Date', 'required|trim');
        $this->form_validation->set_rules('port[IND_DUE_DATE]', 'Induction Due Date', 'required|trim');
//        print_r($exitDatas);
        if ($this->form_validation->run()) {
            $hazadatas = [
                'PORT_UNQ_ID' => postData($portDatas, 'PORT_UNQ_ID'),
                'NAME' => postData($portDatas, 'NAME'),
                'ID_TYPE' => postData($portDatas, 'ID_TYPE'),
                'PASS_NO' => postData($portDatas, 'PASS_NO'),
                'COMP_NAME' => postData($portDatas, 'COMP_NAME'),
                'DESIG' => postData($portDatas, 'DESIG'),
                'TERMIN_ID' => postData($portDatas, 'TERMIN_ID'),
                'IND_DATE' => converttoDBDate(postData($portDatas, 'IND_DATE')),
                'IND_DUE_DATE' => converttoDBDate(postData($portDatas, 'IND_DUE_DATE'))
            ];
            if ($did != '') {
                $upWhere = [
                    'AUTO_ID' => $did
                ];
                $updtProfile = $this->common_model->updateData(PR_SEC, $hazadatas, $upWhere);
            } else {
                $updtProfile = $this->common_model->updateData(PR_SEC, $hazadatas);
            }
            
             /////////image upload start
            if(isset($certiDatas) && !empty($certiDatas)){
                $imgDatasother = [];
                if(isset($_FILES) && !empty($_FILES)){
                  $imgDatasother = uploadMultipleimage($_FILES, 'assets/images/modules/psa/','oth_competency_certi');
                }
               
                $imgKey = 0;
                
                foreach($certiDatas as $cKey => $cVal){
                   $insertOthercerti = [
                        'CERT_NAME' => postData($cVal,'oth_compCerti_name'),
                        'CERT_START_DATE' =>  date("Y-m-d",strtotime($cVal['oth_start_date'])),
                        'CERT_END_DATE' =>  date("Y-m-d",strtotime($cVal['oth_end_date'])),
                   ]; 
                   
                   /////////image upload start
            
                   if(!empty($imgDatasother[$imgKey])){
                       
                        $imgUplname =  $imgDatasother[$imgKey]['uploadname'];
                        $imgUplpath =  $imgDatasother[$imgKey]['uploadpath'];
                        $imgUplext =  $imgDatasother[$imgKey]['uploadextension'];
                        $imgUplsize =  $imgDatasother[$imgKey]['filesize'];
                        $insertOthercerti['CERT_FILE_NAME'] = $imgUplname;
                               $insertOthercerti['CERT_PATH'] = $imgUplpath;
                               $insertOthercerti['CERT_EXT'] = $imgUplext;
                               $insertOthercerti['CERT_SIZE'] = $imgUplsize;
                       
                    }else{
                       $userImgs = $this->input->post('other_user_img');
                        $uplImgdatas = $userImgs[$imgKey];
                    }
         
                    $imgKey++;
            /////////image upload end
//               print_R($insertOthercerti);
               if($did != ''){
                  
                  $othCompIDedit =  postData($cVal,'other_compCerti_ID');
                   if(isset($othCompIDedit) && !empty($othCompIDedit)){
                       $othercertiWhere['COMP_CERT_ID'] = $othCompIDedit;
                       $insertOthercerti['CERT_PORT_ACCESS_ID'] = $did;
                       $updateOthercert = $this->common_model->updateData(PSA_CERTI,$insertOthercerti,$othercertiWhere);
                   }else{
                       $insertOthercerti['CERT_PORT_ACCESS_ID'] = $did;
                       $updateOthercert = $this->common_model->updateData(PSA_CERTI,$insertOthercerti);
                   }
                    
                 }else{
                     $insertOthercerti['CERT_PORT_ACCESS_ID'] = $updtProfile;
                    $updateOthercert = $this->common_model->updateData(PSA_CERTI,$insertOthercerti);
                 }
                  }
            }
            /////////image upload end

            if ($updtProfile && $updtProfile > 0) {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Port Security Access has been Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Port Security Access has been Created</div>');
                }
                redirect('psa/portsecurity');
            } else {
                if ($did != '') {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Port Security Access cannot be Updated</div>');
                } else {
                    $this->session->set_flashdata('locatn', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Error!</span> Port Security Access cannot be Created</div>');
                }
                redirect('psa/portsecurity');
            }
        } else {
            $this->addpsa($id);
        }
    }
    
    public function deleteParticularcerti(){
            $certiId = $this->input->post('certiId');
           $delCerti = $this->common_model->updateData(PSA_CERTI,['CERT_COMMON_STATUS' => 'N'],['COMP_CERT_ID' => $certiId]);
       
           if($delCerti){
            if($certiId == $delCerti){
                $datResp = [
                    'status' => true,
                    'msg' => 'Certificate Details Deleted Successfully',
                ];
            }else{
                 $datResp = [
                    'status' => false,
                    'msg' => 'Error in Deleting Certificate Details',
                ];
            }
           
        }else{
            $datResp = [
                    'status' => false,
                    'msg' => 'Error in Deleting Certificate Details',
                ];
        }
        echo json_encode($datResp); 
        }

     public function view_report($id = '') {
        $did = decryptval($id);
        $getPsadatas = [];
        $getterminalNamedatas = [];

        if ($id != '') {
            $optWhr['where'] = [
                'AUTO_ID' => $did,
                'VEC_STATUS' => 'Y'
            ];
                  $table = PR_SEC . ' as p';
        $optWhr['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = p.TERMIN_ID', 'left'];
        $orderby = 'p.CREATED_ON';
        $getPsadatas = $this->common_model->getAlldata($table, ['p.*,t.TERMINAL_NAME'], $optWhr, '', '', $orderby, 'DESC');
        }
        $portUniqId = uniqueRefId('PORT', PR_SEC, 'AUTO_ID');
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
            'view_file' => 'psa/psa_user/view_report',
            'current_menu' => 'View Port Security Access ',
            'getPsadatas' => $getPsadatas,
            'portUniqId' => $portUniqId,
            'idTypeData' => $idTypeData,
            'geterminalNamedatas' => $getterminalNamedatas,
            'getOthercertdet' => $getOthercertdet,
        );
        $this->template->load_common_template($data);
    }

   public function deletepsa() {
       $deleteId = $this->input->post('delid');
       $updtDelete = $this->common_model->updateData(PR_SEC, ['VEC_STATUS' => 'N'], ['AUTO_ID' => decryptval($deleteId)]);
//        $updtHazNameDelete = $this->common_model->updateData(HAZA_NAME, ['HAZ_STATUS' => 'N'], ['HIR_HAZA_ID' => decryptval($deleteId)]);
       if ($updtDelete) {
           $retData = [
               'status' => true,
               'msgs' => 'Port Security Access details has been deleted successfully'
           ];
       } else {
           $retData = [
               'status' => false,
               'msgs' => 'Error in deleting Port Security Access details! Try Again later.'
           ];
       }
       echo json_encode($retData);
   }
    //// port end
}
