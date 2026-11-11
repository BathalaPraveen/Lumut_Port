<?php

function getHazardActivitiesCategory($type){
     $ci = & get_instance();
    $options['return_type'] = 'row';
    $options['where_in']=[
        'CTYPE'=>['BOTH',$type]
    ];
    $options['return_type'] = 'result';
     $actvity = $ci->common_model->getAlldata(PTW_M_HA_CAT, ['HZRDAC_ID','CAT_NAME'], $options, $limit = "", $offset = "", $orderby = "SORT_ORDER", $disporder = "ASC");
    return $actvity;
}

function getHazardActivities($type,$ref_id){
     $ci = & get_instance();
    $options['return_type'] = 'row';
    $options['where_in']=[
        'PTYPE'=>['BOTH',$type]
    ];
    $options['where']=[
        'HZRDAC_REF_ID'=>$ref_id,
        'STATUS'=>'Y'
    ];
    $options['return_type'] = 'result';
     $actvity= $ci->common_model->getAlldata(PTW_M_HA, ['HZRDA_ID','HZRDAC_REF_ID','PTYPE','HZRDA_NAME','HZRDA_CHKLST','IS_UPLOAD','SORT_ORDER','HAZARD_DECLARATION'], $options, $limit = "", $offset = "", $orderby = "SORT_ORDER", $disporder = "ASC");
  return $actvity;
}

