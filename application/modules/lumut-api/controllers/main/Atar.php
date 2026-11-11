<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require LUMAPIPATH . 'libraries/REST_Controller.php';

class Atar extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        
        $this->load->model('common/common_model', 'common');
        $this->load->helper('atar_helper');
        $this->load->library('upload');
        //  $this->load->helper('incident/incident_helper');
        // $this->load->library('pdf');
        // $this->load->model('Email_model','emi');
        $this->common_model->api_log($this->post());
        
    }

    public function getSpecificLocationlist_post() {
         $location_id = $this->post('location_id');

        if (!empty($location_id)) {

            $option['where'] = [
                'SPECIFIC_LOC_STATUS' => 'Y',
                'FK_TERMINAL_ID' => $location_id,
            ];
          
            $getSpecificLocationdatas = $this->common->getAlldata(SPEC_LOC, ['*'], $option);

            $othersArray[-1] = [
                        'SL_AUTO_ID' => '-1',
                        'SPECIFIC_LOC_ID' => '',
                        'FK_TERMINAL_ID'=>$location_id,
                        'SPECIFIC_LOC_NAME' => 'Others',
                        'SPECIFIC_LOC_DESC' => '',
                        'SPECIFIC_LOC_STATUS' => 'Y',
                        'CREATED_ON' => date('Y-m-d H:i:s'),
                        'UPDATED_ON' => date('Y-m-d H:i:s')
            ];
            if($getSpecificLocationdatas != FALSE){
                 $getSpecificLocationdata = array_merge($getSpecificLocationdatas,$othersArray);
            }else{
               $getSpecificLocationdata[] = (object) $othersArray[-1];
            }
          

            if (!empty($getSpecificLocationdata)) {
                $message = array(
                    'status' => TRUE,
                    'getSpecificLocationdata' => $getSpecificLocationdata
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            } else {

                $message = array(
                    'status' => FALSE,
                    'getSpecificLocationdata' =>(object) [],
                    'message' => 'No Data'
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            }
        } else {

            $message = array(
                'status' => FALSE,
                'message' => 'Select Region'
            );
            $this->set_response($message, REST_Controller::HTTP_CREATED);
        }
    }
    
    public function atarNotificationSubmit_post(){
        error_reporting(E_ERROR | E_PARSE);
        //$atarid= $this->post('atar_id');
        
        $user_id = $this->post('user_id');
        $user_type_id = $this->post('user_type_id');
        $designation_id= $this->post('designation_id');
        $location_id= $this->post('location_id');
        $specific_loc_id= $this->post('specific_loc_id');
        $specific_loc_other= $this->post('specific_loc_other');
        $date_time_atar = $this->post('atar_date_Time');
        $newDateTime = date('Y-m-d H:i:s', strtotime($date_time_atar));
        
        $atar_usee_cat_id = $this->post('atar_usee_cat_id');
        $atar_usee_desc = $this->post('atar_usee_desc');
        $atar_uact_cat_id = $this->post('atar_uact_cat_id');
        $atar_uact_desc = $this->post('atar_uact_desc');
        $atar_language = $this->post('atar_language');
        
        $AtarImages = $this->post('AtarImages');
        $AtarImages1 = $this->post('AtarImagesUact');
        
//        $uniqAtarwhr = [];
//        $atarUniq = uniqueIntRefId('ATAR', ATAR_FLOW, 'ATAR_AUTO_ID', 'ATAR_AUTO_ID', $uniqAtarwhr);

        $userType = $user_type_id;
        $module = 'USUA';

        $locName = getLocationShorName($location_id);
         
        $atarId = getAtarNumber($module,$locName,$location_id);

 if($user_type_id == 11){

$where = [
    'LOGIN_ID' => $user_id, 
    'USER_TYPE_ID' => 11
];
$optioncon['where'] = $where;
$optioncon['return_type'] = 'row';
$detailsuser = $this->common->getAlldata(LOGIN_DETAILS, ['*'], $optioncon);
$login_user_id = $user_id;

}else{


$where = [
    'LOGIN_ID' => $user_id, 
    'USER_TYPE_ID !=' => 11
];
$optioncon['where'] = $where;
$optioncon['return_type'] = 'row';
$detailsuser = $this->common->getAlldata(LOGIN_DETAILS, ['*'], $optioncon);
$login_user_id = $user_id;

}





        
        
        $atar_data = [
            'ATAR_ID' => $atarId,
            'ATAR_TYPE_ID' => 1,
            'ATAR_REPORTER_TYPE_ID' => $user_type_id,
            'ATAR_REPORTER_ID' => $login_user_id,
            'ATAR_REPORTER_DESG_ID' => $designation_id,
            'ATAR_LOC_ID' => $location_id,
            'ATAR_SPEC_LOC_ID' => $specific_loc_id,
            'ATAR_SPEC_LOC_OTHER' => $specific_loc_other,
            'ATAR_REPORT_DATETIME' => $newDateTime,
            'ATAR_USEE_CAT_ID' => $atar_usee_cat_id,
            'ATAR_USEE_WHAT_RECCOM' => $atar_usee_desc,
            'ATAR_UACT_CAT_ID' => $atar_uact_cat_id,
            'ATAR_UACT_WHAT' => $atar_uact_desc,
            'ATAR_LANG' => $atar_language,
            'ATAR_APP_STATUS' => 1,
        ];
        
       
        //print_r($inc_data);exit;
//        if($incid != '') {
//            $whr = ['INC_NOTI_ID' => $incid];
//            $incResult = $this->common->updateData(INCI_NOTI, $inc_data,$whr);
//        } else {
            $atarResult = $this->common->updateData(ATAR_FLOW, $atar_data);
        //}

//echo    $this->db->last_query();exit;
                
        if(isset($AtarImages) && !empty($AtarImages)){
            
            foreach($AtarImages as $inc_image){  
                $image_upload = $this->InitialfileUpload($inc_image['inc_image'],$atarResult);
                  sleep(1);
            }
        } else {
             $image_upload ='';
        }
        
        if(isset($AtarImages1) && !empty($AtarImages1)){
            
            foreach($AtarImages1 as $inc_image){  
                $image_upload2 = $this->InitialfileUpload2($inc_image['inc_image'],$atarResult);
                  sleep(1);
            }
        } else {
             $image_upload2 ='';
        }
            
        if (!empty($atarResult) && $atarResult > 0){ 
            sendAtarNotification($atarResult);
            $message = array(
                'status' => TRUE,
                'message'=> 'Success! Atar Details has been created'
            );
            
            $this->set_response($message, REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
        }else{
            $message = array(
                'status' => FALSE,
                'message' => 'Sorry! Atar Details  has not been created'
            );
            $this->set_response($message, REST_Controller::HTTP_CREATED); // NOT_FOUND (404) being the HTTP response code
        }
        
    }
    
    public function atarViewList_post(){
        $message = [];
        $id = $this->post('atar_id');
        $user_id = $this->post('user_id');
        $user_type_id = $this->post('user_type_id');

if($user_type_id == 11){

$where = [
    'USER_REF_ID' => $user_id, 
    'USER_TYPE_ID' => 11
];
$optioncon['where'] = $where;
$optioncon['return_type'] = 'row';
$detailsuser = $this->common->getAlldata(LOGIN_DETAILS, ['*'], $optioncon);
$login_user_id = $detailsuser->LOGIN_ID;

}else{


$where = [
    'USER_REF_ID' => $user_id, 
    'USER_TYPE_ID !=' => 11
];
$optioncon['where'] = $where;
$optioncon['return_type'] = 'row';
$detailsuser = $this->common->getAlldata(LOGIN_DETAILS, ['*'], $optioncon);
$login_user_id = $detailsuser->LOGIN_ID;

}


        
     //echo "sdgsd";exit;
        
        if($id != ''){        //view 
            $option['where'] = [
                 'ATAR_TYPE_ID' => 1, 
                'ATAR_APP_STATUS' => 1, 
                'ATAR_STATUS' => 'Y',
                'ATAR_AUTO_ID' => $id
            ];
            $option['return_type'] = 'row';
        }elseif ($user_id !='' && $user_type_id !='') {     //list
            $option['where'] = [
                'ATAR_REPORTER_ID' => $user_id, 
                'ATAR_REPORTER_TYPE_ID' => $user_type_id,
                'ATAR_TYPE_ID' => 1, 
                'ATAR_APP_STATUS' => 1, 
                'ATAR_STATUS' => 'Y'
            ];
        }

        $table = ATAR_FLOW . ' as ATAR';
        
        $col = ['ATAR.*,TER.TERMINAL_NAME,SPEC.SPECIFIC_LOC_NAME,USEE.ATAR_CAT_NAME_EN AS USEE_CAT_EN,USEE.ATAR_CAT_NAME_MALY AS USEE_CAT_MAL,UACT.ATAR_CAT_NAME_EN AS UACT_CAT_EN,UACT.ATAR_CAT_NAME_MALY AS UACT_CAT_MAL,DES.DESIGNATION_NAME,USER.EMP_NAME AS REPORTER_NAME'];


        
        
        if($user_type_id == 11){
            $col = ['ATAR.*,TER.TERMINAL_NAME,SPEC.SPECIFIC_LOC_NAME,USEE.ATAR_CAT_NAME_EN AS USEE_CAT_EN,USEE.ATAR_CAT_NAME_MALY AS USEE_CAT_MAL,UACT.ATAR_CAT_NAME_EN AS UACT_CAT_EN,UACT.ATAR_CAT_NAME_MALY AS UACT_CAT_MAL,USER.CONT_DESIGNATION as DESIGNATION_NAME,USER.CONT_NAME AS REPORTER_NAME'];
        }
           
        
        if($user_type_id == 11){
 
       

$option['join'][LOGIN . ' as LD3'] = ['LD3.LOGIN_ID = ATAR.ATAR_REPORTER_ID', 'left'];
            $option['join'][CONT_DET . ' as USER'] = ['USER.CONT_AUTO_ID = LD3.USER_REF_ID', 'left'];
        }else{

$option['join'][LOGIN . ' as LD4'] = ['LD4.LOGIN_ID = ATAR.ATAR_REPORTER_ID', 'left'];
            $option['join'][EMPL . ' as USER'] = ['USER.EMP_AUTO_ID = LD4.USER_REF_ID', 'left'];
  
        }
           
        
        $option['join'][TER_MAN . ' as TER'] = ['TER.TER_AUTO_ID = ATAR.ATAR_LOC_ID', 'left'];
        $option['join'][SPEC_LOC . ' as SPEC'] = ['SPEC.SL_AUTO_ID = ATAR.ATAR_SPEC_LOC_ID', 'left'];
        $option['join'][ATAR_CAT . ' as USEE'] = ['USEE.ATAR_CAT_AUTO_ID = ATAR.ATAR_USEE_CAT_ID', 'left'];
        $option['join'][ATAR_CAT . ' as UACT'] = ['UACT.ATAR_CAT_AUTO_ID = ATAR.ATAR_UACT_CAT_ID', 'left'];
        $option['join'][DES . ' as DES'] = ['DES.DESIGNATION_ID = ATAR.ATAR_REPORTER_DESG_ID', 'left'];


        $initialAtarDetails = $this->common->getAllData($table, $col, $option, '', '', 'ATAR_AUTO_ID', 'DESC');
//  echo $this->db->last_query();exit;   
        $initialAtar = (isset($initialAtarDetails) && $initialAtarDetails != '') ? $initialAtarDetails : [];
       
       
        if($id !=''){
            
            $image_data =[];
            
            $options['where'] = [
               'ATAR_ATTACH_STATUS' => 'Y',
               'ATAR_FILE_TYPE' => 1,
                'FK_ATAR_MAIN_ID' => $id
            ];
           
            $imagedata = $this->common->getAllData(ATAR_IMG, ['*'], $options);
          
            $image_data = (isset($imagedata) && $imagedata != '') ? $imagedata : [];
            
        }else{
            $image_data = [];
           
        }
        
        if($id !=''){
            
            $image_data1 =[];
            
            $options1['where'] = [
               'ATAR_ATTACH_STATUS' => 'Y',
               'ATAR_FILE_TYPE' => 2,
                'FK_ATAR_MAIN_ID' => $id
            ];
           
            $imagedata2 = $this->common->getAllData(ATAR_IMG, ['*'], $options1);
          
            $image_data1 = (isset($imagedata2) && $imagedata2 != '') ? $imagedata2 : [];
            
        }else{
            $image_data1 = [];
           
        }
      
        if (isset($initialAtar) && count($initialAtar) > 0){
            $message = array(
                    'initialAtarDetails'=> $initialAtar,
                    'image_list_usee'=> $image_data,
                    'image_list_uact'=> $image_data1,
                    'status' => TRUE,
                    'message'=> 'Success',
            );
            
            $this->set_response($message, REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
        }
        else{
            $message = array(
                'initialincdetails'=> $initialAtar,
                'image_list'=> $image_data,
                'image_list_uact'=> $image_data1,
                'status' => FALSE,
                'message' => 'No Data'
            );
            
            $this->set_response($message, REST_Controller::HTTP_CREATED); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    public function atarDelete_post() {
        $atar_id = $this->post('atar_id');

        $where = [
            'ATAR_AUTO_ID' => $atar_id
        ];
        
        $dlt_upd=[
            'ATAR_STATUS' => 'N'
        ];
        
        $inc_delete =  $this->common->updateData(ATAR_FLOW,$dlt_upd, $where);
        $where_image =[
            'FK_ATAR_MAIN_ID' => $atar_id
        ];
        $update_image =[
            'ATAR_ATTACH_STATUS' => 'N'
        ];
        $inc_img_delete = $this->common->updateData(ATAR_IMG,$update_image, $where_image);

        if (isset($inc_delete) && $inc_delete > 0 && isset($inc_img_delete) && $inc_img_delete > 0) {

            $message = array(
                'status' => TRUE,
                'message' => 'Success',
            );

            $this->set_response($message, REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
        } else {

            $message = array(
                'status' => FALSE,
                'message' => 'No Data'
            );

            $this->set_response($message, REST_Controller::HTTP_CREATED); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    public function getFileSizeInKb($base64string){
        
        $bytes = strlen(base64_decode($base64string));
        $roughsize = (((int)$bytes) / 1024.0)* 0.67;
        return round($roughsize,2);
    
    }
    
    public function InitialfileUpload($base64string,$atarResult){      
        $file_size = $this->getFileSizeInKb($base64string);
        if($file_size == FALSE){
           return FALSE;
        }
        $file_data = base64_decode($base64string, $strict = TRUE);
       
      
        $f = finfo_open();
        $file_type = finfo_buffer($f, $file_data, FILEINFO_MIME_TYPE);

        $file_type_ext_1 = explode("/",$file_type)[0];
        $file_type_ext_2 = '.'.explode("/",$file_type)[1];
       
        $image_type = $file_type;
        
        $path = "./assets/images/modules/atar/";
        
        $foldername = ($file_type_ext_1 == 'video')?"videos/":"images/usee/before_usee/";
        $target_dir = $path.$foldername;
        $file_name = time().$atarResult.$file_type_ext_2;
        $file = $target_dir.$file_name;

        $success = file_put_contents($file, $file_data);
            
        
        if(!empty($success) && $success > 0){
           $file_path =  $file;
        }else{
            $file_path ='';
        }
            
        $filedata = [
            'FK_ATAR_MAIN_ID' => $atarResult,
            'ATAR_FILE_TYPE' => 1,
            'ATAR_FILENAME' => $file_name,
            'ATAR_FILE_PATH' => $target_dir,
            'ATAR_FILETYPE' => $file_type,
            'ATAR_FILE_EXT' => $file_type_ext_2,
            'ATAR_FILE_SIZE' => $file_size,
        ];
        //print_r($filedata);exit;
        $this->common->updateData(ATAR_IMG, $filedata);
      //  echo    $this->db->last_query();exit;
    }
   
    public function InitialfileUpload2($base64string,$atarResult){      
        $file_size = $this->getFileSizeInKb($base64string);
        if($file_size == FALSE){
           return FALSE;
        }
        $file_data = base64_decode($base64string, $strict = TRUE);
       
      
        $f = finfo_open();
        $file_type = finfo_buffer($f, $file_data, FILEINFO_MIME_TYPE);

        $file_type_ext_1 = explode("/",$file_type)[0];
        $file_type_ext_2 = '.'.explode("/",$file_type)[1];
       
        $image_type = $file_type;
        
        $path = "./assets/images/modules/atar/";
        
        $foldername = ($file_type_ext_1 == 'video')?"videos/":"images/usee/before_usee/";
        $target_dir = $path.$foldername;
        $file_name = time().$atarResult.$file_type_ext_2;
        $file = $target_dir.$file_name;

        $success = file_put_contents($file, $file_data);
            
        
        if(!empty($success) && $success > 0){
           $file_path =  $file;
        }else{
            $file_path ='';
        }
            
        $filedata = [
            'FK_ATAR_MAIN_ID' => $atarResult,
            'ATAR_FILE_TYPE' => 2,
            'ATAR_FILENAME' => $file_name,
            'ATAR_FILE_PATH' => $target_dir,
            'ATAR_FILETYPE' => $file_type,
            'ATAR_FILE_EXT' => $file_type_ext_2,
            'ATAR_FILE_SIZE' => $file_size,
        ];
        //print_r($filedata);exit;
        $this->common->updateData(ATAR_IMG, $filedata);
      //  echo    $this->db->last_query();exit;
    }
}
