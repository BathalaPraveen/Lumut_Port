<?php

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
                
                $ppeCheckItemList = isset($aPPECheckList[$PPEId]) ? $aPPECheckList[$PPEId] : [];
              
                
                 $checked = ((in_array($PPEItemId,$ppeCheckItemList))) ? TRUE : FALSE;
                            $checkedLabel = ($checked) ? 'checked ' : '';
                            $ppeRequireClass = ($checked) ? '' : 'display:none;';
                            $readOnlyCheck = 'onclick="return false;"';
                
                ?>
                <div class="form-check">
                                    <input class="form-check-input ppe_checkbox " type="checkbox" name="<?php echo $formName; ?>" <?php echo $checkedLabel;?> <?php echo $readOnlyCheck;?> id="<?php echo $formIdName . $PPEItemId; ?>" value="<?php echo $PPEItemId; ?>" data-dynamicref="add_<?php echo $formIdName; ?>_<?php echo $PPEItemId; ?>" data-id="<?php echo $PPEItemId; ?>" >
                        
                                    <label class="form-check-label" for="<?php echo $formIdName . $PPEItemId; ?>">
                                        <?php echo $PPEName; ?> 
                                    </label>
                   </div>
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
  $ppeCheckItemList = isset($aPPECheckList[-1]) ? $aPPECheckList[-1] : [];
$checked = ((in_array(-1,$ppeCheckItemList))) ? TRUE : FALSE;
$checkedLabel = ($checked) ? 'checked ' : '';
$ppeRequireClass = ($checked) ? '' : 'display:none;';
 $readOnlyCheck = 'onclick="return false;"';
?>
<div class="form-check">
                                    <input class="form-check-input ppe_checkbox " <?php echo $checkedLabel;?>  <?php echo $readOnlyCheck;?>type="checkbox" name="<?php echo $formName; ?>"  id="<?php echo $formIdName. '-1'; ?>" value="-1" data-dynamicref="add_<?php echo $formIdName; ?>_-1" data-id="-1" >
                        
                                    <label class="form-check-label" for="<?php echo $formIdName . '-1'; ?>">Others</label>
                   </div>
<div class="additional_ppe_doc" id="add_<?php echo $formIdName; ?>_-1"  style="<?php echo $ppeRequireClass;?>">

    <div class="row m-t-10">
    <div class="col-md-6">
        <?php
            $data = array(
                'name' => 'other_ppe_desc',
                'id' => 'other_ppe_desc',
                'placeholder' => '',
                'class' => 'form-control',
                'autocomplete' => 'off',
                'value' => $other_ppe_desc,
                 'disabled' => 'disabled',
                  'readonly' => 'readonly',
            );

            echo form_input($data);
            ?> 
    </div>
    </div>
    
    <div class="row m-t-10 ">
               
                                      <div class="col-md-12">
                                           
                                                <label >Upload Photo </label>
                                                					    
                                                <div class="clearfix"></div>
                                                <br/>
                                                 <?php echo displayPPEAttachment($otherPPEAttachment);?>
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
