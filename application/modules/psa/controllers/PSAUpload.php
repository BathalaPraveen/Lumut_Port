<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PSAUpload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(1);
        isLogin();
    }

    public function index($fdata = ['upload_error' => '']) {

        $data = array(
            'view_file' => 'psa_upload/upload',
            'site_title' => 'Port Security Access Upload ',
            'current_menu' => 'psa_upload ',
        );
        $formData = $fdata + $data;


        $this->template->load_table_template($formData);
    }
    
   public function get_file_extensions($file_name) {
   $ext =  pathinfo($file_name, PATHINFO_EXTENSION);
   return '.'.$ext;
   }
   
   public function readExcel($filePath = ''){
       $this->load->library('PHPExcel');
                $extension = $this->get_file_extensions($filePath);
                if (strtolower($extension) == '.csv') {
                    $inputFileType = 'CSV';
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $excel = $objReader->load($filePath);
                } else if (strtolower($extension) == '.xls') {
                    $reader = PHPExcel_IOFactory::createReader('Excel5');
                    $reader->setReadDataOnly(true);
                    $path = (FCPATH . $fileName);
                    $excel = $reader->load($path);
                } else {
                    $reader = PHPExcel_IOFactory::createReader('Excel2007');
                    $reader->setReadDataOnly(true);
                    $path = (FCPATH . $filePath);
                    $excel = $reader->load($path);
                }

                return $sheet = $excel->getActiveSheet()->toArray(null, true, true, true);
   }

    public function uploadfile() {
        $userType = getCurrentUserGroupId();
        $userid = getCurrentUserid();
        
        $mpath = 'public/module/PSA/';
        if (!file_exists(FCPATH . $mpath)) {
            mkdir(FCPATH . $mpath, 0755, true);
        }

        $uploadPath = 'public/module/PSA/' . date('Ymd') . '/';
        $allowedTyp = "xls|csv|xlsx";

        $mpath = $imgUploadpath;
        if (!file_exists(FCPATH . $mpath)) {
            mkdir(FCPATH . $mpath, 0755, true);
        }


        $config['upload_path'] = FCPATH . $uploadPath;
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0755);
        }

        $config['allowed_types'] = $allowedTyp;
        $config['encrypt_name'] = FALSE;
