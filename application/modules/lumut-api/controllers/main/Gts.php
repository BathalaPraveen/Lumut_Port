<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require LUMAPIPATH . 'libraries/REST_Controller.php';

class Gts extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        
        $this->load->model('common/common_model', 'common');

        $this->load->library('upload');
        //  $this->load->helper('incident/incident_helper');
        // $this->load->library('pdf');
        // $this->load->model('Email_model','emi');
        $this->common->api_log($this->post());
        
    }

    
    public function gtsNotificationSubmit_post(){
        error_reporting(E_ERROR | E_PARSE);
        //$atarid= $this->post('atar_id');
        $user_type_id = $this->post('user_type_id');
        $user_id = $this->post('user_id');
        $designation_id = $this->post('designation_id');
        
        $gtsResult = false;
        $point_id = $this->post('qr_data');
        if (!empty($point_id) && !empty($user_id)) {

            $option['where'] = [
                'UNIQ_ID' => $point_id
            ];
            $option['return_type'] = 'row';
            $getGtsdata = $this->common->getAlldata(GTS, ['*'], $option);
        
        $location_id = $getGtsdata->TERM_ID;
        //print_r();exit;
        $date_time_gts = $this->post('gts_date_Time');
        $newDateTime = date('Y-m-d H:i:s', strtotime($date_time_gts));
        
        $latitude = $this->post('latitude');
        $longitude = $this->post('longitude');
        $address_data = $this->post('address_data');
        
        $gtsImages = $this->post('gtsImages');
        
        $gts_data = [
            'FK_POINT_ID_QR_CODE' => $point_id,
            'FK_NOTIFY_TYPE_ID' => $user_type_id,
            'FK_NOTIFY_ID' => $user_id,
            'FK_NOTIFY_DESIG_ID' => $designation_id,
            'FK_TERMINAL_ID' => $location_id,
            'GTS_DATE_TIME' => $newDateTime,
            'GTS_LATITUDE' => $latitude,
            'GTS_LONGITUDE' => $longitude,
            'GTS_GPS_ADDRESS' => $address_data
            
        ];
        
       
        //print_r($inc_data);exit;
//        if($incid != '') {
//            $whr = ['INC_NOTI_ID' => $incid];
//            $incResult = $this->common->updateData(INCI_NOTI, $inc_data,$whr);
//        } else {
            $gtsResult = $this->common->updateData(GTS_MAIN_FLOW, $gts_data);
        //}

//echo    $this->db->last_query();exit;
                
        if(isset($gtsImages) && !empty($gtsImages)){
            
            foreach($gtsImages as $inc_image){  
                $image_upload = $this->InitialfileUpload($inc_image['inc_image'],$gtsResult);
                  sleep(1);
            }
        } else {
             $image_upload ='';
        }
        
         $gtsImagecol = ['GTS_AUTO_UPL_ID', 'FK_GTS_MAIN', 'GTS_FILENAME', 'GTS_FILE_EXT', 'GTS_FILE_SIZE', 'GTS_FILE_PATH', 'GTS_UPL_STATUS', 'CREATED_DATE', 'UPDATED_DATE'];
         $gtsimgoption['where'] = [
             'FK_GTS_MAIN'=>$gtsResult
         ];
        $getImageInfo =$this->common->getAllData(GTS_MAIN_UPLOAD, $gtsImagecol, $gtsimgoption, '', '', 'GTS_AUTO_UPL_ID', 'ASC'); 
        
        
        
         
         $gtsoption['where'] = [
             'gt.GTS_AUTO_ID'=>$gtsResult,
             'gt.GTS_MAIN_STATUS'=>'Y'
         ];
         
          $gtsoption['join']['GTS_POINT' . ' as g'] = ['g.UNIQ_ID = gt.FK_POINT_ID_QR_CODE', 'left'];
          $gtsoption['join'][TERM . ' as t'] = ['t.TER_AUTO_ID = g.TERM_ID', 'left'];
            
          $gtsoption['join'][LOGIN . ' as LD'] = ['LD.LOGIN_ID = gt.FK_NOTIFY_ID', 'left'];
        $gtsoption['join'][EMPLOYEE_MANAGEMENT . ' as e'] = ['e.EMP_AUTO_ID = LD.USER_REF_ID', 'left'];
        
          $gtsoption['join'][DESIG . ' as d'] = ['d.DESIGNATION_ID = e.EMP_DESIGNATION_ID', 'left'];
          
          $gtsoption['return_type'] = 'row';
          
          $gtscol = ['g.UNIQ_ID,g.POINT_ID,g.LOCA_POINT,t.TERMINAL_NAME,gt.FK_NOTIFY_TYPE_ID,gt.GTS_DATE_TIME,e.EMP_NAME,d.DESIGNATION_NAME as designation_name'];
//echo $this->db->last_query();exit;
        $getgtsInfo =$this->common->getAllData(GTS_MAIN_FLOW. ' as gt', $gtscol, $gtsoption, '', '');
        
        }
          
        if (!empty($gtsResult) && $gtsResult > 0){ 
            $message = array(
                'status' => TRUE,
                'message'=> 'Success! GTS Details has been created',
                'reporter_name'=> postData($getgtsInfo,'EMP_NAME'),
                'designation_name'=>postData($getgtsInfo,'designation_name'),
                'terminal_name'=>postData($getgtsInfo,'TERMINAL_NAME'),
                'specific_location'=>postData($getgtsInfo,'LOCA_POINT'),
                'gts_created_date'=>postData($getgtsInfo,'GTS_DATE_TIME'),
                'gtsImageDetails'=>$getImageInfo,
            );
            
            $this->set_response($message, REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
        }else{
            $message = array(
                'status' => FALSE,
                'message' => 'Sorry! GTS Details  has not been created'
            );
            $this->set_response($message, REST_Controller::HTTP_CREATED); // NOT_FOUND (404) being the HTTP response code
        }
        
    }
    
  
    public function getFileSizeInKb($base64string){
        
        $bytes = strlen(base64_decode($base64string));
        $roughsize = (((int)$bytes) / 1024.0)* 0.67;
        return round($roughsize,2);
    
    }
    
    public function InitialfileUpload($base64string,$gtsResult){      
        $file_size = $this->getFileSizeInKb($base64string);
        if($file_size == FALSE){
           return FALSE;
        }
        $file_data = base64_decode($base64string, $strict = TRUE);
       
      
        $f = finfo_open();
        $file_type = finfo_buffer($f, $file_data, FILEINFO_MIME_TYPE);

        $file_type_ext_1 = explode("/",$file_type)[0];
        $file_type_ext_2 = '.'.explode("/",$file_type)[1];

        
        $path = "./assets/images/modules/gts/";
        
        $foldername = ($file_type_ext_1 == 'video')?"videos/":"images/";
        $target_dir = $path.$foldername;
        $file_name = time().$gtsResult.$file_type_ext_2;
        $file = $target_dir.$file_name;

        $success = file_put_contents($file, $file_data);
            
        
        if(!empty($success) && $success > 0){
           $file_path =  $file;
        }else{
            $file_path ='';
        }
            
        $filedata = [
            'FK_GTS_MAIN' => $gtsResult,
            'GTS_FILENAME' => $file_name,
            'GTS_FILE_PATH' => $file_path,
            'GTS_FILE_EXT' => $file_type_ext_2,
            'GTS_FILE_SIZE' => $file_size
        ];
        //print_r($filedata);exit;
        $this->common->updateData(GTS_MAIN_UPLOAD, $filedata);
      //  echo    $this->db->last_query();exit;
    }
   
   
}
