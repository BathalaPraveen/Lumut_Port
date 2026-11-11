<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permit_model extends CI_Model {
    
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
        return $details = $this->common->getAlldata('SPECIFIC_LOCATION', ['SL_AUTO_ID', 'SPECIFIC_LOC_NAME'], $option);
    }

    public function getAreaClassification() {
        $where = [
            'STATUS' => 'Y'
        ];
        $option['where'] = $where;
        $option['return_type'] = 'result';
        return $details = $this->common->getAlldata(PTW_M_AOC, ['CLS_ID', 'CLS_NAME'], $option);
    }

    public function getPTWInfo($where, $type,$option=[]) {
        $option['where'] = $where;
        $option['return_type'] = $type;
        $aOption = $option + $option;
        return $details = $this->common->getAlldata(PTW_TBL, ['*', 'FN_GET_DEPARTMENT_NAME(SECTION) as SECTION_NAME', 'FN_GET_DESIGNATION_NAME(DESIGNATION) as DESIGNATION_NAME','FN_GET_AREA_CLASSIFICATION_NAME(AREA_OF_CLASSIFICATION) as AREA_OF_CLASSIFICATION_NAME'], $aOption);
    }
    public function getPTWDetails($where, $type,$option=[]) {
        $option['where'] = $where;
        $option['return_type'] = $type;
        $option['join'] = [
        'LOGIN_DETAILS AS LD'=>['LD.LOGIN_ID = '.PTW_TBL.'.OA1','LEFT'],
        'EMPLOYEE_MANAGEMENT AS EMP'=>['EMP.EMP_AUTO_ID = LD.USER_REF_ID','LEFT'],
        'LOGIN_DETAILS AS LD1'=>['LD1.LOGIN_ID = '.PTW_TBL.'.OA2','LEFT'],
        'EMPLOYEE_MANAGEMENT AS EMP1'=>['EMP1.EMP_AUTO_ID = LD1.USER_REF_ID','LEFT'],
        
        ];
        $aOption = $option + $option;
        return $details = $this->common->getAlldata(PTW_TBL, ['*', 'FN_GET_DEPARTMENT_NAME(SECTION) as SECTION_NAME', 'FN_GET_DESIGNATION_NAME(DESIGNATION) as DESIGNATION_NAME','FN_GET_AREA_CLASSIFICATION_NAME(AREA_OF_CLASSIFICATION) as AREA_OF_CLASSIFICATION_NAME','EMP.EMP_NAME as OA1_NAME','EMP1.EMP_NAME as OA2_NAME'], $aOption);
    }
    
    public function getPTWHzActivityInfo($where, $type) {
        $option['where'] = $where;
        $option['return_type'] = $type;
        $option['group_by'] = [
            'DESC'=>'WH_REF_ID'
        ];
        return $details = $this->common->getAlldata(PTW_WORK_HA, ['WH_REF_ID','GROUP_CONCAT(DISTINCT `WH_CHKLST_ID`) as checkListIds'], $option);
    }
    
     public function getPTWHzActivityHirarcInfo($where, $type) {
        $option['where'] = $where;
        $option['return_type'] = $type;
        $option['group_by'] = [
            'DESC'=>'PTW_WH_REF_ID'
        ];
        return $details = $this->common->getAlldata(WORK_HA_HIRARC, ['PTW_WH_REF_ID','GROUP_CONCAT(DISTINCT `HIRARC_ID`) as hirarcIds','HIRAC_TYPE'], $option);
    }
    
    public function getPTWHzActivityHirarcDetails($where, $type) {
        $option['where'] = $where;
        $option['return_type'] = $type;
        $option['join'] = [
        'HIRARC_MAIN_FLOW AS HM'=>['HM.MAIN_AUTO_ID = PHM.HIRARC_ID' ,'INNER']
        
    ];
        
        return $details = $this->common->getAlldata(WORK_HA_HIRARC.' as PHM', ['*'], $option);
    }
        
    public function getPTWSecAttachment($where, $type) {
        $option['where'] = $where;
        $option['return_type'] = $type;
        return $details = $this->common->getAlldata(PTW_SEC_ATTACH, ['*'], $option);
    }
    
    public function getPTWHZAttachment($where, $type) {
        
        $option['where'] = $where;
        $option['return_type'] = $type;
        return $result = $this->common->getAlldata(PTW_WORK_HA_ATT, ['*'], $option);
        
    }
    public function getPTWHZClearenceCertCheckListInfo($where, $type) {
        $option['where'] = $where;
        $option['return_type'] = $type;
        $option['group_by'] = [
            'DESC'=>'REF_PTW_WH_ID'
        ];
        return $details = $this->common->getAlldata(PTW_WORK_HA_CC, ['REF_PTW_WH_ID','GROUP_CONCAT(DISTINCT `CHECKLIST_ID`) as checklistIds'], $option);
    }
    public function getPTWHZClearenceCertInfo($where, $type) {
        $aResponse = [];
        $option['where'] = $where;
        $option['return_type'] = $type;
        return $result = $this->common->getAlldata(PTW_WORK_HA_CC, ['*'], $option);
        
    }
    public function getPTWHZClearenceCertAttachment($where, $type) {
       
        $options['where'] = $where;
        $options['return_type'] = $type;
         return $attachment = $this->common->getAlldata(PTW_WORK_HA_CC_ATT, ['*'], $options);
         
        
    }
    public function getPTWSANCFormAttachment($where, $type) {
        
        $option['where'] = $where;
        $option['return_type'] = $type;
        return $result = $this->common->getAlldata(PTW_SANC_DOCS, ['*'], $option);
        
    }
    public function getPTWSANCFormAttachment1($where, $type) {
        
        $option['where'] = $where;
        $option['return_type'] = $type;
        return $result = $this->common->getAlldata(PTW_SANC_TOOL_DOCS, ['*'], $option);
        
    }
    public function getPTWHZConfinedSpaceInfo($where, $type) {
        $aResponse = [];
        $option['where'] = $where;
        $option['return_type'] = $type;
        return $result = $this->common->getAlldata(PTW_WORK_HA_CC_CS, ['*'], $option);
        
    }
       
   public function getHzActivityCheckList($where, $type){
       
       $option['where'] = $where;
        $option['return_type'] = $type;
        $option['group_by'] = [
            'DESC'=>'WH_REF_ID'
        ];
        $param = ['WH_REF_ID','GROUP_CONCAT(DISTINCT `WH_CHKLST_ID`) as checkListIds'];
        return $details = $this->common->getAlldata(PTW_WORK_HA, $param, $option);
      
   }
    
   public function getHzActivityInfo($where, $type,$param=['*']) {
        $aResponse = [];
        $option['where'] = $where;
        $option['return_type'] = $type;
        $result = $this->common->getAlldata(PTW_WORK_HA, $param, $option);
        if($result != FALSE){
           foreach($result as $key => $row){
               $hzActId = postData($row,'PTW_WH_ID');
               $PTWRefId = postData($row,'REF_PTW_ID');
               $WHRefId = postData($row,'WH_REF_ID');
               $WHCHLRefId = postData($row,'WH_CHKLST_ID');
               $WHCHLText = postData($row,'WH_CHKLIST_TEXT');
               $HirarcType = postData($row,'HIRAC_TYPE');
               $aResponse[$WHRefId][$WHCHLRefId]['info'] = $row; 
               
               $attachmentWhere = [
                   'REF_PTW_WH_ID' => $hzActId,
                   'WHA_CATEGORY' => $WHCHLRefId,
               ];
               $clearenceCertWhere = [
                   'REF_PTW_WH_ID'=>$hzActId
               ];
               $clearenceCertAttWhere = [
                   'REF_PTW_WH_ID'=>$hzActId
               ];
               
               $attachment = $this->getPTWHZAttachment($attachmentWhere,'result');
                $aResponse[$WHRefId][$WHCHLRefId]['attachment'] = $attachment; 
                $clearenceCert = $this->getPTWHZClearenceCertCheckListInfo($clearenceCertAttWhere,'row');
                $aResponse[$WHRefId][$WHCHLRefId]['clearance_certificate_checklist'] = $clearenceCert; 
               $clearenceCertAttr = $this->getPTWHZClearenceCertAttachment($clearenceCertAttWhere,'result');
                $aResponse[$WHRefId][$WHCHLRefId]['clearance_certificate_attachment'] = $clearenceCertAttr; 
                $confinedSpaceWhere = [
                    'REF_PTW_WH_ID'=>$hzActId
                ];
               $confinedSpaceInfo =  $this->getPTWHZConfinedSpaceInfo($confinedSpaceWhere,'result');
               $aResponse[$WHRefId][$WHCHLRefId]['confined_space'] = $confinedSpaceInfo; 
               
              
           }
       }
      
       return $aResponse;
    }
    
   public function getWPPCheckList($where, $type){
       
       $option['where'] = $where;
        $option['return_type'] = $type;
        $option['group_by'] = [
            'DESC'=>'WSP_CATEGORY_ID'
        ];
        $param = ['WSP_CATEGORY_ID','GROUP_CONCAT(DISTINCT `WSP_ITEM_ID`) as checkListIds'];
        return $details = $this->common->getAlldata(PTW_WS_PREPARE, $param, $option);
      
   }
  
   public function getWPPInfo($where, $type,$param=['*']) {
        $aResponse = [];
        $option['where'] = $where;
        $option['return_type'] = $type;
        $result = $this->common->getAlldata(PTW_WS_PREPARE, $param, $option);
        if($result != FALSE){
            $aChecklist = [];
           foreach($result as $key => $row){
               $primaryId = postData($row,'PTW_WS_P_ID');
               $PTWRefId = postData($row,'REF_PTW_ID');
               $catId = postData($row,'WSP_CATEGORY_ID');
               $itemId = postData($row,'WSP_ITEM_ID');
               $aChecklist[$catId][$itemId] = $itemId;
               $aResponse[$catId][$itemId]['info'] = $row; 
               
               $attachmentWhere = [
                   'REF_PTW_WS_P_ID' => $primaryId,
                  
               ];
               
               $attachment = $this->getWPPAttachment($attachmentWhere,'result');
               
               $aResponse[$catId][$itemId]['attachment'] = $attachment; 
           }
       }
      
       return $aResponse;
    }
    
   public function getWPPAttachment($where, $type) {
        
        $option['where'] = $where;
        $option['return_type'] = $type;
        return $result = $this->common->getAlldata(PTW_WS_PREPARE_ATT, ['*'], $option);
        
    }
   
    
    public function getPPECheckList($where, $type){
       
       $option['where'] = $where;
        $option['return_type'] = $type;
        $option['group_by'] = [
            'DESC'=>'PPE_CAT_ID'
        ];
        $param = ['PPE_CAT_ID','GROUP_CONCAT(DISTINCT `PPE_ITEM_ID`) as checkListIds'];
        return $details = $this->common->getAlldata(PTW_PPE, $param, $option);
      
   }
   
   public function getPPEInfo($where, $type,$param=['*']) {
        $aResponse = [];
        $option['where'] = $where;
        $option['return_type'] = $type;
        $result = $this->common->getAlldata(PTW_PPE, $param, $option);
        if($result != FALSE){
            $aChecklist = [];
           foreach($result as $key => $row){
               $primaryId = postData($row,'PTW_PPE_ID');
               $PTWRefId = postData($row,'REF_PTW_ID');
               $catId = postData($row,'PPE_CAT_ID');
               $itemId = postData($row,'PPE_ITEM_ID');
               $aChecklist[$catId][$itemId] = $itemId;
              
               $aResponse[$catId][$itemId]['info'] = $row; 
               
               $attachmentWhere = [
                   'REF_PTW_ID' => $primaryId,
                  
               ];
               
               $attachment = $this->getPPEAttachment($attachmentWhere,'result');
               
               $aResponse[$catId][$itemId]['attachment'] = $attachment; 
           }
       }
      
       return $aResponse;
    }
    
   public function getPPEAttachment($where, $type) {
        
        $option['where'] = $where;
        $option['return_type'] = $type;
        return $result = $this->common->getAlldata(PTW_PPE_UPLS, ['*'], $option);
        
    }
   
    
    
    
    public function getHZActivityOther($PTWID){
        $aResponse = [];
        $option['where'] =  ['REF_PTW_ID' => $PTWID,'HZ_STATUS'=>'Y'];
        $option['return_type'] = 'result';
        $option['where_in'] = ['WH_CHKLST_ID'=> [-1,26]];
       
        $result = $this->common->getAlldata(PTW_WORK_HA, ['*'], $option);
      
       if($result != FALSE){
           foreach($result as $key => $val){
               $whID = postData($val,'PTW_WH_ID');
               $refId = postData($val,'WH_REF_ID');
               $checkListId = postData($val,'WH_CHKLST_ID');
               $checkText= postData($val,'WH_CHKLIST_TEXT');
               $aResponse[$refId][$checkListId][] = $checkText;
           }
       }
       return $aResponse;
    }
    
    public function deleteInfo($table,$where){
        return $this->db->delete($table, $where);
    }
    
    
}

