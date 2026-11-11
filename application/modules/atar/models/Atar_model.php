<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Atar_model extends CI_Model {
    
    public function __construct()
   {
      $this->load->model('common/common_model','common');
      parent::__construct();
   } 
   
    public function getLocation() {
        $where = [
            'TERMINAL_STATUS' => 'Y'
        ];
        $option['where'] = $where;
        $option['return_type'] = 'result';
        return $details = $this->common->getAlldata(TERM, ['TER_AUTO_ID', 'TERMINAL_NAME'], $option);
    }

    public function getSpecificLocation() {
        $where = [
            'SPECIFIC_LOC_STATUS' => 'Y'
        ];
        $option['where'] = $where;
        $option['return_type'] = 'result';
        return $details = $this->common->getAlldata(SPEC_LOC, ['SL_AUTO_ID', 'SPECIFIC_LOC_NAME'], $option);
    }
    
    public function getUseeCategory() {
        $where = [
            'ATAR_CAT_STATUS' => 'Y',
            'ATAR_CAT_TYPE_ID' => 1
        ];
        $option['where'] = $where;
        $option['return_type'] = 'result';
        return $details = $this->common->getAlldata(ATAR_CAT, ['ATAR_CAT_AUTO_ID', 'ATAR_CAT_NAME_EN'], $option);
    }
    
    public function getActCategory() {
        $where = [
            'ATAR_CAT_STATUS' => 'Y',
            'ATAR_CAT_TYPE_ID' => 2
        ];
        $option['where'] = $where;
        $option['return_type'] = 'result';
        return $details = $this->common->getAlldata(ATAR_CAT, ['ATAR_CAT_AUTO_ID', 'ATAR_CAT_NAME_EN'], $option);
    }
    public function getMainCategory() {
        $where = [
            'ATAR_CAT_STATUS' => 'Y',
            'ATAR_CAT_TYPE_ID' => 3
        ];
        $option['where'] = $where;
        $option['return_type'] = 'result';
        return $details = $this->common->getAlldata(ATAR_CAT, ['ATAR_CAT_AUTO_ID', 'ATAR_CAT_NAME_EN'], $option);
    }
    
    public function getUseeImageBefore($did = '') {
        $where = [
            'FK_ATAR_MAIN_ID' => $did,
                'ATAR_FILE_TYPE' => 1,
                'ATAR_ATTACH_STATUS' => 'Y'
        ];
        $option['where'] = $where;
        $option['return_type'] = 'result';
        return $details = $this->common->getAlldata(ATAR_IMG, ['*'], $option);
    }
    
    public function getUactImageBefore($did = '') {
        $where = [
            'FK_ATAR_MAIN_ID' => $did,
                'ATAR_FILE_TYPE' => 2,
                'ATAR_ATTACH_STATUS' => 'Y'
        ];
        $option['where'] = $where;
        $option['return_type'] = 'result';
        return $details = $this->common->getAlldata(ATAR_IMG, ['*'], $option);
    }
    
    public function getUseeactImageAfter($did = '') {
        $where = [
            'FK_ATAR_MAIN_ID' => $did,
                'ATAR_FILE_TYPE' => 3,
                'ATAR_ATTACH_STATUS' => 'Y'
        ];
        $option['where'] = $where;
        $option['return_type'] = 'result';
        return $details = $this->common->getAlldata(ATAR_IMG, ['*'], $option);
    }
    
    
    public function getUseeDetails($where, $type,$option=[]) {
        $option['where'] = $where;
        $option['return_type'] = $type;
        $option['join'] = [
        'LOGIN_DETAILS AS LD'=>['LD.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS Reporter'=>['Reporter.EMP_AUTO_ID = LD.USER_REF_ID','LEFT'],
            
        'LOGIN_DETAILS AS LD1'=>['LD1.LOGIN_ID = '.ATAR_FLOW.'.ATAR_HSSE_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS Hsse'=>['Hsse.EMP_AUTO_ID = LD1.USER_REF_ID','LEFT'],
         
        'LOGIN_DETAILS AS LD5'=>['LD5.LOGIN_ID = '.ATAR_FLOW.'.ATAR_ASSIGN_UNIT_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS Unithead'=>['Unithead.EMP_AUTO_ID = LD5.USER_REF_ID','LEFT'],
        
            
        'LOGIN_DETAILS AS LD2'=>['LD2.LOGIN_ID = '.ATAR_FLOW.'.ATAR_ASSIGN_HOD_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS Hod'=>['Hod.EMP_AUTO_ID = LD2.USER_REF_ID','LEFT'],
            
        'LOGIN_DETAILS AS LD4'=>['LD4.LOGIN_ID = '.ATAR_FLOW.'.ATAR_ASSIGN_HOD_ID','LEFT'],
        'CONTRACTOR_DETAILS AS Hodcon'=>['Hodcon.CONT_AUTO_ID = LD4.USER_REF_ID','LEFT'],
        
         
        'LOGIN_DETAILS AS LD3'=>['LD3.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
        'CONTRACTOR_DETAILS AS Contractor'=>['Contractor.CONT_AUTO_ID = LD3.USER_REF_ID','LEFT'],
   
        ];
        $aOption = $option + $option;
       
       return $details = $this->common->getAlldata(ATAR_FLOW, ['*', 'Contractor.CONT_NAME AS contractor_name','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN `Contractor`.`CONT_NAME` ELSE  `Reporter`.`EMP_NAME` END) as Reporter','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'FN_SPECIFIC_LOCATION_NAME(ATAR_SPEC_LOC_ID) as spec_loc_name','Reporter.EMP_NAME as empName','Hsse.EMP_NAME as Hsse','Unithead.EMP_NAME as Unithead', '(CASE WHEN `LD4`.`USER_TYPE_ID` = 11 THEN `Hodcon`.`CONT_NAME` ELSE  `Hod`.`EMP_NAME` END) as Hod','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN Contractor.CONT_DESIGNATION ELSE  FN_GET_DESIGNATION_NAME(ATAR_REPORTER_DESG_ID) END) as desig','FN_ATAR_USEE_CATEGORY_NAME(ATAR_USEE_CAT_ID) as usee','FN_ATAR_UACT_CATEGORY_NAME(ATAR_UACT_CAT_ID) as uact','FN_ATAR_MAIN_CATEGORY_NAME(ATAR_MAIN_CAT_ID) as mainCat'], $aOption);
   
//exit;
        
    }

public function getUseeMonthlyDetails($where, $type,$option=[]) {
        $option['where'] = $where;
        $option['return_type'] = $type;
        $option['join'] = [
       // 'LOGIN_DETAILS AS LD'=>['LD.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS Reporter'=>['Reporter.EMP_AUTO_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],

//$monMainoptn['join'][EMPL.' as empl'] = ['empl.EMP_AUTO_ID = main.MON_INSP_HSSE_ID','left'];
            
        'LOGIN_DETAILS AS LD1'=>['LD1.LOGIN_ID = '.ATAR_FLOW.'.ATAR_HSSE_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS Hsse'=>['Hsse.EMP_AUTO_ID = LD1.USER_REF_ID','LEFT'],
         
        'LOGIN_DETAILS AS LD5'=>['LD5.LOGIN_ID = '.ATAR_FLOW.'.ATAR_ASSIGN_UNIT_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS Unithead'=>['Unithead.EMP_AUTO_ID = LD5.USER_REF_ID','LEFT'],
        
            
        'LOGIN_DETAILS AS LD2'=>['LD2.LOGIN_ID = '.ATAR_FLOW.'.ATAR_ASSIGN_HOD_ID','LEFT'],
        'EMPLOYEE_MANAGEMENT AS Hod'=>['Hod.EMP_AUTO_ID = LD2.USER_REF_ID','LEFT'],
            
        'LOGIN_DETAILS AS LD4'=>['LD4.LOGIN_ID = '.ATAR_FLOW.'.ATAR_ASSIGN_HOD_ID','LEFT'],
        'CONTRACTOR_DETAILS AS Hodcon'=>['Hodcon.CONT_AUTO_ID = LD4.USER_REF_ID','LEFT'],
        
         
        'LOGIN_DETAILS AS LD3'=>['LD3.LOGIN_ID = '.ATAR_FLOW.'.ATAR_REPORTER_ID','LEFT'],
        'CONTRACTOR_DETAILS AS Contractor'=>['Contractor.CONT_AUTO_ID = LD3.USER_REF_ID','LEFT'],
   
        ];
        $aOption = $option + $option;
       
       return $details = $this->common->getAlldata(ATAR_FLOW, ['*', 'Contractor.CONT_NAME AS contractor_name','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN `Contractor`.`CONT_NAME` ELSE  `Reporter`.`EMP_NAME` END) as Reporter','FN_GET_LOCATION(ATAR_LOC_ID) as loc_name', 'FN_SPECIFIC_LOCATION_NAME(ATAR_SPEC_LOC_ID) as spec_loc_name','Reporter.EMP_NAME as empName','Hsse.EMP_NAME as Hsse','Unithead.EMP_NAME as Unithead', '(CASE WHEN `LD4`.`USER_TYPE_ID` = 11 THEN `Hodcon`.`CONT_NAME` ELSE  `Hod`.`EMP_NAME` END) as Hod','(CASE WHEN `ATAR_MAIN_FLOW`.`ATAR_REPORTER_TYPE_ID` = 11 THEN Contractor.CONT_DESIGNATION ELSE  FN_GET_DESIGNATION_NAME(ATAR_REPORTER_DESG_ID) END) as desig','FN_ATAR_USEE_CATEGORY_NAME(ATAR_USEE_CAT_ID) as usee','FN_ATAR_UACT_CATEGORY_NAME(ATAR_UACT_CAT_ID) as uact','FN_ATAR_MAIN_CATEGORY_NAME(ATAR_MAIN_CAT_ID) as mainCat'], $aOption);
   
//exit;
        
    }
}