function getHIRARCList($return="",$user_id=0){
    $userid = getCurrentUserid();
    $userGroupId = getCurrentUserGroupId();
    $currentUserId = ($user_id >0) ? $user_id : $userid;
     $ci = & get_instance();
    $options['where']=[
        'HIRARC_STATUS'=>'Y',
        'HIRARC_FLOW_STATUS'=>4
    ];
//    if($userGroupId == 4){
//         $options['where']['CREATED_BY'] = $currentUserId;
//    }
    $options['return_type'] = 'result';
    $actvity = $ci->common_model->getAlldata('HIRARC_MAIN_FLOW', ['MAIN_AUTO_ID','HIRARC_ID'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
   $dropdownDetails = [
                '-1'=>'N/A'
            ];
    if($return == 'drop'){
        if($actvity != FALSE && count($actvity) > 0){
         $dropdownHIARCListDetails = customFormDropDown($actvity,'MAIN_AUTO_ID','HIRARC_ID');
         $dropdownDetails = $dropdownHIARCListDetails;
        }
        return $dropdownDetails;
    }else{
        return $actvity;
    }
   
}

function getPTWStatus($return){
     $ci = & get_instance();
    $options['where']=[];
    $options['return_type'] = 'result';
    $actvity = $ci->common_model->getAlldata('PTW_MSTR_STATUS', ['STATUS_ID','strip_tags(STATUS_TEXT) as statustext'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
  if($return == 'drop'){
        return $dropdownDetails = customFormDropDown($actvity,'STATUS_ID','statustext','Select Status');
    }else{
        return $actvity;
    }
}

function getHazardActivitiesChecklist($ref_id){
     $ci = & get_instance();
    $options['where']=[
        'REF_HZRDA_ID'=>$ref_id,
        'STATUS'=>'Y'
    ];
    $options['return_type'] = 'result';
    return $actvity = $ci->common_model->getAlldata(PTW_M_HAI, ['HZRDA_ITEM_ID','REF_HZRDA_ID','HZRDA_CHKL_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
  
}

function getWPPCategoryList(){
     $ci = & get_instance();
    $options['where']=[
        'STATUS'=>'Y'
    ];
    $options['return_type'] = 'result';
    return $actvity = $ci->common_model->getAlldata(PTW_M_WPP_CAT, ['WPPC_ID','WPPC_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
  
}

function getWPPCategoryItemList($ref_id,$type){
     $ci = & get_instance();
    $options['where']=[
        'REF_WPPC_ID'=>$ref_id,
        'STATUS'=>'Y'
    ];
    $options['where_in']=[
        'PTYPE'=>['BOTH',$type]
    ];
    $options['return_type'] = 'result';
    return $actvity = $ci->common_model->getAlldata(PTW_M_WPP_ITEMS, ['WPPI_ID','WPPI_NAME','REF_WPPC_ID'], $options, $limit = "", $offset = "", $orderby = "SORT_ORDER", $disporder = "ASC");
  
}

/*
 * Section - 4 
 */

function getPPECategoryList(){
     $ci = & get_instance();
    $options['where']=[
        'STATUS'=>'Y'
    ];
    $options['return_type'] = 'result';
    return $actvity = $ci->common_model->getAlldata(PTW_M_PPE_CAT, ['PPEC_ID','PPEC_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
  
}

function getPPECategoryItemList($ref_id){
     $ci = & get_instance();
    $options['where']=[
        'REF_PPEC_ID'=>$ref_id,
        'STATUS'=>'Y'
    ];
   
    $options['return_type'] = 'result';
    return $actvity = $ci->common_model->getAlldata(PTW_M_PPE_ITEMS, ['PPEI_ID','REF_PPEC_ID','PPEI_NAME','PPEI_MANDATE','STATUS'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
  
}

/*
 * Section 5
 */

function getOAList($return){
     $ci = & get_instance();
    $options['where']=[
        'LD.USER_TYPE_ID'=>5,
        'EMP.EMP_LOGIN_STATUS'=>'E',
        'EMP.EMP_STATUS'=>'Y',
    ];
    $options['return_type'] = 'result';
    $options['join'] = [
        'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = EMP.EMP_AUTO_ID','INNER']
    ];
    $actvity = $ci->common_model->getAlldata('EMPLOYEE_MANAGEMENT AS EMP', ['LD.LOGIN_ID','EMP.EMP_AUTO_ID','EMP.EMP_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
  
    if($return == 'drop'){
        return $dropdownDetails = customFormDropDown($actvity,'LOGIN_ID','EMP_NAME','Select Operating Authority');
    }else{
        return $actvity;
    }
}

function getLocationShorName($locationId){
    $ci = & get_instance();
    $options['where']=[
        'TER_AUTO_ID'=>$locationId,
        'TERMINAL_STATUS'=>'Y'
    ];
    $options['return_type'] = 'row';
     $details = $ci->common_model->getAlldata('TERMINAL_MANAGEMENT', ['TERMINAL_SHORTNAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
     return ($details != FALSE) ? $details->TERMINAL_SHORTNAME : 'LOC';
}

function getPermitNumber($locName,$locationId){
    
    $ci = & get_instance();
    $ci->db->select('max(PTW_ID) as counts');
    $ci->db->where(['LOCATION'=>$locationId]);
    $result = $ci->db->get(PTW_TBL)->row();
    $maxid = $result->counts;
    $maxid = $maxid + 1;
    $returnId = str_pad($maxid, 5, 0, STR_PAD_LEFT);


    return 'PTW-'.$locName.'-'.$returnId;
}

function getPTWActAttCount($id){
    
    $ci = & get_instance();
    $ci->db->select('COUNT(PTW_WH_ATT_ID) as counts');
    $ci->db->where(['REF_PTW_WH_ID'=>$id]);
    $result = $ci->db->get(PTW_WORK_HA_ATT)->row();
    $maxid = ($result != FALSE) ? $result->counts : 0;
    echo $ci->db->last_query();
    return $maxid;
}
function getPTWActAttName($id){
    
    $ci = & get_instance();
    $ci->db->select('HZRDA_NAME as cat_name');
    $ci->db->where(['HZRDA_ID'=>$id]);
    $result = $ci->db->get(PTW_M_HA)->row();
    $cName = ($result != FALSE) ? $result->cat_name : 0;
   
    return $cName;
}

function displayPTWHZPDFAttachment($viewdata){
   
    $html = '<div class="doc-border fsize" style="padding-top:10px;padding-bottom:10px;"><table style="width:80%"><thead><tr><th>S.No</th><th>Link</th></tr></thead><tbody>';
    $i = 0;
        if($viewdata != '' && count($viewdata) > 0){
           
            foreach($viewdata as $key  => $view){
                 $i++;
                 $attachId = postData($view,'PTW_WH_ATT_ID');
                 $PTWWHId = postData($view,'REF_PTW_WH_ID');
                 $filepath = postData($view,'WHA_FILE_PATH');
                    $filename = postData($view,'WHA_FILENAME');
                    $fileext= postData($view,'WHA_FILE_EXT');
//                    $is_image= postData($view,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                    $encId = encryptval($attachId);
                    $encREFId = encryptval($PTWWHId);
                    $refId = 'HZATTACH_'.$PTWWHId.'_'.$key;
                    $fpath = $filepath.$filename;
                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'" width="250" height="150"  style="vertical-align: top;padding-top:10px;padding-bottom:10px;"/> ';
                    $displayhref =' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>';
              $html .='<tr>';
              $html .='<td>'.$i.'</td>';
              $html .='<td>'.$displayhref.'</td>';
              $html .='</tr>';
             
            }
        }else{
            $html .= '<tr><td colspan="2">No record found</td></tr>';
        }
         $html .= '</tbody></table></div><div style="clear:both"></div>';
       
    return $html;  
}
function displayWPPPDFAttachment($viewdata){
   
   $html = '<div class="doc-border fsize" style="padding-top:10px;padding-bottom:10px;"><table style="width:80%"><thead><tr><th>S.No</th><th>Link</th></tr></thead><tbody>';
    $i = 0;
        if($viewdata != '' && count($viewdata) > 0){
            foreach($viewdata as $key  => $view){
                 $i++;
                 $attachId = postData($view,'PTW_WS_P_ATT_ID');
                 $refId = postData($view,'REF_PTW_WS_P_ID');
                 $filepath = postData($view,'WSPA_FILE_PATH');
                    $filename = postData($view,'WSPA_FILENAME');
                    $fileext= postData($view,'WSPA_FILE_EXT');
//                    $is_image= postData($view,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                    $encId = encryptval($attachId);
                    $encREFId = encryptval($PTWWHId);
                    $refId = 'HZATTACH_'.$PTWWHId.'_'.$key;
                    $fpath = $filepath.$filename;
                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'" width="250" height="150"  style="vertical-align: top;padding-top:10px;padding-bottom:10px;"/> ';
                    $displayhref =' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>';
              $html .='<tr>';
              $html .='<td>'.$i.'</td>';
              $html .='<td>'.$displayhref.'</td>';
              $html .='</tr>';
            }
        }else{
            $html .= '<tr><td colspan="2">No record found</td></tr>';
        }
       $html .= '</tbody></table></div><div style="clear:both"></div>';
       
    return $html;  
}
function displayPPEPDFAttachment($viewdata){
   
    $html = '<div class="doc-border fsize" style="padding-top:10px;padding-bottom:10px;"><table style="width:80%"><thead><tr><th>S.No</th><th>Link</th></tr></thead><tbody>';
    $i = 0;
        if($viewdata != '' && count($viewdata) > 0){
            foreach($viewdata as $key  => $view){
                  $i++;
                 $attachId = postData($view,'PTW_PPE_UP_ID');
                 $refId = postData($view,'REF_PTW_ID');
                 $filepath = postData($view,'PPEA_FILE_PATH');
                    $filename = postData($view,'PPEA_FILENAME');
                    $fileext= postData($view,'PPEA_FILE_EXT');
//                    $is_image= postData($view,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                    $encId = encryptval($attachId);
                    $encREFId = encryptval($PTWWHId);
                    $refId = 'HZATTACH_'.$PTWWHId.'_'.$key;
                    $fpath = $filepath.$filename;
                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'" width="250" height="150"  style="vertical-align: top;padding-top:10px;padding-bottom:10px;"/> ';
                    $displayhref =' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>';
              $html .='<tr>';
              $html .='<td>'.$i.'</td>';
              $html .='<td>'.$displayhref.'</td>';
              $html .='</tr>';
            }
        }else{
            $html .= '<tr><td colspan="2">No record found</td></tr>';
        }
          $html .= '</tbody></table></div><div style="clear:both"></div>';
       
    return $html;  
}
function displayPTWClosePDFAttachment($viewdata){
   
    $html = '<div class="doc-border fsize" style="padding-top:10px;padding-bottom:10px;"><table style="width:80%"><thead><tr><th>S.No</th><th>Link</th></tr></thead><tbody>';
    $i = 0;
        if($viewdata != '' && count($viewdata) > 0){
            foreach($viewdata as $key  => $view){
                $i++;
                $attachId = postData($view,'PTW_SD_ID');
                 $refId = postData($view,'REF_PTW_ID');
                 $filepath = postData($view,'SD_FILE_PATH');
                    $filename = postData($view,'SD_FILENAME');
                    $fileext= postData($view,'SD_FILE_EXT');
                    $is_image= postData($view,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                    $encId = encryptval($attachId);
                    $encREFId = encryptval($PTWWHId);
                    $refId = 'HZATTACH_'.$PTWWHId.'_'.$key;
                    $fpath = $filepath.$filename;
                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'" width="250" height="150"  style="vertical-align: top;padding-top:10px;padding-bottom:10px;"/> ';
                    $displayhref =' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>';
              $html .='<tr>';
              $html .='<td>'.$i.'</td>';
              $html .='<td>'.$displayhref.'</td>';
              $html .='</tr>';
            }
        }else{
            $html .= '<tr><td colspan="2">No record found</td></tr>';
        }
        $html .= '</tbody></table></div><div style="clear:both"></div>';
       
    return $html;  
}
function displayPTWClosePDFAttachment1($viewdata){
   
    $html = '<div class="doc-border fsize" style="padding-top:10px;padding-bottom:10px;"><table style="width:80%"><thead><tr><th>S.No</th><th>Link</th></tr></thead><tbody>';
    $i = 0;
        if($viewdata != '' && count($viewdata) > 0){
            foreach($viewdata as $key  => $view){
                $i++;
                $attachId = postData($view,'PTW_SD_ID');
                 $refId = postData($view,'REF_PTW_ID');
                 $filepath = postData($view,'SD_FILE_PATH');
                    $filename = postData($view,'SD_FILENAME');
                    $fileext= postData($view,'SD_FILE_EXT');
                    $is_image= postData($view,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                    $encId = encryptval($attachId);
                    $encREFId = encryptval($PTWWHId);
                    $refId = 'HZATTACH_'.$PTWWHId.'_'.$key;
                    $fpath = $filepath.$filename;
                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'" width="250" height="150"  style="vertical-align: top;padding-top:10px;padding-bottom:10px;"/> ';
                    $displayhref =' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>';
              $html .='<tr>';
              $html .='<td>'.$i.'</td>';
              $html .='<td>'.$displayhref.'</td>';
              $html .='</tr>';
            }
        }else{
            $html .= '<tr><td colspan="2">No record found</td></tr>';
        }
        $html .= '</tbody></table></div><div style="clear:both"></div>';
       
    return $html;  
}
function displayPTWHZCCPDFAttachment($viewdata){
   
    $html = '<div class="doc-border fsize" style="padding-top:10px;padding-bottom:10px;"><table style="width:80%"><thead><tr><th>S.No</th><th>Link</th></tr></thead><tbody>';
    $i = 0;
        if($viewdata != '' && count($viewdata) > 0){
            foreach($viewdata as $key  => $view){
                $i++;
                $attachId = postData($view,'WHCA_ID');
                 $PTWWHId = postData($view,'REF_PTW_WH_ID');
                 $filepath = postData($view,'WHCA_FILE_PATH');
                    $filename = postData($view,'WHCA_FILENAME');
                    $fileext= postData($view,'WHCA_FILE_EXT');
//                    $is_image= postData($view,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                    $encId = encryptval($attachId);
                    $encREFId = encryptval($PTWWHId);
                    $refId = 'HZATTACH_'.$PTWWHId.'_'.$key;
                    $fpath = $filepath.$filename;
                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'" width="250" height="150"  style="vertical-align: top;padding-top:10px;padding-bottom:10px;"/> ';
                    $displayhref =' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>';
              $html .='<tr>';
              $html .='<td>'.$i.'</td>';
              $html .='<td>'.$displayhref.'</td>';
              $html .='</tr>';
            }
        }else{
            $html .= '<tr><td colspan="2">No record found</td></tr>';
        }
        $html .= '</tbody></table></div><div style="clear:both"></div>';
       
    return $html;  
}
//function displayWPPPDFAttachment($viewdata){
//   
//    $html = '';
//        if($viewdata != '' && count($viewdata) > 0){
//            foreach($viewdata as $key  => $view){
//                 $attachId = postData($view,'PTW_WS_P_ATT_ID');
//                 $refId = postData($view,'REF_PTW_WS_P_ID');
//                 $filepath = postData($view,'WSPA_FILE_PATH');
//                    $filename = postData($view,'WSPA_FILENAME');
//                    $fileext= postData($view,'WSPA_FILE_EXT');
////                    $is_image= postData($view,'IS_IMAGE');
//                    $fileFullpath = BASE_URL.$filepath.$filename;
//                    $fileIcon = '';
//                    switch ($fileext) {
//                        case '.pdf':
//                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';
//
//                            break;
//
//                        default:
//                            break;
//                    }
//                    $encId = encryptval($attachId);
//                    $encREFId = encryptval($PTWWHId);
//                    $refId = 'HZATTACH_'.$PTWWHId.'_'.$key;
//                    $fpath = $filepath.$filename;
//                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'" width="250" height="150"  style="vertical-align: top;padding-top:10px;padding-bottom:10px;"/> ';
//             
//               $html .='<div style="width:40%;float:left;">
//                                <div style="display: inline-block;max-width: 100vw;margin-bottom: 9px;" >
//                                    <div  style="height:200px;display: inline-block;margin-bottom: 5px;overflow: hidden;text-align: center;vertical-align: middle;margin-left:25px;
//    background-color: #fff;
//    border: 1px solid #dee2e6;
//    border-radius: 1px;
//    box-shadow: 0 1px 2px rgba(0,0,0,.075);
//   
//    ">'.$displayLabel.'</div>
//
//                                </div>	    
//                            </div>'; 
//            }
//        }
//        $html .= '<div style="clear:both"></div>';
//       
//    return $html;  
//}

function displayPTWHZCCAttachment($viewdata,$is_delete=FALSE,$catRef=''){
   
    $html = ($is_delete)? '': '<div class="row">';
        if($viewdata != '' && count($viewdata) > 0){
            foreach($viewdata as $key  => $view){
                 $attachId = postData($view,'WHCA_ID');
                 $PTWWHCatId = postData($view,'WHCA_FILENAME');
                 $PTWWHId = postData($view,'REF_PTW_WH_ID');
                 $filepath = postData($view,'WHCA_FILE_PATH');
                    $filename = postData($view,'WHCA_FILENAME');
                    $fileext= postData($view,'WHCA_FILE_EXT');
//                    $is_image= postData($view,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                    $encId = encryptval($attachId);
                    $encREFId = encryptval($PTWWHId);
                    $refId = 'HZCCATTACH_'.$PTWWHId.'_'.$key;
                    $fpath = $filepath.$filename;
                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'"/><div class="col-md-3 popupgal"><a data-fancybox="gallery" href="' . $fileFullpath . '"><i class="fa fa-search" aria-hidden="true"></i></a></div>';
                    $deleteHtml = '';
                    if($is_delete){
                        $deleteHtml = '<a href="javascript:void(0)" class="btn btn-danger deleteDoc" data-id="'.$encId.'" data-addref="'.$catRef.'" data-ref="'.$encREFId.'" data-refId ="'.$refId.'" data-filepath = "'.$fpath.'" data data-ref-type="HZCCATTACH"><i class="fa fa-trash" aria-hidden="true" style="color:#FFF !important" ></i> Delete</a>';
                    }
                    
                    
                    
               
               $html .='<div class="col-md-3 imagepopcombine" id="'.$refId.'">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview img-thumbnail"  style="width: 200px; height: 150px;">'.$displayLabel.' </div> <div class="text-center" >'.$deleteHtml.'</div>
                    <div>
                    </div>
                </div>	    
            </div>'; 
            }
        }
         $html .= ($is_delete)? '': '</div>';
       
    return $html;  
}


function displayPTWHZAttachment($viewdata,$is_delete=FALSE,$catRef=''){
   
    $html = ($is_delete)? '': '<div class="row">';
        if($viewdata != '' && count($viewdata) > 0){
            foreach($viewdata as $key  => $view){
                 $attachId = postData($view,'PTW_WH_ATT_ID');
                 $PTWWHId = postData($view,'REF_PTW_WH_ID');
                 $PTWWHCatId = postData($view,'WHA_CATEGORY');
                 $filepath = postData($view,'WHA_FILE_PATH');
                    $filename = postData($view,'WHA_FILENAME');
                    $fileext= postData($view,'WHA_FILE_EXT');
//                    $is_image= postData($view,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                    $encId = encryptval($attachId);
                    $encREFId = encryptval($PTWWHId);
                    $refId = 'HZATTACH_'.$PTWWHId.'_'.$key;
                    $fpath = $filepath.$filename;
                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'"/><div class="col-md-3 popupgal"><a data-fancybox="gallery" href="' . $fileFullpath . '"><i class="fa fa-search" aria-hidden="true"></i></a></div>';
                    $deleteHtml = '';
                    if($is_delete){
                        $deleteHtml = '<a href="javascript:void(0)" class="btn btn-danger deleteDoc" data-id="'.$encId.'" data-addref="'.$catRef.'" data-ref="'.$encREFId.'" data-refId ="'.$refId.'" data-filepath = "'.$fpath.'" data data-ref-type="HZATTACH"><i class="fa fa-trash" aria-hidden="true" style="color:#FFF !important" ></i> Delete</a>';
                    }
                    
                    
                $hracUpload = ($catRef == 'upload_documents_24')  ? '<div style="display: inline-block;float:left;margin-right:5px;">
                        <span class="btn-file" style="display: inline-block;"><input type="file" name="upload_documents_24[]" class="hirarcupload docfileupload" accept="image/*,application/pdf" data-msg-accept="Accepts only pdf,jpg, jpeg, png, gif images"></span></div>' : '';  
                $hracUpClass= ($catRef == 'upload_documents_24')  ? 'edit_upload_documents_24' : '';
               
               $html .='<div class="col-md-3 imagepopcombine '.$hracUpClass.' " id="'.$refId.'">
                  
                <div class="  fileinput fileinput-new" data-provides="fileinput">
                    '.$hracUpload.'
                    
                    <div class="fileinput-preview img-thumbnail"  style="width: 200px; height: 150px;">'.$displayLabel.' </div> <div class="text-center" >'.$deleteHtml.'</div>
                    <div>
                    </div>
                </div>	    
            </div>'; 
            }
        }
         $html .= ($is_delete)? '': '</div>';
       
    return $html;  
}


function displayWPPAttachment($viewdata,$is_delete=FALSE,$catRef=''){
   
    $html = ($is_delete)? '': '<div class="row">';
        if($viewdata != '' && count($viewdata) > 0){
            foreach($viewdata as $key  => $view){
                 $attachId = postData($view,'PTW_WS_P_ATT_ID');
                 $refId = postData($view,'REF_PTW_WS_P_ID');
                 $filepath = postData($view,'WSPA_FILE_PATH');
                    $filename = postData($view,'WSPA_FILENAME');
                    $fileext= postData($view,'WSPA_FILE_EXT');
//                    $is_image= postData($view,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                    
                     $encId = encryptval($attachId);
                    $encREFId = encryptval($refId);
                    $deleteHtml = '';
                    $refId = 'WPPATTACH_'.$refId.'_'.$key;
                    $fpath = $filepath.$filename;
                    if($is_delete){
                        $deleteHtml = '<a href="javascript:void(0)" class="btn btn-danger deleteDoc" data-id="'.$encId.'" data-addref="'.$catRef.'" data-ref="'.$encREFId.'" data-filepath = "'.$fpath.'" data-ref-type="WPPATTACH" data-refId ="'.$refId.'"><i class="fa fa-trash" aria-hidden="true" style="color:#FFF !important" ></i> Delete</a>';
                    }
                    
                    
                    
                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'"/><div class="col-md-3 popupgal"><a data-fancybox="gallery" href="' . $fileFullpath . '"><i class="fa fa-search" aria-hidden="true"></i></a></div>';
               
               $html .='<div class="col-md-3 imagepopcombine" id="'.$refId.'">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview img-thumbnail"  style="width: 200px; height: 150px;">'.$displayLabel.'</div><div class="text-center" >'.$deleteHtml.'</div>
                    <div>
                    </div>
                </div>	    
            </div>'; 
            }
        }
        $html .= ($is_delete)? '': '</div>';
    return $html;  
}

function displayPPEAttachment($viewdata,$is_delete=FALSE){
   
    $html = ($is_delete)? '': '<div class="row">';
        if($viewdata != '' && count($viewdata) > 0){
            foreach($viewdata as $key  => $view){
                $attachId = postData($view,'PTW_PPE_UP_ID');
                 $refId = postData($view,'REF_PTW_ID');
                 $filepath = postData($view,'PPEA_FILE_PATH');
                    $filename = postData($view,'PPEA_FILENAME');
                    $fileext= postData($view,'PPEA_FILE_EXT');
//                    $is_image= postData($view,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                    $encId = encryptval($attachId);
                    $encREFId = encryptval($refId);
                    $deleteHtml = '';
                    $refId = 'PPEATTACH_'.$refId.'_'.$key;
                    $fpath = $filepath.$filename;
                    if($is_delete){
                        $deleteHtml = '<a href="javascript:void(0)" class="btn btn-danger deleteDoc" data-id="'.$encId.'" data-ref="'.$encREFId.'" data-filepath = "'.$fpath.'" data-ref-type="PPEATTACH" data-refId ="'.$refId.'"><i class="fa fa-trash" aria-hidden="true" style="color:#FFF !important" ></i> Delete</a>';
                    }
                    
                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'"/><div class="col-md-3 popupgal"><a data-fancybox="gallery" href="' . $fileFullpath . '"><i class="fa fa-search" aria-hidden="true"></i></a></div>';
               
               $html .='<div class="col-md-3 imagepopcombine" id="'.$refId.'">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview img-thumbnail"  style="width: 200px; height: 150px;">'.$displayLabel.'</div><div class="text-center" >'.$deleteHtml.'</div>
                    <div>
                    </div>
                </div>	    
            </div>'; 
            }
        }
         $html .= ($is_delete)? '': '</div>';
    return $html;  
}

function displayPTWCloseAttachment($viewdata,$is_delete=FALSE){
   
    $html = ($is_delete)? '': '<div class="row">';
        if($viewdata != '' && count($viewdata) > 0){
            foreach($viewdata as $key  => $view){
                $attachId = postData($view,'PTW_SD_ID');
                 $refId = postData($view,'REF_PTW_ID');
                 $filepath = postData($view,'SD_FILE_PATH');
                    $filename = postData($view,'SD_FILENAME');
                    $fileext= postData($view,'SD_FILE_EXT');
                    $is_image= postData($view,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                    $encId = encryptval($attachId);
                    $encREFId = encryptval($refId);
                    $deleteHtml = '';
                    $refId = 'PTWSANC_'.$refId.'_'.$key;
                    $fpath = $filepath.$filename;
                    if($is_delete){
                        $deleteHtml = '<a href="javascript:void(0)" class="btn btn-danger deleteDoc" data-id="'.$encId.'" data-ref="'.$encREFId.'" data-filepath = "'.$fpath.'" data-ref-type="PTWSANC" data-refId ="'.$refId.'"><i class="fa fa-trash" aria-hidden="true" style="color:#FFF !important" ></i> Delete</a>';
                    }
                    
                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'"/><div class="col-md-3 popupgal"><a data-fancybox="gallery" href="' . $fileFullpath . '"><i class="fa fa-search" aria-hidden="true"></i></a></div>';
               
               $html .='<div class="col-md-3 imagepopcombine" id="'.$refId.'">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview img-thumbnail"  style="width: 200px; height: 150px;">'.$displayLabel.'</div><div class="text-center" >'.$deleteHtml.'</div>
                    <div>
                    </div>
                </div>	    
            </div>'; 
            }
        }
         $html .= ($is_delete)? '': '</div>';
    return $html;  
}
function displayPTWCloseAttachment1($viewdata,$is_delete=FALSE){
   
    $html = ($is_delete)? '': '<div class="row">';
        if($viewdata != '' && count($viewdata) > 0){
            foreach($viewdata as $key  => $view){
                $attachId = postData($view,'PTW_SD_ID');
                 $refId = postData($view,'REF_PTW_ID');
                 $filepath = postData($view,'SD_FILE_PATH');
                    $filename = postData($view,'SD_FILENAME');
                    $fileext= postData($view,'SD_FILE_EXT');
                    $is_image= postData($view,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                    $encId = encryptval($attachId);
                    $encREFId = encryptval($refId);
                    $deleteHtml = '';
                    $refId = 'PTWSANC_'.$refId.'_'.$key;
                    $fpath = $filepath.$filename;
                    if($is_delete){
                        $deleteHtml = '<a href="javascript:void(0)" class="btn btn-danger deleteDoc" data-id="'.$encId.'" data-ref="'.$encREFId.'" data-filepath = "'.$fpath.'" data-ref-type="PTWSANC" data-refId ="'.$refId.'"><i class="fa fa-trash" aria-hidden="true" style="color:#FFF !important" ></i> Delete</a>';
                    }
                    
                    $displayLabel = ($fileext == '.pdf' ) ? $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>': '<img src="'.$fileFullpath.'"/><div class="col-md-3 popupgal"><a data-fancybox="gallery" href="' . $fileFullpath . '"><i class="fa fa-search" aria-hidden="true"></i></a></div>';
               
               $html .='<div class="col-md-3 imagepopcombine" id="'.$refId.'">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview img-thumbnail"  style="width: 200px; height: 150px;">'.$displayLabel.'</div><div class="text-center" >'.$deleteHtml.'</div>
                    <div>
                    </div>
                </div>	    
            </div>'; 
            }
        }
         $html .= ($is_delete)? '': '</div>';
    return $html;  
}

function getEmailDetails($ids,$type='USERTYPE'){
    $ci = &get_instance();
    //$options['join'] = [
        //'LOGIN_DETAILS AS LD'=>['LD.USER_DESINATION_ID = EMP.EMP_DESIGNATION_ID' ,'INNER']
        
    //];
$options['join'] = [
        'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = EMP.EMP_AUTO_ID' ,'INNER']
        
    ];
    $options['return_type'] = 'row';
   
    if($type == 'USERTYPE'){
         $options['where_in'] = ['USER_TYPE_ID'=> $ids];
         $options['group_by'] = [
            'DESC'=>'LD.USER_TYPE_ID'
         ];
    }else{
       $options['where_in'] = ['LOGIN_ID'=> $ids];
    }
     $details = $ci->common_model->getAlldata('EMPLOYEE_MANAGEMENT as EMP', ['GROUP_CONCAT( DISTINCT EMP_EMAIL_ID) as emailList'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
     
     return $details;
}

function getContractorEmailDetails($ids){
    $ci = &get_instance();
    $options['join'] = [
        'LOGIN_DETAILS AS LD'=>['LD.USER_REF_ID = CONT.CONT_AUTO_ID' ,'INNER']
        
    ];
    $options['return_type'] = 'row';
    $options['where_in'] = ['LOGIN_ID'=> $ids];
     $details = $ci->common_model->getAlldata('CONTRACTOR_DETAILS as CONT', ['GROUP_CONCAT( DISTINCT CONT_EMAIL_ID) as emailList'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
     
     return $details;
}


/*
 * Send System Notification and Email Notification to User below are user type info
 * 
 * User Type
 * 1 ==> Super Admin
 * 2 ==> Admin
 * 3 ==> Normal User
 * 4 ==> Executive User
 * 5 ==> Unit Heads
 * 6 ==> HSSE User
 * 7 ==> HSSE Head/Reviewer
 * 8 ==> Verifier User
 * 9 ==> Approver User
 * 10 ==> Guard User
 * 11 ==> Contractor User
 * 
 * 
 */

function sendNotification($data=[]){
    $ci = &get_instance();
    global $aPermitType,$ptwInitialTemplate,$ptwHseVerificationTemplate,$ptwOAVerificationTemplate,$ptwFinalTemplate,$ptwFooterMailContent;
    
    $permitId = postData($data,'permitId');
    
    $options['return_type'] = 'row';
    $options['where']=[
        'PTW_ID'=>$permitId,
        'PTW_STATUS'=>'Y'
    ];
    
    $ptwDetails = $ci->common_model->getAlldata(PTW_TBL, ['*','(CASE WHEN PERMIT_TYPE = "1" THEN "Normal PTW" ELSE "Critical PTW" END) as PERMIT_TYPE_NAME','FN_GET_AREA_CLASSIFICATION_NAME(AREA_OF_CLASSIFICATION) as AREA_OF_CLASSIFICATION_NAME','FN_PTW_STATUS_NAME(STATUS) as STATUS_NAME'], $options, $limit = "", $offset = "", $orderby = "", $disporder = "");
    
    if($ptwDetails != FALSE){
        $ptwTypeName = postData($ptwDetails,'PERMIT_TYPE_NAME');
        $ptwStartDate = postData($ptwDetails,'START_DATE');
        $ptwEndDate = postData($ptwDetails,'END_DATE');
        $displayStartDate = convertDate($ptwStartDate, $format='d-m-Y');
        $displayEndDate = convertDate($ptwEndDate, $format='d-m-Y');
        $locationName = postData($ptwDetails,'LOCATION_NAME');
        $specificLocationName = postData($ptwDetails,'SPECIFIC_WORKSITE');
        $areaClassificationName = postData($ptwDetails,'AREA_OF_CLASSIFICATION_NAME');
        $workdescription = postData($ptwDetails, 'WORK_DESCRIPTION');
        $requsterName = postData($ptwDetails,'APPLICANT_NAME');
        $requesterDesignation = postData($ptwDetails,'APPLICANT_DESIGNATION_NAME');
        $statusName = strip_tags(postData($ptwDetails,'STATUS_NAME'));
        $hseName = postData($ptwDetails,'SHO_HSE_NAME');
        $hseDesignationName = postData($ptwDetails,'HSE_DESIGNATION_NAME');
        $OAName = postData($ptwDetails,'OA_NAME');
        $OADesignationName = postData($ptwDetails,'OA_DESIGNATION_NAME');
        $remarks = postData($ptwDetails,'SHO_HSE_REMARKS');
        $permitNumber = postData($ptwDetails,'LIVE_PERMIT_NO');
        $userType = postData($ptwDetails,'APPLICANT_USER_TYPE_ID');
        $PTWStatus = postData($ptwDetails,'STATUS');
        $PTWId = postData($ptwDetails,'PTW_ID');
        $OA1 = postData($ptwDetails,'OA1');
        $OA2 = postData($ptwDetails,'OA2');
        $applicatUserId = postData($ptwDetails,'CREATED_BY');
        $HseUserId = postData($ptwDetails,'SHO_HSE_USER_LOGIN_ID');
        $OAUserId = postData($ptwDetails,'OA_USER_LOGIN_ID');
        $permitTypeId = postData($ptwDetails,'PERMIT_TYPE');
        $aNotifyData = [
            '{permitNumber}'=> $permitNumber,
            '{ptwTypeName}'=> $ptwTypeName,
            '{ptwStartDate}'=> $displayStartDate,
            '{ptwEndDate}'=> $displayEndDate,
            '{locationName}'=> $locationName,
            '{specificLocationName}'=> $specificLocationName,
            '{areaClassification}'=> $areaClassificationName,
            '{workdescription}' => $workdescription,
            '{requsterName}'=> $requsterName,
            '{requesterDesignation}'=> $requesterDesignation,
            '{statusName}'=> $statusName,
            '{hseName}'=> $hseName,
            '{hseDesignation}'=>$hseDesignationName,
            '{oaName}'=> $OAName,
            '{oaDesignation}'=> $OADesignationName,
            '{remarks}'=> $remarks,
        ];
       
    }
    
   
    $employeeTo = [];
    $groupUserTypeTo = [];
    $encPTWID = encryptval($PTWId);
    $notifyUrl = '';
    $employeeEmail = FALSE;
    $userTypeEmail = FALSE;
    $contUserId = ($userType == 11) ? $applicatUserId : 0;
    $employeeId = ($userType == 4) ? $applicatUserId : 0;

    
    $notifypermitType = isset($aPermitType[$permitTypeId]) ? $aPermitType[$permitTypeId] : '';
    switch ($PTWStatus) {
        case 1:
            /*Pending*/
            $notifyMessage = str_replace(array_keys($aNotifyData), array_values($aNotifyData),$ptwInitialTemplate);
                  
            $employeeTo = [];
            $groupUserTypeTo = [6];
            $notifyUrl = 'ptw/permit/verify/' . $encPTWID . '?type=' . $notifypermitType; 
            $employeeEmail = TRUE;
            $userTypeEmail = TRUE;
           
            break;
        case 2:
            /*HSSE Approved*/
            $notifyMessage = str_replace(array_keys($aNotifyData), array_values($aNotifyData),$ptwHseVerificationTemplate);
            $groupUserTypeTo = [];
            $employeeTo = [$HseUserId,$OA1];
            $notifyUrl = 'ptw/permit/verify/' . $encPTWID . '?type=' . $notifypermitType; 
            $employeeEmail = TRUE;
            break;
        
        case 3:
            /*HSSE Rejected*/
            $notifyMessage = str_replace(array_keys($aNotifyData), array_values($aNotifyData),$ptwHseVerificationTemplate);
             $employeeTo = [];
             $notifyUrl = 'ptw/permit/index/' . $encPTWID . '?type=' . $notifypermitType; 
             $employeeEmail = TRUE;
            
            break;
        
         case 4:
             /*OA Approved*/
            $notifyMessage = str_replace(array_keys($aNotifyData), array_values($aNotifyData),$ptwOAVerificationTemplate);
             $notifyUrl = 'ptw/permit/verify/' . $encPTWID . '?type=' . $notifypermitType;
             $employeeTo = [$HseUserId];
             $employeeEmail = TRUE;
            
            break;
        
        
         case 5:
             /*OA Rejected*/
            $notifyMessage = str_replace(array_keys($aNotifyData), array_values($aNotifyData),$ptwOAVerificationTemplate);
              $employeeTo = [$HseUserId];
              $notifyUrl = 'ptw/permit/index/' . $encPTWID . '?type=' . $notifypermitType;
              $employeeEmail = TRUE;
            
            break;
        
        
        
        case 6:
            /*Permit Approved*/
            $notifyMessage = str_replace(array_keys($aNotifyData), array_values($aNotifyData),$ptwFinalTemplate);
            $employeeTo = [$OAUserId,$HseUserId];
            $groupUserTypeTo = [];
            $notifyUrl = 'ptw/permit/verify/' . $encPTWID . '?type=' . $notifypermitType;
            $employeeEmail = TRUE;
            
            break;
        
         case 7:
             /*Permit Close*/
            $notifyMessage = str_replace(array_keys($aNotifyData), array_values($aNotifyData),$ptwFinalTemplate);
             $employeeTo = [$OAUserId,$HseUserId];
             $notifyUrl = 'ptw/permit/view/' . $encPTWID . '?type=' . $notifypermitType;
             $employeeEmail = TRUE;
            break;
        
         case 8:
             /*Permit Stopped*/
            $notifyMessage = str_replace(array_keys($aNotifyData), array_values($aNotifyData),$ptwFinalTemplate);
             $employeeTo = [$OAUserId,$HseUserId];
              $notifyUrl = 'ptw/permit/verify/' . $encPTWID . '?type=' . $notifypermitType;
             $employeeEmail = TRUE;
            break;
        
         case 9:
             /*Permit Cancelled*/
            $notifyMessage = str_replace(array_keys($aNotifyData), array_values($aNotifyData),$ptwFinalTemplate);
             $employeeTo = [$OAUserId,$HseUserId];
             $notifyUrl = 'ptw/permit/view/' . $encPTWID . '?type=' . $notifypermitType;
             $employeeEmail = TRUE;
            break;
        
        case 10:
            /*Re-activated*/
            $notifyMessage = str_replace(array_keys($aNotifyData), array_values($aNotifyData),$ptwFinalTemplate);
            $employeeTo = [$OAUserId,$HseUserId];
            $notifyUrl = 'ptw/permit/verify/' . $encPTWID . '?type=' . $notifypermitType;
            $employeeEmail = TRUE;
            break;

        default:
            break;
    }
    $notifyGroupTo = (is_array($groupUserTypeTo) && count($groupUserTypeTo) > 0) ? implode(',',$groupUserTypeTo) : '';
    $aSentNotifyEmpId = $employeeTo;
    if($userType == 11){
        array_push($employeeTo, $contUserId);
    }else{
        array_push($employeeTo, $employeeId);
    }
    $notifyEmployeeTo = (is_array($employeeTo) && count($employeeTo) > 0) ? implode(',',$employeeTo) : '';
    
    $notifydata = [
            'text' => $notifyMessage,
            'url' => $notifyUrl,
            'type' => 1,
            'notifygroup' => $notifyGroupTo,
            'employee' => $notifyEmployeeTo,
            'mobilelink' => '',
    ];
    insertNotifications($notifydata);
    
    /*Email Template Details*/
    
    $subject = $ptwTypeName.':'.$permitNumber;
    $emailMessage = $notifyMessage.$ptwFooterMailContent;
    
   
        if($employeeEmail){
            if($userType == 4){
                array_push($aSentNotifyEmpId, $employeeId);
            }
           
             $notifyEmployeeTo = (is_array($aSentNotifyEmpId) && count($aSentNotifyEmpId) > 0) ? $aSentNotifyEmpId : FALSE;
             if($notifyEmployeeTo != FALSE){
                 $emailInfo =  getEmailDetails($notifyEmployeeTo,'USER');
                 $emailList = postData($emailInfo,'emailList');
                 $emailData = [
                     'email' => $emailList,
                     'subject' => $subject,
                     'message' => $emailMessage,
                 ];
                 sendNotificationEmail($emailData);
             }
            
        }
        
        if($userType == 11){
                 $emailInfo =  getContractorEmailDetails($contUserId);                 
                 $emailList = postData($emailInfo,'emailList');
                 $emailData = [
                     'email' => $emailList,
                     'subject' => $subject,
                     'message' => $emailMessage,
                 ];
                 sendNotificationEmail($emailData);
             
        }
        
        if($userTypeEmail){
             $notifyUserGroupTo = (is_array($groupUserTypeTo) && count($groupUserTypeTo) > 0) ? $groupUserTypeTo : FALSE;
             if($notifyEmployeeTo != FALSE){
                 $emailInfo =  getEmailDetails($notifyUserGroupTo,'USERTYPE');
                 $emailList = postData($emailInfo,'emailList');
                 $emailData = [
                     'email' => $emailList,
                     'subject' => $subject,
                     'message' => $emailMessage,
                 ];
                 sendNotificationEmail($emailData);
             }
            
        }
    
         
    return TRUE;
}

function sendNotificationEmail($data=[]){
     $ci = &get_instance();
    $subject = isset($data['subject']) ? $data['subject'] : '';
    $toemail = isset($data['email']) ? $data['email'] : '';
    $message = isset($data['message']) ? $data['message'] : '';
    
    $tempdata = array(
                'view_file' => 'common/email/common_mail',
                'messageText' => $message,
                'footerText' => ''
               
    );
    
        $template = $ci->template->load_email_template($tempdata);
       return $ci->email_model->sendEmail($toemail, $subject, $template, $file = "");
  
  
}
function slug_string($str, $separator = '_', $first = 1)
{
		preg_match('/(.+)'.preg_quote($separator, '/').'([0-9]+)$/', $str, $match);
		return isset($match[2]) ? $match[1].$separator : $str.$separator;
}
function uploadMultipleDoc($files, $path, $type = '', $allowedType = '*',$returnType=FALSE,$encryptNameType=FALSE,$encryptName='file') {

    $ci = & get_instance();
    $config['allowed_types'] = $allowedType;
    $config['encrypt_name'] = FALSE;
    $ci->load->library('upload', $config);
    $returndata = array();
    $filesCount = count($files[$type]['name']);

//        foreach($files)
    $loopOver = $files[$type];

    for ($i = 0; $i < $filesCount; $i++) {
         $newName = (int)$uploadTotCount+$i+1;
	if ($loopOver['name'][$i] != '') {
           
	    $_FILES[$type]['name'] = $loopOver['name'][$i];
	    $_FILES[$type]['type'] = $loopOver['type'][$i];
	    $_FILES[$type]['tmp_name'] = $loopOver['tmp_name'][$i];
	    $_FILES[$type]['error'] = $loopOver['error'][$i];
	    $_FILES[$type]['size'] = $loopOver['size'][$i];
            
            
            $file_ext = pathinfo($loopOver['name'][$i], PATHINFO_EXTENSION);
            $j = $i;
            fcheck:
            $lastIncId = $j+1;
            $newfname = increment_string(($encryptName),'_',$lastIncId);
            $newfnameext = FCPATH . $path.$newfname.'.'.strtolower($file_ext);
            $newfnamejpg = FCPATH . $path.$newfname.'.jpg';
            $newfnamepng = FCPATH . $path.$newfname.'.png';
            $newfnamejpeg = FCPATH . $path.$newfname.'.jpeg';
            $newfnamepdf = FCPATH . $path.$newfname.'.pdf';
           
            if (file_exists($newfnameext) || file_exists($newfnamejpg) || file_exists($newfnamepng) || file_exists($newfnamepng) || file_exists($newfnamepdf)) {
                    $j++;
                    goto fcheck;
            }
            
                
            $config['file_name'] = $newfname;


	    $config['upload_path'] = FCPATH . $path;
	    if (!file_exists($config['upload_path'])) {
		mkdir($config['upload_path'], 0777, true);
	    }

	    $ci->load->library('upload', $config);
	    $ci->upload->initialize($config);
	    $finalImgdata = [];
	    if ($ci->upload->do_upload($type)) {
		$fileData = $ci->upload->data();

		$uploadpath = $path;
		$returndata[$i]['uploadname'] = $fileData['file_name'];
		$returndata[$i]['uploadorigname'] = $fileData['orig_name'];
		$returndata[$i]['uploadpath'] = $uploadpath;
		$returndata[$i]['uploadtype'] = $fileData['file_type'];
		$returndata[$i]['uploadextension'] = $fileData['file_ext'];
		$returndata[$i]['filesize'] = $fileData['file_size'];
		$returndata[$i]['client_name'] = $fileData['client_name'];
		$returndata[$i]['orig_name'] = $fileData['orig_name'];
		$returndata[$i]['is_image'] = $fileData['is_image'];
		$returndata[$i]['image_type'] = $fileData['image_type'];
		$returndata[$i]['image_width'] = $fileData['image_width'];
		$returndata[$i]['image_height'] = $fileData['image_height'];
		$returndata[$i]['image_size_str'] = $fileData['image_size_str'];
		
	    } else {
//              print_r($_FILES);
		 if($returnType){
                    return $ci->upload->display_errors();
                }else{
                    echo $ci->upload->display_errors();
                }
		return FALSE;
	    }
	}
    }

    return $returndata;
}
 
?>