//        $config['overwrite'] = TRUE;
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('upload_documents')) {
            $error = $this->upload->display_errors();
            $data['upload_error'] = $error;
            $this->index($data);
        } else {
            $fileData = $this->upload->data();

            $uploadpath = $path;
            $returndata['uploadname'] = $fileData['file_name'];
            $returndata['uploadorigname'] = $fileData['orig_name'];
            $returndata['uploadpath'] = $uploadPath;
            $returndata['uploadtype'] = $fileData['file_type'];
            $returndata['uploadextension'] = $fileData['file_ext'];
            $returndata['filesize'] = $fileData['file_size'];
            $returndata['client_name'] = $fileData['client_name'];
            $returndata['orig_name'] = $fileData['orig_name'];
            $returndata['is_image'] = $fileData['is_image'];
            $returndata['image_type'] = $fileData['image_type'];
            $returndata['image_width'] = $fileData['image_width'];
            $returndata['image_height'] = $fileData['image_height'];
            $returndata['image_size_str'] = $fileData['image_size_str'];
        }
        if (count($returndata) > 0) {
            $fileName = $returndata['uploadname'];
            $filePath = $returndata['uploadpath'].$fileName;
            $uploadData = [
                'UPLOAD_FILE_NAME' => $fileName,
                'UPLOAD_FILE_PATH' => $returndata['uploadpath'],
                'LOGIN_ID' => $userid,
                'STATUS' => 1,
            ];
            $where = [
                'UPLOAD_FILE_NAME' => $fileName,
                'UPLOAD_FILE_PATH' => $returndata['uploadpath'],
                'LOGIN_ID' => $userid,
            ];
            $updateId = $this->common_model->updateInfo('TEMP_PSA_UPLOAD_FILE', $uploadData, $returnid = 'PSA_UPLOAD_ID', $where);

            if ($updateId) {
                $sheet = $this->readExcel($filePath);
                
                if($sheet != FALSE && count($sheet) > 0){
           
            
                    foreach($sheet as $row){
                        $aRow = $row;
                        $row = (object)$aRow;
                                              
                        
                        $psaName = postData($row,'A');
                        $psaIdType = postData($row,'B');
                        $psaIdTypeNumber = postData($row,'C');
                        $companyName = postData($row,'D');
                        $psaDesignation = postData($row,'E');
                        $psaTerminal = postData($row,'F');
                        //$psaInductionDate = postData($row,'G');
                        //$psaInductionDueDate = postData($row,'H');
			$psaInductionDate = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP(postData($row,'G')));
                        $psaInductionDueDate = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP(postData($row,'H')));
                        $psaackby = postData($row,'I');
                                                
                        $idTypeData = [
                            '' => 'Select ID Type',
                            '1' => 'IC',
                            '2' => 'Passport'
                        ];
                        
                        $psaId = array_search(trim($psaIdType), $idTypeData);

                        if($psaName !='Name'){
                            
                           // $psaIndDate = convertDate($psaInductionDate, $format='Y-m-d');
                          //  $psaIndDueDate = convertDate($psaInductionDueDate, $format='Y-m-d');
			$psaIndDate = $psaInductionDate;
                            $psaIndDueDate = $psaInductionDueDate;
                          
                            
                            $insertData = [
                                'UPLOAD_ID'=>$updateId,
                                'PSA_NAME'=>$psaName,
                                'PSA_ID_TYPE'=>$psaIdType,
                                'PSA_ID_TYPE_ID'=>$psaId,
                                'PSA_ID_NUMBER'=>$psaIdTypeNumber,
                                'PSA_COMPANY_NAME'=>$companyName,
                                'PSA_DESIGNATION_NAME'=>$psaDesignation,
                                'TERMINAL_NAME'=>$psaTerminal,
                                'TERMINAL_ID'=>0,
                                'PSA_INDUCTION_DATE'=>$psaIndDate,
                                'PSA_INDUCTION_DUE_DATE'=>$psaIndDueDate,
                                'ACK_BY'=>$psaackby,
                                'CREATED_BY'=>$userid,
                                'IS_DELETED'=>'0',
                                'IS_TRASH'=>'N',
                                'IS_DUPLICATE'=>'0',
                                'IS_IMPORTED'=>'0',
                                'CREATED_ON'=>date('Y-m-d H:i:s')
                            ];
                            $where = [
                                'UPLOAD_ID'=>$updateId,
                                'PSA_NAME'=>$psaName,
                                'PSA_ID_TYPE'=>$psaIdType,
                                'PSA_ID_TYPE_ID'=>$psaId,
                                'PSA_ID_NUMBER'=>$psaIdTypeNumber,
                                'PSA_COMPANY_NAME'=>$companyName,
                                'PSA_DESIGNATION_NAME'=>$psaDesignation,
                                'TERMINAL_NAME'=>$psaTerminal,
                                'TERMINAL_ID'=>0,
                                'PSA_INDUCTION_DATE'=>$psaIndDate,
                                'PSA_INDUCTION_DUE_DATE'=>$psaIndDueDate,
                                'ACK_BY'=>$psaackby,
                                'CREATED_BY'=>$userid,
                            ];
                            
                             $optionsEmp = [
                               
                                'ID_TYPE' => $psaId,
                                'PASS_NO' => $psaIdTypeNumber,
                                'COMP_NAME' => $companyName,
                                'DESIG' => $psaDesignation,
                                'IND_DATE' => $psaIndDate,
                                'IND_DUE_DATE' => $psaIndDueDate
                             ];
                    
                            $this->db->select('*');
                            $this->db->from(PR_SEC);
                            foreach ($optionsEmp as $wKey => $wVal) {
                              $this->db->where($wKey, $wVal);
                            }
                           
                            
                            $result = $this->db->get();
                            $getEmpInfo = ($result != false && $result->num_rows() > 0) ? $result->row() : FALSE;
                            if($getEmpInfo != FALSE){
                                $insertData['IS_DUPLICATE'] = '1';
                            }else{
                                $insertData['IS_DUPLICATE'] = '0';
                            }
                            
                            $insertId = $this->common_model->updateInfo('TEMP_PSA_UPLOAD_DATA', $insertData, $returnid = 'PSA_UPLOAD_DATA_ID', $where);
                        }
                       
                    }
                }
                $redirectURL = BASE_URL.'psa/PSAUpload/previewData/'. encryptval($updateId);
                 $this->session->set_flashdata('uploadDatamsg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Port security access data has been uploaded and waiting for your confirmation. </div>');
                redirect($redirectURL);
            }else{
                $this->session->set_flashdata('uploadDatamsg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Port security access data  uploaded failed. </div>');
                 $redirectURL = BASE_URL.'psa/PSAUpload/';
                redirect($redirectURL);
            }
        }else{
              $this->session->set_flashdata('uploadDatamsg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Port security access data uploaded failed. </div>');
                 $redirectURL = BASE_URL.'psa/PSAUpload';
                redirect($redirectURL);
        }
    }
    
    public function previewData($id=''){
        $showBtn = TRUE;
        if($id !=''){
            $decId = decryptval($id);
            $tab = 'TEMP_PSA_UPLOAD_FILE';
            $optionsEmp['where'] = [
                'IS_IMPORTED'=>'1',
                'PSA_UPLOAD_ID'=>$decId,
            ];
             $getuploadedDataInfo = $this->common_model->getAlldata($tab, ['*'], $optionsEmp);
             $showBtn = ($getuploadedDataInfo != FALSE) ? FALSE : TRUE;
        }
        
        $data = array(
            'view_file' => 'psa_upload/preview_upload',
            'site_title' => 'PSA ',
            'current_menu' => 'psa_upload ',
            'editId' => $id,
            'showImportBtn' => $showBtn,
            'ajaxurl' => 'psa/PSAUpload/previewUploadList/'.$id,
        );

        $this->template->load_table_template($data);
    }
    
    public function previewUploadList($id=''){
        $decId = decryptval($id);
        if($decId > 0){
            $table = 'TEMP_PSA_UPLOAD_DATA';
        $column_order = array('PSA_NAME','PSA_ID_TYPE','PSA_ID_NUMBER' ,'PSA_COMPANY_NAME', 'PSA_DESIGNATION_NAME','TERMINAL_NAME','PSA_INDUCTION_DATE','PSA_INDUCTION_DUE_DATE','ACK_BY');
        $column_search = array('PSA_NAME','PSA_ID_TYPE', 'PSA_ID_NUMBER' ,'PSA_COMPANY_NAME', 'PSA_DESIGNATION_NAME','TERMINAL_NAME','PSA_INDUCTION_DATE','PSA_INDUCTION_DUE_DATE','ACK_BY');
        $order = array('CREATED_ON' => 'desc');
        $where = [
            'IS_TRASH' => 'N',
            'UPLOAD_ID' => $decId,
            ];
        $optns = [];
        
        $listDept = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where,$optns);

        $finalDatas = [];
        if (isset($listDept) && !empty($listDept)) {
            foreach ($listDept as $ltKey => $ltVal) {
                
                        switch ($ltVal->IS_IMPORTED) {
                            case 1:
                                $stuatus = '<label class="btn btn-xs btn-success">Imported</label>';
                                break;
                            
                            default:
                                 $stuatus = '<label class="btn btn-xs btn-warning">Pending</label>';
                                break;
                        }
              
                $rows = [];
               
                $rows[] = $ltVal->PSA_NAME;
                $rows[] = $ltVal->PSA_ID_TYPE;
                $rows[] = $ltVal->PSA_ID_NUMBER;
                $rows[] = $ltVal->PSA_COMPANY_NAME;
                $rows[] = $ltVal->PSA_DESIGNATION_NAME;
                $rows[] = $ltVal->TERMINAL_NAME;
                $rows[] = $ltVal->PSA_INDUCTION_DATE;
                $rows[] = $ltVal->PSA_INDUCTION_DUE_DATE;
                $rows[] = $ltVal->ACK_BY;
                $rows[] = $stuatus;
                $rows[] = $ltVal->IS_DUPLICATE;
                $rows[] = $ltVal->IS_IMPORTED;
                
               
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
    }
   
    public function importData(){
        $id = $this->input->post('editId');
        $importType = $this->input->post('import_type');
        $decId = decryptval($id);
       
        if($decId > 0){
           
         
        $optionsEmp['where'] = [
               'IS_TRASH' => 'N',
               'UPLOAD_ID' => $decId,
//               'IS_IMPORTED' => '0',
            ];
            $optionsEmp['return_type'] = 'result';
             if($importType == 'edit'){
              $optionsEmp['where_in'] = [
                  'IS_DUPLICATE'=>['0','1']
              ];
            }else{
                $optionsEmp['where']['IS_DUPLICATE'] = '0';
            }
            $getuploadedDataInfo = $this->common_model->getAlldata('TEMP_PSA_UPLOAD_DATA', ['*'], $optionsEmp);
                      
            if($getuploadedDataInfo != FALSE && count($getuploadedDataInfo) > 0){
                foreach ($getuploadedDataInfo as $row){
                    
                        $uploadDataId = postData($row,'UPLOAD_ID');
                        $uploadId = postData($row,'PSA_UPLOAD_DATA_ID');
                        $psaName = postData($row,'PSA_NAME');
                        $psaTypeId = postData($row,'PSA_ID_TYPE_ID');
                        $psaIDNumber = postData($row,'PSA_ID_NUMBER');
                        $companyName = postData($row,'PSA_COMPANY_NAME');
                        $design = postData($row,'PSA_DESIGNATION_NAME');
                        $terminal = postData($row,'TERMINAL_NAME');
                        $indDate = postData($row,'PSA_INDUCTION_DATE');
                        $indDueDate = postData($row,'PSA_INDUCTION_DUE_DATE');
                        $psaack = postData($row,'ACK_BY');
                       
                        
                      /*Location*/  
                        $termOptn['return_type'] = 'row';
                        $termOptn['where'] = [
                        'TERMINAL_STATUS' => 'Y',
                        'LOWER(TERMINAL_NAME)' =>strtolower($terminal)
                        ];
                    $getAllterminal = $this->common_model->getAlldata(TERM, ['TER_AUTO_ID'], $termOptn);
                    if($getAllterminal == FALSE){
                        $terminalId = 0;
                    }else{
                        $terminalId =  postData($getAllterminal,'TER_AUTO_ID');
                    }
                    
                  
                    
                  if($terminalId > 0){
                   
                    $insertPsaData = [
                        
                        'NAME' => $psaName,
                        'ID_TYPE' => $psaTypeId,
                        'PASS_NO' => $psaIDNumber,
                        'COMP_NAME' => $companyName,
                        'DESIG' => $design,
                        'TERMIN_ID' => $terminalId,
                        'IND_DATE' => $indDate,
                        'IND_DUE_DATE' => $indDueDate,
                        'ACK_BY' => $psaack
                    ];
                   
                    $psaWhere = [
                        'ID_TYPE' => $psaTypeId,
                        'PASS_NO' => $psaIDNumber,
                        'COMP_NAME' => $companyName,
                        'DESIG' => $design,
                        'TERMIN_ID' => $terminalId,
                        'IND_DATE' => $indDate,
                        'IND_DUE_DATE' => $indDueDate
                    ];
                    
                    $optionsPsa = [   
                        'ID_TYPE' => $psaTypeId,
                        'PASS_NO' => $psaIDNumber,
                        'COMP_NAME' => $companyName,
                        'DESIG' => $design,
                        'TERMIN_ID' => $terminalId,
                        'IND_DATE' => $indDate,
                        'IND_DUE_DATE' => $indDueDate
                    ];
                    
                            $this->db->select('*');
                            $this->db->from(PR_SEC);
                            foreach ($optionsPsa as $wKey => $wVal) {
                              $this->db->where($wKey, $wVal);
                            }
                           
                            $result = $this->db->get();
                            $getPSAInfo = ($result != false && $result->num_rows() > 0) ? $result->row() : FALSE;
                            if($getPSAInfo == FALSE){
                                $portUniqId = uniqueRefId('PORT', PR_SEC, 'AUTO_ID');
                                $insertPsaData['PORT_UNQ_ID'] = $portUniqId;
                                
                            }
                    
                    $psaId = $this->common_model->updateInfo(PR_SEC,$insertPsaData,'AUTO_ID',$psaWhere);
                                        
                    if($psaId > 0){
                        $upData = [
                            'IS_IMPORTED'=>'1'
                        ];
                        $upWhere = [
                            'PSA_UPLOAD_DATA_ID'=>$uploadId
                        ];
                        $updtUpload = $this->common_model->updateData('TEMP_PSA_UPLOAD_DATA',$upData,$upWhere);
                        
                         $upDatafileData = [
                            'IS_IMPORTED'=>'1'
                        ];
                        $upDatafileWhere = [
                            'PSA_UPLOAD_ID'=>$uploadDataId
                        ];
                        $updtUpload = $this->common_model->updateData('TEMP_PSA_UPLOAD_FILE',$upDatafileData,$upDatafileWhere);
                   
                        
                       
                     }
                    }else{
                      
                        if($terminalId == 0){
                            $status = '2';
                        }else{
                            $status = '5';
                        }
                       
                       
                       
                        
                       
                    }
                    
                      $upDatafileData = [
                            'IS_IMPORTED'=>'1'
                        ];
                        $upDatafileWhere = [
                            'PSA_UPLOAD_ID'=>$uploadDataId
                        ];
                        $updtUpload = $this->common_model->updateData('TEMP_PSA_UPLOAD_FILE',$upDatafileData,$upDatafileWhere);
                    
                                           
                }
                
                
//                echo '<pre>';
//                   echo $empId;
//                   exit;
                     $this->session->set_flashdata('uploadDatamsg', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Success!</span> Port security access data  imported successfully. </div>');
             $redirectURL = BASE_URL.'psa/PSAUpload/previewData/'.$id;
             redirect($redirectURL);
            }else{
                $this->session->set_flashdata('uploadDatamsg', '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Warning!</span> No data to import. </div>');
             $redirectURL = BASE_URL.'psa/PSAUpload/previewData/'.$id;
             redirect($redirectURL);
            }
            
        }else{
             $this->session->set_flashdata('uploadDatamsg', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><span>Sorry!</span> Port security access data  imported failied. </div>');
             $redirectURL = BASE_URL.'psa/PSAUpload';
             redirect($redirectURL);
        }
       
    }
}
