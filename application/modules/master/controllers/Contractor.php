<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contractor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(1);
        isLogin();
       
    }
    
    public function index(){
        
        $data = array(
            'view_file' => 'contractor/list_contractor',
            'site_title' => 'Contractor ',
            'current_menu' => 'List Contractor ',
            'ajaxurl' => 'master/contractor/list_contractor',
        );

        $this->template->load_table_template($data);
    }
    
    public function list_contractor(){
        $table = CONT_DET.' as cont';
        $column_order = array(null, 'CONT_ID','CONT_COMPANY','CONT_NAME', 'CONT_EMAIL_ID', 'CONT_PHONE_NO', null);
        $column_search = array('CONT_ID','CONT_COMPANY','CONT_NAME', 'CONT_EMAIL_ID', 'CONT_PHONE_NO');
        $order = array('CREATED_ON' => 'desc');
        $where = ['CONT_STATUS' => 'Y'];
        
        $listDept = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where,$optns);
//echo "<pre>";
//echo $this->db->last_query();
        $finalDatas = [];
        if (isset($listDept) && !empty($listDept)) {
            foreach ($listDept as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->CONT_AUTO_ID;
                
                $contLogstat = $ltVal->CON_LOGIN_STATUS;
                
                 if($contLogstat == 'P'){
                    $titileStat = 'Activate/Deactivate';
                }elseif($contLogstat == 'E'){
                     $titileStat = 'Deactivate';
                }else{
                     $titileStat = 'Activate';
                }

                $action .= " " . anchor('master/contractor/addContractor/' . encryptval($id), '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));

                $action .= " " . anchor('master/contractor/viewContractor/' . encryptval($id), '<i class="fas fa-eye aria-hidden="true"></i>', array('class' => '', 'title' => 'View'));
                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteContractor', 'title' => 'Delete', 'delt-id' => $id));
                //$action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";
                $action .= " " . anchor('master/contractor/pdfContractor/' . encryptval($id), '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF'));
               
                $action .= " " . anchor('master/contractor/statusContractor/' . encryptval($id), '<i class="fas fa-user" aria-hidden="true"></i>', array('class' => '', 'title' => $titileStat));
                
                $rows = [];
//            $rows[] = $ltVal->USER_ROLE_ID;
                $rows[] = $ltVal->CONT_ID;
                $rows[] = $ltVal->CONT_COMPANY;
                $rows[] = $ltVal->CONT_NAME;
                $rows[] = $ltVal->CONT_EMAIL_ID;
                $rows[] = $ltVal->CONT_PHONE_NO;
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
    
    public function addContractor($id=""){
        
        $did = decryptval($id);
        
        $uniqContwhr = [];
        if ($id != '') {
            $uniqContwhr = [
                'CONT_AUTO_ID' => $did
            ];
        }

        $contrUniq = uniqueIntRefId('CONT', CONT_DET, 'CONT_AUTO_ID', 'CONT_AUTO_ID', $uniqContwhr);
        
        $getGender = $this->common_model->getAlldata(GENDER, ['*']);
        $dropGender = customFormDropDown($getGender, 'GENDER_ID', 'GENDER_NAME', 'Select Gender');
        
        $getNationality = $this->common_model->getAlldata(NATION, ['*']);
        $dropNation = customFormDropDown($getNationality, 'NATIONALITY_ID', 'NATIONALITY_NAME', 'Select Nationality');

        
        $desigOptn['where'] = [
            'des.DESIGNATION_STATUS' => 'Y',
//            'utdes.USER_TYPE_ID' => 7
        ];
//        $desigOptn['join'][UTYPE_DESIG.' as utdes'] = ['utdes.USER_DESIGN_ID = des.DESIGNATION_ID','left'];
        $getAlldesig = $this->common_model->getAlldata(DESIG.' as des', ['*'], $desigOptn);
        $dropdesignation = customFormDropDown($getAlldesig, 'DESIGNATION_ID', 'DESIGNATION_NAME', 'Select Designation');
        
        
        $ccomOptn['where'] = [
           'certi.CERT_USER_TYPE' => 'EMP',
            'certi.CERT_TYPE' => 'MAIN',
            'certi.CERT_USER_ID' => $did,
        ];
        $getAllcCom = $this->common_model->getAlldata(COMP_CERTI.' as certi', ['*'], $ccomOptn);
        
        $emplOptns['where'] = [
            'CONT_AUTO_ID' => $did,
//            'CERT_USER_TYPE' => 'CONT',
            'CONT_STATUS' => 'Y',
//            'CERT_TYPE' => 'MAIN',
        ];
        
        if($getAllcCom != ''){
            $emplOptns['where']['CERT_USER_TYPE'] = 'CONT';
            $emplOptns['where']['CERT_TYPE'] = 'MAIN';
        }
        $emplOptns['join'][COMP_CERTI.' as cert'] = ['cert.CERT_USER_ID = cont.CONT_AUTO_ID','left'];
        $emplOptns['return_type'] = 'row';
        $getEmploydetails = $this->common_model->getAlldata(CONT_DET.' as cont',['*'],$emplOptns);
        
        $othercertiDet['where'] = [
            'CERT_USER_ID' => $did,
            'CERT_TYPE' => 'OTHER',
            'CERT_USER_TYPE' => 'CONT',
            'CERT_COMMON_STATUS' => 'Y',
            ];
        $getOthercertdet = $this->common_model->getAlldata(COMP_CERTI.' as certi',['*'],$othercertiDet);
//        echo "<pre>";
//        echo $this->db->last_query();
//        print_R($getOthercertdet);
//        exit;
       
         $data = array(
            'view_file' => 'contractor/add_contractor',
            'current_menu' => 'Add Contractor',
            'dropGender' => $dropGender,
            'dropNation' => $dropNation,
            'dropTermname' => $dropTermname,
            'dropdesignation' => $dropdesignation,
            'dropDepart' => $dropDepart,
            'getEmploydetails' => $getEmploydetails,
            'getOthercertdet' => $getOthercertdet,
            'contrUniq' => $contrUniq,
         );
        $this->template->load_common_template($data);
    }
    
    public function insertContractor($id=""){
//        echo "<pre>";
//        print_R($this->input->post());
//        print_R($_FILES);
//        exit;
        $this->form_validation->set_rules('cont[comp_name]', 'Company Name', 'required|trim');
        $empDatas = $this->input->post('cont');
        $certiDatas = $this->input->post('certi');
       
        if ($this->form_validation->run() == true) {
            
            $did = decryptval($id);
            
            $nationalDet = postData($empDatas,'nationality');
            if($nationalDet != 3){
                $nationalDetfinal = '';
            }else{
                $nationalDetfinal = postData($empDatas,'nationality_other');
            }
            $inserEmpldatas = [
                'CONT_ID' => postData($empDatas,'cont_no'),
                'CONT_NAME' => postData($empDatas,'cont_name'),
                'CONT_COMPANY' => postData($empDatas,'comp_name'),
                'CONT_EMAIL_ID' => postData($empDatas,'cont_mail'),
                'CONT_SPECIAL' => postData($empDatas,'comp_spec'),
                'CONT_PHONE_NO' => postData($empDatas,'phone_num'),
                'CONT_ADDRESS' => postData($empDatas,'address'),
                'CONT_CITY' => postData($empDatas,'city'),
                'CONT_COUNTRY' => postData($empDatas,'country'),
                'CONT_POSTAL_CODE' => postData($empDatas,'pos_code'),
                'CONT_DOB' => date("Y-m-d",strtotime($empDatas['dob'])),
                'CONT_GENDER' => postData($empDatas,'gender'),
                'CONT_NATIONALITY' => $nationalDet,
                'CONT_NATIONALITY_OTHER' => $nationalDetfinal,
                'CONT_DESIGNATION' => postData($empDatas,'desig'),
                'CON_LOGIN_STATUS' => 'P',
                'CONT_ID_TYPE' => postData($empDatas,'contIdtyp'),
                'CONT_ID_NUMBER' => postData($empDatas,'nric'),
            ];
           
            if($did != ''){
               $updtEmpl = $this->common_model->updateData(CONT_DET,$inserEmpldatas,['CONT_AUTO_ID' => $did]);
            }else{
               $updtEmpl = $this->common_model->updateData(CONT_DET,$inserEmpldatas);
            }
            
            $insertCertidet = [
                'CERT_USER_TYPE' => 'CONT',
                'CERT_TYPE' => 'MAIN',
                'CERT_NAME' => postData($empDatas,'compCerti_name'),
                'CERT_START_DATE' => date("Y-m-d",strtotime($empDatas['start_date'])),
                'CERT_END_DATE' => date("Y-m-d",strtotime($empDatas['end_date'])),
            ];
            
            /////////image upload start
            $imgDatas = [];
          if(isset($_FILES) && !empty($_FILES)){
            $imgDatas = uploadMultipleimage($_FILES, 'assets/images/modules/contractor/','competency_certi');
          }
          
//          print_R($imgDatas);
         
                        if(!empty($imgDatas[0])){
                               $imgUplname =  $imgDatas[0]['uploadname'];
                               $imgUplpath =  $imgDatas[0]['uploadpath'];
                               $imgUplext =  $imgDatas[0]['uploadextension'];
                               $imgUplsize =  $imgDatas[0]['filesize'];
                               $insertCertidet['CERT_FILE_NAME'] = $imgUplname;
                               $insertCertidet['CERT_PATH'] = $imgUplpath;
                               $insertCertidet['CERT_EXT'] = $imgUplext;
                               $insertCertidet['CERT_SIZE'] = $imgUplsize;
                         }
            /////////image upload end
            if($did != ''){
                
                $mainCertID = postData($empDatas,'mainCerti_id');
                
                $certiWhere = [
                    'CERT_USER_ID' => $did,
                    'CERT_TYPE' => 'MAIN',
                    'CERT_USER_TYPE' => 'CONT',
                ];
                 if($mainCertID !=''){
                    $updtCerti = $this->common_model->updateData(COMP_CERTI,$insertCertidet,$certiWhere);
                 }else{
                     $insertCertidet['CERT_USER_ID'] = $did;
                    $updtCerti = $this->common_model->updateData(COMP_CERTI,$insertCertidet);
                 }
               
               if($did != ''){
                   $cntDetoptwhr = [
                       'CONT_AUTO_ID' => $did
                   ];
                  
               }else{
                   $cntDetoptwhr = [
                       'CONT_AUTO_ID' => $updtEmpl
                   ]; 
               }
               
               $updtEmplcerti = $this->common_model->updateData(CONT_DET,['CERT_STATUS' => postData($empDatas,'elig_status')],$cntDetoptwhr);
//               echo $this->db->last_query();
            }else{
                $insertCertidet['CERT_USER_ID'] = $updtEmpl;
               $updtCerti = $this->common_model->updateData(COMP_CERTI,$insertCertidet);
               
               $updtEmplcerti = $this->common_model->updateData(CONT_DET,['CERT_STATUS' => postData($empDatas,'elig_status')],[ 'CONT_AUTO_ID' => $updtEmpl]);
            
//               echo $this->db->last_query();
            }
//            exit;
            if(isset($certiDatas) && !empty($certiDatas)){
                $imgDatasother = [];
                if(isset($_FILES) && !empty($_FILES)){
                  $imgDatasother = uploadMultipleimage($_FILES, 'assets/images/modules/contractor/','oth_competency_certi');
                }
                
               
//                echo "<pre>";
//                print_R($imgDatasother);
//                print_R($certiDatas);
//                exit;
                $imgKey = 0;
                
                foreach($certiDatas as $cKey => $cVal){
                   $insertOthercerti = [
                        'CERT_USER_TYPE' => 'CONT',
                        'CERT_TYPE' => 'OTHER',
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
                   $othercertiWhere = [
                    'CERT_USER_ID' => $did,
                    'CERT_TYPE' => 'OTHER',
                    'CERT_USER_TYPE' => 'CONT',
                ];
                  $othCompIDedit =  postData($cVal,'other_compCerti_ID');
                   if(isset($othCompIDedit) && !empty($othCompIDedit)){
                       $othercertiWhere['COMP_CERT_ID'] = $othCompIDedit;
                       $othercertiWhere['CERT_USER_ID'] = $did;
                       $updateOthercert = $this->common_model->updateData(COMP_CERTI,$insertOthercerti,$othercertiWhere);
                   }else{
                       $insertOthercerti['CERT_USER_ID'] = $did;
                       $updateOthercert = $this->common_model->updateData(COMP_CERTI,$insertOthercerti);
                   }
                    
                 }else{
                     $insertOthercerti['CERT_USER_ID'] = $updtEmpl;
                    
                    $updateOthercert = $this->common_model->updateData(COMP_CERTI,$insertOthercerti);
                 }
                  }
            }
//              exit;        
            if ($updtEmpl) {
               
                if ($did != '') {
                    $data['flasmsg'] = $this->session->set_flashdata('contractor', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Contractor Details has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('contractor', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Contractor Details has been Created</div>');
                }
                redirect('master/contractor');
            } else {
                
                if ($did != '') {
                    $data['flasmsg'] = $this->session->set_flashdata('contractor', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Sorry!</span> Contractor Details cannot be Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('contractor', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Sorry!</span> Contractor Details cannot be Created</div>');
                }
                redirect('master/contractor');
            }  
             
        }else{
            $this->addContractor($id);
        }
    }
    public function deleteContractor($id=""){
         $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(CONT_DET, ['CONT_STATUS' => 'N'], ['CONT_AUTO_ID' => $deleteId]);
      $updtloginDelete = $this->common_model->updateData(LOGIN, ['USER_LOG_STATUS' => 'N'], ['USER_REF_ID' => $deleteId,'USER_LOGIN_TYP'=> 1]);
        $updtCertDelete = $this->common_model->updateData(COMP_CERTI, ['CERT_COMMON_STATUS' => 'N'], ['CERT_USER_ID' => $deleteId,'CERT_USER_TYPE'=>'CONT']);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Contractor deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Contractor'
            ];
        }
        echo json_encode($retData);
    }
    
    public function viewContractor($id=""){
        $did = decryptval($id);
        
        $ccomOptn['where'] = [
           'cert.CERT_USER_TYPE' => 'CONT',
            'cert.CERT_TYPE' => 'MAIN',
            'cert.CERT_USER_ID' => $did,
        ];
        $getAllcCom = $this->common_model->getAlldata(COMP_CERTI.' as cert', ['*'], $ccomOptn);
        
        $emplOptns['where'] = [
            'CONT_AUTO_ID' => $did,
//            'CERT_USER_TYPE' => 'CONT',
        ];
        
        if($getAllcCom != ''){
            $emplOptns['where']['CERT_USER_TYPE'] = 'CONT';
            $emplOptns['where']['CERT_TYPE'] = 'MAIN';
        }
        
        $emplOptns['join'][COMP_CERTI.' as cert'] = ['cert.CERT_USER_ID = cont.CONT_AUTO_ID','left'];
//        $emplOptns['join'][DESIG.' as desg'] = ['desg.DESIGNATION_ID = cont.CONT_DESIGNATION','left'];
        $emplOptns['join'][NATION.' as nation'] = ['nation.NATIONALITY_ID = cont.CONT_NATIONALITY','left'];
        $emplOptns['join'][GENDER.' as gend'] = ['gend.GENDER_ID = cont.CONT_GENDER','left'];
        $emplOptns['return_type'] = 'row';
        $getEmploydetails = $this->common_model->getAlldata(CONT_DET.' as cont',['cont.*,cert.*,gend.GENDER_NAME,nation.NATIONALITY_NAME'],$emplOptns);
        
        $othercertiDet['where'] = [
            'CERT_USER_ID' => $did,
            'CERT_TYPE' => 'OTHER',
            'CERT_COMMON_STATUS' => 'Y',
            'CERT_USER_TYPE' => 'CONT',
            ];
        $getOthercertdet = $this->common_model->getAlldata(COMP_CERTI.' as certi',['*'],$othercertiDet);
        
         $data = array(
            'view_file' => 'contractor/view_contractor',
            'current_menu' => 'View Contractor',
            'getEmploydetails' => $getEmploydetails,
            'getOthercertdet' => $getOthercertdet,
         );
        $this->template->load_common_template($data);
   
        }
        
        public function deleteParticularcerti(){
            $certiId = $this->input->post('certiId');
           $delCerti = $this->common_model->updateData(COMP_CERTI,['CERT_COMMON_STATUS' => 'N'],['COMP_CERT_ID' => $certiId]);
       
           if($delCerti){
            if($certiId == $delCerti){
                $datResp = [
                    'status' => true,
                    'msg' => 'Competency Certificate Deleted Successfully',
                ];
            }else{
                 $datResp = [
                    'status' => false,
                    'msg' => 'Error in Deleting Competency Certificate',
                ];
            }
           
        }else{
            $datResp = [
                    'status' => false,
                    'msg' => 'Error in Deleting Competency Certificate',
                ];
        }
        echo json_encode($datResp); 
        }
        
        public function pdfContractor($id ='') {
        $did = decryptval($id);
        
        $ccomOptn['where'] = [
           'cert.CERT_USER_TYPE' => 'CONT',
            'cert.CERT_TYPE' => 'MAIN',
            'cert.CERT_USER_ID' => $did,
        ];
        $getAllcCom = $this->common_model->getAlldata(COMP_CERTI.' as cert', ['*'], $ccomOptn);
        
        $emplOptns['where'] = [
            'CONT_AUTO_ID' => $did,
//            'CERT_USER_TYPE' => 'CONT',
        ];
        
        if($getAllcCom != ''){
            $emplOptns['where']['CERT_USER_TYPE'] = 'CONT';
            $emplOptns['where']['CERT_TYPE'] = 'MAIN';
        }
        $emplOptns['join'][COMP_CERTI.' as cert'] = ['cert.CERT_USER_ID = cont.CONT_AUTO_ID','left'];
//        $emplOptns['join'][DESIG.' as desg'] = ['desg.DESIGNATION_ID = cont.CONT_DESIGNATION','left'];
        $emplOptns['join'][NATION.' as nation'] = ['nation.NATIONALITY_ID = cont.CONT_NATIONALITY','left'];
        $emplOptns['join'][GENDER.' as gend'] = ['gend.GENDER_ID = cont.CONT_GENDER','left'];
        $emplOptns['return_type'] = 'row';
        $getEmploydetails = $this->common_model->getAlldata(CONT_DET.' as cont',['cont.*,cert.*,gend.GENDER_NAME,nation.NATIONALITY_NAME'],$emplOptns);
        
        $othercertiDet['where'] = [
            'CERT_USER_ID' => $did,
            'CERT_TYPE' => 'OTHER',
            'CERT_COMMON_STATUS' => 'Y',
            'CERT_USER_TYPE' => 'CONT',
            ];
        $getOthercertdet = $this->common_model->getAlldata(COMP_CERTI.' as certi',['*'],$othercertiDet);
        
        
        $data=[
            'getEmploydetails'=>$getEmploydetails,
            'getOthercertdet'=>$getOthercertdet,
        ];
        $html2 = $this->load->view('master/contractor/pdf_contractor',$data, true);
         $mpdf2 = $this->pdf->ptwload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "contractor";
        $file_path = "assets/uploads/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $file_path . 'Contractor-' . $PdfId . '-' . $currenttime . '.pdf';
        $name = 'Contractor-' . $currenttime . '.pdf';
        $mpdf2->Output($path2, "F");
        $data = file_get_contents($path2);
        force_download($name, $data);
        
    }
    
     public function statusContractor($id=''){
        $did = decryptval($id);
        
        $emplOptns['where'] = [
            'cont.CONT_AUTO_ID' => $did
        ];
//        $emplOptns['join'][DESIG.' as des'] = ['des.DESIGNATION_ID = cont.CONT_DESIGNATION','left'];
//        $emplOptns['join'][UTYPE_DESIG.' as utdes'] = ['utdes.USER_DESIGN_ID = cont.CONT_DESIGNATION','left'];
//        $emplOptns['join'][UTYPE.' as utyp'] = ['utyp.USER_TYPE_ID = utdes.USER_TYPE_ID','left'];
//        $emplOptns['join'][LOGIN.' as log'] = ['log.USER_REF_ID = cont.CONT_AUTO_ID','left'];
        $emplOptns['join'][NATION.' as nation'] = ['nation.NATIONALITY_ID = cont.CONT_NATIONALITY','left'];
        $emplOptns['join'][GENDER.' as gend'] = ['gend.GENDER_ID = cont.CONT_GENDER','left'];
        $emplOptns['return_type'] = 'row';
        $getEmploydetails = $this->common_model->getAlldata(CONT_DET.' as cont',['cont.*,gend.GENDER_NAME,nation.NATIONALITY_NAME'],$emplOptns);

        $emplLogoptns['where'] = [
            'USER_REF_ID' => $did,
            'USER_LOGIN_TYP' => 1,
        ];
        $emplLogoptns['return_type'] = 'row';
        $emplLogindet = $this->common_model->getAlldata(LOGIN,['*'],$emplLogoptns);
        
        $data = array(
            'view_file' => 'contractor/status_contractor',
            'current_menu' => 'Contractor Status',
            'getEmploydetails' => $getEmploydetails,
            'emplLogindet' => $emplLogindet,
//            'getOthercertdet' => $getOthercertdet,
         );
        $this->template->load_common_template($data);
    }
    public function updateContstatus($id=''){
       
        $did = decryptval($id);
        $statDet = $this->input->post('stat');
        $empStatus = postData($statDet,'empStatus');
        $hidLogid = postData($statDet,'hidLogid');
//         echo "<pre>";
//         print_R($this->input->post());
//         exit;
       $updateEmp = $this->common_model->updateData(CONT_DET,['CON_LOGIN_STATUS' => $empStatus],['CONT_AUTO_ID' => $did]);
    
       $logDet = [
           'USER_REF_ID' => postData($statDet,'userRefid'),
           'USER_TYPE_ID' => 11,
           'USER_DESINATION_ID' => postData($statDet,'contDesig'),
           'USERNAME' => postData($statDet,'contID'),
//           'ENCRYPT_PASSWORD' => md5(postData($statDet,'password')),
//           'ORG_PWD' => postData($statDet,'password'),
           'USER_LOGIN_TYP' => 1
       ];
       if($empStatus == 'E' || $empStatus == 'N'){
           $logDet['USER_LOG_STATUS'] = 'Y';
           $logDet['ORG_PWD'] = postData($statDet,'password');
           $logDet['ENCRYPT_PASSWORD'] = md5(postData($statDet,'password'));
       }else{
           $logDet['USER_LOG_STATUS'] = 'N';
       }
       if($hidLogid != ''){
           $updateLogin = $this->common_model->updateData(LOGIN,$logDet,['LOGIN_ID' => $hidLogid]);
       }else{
           $updateLogin = $this->common_model->updateData(LOGIN,$logDet);
       }
       
       
       if($updateLogin){
            /////////// new notification start
               $idata['messageText'] = 'Login credential has been created for you to access Vault, by HSSE team,Lumut
Maritime Terminal Sdn Bhd by HSSE team. Find
                                        your below credentials :<br><br>'
                                        .'<b>URL</b> : '.BASE_URL
                                        .'<br><b>User Name</b> : '.postData($statDet,'contID')
                                        .'<br><b>Password</b> : '.postData($statDet,'password')
                                        .'<br><br>This is system generated E-mail, do not reply to this email.';
//                   $idata['footerText'] = ' <br><br/> SYSTEM GENERATED EMAIL. <br>';
                $idata['emplmailID'] = postData($statDet,'contMailid');
                $idata['emplName'] = postData($statDet,'contrcName');
//                $idata['messageTextnotify'] = '<br>Safety Officer( '.$safOffNameval.' ) has been successfully executed the "<b>INSPECTION</b>" with the ID # <b>"'.$inspUniqid.'" </b> and assigned <b> '.$idata['emplName'].'</b> for the fixation. <br><br>For more details about the inspection, kindly review the attached report in this mail.<br><br>For any further information or clarification, please do not hesitate to contact us. <br>Have a nice day.<br><br>Thanks & Regards,<br>KCG Support Team<br>Email: support@kcg.com<br>';
                $idata['subject'] = 'VAULT - CONTRACTOR REGISTRATION';
                $idata['mainModule'] = 'masterMod';
  
            internalNotificationOverall($idata);  
            //////////// mail notification start
            
                 ///// notification end
            
             if ($empStatus == 'E') {
                    $data['flasmsg'] = $this->session->set_flashdata('contractor', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Contractor Activated Successfully </div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('contractor', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Contractor Deactivated Successfully</div>');
                }
       }
        redirect('master/contractor');
    }
    
}
