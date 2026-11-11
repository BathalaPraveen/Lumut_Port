<?php

function getAtarlocationDet($inspId,$subcatdataId){
    
    $ci = & get_instance();
    $ci->db->select("*");
    $ci->db->from(ATAR_MAIN);
    $ci->db->where('ATAR_INSP_INC_ID',$inspId);
    $ci->db->where('ATAR_INSP_SUBCAT_ID',$subcatdataId);
    $ci->db->where('ATAR_STATUS','Y');
    $query = $ci->db->get();
    
    if($query->num_rows() > 0){
        return $query->row();
    }else{
        return false;
    }
}

function getcommonSelloct($loctId){
    $ci = & get_instance();
    $ci->db->select("*");
    $ci->db->from(SPE_LOC);
    $ci->db->where_in('SL_AUTO_ID',$loctId);
    $querys = $ci->db->get();
//    echo $ci->db->last_query();
//    exit;
    if($querys->num_rows() > 0){
        $finRes =  $querys->result();
//        $selLocoptn = '<option value=" ">Select Location</option>';
//        foreach($finRes as $fiKey => $fiVal){
//            $selLocoptn .= '<option value="'. postData($fiVal,'SL_AUTO_ID').'">'.postData($fiVal,'SPECIFIC_LOC_NAME').'</option>';
//        }
//        if(in_array("-1",$loctId)){
//            $selLocoptn .= '<option value="-1">Others</option>';
//        }
        return $finRes;
    }else{
        return false;
    }
}

 function getEmpbytypdes($typId = [],$desid=[]){
        $ci = & get_instance();
        
        $ci->db->select("*");
        $ci->db->from(LOGIN.' as log');
        $ci->db->join(EMPL.' as emp','emp.EMP_AUTO_ID = log.USER_REF_ID','left');
        $ci->db->where('log.USER_LOGIN_TYP',0);
        $ci->db->where_in('log.USER_TYPE_ID',$typId);
        $ci->db->where_in('log.USER_DESINATION_ID',$desid);
        $ci->db->where('log.USER_LOG_STATUS','Y');
        $ci->db->group_by('log.LOGIN_ID');
        $query =  $ci->db->get();
//       echo $ci->db->last_query();
//       exit;
        if($query->num_rows() > 0){
           return $query->result();
       }else{
           return false;
       }
      
    }
    
    function getExecutiveHSSE($return){
     $ci = & get_instance();
    $options['where']=[
//        'LD.USER_TYPE_ID'=>4,
        'EMP.EMP_LOGIN_STATUS'=>'E',
'EMP.EMP_STATUS'=>'Y'
    ];
    $options['where_in'] = [
        'LD.USER_TYPE_ID'=> [4,6],
    ];
    $options['return_type'] = 'result';
    $options['join'] = [
        'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = EMP.EMP_AUTO_ID','INNER']
    ];
    $actvity = $ci->common_model->getAlldata('EMPLOYEE_MANAGEMENT AS EMP', ['LD.LOGIN_ID','EMP.EMP_AUTO_ID','EMP.EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");

    if($return == 'drop'){
        return $dropdownDetails = customFormDropDown($actvity,'LOGIN_ID','EMP_NAME','Select Executive');
    }else{
        return $actvity;
    }
}

function getTotalcount($inspId){
    $ci = & get_instance();
    $ci->db->select("*");
    $ci->db->from(MON_INSP_CHK);
    $ci->db->where('FK_MON_INSP_ID',$inspId);
    $ci->db->where('MON_INSP_IMG_STATUS','Y');
   $query =  $ci->db->get();
   if($query->num_rows() > 0){
       $finRes = $query->result();
       if(isset($finRes) && !empty($finRes)){
           $givenScore = 0;
           $totalScore = 0;
           foreach($finRes as $reKey => $reVal){
               $inspScore = postData($reVal,MON_INSP_SCORE);
               if($inspScore != -1){
               $givenScore = $givenScore+$inspScore;
               $totalScore = $totalScore+3;
               }
           }
          $data['givenScore'] = $givenScore;
          $data['totalScore'] = $totalScore;
          
          return $data;
       }
   }else{
       return false;
   }
   
}

function getInspemplname($lognId){
    $ci = & get_instance();
    $ci->db->select("emp.EMP_NAME");
    $ci->db->from(EMPL.' as emp');
    $ci->db->where('emp.EMP_AUTO_ID',$lognId);
   $query =  $ci->db->get();
//   echo $ci->db->last_query();
//   exit;
   if($query->num_rows() > 0){
       return $query->row();
   }else{
       return false;
   }
}

function getReviewdatetime($inspId,$revId,$status){
     $ci = & get_instance();
    $ci->db->select("*");
    $ci->db->from(MON_ACTIVITY.' as act');
    $ci->db->where('act.MON_ACT_INSP_ID',$inspId);
    $ci->db->where('act.MON_ACT_INSP_REVIEWER_ID',$revId);
    if($status == 2){
        $ci->db->where('act.MON_ACT_INSP_ACC_REJ_STATUS',1);
    }else{
        $ci->db->where('act.MON_ACT_INSP_ACC_REJ_STATUS',2);
    }
    $ci->db->order_by('INSP_ACT_ID','DESC');
   $query =  $ci->db->get();
//   echo $ci->db->last_query();
//   exit;
   if($query->num_rows() > 0){
       return $query->row();
   }else{
       return false;
   }
}
function getVerifierdatetime($inspId,$veriId,$status){
     $ci = & get_instance();
    $ci->db->select("*");
    $ci->db->from(MON_ACTIVITY.' as act');
    $ci->db->where('act.MON_ACT_INSP_ID',$inspId);
    $ci->db->where('act.MON_ACT_INSP_VERIFIER_ID',$veriId);
    if($status == 3){
        $ci->db->where('act.MON_ACT_INSP_ACC_REJ_STATUS',1);
    }else{
        $ci->db->where('act.MON_ACT_INSP_ACC_REJ_STATUS',2);
    }
    $ci->db->order_by('INSP_ACT_ID','DESC');
   $query =  $ci->db->get();
//   echo $ci->db->last_query();
//   exit;
   if($query->num_rows() > 0){
       return $query->row();
   }else{
       return false;
   }
}
function getApproverdatetime($inspId,$apprId,$status){
     $ci = & get_instance();
    $ci->db->select("*");
    $ci->db->from(MON_ACTIVITY.' as act');
    $ci->db->where('act.MON_ACT_INSP_ID',$inspId);
    $ci->db->where('act.MON_ACT_INSP_APPROVER_ID',$apprId);
    if($status == 4){
        $ci->db->where('act.MON_ACT_INSP_ACC_REJ_STATUS',1);
    }else{
        $ci->db->where('act.MON_ACT_INSP_ACC_REJ_STATUS',2);
    }
    $ci->db->order_by('INSP_ACT_ID','DESC');
   $query =  $ci->db->get();
//   echo $ci->db->last_query();
//   exit;
   if($query->num_rows() > 0){
       return $query->row();
   }else{
       return false;
   }
}

