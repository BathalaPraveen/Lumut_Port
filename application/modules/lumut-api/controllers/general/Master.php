<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require LUMAPIPATH . 'libraries/REST_Controller.php';

class Master extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        //$this->load->model('master/master_model');
        $this->load->model('common/common_model');
        $this->load->library('pdf');
        $this->common_model->api_log($this->post());
    }

    public function basicMaster_get() {
        $message = [];
        $getNationality =$getgender=$getAlldesig=$getAllloc=$getAllUsee=$getAllUact= [];
        
        $getgender = $this->common_model->getAllData(GENDER);
        $getNationality = $this->common_model->getAlldata(NATION);
        
        $desigOptn['where'] = [
            'DESIGNATION_STATUS' => 'Y'
        ];
        $getAlldesig = $this->common_model->getAlldata(DESIG, ['*'], $desigOptn);
        $terOptn['where'] = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $getAllTerminal = $this->common_model->getAlldata(TER_MAN, ['*'], $terOptn);
        $useeOptn['where'] = [
            'ATAR_CAT_TYPE_ID' => 1,
            'ATAR_CAT_STATUS' => 'Y'
        ];
        $getAllUsee = $this->common_model->getAlldata(ATAR_CAT, ['*'], $useeOptn);
        $uactOptn['where'] = [
            'ATAR_CAT_TYPE_ID' => 2,
            'ATAR_CAT_STATUS' => 'Y'
        ];
        $getAllUact = $this->common_model->getAlldata(ATAR_CAT, ['*'], $uactOptn);
        
        //$designation = $this->common_model->getAlldata(USER_TYPE, ['status' => '1']);

        if (!empty($getNationality)|| !empty($getAllUact) || !empty($getgender) || !empty($getAlldesig) || !empty($getAllTerminal) || !empty($getAllUsee)) {
            $message = array(
                'getgender' => $getgender,
                'getNationality' => $getNationality,
                'getAlldesig' => $getAlldesig,
                'getAllTerminal' => $getAllTerminal,
                'getAllUsee' => $getAllUsee,
                'getAllUact' => $getAllUact,
                'status' => TRUE,
                'message' => 'Success',
            );

            $this->set_response($message, REST_Controller::HTTP_CREATED); // OK (200) being the HTTP response code
        } else {
            $message = array(
                'status' => FALSE,
                'message' => 'No Data'
            );

            $this->set_response($message, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

   
   
}
