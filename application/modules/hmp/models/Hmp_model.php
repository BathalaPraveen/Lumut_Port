<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hmp_model extends CI_Model {
    
    public function __construct()
   {
      $this->load->model('common/common_model','common');
      parent::__construct();
   }
   
    
    public function getHmpDetails($where, $type,$option=[]) {
        $option['where'] = $where;
        $option['return_type'] = $type;
        $option['join'] = [
        'LOGIN_DETAILS AS LD'=>['LD.LOGIN_ID = '.HMP_MAIN.'.HMP_UNIT_HEAD_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS EMP'=>['EMP.EMP_AUTO_ID = LD.USER_REF_ID','LEFT'],
        'LOGIN_DETAILS AS LD1'=>['LD1.LOGIN_ID = '.HMP_MAIN.'.HMP_EXEC_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS EMP1'=>['EMP1.EMP_AUTO_ID = LD1.USER_REF_ID','LEFT'],
        
        ];
        $aOption = $option + $option;
        return $details = $this->common->getAlldata(HMP_MAIN, ['*', 'FN_GET_LOCATION(HMP_LOC_ID) as loc_name', 'FN_GET_DEPARTMENT_NAME(HMP_DEPT_ID) as dept_name','EMP.EMP_NAME as unithead','EMP1.EMP_NAME as executive'], $aOption);
    }
   
    
       public function getRecDetails($where, $type,$option=[]) {
        $option['where'] = $where;
        $option['return_type'] = $type;
        $option['join'] = [
        'LOGIN_DETAILS AS LD'=>['LD.LOGIN_ID = '.REC_MAIN.'.REC_CREATOR_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS EMP'=>['EMP.EMP_AUTO_ID = LD.USER_REF_ID','LEFT']
        
        ];
        $aOption = $option + $option;
        return $details = $this->common->getAlldata(REC_MAIN, ['*', 'FN_GET_LOCATION(REC_TER_ID) as loc_name','EMP.EMP_NAME as reporter_name'], $aOption);
    }
    
     public function getRecordImage($did = '') {
        $where = [
            'FK_REC_MAIN_ID' => $did,
                'REC_ATTACH_STATUS' => 'Y'
        ];
        $option['where'] = $where;
        $option['return_type'] = 'result';
        return $details = $this->common->getAlldata(REC_IMG, ['*'], $option);
    }
   
    
   
    
}
