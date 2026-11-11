<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(1);
        isLogin();
       
    }
    
    public function index(){
        
        $data = array(
            'view_file' => 'employee/list_employee',
            'site_title' => 'Employee ',
            'current_menu' => 'List Employee ',
            'ajaxurl' => 'master/employee/list_employee',
        );

        $this->template->load_table_template($data);
    }
    
    public function list_employee(){
        $table = EMPL.' as emp';
        $column_order = array(null, 'EMP_ID','EMP_NAME', 'DESIGNATION_NAME', 'DEPT_NAME', null);
        $column_search = array('EMP_ID','EMP_NAME', 'DESIGNATION_NAME', 'DEPT_NAME');
        $order = array('emp.CREATED_ON' => 'desc');
        $where = ['EMP_STATUS' => 'Y'];
        $optns['join'][DESIG.' as des'] = ['des.DESIGNATION_ID = emp.EMP_DESIGNATION_ID','left'];
        $optns['join'][DEPT.' as dept'] = ['dept.DEPT_AUTO_ID = emp.EMP_DEPT_ID','left'];
        
        $listDept = $this->common_model->get_datatables($table, $column_order, $column_order, $order, $where,$optns);
//echo "<pre>";
//echo $this->db->last_query();
        $finalDatas = [];
        if (isset($listDept) && !empty($listDept)) {
            foreach ($listDept as $ltKey => $ltVal) {

                $action = '';
                $id = $ltVal->EMP_AUTO_ID;
                $empLogstat = $ltVal->EMP_LOGIN_STATUS;
                if($empLogstat == 'P'){
                    $titileStat = 'Activate/Deactivate';
                }elseif($empLogstat == 'E'){
                     $titileStat = 'Deactivate';
                }else{
                     $titileStat = 'Activate';
                }

                $action .= " " . anchor('master/employee/addEmployee/' . encryptval($id), '<i class="fa fa-edit"></i>', array('class' => 'roletarget', 'title' => 'Edit'));

                //$action .= "<a href class='deleteLoctype' title ='Delete' datatype='cat' href='javascript:void(0)'><i class='fa fa-times'></i></a>";
                $action .= " " . anchor('master/employee/viewEmployee/' . encryptval($id), '<i class="fas fa-eye aria-hidden="true"></i>', array('class' => '', 'title' => 'View'));
               
                $action .= " " . anchor('#', '<i class="fa fa-trash"></i>', array('class' => 'deleteEmployee', 'title' => 'Delete', 'delt-id' => $id));
                
                $action .= " " . anchor('master/employee/pdfEmployee/' . encryptval($id), '<i class="fas fa-file-pdf" aria-hidden="true"></i>', array('class' => '', 'title' => 'PDF'));
                
                $action .= " " . anchor('master/employee/statusEmployee/' . encryptval($id), '<i class="fas fa-user" aria-hidden="true"></i>', array('class' => 'emplStatus', 'title' => $titileStat));
//                $action .= " " . anchor('master/EmployeeUpload/' . encryptval($id), '<i class="fa fa-upload" aria-hidden="true"></i>', array('class' => '', 'title' => 'Bulk Upload'));
               
                $rows = [];
//            $rows[] = $ltVal->USER_ROLE_ID;
                $rows[] = $ltVal->EMP_ID;
                $rows[] = $ltVal->EMP_NAME;
                $rows[] = $ltVal->DESIGNATION_NAME;
                $rows[] = $ltVal->DEPT_NAME;
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
    
   public function addEmployee($id=""){

$did = decryptval($id);
// echo $did;
$gendOptn['where'] = [
'GENDER_STATUS' => 'Y'
];
$getGender = $this->common_model->getAlldata(GENDER, ['*'],$gendOptn);
$dropGender = customFormDropDown($getGender, 'GENDER_ID', 'GENDER_NAME', 'Select Gender');

$getNationality = $this->common_model->getAlldata(NATION, ['*']);
$dropNation = customFormDropDown($getNationality, 'NATIONALITY_ID', 'NATIONALITY_NAME', 'Select Nationality');

$termOptn['where'] = [
'TERMINAL_STATUS' => 'Y'
];
$getAllterminal = $this->common_model->getAlldata(TERM, ['*'], $termOptn);
$dropTermname = customFormDropDown($getAllterminal, 'TER_AUTO_ID', 'TERMINAL_NAME', 'Select Terminal Name');

$deptOptn['where'] = [
'DEPT_STATUS' => 'Y'
];
$getAlldept = $this->common_model->getAlldata(DEPT, ['*'], $deptOptn);
$dropDepart = customFormDropDown($getAlldept, 'DEPT_AUTO_ID', 'DEPT_NAME', 'Select Department');

$desigOptn['where'] = [
'DESIGNATION_STATUS' => 'Y'
];
$desigOptn['join'][UTYPE_DESIG.' as udes'] = ['udes.USER_DESIGN_ID = des.DESIGNATION_ID','left'];
$desigOptn['join'][UTYPE.' as typ'] = ['typ.USER_TYPE_ID = udes.USER_TYPE_ID','left'];
$getAlldesig = $this->common_model->getAlldata(DESIG.' as des', ['des.*,typ.USER_TYPE_NAME'], $desigOptn);
// $dropdesignation = customFormDropDown($getAlldesig, 'DESIGNATION_ID', 'DESIGNATION_NAME', 'Select Designation');
$finalDesiginfo[''] = ['' => 'Select Designation'];
if(isset($getAlldesig) && !empty($getAlldesig)){
foreach($getAlldesig as $dsKey => $dsVal){
$utypName = postData($dsVal,'USER_TYPE_NAME');
$designID = postData($dsVal,'DESIGNATION_ID');
$finalDesiginfo[$utypName][$designID] = postData($dsVal,'DESIGNATION_NAME');
}
}


$ccomOptn['where'] = [
'certi.CERT_USER_TYPE' => 'EMP',
'certi.CERT_TYPE' => 'MAIN',
'certi.CERT_USER_ID' => $did,
];
$getAllcCom = $this->common_model->getAlldata(COMP_CERTI.' as certi', ['*'], $ccomOptn);

$emplOptns['where'] = [
'emp.EMP_AUTO_ID' => $did,
'emp.EMP_STATUS' => 'Y',
// 'cert.CERT_USER_TYPE' => 'EMP',
// 'cert.CERT_TYPE' => 'MAIN',
];

if($getAllcCom != ''){
$emplOptns['where']['CERT_USER_TYPE'] = 'EMP';
$emplOptns['where']['CERT_TYPE'] = 'MAIN';
}
$emplOptns['join'][COMP_CERTI.' as cert'] = ['cert.CERT_USER_ID = emp.EMP_AUTO_ID','left'];
$emplOptns['return_type'] = 'row';
$getEmploydetails = $this->common_model->getAlldata(EMPL.' as emp',['*'],$emplOptns);


$othercertiDet['where'] = [
'CERT_USER_ID' => $did,
'CERT_TYPE' => 'OTHER',
'CERT_USER_TYPE' => 'EMP',
'CERT_COMMON_STATUS' => 'Y',
];
$getOthercertdet = $this->common_model->getAlldata(COMP_CERTI.' as certi',['*'],$othercertiDet);
//echo $this->db->last_query();
//echo "<pre>";
//print_R($getOthercertdet);

$data = array(
'view_file' => 'employee/add_employee',
'current_menu' => 'Add Employee',
'dropGender' => $dropGender,
'dropNation' => $dropNation,
'dropTermname' => $dropTermname,
'dropdesignation' => $finalDesiginfo,
'dropDepart' => $dropDepart,
'getEmploydetails' => $getEmploydetails,
'getOthercertdet' => $getOthercertdet,
);
$this->template->load_common_template($data);
}
    
    public function insertEmployee($id=""){
//        echo "<pre>";
//        print_R($this->input->post());
//        print_R($_FILES);
//        exit;
//        exit;
        $this->form_validation->set_rules('emp[emp_no]', 'Employee Number', 'required|trim');
        $empDatas = $this->input->post('emp');
        $certiDatas = $this->input->post('certi');
       
        if ($this->form_validation->run() == true) {
            
            $did = decryptval($id);
            $inserEmpldatas = [
                'EMP_ID' => postData($empDatas,'emp_no'),
                'EMP_NAME' => postData($empDatas,'emp_name'),
                'EMP_GENDER' => postData($empDatas,'gender'),
                'EMP_NATIONALITY' => postData($empDatas,'nationality'),
                'EMP_NATIONALITY_OTHER' => postData($empDatas,'nationality_other'),
                'EMP_DESIGNATION_ID' => postData($empDatas,'desig'),
                'EMP_DEPT_ID' => postData($empDatas,'depart'),
                'EMP_LOC_ID' => postData($empDatas,'location'),
                'EMP_EMAIL_ID' => postData($empDatas,'emp_mail'),
//                'EMP_LOGIN_STATUS' => 'P',
            ];
            if($did != ''){
               $updtEmpl = $this->common_model->updateData(EMPL,$inserEmpldatas,['EMP_AUTO_ID' => $did]);
            }else{
               $updtEmpl = $this->common_model->updateData(EMPL,$inserEmpldatas);
            }
            
            if($did != ''){
            $logDetoptn['where'] = [
                'USER_REF_ID' => $did,
                'USER_LOGIN_TYP' => 0,
//                'USER_DESINATION_ID' => postData($empDatas,'desig'),
            ];
            $logDetoptn['return_type'] = 'row';
           $gteLogdet =  $this->common_model->getAlldata(LOGIN,['*'],$logDetoptn);
          
           if(!empty($gteLogdet)){
               $gedbDesigid = postData($gteLogdet,'USER_DESINATION_ID');
               $geformDesigid = postData($empDatas,'desig');
               
               if($geformDesigid != $gedbDesigid){
                   $checkempDbwher = [
                       'EMP_AUTO_ID' => $did,
                   ];
                   $checkloginDbwher = [
                       'USER_REF_ID' => $did,
                       'USER_LOGIN_TYP' => 0,
                   ];
                   $this->common_model->updateData(EMPL,['EMP_LOGIN_STATUS' => 'P'],$checkempDbwher);
                   $this->common_model->updateData(LOGIN,['USER_LOG_STATUS' => 'N'],$checkloginDbwher);
               }
           }
//           echo "<pre>";
//           echo  $this->db->last_query();
//           print_R($gteLogdet);
//           exit;
            }
            $insertCertidet = [
                'CERT_USER_TYPE' => 'EMP',
                'CERT_TYPE' => 'MAIN',
                'CERT_NAME' => postData($empDatas,'compCerti_name'),
                'CERT_START_DATE' => date("Y-m-d",strtotime($empDatas['start_date'])),
                'CERT_END_DATE' => date("Y-m-d",strtotime($empDatas['end_date'])),
            ];
            
            /////////image upload start
            $imgDatas = [];
          if(isset($_FILES) && !empty($_FILES)){
            $imgDatas = uploadMultipleimage($_FILES, 'assets/images/modules/employee/','competency_certi');
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
//echo "<pre>";
//print_r($empDatas);exit;

                
                $mainCertID = postData($empDatas,'mainCerti_id');
                $certiWhere = [
                    'CERT_USER_ID' => $did,
                    'CERT_TYPE' => 'MAIN',
                    'CERT_USER_TYPE' => 'EMP',
                ];
                if($mainCertID !=''){
                    $updtCerti = $this->common_model->updateData(COMP_CERTI,$insertCertidet,$certiWhere);
                }else{
                    $insertCertidet['CERT_USER_ID'] = $did;
                    $updtCerti = $this->common_model->updateData(COMP_CERTI,$insertCertidet);
                }
               
//               echo $this->db->last_query();
                  if($did != ''){
                   $cntDetoptwhr = [
                       'EMP_AUTO_ID' => $did
                   ];
                  
               }else{
                   $cntDetoptwhr = [
                       'EMP_AUTO_ID' => $updtEmpl
                   ]; 
               }
               
               $updtEmplcerti = $this->common_model->updateData(EMPL,['CERT_STATUS' => postData($empDatas,'elig_status')],$cntDetoptwhr);

            }else{
                $insertCertidet['CERT_USER_ID'] = $updtEmpl;
               $updtCerti = $this->common_model->updateData(COMP_CERTI,$insertCertidet);
               $updtEmplcerti = $this->common_model->updateData(EMPL,['CERT_STATUS' => postData($empDatas,'elig_status')],['EMP_AUTO_ID' => $updtEmpl]);
            }
            
            if(isset($certiDatas) && !empty($certiDatas)){
                $imgDatasother = [];
                if(isset($_FILES) && !empty($_FILES)){
                  $imgDatasother = uploadMultipleimage($_FILES, 'assets/images/modules/employee/','oth_competency_certi');
                }
                
               
//                echo "<pre>";
////                print_R($imgDatasother);
//                print_R($certiDatas);
//                exit;
                $imgKey = 0;
                
                foreach($certiDatas as $cKey => $cVal){
                   $insertOthercerti = [
                        'CERT_USER_TYPE' => 'EMP',
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
                    'CERT_USER_TYPE' => 'EMP',
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
                    $data['flasmsg'] = $this->session->set_flashdata('employee', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Employee Details has been Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('employee', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Employee Details has been Created</div>');
                }
                redirect('master/employee');
            } else {
                
                if ($did != '') {
                    $data['flasmsg'] = $this->session->set_flashdata('employee', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Sorry!</span> Employee Details cannot be Updated</div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('employee', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Sorry!</span> Employee Details cannot be Created</div>');
                }
                redirect('master/employee');
            }  
             
        }else{
            $this->addEmployee($id);
        }
    }
    
    public function deleteEmployee($id=""){
         $deleteId = $this->input->post('delid');
        $updtDelete = $this->common_model->updateData(EMPL, ['EMP_STATUS' => 'N'], ['EMP_AUTO_ID' => $deleteId]);
        $updtCertDelete = $this->common_model->updateData(COMP_CERTI, ['CERT_COMMON_STATUS' => 'N'], ['CERT_USER_ID' => $deleteId,'CERT_USER_TYPE'=>'EMP']);
        $updtloginDelete = $this->common_model->updateData(LOGIN, ['USER_LOG_STATUS' => 'N'], ['USER_REF_ID' => $deleteId,'USER_LOGIN_TYP'=> 0]);

        if ($updtDelete) {
            $retData = [
                'status' => true,
                'msgs' => 'Employee deleted successfully'
            ];
        } else {
            $retData = [
                'status' => false,
                'msgs' => 'Error in deleting Employee'
            ];
        }
        echo json_encode($retData);
    }
    
    public function viewEmployee($id=""){
        $did = decryptval($id);
        
        $ccomOptn['where'] = [
           'cert.CERT_USER_TYPE' => 'EMP',
            'cert.CERT_TYPE' => 'MAIN',
            'cert.CERT_USER_ID' => $did,
        ];
        $getAllcCom = $this->common_model->getAlldata(COMP_CERTI.' as cert', ['*'], $ccomOptn);
        
        $emplOptns['where'] = [
            'EMP_AUTO_ID' => $did,
//            'CERT_USER_TYPE' => 'EMP',
        ];
        
        if($getAllcCom != ''){
            $emplOptns['where']['CERT_USER_TYPE'] = 'EMP';
            $emplOptns['where']['CERT_TYPE'] = 'MAIN';
        }
        
        $emplOptns['join'][COMP_CERTI.' as cert'] = ['cert.CERT_USER_ID = emp.EMP_AUTO_ID','left'];
        $emplOptns['join'][DESIG.' as desg'] = ['desg.DESIGNATION_ID = emp.EMP_DESIGNATION_ID','left'];
        $emplOptns['join'][DEPT.' as dept'] = ['dept.DEPT_AUTO_ID = emp.EMP_DEPT_ID','left'];
        $emplOptns['join'][NATION.' as nation'] = ['nation.NATIONALITY_ID = emp.EMP_NATIONALITY','left'];
        $emplOptns['join'][GENDER.' as gend'] = ['gend.GENDER_ID = emp.EMP_GENDER','left'];
        $emplOptns['join'][TERM.' as term'] = ['term.TER_AUTO_ID = emp.EMP_LOC_ID','left'];
        $emplOptns['return_type'] = 'row';
        $getEmploydetails = $this->common_model->getAlldata(EMPL.' as emp',['emp.*,cert.*,desg.DESIGNATION_NAME,dept.DEPT_NAME,gend.GENDER_NAME,term.TERMINAL_NAME,nation.NATIONALITY_NAME'],$emplOptns);
        
        $othercertiDet['where'] = [
            'CERT_USER_ID' => $did,
            'CERT_TYPE' => 'OTHER',
            'CERT_COMMON_STATUS' => 'Y',
            'CERT_USER_TYPE' => 'EMP',
            ];
        $getOthercertdet = $this->common_model->getAlldata(COMP_CERTI.' as certi',['*'],$othercertiDet);
        
         $data = array(
            'view_file' => 'employee/view_employee',
            'current_menu' => 'View Employee',
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
        
public function pdfEmployee($id ='') {
        
         $did = decryptval($id);
         
          $ccomOptn['where'] = [
           'cert.CERT_USER_TYPE' => 'EMP',
            'cert.CERT_TYPE' => 'MAIN',
            'cert.CERT_USER_ID' => $did,
        ];
        $getAllcCom = $this->common_model->getAlldata(COMP_CERTI.' as cert', ['*'], $ccomOptn);
        
        $emplOptns['where'] = [
            'EMP_AUTO_ID' => $did,
//            'CERT_USER_TYPE' => 'EMP',
        ];
        
        if($getAllcCom != ''){
            $emplOptns['where']['CERT_USER_TYPE'] = 'EMP';
            $emplOptns['where']['CERT_TYPE'] = 'MAIN';
        }
        
        $emplOptns['join'][COMP_CERTI.' as cert'] = ['cert.CERT_USER_ID = emp.EMP_AUTO_ID','left'];
        $emplOptns['join'][DESIG.' as desg'] = ['desg.DESIGNATION_ID = emp.EMP_DESIGNATION_ID','left'];
        $emplOptns['join'][DEPT.' as dept'] = ['dept.DEPT_AUTO_ID = emp.EMP_DEPT_ID','left'];
        $emplOptns['join'][NATION.' as nation'] = ['nation.NATIONALITY_ID = emp.EMP_NATIONALITY','left'];
        $emplOptns['join'][GENDER.' as gend'] = ['gend.GENDER_ID = emp.EMP_GENDER','left'];
        $emplOptns['join'][TERM.' as term'] = ['term.TER_AUTO_ID = emp.EMP_LOC_ID','left'];
        $emplOptns['return_type'] = 'row';
        $getEmploydetails = $this->common_model->getAlldata(EMPL.' as emp',['emp.*,cert.*,desg.DESIGNATION_NAME,dept.DEPT_NAME,gend.GENDER_NAME,term.TERMINAL_NAME,nation.NATIONALITY_NAME'],$emplOptns);
        
        $othercertiDet['where'] = [
            'CERT_USER_ID' => $did,
            'CERT_TYPE' => 'OTHER',
            'CERT_COMMON_STATUS' => 'Y',
            'CERT_USER_TYPE' => 'EMP',
            ];
        $getOthercertdet = $this->common_model->getAlldata(COMP_CERTI.' as certi',['*'],$othercertiDet);
        
        
        $data=[
            'getEmploydetails'=>$getEmploydetails,
            'getOthercertdet'=>$getOthercertdet,
        ];
        $html2 = $this->load->view('master/employee/pdf_employee',$data, true);
        $mpdf2 = $this->pdf->ptwload();
        $das = $mpdf2->WriteHTML($html2);
        $currenttime = date('d-m-Y');
        $folder_name = "employee";
        $file_path = "assets/uploads/" . $folder_name . "/";
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                chmod($file_path, 0777);
            }
        }
        $path2 = $file_path . 'Employee-' . $PdfId . '-' . $currenttime . '.pdf';
        $name = 'Employee-' . $currenttime . '.pdf';
        $mpdf2->Output($path2, "F");
        $data = file_get_contents($path2);
        force_download($name, $data);
        
    }
    
    public function statusEmployee($id=''){
        $did = decryptval($id);
        
        $emplOptn['where'] = [
            'emp.EMP_AUTO_ID' => $did,
//            'log.USER_TYPE_ID !=' => '',
//            'log.USER_LOGIN_TYP ' => 0,
        ];
        $emplOptn['join'][DESIG.' as des'] = ['des.DESIGNATION_ID = emp.EMP_DESIGNATION_ID','left'];
//        $emplOptn['join'][UTYPE_DESIG.' as utdes'] = ['utdes.USER_DESIGN_ID = emp.EMP_DESIGNATION_ID','left'];
        $emplOptn['join'][UTYPE.' as utyp'] = ['utyp.USER_TYPE_ID = emp.EMP_USERTYPE_ID','left'];
//        $emplOptn['join'][LOGIN.' as log'] = ['log.USER_REF_ID = emp.EMP_AUTO_ID','left'];
       
        $emplOptn['return_type'] = 'row';
        
        $getEmploydetails = $this->common_model->getAlldata(EMPL.' as emp',['emp.*,des.DESIGNATION_NAME,utyp.USER_TYPE_NAME'],$emplOptn);

        $emplLogoptns['where'] = [
            'USER_REF_ID' => $did,
            'USER_LOGIN_TYP' => 0,
        ];
        $emplLogoptns['return_type'] = 'row';
        $emplLogindet = $this->common_model->getAlldata(LOGIN,['*'],$emplLogoptns);
        
        $utypoptns['where'] = [
            'utyp.USER_TYPE_STATUS' => 'Y',
            'utdes.USER_DESIGN_ID' => postData($getEmploydetails,'EMP_DESIGNATION_ID'),
        ];
        $utypoptns['join'][UTYPE_DESIG.' as utdes'] = ['utdes.USER_TYPE_ID = utyp.USER_TYPE_ID','left'];
        $getUsertyp = $this->common_model->getAlldata(UTYPE.' as utyp',['*'],$utypoptns);
        $dropUsertyp = customFormDropDown($getUsertyp, 'USER_TYPE_ID', 'USER_TYPE_NAME', '');
//       echo count($dropUsertyp);
//       exit;
        
        $data = array(
            'view_file' => 'employee/status_employee',
            'current_menu' => 'Status Employee',
            'getEmploydetails' => $getEmploydetails,
            'dropUsertyp' => $dropUsertyp,
            'emplLogindet' => $emplLogindet,
            
//            'getOthercertdet' => $getOthercertdet,
         );
        $this->template->load_popup_template($data);
    }
    
    public function updateEmplstatus($id=''){
        
        $did = decryptval($id);
        $statDet = $this->input->post('stat');
//        echo "<pre>";
//        print_R($this->input->post());
//        exit;
        
        $empStatus = postData($statDet,'empStatus');
        $empuserTyp = postData($statDet,'empUsertyp');
        $hidLogid = postData($statDet,'hidLogid');
        $updateEmpdet = [
            'EMP_LOGIN_STATUS' => $empStatus
        ];
        if($empuserTyp != ''){
            $updateEmpdet['EMP_USERTYPE_ID'] = $empuserTyp;
        }
       $updateEmp = $this->common_model->updateData(EMPL,$updateEmpdet,['EMP_AUTO_ID' => $did]);
    
      if($hidLogid == ''){
       $logDet = [
           'USER_REF_ID' => postData($statDet,'empId'),
           'USER_LOGIN_TYP' => 0,
           'USER_TYPE_ID' => postData($statDet,'empUsertyp'),
           'USER_DESINATION_ID' => postData($statDet,'empDesig'),
           'USERNAME' => postData($statDet,'empUsername'),
           'ENCRYPT_PASSWORD' => md5(postData($statDet,'password')),
           'ORG_PWD' => postData($statDet,'password'),
           'USER_LOGIN_TYP' => 0
       ];
       $updateLogin = $this->common_model->updateData(LOGIN,$logDet);
      }else{
            if($empStatus == 'E' || $empStatus == 'N'){
		$userDesig =  postData($statDet,'empUsertyp');
               if($userDesig != ''){
                   $logDet['USER_TYPE_ID'] = $userDesig;
               }
                $logDet['USER_LOG_STATUS'] = 'Y';
                $logDet['USER_DESINATION_ID'] = postData($statDet,'empDesig');
               // $logDet['USER_TYPE_ID'] = postData($statDet,'empUsertyp');
                $logDet['ORG_PWD'] = postData($statDet,'password');
                $logDet['ENCRYPT_PASSWORD'] = md5(postData($statDet,'password'));
            }else{
                $logDet['USER_LOG_STATUS'] = 'N';
            }
            
            
            $updateLogin = $this->common_model->updateData(LOGIN,$logDet,['LOGIN_ID' => $hidLogid]);
        
      }
       
       if($updateLogin){
            /////////// new notification start
               $idata['messageText'] = 'Login credential has been created for you to access Vault, by HSSE team. Find
                                        your below credentials :<br><br>'
                                        .'<b>URL</b> : '.BASE_URL.'<br>'
                                        .'<b>User Name</b> : '.postData($statDet,'empUsername')
                                        .'<br><b>Password</b> : '.postData($statDet,'password')
                                         .'<br><br>This is system generated E-mail, do not reply to this email.';
//                   $idata['footerText'] = ' <br><br/> SYSTEM GENERATED EMAIL. <br>';
                $idata['emplmailID'] = postData($statDet,'empMail');
                $idata['emplName'] = postData($statDet,'empName');
//                $idata['messageTextnotify'] = '<br>Safety Officer( '.$safOffNameval.' ) has been successfully executed the "<b>INSPECTION</b>" with the ID # <b>"'.$inspUniqid.'" </b> and assigned <b> '.$idata['emplName'].'</b> for the fixation. <br><br>For more details about the inspection, kindly review the attached report in this mail.<br><br>For any further information or clarification, please do not hesitate to contact us. <br>Have a nice day.<br><br>Thanks & Regards,<br>KCG Support Team<br>Email: support@kcg.com<br>';
                $idata['subject'] = 'VAULT - EMPLOYEE REGISTRATION';
                 $idata['mainModule'] = 'masterMod';
                
  
            internalNotificationOverall($idata);  
            //////////// mail notification start
            
                 ///// notification end
            
             if ($empStatus == 'E') {
                    $data['flasmsg'] = $this->session->set_flashdata('employee', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Employee Activated Successfully </div>');
                } else {
                    $data['flasmsg'] = $this->session->set_flashdata('employee', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><span>Success!</span> Employee Deactivated Successfully</div>');
                }
       }
        redirect('master/employee');
    }
    
    public function getEmploid(){
        $empId = $this->input->post('empId');
        $emplOptn['where'] = [
            'EMP_ID' => $empId,
            'EMP_STATUS' => 'Y',
        ];
        $emplOptn['return_type'] = 'row';
      $getEmpldet =   $this->common_model->getAlldata(EMPL,['*'],$emplOptn);
      $data = [];
      if(!empty($getEmpldet)){
          $data = [
              'status' => true,
              'msg' => 'Employee No should be Unique',
          ];
      }else{
          $data = [
              'status' => false,
//              'msg' => 'Employee No should be Unique',
          ];
      }
      echo json_encode($data);
    }
    
}
