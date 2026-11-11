<?php
$hazardActivityHirarcInfo = postData($additionalData,'hazardActivityHirarcInfo');
$hazardActivityOther = postData($additionalData,'hazardActivityOther');
$hzActivityInfo = postData($additionalData,'hzActivityInfo');


$hirarcReports = postData($hazardActivityHirarcInfo,'hirarcIds');
$hirarc_reports = ($ptw_id > 0 ) ? ($hirarcReports != FALSE) ? explode(',',$hirarcReports) : [] : $this->input->post('hirarc_reports');

$hazardActivityCheckListInfo = postData($additionalData,'hazardActivityCheckListInfo');

$aHzCheckList = [];

if($hazardActivityCheckListInfo != FALSE && count($hazardActivityCheckListInfo) > 0){
    foreach($hazardActivityCheckListInfo as $hazActItem => $hazActVal){
        $Hzid = postData($hazActVal,'WH_REF_ID');
        $HzCheckList = postData($hazActVal,'checkListIds');
        $aHzCheckList[$Hzid] = explode(',',$HzCheckList);
    }
}


if ($hazardActivity != FALSE && count($hazardActivity) > 0) {
    foreach ($hazardActivity as $key => $val) {
        $hazardActId = postData($val, 'HZRDAC_ID');
        $checkedList = [];
        $getHazActInfo = getHazardActivities($permitType, $hazardActId);
        if(array_key_exists($hazardActId,$aHzCheckList)){
            $checkedList = $aHzCheckList[$hazardActId];
        }
        $cName = postData($val, 'CAT_NAME');
        ?>
        <div class="row m-t-10">
            <div class="col-md">  
                <label ><?php echo $cName; ?> <?php if($hazardActId == 1 || $hazardActId == 2) { echo '<span class="red">* (Please select atleast one) </span> ';} ?> </label><br>
                <?php echo form_hidden('hazard_activity_ref_id['.$hazardActId.']', $hazardActId); ?>
               
            </div>
        </div>
        <?php
        /*Section A,B,C start
         * $hazardActId = 1 --> for section A
         * $hazardActId = 2 --> for section B
         * $hazardActId = 3 --> for section C
         * 24 --> HIRARC
         * 25 --> Work Method Statement
         * 26 --> Others
         * 19 --> Confined Space
         * -1 --> Other (5 input textbox)
         * 
         */
        if ($hazardActId == 1 || $hazardActId == 2 || $hazardActId == 3) {
            $formclass = "";
            switch ($hazardActId) {
                case 1:
                    $formName = 'hazardActivities_routine[]';
                    $formIdName = 'hazardActivities_routine';
                    $formclass = "hazardDiv hazardRoutineDiv";
                    $formerrorclass = "hazardRoutineDiv_error";
                    $formerrorFname = "hazardActivities_routine";
                    break;
                case 2:
                    $formName = 'hazardActivities_cc[]';
                    $formIdName = 'hazardActivities_cc';
                    $formclass = "hazardDiv hazardAddCCDiv";
                    $formerrorclass = "hazardAddCCDiv_error";
                    $formerrorFname = "hazardActivities_cc";
                    break;
                case 3:
                    $formName = 'hazardActivities_additional_doc[]';
                    $formIdName = 'hazardActivities_additional_doc';
                    $formclass = "hazardDiv hazardAddDocDiv";
                    $formerrorclass = "hazardAddDocDiv_error";
                    $formerrorFname = "hazardActivities_additional_doc";
                    break;

                default:
                    $formclass = "";
                    break;
            }
            $newformName = $formName;
            
        $otherHazActRoutine = ($ptw_id > 0) ? isset($hazardActivityOther[$hazardActId][-1]) ? $hazardActivityOther[$hazardActId][-1] : FALSE : $this->input->post('other_hazardActivities_routine');
        $aOtherHazardDesc = isset($hazardActivityOther[$hazardActId][26]) ? $hazardActivityOther[$hazardActId][26] : [];

        $other_hazard_desc = isset($aOtherHazardDesc[0]) ? $aOtherHazardDesc[0] :$this->input->post('other_hazard_desc');
        
         
              
            ?>

            <div class="row ">
                <div class="col-md">  

                    <div>
                        <?php
                        if ($getHazActInfo != FALSE && count($getHazActInfo) > 0) {
                            $getHazActPost = ($checkedList != FALSE && count($checkedList) > 0) ? $checkedList :  $this->input->post($formerrorFname);
                            foreach ($getHazActInfo as $key => $val) {
                                
                                $hazAddId = postData($val, 'HZRDA_ID');
                                $hazChecklist = postData($val, 'HZRDA_CHKLST');
                                $hazName = postData($val, 'HZRDA_NAME');
                                $hazDeclaration = postData($val, 'HAZARD_DECLARATION');
                                $requireClass = (in_array($hazAddId,[24,25])) ? 'required additional_doc_req' : '';
                                 $req = false;
                                  $reqString = '';
                                if((in_array($hazAddId,[24,25]))){
                                    $req = true;
                                   
                                    $formName = 'hazardActivities_additional_doc['.$hazAddId.']';
                                    $reqString = '<span class="red">*</span>';
                                }else if($hazAddId == 26){
                                     $formName = 'hazardActivities_additional_doc['.$hazAddId.']';
                                }else if($hazardActId == 3 && !in_array($hazAddId,[24,25,26])){
                                   $formName = 'hazardActivities_additional_doc['.$hazAddId.']';
                                }else{
                                   $formName = $newformName;
                                }
                                 $checked = ($getHazActPost != FALSE && in_array($hazAddId, $getHazActPost)) ? TRUE : FALSE;
                            $checkedLabel = ($checked) ? 'checked' : '';
                            $showHideClass = ($checked) ? '' : 'display:none;';
                               $hzAttachmentInfo = (isset($hzActivityInfo[$hazardActId][$hazAddId]['attachment'])) ? $hzActivityInfo[$hazardActId][$hazAddId]['attachment'] : [];
                               $hzclearance_certificate_checklist = (isset($hzActivityInfo[$hazardActId][$hazAddId]['clearance_certificate_checklist'])) ? $hzActivityInfo[$hazardActId][$hazAddId]['clearance_certificate_checklist'] : [];
                               $hzclearance_certificate_Attachment = (isset($hzActivityInfo[$hazardActId][$hazAddId]['clearance_certificate_attachment'])) ? $hzActivityInfo[$hazardActId][$hazAddId]['clearance_certificate_attachment'] : [];
                               $hzConfinedSpace = (isset($hzActivityInfo[$hazardActId][$hazAddId]['confined_space'])) ? $hzActivityInfo[$hazardActId][$hazAddId]['confined_space'] : [];
                               $aConfinedSpaceList = [];
                               if($hzConfinedSpace != FALSE && count($hzConfinedSpace) > 0){
                                   foreach($hzConfinedSpace as $row){
                                       $csId = postData($row,'WHA_REF_ID');
                                       $csDate = postData($row,'CS_DATE');
                                       $csTime = postData($row,'CS_TIME');
                                       $csLel = postData($row,'CS_LEL');
                                       $csO2 = postData($row,'CS_O2');
                                       $csH2S = postData($row,'CS_H2S');
                                       $csCo = postData($row,'CS_CO');
                                       $csAGTName = postData($row,'CS_AGT_NAME');
                                       $aConfinedSpaceList[$csId]=[
                                           'date'=>$csDate,
                                           'time'=>$csTime,
                                           'lel'=>$csLel,
                                           'O2'=>$csO2,
                                           'H2S'=>$csH2S,
                                           'CO'=>$csCo,
                                           'agt_name'=>$csAGTName,
                                       ];
                                   }
                               }
                              
                             
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input <?php echo $formclass; ?> <?php echo $requireClass;?>" data-msg-required ="Please Select <?php echo $hazName;?> " <?php echo $checkedLabel;?> type="checkbox" name="<?php echo $formName; ?>" id="<?php echo $formIdName . $key; ?>" value="<?php echo $hazAddId; ?>" data-dynamicref="add_<?php echo $formIdName; ?>_<?php echo $hazAddId; ?>" data-id="<?php echo $hazAddId; ?>" >
                        
                                    <label class="form-check-label" for="<?php echo $formIdName . $key; ?>">
                                        <?php echo $hazName; ?> <?php echo $reqString;?>
                                    </label>
                                </div>
                                 <?php 
                                 echo form_hidden('hazard_activity_ref_cat_name['.$hazAddId.']', $hazName);
                                 ?>
                                 <?php if($req){
                            ?>
                          <span class="red hazact_error"></span>
                          <?php echo form_error($formName, '<div class="error">', '</div>'); ?>
                        <?php } ?>
                                <div class="additional_doc" id="add_<?php echo $formIdName; ?>_<?php echo $hazAddId; ?>"  style="<?php echo $showHideClass;?>">
                                    <?php
                                                                       
                                     /*Section HIRARC start*/
                                    if ($hazAddId == 24) 
                                        {
                                        
                                        $hzTypeInfo = isset($hzActivityInfo[$hazardActId][$hazAddId]['info']) ? $hzActivityInfo[$hazardActId][$hazAddId]['info'] : [];
                                        
                                        $editHTData = postData($hzTypeInfo,'HIRAC_TYPE',FALSE);
                                       
                                        
                                        $userType = getCurrentUserGroupId();
                                        if($userType == 4 && empty($editHTData)){
                                            $editHTData = 'EMP'; 
                                        }else if($userType == 11 && empty($editHTData)){
                                            $editHTData = 'CONT'; 
                                        }else if(!empty($editHTData)){
                                            $editHTData = $editHTData;
                                        }else{
                                             $editHTData = 'EMP';
                                        }
                                                                              
                                        switch ($editHTData) {
                                            case 'EMP':
                                                $hirarc_type = 1;

                                                break;
                                            case 'CONT':
                                                $hirarc_type = 2;

                                                break;

                                            default:
                                              $hirarc_type=  $this->input->post('hirarc_type');
                                                break;
                                        }
                                        
                                        $showHideEmpClass = ($hirarc_type == 1) ? '' : 'display:none';
                                        $showHideContClass = ($hirarc_type == 2) ? '' : 'display:none';
                                        echo form_hidden('hirarc_type',$hirarc_type);
                                        $docfileClassName = ($hirarc_type == 2) ? 'docfileuploadrequire' : 'docfileupload';
                                        ?>

                                        <div class="row m-t-10 hirarc_upload_doc hirarc_upload_doc_1" style="<?php echo $showHideEmpClass;?>">

                                            <div class="col-md-6"> 
                                                <label >HIRARC ID</label><br>
                                                <div>
                                                    <?php
                                                    $hrirarcInfoDetails = [
                                                        'id' => 'hirarc_reports',
                                                        'class' => 'form-control select2bs4 hirarc_reports',
                                                        'multiple' => 'multiple'
                                                    ];
                                                    $hirarcIDList = getHIRARCList('drop');
                                                    echo form_dropdown('hirarc_reports[]', $hirarcIDList,$hirarc_reports, $hrirarcInfoDetails);
                                                    
                                                     $hazardActivityResultHirarcInfo = postData($additionalData, 'hazardActivityResultHirarcInfo');
                                                    
                                                    ?>
                                                   
                                                </div>
                                                 <span class="red"></span>
                                            </div>
                                            <div class="col-md-12 m-t-10">
                                                 <table class="table   table-striped" id="hirarcUpdate">
                                                        <thead class="">
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>HIRARC ID</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                           <?php
                                                            if ($hazardActivityResultHirarcInfo != FALSE && count($hazardActivityResultHirarcInfo) > 0) {
                                                                $i = 0;
                                                                foreach ($hazardActivityResultHirarcInfo as $row) {
                                                                    $hid = postData($row, 'HIRARC_ID');
                                                                    $id = postData($row,'MAIN_AUTO_ID');
                                                                    
                                                                    $action =  " " . anchor(BASE_URL.'hirarc/hirarc/pdf_report/'. encryptval($id), '<i class="fa fa-eye"></i>', array('title' => 'view','target'=>'_new'));
                                                                    $i++;
                                                                    ?>
                                                                    <tr class="hirarcReports" id="hirac_<?php echo $id;?>">
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><?php echo $hid; ?></td>
                                                                        <td><?php echo $action;?></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }else{
                                                                ?>
                                                                    <tr>
                                                                        <td colspan="3" align="center"> No Record Found</td>
                                                                    </tr>
                                                                    <?php
                                                            }
                                                            ?> 

                                                        </tbody>
                                                    </table>
                                            </div>

                                        </div>
                                    <br/>
                                    <div class="row m-t-10 hirarc_upload_doc hirarc_upload_doc_2 " >
                                      <div class="col-md-12">
                                           
                                                <label >Document Upload </label>
                                                <div class="btn btn-primary btn-sm additionalDoc" id="upload_documents_<?php echo $hazAddId;?>" data-ref="upload_documents_<?php echo $hazAddId;?>" data-refbind="fileuploadrow_<?php echo $hazAddId;?>" data-max="10" data-classname="<?php echo $docfileClassName;?> hirarcupload" data-accept="image/*,application/pdf" data-acceptmsg="Accepts only pdf,jpg, jpeg, png, gif images" >Add +</div>
                                                								    
                                                <div class="clearfix"></div>
                                                <br/>
                                                 <div class="row fileuploadrow_<?php echo $hazAddId;?>">
                                                                                                      <?php echo displayPTWHZAttachment($hzAttachmentInfo,TRUE,'upload_documents_'.$hazAddId);?>
            <?php if($hzAttachmentInfo == FALSE) {?>                                          
						<div class="col-md-3">
						    <div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="<?php echo DEFAULT_IMG_PNG;?>"></div>
							<div style="display: inline-block;float:left;margin-right:5px;">
                        <span class="btn-file" style="display: inline-block;">
								<span class="btn btn-sm btn-primary fileinput-new">Upload attachment</span>
								<span class="btn btn-sm btn-warning fileinput-exists">Change</span>
								<input type="file" name="upload_documents_<?php echo $hazAddId;?>[]" class='<?php echo $docfileClassName;?> hirarcupload' accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png, gif images" data-rule-required="false" data-msg-required="Please upload document is required">
							    </span>
							    <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
							</div>
						    </div>	    
						</div>
            <?php } ?>
					    </div>
                                            </div>  
                                    </div>
                                    
                                        <?php
                                        /*Section HIRARC End*/
                                    }else {
                                        if($hazAddId == 26){ /*Section Other start*/
                                       ?>
                                        <div class="row m-t-10">
                                           <div class="col-md-6">
                                               <?php
                                                   $data = array(
                                                       'name' => 'other_hazard_desc',
                                                       'id' => 'other_hazard_desc',
                                                       'placeholder' => '',
                                                       'class' => 'otherfield form-control',
                                                       'autocomplete' => 'off',
                                                       'value' => $other_hazard_desc,
                                                   );

                                                   echo form_input($data);
                                                   ?> 
                                           </div>
                                           </div>
                                        <?php } 
                                        /*Section Other end*/
                                        if(in_array($hazardActId,[3])){
                                        ?>
                                     <div class="row m-t-10 ">
                                      <div class="col-md-12">
                                           
                                                <label >Document Upload  </label>
                                                <div class="btn btn-primary btn-sm additionalDoc" id="additionalDoc_<?php echo $hazAddId;?>" data-ref="upload_documents_<?php echo $hazAddId;?>" data-refbind="fileuploadrow_<?php echo $hazAddId;?>" data-max="10" data-classname="docfileuploadrequire" data-accept="image/*,application/pdf" data-acceptmsg="Accepts only pdf,jpg, jpeg, png, gif images">Add +</div>					    
                                                <div class="clearfix"></div>
                                                <br/>
                                                 <div class="row fileuploadrow_<?php echo $hazAddId;?>">
                                                     <?php echo displayPTWHZAttachment($hzAttachmentInfo,TRUE,'additionalDoc_'.$hazAddId);?>
                                                     <?php 
                                                                                                                                                  if($hzAttachmentInfo == FALSE) {?>
						<div class="col-md-3">
                                                    
						    <div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="<?php echo DEFAULT_IMG_PNG;?>"></div>
							<div style="display: inline-block;float:left;margin-right:5px;">
                        <span class="btn-file" style="display: inline-block;">
								<span class=" btn btn-sm btn-primary fileinput-new">Upload attachment</span>
								<span class="btn btn-sm btn-warning fileinput-exists">Change</span>
								<input type="file" name="upload_documents_<?php echo $hazAddId;?>[]" class='docfileuploadrequire' accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png, gif images" data-rule-required="false" data-msg-required="Please upload document is required">
							    </span>
							    <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
							</div>
						    </div>	    
						</div>
                                                     <?php } ?>
					    </div>
                                            </div>  
                                    </div>
                                    <?php
                                        }else if($hazChecklist == 'Y') { // Cheklist is Yes the photo upload will shown
                                            $checklistInfo = getHazardActivitiesChecklist($hazAddId);
                                            $showClass = ($hazAddId == 19) ? 'display:block;': 'display:none;';
                                            echo form_hidden('hazActClearanceCert['.$hazAddId.']','Y');
                                                                                        

             $checkListCC = postData($hzclearance_certificate_checklist,'checklistIds');                   $aCheckListCC   = ($checkListCC != FALSE) ? explode(',',$checkListCC):[];    
                                            ?>
                                    
                                    <div class="card m-t-10">
                                    <div class="card-header card-header-cc uppertext ">
                                        <?php echo $hazName.' CLEARANCE CERTIFICATE';
?>
                                    </div>
                                   
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" onclick="return false;" name="cc_declaration" id="<?php echo 'cc_declaration_'.$hazAddId; ?>" checked  readonly value="<?php echo $hazAddId; ?>"  >
                                    <label class="form-check-label" for="<?php echo 'cc_declaration_'.$hazAddId; ?>">
                                        <?php echo $hazDeclaration;?>
                                    </label>
                                </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row m-t-10">
                                                <div class="col-md-12">
                                                    <label>Checklist : <?php echo '<span class="red">* (Please select atleast one) </span> '; ?></label>
                                                  <?php if($checklistInfo != FALSE && count($checklistInfo) > 0){
                                                      foreach($checklistInfo as $ckey => $cval){
                                                          $checklistName = 'checklist_'.$hazAddId.'[]';
                                                          $checklistIdName = 'checklist_'.$hazAddId.'_';
                                                          $checkListId = postData($cval,'HZRDA_ITEM_ID');
                                                          $checkListName = postData($cval,'HZRDA_CHKL_NAME');
                                                          $checked = (in_array($checkListId,$aCheckListCC)) ? 'checked' : '';
       
                                                      ?>
                                                    <div class="form-check">
                                                    <input class="form-check-input ccchecklist" type="checkbox" name="<?php echo $checklistName;?>" id="<?php echo $checklistIdName.$ckey; ?>"  value="<?php echo $checkListId; ?>" <?php echo $checked;?> >
                                    <label class="form-check-label" for="<?php echo $checklistIdName.$ckey; ?>">
                                        <?php echo $checkListName;?>
                                    </label>
                                                    
                                </div>
                                                    <span class="ccchecklist_error red" id="ccchecklist_error"></span>
                                                      <?php } } ?>
                                            
                                             </div>
                                                
                                            </div>
                                            
                                            
                                            
                                             <div class="row m-t-10 ">
                                      <div class="col-md-12">
                                           
                                                <label >Photo Upload </label>
                                                <div class="btn btn-primary btn-sm additionalDoc" id="upload_photo_<?php echo $hazAddId;?>" data-ref="upload_photo_<?php echo $hazAddId;?>" data-refbind="fileuploadrow_<?php echo $hazAddId;?>" data-max="5" data-classname="initialfile" data-accept="image/*" data-acceptmsg="Accepts only jpg, jpeg, png, gif images">Add +</div>					    
                                                <div class="clearfix"></div>
                                                <br/>
                                                 <div class="row fileuploadrow_<?php echo $hazAddId;?>">
                                                      <?php echo displayPTWHZCCAttachment($hzclearance_certificate_Attachment,TRUE,'upload_photo_'.$hazAddId);?>
                                                     <?php if($hzclearance_certificate_Attachment == FALSE){?>
						<div class="col-md-3">
						    <div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="<?php echo DEFAULT_IMG_PNG;?>"></div>
							<div style="display: inline-block;float:left;margin-right:5px;">
                        <span class="btn-file" style="display: inline-block;">
								<span class=" btn btn-sm btn-primary fileinput-new">Select image</span>
								<span class="btn btn-sm btn-warning fileinput-exists">Change</span>
								<input type="file" name="upload_photo_<?php echo $hazAddId;?>[]" class='initialfile' accept="image/*" data-msg-accept = "Accepts only jpg, jpeg, png, gif images" data-rule-required="false" data-msg-required="Please upload document is required">
							    </span>
							    <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
							</div>
						    </div>	    
                                                     </div> <?php } ?>
					    </div>
                                            </div>  
                                    </div>
                                        </div>
                                   
                                </div>
                                    <?php if($hazAddId == 19){
                                        $sectionData = [
                                            'confinedEntryCounts'=>$confineLoopEntryCount,
                                            'confinedSpaceList'=>$aConfinedSpaceList
                                        ];
                                       
                                        ?>
                                    
                                    <div class="card" id="confinedspace" style="<?php echo $showClass;?>">
                                    <div class="card-header ">
                                        <a class="card-link " href="javascript:void(0)">
                                            SECTION 6 - WORKING IN CONFINED SPACE<span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_6" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
<?php echo $this->load->view('section6_form',$sectionData); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <?php } ?>
                                    <?php
                                    
                                        }
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                        }
                        /* Section A other start */
                        if ($hazardActId == 1) {
                            $checked = ($getHazActPost != FALSE && in_array(-1, $getHazActPost)) ? TRUE : FALSE;
                            $checkedLabel = ($checked) ? 'checked' : '';
                            $showHideClass = ($checked) ? '' : 'display:none;';
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="<?php echo $formName; ?>" <?php echo $checkedLabel;?> id="<?php echo $formIdName; ?>-1" value="-1" data-dynamicref="add_<?php echo $formIdName; ?>_-1" data-id="-1">
                                <label class="form-check-label" for="<?php echo $formIdName; ?>-1">Others</label>
                            </div>
                           <?php 
                                 echo form_hidden('hazard_activity_ref_cat_name[-1]', 'Others');
                                 ?>
                            <div class="additional_doc" id="add_<?php echo $formIdName; ?>_-1" style="<?php echo $showHideClass;?>" >
                                <?php 
                                if($otherHazActRoutine != FALSE && count($otherHazActRoutine) > 0){
                                    foreach($otherHazActRoutine as $rkey => $rval){
                                        ?>
                                <div class="col-md-6 appendsect appendsect<?php echo $rkey;?>">
                                    <div class="input-group mb-2"  >
                                        <?php
                                        $data = array(
                                            'name' => 'other_' . $formIdName . '[]',
                                            'id' => 'other_' . $formIdName . '_'.$rkey,
                                            'placeholder' => '',
                                            'class' => 'otherfield other_' . $formIdName . ' form-control',
                                            'autocomplete' => 'off',
                                            'value' => $rval,
                                        );

                                        echo form_input($data);
                                        ?> &nbsp;&nbsp;<div class="input-group-prepend">
                                            
                                            <button type="button" class="btn btn-primary addItem itemaddition" data-id="<?php echo $rkey;?>" data-ref="<?php echo 'other_' . $formIdName; ?>">+</button>
                                            <?php if($rkey > 0) {?>
                                            &nbsp;&nbsp;<button type="button" class="btn btn-primary removeItem itemaddition" data-id="<?php echo $rkey;?>">-</button>
                                            <?php } ?>

                                        </div>
                                        

                                    </div>
                                    <span class="red " id="other_hazardActivities_routine_error_<?php echo $rkey;?>"></span>
                                </div>
                                <?php
                                    }
                                    
                                    
                                }else {
                                ?>
                                <div class="col-md-6">
                                    <div class="input-group mb-2"  >
                                        <?php
                                        $data = array(
                                            'name' => 'other_' . $formIdName . '[]',
                                            'id' => 'other_' . $formIdName . '_0',
                                            'placeholder' => '',
                                            'class' => 'otherfield other_' . $formIdName . ' form-control',
                                            'autocomplete' => 'off',
                                            'value' => '',
                                        );

                                        echo form_input($data);
                                        ?> &nbsp;&nbsp;<div class="input-group-prepend">
                                            <button type="button" class="btn btn-primary addItem itemaddition" data-id="0" data-ref="<?php echo 'other_' . $formIdName; ?>">+</button>

                                        </div>
                                        

                                    </div>
                                    <span class="red " id="other_hazardActivities_routine_error_0"></span>
                                </div>
                                <?php } ?>
                            </div>  
                        <?php
                        }
                        /* Section A other End */
                        ?>

                    </div>
                    
                    <span class="red <?php echo $formerrorclass;?>"></span>
                </div>


            </div>
            <?php
        }
    }
}
?>

<script>
    $(document).ready(function () {
        
       
        $('#other_hazardActivities_routine_0').removeClass('required');
        $(document).on('change', '#hazardActivities_routine-1', function () {
            var dref = $(this).attr('data-dynamicref');
            if ($(this).is(':checked')) {
                $('#other_hazardActivities_routine_0').addClass('required');
                $('#' + dref).show();
            } else {
                $('#other_hazardActivities_routine_0').removeClass('required');
                $('#' + dref).hide();
            }
        });

        $(document).on('click', '.addItem', function () {

            var numItems = $('.other_hazardActivities_routine').length;
            var did = $(this).attr('data-id');
            var dref = $(this).attr('data-ref');
            if (numItems < 5) {
                var html = '<div class="col-md-6 input-group mb-2 appendsect appendsect' + numItems + '"  > <input   type="text" class="otherfield other_hazardActivities_routine form-control  "  name="' + dref + '[]" value="" placeholder=""  autocomplete="off">&nbsp;&nbsp; <div class="input-group-prepend"><button type="button" class="btn btn-primary addItem itemaddition" style="margin-right: 5px;" data-ref="' + dref + '" data-id="' + numItems + '">+</button> <button type="button" class="btn btn-primary removeItem itemaddition" data-id="' + numItems + '">-</button></div></div><span class="red"></span>';
                $('#add_hazardActivities_routine_-1').append(html);
            }
        });

        $(document).on('click', '.removeItem', function () {
            var id = $(this).data('id');
            $('.appendsect' + id).remove();
            var i = 1;
            $('.appendsect').each(function () {
                var nclass = "appendsect" + i;
                nclass = "col-md-6 input-group mb-2 appendsect " + nclass;
                $(this).removeClass().addClass(nclass);
                $(this).find('button').attr('data-id', i);
                i++;
            });
        });

        $(document).on('change', '.hazardDiv', function () {
           
            var cArray = $('input[name="hazardActivities_cc[]"]:checked').map(function () {
                     return this.value; 
                }).get();
           
            if(typeof cArray === "undefined"){
                cArray = [];
            }
            var dref = $(this).attr('data-dynamicref');
            var cval = $(this).val();
            if ($(this).is(':checked')) {
                $('#' + dref).show();
                if($.inArray(19,cArray)){
                    $('#confinedspace').show();
                }else{
                    $('#confinedspace').hide();
                }
            } else {
                $('#' + dref).hide();
            }
        });

        $(document).on('change', '#hirarc_type', function () {
            var dval = $(this).val()
            if (dval) {
                $('.hirarc_upload_doc').hide();
                $('.hirarc_upload_doc_' + dval).show();
            } else {
                $('.hirarc_upload_doc').hide();

            }
        });
  var hirarcurl = '<?php echo $hirarcURL; ?>';
  $('#hirarc_reports').on("select2:unselect", function(e){
      
           var cid = $(this).val();
          var data = {currentId: cid,'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};
           $.ajax({
                                url: hirarcurl,
                                type: "post",
                                data: data,
                                dataType: 'JSON',
                                cache: false,
                                success: function (resp) {
                                    
                                    if (resp.status) {
                                      $('#hirarcUpdate tbody').html(resp.result); 
                                    } else {
                                        

                                    }
                                }
                            });
          var hcount = $('.hirarcReports').length;
          if(hcount == 0){
              var html = '<tr><td colspan="3" align="center">No Record Found.</td></tr>';
              $('#hirarcUpdate tbody').html(html);
          }
    })
     $('#hirarc_reports').on("select2:select", function(e){
          var cid = $(this).val();
          var data = {currentId: cid,'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};
           $.ajax({
                                url: hirarcurl,
                                type: "post",
                                data: data,
                                dataType: 'JSON',
                                cache: false,
                                success: function (resp) {
                                    
                                    if (resp.status) {
                                      $('#hirarcUpdate tbody').html(resp.result); 
                                    } else {
                                        

                                    }
                                }
                            });
    
    })
    
    
    


    })
</script>


