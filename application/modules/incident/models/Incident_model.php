<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Incident_model extends CI_Model {
    
    public function __construct()
   {
      $this->load->model('common/common_model','common');
      parent::__construct();
   }
   
     public function getLocatDetails($id,$idd){
           $this->db->select('*');
           if($id == ''){
           $this->db->where('INCIDENT_NOTIFY_ID',$idd);
           }else{
           $this->db->where('INCIDENT_NOTIFY_ID',$id); 
           }
            return $this->db->get('INCIDENT_NOTIFICATION_DETAILS')->row_array();
            //echo $this->db->last_query();exit;
       }
       public function InsertATTRMainDetails($data){
           $this->db->insert('ATAR_MAIN_FLOW',$data);
          // echo $this->db->last_query();
           return $this->db->insert_id();
       }
       public function DeleteATTRUpload($id){
        $this->db->where('FK_ATAR_MAIN_ID' ,$id);
        $this->db->delete('ATAR_IMAGE_UPLOAD');
       }
       public function getUploadDetails($id){
           $this->db->select('*');
           $this->db->where('INC_NOTIFY_ID',$id);
           return $this->db->get('INCIDENT_NOTIFY_ATTACHMENT')->result_array();
       }
       public function UpdateATARUploadDetail($result){
           $this->db->insert('ATAR_IMAGE_UPLOAD',$result); 
       }
       public function getnotifyStatusList(){
        return $this->db->get('INCIDENT_NOTIFICATION_STATUS_MASTER')->result_array();
       }
       public function getEmployeeNames(){
        $this->db->select('*');
        $this->db->where('EMP_STATUS','Y');
        return $this->db->get('EMPLOYEE_MANAGEMENT')->result_array();
       }
       public function getClassificationDetails(){
        $this->db->select('*');
        $this->db->where('CLASSFICATION_STATUS','Y');
        return $this->db->get('INCIDENT_CLASSFICATION_MASTER')->result_array();
       }
       public function fetchAllDetails($employeeId){
        $this->db->select('E.*,D.DESIGNATION_NAME');
        $this->db->join('DESIGNATION D','D.DESIGNATION_ID = E.EMP_DESIGNATION_ID');
        $this->db->where('E.EMP_STATUS','Y');
        $this->db->where('E.EMP_AUTO_ID',$employeeId);
        $this->db->where('D.DESIGNATION_STATUS',Y);
        return $this->db->get('EMPLOYEE_MANAGEMENT E')->row_array();
       }
       public function getbodyPartMainData(){
           $this->db->where('STATUS',Y);
           return $this->db->get('INJURIED_MAIN_BODY_PARTS')->result_array();
       }
       public function getInvestigationId($id){
        $inv_notify_id = decryptval($id);
        $this->db->select('INCIDENT_INVESTIGATION_ID');
        $this->db->where('INCIDENT_NOTIFY_ID',$inv_notify_id);
        return $this->db->get('INCIDENT_INVESTIGATION')->row_array();
       }
       public function insertHistoryForIncidentSubDetail($data){
           $this->db->insert('INCIDENT_INVESTIGATE_SUBDETAILS_HISTORY',$data); 
          // echo $this->db->last_query();
       }
       public function getAllNotify($id){
        $this->db->where('INCIDENT_NOTIFY_ID',$id);
        return $this->db->get('INCIDENT_NOTIFICATION_DETAILS')->row_array();
       }
       public function getEventTypes1($eventIds,$id){
          $ids = decryptval($id);
         // if($ids !=''){
          $query = $this->db->query('SELECT group_concat(E.EVENT_TYPE_NAME) as EVENT_TYPE_NAME,INN.* FROM INCIDENT_EVENT_TYPE_MASTER E JOIN INCIDENT_NOTIFICATION_DETAILS INN ON FIND_IN_SET(E.EVENT_TYPE_ID , INN.EVENT_TYPE_IDS)>0 WHERE INN.`EVENT_TYPE_IDS` IN ('.$eventIds.') AND INN.INCIDENT_NOTIFY_ID =  "'.$ids.'" GROUP BY INN.INCIDENT_NOTIFY_ID');
//          }else{
//          $query = $this->db->query('SELECT group_concat(E.EVENT_TYPE_NAME) as EVENT_TYPE_NAME,INN.* FROM INCIDENT_EVENT_TYPE_MASTER E JOIN INCIDENT_NOTIFICATION_DETAILS INN ON FIND_IN_SET(E.EVENT_TYPE_ID , INN.EVENT_TYPE_IDS)>0 WHERE INN.`EVENT_TYPE_IDS` IN ('.$eventIds.') GROUP BY INN.INCIDENT_NOTIFY_ID');
//
//          }
          //echo $this->db->last_query();
          return $query->row_array();
        
//        $this->db->where('EVENT_TYPE_STATUS',Y);
//        return $this->db->get('INCIDENT_EVENT_TYPE_MASTER')->result_array();
        
        
       }
       public function getEventTypes($eventIds){
           if($eventIds !=''){
           if(count($eventIds) == 1){
               $eventId = $eventIds[0];
           }else{
               $eventId = implode(',', $eventIds);
           }
           //echo 'M<pre>';print_r($eventId);exit;

        $query = $this->db->query('SELECT EVENT_TYPE_NAME FROM `INCIDENT_EVENT_TYPE_MASTER` WHERE `EVENT_TYPE_ID` IN ('.$eventId.') ');
        //echo $this->db->last_query();
        return $query->result_array();
       }
       }
       public function UpadteApprovalProcess($data){
        if($data['INCIDENT_INVESTIGATION_ID']!='')
            {
                $this->db->where('INCIDENT_INVESTIGATION_ID',$data['INCIDENT_INVESTIGATION_ID']);
                $this->db->update('INCIDENT_INVESTIGATION',$data);
              
            }
       }
       public function getLocationName($locId , $specId){
          // echo '<pre>';print_r($specId);exit;
        if(isset($specId) && $specId != '' && $specId != '-1'){
        $this->db->select('LC.TERMINAL_SHORTNAME , SC.SPECIFIC_LOC_NAME');
        $this->db->join('TERMINAL_MANAGEMENT LC','LC.TER_AUTO_ID = INN.LOCATION_ID AND LC.TER_AUTO_ID = "'.$locId.'"');
        $this->db->join('SPECIFIC_LOCATION SC','SC.SL_AUTO_ID = INN.SPECIFIC_LOCATION_ID AND SC.SL_AUTO_ID = "'.$specId.'"');
        $query = $this->db->get('INCIDENT_NOTIFICATION_DETAILS INN')->row_array();
        }
        else{
        $this->db->select('LC.TERMINAL_SHORTNAME');
        $this->db->join('TERMINAL_MANAGEMENT LC','LC.TER_AUTO_ID = INN.LOCATION_ID AND LC.TER_AUTO_ID = "'.$locId.'"'); 
        $query  = $this->db->get('INCIDENT_NOTIFICATION_DETAILS INN')->row_array();
        }
          return $query;
        //echo $this->db->last_query();exit;
       }
       public function getEmployeeDetails($id,$notId){
           //echo '<pre>';print_r($notId);exit;
            

            $this->db->where('INCIDENT_INVESTIGATION_ID',$id);
            $this->db->where('INVESTIGATION_STATUS','Y');
            $data['IncidentInvestigationData'] = $this->db->get('INCIDENT_INVESTIGATION')->row_array();

            
            $this->db->select('INVESTIGATION_TEAM_SUMMARY,FILE_PATH,FILE_NAME');
            $this->db->where('INC_INVEST_ID',$id);
            $this->db->where('INVESTIGATION_TEAM_STATUS','Y');
            $data['incidentTeamSummary'] = $this->db->get('INCIDENT_INVESTIGATION_TEAM')->row_array();

            $this->db->select('INVEST_INJURED_PERSON_STATUS');
            $this->db->where('INC_INVEST_ID',$id);
            $data['injuredPersonStatus'] = $this->db->get('INCIDENT_INVEST_INJURED_PERSON_INFO')->row_array();

            $this->db->select('ASSET_DETAIL_STATUS');
            $this->db->where('INCIDENT_INVEST_ID',$id);
            $data['injuredAssetStatus'] = $this->db->get('INCIDENT_INVEST_ASSET_DETAIL')->row_array();
            
            $this->db->where('SUP_STATUS','Y');
            $this->db->where('INC_INVEST_ID',$id);
            $data['superiorAllDetails'] = $this->db->get('INCIDENT_SUPERVISOR_SUPERIOR_DETAIL')->result_array();
            
            $this->db->select('E.*,D.DESIGNATION_NAME,EMS.EMP_NAME,E.EMP_NAME as EMPLOYEE_ID');
            $this->db->join('DESIGNATION D','D.DESIGNATION_ID = E.DESIGNATION_ID');
            $this->db->join('EMPLOYEE_MANAGEMENT EMS','EMS.EMP_AUTO_ID = E.EMP_NAME');
            $this->db->where('D.DESIGNATION_STATUS','Y');
            $this->db->where('E.INVESTIGATION_TEAM_STATUS','Y');
            $this->db->where('E.INC_INVEST_ID',$id);
            $data['investigationAllDetails'] = $this->db->get('INCIDENT_INVESTIGATION_TEAM E')->result_array();

        
            $this->db->select('IP.*');
            $this->db->where('INC_INVEST_ID',$id);
            $data['injuredAllDetails'] = $this->db->get('INCIDENT_INVEST_INJURED_PERSON_INFO IP')->result_array();


            $this->db->select('IPB.*');
            $this->db->join('INCIDENT_INVEST_INJURED_PERSON_INFO IMPS' ,'IMPS.INC_INVEST_INJURED_PERSON_INFO_ID = IPB.INC_INJURED_PERSON_ID');
            $this->db->where('IMPS.INVEST_INJURED_PERSON_STATUS','Y');
            $this->db->where('IPB.INC_INVEST_ID',$id);
            $data['injuredAllDetailsBody'] = $this->db->get('INCIDENT_INVEST_INJURED_PERSON_BODY_INFO IPB')->result_array();


            $this->db->where('INCIDENT_INVEST_ID',$id);
            $data['AssetAllDetails'] = $this->db->get('INCIDENT_INVEST_ASSET_DETAIL')->result_array();


            $this->db->where('INTERVIEWED_DETAIL_STATUS','Y');
            $this->db->where('INC_INVEST_ID',$id);
            $data['personInterviewd'] = $this->db->get('INCIDENT_INVEST_INTERVIEWED_DETAIL')->result_array();

            $this->db->select('EMS.EMP_NAME,IAP.*');
            $this->db->join('EMPLOYEE_MANAGEMENT EMS','EMS.EMP_AUTO_ID = IAP.RESPOSIBILITY_ID');
            $this->db->where('IAP.ACTION_PLAN_STATUS','Y');
            $this->db->where('IAP.INC_INVEST_ID',$id);
            $data['activePlanAllDetails'] = $this->db->get('INCIDENT_ACTION_PLAN IAP')->result_array();

            $this->db->where('CIRCUMSTANCE_STATUS','Y');
            $this->db->where('INC_INVEST_ID',$id);
            $data['circumstanceDetails'] = $this->db->get('INCIDENT_CIRCUMSTANCE_INFO')->result_array();
            
            $docType = 'ATTACHDOC';
            $this->db->where('ATTACHMENT_STATUS','Y');
            $this->db->where('INC_INVEST_ID',$id);
            $this->db->where('INVEST_DOC_TYPE',$docType);
            $data['attachAllDetail'] = $this->db->get('INCIDENT_INVEST_ATTACHMENT')->result_array();

            $docType1 = 'ROOTDOC';
            $this->db->where('ATTACHMENT_STATUS','Y'); 
            $this->db->where('INC_INVEST_ID',$id);
            $this->db->where('INVEST_DOC_TYPE',$docType1);
            $data['rootUpload'] = $this->db->get('INCIDENT_INVEST_ATTACHMENT')->row_array();

            $this->db->select('IND.*,TM.TERMINAL_SHORTNAME');
            $this->db->join('TERMINAL_MANAGEMENT TM','TM.TER_AUTO_ID = IND.LOCATION_ID');
            if($notId!=''){
            $this->db->where('IND.INCIDENT_NOTIFY_ID',decryptval($notId));
            }
            $data['LocationDetail'] = $this->db->get('INCIDENT_NOTIFICATION_DETAILS IND')->row_array();

            $this->db->select('INDD.*,SL.SPECIFIC_LOC_NAME');
            $this->db->join('SPECIFIC_LOCATION SL','SL.SL_AUTO_ID = INDD.SPECIFIC_LOCATION_ID');
             if($notId!=''){
            $this->db->where('INDD.INCIDENT_NOTIFY_ID',decryptval($notId));
             }
            $data['SpecificLoc'] = $this->db->get('INCIDENT_NOTIFICATION_DETAILS INDD')->row_array();
            
            
            $this->db->select('IP.*');
            $this->db->where('INC_INVEST_ID',$id);
            $this->db->where('INVEST_INJURED_PERSON_STATUS','Y');
            $data['injuredAllDetails'] = $this->db->get('INCIDENT_INVEST_INJURED_PERSON_INFO IP')->result_array();


            $this->db->select('IPB.*');
            $this->db->join('INCIDENT_INVEST_INJURED_PERSON_INFO IMPS' ,'IMPS.INC_INVEST_INJURED_PERSON_INFO_ID = IPB.INC_INJURED_PERSON_ID');
            $this->db->where('IMPS.INVEST_INJURED_PERSON_STATUS','Y');
            $this->db->where('IPB.INC_INVEST_ID',$id);
            $data['injuredAllDetailsBody'] = $this->db->get('INCIDENT_INVEST_INJURED_PERSON_BODY_INFO IPB')->result_array();
            
            
            $this->db->select('INDVD.*,MP.MAIN_BODY_PART_NAME,SP.SUB_BODY_PART');
            $this->db->join('INJURIED_MAIN_BODY_PARTS MP','MP.PART_ID = INDVD.BODY_PART_ID');
            $this->db->join('INJURIED_SUB_BODY_PARTS_IMG SP','SP.IMG_ID = INDVD.SUB_ID');
            $this->db->where('INDVD.INC_INVEST_ID',$id);
            $data['BodyParyDts'] = $this->db->get('INCIDENT_INVEST_INJURED_PERSON_BODY_INFO INDVD')->result_array();
           // echo $this->db->last_query();exit;
            
            return $data;
       }
       public function getActivityTableList($id){
           
        $this->db->select('IAA.*,EM.EMP_NAME as UserNameEmp , CD.CONT_NAME as UserNameCon ');
        $this->db->join('CONTRACTOR_DETAILS CD',' CD.CONT_ID = IAA.ID ','left');
        $this->db->join('EMPLOYEE_MANAGEMENT EM',' EM.EMP_ID = IAA.ID','left');
        $this->db->where('INCIDENT_NOTIFY_ID',decryptval($id));
        $this->db->order_by('INCIDENT_ACTIVE_AUDIT_ID desc');
        return $this->db->get('INCIDENT_ACTIVE_AUDITS IAA')->result_array();
        // echo $this->db->last_query();exit;

       }
       public function UpdateIncidentSpecificDetails($data){

            if($data['INCIDENT_INVESTIGATION_ID']!='')
            {
                $this->db->where('INCIDENT_INVESTIGATION_ID',$data['INCIDENT_INVESTIGATION_ID']);
                $this->db->update('INCIDENT_INVESTIGATION',$data);
                return $this->db->affected_rows();
              
            }
            else
            {
               
                $this->db->insert('INCIDENT_INVESTIGATION',$data);
                //echo $this->db->last_query();exit;
                return $this->db->insert_id();
             
            }

        }
        public function DeleteAllDetails($id,$table,$pri_clm,$status){
//$this->db->query("DELETE FROM ".$table." WHERE ".$pri_clm."= ".$id."");

$this->db->set($status,'N');
$this->db->where($pri_clm,$id);
$this->db->update($table);
//echo $this->db->query();exit;
}
public function DeleteAllDetailsPerson($id,$table,$pri_clm,$status){
$this->db->where('INC_INVEST_INJURED_PERSON_INFO_ID',$id);
$this->db->set('INVEST_INJURED_PERSON_STATUS','N');
$this->db->update('INCIDENT_INVEST_INJURED_PERSON_INFO');
}
       
       public function getSubBodyPart($mainId){
        $this->db->select('IMP.*');
        $this->db->join('INJURIED_SUB_BODY_PARTS_IMG IMP','IMP.SUB_ID = ISB.SUB_ID');
        $this->db->where('ISB.MAIN_BODY_ID',$mainId);
        $this->db->where('ISB.STATUS','Y');
        return $this->db->get('INJURIED_SUB_BODY_PARTS ISB')->result_array();
       
       }
       public function getSubBodyDetail(){
        $this->db->select('IPB.*');
        $this->db->join('INCIDENT_INVEST_INJURED_PERSON_INFO IMPS' ,'IMPS.INC_INVEST_INJURED_PERSON_INFO_ID = IPB.INC_INJURED_PERSON_ID');
        $this->db->where('IMPS.INVEST_INJURED_PERSON_STATUS','Y');
        return $this->db->get('INCIDENT_INVEST_INJURED_PERSON_BODY_INFO IPB')->result_array();
       }
       public function getSubBodyPartImage($subId){
        $this->db->select('BODY_IMG');
        $this->db->where('IMG_ID',$subId);
        $this->db->where('IMG_STATUS','Y');
        return $this->db->get('INJURIED_SUB_BODY_PARTS_IMG')->row_array();
       }
       public function updateNotify($status,$ids){
        $this->db->where('INCIDENT_NOTIFY_ID',$ids);
        $this->db->set('STATUS',$status);
        $this->db->update('INCIDENT_NOTIFICATION_DETAILS');
        //echo $this->db->last_query();
       }
       

        public function UpdateSupervisorDetail($data)
        {
            //echo '<pre>';print_r($data);exit;
          
          if($data['INCIDENT_SUP_ID']!='')
            {
                $this->db->where('INCIDENT_SUP_ID',$data['INCIDENT_SUP_ID']);
                $this->db->update('INCIDENT_SUPERVISOR_SUPERIOR_DETAIL',$data);
              
            }
            else{
               
                $this->db->insert('INCIDENT_SUPERVISOR_SUPERIOR_DETAIL',$data);
                //echo $this->db->last_query();
            }
        }

        public function UpdateIncidentNotify($data)
        {
          
          if($data['INCIDENT_ID']!='')
            {
                $this->db->where('INCIDENT_ID',$data['INCIDENT_ID']);
                $this->db->update('INCIDENT_NOTIFICATION_DETAILS',$data);
              
            }
            
        }
    

        public function UpdateInvestigationTeam($data)
        {
         // echo '<pre>';print_r($data);exit;
          if($data['INC_INVESTIGATION_TEAM_ID']!='')
            {
                $this->db->where('INC_INVESTIGATION_TEAM_ID',$data['INC_INVESTIGATION_TEAM_ID']);
                $this->db->update('INCIDENT_INVESTIGATION_TEAM',$data);
                //echo $this->db->last_query();exit; 
              
            }
            else{
               
                $this->db->insert('INCIDENT_INVESTIGATION_TEAM',$data);
               // echo $this->db->last_query();exit;
            }
        }

        public function UpdateInjuredPerson($data){
             //echo '<pre>';print_r($data);exit;

           if($data['INC_INVEST_INJURED_PERSON_INFO_ID']!='')
            {
               if(isset($data['SUB_ID']) && $data['SUB_ID'] !=''){ 
                $this->db->where('INC_INVEST_INJURED_PERSON_INFO_ID',$data['INC_INVEST_INJURED_PERSON_INFO_ID']);
                $query = $this->db->update('INCIDENT_INVEST_INJURED_PERSON_INFO',$data);
               }
               // echo $this->db->last_query();exit;
               // return $data['INC_INVEST_INJURED_PERSON_INFO_ID'];
              
            }
            else{
               if(isset($data['SUB_ID']) && $data['SUB_ID'] !=''){ 
                $this->db->insert('INCIDENT_INVEST_INJURED_PERSON_INFO',$data);
               }
                //echo $this->db->last_query();exit;
               // return $this->db->insert_id();
            }
        }

        public function UpdateAssetDetail($data){
         

           if($data['INC_ASSET_DETAIL_ID']!='')
            {
                $this->db->where('INC_ASSET_DETAIL_ID',$data['INC_ASSET_DETAIL_ID']);
                $this->db->update('INCIDENT_INVEST_ASSET_DETAIL',$data);
              
              
            }
            else{
              
                $this->db->insert('INCIDENT_INVEST_ASSET_DETAIL',$data);
             
            }
        }

        public function UpdatePersonInterview($data){
         

           if($data['INVEST_INTERVIEWED_DETAIL_ID']!='')
            {
                $this->db->where('INVEST_INTERVIEWED_DETAIL_ID',$data['INVEST_INTERVIEWED_DETAIL_ID']);
                $this->db->update('INCIDENT_INVEST_INTERVIEWED_DETAIL',$data);
              
              
            }
            else{
              
                $this->db->insert('INCIDENT_INVEST_INTERVIEWED_DETAIL',$data);
             
            }
        }

        public function UpdateActivePlanDat($data){
         

           if($data['ACTION_PLAN_ID']!='')
            {
                $this->db->where('ACTION_PLAN_ID',$data['ACTION_PLAN_ID']);
                $this->db->update('INCIDENT_ACTION_PLAN',$data);
              
              
            }
            else{
              
                $this->db->insert('INCIDENT_ACTION_PLAN',$data);
             
            }
        }

        public function UpdateCircumstance($data){   
         //echo '<pre>';print_r($data);exit;

           if($data['INC_CIRCUMSTANCE_INFO']!='')
            {
                $this->db->where('INC_CIRCUMSTANCE_INFO',$data['INC_CIRCUMSTANCE_INFO']);
                $this->db->update('INCIDENT_CIRCUMSTANCE_INFO',$data);
              
              
            }
            else{
              
                $this->db->insert('INCIDENT_CIRCUMSTANCE_INFO',$data);
             
            }
        }

        public function UpdateAttachDocument($data){   
         //echo '<pre>';print_r($data);exit;

           if($data['INVEST_ATTACHMENT_ID']!='')
            {
                $this->db->where('INVEST_ATTACHMENT_ID',$data['INVEST_ATTACHMENT_ID']);
                $this->db->update('INCIDENT_INVEST_ATTACHMENT',$data);
              
              
            }
            else{
              
                $this->db->insert('INCIDENT_INVEST_ATTACHMENT',$data);
             
            }
        }



        public function UpdateRootAttachDocument($data){   
         //echo '<pre>';print_r($data);exit;

           if($data['INVEST_ATTACHMENT_ID']!='')
            {
                $this->db->where('INVEST_ATTACHMENT_ID',$data['INVEST_ATTACHMENT_ID']);
                $this->db->update('INCIDENT_INVEST_ATTACHMENT',$data);
              
              
            }
            else{
              
                $this->db->insert('INCIDENT_INVEST_ATTACHMENT',$data);  
             
            }
        }   
        public function InsertActiveofUserAudit($details){
        $this->db->insert('INCIDENT_ACTIVE_AUDITS',$details);
       }

       
        
        public function DeleteBodyDetails($id){   
        $this->db->where('INC_INJURED_PERSON_ID' ,$id);
        $this->db->delete('INCIDENT_INVEST_INJURED_PERSON_BODY_INFO');
        //echo $this->db->last_query();
       }
       public function insertHistoryForNotifyDetail($data){
        $this->db->insert('INCIDENT_NOTIFICATION_DETAILS_HISTORY',$data); 
        //echo $this->db->last_query();
       }

       public function UpdateBodyDetails($result){
      //  echo '<pre>';print_r($result);exit;
           $this->db->insert('INCIDENT_INVEST_INJURED_PERSON_BODY_INFO',$result); 
           //echo $this->db->last_query();exit;
       }
       public function getNotifyTableData($id , $invesId = ""){
        $inv_notify_id = decryptval($id);
        $this->db->select('IND.*,II.*');
        $this->db->join('INCIDENT_INVESTIGATION II','II.INCIDENT_NOTIFY_ID = IND.INCIDENT_NOTIFY_ID');
        $this->db->where('IND.INCIDENT_NOTIFY_ID',$inv_notify_id);
        if($invesId!= ""){
        $this->db->where('II.INCIDENT_INVESTIGATION_ID',$invesId);
        }
        return $this->db->get('INCIDENT_NOTIFICATION_DETAILS IND')->row_array();
       }
       public function getclassFyName($clasyIds){
           if($clasyIds !=''){
        $this->db->select('CLASSFICATION_NAME');
        $this->db->where('CLASSFICATION_MST_ID in('.$clasyIds.')'); 
        //$this->db->where('DBC.degree_branch_course_id in('.$dbcid.')'); 
        return $this->db->get('INCIDENT_CLASSFICATION_MASTER')->result_array();
        }
        //echo $this->db->last_query();
       }
       public function geteventRelatedToDt($eventRelId){
        $this->db->select('INCIDENT_EVENT_NAME');
        $this->db->where('INCIDENT_EVENT_ID in('.$eventRelId.')'); 
        //$this->db->where('DBC.degree_branch_course_id in('.$dbcid.')'); 
        return $this->db->get('INCIDENT_EVENT_RELATE_MASTER')->result_array();
       }
       public function geteventTypeDt($eventTYpeId){
       if($eventTYpeId !=''){
        $this->db->select('EVENT_TYPE_NAME');
        $this->db->where('EVENT_TYPE_ID in('.$eventTYpeId.')'); 
        //$this->db->where('DBC.degree_branch_course_id in('.$dbcid.')'); 
        return $this->db->get('INCIDENT_EVENT_TYPE_MASTER')->result_array();
       }
       }
       public function getUserPrepared($prepared,$reviewed,$verified,$approved){
          
        if($prepared !=0){
         $this->db->where('LOGIN_ID',$prepared);
         $prepared = $this->db->get('LOGIN_DETAILS')->row_array();
          $this->db->select('C.CONT_NAME,C.CONT_DESIGNATION,C.CONT_AUTO_ID,E.EMP_NAME,E.EMP_DESIGNATION_ID,E.EMP_AUTO_ID,D.DESIGNATION_NAME,D1.DESIGNATION_NAME as CON_DESC');
         $this->db->join('CONTRACTOR_DETAILS C','C.CONT_ID = "'.$prepared['USERNAME'].'"' ,'left');
         $this->db->join('EMPLOYEE_MANAGEMENT E','E.EMP_ID = "'.$prepared['USERNAME'].'"','left');
       
        $this->db->join('DESIGNATION D','D.DESIGNATION_ID = E.EMP_DESIGNATION_ID ','left');
        $this->db->join('DESIGNATION D1','D1.DESIGNATION_ID = C.CONT_DESIGNATION  ','left');
        return $this->db->get('INCIDENT_INVESTIGATION INN')->row_array();
         //echo $this->db->last_query();
        }
          
       }
        public function getUserReviewed($prepared,$reviewed,$verified,$approved){
            if($reviewed != 0){
                $this->db->where('LOGIN_ID',$reviewed);
                $reviewed = $this->db->get('LOGIN_DETAILS')->row_array();
         
         
        $this->db->select('C.CONT_NAME,C.CONT_DESIGNATION,C.CONT_AUTO_ID,E.EMP_NAME,E.EMP_DESIGNATION_ID,E.EMP_AUTO_ID,D.DESIGNATION_NAME,D1.DESIGNATION_NAME as CON_DESC');        
         $this->db->join('CONTRACTOR_DETAILS C','C.CONT_ID = "'.$reviewed['USERNAME'].'"' ,'left');
         $this->db->join('EMPLOYEE_MANAGEMENT E','E.EMP_ID = "'.$reviewed['USERNAME'].'"','left');
       
        $this->db->join('DESIGNATION D','D.DESIGNATION_ID = E.EMP_DESIGNATION_ID ','left');
        $this->db->join('DESIGNATION D1','D1.DESIGNATION_ID = C.CONT_DESIGNATION  ','left');

        return $this->db->get('INCIDENT_INVESTIGATION INN')->row_array();
    }
         // echo $this->db->last_query();
       

        }
       public function getUserVerified($prepared,$reviewed,$verified,$approved){
         if($verified != 0){
              $this->db->where('LOGIN_ID',$verified);
                $verified = $this->db->get('LOGIN_DETAILS')->row_array();
                
        $this->db->select('C.CONT_NAME,C.CONT_DESIGNATION,C.CONT_AUTO_ID,E.EMP_NAME,E.EMP_DESIGNATION_ID,E.EMP_AUTO_ID,D.DESIGNATION_NAME,D1.DESIGNATION_NAME as CON_DESC');
        $this->db->join('CONTRACTOR_DETAILS C','C.CONT_ID = "'.$verified['USERNAME'].'"' ,'left');
        $this->db->join('EMPLOYEE_MANAGEMENT E','E.EMP_ID = "'.$verified['USERNAME'].'"','left'); 
        $this->db->join('DESIGNATION D','D.DESIGNATION_ID = E.EMP_DESIGNATION_ID ','left');
        $this->db->join('DESIGNATION D1','D1.DESIGNATION_ID = C.CONT_DESIGNATION  ','left');
        return $this->db->get('INCIDENT_INVESTIGATION INN')->row_array();
         }
        // echo $this->db->last_query();
       

       }
       public function getUserApproved($prepared,$reviewed,$verified,$approved){
        if($approved != 0){
            $this->db->where('LOGIN_ID',$approved);
            $approved = $this->db->get('LOGIN_DETAILS')->row_array();
            
        $this->db->select('C.CONT_NAME,C.CONT_DESIGNATION,C.CONT_AUTO_ID,E.EMP_NAME,E.EMP_DESIGNATION_ID,E.EMP_AUTO_ID,D.DESIGNATION_NAME,D1.DESIGNATION_NAME as CON_DESC');
        $this->db->join('CONTRACTOR_DETAILS C','C.CONT_ID = "'.$approved['USERNAME'].'"' ,'left');
        $this->db->join('EMPLOYEE_MANAGEMENT E','E.EMP_ID = "'.$approved['USERNAME'].'"','left'); 
        $this->db->join('DESIGNATION D','D.DESIGNATION_ID = E.EMP_DESIGNATION_ID ','left');
        $this->db->join('DESIGNATION D1','D1.DESIGNATION_ID = C.CONT_DESIGNATION  ','left');
        return  $this->db->get('INCIDENT_INVESTIGATION INN')->row_array();
        // echo $this->db->last_query();
        }
       }
        public function getHsseEmail($roldId){
           $this->db->where('USER_TYPE_ID in('.$roldId.')'); 
           return $this->db->get('LOGIN_DETAILS')->result_array();
           
        }
        
        public function getHSSEDtsEmail($id,$dpt,$desn){
            if($dpt == '' && $desn == ''){
            $this->db->select('EMP_EMAIL_ID as emailId , EMP_AUTO_ID');
            $this->db->where('EMP_ID', $id);     
            $this->db->order_by('EMP_ID',desc);
            $query = $this->db->get('EMPLOYEE_MANAGEMENT')->result_array();
            // echo $this->db->last_query();
            // exit;
            }
            //echo 'A<pre>';print_r($query);exit;
           
            if($dpt !=''){
            $this->db->select('EMP_EMAIL_ID as emailId , EMP_AUTO_ID');
            $this->db->where('EMP_ID', $id);   
            $this->db->where('EMP_DEPT_ID', $dpt); 
            $query = $this->db->get('EMPLOYEE_MANAGEMENT')->result_array();
            //echo '<pre>';print_r($query5);exit;
           
             }
           
            if($desn !=''){
            $this->db->select('EMP_EMAIL_ID as emailId , EMP_AUTO_ID');
            $this->db->where('EMP_ID', $id);   
            $this->db->where('EMP_DESIGNATION_ID', $desn);         
            $query = $this->db->get('EMPLOYEE_MANAGEMENT')->result_array();   
            
//            $this->db->select('CONT_EMAIL_ID as emailId , CONT_AUTO_ID');
//            $this->db->where('EMP_ID', $id);   
//            $this->db->where('CONT_DESIGNATION', $id); 
//            $query = $this->db->get('CONTRACTOR_DETAILS')->result_array();
            }
            //echo 'A<pre>';print_r($query4);
            

//            if($query3 == '' && $dpt == '' && $desn == ''){
//            $this->db->select('CONT_EMAIL_ID as emailId , CONT_AUTO_ID');
//            $this->db->where('CONT_ID', $id); 
//            $query = $this->db->get('CONTRACTOR_DETAILS')->result_array();
//            //echo 'A<pre>';print_r($query2);
//            }
            
            //if( $query3 !="" || $query2 !="" || $query4 !='' || $query5 !='' || $query6 !='')  {
                //echo 1;exit;
            // $result = array_merge($query3,$query2,$query4,$query5,$query6);
                
//           }
//           else if($query3 !="" && $query4 !=""){
//               // echo 2;exit;
//               $result = array_merge($query3,$query4);
//           }
//           else if($query2 !=""){
//               //echo 3;exit;
//            $result = $query2;
//           }
//           else{
//              // echo 4;exit;
//                $result = array_merge($query3,$query2,$query4,$query5,$query6);
//            }
            //echo '<pre>';print_r($query);exit;
            return $query;
        }
        
        public function getHSSEDtsEmailS($id,$dpt,$desn){
            //if($dpt == '' && $desn == ''){
            $this->db->select('EMP_EMAIL_ID as emailId , EMP_AUTO_ID');
            $this->db->where('EMP_ID', $id);         
            $query1 = $this->db->get('EMPLOYEE_MANAGEMENT')->result_array();
           // }
            //echo 'A<pre>';print_r($query3);
           
            if($desn !=''){
            $this->db->select('EMP_EMAIL_ID as emailId , EMP_AUTO_ID');
            $this->db->where('EMP_ID', $id);   
            $this->db->where('EMP_DESIGNATION_ID', $desn);         
            $query2 = $this->db->get('EMPLOYEE_MANAGEMENT')->result_array();   
           
            }
           $result = array_merge($query1,$query2);
           return $result;
            
            
            //if( $query3 !="" || $query2 !="" || $query4 !='' || $query5 !='' || $query6 !='')  {
                //echo 1;exit;
            // $result = array_merge($query3,$query2,$query4,$query5,$query6);
                
//           }
//           else if($query3 !="" && $query4 !=""){
//               // echo 2;exit;
//               $result = array_merge($query3,$query4);
//           }
//           else if($query2 !=""){
//               //echo 3;exit;
//            $result = $query2;
//           }
//           else{
//              // echo 4;exit;
//                $result = array_merge($query3,$query2,$query4,$query5,$query6);
//            }
           // echo '<pre>';print_r($query);exit;
            
        }
        
       
        public function  deleteInfo($deleteId,$tableName,$prmyId,$whrId){
            $this->db->set($whrId,'N');
            $this->db->where($prmyId,$deleteId);
            $this->db->update($tableName);
            //echo $this->db->last_query();
        }
        public function batchinsertdata($table, $data) {
	$this->db->insert_batch($table, $data);
        return $this->db->insert_id();
       // echo $this->db->last_query();
	return 1;
    }
    public function UpdateNotifyReportId($id , $RepId){
        $this->db->where('INCIDENT_NOTIFY_ID',$id);
        $this->db->set('INCIDENT_REPORT_ID',$RepId);
        $this->db->update('INCIDENT_NOTIFICATION_DETAILS');
        
    }
    public function  getempIdGets($id){
        $this->db->select('USERNAME');
        $this->db->where('LOGIN_ID',$id);
        return $this->db->get('LOGIN_DETAILS')->row_array();
        
    }
    public function getLocationIdInNotify($id){
        $ids = decryptval($id); 
        //echo '<pre>';print_r($ids);exit;
        $this->db->select('LOCATION_ID');
        $this->db->where('INCIDENT_NOTIFY_ID',$ids); 
       return $this->db->get('INCIDENT_NOTIFICATION_DETAILS')->row_array();
    }
    
    public function getSpecificLocatDetails($eventLocation){
       $this->db->select('SL_AUTO_ID,SPECIFIC_LOC_NAME');
       $this->db->where('FK_TERMINAL_ID',$eventLocation);
       return $this->db->get('SPECIFIC_LOCATION')->result_array();
        //echo $this->db->last_query();
    }
    
    public function getSubPartMainData(){
        $this->db->where('IMG_STATUS','Y');
        return $this->db->get('INJURIED_SUB_BODY_PARTS_IMG')->result_array();
    }

 private function _get_datatables_query($table, $column_order, $column_search, $order, $where, $options = []) {
        
        if (isset($options['select']) && $options['select'] != '') {
            $this->db->select($options['select']);
        } else {
            $this->db->select('*');
        }
        $this->db->from($table);
      
         if (isset($options['join']) && !empty($options['join'])) {
            foreach ($options['join'] as $joinKey => $joinVal) {

                $this->db->join($joinKey, $joinVal[0], $joinVal[1]);
            }
        }

        $i = 0;

        foreach ($column_search as $item) { // loop column 
            if ($this->input->post('search')['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($column_search) - 1 === $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
       
//        print_r($options);
        if (isset($options['where_in']) && !empty($options['where_in'])) {
            $where_in = $options['where_in'];
            foreach ($where_in as $key => $val) {
                $this->db->where_in($key, $val);
            }
        }
        
        if(isset($options['orwhere']) && count($options['orwhere']) > 0){
            $this->db->group_start(); 
            foreach($options['orwhere'] as $key => $val){
                $this->db->or_where($key,$val);

            }
            $this->db->group_end(); 
            if(isset($options['where']) && count($options['where']) > 0){
                    $this->db->where($options['where']);
             }
        }else{
             if (is_array($where) && count($where) > 1) {
                foreach($where as $whKey => $whVal){
                    $this->db->where($whKey,$whVal);
                }
           
            }else{
                $this->db->where($where);
            }
        }
     
        
        if (isset($options['group_by']) && !empty($options['group_by'])) {
            $groupBy = $options['group_by'];
            $this->db->group_by($groupBy);
        }
        if ($this->input->post('order') == "") {
            $this->db->order_by(key($order), $order[key($order)]);
        } else if ($this->input->post('order')) { // here order processing
            if (isset($column[$_REQUEST['order']['0']['column']]))
                $this->db->order_by($column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
       
    }
    
    public function count_all($table,$column_order, $column_search, $order, $where = array(),$optns=[]) {
      $this->_get_datatables_query($table, $column_order, $column_search, $order, $where,$optns);
      
        $query = $this->db->get();
        //echo '<pre>';print_r($query);exit;
        if($query !=  FALSE && $query->num_rows() > 0){
           // echo 1;exit;
            $res =  $query->num_rows();
        }else{
           // echo 2;exit;
            $res = 0;
        }
        //echo '<pre>';print_r($res);exit;
      
        return $res;
    }
    
    public function count_alls($table,$column_order, $column_search, $order, $where = array()) {
        $this->db->where($where);
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    public function updatePrimaryId($Oldcapa,$capa){
$this->db->where('ATAR_USEE_WHAT_RECCOM',$Oldcapa);
$this->db->where('ATAR_TYPE_ID','4');
$this->db->set('ATAR_INSP_INC_ID',$capa);
$this->db->update('ATAR_MAIN_FLOW');
//echo $this->db->last_query();exit;
return $capa;
}

       public function UpdateATTRMainDetails($data,$capa){
$this->db->where('ATAR_INSP_INC_ID',$capa);
$this->db->where('ATAR_TYPE_ID','4');
$this->db->set('ATAR_USEE_WHAT_RECCOM',$data['ATAR_USEE_WHAT_RECCOM']);
$this->db->update('ATAR_MAIN_FLOW');
//echo $this->db->last_query();exit;
return $capa;
}
    
}
