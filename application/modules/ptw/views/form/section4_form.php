<?php
$other_ppe_desc = $this->input->post('other_ppe_desc');
$PPEcategoryLst = getPPECategoryList();

$ppeCheckListInfo = postData($additionalData,'ppeCheckListInfo');
$ppeViewInfo = postData($additionalData,'ppeInfo');


$aPPECheckList = [];

if($ppeCheckListInfo != FALSE && count($ppeCheckListInfo) > 0){
    foreach($ppeCheckListInfo as $ppeItem => $ppeVal){
        $ppeCid = postData($ppeVal,'PPE_CAT_ID');
        $ppeCheckList = postData($ppeVal,'checkListIds');
        $aPPECheckList[$ppeCid] = explode(',',$ppeCheckList);
    }
}

if($PPEcategoryLst != FALSE && count($PPEcategoryLst) > 0){
    foreach($PPEcategoryLst as $key => $ppecat){
        $PPEId = postData($ppecat,'PPEC_ID');
        $PPEName = postData($ppecat, 'PPEC_NAME');
        $PPEItemList = getPPECategoryItemList($PPEId);
        ?>
        <div class="row m-t-10">
            <div class="col-md">  
                <label ><?php echo $PPEName; ?></label><br>
              
            </div>
        </div>
<?php
        if($PPEItemList != FALSE && count($PPEItemList) > 0){
            foreach ($PPEItemList as $PPEkey => $PPEval){
                $PPEItemId = postData($PPEval,'PPEI_ID');
                $PPEName = postData($PPEval,'PPEI_NAME');
                $PPEMAND = postData($PPEval,'PPEI_MANDATE');
                $formIdName = 'ppe_checklist_';
                $formName = 'PPE_ref_id['.$PPEId.'][checklist][]';
                
                 $checked = ($PPEMAND == 'Y') ? TRUE : FALSE;
                 $checkedLabel = ($checked) ? 'checked ' : '';
                 $ppeRequireClass = ($checked) ? '' : 'display:none;';
                 $readOnlyCheck = ($PPEMAND == 'Y') ? 'onclick="return false;"  ' : '';
                 
                 $ppeCheckItemList = isset($aPPECheckList[$PPEId]) ? $aPPECheckList[$PPEId] : [];
              
                 if((in_array($PPEItemId,$ppeCheckItemList))){
                    $checkedLabel = 'checked'; 
                    $ppeRequireClass = '';
                 }
                
               
                
                ?>
                <div class="form-check">
                                    <input class="form-check-input ppe_checkbox " type="checkbox" name="<?php echo $formName; ?>" <?php echo $checkedLabel;?> <?php echo $readOnlyCheck;?> id="<?php echo $formIdName . $PPEItemId; ?>" value="<?php echo $PPEItemId; ?>" data-dynamicref="add_<?php echo $formIdName; ?>_<?php echo $PPEItemId; ?>" data-id="<?php echo $PPEItemId; ?>" >
                        
                                    <label class="form-check-label" for="<?php echo $formIdName . $PPEItemId; ?>">
                                        <?php echo $PPEName; ?> 
                                    </label>
                   </div>
<?php  
                $refPPEName = (strtolower($PPEName) == 'others') ? 'ppe_others': strtolower($PPEName);
                echo form_hidden('ppe_ref_cat_name['.$PPEItemId.']',$refPPEName);  ?>
<div class="additional_ppe_doc" id="add_<?php echo $formIdName; ?>_<?php echo $PPEItemId; ?>"  style="<?php echo $ppeRequireClass;?>"></div>
    <?php }
}


 
?>



<?php }
}

$otherPPE = isset($ppeViewInfo[-1]) ? $ppeViewInfo[-1] : [];
$aOtherPPEInfo = isset($otherPPE[-1]) ? $otherPPE[-1] : [];
$otherPPEInfo = postData($aOtherPPEInfo,'info');
$otherPPEAttachment = postData($aOtherPPEInfo,'attachment');
$other_ppe_desc = postData($otherPPEInfo,'PPE_ITEM_OTHER');

$formName = 'PPE_ref_id[-1][checklist][]';
$ppeRequireClass = 'display:none';

$ppeCheckItemList = isset($aPPECheckList[-1]) ? $aPPECheckList[-1] : [];
$checked = ((in_array(-1,$ppeCheckItemList))) ? TRUE : FALSE;
$checkedLabel = ($checked) ? 'checked ' : '';
$ppeRequireClass = ($checked) ? '' : 'display:none;';


?>
<div class="form-check">
                                    <input class="form-check-input ppe_checkbox " type="checkbox" <?php echo $checkedLabel;?> name="<?php echo $formName; ?>"  id="<?php echo $formIdName. '-1'; ?>" value="-1" data-dynamicref="add_<?php echo $formIdName; ?>_-1" data-id="-1" >
                        
                                    <label class="form-check-label" for="<?php echo $formIdName . '-1'; ?>">Others</label>
                   </div>
<?php   echo form_hidden('ppe_ref_cat_name[-1]','ppe_others');  ?>
<div class="additional_ppe_doc" id="add_<?php echo $formIdName; ?>_-1"  style="<?php echo $ppeRequireClass;?>">

    <div class="row m-t-10">
    <div class="col-md-6">
        <?php
            $data = array(
                'name' => 'other_ppe_desc',
                'id' => 'other_ppe_desc',
                'placeholder' => '',
                'class' => 'otherfield form-control',
                'autocomplete' => 'off',
                'value' => $other_ppe_desc,
            );

            echo form_input($data);
            ?> 
    </div>
    </div>
    
    <div class="row m-t-10 ">
               
                                      <div class="col-md-12">
                                           
                                                <label >Upload Photo </label>
                                                <div class="btn btn-primary btn-sm additionalDoc" data-ref="ppe_upload_documents_-1" data-refbind="ppefileuploadrow_-1" data-max="5" data-classname = 'initialfile' data-accept='image/*' data-classname="initialfilerequire" data-accept="image/*" data-acceptmsg="Accepts only jpg, jpeg, png, gif images">Add +</div>					    
                                                <div class="clearfix"></div>
                                                <br/>
                                                 <div class="row ppefileuploadrow_-1">
                                                     <?php echo displayPPEAttachment($otherPPEAttachment,TRUE);?>
                                                     <?php if($otherPPEAttachment == FALSE){?>
						<div class="col-md-3">
						    <div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="<?php echo DEFAULT_IMG_PNG;?>"></div>
							<div style="display: inline-block;float:left;margin-right:5px;">
                        <span class="btn-file" style="display: inline-block;">
								<span class=" btn btn-sm btn-primary fileinput-new">Select image</span>
								<span class="btn btn-sm btn-warning fileinput-exists">Change</span>
								<input type="file" name="ppe_upload_documents_-1[]" accept="image/*" class="initialfile"   data-msg-accept = "Accepts only jpg, jpeg, png, gif images" data-rule-required="false" data-msg-required="Please Upload Photo">
							    </span>
							    <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
							</div>
						    </div>	    
						</div>
                                                     <?php } ?>
					    </div>
                                            </div>  
                                    </div>


</div>
<script>
    $(document).ready(function () {
        
        $(document).on('change', '.ppe_checkbox', function () {
            var dref = $(this).attr('data-dynamicref');
            if ($(this).is(':checked')) {
                $('#' + dref).show();
            } else {
                $('#' + dref).hide();
            }
        });

    })
</script>
